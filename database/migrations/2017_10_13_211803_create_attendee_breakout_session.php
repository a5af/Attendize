<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendeeBreakoutSession extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendee_breakout_session', function (Blueprint $table) {
            $table->integer('attendee_id')->unsigned();
            $table->integer('breakout_session_id')->unsigned();

            $table->foreign('attendee_id')->references('id')->on('attendees')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('breakout_session_id')->references('id')->on('breakout_sessions')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('attendee_breakout_session');
    }
}
