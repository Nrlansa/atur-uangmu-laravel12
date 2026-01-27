<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

function format_uang(int|float $nominal, string $currency = 'IDR'): string
{
    if ($currency === 'USD') {
        // Ambil hasil cache yang sudah disiapkan oleh Service 
        $rate = Cache::get('usd_rate', 0.000064);
        return '$ ' . number_format($nominal * $rate, 2, '.', ',');
    }

    return 'Rp ' . number_format($nominal, 0, ',', '.');
}
