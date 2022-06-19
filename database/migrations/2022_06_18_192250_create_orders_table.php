<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id');
            $table->foreign('store_id')->on('stores')->references('id')->cascadeOnDelete();
            $table->string('client_phone');
            //$table->integer('count');
            $table->double('price');
            $table->string('order_time')->nullable();
            $table->string('status');
            $table->string('client_address')->nullable();
            $table->string('client_note')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
