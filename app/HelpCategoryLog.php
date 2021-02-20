<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpCategoryLog extends Model
{
    public $table = "help_categories_log";
    protected $fillable = ['parent_id','name','priority','action','admin_id'];

    public function categoryLog(){
        return $this->belongsTo('App\HelpCategory','parent_id');
    }

    public function user(){
        return $this->belongsTo('App\User','admin_id');
    }
}
