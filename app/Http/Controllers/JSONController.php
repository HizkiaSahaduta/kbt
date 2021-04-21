<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class JSONController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    //Dashboard

    

    // Sales

    public function listDeptSales(){

        $result =DB::table('sec_group')
                ->select('group_id')
                ->whereIn('group_id', ['SALES', 'KACAB', 'RM'])
                ->distinct()
                ->get();

        return response()->json($result);

    }

    public function listCitySales(){

        $result =DB::connection("sqlsrv3")
                ->table('sales')
                ->select('kota')
                ->distinct()
                ->orderBY('kota')
                ->get();

        return response()->json($result);


    }

    public function listDivisionSales(){

        $result =DB::connection("sqlsrv3")
                ->table('division')
                ->select('class', 'descr')
                ->where('active_flag',  '=', 'Y')
                ->get();

        return response()->json($result);


    }

    public function listRegionSales(){

        $result =DB::connection("sqlsrv3")
                ->table('sales')
                ->select('region')
                ->where('active_flag',  '=', 'Y')
                ->distinct()
                ->get();

        return response()->json($result);

    }

    public function listSalesOffice(){

        $result =DB::connection("sqlsrv2")
                ->table('branch_office')
                ->select('office_id','office')
                ->where('pt_id',  '=', 'KBT')
                ->where('active_flag',  '=', 'Y')
                ->get();

        return response()->json($result);

    }

    public function listBranchHead($id){

        $result =DB::connection("sqlsrv2")
                ->table('branch_office')
                ->selectRaw('LTRIM(RTRIM(branch_office.ka_cab)) as ka_cab,  LTRIM(RTRIM(sales.nama)) as namasales')
                ->join('sales', 'branch_office.ka_cab', '=', 'sales.sales_id')
                ->where ('branch_office.office_id', '=', $id)
                ->where ('branch_office.pt_id', '=', 'KBT')
                ->where('sales.active_flag',  '=', 'Y')
                ->get();

        return response()->json($result);

    }

    public function listBankSales(){

        $result =DB::connection("sqlsrv3")
                ->table('account')
                ->select('bank_name')
                ->distinct()
                ->get();

        return response()->json($result);


    }

    public function checkRegion($id){

        $result =DB::connection("sqlsrv2")
                ->table('branch_office')
                ->selectRaw('LTRIM(RTRIM(branch_office.rm)) as rm')
                ->where ('office_id', '=', $id)
                ->value('rm');

        return response()->json($result);

    }

    public function getCust(Request $request){

        $search = $request->get('term');
        $result = DB::connection('sqlsrv2')
                    ->table('customer')
                    ->selectRaw("customer_id, LTRIM(RTRIM(nama)) as nama, CONCAT(address1, ' ', address2) as alamat, city")
                    ->where('nama', 'LIKE', '%'. $search. '%')
					->where('active_flag', '=', 'Y')
                    ->take(25)
                    ->get();

        return response()->json($result);
    }

    public function getCustID($id){
        $result = DB::connection('sqlsrv2')
                    ->table('customer')
                    ->selectRaw("customer_id, LTRIM(RTRIM(nama)) as nama, CONCAT(address1, ' ', address2) as alamat, city")
                    ->Where('customer_id', '=', $id)
                    ->first();
                    
        return response()->json($result);
    }

    public function getSalesByOffice($id){
        
        if($id != 0)
        {
            $result = DB::connection('sqlsrv2')
                        ->table('sales')
                        ->select('sales_id', 'nama')
                        ->where('office_id', '=', $id)
                        ->where('pt_id', '=', 'KBT')
                        ->where('active_flag','=','Y')
                        ->get();
            return response()->json($result);
        }
        else
        {
            $result = DB::connection('sqlsrv2')
                        ->table('sales')
                        ->select('sales_id', 'nama')
                        ->where('pt_id', '=', 'KBT')
                        ->where('active_flag','=','Y')
                        ->get();
            return response()->json($result);
        }
    }

    public function checkSalesId($id){
        $result = DB::connection('sqlsrv2')
                    ->table('sales')
                    ->Where('salesid', '=', $id)
                    ->value('salesid');

        return response()->json($result);
    }

    public function genSalesId(){

        $result = DB::connection('sqlsrv2')
                ->select(DB::raw("select 'S' + replicate('0',3-LEN(max(substring(sales_id,2,3) + 1 ))) + CONVERT(VARCHAR,max(substring(sales_id,2,3) + 1 )) as lastnum from sales"));

        return response()->json($result);
        
    }

    public function getOrderBySales($id){
        
        $result = DB::connection('sqlsrv2')
                ->table('order_mast')
                ->selectRaw('LTRIM(RTRIM(doc_id)) as doc_id')
                ->where('sales_id', '=', $id)
                ->groupBy('doc_id')
                ->get();

        return response()->json($result);           
    }

    public function getCustomerBySales($id) {

        $result =  DB::connection("sqlsrv2")
                    ->select(DB::raw("select LTRIM(RTRIM(a.customer_id)) as customer_id, LTRIM(RTRIM(b.nama)) as nama from order_mast a
                    inner join customer b on a.customer_id = b.customer_id
                    where a.sales_id = '$id' group by a.customer_id, b.nama"));

        return response()->json($result);                
    }

    public function getCustomerByOrder($id) {

        $result =  DB::connection("sqlsrv2")
                    ->select(DB::raw("select LTRIM(RTRIM(a.customer_id)) as customer_id, LTRIM(RTRIM(b.nama)) as nama from order_mast a
                    inner join customer b on a.customer_id = b.customer_id
                    where a.doc_id = '$id' group by a.customer_id, b.nama"));

        return response()->json($result);                
    }

    public function getCustomerBySalesOrder($a, $b) {

        $result =  DB::connection("sqlsrv2")
                    ->select(DB::raw("select LTRIM(RTRIM(a.customer_id)) as customer_id, LTRIM(RTRIM(b.nama)) as nama from order_mast a
                    inner join customer b on a.customer_id = b.customer_id
                    where a.sales_id = '$a' and a.doc_id = '$b' group by a.customer_id, b.nama"));

        return response()->json($result); 

    }


}
