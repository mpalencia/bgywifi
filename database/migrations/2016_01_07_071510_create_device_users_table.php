<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeviceUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_user', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('home_owner_id')->unsigned();
            $table->index('home_owner_id');
            $table->foreign('home_owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('email');
            $table->string('mobile_no');
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
        Schema::drop('device_user');
    }
}
