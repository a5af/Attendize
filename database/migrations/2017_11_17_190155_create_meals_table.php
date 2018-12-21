<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals', function(Blueprint $table) {
          $table->increments('id');
          $table->string('type');
          $table->date('date');
          $table->string('option');
          $table->unsignedInteger('event_id')->index();
          $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
          $table->unsignedInteger('account_id')->index();
          $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
          $table->unsignedInteger('user_id');
          $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
      Schema::drop('meals');
    }
}
