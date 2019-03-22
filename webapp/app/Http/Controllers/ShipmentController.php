<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Sale;
use MercadoPago;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
	const PENDING_STATUS = 1;
	const ARRIVED_STATUS = 0;

    public function index(Request $request, $orderId = null)
    {
    	$state = $request->input('state');
        return view('shipment')->with([
            'searchId' => $orderId ?? 0,
            'state' => $state,
            'shipments' => $orderId ? $this->searchShipments($orderId) : []
        ]);
    }

    private function searchShipments($orderId)
    {
        $sale = Sale::getByMerchantOrderId($orderId);
        if ($sale)
        {
            MercadoHandler::authAccess();
            $merchant_order = MercadoPago\MerchantOrder::find_by_id($orderId);
            $shipmentsObject = $this->getShipment($orderId, MercadoHandler::getAccessToken());
            $shipment = (object)[];
            $shipment->price = $merchant_order->total_amount;
            $shipment->products = json_decode($sale->products, true);
            $shipment->id = $orderId;
            $shipment->date = date('Y-m-d - h:m:s', strtotime($merchant_order->date_created));
            $shipment->statusMessage = $this->parseStatusMessage($shipmentsObject["status"]);
            $shipment->status = $this->parseStatusState($shipmentsObject["status"]);
            return [$shipment];
        }
        return [];
    }

    private function getShipment($orderId, $accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/merchant_orders/{$orderId}?access_token={$accessToken}"); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = json_decode(curl_exec($ch), true)["shipments"]; 
        curl_close($ch);
        return $output[0];
    }

    private function parseStatusMessage($msg)
    {
        if ($msg == "ready_to_ship")
        {
            return "EN PROCCESO";
        }
        return "DESPACHADO";   
    }

    private function parseStatusState($msg)
    {
        if ($msg == "ready_to_ship")
        {
            return "process";
        }
        return "success";
    }

    public static function getShipmentString($products)
    {
    	return "30x30x30," . (250 * count($products));
    }

    public static function find(Request $request)
    {
        return redirect("shipment/{$request->input('shipmentId')}");
    }
}
