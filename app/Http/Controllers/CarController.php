<?php

namespace App\Http\Controllers;

use App\Car;
use App\NFT;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CarController extends Controller {
	public function addCar() {
		return view( 'cars/addCar' );
	}

	public function details( $id ) {
		$car        = Car::where( 'id', $id )->first();
		$isReserved = Reservation::where( 'car_id', $id )->exists();

		return view( 'cars/details' )
			->with( 'car', $car )
			->with( 'isReserved', $isReserved );
	}

	/**
	 * Car reserved by the logged in user
	 *
	 * @param $id
	 */
	public function reserveCar( $id ) {
		$isReserved = Reservation::where( 'car_id', $id )->exists();
		$NewDate    = Date( 'y:m:d', strtotime( '+3 days' ) );
		$msg        = [ 'STATUS' => 'FAIL' ];

		if ( ! $isReserved ) {
			$reservation = Reservation::create( [
				'car_id'      => $id,
				'user_id'     => Auth::user()->id,
				'expiry_date' => $NewDate
			] );

			if ( $reservation->id > 0 ) {
				$msg = [ 'STATUS' => 'OK' ];
			}
		}


		return response()->json( $msg );

	}

	public function addedCar( Request $request ) {
		$url                = $request->file( 'url' );
		$name               = $request->get( 'name' );
		$vin                = $request->get( 'vin' );
		$price              = $request->get( 'price' );
		$uploaded_file_hash = '';
		$user_id            = Auth::user()->id;

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
						'name'    => $name,
						'vin'     => $vin,
						'url'     => $uploaded_file_hash,
						'user_id' => $user_id,
						'price'   => $price,
						'status'  => 1,
					] );

					if ( $car->id > 0 ) {
						/**
						 * Add NFT Data
						 */

						$description = "This NFT Belongs to {$name}";
						$image_url   = 'https://gateway.pinata.cloud/ipfs/' . $uploaded_file_hash;

						$meta = [
							'name'        => $name,
							'description' => $description,
							'image'       => $image_url,
							'vin'         => $vin
						];

						$nft = NFT::create( [
							'car_id' => $car->id,
							'meta'   => json_encode( $meta )
						] );


						return redirect()->route( 'user_dashboard' );
					}

				}
			}
		}
	}


	public function getNFTMeta( $id ) {
		$nft  = NFT::where( 'id', $id )->firstOrFail();
		$meta = null;

		if ( $nft != null ) {
			return response()->json(json_decode($nft->meta,true));
		}
	}
}
