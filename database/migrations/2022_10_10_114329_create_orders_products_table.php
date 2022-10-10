<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('orders_id');
            $table->unsignedBiginteger('products_id');
            $table->foreign('orders_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('products_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_products');
    }
};
