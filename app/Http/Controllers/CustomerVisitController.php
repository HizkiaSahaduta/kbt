<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use DateTime;
use Carbon\Carbon;

class CustomerVisitController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
		
		if(!Session::has('mnuCustomerVisit'))
        {
            return view('layouts.PageNotFound');
        }
		
        return view('layouts.CustomerVisit');
    }
	
	public function checkLastVisit()
    {
		
		$salesid = strtoupper(Session::get('SALESID'));

		$min = 30;

		if($salesid)
		{
			$timeVisit = DB::connection('sqlsrv2')
					->table('web_SalesActivity')
					->selectRaw('DATEDIFF(MINUTE, tr_date, getDate()) AS MinuteDiff')
					->where('salesid', '=', $salesid)
					->orderBy('tr_date', 'desc')
					->take(1)
					->get();

			$result = $min - $timeVisit[0]->MinuteDiff;

			return response()->json($result);

		}
		
    }

    public function storeActivity(Request $request)
    {
        $txtusr = strtoupper(Session::get('USERNAME'));
        
		$salesid = strtoupper(Session::get('SALESID'));

		$customCheckbox1 = '';
		$customCheckbox2 = '';
		$customCheckbox3 = '';
		$customCheckbox4 = '';
		
		if ($request->customCheckbox1) 
		{
			$customCheckbox1 = 'Y';
		}
		else
		{
			$customCheckbox1 = 'N';
		}

		if ($request->customCheckbox2) 
		{
			$customCheckbox2 = 'Y';
		}
		else
		{
			$customCheckbox2 = 'N';
		}

		if ($request->customCheckbox3) 
		{
			$customCheckbox3 = 'Y';
		}
		else
		{
			$customCheckbox3 = 'N';
		}

		if ($request->customCheckbox4) 
		{
			$customCheckbox4 = 'Y';
		}
		else
		{
			$customCheckbox4 = 'N';
		}
		
		if ($request->customCheckbox5) 
		{
			$customCheckbox5 = 'Y';
		}
		else
		{
			$customCheckbox5 = 'N';
		}
		
		if($txtusr)
		{
			// $salesid = Session::get('SALESID');
			// $dt = new DateTime();
			// $dtime = $dt->format('dmYHi');
			$dtime = Carbon::now()->format('dhis');
			$trid = "";
			$txtCustId = $request->input('customerid');

			if(empty($request->input('customerid'))){
				$trid = $salesid . $dtime . "NEW";
				$txtCustId = "NEWCUST".$salesid.$dtime;
			}
			else
			{
				$trid = $salesid . $dtime . substr($txtCustId, -3);
			}

			$save = DB::connection('sqlsrv2')
				->table('web_SalesActivity')
				->insert([
				'mill_id' => 'KP',
				'tr_id' => $trid,
				'salesid' => $salesid,
				'customerid' => $txtCustId,
				'namacustomer' => $request->input('customername'),
				'alamat' => $request->input('customeraddress'),
				'city' => $request->input('customercity'),
				'sales_latitude' => $request->input('Latitude'),
				'sales_longitude' => $request->input('Longitude'),
				'lt_location' => $request->input('Address'),
				'remark' => $request->input('remark'),
				'user_id' => $txtusr,
				'presentasi' => $customCheckbox1,
				'takingorder' => $customCheckbox2,
				'info' => $customCheckbox3,
				'penagihan' => $customCheckbox4,
				'maintenance' => $customCheckbox5
				]);
		}
		else
		{
			Auth::logout();
			Session::flush();
			return redirect('login');
		}

	
    }
    
}
