<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = ['lister_id','property_name','description','zone_entry_id','lat','lng','listing_type','thumbnail','stories','status','price'];

    // public function favourite(){
    // 	return $this->hasMany('App\Customer','property_id',);
    // }

    public function listingEntry(){
        return $this->hasMany('App\ListingEntry','parent_id'); //parent_id is the foreign key found in the model ListingEntry
    }

    public function listingManagement(){
        return $this->hasMany('App\ListingManagement','property_id');
    }

}