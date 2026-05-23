<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $edp = Category::where('name', 'Eau de Parfum')->first();
        $edt = Category::where('name', 'Eau de Toilette')->first();
        $cologne = Category::where('name', 'Cologne')->first();
        $oils = Category::where('name', 'Perfume Oils')->first();
        $gifts = Category::where('name', 'Gift Sets')->first();
        $niche = Category::where('name', 'Niche & Luxury')->first();

        $products = [
            [
                'category_id' => $edp->id, 'name' => 'Blooming Rose',
                'price' => 89.00, 'original_price' => 110.00, 'stock' => 35,
                'rating' => 4.8, 'reviews_count' => 142, 'is_featured' => true,
                'description' => 'A captivating floral fragrance that captures the essence of a blooming rose garden at dawn. Notes of fresh damask rose, violet leaf, and soft musk create an elegant and timeless scent.',
                'features' => ['Top notes: Bergamot, Violet Leaf', 'Heart notes: Damask Rose, Jasmine', 'Base notes: Musk, Sandalwood, Amber', 'Longevity: 6-8 hours', 'Concentration: 20% perfume oil'],
            ],
            [
                'category_id' => $edp->id, 'name' => 'Velvet Noir',
                'price' => 120.00, 'original_price' => 120.00, 'stock' => 20,
                'rating' => 4.9, 'reviews_count' => 98, 'is_featured' => true,
                'description' => 'A bold and sophisticated dark floral-woody fragrance. Black rose, rich oud, and warm amber create an intense, seductive scent that commands attention.',
                'features' => ['Top notes: Black Currant, Pink Pepper', 'Heart notes: Black Rose, Saffron', 'Base notes: Oud, Amber, Patchouli', 'Longevity: 8-10 hours', 'Concentration: 25% perfume oil'],
            ],
            [
                'category_id' => $edt->id, 'name' => 'Ocean Breeze',
                'price' => 65.00, 'original_price' => 65.00, 'stock' => 50,
                'rating' => 4.6, 'reviews_count' => 87, 'is_featured' => false,
                'description' => 'A fresh aquatic fragrance that transports you to a serene seaside escape. Marine accord, white musk, and citrus notes create a clean and invigorating scent.',
                'features' => ['Top notes: Sea Salt, Lemon, Bergamot', 'Heart notes: Lavender, Sage, Aquatic Notes', 'Base notes: White Musk, Cedarwood, Driftwood', 'Longevity: 4-6 hours', 'Concentration: 10% perfume oil'],
            ],
            [
                'category_id' => $edt->id, 'name' => 'Jasmine Nights',
                'price' => 72.00, 'original_price' => 88.00, 'stock' => 30,
                'rating' => 4.7, 'reviews_count' => 115, 'is_featured' => true,
                'description' => 'An enchanting white floral fragrance inspired by warm Mediterranean evenings. Star jasmine, orange blossom, and creamy vanilla create a romantic and radiant aura.',
                'features' => ['Top notes: Bergamot, Pear, Pink Pepper', 'Heart notes: Jasmine, Orange Blossom, Ylang-Ylang', 'Base notes: Vanilla, Sandalwood, White Musk', 'Longevity: 5-7 hours', 'Concentration: 12% perfume oil'],
            ],
            [
                'category_id' => $cologne->id, 'name' => 'Fresh Citrus',
                'price' => 55.00, 'original_price' => 55.00, 'stock' => 60,
                'rating' => 4.5, 'reviews_count' => 73, 'is_featured' => false,
                'description' => 'A vibrant and zesty cologne that bursts with sun-ripened citrus. Sicilian lemon, juicy grapefruit, and a touch of mint create an uplifting and energizing scent.',
                'features' => ['Top notes: Sicilian Lemon, Grapefruit, Mint', 'Heart notes: Petitgrain, Rosemary, Coriander', 'Base notes: White Musk, Vetiver, Oakmoss', 'Longevity: 3-4 hours', 'Concentration: 5% perfume oil'],
            ],
            [
                'category_id' => $oils->id, 'name' => 'White Musk',
                'price' => 45.00, 'original_price' => 45.00, 'stock' => 40,
                'rating' => 4.8, 'reviews_count' => 164, 'is_featured' => true,
                'description' => 'A纯净 and sensual alcohol-free perfume oil. Clean white musk layered with soft florals and a hint of amber creates a signature scent that feels like your own skin, but better.',
                'features' => ['Notes: White Musk, Lily of the Valley, Rose', 'Alcohol-free formula', 'Roll-on application', 'Longevity: 8-12 hours', 'Concentrated oil format'],
            ],
            [
                'category_id' => $oils->id, 'name' => 'Amber Oud',
                'price' => 58.00, 'original_price' => 58.00, 'stock' => 25,
                'rating' => 4.9, 'reviews_count' => 91, 'is_featured' => false,
                'description' => 'A warm and exotic perfume oil that blends rich amber with precious oud wood. Hints of saffron and leather add depth to this luxurious, long-lasting fragrance oil.',
                'features' => ['Notes: Amber, Oud, Saffron, Leather', 'Alcohol-free formula', 'Roll-on application', 'Longevity: 10-14 hours', 'Concentrated oil format'],
            ],
            [
                'category_id' => $niche->id, 'name' => 'Platinum',
                'price' => 195.00, 'original_price' => 195.00, 'stock' => 10,
                'rating' => 5.0, 'reviews_count' => 42, 'is_featured' => true,
                'description' => 'An exclusive artisanal eau de parfum crafted with rare and precious ingredients. Iris butter, ambergris, and real Omani frankincense create an impossibly refined and sophisticated scent.',
                'features' => ['Top notes: Pink Pepper, Frankincense', 'Heart notes: Iris Butter, Orris Root, Rose Absolute', 'Base notes: Ambergris, Vetiver, Leather, Musk', 'Longevity: 10-12 hours', 'Handcrafted in limited batches'],
            ],
            [
                'category_id' => $gifts->id, 'name' => 'Luxury Gift Set — Diamond',
                'price' => 150.00, 'original_price' => 185.00, 'stock' => 15,
                'rating' => 4.9, 'reviews_count' => 67, 'is_featured' => true,
                'description' => 'A lavish gift set featuring full-size Blooming Rose Eau de Parfum, matching body lotion, and a travel-sized atomizer. Presented in an elegant keepsake box.',
                'features' => ['Full-size Blooming Rose EdP (50ml)', 'Matching body lotion (100ml)', 'Travel atomizer (10ml)', 'Luxury keepsake gift box', 'Perfect for gifting'],
            ],
            [
                'category_id' => $gifts->id, 'name' => 'Travel Trio Gift Set',
                'price' => 85.00, 'original_price' => 85.00, 'stock' => 22,
                'rating' => 4.7, 'reviews_count' => 53, 'is_featured' => false,
                'description' => 'Three miniature versions of our best-selling fragrances in a portable gift set. Includes Blooming Rose, Ocean Breeze, and Jasmine Nights — perfect for travel or discovery.',
                'features' => ['Blooming Rose EdP (10ml)', 'Ocean Breeze EdT (10ml)', 'Jasmine Nights EdT (10ml)', 'Compact travel case', 'TSA-friendly sizes'],
            ],
        ];

        foreach ($products as $data) {
            Product::firstOrCreate(
                ['slug' => str($data['name'])->slug()],
                $data + ['is_active' => true]
            );
        }
    }
}
