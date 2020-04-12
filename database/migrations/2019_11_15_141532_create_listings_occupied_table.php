<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsOccupiedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings_occupation_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_entry_id')->unsigned();
            $table->foreign('listing_entry_id')->references('id')->on('listings_entries')->onDelete('cascade');
            $table->string('status'); //occupied,vacant,disabled
            $table->integer('occupied_by_user')->nullable(); //id of user occupying this listing
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
        Schema::dropIfExists('listings_occupation_status');
    }
}
