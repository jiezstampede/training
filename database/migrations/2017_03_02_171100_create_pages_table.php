<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug',255);
            $table->string('name',255);
            $table->text('value')->nullable();
            $table->string('title',255)->nullable();
            $table->string('blurb',255)->nullable();
            $table->text('description');
            $table->string('button_caption',255)->nullable();
            $table->text('button_link')->nullable();
            $table->string('image',255)->nullable();
            $table->string('video',255)->nullable();
            $table->string('yt_video')->nullable();
            $table->text('content')->nullable();
            $table->enum('icon_type', ['font-awesome', 'image']);    
			$table->string('icon_value',255)->nullable();
            $table->enum('published', ['draft', 'published']);    
            $table->text('json_data')->nullable();
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
        Schema::drop('pages');
    }
}
