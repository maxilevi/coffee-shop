<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Illuminate\Support\Facades\DB;

class SingleProductController extends Controller
{
    const SIMILAR_PRODUCTS_LIMIT = 4;

    public function index($id)
    {
        $topProducts = Product::getTopProducts(self::SIMILAR_PRODUCTS_LIMIT)->get();
        $product = DB::table('products')->where('id', $id)->first();
        if ($product !== null)
        {
            return view('single_product')->with([
                'product' => $product,
                'top_products' => $topProducts,
                'prices' => [
                    Product::calculatePrice($product->price, .25),
                    Product::calculatePrice($product->price, .5),
                    Product::calculatePrice($product->price, 1)
                ]
            ]);
        } else {
            abort(404, 'Not found.');
        }
    }
}
