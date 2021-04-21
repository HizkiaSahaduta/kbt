<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;

class HomeController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){

      // $curr = Carbon::now();
      $month =  date("F", mktime(0, 0, 0, Carbon::now()->month, 1));
    //   $subMonth = "February";
      $subMonth = date("F", mktime(0, 0, 0, Carbon::now()->subMonth()->month, 1));
      $year =  Carbon::now()->year;
      $subYear =  Carbon::now()->subYear()->year;
      $subYear2 =  Carbon::now()->subYear(2)->year;
      $num_month =  Carbon::now()->month;
    //   $num_subMonth = Carbon::now()->subMonth()->month;
      $num_subMonth = 2;
      return view('layouts.Home',['num_month' => $num_month, 'num_subMonth' => $num_subMonth, 'year' => $year, 'subYear' => $subYear, 'subYear2' => $subYear2, 'month' => strtoupper($month), 'subMonth' => strtoupper($subMonth)]);
        
    }

    public function getDashboardItems(){

        $groupid = Session::get('GROUPID');
        $officeid = Session::get('OFFICEID');
        $salesid = Session::get('SALESID');
        $region = Session::get('REGIONID');
        $year =  Carbon::now()->year;
        $subYear =  Carbon::now()->subYear()->year;
        $month =  Carbon::now()->month;
        // $subMonth = 2;
        $subMonth = Carbon::now()->subMonth()->month;
        $whereRaw = '1=1 ';
		$whereRawJoin = '1=1 ';

        if($groupid == "RM") 
        {
            $offRegion = DB::connection("sqlsrv2")
                        ->table('branch_office')
                        ->select('office_id')
                        ->where('region','=', $region)
                        ->pluck('office_id')
                        ->toArray();
                        
            $regionList = implode(",", $offRegion);
                        
			$whereRawJoin = $whereRawJoin . "and a.office_id in (".$regionList.")";
            $whereRaw = $whereRaw . "and office_id in (".$regionList.")";
        }
        elseif($groupid == "KACAB") 
        {
			$whereRawJoin = $whereRawJoin . "and a.office_id = '".$officeid."'";
            $whereRaw = $whereRaw . "and office_id = '".$officeid."'";

        }
        elseif($groupid == "SALES") 
        {
			$whereRawJoin = $whereRawJoin . "and a.office_id = '".$officeid."' and a.salesman_id = '".$salesid."'";
            $whereRaw = $whereRaw . "and office_id = '".$officeid."' and salesman_id = '".$salesid."'";
        }
        else
        {
            $whereRaw = $whereRaw;
        }

        // ======================================================================== //
        if ($subMonth = 12) {
            // $year = Carbon::now()->subYear()->year;

            $invThisYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_invoice')
                                ->selectRaw("format(sum(amt_total), 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', $subYear)
                                ->whereRaw($whereRaw)
                                ->first();

            $countInvThisYearSubMonth = DB::connection("sqlsrv2")
                                    ->table('dashboard_invoice')
                                    ->selectRaw("format(sum(count_inv), 'N0') as total")
                                    ->where('month', '=', $subMonth)
                                    ->where('year', '=', $subYear)
                                    ->whereRaw($whereRaw)
                                    ->first();

            $wgtInvThisYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_invoice')
                                ->selectRaw("format(sum(wgt_inv)/1000, 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', $subYear)
                                ->whereRaw($whereRaw)
                                ->first();
        }

        else {

            $invThisYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_invoice')
                                ->selectRaw("format(sum(amt_total), 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', $year)
                                ->whereRaw($whereRaw)
                                ->first();

            $countInvThisYearSubMonth = DB::connection("sqlsrv2")
                                    ->table('dashboard_invoice')
                                    ->selectRaw("format(sum(count_inv), 'N0') as total")
                                    ->where('month', '=', $subMonth)
                                    ->where('year', '=', $year)
                                    ->whereRaw($whereRaw)
                                    ->first();

            $wgtInvThisYearSubMonth = DB::connection("sqlsrv2")
                                    ->table('dashboard_invoice')
                                    ->selectRaw("format(sum(wgt_inv)/1000, 'N0') as total")
                                    ->where('month', '=', $subMonth)
                                    ->where('year', '=', $year)
                                    ->whereRaw($whereRaw)
                                    ->first();
        }


        // ======================================================================== //

        $invSubYearSubMonth = DB::connection("sqlsrv2")
                            ->table('dashboard_invoice')
                            ->selectRaw("format(sum(amt_total), 'N0') as total")
                            ->where('month', '=', $subMonth)
                            ->where('year', '=', Carbon::now()->subYear(2)->year)
                            ->whereRaw($whereRaw)
                            ->first();

        $countInvSubYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_invoice')
                                ->selectRaw("format(sum(count_inv), 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', Carbon::now()->subYear(2)->year)
                                ->whereRaw($whereRaw)
                                ->first();

        $wgtInvSubYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_invoice')
                                ->selectRaw("format(sum(wgt_inv)/1000, 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', Carbon::now()->subYear(2)->year)
                                ->whereRaw($whereRaw)
                                ->first();

        // ======================================================================== //

        if ($subMonth = 12) {
            
            // $year = Carbon::now()->subYear()->year;

                                 
            $orderThisYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_order')
                                ->selectRaw("format(sum(total_order), 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', $subYear)
                                ->whereRaw($whereRaw)
                                ->first();

            $countOrderThisYearSubMonth = DB::connection("sqlsrv2")
                                    ->table('dashboard_order')
                                    ->selectRaw("format(sum(count_order), 'N0') as total")
                                    ->where('month', '=', $subMonth)
                                    ->where('year', '=', $subYear)
                                    ->whereRaw($whereRaw)
                                    ->first();      


            $wgtThisYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_order')
                                ->selectRaw("format(sum(wgt_order)/1000, 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', $subYear)
                                ->whereRaw($whereRaw)
                                ->first();
        }

        else {

            $orderThisYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_order')
                                ->selectRaw("format(sum(total_order), 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', $year)
                                ->whereRaw($whereRaw)
                                ->first();

            $countOrderThisYearSubMonth = DB::connection("sqlsrv2")
                                    ->table('dashboard_order')
                                    ->selectRaw("format(sum(count_order), 'N0') as total")
                                    ->where('month', '=', $subMonth)
                                    ->where('year', '=', $year)
                                    ->whereRaw($whereRaw)
                                    ->first();      


            $wgtThisYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_order')
                                ->selectRaw("format(sum(wgt_order)/1000, 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', $year)
                                ->whereRaw($whereRaw)
                                ->first();
        }


    // ======================================================================== //


        $orderSubYearSubMonth = DB::connection("sqlsrv2")
                            ->table('dashboard_order')
                            ->selectRaw("format(sum(total_order), 'N0') as total")
                            ->where('month', '=', $subMonth)
                            ->where('year', '=', Carbon::now()->subYear(2)->year)
                            ->whereRaw($whereRaw)
                            ->first();

        $countOrderSubYearSubMonth = DB::connection("sqlsrv2")
                                ->table('dashboard_order')
                                ->selectRaw("format(sum(count_order), 'N0') as total")
                                ->where('month', '=', $subMonth)
                                ->where('year', '=', Carbon::now()->subYear(2)->year)
                                ->whereRaw($whereRaw)
                                ->first();

        $wgtSubYearSubMonth = DB::connection("sqlsrv2")
                            ->table('dashboard_order')
                            ->selectRaw("format(sum(wgt_order)/1000, 'N0') as total")
                            ->where('month', '=', $subMonth)
                            ->where('year', '=', Carbon::now()->subYear(2)->year)
                            ->whereRaw($whereRaw)
                            ->first();


        // ======================================================================== //



        $orderThisYear = DB::connection("sqlsrv2")
                    ->table('dashboard_order')
                    ->selectRaw("format(sum(total_order), 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->whereRaw($whereRaw)
                    ->first();

        $countOrderThisYear = DB::connection("sqlsrv2")
                    ->table('dashboard_order')
                    ->selectRaw("format(sum(count_order), 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->whereRaw($whereRaw)
                    ->first();

       

        $orderSubYear = DB::connection("sqlsrv2")
                    ->table('dashboard_order')
                    ->selectRaw("format(sum(total_order), 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $subYear)
                    ->whereRaw($whereRaw)
                    ->first();

        $countOrderSubYear = DB::connection("sqlsrv2")
                    ->table('dashboard_order')
                    ->selectRaw("format(sum(count_order), 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $subYear)
                    ->whereRaw($whereRaw)
                    ->first();

        $wgtThisYear = DB::connection("sqlsrv2")
                    ->table('dashboard_order')
                    ->selectRaw("format(sum(wgt_order)/1000, 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->whereRaw($whereRaw)
                    ->first();

        $wgtSubYear = DB::connection("sqlsrv2")
                    ->table('dashboard_order')
                    ->selectRaw("format(sum(wgt_order)/1000, 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $subYear)
                    ->whereRaw($whereRaw)
                    ->first();

        $invThisYear = DB::connection("sqlsrv2")
                    ->table('dashboard_invoice')
                    ->selectRaw("format(sum(amt_total), 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->whereRaw($whereRaw)
                    ->first();

        $countInvThisYear = DB::connection("sqlsrv2")
                    ->table('dashboard_invoice')
                    ->selectRaw("format(sum(count_inv), 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->whereRaw($whereRaw)
                    ->first();

        $invSubYear = DB::connection("sqlsrv2")
                    ->table('dashboard_invoice')
                    ->selectRaw("format(sum(amt_total), 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $subYear)
                    ->whereRaw($whereRaw)
                    ->first();

        $countInvSubYear = DB::connection("sqlsrv2")
                    ->table('dashboard_invoice')
                    ->selectRaw("format(sum(count_inv), 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $subYear)
                    ->whereRaw($whereRaw)
                    ->first();


        $wgtInvThisYear = DB::connection("sqlsrv2")
                    ->table('dashboard_invoice')
                    ->selectRaw("format(sum(wgt_inv)/1000, 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->whereRaw($whereRaw)
                    ->first();


        $wgtInvSubYear = DB::connection("sqlsrv2")
                    ->table('dashboard_invoice')
                    ->selectRaw("format(sum(wgt_inv)/1000, 'N0') as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $subYear)
                    ->whereRaw($whereRaw)
                    ->first();
                
        

        // $activeOutletThisMonth = DB::connection("sqlsrv2")
        //             ->table('dashboard_order as a')
        //             ->leftJoin('dashboard_new_customer as b', function($join)
        //             {
        //                 $join->on('a.office_id', '=', 'b.office_id');
        //                 $join->on('a.salesman_id', '=', 'b.salesman');
        //                 $join->on('a.month', '=', 'b.cMonth');
        //                 $join->on('a.year', '=', 'b.cYear');
        //             })
        //             ->leftJoin('branch_office as c', 'c.office_id', '=', 'a.office_id')
        //             ->selectRaw('c.office,a.office_id,a.year,a.month,isnull(sum(a.count_customer), 0) as activeOutlet,isnull(sum(b.count_customer), 0) as total')
        //             ->where('month', '=', $month)
        //             ->where('year', '=', $year)
        //             ->whereRaw($whereRawJoin)
        //             ->groupBy('c.office', 'a.office_id' ,'a.year', 'a.month')
        //             ->first();

        // $newCustomerThisMonth = DB::connection("sqlsrv2")
        //             ->table('dashboard_order as a')
        //             ->leftJoin('dashboard_new_customer as b', function($join)
        //             {
        //                 $join->on('a.office_id', '=', 'b.office_id');
        //                 $join->on('a.salesman_id', '=', 'b.salesman');
        //                 $join->on('a.month', '=', 'b.cMonth');
        //                 $join->on('a.year', '=', 'b.cYear');
        //             })
        //             ->selectRaw('sum(b.count_customer) as total')
        //             ->where('month', '=', $month)
        //             ->where('year', '=', $year)
        //             ->whereRaw($whereRawJoin)
        //             ->first();

        // $activeOutletSubMonth = DB::connection("sqlsrv2")
        //             ->table('dashboard_order as a')
        //             ->leftJoin('dashboard_new_customer as b', function($join)
        //             {
        //                 $join->on('a.office_id', '=', 'b.office_id');
        //                 $join->on('a.salesman_id', '=', 'b.salesman');
        //                 $join->on('a.month', '=', 'b.cMonth');
        //                 $join->on('a.year', '=', 'b.cYear');
        //             })
        //             ->leftJoin('branch_office as c', 'c.office_id', '=', 'a.office_id')
        //             ->selectRaw('c.office,a.office_id,a.year,a.month,isnull(sum(a.count_customer), 0) as activeOutlet,isnull(sum(b.count_customer), 0) as total')
        //             ->where('month', '=', $subMonth)
        //             ->where('year', '=', $year)
        //             ->whereRaw($whereRawJoin)
        //             ->groupBy('c.office', 'a.office_id' ,'a.year', 'a.month')
        //             ->first();

        // $newCustomerSubMonth = DB::connection("sqlsrv2")
        //             ->table('dashboard_order as a')
        //             ->leftJoin('dashboard_new_customer as b', function($join)
        //             {
        //                 $join->on('a.office_id', '=', 'b.office_id');
        //                 $join->on('a.salesman_id', '=', 'b.salesman');
        //                 $join->on('a.month', '=', 'b.cMonth');
        //                 $join->on('a.year', '=', 'b.cYear');
        //             })
        //             ->selectRaw('sum(b.count_customer) as total')
        //             ->where('month', '=', $subMonth)
        //             ->where('year', '=', $year)
        //             ->whereRaw($whereRawJoin)
        //             ->first();

        if($orderThisYear->total != null && $orderSubYear->total != null)
        {
            $orderPercent = number_format((( (int)$orderThisYear->total / (int)$orderSubYear->total) * 100) - 100, 2);
        }
        else
        {
            $orderPercent = '0';
        }

        if($orderThisYearSubMonth->total != null && $orderSubYearSubMonth->total != null)
        {
            $orderPercentSub = number_format((( (int)$orderThisYearSubMonth->total / (int)$orderSubYearSubMonth->total) * 100) - 100, 2);
        }
        else
        {
            $orderPercentSub = '0';
        }
        
        // echo $year;

        return response()->json(['orderThisYear' => $orderThisYear,
                                'countOrderThisYear' => $countOrderThisYear,
                                'orderThisYearSubMonth' => $orderThisYearSubMonth,
                                'countOrderThisYearSubMonth' => $countOrderThisYearSubMonth,
                                'orderSubYear' => $orderSubYear,
                                'countOrderSubYear' => $countOrderSubYear,
                                'orderSubYearSubMonth' => $orderSubYearSubMonth,
                                'countOrderSubYearSubMonth' => $countOrderSubYearSubMonth,
                                'wgtThisYear' => $wgtThisYear,
                                'wgtThisYearSubMonth' => $wgtThisYearSubMonth,
                                'wgtSubYear' => $wgtSubYear,
                                'wgtSubYearSubMonth' => $wgtSubYearSubMonth,
                                'invThisYear' => $invThisYear,
                                'countInvThisYear' => $countInvThisYear,
                                'invThisYearSubMonth' => $invThisYearSubMonth,
                                'countInvThisYearSubMonth' => $countInvThisYearSubMonth,
                                'invSubYear' => $invSubYear,
                                'countInvSubYear' => $countInvSubYear,
                                'invSubYearSubMonth' => $invSubYearSubMonth,
                                'countInvSubYearSubMonth' => $countInvSubYearSubMonth,
                                'wgtInvThisYear' => $wgtInvThisYear,
                                'wgtInvThisYearSubMonth' => $wgtInvThisYearSubMonth,
                                'wgtInvSubYear' => $wgtInvSubYear,
                                'wgtInvSubYearSubMonth' => $wgtInvSubYearSubMonth,
                                // 'activeOutletThisMonth' => $activeOutletThisMonth,
                                // 'newCustomerThisMonth' => $newCustomerThisMonth,
                                // 'activeOutletSubMonth' => $activeOutletSubMonth,
                                // 'newCustomerSubMonth' => $newCustomerSubMonth,
                                'orderPercent' => $orderPercent,
                                'orderPercentSub' => $orderPercentSub
                                ]);

    }

    public function getOrderThisYearLastMonth(){

        $groupid = Session::get('GROUPID');
        $officeid = Session::get('OFFICEID');
        $salesid = Session::get('SALESID');
        $month =  Carbon::now()->subMonth()->month;
        $year =  Carbon::now()->year;
        $whereRaw = '1=1 ';

        if($groupid == "RM") 
        {

            $offRegion = DB::connection("sqlsrv2")
                        ->table('branch_office')
                        ->select('office_id')
                        ->where('rm','=', $salesid)
                        ->pluck('office_id')
                        ->toArray();

            $whereRaw = $whereRaw . "and office_id in (".$offRegion.")";

            // return response()->json($result);
        }
        elseif($groupid == "KACAB") 
        {

            $whereRaw = $whereRaw . "and office_id = '".$officeid."'";

        }
        elseif($groupid == "SALES") 
        {

            $whereRaw = $whereRaw . "and office_id = '".$officeid."' and salesman_id = '".$salesid."'";

        }
        // else
        // {

        //     return response()->json('error');
        // }

        $result = DB::connection("sqlsrv2")
                    ->table('dashboard_order')
                    ->selectRaw("format(sum(total_order), 'N0')  as total")
                    ->where('month', '=', $month)
                    ->where('year', '=', $year)
                    ->whereRaw($whereRaw)
                    ->first();

        return response()->json($result);

    }

    public function getDashboardOrderLastYear(){


        $month =  Carbon::now()->subMonth()->month;
        $year =  Carbon::now()->subYear()->year;

        $session = Session::get('GROUPID');
        $officeid = Session::get('OFFICEID');

        switch($session)
        {
            case 'DEVELOPMENT';

            $DashboardOrder = DB::connection("sqlsrv2")
                        ->select(DB::raw("select month,year,sum(total_order) as total from (
                            select month,year,total_order  from  dashboard_order 
                            where year=".$year."
                            union all
                            select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                            group by month,year
                            order by month"));

            return response()->json($DashboardOrder);

            break;

            case 'FINANCE';

            $DashboardOrder = DB::connection("sqlsrv2")
                        ->select(DB::raw("select month,year,sum(total_order) as total from (
                            select month,year,total_order  from  dashboard_order 
                            where year=".$year."
                            union all
                            select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                            group by month,year
                            order by month"));

            return response()->json($DashboardOrder);

            break;

            case 'MANAGEMENT';

                $DashboardOrder = DB::connection("sqlsrv2")
                                ->select(DB::raw("select month,year,sum(total_order) as total from (
                                select month,year,total_order  from  dashboard_order 
                                where year=".$year."
                                union all
                                select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                                group by month,year
                                order by month"));

                return response()->json($DashboardOrder);
            break;

            case 'RM';

                $region = Session::get('REGIONID');

                $offRegion = DB::connection("sqlsrv2")
                            ->table('branch_office')
                            ->select('office_id')
                            ->where('region','=', $region)
                            ->pluck('office_id')
                            ->toArray();

                $offRegionList = implode(',',$offRegion);

                $DashboardOrder = DB::connection("sqlsrv2")
                                ->select(DB::raw("select month,year,sum(total_order) as total from (
                                select month,year,total_order  from  dashboard_order 
                                where office_id in (".$offRegionList.") and year=".$year."
                                union all
                                select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                                group by month,year
                                order by month"));

                return response()->json($DashboardOrder);
            break;

            case 'KACAB';

                $DashboardOrder = DB::connection("sqlsrv2")
                                ->select(DB::raw("select month,year,sum(total_order) as total from (
                                select month,year,total_order  from  dashboard_order 
                                where office_id='".$officeid."' and year=".$year."
                                union all
                                select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                                group by month,year
                                order by month"));

                return response()->json($DashboardOrder);
            break;

            case 'SALES';

                $DashboardOrder = DB::connection("sqlsrv2")
                                ->select(DB::raw("select month,year,sum(total_order) as total from (
                                select month,year,total_order  from  dashboard_order 
                                where salesman_id='".Session::get('SALESID')."' and year=".$year."
                                union all
                                select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                                group by month,year
                                order by month"));

                return response()->json($DashboardOrder);
            break;

        }
        
    }

    public function getDashboardOrderThisYear(){

        $month = Carbon::now()->month;
        $year =  Carbon::now()->year;

        $session = Session::get('GROUPID');
        $officeid = Session::get('OFFICEID');

        // echo "select month,year,sum(total_order) as total from (select month,year,total_order from  dashboard_order  where year=".$year."union all select distinct month,".$year." year,0 total_order from  dashboard_order ) x group by month,year order by month";

        switch($session)
        {
            case 'DEVELOPMENT';

                $DashboardOrder = DB::connection("sqlsrv2")
                            ->select(DB::raw("select month,year,sum(total_order) as total from (
                                select month,year,total_order  from  dashboard_order 
                                where year=".$year."
                                union all
                                select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                                group by month,year
                                order by month"));

                return response()->json($DashboardOrder);

                // $DashboardOrder = DB::connection("sqlsrv2")
                //             ->select(DB::raw("select month,year,sum(amt_total) as total from (
                //                 select month,year,amt_total from  dashboard_invoice 
                //                 where year=".$year."
                //                 union all
                //                 select distinct month,".$year." year,0 amt_total from  dashboard_invoice ) x 
                //                 group by month,year
                //                 order by month"));

                // return response()->json($DashboardOrder);

            break;

            case 'FINANCE';

            $DashboardOrder = DB::connection("sqlsrv2")
                        ->select(DB::raw("select month,year,sum(total_order) as total from (
                            select month,year,total_order  from  dashboard_order 
                            where year=".$year."
                            union all
                            select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                            group by month,year
                            order by month"));

            return response()->json($DashboardOrder);

            break;

            case 'MANAGEMENT';

                $DashboardOrder = DB::connection("sqlsrv2")
                            ->select(DB::raw("select month,year,sum(total_order) as total from (
                                select month,year,total_order  from  dashboard_order 
                                where year=".$year."
                                union all
                                select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                                group by month,year
                                order by month"));

                return response()->json($DashboardOrder);
            break;


            case 'RM';

            $region = Session::get('REGIONID');

                $offRegion = DB::connection("sqlsrv2")
                            ->table('branch_office')
                            ->select('office_id')
                            ->where('region','=', $region)
                            ->pluck('office_id')
                            ->toArray();

                $offRegionList = implode(',',$offRegion);

                $DashboardOrder = DB::connection("sqlsrv2")
                            ->select(DB::raw("select month,year,sum(total_order) as total from (
                                select month,year,total_order  from  dashboard_order 
                                where office_id in (".$offRegionList.") and year=".$year."
                                union all
                                select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                                group by month,year
                                order by month"));

                return response()->json($DashboardOrder);
            break;

            case 'KACAB';

                $DashboardOrder = DB::connection("sqlsrv2")
                            ->select(DB::raw("select month,year,sum(total_order) as total from (
                                select month,year,total_order  from  dashboard_order 
                                where office_id='".$officeid."' and year=".$year."
                                union all
                                select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                                group by month,year
                                order by month"));

                return response()->json($DashboardOrder);
            break;

            case 'SALES';

                $DashboardOrder = DB::connection("sqlsrv2")
                            ->select(DB::raw("select month,year,sum(total_order) as total from (
                                select month,year,total_order  from  dashboard_order 
                                where salesman_id='".Session::get('SALESID')."' and year=".$year."
                                union all
                                select distinct month,".$year." year,0 total_order from  dashboard_order ) x 
                                group by month,year
                                order by month"));

                return response()->json($DashboardOrder);
            break;

        }
        
    }

    public function getDashboardOrderPrcentageLastYear(){

        $year = Carbon::now()->subYear()->year;

        $groupid = Session::get('GROUPID');
        $officeid = Session::get('OFFICEID');

        switch($groupid)
        {
            case 'DEVELOPMENT';
                            
                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;


            case 'FINANCE';
                            
                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

            case 'MANAGEMENT';

                // $divider = DB::connection("sqlsrv2")
                //         ->table('dashboard_order_prod')
                //         ->selectRaw('sum(total_order) as total_order')
                //         ->where('year', '=', $year)
                //         ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

            case "RM":

                $region = Session::get('REGIONID');

                $offRegion = DB::connection("sqlsrv2")
                            ->table('branch_office')
                            ->select('office_id')
                            ->where('region','=', $region)
                            ->pluck('office_id')
                            ->toArray();

                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->whereIn('office_id', $offRegion)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->whereIn('office_id', $offRegion)
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

            case 'KACAB';

                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->where('office_id', $officeid)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }
 
                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('office_id', $officeid)
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();
                            
                return response()->json($OrderPrcentageLastMonth);
            break;

            case 'SALES';

                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->where('office_id', $officeid)
                //             ->where('salesman_id', Session::get('SALESID'))
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }
                            
                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->where('office_id', $officeid)
                                        ->where('salesman_id', Session::get('SALESID'))
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

        }

    }
    
    public function getDashboardOrderPrcentageThisYear(){


        $year = Carbon::now()->year;

        $groupid = Session::get('GROUPID');
        $officeid = Session::get('OFFICEID');

        switch($groupid)
        {
            case 'DEVELOPMENT';
                            
                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;


            case 'FINANCE';
                            
                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

            case 'MANAGEMENT';

                // $divider = DB::connection("sqlsrv2")
                //         ->table('dashboard_order_prod')
                //         ->selectRaw('sum(total_order) as total_order')
                //         ->where('year', '=', $year)
                //         ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

            case "RM":

                $region = Session::get('REGIONID');

                $offRegion = DB::connection("sqlsrv2")
                            ->table('branch_office')
                            ->select('office_id')
                            ->where('region','=', $region)
                            ->pluck('office_id')
                            ->toArray();

                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->whereIn('office_id', $offRegion)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->whereIn('office_id', $offRegion)
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

            case 'KACAB';

                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->where('office_id', $officeid)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }
 
                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('office_id', $officeid)
                                        ->where('year', '=', $year)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();
                            
                return response()->json($OrderPrcentageLastMonth);
            break;

            case 'SALES';

                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->where('office_id', $officeid)
                //             ->where('salesman_id', Session::get('SALESID'))
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }
                            
                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->where('office_id', $officeid)
                                        ->where('salesman_id', Session::get('SALESID'))
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

        }

    }

    public function getDashboardOrderPrcentageThisMonth(){

        $curr = Carbon::now();

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        $groupid = Session::get('GROUPID');
        $officeid = Session::get('OFFICEID');

        switch($groupid)
        {
            case 'DEVELOPMENT';
                            
                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->where('month', '=', $month)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->where('month', '=', $month)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;


            case 'FINANCE';
                            
                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->where('month', '=', $month)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->where('month', '=', $month)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

            case 'MANAGEMENT';

                // $divider = DB::connection("sqlsrv2")
                //         ->table('dashboard_order_prod')
                //         ->selectRaw('sum(total_order) as total_order')
                //         ->where('year', '=', $year)
                //         ->where('month', '=', $month)
                //         ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->where('month', '=', $month)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

            case "RM":

                $region = Session::get('REGIONID');

                $offRegion = DB::connection("sqlsrv2")
                            ->table('branch_office')
                            ->select('office_id')
                            ->where('region','=', $region)
                            ->pluck('office_id')
                            ->toArray();

                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->where('month', '=', $month)
                //             ->whereIn('office_id', $offRegion)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }

                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->whereIn('office_id', $offRegion)
                                        ->where('year', '=', $year)
                                        ->where('month', '=', $month)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

            case 'KACAB';

                // $divider = DB::connection("sqlsrv2")
                //             ->table('dashboard_order_prod')
                //             ->selectRaw('sum(total_order) as total_order')
                //             ->where('year', '=', $year)
                //             ->where('month', '=', $month)
                //             ->where('office_id', $officeid)
                //             ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }
 
                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('office_id', $officeid)
                                        ->where('year', '=', $year)
                                        ->where('month', '=', $month)
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();
                            
                return response()->json($OrderPrcentageLastMonth);
            break;

            case 'SALES';

                $divider = DB::connection("sqlsrv2")
                            ->table('dashboard_order_prod')
                            ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                            ->where('year', '=', $year)
                            ->where('month', '=', $month)
                            ->where('office_id', $officeid)
                            ->where('salesman_id', Session::get('SALESID'))
                            ->get();

                // $divider = $divider[0]->total_order;

                // if ($divider == null) {
                //     $divider = 1;
                // }
                            
                $OrderPrcentageLastMonth = DB::connection("sqlsrv2")
                                        ->table('dashboard_order_prod')
                                        ->selectRaw("category, cast(sum(total_order)/1000000 as numeric(10,2)) as total")
                                        ->where('year', '=', $year)
                                        ->where('month', '=', $month)
                                        ->where('office_id', $officeid)
                                        ->where('salesman_id', Session::get('SALESID'))
                                        ->groupBy('category')
                                        ->orderBy('category')
                                        ->get();

                return response()->json($OrderPrcentageLastMonth);
            break;

        }

    }

    
   

}
