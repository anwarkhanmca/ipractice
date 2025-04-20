@extends('layouts.layout') 
@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
@stop 

@section('myjsfile')

<script type="text/javascript" src="{{ URL :: asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ URL :: asset('tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ URL :: asset('js/notice_board.js') }}"></script>
<script type="text/javascript" src="{{ URL :: asset('js/fixedsortable.js') }}"></script>
<script type="text/javascript" src="{{ URL :: asset('js/jquery.form.js') }}"></script>

<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- <script src="http://jquery-ui.googlecode.com/svn/tags/latest/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script>
<script src="http://jquery-ui.googlecode.com/svn/tags/latest/ui/minified/i18n/jquery-ui-i18n.min.js" type="text/javascript"></script> -->

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="{{ URL :: asset('js/holiday.js') }}" type="text/javascript"></script>
<script>
$(document).ready(function(){
    $("#holiday_start").datepicker({dateFormat:'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+100"});
    $("#holiday_end").datepicker({dateFormat:'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+100"});
});
</script>
@stop




@section('content')
<input type="hidden" id="noticeMaxLength" value="{{ $noticeMaxLength }}">
<div class="wrapper row-offcanvas row-offcanvas-left">
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="left-side sidebar-offcanvas {{ $left_class }}">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      @include('layouts/inner_leftside')
    </section>
    <!-- /.sidebar -->
  </aside><p style="font-family:arial; font-size:7;"></p>
  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side {{ $right_class }}">
    <!-- Content Header (Page header) -->
    @include('layouts.below_header')
    <!-- Main content -->
  <!--  {{ Form::open(array('url' => '/insert-noticeboard', 'files' => true)) }} -->
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
      <!--  <form> -->
        <div class="tabarea">
          <div class="nav-tabs-custom">
            <div class="notice_board_main">
              <div class="notice_board_tab" id="noticetab">
              <ul>
                <li style="width:20%;" ><a href="/noticeboard/{{ '1' }}" class="{{ ($page_open == 1)?'tab_active':'' }} notice_tabhover">Board 1</a></li>
                <li style="width:20%;" ><a href="/noticeboard/{{ '2' }}" class="{{ ($page_open == 2)?'tab_active':'' }} notice_tabhover">Board 2</a></li>
                <li style="width:30%;" ><a href="/noticeboard/{{ '3' }}" class="{{ ($page_open == 3)?'tab_active':'' }} notice_tabhover">Staff Holidays & Time off</a></li>
                <!-- <li style="width:30%;" ><a href="/staff-holidays/{{ base64_encode('staff') }}/5/{{ base64_encode($start_date) }}" class="notice_tabhover">Staff Holidays & Time off</a></li> -->
                <!-- <li style="width:20%;" ><a href="/noticeboard/{{ '4' }}" class="{{ ($page_open == 4)?'tab_active':'' }} notice_tabhover">Excel Viewer</a></li> -->
                <li style="width:30%;" ><a href="/noticeboard/{{ '5' }}" class="{{ ($page_open == 5)?'tab_active':'' }} notice_tabhover">Share- a- file</a></li>
              </ul>
              </div>
            </div>
            <div class="tab-content" style="padding:10px 0 0 0;">
<div id="step1" class="tab-pane show_div {{ ($page_open == 1)?'active':'' }}">
  
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
<span class="board_title">BOARD 1</span>
<div class="col-xs-12 holidays_border" >

<!--<div class="col-xs-4">
<div class="noticeboard_leftside">
<a href="#" data-toggle="modal" class="add_new">Add New...</a>
</div>


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

</div>-->

<div class="col-xs-12"  style="position: relative;">

<div class="col-xs-4 loop_sec" >
<div class="noticeboard_leftside">
<a href="javascript:void(0)" data-toggle="modal" id="fixed_add" class="add_new"><img src="/img/plus_icon.png"></a>
</div>
</div>
<div  id="sortable" >
@foreach($font as $key=>$val)
<div class="col-xs-4 loop_sec" id="<?php echo $val['noticefont_id']; ?>">

<div class="hvr-grow2 limitboard" id="<?php echo $val['noticefont_id']; ?>">

<div class="holidays_list" id="{{ $val['noticefont_id'] }}"  >
<div  style="cursor:move; width: 100%;" class="holidays_h">{{$val['message_subject'] }}</div>
<div  style="cursor:pointer; overflow:scroll; height: 308px;" >
<?php
$text = $val['message'];
$text = str_replace("<p>" , "<span>" , $text);
$text = str_replace("</p>" , "</span></br>" , $text);
?>
<div class="holidays_content swapboard1" id="body{{ $val['noticefont_id'] }}" onclick="openbodyModal('{{ $val['noticefont_id'] }}')">{{$text}}</div>
<!--
<p class="holidays_content swapboard1" id="body{{ $val['noticefont_id'] }}" onclick="openbodyModal('{{ $val['noticefont_id'] }}')" >
{{$text}} -->
   <!-- {{ (strlen($text) > 625)? substr($text, 0, 625)."...": $text }} -->
</p>
</div>
<div class="clear"></div>

<div class="bottom_content">

        <p class="posted_t">Posted by {{ $userfullname->fname }} {{ $userfullname->lname}} {{ $val['created']}}</p>
        
        <input type="hidden" name="sort_id" id="sort_id" value="{{ $val['sort_id'] }}" />
        
         <input type="hidden" name="noticefont_id" id="noticefont_id" value="{{ $val['noticefont_id'] }}" />
        
        <div class="edit_controlar">
<a  href="javascript:void(0)" data-template_id="{{ $val['noticefont_id'] }}" onclick="openModal('{{ $val['noticefont_id'] }}')"><img src="/img/edit_icon.png"  /></a>

<a href="/delete-template/{{ $val['noticefont_id'] }}" onClick="return delfun()"><img src="/img/cross.png" /></a>
        </div>

        
        <div class="clearfix"></div>
  
</div>
</div>
 
</div></div>
 @endforeach
<!--<div id="console"></div>-->
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
  <!--<div id="step2" class="tab-pane show_div">-->
    <div id="step2" class="tab-pane show_div {{ ($page_open == 2)?'active':'' }}">
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
<span class="board_title">BOARD 2</span>
<div class="col-xs-12 holidays_border" >

<!-- <div class="col-xs-4">
<div class="noticeboard_leftside">
<a href="#" data-toggle="modal" class="add_new2">Add New...</a>
<a href="#" data-toggle="modal" data-target="#compose-modal" class="add_new">Add New...</a> -->
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

</div>-->

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

</div>-->

<div class="col-xs-12" >
<div class="col-xs-4 loop_sec">
<div class="noticeboard_leftside">
<a href="javascript:void(0)" data-toggle="modal" id="fixed_add2" class="add_new2"><img src="/img/plus_icon.png"></a>
</div>
</div>
<div id="sortable2">

@foreach($font2 as $key=>$val2)
<div class="col-xs-4 loop_sec" id="<?php echo $val2['noticefont_id']; ?>">
<div class="staff_left hvr-grow2 limitboard2" id="<?php echo $val2['noticefont_id']; ?>">

<div class="holidays_list" id="dyn">
<div  style="cursor:move; width:100%" class="holidays_h">{{$val2['message_subject'] }}</div>
<div style="cursor:pointer;overflow:scroll; height: 308px;" >

<!--
<p class="holidays_content" id="body{{ $val2['noticefont_id'] }}" onclick="openbodyModal('{{ $val2['noticefont_id'] }}')" >
    {{ (strlen($val2['message']) > 625)? substr(strip_tags($val2['message']), 0, 625)."...": strip_tags($val2['message']) }}
</p>
-->
<?php
$text = $val2['message'];
$text = str_replace("<p>" , "<span>" , $text);
$text = str_replace("</p>" , "</span></br>" , $text);
?>
  <div class="holidays_content swapboard1" id="body{{ $val2['noticefont_id'] }}" onclick="openbodyModal('{{ $val2['noticefont_id'] }}')">{{$text}}</div>
  <!--
  <p class="holidays_content swapboard1" id="body{{ $val2['noticefont_id'] }}" onclick="openbodyModal('{{ $val2['noticefont_id'] }}')" >
      {{ (strlen($text) > 625)? substr($text, 0, 625)."...": $text }}
  </p> -->
  </div>  
  <div class="bottom_content">
    <p class="posted_t">Posted by {{ $userfullname->fname }} {{ $userfullname->lname}} {{ $val2['created']}}</p>
    <div class="edit_controlar">
      <a href="javascript:void(0)" data-template_id="{{ $val2['noticefont_id'] }}" onclick="openModal('{{ $val2['noticefont_id'] }}')"><img src="/img/edit_icon.png"  /></a>
      <a href="/delete-template/{{ $val2['noticefont_id'] }}" onClick="return delfun()"><img src="/img/cross.png" /></a>
    </div>
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
                
<div id="step3" class="tab-pane show_div {{ ($page_open == 3)?'active':'' }}">
@include('notice.includes.staff_holidays')
</div>

<div id="step4" class="tab-pane show_div {{ ($page_open == 4)?'active':'' }}">
<div style="padding-left: 396px;">


          
              <span class="btn btn-default btn-file" style="float:left; margin-right: 10px; width: 80px;"> Browse
                <input type="file" class="staffupload_file" name="stafffile1"  id="stafffile1" >
              
            </span>
            
            
             <span style="float:left; margin-right: 10px;">
    <div class="j_selectbox2" style="width:260px !important;">
    <span>VIEW Excel</span>
    <div class="select_icon" id="select_icon"></div>
    <div class="clr"></div>
    <div class="open_toggle">
      <ul>
       
        <li data-value="non">VIEW Excel 1  <strong style="float: right;"><a href="javascript:void(0)" onclick="return delfun()"><img src="/img/cross.png"></a></strong></li>
        <li data-value="non">VIEW Excel 2 <strong style="float: right;"><a href="javascript:void(0)" onclick="return delfun()"><img src="/img/cross.png"></a></strong></li>
        <li data-value="non">VIEW Excel 3  <strong style="float: right;"><a href="javascript:void(0)" onclick="return delfun()"><img src="/img/cross.png"></a></strong></li>
     
     
      </ul>
    </div>
  </div>
        </span>
             
             <div class="clr"></div>
          
          
          
</div>
<div style="padding-left: 172px;padding-top: 40px;">

 <iframe id="showquoteview" width="900" height="500" src=""></iframe>
</div>

                  <!--end table-->
                
              
                                
                <!-- /.tab-pane -->
              </div>
                            
<div id="step5" class="tab-pane show_div {{ ($page_open == 5)?'active':'' }}">
<div style="padding-left: 396px;">
  {{ Form::open( array('url' => '/excel-upload', 'files' => true,'id'=>'pdfeform1', 'name'=>'pdfeform1')) }}
    <input type="hidden" name="file_type" id="pdf" value="P" />
    <span class="btn btn-default btn-file" style="float:left; margin-right: 10px; width: 80px;"> Browse
    <input type="file" name="add_pdffile1" id="add_pdffile1" data-looper="1"  class="pdf"  />
    </span>
  {{ Form :: close() }}


<span style="float:left; margin-right: 10px;">
    <div class="j_selectbox2" style="width:400px !important;">
    <span>VIEW PDF</span>
    <div class="select_icon" id="select_iconpdf"></div>
    <div class="clr"></div>
 
    <div class="open_toggle">
      <ul>
        @if(!empty($all_pdf))
          @foreach($all_pdf as $key=>$pdffile)
            <li class="delete_{{ $pdffile['noticeexcel_id'] }}">
              <div data-value="non" class="pdfviewclass" id="{{$pdffile['noticeexcel_id']}}" style="float: left;">{{$pdffile['file'] or ""}}</div>
              <strong style="float: right;">
                <a href="javascript:void(0)" data-file_id="{{$pdffile['noticeexcel_id']}}" class="deleteNoticeFiles"><img src="/img/cross.png"></a></strong>
            </li>
        
     @endforeach
     @endif
      </ul>
      
      
      
    </div>
  </div>
        </span>
             
             <div class="clr"></div>
          
          
          
</div>
<div style="padding-left: 172px;padding-top: 40px;text-align: center;" id="show_notice">

 
</div>

                  <!--end table-->
                
              
                                
                <!-- /.tab-pane -->
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

<!-- {{ Form::open(array('url' => '/notice-template', 'files' => true)) }} -->
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
    <!--  <form action="#" method="post"> -->
        
  {{ Form::open( array('url' => '/notice-template', 'files' => true, 'id'=>'upform', 'name'=>'upform', 'onSubmit'=>'return addNotesValidation()')   ) }}

         <div class="show_loader"></div>
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
                  <input type="hidden" name="board_no" id="board_no" value="{{$page_open}}"/>
                  <!--  Type
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
              <textarea name="add_message" id="add_message" class="form-control" maxlength="2" placeholder="Message....." style="height: 250px;">
              </textarea>
            </div>
          </div>
          <div id="character_count">
</div>
          <div class="twobox">
            <div class="twobox_1">&nbsp;
              <!-- <i class="fa fa-attach">
              </i>
              Attachment
              <input type="file" name="add_file" id="add_file" /> -->
            </div>
            <div class="twobox_2">
              <div class="email_btns1">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                  Cancel
                </button>
                <button type="submit" class="btn btn-info pull-left save_t upbutton">
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
              @if($val['fname'] != "" && $val['lname'] != "")
                <div class="notify_users">
                  <input type="checkbox" name="notifycheckadd[]" id="notifycheckadd" value="{{$val['user_id'] }}"/>
                  <label>{{ $val['fname'].' '.$val['lname']}}</label>
                </div>
              @endif
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
                  {{ Form :: close() }}
    <!--  </form> -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>

<div class="modal fade" id="compose-modal1" tabindex="-1" role="dialog" aria-hidden="true">
  {{ Form::open(array('url' => '/edit-notice-template', 'files' => true)) }}
  <input type="hidden" name="edit_notice_template_id" id="edit_notice_template_id1" value=" ">
  <input type="hidden" name="hidd_file" id="hidd_file" value="">
    <input type="hidden" name="editboard_no" id="editboard_no" value="{{$page_open}}"/>
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
            <div class="twobox_1">&nbsp;
              <!-- <i class="fa fa-attach">
              </i>
              Attachment
              <input type="file" name="edit_attach_file" id="edit_attach_file1" />
              <p class="help-block" id="edit_attach_file2"></p> -->
              <!-- <p id="attachdel"></p> -->
            </div>
            <div class="twobox_2">
              <div class="email_btns1">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                  Cancel
                </button>
                <button type="save" class="btn btn-info pull-left save_t">
                  Save
                </button>
              </div>
            </div>
            <div class="clearfix">
            </div>
          </div>
          <div class="notify_con">
            <h4 class="modal-title"> Notify Users </h4>
            @foreach($username as $key=>$val)
              @if($val['fname'] != '' && $val['lname'] != '')
              <div class="notify_users">
                <input type="checkbox" class="chknotifys" name="notifychecked[]" id="notifycheck{{ $val['user_id'] }}" value="{{ $val['user_id'] }}" <?php //if($val['user_id']==$check){ checked; } ?> />
                <input type="hidden" name="chknotify[]" id="chknotify{{ $val['user_id'] }}" value="{{ $val['user_id'] }}" />
               <input type="hidden" name="chknotifychk[]" id="chknotifychknotifychk" value="{{ $val['user_id'] }}" />
                              
                <label> {{ $val['fname'].' '.$val['lname']}} </label>
              </div>
              @endif
            @endforeach
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
        <h4 class="modal-title" id="noticeTitle">
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
              <div id="edit_msgmessage" class="form-control" style="height: 250px; overflow:scroll;" ></div> 
                        <!--
              <textarea  name="edit_message" id="edit_msgmessage" class="form-control" style="height: 250px;" >
              </textarea> 
                            
                            -->
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
            
                                                               
              <!--  <input type="hidden" id="count_chk" value="<?php //echo $i; ?>"> -->
                
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