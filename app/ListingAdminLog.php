<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingAdminLog extends Model
{
    public $table = "listings_admin_log";
    protected $fillable = ['parent_id','listing_entry_id','action','reason','admin_id'];

    public function listing(){
	    return $this->belongsTo('App\Listing','parent_id');
    }
    
    public function listingEntry(){
	     return $this->belongsTo('App\ListingEntry','listing_entry_id');
    }
    
    public function user(){
	    return $this->belongsTo('App\User','admin_id');
	}
}
