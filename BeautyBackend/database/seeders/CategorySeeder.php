<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Eau de Parfum', 'description' => 'Concentrated fragrances with 15-20% perfume oil, offering long-lasting scent for 6-8 hours.', 'sort_order' => 1],
            ['name' => 'Eau de Toilette', 'description' => 'Lighter everyday fragrances with 5-15% perfume oil, perfect for casual and office wear.', 'sort_order' => 2],
            ['name' => 'Cologne', 'description' => 'Fresh and invigorating scents with 2-5% perfume oil, ideal for a subtle fragrance boost.', 'sort_order' => 3],
            ['name' => 'Perfume Oils', 'description' => 'Concentrated alcohol-free perfume oils that provide a rich, long-lasting scent experience.', 'sort_order' => 4],
            ['name' => 'Gift Sets', 'description' => 'Curated fragrance collections and gift boxes, perfect for any occasion.', 'sort_order' => 5],
            ['name' => 'Niche & Luxury', 'description' => 'Exclusive artisanal fragrances crafted with rare ingredients for discerning connoisseurs.', 'sort_order' => 6],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(
                ['name' => $data['name']],
                $data + ['is_active' => true]
            );
        }
    }
}
