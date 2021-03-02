<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpTicket extends Model
{
    public $table = "tickets";
    protected $fillable = ['email','is_registered','user_id','topic','description','status','assigned_to'];

    public function helpCategory(){
        return $this->belongsTo('App\HelpCategory','topic','name');
    }

    public function assignedToUser(){
        return $this->belongsTo('App\User','assigned_to');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function userEmail(){
        return $this->belongsTo('App\User','email','email');
    }
}
