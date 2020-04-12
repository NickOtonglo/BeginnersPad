<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpTicket extends Model
{
    public $table = "tickets";
    protected $fillable = ['email','is_registered','user_id','topic','description','status','assigned_to'];
}
