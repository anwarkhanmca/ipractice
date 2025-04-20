<?php include ('connect.php'); 
if(!isset($_SESSION['admin_details']['id']) && $_SESSION['admin_details']['id']=="") {
	echo "Logout!";
	header("Location:http://mpm.digiopia.in/login");
}
$user_id = $_SESSION['admin_details']['id'];

/* ============================= File upload to Dropbox ================================= */
function uploadx($dirtocopy, $dropboxdir, $uploader){
    if ($handle = opendir($dirtocopy)) {
        while (false !== ($entry = readdir($handle))) {
            if ($entry != "." && $entry != "..") {

                if(is_dir($entry)){
                    uploadx($dirtocopy.$entry.'/', $dropboxdir.$entry.'/', $uploader);
                } else {
                    $uploader->upload($dirtocopy.$entry, $dropboxdir.$entry);
                }

            }
        }
        closedir($handle);
    }
}

// Dropbox username/password
$dropbox_email='sakir@crystalinfoway.com';
$dropbox_pass='developer@123';

// File to backup
$siteroot = "ds_files/pdf_files/";

include("include/DropboxUploader.php");

$uploader = new DropboxUploader($dropbox_email, $dropbox_pass);

uploadx($siteroot, '/', $uploader);

/* ============================= File upload to Dropbox ================================= */

?>