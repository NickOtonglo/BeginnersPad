<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lister_id');
            $table->string('property_name');
            $table->text('description');
            $table->integer('zone_entry_id');
            $table->string('lat');
            $table->string('lng');
            $table->string('listing_type'); //single,multi
            $table->string('thumbnail');
            $table->string('stories'); //number of stories
            $table->string('status'); // pending,approved,rejected,suspended
            $table->float('price',10,2)->nullable();
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
        Schema::dropIfExists('listings');
    }
}
