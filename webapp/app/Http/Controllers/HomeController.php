<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    	$products = $this->getProducts($request);
        return view('home')->with([
            'top_products' => $products
        ]);
    }

    private function getProducts(Request $request) {
    	$brand = $request->input('brand');
    	$sql = Product::getTopProducts();
    	return Product::getTopProducts(function ($sql) use($brand) {
            return ($brand !== null) ? $sql->where('brand', $brand) : $sql;
        });
    }
}
