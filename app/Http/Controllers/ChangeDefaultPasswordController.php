<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Hash;
use Session;

class ChangeDefaultPasswordController extends Controller
{
    public function index()
    {
        return view('layouts.ChangeDefaultPassword');
    }

    public function ChangeDefPass(Request $request)
    {

        $newPass = $request->password;
        $username = Session::get('USERNAME');

        if($newPass != $username )
        {
            DB::table('sec_user')
                ->where('username', '=', $username)
                ->update(['password' => Hash::make($newPass), 'user_pass' => $newPass]);

            Auth::logout();
            Session::flush();

            return redirect('login')->with('success','Password changed, please login again');;
        }
        else
        {
            return redirect('ChangeDefaultPassword')->with('alert','Your password cannot same as your username');
        }

    }

}
