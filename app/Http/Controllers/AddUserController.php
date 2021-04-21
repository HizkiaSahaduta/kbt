<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Hash;

class AddUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
		
		if(!Session::has('mnuAddUser'))
        {
            return view('layouts.PageNotFound');
        }

        return view('layouts.AddUser');

    }

    public function listUser(){

        $result = DB::table('sec_user')
                    ->select('id', 'user_id2', 'user_pass', 'name1', 'name2', 'name3', 'plant', 'division', 'dept', 'section', 'position', 'active_flag')
                    ->get();

         return \DataTables::of($result)
                ->editColumn('active_flag', function ($data) {
                    if ($data->active_flag == "Y") return '<span class="shadow-none badge badge-success"> Active</span>';
                    return '<span class="shadow-none badge badge-danger"> N/A</span>';
                })
                ->addColumn('Detail', function($data) {

                    return '
                        <a href="javascript:void(0)" data-id1="'.$data->id.'" data-id2="'.$data->user_id2.'" class="bs-tooltip editUser" data-placement="top" title="Edit" data-toggle="modal" data-target="#editUser">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit text-warning"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>

                        <a href="javascript:void(0)" data-id1="'.$data->id.'" data-id2="'.$data->user_id2.'" class="bs-tooltip delUser" data-placement="top" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                        </a>
                        ';
                    })
                ->rawColumns(['Detail','active_flag'])
                ->make(true);
    }

    public function saveUser(Request $request){

        $userid = Session::get('USERNAME');
        $user_id2 = $request->user_id2;
        // $user_pass = $request->user_pass;
        $password = Hash::make($user_id2);

        $name1 = $request->name1;
        if(!$name1){
            $name1 = '';
        }

        $name2 = $request->name2;
        if(!$name2){
            $name2 = '';
        }

        $name3 = $request->name3;
        if(!$name3){
            $name3 = '';
        }

        $plant = $request->plant;
        if(!$plant){
            $plant = '';
        }

        $division = $request->division;
        if(!$division){
            $division = '';
        }

        $dept = $request->dept;
        if(!$dept){
            $dept = '';
        }

        $section = $request->section;
        if(!$section){
            $section = '';
        }

        $position = $request->position;
        if(!$position){
            $position = '';
        }

        try{

            $id = DB::table('sec_user')
                    ->select('id')
                    ->max('id');

            $item = DB::table('sec_user')
                        ->insert([
                            'id' => $id + 1,
                            'global_id' => $user_id2,
                            'user_id2' => $user_id2,
                            'username' => $user_id2,
                            'password' => $password,
                            'user_pass'=> $user_id2,
                            'name1' => $name1,
                            'name2' => $name2,
                            'name3' => $name3,
                            'plant' => $plant,
                            'division' => $division,
                            'dept' => $dept,
                            'section' => $section,
                            'position' => $position,
                            'active_flag' => 'Y',
                            'user_id' => $userid
                        ]);

            return response()->json(['response' => 'User Added']);

        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            return response()->json(['response' => 'Whops, something error', 'detail'=> $error]);
        }


    }

    public function getUser($id, $id2){

        $html = '';
        $data = DB::table('sec_user')
                    ->selectRaw('LTRIM(RTRIM(id)) as id, LTRIM(RTRIM(user_id2)) as user_id2, LTRIM(RTRIM(user_pass)) as user_pass, LTRIM(RTRIM(name1)) as name1,
                    LTRIM(RTRIM(name2)) as name2, LTRIM(RTRIM(name3)) as name3, LTRIM(RTRIM(plant)) as plant, LTRIM(RTRIM(division)) as division,
                    LTRIM(RTRIM(dept)) as dept, LTRIM(RTRIM(section)) as section, LTRIM(RTRIM(position)) as position, active_flag')
                    ->where('id', '=', $id)
                    ->where('user_id2', '=', $id2)
                    ->get();

        foreach ($data as $data) {

            $html .= "
                    <input id='id' type='hidden' value=".$data->id.">
                    <div class='form-row mb-6'>
                    <div class='form-group col-md-4'>
                        <label for='edit_user_id'>User ID</label>
                        <input id='edit_user_id' type='text' class='form-control' value=".$data->user_id2.">
                    </div>
                    <div class='form-group col-md-4'>
                        <label for='edit_user_pass'>User Pass</label>
                        <input id='edit_user_pass' type='text' class='form-control' value=".$data->user_pass.">
                    </div>
                    <div class='form-group col-md-3'>
                        <label for='edit_flag'>Active Flag</label>
                        <select class='form-control' id='edit_flag'>";

            if ($data->active_flag == 'Y'){
                $html .= "<option value='Y' selected>Y</option>";
                $html .= "<option value='N'>N</option>";
            }

            else {
                $html .= "<option value='Y'>Y</option>";
                $html .= "<option value='N' selected>N</option>";
            }

            $html .= "
                         </select>
                    </div>
                    </div>

                    <div class='form-row mb-6'>
                    <div class='form-group col-md-4'>
                        <label for='edit_name1'>Name 1</label>
                        <input id='edit_name1' type='text' class='form-control' value=".$data->name1.">
                    </div>
                    <div class='form-group col-md-4'>
                        <label for='edit_name2'>Name 2</label>
                        <input id='edit_name2' type='text' class='form-control' value=".$data->name2.">
                    </div>
                    <div class='form-group col-md-4'>
                        <label for='edit_name3'>Name 3</label>
                        <input id='edit_name3' type='text' class='form-control' value=".$data->name3.">
                    </div>
                    </div>

                    <div class='form-row mb-6'>
                    <div class='form-group col-md-5'>
                        <label for='edit_plant'>Plant</label>
                        <input id='edit_plant' type='text' class='form-control' value=".$data->plant.">
                    </div>
                    <div class='form-group col-md-5'>
                        <label for='edit_division'>Division</label>
                        <input id='edit_division' type='text' class='form-control' value=".$data->division.">
                    </div>
                    </div>

                    <div class='form-row mb-6'>
                    <div class='form-group col-md-4'>
                        <label for='edit_dept'>Dept</label>
                        <input id='edit_dept' type='text' class='form-control' value=".$data->dept.">
                    </div>
                    <div class='form-group col-md-4'>
                        <label for='edit_section'>Section</label>
                        <input id='edit_section' type='text' class='form-control' value=".$data->section.">
                    </div>
                    <div class='form-group col-md-4'>
                        <label for='edit_position'>Position</label>
                        <input id='edit_position' type='text' class='form-control' value=".$data->position.">
                    </div>
                    </div>";
        }

        return response()->json(['html'=>$html]);


    }

    public function editUser(Request $request){

        $userid = Session::get('USERNAME');
        $id = $request->id;
        $flag = $request->flag;
        $user_id2 = $request->user_id2;
        $user_pass = $request->user_pass;
        $password = Hash::make($user_pass);

        $name1 = $request->name1;
        if(!$name1){
            $name1 = '';
        }

        $name2 = $request->name2;
        if(!$name2){
            $name2 = '';
        }

        $name3 = $request->name3;
        if(!$name3){
            $name3 = '';
        }

        $plant = $request->plant;
        if(!$plant){
            $plant = '';
        }

        $division = $request->division;
        if(!$division){
            $division = '';
        }

        $dept = $request->dept;
        if(!$dept){
            $dept = '';
        }

        $section = $request->section;
        if(!$section){
            $section = '';
        }

        $position = $request->position;
        if(!$position){
            $position = '';
        }

        try{

            $update = DB::table('sec_user')
                        ->where('id', '=', $id)
                        ->update([
                            'global_id' => $user_id2,
                            'user_id2' => $user_id2,
                            'username' => $user_id2,
                            'password' => $password,
                            'user_pass'=> $user_pass,
                            'name1' => $name1,
                            'name2' => $name2,
                            'name3' => $name3,
                            'plant' => $plant,
                            'division' => $division,
                            'dept' => $dept,
                            'section' => $section,
                            'position' => $position,
                            'active_flag' => 'Y',
                            'active_flag' => $flag,
                            'user_id' => $userid
                        ]);

            return response()->json(['response' => 'User Updated']);

        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            return response()->json(['response' => 'Whops, something error', 'detail'=> $error]);
        }


    }

    public function delUser($id, $id2){

        try{

            $delete = DB::table('sec_user')
                        ->where('id', '=', $id)
                        ->where('user_id2', '=', $id2)
                        ->delete();

            return response()->json(['response' => 'User Deleted']);

        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            return response()->json(['response' => 'Whops, something error', 'detail'=> $error]);
        }




    }
}
