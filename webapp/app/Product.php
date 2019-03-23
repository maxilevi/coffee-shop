<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model {

	protected $guarded = ['id'];

	public static function getTopProducts(callable $filter = null) {
		# SELECT * FROM products ORDER BY (SELECT COUNT(1) FROM sales WHERE sales.product_id = products.id) DESC;
		$sql = DB::table('products');
		if ($filter) $sql = $filter($sql);
		//$sql->orderBy(DB::raw('(SELECT COUNT(1) FROM sales WHERE sales.product_id = products.id)'), 'DESC');
		$products = $sql->get();
		self::modifyPrice($products);
		return $products;
	}

    private static function modifyPrice(&$products) {
    	foreach ($products as &$product) {
    		$product->price = Product::calculatePrice($product->price);
    	}
    }

	public static function calculatePrice(int $price) {
		return ceil(($price * .25) / 50) * 50 - 1;
	}

	public static function getBrands() {
		return DB::table('products')->distinct()->groupBy('brand')->select('brand')->get();
	}

	public static function getFromIds(array $ids) : array {
		return array_map(function(int $id) { return Product::where('id', '=', $id)->first(); }, $ids);
	}
}