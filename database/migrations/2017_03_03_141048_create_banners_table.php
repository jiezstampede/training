<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->string('caption',512)->nullable();
            $table->enum('published', ['draft', 'published']);
            $table->integer('order')->default(100)->nullable();
            $table->string('image',512)->nullable();
            $table->string('image_thumbnail',512)->nullable();
            $table->string('link',512)->nullable();
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
        Schema::drop('banners', function (Blueprint $table) {
            //
        });
    }
}
