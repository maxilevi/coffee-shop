<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model {

	protected $guarded = ['id'];

	public static function create()
	{
		$payment = new Payment();
		$payment->code = uniqid();
		$payment->save();
		return $payment->code;
	}

	public static function exists($code)
	{
		return Payment::where('code' '=', $code) !== null;
	}

	public static function delete()
	{
		Payment::where('code' '=', $code)->delete();
	}
}