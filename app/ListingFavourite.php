<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingFavourite extends Model
{
    public $table = "listings_favourites";
    protected $fillable = ['listing_entry_id','user_id'];
    
    public function listingEntry(){
		//https://laracasts.com/series/laravel-from-scratch-2017/episodes/15
		return $this->belongsTo('App\ListingEntry','listing_entry_id');
	}
}
