<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class CartController extends Controller
{
    const COOKIE_NAME = 'cartIds';
    const COOKIE_DURATION = 24 * 60;

    public function index(Request $request)
    {
    	$productIds = $this->getExistingItems();
        $products = Product::getFromIds($productIds);
        foreach ($products as &$product) {
            $realPrice = $product->price;
            $amount = 1;
            $product->price = Product::calculatePrice($realPrice);
            $product->value = Product::calculatePrice($realPrice) * $amount;
        }
    	return view('cart')->with([
    		'products' => $products
    	]);
    }

    public function handle(Request $request) {
        $action = $request->input('action');
        $productId = $request->input('product_id');
        $previous = $this->getExistingItems();
        $cookie = null;
        if ($action && $productId)
        {
            if ($action == 'add') $cookie = $this->add($previous, $productId);
            else if ($action == 'remove') $cookie = $this->remove($previous, $productId);
        }
        return redirect('/cart/')->cookie($cookie);
    }

    public function add(array $previous, int $id) {
        $new = array_merge($previous, [$id]);
        return $this->updateCookie($new);
    }

    public function remove(array $previous, int $id) {
        $key = array_search($id, $previous);
        if ($key !== false) unset($previous[$key]);
        return $this->updateCookie($previous);
    }

    private static function getExistingItems() {
        return json_decode($_COOKIE[self::COOKIE_NAME], true) ?? [];
    }

    private function updateCookie(array $new) {
        return cookie(self::COOKIE_NAME, json_encode($new), self::COOKIE_DURATION);
    }

    public static function getItems() {
        return self::getExistingItems();
    }
}