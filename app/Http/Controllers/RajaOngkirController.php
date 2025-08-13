<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RajaOngkirService;

class RajaOngkirController extends Controller
{
    protected $rajaOngkir;

    public function __construct(RajaOngkirService $rajaOngkir)
    {
        $this->rajaOngkir = $rajaOngkir;
    }

    public function getProvinces()
    {
        $provinces = $this->rajaOngkir->getProvinces();
        return response()->json($provinces);
    }

    public function getCities(Request $request)
    {
        $cities = $this->rajaOngkir->getCities($request->province_id);
        return response()->json($cities);
    }

    public function getCost(Request $request)
    {
        $costs = $this->rajaOngkir->getShippingCost(
            $request->origin,
            $request->destination,
            $request->weight,
            $request->courier
        );
        return response()->json($costs);
    }
}
