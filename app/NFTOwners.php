<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NFTOwners extends Model {
	protected $table = 'nft_owners';
	protected $fillable = [ 'nft_id', 'owner_address' ];
}
