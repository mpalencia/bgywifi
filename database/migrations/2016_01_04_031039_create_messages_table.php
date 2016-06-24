<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('message');
            $table->string('category');

            $table->integer('from_user_id')->unsigned();
            $table->index('from_user_id');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('to_user_id')->unsigned();
            $table->index('to_user_id');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('status')->default(0);
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
        Schema::drop('messages');
    }
}
