<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/css/mps_style.css" rel="stylesheet" type="text/css">
<style type="text/css">
textarea {
  resize: none;
}
</style>
<!-- <div class="modal fade" id="activity_history-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Database Structure</h4>
        <p>December 5, 2015 at 10:00 PM <i class="glyphicon glyphicon-paperclip"></i></p>
        <p class="no_pad">From <span class="blue">Abel Asiamah</span></p>
         <p class="no_pad">To <span class="blue">jenish@gmail.com</span></p>
         <p class="no_pad"><i class="glyphicon glyphicon-paperclip"></i> 
        <i class="glyphicon glyphicon-file"></i> <span class="blue">jenish@gmail.250 MB</span></p>

        <div class="clearfix"></div>
      </div>

    <input type="hidden" name="client_type" value="org">
    <div class="modal-body">
      <div class="form-group">
        <p>Screen readers will have trouble with your forms if you don't include a label for every input. For these inline forms, you can hide the labels using the .sr-only class. There are further alternative methods of providing a label for assistive technologies, such as the aria-label, aria-labelledby or title attribute.</p>
      </div>
      

  </div>
</div>
</div> -->
<?php 
  $subject    = $_REQUEST['subject'];
  $to_email   = $_REQUEST['to_email'];
  $from_email = $_REQUEST['from_email'];
  $body       = $_REQUEST['body'];
  $send_date  = $_REQUEST['send_date'];
  //$files      = $_REQUEST['files'];
//echo $files;die;
  $file_name = '';
  /*if(isset($files) && count($files) >0){
    foreach ($files as $key => $value) {
      $file_size = $value['file_size']/1000;
      $file_name .= $value['file_name'].' '.$file_size.' MB, ';
    }
  }*/
?>
    
  <div class="alert alert-info" style="margin:0; text-align: center;">
    <strong><?php echo $subject;?></strong>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12" style="padding:10px 30px;">
    <div class="form-group">
      <p><div class="width-email">Email To</div> <span class="blue"><?php echo $to_email;?></span></p>
      <p><div class="width-email">Email From</div><span class="blue"><?php echo $from_email;?></span></p>
      <p><div class="width-email">Date</div> <span class="blue"><?php echo date('M d, Y H:i a', $send_date);?></span></p>
      <?php if($file_name != ''){?>
      <p><div class="width-email">Attachment</div> <i class="glyphicon glyphicon-paperclip"></i> 
        <i class="glyphicon glyphicon-file"></i> <span class="blue">
      <?php echo $file_name;?>
      </span>
      </p>
      <?php }?>
    </div>
      
      <div class="form-group">
        <label style="margin-top:0!important">Message</label>
        <textarea class="form-control" rows="10" readonly="readonly" id="editor123"><?php echo $body;?></textarea>
      </div>
        
  </div>  