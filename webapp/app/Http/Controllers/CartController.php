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
    	return view('cart')->with([
    		'products' => $this->getProducts()
    	]);
    }

    public static function getProducts() {
        $productIds = self::getExistingItems();
        $products = Product::getFromIds($productIds);
        foreach ($products as &$product) {
            $realPrice = $product->price;
            $amount = 1;
            $product->amount = $amount;
            $product->price = Product::calculatePrice($realPrice);
            $product->value = Product::calculatePrice($realPrice) * $amount;
        }
        return $products;
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
        return self::updateCookie($new);
    }

    public function remove(array $previous, int $id) {
        $key = array_search($id, $previous);
        if ($key !== false) unset($previous[$key]);
        return self::updateCookie($previous);
    }

    private static function getExistingItems() {
        return json_decode($_COOKIE[self::COOKIE_NAME], true) ?? [];
    }

    private static function updateCookie(array $new) {
        return cookie(self::COOKIE_NAME, json_encode($new), self::COOKIE_DURATION);
    }

    public static function getItems() {
        return self::getExistingItems();
    }

    public static function empty() {
        self::updateCookie([]);
    }
}
