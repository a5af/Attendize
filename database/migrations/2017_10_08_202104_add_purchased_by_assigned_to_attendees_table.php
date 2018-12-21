<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchasedByAssignedToAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendees', function(Blueprint $table) {
            $table->unsignedInteger('purchased_by')->index()->nullable();
            $table->foreign('purchased_by')->references('id')->on('users');
            $table->string('assigned_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendees', function (Blueprint $table) {
            $table->dropForeign('attendees_purchased_by_foreign');
            $table->dropColumn('purchased_by');
            $table->dropColumn('assigned_to');
        });
    }
}
