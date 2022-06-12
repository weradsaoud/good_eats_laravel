<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScategoryStorePivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scategory_store', function (Blueprint $table) {
            $table->foreignId('store_id')->index();
            $table->foreign('store_id')->on('stores')->references('id')->cascadeOnDelete();
            $table->foreignId('scategory_id')->index();
            $table->foreign('scategory_id')->on('scategories')->references('id')->cascadeOnDelete();
            $table->primary(['store_id', 'scategory_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scategory_store');
    }
}
