<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagEntry extends Model
{
    public $table = 'tags_entries';
    protected $fillable = ['parent_id','source','source_id','user'];

    public function tag(){
        return $this->belongsTo('App\Tag','parent_id');
    }
}
