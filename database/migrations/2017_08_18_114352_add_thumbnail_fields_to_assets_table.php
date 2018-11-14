<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbnailFieldsToAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assets', function ($table) {
            $table->string('medium_thumbnail');
            $table->string('small_thumbnail');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assets', function ($table) {
            $table->dropColumn('medium_thumbnail');
            $table->dropColumn('small_thumbnail');
        });
    }
}
