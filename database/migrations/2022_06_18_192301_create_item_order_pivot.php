<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemOrderPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_order', function (Blueprint $table) {
            $table->foreignId('order_id')->index();
            $table->foreign('order_id')->on('orders')->references('id')->cascadeOnDelete();
            $table->foreignId('item_id')->index();
            $table->foreign('item_id')->on('items')->references('id')->cascadeOnDelete();
            $table->primary(['item_id', 'order_id']);
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
        Schema::dropIfExists('item_order');
    }
}
