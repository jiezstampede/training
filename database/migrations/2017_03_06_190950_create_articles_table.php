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
            $table->string('title',255);
			$table->text('slug');
            $table->string('author',255)->nullable();
            $table->date('date');
            $table->text('excerpt');
            $table->text('content');
			$table->string('thumbnail',512)->nullable();
			$table->string('banner_image',512)->nullable();
			$table->string('banner_subtitle',255);
			$table->date('date_published')->nullable();
			$table->integer('featured');
			$table->enum('published', ['draft', 'published']);
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
