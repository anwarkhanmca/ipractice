<?php
class KnowledgeBaseController extends BaseController {
	public function __construct()
    {
        parent::__construct();
        $session = Session::get('admin_details');
        $user_id = $session['id'];
        if (empty($user_id)) {
            Redirect::to('/login')->send();
        }
        if (isset($session['user_type']) && $session['user_type'] == "C") {
            Redirect::to('/client-portal')->send();
        }
    }

	public function index()
  {
		$data['title'] = 'Knowledge Base';
		//$data['previous_page'] = '<a href="/staff-profile">Staff Profile</a>';
		$data['heading']  = "KNOWLEDGE BASE";
		$admin_s          = Session::get('admin_details');
		$user_id          = $admin_s['id'];
		$groupUserId      = $admin_s['group_users'];
    $group_id         = $admin_s['group_id'];
        
		$data['staffprof_notes']=Knowledgebase::WhereIn("user_id",$groupUserId)->select("knowledgebase_id","user_id","title","textmessage","created")->orderBy('created', 'DESC')->first();
        
    $data['knowledge_notes']=Knowledgebase::WhereIn("user_id",$groupUserId)->select("knowledgebase_id","user_id","title","textmessage","created")->orderBy('created', 'DESC')->get();
    
    
    $data['user'] = User::where("user_id", $data['staffprof_notes']['user_id'])->select("fname", "lname","user_id")->first();   
		
		//echo "<prev>".print_r($data['staffprof_notes']);die;
		return View::make('knowledgebase.index', $data);
	}
    
    public function knowledgebase_notesinsert(){
        
        $postData = Input::all();
        $arrData = array();
        $file_data = array();
        
        //print_r($postData);die();
        
       	$admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
		$groupUserId = $admin_s['group_users'];
        $data=array();
     
       // $notestitle = Input::get("notestitle");
        // $notesmsg = Input::get("notesmsg");
       
        
        $data['title']=$postData['notestitle'];
        $data['textmessage']=$postData['notesmsg'];
        
        $data['user_id']=$user_id;
        //$data['modified']=date("Y-m-d h:i:s");
        
        //if (Request::ajax()) {
          $notes_id = Knowledgebase::insertGetId($data);
        
        
        $path = "uploads/knowledgebase/".$user_id;
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
        
        
        
        
        if ($notes_id) {
                //////////////////file upload start//////////////////
                if (Input::hasFile('add_file')) {
                    $file = Input::file('add_file');
                    $destinationPath = "uploads/knowledgebase/".$user_id;
                    $fileName = Input::file('add_file')->getClientOriginalName();

                    $fileName = $notes_id . $fileName;
                    $result = Input::file('add_file')->move($destinationPath, $fileName);

                    $file_data['file'] = $fileName;
                    Knowledgebase::where("knowledgebase_id", "=", $notes_id)->update($file_data);

                }
                /////////////////file upload end////////////////////

            }
        
        
        
        $data['knowledge_notes'] = Knowledgebase::where('knowledgebase_id','=',$notes_id)->select("knowledgebase_id","user_id","title","textmessage","file","created")->first();
        $user=$data['knowledge_notes']['user_id'];
              // die();
               
        $data['user'] = User::where("user_id","=",$user)->select("fname", "lname","user_id")->first();  
        $data['inserted_id']=$notes_id;
        
        echo View::make('knowledgebase.notesedit', $data);
       
       //  }
    
    
    }
    
    public function editmodekbase_notes(){
        
        
        $notesmsgid = Input::get("notesmsgid");
		if (Request::ajax()) {
		
        	$data['staffprof_notes'] = Knowledgebase::where('knowledgebase_id','=',$notesmsgid)->select("knowledgebase_id","user_id","title","textmessage","file","created")->first();
		  
          $user=$data['staffprof_notes']['user_id'];
              // die();
               
        $data['user'] = User::where("user_id","=",$user)->select("fname", "lname","user_id")->first();  
        
        
         //echo View::make('hmrc.rsponce')->with('datares',$data['name']);
         
        echo View::make('knowledgebase.notes', $data);
        	//echo $data;
		
        }    
        
        
        
    }
    
    
    
    public function view_article(){
        
        
        
        $notesmsgid = Input::get("notesmsgid");
		if (Request::ajax()) {
		
        	$data['knowledge_notes'] = Knowledgebase::where('knowledgebase_id','=',$notesmsgid)->select("knowledgebase_id","user_id","title","textmessage","created")->first();
		  $user=$data['knowledge_notes']['user_id'];
              // die();
               
        $data['user'] = User::where("user_id","=",$user)->select("fname", "lname","user_id")->first();  
        
        
         //echo View::make('hmrc.rsponce')->with('datares',$data['name']);
         
        echo View::make('knowledgebase.notesedit', $data);
        	//echo $data;
		
        }  
        
    }
    
    public function editsave_article(){
      $postData = Input::all();
      $arrData = array();
      $file_data = array();
      $data = array();
      $admin_s = Session::get('admin_details');
	    $user_id = $admin_s['id'];
    // print_r($postData);
    // print_r($_FILES);
     //die();
      
      $edited_id =  $postData["knowledgebase_id"];
         //print_r($edited_id);
        //$client_id = Input::get("client_id");
        

        
      $data['title']=$postData["notestitle"];
      $data['textmessage']=$postData["notesmsg"];
        
                  
         
         $update = Knowledgebase::where("knowledgebase_id", $edited_id)->update($data);
         // echo $this->last_query();die();
         $path = "uploads/knowledgebase/".$user_id;
            if (!file_exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }
         
        if ($_FILES) {
          //////////////////file upload start//////////////////
          if (Input::hasFile('edit_attach_file')) {
            // echo 'hasf';die();
            $file = Input::file('edit_attach_file');
            $destinationPath = "uploads/knowledgebase/".$user_id;
            $fileName = Input::file('edit_attach_file')->getClientOriginalName();
          
            $fileName = $postData['knowledgebase_id'] . $fileName;
            $result = Input::file('edit_attach_file')->move($destinationPath, $fileName);

            $file_data['file'] = $fileName;
            //print_r($file_data);die();
            Knowledgebase::where("knowledgebase_id", $postData['knowledgebase_id'])->update($file_data);
              ### delete the previous image if exists ###
          }
          /////////////////file upload end////////////////////

        }
         
           
        
        $data['knowledge_notes'] = Knowledgebase::where('knowledgebase_id', $edited_id)->select("knowledgebase_id","user_id","title","textmessage","file","created")->first();
        $user=$data['knowledge_notes']['user_id'];
              // die();
               
        $data['user'] = User::where("user_id","=",$user)->select("fname", "lname","user_id")->first();  
        
       // $data['inserted_id']=$edited_id;
       echo View::make('knowledgebase.notesedit', $data);
          
        
    }
    
    
    public function delete_article(){
        
        
        
        $edited_id = Input::get("edited_id");
         //$client_id = Input::get("client_id");
        $admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
        
        
        
        
        if (Request::ajax()) {
		
        	 
         $notes_id = Knowledgebase::where("knowledgebase_id","=",$edited_id)->delete();
        
        $data['knowledge_notes']=Knowledgebase::where('user_id','=',$user_id)->select("knowledgebase_id","user_id","title","textmessage","file","created")->orderBy('created', 'DESC')->first();
        $user=$data['knowledge_notes']['user_id'];
              // die();
               
        $data['user'] = User::where("user_id","=",$user)->select("fname", "lname","user_id")->first();  
        
        
        echo View::make('knowledgebase.notesedit', $data);
        	//echo $data;
		
        }
        
        
    }
    
    public function deletearticlefile()
    {
        $deleted_id = Input::get("deleted_id");
         //$client_id = Input::get("client_id");
        $admin_s = Session::get('admin_details');
		$user_id = $admin_s['id'];
        
        
        
        $data['file']="";
        if (Request::ajax()) {
		
        	 Knowledgebase::where("knowledgebase_id", "=", $deleted_id)->update($data);
            echo 1;
        	
		
        }
        
        
        
        
        
    }
    

}
