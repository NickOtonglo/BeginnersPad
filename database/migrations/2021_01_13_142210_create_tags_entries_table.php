<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id'); // id in "tags" table
            $table->string('source'); //table name e.g. topics, listing, listings_entry etc.
            $table->integer('source_id'); // id in the source table
            $table->integer('user');
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
        Schema::dropIfExists('tags_entries');
    }
}
