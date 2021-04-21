<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Hash;

class ChangePassController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		
		if(!Session::has('mnuChangePass'))
        {
            return view('layouts.PageNotFound');
        }

        return view('layouts.ChangePassword');
    }

    public function ActChangePass(Request $request)
    {


        $userid = Session::get('USERNAME');
        $passwd = Session::get('PASSWORD');

        $currentpasswd = $request->input('currentpassword');
        $newpassword = $request->input('newpassword');

        if($passwd == $currentpasswd)
        {

            if($newpassword == null || empty($newpassword)){
                return redirect('ChangePass')->with('alert','New Password field must be filled!');
            }
            if($currentpasswd== $newpassword){
                return redirect('ChangePass')->with('alert','New password cant be the same as the old password!');
            }
            else
            {
                DB::table('sec_user')
                    ->where('user_id2', $userid)
                    ->update(['password' => Hash::make($newpassword), 'user_pass' => $newpassword]);

                Session::put('PASSWORD', $newpassword);
                return redirect('ChangePass')->with('password_changed','Password change, you must login again.');
            }

        }
        else
        {
            return redirect('ChangePass')->with('alert','Wrong Current Password!');
        }

    }

}
