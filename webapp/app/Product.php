<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model {

	protected $guarded = ['id'];

	public static function getTopProducts(int $limit = null) {
		$sql = DB::table('products');
		if ($limit !== null) $sql->take($limit);
		return $sql;
	}
}