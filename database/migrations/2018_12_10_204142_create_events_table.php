<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');

            $table->string('sid');
            $table->string('trans-id');
            $table->string('status');
            $table->string('base-price-point');
            $table->string('msisdn');
            $table->string('keyword');
            $table->string('Validity');
            $table->string('next_renewal_date');
            $table->string('Shortcode');
            $table->string('billed-price-point');
            $table->string('trans-status');
            $table->string('chargeCode');
            $table->string('datetime');
            $table->string('event-type');
            $table->string('channel');

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
        Schema::dropIfExists('events');
    }
}
