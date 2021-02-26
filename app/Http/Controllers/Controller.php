<?php

namespace App\Http\Controllers;

use App\Listing;
use App\ListingApplication;
use App\Customer;
use App\Review;
use App\ListingAdminLog;
use App\AdminBookmark;
use App\User;
use App\UserManagementLog;
use App\ListingFile;
use App\ReviewModerationLog;
use App\HelpTicket;
use App\FAQ;
use App\ListingStatus;
use App\HelpCategory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkUserState(){
        if (Auth::check() && Auth::user()->status == 'suspended') {
            return false;
        } else return true;
    }

    public function setup(){
        return view('setup');
    }

    public function index(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        // return view('listings.index');
        $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();

        return view('layouts.index',compact('listings'));
    }

    public function main(){
    	if (!Auth::guest()) {
    		if (Auth::user()->status=='active') {
	    		$listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
                return view('welcome',compact('listings'));
	    	} elseif (Auth::user()->status=='inactive') {
	    		Auth::logout();
	            return redirect('/login')->withErrors(['msg'=>'Sorry, your account is pending activation by the system administrator.']);
	    	} elseif (Auth::user()->status=='suspended') {
	    		Auth::logout();
	            return redirect('/login')->withErrors(['msg'=>'Sorry, your account has been suspended. Contact a representative or administrator for assistance.']);
	    	}
    	} elseif (Auth::guest()) {

    		$listings = Listing::where('status','approved')->orderBy('created_at','id')->get();

            return view('welcome',compact('listings'));
    	}
    }

    public function view($id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }
        $API_KEY = config('constants.API_KEY.maps');
        $listing = Listing::where('id',$id)->find($id);
        $reviews = Review::where('property_id',$id)->orderBy('updated_at','id')->get();
        $images = ListingFile::where('listing_id',$id)->where('category','regular')->get();
        $mean = Review::where('property_id',$id)->avg('review_rating');
        $rating = round($mean, 1)*(100/5);
        $lister = User::where('id',$listing->user_id)->first();
        $listingsList = Listing::where('status','approved')->where('location',$listing->location)->orderBy('created_at','id')->take(4)->get();
        $favourite = Customer::where('property_id',$listing->id)->first();
        if ($listing->status == "suspended") {
            return "This listing is not available.";
        } else {
            if (Auth::guest()) {
                return view('listings.view_listing')->with(compact('reviews','listing','images','mean','rating','API_KEY','lister','listingsList','favourite'));
            } else {
            $user = Auth::user();
            $application = ListingApplication::where('property_id',$listing->id)->where('customer_id',$user->id)->where('status','active')->orderBy('created_at','id')->first();
            $appl = ListingApplication::first()->listing();
            return view('listings.view_listing')->with(compact('reviews','listing','images','mean','rating','API_KEY','lister','listingsList','favourite','appl'));
            }
        }
    }

    public function viewReviews($id){
        // if (!$this->checkUserState()) {
        //     return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
        //     Auth::logout();
        // }

        // $reviews = Review::where('property_id',$id)->orderBy('updated_at','id')->get();
        // $propertyDetails = Listing::where('id',$id)->first();

        // return view('listings.view_reviews')->with(compact('reviews','propertyDetails'));
    }

    public function manageAccount(){
        $user = Auth::user();
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $users = $user;
        $id = $user->id;
        $targetUser = $users;

        $customerApplications = ListingApplication::where('action_by_user',$id)->where('action','occupied')->get();
        $customerReviews = Review::where('user_id',$id)->get();
        $customerLastApplication = ListingApplication::where('action_by_user',$id)->where('action','occupied')->first();
        $customerLastReview = Review::where('user_id',$id)->first();
        $customerSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

        $listerListings = Listing::where('lister_id',$id)->get();
        $listerCustomers = ListingApplication::where('action_by_user',$id)->where('action','occupied')->get();
        $listerPendingApplications = Listing::where('lister_id',$id)->where('status','pending')->get();
        $listerSuspendedListings = Listing::where('lister_id',$id)->where('status','suspended')->get();
        $listerRejectedApplications = Listing::where('lister_id',$id)->where('status','rejected')->get();
        $listerSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();
        // $listerLastApplication = Listing::where('user_id',$id)->where('status','pending')->first();
        $listerLastApplication = Listing::where('lister_id',$id)->where('status','approved')->latest()->first();

        $repUsersSuspended = UserManagementLog::where('admin_id',$id)->where('status','suspended')->get();
        $repListingsApproved = ListingAdminLog::where('admin_id',$id)->where('action','approved')->get();
        $repListingsRejected = ListingAdminLog::where('admin_id',$id)->where('action','rejected')->get();
        $repListingsSuspended = ListingAdminLog::where('admin_id',$id)->where('action','suspended')->get();
        $repListingsDeleted = ListingAdminLog::where('admin_id',$id)->where('action','deleted')->get();
        $repSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

        $adminUsersSuspended = UserManagementLog::where('admin_id',$id)->where('status','suspended')->get();
        $adminListingsApproved = ListingAdminLog::where('admin_id',$id)->where('action','approved')->get();
        $adminListingsRejected = ListingAdminLog::where('admin_id',$id)->where('action','rejected')->get();
        $adminListingsSuspended = ListingAdminLog::where('admin_id',$id)->where('action','suspended')->get();
        $adminListingsDeleted = ListingAdminLog::where('admin_id',$id)->where('action','deleted')->get();
        $adminUsersCreated = UserManagementLog::where('admin_id',$id)->where('status','inactive')->get();
        $adminSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

        if ($targetUser->user_type==5) {
            return view('layouts.account', compact('users','targetUser','customerApplications','customerReviews','customerLastApplication',
                'customerLastReview','customerSuspendedCount'));
        } else if ($targetUser->user_type==4) {
            return view('layouts.account', compact('users','targetUser','listerListings','listerCustomers','listerPendingApplications',
                'listerSuspendedListings','listerRejectedApplications','listerSuspendedCount','listerLastApplication'));
        } else if ($targetUser->user_type==3) {
            return view('layouts.account', compact('users','targetUser','repUsersSuspended','repListingsApproved','repListingsRejected',
                'repListingsSuspended','repListingsDeleted','repSuspendedCount'));
        } else if ($targetUser->user_type==2 || $targetUser->user_type==1) {
            return view('layouts.account', compact('users','targetUser','adminUsersSuspended','adminListingsApproved','adminListingsRejected',
                'adminListingsSuspended','adminListingsDeleted','adminUsersCreated','adminSuspendedCount'));
        }
    }

    public function updateDetails(Request $request){

        $user = Auth::user();
        switch ($request->input('btn_submit')) {

            case 'Update':

                $this->validate($request,[
                    'name' => 'required|string|max:255',
                    // 'email' => 'required|string|email|max:255|unique:users',
                    'telephone' => 'required|string|size:12',
                ]);

                // User::where('id',$user->id)->update(['name'=>$request->name,'telephone'=>$request->telephone]);
                $user->name = $request->name;
                $user->telephone = $request->telephone;
                $user->save();
                return back()->with('message','Account info updated');
                
                break;

            case 'Change Password':

                $this->validate($request,[
                    // 'email' => 'required|string|email|max:255|unique:users',
                    'current_password' => 'required',
                    'password' => 'required|string|min:6|confirmed|',
                    // 'password' => 'required|string|min:6|confirmed|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'required',
                ]);

                if (Hash::check($request->current_password, $user->password)) {
                    if ($request->password==$request->password_confirmation) {
                        $user->password = bcrypt($request->password);
                        $user->save();
                        return back()->with('message','Password changed');
                    }
                } else {
                    return 'Wrong password!';
                }
                
                break;

            case 'Update Avatar':
                
                $this->validate($request,[
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                if ($request->hasFile('post_avatar')) {
                    $image = $request->file('post_avatar');

                    if (!File::exists('images/avatar/'.$user->id.'/')) {
                        File::makeDirectory('images/avatar/'.$user->id.'/',0777,true);
                    }
                    $fileName = $user->id.'_'.time().'_'.rand(1111,9999).'.'.$image->getClientOriginalExtension();
                    $location = public_path('images/avatar/'.$user->id.'/'.$fileName);
                    $user->avatar = $fileName;
                    if (!$user->save()) {
                        return false;
                    }
                    Image::make($image)->resize(350,250, function($constraint){
                        $constraint->aspectRatio();
                    })->save($location); 
                    $user->save();
                    return back();
                } else {
                    return 'An error occured! Please try again.';
                }

                break;
        }
    }

    public function help(){
        $faqs = FAQ::all();
        $helpCats = HelpCategory::all();
        if (!Auth::user()==null) {
            $user_type = Auth::user()->user_type;
            if ($user_type == 3 || $user_type == 2 || $user_type == 1) {
                return $this->adminHelp();
            } else {
                return view('layouts.help',compact('faqs','helpCats'));
            }
        }
        else if (Auth::user()==null) {
            return view('layouts.help',compact('faqs','helpCats'));
        }
    }

    public function adminHelp(){
        $tickets = HelpTicket::orderBy('created_at','DESC')->get();
        $users = User::all();
        return view('administrators.all_tickets',compact('tickets','users'));
    }

    public function createTicket(Request $request){
        $user = Auth::user();

        switch ($user) {
            case null:
                    $this->validate($request,[
                    'category' => 'required|string',
                    'email' => 'required|string',
                    'description' => 'required|string',
                ]);
                break;
            
            case !null:
                $this->validate($request,[
                    'category' => 'required|string',
                    'description' => 'required|string',
                ]);
                break;
        }
        
        //https://stackoverflow.com/questions/1935918/php-substring-extraction-get-the-string-before-the-first-or-the-whole-strin
        // $mystring = 'home/cat1/subcat2/';
        // $first = strtok($mystring, '/');
        // echo $first; // home

        $ticket = new HelpTicket;
        $ticket->topic = $request->input('category');
        $ticket->description = $request->input('description');
        $ticket->status = 'open';
        if ($user==null) {
            $ticket->email = $request->input('email');
            $ticket->is_registered = 'false';
        } else if (!$user==null) {
            $ticket->email = $user->email;
            $ticket->is_registered = 'true';
            $ticket->user_id = $user->id;
        }
        $ticket->save();
        return redirect()->back()->with('message','Your ticket has been issued. A representative will get in touch with you shortly. Please be patient.');
    }

    public function viewTicketHistory(){
        if (Auth::user()!=null) {
            $user = Auth::user();
            $tickets = HelpTicket::where('email',$user->email)->orderBy('created_at','id')->get();
            return view('layouts.ticket_history',compact('tickets'));
        }
    }

    public function viewTicket($id,Request $request){
        $userType = Auth::user()->user_type;
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 4 || $userType == 5) {
            $ticket = HelpTicket::where('id',$id)->first();
            $user = User::where('email',$ticket->email)->first();
            $admin = User::where('id',$ticket->assigned_to)->first();
            $reps = User::where('user_type',3)->get();
            return view('layouts.view_ticket',compact('ticket','user','admin','reps'));
        } else {

        }
    }

    public function viewTicketCategory($category){
        $user = Auth::user();
        switch ($category) {
            case 'all':
                $tickets = HelpTicket::where('email',$user->email)->orderBy('created_at','id')->get();
                return view('layouts.ticket_history',compact('tickets'));
                break;

            case 'pending':
                $tickets = HelpTicket::where('email',$user->email)->where('status','pending')->orderBy('created_at','id')->get();
                return view('layouts.ticket_history',compact('tickets'));
                break;

            case 'resolved':
                $tickets = HelpTicket::where('email',$user->email)->where('status','resolved')->orderBy('created_at','id')->get();
                return view('layouts.ticket_history',compact('tickets'));
                break;

            case 'open':
                $tickets = HelpTicket::where('email',$user->email)->where('status','open')->orderBy('created_at','id')->get();
                return view('layouts.ticket_history',compact('tickets'));
                break;

            case 'closed':
                $tickets = HelpTicket::where('email',$user->email)->where('status','closed')->orderBy('created_at','id')->get();
                return view('layouts.ticket_history',compact('tickets'));
                break;
            
            default:
                $tickets = HelpTicket::where('email',$user->email)->orderBy('created_at','id')->get();
                return view('layouts.ticket_history',compact('tickets'));
                break;
        }
    }
}
