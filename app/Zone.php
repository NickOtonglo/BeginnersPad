<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    public $table = "listings_zones";
    protected $fillable = ['name','country','county','state','lat','lng','radius','timezone'];

    public function zoneEntry(){
        return $this->hasMany('App\ZoneEntry','parent_id');
    }
}
