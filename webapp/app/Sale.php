<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model {

	protected $guarded = ['id'];

	public static function create($orderId) {
		//self::insert();
	}

	public static function getByMerchantOrderId($orderId) {
		return self::where('order_id', '=', $orderId)->first();
	}
}