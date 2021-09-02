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

Route::get( '/', 'HomeController@index' )->name( 'index' );
Route::get( '/car/{id}', 'HomeController@details' )->name( 'details' );

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin Routes
 */

Route::get( '/admin/', 'AdminController@dashboard' )->name( 'dashboard' );

Route::get( '/admin/car/add', 'AdminController@addCar' )->name( 'addCar' );
Route::post( '/admin/car/added', 'AdminController@addedCar' )->name( 'addedCar' );
