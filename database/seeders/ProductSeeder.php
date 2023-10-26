<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder untuk Kategori Produk
        \App\Models\Category::create([
            'name' => "Category 1",
            'image_category' => "img/img-category.svg",
        ]);

        \App\Models\Category::create([
            'name' => "Category 2",
            'image_category' => "img/img-category.svg",
        ]);

        \App\Models\Category::create([
            'name' => "Category 3",
            'image_category' => "img/img-category.svg",
        ]);

        // Seeder untuk Produk
        \App\Models\Product::create([
            'category_id' => 1,
            'name' => "Product 1",
            'brand' => "Brand A",
            'description' => "This is Product 1 from Category 1.",
        ]);

        \App\Models\Product::create([
            'category_id' => 1,
            'name' => "Product 2",
            'brand' => "Brand B",
            'description' => "This is Product 2 from Category 1.",
        ]);

        \App\Models\Product::create([
            'category_id' => 2,
            'name' => "Product 3",
            'brand' => "Brand X",
            'description' => "This is Product 3 from Category 2.",
        ]);

        \App\Models\Product::create([
            'category_id' => 3,
            'name' => "Product 4",
            'brand' => "Brand Z",
            'description' => "This is Product 4 from Category 3.",
        ]);

        // seeder untuk foto produk
        \App\Models\ImagesProduct::create([
            'product_id' => 1,
            'image_product' => "img/img-product.svg",
        ]);
        \App\Models\ImagesProduct::create([
            'product_id' => 1,
            'image_product' => "img/img-product.svg",
        ]);
        \App\Models\ImagesProduct::create([
            'product_id' => 1,
            'image_product' => "img/img-product.svg",
        ]);
        \App\Models\ImagesProduct::create([
            'product_id' => 1,
            'image_product' => "img/img-product.svg",
        ]);
        \App\Models\ImagesProduct::create([
            'product_id' => 2,
            'image_product' => "img/img-product.svg",
        ]);
        \App\Models\ImagesProduct::create([
            'product_id' => 2,
            'image_product' => "img/img-product.svg",
        ]);
        \App\Models\ImagesProduct::create([
            'product_id' => 3,
            'image_product' => "img/img-product.svg",
        ]);
        \App\Models\ImagesProduct::create([
            'product_id' => 4,
            'image_product' => "img/img-product.svg",
        ]);
    }
}
