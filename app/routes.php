<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', function()
// {
// 	return View::make('hello');
// });

// Users Routes

Route::get('/', function() {
 	return View::make('index');
});

Route::get('/home/index', 'HomeController@index');

Route::get('/member/login_regist_form', 'MemberController@loginAndRegistForm');

Route::post('/member/login', 'MemberController@login');

Route::get('/member/logout', 'MemberController@logout');

Route::post('/member/regist', 'MemberController@regist');

Route::post('/member/find_passwd', 'MemberController@findPasswd');

Route::get('/item/regist_form', 'ItemController@registForm');

Route::get('/item/view', 'ItemController@view');

Route::post('/item/regist', 'ItemController@regist');

Route::post('/category/get_child', 'CategoryController@getChild');

Route::post('/category/get_full_label', 'CategoryController@getFullLabel');

Route::post('/trade/create', 'TradeController@create');

Route::post('/trade/complete', 'TradeController@complete');

Route::post('/trade/cancel', 'TradeController@cancel');

Route::get('/trade/ongoing_list', 'TradeController@onGoingList');

Route::get('/trade/completion_list', 'TradeController@completionList');

Route::get('/trade/cancellation_list', 'TradeController@cancellationList');


// Admin Routes

Route::get('/admin/index', 'AdminController@index');

Route::get('/admin/category/list_form', 'AdminCategoryController@listForm');

Route::post('/admin/category/get_child', 'AdminCategoryController@getChild');

Route::post('/admin/category/add', 'AdminCategoryController@add');

Route::post('/admin/category/remove', 'AdminCategoryController@remove');

Route::post('/admin/category/modify', 'AdminCategoryController@modify');