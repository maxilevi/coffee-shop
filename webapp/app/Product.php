<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model {

	protected $guarded = ['id'];

	public static function getTopProducts(int $limit = null) {
		# SELECT * FROM products ORDER BY (SELECT COUNT(1) FROM sales WHERE sales.product_id = products.id) DESC;
		$sql = DB::table('products');
		$sql->orderBy(DB::raw('(SELECT COUNT(1) FROM sales WHERE sales.product_id = products.id)'), 'DESC');
		if ($limit !== null) $sql->take($limit);
		return $sql;
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