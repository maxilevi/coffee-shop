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
        $topProducts = Product::getTopProducts(function ($sql) {
            return $sql->take(self::SIMILAR_PRODUCTS_LIMIT);
        });
        $product = DB::table('products')->where('id', $id)->first();
        if ($product !== null)
        {
            $product->price = Product::calculatePrice($product->price);
            return view('single_product')->with([
                'product' => $product,
                'top_products' => $topProducts,
            ]);
        } else {
            abort(404, 'Not found.');
        }
    }
}
