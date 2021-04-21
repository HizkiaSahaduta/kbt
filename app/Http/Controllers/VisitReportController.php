<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class VisitReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		
		if(!Session::has('mnuActivityReport'))
        {
            return view('layouts.PageNotFound');
        }

        $userid = Session::get('USERNAME');
        $groupid = Session::get('GROUPID');
        $officeid = Session::get('OFFICEID');

        switch ($groupid) {

            case "SALES":

                $officeidlist = DB::connection('sqlsrv2')
                                ->table('branch_office')
                                ->select('office_id', 'office')
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->where('office_id', '=', $officeid)
                                ->get();

                $listsales = DB::connection('sqlsrv2')
                                ->table('Sales')
                                ->select('sales_id', 'office_id', 'nama')
                                ->where('sales_id', '=', $userid)
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->get();

                return view('layouts.VisitReport',['officeidlist' => $officeidlist, 'listsales' => $listsales]);
            break;

            case "KACAB":

                $officeidlist = DB::connection('sqlsrv2')
                                ->table('branch_office')
                                ->select('office_id', 'office')
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->where('office_id', '=', $officeid)
                                ->orderBy('office_id', 'ASC')
                                ->get();

                $listsales = DB::connection('sqlsrv2')
                                ->table('Sales')
                                ->select('sales_id', 'office_id', 'nama')
                                ->Where('office_id', '=', $officeid)
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->get();

                return view('layouts.VisitReport',['officeidlist' => $officeidlist, 'listsales' => $listsales]);
            break;
			
			case "RM":
			
                $region = Session::get('REGIONID');
                
                $offRegion = DB::connection("sqlsrv2")
                                ->table('branch_office')
                                ->select('office_id')
                                ->where('pt_id', '=', 'KBT')
                                ->where('rm','=', Session::get('SALESID'))
                                ->pluck('office_id')
                                ->toArray();
			
				$officeidlist = DB::connection('sqlsrv2')
                                ->table('branch_office')
                                ->select('office_id', 'office')
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->where('region', '=', $region)
                                ->orderBy('office_id', 'ASC')
                                ->get();
								
				$listsales = DB::connection('sqlsrv2')
                                ->table('Sales')
                                ->select('sales_id', 'office_id', 'nama')
                                ->whereIn('office_id', $offRegion)
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->get();
			
				return view('layouts.VisitReport',['officeidlist' => $officeidlist, 'listsales' => $listsales]);
			break;

            case "DEVELOPMENT":

                $officeidlist = DB::connection('sqlsrv2')
                                ->table('branch_office')
                                ->select('office_id', 'office')
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->orderBy('office_id', 'ASC')
                                ->get();

                $listsales = DB::connection('sqlsrv2')
                                ->table('Sales')
                                ->select('sales_id', 'office_id', 'nama')
                                // ->whereNotIn('salesid', ['tes1','tes2','tes3'])
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->orderBy('nama', 'ASC')
                                ->get();


                return view('layouts.VisitReport',['officeidlist' => $officeidlist, 'listsales' => $listsales]);
                break;


            case "FINANCE":

                $officeidlist = DB::connection('sqlsrv2')
                                ->table('branch_office')
                                ->select('office_id', 'office')
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->orderBy('office_id', 'ASC')
                                ->get();

                $listsales = DB::connection('sqlsrv2')
                                ->table('Sales')
                                ->select('sales_id', 'office_id', 'nama')
                                // ->whereNotIn('salesid', ['tes1','tes2','tes3'])
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->orderBy('nama', 'ASC')
                                ->get();


                return view('layouts.VisitReport',['officeidlist' => $officeidlist, 'listsales' => $listsales]);
                break;

            case "MANAGEMENT":

                    $officeidlist = DB::connection('sqlsrv2')
                                    ->table('branch_office')
                                    ->select('office_id', 'office')
                                    ->where('pt_id', '=', 'KBT')
                                    ->where('active_flag', '=', 'Y')
                                    ->orderBy('office_id', 'ASC')
                                    ->get();
    
                    $listsales = DB::connection('sqlsrv2')
                                    ->table('Sales')
                                    ->select('sales_id', 'office_id', 'nama')
                                    // ->whereNotIn('salesid', ['tes1','tes2','tes3'])
                                    ->where('pt_id', '=', 'KBT')
                                    ->where('active_flag', '=', 'Y')
                                    ->orderBy('nama', 'ASC')
                                    ->get();
    
    
                    return view('layouts.VisitReport',['officeidlist' => $officeidlist, 'listsales' => $listsales]);
                    break;
    

            default:
                return redirect('home')->with("alert", "You are not allowed to view this page");
        }

    }

    public function GetVisit(Request $request){

        $userid = Session::get('USERNAME');
        $groupid = trim(Session::get('GROUPID'));
        $sqlWhere = "1=1";

        $txtOffID = $request->txtOffID;
        if(!$txtOffID)
        {
            $txtOffID = '';
        }

        $salesid = $request->salesid;
        if(!$salesid)
        {
            $salesid = '';
        }

        $start_date = $request->start_date;
        if(!$start_date)
        {
            $start_date = '';
        }

        $end_date = $request->end_date;
        if(!$end_date)
        {
            $end_date = '';
        }


        if ($txtOffID)
        {
            $sqlWhere .= " and b.office_id = " . "'" . $txtOffID . "'";
        }

        if ($salesid)
        {
            $sqlWhere .= " and a.salesid = " . "'" . $salesid . "'";
        }

        if ($start_date)
        {
            if ($end_date)
            {
                $sqlWhere .= " and a.tr_date BETWEEN CONVERT(datetime,'" .$start_date. "') AND CONVERT(datetime,'" . $end_date . " 23:59:59:999')";
            }
            else
            {
                $sqlWhere .= " and a.tr_date BETWEEN CONVERT(datetime,'" .$start_date. "') AND CONVERT(datetime,'" . $start_date . " 23:59:59:999')";
            }
        }

        $vResult =  DB::connection("sqlsrv2")
                    ->table("web_SalesActivity as a")
                    ->selectRaw("a.salesid, a.customerid, a.namacustomer, b.nama,
                            a.alamat, a.city, FORMAT(a.tr_date, 'dd MMM yyyy HH:m:ss') as tr_date,
                            a.lt_location, a.today_order,a.remark,
                            b.office_id,a.sales_latitude,a.sales_longitude,
                            case when a.presentasi='Y' then 'Penawaran Produk-' else '' end +
                            case when a.takingorder='Y' then 'Taking Order-' else '' end +
                            case when a.info='Y' then 'Info Program/Hadiah-' else '' end +
                            case when a.penagihan='Y' then 'Penagihan-' else '' end +
                            case when a.maintenance='Y' then 'Cust.Maintenance-' else '' end as activity
                            ")
                    ->join("Sales as b","a.salesid", "=", "b.sales_id")
                    ->whereRaw(" $sqlWhere ")
                    ->orderBy("a.tr_date", "DESC")
                    ->get();
        
        //  $vResultArray = $vResult->toArray();

        // dd($vResult);

        return \DataTables::of($vResult)
                        ->editColumn('Activity', function ($data) {
                            
                            $str = explode("-",$data->activity);
                            $count = count($str);
                            $result = '';
                            foreach($str as $str) {
                                if ($count > 2) {

                                    if ($str == 'Penawaran Produk') {
                                        $result .= '<span class="shadow-none badge badge-info">'.$str.'</span><br>';
                                    }
                                    if ($str == 'Taking Order') {
                                        $result .= '<span class="shadow-none badge badge-success">'.$str.'</span><br>';
                                    } 
                                    if ($str == 'Info Program/Hadiah') {
                                        $result .= '<span class="shadow-none badge badge-primary">'.$str.'</span><br>';
                                    } 
                                    if ($str == 'Penagihan') {
                                        $result .= '<span class="shadow-none badge badge-danger">'.$str.'</span><br>';
                                    }  
                                    if ($str == 'Cust.Maintenance') {
                                        $result .= '<span class="shadow-none badge badge-warning">'.$str.'</span><br>';
                                    } 
                                    
                                }
                                else{
                                    
                                    if ($str == 'Penawaran Produk') {
                                        $result .= '<span class="shadow-none badge badge-info">'.$str.'</span><br>';
                                    }
                                    if ($str == 'Taking Order') {
                                        $result .= '<span class="shadow-none badge badge-success">'.$str.'</span><br>';
                                    } 
                                    if ($str == 'Info Program/Hadiah') {
                                        $result .= '<span class="shadow-none badge badge-primary">'.$str.'</span><br>';
                                    } 
                                    if ($str == 'Penagihan') {
                                        $result .= '<span class="shadow-none badge badge-danger">'.$str.'</span><br>';
                                    }  
                                    if ($str == 'Cust.Maintenance') {
                                        $result .= '<span class="shadow-none badge badge-warning">'.$str.'</span><br>';
                                    } 
                                }
                            }
                            return $result;
                            
                        })
                        ->addColumn('ViewMap', function($data) {
                            return '<button class="btn btn-sm btn-primary showModal" data-toggle="modal" data-target="#myModal" onclick="showMap('.$data->sales_latitude.','.$data->sales_longitude.')">View Maps</button>';
                        })
                        ->rawColumns([ 'Activity','ViewMap'])
                        ->make(true);

    }



}