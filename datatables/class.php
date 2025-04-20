<?php

function normalise_description($description) {
	$description = preg_replace('/–/', '-',$description);
	$description = preg_replace('/\s+/', ' ',$description);
	return mysql_real_escape_string(trim($description));
}

function normalise_description_for_matching($description) {
	$description = preg_replace('/–/', '-',$description);
	$description = preg_replace('/\s+/', '',$description);
	return mysql_real_escape_string(strtolower(trim($description)));
}

function normalise_description_for_matching_no_escape($description) {
	$description = preg_replace('/–/', '-',$description);
	$description = preg_replace('/\s+/', '',$description);
	return strtolower(trim($description));
}

class APCODE{
    public $id;
    public $code;
    public $description;
    public $production_system_id;
	public $user_id;
	public $manager_id;
	public $alias;
    public function __construct($id=0) {
        if($id!=0){
            $this->get_code_from_id($id);
        }else{
	        $this->id=0;
	        $this->code=0;
	        $this->description='';
	        $this->production_system_id=0;
	        $this->user_id=0;
	        $this->manager_id=0;
			$this->alias='';
		}
        return $this;
    }
    public function update_apcode($code,$description){
        global $wpdb;
        $this->code=$code;
        $this->description=$description;
        $sql="update wp_user_code set code='".$code."',description='".normalise_description($description)."' where id='".$this->id."'";
        $wpdb->query($sql);
        return $this;
    }
    public function update_apcode_alias($alias){
        global $wpdb;
        $this->code=$code;
        $this->description=$description;
        $sql="update wp_user_code set alias='".normalise_description($alias)."' where id='".$this->id."'";
        $wpdb->query($sql);
        return $this;
    }
    public function get_code_from_id($id){
        global $wpdb;
        $sql="select * from wp_user_code where id='".$id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$id;
            $this->code=$rows[0]->code;
            $this->description=$rows[0]->description;
            $this->production_system=$rows[0]->production_system_id;
			$this->user_id=$rows[0]->user_id;
			$this->manager_id=$rows[0]->manager_id;
			$this->alias=$rows[0]->alias;
            return $this;
        }else{
            return 0;
        }
    }
    public function get_from_code_and_ap($code,$production_system_id){
        global $wpdb;
        $sql="select * from wp_user_code where code='".$code."' and production_system_id='".$production_system_id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$rows[0]->id;
            $this->code=$rows[0]->code;
            $this->description=$rows[0]->description;
            $this->production_system_id=$rows[0]->production_system_id;
			$this->user_id=$rows[0]->user_id;
			$this->manager_id=$rows[0]->manager_id;
			$this->alias=$rows[0]->alias;
        }else{
            $this->id= 0;
        }
        return $this;
    }
    public function get_from_user_and_code_and_ap($user_info, $code,$production_system_id){
        global $wpdb;
        $sql="select * from wp_user_code where code='".
			  mysql_real_escape_string(trim($code))."' and production_system_id='".
			  mysql_real_escape_string($production_system_id)."' and manager_id='" . $user_info->get_manager_id() . "'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$rows[0]->id;
            $this->code=$rows[0]->code;
            $this->description=$rows[0]->description;
            $this->production_system_id=$rows[0]->production_system_id;
			$this->user_id=$rows[0]->user_id;
			$this->manager_id=$rows[0]->manager_id;
			$this->alias=$rows[0]->alias;
        }else{
            $this->id= 0;
        }
        return $this;
    }
	// Match code by user_info, description and AP ID
    public function match_code_by_des($user_info,$des,$production_system_id){
        global $wpdb;
        $search_strings = SEARCH_TAGS::getTagsForMatching($des);
        array_unshift($search_strings, normalise_description_for_matching($des));
        
        $sql="select * from wp_user_code where LOWER(replace(description,' ','')) in ('" . implode("','", $search_strings) . "') and manager_id='"
			 .$user_info->get_manager_id()."' and production_system_id='".$production_system_id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
           $this->id=$rows[0]->id;
            $this->code=$rows[0]->code;
            $this->description=$rows[0]->description;
            $this->production_system_id=$rows[0]->production_system_id;
			$this->user_id=$rows[0]->user_id;
			$this->manager_id=$rows[0]->manager_id;
			$this->alias=$rows[0]->alias;
        }else{
            $this->id=0;
        }
        return $this;
    }
	// Plural match code by user_info, description and AP ID
    public function match_code_by_des_plural($user_info, $des,$production_system_id){
        global $wpdb;
        $search_strings = SEARCH_TAGS::getTagsForMatching($des);
        array_unshift($search_strings, normalise_description_for_matching($des));
        array_unshift($search_strings, normalise_description_for_matching($des)."s");

        $sql="select * from wp_user_code where LOWER(replace(description,' ','')) in ('" . implode("','", $search_strings) . 
             "') and manager_id='".$user_info->get_manager_id()."' and production_system_id='".$production_system_id."'";
        $rows=$wpdb->get_results($sql);
        if(!isset($rows[0]->code)){
            return 0;
        }else{
            $this->id=$rows[0]->id;
            $this->code=$rows[0]->code;
            $this->description=$rows[0]->description;
            $this->production_system_id=$rows[0]->production_system_id;
			$this->user_id=$rows[0]->user_id;
			$this->manager_id=$rows[0]->manager_id;
			$this->alias=$rows[0]->alias;
            return $this;
        }
    }
	public function insert_into_db($user_info,$code,$description,$production_system_id) {
        global $wpdb;
		$sql = "insert into wp_user_code (code,description,user_id,production_system_id,manager_id) values('".
			mysql_real_escape_string(trim($code))."','".normalise_description($description)."','".$user_info->ID."','".
			mysql_real_escape_string($production_system_id)."','" . $user_info->get_manager_id() . "')";
	    $wpdb->query($sql);
		$this->id=$wpdb->insert_id;
		return $this->id;
	}
	
	public function insert_into_db_unless_found($user_info,$code,$description,$production_system_id) {
		$this->get_from_user_and_code_and_ap($user_info,$code, $production_system_id);
        if($this->ID==0){
			$this->insert_into_db($user_info,$code,$description,$production_system_id);
        }
		return $this;
	}
	
	public function reset_last_import_for_user($user_info) {
        global $wpdb;
		$sql_update="update wp_user_code set last_import='0' where user_id='".$user_info->ID."' and last_import='1'";
	    $wpdb->query($sql_update);
	    return $this;
	}
}
class SEARCH_TAGS {
/* static functions */
	public function insert_tag($description, $tag) {
		global $wpdb;
		return $wpdb->insert('wp_search_tags',
						array(
							'description' => trim($description),
							'tag' => trim($tag)
						));
	}
	public function delete_tag($description, $tag) {
		global $wpdb;
		return $wpdb->delete('wp_search_tags',
						array(
							'description' => trim($description),
							'tag' => trim($tag)
						));
	}
	public function delete_tag_by_id($id) {
		global $wpdb;
		return $wpdb->delete('wp_search_tags',
						array(
							'id' => $id
						));
	}
	public function getTagsForMatching($description, $with_plural = false) {
		global $wpdb;
		$rows = $wpdb->get_results($wpdb->prepare("SELECT tag FROM wp_search_tags WHERE description = %s",
				normalise_description_for_matching_no_escape($description)));
		$tags = array();
		foreach ($rows as $row)	{
			$tags[] = normalise_description_for_matching($row->tag);
			if ($plural) {
				$tags[] = normalise_description_for_matching($row->tag) . 's';
			}
		}
		return $tags;
	}
}

class CLIENT_CODE{
    public $id;
    public $code;
    public $description;
    public $production_system_id;
    public $match_id;
    public $client_id;
    public $user_id;
    public $manager_id;
	public $last_import;
    public function __construct() {
        $this->id=0;
        $this->code=0;
        $this->description='';
        $this->production_system_id=0;
        $this->client_id=0;
        $this->user_id=0;
        $this->match_id=0;
        $this->manager_id=0;
		$this->last_import=0;
        return $this;
    }
    public function update_client_code($code,$description){
        global $wpdb;
        $this->code=$code;
        $this->description=$description;
        $sql="update wp_client_code set code='".$code."',description='".normalise_description($description)."' where id='".$this->id."'";
        $wpdb->query($sql);
    }
    public function get_code_by_id($id){
        global $wpdb;
        $sql="select * from wp_client_code where id='".$id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$id;
            $this->code=$rows[0]->code;
            $this->description=$rows[0]->description;
            $this->production_system_id=$rows[0]->production_system_id;
            $this->match_id=$rows[0]->match_id;
            $this->client_id=$rows[0]->client_id;
            $this->user_id=$rows[0]->user_id;
            $this->manager_id=$rows[0]->manager_id;
			$this->last_import=$rows[0]->last_import;
        }
        return $this;
    }
    public function delete_code_by_id($id=0){
        global $wpdb;
        if($id==0){
            $sql="delete from wp_client_code where id='".$this->id."'";
        }else{
            $sql="delete from wp_client_code where id='".$id."'";
        }
        $wpdb->query($sql);
    }
    public function check_code_exist($code,$description,$client_id,$user_info){
        global $wpdb;
        $sql="select * from wp_client_code where code='".$code."' and LOWER(replace(description,' ',''))='".normalise_description_for_matching($description)."' and manager_id='".
			 $user_info->get_manager_id()."' and client_id='".$client_id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$rows[0]->id;
            $this->code=$rows[0]->code;
            $this->description=$rows[0]->description;
            $this->production_system_id=$rows[0]->production_system_id;
            $this->match_id=$rows[0]->match_id;
            $this->client_id=$rows[0]->client_id;
            $this->user_id=$rows[0]->user_id;
            $this->manager_id=$rows[0]->manager_id;
			$this->last_import=$rows[0]->last_import;
        }else{
            $this->id=0;
        }
        return $this;
    }
    public function match_code_by_des($des,$client_id){
        global $wpdb;
        $search_strings = SEARCH_TAGS::getTagsForMatching($des);
        array_unshift($search_strings, normalise_description_for_matching($des));
        
        $sql="select * from wp_client_code where LOWER(replace(description,' ','')) in ('" . implode("','", $search_strings) . "')  and client_id='".$client_id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
           $this->id=$rows[0]->id;
            $this->code=$rows[0]->code;
            $this->description=$rows[0]->description;
            $this->production_system_id=$rows[0]->production_system_id;
            $this->match_id=$rows[0]->match_id;
            $this->client_id=$client_id;
            $this->user_id=$rows[0]->user_id;
            $this->manager_id=$rows[0]->manager_id;
			$this->last_import=$rows[0]->last_import;
        }else{
            $this->id=0;
        }
        return $this;
    }
	public function insert_code_from_other_clients($des, $client_id, $production_system_id) {
        global $wpdb;
        $sql="select id from wp_client where production_system_id='".$production_system_id."' and id!='".$client_id."'";
        $other_client_ids=$wpdb->get_results($sql);
        $search_strings = SEARCH_TAGS::getTagsForMatching($des);
        array_unshift($search_strings, normalise_description_for_matching($des));

		if (count($other_client_ids) > 0) {
			$client_ids_arr = array();
			foreach($other_client_ids as $client) {
				$client_ids_arr[] = $client->id;
			}			
			$sql="select * from wp_client_code where LOWER(replace(description,' ','')) in ('" . implode("','", $search_strings) . "') and client_id in (" . join(',', $client_ids_arr) . ")";
	        $rows=$wpdb->get_results($sql);
	        if(count($rows)>0){
		    	$this->id=$rows[0]->id;
	            $this->code=$rows[0]->code;
	            $this->description=$rows[0]->description;
	            $this->production_system_id=$rows[0]->production_system_id;
	            $this->match_id=$rows[0]->match_id;
	            $this->client_id=$client_id;
	            $this->user_id=$rows[0]->user_id;
	            $this->manager_id=$rows[0]->manager_id;
				$this->last_import=$rows[0]->last_import;
	            $this->insert_client_code();
	        }else{
	            $this->id=0;
	        }
		} else {
            $this->id=0;
		}
        return $this;
	}
    public function insert_client_code_with_values($code, $description, $production_system_id, $match_id, $client_id, $user_info, $last_import=0){
		$this->code=$code;
		$this->description=$description;
		$this->production_system_id=$production_system_id;
		$this->match_id=$match_id;
		$this->client_id=$client_id;
		$this->user_id=$user_info->ID;
		$this->manager_id=$user_info->get_manager_id();
		$this->last_import=$last_import;
		return $this->insert_client_code();
	}
    public function  insert_client_code(){
        global $wpdb;
        $sql="insert into wp_client_code(code,description,production_system_id,match_id,client_id,user_id,manager_id,last_import) 
            values('".$this->code."','".normalise_description($this->description)."','".$this->production_system_id."','".
			$this->match_id."','".$this->client_id."','".$this->user_id . "','" . $this->manager_id . "','" . $this->last_import . "')";
        if(!$wpdb->query($sql)){
			error_log("CLIENT_CODE insert_client_code error - [$sql].");
            echo $sql;            
        }else{
            $this->id=$wpdb->insert_id;
            return $this;
        }
    }
	// copy function, not copying id
	public function copy() {
		$new_client=new CLIENT_CODE();
		$new_client->code=$this->code;
		$new_client->description=$this->description;
		$new_client->production_system_id=$this->production_system_id;
		$new_client->match_id=$this->match_id;
		$new_client->client_id=$this->client_id;
		$new_client->user_id=$this->user_id;
		$new_client->manager_id=$this->manager_id;
		return $new_client;
	}
	/* Client codes - TODO: shouldn't be used */
    public function insert_client_code_to_other_client($client_id,$user_id){
		$other_client = $this->copy();
		$other_client->insert_client_code();
		return $other_client->id;
    }
    //insert into client code with description bookkeeping
    public function insert_from_apcode($user_info,$apcode,$client_id,$des_bk){
		$this->code = $apcode->code;
		$this->description=$des_bk;
		$this->production_system_id=$apcode->production_system_id;
		$this->match_id=$apcode->id;
		$this->client_id=$client_id;
		$this->user_id=$user_info->ID;
		$this->manager_id=$user_info->get_manager_id();
		return $this->insert_client_code();
    }
}
class CLIENT{
    public $id;
    public $client_name;
    public $user_id;
    public $manager_id;
    public $production_system_id;
    public $client_code_other;
	public $wp_client_reference;
    public function __construct($id=0) {
        if($id!=0){
            $this->get_client_by_id($id);
        }else{
            $this->id=0;
            $this->client_name='';
            $this->user_id=0;
            $this->manager_id=0;
            $this->production_system_id=0;
			$this->wp_client_reference='';
        }
        return $this;
    }
	/*Add Client*/
	// returns true if insert was successful, false if the client name-manager id pair already exist
	public function add_client($client_name, $user_info){
	    global $wpdb;	
	    return $wpdb->insert('wp_client',
						array(
							'user_id' => $user_info->ID,
							'manager_id' => $user_info->get_manager_id(),
							'client_name' => trim(strtolower($client_name))
						));
	}
    public function delete_client($id){
        global $wpdb;
        $this->id=$id;
        $wpdb->delete('wp_client', array('id' => $id));
		$this->delete_client_codes($id);
		$this->delete_xero_client_accounts();
        return $this;
    }
	public function rename($new_name) {
		global $wpdb;
		$new_name = trim(strtolower($new_name));
		$ret = $wpdb->update( "wp_client", 
				array('client_name' => $new_name), 
				array('id' => $this->id) );
		if ($ret !== false) {
			// update object client_name if successful
			$this->client_name=$new_name;
			return 1;
		} else {
			return 0;
		}
	}
    public function delete_client_codes(){
        global $wpdb;
        $wpdb->delete('wp_client_code', array('client_id' => $this->id));
        return $this;
    }
    public function delete_xero_client_accounts(){
		$xero_ca = new XERO_CLIENT_ACCOUNTS();
		$xero_ca->delete_accounts_by_client($this->id);
		return $this;
    }
    public function get_client_by_id($id){
        global $wpdb;
        $sql=$wpdb->prepare("select * from wp_client where id=%d", $id);
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$id;
            $this->client_name=$rows[0]->client_name;
            $this->user_id=$rows[0]->user_id;
            $this->manager_id=$rows[0]->manager_id;
            $this->production_system_id=$rows[0]->production_system_id;
            $this->wp_client_reference=$rows[0]->wp_client_reference;
        }
        return $this;
    }
    public function update_production_system($production_system_id){
        $this->production_system_id=$production_system_id;
        global $wpdb;
        $wpdb->update('wp_client',
				array('production_system_id' => $production_system_id),
				array('id' => $this->id));
        return $this;
    }    
    public function update_wp_client_reference($wp_client_reference){
        $this->wp_client_reference=trim($wp_client_reference);
        global $wpdb;
		$ret = $wpdb->update( 'wp_client', 
				array('wp_client_reference' => $this->wp_client_reference), 
				array('id' => $this->id) );
		if ($ret === false) {
			error_log("ERROR updating client reference to $wp_client_reference, client_id=" . $this->ID);
			return false;
		} else {
			error_log("SUCCESS!! Updated client reference to $wp_client_reference, client_id=" . $this->ID);
			return true;
		}
    }    
    public function get_client_by_name_and_user($client_name, $user_info){
        global $wpdb;
        $sql=$wpdb->prepare("select * from wp_client where LOWER(client_name)=%s and manager_id=%d",
						trim(strtolower($client_name)), $user_info->get_manager_id());
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->id=$rows[0]->id;
            $this->client_name=$rows[0]->client_name;
            $this->user_id=$rows[0]->user_id;
            $this->manager_id=$rows[0]->manager_id;
            $this->production_system_id=$rows[0]->production_system_id;
            $this->wp_client_reference=$rows[0]->wp_client_reference;
        }
        return $this;
    }
    /*TODO: calls to this function are all commented out - insert all client code of a product system for new client*/
    public function update_code_wide_map_for_new_client(){
        global $wpdb;
        $a=array();
        if($this->id!=0&&$this->production_system_id!=0&&$this->user_id!=0){
            $sql=$wpdb->prepare("select * from wp_client_code where production_system_id=%d", $this->production_system_id);
            $rows=$wpdb->get_results($sql);

            foreach ($rows as $row){
				$ccode = new CLIENT_CODE();
				$ccode->code=$row->code;
				$ccode->description=$row->description;
				$ccode->user_id=$this->user_id;
				$ccode->client_id=$this->id;
				$ccode->match_id=$row->match_id;
				$ccode->production_system_id=$row->production_system_id;
				$ccode->manager_id=$this->manager_id;
				$ccode->insert_client_code();
				if ($ccode->id==0) {
                    die('Error inserting client code.');
                }                
            }            
        } else {
            die('Cannot insert client code without client id, production system id and user info');
        }
    }

	public function check_client_production_exist($production_system_id,$client_id){
	    global $wpdb;
	    $sql=$wpdb->prepare("select * from wp_client_production_system where production_system_id=%d and client_id=%d",
					$production_system_id, $client_id);
	    $rows= $wpdb->get_results($sql);
	    if(count($rows)>0){
	        return 1;
	    }else{
	        return 0;
	    }
	}

	public function update_client_production_system($production_system_id, $client_id) {
        global $wpdb;
	    $wpdb->delete('wp_client_production_system', array('client_id' => $client_id));
	    if($this->check_client_production_exist($production_system_id,$client_id)==0){
			// insert using manager id??
	        $wpdb->insert('wp_client_production_system',
					array(
						'production_system_id' => $production_system_id,
						'client_id' => $client_id
					));
	    }
		return $this;
	}
	
	public function get_client_code_and_ap_desc() {
	    global $wpdb;
	    $sql=$wpdb->prepare("SELECT cc.*, uc.description as ap_description FROM `wp_client_code` cc " .
			 "LEFT JOIN wp_user_code uc ON cc.match_id=uc.id WHERE client_id=%d", $this->id);
	    $rows=$wpdb->get_results($sql);
	    return $rows;		
	}
	
	public function get_workpapers() {
		global $wpdb;
		$sql=$wpdb->prepare("SELECT * FROM wp_workpapers WHERE client_id=%d and is_archived='0'", $this->ID);
		$rows=$wpdb->get_results($sql);
		return $rows;
	}
}
class CLIENTS{
    public $user_id;
    public $clients;
    public  function __construct() {
        $this->clients=array();
    }
    public function get_clients_by_user($user_info){
        global $wpdb;
        $sql="select * from wp_client where manager_id='".$user_info->get_manager_id()."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)){
            $this->clients=$rows;
        }
        return $this;
    }
}
class PRODUCTION_SYSTEM{
    public  $id;
    public  $name;
    public  $user_id;
    public  $ap_system_id;
    public  $chart_type;
	public 	$manager_id;
    public  function __construct($id=0) {
		if ($id==0) {
	        $this->id=0;
	        $this->name='';
	        $this->user_id=0;
	        $this->clients=array();
	        $this->ap_system_id=0;
	        $this->chart_type=0;
	        $this->manager_id=0;
		} else {
			$this->get_by_id($id);
		}
        return $this;
    }
	public function get_by_id($id) {
        global $wpdb;
        $this->id=$id;
        $sql="select * from wp_ap_systems where production_system_id='".$id."' ";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->name=$rows[0]->name;
            $this->chart_type=$rows[0]->chart_type_id;
	        $this->user_id=$rows[0]->user_id;
	        $this->manager_id=$rows[0]->manager_id;
	        $this->ap_system_id=$rows[0]->original_ap_system_id;
        }		
	}
    public function get_name_ap_system(){
        global $wpdb;
        $sql="select name from wp_ap_systems where production_system_id='".$this->ap_system_id."'";
        $rows=$wpdb->get_results($sql);
        return $rows[0]->name;
    }
    public function set_chart_type($chart_type_id){
        global $wpdb;
		$this->chart_type=$chart_type_id;
        $sql="update wp_ap_systems set chart_type_id='".$chart_type_id."' where production_system_id='".$this->id."'";
        $wpdb->query($sql);
        return $this;
    }
    public function set_ap_system_id($ap_system_id){
        global $wpdb;
        $this->ap_system_id=$ap_system_id;
        $sql="update wp_ap_systems set original_ap_system_id='".$ap_system_id."' where production_system_id='".$this->id."'";
        $wpdb->query($sql);
        return $this;
    }
    public function get_codes(){
        global $wpdb;
        $sql="select id,code,description from wp_user_code where production_system_id='".$this->id."' order by code";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            return $rows;
        }else{
            return 0;
        }
    }
	public function add_user_production_system($user_info, $production_system_name, $chart_type_id, $ap_system_id){
	    global $wpdb;
	    $sql="insert into wp_ap_systems (name,chart_type_id,original_ap_system_id,user_id,manager_id) VALUES ('" . 
			 mysql_real_escape_string($production_system_name) . "','" . mysql_real_escape_string($chart_type_id) . "','" . 
			 mysql_real_escape_string($ap_system_id) . "','" . $user_info->ID . "','" . $user_info->get_manager_id() . "')";
		$wpdb->query($sql);
		$this->id=$wpdb->insert_id;
		return $this;
	}
	public static function check_production_system_exist($user_info, $production_system){
	    global $wpdb;
		// include admin ap systems
	    $sql="select * from wp_ap_systems where name='".$production_system."' and (manager_id='" . $user_info->get_manager_id() 
			 . "' or user_id='1')";
	    $rows=$wpdb->get_results($sql);
	    if(count($rows)>0){
	        return 1;
	    }else{
	        return 0;
	    }
	}
    //get all production system of admin
    public static function get_admin_production_system(){
        global $wpdb;
        $sql ="select * from wp_ap_systems where user_id='1' order by production_system_id";
        $rows=$wpdb->get_results($sql);
        return $rows;
    }
	public static function delete_production_system_and_codes($production_system_id) {
	    global $wpdb;
	    $sql="delete from wp_user_code where production_system_id='".$production_system_id."'";
	    $wpdb->query($sql);
        $sql1="delete from wp_ap_systems where production_system_id='".$production_system_id."'";
        $wpdb->query($sql1);
        return $this;	
	}
	//get all production system
	public static function get_production_system_for_team($user_info) {
	    global $wpdb;
	    $sql="select * from wp_ap_systems where manager_id='" . $user_info->get_manager_id() . "'";
	    $rows=$wpdb->get_results($sql);
	    return $rows;
	}
	//get production system of user
	public static function get_production_system_for_user($user_id){
	    global $wpdb;
	    $sql="select * from wp_ap_systems where user_id='" . $user_id . "'";
	    $rows=$wpdb->get_results($sql);
	    return $rows;
	}
		
	//get code from wp_user_code by user and production system with sort
	function get_user_code_by_id_with_sort($user_info,$production_system_id,$sort){
	    global $wpdb;
	    if($sort=='code'){
	        $sql="select * from wp_user_code where manager_id='".$user_info->get_manager_id()."' and production_system_id='".$production_system_id."' order by ABS(code)";
	    }else{
	        $sql="select * from wp_user_code where manager_id='".$user_info->get_manager_id()."' and production_system_id='".$production_system_id."' order by description";
	    }
	    $rows=$wpdb->get_results($sql);
	    if(count($rows)>0){
	        return $rows;
	    }else{
	        return 0;
	    }
	}
}
class CSV_LAST_FILE{
    public $id;
    public $csv_file;
    public $excel_file;
    public $path_csv_file;
    public $path_excel_file;
    public $export;
    public $user_id;
	public $production_system_id;
	public $name;
	public $description;
	public $date_from;
	public $date_to;
	public $source;
	public $wide_map;
	
    public function __construct($user_id=0) {
		// init
        $this->id=0;
        $this->csv_file='';
        $this->excel_file='';
        $this->export=0;
        $this->user_id=$user_id;
        $this->path_csv_file='';
        $this->path_excel_file='';
		$this->production_system_id=0;
		$this->name='';
		$this->description='';
		$this->client_id=0;
		$this->date_from=0;
		$this->date_to=0;
		$this->source=0;
		$this->wide_map=0;
		
		global $wpdb;
		if ($user_id != 0) {
	        $sql="select * from wp_csv_file where user_id='".$user_id."' and last_file='1' and opening_balance=false";
	        $rows=$wpdb->get_results($sql);
	        if(count($rows)>0){
	            $this->id=$rows[0]->id;
	            $this->csv_file=$rows[0]->csv_file;
	            $this->excel_file=$rows[0]->excel_file;
	            $this->path_csv_file=$rows[0]->path_csv_file;
	            $this->path_excel_file=$rows[0]->path_excel_file;
	            $this->export=$rows[0]->export;
				$this->production_system_id=$rows[0]->production_system_id;
				$this->name=$rows[0]->name;
				$this->description=$rows[0]->description;
				$this->client_id=$rows[0]->client_id;
				$this->date_from=$rows[0]->date_from;
				$this->date_to=$rows[0]->date_to;
				$this->source=$rows[0]->source;
				$this->wide_map=$rows[0]->wide_map;
	        }
		}		
    }

	public function get_csv_file_name() {
		return end(explode("/", $this->csv_file));
	}
}
class USER_INFO extends WP_User{
    public $expire;
    public $num_imports;
    public $manager_id;
    public $user_news;
    public $user_invited;
    public $access;
    public $members;
    public $account_status;
    public $limit_import_status;
    
    function remove_user_friend($user_id){
        $a=array();
        foreach ($this->user_friends as $user_friend_id){
            if($user_friend_id!=$user_id){
                $a[]=$user_friend_id;
            }
        }
        $this->user_friends=$a;
        update_user_meta($this->ID, "_user_friends", $a);
        $b=  $this->user_news;
        $b[]=$user_id;
        $this->user_news=$b;
        $user2 = new USER_INFO($user_id);
        $c=array();
        foreach ($user2->user_friends as $user_friend_id2){
            if($this->ID!=$user_friend_id2){
                $c[]=$user_friend_id2;
            }
        }
        $user2->user_friends=$c;
        update_user_meta($user_id, "_user_friends", $c);
        $d=$user2->user_news;
        $d[]=  $this->ID;
        $user2->user_news=$d;
        return $this;
    }
    function invite_user($user_id){
        $a=  $this->user_invites;
        $a[]=$user_id;
        $this->user_invites=$a;
        update_user_meta($this->ID, "_user_invites", $a);
        $this->get_user_news();
        $user2=new USER_INFO($user_id);
        $b=$user2->user_confirms;
        $b[]=  $this->ID;
        $user2->user_confirms=$b;
        update_user_meta($user_id, "_user_confirms", $b);
        $user2->get_user_news();
        return $this;
    }

    function get_colleagues(){
        global $wpdb;
        $sql=$wpdb->prepare("SELECT u.ID, u.display_name FROM " .
				"wp_users u LEFT JOIN wp_user_member um " .
				"ON u.ID=um.member_id " .
				"WHERE um.manager_id=%d OR u.ID=%d ORDER BY u.display_name",
				$this->get_manager_id(), $this->get_manager_id());
        return $wpdb->get_results($sql);
    }

	// static helper
	function get_initials_for_user_id($user_id) {
		$tokens = explode(' ', get_userdata($user_id)->display_name);
		$initials = '';
		foreach ($tokens as $token) {
			$initials .= strtoupper($token[0]);
		}
		return $initials;
	}
	
    function get_user_member(){
        global $wpdb;
        $a=array();
        if($this->manager_id==0){
            $sql="select * from wp_user_member where manager_id='".$this->ID."'";
            $rows=$wpdb->get_results($sql);
            if(count($rows)>0){
                foreach ($rows as $row){
                    $a[]=$row->member_id;
                }
            }
        }
        $this->members=$a;
        return $this;
    }
    function set_account_status($status){
        $this->account_status=$status;
        update_user_meta($this->ID, "_account_status", $status);
    }
    function set_limit_import_status($status){
        $this->limit_import_status=$status;
        update_user_meta($this->ID, "_limit_import_status", $status);
    }
    function __construct($id = 0, $name = '', $blog_id = '') {
        global $wpdb;
        parent::__construct($id, $name, $blog_id);
        $this->expire=0;
        $this->num_imports=0;
        $this->manager_id=0;
        $this->user_invited=array();
        $this->members=array();
        $this->_get_manager();
        //trial account or live account
        $this->account_status=0;
        $this->package_buy=array();
        if(get_user_meta($this->ID,"_access",true)==''){
            $a=array();
            $a['r_import_account_production_charts']=0;
            $a['r_import_new_clients']=0;
            $a['r_import_posting_files']=0;
            $a['r_view_edit_delete_clients_speccific_maps']=0;
            update_user_meta($this->ID, "_access", $a);
            $this->access=$a;
        }else{
            $this->access=  get_user_meta($this->ID,"_access",true);
        }        
        if(get_user_meta($this->ID,"_limit_import_status",true)==''){
            update_user_meta($this->ID, "_limit_import_status", 0);
            $this->limit_import_status=0;
        }else{
            $this->limit_import_status=get_user_meta($this->ID,"_limit_import_status",true);
        }
        if($this->manager_id==0){
            if(get_user_meta($this->ID,"_account_status",true)==''){
                update_user_meta($this->ID, "_account_status", 0);
                $this->account_status=0;
            }else{
                $this->account_status=get_user_meta($this->ID,"_account_status",true);
            }
        }else{
            if(get_user_meta($this->manager_id,"_account_status",true)==''){
                update_user_meta($this->manager_id, "_account_status", 0);
                $this->account_status=0;
            }else{
                $this->account_status=get_user_meta($this->manager_id,"_account_status",true);
            }
        }
        if(get_user_meta($this->ID,"_user_invited",true)==''){
            $a=array();
            update_user_meta($this->ID, "_user_invited", $a);
            $this->user_invited=$a;
        }else{
            $this->user_invited=get_user_meta($this->ID,"_user_invited",true);
        }
        if($this->roles[0]!='member'){
            if(get_user_meta($this->ID,"_timeExpire",true)==''){
                update_user_meta($this->ID, "_timeExpire", time()+30*24*60*60);
                $this->expire=time()+30*24*60*60;
            }else{
                $this->expire=get_user_meta($this->ID,"_timeExpire",true);
            }
            if(get_user_meta($this->ID,'_num_imports',true)!=''){
                $this->num_imports=  get_user_meta($this->ID,'_num_imports',true);
            }else{
                update_user_meta($this->ID, '_num_imports', 10);
                $this->num_imports=10;
            }
        }
        if($this->roles[0]=='member'){
            $user_manager=new USER_INFO($this->manager_id);
            $this->expire=$user_manager->expire;
            $this->num_imports=$user_manager->num_imports;
        }
        if($this->roles[0]=='manager'){
            $this->get_user_member();
        }
        
    }
    function insert_tags($name,$description,$ap_system_id,$user_id,$client_id){
        global $wpdb;
        $sql="insert into wp_tags (name,description,ap_system_id,user_id,client_id) values('".$name."','".$description."','".$ap_system_id."','".$user_id."','".$client_id."')";
        if(!$wpdb->query($sql)){
            echo $sql;
            die();
        }
    }
    function get_all_package_pay(){
        global $wpdb;
        $sql="SELECT * FROM `wp_order` o left join wp_posts p ON o.product_id=p.ID WHERE user_id='".$this->ID."' order by order_id ASC";
        $rows=$wpdb->get_results($sql);
        $a=array();
        foreach ($rows as $row){
            $ob= new stdClass();
			$ob->order_id=$row->order_id;
            $ob->pack_title=$row->post_title;
            $ob->quantity=$row->quantity;
            $ob->pack_num_imports=  get_post_meta($row->product_id,"_import_times",true);
            $ob->pack_price=  get_post_meta($row->product_id,'_import_times_price',true);
            $ob->pack_time=date('m/d/Y',$row->time_pay);
            $ob->email=$row->email;
            $a[]=$ob;
        }
        return $a;
    }
	function delete_order($order_id) {
        global $wpdb;
		$sql="delete from wp_order where user_id='".$this->ID."' and order_id='" . mysql_real_escape_string($order_id) . "'";
        $wpdb->query($sql);
        return $this;
	}
    function get_all_tags(){
        global $wpdb;
        $sql="select * from wp_tags where user_id='".$this->ID."'";
        $rows=$wpdb->get_results($sql);
        return $rows;
    }
    function delete_user_invite($user_id){
        $a=array();
        foreach ($this->user_invited as $uid){
            if($uid!=$user_id){
                $a[]=$uid;
            }
        }
        $this->user_invited=$a;
        update_user_meta($this->ID, "_user_invited", $a);
        wp_delete_user($user_id);
    }
//    function move_invite_to_member($memberId){
//        $a=array();
//        foreach ($this->user_invited as $inviteId){
//            if($inviteId!=$memberId){
//                $a[]=$inviteId;
//            }
//        }
//        $this->user_invited=$a;
//        update_user_meta($this->ID, "_user_invited", $a);
//        add_user_member($this->ID, $memberId);
//    }
    function invite_new_user($user_name,$user_email){
        $base_url=  get_option('siteurl');
        if($user_name!=''&&$user_email!=''){
            $user_id = username_exists( $user_email );
            if ( !$user_id and email_exists($user_email) == false ) {
            
                $data=array();
                $data['user_nicename']=$user_name;
                $data['user_login']=$user_email;
                $password=  generateRandomString(6);
                $data['user_pass']=$password;
                $data['user_email']=$user_email;
                $data['role']='manager';
                //$data['user_activation_key']=  generateRandomString(30);
                $user_id =wp_insert_user( $data );
                $user_manager=new USER_INFO($user_id);
                $access=array();
                $access['r_invite_users']=1;
                $access['r_import_account_production_charts']=1;
                $access['r_import_new_clients']=1;
                $access['r_taging']=1;
                $access['r_import_posting_files']=1;
                $access['r_view_edit_delete_clients_speccific_maps']=1;
                $user_manager->set_access($access);
                $user_manager->set_number_import(100);
                $a=array();
                if(count($this->user_invited)>0){
                    foreach ($this->user_invited as $user_invited_id){
                        $aux = get_userdata($user_invited_id );
                        if($aux==true){
                            $a[]=$user_invited_id;
                        }
                    }
                }
                $a[]=$user_manager->ID;
                $this->user_invited=$a;
                update_user_meta($this->ID, "_user_invited", $a);
                $to = $data['user_email'];
                $subject = "TB Coder";
                
                $message = "Do you want to join in TB Coder ";
                $message .="Please click this link to accept ".$base_url."/accept?p=".generateRandomString(30)."&email=".$data['user_email']."&id=".$user_id."&pinviteid=".$this->ID;
                $from = "TB Coder";
                $headers = "From:" . $from;
                mail($to,$subject,$message,$headers);
            } else {
                echo 'User already exists.  Password inherited.';
                die();
            }    
        }
        return $this;
    }
    function set_num_days_expire($numDay){
        if($this->roles[0]=='manager'){
            update_user_meta($this->ID, "_timeExpire", time()+$numDay*24*60*60);
            $this->expire=time()+$numDay*24*60*60;
        }
        return $this;
    }
    function set_expire($timeExpire){
        update_user_meta($this->ID, "_timeExpire", $timeExpire);
        $this->expire=$timeExpire;
    }
    function get_time_remain(){
        $timeExpire=  $this->expire;
        $timeNow=time();
        if($timeExpire>$timeNow){
            $days=floor(($timeExpire-$timeNow)/86400);
            $expire= $days;
        }else{
            $expire="0";
        }
        return $expire;
    }
    function delete_user($user_id){
        global $wpdb;
        if($this->ID==1){
            $a=array();
			$user_del = new USER_INFO($user_id);
			if ($user_del->is_manager) {
	            foreach ($user_del->members as $memberid){
	                $user_del->delete_member($member_id);
	            }
			}
            $sql="delete from wp_user_member where manager_id='".$user_id."' OR member_id='".$user_id."'";
            $wpdb->query($sql);
            wp_delete_user($user_id);
            $sql1="delete from wp_posts where post_author='".$user_id."'";
            $wpdb->query($sql1);
            $sql1="DELETE cp FROM wp_client_production_system AS cp INNER JOIN wp_ap_systems AS ap WHERE cp.production_system_id=ap.production_system_id AND ap.user_id='".
				  $user_id."'";
            $wpdb->query($sql1);
            $sql1="delete from wp_ap_systems where user_id='".$user_id."'";
            $wpdb->query($sql1);
            $sql2="delete from wp_user_code where user_id='".$user_id."'";
            $wpdb->query($sql2);
            $sql3="delete from wp_balance where userid='".$user_id."'";
            $wpdb->query($sql3);
            $sql4="delete from wp_csv_file where user_id='".$user_id."'";
            $wpdb->query($sql4);
            $sql5="delete from wp_client where user_id='".$user_id."'";
            $wpdb->query($sql5);
            $sql6="delete from wp_client_code where user_id='".$user_id."'";
            $wpdb->query($sql6);
            return $this;
        }
    }
    function delete_member($member_id){
        global $wpdb;
        if($this->manager_id==0){
            $a=array();
            $sql="delete from wp_user_member where manager_id='".$this->ID."' and member_id='".$member_id."'";
            $wpdb->query($sql);
            wp_delete_user($member_id);
            $sql1="delete from wp_posts where post_author='".$member_id."'";
            $wpdb->query($sql1);
            $sql1="DELETE cp FROM wp_client_production_system AS cp INNER JOIN wp_ap_systems AS ap WHERE cp.production_system_id=ap.production_system_id AND ap.user_id='".
				  $member_id."'";
            $wpdb->query($sql1);
            $sql1="delete from wp_ap_systems where user_id='".$member_id."'";
            $wpdb->query($sql1);
            $sql2="delete from wp_user_code where user_id='".$member_id."'";
            $wpdb->query($sql2);
            $sql3="delete from wp_balance where userid='".$member_id."'";
            $wpdb->query($sql3);
            $sql4="delete from wp_csv_file where user_id='".$member_id."'";
            $wpdb->query($sql4);
            $sql5="delete from wp_client where user_id='".$member_id."'";
            $wpdb->query($sql5);
            $sql6="delete from wp_client_code where user_id='".$member_id."'";
            $wpdb->query($sql6);
            foreach ($this->members as $memberid){
                if($member_id!=$memberid){
                    $a[]=$memberid;           
                }
            }
            $this->members=$a;
            update_user_meta($this->ID, "_member", $a);
            return $this;
        }
    }
	// get all team members
	function get_team_member_ids() {
        global $wpdb;
		$member_ids = array();
        $member_ids[] = $this->ID;
        if($this->manager_id==0){
            if(count($this->members)>0){
                foreach ($this->members as $memberid){
                    $member_ids[] = $memberid;
                }
				return $member_ids;
            }
        }else{
            if($this->roles[0]=='member'){
                //every user can see every client
                $user2=new USER_INFO($this->manager_id);
                return $user2->get_team_member_ids();
			}
        }
		return $member_ids;
	}
	// return team member IDs in the form of (1,2,3,4)
	function get_team_member_ids_joined() {
		$member_ids_arr = $this->get_team_member_ids();
		return '(' . implode(',', $member_ids_arr) . ')';
	}
    //get all clients of manager and user
    function get_client_manager_and_user(){
        global $wpdb;
        $sql="select * from wp_client where manager_id='".$this->get_manager_id() . "'";
        $rows=$wpdb->get_results($sql);
        return $rows;
    }
    function get_access(){
        return $this->access;
    }
    function set_access($a){
        $this->access=$a;
        update_user_meta($this->ID, "_access", $a);
    }
    public function set_number_import($number_import){
        $this->num_imports=$number_import;
        if($this->manager_id==0){
            update_user_meta($this->ID, "_num_imports",$number_import);
        }else{
            update_user_meta($this->manager_id, "_num_imports", $number_import);
        }
    }
	// Return self id if the user is a manager, otherwise, return manager's id
    public function get_manager_id(){
		return ($this->manager_id == 0 ? $this->ID : $this->manager_id);
	}
    public function is_manager(){
		return ($this->manager_id == 0);
	}
    protected function _get_manager(){
        global $wpdb;
        $sql="select manager_id from wp_user_member where member_id='".$this->ID."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $this->manager_id=$rows[0]->manager_id;
        }else{
            $this->manager_id=0;
        }
        return $this;
    }
    //get all type chart of admin
    function get_type_chart(){
        global $wpdb;
		// category = "Chart Type"
        $sql="SELECT p.* FROM wp_posts p, `wp_term_relationships` r where p.id=r.object_id and r.term_taxonomy_id=23 and p.post_author='1' order by p.id";
        return$wpdb->get_results($sql);
    }

	function _update_table_manager_id($table_name, $old_manager_id) {
        global $wpdb;
		$ret = $wpdb->update( $table_name, array('manager_id' => $this->ID), array('manager_id' => $old_manager_id) );
		if ($ret === false) {
			error_log("ERROR transferring $table_name code from manager_id=$old_manager_id to user_id=" . $this->ID);
		} else {
			error_log("SUCCESS!! Transferred $table_name code from manager_id=$old_manager_id to user_id=" . $this->ID);
		}
	}

	function make_manager(){
        global $wpdb;

		// If role is changed to manager, give the user manager access
		$access=array();
		$access['r_invite_users']=1;
		$access['r_import_account_production_charts']=1;
		$access['r_import_new_clients']=1;
		$access['r_taging']=1;
		$access['r_import_posting_files']=1;
		$access['r_view_edit_delete_clients_speccific_maps']=1;
		$this->set_access($access);

		// hand over manager access to this person
		if ($this->get_manager_id() != $this->ID) {
			$old_manager_id = $this->get_manager_id();

			// transfer users
			$this->_update_table_manager_id("wp_user_member", $old_manager_id);			

			// make him/her-self manager
			$wpdb->delete( "wp_user_member", array('member_id' => $this->ID));
			$this->manager_id=0;

			// transfer pay packages
			$ret = $wpdb->update( "wp_order", array('user_id' => $this->ID), array('user_id' => $old_manager_id) );
			if ($ret === false) {
				error_log("ERROR transferring pay packages from manager_id=$old_manager_id to user_id=" . $this->ID);
			} else {
				error_log("SUCCESS!! Transferred pay packages from manager_id=$old_manager_id to user_id=" . $this->ID);
			}

			// update tbcoder tables
			$this->_update_table_manager_id("wp_ap_systems", $old_manager_id);			
			$this->_update_table_manager_id("wp_balance", $old_manager_id);			
			$this->_update_table_manager_id("wp_client", $old_manager_id);			
			$this->_update_table_manager_id("wp_client_code", $old_manager_id);			
			$this->_update_table_manager_id("wp_open_balance", $old_manager_id);			
			$this->_update_table_manager_id("wp_user_code", $old_manager_id);			

			$old_manager = get_user_by('id', $this->get_manager_id());
			if ($old_manager !== false) {
				// old manager still exist
				// transfer remaining imports
				error_log("FOUND old manager id [" . $this->get_manager_id() . "], transferring remaining imports, expiry date and company details.");
				$old_manager = new USER_INFO($old_manager_id);
				$this->set_expire($old_manager->expire);
				$this->set_number_import($old_manager->num_imports);

				// transfer company details
				update_user_meta( $this->ID, 'practice_name', get_user_meta($old_manager->ID, 'practice_name', true) );
				update_user_meta( $this->ID, 'phone', get_user_meta($old_manager->ID, 'phone', true) );

				// make old manager a member
				wp_update_user( array( 'ID' => $old_manager_id, 'role' => 'member' ) );
				$wpdb->insert( "wp_user_member", array('manager_id' => $this->ID, 'member_id' => $old_manager_id));
				error_log("Old manager id [" . $this->get_manager_id() . "] will now be a member.");
			} else {
				error_log("CANNOT FIND old manager id [" . $this->get_manager_id() . "] (deleted), not transferring remaining imports, expiry date and company details.");
			}
		}
	}
}
class TAG{
    public $id;
    public $name;
    public $description;
    public $ap_system_id;
    public $user_id;
    public $client_id;
    function __construct($id=0) {
        if($id!=0){
            global $wpdb;
            $sql="select * from wp_tags where id='".$id."'";
            $rows=$wpdb->get_results($sql);
            if(count($rows)>0){
                $this->id=$rows[0]->id;
                $this->name=$rows[0]->name;
                $this->description=$rows[0]->description;
                $this->ap_system_id=$rows[0]->ap_system_id;
                $this->user_id=$rows[0]->user_id;
                $this->client_id=$rows[0]->client_id;
            }
        }else{
            $this->id=0;
            $this->name='';
            $this->description='';
            $this->ap_system_id=0;
            $this->user_id=0;
            $this->client_id=0;
        }
        return $this;
    }
    function update_tag($id,$name,$description,$ap_system_id,$user_id,$client_id){
        global $wpdb;
        $sql="update wp_tags set name='".$name."',description='".$description."',ap_system_id='".$ap_system_id."',user_id='".$user_id."',client_id='".$client_id."' where id ='".$id."'";
        $wpdb->query($sql);
        $this->id=$id;
        $this->name=$name;
        $this->description=$description;
        $this->ap_system_id=$ap_system_id;
        $this->user_id=$user_id;
        $this->client_id=$client_id;
        return $this;
    }
}

class PRICING{
	public $id;
	public $updated_time;
	public $package_name;
	public $import_limit;
	public $price;
	function __construct($id=0) {
		if ($id!=0) {
			global $wpdb;
		    $sql="SELECT p.ID, p.post_date, p.post_title, pm1.meta_value as import_limit, pm2.meta_value as pricing FROM wp_posts p ". 
				 "JOIN wp_postmeta pm1 ON p.id=pm1.post_id and pm1.meta_key='_import_times' " .
				 "JOIN wp_postmeta pm2 ON p.id=pm2.post_id and pm2.meta_key='_import_times_price' WHERE post_type='import_times' and p.ID='" . $id . "'";
		    $results = $wpdb->get_results($sql);
			if (count($results)>0) {
				$this->id=$results[0]->ID;
				$this->updated_time=$results[0]->post_date;
				$this->package_name=$results[0]->post_title;
				$this->import_limit=$results[0]->import_limit;
				$this->price=$results[0]->pricing;
			}
		} else {
			$this->id=0;
			$this->updated_time=null;
			$this->package_name='';
			$this->import_limit='';
			$this->price='';
		}
		return $this;
	}
	
	function insert_pricing() {
		$new_post = array(
			'post_title' => trim($this->package_name),
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_author' => 1,
			'post_type' => 'import_times',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'post_category' => array(0)
		);
		$this->id = wp_insert_post($new_post);
		add_post_meta($this->id, '_import_times', trim($this->import_limit), true);
		add_post_meta($this->id, '_import_times_price', trim($this->price), true);
		return $this->id;		
	}

	function update_pricing() {
		if ($this->id!=0) {
			$pricing_post = array(
			    'ID'           => $this->id,
			    'post_title' => trim($this->package_name)			
			);
			// Update the post into the database
			wp_update_post( $pricing_post );
			update_post_meta($this->id, '_import_times', trim($this->import_limit));
			update_post_meta($this->id, '_import_times_price', trim($this->price));
		}
		return $this;
	}

	function delete_pricing() {
		wp_delete_post(trim($this->ID));
		return $this;
	}
	
	function get_all() {
		global $wpdb;
	    $sql="SELECT p.ID, p.post_date, p.post_title, pm1.meta_value as import_limit, pm2.meta_value as pricing FROM wp_posts p ". 
			 "JOIN wp_postmeta pm1 ON p.id=pm1.post_id and pm1.meta_key='_import_times' " .
			 "JOIN wp_postmeta pm2 ON p.id=pm2.post_id and pm2.meta_key='_import_times_price' WHERE post_type='import_times'";
	    return $wpdb->get_results($sql);
	}
	
	function get_all_count() {
		global $wpdb;
		$sql_count = "select count(*) FROM wp_posts p WHERE post_type='import_times'";
		return $wpdb->get_var($sql_count);
	}
}

?>