<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Hash;
use Carbon\Carbon;

class AddSalesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
		
		if(!Session::has('mnuAddSales'))
        {
            return view('layouts.PageNotFound');
        }

        return view('layouts.AddSales');

    }

    
    public function listSales(){

        $result = DB::connection("sqlsrv2")
                    ->select(DB::raw("select a.sales_id, a.nama, a.active_flag, a.division, 
                    case when division = 'K' then 'KACAB'
                    when division = 'S' then 'RM' else b.descr end
                    as descr, c.office 
                    from sales a
                    left outer join kepuh.dbo.division b on a.division = b.class
                    left outer join branch_office c on a.office_id = c.office_id
                    where a.pt_id = 'KBT'"));
                    
        return \DataTables::of($result)
                ->editColumn('active_flag', function ($data) {
                    if ($data->active_flag == "Y") return '<span class="shadow-none badge badge-success"> Active</span>';
                    return '<span class="shadow-none badge badge-danger"> N/A</span>';
                })
                ->addColumn('Detail', function($data) {

                    return '
                        <a href="javascript:void(0)" data-id="'.$data->sales_id.'" class="bs-tooltip editUser" data-placement="top" title="Edit" data-toggle="modal" data-target="#editSales">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit text-warning"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </a>
                        ';
                    })
                ->rawColumns(['Detail','active_flag'])
                ->make(true);
    }

    
    public function saveSales(Request $request){

        $userid = Session::get('USERNAME');
        $tr_date = Carbon::now();
        $txtSalesID = $request->txtSalesID;
        if (!$txtSalesID){
            $txtSalesID = '';
        }

        $txtSalesCode = $request->txtSalesCode;
        if (!$txtSalesCode){
            $txtSalesCode = '';
        }

        $txtDepartment = $request->txtDepartment;
        if ($txtDepartment == 'SALES'){
            $txtDivision = $request->txtDivision;
            $group = 'SALES';
                if(!$txtDivision){
                    $txtDivision = '';
                }
        }
        else if ($txtDepartment == 'KACAB'){
            $txtDivision = 'K';
            $group = 'KACAB';
        }
        else if ($txtDepartment == 'RM'){
            $txtDivision = 'S';
            $group = 'RM';
        }

        $txtSalesName = $request->txtSalesName;
        if (!$txtSalesName){
            $txtSalesName = '';
        }

        $txtEmail = $request->txtEmail;
        if (!$txtEmail){
            $txtEmail = '';
        }

        $txtPhone =	$request->txtPhone;
        if (!$txtPhone){
            $txtPhone = '';
        }

        $txtCity =	$request->txtCity;
        if (!$txtCity){
            $txtCity = '';
        }

        $txtRegion 	= $request->txtRegion;
        if (!$txtRegion){
            $txtRegion = '';
        }

        $txtAddress = $request->txtAddress;
        if (!$txtAddress){
            $txtAddress = '';
        }

        $txtSalesOffice = $request->txtSalesOffice;
        if (!$txtSalesOffice){
            $txtSalesOffice = '';
        }

        $txtBranchHead = $request->txtBranchHead;
        if (!$txtBranchHead){
            $txtBranchHead = '';
        }

        $txtBankAccount = $request->txtBankAccount;
        if (!$txtBankAccount){
            $txtBankAccount = '';
        }

        $txtAccountName = $request->txtAccountName;
        if (!$txtAccountName){
            $txtAccountName = '';
        }

        $txtRegionName = $request->txtRegionName;
        if (!$txtRegionName){
            $txtRegionName = '';
        }

        $txtRegionScope = $request->txtRegionScope;
        if (!$txtRegionScope){
            $txtRegionScope = '';
        }
        else {
            $string = [];
            foreach($txtRegionScope as $txtRegionScope) {
                $string[] = "'".$txtRegionScope."'";
            }
            $list_office_id = implode(",", $string);
        }

        $user_id2 = $txtSalesID;
        $password = Hash::make($user_id2);
        $pt_id = 'KBT';

        

        try{

            $id = DB::table('sec_user')
                    ->select('id')
                    ->max('id');

            $user = DB::table('sec_user')
                        ->insert([
                            'id' => $id + 1,
                            'global_id' => $user_id2,
                            'user_id2' => $user_id2,
                            'username' => $user_id2,
                            'password' => $password,
                            'user_pass'=> $user_id2,
                            'name1' => $txtSalesName,
                            'active_flag' => 'Y',
                            'user_id' => $userid
                        ]);

            $group = DB::table('sec_group')
                        ->insert([
                            'appl_id' => 'KBTWEB',
                            'user_id2' => $user_id2,
                            'group_id' => $group,
                            'active_flag' => 'Y',
                            'dt_modified' => $tr_date,
                            'user_id' => $userid
                        ]);

            $env1 = DB::table('sec_env_conf')
                        ->insert([
                            'appl_id' => 'KBTWEB',
                            'group_id' => '',
                            'user_id2' => $user_id2,
                            'var_id' => 'SALESID',
                            'var_type' => 'S',
                            'var_value' => strtoupper($txtSalesID),
                            'note1' => '',
                            'active_flag' => 'Y',
                            'dt_modified' => $tr_date,
                            'user_id' => $userid
                        ]);

            $env2 = DB::table('sec_env_conf')
                        ->insert([
                            'appl_id' => 'KBTWEB',
                            'group_id' => '',
                            'user_id2' => $user_id2,
                            'var_id' => 'OFFICEID',
                            'var_type' => 'S',
                            'var_value' => $txtSalesOffice,
                            'note1' => '',
                            'active_flag' => 'Y',
                            'dt_modified' => $tr_date,
                            'user_id' => $userid
                        ]);

            if ($txtDivision == 'K' && $txtBranchHead) {

                $sales1 = DB::connection("sqlsrv2")
                            ->table('sales')
                            ->where('salesid', '=', $txtBranchHead)
                            ->update([
                                'active_flag' => 'N'
                            ]);

                $sales2 = DB::connection("sqlsrv2")
                            ->table('sales')
                            ->where('ka_cab', '=', $txtBranchHead)
                            ->update([
                                'ka_cab' => strtoupper($txtSalesID)
                            ]);

                $user = DB::table('sec_user')
                            ->where('user_id2', '=', strtolower($txtBranchHead))
                            ->update([
                                'active_flag' => 'N'
                            ]);

                $group = DB::table('sec_group')
                            ->where('user_id2', '=', strtolower($txtBranchHead))
                            ->update([
                                'active_flag' => 'N'
                            ]);

                $env = DB::table('sec_env_conf')
                            ->where('user_id2', '=', strtolower($txtBranchHead))
                            ->update([
                                'active_flag' => 'N'
                            ]);

                $branch_office = DB::connection("sqlsrv2")
                                ->table('branch_office')
                                ->where('ka_cab', '=', strtolower($txtBranchHead))
                                ->where('office_id','=', $txtSalesOffice)
                                ->where('pt_id', '=', $pt_id)
                                ->update([
                                    'ka_cab' => strtoupper($txtSalesID)
                                ]);

                $sales3 = DB::connection("sqlsrv2")
                            ->table('sales')
                            ->insert([
                                'sales_id' => strtoupper($txtSalesID),
                                'nama' => strtoupper($txtSalesName),
                                'address1' => strtoupper($txtAddress),
                                'city' => $txtCity,
                                'propinsi' => $txtRegion,
                                'hp' => $txtPhone,
                                'active_flag' => 'Y',
                                'ka_cab' => strtoupper($txtSalesID),
                                'region' => $txtRegion,
                                'division' => $txtDivision,
                                's_age' => '',
                                'e_mail' => $txtEmail,
                                's_code' => '',
                                'office_id' => $txtSalesOffice,
                                'bank' => $txtBankAccount,
                                'rek_id' => $txtAccountName,
                                'idemployee' => '',
                                'target' => '',
                                'type_code' => '',
                                'cv_id' => '',
                                'user_id2' => $txtSalesID,
                                'sales_type' => '',
                                'pt_id' => $pt_id
                            ]);

            }

            if ($txtDivision == 'K' && !$txtBranchHead) {

                $branch_office = DB::connection("sqlsrv2")
                                ->table('branch_office')
                                ->where('office_id','=', $txtSalesOffice)
                                ->update([
                                    'ka_cab' => strtoupper($txtSalesID),
                                    'pt_id' => $pt_id
                                ]);

                $sales1 = DB::connection("sqlsrv2")
                            ->table('sales')
                            ->where('office_id','=', $txtSalesOffice)
                            ->update([
                                'ka_cab' => strtoupper($txtSalesID)
                            ]);

                $sales2 = DB::connection("sqlsrv2")
                            ->table('sales')
                            ->insert([
                                'sales_id' => strtoupper($txtSalesID),
                                'nama' => strtoupper($txtSalesName),
                                'address1' => strtoupper($txtAddress),
                                'city' => $txtCity,
                                'propinsi' => $txtRegion,
                                'hp' => $txtPhone,
                                'active_flag' => 'Y',
                                'ka_cab' => strtoupper($txtSalesID),
                                'region' => $txtRegion,
                                'division' => $txtDivision,
                                's_age' => '',
                                'e_mail' => $txtEmail,
                                's_code' => '',
                                'office_id' => $txtSalesOffice,
                                'bank' => $txtBankAccount,
                                'rek_id' => $txtAccountName,
                                'idemployee' => '',
                                'target' => '',
                                'type_code' => '',
                                'cv_id' => '',
                                'user_id2' => $txtSalesID,
                                'sales_type' => '',
                                'pt_id' => $pt_id
                            ]);

            }

            if ($txtDivision == 'S') {

                $branch_office = DB::connection("sqlsrv2")
                                ->table('branch_office')
                                ->whereRaw('office_id in ('.$list_office_id.')')
                                ->update([
                                    'rm' => strtoupper($txtSalesID),
                                    'region' => strtoupper($txtRegionName),
                                    'pt_id' => $pt_id
                                ]);
            }

            if ($txtDivision != 'K') {

                $sales = DB::connection("sqlsrv2")
                            ->table('sales')
                            ->insert([
                                'sales_id' => strtoupper($txtSalesID),
                                'nama' => strtoupper($txtSalesName),
                                'address1' => strtoupper($txtAddress),
                                'city' => $txtCity,
                                'propinsi' => $txtRegion,
                                'hp' => $txtPhone,
                                'active_flag' => 'Y',
                                'ka_cab' => $txtBranchHead,
                                'region' => $txtRegion,
                                'division' => $txtDivision,
                                's_age' => '',
                                'e_mail' => $txtEmail,
                                's_code' => '',
                                'office_id' => $txtSalesOffice,
                                'bank' => $txtBankAccount,
                                'rek_id' => $txtAccountName,
                                'idemployee' => '',
                                'target' => '',
                                'type_code' => '',
                                'cv_id' => '',
                                'user_id2' => $txtSalesID,
                                'sales_type' => '',
                                'pt_id' => $pt_id
                            ]);
            }

            return response()->json(['response' => 'Sales Added']);

        }
        catch(QueryException $ex){
            $error = $ex->getMessage();
            return response()->json(['response' => $error]);
        }
        
        

    }




}
