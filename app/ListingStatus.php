<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingStatus extends Model
{
    public $table = "listings_occupation_status";
    protected $fillable = ['listing_entry_id','status','occupied_by_user'];

    public function listing(){
        return $this->belongsTo('App\ListingEntry','listing_entry_id');
    }
}
