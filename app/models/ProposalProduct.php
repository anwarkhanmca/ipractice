<?php
class ProposalProduct extends Eloquent {

	protected $table = 'proposal_products';
	public $timestamps = false;

	public function service()
    {
        return $this->belongsTo('Service', 'service_id');
    }

}
