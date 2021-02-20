<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelpCategoriesLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_categories_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->string('name');
            $table->integer('priority');
            $table->string('action'); //create,update,delete
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
        Schema::dropIfExists('help_categories_log');
    }
}
