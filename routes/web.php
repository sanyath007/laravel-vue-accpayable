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
    Route::get('/creditor/list', 'CreditorController@list');
    Route::get('/creditor/add', 'CreditorController@add');

    Route::get('debt-type/list', 'DebtTypeController@list');
    Route::get('debt-type/add', 'DebtTypeController@add');

    Route::get('debt/list', 'DebtController@list');
    Route::get('debt/rpt/{creditor}/{sdate}/{edate}/{showAll}', 'DebtController@debtRpt');
    Route::get('debt/add/{creditor}', 'DebtController@add');
    Route::get('debt/edit/{creditor}/{debtId}', 'DebtController@edit');
    Route::post('debt/setzero', 'DebtController@setZero');

    Route::get('debt-creditor/list', 'ReportController@debtCreditor');    
    Route::get('debt-creditor/rpt/{creditor}/{sdate}/{edate}/{showAll}', 'ReportController@debtCreditorRpt');    
    Route::get('debt-debttype/list', 'ReportController@debtDebttype');    
    Route::get('debt-debttype/rpt/{debtType}/{sdate}/{edate}/{showAll}', 'ReportController@debtDebttypeRpt');  

    Route::get('account/arrear', 'AccountController@arrear');    
    Route::get('account-arrear/rpt/{debttypes}/{creditor}/{sdate}/{edate}/{showAll}', 'AccountController@arrearRpt');     
});
