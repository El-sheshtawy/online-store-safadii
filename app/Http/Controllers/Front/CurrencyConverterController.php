<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'currency_code' => 'required|string|size:3',
        ]);

        $currencyCode = $request->input('currency_code');
        $cacheKey = 'currency_rate_'. $currencyCode;
        $rate = Cache::get($cacheKey, 0);

        if (!$rate) {
            $converter = App::make('currency.converter');
      // or $converter = app()->make('currency.converter');
      // or $converter = app('currency.converter');
            $baseCurrencyCode = config('app.currency');
            $rate = $converter->convert($baseCurrencyCode, $currencyCode);
            Cache::put($cacheKey, $rate, now()->addMinutes(60));
        }

        Session::put('currency_code', $currencyCode);

       return redirect()->back();

    }
}
