<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TaxRate;
use Illuminate\Http\Request;

class TaxRateController extends Controller
{
    public function index()
    {
        $taxRates = TaxRate::orderBy('country')->orderBy('region')->orderBy('priority')->paginate(20);
        return view('admin.tax-rates.index', compact('taxRates'));
    }

    public function create()
    {
        return view('admin.tax-rates.form', ['taxRate' => new TaxRate]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:5',
            'region' => 'nullable|string|max:100',
            'label' => 'required|string|max:100',
            'rate' => 'required|numeric|min:0|max:100',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        TaxRate::create($validated + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.tax-rates.index')
            ->with('success', 'Tax rate created successfully.');
    }

    public function edit(TaxRate $taxRate)
    {
        return view('admin.tax-rates.form', compact('taxRate'));
    }

    public function update(Request $request, TaxRate $taxRate)
    {
        $validated = $request->validate([
            'country' => 'required|string|max:5',
            'region' => 'nullable|string|max:100',
            'label' => 'required|string|max:100',
            'rate' => 'required|numeric|min:0|max:100',
            'priority' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $taxRate->update($validated + ['is_active' => $request->boolean('is_active')]);

        return redirect()->route('admin.tax-rates.index')
            ->with('success', 'Tax rate updated successfully.');
    }

    public function destroy(TaxRate $taxRate)
    {
        $taxRate->delete();

        return redirect()->route('admin.tax-rates.index')
            ->with('success', 'Tax rate deleted successfully.');
    }
}
