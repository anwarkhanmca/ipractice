<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Signplace extends Model {

	protected $table = 'signplaces';

	public $timestamps = false;

	protected $fillable = ['user_id' , 'top' , 'left'];

}
