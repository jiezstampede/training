<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //USE POSSIBLE FIELDS BELOW 
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id')->unsigned(); //required to be first in the order
            $table->string('name',255); 
            $table->string('slug',255)->nullable(); //needs to be nullable, gets the 2nd field and creates a slug automatically 
            $table->date('date')->nullable(); //automatically creates mm/dd/yyyy dropdown field
            $table->tinyInteger('tinyint')->default(0)->nullable(); //creates ON/OFF toggle
            $table->integer('order')->default(100)->nullable(); //automatically creates table admin can re-order | should be nullable
            $table->integer('integer'); 
            $table->string('image')->nullable(); //creates uploadable assets 
            $table->string('image_thumbnail',512)->nullable(); // | should be nullable
            $table->enum('enum', ['one', 'two']); //auto creates dropdown
            $table->text('text')->nullable(); // auto create WYSIWYG editor // 
            $table->timestamps(); // creates timestamps for created and updated including user id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tests');
    }
}
