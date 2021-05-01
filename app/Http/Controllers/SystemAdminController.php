<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Listing;
use App\ListingApplication;
use App\Customer;
use App\Review;
use App\ApplicationResponse;
use App\AdminBookmark;
use App\User;
use App\UserManagementLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SystemAdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('checkUserStatus')->except('logout');
	}

	public function deleteUser($id){
		$user = Auth::user();
		$targetUser = User::where('id',$id)->first();

        if ($targetUser->status == 'suspended' && $user->user_type==1) {
        	$log = new UserManagementLog;
			$log->user_id = $targetUser->id;
			$log->name = $targetUser->name;
			$log->user_type = $targetUser->user_type;
			$log->status = 'deleted';
			$log->admin_id = $user->id;
			$log->save();

			$targetUser->delete();	

			return redirect()->back();

        } else {
            return redirect()->route('listings.list');
        }
    }

}
