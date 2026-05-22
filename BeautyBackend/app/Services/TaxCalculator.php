<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\TaxRate;

class TaxCalculator
{
    public static function calculate(float $subtotal, string $country, ?string $region = null): array
    {
        $rate = self::resolveRate($country, $region);

        if (!$rate) {
            return [
                'rate' => 0,
                'label' => 'Tax',
                'amount' => 0,
            ];
        }

        $percentage = (float) $rate->rate;
        $amount = round($subtotal * $percentage / 100, 2);

        return [
            'rate' => $percentage,
            'label' => $rate->label,
            'amount' => $amount,
        ];
    }

    private static function resolveRate(string $country, ?string $region): ?TaxRate
    {
        $region = $region ? trim($region) : null;

        if ($region) {
            $rate = TaxRate::active()
                ->where('country', $country)
                ->where('region', $region)
                ->orderBy('priority')
                ->first();
            if ($rate) return $rate;
        }

        $rate = TaxRate::active()
            ->where('country', $country)
            ->whereNull('region')
            ->orderBy('priority')
            ->first();
        if ($rate) return $rate;

        $rate = TaxRate::active()
            ->where('country', '*')
            ->orderBy('priority')
            ->first();
        if ($rate) return $rate;

        $generalRate = Setting::where('key', 'tax_rate')->value('value');
        if ($generalRate && is_numeric($generalRate)) {
            $rateObj = new TaxRate();
            $rateObj->rate = (float) $generalRate;
            $rateObj->label = 'Tax';
            return $rateObj;
        }

        return null;
    }
}
