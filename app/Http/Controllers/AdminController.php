<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller {
	public function dashboard() {
		$cars = Car::all();

		return view( 'admin/dashboard' )
			->with( 'cars', $cars );
	}

	public function addCar() {
		return view( 'admin/addCar' );
	}

	public function addedCar( Request $request ) {
		$url                = $request->file( 'url' );
		$name               = $request->get( 'name' );
		$vin                = $request->get( 'vin' );
		$price              = $request->get( 'price' );
		$uploaded_file_hash = '';

		if ( $request->hasFile( 'url' ) ) {
			$url                = $request->file( 'url' );
			$uploaded_file_name = strtolower( str_replace( ' ', '_', $name ) );

			$response = Http::withHeaders( [
				'pinata_api_key'        => '72a94c9c71e9e91de6e3',
				'pinata_secret_api_key' => '19e64398c5ef83b27374ebc0984befb15510cb1b7bea63faa7db0277398cb194'
			] )->attach( 'file', file_get_contents( $url ), $uploaded_file_name )
			                ->post( 'https://api.pinata.cloud/pinning/pinFileToIPFS', [
			                ] );
			$data     = $response->json();

			if ( array_key_exists( 'IpfsHash', $data ) ) {
				$uploaded_file_hash = $data['IpfsHash'];
				$size               = $data['PinSize'];

				if ( $size > 0 ) {
					// It is time to upload it
					$car = Car::create( [
						'name'   => $name,
						'vin'    => $vin,
						'url'    => $uploaded_file_hash,
						'price'  => $price,
						'status' => 1,
					] );

					if ( $car->id > 0 ) {
						return redirect()->route( 'dashboard' );
					}

				}
			}
		}
	}
}

