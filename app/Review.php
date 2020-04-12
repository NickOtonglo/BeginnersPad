<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $table = "listings_reviews";
    protected $fillable = ['user_id','listing_entry_id','parent_id','comments','rating'];

	public function listingEntry(){
		return $this->belongsTo('App\ListingEntry','listing_entry_id');
	}
}
