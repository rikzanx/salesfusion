<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Company::create([
            'name' => "SalesFusion",
            'about' => "SalesFusion is a comprehensive application that combines sales management, inventory management, as well as ERP and CRM solutions to help companies efficiently manage their operations.",
            'address' => "123 Main Street, Anytown, USA",
            'telp' => "+1234567890",
            'email' => "info@salesfusion.com",
            'image_company' => "img/img-company.svg",
            'lat' => "40.7128",
            'lng' => "-74.0060",
            'saldo' => 0
        ]);
        config(['app.name' => "SalesFusion",]);
        config(['app.icon' => "img/img-company.svg"]);
        $configPath = base_path('config/app.php');
        file_put_contents($configPath, '<?php return ' . var_export(config('app'), true) . ';');
    }
}
