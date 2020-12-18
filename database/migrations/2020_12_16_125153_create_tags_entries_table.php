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
        Schema::table('tags_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('parent_id'); // id in "tags" table
            $table->text('source'); //table name e.g. topics, listing, listings_entry etc.
            $table->string('source_id'); // id in the source table
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
        Schema::table('tags_entries', function (Blueprint $table) {
            //
        });
    }
}
