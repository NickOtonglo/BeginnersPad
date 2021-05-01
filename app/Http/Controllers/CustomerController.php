<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Customer;
use App\Listing;
use App\ListingApplication;
use App\Review;
use App\ListingFile;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware('checkUserStatus')->except('logout');
    }

    public function makeApplication(Request $request,$id){
        $utype = Auth::user()->user_type;
        $user = Auth::user();
        $postData = $request->all();
        $listing = Listing::where('id',$id)->first();

        switch ($request->input('btn_submit')) {
            case 'Add to Favourites':
                if ($utype==5) {
                    $favourite = new Customer;
                    $favourite->customer_id = $user->id;
                    $favourite->lister_id = $listing->user_id;
                    $favourite->property_id = $listing->id;
                    $favourite->lister_name = $listing->lister_name;
                    $favourite->property_name = $listing->property_name;
                    $favourite->location = $listing->location;
                    $favourite->available_units = $listing->available_units;
                    $favourite->cost = $listing->cost;
                    $favourite->save();

                    // return redirect()->route('listings.list');
                    return redirect()->back();
                } else {
                    return "Not allowed";
                }
                break;

            case 'Remove from Favourites':
                if ($utype==5) {
                    $favourite = Customer::where('property_id',$id)->first();
                    $favourite->delete();
                    return redirect()->back();
                } else {
                    return "Not allowed";
                }
                break;

            case 'Apply':
                if ($utype==5) {
                    $application = new ListingApplication;
                    $application->customer_id = $user->id;
                    $application->lister_id = $listing->user_id;
                    $application->property_id = $listing->id;
                    $application->lister_name = $listing->lister_name;
                    $application->property_name = $listing->property_name;
                    $application->location = $listing->location;
                    $application->available_units = $listing->available_units;
                    $application->cost = $listing->cost;
                    $application->status = "active";
                    $application->save();

                    return redirect()->back();
                } else {
                    return "Not allowed";
                }
                break;

            case 'End Stay':
                if ($utype==5) {
                    $application = ListingApplication::where('property_id',$id)->where('customer_id',$user->id)->orderBy('created_at','id')->first();
                    $application->status = "inactive";
                    $application->save();
                    return redirect()->back();
                } else {
                    return "Not allowed";
                }
                break;

            case 'Login to apply':
                $this->middleware('auth');
                
                break;
        }
        
    }

    public function baseBeginnerNavPanel(){
        // $user = Auth::user();
        // $p_listings = Listing::orderBy('created_at','id')->take(3)->get();
        // $p_favourites = Listing::orderBy('created_at','id')->take(3)->get();
    }

    public function myApplications(){
        $user = Auth::user();
        $applications = ListingApplication::where('customer_id',$user->id)->orderBy('created_at','id')->get();
        $listings = Listing::all();
        $p_listings = Listing::orderBy('created_at','id')->take(3)->get();
        $p_favourites = Customer::where('customer_id',$user->id)->orderBy('created_at','id')->get();

        $utype = $user->user_type;
        if ($utype==5) {
            return view('layouts.my_applications',compact('applications','listings','p_listings','p_favourites'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function myFavourites(){
        $user = Auth::user();
        $favourites = Customer::where('customer_id',$user->id)->orderBy('created_at','id')->get();
        $p_listings = Listing::orderBy('created_at','id')->take(3)->get();
        $p_favourites = Customer::where('customer_id',$user->id)->orderBy('created_at','id')->get();

        $utype = Auth::user()->user_type;
        if ($utype==5) {
            return view('layouts.my_favourites',compact('favourites','p_listings','p_favourites'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function reviewListing($id){
        $listings = Listing::all();

        $utype = Auth::user()->user_type;
        if ($utype==5) {
            $listing = Listing::where('id',$id)->find($id);
            return view('customers.review_listing')->with('listing',$listing);
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function myReviews(){
        $user = Auth::user();
        $reviews = Review::where('customer_id',$user->id)->orderBy('created_at','id')->get();
        $p_listings = Listing::orderBy('created_at','id')->take(3)->get();
        $p_favourites = Customer::where('customer_id',$user->id)->orderBy('created_at','id')->get();

        $utype = Auth::user()->user_type;
        if ($utype==5) {
            return view('customers.my_reviews',compact('reviews','p_listings','p_favourites'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function saveReview(Request $request,$id){

        $this->validate($request,[
            'review'=>'required|max:6000'            
            ]);

        $utype = Auth::user()->user_type;
        $user = Auth::user();
        $postData = $request->all();
        $listing = Listing::where('id',$id)->first();

        if (Review::where('customer_id','=',$user->id)->where('property_id','=',$id)->exists()){
            return "You have already reviewed this item!";
        }
        else{
            switch ($request->input('btn_submit')) {
            case 'Submit':
                if ($utype==5) {
                    $review = new Review;
                    $review->customer_id = Auth::user()->id;
                    $review->customer_name = Auth::user()->name;
                    $review->lister_id = $listing->user_id;
                    $review->property_id = $listing->id;
                    $review->lister_name = $listing->lister_name;
                    $review->property_name = $listing->property_name;
                    $review->review = $request->get('review');
                    $review->review_rating = $request->get('review_rating');
                    $review->save();

                    // return redirect()->route('listings.list');
                    return redirect()->route('customer.myReviews');
                } else {
                    return redirect()->route('listings.list');
                }
                break;
            }
        }
    }

    public function editReview($id){
        $utype = Auth::user()->user_type;
        $user = Auth::user();

        if ($utype==5) {
            $review = Review::where('property_id',$id)->first();
            return view('customers.edit_review')->with('review',$review);
        } else {
            return "Not allowed!";
        }
    }

    public function updateReview(Request $request,$id){
        $utype = Auth::user()->user_type;
        $user = Auth::user();
        $userId = Review::where('customer_id','=',$user->id)->where('property_id','=',$id)->first()->customer_id;
        if ($utype==5 && $user->id==$userId) {

            $review = Review::where('customer_id','=',$user->id)->where('property_id','=',$id)->first();

            $review->update($request->all());

            return redirect()->route('customer.myReviews');
        } else {
            return redirect()->route('listings.list');
        }
        // return $userId;
    }

    public function deleteReview($id){
        $user = Auth::user();
        $utype = Auth::user()->user_type;
        
        $userId = Review::where('customer_id','=',$user->id)->where('property_id','=',$id)->first()->customer_id;
        if ($utype==5 && $user->id==$userId) {
            $review = Review::where('customer_id','=',$user->id)->where('property_id','=',$id)->first();
            $review->delete();
            
            return redirect()->route('customer.myReviews');
        } else {
            return "Not allowed!";
        } 
    }

    public function loadWaitingList(){
    	$user = Auth::user();
        if ($user->user_type == 5) {
            $p_listings = Listing::orderBy('created_at','id')->take(3)->get();
            $p_favourites = Customer::where('customer_id',$user->id)->orderBy('created_at','id')->get();

        	return view('customers.waiting_list',compact('p_listings','p_favourites'));
        }
    }
}
