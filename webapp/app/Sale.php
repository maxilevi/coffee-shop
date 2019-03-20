<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model {

	protected $guarded = ['id'];

	public static function create($orderId, $email, $products)
	{
		$sale = new Sale();
		$sale->order_id = $order_id;
		$sale->email = $email;
		$sale->products = json_encode($products);
		$sale->save();
	}

	public static function getByMerchantOrderId($orderId)
	{
		return self::where('order_id', '=', $orderId)->first();
	}
}