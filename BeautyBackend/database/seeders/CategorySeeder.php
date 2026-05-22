<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Skincare', 'description' => 'Skincare products including cleansers, serums, moisturizers, and treatments.', 'sort_order' => 1],
            ['name' => 'Makeup', 'description' => 'Makeup products including foundation, lipstick, eyeshadow, and more.', 'sort_order' => 2],
            ['name' => 'Tools & Accessories', 'description' => 'Beauty tools and accessories including brushes, sponges, and mirrors.', 'sort_order' => 3],
            ['name' => 'Haircare', 'description' => 'Haircare products including shampoo, conditioner, serums, and treatments.', 'sort_order' => 4],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(
                ['name' => $data['name']],
                $data + ['is_active' => true]
            );
        }
    }
}
