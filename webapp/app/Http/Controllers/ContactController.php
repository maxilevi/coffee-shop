<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Sale;
use MercadoPago;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
    	return view('contact');
    }

    public function tyc()
    {
    	return view('tyc');
    }
}
