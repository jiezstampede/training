<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSamplesTypesPivotTableForAssets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_samples_type', function (Blueprint $table) {
            $table->integer('asset_id')->references('id')->on('assets');
            $table->integer('samples_type_id')->references('id')->on('samples_type');
            $table->tinyInteger('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('asset_samples_type');
    }
}
