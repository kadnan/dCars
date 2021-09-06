<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model {
	protected $fillable = [ 'name', 'vin', 'price', 'url', 'status','user_id' ];
	protected $table = 'cars';
}
