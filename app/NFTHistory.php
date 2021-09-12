<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NFTHistory extends Model {
	protected $table = 'nft_history';
	protected $fillable = [ 'nft_id', 'event', 'to', 'from' ];
}
