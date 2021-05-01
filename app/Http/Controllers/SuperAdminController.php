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

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkUserStatus')->except('logout');
    }

    public function createUser(){
        $user = Auth::user();
        $utype = $user->user_type;
        if ($utype==2 || $utype==1){
            return view('super_administrator.add_user');
        } else {
            return redirect()->route('listings.list');
        }
    }

    public function storeUser(Request $request){

    	$this->validate($request,[
    		'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'telephone' => 'required|string|min:10|max:13',
    		]);

        $user = Auth::user();
        $utype = $user->user_type;
        if ($utype==2 || $utype==1){

            if (User::where('email',$request->email)->exists()) {
                return 'Account with the email \"'.$request->email.'\" already exists.';
            } else

            $newUser = new User;
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->telephone = $request->telephone;
            $newUser->password = Hash::make($request->password);
            $newUser->user_type = $request->user_type;
            $newUser->status = "inactive";
            $newUser->save();

            $getUser = User::where('email',$request->email)->first();

            $newUser = new UserManagementLog;
            $newUser->user_id = $getUser->id;
            $newUser->name = $getUser->name;
            $newUser->user_type = $getUser->user_type;
            $newUser->status = $getUser->status;
            $newUser->admin_id = $user->id;
            $newUser->save();

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

            return redirect()->route('admin.listUsers')->with(compact('users'))->with('message','"'.$request->name.'" created');
        } else {
            return redirect()->route('listings.list');
        }
    }
}
