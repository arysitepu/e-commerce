<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RajaOngkirService
{
    protected $key;
    protected $baseUrl;

    public function __construct()
    {
        $this->key = config('rajaongkir.api_key');
        $this->baseUrl = config('rajaongkir.api_url');
    }

    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => $this->key
        ])->get("{$this->baseUrl}/province");
        dd($response->json());
        // return $response['rajaongkir']['results'] ?? [];
    }

    public function getCities($provinceId)
    {
        $response = Http::withHeaders([
            'key' => $this->key
        ])->get("{$this->baseUrl}/city?province={$provinceId}");

        return $response['rajaongkir']['results'] ?? [];
    }

    public function getShippingCost($origin, $destination, $weight, $courier)
    {
        $response = Http::withHeaders([
            'key' => $this->key
        ])->post("{$this->baseUrl}/cost", [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        ]);

        return $response['rajaongkir']['results'][0]['costs'] ?? [];
    }

}