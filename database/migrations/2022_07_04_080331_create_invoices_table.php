<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer("id_inv")->nullable();
            $table->string("no_invoice");
            $table->date("duedate")->nullable();
            $table->integer("id_customer");
            $table->string("comment")->nullable();
            $table->decimal("diskon_rate",10,2)->default(0);
            $table->decimal("tax_rate",10,2)->default(0);
            $table->decimal("profit",10,2)->default(0);
            $table->timestamps();
            $table->date("tanggal_pengiriman")->nullable();
            $table->decimal('dp',10,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
