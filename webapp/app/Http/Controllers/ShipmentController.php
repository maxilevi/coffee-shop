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
            $shipment = (object)[];
            $shipment->price = $merchant_order->total_amount;
            $shipment->products = json_decode($sale->products, true);
            $shipment->id = $sale->order_id;
            $shipment->date = $merchant_order->date_created;
            $shipment->status = $this->parseStatusMessage($merchant_order->shipment->status);
            $shipment->statusMessage = $merchant_order->shipments->status;
            return [$shipment];
        }
        return [];
    }

    private function parseStatusMessage($msg)
    {
        return $msg;
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
