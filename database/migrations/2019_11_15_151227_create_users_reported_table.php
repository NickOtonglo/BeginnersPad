<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersReportedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_reported', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('reported_user_id');
            $table->integer('user_id'); //user who made the report
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
        Schema::dropIfExists('users_reported');
    }
}
