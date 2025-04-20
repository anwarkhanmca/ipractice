<?php
$content = '';
if (isset($details['description']) && count($details['description'])>0) {
  foreach($details['description'] as $key=>$value){
    if(isset($value['prev_value']) && $value['prev_value'] != ''){
      $prev_value = $value['prev_value'];
    }else{
      $prev_value = '';
    }
    if(isset($value['updated_value']) && $value['updated_value'] != ''){
      $updated_value = $value['updated_value'];
    }else{
      $updated_value = '';
    }
    $content .= "<p><strong>".$value['full_name']."</strong><br>Updated from ".$prev_value." to ".$updated_value."</p>";
  }
}
?>

<p><strong>Staff Details Changes:</strong></p>
<p><?= $content;?></p>
<p>Author : {{$USERNAME or ''}}</p>
<p>Regard</p>
<p>{{$PRACTICENAME or ''}}</p>
<p>This email and any attachments to it may be confidential and are intended solely for the use of the individual to whom it is addressed. If you are not the intended recipient of this email, you must neither take any action based upon its contents, nor copy or show it to anyone. Please contact the sender if you believe you have received this email in error.</p>
