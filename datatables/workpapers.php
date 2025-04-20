<?php
// This file contains mainly ajax functions related to the workpaper section :)

// Remove commas from numeric string and check if it is indeed numeric :)
function cleanNumericString($target) {
	$ret = str_replace( ',', '', $target );

	if( is_numeric( $ret ) ) {
	    return $ret;
	} else {
		error_log("$target not numeric");
	}
	return '';
}

add_action('wp_ajax_get_wps_for_client', 'get_wps_for_client');
function get_wps_for_client(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
	$limit_clause = '';
	if (isset($_POST['length'])) {
		$start = (isset($_POST['start']) ? $_POST['start'] : 0);
		$limit_clause = sprintf("LIMIT %d,%d", $start, $_POST['length']);
	}
	$client_clause = '';
	if (isset($_POST['client_id']) && $_POST['client_id'] != -1) {
		$client_clause = "wp.client_id='" . $_POST['client_id'] . "'";
	}
	
	$show_archived_clause = "and is_archived='0'";
	if (isset($_POST['show_archived']) && $_POST['show_archived'] === '1') {
		$show_archived_clause = "";
	}

	$columnNames = array("balance_sheet_date", "id", "name");
	$order_clause = '';
	if (isset($_POST['order']) && is_array($_POST['order'])) {
		for ($i=0; $i<count($_POST['order']); $i++) {
			$ord=$_POST['order'][$i];
			$order_clause .= sprintf("%s %s,", $columnNames[$ord['column']], $ord['dir']);
		}	
		$order_clause = substr($order_clause, 0, -1);
	}
	if (trim($order_clause) === '') {
		$order_clause = 'id ASC, balance_sheet_date ASC';
	}

	$sql="SELECT id, balance_sheet_date, name, is_archived " .
		 "FROM wp_wpp_period wp " .
		 "WHERE $client_clause $show_archived_clause order by $order_clause $limit_clause";
	$results = $wpdb->get_results($sql);
	$return_arr = array();
	foreach ($results as $row) {
		$new_row = array();
		// balance_sheet_date (hidden)
		$new_row[] = date("d M Y H:i:s",$row->balance_sheet_date);
		// id (delete)
		$new_row[] = $row->id;
		// name, link
		$new_row[] = '<a class="wpp_link" href="' . home_url('/workpaper-period/') . '?id=' . $row->id . '" id="wpp_link_' . $row->id . '">' . $row->name . '</a>&nbsp;' .
					 '<a href="#TB_inline?width=500&amp;height=500&amp;inlineId=form-add-wp" id="roll-fwd-wp" title="Edit Workpaper" class="edit_wpp" id="edit_wpp_' . $row->id . '" data-id="' . $row->id . '" title="Edit WP"><i class="fa fa-pencil fa-sm"></i></a>';
		// id (roll forward)
		$new_row[] = $row->id;
		// id (export)
		$new_row[] = $row->id;
		// id (export 2)
		$new_row[] = $row->id;
		// id (archive)
		$new_row[] = array($row->id, $row->is_archived);
		// append new row
		$return_array[] = $new_row;
	}
	
	$sql_count = "select count(*) from wp_wpp_period wp where $client_clause $show_archived_clause";
	$sql_count_filtered = "select count(*) from wp_wpp_period wp where $client_clause $show_archived_clause";
	$count = $wpdb->get_var($sql_count);
	$count_filtered = $wpdb->get_var($sql_count_filtered);

	if ($count_filtered == 0) {
		echo '{
		    "draw": 1,
		    "recordsTotal": "'.$count.'",
		    "recordsFiltered": "0",
		    "data": []
		}';
	} else {
		$return_assoc = array(
			'data' => $return_array,
			'draw' => (isset($_POST['draw']) ? $_POST['draw'] : '1'),
			'recordsTotal' => $count,
			'recordsFiltered' => $count_filtered
		);
		print_r(json_encode($return_assoc));
	}
	
	// clean up
	unset($results);
	$results = null;
	unset($return_arr);
	$return_arr = null;
	unset($return_assoc);
	$return_assoc = null;
	exit();
}


add_action('wp_ajax_get_workpaper_period', 'get_workpaper_period');
function get_workpaper_period() {
    if(isset($_POST['workpaper_period_id'])){
		$current_user=new USER_INFO(wp_get_current_user()->ID);
		$wp = new WORKPAPER_PERIOD($_POST['workpaper_period_id']);
		if ($wp->manager_id==$current_user->get_manager_id()) {
			error_log("get_workpaper_period() - preparer_id=[" . $wp->preparer_id . "], reviewer_id=[" . $wp->reviewer_id . "], partner_id=[" . $wp->partner_reviewer_id . "]");
	        echo json_encode($wp);
			exit;
		}
    }
    echo '0';
    exit();
}

add_action('wp_ajax_get_wp_client_reference', 'get_wp_client_reference');
function get_wp_client_reference() {
    if(isset($_POST['client_id'])){
        $client_id=$_POST['client_id'];
        $client = new CLIENT($client_id);
        if($client->id>0){
			echo $client->wp_client_reference;
            exit();
		}
    }
    echo '0';
    exit();
}

add_action('wp_ajax_rename_wp_client_reference', 'rename_wp_client_reference');
function rename_wp_client_reference() {
    if(isset($_POST['client_id']) && isset($_POST['client_ref'])
		&& $_POST['client_ref'] !== $client->wp_client_reference){
		$client_id=$_POST['client_id'];
        $client = new CLIENT($client_id);
		$client->update_wp_client_reference($_POST['client_ref']);
		echo '1';
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_rename_workpaper_period', 'rename_workpaper_period');
function rename_workpaper_period(){
	$wp_id = $_POST['rename_id'];
	$new_name = $_POST['new_name'];
	$current_user=new USER_INFO(wp_get_current_user()->ID);
	$wp = new WORKPAPER_PERIOD();
	echo $wp->rename($current_user, $wp_id, $new_name);
	exit();
}

add_action('wp_ajax_archive_workpaper_period', 'archive_workpaper_period');
function archive_workpaper_period(){
	$wp_id = $_POST['workpaper_period_id'];
	$current_user=new USER_INFO(wp_get_current_user()->ID);
	$wp = new WORKPAPER_PERIOD($_POST['workpaper_period_id']);
	if ($wp->manager_id==$current_user->get_manager_id()) {
		echo $wp->archive();
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_unarchive_workpaper_period', 'unarchive_workpaper_period');
function unarchive_workpaper_period(){
	$wp_id = $_POST['workpaper_period_id'];
	$current_user=new USER_INFO(wp_get_current_user()->ID);
	$wp = new WORKPAPER_PERIOD($_POST['workpaper_period_id']);
	if ($wp->manager_id==$current_user->get_manager_id()) {
		echo $wp->unarchive();
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_delete_workpaper_data', 'delete_workpaper_data');
function delete_workpaper_data(){
	$wp_id = $_POST['workpaper_id'];
	$current_user=new USER_INFO(wp_get_current_user()->ID);
	$wp = new WORKPAPER($wp_id);
	if ($wp->check_permission($current_user, $wp_id)) {
		echo $wp->delete_data();
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_delete_workpaper', 'delete_workpaper');
function delete_workpaper(){
	$wp_id = $_POST['workpaper_id'];
	$current_user=new USER_INFO(wp_get_current_user()->ID);
	$wp = new WORKPAPER($wp_id);
	if ($wp->check_permission($current_user, $wp_id)) {
		echo $wp->delete();
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_delete_workpaper_period', 'delete_workpaper_period');
function delete_workpaper_period(){
	$wp_id = $_POST['workpaper_period_id'];
	$current_user=new USER_INFO(wp_get_current_user()->ID);
	$wp = new WORKPAPER_PERIOD($_POST['workpaper_period_id']);
	if ($wp->manager_id==$current_user->get_manager_id()) {
		echo $wp->delete();
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_delete_tb_entries_bulk', 'delete_tb_entries_bulk');
function delete_tb_entries_bulk(){
	$wpp_tb_ids = $_POST['wpp_tb_ids'];
	$ret = WP_TRIAL_BALANCE::delete_tb_entries_bulk($wpp_tb_ids);
	if ($ret) {
		echo '1';
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_update_wp_account_type_bulk', 'update_wp_account_type_bulk');
function update_wp_account_type_bulk(){
	global $wpdb;
	$wpp_tb_ids = $_POST['wpp_tb_ids'];
	$account_type_id = $_POST['account_type_id'];
	
	$ret = WP_TRIAL_BALANCE::update_wp_account_type_bulk($wpp_tb_ids, $account_type_id);
	if ($ret) {
		echo wp_acc_type_to_string($account_type_id);
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_update_wp_tb_status_bulk', 'update_wp_tb_status_bulk');
function update_wp_tb_status_bulk(){
	global $wpdb;
	$wpp_tb_ids = $_POST['wpp_tb_ids'];
	$status_id = $_POST['status_id'];
	
	$ret = WP_TRIAL_BALANCE::update_wp_tb_status_bulk($wpp_tb_ids, $status_id);
	if ($ret) {
		echo '1';
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_update_new_tb_entries_to_draft_bulk', 'update_new_tb_entries_to_draft_bulk');
function update_new_tb_entries_to_draft_bulk() {
	global $wpdb;
	$wpp_tb_ids = $_POST['wpp_tb_ids'];
	
	$ret = WP_TRIAL_BALANCE::update_new_tb_entries_to_draft_bulk($wpp_tb_ids);
	if ($ret) {
		echo '1';
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_remove_jnl_entries_from_tb_bulk', 'remove_jnl_entries_from_tb_bulk');
function remove_jnl_entries_from_tb_bulk() {
	global $wpdb;
	$jnl_entry_ids = $_POST['jnl_entry_ids'];
	
	$ret = WP_JOURNAL::remove_jnl_entries_from_tb_bulk($jnl_entry_ids);
	if ($ret) {
		echo '1';
	} else {
		echo '0';
	}
	exit();
}


add_action('wp_ajax_delete_journals_bulk', 'delete_journals_bulk');
function delete_journals_bulk(){
	$wpp_jnl_ids = $_POST['wpp_jnl_ids'];
	$ret = WP_JOURNAL::delete_journals_bulk($wpp_jnl_ids);
	if ($ret) {
		echo '1';
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_get_updated_time_tb', 'get_updated_time_tb');
function get_updated_time_tb() {
	global $wpdb;
	$tb_id = $_POST['tb_id'];
	
	$ret = WP_TRIAL_BALANCE::get_last_updated_time($tb_id);
	if ($ret) {
		echo date("d/m/Y H:i", $ret);
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_update_wp_reviewer', 'update_wp_reviewer');
function update_wp_reviewer() {
	global $wpdb;
	$wp_id = $_POST['wp_id'];
	
	$wp = new WORKPAPER($wp_id);
	$ret = $wp->update_reviewer_and_date();
	if ($ret) {
		echo date("d/m/y", $wp->reviewed_date);
	} else {
		echo '0';
	}
	exit();
}


add_action('wp_ajax_clear_wp_reviewer_and_date', 'clear_wp_reviewer_and_date');
function clear_wp_reviewer_and_date() {
	global $wpdb;
	$wp_id = $_POST['wp_id'];
	
	$wp = new WORKPAPER($wp_id);
	$ret = $wp->clear_reviewer_and_date();
	if ($ret) {
		echo '1';
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_update_wpp_reviewer', 'update_wpp_reviewer');
function update_wpp_reviewer() {
	global $wpdb;
	$wpp_id = $_POST['wpp_id'];
	
	$ret = WORKPAPER_PERIOD::update_reviewer_and_date($wpp_id);
	if ($ret !== false) {
		echo date("d M Y", $ret);
	} else {
		echo '0';
	}
	exit();
}


add_action('wp_ajax_clear_wpp_reviewed_date', 'clear_wpp_reviewed_date');
function clear_wpp_reviewed_date() {
	global $wpdb;
	$wpp_id = $_POST['wpp_id'];
	
	$ret = WORKPAPER_PERIOD::clear_reviewed_date($wpp_id);
	if ($ret) {
		echo '1';
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_post_journal', 'post_journal');
function post_journal() {
	global $wpdb;
	// post a journal
	$new_journal;
	$current_user=new USER_INFO(wp_get_current_user()->ID);
	
	if (isset($_POST['jnl_account']) && isset($_POST['jnl_code']) && isset($_POST['jnl_dr']) && isset($_POST['jnl_cr'])
		&& isset($_POST['code_number']) && isset($_POST['strdate']) && isset($_POST['jnl_wp_id']) && isset($_POST['client_id'])) {
		// should do server-side validation, like total dr = total cr
		$jnl_wp_id = $_POST['jnl_wp_id'];
		if (isset($_POST['journal_id']) && $_POST['journal_id'] > 0) {
			// update existing journal
			$new_journal = new WP_JOURNAL($_POST['journal_id']);
			$new_journal->update_to_db($current_user, $_POST['narrative'], ($_POST['show_on_etb'] == 'on'), strtotime($_POST['strdate']));
			$new_journal->delete_journal_entries();
		} else {
			// add journal to the first workpaper in this group
			$new_journal = new WP_JOURNAL();
			$new_journal->insert_to_db($current_user, $_POST['code_number'], $_POST['client_id'], $jnl_wp_id, $_POST['narrative'], ($_POST['show_on_etb'] == 'on'), strtotime($_POST['strdate']));
		}
		$entries = array();
		for($i = 0; $i<count($_POST['jnl_account']); $i++) {
			if (isset($_POST['jnl_account'][$i]) && !empty($_POST['jnl_account'][$i]) && trim($_POST['jnl_account'][$i]) !== '') {				
				$dr = cleanNumericString($_POST['jnl_dr'][$i]);
				$cr = cleanNumericString($_POST['jnl_cr'][$i]);
				$price = (float) $dr - (float) $cr;
				
				$obj = new stdClass();
				$obj->account = $_POST['jnl_account'][$i];
				$obj->code = $_POST['jnl_code'][$i];
				$obj->price = $price;
				$entries[] = $obj;
			}
		}
		$new_journal->insert_journal_entries($current_user, $entries, ($_POST['show_on_etb'] == 'on'));
		echo "1";
		exit();
	} else {
		// missing fields.
		error_log("Cannot save journal - missing fields.");
		echo "Cannot save journal - missing fields.";
	}
	echo "0";
	exit();
}


add_action('wp_ajax_delete_working_papers', 'delete_working_papers');
function delete_working_papers() {
	global $wpdb;
	$tb_obj = new WP_TB_DETAILS();
	$value = $tb_obj->delete_working_papers($_POST['papers_id']);
	echo $value;
	exit();
	
}

add_action('wp_ajax_delete_notes_entry', 'delete_notes_entry');
function delete_notes_entry() {
	global $wpdb;
	$acc_prep_notes = new WP_ACC_PREP_NOTES($_POST['acc_prep_notes_id']);
	$value = $acc_prep_notes->delete_notes_entry_by_entry_id($_POST['entry_id']);
	echo ($value ? '1' : '0');
	exit();
}


add_action('wp_ajax_delete_acc_prep_notes_bulk', 'delete_acc_prep_notes_bulk');
function delete_acc_prep_notes_bulk(){
	$wpp_acc_prep_notes_ids = $_POST['ids'];
	$ret = WP_ACC_PREP_NOTES::delete_acc_prep_notes_bulk($wpp_acc_prep_notes_ids);
	if ($ret) {
		echo '1';
	} else {
		echo '0';
	}
	exit();
}


add_action('wp_ajax_add_linked_to', 'add_linked_to');
function add_linked_to() {
	global $wpdb;
	$tb_obj = new WP_TB_DETAILS();
	$data = array();
	$data['from_id'] = $_POST['from_id'];
	$data['to_id'] = $_POST['to_id'];
	$data['user_id'] = $_POST['user_id'];
	$data['added_date'] = date('Y-m-d H:i:s');
	$data['added_time'] = time();
	$value = $tb_obj->add_linked_to($data);
	echo $value;
	exit();
}

add_action('wp_ajax_delete_linked_to', 'delete_linked_to');
function delete_linked_to() {
	global $wpdb;
	$tb_obj = new WP_TB_DETAILS();
	$value = $tb_obj->delete_linked_to($_POST['linked_id']);
	echo $value;
	exit();
}

add_action('wp_ajax_get_wp_by_papers_id', 'get_wp_by_papers_id');
function get_wp_by_papers_id() {
	global $wpdb;
	$tb_obj = new WP_TB_DETAILS();
	$value = $tb_obj->get_wp_by_papers_id($_POST['papers_id']);
	echo json_encode($value);
	exit();
}

add_action('wp_ajax_manage_wp_account', 'manage_wp_account');
function manage_wp_account(){
	global $wpdb;
	$acc_array  = $_POST['acc_array'];
	$code       = $_POST['code'];
    $tab_id     = $_POST['tab_id'];
	//print_r($acc_array);die;
	$ret = WP_TB_DETAILS::manage_wp_account($acc_array, $code, $tab_id);
	if ($ret) {
        echo 1;
		//echo wp_acc_type_to_string($account_type_id);
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_update_tab_name', 'update_tab_name');
function update_tab_name(){
	global $wpdb;
	$value      = $_POST['value'];
    $tab_id     = $_POST['tab_id'];
    $db_action     = $_POST['db_action'];
    if($db_action == 'delete'){
        $rows=$wpdb->get_results("SELECT tab_id FROM wp_manage_accounts WHERE tab_id='".$tab_id."'");
		if(isset($rows) && count($rows) >0){
			echo 0;die;
		}
        $sql    = $wpdb->prepare("DELETE FROM wp_leads_tabs  WHERE tab_id=%d", $tab_id);
    }else{
        $sql    = $wpdb->prepare("UPDATE wp_leads_tabs SET tab_name='".$value."' WHERE tab_id=%d", $tab_id);
    }
	
    $ret    = $wpdb->get_results($sql);
	echo 1;
	exit();
}

?>
