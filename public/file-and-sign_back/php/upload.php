<?php
//include ('../connect.php');
//include('../../../../app/library/FileAndSign.php');
//$user_id    = $_SESSION['admin_details']['id'];

//$client_id  = $_POST['client_id'];
//print_r($_REQUEST);die;
    include('class.uploader.php');//print_r($_FILES['files']);die;
    
    $uploader = new Uploader();
    $data = $uploader->upload($_FILES['files'], array(
        'limit' => 10, //Maximum Limit of files. {null, Number}
        'maxSize' => 10, //Maximum Size of files {null, Number(in MB's)}
        'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
        'required' => false, //Minimum one file is required for upload {Boolean}
        'uploadDir' => '../../uploads/client_doc/', //Upload directory {String}
        'title' => array('name'), //New file name {null, String, Array} *please read documentation in README.md
        'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
        'perms' => null, //Uploaded file permisions {null, Number}
        'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
        'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
        'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
        'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
        'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
        'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
    ));
    
    if($data['isComplete']){
        $files = $data['data'];
        //print_r($_FILES['files']);
        /*$value = $files['metas'][0]['name'];
        $que = mysql_query("insert into file_signs set user_id='".$user_id."', client_id='".$client_id."', document='".$value."', created='".date('Y-m-d H:i:s')."'") or die(mysql_error());*/
        //$details['name'] = $files['metas'][0]['name'];
        $details['name'] = $_FILES['files']['name'][0];

        echo json_encode($details);
    }

    if($data['hasErrors']){
        $errors = $data['errors'];
        print_r($errors);
    }
    
    function onFilesRemoveCallback($removed_files){
        foreach($removed_files as $key=>$value){
            $file = '../../uploads/client_doc/' . $value;
            if(file_exists($file)){
                unlink($file);
            }
        }
        
        return $removed_files;
    }
?>
