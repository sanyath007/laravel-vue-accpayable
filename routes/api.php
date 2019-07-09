<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** JWT Auth */
Route::post('auth/register', 'AuthController@register');
Route::post('auth/login', 'AuthController@login');
Route::group(['middleware' => 'jwt.auth'], function() {
    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');
});
Route::group(['middleware' => 'jwt.refresh'], function() {
    Route::get('auth/refresh', 'AuthController@refresh');
});

/** Todo */
Route::get('todos','TaskController@fetchAll');
Route::post('todos','TaskController@store');
Route::delete('todos/{id}','TaskController@delete');

Route::get('approve/list', 'ApprovementController@list');
Route::get('approve/search/{searchKey}', 'ApprovementController@search');
Route::get('approve/get-approve/{appId}', 'ApprovementController@getById');
Route::get('approve/add', 'ApprovementController@add');
Route::post('approve/store', 'ApprovementController@store');
Route::get('approve/detail/{appId}', 'ApprovementController@detail');
Route::get('approve/edit/{appId}', 'ApprovementController@edit');
Route::put('approve/update', 'ApprovementController@update');
Route::delete('approve/delete/{appId}', 'ApprovementController@delete');

Route::get('payment/list', 'PaymentController@list');
Route::get('payment/search/{searchKey}', 'PaymentController@search');
Route::get('payment/get-payment/{appId}', 'PaymentController@getById');
Route::get('payment/add', 'PaymentController@add');
Route::post('payment/store', 'PaymentController@store');
Route::get('payment/detail/{appId}', 'PaymentController@detail');
Route::get('payment/edit/{appId}', 'PaymentController@edit');
Route::put('payment/update', 'PaymentController@update');
Route::delete('payment/delete/{appId}', 'PaymentController@delete');

Route::get('account/arrear', 'AccountController@arrear');    
Route::get('account/arrear-rpt/{debttype}/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@arrearRpt');     
Route::get('account/arrear-excel/{debttype}/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@arrearExcel'); 
Route::get('account/creditor-paid', 'AccountController@creditorPaid');    
Route::get('account/creditor-paid-rpt/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@creditorPaidRpt');     
Route::get('account/creditor-paid-excel/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@creditorPaidExcel');
Route::get('account/ledger/{sdate}/{edate}/{showall}', 'AccountController@ledger');     
Route::get('account/ledger-excel/{sdate}/{edate}/{showall}', 'AccountController@ledgerExcel');
Route::get('account/ledger-debttype/{sdate}/{edate}/{showall}', 'AccountController@ledgerDebttype');     
Route::get('account/ledger-debttype-excel/{sdate}/{edate}/{showall}', 'AccountController@ledgerDebttypeExcel'); 

Route::get('creditors/list', 'CreditorController@list');
Route::get('creditors/search/{searchKey}', 'CreditorController@search');
Route::get('creditors/get-creditor/{creditorId}', 'CreditorController@getById');
Route::get('creditors/add', 'CreditorController@add');
Route::post('creditors/store', 'CreditorController@store');
Route::get('creditors/edit/{creditorId}', 'CreditorController@edit');
Route::put('creditors/update', 'CreditorController@update');
Route::delete('creditors/delete/{creditorId}', 'CreditorController@delete');

Route::get('creditors/prefixes', 'CreditorController@prefixes');

Route::get('debttypes/list', 'DebtTypeController@list');
Route::get('debttypes/search/{searchKey}', 'DebttypeController@search');
Route::get('debttypes/get-debttype/{debttypeId}', 'DebttypeController@getById');
Route::get('debttypes/add', 'DebtTypeController@add');
Route::post('debttypes/store', 'DebttypeController@store');
Route::get('debttypes/edit/{debttypeId}', 'DebttypeController@edit');
Route::put('debttypes/update', 'DebttypeController@update');
Route::delete('debttypes/delete/{debttypeId}', 'DebttypeController@delete');

Route::get('debts/list', 'DebtController@list');
Route::get('debts/{creditor}/{sdate}/{edate}/{showall}', 'DebtController@debtRpt');
Route::get('debt/get-debt/{debtId}', 'DebtController@getById');
Route::get('debts/add/{creditor}', 'DebtController@add');
Route::post('debts/store', 'DebtController@store');
Route::get('debts/edit/{creditor}/{debtId}', 'DebtController@edit');
Route::put('debts/update', 'DebtController@update');
Route::delete('debts/delete/{debtId}', 'DebtController@delete');
Route::post('debts/setzero', 'DebtController@setZero');
Route::get('debt/{creditor}/list', 'DebtController@supplierDebt');

Route::get('report/debt-creditor/list', 'ReportController@debtCreditor');    
Route::get('report/debt-creditor/rpt/{creditor}/{sdate}/{edate}/{showall}', 'ReportController@debtCreditorRpt');    
Route::get('report/debt-creditor-excel/{creditor}/{sdate}/{edate}/{showall}', 'ReportController@debtCreditorExcel');     
Route::get('report/debt-debttype/list', 'ReportController@debtDebttype');    
Route::get('report/debt-debttype/rpt/{debtType}/{sdate}/{edate}/{showall}', 'ReportController@debtDebttypeRpt');  
Route::get('report/debt-debttype-excel/{debttype}/{sdate}/{edate}/{showall}', 'ReportController@debtDebttypeExcel');
Route::get('report/debt-chart/{creditorId}', 'ReportController@debtChart');     
Route::get('report/sum-month-chart/{month}', 'ReportController@sumMonth');     
Route::get('report/sum-year-chart/{month}', 'ReportController@sumYear');   
