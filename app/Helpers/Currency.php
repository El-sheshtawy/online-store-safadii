<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use NumberFormatter;

class Currency
{
    public static function formatAppCurrency($amount, $currencyType = null)
    {
        $baseCurrency = config('app.currency', 'USD');
        if (is_null($currencyType)){
            $currencyType = Session::get('currency_code', $baseCurrency);
        }
        if ($currencyType != $baseCurrency){
            $rate = Cache::get('currency_rate_'. $currencyType, 1);
            $amount = $amount * $rate ;
        }
        $currencyFormatter = new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
        return $currencyFormatter->formatCurrency($amount, $currencyType);
    }
}
