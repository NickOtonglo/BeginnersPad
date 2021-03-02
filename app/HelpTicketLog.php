<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpTicketLog extends Model
{
    public $table = "tickets_activity_log";
    protected $fillable = ['ticket_id','user_email','old_status','action','action_by','action_to','new_status'];

    public function actionByUser(){
        return $this->belongsTo('App\User','action_by');
    }
}