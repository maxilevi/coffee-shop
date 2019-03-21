<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Log;

class Sale extends Model {

	protected $guarded = ['id'];

	public static function build($orderId, $email, $products)
	{
		$sale = new Sale();
		$sale->order_id = $orderId;
		$sale->email = $email;
		$sale->products = json_encode($products);
		$sale->save();
		$productCount = count($products);
		Log::info("Created sale with order id '{$orderId}' of '{$productCount}' products by '{$email}'");
	}

	public static function getByMerchantOrderId($orderId)
	{
		return self::where('order_id', '=', $orderId)->get();
	}
}