<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ListingAdminLog extends Model
{
    public $table = "listings_admin_log";
    protected $fillable = ['parent_id','listing_entry_id','action','reason','admin_id'];
}
