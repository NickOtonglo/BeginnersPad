<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('help_faqs_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entry_id'); //id of FAQ
            $table->string('question');
            $table->text('answer');
            $table->string('category');
            $table->string('action'); //create,update,delete
            $table->string('action_by'); //admin
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
        Schema::dropIfExists('help_faqs_log');
    }
}
