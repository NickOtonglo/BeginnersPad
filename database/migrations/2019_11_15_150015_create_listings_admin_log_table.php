<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListingsAdminLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings_admin_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id'); // id of the parent listing
            $table->integer('listing_entry_id')->nullable(); // id of the child of the parent listing
            $table->string('action'); // approved,deleted,rejected,suspended
            $table->text('reason')->nullable();
            $table->integer('admin_id');
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
        Schema::dropIfExists('listings_admin_log');
    }
}
