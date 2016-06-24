<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIssuesActionTakenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues_action_taken', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('home_owner_id')->unsigned();
            $table->index('home_owner_id');
            $table->foreign('home_owner_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('security_guard_id')->unsigned();
            $table->index('security_guard_id');
            $table->foreign('security_guard_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('issue_id')->nullable()->unsigned();
            $table->index('issue_id');
            $table->foreign('issue_id')->references('id')->on('suggestion_complaints')->onDelete('cascade');

            $table->text('action_taken');
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
        Schema::drop('issues_action_taken');
    }
}
