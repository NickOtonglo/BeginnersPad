<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingFile extends Model
{	
	public $table = "listings_files";
    protected $fillable = ['listing_entry_id','file_name','file_type','category'];
}
