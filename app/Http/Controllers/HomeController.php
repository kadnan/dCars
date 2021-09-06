<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller {
	public function index() {

		return view( 'index' );
	}


	public function dashboard() {
		$cars = Car::where( 'user_id', Auth::user()->id )->get();
		return view( 'dashboard' )
			->with( 'cars', $cars );
	}
}
