<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('image');
            $table->string('background_image');
            $table->string('position')->nullable();
			$table->text('description')->nullable();
            $table->integer('order');
            $table->enum('published', ['draft', 'published']);
            $table->timestamps();
		});
		Schema::create('team_member_socials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('team_member_id');
            $table->string('name');
			$table->enum('icon_type', ['font-awesome', 'image']);    
            $table->string('icon_value',512)->nullable();
			$table->string('icon_color',512)->nullable();
			$table->text('link')->nullable();
            $table->integer('order');
            $table->enum('published', ['draft', 'published']);
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
        Schema::drop('team_members');
        Schema::drop('team_member_socials');
    }
}
