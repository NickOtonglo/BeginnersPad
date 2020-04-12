<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsZonesEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings_zones_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned();
            $table->foreign('parent_id')->references('id')->on('listings_zones')->onDelete('cascade');
            $table->string('name'); //subzone name
            $table->string('timezone');
            $table->string('role'); // residential,industrial,commercial... etc
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->float('radius',10,2)->nullable();
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
        Schema::dropIfExists('listings_zones_entries');
    }
}
