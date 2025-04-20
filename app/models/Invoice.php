<?php
class Invoice extends Eloquent {

	protected $table = 'invoice';
	public $timestamps = false;

	public function ProposalInfo()
    {
        return $this->belongsTo('ProposalInfo', 'proposal_id');
    }

}