<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWallets extends Model {
	protected $fillable = [ 'user_id', 'address', 'status' ];
	protected $table = 'user_wallets';
}
