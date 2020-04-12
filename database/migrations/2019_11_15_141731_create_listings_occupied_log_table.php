<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsOccupiedLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings_occupation_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_entry_id');
            $table->integer('listing_entry_parent_id');
            $table->string('action'); //occupied,vacated,disabled
            $table->integer('action_by_user'); //user who performed the action above
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
        Schema::dropIfExists('listings_occupation_log');
    }
}
