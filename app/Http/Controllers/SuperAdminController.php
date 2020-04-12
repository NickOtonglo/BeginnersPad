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
    public function checkUserState(){
        if (Auth::check() && Auth::user()->status == 'suspended') {
            return false;
        } else return true;
    }

    public function createUser(){
        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact the system administrator for assistance.');
            Auth::logout();
        }

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
            'telephone' => 'required|string|size:12',
    		]);

        if (!$this->checkUserState()) {
            return redirect('/login')->with('error_login','Sorry, your account has been suspended. Contact the system administrator for assistance.');
            Auth::logout();
        }

        $user = Auth::user();
        $utype = $user->user_type;
        if ($utype==2 || $utype==1){

            if (User::where('email',$request->email)->exists()) {
                return 'Account with the email '.$request->email.' already exists.';
            } else

            $newUser = new User;
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = Hash::make('password');
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

            return redirect()->route('admin.listUsers')->with(compact('users'));
        } else {
            return redirect()->route('listings.list');
        }
    }
}
