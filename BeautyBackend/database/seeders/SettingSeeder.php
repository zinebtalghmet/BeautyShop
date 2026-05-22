<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['key' => 'store_name', 'value' => 'BeautyShop', 'group' => 'general'],
            ['key' => 'store_email', 'value' => 'support@beautyshop.com', 'group' => 'general'],
            ['key' => 'store_phone', 'value' => '+1 (555) 123-4567', 'group' => 'general'],
            ['key' => 'store_address', 'value' => '123 Beauty Street, Los Angeles, CA 90001', 'group' => 'general'],
            ['key' => 'facebook_url', 'value' => 'https://facebook.com', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com', 'group' => 'social'],
            ['key' => 'free_shipping_threshold', 'value' => '50', 'group' => 'checkout'],
            ['key' => 'tax_rate', 'value' => '0.10', 'group' => 'checkout'],
            ['key' => 'shipping_cost', 'value' => '8.99', 'group' => 'checkout'],
            ['key' => 'currency', 'value' => 'USD', 'group' => 'checkout'],
            ['key' => 'currency_symbol', 'value' => '$', 'group' => 'checkout'],
        ];

        foreach ($defaults as $data) {
            Setting::firstOrCreate(['key' => $data['key']], $data);
        }
    }
}
