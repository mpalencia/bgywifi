<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('visitors_id')->unsigned();
            $table->index('visitors_id');
            $table->foreign('visitors_id')->references('id')->on('visitors')->onDelete('cascade');

            $table->integer('home_owner_id')->unsigned();
            $table->index('home_owner_id');
            $table->foreign('home_owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('homeowner_address_id')->unsigned();
            $table->index('homeowner_address_id');
            $table->foreign('homeowner_address_id')->references('id')->on('homeowner_address')->onDelete('cascade');

            $table->integer('status');
            $table->string('chikka_code')->nullable();

            $table->integer('approved_by')->nullable()->unsigned();
            $table->index('approved_by');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');

            $table->rememberToken();
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
        Schema::drop('notifications');
    }
}
