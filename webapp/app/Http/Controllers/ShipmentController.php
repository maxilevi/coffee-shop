<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\DB;

class ShipmentController extends Controller
{
	const PENDING_STATUS = 1;
	const ARRIVED_STATUS = 0;

    public function index(Request $request, $orderId)
    {
    	$success = $request->input('success');
        return view('shipment')->with([]);
    }

    public function getShipmentString($products)
    {
    	return "30x30x30," . (250 * count($products));
    }
}
