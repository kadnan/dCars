<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model {
	protected $fillable = [ 'tx_hash', 'data' ];
	protected $table = 'transactions';
}
