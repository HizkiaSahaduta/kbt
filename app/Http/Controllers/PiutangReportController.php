<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class PiutangReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		
		if(!Session::has('mnuPiutangReport'))
        {
            return view('layouts.PageNotFound');
        }

        $groupid = Session::get('GROUPID');
        $officeid = Session::get('OFFICEID');
        $salesid = Session::get('SALESID');
        $whereRaw = '1=1 ';

        if($groupid == "KACAB")
        {

            $office = DB::connection('sqlsrv2')
                                    ->table('branch_office')
                                    ->select('office_id','office')
                                    ->where('active_flag', '=', 'Y')
                                    ->where('office_id', '=', $officeid)
                                    ->get();

            $sales = DB::connection('sqlsrv2')
                                    ->table('Sales')
                                    ->select('sales_id','nama')
                                    ->where('active_flag', '=', 'Y')
                                    ->where('office_id', '=', $officeid)
                                    ->orderBy('NamaSales', 'asc')
                                    ->get();

            return view('layouts.PiutangReport', ['office' => $office, 'sales' => $sales]);

        }
        elseif($groupid == "SALES") 
        {

            $office = DB::connection('sqlsrv2')
                                    ->table('branch_office')
                                    ->select('office_id','office')
                                    ->where('active_flag', '=', 'Y')
                                    ->where('office_id', '=', $officeid)
                                    ->get();

            $sales = DB::connection('sqlsrv2')
                                    ->table('Sales')
                                    ->select('sales_id','nama')
                                    ->where('active_flag', '=', 'Y')
                                    ->where('sales_id', '=', $salesid)
                                    ->orderBy('nama', 'asc')
                                    ->get();

            return view('layouts.PiutangReport', ['office' => $office, 'sales' => $sales]);

        }
        else
        {
            $whereRaw = $whereRaw;

            $office = DB::connection('sqlsrv2')
                                    ->table('branch_office')
                                    ->select('office_id','office')
                                    ->where('active_flag', '=', 'Y')
                                    ->whereRaw($whereRaw)
                                    ->distinct()
                                    ->get();

            $sales = DB::connection('sqlsrv2')
                                    ->table('Sales')
                                    ->select('sales_id','nama')
                                    ->where('active_flag', '=', 'Y')
                                    ->whereRaw($whereRaw)
                                    ->orderBy('nama', 'asc')
                                    ->get();

            return view('layouts.PiutangReport', ['office' => $office, 'sales' => $sales]);

        }
		
    }
    
    public function find_invoices(Request $request)
    {

        $sqlWhere = "1=1 ";
        $orderByRaw = "tglFaktur asc";

        $txtOffID = $request->txtOffID;
        $txtSalesId = $request->txtSalesId;
        $txtCustomer = $request->txtCustomer;
        $txtOrderId = $request->txtOrderId;
        $txtFaktur = $request->txtFaktur;
        $rdStr = $request->rdStr;
        $start = $request->startDate;
        $end = $request->endDate;

        if (!empty($txtOffID))
        {
            $sqlWhere = $sqlWhere . " and office_id = " . "'" . $txtOffID . "'";
        }

        if (!empty($txtSalesId))
        {
            $sqlWhere = $sqlWhere . " and SalesId = " . "'" . $txtSalesId . "'";
        }

        if (!empty($txtCustomer))
        {
            $sqlWhere = $sqlWhere . " and CustomerId = " . "'" . $txtCustomer . "'";
        }

        if (!empty($txtOrderId))
        {
            $sqlWhere = $sqlWhere . " and CustomerOrderNo = " . "'" . $txtOrderId . "'";
        }

        if (!empty($txtFaktur))
        {
            $sqlWhere = $sqlWhere . " and faktur = " . "'" . $txtFaktur . "'";
        }

        if($rdStr == 'inv')
        {
            if (!empty($start))
            {
                if (!empty($end))
                {
                    $sqlWhere = $sqlWhere . " and tglfaktur >= '" .$start. "' AND tglfaktur <= '" . $end . "'";
                }
                else
                {
                    $sqlWhere = $sqlWhere . " and tglfaktur >= '" .$start. "'";
                }
            }

            if (!empty($end))
            {
                if (!empty($start))
                {
                    $sqlWhere = $sqlWhere . " and tglfaktur >= '" .$start. "' AND tglfaktur <= '" . $end . "'";
                }
                else
                {
                    $sqlWhere = $sqlWhere . " and tglfaktur <= '" .$end. "'";
                }
            }

        }

        if($rdStr == 'due')
        {
            if (!empty($start))
            {
                if (!empty($end))
                {
                    $sqlWhere = $sqlWhere . " and TglJTempo >= '" .$start. "' AND TglJTempo <= '" . $end . "'";
                    $orderByRaw = "TglJTempo asc";
                }
                else
                {
                    $sqlWhere = $sqlWhere . " and TglJTempo >= '" .$start. "'";
                    $orderByRaw = "TglJTempo asc";
                }
            }

            if (!empty($end))
            {
                if (!empty($start))
                {
                    $sqlWhere = $sqlWhere . " and TglJTempo >= '" .$start. "' AND TglJTempo <= '" . $end . "'";
                    $orderByRaw = "TglJTempo asc";
                }
                else
                {
                    $sqlWhere = $sqlWhere . " and TglJTempo <= '" .$end. "'";
                    $orderByRaw = "TglJTempo asc";
                }
            }

        }

        $result =  DB::connection('sqlsrv2')
                    ->table("v_piutang")
                    ->selectRaw("NamaCustomer,
                            CustomerOrderNo,
                            faktur,
                            FORMAT(tglfaktur, 'dd-MM-yyyy') as tglfaktur,
                            FORMAT(TglJTempo, 'dd-MM-yyyy') as TglJTempo,
                            FORMAT(NominalFaktur, 'N0') as NominalFaktur,
                            FORMAT(tagihan, 'N0') as tagihan,
                            FORMAT(bayar, 'N0') as bayar,
                            FORMAT(piutang, 'N0') as piutang")
                    ->whereRaw($sqlWhere)
                    ->orderByRaw($orderByRaw)
                    ->get();

        return \DataTables::of($result)
                            ->make(true);            

    }

    public function invoiceSummary(Request $request)
    {

        $sqlWhere = "1=1 ";

        $txtOffID = $request->txtOffID;
        $txtSalesId = $request->txtSalesId;
        $txtCustomer = $request->txtCustomer;
        $txtOrderId = $request->txtOrderId;
        $txtFaktur = $request->txtFaktur;
        $rdStr = $request->rdStr;
        $start = $request->startDate;
        $end = $request->endDate;

        if (!empty($txtOffID))
        {
            $sqlWhere = $sqlWhere . " and office_id = " . "'" . $txtOffID . "'";
        }

        if (!empty($txtSalesId))
        {
            $sqlWhere = $sqlWhere . " and SalesId = " . "'" . $txtSalesId . "'";
        }

        if (!empty($txtCustomer))
        {
            $sqlWhere = $sqlWhere . " and CustomerId = " . "'" . $txtCustomer . "'";
        }

        if (!empty($txtOrderId))
        {
            $sqlWhere = $sqlWhere . " and CustomerOrderNo = " . "'" . $txtOrderId . "'";
        }

        if (!empty($txtFaktur))
        {
            $sqlWhere = $sqlWhere . " and faktur = " . "'" . $txtFaktur . "'";
        }

        if($rdStr == 'inv')
        {
            if (!empty($start))
            {
                if (!empty($end))
                {
                    $sqlWhere = $sqlWhere . " and tglfaktur >= '" .$start. "' AND tglfaktur <= '" . $end . "'";
                }
                else
                {
                    $sqlWhere = $sqlWhere . " and tglfaktur >= '" .$start. "'";
                }
            }

            if (!empty($end))
            {
                if (!empty($start))
                {
                    $sqlWhere = $sqlWhere . " and tglfaktur >= '" .$start. "' AND tglfaktur <= '" . $end . "'";
                }
                else
                {
                    $sqlWhere = $sqlWhere . " and tglfaktur <= '" .$end. "'";
                }
            }
        }

        if($rdStr == 'due')
        {
            if (!empty($start))
            {
                if (!empty($end))
                {
                    $sqlWhere = $sqlWhere . " and TglJTempo >= '" .$start. "' AND TglJTempo <= '" . $end . "'";
                    $orderByRaw = "TglJTempo desc";
                }
                else
                {
                    $sqlWhere = $sqlWhere . " and TglJTempo >= '" .$start. "'";
                    $orderByRaw = "TglJTempo desc";
                }
            }

            if (!empty($end))
            {
                if (!empty($start))
                {
                    $sqlWhere = $sqlWhere . " and TglJTempo >= '" .$start. "' AND TglJTempo <= '" . $end . "'";
                    $orderByRaw = "TglJTempo desc";
                }
                else
                {
                    $sqlWhere = $sqlWhere . " and TglJTempo <= '" .$end. "'";
                    $orderByRaw = "TglJTempo desc";
                }
            }
        }

        $summaryInv =  DB::connection('sqlsrv2')
                    ->table("v_piutang")
                    ->selectRaw("format(sum(isnull(cast(Nominalfaktur as float),0)), 'N0') as totalFaktur, 
                                format(sum(isnull(cast(tagihan as float),0)), 'N0') as totalTagihan,
                                format(sum(isnull(cast(bayar as float),0)), 'N0') as totalBayar,
                                format(sum(isnull(cast(piutang as float),0)), 'N0') as totalPiutang")
                    ->whereRaw($sqlWhere)
                    ->first();

        return response()->json(['summaryInv' => $summaryInv]);  

    }

}
