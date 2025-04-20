<?php
function get_post_by_conditions($catId,$post_type,$posts_per_page,$offset,$order='DESC'){
    $args = array(
	'posts_per_page'   => $posts_per_page,
	'offset'           => $offset,
	'category'         => $catId,
	'orderby'          => 'post_date',
	'order'            => $order,
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => $post_type,
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true );
     $posts_array = get_posts( $args );
     return $posts_array;
}
function get_price_product($id){
    global $wpdb;
    $sql="select * from wp_posts where id='".$id."'";
    $rows=$wpdb->get_results($sql);
    $price = get_post_meta($rows[0]->ID,'_import_times_price',true);
    return $price;
}
function get_product_service($type){
    global $wpdb;
    $sql="select * from wp_product_service where product_type='".$type."'";
    $rows=$wpdb->get_results($sql);
    return $rows;
}
function get_price_time_expire_by_id($id){
    global $wpdb;
    $sql="select price from wp_time_expire where id='".$id."'";
    return $wpdb->get_var($sql);
}

function get_time_expire(){
    global $wpdb;
    $sql="select * from wp_time_expire";
    return $wpdb->get_results($sql);
}
function get_client_price_by_id($id){
    global $wpdb;
    $sql="select price from wp_client_limit where id='".$id."'";
    return $wpdb->get_var($sql);
}

function get_client_limit(){
    global $wpdb;
    $sql="select * from wp_client_limit";
    $rows=$wpdb->get_results($sql);
    return $rows;
}
function get_client_by_id($id){
    global $wpdb;
    $sql="select * from wp_client where id='".$id."'";
    $rows=$wpdb->get_results($sql);
    return $rows;
}
function split_description_special($description_original) {
	// split on space, comma, two types of dashes
	return preg_split("/[\s\(\)\\/.,–-]+/", trim(strtolower($description_original)));
}
function get_other_possible($description_original,$user_info,$production_system_id){
	// split on space, comma, two types of dashes
	$desc_tokens = split_description_special($description_original);
	$new_desc_tokens = array();
	$unwanted_tokens = array("fee", "fees", "expense", "expenses", "cost", "account", "on", "of");
	foreach($desc_tokens as $token) {
	    if (!in_array($token, $unwanted_tokens)) {
	        $new_desc_tokens[] = $token;
		}
	}
	$st=" (";
    $add_or = false;

    foreach ($new_desc_tokens as $desc_token){
		if ($desc_token == 'acc' || $desc_token == 'accumulated') {
			if ($add_or) {
				$st .= " or ";
			}
			$st.='(description RLIKE "[[:<:]]accumulated[[:>:]]")';
			$add_or = true;
		} else if (strlen($desc_token)>0) {
			// less than 4 characters
			if ($add_or) {
				$st .= " or ";
			}			
			$st.='(description RLIKE "[[:<:]]' . mysql_real_escape_string($desc_token) . '[[:>:]]")';
			$add_or = true;
		}
    }
    $st.=") ";
    global $wpdb;
    $sql="select * from wp_user_code where manager_id='".$user_info->get_manager_id().
		"' and production_system_id='$production_system_id' and $st order by code";
    $rows=$wpdb->get_results($sql);
	$new_rows = array();
	$key_column = array();	// sort key
	foreach ($rows as $key => $row) {
		$user_code_desc_tokens = split_description_special($row->description);
		$count_match = 0;
		foreach ($user_code_desc_tokens as $token){
			if (in_array($token, $new_desc_tokens)) {
				$count_match++;
			}
		}
		$row->count_match = $count_match;
		$key_column[$key] = $row->count_match;
		$new_rows[$key] = $row;
	}
	
	// Sort the data with count_match desc
	if (count($key_column) > 0) {
		array_multisort($key_column, SORT_DESC, SORT_NUMERIC, $rows);
	}

    return $rows;
}
/* not in use */
function get_other_possible_client_custom($description_original,$user_id,$production_system_id,$client_id){
    $description_original = str_replace("-", " ", $description_original);
    $b = mysql_real_escape_string(str_replace("–", " ", strtolower(trim($description_original))));
    $a = explode(" ", $b);
    $st=" (";
    $i=0;
    foreach ($a as $value){
        if($i==0){
            $st.=" (description like '%".trim($value)."%') ";
        }else{
            if(trim($value)!=""){
                $st.=" or (description like '%".trim($value)."%') ";
            }
        }
        $i++;
    }
    $st.=") ";
    global $wpdb;
    $sql="select * from wp_client_code where ".$st." and user_id='".$user_id."' and production_system_id='".$production_system_id."' and client_id='".$client_id."'";
    $rows=$wpdb->get_results($sql);
    return $rows;
}
function get_post_by_cat($catId,$posts_per_page){
    $args = array(
	'posts_per_page'   => $posts_per_page,
	'offset'           => 0,
	'category'         => $catId,
	'orderby'          => 'post_date',
	'order'            => 'ASC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true );
     $posts_array = get_posts( $args );
     return $posts_array;
}
function get_feature_home($catId){
     $args = array(
	'posts_per_page'   => 5,
	'offset'           => 0,
	'category'         => $catId,
	'orderby'          => 'post_date',
	'order'            => 'ASC',
	'include'          => '',
	'exclude'          => '',
	'meta_key'         => '',
	'meta_value'       => '',
	'post_type'        => 'post',
	'post_mime_type'   => '',
	'post_parent'      => '',
	'post_status'      => 'publish',
	'suppress_filters' => true );
     $posts_array = get_posts( $args );
     return $posts_array;
}
/*get all client by user*/
function get_all_client_by_user($user_id){
    global $wpdb;
    $manager_id = get_manager($user_id);
    if($manager_id==0){
        $manager_id=$user_id;
    }
    $sql="select * from wp_client where user_id='".$manager_id."'";
    $rows=$wpdb->get_results($sql);
    return $rows;
}
function get_rows_by_column_value($table,$column,$value){
    global $wpdb;
    $sql="select * from ".$table." where ".$column."='".$value."'";
    $rows=$wpdb->get_results($sql);
    if(count($rows)>0){
        return $rows;
    }else{
        return 0;
    }
}
function get_user_member(){
    global $wpdb;
    $sql="select * from wp_users";
    $rows=$wpdb->get_results($sql);
    return $rows;
}
function get_user_member_by_id($user_id){
    global $wpdb;
    $a = get_user_meta($user_id,"_member",true);
    $b=array();
    if($a==''){
        return 0;
    }
    foreach ($a as $id){
        $sql="select * from wp_users where ID='".$id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $b[]=$rows[0];
        }
    }
    if(count($b)>0){
        return $b;
    }else{
        return 0;
    }
}
function get_trial_balance(){
    global $wpdb;
    $sql="select * from wp_posts where post_type='balance' and post_status='publish'";
    $rows=$wpdb->get_results($sql);
    return $rows;
}
function get_trial_balance_for_user($user_id){
    global $wpdb;
    $a = get_user_meta($user_id,"_trial_balance",true);
    if($a!==''){
        $b=array();
        foreach ($a as $value){
            $sql="select * from wp_posts where ID='".$value."'";
            $rows=$wpdb->get_results($sql);
            if(count($rows)>0){
                $b[]=$rows[0];
            }
        }
        return $b;
    }else{
        return 0;
    }
}
/*get code of last file by user*/
function get_user_code_of_last_file($user_id){
    global $wpdb;
    $sql="select * from wp_user_code where user_id='".$user_id."' and last_import='1'";
    $rows=$wpdb->get_results($sql);
    if(count($rows)>0){
        return $rows;
    }else{
        return 0;
    }
}
/*get code of last file by user*/
function get_client_code_of_last_file($user_id){
    global $wpdb;
    $sql="select * from wp_client_code where user_id='".$user_id."' and last_import='1'";
    $rows=$wpdb->get_results($sql);
    if(count($rows)>0){
        return $rows;
    }else{
        return 0;
    }
}

/*Table wp_user_code*/
//code from wp_user_code
function get_user_code_by_des($des,$user_id){
    global $wpdb;
    $sql="select * from wp_user_code where replace(description,' ','') like '%".str_replace(' ','',ucfirst(trim($des)))."' and user_id='".$user_id."'";
    //echo "<pre>".print_r($sql,1)."</pre>";
    $rows=$wpdb->get_results($sql);
    if(!isset($rows[0]->code)){
        return 0;
    }else{
        return $rows[0];
    }
}
/*get code from wp_user_code by description and production system*/
function get_user_code_by_des_product_system($des,$user_id,$production_system_id,$client_id,$wide_map=0){
    global $wpdb;
    $des11=strtolower(str_replace(' ','',trim($des)));
    $des1=strtolower(str_replace("'","''",$des11));
    $des2=strtolower(str_replace(' ','',trim($des)))."s";
    $des2=strtolower(str_replace("'","''",$des2))."s";
    $manager_id = get_manager($user_id);
    if($manager_id==0){
        $manager_id=$user_id;
    }
    //$sql="select * from wp_user_code where ('".strtolower(str_replace(' ','',trim($des)))."' REGEXP LOWER(replace(description,' ',''))) and user_id='".$user_id."' and production_system_id='".$production_system_id."'";
    //change again
    
    $sql="select * from wp_user_code where (('".$des1."'  = LOWER(replace(description,' ',''))) or ('".$des2."'  = LOWER(replace(description,' ','')))) and (user_id='".$manager_id."' or user_id='".$user_id."') and production_system_id='".$production_system_id."'";
    $rows=$wpdb->get_results($sql);
    if(!isset($rows[0]->code)){
        return 0;
    }else{
        return $rows[0];
    }
}
/*get code from wp_client_code by description and production system*/
function get_user_code_by_des_product_system_client($des,$user_id,$production_system_id,$client_id){
    global $wpdb;
    $des1=strtolower(str_replace(' ','',trim($des)));
    $des2=strtolower(str_replace(' ','',trim($des)))."s";
    $sql="select * from wp_client_code where (('".$des1."'  = LOWER(replace(description,' ',''))) or ('".$des2."'  = LOWER(replace(description,' ','')))) and client_id='".$client_id."'";
    $rows=$wpdb->get_results($sql);
    if(!isset($rows[0]->code)){        
        return 0;
    }else{
        return $rows[0];
    }
}

/*Get code by production system and client*/
function get_code_system_and_client_by_des($des,$user_id,$production_system_id,$client_id,$wide_map=0){
    
    
    if(get_user_code_by_des_product_system_client($des, $user_id, $production_system_id, $client_id)==0){
        if(get_user_code_by_des_product_system($des, $user_id, $production_system_id,$client_id,$wide_map)==0){
            return 0;
        }else{
            return get_user_code_by_des_product_system($des, $user_id, $production_system_id,$client_id,$wide_map);
        }
        return 0;
    }else{
        //echo "<pre>".$des."</pre>";
        return get_user_code_by_des_product_system_client($des, $user_id, $production_system_id, $client_id);
    }
}
//get code from wp_user_code by user and production system
function get_user_code_by_user_product_system($manager_id,$production_system_id){
    global $wpdb;
    $sql="select * from wp_user_code where manager_id='".$manager_id."' and production_system_id='".$production_system_id."' order by code asc";
    $rows=$wpdb->get_results($sql);
    if(count($rows)>0){
        return $rows;
    }else{
        return 0;
    }
}
//get code from wp_user_code by user and production system
function get_user_and_manger_code_by_user_product_system($manager_id,$user_id,$production_system_id){
    global $wpdb;
    $sql="select * from wp_user_code where (user_id='".$user_id."' or user_id='". $manager_id . 
		 "') and production_system_id='".$production_system_id."' order by code asc";
    $rows=$wpdb->get_results($sql);
    objSort($rows,'getIndex'); 
    if(count($rows)>0){
        return $rows;
    }else{
        return 0;
    }
}
//get code from wp_client_code by user and production system and client
function get_user_code_by_user_product_system_client_custom($user_id,$production_system_id,$client_id){
    global $wpdb;
    $sql="select * from wp_client_code where user_id='".$user_id."' and production_system_id='".$production_system_id."' and client_id='".$client_id."' order by code ";
    $rows=$wpdb->get_results($sql);
    if(count($rows)>0){
        return $rows;
    }else{
        return 0;
    }
}

/* Sort array object*/
function objSort(&$objArray,$indexFunction,$sort_flags=0) {
    $indices = array();
    foreach($objArray as $obj) {
        $indeces[] = $indexFunction($obj);
    }
    return array_multisort($indeces,SORT_DESC,SORT_NUMERIC,$objArray);
}
function getIndex($obj) {
    $a = explode("/", $obj->code);
    if(count($a)>1){
        return $a[0];
    }else{
        return  $obj->code;
    }
}
/*end sort*/

/*End Table wp_user_code*/

//get map of last file 


function get_last_file_compare($user_id){
    global $wpdb;
    $sql="select file_id from wp_balance where userid='".$user_id."' and last_file='1' order by id limit 1";
    $file_id = $wpdb->get_var($sql);
	return get_file_compare_by_file_id($file_id);
}

function get_file_compare_by_file_id($file_id) {
    global $wpdb;
    $sql="select *, 1 as is_tb from wp_balance where file_id='$file_id' order by id";
    $rows = $wpdb->get_results($sql);
    $sql2="select *, 0 as is_tb from wp_open_balance where confirmed=TRUE and tb_file_id='$file_id' order by id";
    $rows_open = $wpdb->get_results($sql2);
	$sql3="SELECT time FROM wp_csv_file WHERE id='$file_id'";
	$csv_file_time=$wpdb->get_var($sql3);	
	
	if (count($rows_open) <= 0) {
		return $rows;
	}	
	
	// hash wp_balance description, minus the blank and dash at the end
	$bal_desc_hash = array();
	$i=0;
	foreach ($rows as $row) {
		$row->description_original = trim($row->description_original);
		$search = rtrim($row->description_original, " -");
		if (!isset($bal_desc_hash[$search])) {
			$bal_desc_hash[$search]=array();
		}
		$bal_desc_hash[$search][] = $i++;
	}
	
	$combined=array();
	$balance_rows_found = array();
	foreach($rows_open as $row_open) {
		$row_open->description_original = trim($row_open->description_original);
		$row_open->found_ob = 0;
		$combined[] = $row_open;
		// find balance with the same description
		if (isset($bal_desc_hash[$row_open->description_original])) {
			foreach ($bal_desc_hash[$row_open->description_original] as $row_index) {
				$combined[] = $rows[$row_index];
				$balance_rows_found[] = $row_index;
				if ($rows[$row_index]->need_ob_check == 1) {
					// only if user has not saved code afterwards, i.e. confirmed the entry.
					$rows[$row_index]->found_ob = 1;
				}
			}
		}
	}
	for($i=0; $i<count($rows); $i++) {
		if (array_search($i,$balance_rows_found) === FALSE) {
			$rows[$i]->found_ob = 0;
			$combined[] = $rows[$i];
		}
	}
	return $combined;
}

function combine_open_balance($file_id) {
	global $wpdb;
    $sql="select *, 1 as is_tb from wp_balance where file_id='$file_id' order by id";
    $rows = $wpdb->get_results($sql);
    $sql2="select *, 0 as is_tb from wp_open_balance where confirmed=TRUE and tb_file_id='$file_id' order by id";
    $rows_open = $wpdb->get_results($sql2);
	$sql3="SELECT wide_map FROM wp_csv_file WHERE id='$file_id'";
	$wide_map=$wpdb->get_var($sql3);	
	
	if (count($rows_open) <= 0) {
		return 1;
	}	
	
	// hash wp_balance description
	$bal_desc_hash = array();
	$i=0;
	foreach ($rows as $row) {
		$row->description_original = trim($row->description_original);
		if (!isset($bal_desc_hash[$row->description_original])) {
			$bal_desc_hash[$row->description_original]=array();
		}
		$bal_desc_hash[$row->description_original][] = $i++;
	}
	
	foreach($rows_open as $row_open) {
		$row_open->description_original = trim($row_open->description_original);
		// find balance with the same description
		if (isset($bal_desc_hash[$row_open->description_original])) {
			foreach ($bal_desc_hash[$row_open->description_original] as $row_index) {
				$row = $rows[$row_index];

				// found matched, update desc and price
				$row->description_original = $row->description_original . ' -';
				$row->price-=$row_open->price;
				
				// prepare for coding
				$org_code = $row->code;
				$org_description = $row->description;
				$org_code_original = $row->code_original;
				$row->description = $row->description_original;
				$user_info = new USER_INFO($row->user_id);
				
				// code with new description
				code_row($user_info, $row, $row->client_id, $row->production_system_id, $wide_map);
				
				// if code_row fails, use original code
				//error_log("Result of code_row, [" . $row->code . "], org_code=[$org_code]");
				if (!isset($row->code) || $row->code==='') {
					//error_log("reassigning $org_code");
					$row->code = $org_code;
					$row->description = $org_description;
					$row->code_original = $org_code_original;
				}
				
				// save to balance table
				$sql_update = sprintf("UPDATE wp_balance SET code='%s', description='%s', code_original='%s', description_original='%s', price='%s', need_ob_check='1' WHERE id='%d' limit 1",
							  $row->code, mysql_real_escape_string($row->description), $row->code_original,
							  mysql_real_escape_string($row->description_original), mysql_real_escape_string($row->price), $row->id);
		        $wpdb->query($sql_update);
		
				// if open balance row is not coded but the TB row is coded, copy over TB code
				if (isset($row->code) && (!isset($row_open->code) || $row_open->code==='')) {
					$row_open->code = $row->code;
					$row_open->description = $row->description;
					$row_open->code_original = $row->code_original;
					// save to obal table
					$ret = $wpdb->update("wp_open_balance", array('code' => $row_open->code,
														   'description' => $row_open->description,
														   'code_original' => $row_open->code_original),
													 array('id' => $row_open->id));
					if ($ret === false) {
						error_log("ERROR updating wp_open_balance with TB code, row_open->id=" . $row_open->id . ", row_open->description_original=" . $row_open->description_original);
					}
				}
			}
		}
	}
	
	return 1;
}

//code from wp_code
function get_code_from_des($des){
    global $wpdb;
    $sql="select code from wp_code where description like'%".trim($des)."%'";
    $rows=$wpdb->get_results($sql);
    if(!isset($rows[0]->code)){
        return 0;
    }else{
        return $rows[0]->code;
    }
    
}
//update id for the last balance
function update_file_id_for_balance($user_id,$file_id,$time){
    global $wpdb;
    $sql="update wp_balance set file_id='".$file_id."' where userid='".$user_id."' and time='".$time."' and last_file='1'";
    $wpdb->query($sql);
}
//update id for the last opening balance
function update_file_id_for_open_balance($user_id,$file_id,$time,$tb_file_id){
    global $wpdb;
    $sql="update wp_open_balance set file_id='".$file_id."' where userid='".$user_id."' and time='".$time."' and tb_file_id='$tb_file_id'";
    $wpdb->query($sql);
}
function check_user_code_exist($user){
    global $wpdb;
    $sql="select count(user_id) from wp_user_code where user_id='".$user->ID."'";
    return $wpdb->get_var($sql);
}
function get_all_code(){
    global $wpdb;
    $sql="select * from wp_code";
    return $wpdb->get_results($sql);
}
function get_code_by_user($user_id,$start,$num){
    global $wpdb;
    $sql="select * from wp_user_code where manager_id='".$user_id."' limit ".$start.", ".$num;
    return $wpdb->get_results($sql);
}
function get_code_by_id($id){
    global $wpdb;
    $sql="select * from wp_user_code where id='".$id."'";
    return $wpdb->get_results($sql);
}
function get_file_csv_by_user($user_id){
    global $wpdb;
    $sql="select * from wp_csv_file where user_id='".$user_id."' and export='1' order by  time DESC";
    return $wpdb->get_results($sql);
}
//search code by description and production system
function search_code_by_des_production_system($str_search,$user_id,$production_system_id){
    global $wpdb;
    if($str_search!=''){
        if($production_system_id>0){
            $sql="select * from wp_user_code where (code like'%".$str_search."' or description like '%".$str_search."%') and user_id='".$user_id."' and production_system_id='".$production_system_id."' ORDER BY id DESC";
        }else{
            $sql="select * from wp_user_code where (code like'%".$str_search."' or description like '%".$str_search."%') and user_id='".$user_id."'  ORDER BY id DESC";
        }
    }else{
        return 0;
    }
    $rows=$wpdb->get_results($sql);
    return $rows;
}
?>
