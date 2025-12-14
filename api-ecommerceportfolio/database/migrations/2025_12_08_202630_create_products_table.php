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
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->enum('inventory_status', ['INSTOCK', 'LOWSTOCK', 'OUTOFSTOCK']);        
            $table->enum('category', ['Accessories', 'Fitness', 'Electronics', 'Clothing']);
            $table->string('image_url')->nullable();
            $table->unsignedInteger('store_id');
            $table->enum('currency', ['€', '$', '£']);
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
