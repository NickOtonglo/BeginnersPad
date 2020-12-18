<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    public $table = 'help_faqs';
    protected $fillable = ['question','answer','category'];
}
