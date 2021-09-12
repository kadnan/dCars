<?php

namespace App\Http\Controllers;

use App\NFT;
use App\NFTHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller {
	public function add( Request $request ) {
		$nft_id = $request->get( 'nft_id' );
		$event  = $request->get( "event" );
		$to     = $request->get( 'to' );
		$from   = $request->get( 'from' );

//		dd( $request->all() );

		$msg = [ 'STATUS' => 'FAIL' ];

//		$nft_history = NFTHistory::create( [
//			'nft_id' => $nft_id,
//			'event'  => $event,
//			'to'     => $to,
//			'from'   => $from,
//		] );
//
//		if ( $nft_history->id > 0 ) {
//			$msg = [ 'STATUS' => 'OK' ];
//		}

		return response()->json( $msg );
	}
}
