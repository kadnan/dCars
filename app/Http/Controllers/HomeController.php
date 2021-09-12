<?php

namespace App\Http\Controllers;

use App\Car;
use App\UserWallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;

class HomeController extends Controller {
	public function index() {
		$cars = Car::all();

		return view( 'index' )
			->with( 'cars', $cars );
	}


	public function dashboard() {
		$cars = Car::where( 'user_id', Auth::user()->id )->get();

		return view( 'dashboard' )
			->with( 'cars', $cars );
	}

	public function setWalletAddress( $address ) {
		$user_id = Auth::user()->id;
		//$hasWallet = UserWallets::where( [ 'user_id' => $user_id, 'address' => $address ] )->exists();
		$hasWallet = UserWallets::where( 'user_id', $user_id )
		                        ->orWhere( 'address', $address )->exists();

		if ( ! $hasWallet ) {
			UserWallets::create( [
				'user_id' => $user_id,
				'address' => $address,
				'status'  => 0
			] );
		}

		return response()->json( [ 'STATUS' => 'OK' ] );
	}
}
