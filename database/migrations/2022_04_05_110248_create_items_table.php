<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id');
            $table->foreign('store_id')->on('stores')->references('id')->cascadeOnDelete();
            $table->foreignId('offer_id')->nullable();
            $table->foreign('offer_id')->on('offers')->references('id')->cascadeOnDelete();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->double('price');
            $table->boolean('available');
            $table->double('vat');
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
        Schema::dropIfExists('items');
    }
}
