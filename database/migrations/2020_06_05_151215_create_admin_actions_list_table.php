<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminActionsListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_actions_list', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action'); //approve,reject,suspend,disable...etc
            $table->text('description')->nullable();
            $table->integer('admin_level'); //3,2,1
            $table->string('category'); //listings,users,zones...etc
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
        Schema::dropIfExists('admin_actions_list');
    }
}
