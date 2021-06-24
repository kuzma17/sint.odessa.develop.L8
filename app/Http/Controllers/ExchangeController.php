<?php

namespace App\Http\Controllers;

use App\Models\Exchange;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    public static function show(){
        $time_exchange = strtotime(Exchange::find(1)->exchange);
        return date("Y.m.d H:i", $time_exchange);
    }
}
