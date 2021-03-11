<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FAQLog extends Model
{
    public $table = 'help_faqs_log';
    protected $fillable = ['entry_id','question','answer','category','action','action_by'];

    public function actionBy(){
        return $this->belongsTo('App\User','action_by');
    }
}
