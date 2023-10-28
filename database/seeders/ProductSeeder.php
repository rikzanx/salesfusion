<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Faker\Factory as FakerFactory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Mengambil data produk dari API
        $apiResponse = Http::get('https://dummyjson.com/products');
        
        $faker = FakerFactory::create('id_ID');

        // Sesuaikan dengan jumlah kategori produk yang ingin Anda buat
        $numberOfCategories = 10;

        for ($i = 0; $i < $numberOfCategories; $i++) {
            \App\Models\Category::create([
                'name' => $faker->word, // Nama kategori produk
                'image_category' => "img/img-category.svg",
            ]);
        }

        if ($apiResponse->successful()) {
            $products = $apiResponse->json()['products'];
            foreach($products as $i=>$product){
                \App\Models\Product::create([
                    'category_id' => mt_rand(1, 10),
                    'name' => $product['title'],
                    'brand' => $product['brand'],
                    'description' => $product['description'],
                ]);
                $id_product = $i +1;
                $stock = $faker->numberBetween(1, 100);
                \App\Models\Inventory::create([
                    'sku' => str_pad($id_product, 8, '0', STR_PAD_LEFT),
                    'name' => $product['title']." ".$product['description'], // Nama inventaris
                    'description' => $product['description'], // Deskripsi inventaris
                    'lokasi' => $faker->city, // Lokasi inventaris
                    'qty' => $stock,
                ]);

                $inventory_transaction = $faker->numberBetween(1,10);
                $inventory_sisa = $stock;
                for($xy=1;$xy <= $inventory_transaction; $xy++){
                    if($inventory_transaction == 1){
                        \App\Models\InventoryTransaction::create([
                            "inventory_id"=> $id_product,
                            "type" => "masuk",
                            "quantity" =>$inventory_sisa,
                            "notes" => $faker->sentence,
                        ]);
                    }else{
                        $enumOptions = ["masuk", "keluar"];
                        $randomValue = $enumOptions[array_rand($enumOptions)];
                        if($xy == 1){
                            $randomValue = "masuk";
                        }
                        if($xy == $inventory_transaction){
                            \App\Models\InventoryTransaction::create([
                                "inventory_id"=> $id_product,
                                "type" => "masuk",
                                "quantity" =>$inventory_sisa,
                                "notes" => $faker->sentence,
                            ]);
                        }else{
                            $quantity = $faker->numberBetween(1, ($stock/$inventory_transaction));
                            \App\Models\InventoryTransaction::create([
                                "inventory_id"=> $id_product,
                                "type" => $randomValue,
                                "quantity" =>$quantity,
                                "notes" => $faker->sentence,
                            ]);
                            if($randomValue == "masuk"){
                                $inventory_sisa -= $quantity;
                            }else{
                                $inventory_sisa += $quantity;
                            }
                        }
                    }
                }

                $numberOfImagesProduct = 5;
                for($z=0;$z < $numberOfImagesProduct;$z ++){
                    // seeder untuk foto produk
                    \App\Models\ImagesProduct::create([
                        'product_id' => $id_product,
                        'image_product' => "img/img-product-new.jpeg",
                    ]);
                    \App\Models\ImagesInventory::create([
                        "inventory_id" => $id_product,
                        "image_inventory" => "img/img-product-new.jpeg",
                    ]);
                }
            }
        }
    }
}
