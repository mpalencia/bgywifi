<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('home_owner_id')->unsigned();
            $table->index('home_owner_id');
            $table->foreign('home_owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('ref_category_id')->unsigned();
            $table->index('ref_category_id');
            $table->foreign('ref_category_id')->references('id')->on('ref_category')->onDelete('cascade');

            $table->integer('homeowner_address_id')->unsigned();
            $table->index('homeowner_address_id');
            $table->foreign('homeowner_address_id')->references('id')->on('homeowner_address')->onDelete('cascade');

            $table->string('name');
            $table->date('start');
            $table->date('end');
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
        Schema::drop('event');
    }
}
