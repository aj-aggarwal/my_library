<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'json.response'], function () {
	
	Route::post('/register', 'Auth\AuthController@register');
	Route::post('/login', 'Auth\AuthController@login');

	Route::group(['middleware' => 'auth:api'], function () {
		
		Route::post('/logout', 'Auth\AuthController@logout');
		
		Route::group(['prefix' => 'books'], function () {
			Route::post('/create', 'BooksController@create');
			Route::get('/list', 'BooksController@list');
		});

		Route::post('/user/actions', 'CheckInCheckOutController@userActions');
	});
});
