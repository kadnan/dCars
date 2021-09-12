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


Auth::routes();

Route::get( '/home', 'HomeController@index' )->name( 'home' );

Route::get( '/car/{id}', 'CarController@details' )->name( 'details' )->where( 'id', '[0-9]+' );

Route::middleware( [ 'auth' ] )->group( function () {
	Route::get( '/dashboard', 'HomeController@dashboard' )->name( 'user_dashboard' );
	Route::get( '/car/add', 'CarController@addCar' )->name( 'addCar1' );
	Route::get( '/car/{id}/reserve/', 'CarController@reserveCar' )->name( 'reserveCar' );
	Route::post( '/car/added', 'CarController@addedCar' )->name( 'addedCar1' );
	Route::get( '/set_wallet/{address}', 'HomeController@setWalletAddress' )->name( 'setWalletAddress' );
	Route::post( '/nft/minted', 'NFTController@minted' )->name( 'minted' );
	Route::post( '/transaction/add', 'TransactionController@add' )->name( 'add_transaction' );
} );

Route::get( '/nft/meta/{id}.json', 'CarController@getNFTMeta' )->name( 'getNFTMeta' );
/**
 * Admin Routes
 */

Route::get( '/admin/', 'AdminController@dashboard' )->name( 'dashboard' );

Route::get( '/admin/car/add', 'AdminController@addCar' )->name( 'addCar' );
Route::post( '/admin/car/added', 'AdminController@addedCar' )->name( 'addedCar' );
