<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
    	$products = $this->getProducts($request);
    	$this->modifyPrice($products);
        return view('home')->with('top_products', $products);
    }

    private function modifyPrice(&$products) {
    	foreach ($products as &$product) {
    		$product->price = Product::calculatePrice($product->price, .25);
    	}
    }

    private function getProducts(Request $request) {
    	$brand = $request->input('brand');
    	$sql = Product::getTopProducts();
    	if($brand !== null) $sql = $sql->where('brand', $brand);
    	return $sql->get();
    }
}
