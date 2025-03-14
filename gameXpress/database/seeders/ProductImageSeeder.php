<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        $product = Product::first();

        dd($product);
        ProductImage::create([
            'product_id' => $product->id,
            'image_url' => 'products/sample1.jpg',
            'is_primary' => true,
        ]);

        ProductImage::create([
            'product_id' => $product->id,
            'image_url' => 'products/sample2.jpg',
            'is_primary' => false,
        ]);
    }
}