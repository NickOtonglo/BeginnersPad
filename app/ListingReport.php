<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingReport extends Model
{
    public $table = "listings_reported";
    protected $fillable = ['listing_entry_id','user_id','issue','details','action','admin_id'];

    public function listingEntry(){
        return $this->belongsTo('App\ListingEntry','listing_entry_id');
    }
}
