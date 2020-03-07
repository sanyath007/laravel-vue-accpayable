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

Route::get('approves/list', 'ApprovementController@list');
Route::get('approves/{creditor}/{sdate}/{edate}/{showall}', 'ApprovementController@search');
Route::get('approves/{appId}', 'ApprovementController@getById');
Route::get('approves/{appId}/debts', 'ApprovementController@appDebts');
Route::post('approves/store', 'ApprovementController@store');
Route::get('approves/detail/{appId}', 'ApprovementController@detail');
Route::get('approves/edit/{appId}', 'ApprovementController@edit');
Route::put('approves/{appId}', 'ApprovementController@update');
Route::delete('approves/delete/{appId}', 'ApprovementController@delete');
Route::post('approves/cancel', 'ApprovementController@cancel');
Route::get('approves/{supplier}/list', 'ApprovementController@supplierApproves');

Route::get('budgets', 'BudgetController@list');
Route::get('budgets/{id}', 'BudgetController@getById');

Route::get('payments/list', 'PaymentController@list');
Route::get('payments/{creditor}/{sdate}/{edate}/{showall}', 'PaymentController@search');
Route::get('payments/get-payment/{paymentId}', 'PaymentController@getById');
Route::get('payments/add', 'PaymentController@add');
Route::post('payments/store', 'PaymentController@store');
Route::get('payments/detail/{paymentId}', 'PaymentController@detail');
Route::get('payments/edit/{paymentId}', 'PaymentController@edit');
Route::put('payments/update', 'PaymentController@update');
Route::delete('payments/delete/{paymentId}', 'PaymentController@delete');
Route::get('payments/{supplier}/list', 'PaymentController@supplierPayments');

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

Route::get('debttypes', 'DebtTypeController@list');
Route::get('debttypes/search/{searchKey}', 'DebttypeController@search');
Route::get('debttypes/get-debttype/{debttypeId}', 'DebttypeController@getById');
Route::get('debttypes/add', 'DebtTypeController@add');
Route::post('debttypes/store', 'DebttypeController@store');
Route::get('debttypes/edit/{debttypeId}', 'DebttypeController@edit');
Route::put('debttypes/{debtId}', 'DebttypeController@update');
Route::delete('debttypes/delete/{debttypeId}', 'DebttypeController@delete');

Route::get('debts/list', 'DebtController@list');
Route::get('debts/{creditor}/{sdate}/{edate}/{showall}', 'DebtController@debtRpt');
Route::get('debts/get-debt/{debtId}', 'DebtController@getById');
Route::post('debts/store', 'DebtController@store');
Route::get('debts/edit/{creditor}/{debtId}', 'DebtController@edit');
Route::put('debts/{debtId}', 'DebtController@update');
Route::delete('debts/{debtId}', 'DebtController@delete');
Route::post('debts/setzero', 'DebtController@setZero');
Route::get('debts/{creditor}/list', 'DebtController@supplierDebt');
Route::get('debts/sum-debit', 'DebtController@sumDebit');
Route::get('debts/sum-credit', 'DebtController@sumCredit');
Route::get('debts/balance', 'DebtController@balance');

Route::get('report/debt-creditor/list', 'ReportController@debtCreditor');    
Route::get('report/debt-creditor/rpt/{creditor}/{sdate}/{edate}/{showall}', 'ReportController@debtCreditorRpt');    
Route::get('report/debt-creditor-excel/{creditor}/{sdate}/{edate}/{showall}', 'ReportController@debtCreditorExcel');     
Route::get('report/debt-debttype/list', 'ReportController@debtDebttype');    
Route::get('report/debt-debttype/rpt/{debtType}/{sdate}/{edate}/{showall}', 'ReportController@debtDebttypeRpt');  
Route::get('report/debt-debttype-excel/{debttype}/{sdate}/{edate}/{showall}', 'ReportController@debtDebttypeExcel');
Route::get('report/debt-chart/{creditorId}', 'ReportController@debtChart');     
Route::get('report/sum-month-chart/{month}', 'ReportController@sumMonth');     
Route::get('report/sum-year-chart/{month}', 'ReportController@sumYear');   
