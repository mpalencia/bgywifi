<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSuggestionComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suggestion_complaints', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('home_owner_id')->unsigned();
            $table->index('home_owner_id');
            $table->foreign('home_owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('issue_type');
            $table->text('message');
            $table->integer('resolved')->default(0);
            $table->dateTime('end_date')->nullable();
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
        Schema::drop('suggestion_complaints');
    }
}
