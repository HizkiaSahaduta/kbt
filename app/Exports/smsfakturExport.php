<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class smsfakturExport implements FromView
{
    public function __construct(string $pickyDate, string $pickyDate2, string $status)
    {
        $this->pickyDate= $pickyDate;
        $this->pickyDate2= $pickyDate2;
        $this->status= $status;

    }

    public function view(): View
    {   

        $report = DB::connection("sqlsrv2")
                    ->table('sms_api')
                    ->selectRaw('sms_api.tr_id, sms_api.phone, sms_api.pesan, sms_api.stat, sms_api.response, 
                    sms_api.dt_put, sms_api.dt_send, sms_api.CustomerId, sms_api.NamaCustomer, Sales.SalesId, Sales.NamaSales, 
                    CustomerOrder.pay_term, branch_office.office_id, branch_office.office')
                    ->join("Penjualan","sms_api.tr_id", "=", "Penjualan.PenjualanNO")
                    ->join("Sales","Sales.SalesId", "=", "Penjualan.SalesId")
                    ->join("CustomerOrder","CustomerOrder.CustomerOrderNo", "=", "Penjualan.CustomerOrderNo")
                    ->join("branch_office","CustomerOrder.office_id", "=", "branch_office.office_id")
                    ->whereBetween('sms_api.dt_send', [$this->pickyDate, $this->pickyDate2])
                    ->where('sms_api.stat','=',$this->status)
                    ->get();

                    return view('exports.SMSFakturViewExport',['report' => $report]);
        
    }
}