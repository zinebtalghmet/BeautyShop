<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\TaxCalculator;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:5',
            'region' => 'nullable|string|max:100',
            'subtotal' => 'nullable|numeric|min:0',
        ]);

        $subtotal = (float) $request->input('subtotal', 0);
        $country = $request->input('country');
        $region = $request->input('region');

        $result = TaxCalculator::calculate($subtotal, $country, $region);

        return response()->json(['data' => $result]);
    }
}
