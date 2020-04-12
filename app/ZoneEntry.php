<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ZoneEntry extends Model
{
    public $table = "listings_zones_entries";
    public $fillable = ['parent_id','name','timezone','role','lat','lng','radius'];

    public function zone(){
        return $this->belongsTo('App\Zone','parent_id');
    }
}
