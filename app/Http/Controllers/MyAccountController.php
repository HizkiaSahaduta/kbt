<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class MyAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

		if(!Session::has('mnuMyAccount'))
        {
            return view('layouts.PageNotFound');
        }

        return view('layouts.MyAccount');
    }

}
