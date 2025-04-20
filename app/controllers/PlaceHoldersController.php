<?php
/*
	
*/

class PlaceHoldersController extends BaseController {
    public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)){
            Redirect::to('/login')->send();
        }
		
		//DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
    }
    
	// shows all the placeholders
    public function index()
    {
		$data['title'] = 'Placeholders';
		$data['previous_page'] = '<a href="/email/template">Email Templates</a>';
		$data['heading'] = "Placeholders List";
		
		$data['placeholders'] = Placeholder::All();
		$data['tables'] = DB::select('SHOW TABLES');
		
		return View::make('placeholders.index',$data);
    }
	
	// Add new Placeholder to database
	public function add($action, $id=null){
		$postData=Input::All();
		$placeholder_id=$postData['placeholder_id'];
		$insertData['module']=$postData['module'];
		$insertData['table']=$postData['table_name'];
		$insertData['field']=$postData['field_name'];
		if(!isset($placeholder_id) && empty($placeholder_id)){
			$id=Placeholder::insertGetId($insertData);
			if($id>=0)
			{	
				Session::flash('success', 'Placeholder has been added.');
			} else {
				Session::flash('error', 'There are some errors while adding Placeholder.');
			}
		}else{
			$id=Placeholder::where('id','=',$placeholder_id)->update($insertData);
			if($id=1)
			{	
				Session::flash('success', 'Placeholder has been Updated.');
			} else {
				Session::flash('error', 'There are some errors while updating Placeholder.');
			}
		}
		Redirect::to('/placeholders')->send();
	}
	
	// Get and return details of placeholder by module name
	public function byModule($module)
	{
		$data['placeholders'] = Placeholder::where('module','=',$module)->get();
		return json_encode($data['placeholders']);
	}
	
	// Required While editing placeholder : Get and return details of placeholder by ID
	public function getDetails($id)
	{
		$data['placeholders'] = Placeholder::where('id','=',$id)->get();
		return json_encode($data['placeholders']);
	}
	
	// Delete placeholder
	public function delete($id)
	{
		$d = Placeholder::where('id','=',$id)->delete();
		if($d)
		{	
			Session::flash('success', 'Placeholder has been Deleted.');
		} else {
			Session::flash('error', 'There are some errors while deleting Placeholder.');
		}
		Redirect::to('/placeholders')->send();
	}
	
	// get all table fields and make them select options
	public function getTableFields($table)
	{
		//DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
		$columns = DB::connection()->getDoctrineSchemaManager()->listTableColumns($table);
		
		//echo "<pre>";//print_r($columns);die;
		$html='<option>Select Field</option>';
		foreach($columns as $column) {
		   $html .= '<option value="'.$column->getName().'">'.$column->getName().'</option>';
		}
		
		return $html;
	}
	
	public function syncAllTable2Placeholders(){
		
		
		//$platform = new Doctrine\DBAL\Platforms\MySqlPlatform;
		//$platform->registerDoctrineTypeMapping('enum', 'string');
		
		$tables = DB::select('SHOW TABLES');
		$a=array();
		$b=array();
		
		foreach($tables as $k => $table){
			try{
				$columns = DB::connection()->getDoctrineSchemaManager()->listTableColumns($table->Tables_in_mpmsdb);
				
				foreach($columns as $column){
					$a[$table->Tables_in_mpmsdb][]=$column->getName();
				}
				
			}catch(Exception $e){
				$b[]=$table->Tables_in_mpmsdb;
			}
		}
		
		$data=array();
		
		foreach($a as $table=>$columns){
			foreach($columns as $k => $column){
				$data[]=array('module'=>$table,
							  'table'=>$table,
							  'field'=>$column,
							  'display_name'=>$column
							 );
			}
		}
		Placeholder::truncate();
		Placeholder::insert($data);
		//echo "<pre>";print_r($b);die;
		
		Redirect::to('/placeholders')->send();
	}
}
