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
use App\AdminAction;
use App\Tag;
use App\TagEntry;
use App\Topic;
use App\HelpCategory;
use App\HelpCategoryLog;

class AdminController extends Controller
{

    public function msgRepo($intent){
        //permission_denied_not_authorised
        //permission_denied_reason_required
        //error_user_does_not_exist
        //error_not_allowed
        if ($intent=='permission_denied_not_authorised'){
            return 'You are not authorised to perform this action!';
        }
        if ($intent=='permission_denied_reason_required'){
            return 'You must a submit a reason to perform this action!';
        }
        if ($intent=='error_user_does_not_exist'){
            return 'This user does not exist!';
        }
        if ($intent=='error_not_allowed'){
            return 'Not allowed!';
        }
    }

    public function checkUserState(){
        if (Auth::check() && Auth::user()->status == 'suspended') {
            return false;
        } else return true;
    }

    public function manageListings($status){
    	$user = Auth::user();
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

    	$userType = $user->user_type;

        $listings_stats = Listing::where('status','!=','deleted')->where('status','!=','unpublished')->orderBy('created_at','id')->get();
        $allListings = Listing::where('status','!=','deleted')->where('status','!=','unpublished')->orderBy('created_at','id');
        $listings = $allListings->where('status',$status)->get();
        $statusItem = $status;
        $zones = Zone::orderBy('county','ASC','name','ASC')->get();
        $subZones = ZoneEntry::orderBy('parent_id','ASC')->get();
        $listers_list = User::where('user_type','4')->orderBy('id','DESC')->get();
        
    	if ($userType == 3 || $userType == 2 || $userType == 1) {
    		return view('administrators.manage_listings',compact('listings','statusItem','allListings','zones','listings_stats','subZones','listers_list'));
    	} else {
    		return redirect()->route('listings.list');
    	}
    }

    public function manageAllListings(){
        $user = Auth::user();
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

    	$userType = $user->user_type;
        $statusItem = 'all';
        $listings_stats = Listing::where('status','!=','deleted')->where('status','!=','unpublished')->orderBy('created_at','id')->get();
        $allListings = Listing::where('status','!=','deleted')->where('status','!=','unpublished')->orderBy('created_at','id');
        $listings = $allListings->get();
        $zones = Zone::orderBy('county','ASC','name','ASC')->get();
        $subZones = ZoneEntry::orderBy('parent_id','ASC')->get();
        $listers_list = User::where('user_type','4')->orderBy('id','DESC')->get();
        
    	if ($userType == 3 || $userType == 2 || $userType == 1) {
    		return view('administrators.manage_listings',compact('listings','statusItem','allListings','zones','listings_stats','subZones','listers_list'));
    	} else {
    		return redirect()->route('listings.list');
    	}
    }

    public function filterListings($category,$value){
    	$user = Auth::user();
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

    	$userType = $user->user_type;

        $listings_stats = Listing::where('status','!=','deleted')->where('status','!=','unpublished')->orderBy('created_at','id')->get();
        $allListings = Listing::where('status','!=','deleted')->where('status','!=','unpublished')->orderBy('created_at','id');

        if ($category=='zone'){
            $zonesItem = Zone::where('id',$value)->first();
            $subZonesList = ZoneEntry::where('parent_id',$value)->get();
            $listings = $allListings->whereIn('zone_entry_id',$subZonesList->pluck('id'))->get();
            $statusItem = $zonesItem->name;
        } else if ($category=='subzone'){
            $listings = $allListings->where('zone_entry_id',$value)->get();
            $statusItem = ZoneEntry::where('id',$value)->first()->name;
        } else if ($category=='lister'){
            $listings = $allListings->where('lister_id',$value)->get();
            $statusItem = User::where('id',$value)->first()->name;
        }

        $zones = Zone::orderBy('county','ASC','name','ASC')->get();
        $subZones = ZoneEntry::orderBy('parent_id','ASC')->get();
        $listers_list = User::where('user_type','4')->orderBy('id','DESC')->get();
        
    	if ($userType == 3 || $userType == 2 || $userType == 1) {
    		return view('administrators.manage_listings',compact('listings','statusItem','allListings','zones','listings_stats','subZones','listers_list','category','value'));
    	} else {
    		return redirect()->route('listings.list');
    	}
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
        $actions = AdminAction::where('category','listing')->where('admin_level','>=',$utype)->get();
        $bookmark = AdminBookmark::where('listing_id',$id)->where('admin_id',$user->id)->where('listing_entry_id',null)->first();

        if ($utype==3 || $utype==2 || $utype==1) {
            $listing = Listing::where('id',$id)->first();
            if($id != 'logs'){
                return view('administrators.manage_listing')->with('listing',$listing)->with('API_KEY',$API_KEY)->with('subZonesList',$subZonesList)
                ->with('entries',$entries)->with('actions',$actions)->with('bookmark',$bookmark);
            } else {
                return $this->viewListingManagementLogs('');
            } 
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
        $bookmark = AdminBookmark::where('listing_id',$listingId)->where('admin_id',$user->id)->where('listing_entry_id',$entryId)->first();

        if ($utype==3 || $utype==2 || $utype==1) {
            $listing = Listing::where('id',$listingId)->first();
            if($listingId != 'logs'){
                return view('administrators.manage_listing_entry')->with('listing',$listing)->with('entry',$entry)->with('bookmark',$bookmark);
            } else {
                return $this->viewListingManagementLogs('all');
            }
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function performListingAction(Request $request,$id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;
        $listing = Listing::where('id',$id)->first();
        $action = AdminAction::where('action',$request->listing_action)->first();

        $actionLog = new ListingAdminLog();
        $actionLog->parent_id = $id;
        $actionLog->listing_entry_id = null;
        $actionLog->action = $request->listing_action;
        $actionLog->reason = $request->action_reason;
        $actionLog->admin_id = $user->id;

        if ($utype==3 || $utype==2 || $utype==1) {
            if($action->admin_level >= $utype){
                if($request->listing_action == 'suspend' || $request->listing_action == 'reject'){
                    if($request->action_reason == ''){
                        return $this->msgRepo('permission_denied_reason_required');
                    } else {
                        $listing->update(['status'=>$request->listing_action.'ed']);
                        $actionLog->save();
                        return redirect()->back()->with('message', 'Listing '.$request->listing_action.'ed');
                    }
                } else if ($request->listing_action == 'approve' || $request->listing_action == 'delete') {
                    $listing->update(['status'=>$request->listing_action.'d']);
                    $actionLog->save();
                    return redirect()->back()->with('message', 'Listing '.$request->listing_action.'d');
                }
            } else {
                return $this->msgRepo('permission_denied_not_authorised');
            }

            // return redirect()->back()->with('message','Successful');
        } else {
            return redirect()->route('listings.list');
        } 
    }

    public function manageBookmarks(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();

        $utype = $user->user_type;
        if ($utype==3 || $utype==2 || $utype==1) {
            $bookmarks = AdminBookmark::where('admin_id',$user->id)->orderBy('created_at','id')->get();
            return view('administrators.bookmarks',compact('bookmarks'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function addListingBookmark(Request $request,$listingId){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;

        if ($utype==3 || $utype==2 || $utype==1) {
            switch ($request->input('btn_bookmark')) {
                case '- Remove Bookmark':
                    $bookmark = AdminBookmark::where('listing_id',$listingId)->where('admin_id',$user->id)->where('listing_entry_id',null)->first();
                    $bookmark->delete();
                    return redirect()->back()->with('message', 'Bookmark removed');
                    break;
                
                case '+ Add Bookmark':
                    $bookmark = new AdminBookmark();
                    $bookmark->admin_id = $user->id;
                    $bookmark->listing_id = $listingId;
                    $bookmark->listing_entry_id = null;
                    $bookmark->save();
                    return redirect()->back()->with('message', 'Bookmark added');
                    break;
    
                default:
                    return redirect()->back();
                    break;
            }
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function addListingEntryBookmark(Request $request,$listingId,$entryId){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;

        if ($utype==3 || $utype==2 || $utype==1) {
            switch ($request->input('btn_bookmark')) {
                case '- Remove Bookmark':
                    $bookmark = AdminBookmark::where('listing_id',$listingId)->where('admin_id',$user->id)->where('listing_entry_id',$entryId)->first();
                    $bookmark->delete();
                    return redirect()->back()->with('message', 'Bookmark removed');
                    break;
                
                case '+ Add Bookmark':
                    $bookmark = new AdminBookmark();
                    $bookmark->admin_id = $user->id;
                    $bookmark->listing_id = $listingId;
                    $bookmark->listing_entry_id = $entryId;
                    $bookmark->save();
                    return redirect()->back()->with('message', 'Bookmark added');
                    break;
    
                default:
                    return redirect()->back();
                    break;
            }
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function removeBookmark(Request $request,$id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $bookmark = AdminBookmark::where('admin_id',$user->id)->where('id',$id)->first();

        if ($user->user_type==3 || $user->user_type==2 || $user->user_type==1) {
            if ($bookmark->admin_id == $user->id){
                $bookmark->delete();
                return redirect()->back()->with('message', 'Bookmark removed');
            } else {
                return $this->msgRepo('permission_denied_not_authorised');
            }   
        } else {
            $listings = Listing::where('status','approved')->orderBy('created_at','id')->get();
            return redirect()->route('listings.list')->with('listings',$listings);
        }
    }

    public function listUsers(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $customer = 5;
        $lister = 4;
        $representative = 3;
        $superAdmin = 2;

        if ($user->user_type==3) {
            $users = User::whereIn('user_type',[$customer,$lister])->orderBy('created_at','id')->get();
        } elseif ($user->user_type==2) {
            $users = User::whereIn('user_type',[$customer,$lister,$representative])->orderBy('created_at','id')->get();
        } else if ($user->user_type==1){
            $users = User::whereIn('user_type',[$customer,$lister,$representative,$superAdmin])->orderBy('created_at','id')->get();
        }

        if ($user->user_type==3 || $user->user_type==2 || $user->user_type==1) {
            return view('administrators.users_list',compact('users'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    // public function suspendUser($id){
    //     if (!$this->checkUserState()) {
    //         return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
    //         Auth::logout();
    //     }

    //     $user = Auth::user();

    //     $targetUser = User::where('id',$id)->first();
    //     $targetUser->status = "suspended";

    //     $activityLog = new UserManagementLog;
    //     $activityLog->user_id = $targetUser->id;
    //     $activityLog->name = $targetUser->name;
    //     $activityLog->user_type = $targetUser->user_type;
    //     $activityLog->status = $targetUser->status;
    //     $activityLog->admin_id = $user->id;

    //     if ($user->user_type==3 || $user->user_type==2 || $user->user_type==1) {
    //         if($id != $user->id){
    //             $targetUser->save();
    //             $activityLog->save();
    //         }
    //         return redirect()->back();
    //     } else {
    //         return redirect()->route('listings.list');
    //     }
    // }

    // public function activateUser($id){
    //     if (!$this->checkUserState()) {
    //         return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
    //         Auth::logout();
    //     }

    //     $user = Auth::user();

    //     $targetUser = User::where('id',$id)->first();
    //     $targetUser->status = "active";

    //     $activityLog = new UserManagementLog;
    //     $activityLog->user_id = $targetUser->id;
    //     $activityLog->name = $targetUser->name;
    //     $activityLog->user_type = $targetUser->user_type;
    //     $activityLog->status = $targetUser->status;
    //     $activityLog->admin_id = $user->id;

    //     if ($user->user_type==3 || $user->user_type==2 || $user->user_type==1) {
    //         if($id != $user->id){
    //             $targetUser->save();
    //             $activityLog->save();
    //         }
    //         return redirect()->back();
    //     } else {
    //         return redirect()->route('listings.list');
    //     }
    // }

    public function performUserAction($id,$action){
        if ($id != 'logs' && ($action != '' || $action != 'all')){
            if (!$this->checkUserState()) {
                return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
                Auth::logout();
            }

            $user = Auth::user();

            $targetUser = User::where('id',$id)->first();

            if ($action == "activate"){
                $targetUser->status = "active";
            } else if ($action == "suspend"){
                $targetUser->status = "suspended";
            } else if ($action == "kick"){
                $targetUser->status = "deleted";
            }
            
            $activityLog = new UserManagementLog;
            $activityLog->user_id = $targetUser->id;
            $activityLog->name = $targetUser->name;
            $activityLog->user_type = $targetUser->user_type;
            $activityLog->status = $targetUser->status;
            $activityLog->admin_id = $user->id;

            if ($user->user_type==3 || $user->user_type==2 || $user->user_type==1) {
                if($id != $user->id){
                    if($action == "activate" || $action == "suspend"){
                        $targetUser->save();
                    } else if($action == "kick"){
                        if($user->user_type==1){
                            $targetUser->delete();
                        }
                    }
                    $activityLog->save();
                }
                return redirect()->back()->with('message', '"'.$targetUser->name.'" '.$targetUser->status);
            } else {
                return redirect()->route('listings.list');
            }
        } else {
            return $this->viewUserManagementLogs($action);
        }
    }

    // public function viewUser($id){
    //     if ($id != 'logs'){
    //         if (!$this->checkUserState()) {
    //             return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
    //             Auth::logout();
    //         }

    //         $user = Auth::user();

    //         $targetUser = User::where('id',$id)->first();

    //         $customerApplications = ListingApplication::where('action_by_user',$id)->get();
    //         $customerReviews = Review::where('user_id',$id)->get();
    //         $customerLastApplication = ListingApplication::where('action_by_user',$id)->first();
    //         $customerLastReview = Review::where('user_id',$id)->first();
    //         $customerSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

    //         $listerListings = Listing::where('lister_id',$id)->get();
    //         $listerCustomers = ListingApplication::where('action_by_user',$id)->get();
    //         $listerPendingApplications = Listing::where('lister_id',$id)->where('status','pending')->get();
    //         $listerSuspendedListings = Listing::where('lister_id',$id)->where('status','suspended')->get();
    //         $listerRejectedApplications = Listing::where('lister_id',$id)->where('status','rejected')->get();
    //         $listerSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();
    //         // $listerLastApplication = Listing::where('user_id',$id)->where('status','pending')->first();
    //         $listerLastApplication = ListingAdminLog::where('parent_id',)->where('action','approve')->latest()->first();


    //         $repUsersSuspended = UserManagementLog::where('admin_id',$id)->where('status','suspended')->get();
    //         $repListingsApproved = ListingAdminLog::where('admin_id',$id)->where('status','approved')->get();
    //         $repListingsRejected = ListingAdminLog::where('admin_id',$id)->where('status','rejected')->get();
    //         $repListingsSuspended = ListingAdminLog::where('admin_id',$id)->where('status','suspended')->get();
    //         $repListingsDeleted = ListingAdminLog::where('admin_id',$id)->where('status','deleted')->get();
    //         $repSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

    //         $adminUsersSuspended = UserManagementLog::where('admin_id',$id)->where('status','suspended')->get();
    //         $adminListingsApproved = ListingAdminLog::where('admin_id',$id)->where('status','approved')->get();
    //         $adminListingsRejected = ListingAdminLog::where('admin_id',$id)->where('status','rejected')->get();
    //         $adminListingsSuspended = ListingAdminLog::where('admin_id',$id)->where('status','suspended')->get();
    //         $adminListingsDeleted = ListingAdminLog::where('admin_id',$id)->where('status','deleted')->get();
    //         $adminUsersCreated = UserManagementLog::where('admin_id',$id)->where('status','inactive')->get();
    //         $adminSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

    //         if ($user->user_type==3 || $user->user_type==2 || $user->user_type==1) {
    //             if (UserManagementLog::where('user_id',$id)->where('status','inactive')->exists()) {
    //                 $creatorId = UserManagementLog::where('user_id',$id)->where('status','inactive')->first();
    //                 $creator = User::where('id',$creatorId->admin_id)->first();

    //                 if ($targetUser->user_type==5) {
    //                     return view('administrators.manage_user',compact('targetUser','creator','customerApplications','customerReviews','customerLastApplication',
    //                         'customerLastReview','customerSuspendedCount'));
    //                 } else if ($targetUser->user_type==4) {
    //                     return view('administrators.manage_user',compact('targetUser','creator','listerListings','listerCustomers','listerPendingApplications',
    //                         'listerSuspendedListings','listerRejectedApplications','listerSuspendedCount','listerLastApplication'));
    //                 } else if ($targetUser->user_type==3) {
    //                     return view('administrators.manage_user',compact('targetUser','creator','repUsersSuspended','repListingsApproved','repListingsRejected',
    //                         'repListingsSuspended','repListingsDeleted','repSuspendedCount'));
    //                 } else if ($targetUser->user_type==2) {
    //                     return view('administrators.manage_user',compact('targetUser','creator','adminUsersSuspended','adminListingsApproved','adminListingsRejected',
    //                         'adminListingsSuspended','adminListingsDeleted','adminUsersCreated','adminSuspendedCount'));
    //                 }

    //             // return view('administrators.manage_user',compact('targetUser','creator'));
    //             } else {
    //                 $creator = '';

    //                 if ($targetUser->user_type==5) {
    //                     return view('administrators.manage_user',compact('targetUser','creator','customerApplications','customerReviews','customerLastApplication',
    //                         'customerLastReview','customerSuspendedCount'));
    //                 } else if ($targetUser->user_type==4) {
    //                     return view('administrators.manage_user',compact('targetUser','creator','listerListings','listerCustomers','listerPendingApplications',
    //                         'listerSuspendedListings','listerRejectedApplications','listerSuspendedCount','listerLastApplication'));
    //                 } else if ($targetUser->user_type==3) {
    //                     return view('administrators.manage_user',compact('targetUser','creator','repUsersSuspended','repListingsApproved','repListingsRejected',
    //                         'repListingsSuspended','repListingsDeleted','repSuspendedCount'));
    //                 } else if ($targetUser->user_type==2) {
    //                     return view('administrators.manage_user',compact('targetUser','creator','adminUsersSuspended','adminListingsApproved','adminListingsRejected',
    //                         'adminListingsSuspended','adminListingsDeleted','adminUsersCreated','adminSuspendedCount'));
    //                 }
    //             }
    //         } else {
    //             return redirect()->route('listings.list');
    //         }
    //     } else {
    //         return $this->viewUserManagementLogs('');
    //     }
    // }

    public function viewUser($id){
        if ($id != 'logs'){
            if (!$this->checkUserState()) {
                return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
                Auth::logout();
            }

            $user = Auth::user();
            $targetUser = User::where('id',$id)->first();

            if ($user->user_type==3 || $user->user_type==2 || $user->user_type==1) {
                if ($targetUser == ''){
                    return $this->msgRepo('error_user_does_not_exist');
                } else {
                    switch ($targetUser->user_type){
                        case 5:
                            return $this->fetchUserData($id,$targetUser->user_type);
                            break;
                        case 4:
                            return $this->fetchUserData($id,$targetUser->user_type);
                            break;
                        case 3:
                            return $this->fetchUserData($id,$targetUser->user_type);
                            break;
                        case 2:
                        case 1:
                            return $this->fetchUserData($id,$targetUser->user_type);
                            break;
                    }
                }
            }
        } else {
            return $this->viewUserManagementLogs('');
        }
    }

    public function fetchUserData($id,$type){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $targetUser = User::where('id',$id)->first();
        $tickets = HelpTicket::where('email',$targetUser->email)->get();

        if ($type == 5){
            $customerOccupations = ListingApplication::where('action','occupied')->where('action_by_user',$id)->get();
            $customerReviews = Review::where('user_id',$id)->get();
            $customerLastOccupation = ListingApplication::where('action','occupied')->where('action_by_user',$id)->first();
            $customerLastReview = Review::where('user_id',$id)->first();
            $customerSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();

            return view('administrators.manage_user',compact('targetUser','customerOccupations','customerReviews','customerLastOccupation',
                'customerLastReview','customerSuspendedCount','tickets'));
        } else if ($type == 4){
            $listerListings = Listing::where('lister_id',$id)->where('status','!=','unpublished')->get();
            $listerCustomers = ListingApplication::where('action_by_user',$id)->get();
            $listerPendingApplications = Listing::where('lister_id',$id)->where('status','pending')->get();
            $listerSuspendedListings = Listing::where('lister_id',$id)->where('status','suspended')->get();
            $listerRejectedApplications = Listing::where('lister_id',$id)->where('status','rejected')->get();
            $listerSuspendedCount = UserManagementLog::where('user_id',$id)->where('status','suspended')->get();
            $listerLastSubmission = Listing::where('lister_id',$id)->where('status','pending')->latest()->first();

            return view('administrators.manage_user',compact('targetUser','listerListings','listerCustomers','listerPendingApplications',
                'listerSuspendedListings','listerRejectedApplications','listerSuspendedCount','listerLastSubmission','tickets'));
        } else if ($type == 3){
            $repUsersSuspended = UserManagementLog::where('admin_id',$id)->where('status','suspended')->get();
            $repListingsApproved = ListingAdminLog::where('admin_id',$id)->where('action','approved')->get();
            $repListingsRejected = ListingAdminLog::where('admin_id',$id)->where('action','rejected')->get();
            $repListingsSuspended = ListingAdminLog::where('admin_id',$id)->where('action','suspended')->get();
            $repListingsDeleted = ListingAdminLog::where('admin_id',$id)->where('action','deleted')->get();

            return view('administrators.manage_user',compact('targetUser','repUsersSuspended','repListingsApproved','repListingsRejected',
                'repListingsSuspended','repListingsDeleted'));
        } else if ($type == 2 || $type == 1){
            $adminUsersSuspended = UserManagementLog::where('admin_id',$id)->where('status','suspended')->get();
            $adminListingsApproved = ListingAdminLog::where('admin_id',$id)->where('action','approved')->get();
            $adminListingsRejected = ListingAdminLog::where('admin_id',$id)->where('action','rejected')->get();
            $adminListingsSuspended = ListingAdminLog::where('admin_id',$id)->where('action','suspended')->get();
            $adminListingsDeleted = ListingAdminLog::where('admin_id',$id)->where('action','deleted')->get();
            $adminUsersCreated = UserManagementLog::where('admin_id',$id)->where('status','inactive')->get();

            return view('administrators.manage_user',compact('targetUser','adminUsersSuspended','adminListingsApproved','adminListingsRejected',
                'adminListingsSuspended','adminListingsDeleted','adminUsersCreated'));
        }
    }

    public function manageReviews($id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $propertyDetails = Listing::where('id',$id)->first();
        $reviews = Review::where('property_id',$id)->orderBy('updated_at','id')->get();
        $mean = Review::where('property_id',$id)->avg('review_rating');
        $rating = round($mean, 1)*(100/5);
        $lister = User::where('id',$propertyDetails->user_id)->first();
        return view('administrators.manage_listing_reviews')->with(compact('reviews','propertyDetails','mean','rating','lister'));
    }

    public function deleteReview($listing,$review){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;
        
        if ($utype==3 || $utype==2 || $utype==1) {
            $propertyDetails = Listing::where('id',$listing)->first();
            $reviews = Review::where('property_id',$listing)->orderBy('updated_at','id')->get();

            $reviewRow = Review::where('id',$review)->first();

            $reviewLog = new ReviewModerationLog;
            $reviewLog->customer_id = $reviewRow->customer_id;
            $reviewLog->customer_name = $reviewRow->customer_name;
            $reviewLog->lister_id = $reviewRow->lister_id;
            $reviewLog->listing_id = $reviewRow->property_id;
            $reviewLog->review = $reviewRow->review;
            $reviewLog->review_rating = $reviewRow->review_rating;
            // $reviewLog->reason = "";
            $reviewLog->admin_id = $user->id;
            $reviewLog->save();

            $reviewRow->delete();
            
            return redirect()->back();
        } else {
            return $this->msgRepo('permission_denied_not_authorised');
        } 
    }

    public function performTicketAction(Request $request,$id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $user = Auth::user();

        $utype = $user->user_type;
        
        if ($utype==3 || $utype==2 || $utype==1) {
            $ticket = HelpTicket::where('id',$id)->first();
            $updateTicket = HelpTicket::find($id);
            switch ($request->input('btn_action')) {
                case 'Pick Ticket':
                    if($ticket->status == "pending"){
                        redirect()->back()->withErrors(['Error', $this->msgRepo('error_not_allowed')]);
                    } else
                    $updateTicket->status = "pending";
                    $updateTicket->assigned_to = $user->id;
                    $updateTicket->save();
                    return $this->performTicketActionLog('assign',$id,$ticket->email,$ticket->status,'pending');
                    break;
                
                case 'Release Ticket':
                    if($ticket->status == "open"){
                        redirect()->back()->withErrors(['Error', $this->msgRepo('error_not_allowed')]);
                    } else
                    $updateTicket->status = "open";
                    $updateTicket->assigned_to = null;
                    // $updateTicket->assigned_to = $user->id;
                    $updateTicket->save();
                    return $this->performTicketActionLog('unassign',$id,$ticket->email,$ticket->status,'open');
                    break;

                case "Close as 'Resolved'":
                    if($ticket->status == "resolved"){
                        redirect()->back()->withErrors(['Error', $this->msgRepo('error_not_allowed')]);
                    } else
                    $updateTicket->status = "resolved";
                    $updateTicket->assigned_to = null;
                    $updateTicket->save();
                    return $this->performTicketActionLog('resolve',$id,$ticket->email,$ticket->status,'resolved');
                    break;

                case 'Close Ticket':
                    if($ticket->status == "closed"){
                        redirect()->back()->withErrors(['Error', $this->msgRepo('error_not_allowed')]);
                    } else
                    $updateTicket->status = "closed";
                    $updateTicket->assigned_to = $user->id;
                    $updateTicket->save();
                    return $this->performTicketActionLog('close',$id,$ticket->email,$ticket->status,'closed');
                    break;

                default:
                    return redirect()->back();
                    break;
            }
        } else {
            return $this->msgRepo('permission_denied_not_authorised');
        }
    }

    public function performTicketActionLog($action,$ticket_id,$issuer,$status_old,$status_new){
        $user = Auth::user();
        $targetUser = $user;

        $actionLog = new HelpTicketLog;
        if ($action == 'assign' || $action == 'unassign' || $action == 'close'){
            $actionLog->ticket_id = $ticket_id;
            $actionLog->user_email = $issuer;
            $actionLog->old_status = $status_old;
            $actionLog->action = $action;
            $actionLog->action_by = $user->id;
            $actionLog->action_to = $targetUser->id;
            $actionLog->new_status = $status_new;
            $actionLog->save();
        } else if($action == 'resolve'){
            $actionLog->ticket_id = $ticket_id;
            $actionLog->user_email = $issuer;
            $actionLog->old_status = $status_old;
            $actionLog->action = 'close';
            $actionLog->action_by = $user->id;
            $actionLog->action_to = $targetUser->id;
            $actionLog->new_status = $status_new;
            $actionLog->save();
        }
       
        return redirect()->back()->with('message','Action performed successfully!');
        // return redirect()->back()->with('message','Your ticket has been issued. A representative will get in touch with you shortly. Please be patient.');
    }

    public function viewTicket($id,Request $request){
        $userType = Auth::user()->user_type;
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $ticket = HelpTicket::where('id',$id)->first();
            $logs = HelpTicketLog::where('ticket_id',$id)->orderBy('created_at','DESC')->get();
            return view('administrators.manage_ticket',compact('ticket','logs'));
        } else {

        }
    }

    public function assignedTickets($id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            if($id == 'me'){
                $tickets = HelpTicket::where('assigned_to',Auth::user()->id)->orderBy('updated_at')->get();
                $targetUser = Auth::user();
            } else {
                $tickets = HelpTicket::where('assigned_to',$id)->orderBy('updated_at')->get();
                $targetUser = User::where('id',$id)->first();
            }
            return view('administrators.tickets_assigned',compact('tickets','targetUser'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function viewTicketLogs($ticket){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            if($ticket == '' || $ticket == 'all'){
                $logs = HelpTicketLog::all();
            } else {
                $logs = HelpTicketLog::where('ticket_id',$ticket)->get();
            }
            return view('administrators.logs_tickets',compact('logs'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function viewAdminTicketLogs($user){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            if($user == '' || $user == 'me'){
                $logs = HelpTicketLog::where('action_by',Auth::user()->id)->get();
            } else {
                $logs = HelpTicketLog::where('action_by',$user)->get();
            }
            return view('administrators.logs_tickets',compact('logs'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function viewUserTicket($email){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $tickets = HelpTicket::where('email',$email)->orderBy('updated_at')->get();
            
            return view('administrators.tickets_reusable',compact('tickets'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function viewHelpCategories(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $user = Auth::user();
        $userType = $user->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $categories = HelpCategory::orderBy('created_at','DESC')->get();
            return view('administrators.manage_help_categories',compact('categories'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function performHelpCategoryTask($id,Request $request){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else
        
        switch($request->input('btn_task')){
            case 'Create':
                return $this->addHelpCategory($request);
                break;
            case 'Update':
                return $this->updateHelpCategory($id,$request);
                break;
            case 'Delete':
                return $this->deleteHelpCategory($id);
                break;
        }
    }

    public function addHelpCategory(Request $request){
        $this->validate($request,[
    		'name'=>'required|max:50',
            'priority'=>'required',
            ]);
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $user = Auth::user();
        $userType = $user->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $category = new HelpCategory;
            $category->name = $request->name;
            $category->description = $request->description;
            $category->priority = $request->priority;
            $category->save();
            $action = 'create';
            
            return $this->createHelpCategoryLog($category,$user->id,$action);

            // return redirect()->back()->with('message','Category added');
        } else {
            return $this->msgRepo('permission_denied_not_authorised');
        }
    }

    public function updateHelpCategory($id,Request $request){
        $this->validate($request,[
    		'name'=>'required|max:50',
            'priority'=>'required',
            ]);
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $user = Auth::user();
        $userType = $user->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {

            $input = HelpCategory::find($id);
            $input->update($request->all());

            $action = 'update';
            
            return $this->createHelpCategoryLog($input,$user->id,$action);

            // return redirect()->back()->with('message','Category added');
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function deleteHelpCategory($id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $user = Auth::user();
        $userType = $user->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {

            $input = HelpCategory::find($id);
            $input->delete();

            $action = 'delete';
            
            return $this->createHelpCategoryLog($input,$user->id,$action);

            // return redirect()->back()->with('message','Category added');
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function createHelpCategoryLog($category,$adminId,$action){
        $categoryLog = new HelpCategoryLog;
        $categoryLog->parent_id = $category->id;
        $categoryLog->name = $category->name;
        $categoryLog->priority = $category->priority;
        $categoryLog->action = $action;
        $categoryLog->admin_id = $adminId;
        $categoryLog->save();

        return redirect()->back()->with('message','Entry '.$action.'d');
    }

    public function viewHelpCategoryLogs($target = null){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $targetUser = '';

        if($target == 'me'){
            $logs = HelpCategoryLog::where('admin_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
            $targetUser = 'me';
        } else if($target == 'all' || empty($target)){
            $logs = HelpCategoryLog::orderBy('created_at','DESC')->get();
            $targetUser = 'all';
        }
        
        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            return view('administrators.logs_help_categories',compact('logs','targetUser'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function listZones(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $user = Auth::user();
        $API_KEY = config('constants.API_KEY.maps');
        $userType = $user->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $zones = Zone::orderBy('created_at','id')->get();
            $p_zones = Zone::withCount('zoneEntry')->orderBy('zone_entry_count', 'updated_at')->paginate(10);
            return view('administrators.all_zones',compact('p_zones','zones','API_KEY'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function createZone(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $API_KEY = config('constants.API_KEY.maps');
        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $zone = "";
            return view('administrators.create_zone',compact('zone','API_KEY'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function saveZone(Request $request){
        $this->validate($request,[
    		'name'=>'required|max:50',
            'country'=>'required',
            'county'=>'required|max:50',
    		]);
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            Zone::create($request->all());
            $zones = Zone::orderBy('created_at','id')->get();
            $p_zones = Zone::withCount('zoneEntry')->orderBy('zone_entry_count', 'updated_at')->paginate(2);
            
            return redirect()->route('admin.zones')->with('zones',$zones)->with('p_zones',$p_zones)->with('message','Zone added');
            
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function viewZone($id,Request $request){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $API_KEY = config('constants.API_KEY.maps');
        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $zone = Zone::where('id',$id)->first();
            $entries = ZoneEntry::where('parent_id',$id)->orderBy('created_at','id')->get();
            return view('administrators.view_zone',compact('zone','entries','API_KEY'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function editZone($id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $zone = Zone::where('id',$id)->first();
            return view('administrators.create_zone',compact('zone'));
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function updateZone(Request $request,$id){
        $this->validate($request,[
    		'name'=>'required|max:50',
            'country'=>'required',
            'county'=>'required|max:50',
            ]);
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $input = Zone::find($id);
            $input->update($request->all());
            $zone = Zone::where('id',$id)->first();
            $entries = ZoneEntry::where('parent_id',$id)->get();
            return redirect()->route('admin.viewZone',[$zone])->with('zone',$zone)->with('entries',$entries)->with('message','Zone updated');
            // return redirect()->route('admin.viewZone',[$zone,$entries])->with('zone',$zone)->with('entries',$entries)->with('message','Zone updated');
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function addZoneEntry($id){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $zone = Zone::where('id',$id)->first();
            $zone_entry = "";
            $zone_entry_count = ZoneEntry::where('parent_id',$id)->count();
            return view('administrators.create_zone_entry',compact('zone','zone_entry','zone_entry_count'));
            // return view('administrators.create_zone_entry');
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function saveZoneEntry(Request $request,$id){
        $this->validate($request,[
    		'name'=>'required|max:50',
            'role'=>'required',
            'timezone'=>'required',
            'radius'=>'numeric',
            ]);
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $request->request->add(['parent_id' => $id]);
            $data = $request->all();
            ZoneEntry::create($data);
            $zone = Zone::where('id',$id)->first();
            $entries = ZoneEntry::where('parent_id',$id)->get();
            return redirect()->route('admin.viewZone',[$zone])->with('zone',$zone)->with('entries',$entries)->with('message','Sub-Zone created');
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function editZoneEntry($zoneId,$entryId){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $zone = Zone::where('id',$zoneId)->first();
            $zone_entry = ZoneEntry::where('id',$entryId)->first();
            $zone_entry_count = ZoneEntry::where('parent_id',$zoneId)->count();
            // return view('administrators.create_zone_entry',compact('zone','zone_entry','zone_entry_count'));
            return view('administrators.edit_zone_entry');
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function updateZoneEntry(Request $request,$zoneId,$entryId){
        $this->validate($request,[
    		'name'=>'required|max:50',
            'role'=>'required',
            'timezone'=>'required|timezone',
            'radius'=>'numeric',
            ]);
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $request->request->add(['parent_id' => $zoneId]);
            $data = $request->all();
            $input = ZoneEntry::find($entryId);
            $input->update($data);
            $zone = Zone::where('id',$zoneId)->first();
            $entries = ZoneEntry::where('parent_id',$zoneId)->get();
            return redirect()->route('admin.viewZone',[$zone])->with('zone',$zone)->with('entries',$entries)->with('message','Sub-Zone updated');
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function deleteZoneEntry($zoneId,$entryId){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            $input = ZoneEntry::find($entryId);
            $input->delete();
            $zone = Zone::where('id',$zoneId)->first();
            $entries = ZoneEntry::where('parent_id',$zoneId)->get();
            return redirect()->route('admin.viewZone',[$zone])->with('zone',$zone)->with('entries',$entries)->with('message','Sub-Zone deleted');
            return $input;
        } else {
            return redirect()->route('listings.list');
        }
    }

    // public function viewListingManagementLogs(){
    //     if (!$this->checkUserState()) {
    //         return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
    //         Auth::logout();
    //     } else

    //     $logs = ListingAdminLog::where('admin_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
    //     $targetUsers = "me";
        
    //     $userType = Auth::user()->user_type;
    //     if ($userType == 3 || $userType == 2 || $userType == 1) {
    //         return view('administrators.logs_manage_listings',compact('logs','targetUsers'));
    //     } else {
    //         return redirect()->route('listings.list');
    //     }


    // }

    // public function viewListingManagementLogsAll(){
    //     if (!$this->checkUserState()) {
    //         return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
    //         Auth::logout();
    //     } else

    //     $logs = ListingAdminLog::orderBy('created_at','DESC')->get();
    //     $targetUsers = "all";
        
    //     $userType = Auth::user()->user_type;
    //     if ($userType == 3 || $userType == 2 || $userType == 1) {
    //         return view('administrators.logs_manage_listings',compact('logs','targetUsers'));
    //     } else {
    //         return redirect()->route('listings.list');
    //     }


    // }

    public function viewListingManagementLogs($target){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $targetUsers = '';

        if($target == ''){
            $logs = ListingAdminLog::where('admin_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
            $targetUsers = "me";
        } else if($target == 'all'){
            $logs = ListingAdminLog::orderBy('created_at','DESC')->get();
            $targetUsers = "all";
        }
        
        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            return view('administrators.logs_manage_listings',compact('logs','targetUsers'));
        } else {
            return redirect()->route('listings.list');
        }

    }

    public function viewUserManagementLogs($target){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact a representative for assistance.');
            Auth::logout();
        } else

        $targetUsers = '';

        if($target == ''){
            $logs = UserManagementLog::where('admin_id',Auth::user()->id)->orderBy('created_at','DESC')->get();
            $targetUsers = "me";
        } else if($target == 'all'){
            $logs = UserManagementLog::orderBy('created_at','DESC')->get();
            $targetUsers = "all";
        } else {
            $logs = UserManagementLog::where('user_id',$target)->orderBy('created_at','DESC')->get();
            $targetUsers = "all";
        }
        
        $userType = Auth::user()->user_type;
        if ($userType == 3 || $userType == 2 || $userType == 1) {
            return view('administrators.logs_manage_users',compact('logs','targetUsers'));
        } else {
            return redirect()->route('listings.list');
        }

    }

}