<?php
class Product extends Eloquent {

	protected $table = 'products';
	public $timestamps = false;

	public function tax()
    {
        return $this->belongsTo('Tax');
    }

}