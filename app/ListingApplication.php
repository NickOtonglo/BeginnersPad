<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingApplication extends Model
{
	public $table = 'listings_occupation_log';
    protected $fillable = ['listing_entry_id','listing_entry_parent_id','action','action_by_user'];

	public function listing(){
		return $this->belongsTo('App\ListingEntry','listing_entry_id');
	}
}
