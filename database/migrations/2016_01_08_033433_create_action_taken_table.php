<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionTakenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_taken', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('home_owner_id')->unsigned();
            $table->index('home_owner_id');
            $table->foreign('home_owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('security_guard_id')->unsigned();
            $table->index('security_guard_id');
            $table->foreign('security_guard_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('emergency_id')->nullable()->unsigned();
            $table->index('emergency_id');
            $table->foreign('emergency_id')->references('id')->on('emergency')->onDelete('cascade');

            $table->integer('caution_id')->nullable()->unsigned();
            $table->index('caution_id');
            $table->foreign('caution_id')->references('id')->on('caution')->onDelete('cascade');

            $table->integer('unidentified_id')->nullable()->unsigned();
            $table->index('unidentified_id');
            $table->foreign('unidentified_id')->references('id')->on('alerts')->onDelete('cascade');

            $table->integer('action_taken_type_id')->unsigned();
            $table->index('action_taken_type_id');
            $table->foreign('action_taken_type_id')->references('id')->on('action_taken_type')->onDelete('cascade');

            $table->integer('status')->default(1);

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
        Schema::drop('action_taken');
    }
}
