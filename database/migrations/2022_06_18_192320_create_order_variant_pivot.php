<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderVariantPivot extends Migration
{
    /**
     * Run the migrations. store->order, user->variant
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_variant', function (Blueprint $table) {
            $table->foreignId('variant_id')->index();
            $table->foreign('variant_id')->on('variants')->references('id')->cascadeOnDelete();
            $table->foreignId('order_id')->index();
            $table->foreign('order_id')->on('orders')->references('id')->cascadeOnDelete();
            $table->primary(['variant_id', 'order_id']);
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
        Schema::dropIfExists('order_variant');
    }
}
