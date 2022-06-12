<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraVariantPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_variant', function (Blueprint $table) {
            $table->foreignId('extra_id')->index();
            $table->foreign('extra_id')->on('extras')->references('id')->cascadeOnDelete();
            $table->foreignId('variant_id')->index();
            $table->foreign('variant_id')->on('variants')->references('id')->cascadeOnDelete();
            $table->primary(['extra_id', 'variant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extra_variant');
    }
}
