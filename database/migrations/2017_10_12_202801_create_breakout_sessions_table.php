<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBreakoutSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakout_sessions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->integer('capacity');
            $table->integer('number_of_subscribers')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->unsignedInteger('event_id')->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->unsignedInteger('account_id')->index();
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_live')->default(true);
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
        Schema::drop('breakout_sessions');
    }
}
