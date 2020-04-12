<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    public $table = "users_reported";
    public $fillable = ['reported_user_id','user_id','issue','details','action','admin_id'];

    public function user(){
        return $this->belongsTo('App\User','reported_user_id');
    }
}
