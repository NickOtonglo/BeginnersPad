<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $table = 'tags';
    protected $fillable = ['name','description','category','author'];
    
    public function tagEntries(){
        return $this->hasMany('App\TagEntry','parent_id');
    }
}
