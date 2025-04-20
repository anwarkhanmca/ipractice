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
$next_id = $_POST['next_id'];
$r_id = $_POST['r_id'];
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
		$history_arr['event'] = "Sign document";
		$history_arr['user'] = $user;
		$history_arr['ip_address'] = $ip_address;
		$history_arr['doc_id'] = $doc_id;
		ins_rec('document_history', $history_arr);
	}
}

if($total_page == $page) {
	
	$signed_doc = get_single_value("document_send_multiple","signed_docs_id","id=$r_id");
	$docs_id = get_single_value("document_send_multiple","docs_id","id=$r_id");
	
	$s_mail = 0;
	if($signed_doc=='') {
		$sID_arr["signed_docs_id"]=$doc_id.",";
		upd_rec("document_send_multiple",$sID_arr,"id=$r_id");
		$s_mail = 0;
	}
	else {
		$signed_doc_arr = array_filter(explode(',',$signed_doc));
		$docs_id_arr = explode(',',$docs_id);
		sort($signed_doc_arr);
		sort($docs_id_arr);
			if($signed_doc_arr == $docs_id_arr) {
				echo $s_mail = 1;
			}
			else {
				$signed_doc_arr = array_filter(explode(',',$signed_doc));
				if(!in_array($doc_id,$signed_doc_arr)) {
					$signed_doc = implode(',',$signed_doc_arr);
					$sID_arr["signed_docs_id"]=$signed_doc.','.$doc_id.",";
					upd_rec("document_send_multiple",$sID_arr,"id=$r_id");
					
					$s_mail = 0;
					
					$signed_doc = get_single_value("document_send_multiple","signed_docs_id","id=$r_id");
					$signed_doc_arr = array_filter(explode(',',$signed_doc));
					$docs_id_arr = explode(',',$docs_id);
					sort($signed_doc_arr);
					sort($docs_id_arr);
						if($signed_doc_arr == $docs_id_arr) {
							echo $s_mail = 1;
						}
				}
				
			} 
	}
	
	if($s_mail == 1) {
	
		$to_email = get_single_value("document_send_multiple","email_arr","id=$r_id");
		$subject = get_single_value("document_send_multiple","email_subject","id=$r_id");
		$message = get_single_value("document_send_multiple","email_body","id=$r_id");
		$documentArr = explode(',',$docs_id);
		
		$email_arr = explode(',',$to_email);
		if(count($email_arr) > $next_id) {
				
				$sID_arr["signed_docs_id"]="";
				upd_rec("document_send_multiple",$sID_arr,"id=$r_id");
				
				$next_id1 = $next_id+1;
			$doc_link = $SITE_URL."document-sign-multiple-with-signer.php?data=".$session_id."&&difs=".$doc_id."&Oid=".$owner_id."&Nid=".$next_id1."&r_id=".$r_id."&Signer=".$email_arr[$next_id];
				$subject= $subject;
				$to=$email_arr[$next_id];
				$from=$From_EmailAddress;	 
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
						<td align="center">'.$message.'</td>
					</tr>
					<tr>
						<td height="20" >&nbsp;</td>
					</tr>';
				//$document_arr = array_filter($documents);	
				if(count($documentArr) > 0) {
					foreach($documentArr as $doc_id) {
						
						$history_arr['event'] = "Invite signer";
						$history_arr['user'] = $_SESSION['admin_details']['email'];
						$history_arr['ip_address'] = $ip_address;
						$history_arr['doc_id'] = $doc_id;
						ins_rec('document_history', $history_arr);	
						$Signer = $email_arr[$next_id];
					$doc_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', get_single_value("documents","doc_name","id=$doc_id")); 
					$doc_link = $SITE_URL."document-sign-multiple-with-signer.php?data=".$session_id."&&difs=".$doc_id."&Oid=".$owner_id."&Nid=".$next_id1."&r_id=".$r_id."&Signer=".$Signer;
					$mailcontent .=	'
						<tr>
							<td align="center">
								<a style="padding:10px; background-color:#3C8DBC; color:#FFFFFF; text-decoration: none; border-radius:5px;" href="'.$doc_link.'">Sign Document "'.$doc_name.'"</a>
							</td>
						</tr>
						<tr>
							<td><strong>&nbsp;</strong></td>
						</tr>';
					}	
				}	
				$mailcontent .=	'
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
					SendHTMLMail($to,$subject,$mailcontent,$from);
		}			
		else {
			if(isset($doc_id) && $doc_id!='') {
				$attachment_arr = array();
				$docs_id = get_single_value("document_send_multiple","docs_id","id=$r_id");
				$documentArr = explode(',',$docs_id);
				if(count($documentArr) > 0) { 
					foreach($documentArr as $d_id) {
						$doc_id = $d_id;
						$doc_arr['doc_status']=2;
						upd_rec("documents",$doc_arr,"id=$doc_id");
					
						$d_name = get_single_value("documents","doc_name","id=$d_id");
						$q = "select * from document_image WHERE doc_id=$d_id ORDER BY id";
						$res = mysql_query($q);
						$total_page = mysql_num_rows($res);
						$jpg_files = "";
						if(mysql_num_rows($res) > 0) {
							while($f = mysql_fetch_array($res))
							{
								$jpg_files .= ' ds_files/jpg_files/'.$f['image_name']; 
							}
							
							$pdf_file = 'ds_files/pdf_files/'.$d_name;
							
							$location  = "convert -density 300";
							$convert   = $location . " " . $jpg_files . " " . $pdf_file;
							exec($convert." 2>&1", $array);
						}
						$attachment_arr[$d_id] = $pdf_file;
					}	
				}
				$doc_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $d_name);
				
				$email_arr1 = explode(',',$to_email);
				
				foreach($email_arr1 as $toEmail) {
					$subject = $doc_name." has been completed";
					$toAddress = $toEmail;
					$fromAddress = $From_EmailAddress;
					$fromName = "i-Practice";
					//$attachment = $pdf_file;	 
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
						SendHTMLMailWITHMultipleFile($toAddress, $toName, $subject, $mailcontent, $attachment_arr, $fromAddress, $fromName);
						//SendHTMLMailWITHFile($toAddress, $toName, $subject, $mailcontent, $attachment, $fromAddress, $fromName);
								
				}
				
				$subject = $doc_name." has been completed";
				$toAddress = $user_email;
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
					SendHTMLMailWITHMultipleFile($toAddress, $toName, $subject, $mailcontent, $attachment_arr, $fromAddress, $fromName)
					
					//SendHTMLMailWITHFile($user_email, $toName, $subject, $mailcontent, $attachment, $fromAddress, $fromName);
					
				//del_rec("document_send", "doc_id=$doc_id");
			}
		}
	}	
}
?>
