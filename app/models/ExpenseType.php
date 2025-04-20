<?php
class ExpenseType  extends Eloquent{
	
	public $timestamps = false;
	public static function getNameByExpenseId( $expense_id )
	{
		$name = "";
		$details = ExpenseType::where('expense_id','=',$expense_id)->select('expense_type')->first();
		if(isset($details->expense_type) && $details->expense_type != ""){
			$name 	= $details->expense_type;
		}
		return $name;
	}

	public static function getExpenseTypeByStatus($status)
    {
        $ret_value      = array();
        $session        = Session::get('admin_details');
        $groupUserId    = $session['group_users'];

        $details = ExpenseType::whereIn('user_id', $groupUserId)->where('status', '=', $status)->orderBy('expense_type', 'ASC')->get();
        
        return ExpenseType::getArray($details);
    }    

    public static function getArray($details)
    {
        $data = array();
        if(isset($details) && count($details) >0){
            foreach ($details as $key => $value) {
                $data[$key]["expense_id"]       = $value['expense_id'];
                $data[$key]["user_id"]          = $value['user_id'];
                $data[$key]["expense_type"]     = $value['expense_type'];
                $data[$key]["status"]           = $value['status'];
                $data[$key]["created"]          = date('d-m-Y', strtotime($value['status']));
            }
        }
        return $data;
    }
	

}
