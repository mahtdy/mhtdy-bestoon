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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/newIncome', 'HomeController@newIncome')->name('newIncome');
Route::post('/newExpense', 'HomeController@newExpense')->name('newExpense');

Route::get('/iande','HomeController@Getiande');
Route::get('/iandeList','HomeController@iandeList');
Route::post('/editIncome','HomeController@editIncome');
Route::post('/editExpense','HomeController@editExpense');
Route::post('/deleteIncome', 'HomeController@deleteIncome');
Route::post('/deleteExpense', 'HomeController@deleteExpense');

Route::get('/plan', 'HomeController@plan');
Route::post('/buyPlan', 'HomeController@buyPlan')->name('buyPlan');

Route::any('/verifyPay', 'HomeController@verifyPay')->name('verifyPay');

Route::get('/subscribe', 'SubscribeController@index');
Route::post('/subscribe', 'SubscribeController@store')->name('subscribe');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/user/{id}/edit', 'AdminController@editUserPage');
Route::put('/admin/user/edit', 'AdminController@editUser')->name('editUser');
Route::delete('/admin/user/delete', 'AdminController@deleteUser')->name('deleteUser');
