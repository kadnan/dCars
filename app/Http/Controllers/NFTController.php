<?php

namespace App\Http\Controllers;

use App\Car;
use App\NFTHistory;
use App\NFTOwners;
use App\Transactions;
use App\UserWallets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NFTController extends Controller {
	public function minted( Request $request ) {
		$nft_id   = $request->get( 'nft_id' );
		$event    = $request->get( 'event' );
		$to       = $request->get( 'to' );
		$from     = $request->get( 'from' );
		$car_id   = $request->get( 'car_id' );
		$tx_hash  = $request->get( 'tx_hash' ); //After Minting
		$token_id = $request->get( 'token_id' ); //Minting Counter Token ID

		$user_id = Auth::user()->id;

//		dd( $request->all() );

		//Fetch User Wallet
		$wallet         = UserWallets::where( 'user_id', $user_id )->firstOrFail();
		$wallet_address = $wallet->address;

		// Add NFT History
		$nft_history = NFTHistory::create( [
			'nft_id' => $nft_id,
			'event'  => $event,
			'to'     => $to,
			'from'   => $from,
		] );


		// Add Transaction Record
		$transaction = Transactions::create( [
			'tx_hash' => $tx_hash,
			'data'    => json_encode([ 'token_id' => $token_id ]),
		] );

		// Add NFT Owners Record

		$nft_owner = NFTOwners::create( [
			'nft_id'        => $nft_id,
			'owner_address' => $wallet_address,
		] );

		// Update the Car flag

		$car         = Car::find( $car_id );
		$car->status = 4; // Car Minted and Ownership Transferred
		$car->save();

		return response()->json( [ 'STATUS' => 'OK' ] );
	}
}
