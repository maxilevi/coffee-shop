<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;
use App\Payment;
use Log;

class PaymentController extends Controller
{
    const SANDBOX_CLIENT_ID = "8165552372634154";
    const SANDBOX_CLIENT_SECRET = "EKzGVQzDTAEclfi6abTOBe3mc1DQ3J6A";
    const SANDBOX_ACCESS_TOKEN = "APP_USR-8165552372634154-032118-219f451f278a1bc962f0b9809ca88b5e-418906657";

    const CLIENT_ID = "4757717842404032";
    const CLIENT_SECRET = "2Y4pmHzCwJPoS9tTpXjLYIFnUtFYb8i7";
    const ACCESS_TOKEN = "APP_USR-4757717842404032-031710-9406a351eb88dc4a26a777de58eeb715-203380971";
    const IS_SANDBOX = true;

    public function handle(Request $request)
    {
        $products = CartController::getProducts();
        if (count($products) === 0) return redirect('/');
        MercadoPago\SDK::setClientId(self::IS_SANDBOX ? self::SANDBOX_CLIENT_ID : self::CLIENT_ID);
        MercadoPago\SDK::setClientSecret(self::IS_SANDBOX ? self::SANDBOX_CLIENT_SECRET : self::CLIENT_SECRET);

        $preference = new MercadoPago\Preference();
        $preference->items = $this->getItems($products);
        $preference->payer = $this->getPayer($request);
        $preference->shipments = $this->getShipment($request, $products);
        $preference->payment_methods = ["installments" => 1];
        $email = $request->input('email');
        $payment_code = Payment::create($email, $products);
        $preference->back_urls = [
            "success" => "https://outletdecafe.com/success?email={$email}",
            "failure" => "https://outletdecafe.com/failure?email={$email}",
            "pending" => "https://outletdecafe.com/pending?email={$email}"
        ];
        $preference->notification_url = "https://outletdecafe.com/api/notifications?code={$payment_code}";
        $preference->auto_return = "all";
        $preference->save();
        $init_point = $preference->sandbox_init_point;
        if ($init_point === null)
        {
            print_r($preference->error);
            print_r($preference->back_urls);
            return abort(500);
        }
        return redirect($init_point);
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
        /*if (count($products) > 5)
        {
            $shipments->free_methods = [["id" => 73328]];
        }*/
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

    public function success(Request $request)
    {
        CartController::empty();
        $orderId = $request->input('merchant_order_id');
        return redirect("/shipment/{$orderId}?success=true")->withCookie(CartController::empty());
    }

    public function pending()
    {
        return view('pending')->withCookie(CartController::empty());
    }

    public function failure()
    {
        return view('failure')->withCookie(CartController::empty());
    }

    public function ipn(Request $request)
    {
        Log::info("IPN RECEIVED topic='{$request->input('topic')}' id={$request->input("id")}");
        MercadoPago\SDK::setAccessToken(self::IS_SANDBOX ? self::SANDBOX_ACCESS_TOKEN : self::ACCESS_TOKEN);
        $merchant_order = null;

        switch($request->input('topic'))
        {
            case "payment":
                $payment = MercadoPago\Payment::find_by_id($request->input("id"));
                if($payment)
                {
                    Log::info("order_id='{$payment->order_id}'");
                    $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order_id);
                }
                break;

            case "merchant_order":
                $merchant_order = MercadoPago\MerchantOrder::find_by_id($request->input("id"));
                break;
        }

        if ($merchant_order)
        {
            Log::info('[IPN] Created merchant order');
            $paid_amount = 0;
            foreach ($merchant_order->payments as $payment)
            {
                if ($payment["status"] == "approved")
                {
                    $paid_amount += $payment['transaction_amount'];
                }
            }

            Log::info("[IPN] Paid amount is '{$paid_amount}', expected '{$merchant_order->total_amount}'");
            if($paid_amount >= $merchant_order->total_amount)
            {
                $payment = Payment::getByCode($request->input('code'));
                Sale::create($merchant_order->order_id, $payment->email, json_decode($payment->products, true));
                self::sendEmail($payment->email, $request->input('merchant_order_id'));
                $payment->delete();
                Log::info("[IPN] Order '{$request->input('merchant_order_id')}' with code '{$request->input('code')}' was paid");
            }
        } else {
            Log::info("Received an IPN but could not recreate the merchant id");
        }
        return response('', 200);
    }

    private static function sendEmail($to, $orderId)
    {
        $headers = 'From: soporte@outletdecafe.com' . "\r\n" .
                   'Reply-To: soporte@outletdecafe.com' . "\r\n";
        $body =<<<BODY
Hola,
¡Gracias por tu compra en OUTLET DE CAFÉ!

El pagó fue confirmado y el pedido esta en camino.
Podes consultar el estado de tu pedido a traves de este link:
* https://outletdecafe.com/shipments/{$orderId}

¡Muchas Gracias!
BODY;
        mail($to, 'Tu compra en OUTLET DE CAFÉ', $body, $headers);
        Log::info("[MAIL] Sent email to '{$to}'");
    }
}
