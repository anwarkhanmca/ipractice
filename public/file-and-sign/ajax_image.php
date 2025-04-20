<?php include('connect.php'); 
/*$png = $_POST['data'];
$name = $_POST['name'];
$filteredData=substr($png, strpos($png, ",")+1);
$unencodedData=base64_decode($filteredData);
$fp = fopen( $name.'.png', 'wb' );
fwrite( $fp, $unencodedData);
fclose( $fp );*/
$user_email = $_SESSION['admin_details']['email'];

$data = $_POST['data'];
$name = $_POST['name'];
$doc_id = $_POST['doc_id'];
$d_done = $_POST['d_done'];

$d_id = $_POST['d_id'];
$page = $_POST['page'];
$total_page = $_POST['total_page'];
$user = $_POST['user'];

//sleep(5);
list($type, $data) = explode(';', $data);
list(, $data)      = explode(',', $data);
$data = base64_decode($data);

file_put_contents($name, $data);

if(isset($doc_id) && $doc_id!='') {

	if($page == $total_page) {	
		
		$d_id = $_POST['doc_id'];
		$d_name = get_single_value("documents","doc_name","id=$d_id");
	
		$q = "select * from document_image WHERE doc_id=$doc_id ORDER BY id";
		$res = mysql_query($q);
		$total_page = mysql_num_rows($res);
		$jpg_files = "";
		if(mysql_num_rows($res) > 0) {
			while($f = mysql_fetch_array($res))
			{
				$jpg_files .= ' ds_files/jpg_files/'.$f['image_name']; 
			}
			
			$pdf_file = 'ds_files/pdf_files/'.$d_name;
			
			$location   = "convert -density 300";
			$convert   = $location . " " . $jpg_files . " " . $pdf_file;
			exec($convert." 2>&1", $array);
		}
			
	
		$doc_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $d_name);
		
		$subject = $doc_name." has been completed";
		$toAddress = $user;
		$fromAddress = $From_EmailAddress;
		$fromName = "i-Practice";
		$attachment = $pdf_file;	 
		$mailcontent = '
		<style>
		  .bodrtab
		  {
				border:1px solid #333333;
		  }
		  td {
			font-family: Arial;
			font-size: 12px;
			color: 363636;
			}
		 .txt-14 {
			font-family: Arial;
			font-size: 14px;										
			font-weight: bolder;
			color: #FFFFFF;
			}
		</style>
		<table width="80%"  style="border:1px solid #333333;background-color:#FFFFFF" cellspacing="4" cellpadding="4" >
		<tr bgcolor="#FFF">
		<td style="background-color:#3C8DBC"><img src="'.$SITE_URL.'images/logo.png"></td>
		</tr>
			<tr>
				<td align="center">Everyone signed the document "'.$doc_name.'".</td>
			</tr>
			<tr>
				<td height="20" >&nbsp;</td>
			</tr>
			
			<tr>
				<td><strong>&nbsp;</strong></td>
			</tr>
			
			<tr>
				<td><strong>Thank You,</strong></td>
			</tr>
	
			<tr>
				<td><strong>i-Practice Team.</strong></td>
			</tr>
		
			</table>';
			//echo $to."<br>".$subject."<br>".$mailcontent."<br>".$from; exit;
			//echo $toAddress."<br>".$subject."<br>".$mailcontent."<br>".$fromAddress; exit;
			
			//echo $attachment= 'ds_files/pdf_files/'.$d_name.'.pdf';
			
			SendHTMLMailWITHFile($toAddress, $toName, $subject, $mailcontent, $attachment, $fromAddress, $fromName);
			
			SendHTMLMailWITHFile($user_email, $toName, $subject, $mailcontent, $attachment, $fromAddress, $fromName);
			if($d_done == 1) {		
				$doc_arr['doc_status']=2;
				upd_rec("documents",$doc_arr,"id=$doc_id");
			}
	}		
}
if(isset($d_id) && $d_id!='') {
	if($page == $total_page) {
		$history_arr['event'] = "Sign document";
		$history_arr['user'] = $user;
		$history_arr['ip_address'] = $ip_address;
		$history_arr['doc_id'] = $d_id;
		ins_rec('document_history', $history_arr);
		
		$history_arr['event'] = "Close document";
		$history_arr['user'] = $user;
		$history_arr['ip_address'] = $ip_address;
		$history_arr['doc_id'] = $d_id;
		ins_rec('document_history', $history_arr);
	}
}	
?>