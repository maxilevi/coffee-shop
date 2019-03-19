<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
    	return view('checkout')->with([
    		'products' => CartController::getProducts()
    	]);
    }

    private static function getExistingItems() {
        return json_decode($_COOKIE[self::COOKIE_NAME], true) ?? [];
    }
}
