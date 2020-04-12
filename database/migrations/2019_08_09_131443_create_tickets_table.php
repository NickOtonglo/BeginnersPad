<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('is_registered'); //true,false
            $table->integer('user_id')->nullable();
            $table->string('topic');
            $table->text('description');
            $table->string('status')->nullable(); //open,pending,resolved,closed,reopened
            $table->string('assigned_to')->nullable(); //admin_id
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
        Schema::dropIfExists('tickets');
    }
}
