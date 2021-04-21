<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'password' => false,
    'verify' => false,
  ]);

Route::get('ChangeDefaultPassword', 'ChangeDefaultPasswordController@index');
Route::post('ChangeDefPass', 'ChangeDefaultPasswordController@ChangeDefPass');


/*---------------------------------------------------------------------------------------------------------------------------------------------*/
//Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index')->name('home');
Route::post('getDashboardItems', 'HomeController@getDashboardItems');
Route::get('getDashboardOrderLastYear', 'HomeController@getDashboardOrderLastYear');
Route::get('getDashboardOrderThisYear', 'HomeController@getDashboardOrderThisYear');
Route::get('getDashboardOrderPrcentageLastYear', 'HomeController@getDashboardOrderPrcentageLastYear');
Route::get('getDashboardOrderPrcentageThisYear', 'HomeController@getDashboardOrderPrcentageThisYear');
Route::get('getDashboardOrderPrcentageThisMonth', 'HomeController@getDashboardOrderPrcentageThisMonth');

/*---------------------------------------------------------------------------------------------------------------------------------------------*/

//-- User Mgmt
Route::get('MyAccount', 'MyAccountController@index')->name('MyAccount');
Route::get('ChangePass', 'ChangePassController@index')->name('ChangePass');
Route::post('ActChangePass', 'ChangePassController@ActChangePass')->name('ActChangePass');
Route::get('AddUser', 'AddUserController@index')->name('AddUser');
Route::post('listUser', 'AddUserController@listUser')->name('listUser');
Route::post('saveUser', 'AddUserController@saveUser')->name('saveUser');
Route::get('getUser/id={id}&id2={id2}', 'AddUserController@getUser');
Route::get('delUser/id={id}&id2={id2}', 'AddUserController@delUser');
Route::post('editUser', 'AddUserController@editUser')->name('editUser');
Route::get('AddSales', 'AddSalesController@index')->name('AddSales');
Route::post('saveSales', 'AddSalesController@saveSales')->name('saveSales');

// JSON Sales
Route::get('listDeptSales', 'JSONController@listDeptSales');
Route::get('listCitySales', 'JSONController@listCitySales');
Route::get('listDivisionSales', 'JSONController@listDivisionSales');
Route::get('listRegionSales', 'JSONController@listRegionSales');
Route::get('listSalesOffice', 'JSONController@listSalesOffice');
Route::get('listBranchHead/id={id}', 'JSONController@listBranchHead');
Route::get('listBankSales', 'JSONController@listBankSales');
Route::get('getCust', 'JSONController@getCust');
Route::get('getCustDetails/id={id}', 'JSONController@getCustID');
Route::get('checkRegion/id={id}', 'JSONController@checkRegion');
Route::get('getSalesByOffice/id={id}', 'JSONController@getSalesByOffice');
Route::get('checkSalesId/id={id}', 'JSONController@checkSalesId');
Route::get('genSalesId', 'JSONController@genSalesId');
Route::get('getOrderBySales/id={id}', 'JSONController@getOrderBySales');
Route::get('getCustomerBySales/id={id}', 'JSONController@getCustomerBySales');
Route::get('getCustomerByOrder/id={id}', 'JSONController@getCustomerByOrder');
Route::get('getCustomerBySalesOrder/a={a}&b={b}', 'JSONController@getCustomerBySalesOrder');

//-- Sales Activity
Route::get('TodayVisit', 'TodayVisitController@index')->name('TodayVisit');
Route::post('getTodayVisit', 'TodayVisitController@getTodayVisit')->name('getTodayVisit');
Route::post('listSales', 'AddSalesController@listSales')->name('listSales');
Route::get('CustomerVisit', 'CustomerVisitController@index')->name('CustomerVisit');
Route::post('storeActivity', 'CustomerVisitController@storeActivity');
Route::get('VisitReport', 'VisitReportController@index')->name('VisitReport');
Route::post('GetVisit', 'VisitReportController@GetVisit');
Route::get('checkLastVisit', 'CustomerVisitController@checkLastVisit');

//-- Material Availability
Route::get('MaterialAvailability', 'MaterialAvailabilityController@index')->name('MaterialAvailability');
Route::post('find_mats', 'MaterialAvailabilityController@find_mats');

//-- Piutang Report
Route::get('PiutangReport', 'PiutangReportController@index')->name('PiutangReport');
Route::post('find_invoices', 'PiutangReportController@find_invoices');
Route::post('invoiceSummary', 'PiutangReportController@invoiceSummary');

//-- Debt Report
Route::get('DebtReport', 'DebtReportController@index')->name('DebtReport');
Route::post('find_debt', 'DebtReportController@find_debt');
Route::post('debt_summary', 'DebtReportController@debt_summary');
Route::post('debt_detail', 'DebtReportController@debt_detail');

//-- Order Report
Route::get('OrderReport', 'OrderReportController@index')->name('OrderReport');
Route::post('getOrderReportHeader', 'OrderReportController@getOrderReportHeader');
Route::post('getOrderReportDetail', 'OrderReportController@getOrderReportDetail');


