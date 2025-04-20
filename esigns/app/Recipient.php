<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model {

	protected $table = 'recipients';

	public $timestamps = false;

	protected $fillable = ['doc_id', 'name', 'email', 'passcode', 'url_key', 'status', 'sent_on'];

}
