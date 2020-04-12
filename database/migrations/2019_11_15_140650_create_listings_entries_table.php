<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('listings')->onDelete('cascade');
            $table->string('listing_name'); //house number/house id/house name... etc
            $table->text('description')->nullable();
            $table->float('floor_area',10,2);
            $table->text('disclaimer')->nullable();
            $table->text('features')->nullable();
            $table->string('status'); //active,inactive
            $table->float('initial_deposit',10,2)->default('0'); //value of initial deposit
            $table->integer('initial_deposit_period')->default('0'); //period (months) in which the initial deposit remains valid
            $table->float('price',10,2);
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
        Schema::dropIfExists('listings_entries');
    }
}
