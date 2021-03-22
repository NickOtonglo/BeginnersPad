<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public $table = 'topics';
    protected $fillable = ['title','text','category','user_group','author'];
}
