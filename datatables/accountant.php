<?php

/*Plugin Name: Accountant
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include "functions-database.php";
include "class.php";
include "workpapers.php";
include "workpapers-class.php";
date_default_timezone_set('Europe/London');

const WP_BULK_ID_REGEX = '/^[0-9]+$|^[0-9][0-9,]+[0-9]$/';

add_filter( 'wp_mail_from', 'my_mail_from' );
function my_mail_from( $email )
{
    return "support@tbcoder.com";
}

add_filter( 'wp_mail_from_name', 'my_mail_from_name' );
function my_mail_from_name( $name )
{
    return "TB Coder";
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
function string_to_time($str_date){
    $a= explode(" ", $str_date);
    $b=  explode("-", $a[0]);
    $c=  explode(":", $a[1]);
    $ob=new stdClass();
    $ob->year=$b[0];
    $ob->month=$b[1];
    $ob->day=$b[2];
    $ob->hour=$c[0];
    $ob->minute=$c[1];
    $ob->second=$c[2];
    return mktime($ob->hour,$ob->minute,$ob->second,$ob->month,$ob->day,$ob->year);
}
function match_file_again($user_id){
    global $wpdb;
    $sql="select * from wp_balance where userid='".$user_id."' and last_file='1' and code='0'";
    $rows= $wpdb->get_results($sql);
    foreach ($rows as $row){
        $row_code=get_user_code_by_des_product_system($row->description_original, $user_id, $row->production_system_id,0);
        if($row_code!==0){
            $sql_update="update wp_balance set code='".$row_code->code."',description='".$row_code->description."' where id='".$row->id."'";
            $wpdb->query($sql_update);
        }
    }
}
function get_rows_condition($field,$value,$table){
    global $wpdb;
    $sql="select * from ".$table." where ".$field."='".$value."'";
    $rows=$wpdb->get_results($sql);
    return $rows;
}
function get_client_by_name($client_name,$user_id){
    global $wpdb;
    $sql="select * from wp_client where client_name='".$client_name."' and user_id='".$user_id."'";
    $rows=$wpdb->get_results($sql);
    return $rows;
}
function get_id_client_by_name($client_name,$user_id){
    global $wpdb;
    $client_name=trim($client_name);
    $sql="select * from wp_client where client_name='".$client_name."' and user_id='".$user_id."'";
    $rows=$wpdb->get_results($sql);
    if(count($rows)>0){
        return $rows[0]->id;
    }else{
        return 0;
    }
}
function check_client_name_exist($client_name,$user_id){
    global $wpdb;
    $sql="select * from wp_client where client_name='".trim(strtolower($client_name))."' and user_id='".$user_id."'";
    //$sql="select * from wp_client where LOWER(client_name)='".trim(strtolower($client_name))."'";
    $rows=$wpdb->get_results($sql);
    if(count($rows)>0){
        return 1;
    }else{
        return 0;
    }
}

/*Import client with csv file*/
function import_client_csv($fileName,$user_info){
    global $wpdb;
    $upload_dir = wp_upload_dir();
    $fp = fopen($upload_dir['path'].'/'.$fileName, "r");
    while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
        if(count($data)==1){
            $client_name=trim(strtolower($data[0]));
			if ($client_name!=='') {
				$client_obj = new CLIENT();
				$client_obj->get_client_by_name_and_user($client_name, $user_info);
                if($client_obj->id == 0){
                    $client_obj->add_client($client_name, $user_info);
                }					
			}
        }else{
            break;
        }
    }
    fclose($fp);
    unlink($upload_dir['path'].'/'.$fileName);
}
/*Import client with excel file*/
function import_client_excel($fileName,$user_info){
    global $wpdb;
    $upload_dir = wp_upload_dir();
    $i=0;
    include 'Classes/PHPExcel/IOFactory.php';
    $inputFileName = $upload_dir['path'].'/'.$fileName;
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    foreach ($sheetData as $row){
        if($row['A']!==''){
            $client_name=trim(strtolower($row['A']));
			if ($client_name!=='') {
				$client_obj = new CLIENT();
				$client_obj->get_client_by_name_and_user($client_name, $user_info);
                if($client_obj->id == 0){
                    $client_obj->add_client($client_name, $user_info);
                }					
			}
        }
        $i++;
    }
    unlink($upload_dir['path'].'/'.$fileName);
}
/*End update with field Client Name*/

/* For Xero opening balance */
function opening_balance_xero($ob) {
	$rows=array();
	$positive_value = 1;
	$parse = false;
    foreach ($ob->Reports->Report->Rows->Row as $value){
        if(isset($value->RowType) && trim($value->RowType) === 'Section'){
			if (isset($value->Title)) {
				if (trim($value->Title) === 'Assets' || trim($value->Title) === 'Non-current Assets') {
					$positive_value = 1;
					// parse each Section until Summary Row
					$parse = true;
				} else if (trim($value->Title) === 'Current Liabilities' || trim($value->Title) === 'Non-Current Liabilities') {
					$positive_value = 0;
					$parse = true;
					// do not skip to next, parse this item
				} else if (trim($value->Title) === 'Equity') {
					$positive_value = 0;
					$parse = true;
					// do not skip to next, parse this item
				} else if (trim($value->Title) === 'Current Assets') {
					$positive_value = 1;
					// parse each Section until Summary Row (including this section)
					$parse = true;					
				} else if (trim($value->Title) === 'Fixed Assets') {
					$positive_value = 1;
					// parse each Section until Summary Row (including this section)
					$parse = true;					
				}
			}
			if (isset($value->Rows) && $parse) {
				foreach ($value->Rows->Row as $row) {
					if (isset($row->RowType) && trim($row->RowType) === 'Row' && isset($row->Cells)) {
						// 3 columns: [0]Title, [1]this year's val, [2]last year's val
						if (isset($row->Cells->Cell[0]->Value) && isset($row->Cells->Cell[1]->Value)) {
							$obj=new stdClass();
		                    $obj->description=trim($row->Cells->Cell[0]->Value);
		                    $obj->price=trim($row->Cells->Cell[1]->Value);
							if (!$positive_value) {
			                    $obj->price=-$obj->price;
							}
							foreach($row->Cells->Cell[0]->Attributes->Attribute as $attr) {
								// get account type
								if ($attr->Id == 'account') {
									$obj->account = (string) $attr->Value;
									break;
								}
							}
							$rows[] = $obj;
						}
					} else if (isset($row->RowType) && trim($row->RowType) === 'SummaryRow') {
						// do no parse till 'Assets/Liabilities/Equity' section is encountered
						$parse = false;
					}
				}
			}	
        }
    }
    return $rows;
}

/*for trialbalance*/
function trial_balance_quickbooks($json_str){
    $rows=array();
	// strip headers of json
	$json_str = substr($json_str, strpos($json_str, "{"));
	$ob = json_decode($json_str);	
	
	if (isset($ob->Rows) && isset($ob->Rows->Row)) {
	    foreach ($ob->Rows->Row as $value){
	        if(isset($value->ColData)){
				$obj = new stdClass();
				$line = $value->ColData;
				
				$obj->description = trim($line[0]->value);
				$obj->account = trim($line[0]->id);
				
				$tokens = explode(' ', $obj->description, 2);
				if (count($tokens) == 2 && is_numeric(trim($tokens[0]))) {
					// first token is a code
					$obj->code = trim($tokens[0]);
				} else {
					$obj->code = trim($line[0]->id);
				}
				
				if (isset($line[1]->value) && $line[1]->value !== "") {
					// it's a debit value
					$obj->price = trim($line[1]->value);
				} else {
					// It's a credit value
					$obj->price = trim($line[2]->value);
                    $obj->price=-$obj->price;
				}
	            $rows[]=$obj;
	        }
	    }
	}
    return $rows;
}

function trial_balance_kashflow($ob){
    $rows=array();
	if (isset($ob->GetTrialBalanceResult) && isset($ob->GetTrialBalanceResult->NominalCode)) {
	    foreach ($ob->GetTrialBalanceResult->NominalCode as $row) {
	        if(isset($row->Name) && (round($row->debit) != 0 || round($row->credit) != 0)) {
				$obj = new stdClass();
				$obj->account = (string) trim($row->Code);
				$obj->description = (string) $row->Name;
				if (round($row->debit) != 0) {
					$obj->price = -$row->debit;
				} else {
					$obj->price = -$row->credit;					
				}
				$obj->price = round($obj->price, 2);
	            $rows[]=$obj;
	        }
	    }
	}
	return $rows;
}

function trial_balance_freeagent($ob){
    $rows=array();

	if (isset($ob->trial_balance_summary)) {
	    foreach ($ob->trial_balance_summary as $row){
	        if(isset($row->name) && isset($row->total)){
				$obj = new stdClass();
				$obj->account = (string) trim($row->nominal_code);
				$obj->description = (string) $row->name;
				$obj->price = (string) $row->total;
				$obj->price = round($obj->price, 2);
	            $rows[]=$obj;
	        }
	    }
	}
    
return $rows;
}

function convert_arr_to_hash($arr, $use_code=0) {
	$hash = array();
	foreach ($arr as $item) {
		if ($use_code && isset($item->code)) {
			$hash[strtolower($item->code)] = $item;	// to match case-insensitive
		} else {
			$hash[strtolower($item->description)] = $item;	// to match case-insensitive
		}
	}
	return $hash;
}

function combine_tb($hash_previous_year, $hash_current_yr) {
	$combined = array();
		
	// iterate through previous year
	if (isset($hash_previous_year) && count($hash_previous_year) > 0) {
		foreach($hash_previous_year as $py_desc => $py_obj) {
			$obj = new stdClass();
			$obj->description = $py_obj->description;
			$obj->py_price = $py_obj->price;
			if (isset($hash_current_yr[$py_desc])) {
				// balance sheet accounts matched
				$obj->price = $hash_current_yr[$py_desc]->price;					
				unset($hash_current_yr[$py_desc]);
			} else {
				$obj->price = '0';
			}
			$obj->account=(isset($py_obj->account) ? $py_obj->account : -1);
			$obj->code=(isset($py_obj->code) ? $py_obj->code : '0');
			$combined[] = $obj;
		}
	}
	
	// iterate through remaining current year
	if (count($hash_current_yr) > 0) {
		foreach($hash_current_yr as $desc => $curr_yr_obj) {
			$obj = new stdClass();
			$obj->description = $curr_yr_obj->description;
			$obj->py_price = '0';
			$obj->price = $curr_yr_obj->price;
			$obj->account=(isset($curr_yr_obj->account) ? $curr_yr_obj->account : -1);
			$obj->code=(isset($curr_yr_obj->code) ? $curr_yr_obj->code : '0');
			$combined[] = $obj;
		}
	}

	return $combined;
}


add_action('admin_menu','register_menu_page');
function register_menu_page(){
    add_menu_page('Import Balance', 'Import Balance', 'manage_options', 'import-balance','wpa_import_balance');
    add_menu_page('Settings Credit Card', 'Settings Credit Card', 'manage_options', 'settings-credit-card', 'wpd_settings_credits_card');
}
function wpd_settings_credits_card(){
    include 'themes/settings-credit-card.php';
    return;
}
function wpa_import_balance(){
    include 'themes/import-balance.php';
    return ;
}

add_action( 'set_user_role', 'user_role_update' );
function user_role_update($user_id) {
	$user_manager=new USER_INFO($user_id);
	if ($user_manager->roles[0]=='manager') {
		$user_manager->make_manager();
	}
}

/*Import new AP Chart of Accounts*/
function import_new_ap_chart_of_accounts($current_user) {
	if (isset($_POST['production_system_name']) && isset($_POST['admin_system']) && isset($_POST['type_chart'])) {
		if ($_POST['production_system_name']!=='0'&&$_POST['admin_system']!='0'&&$_POST['type_chart']!='0') {
	    	$extension = end(explode(".", $_FILES["file_code"]["name"]));
		    if($extension=='csv'||$extension=='CSV'||$extension=='xls'||$extension=='xlsx'){
		        $upload_dir = wp_upload_dir();
		        $file_result=move_uploaded_file($_FILES["file_code"]["tmp_name"], $upload_dir['path']."/".$_FILES["file_code"]["name"]);
		        if($file_result){
					$ap = new PRODUCTION_SYSTEM();
					if($ap->check_production_system_exist($current_user, $_POST['production_system_name'])==0){
	                  	// Insert the ap into the database
						$ap->add_user_production_system($current_user,$_POST['production_system_name'], $_POST['type_chart'], $_POST['admin_system']);

						$client_id=0;
						if (isset($_POST['client_name'])&&$_POST['client_name']!='Search'&&$_POST['client_name']!='') {
							$client->get_client_by_name_and_user($_POST['client_name'], $current_user);
							$client_id=$client->id;
						}

	                    if($extension=='csv'||$extension=='CSV'){
	                        import_more_code_user_csv($_FILES["file_code"]["name"],$ap->id,$client_id);
	                    } else if($extension=='xls'||$extension=='xlsx'){
	                        import_more_code_user_excel_file($_FILES["file_code"]["name"],$ap->id,$client_id);
	                    }
	                    $optionId=$production_system_id;
	                    $msg= "Import successful";
	                } else {
						error_log("AP exists, not imported - " . $_POST['production_system_name']);
		                $msg_err = "AP exists, not imported - " . $_POST['production_system_name'];
					}
	            }else{
	                return "Error Upload";
	            }
	        }else{
	            return 'File must be of *.csv/CSV/xls/xlsx';
	        }
	    }else{
	        return "Missing values for new AP Chart";
	    }		
	}

	return "";
}
/*Import new code for user*/
function import_more_code_user($codes_array,$production_system_id,$client_id){
    global $wpdb;
    $current_user = new USER_INFO(wp_get_current_user()->ID);

	$apcode = new APCODE();
    $apcode->reset_last_import_for_user($current_user);
	foreach($codes_array as $code) {
        if($code->code!==''&&$code->description!=''){
			$apcode->insert_into_db_unless_found($current_user,
				$code->code,
				$code->description,
				$production_system_id);
        }
    }

	if ($client_id != 0) {
		$client = new CLIENT();		
		$client->update_client_production_system($production_system_id, $client_id);
	}
}

/*Import more code for user
 * The csv file have 2 column
 * Code is imported against user ID
 */
function import_more_code_user_csv($fileName,$production_system_id,$client_id=0){
    $upload_dir = wp_upload_dir();
    $fp = fopen($upload_dir['path'].'/'.$fileName, "r");

	$codes_array = array();
    while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
		$ob=new stdClass();
		$ob->code=$data[0];
		$ob->description=$data[1];
		$codes_array[] = $ob;
    }
    fclose($fp);

	import_more_code_user($codes_array,$production_system_id,$client_id);
}
/*Import more code for user
 * The excel file have 2 column
 */
function import_more_code_user_excel_file($fileName,$production_system_id,$client_id=0){
    $upload_dir = wp_upload_dir();
    $fp = fopen($upload_dir['path'].'/'.$fileName, "r");
    $i=0;
    include 'Classes/PHPExcel/IOFactory.php';
    $inputFileName = $upload_dir['path'].'/'.$fileName;
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

	$codes_array = array();
    foreach ($sheetData as $row){
		$ob=new stdClass();
		$ob->code=$row['A'];
		$ob->description=$row['B'];
		$codes_array[] = $ob;
    }
	
	import_more_code_user($codes_array,$production_system_id,$client_id);
}

function add_client_code($code,$desc,$client_id,$production_system_id,$current_user,$last_import=0) {
	$ccode = new CLIENT_CODE();
	$ccode->check_code_exist($code, $desc, $client_id,$current_user);
    if($ccode->id==0){
        $ap_code=new APCODE();
        $ap_code->get_from_code_and_ap($code,$production_system_id);
		// if ($ap_code->id != 0) {	// TODO: check if this is intended, i.e. do not import if APCODE not found?
		$ccode->insert_client_code_with_values(
			$code, 
			$desc, 
			$production_system_id, 
			$ap_code->id, 
			$client_id, 
			$current_user,
			$last_import);	// last_import
		// }
    }
}


/* Import code for client for csv file
 */
function import_code_for_client($rows,$client_id,$production_system_id){
    global $wpdb;
	$current_user = new USER_INFO(wp_get_current_user()->ID);
    $client= new CLIENT($client_id);
    $client->update_production_system($production_system_id);
	$client->delete_client_codes();
    $sql_update="update wp_client_code set last_import='0' where user_id='".$current_user->ID."' and last_import='1'";
    $wpdb->query($sql_update);
    foreach($rows as $data) {
        if($data[0]!==''&&$data[1]!=''){
            $datanew=  explode("-", $data[1]);
            if(isset($datanew[1]) && strlen($datanew[1])>0 && is_numeric(trim($datanew[0]))){
				// 123,123-description
				add_client_code($data[0], $datanew[1], $client_id, $production_system_id, $current_user,1);
				add_client_code($datanew[0], $datanew[1], $client_id, $production_system_id, $current_user,1);
            }else{
				// 123,XYZ
				add_client_code($data[0], $data[1], $client_id, $production_system_id, $current_user,1);
            }
        }
    }
}

/* Import code for client for csv file
 */
function import_code_for_client_csv($fileName,$client_id,$production_system_id){
    $upload_dir = wp_upload_dir();
    $fp = fopen($upload_dir['path'].'/'.$fileName, "r");
	$rows=array();
    while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
		$rows[]=$data;
    }
    fclose($fp);
    unlink($upload_dir['path'].'/'.$fileName);
	import_code_for_client($rows,$client_id,$production_system_id);
}

/* Import code for client for excel file
 */
function import_code_for_client_from_excel_file($fileName,$client_id,$production_system_id){    
    $upload_dir = wp_upload_dir();
    include 'Classes/PHPExcel/IOFactory.php';    
    $inputFileName = $upload_dir['path'].'/'.$fileName;
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	$rows=array();
    foreach ($sheetData as $row){
		$data=array($row['A'],$row['B']);
		$rows[]=$data;
    }
    unlink($inputFileName);
	import_code_for_client($rows,$client_id,$production_system_id);
}

/*create a new or import  production system one time only
 * the filename is import_one_time_only.csv
 */
function import_new_code_user($fileName,$production_system_id,$client_id){
    $upload_dir = wp_upload_dir();
    $fp = fopen($upload_dir['path'].'/'.$fileName, "r");
    $i=0;
	$codes_array = array();
    while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
        if($data[1]!==''&&$data[2]!=''){			
			$ob=new stdClass();
			$ob->code=$data[2];
			$ob->description=$data[1];
			$codes_array[] = $ob;
        }
    }
    fclose($fp);
	import_more_code_user($codes_array, $production_system_id, $client_id);
}

/* Export to PDF file using wkhtmltopdf, installed via RPM */
function export_to_pdf_file(&$rows, $date_new, $sum_new, $date_old, $sum_old, $file_name, $force){
    error_reporting(E_ALL);
	$base_url=  get_option('siteurl');
    $current_user=  wp_get_current_user();
    $upload_dir=  wp_upload_dir();
	$html_file_path = $upload_dir['basedir']."/html/$file_name.html";
	$pdf_file_path = $upload_dir['basedir']."/html/$file_name.pdf";
	
	if (file_exists($pdf_file_path)) {
		if ($force) {
			// delete old files and recreate
			unlink($html_file_path);
			unlink($pdf_file_path);
		} else {
			return;
		}		
	}	
	
	$html_file = fopen($html_file_path, "w") or die("Unable to open file $html_file_path for writing (html->pdf export)!");
	$html = <<<'ENDHTML'
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
		</head>
		<body>
			<div class="container">
				<img src="<?=$base_url?>/wp-content/uploads/logo/logo-1.jpg" style="position:absolute;top:-10px;left:15px;width:120px">
				<h2 style="text-align:center;padding-bottom:15px;padding-top:15px">Compare Trial Balances</h2>
			  	<table class="table table-bordered" style="font-size:12px;font-family:Helvetica">
				        <thead>
				          <tr>
ENDHTML;
	fwrite($html_file, $html);
	$html = sprintf('<th style="text-align:center">NEW<br>TRIAL BALANCE<br>[%s]</th>
		            <th style="width:85px;text-align:center">BALANCE CHECK<br>[%01.2f]</th>
		            <th style="text-align:center">OLD<br>TRIAL BALANCE<br>[%s]</th>
		            <th style="width:85px;text-align:center">BALANCE CHECK<br>[%01.2f]</th>
		            <th style="width:85px;text-align:center">DIFFERENCE</th></tr></thead><tbody>', 
				$date_new, $sum_new, $date_old, $sum_old);
	fwrite($html_file, $html);
	if(count($rows)>0){
	    foreach($rows as $row){
			$html = sprintf('<tr><td style="padding:2px 4px">%s</td>
				            <td style="width:85px;text-align:right;padding:2px 4px">%01.2f</td>
				            <td style="padding:2px 4px">%s</td>
				            <td style="width:85px;text-align:right;padding:2px 4px">%01.2f</td>
				            <td style="width:85px;text-align:right;padding:2px 4px">%01.2f</td></tr>', 
				$row->description, $row->balance, $row->description_old, $row->balance_old, $row->difference);
			fwrite($html_file, $html);			
		}
	}
	$html = '</tbody></table></div></body></html>';
	fwrite($html_file, $html);			
	fclose($html_file);
	unset($html_file);
	$html_file = null;
	
	// DC: To avoid "Unable to fork" warnings, /etc/httpd/conf/httpd.conf and /etc/php.ini are tuned according to
	// http://imperialwicket.com/tuning-apache-for-a-low-memory-server-like-aws-micro-ec2-instances/
	exec("/usr/local/bin/wkhtmltopdf --encoding 'utf-8' $html_file_path $pdf_file_path > /dev/null 2>/dev/null", $output, $ret_val);
	
	if ($ret_val != 0) {
		error_log("error writing compare tb pdf - " . print_r($output, true));
	} else {
		error_log("success writing compare tb pdf.");
	}
}


/*Export to Excel file*/
function export_to_excel_file(&$rows, $date_new, $sum_new, $date_old, $sum_old, $file_name, $force){
    error_reporting(E_ALL);
    $upload_dir=  wp_upload_dir();    
	$excel_path = $upload_dir['basedir']."/excel/$file_name.xlsx";
	
	if (file_exists($excel_path)) {
		if ($force) {
			// delete old file and recreate
			unlink($excel_path);
		} else {
			return;
		}		
	}
	
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');
    define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
    /** Include PHPExcel */
    include 'Classes/PHPExcel.php';
    $objPHPExcel = new PHPExcel();
    $objPHPExcel->getProperties()->setCreator("TBCoder")
				->setLastModifiedBy("TBCoder")
				->setTitle("Compare TBs")
				->setSubject("Compare TBs")
				->setDescription("Compare TBs.")
				->setKeywords("TBCoder Compare TBs")
				->setCategory("TBCoder Compare TBs");
    // Add some data    
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', "NEW TB $date_new")
            ->setCellValue('B1', "NEW BALANCE CHECK [$sum_new]")
            ->setCellValue('C1', "OLD TB $date_old")
            ->setCellValue('D1', "OLD BALANCE CHECK [$sum_old]")
            ->setCellValue('E1', 'DIFFERENCE');
    if(count($rows)>0){
        $i=2;
        foreach ($rows as $row){
            $cellA='A'.$i;
            $cellB='B'.$i;
            $cellC='C'.$i;
            $cellD='D'.$i;
            $cellE='E'.$i;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue($cellA, $row->description)
                    ->setCellValue($cellB, ($row->balance === '' ? '' : number_format($row->balance,2,".","")))
                    ->setCellValue($cellC, $row->description_old)
                    ->setCellValue($cellD, ($row->balance_old === '' ? '' : number_format($row->balance_old,2,".","")))
                    ->setCellValue($cellE, ($row->difference === '' ? '' : number_format($row->difference,2,".","")));
            $i++;
        }    
    }
    
    $objPHPExcel->getActiveSheet()->setTitle('Compare TBs');
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    // Save Excel 2007 file
    $callStartTime = microtime(true);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    date_default_timezone_set('Europe/London');
    $time=time();
    $objWriter->save($excel_path);
    
    $callEndTime = microtime(true);
    $callTime = $callEndTime - $callStartTime;

	unset($objPHPExcel);
	$objPHPExcel = null;
	unset ($objWriter);
	$objWriter = null;

    //echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
    //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
    // Echo memory usage

}

function startsWith($haystack, $needle) {
    return (substr($haystack, 0, strlen($needle)) === $needle);
}

function endsWith($haystack, $needle) {
    return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
}

function code_row($user_info, $row, $client_id, $production_system_id, $wide_map) {
	$row->client_code_id=0;
    $ccode=new CLIENT_CODE();
    $ccode->match_code_by_des($row->description, $client_id);
    $apcode=new APCODE();
    if($wide_map==1&&$ccode->id==0){
		// if wide_map is selected, check code from other clients, insert to this client if found
		$ccode->insert_code_from_other_clients($row->description, $client_id, $production_system_id);
    }
    if($ccode->id==0){
		// If code is not found, try Account Production
        $apcode->match_code_by_des_plural($user_info, $row->description, $production_system_id);
        if($apcode->id!=0){
			$ccode->insert_from_apcode($user_info,$apcode,$client_id,$row->description);
        }
    } else {
		// If code is found
        $row->client_code_id=$ccode->id;
        $apcode->get_from_code_and_ap($ccode->code, $production_system_id);
	}

	// Value-add on $row for CSV output
    $row->code=($ccode->id == 0 ? '' : $ccode->code);
    $row->description_original=$row->description;
	$row->code_original=($apcode->id == 0 ? '' : $apcode->code);
    $row->description=$apcode->description;
	
	// clean currency
	// replace the comma with a dot, in the number format ",12" or ",43"
	$row->price = preg_replace('/,(\d{2})$/', '.$1', $row->price);

	// remove everything except a digit "0-9", and a dot "." and negative sign "-"
	$row->price = preg_replace('/[^-\d\.]/', '', $row->price);
}

/* Insert balance by array of rows
   wp_balance inserted against User ID
   $rows is array of description, price
   $source enum, 0=file, 1=xero, 2=quickbooks, 3=freeagent, 4=kashflow, 5=sageone
*/
function insert_balance($source,$user_info,$rows,$production_system_id,$client_id,$name,$description='',$wide_map=0,$simple_csv=1, $opening_balance=false, $date_to, $date_from){
    global $wpdb;
    date_default_timezone_set('Europe/London');
	$time = time();
	if ($opening_balance) {
		// delete previously uploaded o/bal
		$sql="select file_id from wp_balance where last_file='1' and userid='".$user_info->ID."' limit 1";
		$tb_file_id=$wpdb->get_var($sql);
		$sql_delete="delete from wp_open_balance where tb_file_id='$tb_file_id'";
	    $wpdb->query($sql_delete);
	} else {
		// Invalidate previous last_file
	    $sql_update="update wp_balance set last_file='0' where last_file='1' and userid='".$user_info->ID."'";
	    $wpdb->query($sql_update);
	}
	// process each row
    foreach ($rows as $row){
		code_row($user_info, $row, $client_id, $production_system_id, $wide_map);

		if ($opening_balance) {
        	$sql="insert into wp_open_balance (code,description,price,userid,code_original,time,description_original,".
				 "production_system_id,client_id,client_code_id,manager_id, tb_file_id) values ('" .
				 $row->code."','".mysql_real_escape_string($row->description)."','".mysql_real_escape_string($row->price)."','".
				 $user_info->ID."','".$row->code_original."','".$time."','".mysql_real_escape_string($row->description_original)."','".
				 $production_system_id."','$client_id','$row->client_code_id','".$user_info->get_manager_id() ."','$tb_file_id')";
		} else {
        	$sql="insert into wp_balance (code,description,price,userid,code_original,time,last_file,description_original,".
				 "production_system_id,client_id,client_code_id,manager_id, need_ob_check) values ('" .
				 $row->code."','".mysql_real_escape_string($row->description)."','".mysql_real_escape_string($row->price)."','".
				 $user_info->ID."','".$row->code_original."','".$time."','1','".mysql_real_escape_string($row->description_original)."','".
				 $production_system_id."','$client_id','$row->client_code_id','".$user_info->get_manager_id() ."','0')";
		}
        if(!$wpdb->query($sql)){
            error_log("Insert Error - [$sql]");
            die('Error insert');
        }
    }

	$fileName = $name;
	if (endsWith(strtolower($fileName), ".xls")) {
		$fileName = substr($fileName, 0, strlen($fileName) - 4) . ".csv";
	} else if (endsWith($fileName, ".xlsx")) {
		$fileName = substr($fileName, 0, strlen($fileName) - 5) . ".csv";
	} else if (!endsWith(strtolower($fileName), ".csv")) {
		// not xls or csv
	    $fileName=$name.'-'.date('YmdHis', $time).".csv";
	}
	
	$update_where_clause='';
	if ($opening_balance) {
		$update_where_clause = "and opening_balance=true";
	}
    $sql_update="update wp_csv_file set last_file='0' where user_id='".$user_info->ID."' and last_file='1' $update_where_clause";
    $wpdb->query($sql_update);		

    $names=explode(".",$fileName);
    $upload_dir = wp_upload_dir();
    write_to_csv($upload_dir['path'].'/'.$names[0].'.csv',$rows,$production_system_id,$simple_csv);

    $csvfilepath=$upload_dir['url']."/".$names[0].".csv";
    $excelfilepath=$upload_dir['url']."/".$fileName;
    $path_csv_file=$upload_dir['path']."/".$names[0].".csv";
    $path_excel_file=$upload_dir['path']."/".$name;

    $sql="insert into wp_csv_file (csv_file,excel_file,time,user_id,last_file,path_csv_file,path_excel_file,production_system_id,name,description,client_id, date_from, date_to, opening_balance, source, wide_map) values('"
		 .$csvfilepath."','".$excelfilepath."','".$time."','".$user_info->ID."','1','".$path_csv_file."','".$path_excel_file."','"
		 ."$production_system_id','$name','$description','$client_id', '$date_from','$date_to'," . ($opening_balance ? 'true' : 'false') . ",'$source','$wide_map')";
    $wpdb->query($sql);

    $sql1="select id from wp_csv_file where user_id='".$user_info->ID."' and last_file='1' and time='".$time."'";
    $file_id=$wpdb->get_var($sql1);
	if ($opening_balance) {
		update_file_id_for_open_balance($user_info->ID, $file_id, $time,$tb_file_id);
	} else {
	    update_file_id_for_balance($user_info->ID, $file_id, $time);
	}
    return $csvfilepath;
}

function import_tb_file($fileName, $is_excel) {
	$upload_dir = wp_upload_dir();
    error_reporting(E_ALL);
    set_time_limit(0);
    date_default_timezone_set('Europe/London');
    $inputFileName = $upload_dir['path'].'/'.$fileName;
    $a = array();

	if ($is_excel) {
	    include_once 'Classes/PHPExcel/IOFactory.php';
	    //echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
	    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	    foreach ($sheetData as $row){
	        if($row['A'] != '' && $row['B'] != ''){
		        $ob=new stdClass();
				if (isset($row['C']) && $row['C'] != '' && is_numeric($row['C'])) {
					// A is code, B is description, C is price
					$ob->code=trim($row['A']);
					$ob->description=trim($row['B']);
					$ob->price=trim($row['C']);
				} else {
					// A is description, B is price
					$ob->description=trim($row['A']);
					$ob->price=trim($row['B']);
					////$ob->py_price=trim($row['C']);	// previous year
				}
				$a[] = $ob;
			}
		}
	} else {
		// csv file
		$fp = fopen($inputFileName, "r");
	    while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
            $ob = new stdClass();
			if (count($data) > 2 && is_numeric($data[2])) {
				// [0] is code, [1] is description, [2] is price
				$ob->code=trim($data[0]);
				$ob->description=trim($data[1]);
				$ob->price=trim($data[2]);				
			} else if (count($data) > 1 && is_numeric($data[1])) {
				$ob->description = trim($data[0]);
				$ob->price = trim($data[1]);
				////$ob->py_price=trim($data[2]);	// previous year
			}
			$a[] = $ob;
			// TODO: show error importing \r
	    }
	    fclose($fp);
	}
    return $a;
}

/*Import balance for excel file*/
function insert_balance_for_excel($source,$user_info,$fileName,$production_system_id,$client_id,$name,$description,$wide_map=0, $opening_balance=false, $date_to, $date_from){
    $upload_dir = wp_upload_dir();
    error_reporting(E_ALL);
    set_time_limit(0);
    date_default_timezone_set('Europe/London');
    include 'Classes/PHPExcel/IOFactory.php';
    $inputFileName = $upload_dir['path'].'/'.$fileName;
    //echo 'Loading file ',pathinfo($inputFileName,PATHINFO_BASENAME),' using IOFactory to identify the format<br />';
    $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    $a=array();
    foreach ($sheetData as $row){      
        if($row['A']!=''&&$row['B']!=''){
	        $ob=new stdClass();
			$ob->description=trim($row['A']);
			$ob->price=trim($row['B']);
			$a[] = $ob;
		}
	}
    insert_balance($source,$user_info,$a,$production_system_id,$client_id,$fileName,$description,$wide_map,0, $opening_balance, $date_to, $date_from);
}

/*Import balance for csv file*/
function insert_balance_for_csv($source,$user_info,$fileName,$production_system_id,$client_id,$name,$description,$wide_map=0, $opening_balance=false, $date_to, $date_from){
    $upload_dir = wp_upload_dir();
    $fp = fopen($upload_dir['path'].'/'.$fileName, "r");
    $a=array();
    while (($data = fgetcsv($fp, 1000, ",")) !== FALSE) {
        if(is_numeric(str_replace("-","",$data[1]))){
            $ob=new stdClass();
			$ob->description=trim($data[0]);
			$ob->price=trim($data[1]);
			$a[]=$ob;
		}
		// TODO: show error importing \r
    }
    fclose($fp);
	insert_balance($source,$user_info,$a,$production_system_id,$client_id,$fileName,$description,$wide_map,0, $opening_balance, $date_to, $date_from);
}

function export_to_csv($user_id, $rows_balance){
    global $wpdb;
	$csv_last_file = new CSV_LAST_FILE($user_id);
	write_to_csv($csv_last_file->path_csv_file,$rows_balance,$rows_balance[0]->production_system_id,0);

    $sql_update_export="update wp_csv_file set export=1 where id='".$csv_last_file->id."'";
    $wpdb->query($sql_update_export);
	return $csv_last_file->path_csv_file;
}

add_action('wp_ajax_export_to_csv_from_file_id', 'export_to_csv_from_file_id_ajax');
function export_to_csv_from_file_id_ajax(){
	if(isset($_POST['file_id'])){
		$file_path = export_to_csv_from_file_id($_POST['file_id']);
		echo $file_path;
	} else {
		echo '0';
	}
	exit();
}

function export_to_csv_from_file_id($file_id){
    global $wpdb;
	$rows_balance=get_file_compare_by_file_id($file_id);
	
    $sql="select path_csv_file from wp_csv_file where id='".$file_id."'";
    $path_csv_file=$wpdb->get_var($sql);
	
	write_to_csv($path_csv_file,$rows_balance,$rows_balance[0]->production_system_id,0);
	return $path_csv_file;
}

function format_code_csv($code) {
	return '="' . $code . '"';
}

// generic write to csv shared function
function write_to_csv($filepath,$rows_balance,$production_system_id,$simple_csv=0){
    $cproduct_system=new PRODUCTION_SYSTEM($production_system_id);
    $t=trim($cproduct_system->get_name_ap_system());
    $f=0;
    $fp = fopen($filepath, "w");
    $fp_gen = fopen(preg_replace('/.csv$/i', '-g.csv', $filepath), "w");
    if($t==='IRIS Practice Suite'||$t==='PTP'){
        foreach ($rows_balance as $val){
            $data=array();
            $data[]=$val->price;
            $data[]=format_code_csv($val->code);
            $data[]=$val->description_original;
            if(!fputcsv($fp, $data)){
                die('error');
            }
        }
        $f=1;
    }
    if($t==='VT'){
        foreach ($rows_balance as $val){
            $data=array();
            $data[]=$val->description;
            $data[]=$val->description_original;
            $data[]=$val->price;
            if(!fputcsv($fp, $data)){
                die('error');
            }
        }
        $f=1;
    }
    if($t==='TaxCalc Accounts Production'||$t==='CaseWare Accounts Production'
		||$t==='Digita Accounts Production'||$t==='Forbes Accounts'
		||$t==='Eureka Software'||$t==='Absolute Accounts Production'
		||$t==='First Choice Final Accounts'){
        foreach ($rows_balance as $val){
            $data=array();
            $data[]=format_code_csv($val->code);
            $data[]=$val->description_original;	// bookeeping desc
            $data[]=$val->price;
            if(!fputcsv($fp, $data)){
                die('error');
            }
        }
        $f=1;
    }
    if($t==='gbooks Company Accounts'){
        foreach ($rows_balance as $val){
            $data=array();
            $data[]=format_code_csv($val->code);
            $data[]=$val->description;
            $data[]=$val->description_original;
            if($val->price>0){
                $data[]=abs($val->price);
                $data[]=' ';
            }else{
                $data[]=' ';
                $data[]=abs($val->price);
            }
            if(!fputcsv($fp, $data)){
                die('error');
            }
        }
        $f=1;
    }
   
    if($t==='Keytime'||$t==='CCH Accounts Production'||$t==='Pinacle'||$t==='Sage Accounts Production'){
        foreach ($rows_balance as $val){
            $data=array();
            $data[]=format_code_csv($val->code);
            $data[]=$val->description_original;
            if($val->price>0){
                $data[]=abs($val->price);
                $data[]=' ';
            }else{
                $data[]=' ';
                $data[]=abs($val->price);
            }
            if(!fputcsv($fp, $data)){
                die('error');
            }
        }
        $f=1;
    }
    foreach ($rows_balance as $val){
        $data=array();
        $data[]=format_code_csv($val->code);
        $data[]=$val->description;	// ap desc
        $data[]=$val->description_original;	// bookeeping desc
        $data[]=$val->price;
		// write general file
        if(!fputcsv($fp_gen, $data)){
            die('error');
        }
		if ($f==0) {
			// lack of system specific file
	        if(!fputcsv($fp, $data)){
	            die('error');
	        }
		}
    }
    fclose($fp);
	fclose($fp_gen);
}

add_action('wp_login', 'after_login_function',10,2);
function after_login_function($user_login,$user){
    global $wpdb;
    $base_url=  get_option('siteurl');
	$current_user = new USER_INFO($user->ID);
    if(check_user_code_exist($user)==0){
        $rows=  get_all_code();
        foreach ($rows as $row){
            $sql="insert into wp_user_code (code,description,user_id,production_system_id,manager_id) values ('".
				 mysql_real_escape_string($row->code)."','".mysql_real_escape_string($row->description)."','".$user->ID."','33','" . $current_user->get_manager_id() . "')";
            $wpdb->query($sql);
        }
    }
	if ($_REQUEST['redirect_to']) {
		wp_redirect($_REQUEST['redirect_to']);
	} else {
		wp_redirect(home_url('/import-tb/'));
	}

    exit();
}

add_action('wp_ajax_delete_code', 'delete_code');
function delete_code(){
    global $wpdb;
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        $sql="delete from wp_user_code where id='".$id."'";
        $wpdb->query($sql);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}
add_action('wp_ajax_delete_code_extract', 'delete_code_extract');
function delete_code_extract(){
    global $wpdb;
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        $sql="delete from wp_user_code_extract where id='".$id."'";
        $wpdb->query($sql);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}
add_action('wp_ajax_delete_code_client', 'delete_code_client');
function delete_code_client(){
    global $wpdb;
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        $sql="delete from wp_client_code where id='".$id."'";
        $wpdb->query($sql);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_check_client_import', 'check_client_import');
function check_client_import(){
	$_POST = stripslashes_deep( $_POST );
	$current_user = new USER_INFO(wp_get_current_user()->ID);
    if(isset($_POST['client_name'])){
        $client_name=$_POST['client_name'];
        $client = new CLIENT();
        $client->get_client_by_name_and_user($client_name, $current_user);
        if($client->id!=0){
            if($client->production_system_id!=0){
                echo '1';
                exit();
            }
        }
    }
    echo '0';
    exit();
}

add_action('wp_ajax_get_rows_donwload_file', 'get_rows_donwload_file');
function get_rows_donwload_file(){
    global $wpdb;
    $base_url=  get_option('siteurl');
    if(isset($_POST['id_ap_system'])){
        $current_user=  wp_get_current_user();
        $rows=get_file_csv_by_user($current_user->ID); 
        ?>
    <div style="border-bottom: 1px solid #dddddd;">
        <div class="fleft d-check"><input type="checkbox" ></div>
        <div class="fleft d-date" style="font-weight:bold;">Date</div>
        <div class="fleft d-name" style="font-weight:bold;">Client Name</div>
        <div class="fleft d-description" style="font-weight:bold;">Notes</div>
        <div class="fleft d-pro-system" style="font-weight:bold;">Product system/AP system</div>
        <div class="fleft d-download" style="font-weight:bold;">Download</div>
        <div class="fleft d-delete" style="font-weight:bold;">Delete</div>
        <div class="clr"></div>
    </div>
    <?php $i=0; foreach ($rows as $row){?>
        <?php $cproduct_sys=new PRODUCTION_SYSTEM($row->production_system_id);?>
        <?php if($cproduct_sys->ap_system_id==$_POST['id_ap_system']||$_POST['id_ap_system']=='0'){?>
            <div  style="border-bottom: 1px solid #dddddd;" class='<?=$i%2==0?"odd":""?>'>
                <div class="fleft d-check">
                    <input type="checkbox" name="a[<?=$row->id?>] " value="<?=$row->id?>" 
                           <?php if(isset($_POST['a'])){?>
                                <?php if(in_array($row->id, $_POST['a'])){ echo "checked";?>

                                <?php }?>
                           <?php }?>
                           >
                </div>
                <?php date_default_timezone_set('Europe/London');?>
                <div class="fleft d-date" style=""><?=date("d M Y-H:i:s",$row->time)?></div>
                <div class="fleft d-name" style=";">
                    <?php 
                    $sql1="select * from wp_balance where file_id='".$row->id."'";
                    $rows11=$wpdb->get_results($sql1);
                    $sql2="select * from wp_client where id='".$rows11[0]->client_id."'";
                    $rows21=$wpdb->get_results($sql2);
                    echo $rows21[0]->client_name;
                    ?>
                </div>
                <div class="fleft d-description" style=";">
                    <?php 
                    echo $row->description;
                    ?>
                </div>
                <div class="fleft d-pro-system">
                    <?php if($cproduct_sys->name===''){?>
                    <span>&nbsp;</span>
                    <?php }else{?>
                        <?=$cproduct_sys->name." / ".$cproduct_sys->get_name_ap_system();?>
                    <?php }?>
                </div>
                <div class="fleft d-download"><a href="<?=$base_url."/page-download?filename=".$row->path_csv_file?>">Download File</a></div>
                <div class="fleft d-delete">
                    <a onclick="delete_file('<?=$row->id?>',this);">
                        <img src="<?=  bloginfo('template_url')?>/images/delete.png"/>
                    </a>
                </div>
                <div class="clr"></div>
            </div>
        <?php }?>
    <?php $i++;}?>
    
<?php
    exit();
    }else{
        echo "0";
        exit();
    }
}
add_action('wp_ajax_delete_trial_balance', 'delete_trial_balance');
function delete_trial_balance(){
    if(isset($_POST['id'])){
        $user_id=$_POST['user_id'];
        $id=$_POST['id'];
        $a=  get_user_meta($user_id,"_trial_balance",true);
        $b=array();
        foreach ($a as $value){
            if($value!=$id){
                $b[]=$value;
            }
        }
        update_user_meta($user_id, "_trial_balance", $b);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_delete_production_system', 'delete_production_system');
function delete_production_system(){
    global $wpdb;
    if(isset($_POST['id']) && isset($_POST['user_id'])){
        $user_id=$_POST['user_id'];
        $id=$_POST['id'];
		PRODUCTION_SYSTEM::delete_production_system_and_codes($user_id, $id);
        echo $id;
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_delete_file', 'delete_file');
function delete_file(){
    global $wpdb;
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        $sql="select * from wp_csv_file where id='".$id."'";
        $rows=$wpdb->get_results($sql);
        unlink($rows[0]->path_csv_file);

	    $generic_format_csv = preg_replace('/.csv$/i', '-g.csv', $rows[0]->path_csv_file);
        unlink($generic_format_csv);

        if(end(explode(".", $rows[0]->path_excel_file))!='csv'){
            unlink($rows[0]->path_excel_file);
        }
        $sql1="delete from wp_csv_file where id='".$id."'";
        $wpdb->query($sql1);
        $sql2="delete from wp_balance where file_id='".$id."'";
        $wpdb->query($sql2);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_delete_files', 'delete_files');
function delete_files(){
    global $wpdb;
    if(isset($_POST['ids'])){
        $ids=$_POST['ids'];

		// delete opening balances
		$sql="select * from wp_csv_file where id in (select distinct(file_id) from wp_open_balance where tb_file_id in (".join(',', $ids)."))";
        $rows=$wpdb->get_results($sql);
		foreach ($rows as $row) {
			$filepath = str_replace(" ", "\\ ", $row->path_csv_file);
			if (file_exists($filepath)) {
	            unlink($filepath);
			}
	        if(end(explode(".", $row->path_excel_file))!='csv'){
				$filepath = str_replace(" ", "\\ ", $row->path_excel_file);
				if (file_exists($filepath)) {
		            unlink($filepath);
				}
	        }
		}
		$sql1="delete from wp_csv_file where id in (select distinct(file_id) from wp_open_balance where tb_file_id in (".join(',', $ids)."))";
        $wpdb->query($sql1);
        $sql2="delete from wp_open_balance where tb_file_id in (".join(',', $ids).")";
        $wpdb->query($sql2);

		// delete tb
        $sql="select * from wp_csv_file where id in (".join(',', $ids).")";
        $rows=$wpdb->get_results($sql);
		foreach ($rows as $row) {
			$filepath = str_replace(" ", "\\ ", $row->path_csv_file);
			if (file_exists($filepath)) {
	            unlink($filepath);
			}
	        if(end(explode(".", $row->path_excel_file))!='csv'){
				$filepath = str_replace(" ", "\\ ", $row->path_excel_file);
				if (file_exists($filepath)) {
		            unlink($filepath);
				}
	        }
		}
        $sql1="delete from wp_csv_file where id in (".join(',', $ids).")";
        $wpdb->query($sql1);
        $sql2="delete from wp_balance where file_id in (".join(',', $ids).")";
        $wpdb->query($sql2);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_delete_balance', 'delete_balance');
function delete_balance(){
    global $wpdb;
    if(isset($_POST['id_balance'])&&isset($_POST['file_id'])&&isset($_POST['is_tb'])){
        $file_id=$_POST['file_id'];
        $id_balance=$_POST['id_balance'];
		$tbl_name = ($_POST['is_tb'] === '1' ? 'wp_balance' : 'wp_open_balance');
        $sql="delete from $tbl_name where id='".$id_balance."'";
        $wpdb->query($sql);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}
/*Show posible match*/
add_action('wp_ajax_get_possible_match', 'get_possible_match');
function get_possible_match(){
    global $wpdb;
	$current_user = new USER_INFO(wp_get_current_user()->ID);
	$tbl_name = ($_POST['is_tb'] === '1' ? 'wp_balance' : 'wp_open_balance');
    $sql1="select * from $tbl_name where id='". mysql_real_escape_string($_POST['rowid'])."'";
    $rows=$wpdb->get_results($sql1);
    $row=$rows[0];	
    $rows_possible=get_other_possible($row->description_original,$current_user,$row->production_system_id);
    ?>
        <div style="border-bottom: 1px solid #c2c2c2;background: #0188CC;padding: 5px 0;">
            <div class="fleft pop-check">&nbsp;</div>
            <div class="fleft pop-code" style="font-weight: bold;">Account Code</div>
            <div class="fleft pop-name" style="font-weight: bold;width:378px;">Account Name</div>
            <div class="fleft pop-close" style="font-weight: bold;width: 25px;">
                <img src="<?=  bloginfo('template_url')?>/images/remove-red.png" width="20px">
            </div>
            <div class="clr"></div>
        </div>
        <div style="overflow: scroll;min-height: 200px;max-height: 400px;">
        <?php foreach ($rows_possible as $row_possible){   ?>
            <div style="border-bottom: 1px solid #c2c2c2;">
                <div class="fleft pop-check"><input type="radio" name="pop-check-radio"
					onclick="if ($(this).is(':checked')){ check_update_possible(this,'<?=str_replace("'","\'",htmlspecialchars($row->description_original))?>','<?=$row_possible->id?>','<?=$row->id?>','<?=$row->client_id?>');}"></div>
                <div class="fleft pop-code"><?=$row_possible->code?></div>
                <div class="fleft pop-name"><?=$row_possible->description?></div>
                <div class="fleft pop-close" style="">&nbsp;</div>
                <div class="clr"></div>
            </div>
        <?php }?>
        </div>   
    <?php
    exit();
}


add_action('wp_ajax_search_code_from_string', 'search_code_from_string');
function search_code_from_string(){
	$_POST = stripslashes_deep( $_POST );
    $base_url=  get_option("siteurl");
    global $wpdb;
    if(isset($_POST['production_system_id'])&&isset($_POST['str_search'])&&isset($_POST['manager_id'])&&isset($_POST['id'])&&isset($_POST['description_original'])){
        $sql="select * from wp_user_code where description like '%".mysql_real_escape_string(trim($_POST['str_search']))."%' and production_system_id='".
			 mysql_real_escape_string($_POST['production_system_id'])."' and manager_id='". mysql_real_escape_string($_POST['manager_id'])."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){?>
                <input name="id_balance" value="<?=$_POST['id']?>" type="hidden" id="id-balance">
                <div style="color: #000080;font-weight: bold;"><?=count($rows)?> Other possible matches found</div>
                <div style="border-bottom: 1px solid #c2c2c2;">
                    <div class="fleft pop-check">&nbsp;</div>
                    <div class="fleft pop-code" style="font-weight: bold;">Account Code</div>
                    <div class="fleft pop-name" style="font-weight: bold;">Account Name</div>
                    <div class="clr"></div>
                </div>
            <?php foreach ($rows as $row){   ?>
                <div style="border-bottom: 1px solid #c2c2c2;">
                    <div class="fleft pop-check"><input type="checkbox" onclick="check_update(this,'<?=$_POST['description_original']?>','<?=$_POST['production_system_id']?>','<?=$row->id?>');"></div>
                    <div class="fleft pop-code"><?=$row->code?></div>
                    <div class="fleft pop-name"><?=$row->description?></div>
                    <div class="clr"></div>
                </div>
            <?php }?>
<script>
    function check_update(a,description_original,production_system_id,id_code){
        id=jQuery("#id-balance").val();
        id_balance="#row_"+jQuery("#id-balance").val();
        if(jQuery(a).prop('checked')===true){
            var r=confirm("Do you want to update!");
            if (r===true){
                code=jQuery(a).parent().parent().children(".pop-code").text();
                des=jQuery(a).parent().parent().children(".pop-name").text();
                jQuery(id_balance+" .i-code").text(code);
                //jQuery(id_balance+" .i-description-sys").text(des);
                //new change
                jQuery(id_balance+" .i-description-sys").text(description_original);
                url = '<?=$base_url?>';
                jQuery.post(url+'/wp-admin/admin-ajax.php',{action:'update_code_search',code:code,description:des,id:id,description_original:description_original,production_system_id:production_system_id,id_code:id_code},function(data){
                    if(data==='0'){
                        alert('No result');
                    }else{
                        alert('Update code success');
                    }
                },'html'); 
            }
            jQuery("#search-result").css('display','none');
        }
    }
</script>
        <?php }
        
        exit();
    }else{
        echo '0';
    exit();
    }
}

add_action('wp_ajax_update_code_search', 'update_code_search');
function update_code_search(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
    if(isset($_POST['id'])&&isset($_POST['code'])&&isset($_POST['description'])&&isset($_POST['description_original'])&&isset($_POST['production_system_id'])&&isset($_POST['id_code'])){
        $sql="update wp_balance set code='".
			 mysql_real_escape_string($_POST['code'])."',description='".mysql_real_escape_string($_POST['description_original'])."' where id='".mysql_real_escape_string($_POST['id'])."'";
        $wpdb->query($sql);

		$apcode = new APCODE();
		$apcode->id=mysql_real_escape_string($_POST['id_code']);
		$apcode->update_apcode_alias($_POST['description_original']);
        echo '1';
        exit();
    }else{
        echo '0';
        exit();
    }
}
add_action('wp_ajax_update_posible_new_code', 'update_posible_new_code');
function update_posible_new_code(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
    if(isset($_POST['old_des'])&&isset($_POST['id'])&&isset($_POST['id_switching'])){
        $old_des=mysql_real_escape_string($_POST['old_des']);
        $code=mysql_real_escape_string($_POST['code']);
        $id=mysql_real_escape_string($_POST['id']);
        $id_switching=mysql_real_escape_string($_POST['id_switching']);

		$apcode = new APCODE();
		$apcode->id=mysql_real_escape_string($id);
		$apcode->update_apcode($_POST['code'],$_POST['old_des']);

        $sql1="update wp_switching set new_code='".$code."',new_des='".$old_des."' where id='".$id_switching."'";
        $wpdb->query($sql1);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_update_possible_balance_code', 'update_possible_balance_code');
function update_possible_balance_code(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
    if(isset($_POST['id_code'])&&isset($_POST['description_original'])&&isset($_POST['id_balance'])&&isset($_POST['client_id'])){		
        $code=new APCODE();
		if ($code->get_code_from_id(mysql_real_escape_string($_POST['id_code'])) != 0) {
	        $a=array();
	        $a['code']=$code->code;
	        $a['description']=$code->description;
	        echo json_encode($a);
		} else {
			echo '0';
		}
    }else{
        echo '0';
    }
    exit();
}
add_action('wp_ajax_update_possible_balance_code_client_custom', 'update_possible_balance_code_client_custom');
function update_possible_balance_code_client_custom(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
    if(isset($_POST['id_code'])&&isset($_POST['description_original'])&&isset($_POST['id_balance'])&&isset($_POST['is_tb'])){
		$tbl_name = ($_POST['is_tb'] === '1' ? 'wp_balance' : 'wp_open_balance');
        $code= get_rows_condition('id',$_POST['id_code'],'wp_client_code');
        $sql="update $tbl_name set code='".$code[0]->code."',description='".$code[0]->description."' where id='".$_POST['id_balance']."'";
        $wpdb->query($sql);
        $a=array();
        $a['code']=$code[0]->code;
        $a['description']=$code[0]->description;
        echo json_encode($a);
        exit();
    }else{
        echo '0';
        exit();
    }
}

/*Export Production Codes to Excel file*/
add_action('wp_ajax_export_ap_codes_to_excel_file', 'export_ap_codes_to_excel_file');
function export_ap_codes_to_excel_file(){
    error_reporting(E_ALL);
	$_POST = stripslashes_deep( $_POST );
	try {		
		$ap_id = $_POST['ap_id'];
		$sort = $_POST['sort'];
	
	    $upload_dir=  wp_upload_dir();
		$prodsys = new PRODUCTION_SYSTEM($ap_id);
	
		$excel_path = sprintf("%s/excel/ap-codes-%s-%d.xlsx", $upload_dir['basedir'], $prodsys->name, $ap_id);
		
		if($sort === 'code'){
	        $rows=$prodsys->get_user_code_by_id_with_sort($current_user,$_POST['production_system_value'],'code');
	    } else if($sort === 'description'){
	        $rows=$prodsys->get_user_code_by_id_with_sort($current_user,$_POST['production_system_value'],'description');
	    } else {
	        $rows=$prodsys->get_codes();
		}
		
		if (file_exists($excel_path)) {
			// delete old file and recreate
			unlink($excel_path);
		}
	
	    ini_set('display_errors', TRUE);
	    ini_set('display_startup_errors', TRUE);
	    date_default_timezone_set('Europe/London');
	    define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
	    /** Include PHPExcel */
	    include 'Classes/PHPExcel.php';
	    $objPHPExcel = new PHPExcel();
	    $objPHPExcel->getProperties()->setCreator("TBCoder")
					->setLastModifiedBy("TBCoder")
					->setTitle("Compare TBs")
					->setSubject("Compare TBs")
					->setDescription("Compare TBs.")
					->setKeywords("TBCoder Compare TBs")
					->setCategory("TBCoder Compare TBs");
	    // Add some data    
	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', "CODE")
	            ->setCellValue('B1', "DESCRIPTION");
	    if(count($rows)>0){
	        $i=2;
	        foreach ($rows as $row){
	            $cellA='A'.$i;
	            $cellB='B'.$i;
	            $objPHPExcel->setActiveSheetIndex(0)
	                    ->setCellValue($cellA, $row->code)
	                    ->setCellValue($cellB, $row->description);
	            $i++;
	        }    
	    }
    
	    $objPHPExcel->getActiveSheet()->setTitle('PRODUCTION CODE - ' . $prodsys->name);
	    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
	    $objPHPExcel->setActiveSheetIndex(0);
	    // Save Excel 2007 file
	    $callStartTime = microtime(true);
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	    date_default_timezone_set('Europe/London');
	    $time=time();
	    $objWriter->save($excel_path);
    
	    $callEndTime = microtime(true);
	    $callTime = $callEndTime - $callStartTime;

		unset($objPHPExcel);
		$objPHPExcel = null;
		unset ($objWriter);
		$objWriter = null;

	    //echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
	    //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
	    // Echo memory usage
		echo '1';
        exit();
    } catch (Exception $e) {
		error_log('Caught exception in ajax method export_ap_codes_to_excel_file() - ' . $e->getMessage());
        echo '0';
        exit();
    }
}


/*Export Client Map to Excel file*/
add_action('wp_ajax_export_client_map_to_excel_file', 'export_client_map_to_excel_file');
function export_client_map_to_excel_file(){
    error_reporting(E_ALL);
	$_POST = stripslashes_deep( $_POST );
	try {		
		$client_id = $_POST['client_id'];
	
	    $upload_dir=  wp_upload_dir();
		$client = new CLIENT($client_id);
		$rows = $client->get_client_code_and_ap_desc();
		$excel_path = sprintf("%s/excel/client-map-%s-%d.xlsx", $upload_dir['basedir'], $client->client_name, $client_id);
		 
		if (file_exists($excel_path)) {
			// delete old file and recreate
			unlink($excel_path);
		}
	
	    ini_set('display_errors', TRUE);
	    ini_set('display_startup_errors', TRUE);
	    date_default_timezone_set('Europe/London');
	    define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
	    /** Include PHPExcel */
	    include 'Classes/PHPExcel.php';
	    $objPHPExcel = new PHPExcel();
	    $objPHPExcel->getProperties()->setCreator("TBCoder")
					->setLastModifiedBy("TBCoder")
					->setTitle("Compare TBs")
					->setSubject("Compare TBs")
					->setDescription("Compare TBs.")
					->setKeywords("TBCoder Compare TBs")
					->setCategory("TBCoder Compare TBs");
	    // Add some data    
	    $objPHPExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', "CODE")
	            ->setCellValue('B1', "BOOK KEEPING ACCOUNT DESCRIPTION")
            	->setCellValue('C1', "PRODUCTION SYSTEM");
	    if(count($rows)>0){
	        $i=2;
	        foreach ($rows as $row){
	            $cellA='A'.$i;
	            $cellB='B'.$i;
	            $cellC='C'.$i;
	            $objPHPExcel->setActiveSheetIndex(0)
	                    ->setCellValue($cellA, format_code_csv($row->code))
	                    ->setCellValue($cellB, $row->description)
	                    ->setCellValue($cellC, $row->ap_description);
	            $i++;
	        }    
	    }
    
	    $objPHPExcel->getActiveSheet()->setTitle('CLIENT MAP - ' . $client->client_name);
	    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
	    $objPHPExcel->setActiveSheetIndex(0);
	    // Save Excel 2007 file
	    $callStartTime = microtime(true);
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	    date_default_timezone_set('Europe/London');
	    $time=time();
	    $objWriter->save($excel_path);
    
	    $callEndTime = microtime(true);
	    $callTime = $callEndTime - $callStartTime;

		unset($objPHPExcel);
		$objPHPExcel = null;
		unset ($objWriter);
		$objWriter = null;

	    //echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
	    //echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
	    // Echo memory usage
		echo '1';
        exit();
    } catch (Exception $e) {
		error_log('Caught exception in ajax method export_client_map_to_excel_file() - ' . $e->getMessage());
        echo '0';
        exit();
    }
}

function add_user_member($current_id,$member_id){
    global $wpdb;
    $sql="select * from wp_user_member where member_id='".$member_id."' and manager_id='".$current_id."'";
    $rows=$wpdb->get_results($sql);
    if(!count($rows)>0){
        $sql1="insert into wp_user_member (manager_id,member_id) values('".$current_id."','".$member_id."')";
        $wpdb->query($sql1);
    }
    if(get_user_meta($current_id,"_member",true)!=''){
        $a=get_user_meta($current_id,"_member",true);
        if(!in_array($member_id, $a)){
            $a[]=$member_id;
            update_user_meta($current_id, "_member", $a);
        }
    }else{
        $a=array();
        $a[]=$member_id;
        update_user_meta($current_id, "_member", $a);
    }
}

add_action('wp_ajax_form_add_user', 'form_add_user');
function form_add_user(){
        ?>
<div style="padding: 0px 20px 0 20px;">
    <form action="" name="form_add_user" id="form-add-user" method="POST">
            <div class="row">
                <div class="a-label col-md-5">User Name:</div>
                <div class="col-md-7"><input type="text" name="user_name"></div>
            </div>
            <div class="row">
                <div class="a-label col-md-5">Email:</div>
                <div class="col-md-7"><input type="text" name="user_email" onblur="validateEmail()"><span id="email_invalid" style='padding:5px 0;color:red;display:none'>Invalid email format</span></div>
            </div>
            
            <div class="row">
                <div class="a-label col-md-5">Password:</div>
                <div class="col-md-7"><input type="password" name="user_pass1" id="user_pass1" onclick="this.value='';"></div>
            </div>
            <div class="row">
                <div class="a-label col-md-5">Confirm:</div>
                <div class="col-md-7"><input type="password" name="user_pass2" id="user_pass2" onclick="this.value='';" onchange="check_password_match(this);"></div>
            </div>
            <div id="result_confirm_password" class="row"></div>
            <div class="row check-des"><input name="rights[1]" type="checkbox" value="1" checked>Import Account Production charts</div>
            <div class="row check-des"><input name="rights[2]" type="checkbox" value="1" checked>Import New Client</div>
            <div class="row check-des"><input name="rights[3]" type="checkbox" value="1" checked>Import Posting File</div>
            <div class="row check-des"><input name="rights[4]" type="checkbox" value="1" checked>View, Edit and Delete Client specific Maps</div>
            <div class="row check-des" style="text-align: center">
                <input type="submit" name="add_new_user" value="Add" onclick="return validateEmail();" class="btn">
                <input type="reset" name="cancel_new_user" value="Cancel" onclick="tb_remove()" class="btn">
            </div>
        </form>
</div>
<script>
    function check_password_match(a){
        pass1=jQuery("#user_pass1").val();
        pass2=jQuery("#user_pass2").val();
        if(pass1===pass2){
            jQuery("#result_confirm_password").html('<span style="color:green;">Passwords match</span>');
        }else{
            jQuery("#result_confirm_password").html('<span style="color:red;">Passwords do not match</span>');
        }
    }
	function validateEmail() {
	    var x = document.forms["form_add_user"]["user_email"].value;
	    var atpos = x.indexOf("@");
	    var dotpos = x.lastIndexOf(".");
	    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
	        jQuery("#email_invalid").show();
			document.forms["form_add_user"]["user_email"].focus();
	        return false;
	    } else {
		    jQuery("#email_invalid").hide();
	    	return true;
		}
	}
</script>
        
<?php
        exit();
    
}



add_action('wp_ajax_form_edit_user', 'form_edit_user');
function form_edit_user(){
	$_GET = stripslashes_deep( $_GET );
    $member_id=$_GET['member_id'];
    $user_member=new USER_INFO($member_id);
    //echo '<pre>'.print_r($user_member->access,1).'</pre>';
        ?>
<div style="padding: 0px 20px;">
    <form action="" name="form_edit_user" id="form-edit-user" method="POST">
        <input name="member_id" type="hidden" value="<?=$_GET['member_id']?>">
        <div class="row">
            <div class="a-label col-md-5">Name:</div>
            <div class="col-md-7"><input type="text" name="edit_user_name" value='<?=$_GET['user_nicename']?>'></div>
        </div>
        <div class="row">
            <div class="a-label col-md-5">Email:</div>
            <div class="col-md-7"><input type="text" name="edit_user_email" value='<?=$_GET['user_email']?>' onblur="validateEmail()"><span id="email_invalid" style='padding:5px 0;color:red;display:none'>Invalid email format</span></div>
        </div>
        <div class="row">
            <div class="a-label col-md-5">New Password:</div>
            <div class="col-md-7"><input type="password" name="edit_user_pass1" id='edit_user_pass1' onclick='this.value="";'></div>
        </div>
        <div class="row">
            <div class="a-label col-md-5">Confirm:</div>
            <div class="col-md-7"><input type="password" name="edit_user_pass2" id='edit_user_pass2' onclick="this.value='';" onchange="check_password_confirm_edit(this);"></div>
        </div>
        <div id="result_confirm_pass_edit" class="row"></div>
        <div class="row cdes"><input name="rights[1]" type="checkbox" value="1" <?=($user_member->access['r_import_account_production_charts']==1)?'checked':''?>>Import Account Production Charts</div>
        <div class="row cdes"><input name="rights[2]" type="checkbox" value="1" <?=($user_member->access['r_import_new_clients']==1)?'checked':''?>>Import New Clients</div>
        <div class="row cdes"><input name="rights[3]" type="checkbox" value="1" <?=($user_member->access['r_import_posting_files']==1)?'checked':''?>>Import Posting files</div>
        <div class="row cdes"><input name="rights[4]" type="checkbox" value="1" <?=($user_member->access['r_view_edit_delete_clients_speccific_maps']==1)?'checked':''?>>View, Edit and Delete Client specific Map</div>
        <div class="row" style="text-align:center">
            <input type="submit" name="edit_user" value="Save" onclick="return validateEmail();" class="btn">
            <input type="reset" name="cancel_new_user" value="Cancel" onclick="tb_remove()" class="btn">
        </div>
    </form>
</div>
<script>
    function check_password_confirm_edit(a){
        pass1=jQuery("#edit_user_pass1").val();
        pass2=jQuery("#edit_user_pass2").val();
        if(pass1===pass2){
            jQuery("#result_confirm_pass_edit").html("<span style='color:green;'>Passwords match</span>");
        }else{
            jQuery("#result_confirm_pass_edit").html("<span style='color:red;'>Passwords do not match</span>");
        }
    }
	function validateEmail() {
	    var x = document.forms["form_edit_user"]["edit_user_email"].value;
	    var atpos = x.indexOf("@");
	    var dotpos = x.lastIndexOf(".");
	    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
	        jQuery("#email_invalid_edit").show();
			document.forms["form_add_user"]["user_email"].focus();
	        return false;
	    } else {
		    jQuery("#email_invalid").hide();
	    	return true;
		}
	}
</script>
<?php
        exit();
}

add_action('wp_ajax_delete_user', 'delete_user');
function delete_user(){
    if(isset($_POST['member_id'])&&isset($_POST['manager_id'])){
        $current_user = wp_get_current_user();
        $user1=new USER_INFO($current_user->ID);
        $member_id=$_POST['member_id'];
        $user1->delete_member($member_id);
        echo '1';
        exit();
    }else{
        echo '0';
        exit();
    }
}


add_action('wp_ajax_admin_delete_user', 'admin_delete_user');
function admin_delete_user(){
    $current_user = new USER_INFO(wp_get_current_user()->ID);
    if(isset($_POST['user_id'])&&$current_user->ID==1){
		$current_user->delete_user($_POST['user_id']);
        echo '1';
        exit();
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_delete_order', 'delete_order');
function delete_order(){
    if(isset($_POST['order_id'])){
        $current_user = wp_get_current_user();
        $user1=new USER_INFO($current_user->ID);
        $order_id=$_POST['order_id'];
        $user1->delete_order($order_id);
        echo '1';
        exit();
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_remove_user_invite', 'remove_user_invite');
function remove_user_invite(){
    if(isset($_POST['uid'])&&($_POST['uid']!='')){
        $uid=$_POST['uid'];
        $current_user = wp_get_current_user();
        $user1=new USER_INFO($current_user->ID);
        $user1->delete_user_invite($uid);
        echo '1';
        exit();
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_load_form_edit_code_switching', 'load_form_edit_code_switching');
function load_form_edit_code_switching(){
    global $wpdb;
    $current_user=  wp_get_current_user();
    if(isset($_GET['id_switching'])){
        $id_switching=$_GET['id_switching'];
        $sql="select * from wp_switching where id='".$id_switching."'";
        $rows=$wpdb->get_results($sql);
    }else{
        echo '0';
        exit();
    }
    ?>
<div id=""  style="">
    <form action="" name="form_edit_code_switching"  method="POST">
        <div style="padding:10px 0 10px 0;font-weight: bold;text-align: center;font-size: 20px;font-weight: bold;">Production Code</div>
        <div style="padding:5px 0;">
            <div class="fleft" style="width:100px">Description :</div>
            <div class="fleft"><input name="description_edit" value="<?=$rows[0]->old_des?>" style="width:150px;"></div>
            <div class="clr"></div>
        </div>
        <div style="padding:5px 0;">
            <div class="fleft" style="width:100px">Account Production :</div>
            <div class="fleft"><input name="account_production" class="test2" id="test2" value="" style="width:150px;"></div>
            <div class="clr"></div>
        </div>
        <input type="hidden" value="<?=$rows[0]->new_production_system_id?>" name="production_system_id">
        <input type="hidden" value="<?=$id_switching?>" name="id_switching">
        <div style="padding:5px 0;margin: 0 auto;width: 200px;">
            <div class="fleft" style="padding:0 10px;"><input type="submit"  value="Save" name="edit_code_switching"></div>
            <div class="fleft" style="padding:0 10px;"><a href="#" id="close" ><input type="submit" value="Cancel" ></a></div>
        </div>
    </form>
</div>
<?php
        $rows_search_code=get_user_code_by_user_product_system($current_user->ID,$rows[0]->new_production_system_id); 
    ?>
<script src="<?=  bloginfo('template_url')?>/js/jquery-ui.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function(){
        var availableTags = [
            <?php $i=1;?>
            <?php foreach ($rows_search_code as $row_search_code){?>
                <?php if($i<count($rows_search_code)){?>
                    "<?=$row_search_code->code."-".$row_search_code->description?>",
                <?php }else{?>
                    "<?=$row_search_code->code."-".$row_search_code->description?>"
                <?php }?>
            <?php $i++; }?>
        ];
        jQuery("#test2" ).autocomplete({
            source: availableTags
        });    
    });
    
</script>
<style>
    #ui-id-1{
        z-index: 1000;
    }
</style>
<?php
    exit();
}

add_action('wp_ajax_load_form_code_edit', 'load_form_code_edit');
function load_form_code_edit(){
	$_GET = stripslashes_deep( $_GET );
    if(isset($_GET['id_edit'])&&isset($_GET['code_edit'])&&isset($_GET['des_edit'])){
        ?>
        <div class="" id="form_edit_code">
            <div>
                <div class="" style="text-align:center;font-size: 30px;padding: 15px 0;">Edit Account Code</div>
                <div class="clr"></div>
            </div>
            <div style="padding:10px 0;">
                <form action="" method="POST" name="form_code_edit" id="form-code-edit">
                    <input type="hidden" name="id_code_edit" value="<?=$_GET['id_edit']?>">
                    <div>
                        <div class="fleft" style="width:100px;font-weight: bold;" >Code:</div>
                        <div class="fleft"><input type="text" name="code_edit" value="<?=$_GET['code_edit']?>"></div>
                        <div class="clr"></div>
                    </div>
                    <div>
                        <div class="fleft" style="width:100px;font-weight: bold;">Description:</div>
                        <div class="fleft"><input type="text" name="description_edit" value="<?=$_GET['des_edit']?>"></div>
                        <div class="clr"></div>
                    </div>
                    <div style="padding-top:10px;">
                        <div class="fleft" style="padding-left:100px;"><input type="submit" name="save_code_edit" value="Save"></div>
                        <div  class="fleft" style="padding-left:20px;"><input type="reset" name="cancel_code_edit" value="Cancel" onclick="tb_remove()"></div>
                        <div class="clr"></div>
                    </div>
                </form>
            </div>
            <div class="clr"></div>
        </div>

                <?php
        exit();
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_get_all_tags_new', 'get_all_tags_new');
function get_all_tags_new(){
	
    $base_url=  get_option('siteurl');
    $current_user=  wp_get_current_user();
    $user1=new USER_INFO($current_user->ID);
    $rows=$user1->get_all_tags();
    ?>
    <div id="code-import" style="width:545px;border: 2px solid #696969;">
        <div class="" style="background:#0188CC;">
            <div class="fleft tag-code tag-title">AP system</div>
            <div class="fleft tag-des tag-title">Book keeping account description </div>
            <div class="fleft tag-desmore" style="color:#fff;font-weight: bold;">Production system</div>
            <div class="fleft tag-action tag-title">Action</div>
            <div class="clr"></div>
        </div>
        <?php foreach ($rows as $row){
            $cclient=new CLIENT();
            $cclient->get_client_by_id($row->client_id);
            $cproduct_sys=new PRODUCTION_SYSTEM($cclient->production_system_id);
            ?>
            <div style="border-bottom:1px solid #696969;">
                <div class="fleft tag-code"><?=$cproduct_sys->get_name_ap_system()?></div>
                <div class="fleft tag-des"><?=$row->description?></div>
                <div class="fleft tag-desmore"><?=$cproduct_sys->name?></div>
                <div class="fleft tag-action">
                    <?php add_thickbox();?>
                    <a href="<?=$base_url?>/wp-admin/admin-ajax.php?action=load_form_edit_tags&width=400&height=300&id=<?=$row->id?>" class='thickbox'><img src="<?=  bloginfo('template_url')?>/images/edit.png"/></a>
                    <a style="padding-left:20px;" onclick="delete_tags(this,'<?=$row->id?>');"><img src="<?=  bloginfo('template_url')?>/images/delete.png"/></a>
                </div>
                <div class="clr"></div>
            </div>
        <?php }?>
    </div>
<?php
    exit();
}

add_action('wp_ajax_delete_tags', 'delete_tags');
function delete_tags(){
    global $wpdb;
    if(isset($_POST['id'])){
        $sql="delete from wp_tags where id='".$_POST['id']."'";
        $wpdb->query($sql);
        echo '1';
    }
    exit();
}

/* not in use, TODO: remove */
add_action('wp_ajax_load_form_code_edit_client', 'load_form_code_edit_client');
function load_form_code_edit_client(){
    if(isset($_GET['id_edit'])&&isset($_GET['code_edit'])&&isset($_GET['des_edit'])){
        $ccode=new CLIENT_CODE();
        $ccode->get_code_by_id($_GET['id_edit']);
        $apcode=new APCODE();
        $apcode->get_code_from_id($ccode->match_id);

		$obj = new stdClass();
		$obj->ccode = $ccode;
		$obj->apcode = $apcode;
		echo json_encode($obj);
        exit();
    }else{
        echo '0';
        exit();
    }
}
add_action('wp_ajax_load_form_edit_tags', 'load_form_edit_tags');
function load_form_edit_tags(){
    $current_user=  wp_get_current_user();
    $user1=new USER_INFO($current_user->ID);
    $rows_client=$user1->get_client_manager_and_user();
    $a=array();
    $b=new stdClass();
    foreach ($rows_client as $row_client){
        $a[]=$row_client->client_name;
    }
    $b->client=$a;
    $rows3= PRODUCTION_SYSTEM::get_admin_production_system();
    if(isset($_GET['id'])){
        $ctag=new TAG($_GET['id']);
        $cclient=new CLIENT();
        $cclient->get_client_by_id($ctag->client_id);
    }
    ?>
<div id="form-edit-tags" style="">
    <form method="POST" action=""  name="form_edit_tags">
        <div style="font-size:20px;text-align: center;padding: 20px 0 10px 0;">EDIT TAG</div>
        <div class='fleft title-tag' style='font-weight:bold;'>Client Name</div>
        <div class='fleft'><input id='client_search' name='client_tag' type="text" value="<?=$cclient->client_name?>" onblur="if(this.value==='') this.value='Search';" onfocus="if(this.value==='Search') this.value='';"></div>
        <div class="clr"></div>
        <div class="fleft title-tag" style="font-weight:bold;">Bookkeeping system </br> terminology :</div>
        <div class="fleft"><input name="tags_name" value="<?=$ctag->description?>" type="text"></div>
        <div class="clr"></div>
        <div class="fleft title-tag" style="font-weight:bold;">A P System :</div>
        <div class="fleft" style="padding:0 0 0 0;">
            <select name="ap_system_tags" id="ap-system-tags">
                <option value="0">Select</option>
                <?php foreach ($rows3 as $row3){?>
                    <option value="<?=$row3->production_system_id?>" <?php if($ctag->ap_system_id==$row3->production_system_id) echo 'selected';?>><?=$row3->name?></option>
                <?php }?>
            </select>
        </div>
        <div class="clr"></div>
        <div class="fleft title-tag" style="font-weight:bold;">A P System </br>terminology :</div>
        <div  class="fleft ui-widget"><input name="tags_des" class="test" id="test" value="<?=$ctag->name?>" type="text"></div>
        <div class="clr"></div>
        <div>
            <div class="fleft"><input type="submit" value="Save" name="edit_tags_manual"></div>
            <div class="fleft" style="padding:0 0 0 20px;"><input type="submit" value="Cancel"></div>
            <div class="clr"></div>
        </div>
        <input type='hidden' name='id_tag' value='<?=$_GET['id']?>' >
    </form>
</div>
<script src="<?=  bloginfo('template_url')?>/js/jquery-ui.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function(){
        var b='<?=json_encode($b);?>';
        ob=JSON.parse(b);
        c=ob.client;
        jQuery("#client_search").autocomplete({
            source: c
        });
    }); 
</script>
<style>
    #ui-id-1{
        z-index: 9000;
    }
</style>
    <?php
        exit();
}

add_action('wp_ajax_load_form_add_tags', 'load_form_add_tags');
function load_form_add_tags(){
    $current_user=  wp_get_current_user();
    $user1=new USER_INFO($current_user->ID);
    $rows_client=$user1->get_client_manager_and_user();
    $a=array();
    $b=new stdClass();
    foreach ($rows_client as $row_client){
        $a[]=$row_client->client_name;
    }
    $b->client=$a;
    $rows3=  PRODUCTION_SYSTEM::get_admin_production_system();
    ?>
<div id="form-add-tags" style="">
    <form method="POST" action=""  name="form_add_tags">
        <div style="font-size:20px;text-align: center;padding: 20px 0 10px 0;">ADD NEW TAG</div>
        <div class='fleft title-tag' style='font-weight:bold;'>Client Name</div>
        <div class='fleft'><input id='client_search' name='client_tag' type="text" value="Search" onblur="if(this.value==='') this.value='Search';" onfocus="if(this.value==='Search') this.value='';"></div>
        <div class="clr"></div>
        <div class="fleft title-tag" style="font-weight:bold;">Bookkeeping system </br> terminology :</div>
        <div class="fleft"><input name="tags_name" value="" type="text"></div>
        <div class="clr"></div>
        <div class="fleft title-tag" style="font-weight:bold;">A P System :</div>
        <div class="fleft" style="padding:0 0 0 0;">
            <select name="ap_system_tags" id="ap-system-tags">
                <option value="0">Select</option>
                <?php foreach ($rows3 as $row3){?>
                    <option value="<?=$row3->production_system_id?>"><?=$row3->name?></option>
                <?php }?>
            </select>
        </div>
        <div class="clr"></div>
        <div class="fleft title-tag" style="font-weight:bold;">A P System </br>terminology :</div>
        <div  class="fleft ui-widget"><input name="tags_des" class="test" id="test" value="" type="text"></div>
        <div class="clr"></div>
        <div>
            <div class="fleft"><input type="submit" value="Save" name="add_tags_manual"></div>
            <div class="fleft" style="padding:0 0 0 20px;"><input type="submit" value="Cancel"></div>
            <div class="clr"></div>
        </div>
    </form>
</div>
<script src="<?=  bloginfo('template_url')?>/js/jquery-ui.js" type="text/javascript"></script>
<script>
    jQuery(document).ready(function(){
        var b='<?=json_encode($b);?>';
        ob=JSON.parse(b);
        c=ob.client;
        jQuery("#client_search").autocomplete({
            source: c
        });
    }); 
</script>
<style>
    #ui-id-1{
        z-index: 9000;
    }
</style>
    <?php
        exit();
}

add_action('wp_ajax_delete_client_ajax', 'delete_client_ajax');
function delete_client_ajax(){
    if(isset($_POST['id'])){
        $client=new CLIENT();
        $client->delete_client($_POST['id']);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_delete_client_code_ajax', 'delete_client_code_ajax');
function delete_client_code_ajax(){
    if(isset($_POST['id'])){
        $client=new CLIENT($_POST['id']);
        $client->delete_client_codes($_POST['id']);
        $client->delete_xero_client_accounts();
        echo '1';
        exit();
    }
    echo '0';
    exit();
}

/*invite user*/
add_action('wp_ajax_invite_user', 'invite_user');
function invite_user(){
    $current_user=  wp_get_current_user();
    $user1=new USER_INFO($current_user->ID);
    if(isset($_POST['user_id'])){
        $user_id2=$_POST['user_id'];
        $user1->invite_user($user_id2);
        $user2=new USER_INFO($user_id2);
        ?>
        <div style="border-bottom: 1px solid #dddddd;">
            <div class="fleft u-check"><input type="checkbox"></div>
            <div class="fleft u-name"><?=$user2->data->display_name?></div>
            <div class="fleft u-email"><?=$user2->data->user_email?></div>
            <div class="fleft u-edit">Spending</div>
            <div class="clr"></div>
        </div>
<?php
        exit();
    }else{
        echo '0';
        exit();
    }
}

/*remove user friend*/
add_action('wp_ajax_remove_user_friend', 'remove_user_friend');
function remove_user_friend(){
    $current_user=  wp_get_current_user();
    $user1=new USER_INFO($current_user->ID);
    if(isset($_POST['user_id'])){
        $user_id2=$_POST['user_id'];
        $user1->remove_user_friend($user_id2);
        $user2=new USER_INFO($user_id2);
        ?>
        <div style="border-bottom: 1px solid #dddddd;">
            <div class="fleft u-check"><input type="checkbox"></div>
            <div class="fleft u-name"><?=$user2->data->display_name?></div>
            <div class="fleft u-email"><?=$user2->data->user_email?></div>
            <div class="fleft u-edit"><button type="button" onclick="invite_user(this,'<?=$user2->ID?>');">Invite</button></div>
            <div class="clr"></div>
        </div>
<?php
        exit();
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_get_code_for_tags', 'get_code_for_tags');
function get_code_for_tags(){
    global $wpdb;
    if(isset($_POST['production_system_id'])&&isset($_POST['user_id'])){
        $production_system_id=$_POST['production_system_id'];
        $user_id=$_POST['user_id'];
        $sql="select * from wp_user_code where production_system_id='".$production_system_id."' and user_id='".$user_id."'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            $a=array();
            foreach ($rows as $row){
                $a[]=$row->code."-".$row->description;
            } 
            echo json_encode($a);
            exit();
        }else{
            echo '0';
            exit();
        }
    }
    echo '0';
    exit();
}
add_action('wp_ajax_save_code_edit', 'save_code_edit');
function save_code_edit(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
    if(isset($_POST['id_edit'])&&isset($_POST['code_edit'])&&isset($_POST['des_edit'])){
        $id = $_POST['id_edit'];
        $code=$_POST['code_edit'];
        $description=$_POST['des_edit'];
		$apcode = new APCODE();
		$apcode->id=mysql_real_escape_string($id);
		$apcode->update_apcode($code,$description);
        echo '1';
        exit();
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_get_downloads', 'get_downloads');
function get_downloads(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
	$current_user= new USER_INFO(wp_get_current_user()->ID);
	$limit_clause = '';
	if (isset($_POST['length'])) {
		$start = (isset($_POST['start']) ? $_POST['start'] : 0);
		$limit_clause = sprintf("LIMIT %d,%d", $start, $_POST['length']);
	}
	$client_clause = '';
	if (isset($_POST['client_id']) && $_POST['client_id'] != -1) {
		$client_clause = "and csv.client_id='" . $_POST['client_id'] . "'";
	}

	$columnNames = array("csv.id","csv.time","cli.client_name","csv.date_to","csv.description","ap.name");
	$order_clause = '';
	if (isset($_POST['order']) && is_array($_POST['order'])) {
		for ($i=0; $i<count($_POST['order']); $i++) {
			$ord=$_POST['order'][$i];
			$order_clause .= sprintf("%s %s,", $columnNames[$ord['column']], $ord['dir']);
		}	
		$order_clause = substr($order_clause, 0, -1);
	}
	if (trim($order_clause) === '') {
		$order_clause = 'time DESC';
	}

	$sql="SELECT csv.id, csv.time, cli.client_name, csv.date_to, csv.description, ap.name as ap_name, csv.path_csv_file " .
		 "FROM wp_csv_file csv LEFT JOIN " .
		 "wp_client cli ON cli.id=csv.client_id LEFT JOIN " .
		 "wp_ap_systems ap ON csv.production_system_id=ap.production_system_id " .
		 "WHERE csv.user_id='".$current_user->ID."' and opening_balance=false $client_clause order by $order_clause $limit_clause";

	$results = $wpdb->get_results($sql);
	$return_arr = array();
	foreach ($results as $row) {
		$new_row = array();
		// id
		$new_row[] = $row->id;
		// date
		$new_row[] = date("d M Y H:i:s",$row->time);
		// client name
		$new_row[] = $row->client_name;
		// date to
		$new_row[] = date("d M Y",$row->date_to);
		// description
		$new_row[] = $row->description;
		
		// acc prod sys name
        if($row->ap_name==''){
            $new_row[] = '';
        }else{            
            $new_row[] = $row->ap_name;
        }

		// download
		$new_row[] = $row->id;
		
		// delete
		$new_row[] = $row->id;
		// append new row
		$return_array[] = $new_row;
	}
	
	$sql_count = "select count(*) from wp_csv_file where user_id='".$current_user->ID."' and opening_balance=false";
	$sql_count_filtered = "select count(*) from wp_csv_file csv where user_id='".$current_user->ID."' and opening_balance=false $client_clause";
	$count = $wpdb->get_var($sql_count);
	$count_filtered = $wpdb->get_var($sql_count_filtered);

	if ($count_filtered == 0) {
		echo '{
		    "draw": ' . (isset($_POST['draw']) ? $_POST['draw'] : '1') . ',
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

add_action('wp_ajax_view_users', 'view_users');
function view_users(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
	// limit to admin
	if (wp_get_current_user()->ID !== 1) {
		echo '0';
		exit();
	}
	
	// limit clause
	$limit_clause = '';
	if (isset($_POST['length'])) {
		$start = (isset($_POST['start']) ? $_POST['start'] : 0);
		$limit_clause = sprintf("LIMIT %d,%d", $start, $_POST['length']);
	}
	
	// order clause
	$columnNames = array("users.ID",
						 "users.user_login",
						"users.user_email",
						"users.practice_name",
						"users.user_registered",
						"users.display_name",
						"imports_left",
						"phone",
						"seen");
	$order_clause = '';
	if (isset($_POST['order']) && is_array($_POST['order'])) {
		for ($i=0; $i<count($_POST['order']); $i++) {
			$ord=$_POST['order'][$i];
			$order_clause .= sprintf("%s %s,", $columnNames[$ord['column']], $ord['dir']);
		}	
		$order_clause = substr($order_clause, 0, -1);
	}
	if (trim($order_clause) === '') {
		$order_clause = 'ID DESC';
	}
	
	//search clause
	if (isset($_POST['search']) && isset($_POST['search']['value']) && trim($_POST['search']['value'] != '')) {
		$esc_val = mysql_real_escape_string(trim($_POST['search']['value']));
		$where_clause = "AND (users.user_login like '%". $esc_val. 
						"%' OR users.user_email like '%" . $esc_val . 
						"%' OR users.user_url like '%" . $esc_val . 
						"%' OR users.display_name like '%" . $esc_val . "%')";
	}

	$sql="SELECT users.*, meta2.meta_value as imports_left, meta3.meta_value as practice_name, meta4.meta_value as phone, meta5.meta_value as show_workpapers FROM wp_users users ".
		 "LEFT JOIN wp_usermeta meta2 on users.ID=meta2.user_id and meta2.meta_key='_num_imports' " .
		 "LEFT JOIN wp_usermeta meta3 on users.ID=meta3.user_id and meta3.meta_key='practice_name' " .
		 "LEFT JOIN wp_usermeta meta4 on users.ID=meta4.user_id and meta4.meta_key='phone' " .
		 "LEFT JOIN wp_usermeta meta5 on users.ID=meta5.user_id and meta5.meta_key='_show_workpapers' " .
		 "LEFT JOIN wp_user_member member on users.ID=member.member_id " . 
		 "WHERE (member.manager_id IS NULL OR member.manager_id=member.member_id) $where_clause order by $order_clause $limit_clause";
	$results = $wpdb->get_results($sql);
	$return_arr = array();
	foreach ($results as $row) {
		$new_row = array();
		// id
		$new_row[] = $row->ID;
		// user_login
		$new_row[] = $row->user_login;
		// email
		$new_row[] = $row->user_email;
		// Practice Name
		$new_row[] = $row->practice_name;
		// date registered
		$new_row[] = $row->user_registered; //date("d M Y-H:i:s",$row->time);
		// display name
		$new_row[] = $row->display_name;
		// Imports left
		$new_row[] = $row->imports_left;
		// Phone
		$new_row[] = $row->phone;
		// delete id
		$new_row[] = $row->ID;
		// show workpapers
		$new_row[] = '<input type="checkbox" class="show_workpapers" ' . ($row->show_workpapers == '1' ? 'checked="checked"' : '') . ' data-id="' . $row->ID . '" onchange="show_workpapers(this);">';
		// append new row
		$return_array[] = $new_row;
	}
	
	$sql_count = "select count(*) from wp_users users LEFT JOIN wp_user_member member on users.ID=member.member_id " . 
	 "WHERE member.manager_id IS NULL";
	
	$sql_count_filtered = "select count(*) from wp_users users LEFT JOIN wp_user_member member on users.ID=member.member_id " . 
	 "WHERE member.manager_id IS NULL $where_clause";
	$count = $wpdb->get_var($sql_count);
	$count_filtered = $wpdb->get_var($sql_count_filtered);

	if ($count_filtered == 0) {
		echo '{
		    "draw": ' . (isset($_POST['draw']) ? $_POST['draw'] : '1') . ',
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

add_action('wp_ajax_admin_show_workpapers', 'admin_show_workpapers');
function admin_show_workpapers(){
	global $wpdb;
	$current_user = new USER_INFO(wp_get_current_user()->ID);
    if(isset($_POST['user_id']) && isset($_POST['show']) && $current_user->ID==1){
		$user = new USER_INFO($_POST['user_id']);
		update_user_meta($_POST['user_id'], "_show_workpapers", $_POST['show']);
        echo '1';
        exit();
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_view_search_tags', 'view_search_tags');
function view_search_tags(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
	// limit to admin
	if (wp_get_current_user()->ID !== 1) {
		echo '0';
		exit();
	}
	
	// limit clause
	$limit_clause = '';
	if (isset($_POST['length'])) {
		$start = (isset($_POST['start']) ? $_POST['start'] : 0);
		$limit_clause = sprintf("LIMIT %d,%d", $start, $_POST['length']);
	}
	
	// order clause
	$columnNames = array("description",
						"tag");
	$order_clause = '';
	if (isset($_POST['order']) && is_array($_POST['order'])) {
		for ($i=0; $i<count($_POST['order']); $i++) {
			$ord=$_POST['order'][$i];
			$order_clause .= sprintf("%s %s,", $columnNames[$ord['column']], $ord['dir']);
		}	
		$order_clause = substr($order_clause, 0, -1);
	}
	if (trim($order_clause) === '') {
		$order_clause = 'description ASC';
	}
	
	//search clause
	if (isset($_POST['search']) && isset($_POST['search']['value']) && trim($_POST['search']['value'] != '')) {
		$esc_val = mysql_real_escape_string(trim($_POST['search']['value']));
		$where_clause = "WHERE (description like '%". $esc_val. 
						"%' OR tag like '%" . $esc_val . "%')";
	} else {
		$where_clause = '';
	}

	$sql="SELECT * FROM wp_search_tags $where_clause order by $order_clause $limit_clause";
	$results = $wpdb->get_results($sql);
	$return_arr = array();
	foreach ($results as $row) {
		$new_row = array();
		// description
		$new_row[] = $row->description;
		// tag
		$new_row[] = $row->tag;
		// delete id
		$new_row[] = $row->id;
		// id
		$new_row[] = $row->id;
		// append new row
		$return_array[] = $new_row;
	}
	
	$sql_count = "select count(*) from wp_search_tags";
	
	$sql_count_filtered = "select count(*) from wp_search_tags $where_clause";
	$count = $wpdb->get_var($sql_count);
	$count_filtered = $wpdb->get_var($sql_count_filtered);

	if ($count_filtered == 0) {
		echo '{
		    "draw": ' . (isset($_POST['draw']) ? $_POST['draw'] : '1') . ',
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


add_action('wp_ajax_admin_delete_search_tag', 'admin_delete_search_tag');
function admin_delete_search_tag(){
	global $wpdb;
    $current_user = new USER_INFO(wp_get_current_user()->ID);
    if(isset($_POST['tag_id'])&&$current_user->ID==1){
		$wpdb->delete("wp_search_tags", array('id' => $_POST['tag_id']));
        echo '1';
        exit();
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_save_code', 'save_code');
function save_code(){
    global $wpdb;
	$current_user = new USER_INFO(wp_get_current_user()->ID);
	$_POST = stripslashes_deep( $_POST );
    if(isset($_POST['des'])&&isset($_POST['id_balance'])&&isset($_POST['client_id'])&&isset($_POST['file_id'])&&isset($_POST['price'])&&isset($_POST['is_tb'])){
        $client_id=$_POST['client_id'];
        $production_system_id=$_POST['production_system_id'];
        $price=str_replace(',', '', urldecode($_POST['price']));	// remove thousand (comma) separator
        $file_id=$_POST['file_id'];
        $id_balance=$_POST['id_balance'];
		$tbl_name = ($_POST['is_tb'] === '1' ? 'wp_balance' : 'wp_open_balance');
        if(is_numeric($price)){
            $sql_get="select * from $tbl_name where id='".mysql_real_escape_string($id_balance)."'";
            $rows=$wpdb->get_results($sql_get);

			$des_org_update = '';
			$description_original = $rows[0]->description_original;
			if (isset($_POST['des_org']) && trim($_POST['des_org']) !== '') {
				// After splitting, we allow edit of original description
				$des_org_update = ",description_original='" . mysql_real_escape_string(trim($_POST['des_org'])) . "'";
				$description_original = trim($_POST['des_org']);
			}

            $dess = explode("|", $_POST['des']);
            if(count($dess)>1){
                $code=$dess[0];
                $description=  str_replace($code.'|','',$_POST['des']);
            }else{
                if(isset($_POST['code'])&&$_POST['code']!=='0'){
                    $code=$_POST['code'];
                    $description=$_POST['des'];
                }else{
                    echo '01';
                    exit();
                }
            }
            

            if($rows[0]->client_code_id != 0 && $rows[0]->code !== trim($code) &&
			  $description_original === $rows[0]->description_original){
				// delete old code matched to this description
                $ccode1=new CLIENT_CODE();
                $ccode1->delete_code_by_id($rows[0]->client_code_id);
            }

            $a=array();
            $ccode=new CLIENT_CODE();
            $ccode->check_code_exist(mysql_real_escape_string($code), $description_original, mysql_real_escape_string($client_id), $current_user);
            if($ccode->id==0){
                $ccode->code=$code;
                $ccode->description=$description_original;
                $ccode->production_system_id=$production_system_id;
                $ccode->client_id=$client_id;
                $ccode->user_id=$current_user->ID;
                $ccode->manager_id=$current_user->get_manager_id();
                $apcode=new APCODE();
                $apcode->get_from_code_and_ap($code, $production_system_id);
                $ccode->match_id=$apcode->id;
                $ccode->insert_client_code();	// insert this code
			}
			$client_code_id=$ccode->id;

			// reset need_ob_check
			$need_ob_check = '';
			if ($_POST['is_tb'] === '1') {
				// wp_balance
				$need_ob_check = ",need_ob_check='0'";
			}
			$sql=sprintf("UPDATE %s set code='%s',description='%s',price='%s',client_code_id='%d' $need_ob_check $des_org_update WHERE id='%s'",
				 $tbl_name, mysql_real_escape_string($code), mysql_real_escape_string($description), mysql_real_escape_string($price),
				 $client_code_id, mysql_real_escape_string($id_balance));
            $wpdb->query($sql);
            $a['code']=$code;
            $a['description']=$description;
            $a['description_original']=$description_original;
            $a['price']=$price;
            export_to_csv_from_file_id($file_id);
            echo json_encode($a);
            exit();
        }else{
            echo '02';
            exit();
        }
    }else{
        echo '03';
        exit();
    }
}
add_action('wp_ajax_get_price', 'get_price');
function get_price(){
    global $wpdb;
    if(isset($_POST['id'])){
        $id=$_POST['id'];
        $sql="select price from wp_product_service where id='".$id."'";
        $rows=$wpdb->get_results($sql);
        echo $rows[0]->price;
        exit();
    }else{
        echo '0';
        exit();
    }
}
add_action('wp_ajax_check_client_custom', 'check_client_custom');
function check_client_custom(){
    global $wpdb;
	$_POST = stripslashes_deep( $_POST );
    if(isset($_POST['client_name'])){
        $client_name= $_POST['client_name'];
        $user_id=$_POST['user_id'];
        $sql="select * from wp_client where client_name='".$client_name."' and user_id='".$user_id."' and custom='1'";
        $rows=$wpdb->get_results($sql);
        if(count($rows)>0){
            echo '1';
            exit();
        }else{
            echo '0';
            exit();
        }
    }else{
        echo '0';
        exit();
    }
}
function is_client_custom($client_name,$user_id){
    global $wpdb;
    $sql="select * from wp_client where client_name='".$client_name."' and user_id='".$user_id."' and custom='1'";
    $rows=$wpdb->get_results($sql);
    if(count($rows)>0){
        return 1;
    }else{
        return 0;
    }
}

add_action('wp_ajax_delete_pricing', 'delete_pricing');
function delete_pricing(){
    global $wpdb;
    if(isset($_POST['id']) && trim($_POST['id']) !== ''){
		// delete pricing
		$pricing = new PRICING();
		$pricing->ID=$_POST['id'];
		$pricing->delete_pricing();
		echo '1';
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_save_pricing', 'save_pricing');
function save_pricing(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
	if (isset($_POST['package']) && isset($_POST['limit']) && isset($_POST['pricing'])) {
	    if(isset($_POST['id']) && trim($_POST['id']) !== ''){
			// edit current pricing
			$pricing = new PRICING($_POST['id']);
		} else {
			$pricing = new PRICING();			
		}
		$pricing->package_name=$_POST['package'];
		$pricing->import_limit=$_POST['limit'];
		$pricing->price=$_POST['pricing'];
	    if(isset($_POST['id']) && trim($_POST['id']) !== ''){
			// edit current pricing
			$pricing->update_pricing();
		} else {
			$pricing->insert_pricing();
		}
		echo $pricing->id;
	} else {
		echo '0';
	}
	exit();
}

add_action('wp_ajax_get_pricings', 'get_pricings');
function get_pricings(){
	$pricing = new PRICING();
	$results = $pricing->get_all();
	$return_arr = array();
	foreach ($results as $row) {
		$new_row = array();
		// date
		$new_row[] = $row->post_date;
		// title
		$new_row[] = $row->post_title;
		// description
		$new_row[] = $row->import_limit;
		// description
		$new_row[] = $row->pricing;
		// edit id
		$new_row[] = $row->ID;
		// delete id
		$new_row[] = $row->ID;

		// append new row
		$return_array[] = $new_row;
	}
	
	$count = $pricing->get_all_count();

	if ($count == 0) {
		echo '{
		    "draw": 1,
		    "recordsTotal": "'.$count.'",
		    "recordsFiltered": "'.$count.'",
		    "data": []
		}';
	} else {
		$return_assoc = array(
			'data' => $return_array,
			'draw' => (isset($_POST['draw']) ? $_POST['draw'] : '1'),
			'recordsTotal' => $count,
			'recordsFiltered' => $count
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

add_action('wp_ajax_split_trial_balance', 'split_trial_balance');
function split_trial_balance(){
    global $wpdb;
    $current_user = new USER_INFO(wp_get_current_user()->ID);
    $base_url=  get_option("siteurl");
    if(isset($_POST['id'])&&isset($_POST['is_tb'])){
        $id=$_POST['id'];
		$tbl_name = ($_POST['is_tb'] === '1' ? 'wp_balance' : 'wp_open_balance');
        $sql="select * from $tbl_name where id='".$id."'";
        $rows=$wpdb->get_results($sql);
		$appendix = ' -'; //($_POST['is_ob'] === '1' ? ' -' : ' - -');
        if(count($rows)>0){
            $sql_insert="insert into wp_balance (code,description,price,userid,code_original,time,last_file,description_original,".
						"file_id,production_system_id,client_id,parent_split,client_code_id,manager_id,parent_split_table) ".
                		"values('".mysql_real_escape_string($rows[0]->code)."','".
						mysql_real_escape_string($rows[0]->description)."','0','".
						$rows[0]->userid."','".
						mysql_real_escape_string($rows[0]->code_original)."','".
						$rows[0]->time."','".$rows[0]->last_file."','".
						mysql_real_escape_string($rows[0]->description_original . $appendix)."','".$rows[0]->file_id."','".
						$rows[0]->production_system_id."','".$rows[0]->client_id."','".$rows[0]->id."','".$rows[0]->client_code_id."','".
 						$rows[0]->manager_id."','$tbl_name')";
            $wpdb->query($sql_insert);
			$insert_id = $wpdb->insert_id;
			// insert client code
			$client_code = new CLIENT_CODE();
			$client_code->get_code_by_id($rows[0]->client_code_id);
			$client_code->description = $rows[0]->description_original . " -";
			$client_code->insert_client_code();
			
            ?>
			<tr class="bal-row" id="row_<?=$insert_id?>">
			    <td class="fleft left-col bal-cell" >
			        <div class="fleft" style="padding-right:5px;"><input class="bal-code" type="text" disabled value="<?=$rows[0]->code?>"/></div>
			        <div class="fleft"><input class="bal-des test" type="text" value="<?=$rows[0]->description?>" placeholder="Search"></div>
			        <?php
			            $rows_possible=get_other_possible($rows[0]->description_original,$current_user,$rows[0]->production_system_id);
			            $num_possible=count($rows_possible);
			        ?>
			        <div class="fleft i-description-sys i-cell" style="font-weight:bold;">
			            <?php if($num_possible!==0){?>
		                    <a class="c-posible" onclick="$('.rows-posible').hide();show_possible_match(this,event,'<?=$rows[0]->id?>','1');">
		                        <?=$num_possible?> other matches 
		                    </a>
							<div class="rows-posible" style="display:none;">
							    <div style="border-bottom: 1px solid #c2c2c2;background: #0188CC;padding: 5px 0;">
							        <div class="fleft pop-check">&nbsp;</div>
							        <div class="fleft pop-code" style="font-weight: bold;">Account Code</div>
							        <div class="fleft pop-name" style="font-weight: bold;width:378px;">Account Name</div>
							        <div class="fleft pop-close" style="font-weight: bold;width: 25px;">
							            <img src="<?=  bloginfo('template_url')?>/images/remove-red.png" width="20px">
							        </div>
							        <div class="clr"></div>
							    </div>
							    <div style="overflow: scroll;min-height: 200px;max-height: 400px;">
							        <?php foreach ($rows_possible as $row_possible){   ?>
							            <div style="border-bottom: 1px solid #c2c2c2;">
							                <div class="fleft pop-check"><input type="radio" name="pop-check-radio"
										onclick="if ($(this).is(':checked')){ check_update_possible(this,'<?=str_replace("'","\'",htmlspecialchars($rows[0]->description_original))?>','<?=$row_possible->id?>','<?=$insert_id?>','<?=$rows[0]->client_id?>');}"></div>
							                <div class="fleft pop-code"><?=$row_possible->code?></div>
							                <div class="fleft pop-name"><?=$row_possible->description?></div>
							                <div class="fleft pop-close" style="">&nbsp;</div>
							                <div class="clr"></div>
							            </div>
							        <?php }?>
							    </div>   
							</div>
			            <?php }else{?>
			                    <a href="#" >
			                        <?=$num_possible?> other matches 
			                    </a>
			            <?php }?>
			        </div>
			        <div class="fleft" style="padding-left:5px;">
			            <input class="save-code-button" onclick="save_code(this,'<?=$insert_id?>','<?=$rows[0]->client_id?>','1');" type="button" value="Save" name="update_code" style="display:block;">
			            <input class="edit-code-button" type="button" value="Edit" onclick="edit_input(this);" style="display:none;">
			        </div>
			        <div class="clr"></div>
			    </td>
			    <td class="fleft right-col  bal-cell" >
                    <div class="fleft des-check"><input type="checkbox" name="verify" value="verified"></div>
			        <div class="fleft des-original"><input style="width:95%" class="bal-des-org" type="text" value="<?=$rows[0]->description_original . $appendix?>" placeholder="Description"></div>
			        <div class="fleft"><input name="price[]" class="bal-price" type="text" value="0" onblur="minus_total_price(this,'<?=$insert_id?>');"></div>
			        <div class="fleft" style="padding-left:5px;">
			            <a ><input class="split-balance-button" value="Split" type="button" onclick="split_trial_balance('<?=$insert_id?>',this,'1');"></a>
			            <a style=""><img onmouseout="change_image_back(this);" onclick="delete_balance('<?=$insert_id?>',this,'1');" src="<?=  bloginfo('template_url')?>/images/remove-grey.png" onmouseover="change_image(this);" width="25px"></a>
			        </div>
			    </td>
			</tr>  
<script>
    function minus_total_price(a,id){
        url = '<?=$base_url?>';
        price=jQuery(a).val();
        jQuery.post(url+'/wp-admin/admin-ajax.php',{action:'minus_total_price',id:id,price:price},function(data){
            ob=JSON.parse(data);
            t="#row_"+ob.parent_id+" .bal-price";
            jQuery(t).val(ob.subprice);
        },'html'); 
    }
</script>
<?php
            exit();
        }else{
            echo "0";
            exit();
        }
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_minus_total_price', 'minus_total_price');
function minus_total_price(){
	$_POST = stripslashes_deep( $_POST );
    global $wpdb;
    if(isset($_POST['id'])&&isset($_POST['price'])){
        $id=$_POST['id'];
        $sqla="select * from wp_balance where id='".$id."'";
        $rows=$wpdb->get_results($sqla);
        $sqlb="select * from " . $rows[0]->parent_split_table . " where id='".$rows[0]->parent_split."'";
        $rows1=$wpdb->get_results($sqlb);
        //update price
        $price=$_POST['price'];
        $sql="update wp_balance set price='".$price."' where id='".$id."'";
        $wpdb->query($sql);
        //update subtract price
        $subprice=$rows1[0]->price - $price+$rows[0]->price;
        $sql1="update " . $rows[0]->parent_split_table . " set price='".$subprice."' where id='".$rows1[0]->id."'";
        $wpdb->query($sql1);
        $ob=new stdClass();
        $ob->parent_id=$rows1[0]->id;
        $ob->price=$price;
        $ob->subprice=$subprice;
        echo json_encode($ob);
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_save_switching', 'save_switching');
function save_switching(){
    $current_user = new USER_INFO(wp_get_current_user()->ID);
    global $wpdb;
	$_POST = stripslashes_deep( $_POST );
    if(isset($_POST['code_des'])&&$_POST['code_des']!=''&&isset($_POST['id_switching'])&&isset($_POST['old_des'])){
        $id_switching=$_POST['id_switching'];
        $sql_get="select from wp_switching where id='".$id_switching."'";
        $rows=$wpdb->get_results($sql_get);
        $code_des=$_POST['code_des'];
        $old_des=$_POST['old_des'];
        $a=  explode("-", $code_des);
        $sql="update wp_switching set new_code='".$a[0]."',new_des='".mysql_real_escape_string($old_des)."' where id='".$id_switching."'";
        $wpdb->query($sql);

		$apcode = new APCODE();
        if($rows[0]->id_new_code!=0){
			$apcode->id=mysql_real_escape_string($rows[0]->id_new_code);
			$apcode->update_apcode($a[0],$old_des);
        }else{
			$apcode->insert_into_db($user_info,$a[0],$old_des,$rows[0]->production_system_id);
        }
        $wpdb->query($sql1);
        echo '1';
        exit();
    }
    echo '0';
    exit();
}

add_action('wp_ajax_customise_load_form_edit_production_system', 'customise_load_form_edit_production_system');
function customise_load_form_edit_production_system(){
    global $wpdb;
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $sql="select * from wp_user_code_extract where id ='".$id."'";
        $rows=$wpdb->get_results($sql);
        ?>
        <form name="edit_production_system_2" method="POST" action="">
            <div style="padding:15px 0;text-align: center;font-size: 25px;">PRODUCTION CODE</div>
            <div style="padding:10px 0;">
                <div class="fleft" style="font-weight:bold;width: 120px;">Code:</div>
                <div class="fleft" ><input name="code_sys" value="<?=$rows[0]->code?>"></div>
                <div class="clr"></div>
            </div>
            <div style="padding:10px 0;">
                <div class="fleft" style="font-weight:bold;width: 120px;">Description:</div>
                <div class="fleft"><input name="des_sys" value="<?=$rows[0]->description_extract?>"></div>
                <div class="clr"></div>
            </div>
            <div style="padding:10px 0;text-align: center;">
                <input  type="hidden" value="<?=$id?>" name="id_sys">
                <input  type="submit" value="Save" name="save_sys">
                <input style="padding-left: 15px;" type="submit" value="Cancel">
            </div>
        </form>
<?php
        exit();
    }
    echo '0';
    exit();
}
add_action('wp_ajax_customise_view_code_production_system', 'customise_view_code_production_system');
function customise_view_code_production_system(){
    $current_user=  wp_get_current_user();
    $base_url=  get_option('siteurl');
    global $wpdb;
    if(isset($_POST['id'])){
        $client_id=$_POST['id'];
        $sql="select * from wp_user_code_extract where client_id='".$client_id."' and user_id='".$manager_id."'";
        $rows=$wpdb->get_results($sql);
        ?>
        <div id="code-production-system" style="width:520px;border: 2px solid #696969;">
            <div class="" style="background:#0188CC;">
                <div class="fleft cu-code cu-title">Code</div>
                <div class="fleft cu-des cu-title">Book keeping account description </div>
                <div class="fleft cu-action cu-title">Action</div>
                <div class="clr"></div>
            </div>
            <?php foreach ($rows as $row){?>
                <div style="border-bottom:1px solid #696969;">
                    <div class="fleft cu-code"><?=$row->code?></div>
                    <div class="fleft cu-des"><?=$row->description_extract?></div>
                    <div class="fleft cu-action">
                        <a href="<?=$base_url?>/wp-admin/admin-ajax.php?action=customise_load_form_edit_production_system&id=<?=$row->id?>&width=400&height=220" class="thickbox thick-button" >
                            <img src="<?=  bloginfo('template_url')?>/images/edit.png"/>
                        </a>                        
                        <a style="padding-left:20px;" onclick="delete_code_extract('<?=$row->id?>',this);"><img src="<?=  bloginfo('template_url')?>/images/delete.png"/></a>
                    </div>
                    <div class="clr"></div>
                </div>
            <?php }?>
        </div>
        <?php
        exit();
    }else{
        echo '0';
        exit();
    }
}


add_action('wp_ajax_load_form_possible_macthes', 'load_form_possible_macthes');
function load_form_possible_macthes(){
	$_GET = stripslashes_deep( $_GET );
    if(isset($_GET['user_id'])&&isset($_GET['sys_id'])&&isset($_GET['description'])&&$_GET['balance_id']){
        $description_original=$_GET['description'];
        $user_id=$_GET['user_id'];
        $production_system_id=$_GET['sys_id'];
        $rows=get_other_possible($description_original, $user_id, $production_system_id);
        ?>
        <form method="POST" action="" name="form_possible_matches">
            <div style="font-size:25px;text-align: center;padding: 20px 0;">Other possible matched found</div>
            <div style="border:1px solid #c2c2c2;height: 230px;display: block;overflow:scroll;">
                <div style="font-weight: bold;background: #0188CC;color: #fff;">
                    <div class="fleft m-check">&nbsp;</div>
                    <div class="fleft m-code">Code</div>
                    <div class="fleft m-des">Description</div>
                    <div class="clr"></div>
                </div>
                <?php foreach ($rows as $row){?>
                <div  style="border-bottom: 1px solid #c2c2c2;">
                    <div class="fleft m-check"><input type="checkbox" value="<?=$row->id?>" name="check_code[]"></div>
                    <div class="fleft m-code"><?=$row->code?></div>
                    <div class="fleft m-des"><?=$row->description?></div>
                    <div class="clr"></div>
                </div>
                <?php }?>
            </div>
            <input type="hidden" value="<?=$_GET['sys_id']?>" name="sys_id">
            <input type="hidden" value="<?=$_GET['description']?>" name="description_original">
            <input type="hidden" value="<?=$_GET['balance_id']?>" name="balance_id">
            <div style="text-align: center;padding: 20px 0 0 0;">
                <input type="submit" value="Save" name="update_code_possible_matches">
                <input type="submit" value="Cancel" >
            </div>
        </form>
<style>
    .m-check{
        width: 50px;
        text-align: center;
    }
    .m-code{
        width: 100px;
    }
    .m-des{
        width: 200px;
    }
</style>
<?php
        exit();
    }else{
        echo '0';
        exit();
    }
}

add_action('wp_ajax_save_open_balance_edits', 'save_open_balance_edits');
function save_open_balance_edits(){
    global $wpdb;
	$_POST = stripslashes_deep( $_POST );
	$id=$_POST['id'];
	$desc=$_POST['desc'];
	$price=$_POST['price'];
	
	$sql_select = "select userid, production_system_id, client_id from wp_open_balance where id='$id'";
    $rows=$wpdb->get_results($sql_select);
    if(count($rows)>0){
		$row->id=$id;
		$row->description = $desc;
		$row->price = $price;
		$user_info = new USER_INFO($rows[0]->userid);
		$production_system_id=$rows[0]->production_system_id;
		$client_id=$rows[0]->client_id;		
		// match code
		code_row($user_info, $row, $client_id, $production_system_id, 0);
		$sql = "update wp_open_balance set description_original='$desc', price='$price' where id='$id'";
		$wpdb->query($sql);
		echo '1';
		exit();
	} else {
		echo '0';
		exit();
	}	
}

add_action('wp_ajax_confirm_open_balance', 'confirm_open_balance');
function confirm_open_balance(){
    global $wpdb;
	$_POST = stripslashes_deep( $_POST );
	$tb_file_id=mysql_real_escape_string($_POST['tb_file_id']);
	$sql = "update wp_open_balance set confirmed=TRUE where tb_file_id='$tb_file_id'";
	$wpdb->query($sql);	
	combine_open_balance($tb_file_id, $_POST['wide_map']);
	echo '1';
	exit();
}

add_action('wp_ajax_delete_open_balance_bulk', 'delete_open_balance_bulk');
function delete_open_balance_bulk(){
    global $wpdb;
	$current_user=new USER_INFO(wp_get_current_user()->ID);
	$_POST = stripslashes_deep( $_POST );
	$ids=$_POST['ids'];
	
	if (preg_match(WP_BULK_ID_REGEX, $ids)) {
		// delete entries
		$ret = $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM wp_open_balance " .
				"WHERE id IN ($ids) AND manager_id=%d",
				$current_user->get_manager_id()
			)
		);

		if ($ret === false) {
			error_log("delete_open_balance_bulk - DB error bulk deleting opening balance entries, ids=$ids");
		} else {
			echo '1';
			exit();
		}
	} else {
		error_log("delete_open_balance_bulk - invalid ids=[$ids]");
	}
	echo '0';
	exit();
}

add_action( 'init', 'create_post_type_system' );
function create_post_type_system() {
    register_post_type( 'production_system',
        array(
            'labels' => array(
                    'name' => __( 'Production System' ),
                    'singular_name' => __( 'Production System' )
            ),
            'public' => false,
            'has_archive' => true,
            'rewrite' => array('slug' => 'production-system'),
            'supports'=>array('title','editor','author','thumbnail'),
        )
    );
    register_post_type( 'balance',
        array(
            'labels' => array(
                    'name' => __( 'Balance' ),
                    'singular_name' => __( 'Balance' )
            ),
            'public' => false,
            'has_archive' => true,
            'rewrite' => array('slug' => 'balance'),
            'supports'=>array('title','editor','author','thumbnail'),
        )
    );
    register_post_type( 'client_limit',
        array(
            'labels' => array(
                    'name' => __( 'Limit Client' ),
                    'singular_name' => __( 'limit client' )
            ),
            'public' => false,
            'has_archive' => true,
            'rewrite' => array('slug' => 'client limit'),
            'supports'=>array('title','editor','author','custom-fields'),
        )
    );
    register_post_type( 'video',
        array(
            'labels' => array(
                    'name' => __( 'Video' ),
                    'singular_name' => __( 'video' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'video'),
            'supports'=>array('title','editor','author','custom-fields','thumbnail'),
        )
    );
    register_post_type( 'import_times',
        array(
            'labels' => array(
                    'name' => __( 'Import Times' ),
                    'singular_name' => __( 'import_times' )
            ),
            'public' => false,
            'has_archive' => true,
            'rewrite' => array('slug' => 'import_times'),
            'supports'=>array('title','editor','author','thumbnail'),
        )
    );
}
/*For Import Times*/
add_action( 'add_meta_boxes', 'import_times_add_custom_box' );
function import_times_add_custom_box(){
    $screens = array('import_times');
    foreach ($screens as $screen) {
        add_meta_box('import_timesid','Import Times option','import_times_inner_custom_box',$screen);
    }
}
function import_times_inner_custom_box($post){
    wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename2' );
    $value1 = get_post_meta( $post->ID, '_import_times', true );
    echo '<label for="myplugin_import_times">Import Times';
    echo '</label> ';
    echo '<input type="text" id="import-times" name="import_times" value="'.esc_attr($value1).'" size="25" />';
    $value2 = get_post_meta( $post->ID, '_import_times_price', true );
    echo '<label for="myplugin_import_times">Price';
    echo '</label> ';
    echo '<input type="text" id="import-times-price" name="import_times_price" value="'.esc_attr($value2).'" size="25" />';
}
add_action( 'save_post', 'import_times_save_postdata' );
function import_times_save_postdata( $post_id ) {
    // First we need to check if the current user is authorised to do this action. 
    if ( 'import_times' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) )
          return;
    } else {
      if ( ! current_user_can( 'edit_post', $post_id ) )
          return;
    }
    // Secondly we need to check if the user intended to change this value.
    if ( ! isset( $_POST['myplugin_noncename2'] ) || ! wp_verify_nonce( $_POST['myplugin_noncename2'], plugin_basename( __FILE__ ) ) )
        return;
    // Thirdly we can save the value to the database
    //if saving in a custom table, get post_ID
    $post_ID = $_POST['post_ID'];
    //sanitize user input
    $mydata1 = sanitize_text_field( $_POST['import_times']);
    $mydata2 = sanitize_text_field( $_POST['import_times_price']);
    // Do something with $mydata 
    // either using 
    add_post_meta($post_ID, '_import_times', $mydata1, true) or
    update_post_meta($post_ID, '_import_times', $mydata1);
    add_post_meta($post_ID, '_import_times_price', $mydata2, true) or
    update_post_meta($post_ID, '_import_times_price', $mydata2);
// or a custom table (see Further Reading section below)
}
/*End for Import Times*/
add_action('init','add_role_for_user');
function add_role_for_user(){
    add_role('member', 'Member');
    add_role('manager', 'Manager');
}
add_action( 'add_meta_boxes', 'myplugin_add_custom_box' );
function myplugin_add_custom_box() {
    $screens = array('balance');
    foreach ($screens as $screen) {
        add_meta_box('myplugin_sectionid','Balance option','myplugin_inner_custom_box',$screen);
    }
}
function myplugin_inner_custom_box( $post ) {
    wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
    $value1 = get_post_meta( $post->ID, '_balance', true );
    echo '<label for="myplugin_new_field">Balance';
    echo '</label> ';
    echo '<input type="text" id="balance" name="balance" value="'.esc_attr($value1).'" size="25" />';
    }
    //save post data
add_action( 'save_post', 'myplugin_save_postdata' );
function myplugin_save_postdata( $post_id ) {
    // First we need to check if the current user is authorised to do this action. 
    if ( 'balance' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) )
          return;
    } else {
      if ( ! current_user_can( 'edit_post', $post_id ) )
          return;
    }
    // Secondly we need to check if the user intended to change this value.
    if ( ! isset( $_POST['myplugin_noncename'] ) || ! wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename( __FILE__ ) ) )
        return;
    // Thirdly we can save the value to the database
    //if saving in a custom table, get post_ID
    $post_ID = $_POST['post_ID'];
    //sanitize user input
    $mydata1 = sanitize_text_field( $_POST['balance']);
    // Do something with $mydata 
    // either using 
    add_post_meta($post_ID, '_balance', $mydata1, true) or
      update_post_meta($post_ID, '_balance', $mydata1);
// or a custom table (see Further Reading section below)
}
function custom_login_form() {
    echo '
    <style type="text/css">
        body.login div#login h1 a {
            background: url('.get_option('siteurl').'/wp-content/uploads/logo/logo-1.jpg) no-repeat;
            height:120px;
            width: 200px;
            margin:0 auto;
        }
        #login {
            padding:20px;
            background:#fff;
            -moz-box-shadow:    3px 3px 5px 6px #ccc;
            -webkit-box-shadow: 3px 3px 5px 6px #ccc;
            box-shadow:         3px 3px 5px 6px #ccc;
        }
        body.login{
            padding-top:100px;
        }
        body.login div#login form#loginform {
            border:none;
            padding:0;
            background:transparent;
            box-shadow:none;
        }
    </style>';
}
add_action( 'login_enqueue_scripts', 'custom_login_form' );

function insert_order($order){
    global $wpdb;
    $sql="insert into wp_order (user_id,product_id,product_type,time_pay,status,cc_number,email,more_info) values('".$order->user_id."','".$order->product_id."','".$order->product_type."','".$order->time."','".$order->status."','".$order->cc_number."','".$order->email."','".$order->more_info."')";
    $wpdb->query($sql);
}
add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
      show_admin_bar(false);
    }
}
function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
?>
