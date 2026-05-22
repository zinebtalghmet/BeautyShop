<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingRate;
use Illuminate\Http\Request;

class ShippingRateController extends Controller
{
    public function index()
    {
        $shippingRates = ShippingRate::orderBy('country')->orderBy('region')->orderBy('priority')->paginate(20);
        return view('admin.shipping-rates.index', compact('shippingRates'));
    }

    public function create()
    {
        return view('admin.shipping-rates.form', ['shippingRate' => new ShippingRate]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:5',
            'region' => 'nullable|string|max:100',
            'label' => 'required|string|max:100',
            'base_rate' => 'required|numeric|min:0',
            'free_threshold' => 'nullable|numeric|min:0',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        ShippingRate::create($validated + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.shipping-rates.index')
            ->with('success', 'Shipping rate created successfully.');
    }

    public function edit(ShippingRate $shippingRate)
    {
        return view('admin.shipping-rates.form', compact('shippingRate'));
    }

    public function update(Request $request, ShippingRate $shippingRate)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:5',
            'region' => 'nullable|string|max:100',
            'label' => 'required|string|max:100',
            'base_rate' => 'required|numeric|min:0',
            'free_threshold' => 'nullable|numeric|min:0',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $shippingRate->update($validated + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.shipping-rates.index')
            ->with('success', 'Shipping rate updated successfully.');
    }

    public function destroy(ShippingRate $shippingRate)
    {
        $shippingRate->delete();

        return redirect()->route('admin.shipping-rates.index')
            ->with('success', 'Shipping rate deleted successfully.');
    }
}
