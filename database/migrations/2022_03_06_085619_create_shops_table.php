<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email');
            $table->string('manager_name');
            $table->float('rating')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
//user_id,name,description,adress,phone,mail,meneger,reyting

// logging


// produt - shop_id, category_id, name, description, price, count, rating
//images table - product_id - image

// pph artisan make:controller ProductController --api

// HomeWork //
// validation product, shop, category
// sarqel category show shop show-i nman

// migracianeri mej karox e linel edit_..._table
