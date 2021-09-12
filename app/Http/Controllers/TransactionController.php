<?php

namespace App\Http\Controllers;

use App\Transactions;
use Illuminate\Http\Request;

class TransactionController extends Controller {


	public function add( Request $request ) {
		$msg         = [ 'STATUS' => 'FAIL' ];
		$transaction = Transactions::create( [
			'tx_hash' => $request->get( 'tx_hash' ),
			'data'    => $request->get( 'data' )
		] );
		if ( $transaction->id > 0 ) {
			$msg = [ 'STATUS' => 'OK' ];
		}
		return response()->json( $msg );
	}
}
