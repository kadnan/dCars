<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller {
	public function index() {

//		$response = Http::withHeaders( [
//			'pinata_api_key'  => '72a94c9c71e9e91de6e3',
//			'pinata_secret_api_key' => '19e64398c5ef83b27374ebc0984befb15510cb1b7bea63faa7db0277398cb194'
//		] )->get( 'https://api.pinata.cloud/data/testAuthentication', [
//			'name' => 'Steve',
//			'role' => 'Network Administrator',
//		] );
//		dd( $response->body() );

		return view( 'index' );
	}

	public function details( $id ) {
		return view( 'details' );
	}
}
