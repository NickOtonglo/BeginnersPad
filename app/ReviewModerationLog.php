<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewModerationLog extends Model
{
    public $table = "listing_reviews_moderation_log";
    protected $fillable = ['customer_id','customer_name','lister_id','listing_id','review','review_rating','reason','admin_id'];
}
