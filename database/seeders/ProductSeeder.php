<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'iPhone 15 Pro Max', 'price' => 1199.99, 'compare_price' => 1299.99, 'stock' => 45, 'category' => 'Electronics', 'sku' => 'SKU-IP15PM', 'featured' => true, 'sales_count' => 320],
            ['name' => 'Samsung 4K Smart TV 65"', 'price' => 899.99, 'compare_price' => 1099.99, 'stock' => 20, 'category' => 'Electronics', 'sku' => 'SKU-SAM65TV', 'featured' => true, 'sales_count' => 185],
            ['name' => 'Sony WH-1000XM5 Headphones', 'price' => 349.99, 'compare_price' => 399.99, 'stock' => 78, 'category' => 'Electronics', 'sku' => 'SKU-SNYWH5', 'featured' => false, 'sales_count' => 412],
            ['name' => 'MacBook Pro 14" M3', 'price' => 1999.99, 'compare_price' => null, 'stock' => 15, 'category' => 'Electronics', 'sku' => 'SKU-MBP14M3', 'featured' => true, 'sales_count' => 98],
            ['name' => 'iPad Air 5th Gen', 'price' => 599.99, 'compare_price' => 649.99, 'stock' => 60, 'category' => 'Electronics', 'sku' => 'SKU-IPAD5', 'featured' => false, 'sales_count' => 210],
            ['name' => 'Men\'s Classic Oxford Shirt', 'price' => 49.99, 'compare_price' => 69.99, 'stock' => 150, 'category' => 'Clothing & Fashion', 'sku' => 'SKU-MOXF01', 'featured' => false, 'sales_count' => 540],
            ['name' => 'Women\'s Running Sneakers', 'price' => 89.99, 'compare_price' => 119.99, 'stock' => 120, 'category' => 'Clothing & Fashion', 'sku' => 'SKU-WRSN01', 'featured' => true, 'sales_count' => 380],
            ['name' => 'Slim Fit Chinos Pants', 'price' => 59.99, 'compare_price' => null, 'stock' => 90, 'category' => 'Clothing & Fashion', 'sku' => 'SKU-SFCP01', 'featured' => false, 'sales_count' => 290],
            ['name' => 'Leather Crossbody Bag', 'price' => 129.99, 'compare_price' => 159.99, 'stock' => 45, 'category' => 'Clothing & Fashion', 'sku' => 'SKU-LCB01', 'featured' => false, 'sales_count' => 175],
            ['name' => 'Stainless Steel Cookware Set', 'price' => 249.99, 'compare_price' => 329.99, 'stock' => 35, 'category' => 'Home & Garden', 'sku' => 'SKU-SSCS01', 'featured' => true, 'sales_count' => 142],
            ['name' => 'Robot Vacuum Cleaner', 'price' => 299.99, 'compare_price' => 399.99, 'stock' => 28, 'category' => 'Home & Garden', 'sku' => 'SKU-RVC01', 'featured' => true, 'sales_count' => 220],
            ['name' => 'Memory Foam Pillow Set', 'price' => 79.99, 'compare_price' => 99.99, 'stock' => 100, 'category' => 'Home & Garden', 'sku' => 'SKU-MFPS01', 'featured' => false, 'sales_count' => 480],
            ['name' => 'Yoga Mat Premium', 'price' => 59.99, 'compare_price' => 79.99, 'stock' => 80, 'category' => 'Sports & Outdoors', 'sku' => 'SKU-YMP01', 'featured' => false, 'sales_count' => 620],
            ['name' => 'Adjustable Dumbbell Set 50lb', 'price' => 189.99, 'compare_price' => 239.99, 'stock' => 40, 'category' => 'Sports & Outdoors', 'sku' => 'SKU-ADS50', 'featured' => true, 'sales_count' => 195],
            ['name' => 'Hiking Backpack 50L', 'price' => 119.99, 'compare_price' => null, 'stock' => 55, 'category' => 'Sports & Outdoors', 'sku' => 'SKU-HBP50', 'featured' => false, 'sales_count' => 165],
            ['name' => 'Vitamin C Serum 30ml', 'price' => 34.99, 'compare_price' => 44.99, 'stock' => 200, 'category' => 'Beauty & Health', 'sku' => 'SKU-VCS30', 'featured' => false, 'sales_count' => 890],
            ['name' => 'Protein Powder Chocolate 2kg', 'price' => 69.99, 'compare_price' => 84.99, 'stock' => 110, 'category' => 'Beauty & Health', 'sku' => 'SKU-PPC2K', 'featured' => false, 'sales_count' => 720],
            ['name' => 'LEGO Technic Formula 1', 'price' => 179.99, 'compare_price' => 199.99, 'stock' => 30, 'category' => 'Toys & Games', 'sku' => 'SKU-LTGF1', 'featured' => true, 'sales_count' => 260],
            ['name' => 'Car Dash Cam 4K', 'price' => 89.99, 'compare_price' => 119.99, 'stock' => 65, 'category' => 'Automotive', 'sku' => 'SKU-CDC4K', 'featured' => false, 'sales_count' => 310],
            ['name' => 'Bestseller Novel Bundle', 'price' => 39.99, 'compare_price' => 59.99, 'stock' => 75, 'category' => 'Books & Media', 'sku' => 'SKU-BNB01', 'featured' => false, 'sales_count' => 430],
        ];

        foreach ($products as $p) {
            $category = Category::where('name', $p['category'])->first();
            if (!$category) continue;
            Product::create([
                'name' => $p['name'],
                'slug' => Str::slug($p['name']) . '-' . rand(100, 999),
                'description' => 'This is a premium quality ' . strtolower($p['name']) . '. It features top-of-the-line specifications and build quality that exceeds expectations. Perfect for everyday use or as a gift. Backed by our satisfaction guarantee and fast shipping.',
                'price' => $p['price'],
                'compare_price' => $p['compare_price'],
                'stock' => $p['stock'],
                'sku' => $p['sku'],
                'image_url' => 'https://picsum.photos/seed/' . $p['sku'] . '/600/600',
                'category_id' => $category->id,
                'featured' => $p['featured'],
                'active' => true,
                'sales_count' => $p['sales_count'],
            ]);
        }
    }
}