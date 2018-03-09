<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
	protected $table = 'states';
	public function zone()
	{
		return $this->belongsTo('App\Zone');
	}
}
