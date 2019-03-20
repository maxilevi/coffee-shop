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
        $preference->payment_methods = ["installments" => 1];
        $email = $request->input('email');
        $encoded_products = json_encode($products);
        $preference->back_urls = [
            "success" => "https://outletdecafe.com/api/success?email={$email}&products={$encoded_products}",
            "failure" => "https://outletdecafe.com/api/failure?email={$email}",
            "pending" => "https://outletdecafe.com/api/pending?email={$email}"
        ];
        $preference->auto_return = "all";
        $payment_code = Payment::create();
        $preference->notification_url = "https://outletdecafe.com/api/notifications?code={$payment_code}";
        $preference->save();
        $init_point = $preference->sandbox_init_point;
        if ($init_point === null)
        {
            //print_r($preference->error);
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
        if (!Payment::exists($request->input('code')) return;
        Payment::delete($request->input('code'));
        $orderId = $request->input('merchant_order_id');
        Sale::create($orderId, $request->input('email'), $request->input('products'));
        self::sendEmail($request->input('email'), $request->input('merchant_order_id'));
        CartController::empty();
        return redirect("/shipment/{$orderId}?success=true");
    }

    private static function sendEmail($to, $orderId)
    {
        $headers = 'From: soporte@outletdecafe.com' . "\r\n" .
                   'Reply-To: soporte@outletdecafe.com' . "\r\n";
<<<BODY
Hola,
¡Gracias por tu compra en OUTLET DE CAFÉ!

El pagó fue confirmado y el pedido esta en camino.
Podes consultar el estado de tu pedido a traves de este link:
* https://outletdecafe.com/shipments/{$orderId}

¡Muchas Gracias!
BODY>>>;
        mail($to, 'Tu compra en OUTLET DE CAFÉ', $body, $headers);
    }

    public function pending()
    {
        return view('pending');  
    }

    public function failure()
    {
        return view('failure');    
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
