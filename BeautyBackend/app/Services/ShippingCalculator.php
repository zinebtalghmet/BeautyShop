<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\ShippingRate;

class ShippingCalculator
{
    public static function calculate(float $subtotal, string $country, ?string $region = null): array
    {
        $rate = self::resolveRate($country, $region);

        if ($rate) {
            if ($rate->free_threshold !== null && $subtotal >= (float) $rate->free_threshold) {
                return [
                    'cost' => 0,
                    'label' => $rate->label . ' (Free)',
                ];
            }

            return [
                'cost' => (float) $rate->base_rate,
                'label' => $rate->label,
            ];
        }

        $threshold = (float) (Setting::where('key', 'free_shipping_threshold')->value('value') ?: 50);
        $defaultRate = (float) (Setting::where('key', 'shipping_cost')->value('value') ?: 8.99);

        if ($subtotal >= $threshold) {
            return [
                'cost' => 0,
                'label' => 'Free Shipping',
            ];
        }

        return [
            'cost' => $defaultRate,
            'label' => 'Shipping',
        ];
    }

    private static function resolveRate(string $country, ?string $region): ?ShippingRate
    {
        $region = $region ? trim($region) : null;

        if ($region) {
            $rate = ShippingRate::active()
                ->where('country', $country)
                ->where('region', $region)
                ->orderBy('priority')
                ->first();
            if ($rate) return $rate;
        }

        $rate = ShippingRate::active()
            ->where('country', $country)
            ->whereNull('region')
            ->orderBy('priority')
            ->first();
        if ($rate) return $rate;

        $rate = ShippingRate::active()
            ->where('country', '*')
            ->orderBy('priority')
            ->first();
        if ($rate) return $rate;

        return null;
    }
}
