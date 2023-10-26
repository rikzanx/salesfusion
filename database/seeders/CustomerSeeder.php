<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = FakerFactory::create();

        // Sesuaikan dengan jumlah data yang ingin Anda buat
        $numberOfCustomers = 30;

        for ($i = 0; $i < $numberOfCustomers; $i++) {
            \App\Models\Customer::create([
                'name_customer' => $faker->name,
                'address_customer' => $faker->address,
                'phone_customer' => $faker->phoneNumber,
            ]);
        }
    }
}
