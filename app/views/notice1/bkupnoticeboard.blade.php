@extends('layouts.layout') @section('mycssfile')
   

 @stop @section('myjsfile')
<script src="{{ URL :: asset('ckeditor/ckeditor.js') }}" type="text/javascript">
</script>

<script type="text/javascript" src="js/notice_board.js">
</script>
<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>-->

<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript">
</script>
@stop

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.8.20/jquery-ui.min.js" type="text/javascript"></script>
<script src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script>
<script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script>
  
 



 @section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
	<!-- Left side column. contains the logo and sidebar -->
	<aside class="left-side sidebar-offcanvas {{ $left_class }}">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			@include('layouts/inner_leftside')
		</section>
		<!-- /.sidebar -->
	</aside>
	<!-- Right side column. Contains the navbar and content of the page -->
	<aside class="right-side {{ $right_class }}">
		<!-- Content Header (Page header) -->
		@include('layouts.below_header')
		<!-- Main content -->
	<!--	{{ Form::open(array('url' => '/insert-noticeboard', 'files' => true)) }} -->
		<section class="content">
			<!--<div class="row">
			<div class="top_bts">
			<ul>
			<li>
			<button class="btn btn-info"><i class="fa fa-print"></i> Print</button>
			</li>
			<li>
			<button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button>
			</li>
			<li>
			<button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button>
			</li>
			<li>
			<button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
			</li>
			<li>
			<button class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button>
			</li>
			<div class="clearfix"></div>
			</ul>
			</div>
			</div>-->
			<div class="practice_mid">
			<!--	<form> -->
					<div class="tabarea">
						<div class="nav-tabs-custom">
                        <div class="notice_board_main">
                                <div class="notice_board_tab" id="noticetab">
                                <ul>
                                        <li style="width:15%;" data-tabno="1"><a href="javascript:void(0)"  class="tab_active notice_tabhover">Board</a></li>
                                        <li style="width:15%;" data-tabno="2" ><a href="javascript:void(0)" class="notice_tabhover">Board2</a></li>
                                        <li style="width:30%;" data-tabno="3"><a href="javascript:void(0)" class="notice_tabhover">Staff Holidays & Time off</a></li>
                                        <li style="width:20%;" data-tabno="4" ><a href="javascript:void(0)" class="notice_tabhover">Excel Viewer</a></li>
                                        <li style="width:20%;" data-tabno="5"><a href="javascript:void(0)" class="notice_tabhover">PDF Viewer</a></li>
                                        </ul>
                                </div>
                        </div>
						<!--	<ul class="nav nav-tabs nav-tabsbg" id="header_ul">
								<li class="active" id="tab_1">
									<a class="open_header" data-id="1" href="javascript:void(0)">Board1</a>
								</li>
								<li class="" id="tab_2">
                                <a class="open_header" data-id="2" href="javascript:void(0)">Board2</a>
								
								</li>
								<li class="" id="tab_3">
									<a class="open_header" data-id="3" href="javascript:void(0)">Staff Holiday/Course</a>
								</li>
                                <li class="" id="tab_4">
									<a class="open_header" data-id="4" href="javascript:void(0)">PDF Viewer</a>
								</li>
                                
								<li class="" id="tab_5">
									<a class="open_header" data-id="5" href="javascript:void(0)">Excel Viewer</a>
								</li>
							
							</ul> -->
							<div class="tab-content" style="padding:10px 0 0 0;">
<div id="step1" class="tab-pane show_div active">
									<!--table area-->
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

                @if ( $errors->count() > 0 )
                     <ul>
                        @foreach( $errors->all() as $message )
                          <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif
                        
<div class="notice_midbg"> 
<span class="board_title">BOARD1</span>
<div class="col-xs-12 holidays_border" >

<div class="col-xs-4">
    <div class="noticeboard_leftside">
    <a href="#" data-toggle="modal" class="add_new">Add New...</a>
    </div>
</div>

<div class="col-xs-8" id="sortable">

@foreach($font as $key=>$val)
<div class="staff_left hvr-grow1 limitboard" id="<?php echo $val['noticefont_id']; ?>">

<div class="holidays_list" id="{{ $val['noticefont_id'] }}"  >
<span style="cursor:move" class="holidays_h">{{$val['message_subject'] }}</span>
<div style="cursor:pointer" >
<p class="holidays_content swapboard1" id="body{{ $val['noticefont_id'] }}" onclick="openbodyModal('{{ $val['noticefont_id'] }}',event)" >
    {{ (strlen($val['message']) > 625)? substr(strip_tags($val['message']), 0, 625)."...": strip_tags($val['message']) }}
</p>
</div>
<div class="clear"></div>

<div class="bottom_content">

        <p class="posted_t">Posted by {{ $userfullname->fname }} {{ $userfullname->lname}} {{ $val['created']}}</p>
        
        <input type="hidden" name="sort_id" id="sort_id" value="{{ $val['sort_id'] }}" />
        
         <input type="hidden" name="noticefont_id" id="noticefont_id" value="{{ $val['noticefont_id'] }}" />
        
        <div class="edit_controlar">
<a  href="#" data-template_id="{{ $val['noticefont_id'] }}" onclick="openModal('{{ $val['noticefont_id'] }}')"><img src="img/edit_icon.png"  /></a>
<a href="/delete-template/{{ $val['noticefont_id'] }}" onClick="return delfun()"><img src="img/cross.png" /></a>
        </div>

        
        <div class="clearfix"></div>
  
</div>
</div>
 
</div>
 @endforeach
<div id="console"></div>
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
                  <!--end table-->
                </div>
                <!-- /.tab-pane -->
	<div id="step2" class="tab-pane show_div">
																<!--table area-->
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

                        
<div class="notice_midbg"> 
<span class="board_title">BOARD2</span>
<div class="col-xs-12 holidays_border" >

<div class="col-xs-4">
<div class="noticeboard_leftside">
<a href="#" data-toggle="modal" class="add_new2">Add New...</a>
<!-- <a href="#" data-toggle="modal" data-target="#compose-modal" class="add_new">Add New...</a> -->
<!--<a href="#" class="add_new">Add New...</a> -->
<!--
<div class="bottom_content">

<p class="posted_t">Posted/Uplaod by Ramjee Sharma 22/06/2015</p>
<div class="edit_controlar">

<a href="#"><img src="img/edit_icon.png" /></a>
<a href="#"><img src="img/cross.png" /></a>
</div>
<div class="clearfix"></div>
</div>
-->
</div>

<!--
<div class="noticeboard_leftside">
<a href="#" class="add_new">Add New...</a>
<div class="bottom_content">
-->
<!--
<p class="posted_t">Posted/Uplaod by Ramjee Sharma 22/06/2015</p>
<div class="edit_controlar">
<a href="#"><img src="img/edit_icon.png" /></a>
<a href="#"><img src="img/cross.png" /></a>
</div>
-->
<!--
<div class="clearfix"></div>
</div>
</div>
-->
</div>

<div class="col-xs-8" id="sortable2">
@foreach($font2 as $key=>$val2)
<div class="staff_left hvr-grow1 limitboard2" id="<?php echo $val2['noticefont_id']; ?>">

<div class="holidays_list" id="dyn">
<span class="holidays_h">{{$val2['message_subject'] }}</span>
<div style="cursor:move" >
<p class="holidays_content" id="body{{ $val2['noticefont_id'] }}" onclick="openbodyModal('{{ $val2['noticefont_id'] }}')" >
    {{ (strlen($val2['message']) > 625)? substr(strip_tags($val2['message']), 0, 625)."...": strip_tags($val2['message']) }}
</p>
</div>
<div class="bottom_content">

        <p class="posted_t">Posted by {{ $userfullname->fname }} {{ $userfullname->lname}} {{ $val2['created']}}</p>
        
        <div class="edit_controlar">
<a href="#" data-template_id="{{ $val2['noticefont_id'] }}" onclick="openModal('{{ $val2['noticefont_id'] }}')"><img src="img/edit_icon.png"  /></a>
<a href="/delete-template/{{ $val2['noticefont_id'] }}" onClick="return delfun()"><img src="img/cross.png" /></a>
        </div>
        
        
  
</div>
</div>
 
</div>

 @endforeach

<!--<div class="staff_right">

<div class="holidays_list">
<span class="holidays_h">STAFF HOLIDAYS</span>
<p class="holidays_content">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum a qui officia deserunt mollit anim id est laborum a qui officia deserunt mollit anim id est laboruma qui officia deserunt mollit anim id est laborum a qui officia deserunt mollit anim id est laborum.</p>
<div class="bottom_content">
<p class="posted_t">Posted/Uplaod by Ramjee Sharma 22/06/2015</p>
<div class="edit_controlar">
<a href="#"><img src="img/edit_icon.png" /></a>
<a href="#"><img src="img/cross.png" /></a>
</div>
<div class="clearfix"></div>
</div>
</div>

</div>-->

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
                  <!--end table-->
                </div>
                <!-- /.tab-pane -->
								<div id="step3" class="tab-pane show_div">
								
                              <!--  	<div class="box-body table-responsive">
										<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
											<div class="row">
												<div class="col-xs-6">
												</div>
												<div class="col-xs-6">
												</div>
											</div>
											<div class="row">
												<div class="col-xs-12 col-xs-6">
													<div class="col_m2">
														<h3 class="box-title">
															Residential Address
														</h3>
														<div class="form-group">
															<label for="exampleInputPassword1">
																Residential Address
															</label>
															<input type="text" id="course_residentialaddress" name="course_residentialaddress" class="form-control">
														</div>
														<div class="twobox">
															<div class="twobox_1">
																<div class="form-group">
																	<label for="exampleInputPassword1">
																		Town/City
																	</label>
																	<input type="text" id="course_town" name="course_town" class="form-control">
																</div>
															</div>
															<div class="twobox_2">
																<div class="form-group">
																	<label for="exampleInputPassword1">
																		State Region
																	</label>
																	<input type="text" id="course_stateregion" name="course_stateregion" class="form-control">
																</div>
															</div>
															<div class="clearfix">
															</div>
														</div>
														<div class="twobox">
															<div class="twobox_1">
																<div class="form-group">
																	<label for="exampleInputPassword1">
																		Postal/Zip Code
																	</label>
																	<input type="text" id="course_zipcode" name="course_zipcode" class="form-control">
																</div>
															</div>
															<div class="twobox_2">
																<div class="form-group">
																	<label for="exampleInputPassword1">
																		Country
																	</label>
																	<input type="text" id="course_country" name="course_country" class="form-control">
																</div>
															</div>
															<div class="clearfix">
															</div>
														</div>
														<h3 class="box-title">
															Service Address
														</h3>
														<div class="form-group">
															<label for="exampleInputPassword1">
																Service Address
															</label>
															<input type="text" id="course_serviceaddress" name="course_serviceaddress" class="form-control">
														</div>
														<div class="twobox">
															<div class="twobox_1">
																<div class="form-group">
																	<label for="exampleInputPassword1">
																		Town/City
																	</label>
																	<input type="text" id="course_servicetown" name="course_servicetown" class="form-control">
																</div>
															</div>
															<div class="twobox_2">
																<div class="form-group">
																	<label for="exampleInputPassword1">
																		State Region
																	</label>
																	<input type="text" id="course_servicestate" name="course_servicestate" class="form-control">
																</div>
															</div>
															<div class="clearfix">
															</div>
														</div>
														<div class="twobox">
															<div class="twobox_1">
																<div class="form-group">
																	<label for="exampleInputPassword1">
																		Postal/Zip Code
																	</label>
																	<input type="text" id="course_servicezip" name="course_servicezip" class="form-control">
																</div>
															</div>
															<div class="twobox_2">
																<div class="form-group">
																	<label for="exampleInputPassword1">
																		Country
																	</label>
																	<input type="text" id="course_servicecountry" name="course_servicecountry" class="form-control">
																</div>
															</div>
															<div class="clearfix">
															</div>
														</div>
														<label for="exampleInputPassword1">
															Telephone
														</label>
														<div class="form-group">
															<div class="n_box01">
																<select class="form-control" name="course_servicetitle">
																	<option value="Mr">
																		Mr.
																	</option>
																	<option value="Mrs">
																		Mrs.
																	</option>
																</select>
															</div>
															<div class="telbox">
																<input type="text" id="course_servicetele" name="course_servicetele" class="form-control">
															</div>
															<div class="clearfix">
															</div>
														</div>
														<div class="form-group">
															<label for="exampleInputPassword1">
																Email
															</label>
															<input type="email" id="course_serviceemail" name="course_serviceemail" class="form-control">
														</div>
														<div class="form-group">
															<label for="exampleInputPassword1">
																Website
															</label>
															<input type="text" id="course_servicewebsite" name="course_servicewebsite" class="form-control">
														</div>
														<div class="form-group">
															<label for="exampleInputPassword1">
																Skype
															</label>
															<input type="text" id="course_serviceskype" name="course_serviceskype" class="form-control">
														</div>
														<div class="add_client_btn">
															<button class="btn btn-info back" data-id="2" type="button">
																Prev
															</button>
															<button type="submit" class="btn btn-success">
																Save
															</button>
															<button class="btn btn-info open" data-id="4" type="button">
																Next
															</button>
														</div>
													{{ Form :: close() }} 
														<div class="clearfix">
														</div>
													</div>
												</div>
												<div class="col-xs-12 col-xs-6">
												</div>
											</div>
										</div>
									</div> -->
								</div>
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
                        
                        

                        
<div class="notice_midbg">
<div class="board_title">
 <!-- <a href="#" class="click_view">Click to view</a> -->
<div class="browse_btn">
<ul>
<?php
for($i=1;$i<=5;$i++){
    
?>
{{ Form::open( array('url' => '/excel-upload', 'files' => true, 'id'=>'imageform'.$i, 'name'=>'imageform'.$i)   ) }}
  <input type="hidden" name="file_type" id="excel" value="E" />                      
<li>
<span class="btn btn-default btn-file">
FILE<?php echo $i; ?><input type="file" name="add_file<?php echo $i; ?>" id="add_file<?php echo $i; ?>" data-looper="<?php echo $i; ?>"  class="upload-buttons"  >
</span>

<span><input type="radio" name="excel_radio" />
</span>

<div id='preview<?php echo $i; ?>'>
</div>

<p class="file_name" id="file_value<?php echo $i; ?>"> 


@if ( (isset($all_excel[$i]['file'])) && (!empty($all_excel[$i]['file'])) )
<!-- {{$all_excel[$i]['file'] }} -->
<img src="img/attachment.png" />
@endif

</p>
</li>


  {{ Form :: close() }}
<?php
}
?>
</ul>
<div id='prev'>
</div>
<div class="upload_btn">
<!-- <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button></div> -->
</div>


  
  

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
     
                  <!--end table-->
								
							
                                
								<!-- /.tab-pane -->
							</div>
                            	<div id="step5" class="tab-pane show_div">


<div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      
                      <div class="row">
                        <div class="col-xs-12">
                        <div class="notice_board">
                        <div class="notice_board_topcon">
                        <div class="notice_top_left"></div>
                        <div class="notice_top_mid"></div>
                        <div class="notice_top_right"></div>
                        <div class="clearfix"></div>
                        </div>
                        
                        


                        
<div class="notice_midbg">
<div class="board_title">
 <!-- <a href="#" class="click_view">Click to view</a> -->
<div class="browse_btn">
<ul>
<?php
for($k=1;$k<=5;$k++){
?>
{{ Form::open( array('url' => '/excel-upload', 'files' => true, 'id'=>'pdfeform'.$k, 'name'=>'pdfform'.$k)   ) }}
<input type="hidden" name="file_type" id="pdf" value="P" />
<li>
<span class="btn btn-default btn-file">
FILE<?php echo $k; ?><input type="file" name="add_pdffile<?php echo $k; ?>" id="add_pdffile<?php echo $k; ?>" data-looper="<?php echo $k; ?>"  class="pdf"  >
</span>
<span><input type="radio" />
</span>
<div id='previewpdf<?php echo $k; ?>'>
</div>

<p class="file_name" id="file_pdfvalue<?php echo $k; ?>"> 
@if ( (isset($all_pdf[$k]['file'])) && (!empty($all_pdf[$k]['file'])) )

<img src="img/attachment.png" />
<!--{{ (strlen($all_pdf[$k]['file']) > 10)? substr(strip_tags($all_pdf[$k]['file']), 0, 10)."...": strip_tags($all_pdf[$k]['file'])
}} -->
@endif

</p>
</li>
  {{ Form :: close() }}
<?php
}
?>
</ul>
<div id='pdfprev'>
</div>
</div>
<div class="upload_btn">
<!-- <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload</button></div> -->
</div>


  
  

<div class="col-xs-12 holidays_border" >
<div class="url_apimain">
<div class="url_apicon">
<div class="url_apicon_heading">
<strong>URL API</strong> to view PDF files online
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
						</div>
					</div>
				</form>
			</div>
		</section>
		<!-- /.content -->
	</aside>
	<!-- /.right-side -->
</div>
<!-- ./wrapper -->
<!-- COMPOSE MESSAGE MODAL -->
{{ Form::open(array('url' => '/notice-template', 'files' => true)) }}
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">
					NOTICE BOARD
				</h4>
				<div class="clearfix">
				</div>
			</div>
			<!-- New popup -->
			<form action="#" method="post">
				<div class="modal-body">
					<div class="twobox">
						<div class="twobox_1">
							<div class="form-group">
								<label for="exampleInputPassword1">
									Message Subject
								</label>
								<input type="text" id="message_subject" name="message_subject" value="" class="form-control">
							</div>
						</div>
						<div class="twobox_2">
							<div class="form-group">
								<label for="exampleInputPassword1">
                                
                                <input type="hidden" name="board_no" id="board_no" value="1"/>
									<!--	Type
								</label>
								<select class="form-control" name="typecatagory" id="typecatagory">
									
								<option value="P">
										Postal
									</option>
									<option value="B">
										Board
									</option> -->
								</select>
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>
					<div class="twobox">
						<div class="form-group">
							<textarea name="add_message" id="add_message" class="form-control" placeholder="Message....." style="height: 250px;">
							</textarea>
						</div>
					</div>
					<div class="twobox">
						<div class="twobox_1">
							<i class="fa fa-attach">
							</i>
							Attachment
							<input type="file" name="add_file" id="add_file" />
						</div>
						<div class="twobox_2">
							<div class="email_btns1">
								<button type="button" class="btn btn-danger" data-dismiss="modal">
									Cancel
								</button>
								<button type="save" class="btn btn-primary pull-left save_t">
									Save
								</button>
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>
					<div class="notify_con">
						<h4 class="modal-title">
							Notify Users
						</h4>
						@foreach($username as $key=>$val)
						<div class="notify_users">
							
                            <input type="checkbox" name="notifycheckadd[]" id="notifycheckadd" value="{{ $val['user_id'] }}"/>
						
                        	<label>
								{{ $val['fname'].' '.$val['lname']}}
							</label>
						</div>
						@endforeach
						<!--<div class="notify_users">
						<input type="checkbox"/>
						<label>AA</label>
						</div>
						<div class="notify_users">
						<input type="checkbox"/>
						<label>RK</label>
						</div>
						<div class="notify_users">
						<input type="checkbox"/>
						<label>RK</label>
						</div>-->
						<div class="clearfix">
						</div>
					</div>
					<!-- New popup -->
					<!--<div class="modal-footer clearfix">
					<div class="email_btns">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="save" class="btn btn-primary pull-left save_t">Save</button>
					</div>
					</div>-->
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
	{{ Form :: close() }}
</div>

<div class="modal fade" id="compose-modal1" tabindex="-1" role="dialog" aria-hidden="true">
	{{ Form::open(array('url' => '/edit-notice-template', 'files' => true)) }}
	<input type="hidden" name="edit_notice_template_id" id="edit_notice_template_id1" value=" ">
	<input type="hidden" name="hidd_file" id="hidd_file" value="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">
					Edit Notice
				</h4>
				<div class="clearfix">
				</div>
			</div>
			<form action="#" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="clearfix">
						</div>
					</div>
					<div class="input_dropdown" id="type_dropdown1">
						<!-- <label>
							Type
						</label>
						<select class="form-control" name="typecatagory[]" id="typecatagory1">
							<option value="P">
								Postal
							</option>
							<option value="B">
								Board
							</option> -->
						</select>
					</div>
					<div class="form-group">
						<div class="input_box_g">
							<label for="exampleInputEmail1">
								Subject
							</label>
							<input name="message_subject" id="message_subject1" type="text" class="form-control" value="">
						</div>
						<div class="clearfix">
						</div>
					</div>
					<div class="twobox">
						<div class="form-group">
							<textarea  name="edit_message" id="edit_message1" class="form-control" style="height: 250px;" >
							</textarea>
						</div>
					</div>
					<div class="twobox">
						<div class="twobox_1">
							<i class="fa fa-attach">
							</i>
							Attachment
							<input type="file" name="edit_attach_file" id="edit_attach_file1" />
							<p class="help-block" id="edit_attach_file2"></p>
            
            <?php // foreach($attach as $key=>$attachm)
                //{
                 //echo "<pre>";print_r($attachm->file);
                
                //}
			?>
            
                            <p id="attachdel"></p>
						</div>
						<div class="twobox_2">
							<div class="email_btns1">
								<button type="button" class="btn btn-danger" data-dismiss="modal">
									Cancel
								</button>
								<button type="save" class="btn btn-primary pull-left save_t">
									Save
								</button>
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>
					<div class="notify_con">
						<h4 class="modal-title">
							Notify Users
						</h4>
						<?php 
                        
                       // $i=0; 
                      //  echo '<pre>';
                        //print_r($username);
                        //print_r($font);
                        
                        ?>
							@foreach($username as $key=>$val)
							<?php //$i++; ?>
                                
								<div class="notify_users">
								
                                
                                	<input type="checkbox" class="chknotifys" name="notifychecked[]" id="notifycheck{{ $val['user_id'] }}" value="{{ $val['user_id'] }}" <?php //if($val['user_id']==$check){ checked; } ?> />
                        
                        
                     <input type="hidden" name="chknotify[]" id="chknotify{{ $val['user_id'] }}" value="{{ $val['user_id'] }}" />
							
                     <input type="hidden" name="chknotifychk[]" id="chknotifychknotifychk" value="{{ $val['user_id'] }}" />
                             	
                                	<label>
										{{ $val['fname'].' '.$val['lname']}}
									</label>
								</div>
								@endforeach
                                
                            <?php //echo '<pre>'; print_r($attach); ?>
                                
                                
							<!--	<input type="hidden" id="count_chk" value="<?php //echo $i; ?>"> -->
								
                                <!--<div class="notify_users">
								<input type="checkbox"/>
								<label>AA</label>
								</div>
								<div class="notify_users">
								<input type="checkbox"/>
								<label>RK</label>
								</div>
								<div class="notify_users">
								<input type="checkbox"/>
								<label>RK</label>
								</div>-->
								<div class="clearfix">
								</div>
					</div>
					<!-- New popup -->
					<!--<div class="modal-footer clearfix">
					<div class="email_btns">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="save" class="btn btn-primary pull-left save_t">Save</button>
					</div>
					</div>-->
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
	{{ Form :: close() }}
</div>





<!-- msg popup -->
<div class="modal fade" id="compose-msgmodal" tabindex="-1" role="dialog" aria-hidden="true">

	<input type="hidden" name="edit_notice_template_id" id="edit_notice_template_id1" value=" ">
	<input type="hidden" name="hidd_file" id="hidd_file" value="">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title">
					<!-- FULL msg -->
				</h4>
				<div class="clearfix">
				</div>
			</div>
			<form action="#" method="post">
				<div class="modal-body">
					<div class="form-group">
						<div class="clearfix">
						</div>
					</div>
					
					
					<div class="twobox">
						<div class="form-group">
							<textarea  name="edit_message" id="edit_msgmessage" class="form-control" style="height: 250px;" >
							</textarea>
						</div>
					</div>
					<div class="twobox">
						
						<div class="twobox_2">
							<div class="email_btns1">
								<!-- <button type="button" class="btn btn-danger" data-dismiss="modal">
									Cancel
								</button> -->
								
							</div>
						</div>
						<div class="clearfix">
						</div>
					</div>
					<div class="notify_con">
						<h4 class="modal-title">
							<!-- Notify UserS -->
						</h4>
						
                                                               
							<!--	<input type="hidden" id="count_chk" value="<?php //echo $i; ?>"> -->
								
                                <!--<div class="notify_users">
								<input type="checkbox"/>
								<label>AA</label>
								</div>
								<div class="notify_users">
								<input type="checkbox"/>
								<label>RK</label>
								</div>
								<div class="notify_users">
								<input type="checkbox"/>
								<label>RK</label>
								</div>-->
								<div class="clearfix">
								</div>
					</div>
					<!-- New popup -->
					<!--<div class="modal-footer clearfix">
					<div class="email_btns">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="save" class="btn btn-primary pull-left save_t">Save</button>
					</div>
					</div>-->
				</div>
			</form>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
	
</div>
<!-- msg popup -->
@stop