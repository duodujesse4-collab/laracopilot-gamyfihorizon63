<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Latest gadgets, smartphones, laptops, and tech accessories.', 'image_url' => 'https://picsum.photos/seed/electronics/400/300'],
            ['name' => 'Clothing & Fashion', 'description' => 'Trendy apparel, footwear, and fashion accessories for every style.', 'image_url' => 'https://picsum.photos/seed/clothing/400/300'],
            ['name' => 'Home & Garden', 'description' => 'Everything you need to make your home beautiful and functional.', 'image_url' => 'https://picsum.photos/seed/home/400/300'],
            ['name' => 'Sports & Outdoors', 'description' => 'Gear and equipment for every sport and outdoor adventure.', 'image_url' => 'https://picsum.photos/seed/sports/400/300'],
            ['name' => 'Books & Media', 'description' => 'Best-selling books, audiobooks, movies, and music.', 'image_url' => 'https://picsum.photos/seed/books/400/300'],
            ['name' => 'Beauty & Health', 'description' => 'Premium skincare, beauty products, and health supplements.', 'image_url' => 'https://picsum.photos/seed/beauty/400/300'],
            ['name' => 'Toys & Games', 'description' => 'Fun toys, board games, and educational products for all ages.', 'image_url' => 'https://picsum.photos/seed/toys/400/300'],
            ['name' => 'Automotive', 'description' => 'Car accessories, tools, and maintenance products.', 'image_url' => 'https://picsum.photos/seed/auto/400/300'],
        ];

        foreach ($categories as $cat) {
            Category::create(array_merge($cat, ['slug' => Str::slug($cat['name'])]));
        }
    }
}