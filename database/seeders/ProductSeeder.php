<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $faker = FakerFactory::create('id_ID');

        // Sesuaikan dengan jumlah kategori produk yang ingin Anda buat
        $numberOfCategories = 10;

        for ($i = 0; $i < $numberOfCategories; $i++) {
            \App\Models\CategoryProduct::create([
                'name' => $faker->word, // Nama kategori produk
                'image_category' => "img/img-category.svg",
            ]);
        }

        $numberOfProducts = 50;

        for ($i = 0; $i < $numberOfProducts; $i++) { // Nama produk
            $name_product = $faker->word;
            $brand = $faker->company;
            $description = $faker->text;
            \App\Models\Product::create([
                'category_id' => mt_rand(1, 10),
                'name' => $name_product,
                'brand' => $brand,
                'description' => $description,
            ]);

            $id_product = $i +1;
            $stock = $faker->numberBetween(1, 100);
            \App\Models\Inventory::create([
                'sku' => str_pad($id_product, 8, '0', STR_PAD_LEFT),
                'name' => $name_product, // Nama inventaris
                'description' => $faker->text, // Deskripsi inventaris
                'lokasi' => $faker->city, // Lokasi inventaris
                'qty' => $stock,
            ]);

            $inventory_transaction = $faker->numberBetween(1,10);
            $inventory_sisa = $inventory_transaction;
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
                    if($xy == $inventory_transaction){
                        \App\Models\InventoryTransaction::create([
                            "inventory_id"=> $id_product,
                            "type" => "masuk",
                            "quantity" =>$inventory_sisa,
                            "notes" => $faker->sentence,
                        ]);
                    }else{
                        $quantity = $faker->numberBetween(1, $inventory_sisa);
                        \App\Models\InventoryTransaction::create([
                            "inventory_id"=> $id_product,
                            "type" => $randomValue,
                            "quantity" =>$quantity,
                            "notes" => $faker->sentence,
                        ]);
                        if($randomValue == "masuk"){
                            $inventory_sisa -= $quantity;
                        }else{
                            $inventory_sisa -= $quantity;
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
                    "image_inventory" => => "img/img-product-new.jpeg",
                ]);
            }
        }
    }
}
