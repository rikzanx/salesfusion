<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImagesSliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\ImagesSlider::create([
            'image_slider' => "img/img-slider.svg",
        ]);
        \App\Models\ImagesSlider::create([
            'image_slider' => "img/img-slider.svg",
        ]);
        \App\Models\ImagesSlider::create([
            'image_slider' => "img/img-slider.svg",
        ]);
    }
}
