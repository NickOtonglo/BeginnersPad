<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\ListingApplication;
use App\ListingFavourite;
use App\Review;
use App\ListingFile;
use App\ListingEntry;
use Illuminate\Support\Facades\Auth;
use Image;
use File;

class ListerController extends Controller
{
    public function checkUserState(){
        if (Auth::check() && Auth::user()->status == 'suspended') {
            return false;
        } else return true;
    }

    public function manageListings(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

    	$user = Auth::user();
    	$userType = $user->user_type;
        $API_KEY = config('constants.API_KEY.maps');
    	$listings = Listing::where('lister_id',$user->id)->orderBy('created_at','id')->get();
    	if ($userType == 4) {
    	    return view('listers.manage_listings',compact('listings','API_KEY'));
    	} else {
    	    return redirect()->route('listings.list');
    	}
    }

    public function createListing(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $utype = Auth::user()->user_type;
        $API_KEY = config('constants.API_KEY.maps');
        if ($utype==4){
            return view('listings.new_listing',compact('API_KEY'));
        }
        else {
            return redirect('/');
        }
    }

    public function storeListing(Request $request){

    	// $this->validate($request,[
    	// 	'property_name'=>'required|max:50',
    	// 	'description'=>'required|max:10000',
    	// 	'location'=>'required|max:50',
    	// 	'lat'=>'required',
    	// 	'lng'=>'required',
    	// 	'available_units'=>'required', 
    	// 	'units_sum'=>'required',
    	// 	'unit_area'=>'required',
    	// 	'cost'=>'required',
        //     'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    	// 	]);

        // if (!$this->checkUserState()) {
        //     return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
        //     Auth::logout();
        // }

        // $formData = $request->all();
        // $user = Auth::user();
        
        // $listings = Listing::where('user_id',$user->id)->orderBy('created_at','id')->get();

        // $postData = array_merge($request->all(),['lister_name'=>Auth::user()->name],['user_id'=>Auth::user()->id]);
        // Listing::create($postData);

        // if ($request->hasFile('post_images')) {
        //     $images = $request->file('post_images');

        //     if (!File::exists('images/listings/'.$user->id.'/')) {
        //         File::makeDirectory('images/listings/'.$user->id.'/',0777,true);
        //     }
        //     if (!File::exists('images/listings/'.$user->id.'/thumbnails/')) {
        //         File::makeDirectory('images/listings/'.$user->id.'/thumbnails/',0777,true);
        //     }
        //     foreach ($images as $image) {
        //         $fileName = $user->id.'_'.time().'_'.rand(1111,9999).'.'.$image->getClientOriginalExtension();
        //         $location = public_path('images/listings/'.$user->id.'/'.$fileName);
        //         $img = new ListingFile;
        //         $img->listing_id = Listing::where('user_id',$user->id)->orderBy('created_at','id')->first()->id;
        //         $img->file_name = $fileName;
        //         $img->file_type = 'image';
        //         $img->category = 'regular';
        //         if (!$img->save()) {
        //             return false;
        //         }
        //         Image::make($image)->resize(640,480, function($constraint){
        //             $constraint->aspectRatio();
        //         })->save($location); 
        //         $img->save();
        //     }
        //     $fileName = $user->id.'_'.time().'_'.$request->property_name.'_thumb.'.$image->getClientOriginalExtension();
        //     $thumbLocation = public_path('images/listings/'.$user->id.'/thumbnails/'.$fileName);
        //     $thumb = new ListingFile;
        //     $thumb->listing_id = $img->listing_id;
        //     $thumb->file_name = $fileName.'_thumb';
        //     $thumb->file_type = 'image';
        //     $thumb->category = 'thumbnail';
        //     if (!$thumb->save()) {
        //         return false;
        //     }
        //     Image::make($images[0])->resize(350,250, function($constraint){
        //         $constraint->aspectRatio();
        //     })->save($thumbLocation); 
        //     $thumb->save();
        //     $lastPost = Listing::where('user_id',$user->id)->orderBy('created_at','id')->first();
        //     $lastPost->update(['images'=>$fileName]);
        // }

        // return redirect()->route('lister.manageListings')->with('listings',$listings);

    }

    public function manageListing($id){
        // if (!$this->checkUserState()) {
        //     return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
        //     Auth::logout();
        // }

        // $user = Auth::user();
        // $utype = $user->user_type;
        // $API_KEY = config('constants.API_KEY.maps');

        // if ($utype==4) {
        //     $listingDetails = Listing::where('id',$id)->first();
        //     if ($listingDetails->user_id == $user->id) {
        //         $listing = $user->listings()->find($id);
        //         $images = ListingFile::where('listing_id',$id)->where('category','regular')->get();
        //         // $listing = Listing::where('id',$id)->first();
        //         return view('listings.manage_listing')->with('listing',$listing)->with('API_KEY',$API_KEY)->with('images',$images);
        //     } else {
        //         $listings = Listing::where('user_id',$user->id)->orderBy('created_at','id')->get();
        //         return redirect()->route('lister.manageListings')->with('listings',$listings);
        //     }
        // }
        // else {
        //     $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
        //     return redirect()->route('listings.list')->with('listings',$listings);
        // }
    }

    public function updateListing(Request $request,$id){
        // $API_KEY = config('constants.API_KEY.maps');
    	// $this->validate($request,[
    	// 	'property_name'=>'required|max:50',
        //     'description'=>'required|max:10000',
        //     'location'=>'required|max:50',
        //     'lat'=>'required',
        //     'lng'=>'required',
        //     'available_units'=>'required', 
        //     'units_sum'=>'required',
        //     'unit_area'=>'required',
        //     'cost'=>'required',
        //     'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    	// 	]);

        // if (!$this->checkUserState()) {
        //     return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
        //     Auth::logout();
        // }

        // $formData = $request->all();
        // $user = Auth::user();
        
        // $listings = Listing::where('user_id',$user->id)->orderBy('created_at','id')->get();
    	
        // $utype = Auth::user()->user_type;
        // if ($utype==4) {
        //     $user = Auth::user();
        //     $listing = $user->listings()->find($id);
        //     $listing->update($request->all());

        //     if ($request->hasFile('post_images')) {
        //         $images = $request->file('post_images');

        //         if (!File::exists('images/listings/'.$user->id.'/')) {
        //             File::makeDirectory('images/listings/'.$user->id.'/',0777,true);
        //         }
        //         if (!File::exists('images/listings/'.$user->id.'/thumbnails/')) {
        //             File::makeDirectory('images/listings/'.$user->id.'/thumbnails/',0777,true);
        //         }
        //         foreach ($images as $image) {
        //             $fileName = $user->id.'_'.time().'_'.rand(1111,9999).'.'.$image->getClientOriginalExtension();
        //             $location = public_path('images/listings/'.$user->id.'/'.$fileName);
        //             $img = new ListingFile;
        //             $img->listing_id = Listing::where('user_id',$user->id)->orderBy('created_at','id')->first()->id;
        //             $img->file_name = $fileName;
        //             $img->file_type = 'image';
        //             $img->category = 'regular';
        //             if (!$img->save()) {
        //                 return false;
        //             }
        //             Image::make($image)->resize(640,480, function($constraint){
        //                 $constraint->aspectRatio();
        //             })->save($location); 
        //             $img->save();
        //         }
        //         $fileName = $user->id.'_'.time().'_'.$request->property_name.'_thumb.'.$image->getClientOriginalExtension();
        //         $thumbLocation = public_path('images/listings/'.$user->id.'/thumbnails/'.$fileName);
        //         $thumb = new ListingFile;
        //         $thumb->listing_id = $img->listing_id;
        //         $thumb->file_name = $fileName.'_thumb';
        //         $thumb->file_type = 'image';
        //         $thumb->category = 'thumbnail';
        //         if (!$thumb->save()) {
        //             return false;
        //         }
        //         Image::make($images[0])->resize(350,250, function($constraint){
        //             $constraint->aspectRatio();
        //         })->save($thumbLocation); 
        //         $thumb->save();
        //         $lastPost = Listing::where('id',$id)->first();
        //         $lastPost->update(['images'=>$fileName]);
        //     }

        //     // $listing = Listing::where('id',$id)->first();
        //     $images = ListingFile::where('listing_id',$id)->where('category','regular')->get();
            

        //     return view('listings.manage_listing')->with('listing',$listing)->with('API_KEY',$API_KEY)->with('images',$images);
        // } else {
        //     return redirect()->route('listings.list');
        // }
    }

    public function removeListing($id){
        // if (!$this->checkUserState()) {
        //     return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
        //     Auth::logout();
        // }

        // $user = Auth::user();
        // // $listing = Listing::where('id',$id)->first();
        // $listing = $user->listings()->find($id);
        // $listing->delete();
        // $listings = Listing::where('user_id',$user->id)->orderBy('created_at','id')->get();

        // return redirect()->route('lister.manageListings')->with('listings',$listings);
    }

    public function deleteImage($listing,$image){
        // if (!$this->checkUserState()) {
        //     return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
        //     Auth::logout();
        // }

        // $user = Auth::user();
        // $lister = Listing::where('id',$listing)->first();
        
        // if ($user->id==$lister->user_id) {
        //     $imagePost = ListingFile::where('id',$image)->first();
        //     $imagePost->delete();
        // }
        // return redirect()->back();
    }

    public function listingReviews($id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

    	$user = Auth::user();
    	$reviews = Review::where('listing_entry_id',$id)->orderBy('updated_at','id')->get();
        $propertyDetails = Listing::where('id',$id)->first();

        if ($user->user_type==4) {
        	if ($propertyDetails->user_id == $user->id) {
	        	return view('listers.listing_reviews')->with(compact('reviews','propertyDetails'));
	        } else {
	        	$listings = Listing::where('lister_id',$user->id)->orderBy('created_at','id')->get();
        		return redirect()->route('lister.manageListings')->with('listings',$listings);
	        }
        } else {
        	$listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function myApplications(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }
        
    	$user = Auth::user();
    	$userType = $user->user_type;

    	$listings = Listing::where('lister_id',$user->id)->where('status','pending')->orderBy('created_at','id')->get();
    	if ($userType == 4) {
    		return view('listers.my_applications',compact('listings'));
    	} else {
    		return redirect()->route('listings.list');
    	}
    }

}
