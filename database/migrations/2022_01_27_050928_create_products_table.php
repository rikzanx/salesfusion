<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer("category_id");
            $table->string("name");
            $table->string('slug')->unique();
            $table->string("brand");
            $table->text("description");
            $table->integer('dilihat')->default(0);
            $table->decimal("price", 10, 2)->default(0); // Menambahkan harga produk
            $table->integer("stock")->default(0); // Menambahkan jumlah stok produk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
