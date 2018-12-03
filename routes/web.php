<?php

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

Route::get('/', 'Auth\LoginController@showLogin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'web'], function() {
    /** ============= Authentication ============= */
    Route::get('/auth/login', 'Auth\LoginController@showLogin');

    Route::post('/auth/signin', 'Auth\LoginController@doLogin');

    Route::get('/auth/logout', 'Auth\LoginController@doLogout');

    Route::get('/auth/register', 'Auth\RegisterController@register');

    Route::post('/auth/signup', 'Auth\RegisterController@create');
});

Route::group(['middleware' => ['web','auth']], function () {
    Route::get('creditor/list', 'CreditorController@list');
    Route::get('creditor/search/{searchKey}', 'CreditorController@search');
    Route::get('creditor/get-creditor/{creditorId}', 'CreditorController@getById');
    Route::get('creditor/add', 'CreditorController@add');
    Route::post('creditor/store', 'CreditorController@store');
    Route::get('creditor/edit/{creditorId}', 'CreditorController@edit');
    Route::put('creditor/update', 'CreditorController@update');
    Route::delete('creditor/delete/{creditorId}', 'CreditorController@delete');

    Route::get('debttype/list', 'DebtTypeController@list');
	Route::get('debttype/search/{searchKey}', 'DebttypeController@search');
    Route::get('debttype/get-debttype/{debttypeId}', 'DebttypeController@getById');
    Route::get('debttype/add', 'DebtTypeController@add');
    Route::post('debttype/store', 'DebttypeController@store');
    Route::get('debttype/edit/{debttypeId}', 'DebttypeController@edit');
    Route::put('debttype/update', 'DebttypeController@update');
    Route::delete('debttype/delete/{debttypeId}', 'DebttypeController@delete');

    Route::get('debt/list', 'DebtController@list');
    Route::get('debt/rpt/{creditor}/{sdate}/{edate}/{showall}', 'DebtController@debtRpt');
    Route::get('debt/get-debt/{debtId}', 'DebtController@getById');
    Route::get('debt/add/{creditor}', 'DebtController@add');
    Route::post('debt/store', 'DebtController@store');
    Route::get('debt/edit/{creditor}/{debtId}', 'DebtController@edit');
    Route::put('debt/update', 'DebtController@update');
    Route::post('debt/setzero', 'DebtController@setZero');

    Route::get('debt-creditor/list', 'ReportController@debtCreditor');    
    Route::get('debt-creditor/rpt/{creditor}/{sdate}/{edate}/{showall}', 'ReportController@debtCreditorRpt');    
    Route::get('debt-debttype/list', 'ReportController@debtDebttype');    
    Route::get('debt-debttype/rpt/{debtType}/{sdate}/{edate}/{showall}', 'ReportController@debtDebttypeRpt');  
    Route::get('report/excel', 'ReportController@excel');     
    Route::get('report/debt-chart/{creditorId}', 'ReportController@debtChart');     

    Route::get('account/arrear', 'AccountController@arrear');    
    Route::get('account/arrear-rpt/{debttype}/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@arrearRpt');     
    Route::get('account/arrear-excel/{debttype}/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@arrearExcel'); 
    Route::get('account/creditor-paid', 'AccountController@creditorPaid');    
    Route::get('account/creditor-paid-rpt/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@creditorPaidRpt');     
    Route::get('account/creditor-paid-excel/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@creditorPaidExcel');     

});
