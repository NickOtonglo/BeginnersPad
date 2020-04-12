<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsReportedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings_reported', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listing_entry_id');
            $table->integer('user_id');
            $table->string('issue'); //topic
            $table->text('details');
            $table->string('action')->nullable(); //a.k.a status
            $table->integer('admin_id'); //assigned to admin
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
        Schema::dropIfExists('listings_reported');
    }
}
