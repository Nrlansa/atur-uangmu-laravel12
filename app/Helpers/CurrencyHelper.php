<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

function format_uang(int|float $nominal, string $currency = 'IDR', ?float $rate = null): string
{
    $nominal = $nominal ?? 0;

    if ($currency === 'USD') {
        // If $rate is not sent (null), retrieve it from the cache. 
        // If sent (from the DB), use the one sent.
        $actualRate = $rate ?? Cache::get('usd_rate', 0.000064);

        return '$ ' . number_format($nominal * $actualRate, 2, '.', ',');
    }

    return 'Rp ' . number_format($nominal, 0, ',', '.');
}
