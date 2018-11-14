<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject',512);
            $table->string('to',512);
            $table->string('cc',512)->nullable();
            $table->string('bcc',512)->nullable();
            $table->string('from_email',512);
            $table->string('from_name',512)->nullable();
            $table->string('replyTo',512)->nullable();
            $table->text('content');
            $table->text('attach')->nullable();
            $table->enum('status', ['pending', 'sent','failed']);    
            $table->datetime('sent')->nullable();
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
        Schema::drop('emails', function (Blueprint $table) {
            //
        });
    }
}
