<div id="step4" class="tab-pane show_div">


<div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                        <div class="notice_board">
                        <div class="notice_board_topcon">
                        <div class="notice_top_left"></div>
                        <div class="notice_top_mid"></div>
                        <div class="notice_top_right"></div>
                        <div class="clearfix"></div>
                        </div>
                        
                        
{{ Form::open( array('url' => '/excel-upload', 'files' => true, 'id'=>'imageform', 'name'=>'imageform')   ) }}
                        
<div class="notice_midbg">
<div class="board_title">
 <!-- <a href="#" class="click_view">Click to view</a> -->
<div class="browse_btn">
<ul>
<?php
for($i=1;$i<=5;$i++){
?>
<li>
<span class="btn btn-default btn-file">
FILE<?php echo $i; ?><input type="file" name="add_file<?php echo $i; ?>" id="add_file<?php echo $i; ?>" class="xyz"  >
</span>
<span><input type="radio" />
</span>
</li>
<?php
}
?>
</ul>
<div id='preview'>
</div>
</div>
<div class="upload_btn">
<!-- <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button></div> -->
</div>

  {{ Form :: close() }}
  
  

<div class="col-xs-12 holidays_border" >
<div class="url_apimain">
<div class="url_apicon">
<div class="url_apicon_heading">
<strong>URL API</strong> to view excel files online
</div>
<div class="url_apitext">
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. <br>
<br>
Excepteur sint occaecat cupidatat non proident, sunt in <a href="#">culpa qui officia deserunt mollit</a> anim id est laborum.
</div>

</div>


<div class="clearfix"></div>
</div>



</div>
<div class="clearfix"></div>
</div>
                        
                        <div class="notice_board_topcon">
                        <div class="notice_bottom_left"></div>
                        <div class="notice_bottom_mid"></div>
                        <div class="notice_bottom_right"></div>
                        <div class="clearfix"></div>
                        </div>
                        </div>
                        
                        </div>
                       
                      </div>
                    </div>
                  </div>

</div>
</div>
     