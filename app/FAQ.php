<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    public $table = 'faqs';
    protected $fillable = ['question','answer','category'];
}
