<?php

namespace App\Http\Controllers;
use Session;
use DB;

use Illuminate\Http\Request;

class DebtReportController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		
		if(!Session::has('mnuDebReport'))
        {
            return view('layouts.PageNotFound');
        }

        $vendor = DB::connection('sqlsrv2')
                    ->table('hutang_summary')
                    ->selectRaw("vendor_id, vendor_name, 
                                vendor_type, invoice, kwitansi,
                                payment, hutang,
                                (case when vendor_type = 'N' then 'NON COIL'
                                when vendor_type = 'E' then 'EKSPEDISI'
                                end) as vendor_type_desc")
                    ->orderBy('vendor_name', 'asc')
                    ->get();

        $currency = DB::connection('sqlsrv2')
                    ->table('hutang_summary')
                    ->select("curr_id")
                    ->distinct()
                    ->get();            

        return view('layouts.DebtReport', ['vendor' => $vendor, 'currency' => $currency]);
    }

    function find_debt(Request $request)
    {

        $txtVendor = $request->txtVendor;
        $txtCurrency = $request->txtCurrency;
        $sqlWhere = '1=1 ';

        if (!empty($txtVendor))
        {
            $sqlWhere = $sqlWhere . " and vendor_id = ". "LTRIM(RTRIM('" . $txtVendor . "'))";
        }

        if (!empty($txtCurrency))
        {
            $sqlWhere = $sqlWhere . " and curr_id = ". "LTRIM(RTRIM('" . $txtCurrency . "'))";
        }

        $result = DB::connection('sqlsrv2')
                    ->table('hutang_summary')
                    ->selectRaw("vendor_id, vendor_name,curr_id,
                                format(invoice, 'N0') as invoice,
                                format(kwitansi, 'N0') as kwitansi,
                                format(payment, 'N0') as payment,
                                format(hutang, 'N0') as hutang")
                    ->whereRaw($sqlWhere)
                    ->orderBy('vendor_name', 'asc')
                    ->get();       

        return \DataTables::of($result)
                        ->addColumn('Actions', function($result) {
                            return '<button type="button" data-toggle="modal" data-target="#DebtModal" id="DebtDtails" data-id="'.LTRIM(RTRIM($result->vendor_id)).'" class="btn btn-success">Details</a>';
                        })
                        ->rawColumns(['Actions'])
                        ->make(true);     

    }

    function debt_summary(Request $request)
    {

        $txtVendor = $request->txtVendor;
        $txtCurrency = $request->txtCurrency;
        $sqlWhere = '1=1 ';

        if (!empty($txtVendor))
        {
            $sqlWhere = $sqlWhere . " and vendor_id = ". "LTRIM(RTRIM('" . $txtVendor . "'))";
        }

        if (!empty($txtCurrency))
        {
            $sqlWhere = $sqlWhere . " and curr_id = ". "LTRIM(RTRIM('" . $txtCurrency . "'))";
        }

        $summaryDebt = DB::connection('sqlsrv2')
                    ->table('hutang_summary')
                    ->selectRaw("format(sum(invoice), 'N0') as invoice,
                                format(sum(kwitansi), 'N0') as kwitansi,
                                format(sum(payment), 'N0') as payment,
                                format(sum(hutang), 'N0') as hutang")
                    ->whereRaw($sqlWhere)
                    ->get();       
        
        return response()->json($summaryDebt);
        
    }

    function debt_detail(Request $request)
    {

        $txtVendor = $request->txtVendor;

        $summaryDetails = DB::connection('sqlsrv2')
                    ->table('hutang_detail')
                    ->selectRaw("vendor_name, tr_id, inv_id,
                                FORMAT(dt_inv, 'dd-MM-yyyy hh:mm tt') as dt_inv,
                                pay_term_desc,curr_id,
                                format(amt_subtotal, 'N0') as amt_subtotal,
                                format(amt_disc, 'N0') as amt_disc,
                                format(amt_ppn, 'N0') as amt_ppn,
                                format(amt_total, 'N0') as amt_total,
                                format(amt_kwitansi, 'N0') as amt_kwitansi,
                                format(amt_paid, 'N0') as amt_paid,
                                format(amt_paid_disc, 'N0') as amt_paid_disc,
                                format(hutang, 'N0') as hutang")
                    ->where('vendor_id', '=', $txtVendor)
                    ->get();

        return \DataTables::of($summaryDetails)
                    ->make(true); 
        
    }

}
