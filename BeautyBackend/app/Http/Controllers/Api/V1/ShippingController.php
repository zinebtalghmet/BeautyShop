<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ShippingCalculator;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'subtotal' => 'required|numeric|min:0',
            'country' => 'nullable|string|max:5',
            'region' => 'nullable|string|max:100',
        ]);

        $result = ShippingCalculator::calculate(
            (float) $request->input('subtotal'),
            $request->input('country', 'US'),
            $request->input('region')
        );

        return response()->json(['data' => $result]);
    }
}
