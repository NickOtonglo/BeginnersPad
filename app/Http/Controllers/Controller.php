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
use App\Topic;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Image;
use File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('checkUserStatus')->except('logout');
    }

    public function msgRepo($intent){
        //error_incorrect_password
        //error_error_occured
        if ($intent=='error_incorrect_password'){
            return 'The password you entered is incorrect. Please try again.';
        }
        if ($intent=='error_error_occured'){
            return 'An error occured. Please try again.';
        }
    }

    //Not in use anymore
    public function checkUserState(){
        if (Auth::check() && Auth::user()->status == 'suspended') {
            return false;
        } else return true;
    }

    public function setup(){
        return view('setup');
    }

    public function index(){
        // return view('listings.index');
        $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();

        return view('layouts.index',compact('listings'));
    }

    public function main(){
    	if (!Auth::guest()) {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return view('welcome',compact('listings'));
    	} elseif (Auth::guest()) {

    		$listings = Listing::where('status','approved')->orderBy('created_at','id')->get();

            return view('welcome',compact('listings'));
    	}
    }

    public function view($id){
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
        $users = $user;
        $id = $user->id;
        $targetUser = $users;
        $tickets = HelpTicket::where('email',$targetUser->email)->get();

        if ($targetUser->user_type == 5){
            $customerOccupations = ListingApplication::where('action','occupied')->where('action_by_user',$id)->get();
            $customerReviews = Review::where('user_id',$id)->get();
            $customerLastOccupation = ListingApplication::where('action','occupied')->where('action_by_user',$id)->first();
            $customerLastReview = Review::where('user_id',$id)->first();
            $customerSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

            return view('layouts.account',compact('targetUser','customerOccupations','customerReviews','customerLastOccupation',
                'customerLastReview','customerSuspendedCount','tickets'));
        } else if ($targetUser->user_type == 4){
            $listerListings = Listing::where('lister_id',$id)->where('status','!=','unpublished')->get();
            $listerCustomers = ListingApplication::where('action_by_user',$id)->get();
            $listerPendingApplications = Listing::where('lister_id',$id)->where('status','pending')->get();
            $listerSuspendedListings = Listing::where('lister_id',$id)->where('status','suspended')->get();
            $listerRejectedApplications = Listing::where('lister_id',$id)->where('status','rejected')->get();
            $listerSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();
            $listerLastSubmission = Listing::where('lister_id',$id)->where('status','pending')->latest()->first();

            return view('layouts.account',compact('targetUser','listerListings','listerCustomers','listerPendingApplications',
                'listerSuspendedListings','listerRejectedApplications','listerSuspendedCount','listerLastSubmission','tickets'));
        } else if ($targetUser->user_type == 3){
            $repUsersSuspended = UserManagementLog::where('admin_id',$id)->where('status','suspended')->get();
            $repListingsApproved = ListingAdminLog::where('admin_id',$id)->where('action','approved')->get();
            $repListingsRejected = ListingAdminLog::where('admin_id',$id)->where('action','rejected')->get();
            $repListingsSuspended = ListingAdminLog::where('admin_id',$id)->where('action','suspended')->get();
            $repListingsDeleted = ListingAdminLog::where('admin_id',$id)->where('action','deleted')->get();
            $repSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

            return view('layouts.account',compact('targetUser','repUsersSuspended','repListingsApproved','repListingsRejected',
                'repListingsSuspended','repListingsDeleted','repSuspendedCount'));
        } else if ($targetUser->user_type == 2 || $targetUser->user_type == 1){
            $adminUsersSuspended = UserManagementLog::where('admin_id',$id)->where('status','suspended')->get();
            $adminListingsApproved = ListingAdminLog::where('admin_id',$id)->where('action','approved')->get();
            $adminListingsRejected = ListingAdminLog::where('admin_id',$id)->where('action','rejected')->get();
            $adminListingsSuspended = ListingAdminLog::where('admin_id',$id)->where('action','suspended')->get();
            $adminListingsDeleted = ListingAdminLog::where('admin_id',$id)->where('action','deleted')->get();
            $adminUsersCreated = UserManagementLog::where('admin_id',$id)->where('status','inactive')->get();
            $adminSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

            return view('layouts.account',compact('targetUser','adminUsersSuspended','adminListingsApproved','adminListingsRejected',
                'adminListingsSuspended','adminListingsDeleted','adminUsersCreated','adminSuspendedCount'));
        }
    }

    public function updateDetails(Request $request){
        $user = Auth::user();
        switch ($request->input('btn_submit')) {

            case 'Update':

                $this->validate($request,[
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255',Rule::unique('users')->ignore($user->id),
                    'telephone' => 'required|string|min:10|max:13',
                    //'username' => 'required|string|email|max:255|unique:users',
                ]);

                // User::where('id',$user->id)->update(['name'=>$request->name,'telephone'=>$request->telephone]);
                $input = User::find($user->id);
                $input->update(['name'=>$request->name,'telephone'=>$request->telephone,'email'=>$request->email]);
                // $user->name = $request->name;
                // $user->telephone = $request->telephone;
                // $user->email = $request->email;
                // $user->save();
                return back()->with('message','Account info updated');
                
                break;

            case 'Change Password':

                $this->validate($request,[
                    // 'email' => 'required|string|email|max:255|unique:users',
                    'password_current' => 'required',
                    'password' => 'required|string|min:6|confirmed|',
                    // 'password' => 'required|string|min:6|confirmed|required_with:password_confirmation|same:password_confirmation',
                    'password_confirmation' => 'required',
                ]);

                if (Hash::check($request->password_current, $user->password)) {
                    if ($request->password==$request->password_confirmation) {
                        // $user->password = bcrypt($request->password);
                        // $user->save();
                        $input = User::find($user->id);
                        $input->update(['password'=>bcrypt($request->password)]);
                        return back()->with('message','Password changed');
                    }
                } else {
                    return back()->withErrors([$this->msgRepo('error_incorrect_password')]);
                }
                
                break;

            case 'X':
                //check if user profile dir exists
                if (File::exists('images/avatar/'.$user->id.'/')) {
                    $fileName = $user->avatar;
                    $location = public_path('images/avatar/'.$user->id.'/'.$fileName);
                    unlink($location);
                    $input = User::find($user->id);
                    $input->update(['avatar'=>null]);

                    return back()->with('message','Avatar removed');
                } else {
                    return back()->withErrors([$this->msgRepo('error_error_occured')]);
                }

                break;

            default:
                
                $this->validate($request,[
                    'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                if ($request->hasFile('btn_submit')) {
                    $image = $request->file('btn_submit');

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
                    return back()->with('message','Avatar updated');
                } else {
                    return back()->withErrors([$this->msgRepo('error_error_occured')]);
                }

                break;
        }
    }

    public function help(){
        $faqs = FAQ::paginate(3);
        $helpCats = HelpCategory::all();
        $topics = Topic::where('category','help')->paginate(3);
        if (!Auth::user()==null) {
            $user_type = Auth::user()->user_type;
            if ($user_type == 3 || $user_type == 2 || $user_type == 1) {
                return $this->adminHelp();
            } else {
                return view('layouts.help',compact('faqs','helpCats','topics'));
            }
        }
        else if (Auth::user()==null) {
            return view('layouts.help',compact('faqs','helpCats','topics'));
        }
    }

    public function adminHelp(){
        $tickets = HelpTicket::orderBy('created_at','DESC')->get();
        $users = User::all();
        return view('administrators.tickets_all',compact('tickets','users'));
    }

    public function helpFAQ(){
        $faqs = FAQ::get();
        return view('layouts.help_faq',compact('faqs'));
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
            if($user->user_type == 4 || $user->user_type == 5){
                $tickets = HelpTicket::where('email',$user->email)->orderBy('created_at','id')->get();
                return view('layouts.ticket_history',compact('tickets'));
            } elseif($user->user_type == 3 || $user->user_type == 2 || $user->user_type == 1) {
                return redirect()->route('help')->with('tickets',HelpTicket::orderBy('created_at','DESC')->get())->with('users',User::all());
            } else {
                $faqs = FAQ::all();
                $helpCats = HelpCategory::all();
                return view('layouts.help',compact('faqs','helpCats'));
            }
            
        }
    }

    public function viewTicket($id,Request $request){
        $userType = Auth::user()->user_type;
        if ($userType == 4 || $userType == 5) {
            $ticket = HelpTicket::where('id',$id)->first();
            
            if ($ticket->user == Auth::user()){
                return view('layouts.view_ticket',compact('ticket'));
            } else {
                return $this->viewTicketCategory('all');
            }
        } else {
            return $this->help();
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
