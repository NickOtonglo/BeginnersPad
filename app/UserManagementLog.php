<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserManagementLog extends Model
{
    public $table = "user_management_activity_log";
    protected $fillable = ['user_id','name','user_type','status','reason','admin_id'];

    public function user(){
        return $this->belongsTo('App\User','user_id');
    }

    public function admin(){
        return $this->belongsTo('App\User','admin_id');
    }
}
