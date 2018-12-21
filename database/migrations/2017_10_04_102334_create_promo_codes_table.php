<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->text('description');
            $table->unsignedInteger('event_id')->index();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->tinyInteger('discount_type')->default(0); // 0: percent-off, 1: discount-off
            $table->float('discount');
            $table->integer('max_redemption')->default(0); // 0: no limit
            $table->integer('number_of_uses')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_paused')->default(false);
            $table->timestamps();
        });

        Schema::table('orders', function(Blueprint $table) {
           $table->unsignedInteger('promo_code_id')->nullable();
           $table->foreign('promo_code_id')->references('id')->on('promo_codes');
        });
    }

    /*
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_promo_code_id_foreign');
            $table->dropColumn('promo_code_id');
        });
        Schema::drop('promo_codes');
    }
}
