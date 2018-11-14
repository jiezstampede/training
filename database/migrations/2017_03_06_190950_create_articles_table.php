<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->string('slug',255)->nullable();
            $table->string('blurb',255)->nullable();
            $table->date('date');
            $table->tinyInteger('featured')->nullable();
            $table->enum('published', ['draft', 'published']);    
            $table->text('content');
            $table->string('image',512)->nullable();
            $table->string('image_thumbnail',512)->nullable();
            $table->string('author',255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles', function (Blueprint $table) {
            //
        });
    }
}
