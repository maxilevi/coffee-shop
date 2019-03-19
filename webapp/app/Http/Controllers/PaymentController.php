<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;

class PaymentController extends Controller
{
    const SANDBOX_CLIENT_ID = "7586911856100224";
    const SANDBOX_CLIENT_SECRET = "9Hl3A9XiQuvjGKY1sfAjPJ3QZq38IYyW";
    const CLIENT_ID = "4757717842404032";
    const CLIENT_SECRET = "2Y4pmHzCwJPoS9tTpXjLYIFnUtFYb8i7";
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
        $preference->payment_methods = [
            "installments" => 1
        ];
        $preference->back_urls = [
            "success" => 'https://outletdecafe.com/api/success',
            "failure" => 'https://outletdecafe.com/api/failure',
            "pending" => 'https://outletdecafe.com/api/pending'
        ];
        $preference->auto_return = "all";
        $preference->external_reference = "";
        $preference->notification_url = "https://outletdecafe.com/api/notifications";
        $preference->save();
        if ($preference->sandbox_init_point === null)
        {
            print_r($preference->error);
            return abort(500);
        }
        return redirect($preference->sandbox_init_point);
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
        $shipments->dimensions = "30x30x30," . (250 * count($products));
        if (count($products) > 4) {
            $shipments->free_methods = [["id" => 73328]];
        }
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
        Sale::create($request->input('merchant_order_id'));
        // actualizar la db
        // mostrar cartel de successfull
        // mandar mail
        //collection_id=18264371&collection_status=approved&preference_id=418076404-8217c373-8d58-4028-921b-3dcbd1eefdce&external_reference=null&payment_type=credit_card&merchant_order_id=993600018
    }

    public function ipn(Request $request)
    {
        MercadoPago\SDK::setAccessToken("ENV_ACCESS_TOKEN");
        $merchant_order = null;

        switch($request->input('topic'))
        {
            case "payment":
                $payment = MercadoPago\Payment::find_by_id($request->input("id"));
                // Get the payment and the corresponding merchant_order reported by the IPN.
                $merchant_order = MercadoPago\MerchantOrder::find_by_id($payment->order_id);
            case "merchant_order":
                $merchant_order = MercadoPago\MerchantOrder::find_by_id($request->input("id"));
        }

        $paid_amount = 0;
        foreach ($merchant_order->payments as $payment) {   
            if ($payment['status'] == 'approved'){
                $paid_amount += $payment['transaction_amount'];
            }
        }

        if($paid_amount >= $merchant_order->total_amount)
        {
            Sale::getByPaymentId($merchant_order->order_id)->markAsPaid();
        }
    }
}
