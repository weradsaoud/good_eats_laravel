<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIcategoryItemPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('icategory_item', function (Blueprint $table) {
            $table->foreignId('icategory_id')->index();
            $table->foreign('icategory_id')->on('icategories')->references('id')->cascadeOnDelete();
            $table->foreignId('item_id')->index();
            $table->foreign('item_id')->on('items')->references('id')->cascadeOnDelete();
            $table->primary(['icategory_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('icategory_item');
    }
}
