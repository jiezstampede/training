<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateImageVarcharLimits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        
        DB::statement('ALTER TABLE `pages` CHANGE `slug` `slug` VARCHAR(255)  NULL');
        DB::statement('ALTER TABLE `pages` CHANGE `content` `content` TEXT NULL;');

        DB::statement('ALTER TABLE `long_names` CHANGE `thumb` `thumb` VARCHAR(512) NULL;');
      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE `pages` CHANGE `slug` `slug` VARCHAR(255)  NOT NULL');
        DB::statement('ALTER TABLE `pages` CHANGE `content` `content` TEXT NOT NULL;');

        DB::statement('ALTER TABLE `long_names` CHANGE `thumb` `thumb` VARCHAR(255) NULL;');

    }
}
