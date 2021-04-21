<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Session;
use DB;
use Carbon\Carbon;
use Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {

        $remember = ($request->has('remember')) ? true : false;

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password]))
        {
            $userStatus = Auth::User()->active_flag;
            $passCheck = Auth::User()->password;

            if (Hash::check($request->username, $passCheck))
            {
                Auth::logout();
                Session::put('USERNAME', $request->username);
                return redirect('ChangeDefaultPassword')->with('alert','Sorry, it seems your current password is exactly same as your username, please change it before continuing.');
            }
            else
            {
                if($userStatus == 'Y')
                {
                    $datetime = Carbon::now();
                    $updateLastActive = DB::table('sec_user')
                                        ->where('username', '=', Auth::User()->username)
                                        ->update(['last_active' => $datetime]);

                    /* $clientIP = $_SERVER['REMOTE_ADDR']; */
                    $clientIP = request()->ip();

                    $salesid = DB::table('sec_env_conf')
                                ->select('var_value')
                                ->where('appl_id','=', 'KBTWEB')
                                ->where('var_id', '=', 'SALESID')
                                ->where('user_id2', '=', Auth::User()->username)
                                ->Value('var_value');

                    $groupid = DB::table('sec_group')
                                ->select('group_id')
                                ->where('appl_id','=', 'KBTWEB')
                                ->Where('user_id2', '=', Auth::User()->username)
                                ->Value('group_id');

                    $officeid = DB::table('sec_env_conf')
                                ->select('var_value')
                                ->where('appl_id','=', 'KBTWEB')
                                ->where('var_id', '=', 'OFFICEID')
                                ->Where('user_id2', '=', Auth::User()->username)
                                ->Value('var_value');

                    $officename = DB::connection("sqlsrv2")
                                    ->table('branch_office')
                                    ->select('office')
                                    ->where('office_id','=', $officeid)
                                    ->Value('office');

                    $name1 = DB::table('sec_user')
                                ->select('name1')
                                ->Where('user_id2', '=', Auth::User()->username)
                                ->Value('name1');

                    $name2 = DB::table('sec_user')
                                ->select('name2')
                                ->Where('user_id2', '=', Auth::User()->username)
                                ->Value('name2');

                    $name3 = DB::table('sec_user')
                                ->select('name3')
                                ->Where('user_id2', '=', Auth::User()->username)
                                ->Value('name3');

                    $getEnvMnu = DB::table('sec_right')
                                ->select('menu_id')
                                ->where('appl_id','=', 'KBTWEB')
                                ->where('group_id','=', $groupid)
                                ->where('active_flag','=', 'Y')
                                ->get();

                    $getEnvID = DB::table('sec_env_var')
                                ->select('var_id')
                                ->where('appl_id','=', 'KBTWEB')
                                ->where('active_flag','=', 'Y')
                                ->get();

                    $rm = DB::connection("sqlsrv2")
                            ->table('branch_office')
                            ->select('region')
                            ->distinct()
                            ->where('rm','=', $salesid)
                            ->Value('region');   
                            
                    if($rm){
                        Session::put('REGIONID', $rm);
                    }

                    foreach($getEnvID as $getEnvID) {

                        $getVarValue1 = DB::table('sec_env_conf')
                                    ->select('var_value')
                                    ->where('appl_id','=', 'KBTWEB')
                                    ->where('var_id','=', $getEnvID->var_id)
                                    ->where('active_flag','=', 'Y')
                                    ->Value('var_value');

                        Session::put( $getEnvID->var_id, $getVarValue1);


                        $getVarValue2 = DB::table('sec_env_conf')
                                    ->select('var_value')
                                    ->where('appl_id','=', 'KBTWEB')
                                    ->where('group_id','=', $groupid)
                                    ->where('var_id','=', $getEnvID->var_id)
                                    ->where('active_flag','=', 'Y')
                                    ->Value('var_value');

                        Session::put( $getEnvID->var_id, $getVarValue2);


                        $getVarValue3 = DB::table('sec_env_conf')
                                    ->select('var_value')
                                    ->where('appl_id','=', 'KBTWEB')
                                    ->Where('user_id2', '=', Auth::User()->username)
                                    ->where('var_id','=', $getEnvID->var_id)
                                    ->where('active_flag','=', 'Y')
                                    ->Value('var_value');

                        Session::put( $getEnvID->var_id, $getVarValue3);

                    }

                    foreach($getEnvMnu as $getEnvMnu) {
                        Session::put($getEnvMnu->menu_id, $getEnvMnu->menu_id);
                    }

                    Session::put('GROUPID', $groupid);
                    Session::put('NAME1', $name1);
                    Session::put('NAME2', $name2);
                    Session::put('NAME3', $name3);
                    Session::put('USERNAME', Auth::User()->username);
                    Session::put('OFFICEID', $officeid);
                    Session::put('OFFICENAME', $officename);
                    Session::put('SALESID', $salesid);
                    Session::put('PASSWORD', $request->password);
                    Session::put('ACTIVE_FLAG', Auth::User()->active_flag);
                    Session::put('USERIP', $clientIP);
                   
                    return redirect()->route('home')->with('success','Voila! Succesfully login');
                  
                }
                else
                {
                    Auth::logout();
                    Session::flush();
                    return redirect(url('login'))->withInput()->with('alert','Your ID is blocked. Please contact our admin');
                }
            }
        }else
        {
            return redirect()->route('login')->with('alert','Sorry, your username and password is incorrect. Please try again.');
        }
    }

}
