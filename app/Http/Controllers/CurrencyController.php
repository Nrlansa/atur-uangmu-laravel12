<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{
    public function switch($currency)
    {
        if (in_array($currency, ['IDR', 'USD'])) {
            Session::put('currency', $currency);
        }
        return redirect()->back();
    }
}
