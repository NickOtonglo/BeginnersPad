<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HelpTicketsActivityLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets_activity_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id');
            $table->string('user_email');
            $table->string('old_status');
            $table->string('action'); //close,reopen,unassign,assign
            $table->string('action_by');
            $table->string('action_to');
            $table->string('new_status');
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
        Schema::dropIfExists('tickets_activity_log');
    }
}
