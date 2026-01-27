<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    public function updateExchangeRate(): float
    {
        return Cache::remember('usd_rate', 3600, function () {
            try {
                $response = Http::get(env('CURRENCY_API_URL'));
                if ($response->failed()) return 0.000064;

                return $response->json()['rates']['USD'] ?? 0.000064;
            } catch (\Exception $e) {
                return 0.000064;
            }
        });
    }
}
