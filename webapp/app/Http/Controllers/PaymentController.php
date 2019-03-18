<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago;

class PaymentController extends Controller
{
    public function handle(Request $request)
    { 
        MercadoPago\SDK::setClientId("4757717842404032");
        MercadoPago\SDK::setClientSecret("2Y4pmHzCwJPoS9tTpXjLYIFnUtFYb8i7");

        $preference = new MercadoPago\Preference();
        $preference->items = $this->getItems($request);
        $preference->payer = $this->getPayer($request);
        $preference->shipments = $this->getShipment($request);
        $preference->save();

        return response($preference['response']['init_point'], 200);
    }

    private function getItems(Request $request) {
        $item = new MercadoPago\Item();
        $item->id = "1234";
        $item->title = "Synergistic Cotton Watch";
        $item->quantity = 5;
        $item->currency_id = "ARS";
        $item->unit_price = 23.25;
    }

    private function getShipment(Request $request) {
        $shipments = new MercadoPago\Shipments();
        $shipments->mode = "me2";
        $shipments->dimensions = "30x30x30,500";
        $shipments->receiver_address = array(
            "zip_code" => "5700",
            "street_number" => 123,
            "street_name" => "Street",
            "floor" => 4,
            "apartment" => "C"
        );
    }

    private function getPayer(Request $request) {
        $payer = new MercadoPago\Payer();
        $payer->name = "Charles";
        $payer->surname = "Alonso";
        $payer->email = "charles@gmail.com";
        $payer->date_created = date('Y-m-d H:i:s', time());;
        $payer->phone = [
            "area_code" => "",
            "number" => "961 502 354"
        ];
        $payer->identification = [
            "type" => "DNI",
            "number" => "12345678"
        ];
        $payer->address = [
            "street_name" => "Plaza Samuel",
            "street_number" => 1037,
            "zip_code" => "90179"
        ];
        return $payer;
    }
}
