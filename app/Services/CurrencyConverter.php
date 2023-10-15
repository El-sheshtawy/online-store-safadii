<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    private $apiKey;
    protected string $baseUrl = 'https://free.currconv.com/api/v7';

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function convert(string $from, string $to, float $amount = 1) : float
    {
        // https://free.currconv.com/api/v7/convert?q=USD_PHP,PHP_USD&compact=ultra&apiKey=[YOUR_API_KEY]

        $q = "{$from}_{$to}";
        $response = Http::baseUrl($this->baseUrl)
            ->get('/convert', [
            'q' => $q,
            'compact' => 'y',
            'apiKey' => $this->apiKey,
            ]);
        $result = $response->json();

        return $result[$q]['val'] * $amount;
    }
}
