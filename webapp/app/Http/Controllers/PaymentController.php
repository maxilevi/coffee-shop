<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;
use App\Payment;
use App\Sale;
use Illuminate\Support\Facades\DB;
use App\Mail\SaleEmail;
use Illuminate\Support\Facades\Mail;
use Log;

class PaymentController extends Controller
{

    public function handle(Request $request)
    {
        $products = CartController::getProducts();
        if (count($products) === 0) return redirect('/');

        MercadoHandler::authClient();
        $preference = new MercadoPago\Preference();
        $preference->items = $this->getItems($products);
        $preference->payer = $this->getPayer($request);
        $preference->shipments = $this->getShipment($request, $products);
        $preference->payment_methods = ["installments" => 1];
        $email = $request->input('email');
        $payment_code = Payment::create($email, $products);
        $preference->back_urls = [
            "success" => "https://outletdecafe.com/success?email={$email}",
            "failure" => "https://outletdecafe.com/failure?email={$email}"
        ];
        $preference->notification_url = "https://outletdecafe.com/api/notifications?code={$payment_code}";
        $preference->auto_return = "all";
        $preference->binary_mode = true;
        $preference->save();
        $init_point = $preference->init_point;
        if ($init_point === null)
        {
            print_r($preference->error);
            print_r($preference->back_urls);
            return abort(500);
        }
        return redirect($init_point)->withCookie(CartController::empty());
    }

    private function getItems($products)
    {
        $items = [];
        foreach ($products as $product) {
            $item = new MercadoPago\Item();
            $item->id = $product->id;
            $item->title = $product->name . ' x 250gr';
            $item->description = $product->short_description;
            $item->picture_url = 'https://outletdecafe.com/' . $product->thumbnail;
            $item->quantity = 1;
            $item->currency_id = "ARS";
            $item->unit_price = $product->price;
            $items[] = $item;
        }
        return $items;
    }

    private function getShipment(Request $request, $products)
    {
        $shipments = new MercadoPago\Shipments();
        $shipments->mode = "me2";
        $shipments->dimensions = ShipmentController::getShipmentString($products);
        return $shipments;
    }

    private function getPayer(Request $request)
    {
        $payer = new MercadoPago\Payer();
        $payer->name = $request->input('name');
        $payer->surname = $request->input('surname');
        $payer->email = $request->input('email');
        $payer->date_created = date('Y-m-d H:i:s', time());
        $payer->phone = [
            "area_code" => "+54",
            "number" => $request->input('phone')
        ];
        return $payer;
    }

    private function shipment(Request $request, $state)
    {
        return redirect("/shipment/{$request->input('merchant_order_id')}?state={$state}");
    }

    public function success(Request $request)
    {
        return $this->shipment($request, 'success');
    }

    public function failure(Request $request)
    {
        return $this->shipment($request, 'failure');
    }

    public function pending(Request $request)
    {
        return $this->shipment($request, 'pending');
    }

    public function ipn(Request $request)
    {
        Log::info("IPN RECEIVED topic='{$request->input('topic')}' id={$request->input("id")}");
        MercadoHandler::authAccess();
        $merchant_order = MercadoPago\MerchantOrder::find_by_id($request->input("id"));
        if ($merchant_order)
        {
            if($merchant_order->status == 'closed')
            {
                DB::beginTransaction();
                Log::info("[IPN] Received IPN with code '{$request->input('code')}'");
                $payment = Payment::getByCode($request->input('code'));
                if ($payment !== null) $payment->delete();
                DB::commit();
                if ($payment !== null)
                {
                    Sale::build($merchant_order->id, $payment->email, json_decode($payment->products, true));
                    self::sendEmail($payment->email, $merchant_order->id);
                    Log::info("[IPN] Order '{$merchant_order->id}' with code '{$request->input('code')}' was paid"); 
                }
            }
        } else {
            Log::info("Received an IPN with topic '{$request->input('topic')}' but could not recreate the merchant id");
        }
        return response('', 200);
    }

    private static function sendEmail($to, $orderId)
    {
        Mail::to($to)->send(new SaleEmail("https://outletdecafe.com/shipment/{$orderId}"));
        Log::info("[MAIL] Sent email to '{$to}'");
    }
}
