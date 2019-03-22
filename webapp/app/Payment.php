<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model {

	protected $guarded = ['id'];

	public static function create($email, $products)
	{
		$payment = new Payment();
		$payment->code = uniqid();
		$payment->email = $email;
		$payment->products = json_encode($products);
		$payment->save();
		return $payment->code;
	}

	public static function getByCode($code)
	{
		return Payment::where('code', '=', $code)->first();
	}
}