<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('options', function (Blueprint $table) {
            DB::statement("ALTER TABLE `options` CHANGE `type` `type` ENUM('text', 'asset', 'bool') ");
            $table->enum('category', ['general', 'email','admin','site']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('options', function (Blueprint $table) {
            DB::statement("ALTER TABLE `options` CHANGE `type` `type` ENUM('text', 'asset') ");
            $table->dropColumn('category');
        });
    }
}
