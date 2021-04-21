<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class OrderReportController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $userid = Session::get('USERNAME');
        $salesid = Session::get('SALESID');
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
                                ->where('sales_id', '=', $salesid)
                                ->where('pt_id', '=', 'KBT')
                                ->where('active_flag', '=', 'Y')
                                ->get();

                $listorderid = DB::connection('sqlsrv2')
                                ->table('order_mast')
                                ->selectRaw('LTRIM(RTRIM(doc_id)) as doc_id')
                                ->where('sales_id', '=', $salesid)
                                ->groupBy('doc_id')
                                ->get();

                $listcustomer =  DB::connection("sqlsrv2")
                                ->select(DB::raw("select LTRIM(RTRIM(a.customer_id)) as customer_id, LTRIM(RTRIM(b.nama)) as nama from order_mast a
                                inner join customer b on a.customer_id = b.customer_id
                                where a.sales_id = '$salesid' group by a.customer_id, b.nama"));


                return view('layouts.OrderReport',['officeidlist' => $officeidlist, 'listsales' => $listsales, 'listorderid' => $listorderid, 'listcustomer' => $listcustomer]);

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

                $listorderid = DB::connection('sqlsrv2')
                                ->table('order_mast')
                                ->selectRaw('LTRIM(RTRIM(doc_id)) as doc_id')
                                ->groupBy('doc_id')
                                ->get();

                $listcustomer =  DB::connection("sqlsrv2")
                                ->select(DB::raw("select LTRIM(RTRIM(a.customer_id)) as customer_id, LTRIM(RTRIM(b.nama)) as nama from order_mast a
                                inner join customer b on a.customer_id = b.customer_id group by a.customer_id, b.nama"));

               return view('layouts.OrderReport',['officeidlist' => $officeidlist, 'listsales' => $listsales, 'listorderid' => $listorderid, 'listcustomer' => $listcustomer]);

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
			
				 $listorderid = DB::connection('sqlsrv2')
                                ->table('order_mast')
                                ->selectRaw('LTRIM(RTRIM(doc_id)) as doc_id')
                                ->groupBy('doc_id')
                                ->get();

                $listcustomer =  DB::connection("sqlsrv2")
                                ->select(DB::raw("select LTRIM(RTRIM(a.customer_id)) as customer_id, LTRIM(RTRIM(b.nama)) as nama from order_mast a
                                inner join customer b on a.customer_id = b.customer_id group by a.customer_id, b.nama"));

               return view('layouts.OrderReport',['officeidlist' => $officeidlist, 'listsales' => $listsales, 'listorderid' => $listorderid, 'listcustomer' => $listcustomer]);

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

                $listorderid = DB::connection('sqlsrv2')
                            ->table('order_mast')
                            ->selectRaw('LTRIM(RTRIM(doc_id)) as doc_id')
                            ->groupBy('doc_id')
                            ->get();

                $listcustomer = DB::connection("sqlsrv2")
                                ->select(DB::raw("select LTRIM(RTRIM(a.customer_id)) as customer_id, LTRIM(RTRIM(b.nama)) as nama from order_mast a
                                inner join customer b on a.customer_id = b.customer_id group by a.customer_id, b.nama"));

               return view('layouts.OrderReport',['officeidlist' => $officeidlist, 'listsales' => $listsales, 'listorderid' => $listorderid, 'listcustomer' => $listcustomer]);

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

                $listorderid = DB::connection('sqlsrv2')
                                ->table('order_mast')
                                ->selectRaw('LTRIM(RTRIM(doc_id)) as doc_id')
                                ->groupBy('doc_id')
                                ->get();

                $listcustomer = DB::connection("sqlsrv2")
                                ->select(DB::raw("select LTRIM(RTRIM(a.customer_id)) as customer_id, LTRIM(RTRIM(b.nama)) as nama from order_mast a
                                inner join customer b on a.customer_id = b.customer_id group by a.customer_id, b.nama"));

                return view('layouts.OrderReport',['officeidlist' => $officeidlist, 'listsales' => $listsales, 'listorderid' => $listorderid, 'listcustomer' => $listcustomer]);

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
    

                    $listorderid = DB::connection('sqlsrv2')
                                    ->table('order_mast')
                                    ->selectRaw('LTRIM(RTRIM(doc_id)) as doc_id')
                                    ->groupBy('doc_id')
                                    ->get();
    
                    $listcustomer = DB::connection("sqlsrv2")
                                    ->select(DB::raw("select LTRIM(RTRIM(a.customer_id)) as customer_id, LTRIM(RTRIM(b.nama)) as nama from order_mast a
                                    inner join customer b on a.customer_id = b.customer_id group by a.customer_id, b.nama"));
    
                    return view('layouts.OrderReport',['officeidlist' => $officeidlist, 'listsales' => $listsales, 'listorderid' => $listorderid, 'listcustomer' => $listcustomer]);

                break;
    

            default:
                return redirect('home')->with("alert", "You are not allowed to view this page");
        }

    }

    public function getOrderReportHeader (Request $request) {


        $txtOfficeID = $request->txtOfficeID;
        $txtSalesID = $request->txtSalesID;
        $txtOrderID = $request->txtOrderID;
        $txtCustomer = $request->txtCustomer;
        $txtOutstanding = $request->txtOutstanding;
        $txtStart = $request->txtStart;
        $txtEnd = $request->txtEnd;
        $where = "where 1=1";

        if ($txtOfficeID) {

            $where .= " and a.office_id = '$txtOfficeID'";

        }

        if ($txtSalesID) {

            $where .= " and a.sales_id = '$txtSalesID'";
            
        }

        if ($txtOrderID) {

            $where .= " and a.doc_id = '$txtOrderID'";
            
        }

        if ($txtCustomer) {

            $where .= " and a.customer_id = '$txtCustomer'";
            
        }

        if ($txtOutstanding) {

            if ($txtOutstanding == "N") {
                
                $where .= " and stat in ('C', 'K', 'S')";

            }

            if ($txtOutstanding == "Y") {
                
                $where .= " and stat not in ('C', 'K', 'X', 'S')";

            }
            
        }

        if ($txtStart && $txtEnd) {

            $where .= " and dt_trans between '$txtStart' and '$txtEnd'";
            
        }

        if ($txtStart && !$txtEnd) {

            $where .= " and dt_trans > '$txtStart'";
            
        }

        if (!$txtStart && $txtEnd) {

            $where .= " and dt_trans < '$txtEnd'";
            
        }


        $result =  DB::connection("sqlsrv2")
                        ->select(DB::raw("select LTRIM(RTRIM(b.nama)) as cust_name, 
                        LTRIM(RTRIM(a.doc_id)) as order_id,
                        LTRIM(RTRIM(a.po_id)) as po_id,
                        FORMAT(amt_pay, 'C', 'us-id') as amt_pay,
                        FORMAT(a.dt_trans, 'dd MMM yyyy') as dt_trans, 
                        FORMAT(a.due_date, 'dd MMM yyyy') as due_date,
                        LTRIM(RTRIM(c.nama)) as salesman,
                        a.stat,
                        FORMAT(a.dt_approved, 'dd MMM yyyy') as dt_approved,
                        CASE
                            WHEN dt_closed > '19000101' THEN FORMAT(a.dt_closed, 'dd MMM yyyy')
                            ELSE '-'
                        END AS dt_closed,
                        LTRIM(RTRIM(a.ship_to)) as ship_to
                        from order_mast a
                        inner join customer b on a.customer_id = b.customer_id
                        inner join sales c on a.sales_id = c.sales_id $where order by a.dt_trans desc"));

        return \DataTables::of($result)
            ->addColumn('Detail', function($data) {

                return '
                    <a href="javascript:void(0)" data-id1="'.$data->order_id.'" data-id2="'.$data->po_id.'" class="btn btn-info mb-2 mr-2 detailOrder">Detail</a>  
                    ';
                })
            ->rawColumns(['Detail'])
            ->make(true);



    }

    public function getOrderReportDetail (Request $request) {

        $txtOrderID = $request->txtOrderID;
        $txtPOID = $request->txtPOID;

        $result =  DB::connection("sqlsrv2")
                        ->select(DB::raw("select item_num, LTRIM(RTRIM(kka_sp)) as kka_sp,
                        LTRIM(RTRIM(article_desc)) as article_desc,
                        cast(ord_qty as float) as order_qty,
                        cast(order_deliv as float) as order_deliv,
                        cast(order_shipped as float) as order_shipped,
                        cast(order_retur as float) as order_retur,
                        cast(po_qty as float) as po_qty,
                        FORMAT(po_price, 'C', 'us-id') as po_price,
                        cast(po_rcv as float) as po_rcv,
                        cast(po_retur as float) as po_retur,
                        cast(kka_order as float) as kka_order,
                        cast(kka_plan as float) as kka_plan,
                        cast(kka_prod as float) as kka_prod,
                        cast(kka_wh as float) as kka_wh,
                        cast(kka_ship as float) as kka_ship,
                        cast(kka_retur as float) as kka_retur,
                        cast(kka_replace as float) as kka_replace,
                        kka_stat
                        from view_order_status_kka where order_id = '$txtOrderID' and po_id = '$txtPOID' order by item_num"));

        return \DataTables::of($result)
            ->make(true);



        



    }

}
