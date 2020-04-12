<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_entry_id')->unsigned();
            $table->foreign('listing_entry_id')->references('id')->on('listings_entries')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_type'); // image,audio,video... etc
            $table->string('category'); // regular,thumbnail
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
        Schema::dropIfExists('listing_files');
    }
}
