<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

function format_uang($nominal, $currency = 'IDR')
{
    if ($currency === 'USD') {
        $rate = Cache::remember('usd_rate', 3600, function () {
            try {
                $response = Http::get('https://open.er-api.com/v6/latest/IDR');
                return $response->json()['rates']['USD'] ?? 0.000064;
            } catch (\Exception $e) {
                return 0.000064; 
            }
        });

        return '$ ' . number_format($nominal * $rate, 2, '.', ',');
    }

    return 'Rp ' . number_format($nominal, 0, ',', '.');
}
