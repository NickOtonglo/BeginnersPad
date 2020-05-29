<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\ListingApplication;
use App\Review;
use App\ListingAdminLog;
use App\AdminBookmark;
use App\User;
use App\UserManagementLog;
use App\HelpTicket;
use App\HelpTicketLog;
use App\ListingEntry;
use Illuminate\Support\Facades\Auth;
use App\ListingFile;
use App\ReviewModerationLog;
use App\ListingReport;
use App\ListingStatus;
use App\UserReport;
use App\Zone;
use App\ZoneEntry;
use App\FAQ;
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
        $subZones = ZoneEntry::orderBy('name');
        $subZonesList = ZoneEntry::orderBy('name')->get();
    	if ($userType == 4) {
    	    return view('listers.manage_listings',compact('listings','API_KEY','subZones','subZonesList'));
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
        $subZonesList = ZoneEntry::orderBy('name')->get();
        if ($utype==4){
            return view('listers.new_listing',compact('subZonesList','API_KEY'));
        }
        else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function storeListing(Request $request){

    	$this->validate($request,[
    		'property_name'=>'required|max:50',
    		'description'=>'required|max:5000',
    		'zone_entry_id'=>'required',
    		'lat'=>'required',
    		'lng'=>'required',
    		'listing_type'=>'required', 
    		'stories'=>'required',
            'thumbnail.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    		]);

        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $postId = Listing::orderBy('id','desc')->first()->id;
        if($postId==null){
            $postId = 1;
        } else {
            $postId = ($postId)+1;
        }

        if ($user->user_type == 4){
            if ($request->hasFile('thumbnail')) {
                $image = $request->file('thumbnail');
                $propertyName = str_replace(' ', '_', $request->property_name);

                if (!File::exists('images/listings/' . $postId . '/thumbnails/')) {
                    File::makeDirectory('images/listings/' . $postId . '/thumbnails/', 0777, true);
                }

                $fileName = $postId . '_' . time() . '_' . $propertyName . '_thumb.' . $image->getClientOriginalExtension();
                $thumbLocation = public_path('images/listings/' . $postId . '/thumbnails/' . $fileName);
                Image::make($image)->resize(640, 480, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbLocation);
                $postData = array_merge($request->all(), ['lister_id' => Auth::user()->id], ['thumbnail' => $fileName], ['status' => 'unpublished']);
                Listing::create($postData);
            }
            return redirect()->back()->with('message', 'Listing property added');
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function addListingEntry($id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $utype = Auth::user()->user_type;
        $API_KEY = config('constants.API_KEY.maps');
        $listing = Listing::where('id',$id)->first();
        if ($utype==4){
            return view('listers.new_listing_entry',compact('listing','API_KEY'));
        }
        else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    // public function createListingEntry(Request $request,$id){
    //     $this->validate($request,[
    // 		'listing_name'=>'required|max:50',
    // 		'description'=>'max:5000',
    // 		'floor_area'=>'required',
    //         'price'=>'required',
    //         'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    // 		]);

    //     if (!$this->checkUserState()) {
    //         return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
    //         Auth::logout();
    //     }

    //     return $request->all();

    // }

    public function createListingEntry(Request $request,$id){
    	$this->validate($request,[
    		'listing_name'=>'required|max:50',
    		'description'=>'max:5000',
    		'floor_area'=>'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480'
    		]);

        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $parent = Listing::where('id',$id)->first();
        $parentId = $parent->id;

        $postId = ListingEntry::orderBy('id','desc')->first();
        if($postId==null){
            $postId = 1;
        } else {
            $postId = ($postId->id)+1;
        }

        $postData = array_merge($request->all(),['parent_id'=>$parentId],['description'=>$request->entry_description],['status'=>'active']);
        if($request->initial_deposit == null){
            $postData = array_merge($postData,['initial_deposit'=>0]);
        }
        if($request->initial_deposit_period == null){
            $postData = array_merge($postData,['initial_deposit_period'=>0]);
        }

        if($request->entry_price == null){
            $postData = array_merge($postData,['price'=>$parent->price]);
        } else {
            $postData = array_merge($postData,['price'=>$request->entry_price]);
        }

        $listingType = 'single';
        $entryCount = ListingEntry::where('parent_id',$parentId)->count();
        if($entryCount>0){
            $listingType = 'multi';
        }

        if($user->user_type==4 && $parent->lister_id==$user->id){
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $entryName = str_replace(' ', '_', $request->listing_name);

                if (!File::exists('images/listings/'.$parentId.'/')) {
                    File::makeDirectory('images/listings/'.$parentId.'/',0777,true);
                }

                foreach ($images as $image) {
                    $fileName = $parentId.'_'.time().'_'.rand(1111,9999).'.'.$image->getClientOriginalExtension();
                    //images/listings/$parent_id
                    $location = public_path('images/listings/'.$parentId.'/'.$fileName);
                    $img = new ListingFile;
                    $img->listing_entry_id = $postId;
                    $img->file_name = $fileName;
                    $img->file_type = 'image';
                    $img->category = 'regular';
                    if (!$img->save()) {
                        return "unable to save images";
                        // return false;
                    }
                    Image::make($image)->resize(1280,720, function($constraint){
                        $constraint->aspectRatio();
                    })->save($location); 
                    $img->save();
                }
                $fileName = $parentId.'_'.time().'_'.$entryName.'_thumb.'.$images[0]->getClientOriginalExtension();
                $thumbLocation = public_path('images/listings/'.$parentId.'/thumbnails/'.$fileName);
                $thumb = new ListingFile;
                $thumb->listing_entry_id = $postId;
                $thumb->file_name = $fileName;
                $thumb->file_type = 'image';
                $thumb->category = 'thumbnail';
                if (!$thumb->save()) {
                    return "unable to save thumbnail";
                    // return false;
                }
                Image::make($images[0])->resize(640,480, function($constraint){
                    $constraint->aspectRatio();
                })->save($thumbLocation); 
                $thumb->save();
                ListingEntry::create($postData);
                $parent->update(['listing_type'=>$listingType]);
            } else {
                return "no images";
            }

            return redirect()->back()->with('message', 'Listing added to '.$parent->property_name);
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }

        return $postId;

    }

    public function manageListing($id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;
        $API_KEY = config('constants.API_KEY.maps');
        $subZonesList = ZoneEntry::orderBy('name')->get();
        $entries = ListingEntry::where('parent_id',$id)->get();

        if ($utype==4) {
            $listing = Listing::where('id',$id)->first();
            if ($listing->lister_id == $user->id) {
                return view('listers.manage_listing')->with('listing',$listing)->with('API_KEY',$API_KEY)->with('subZonesList',$subZonesList)->with('entries',$entries);
            } else {
                $listings = Listing::where('lister_id',$user->id)->orderBy('created_at','id')->get();
                return redirect()->route('lister.manageListings')->with('listings',$listings);
            }
        }
        else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function updateListing(Request $request,$id){
        $this->validate($request,[
    		'property_name'=>'required|max:50',
    		'description'=>'required|max:5000',
    		'zone_entry_id'=>'required',
    		'lat'=>'required',
    		'lng'=>'required',
    		'listing_type'=>'required', 
    		'stories'=>'required',
            'thumbnail.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    		]);

        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $post = Listing::where('id',$id)->first();
        $postId = $post->id;

        if($user->user_type==4 && Listing::where('id',$id)->first()->lister_id==$user->id){
            $postData = array_merge($request->all(),['lister_id'=>Auth::user()->id],['status'=>'unpublished']);

            if ($request->hasFile('thumbnail')) {
                $images = $request->file('thumbnail');
                $entryName = str_replace(' ', '_', $request->listing_name);

                if (!File::exists('images/listings/'.$postId.'/')) {
                    File::makeDirectory('images/listings/'.$postId.'/',0777,true);
                }

                $fileName = $postId.'_'.time().'_'.$entryName.'_thumb.'.$images->getClientOriginalExtension();
                $thumbLocation = public_path('images/listings/'.$postId.'/thumbnails/'.$fileName);
                $thumb = new ListingFile;
                $thumb->listing_entry_id = $postId;
                $thumb->file_name = $fileName;
                $thumb->file_type = 'image';
                $thumb->category = 'thumbnail';
                if (!$thumb->save()) {
                    return "unable to save thumbnail";
                }
                Image::make($images)->resize(1280,720, function($constraint){
                    $constraint->aspectRatio();
                })->save($thumbLocation); 
                $thumb->save();
                $postData = array_merge($postData,['thumbnail'=>$fileName]);
            } else {
                return 'no thumbnail';
                // dd($request->all());
            }
            $post->update($postData);
            return redirect()->back()->with('message','Listing property updated');
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function manageListingEntry($listingId,$entryId){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;
        $entry = ListingEntry::where('id',$entryId)->first();

        if ($utype==4) {
            $listing = Listing::where('id',$listingId)->first();
            if ($listing->lister_id == $user->id) {
                return view('listers.manage_listing_entry')->with('entry',$entry);
            } else {
                $listings = Listing::where('lister_id',$user->id)->orderBy('created_at','id')->get();
                return redirect()->route('lister.manageListings')->with('listings',$listings);
            }
        }
        else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function updateListingEntry(Request $request,$listingId,$entryId){
        // $this->validate($request,[
    	// 	'listing_name'=>'required|max:50',
    	// 	'description'=>'max:5000',
    	// 	'floor_area'=>'required'
        //     ]);
            
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;
        $parent = Listing::where('id',$listingId)->first();
        $post = ListingEntry::where('id',$entryId)->first();

        if($utype == 4 && $parent->lister_id == $user->id){
            switch($request->input('btn_submit')){
                case 'Make Inactive (hide)':
                    $postData = array_merge($request->all(),['status'=>'inactive']);
                    $post->update($postData);
                    return redirect()->back()->with('message','Listing hidden from public view');
                    break;

                case 'Activate':
                    $postData = array_merge($request->all(),['status'=>'active']);
                    $post->update($postData);
                    return redirect()->back()->with('message','Listing made publicly accessible');
                    break;

                case 'Declare Vacant':
                    $postData = array_merge($request->all(),['status'=>'active']);
                    $post->update($postData);
                    return redirect()->back()->with('message','Listing declared vacant and made publicly accessible');
                    break;

                case 'Update Listing':
                    $postData = array_merge($request->all(),['description'=>$request->entry_description]);
                    if($request->initial_deposit == null){
                        $postData = array_merge($postData,['initial_deposit'=>0]);
                    }
                    if($request->initial_deposit_period == null){
                        $postData = array_merge($postData,['initial_deposit_period'=>0]);
                    }

                    if($request->entry_price == null){
                        $postData = array_merge($postData,['price'=>$parent->price]);
                    } else {
                        $postData = array_merge($postData,['price'=>$request->entry_price]);
                    }
                    $post->update($postData);
                    return redirect()->back()->with('message','Listing updated');
                    break;
            }
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function storeListingEntryImage(Request $request,$listingId,$entryId){
        $this->validate($request,[
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480'
    		]);

        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;
        $parent = Listing::where('id',$listingId)->first();
        $post = ListingEntry::where('id',$entryId)->first();
        $parentId = $parent->id;

        $postId = $post->id;

        if($utype == 4 && $parent->lister_id == $user->id){
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                $entryName = str_replace(' ', '_', $request->listing_name);

                if (!File::exists('images/listings/'.$parentId.'/')) {
                    File::makeDirectory('images/listings/'.$parentId.'/',0777,true);
                }

                foreach ($images as $image) {
                    $fileName = $parentId.'_'.time().'_'.rand(1111,9999).'.'.$image->getClientOriginalExtension();
                    //images/listings/$parent_id
                    $location = public_path('images/listings/'.$parentId.'/'.$fileName);
                    $img = new ListingFile;
                    $img->listing_entry_id = $postId;
                    $img->file_name = $fileName;
                    $img->file_type = 'image';
                    $img->category = 'regular';
                    if (!$img->save()) {
                        return "unable to save images";
                        // return false;
                    }
                    Image::make($image)->resize(1280,720, function($constraint){
                        $constraint->aspectRatio();
                    })->save($location); 
                    $img->save();
                }
            } else {
                return "no images";
            }
            return redirect()->back()->with('message','Image(s) added to listing');
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function storeListingEntryThumb(Request $request,$listingId,$entryId){
        $this->validate($request,[
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:20480'
    		]);

        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;
        $parent = Listing::where('id',$listingId)->first();
        $post = ListingEntry::where('id',$entryId)->first();
        $parentId = $parent->id;

        $postId = $post->id;

        if($utype == 4 && $parent->lister_id == $user->id){
            if ($request->hasFile('thumb')) {
                $images = $request->file('thumb');
                $entryName = str_replace(' ', '_', $request->listing_name);

                if (!File::exists('images/listings/'.$parentId.'/')) {
                    File::makeDirectory('images/listings/'.$parentId.'/',0777,true);
                }

                $fileName = $parentId.'_'.time().'_'.$entryName.'_thumb.'.$images->getClientOriginalExtension();
                $thumbLocation = public_path('images/listings/'.$parentId.'/thumbnails/'.$fileName);
                $thumb = new ListingFile;
                $thumb->listing_entry_id = $postId;
                $thumb->file_name = $fileName;
                $thumb->file_type = 'image';
                $thumb->category = 'thumbnail';
                if (!$thumb->save()) {
                    return "unable to save thumbnail";
                }
                Image::make($images)->resize(640,480, function($constraint){
                    $constraint->aspectRatio();
                })->save($thumbLocation); 
                $thumb->save();
            } else {
                return "no image";
            }
            return redirect()->back()->with('message','Thumbnail set');
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function deleteListingEntryImage(Request $request,$listingId,$entryId,$imageId){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;
        $parent = Listing::where('id',$listingId)->first();
        $post = ListingEntry::where('id',$entryId)->first();

        if($utype == 4 && $parent->lister_id == $user->id){
            switch($request->input('btn_submit')){
                case 'Delete Listing':
                    
                    break;

                case 'Remove':
                    $image = ListingFile::where('id',$imageId)->first();
                    $image->delete();
                    return redirect()->back()->with('message','Image removed from listing');
                    break;
            }
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
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
        	if ($propertyDetails->lister_id == $user->id) {
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
