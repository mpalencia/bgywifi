<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->index('user_id');
            $table->foreign('user_id')->references('id')->on('homeowner_address')->onDelete('cascade');

            $table->integer('ref_category_id')->unsigned();
            $table->index('ref_category_id');
            $table->foreign('ref_category_id')->references('id')->on('ref_category')->onDelete('cascade');

            $table->integer('home_owner_id')->unsigned();
            $table->index('home_owner_id');
            $table->foreign('home_owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('name');
            $table->string('plate_number');
            $table->string('car_description');
            $table->text('notes');
            $table->text('photo');
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
        Schema::drop('visitors');
    }
}
