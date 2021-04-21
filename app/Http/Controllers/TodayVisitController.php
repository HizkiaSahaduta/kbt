<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class TodayVisitController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		
		if(!Session::has('mnuTodayVisit'))
        {
            return view('layouts.PageNotFound');
        }
		
        return view('layouts.TodayVisit');
    }

    public function getTodayVisit(){
        $salesid = Session::get('SALESID');
        $userid = Session::get('USERNAME');

        
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
                    ->where('a.salesid','=', $salesid)
                    ->whereRaw('a.tr_date >=DATEADD(day, DATEDIFF(day,0,GETDATE()),0) AND a.tr_date < DATEADD(day, DATEDIFF(day,0,GETDATE())+1,0)')
                    ->orderBy('a.tr_date', 'desc')
                    ->get();

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
