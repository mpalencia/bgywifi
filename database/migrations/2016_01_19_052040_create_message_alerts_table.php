<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessageAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_alerts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('homeowner_id')->unsigned()->nullable();
            $table->index('homeowner_id');
            $table->foreign('homeowner_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('action_taken_id')->unsigned()->nullable();
            $table->index('action_taken_id');
            $table->foreign('action_taken_id')->references('id')->on('action_taken')->onDelete('cascade');
            $table->string('resolved')->default(0);
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
        Schema::drop('message_alerts');
    }
}
