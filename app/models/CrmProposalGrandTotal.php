<?php
class CrmProposalGrandTotal extends Eloquent {

	public $timestamps = false;

	public static function getGrandTotal( $proposal_id, $is_show )
    {
        $total = 0;
    	$session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];
        
        $details = CrmProposalGrandTotal::whereIn('user_id', $groupUserId)->where('proposal_id', $proposal_id)->get();
        //Common::last_query();
        if(isset($details) && count($details) >0){
            foreach ($details as $k => $v) {
                $details1 = CrmProposalTable::whereIn('user_id', $groupUserId)->where('proposal_id', '=', $v['proposal_id'])->where('heading_id', '=', $v['heading_id'])->get();
                //Common::last_query();
                if(isset($details1) && count($details1) >0){
                    foreach ($details1 as $k1 => $v1) {
                        $total += $v1->fees;
                    }
                }
            }
        }
        return number_format($total, 2);
    }

    public static function checkTable( $proposal_id, $heading_id )
    {
        $session        = Session::get('admin_details');
        $user_id        = $session['id'];
        $groupUserId    = $session['group_users'];

        $details = CrmProposalGrandTotal::whereIn('user_id', $groupUserId)->where('proposal_id', '=', $proposal_id)->where('heading_id', '=', $heading_id)->first();
        $count = 0;
        if(isset($details) && count($details) >0 ){
            $count = $details->grand_total_id;
        }
        return $count;
    }

    

}
