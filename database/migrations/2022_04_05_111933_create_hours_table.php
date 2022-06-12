<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id');
            $table->foreign('store_id')->on('stores')->references('id')->cascadeOnDelete();
            $table->time('sat_from')->nullable();
            $table->time('sat_to')->nullable();
            $table->time('sun_from')->nullable();
            $table->time('sun_to')->nullable();
            $table->time('mon_from')->nullable();
            $table->time('mon_to')->nullable();
            $table->time('tue_from')->nullable();
            $table->time('tue_to')->nullable();
            $table->time('wed_from')->nullable();
            $table->time('wed_to')->nullable();
            $table->time('thur_from')->nullable();
            $table->time('thur_to')->nullable();
            $table->time('fri_from')->nullable();
            $table->time('fri_to')->nullable();
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
        Schema::dropIfExists('hours');
    }
}
