<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NFT extends Model {
	protected $table = 'nfts';
	protected $fillable = [ 'car_id', 'meta' ];
}
