<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminBookmark extends Model
{
    public $table = "admin_bookmarks";
    protected $fillable = ['admin_id','listing_id','listing_entry_id'];

    public function listingEntry(){
        return $this->belongsTo('App\ListingEntry','listing_entry_id');
    }

    public function listing(){
        return $this->belongsTo('App\Listing','listing_id');
    }
}