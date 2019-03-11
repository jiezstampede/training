<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_items', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('page_id');
            $table->text('slug');
            $table->string('title')->nullable();
            $table->text('value')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('order');
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
        Schema::drop('page_items');
    }
}
