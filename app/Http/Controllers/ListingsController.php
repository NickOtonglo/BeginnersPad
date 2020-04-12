<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Listing;
use App\ListingApplication;
use App\Customer;
use App\Review;
use App\ListingFile;
use Illuminate\Support\Facades\Auth;

// use App\Http\Requests;

class ListingsController extends Controller
{

    // public function __construct(){
    //     $this->middleware('auth');
    // }

    public function checkUserState(){
        if (Auth::check() && Auth::user()->status == 'suspended') {
            return false;
        } else return true;
    }

    // public function review($id){
    //     $review = Review::where('property_id',$id)->find($id);
    //     return view('listings.view_review')->with('review',$review);
    // }

}
