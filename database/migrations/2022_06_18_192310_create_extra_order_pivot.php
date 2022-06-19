<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraOrderPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_order', function (Blueprint $table) {
            $table->foreignId('order_id')->index();
            $table->foreign('order_id')->on('orders')->references('id')->cascadeOnDelete();
            $table->foreignId('extra_id')->index();
            $table->foreign('extra_id')->on('extras')->references('id')->cascadeOnDelete();
            $table->primary(['order_id', 'extra_id']);
            $table->integer('count')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_order');
    }
}
