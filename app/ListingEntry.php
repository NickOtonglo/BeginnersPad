<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingEntry extends Model
{
    public $table = 'listings_entries';
    protected $fillable = ['parent_id','listing_name','description','floor_area','disclaimer','features','status','initial_deposit','initial_deposit_period','price'];

    public function listing(){
        return $this->belongsTo('App\Listing','parent_id');
    }

    public function listingFile(){
        return $this->hasMany('App\ListingFile','listing_entry_id');
    }

    public function review(){
        return $this->hasMany('App\Review','listing_entry_id');
    }

    public function listingReport(){
        return $this->hasMany('App\ListingReport','listing_entry_id');
    }
}
