<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $skincare = Category::where('name', 'Skincare')->first();
        $makeup = Category::where('name', 'Makeup')->first();
        $tools = Category::where('name', 'Tools & Accessories')->first();
        $haircare = Category::where('name', 'Haircare')->first();

        $products = [
            ['category_id' => $skincare->id, 'name' => 'Hydrating Face Serum', 'price' => 45.99, 'original_price' => 59.99, 'stock' => 45, 'rating' => 4.8, 'reviews_count' => 124, 'is_featured' => true, 'description' => 'A lightweight, fast-absorbing serum that deeply hydrates and plumps skin.', 'features' => ['Hyaluronic acid for deep hydration', 'Vitamin E for antioxidant protection', 'Non-greasy formula', 'Suitable for all skin types']],
            ['category_id' => $skincare->id, 'name' => 'Vitamin C Brightening Cream', 'price' => 38.50, 'original_price' => 55.00, 'stock' => 32, 'rating' => 4.6, 'reviews_count' => 89, 'is_featured' => true, 'description' => 'Illuminate your complexion with this powerful vitamin C cream.', 'features' => ['Contains 15% vitamin C', 'Reduces hyperpigmentation', '24-hour moisture', 'SPF 15 protection']],
            ['category_id' => $skincare->id, 'name' => 'Gentle Cleansing Foam', 'price' => 24.99, 'original_price' => 24.99, 'stock' => 67, 'rating' => 4.7, 'reviews_count' => 156, 'is_featured' => false, 'description' => 'A soft, foaming cleanser that gently removes makeup and impurities.', 'features' => ['pH-balanced formula', 'Removes makeup effectively', 'No harsh chemicals', 'Leaves skin soft and clean']],
            ['category_id' => $makeup->id, 'name' => 'Luxstick Lipstick Set', 'price' => 32.99, 'original_price' => 46.99, 'stock' => 28, 'rating' => 4.9, 'reviews_count' => 203, 'is_featured' => true, 'description' => 'A collection of 5 long-lasting, highly pigmented lipsticks.', 'features' => ['5 luxurious shades', 'Long-lasting formula', 'Moisturizing ingredients', 'Cruelty-free']],
            ['category_id' => $makeup->id, 'name' => 'Flawless Foundation', 'price' => 42.00, 'original_price' => 52.50, 'stock' => 54, 'rating' => 4.7, 'reviews_count' => 178, 'is_featured' => true, 'description' => 'Achieve a flawless complexion with this lightweight, buildable foundation.', 'features' => ['20 shade range', 'Medium to full coverage', 'Oil-free formula', '12-hour wear']],
            ['category_id' => $tools->id, 'name' => 'Professional Makeup Brush Set', 'price' => 56.99, 'original_price' => 75.99, 'stock' => 42, 'rating' => 4.9, 'reviews_count' => 267, 'is_featured' => true, 'description' => 'Complete 12-piece brush set with synthetic bristles.', 'features' => ['12 essential brushes', 'Synthetic bristles', 'Vegan and cruelty-free', 'Storage case included']],
            ['category_id' => $tools->id, 'name' => 'Makeup Fixing Mist', 'price' => 26.50, 'original_price' => 26.50, 'stock' => 71, 'rating' => 4.6, 'reviews_count' => 98, 'is_featured' => true, 'description' => 'Lock in your makeup for all-day wear with this lightweight setting spray.', 'features' => ['All-day hold', 'Lightweight formula', 'Refreshing mist', 'Travel-friendly size']],
            ['category_id' => $tools->id, 'name' => 'LED Makeup Mirror', 'price' => 64.99, 'original_price' => 64.99, 'stock' => 23, 'rating' => 4.8, 'reviews_count' => 134, 'is_featured' => false, 'description' => 'Professional-grade mirror with adjustable LED lighting.', 'features' => ['Adjustable LED lighting', '10x magnification', '360° rotation', 'USB rechargeable']],
            ['category_id' => $haircare->id, 'name' => 'Argan Oil Hair Serum', 'price' => 34.99, 'original_price' => 34.99, 'stock' => 58, 'rating' => 4.7, 'reviews_count' => 112, 'is_featured' => false, 'description' => 'Nourish and repair damaged hair with this luxurious argan oil serum.', 'features' => ['Pure argan oil', 'Anti-frizz formula', 'Heat protection', 'Suitable for all hair types']],
            ['category_id' => $haircare->id, 'name' => 'Volumizing Shampoo & Conditioner Set', 'price' => 42.99, 'original_price' => 42.99, 'stock' => 34, 'rating' => 4.5, 'reviews_count' => 87, 'is_featured' => false, 'description' => 'Add body and bounce to fine hair with this volumizing duo.', 'features' => ['Sulfate-free', 'Adds volume', 'Color-safe', 'Paraben-free']],
            ['category_id' => $haircare->id, 'name' => 'Deep Conditioning Hair Mask', 'price' => 29.99, 'original_price' => 39.99, 'stock' => 46, 'rating' => 4.9, 'reviews_count' => 201, 'is_featured' => false, 'description' => 'Intensive treatment mask that repairs and strengthens damaged hair.', 'features' => ['Intensive repair', 'Keratin-enriched', 'Weekly treatment', 'Salon results at home']],
            ['category_id' => $skincare->id, 'name' => 'Rose Water Toner', 'price' => 22.99, 'original_price' => 22.99, 'stock' => 62, 'rating' => 4.6, 'reviews_count' => 76, 'is_featured' => false, 'description' => 'Refreshing rose water toner that balances skin pH and tightens pores.', 'features' => ['Pure rose water', 'Balances pH', 'Tightens pores', 'Alcohol-free']],
            ['category_id' => $makeup->id, 'name' => 'Glow Highlighter Palette', 'price' => 35.99, 'original_price' => 35.99, 'stock' => 39, 'rating' => 4.8, 'reviews_count' => 143, 'is_featured' => false, 'description' => 'Four stunning highlighter shades to add luminous glow to your face.', 'features' => ['4 shade palette', 'Silky powder texture', 'Long-lasting glow', 'Buildable coverage']],
            ['category_id' => $tools->id, 'name' => 'Beauty Blender Sponge Set', 'price' => 18.99, 'original_price' => 24.99, 'stock' => 95, 'rating' => 4.7, 'reviews_count' => 189, 'is_featured' => false, 'description' => 'Set of 3 makeup sponges for flawless foundation application.', 'features' => ['3-piece set', 'Latex-free', 'Reusable', 'Multiple colors']],
        ];

        foreach ($products as $data) {
            Product::firstOrCreate(
                ['slug' => str($data['name'])->slug()],
                $data + ['is_active' => true]
            );
        }
    }
}
