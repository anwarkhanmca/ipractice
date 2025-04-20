@extends('layouts.layout')

@section('mycssfile')
<!--<link href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />-->
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

<!-- Date picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/jquery-ui.css') }}" />
<!-- Date picker script -->

<!-- Time picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/timepicki.css') }}" />
<!-- Time picker script -->

<!-- Add To Calender Start -->
<link href="{{ URL :: asset('css/atc-style-blue.css') }}" rel="stylesheet" type="text/css">
<!-- Add To Calender End -->    
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/jobs.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/custom_tasks.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="{{ URL :: asset('js/jquery-ui.min.js') }}"></script>
<!-- Date picker script -->

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->

<script src="{{ URL :: asset('js/client_services.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/tasks_tab.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/todolist.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/timesheet.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/client_allocation.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/jtablejs/tasks.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('tinymce/tinymce.min.js') }}"></script>
<!-- page script -->
<script type="text/javascript">
$("#DeadlineDate").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });
$(".addto_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });
$("#edittaskdate").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });
$(".chaserStopCheck").datepicker({dateFormat:'dd-mm-yy', changeMonth:true, changeYear:true});

$(document).ready(function(){
  $('#table_completed').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "iDisplayLength": 25,


    "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true}
    ],
    "aaSorting": [[1, 'asc']]
  });

  window.table = $('#example1').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,
      language: { search: "",searchPlaceholder: "Search..." },
      //"sDom": 'rtlfip',

      "aoColumns":[
          {"bSortable": false},
          {"bSortable": true},
          {"bSortable": false},
          {"bSortable": false},
          {"bSortable": false},
          {"bSortable": true},
          {"bSortable": true},
          {"bSortable": false},
          {"bSortable": false},
          {"bSortable": false}
      ],
      "aaSorting": [[1, 'asc']]
    });
        
});//end document ready

$(window).load(function() {
  tinymce.init({
    selector: "#frequency_message",
    height : "250px",
    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code", "paste code" ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    entity_encoding : 'raw',
    force_br_newlines : true,
    force_p_newlines : false,
    forced_root_block : false
  });
  tinymce.init({
    selector: "#chaser_message",
    height : "250px",
    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code", "paste code" ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    entity_encoding : 'raw',
    force_br_newlines : true,
    force_p_newlines : false,
    forced_root_block : false
  });
});
</script>

<!-- Add to Calender -->
<script type="text/javascript">(function () {
  if (window.addtocalendar)if(typeof window.addtocalendar.start == "function")return;
  if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
      var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
      s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
      //s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
      s.src = '/js/atc.min.js';
      var h = d[g]('body')[0];h.appendChild(s); }})();
</script>

<script>
  $('#calender_time').timepicki({
    show_meridian:false,
    //min_hour_value:0,
    max_hour_value:23,
    //step_size_minutes:15,
    //overflow_minutes:true,
    increase_direction:'up'
    //disable_keyboard_mobile: true
  });

  $('#edittask_time').timepicki({
    show_meridian:false,
    max_hour_value:23,
    increase_direction:'up'
  });
</script>

@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas {{ $left_class }}">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            @include('layouts.inner_leftside')
        </section>
        <!-- /.sidebar -->
    </aside>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side {{ $right_class }}">
  <!-- Content Header (Page header) -->
    @include('layouts.below_header')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="practice_hed">
        <div class="top_bts" style="width: 41%;">
          <ul style="padding-left: 0px;">
            <!-- <li>
              <a href="javascript:void(0)" id="test" class="btn btn-success">test</a>
            </li> -->
            <!-- <li>
              <a href="/ct/download/{{$service_id}}/{{ base64_encode($page_open) }}/{{ base64_encode($staff_id) }}/pdf" class="btn btn-success"><i style="padding-right: 4px;" class="fa fa-download"></i> Generate PDF</a>
            </li>
            <li>
              <a href="/ct/download/{{$service_id}}/{{base64_encode($page_open)}}/{{ base64_encode($staff_id)}}/excel" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</a>
            </li> -->

            <li>
              <a href="#" class="btn btn-success"><i style="padding-right: 4px;" class="fa fa-download"></i> Generate PDF</a>
            </li>
            <li>
              <a href="#" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</a>
            </li>
            <li style="font-size: 18px; float: left"><a href="javascript:void(0)" class="clockPop" style="float: left;"><img src="/img/icon_clock.png" height="32" style="margin-right: 5px;"><span style="color: #00c0ef; margin-top: 5px;">Client Reminders!</span></a></li>
            <div class="clearfix"></div>
          </ul>
        </div>

        <div style="float: left; width:59%;">
          <table width="100%">
            <tr>
            @if($page_open == 1)  
              <td width="9%" class="head_txt">Add to List</td>

              <td width="12%" class="head_txt">
                <select class="form-control newdropdown" id="select_client_type">
                  <option value="">Client Type</option>
                  <option value="org">Organisation</option>
                  <option value="ind">Individual</option>
                </select>
              </td>
              <td width="1%">&nbsp;</td>
              <td width="24%" class="head_txt">
                <div style="position: relative;">
                <div class="nt_selectbox">
                  <span>Select 1 or more clients</span>
                  <div class="icon avoid-clicks" id="select_icon"></div>
                  <div class="clr"></div>
                  <div class="open_toggle" style="top:23px;">
                    <input type='text' class="email_top search_text" id='search_text'/>
                    <ul class="document_ul" id="clients_list">
                      <!-- Ajax Call -->
                    </ul>
                  </div>
                </div>
                </div>
              </td>
              <td width="1%">&nbsp;</td>
            @else
              <td width="45%">&nbsp;</td>
            @endif

            @if($page_open != 3)
              <td width="11%" class="head_txt">Filter By Staff <!-- <a href="/client-list-allocation/0/b3Jn"><i class="fa fa-cog fa-fw settings_icon"></i></a> --></td>
              <td width="16%">
                <select class="form-control newdropdown search_by_staff" id="search_by_staff">
                  <option value="{{ base64_encode('all') }}" {{ (isset($staff_id) && $staff_id == 'all')?"selected":"" }}>Show All</option>
                  @if(!empty($staff_details))
                    @foreach($staff_details as $key=>$staff_row)
                      <option value="{{ base64_encode($staff_row['user_id']) }}" {{ (isset($staff_id) && $staff_id == $staff_row['user_id'])?"selected":"" }}>{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                    @endforeach
                  @endif
                  <option value="{{ base64_encode('none') }}" {{ (isset($staff_id) && $staff_id == 'none')?"selected":"" }}>Unassigned</option>
                </select>
              </td>
            @endif
            </tr>
          </table>
           <div class="clearfix"></div>
        </div>
       
        <div id="message_div"><!-- Loader image show while sync data --></div>
      </div>

  </div>

  <div class="practice_mid">
    <input type="hidden" id="service_id" value="{{ $service_id or "" }}">
    <input type="hidden" id="page_open" value="{{ $page_open or "" }}">
    <input type="hidden" id="step_id" value="{{ $step_id or "" }}">
    <input type="hidden" id="goto_url" value="{{ $goto_url or "" }}">
    <input type="hidden" id="encode_page_open" value="{{ $encode_page_open or "" }}">
    <input type="hidden" id="encode_staff_id" value="{{$encode_staff_id or ""}}">
    <input type="hidden" id="encode_org_client" value="{{ base64_encode('org_client') }}">
    <input type="hidden" id="client_id" value="">
    <input type="hidden" id="job_manage_id" value="" />
    <input type="hidden" id="service_name" value="{{ $title or "" }}">
    <input type="hidden" id="admin_name" value="{{ $admin_name }}" />
    <input type="hidden" id="logged_email" value="{{ $logged_email }}" />
    <input type="hidden" id="headfield1" value="{{ $headfield1 or "" }}">
    <input type="hidden" id="headfield2" value="{{ $headfield2 or "" }}">
    <input type="hidden" id="field1" value="{{ $field1 or "" }}">
    <input type="hidden" id="field2" value="{{ $field2 or "" }}">


    <div class="tabarea">


    <ul class="nav nav-tabs nav-tabsbg">
        <li class="{{ ($page_open == 1)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('1') }}/{{ base64_encode($staff_id) }}/{{$field1}}/{{$field2}}">CLIENT DETAILS <!-- [<span id="task_count_1">{{ $all_count or '0' }}</span>] --></a></li>
        <li class="{{ ($page_open == 2)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('2') }}/{{ base64_encode($staff_id) }}/{{$field1}}/{{$field2}}">TASKS</a></li>
        <li class="{{ ($page_open == '3')?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('3') }}/{{ base64_encode($staff_id) }}/{{$field1}}/{{$field2}}"><span id="step_field_completed">COMPLETED TASKS</span></a></li>
    
      </ul>


    @if($page_open == 2)
      <!-- <ul class="nav nav-tabs nav-tabsbg" style="margin-top: 10px">
        <li class="{{ ($page_open == 2)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('2') }}/{{ base64_encode($staff_id) }}/{{$field1}}/{{$field2}}">Not Started [<span id="task_count_22">{{ (isset($not_started_count) && $not_started_count >0 )?$not_started_count:"0" }}</span>]</a></li>
        @if(isset($jobs_steps) && count($jobs_steps) >0)
          <?php $i = 3;?>
            @foreach($jobs_steps as $key=>$value)
              <li class="header_step_{{ $value['step_id'] }} {{ ($page_open == '2'.$i)?'active':'' }}" style="display: {{ ($value['status'] == 'H')?'none':'block' }}"><a href="{{ $goto_url }}/{{ base64_encode('2'.$i) }}/{{ base64_encode($staff_id) }}/{{$field1}}/{{$field2}}"><span id="step_field_{{ $value['step_id'] }}">{{ $value['title'] or "" }}</span> [<span id="task_count_2{{ $value['step_id'] }}">{{ $value['count'] or "0" }}</span>]</a></li>
              <?php $i++;?>
            @endforeach
        @endif
      </ul> -->
    @endif

    <div class="tab-content">
    @include('../jobs/custom_tasks/tab')
    </div>
    </div>
    </div>

    </section>


    </aside><!-- /.right-side -->



    <!-- COMPOSE MESSAGE MODAL -->
    <div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">ADD NEW FIELD</h4>
    <div class="clearfix"></div>
    </div>
    {{ Form::open(array('url' => '', 'id'=>'field_form')) }}
    <div class="modal-body">
    <table class="table table-bordered table-hover dataTable add_status_table">
    <thead>
      <tr>
        <th align="center" width="20%">Show/Unshow</th>
        <th >Status Name</th>
        <th align="center">Action</th>
      </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($jobs_steps) && count($jobs_steps) >0)
        @foreach($jobs_steps as $key=>$value)
          <tr id="change_status_tr_{{ $value['step_id'] or "" }}">
            <td align="center"><input type="checkbox" id="step_check_2{{ $value['step_id']}}" class="status_check" {{ ($value['status'] == "S")?"checked":"" }} value="{{ $value['step_id'] or "" }}" data-step_id="{{ $value['step_id'] }}" {{ ((isset($value['count']) && $value['count'] !=0) || $value['step_type'] == 'filed')?"disabled":"" }} /></td>
            <td><span id="status_span{{ $value['step_id'] or "" }}">{{ $value['title'] or "" }}</span></td>
            <td align="center"><span id="action_{{ $value['step_id'] or "" }}"><a href="javascript:void(0)" class="edit_status" data-step_id="{{ $value['step_id'] or "" }}"><img src="/img/edit_icon.png"></a></span></td>
          </tr>
        @endforeach
      @endif

    </tbody>

    </table>


    </div>
    {{ Form::close() }}
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>

    <!-- Notes modal start -->
    <div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:510px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">SAVE NOTES</h4>
    <div class="clearfix"></div>
    </div>

    <div class="modal-body">
    <input type="hidden" id="notes_client_id" name="notes_client_id">
    <input type="hidden" id="notes_manage_id" name="notes_manage_id">
    <input type="hidden" id="notes_tab" name="notes_tab">
    <table width="100%">
      <tr>
        <td align="left" width="15%"><strong>Notes : </strong></td>
        <td align="left">
          <textarea cols="56" rows="4" id="notes" name="notes" class="form-control"></textarea>
        </td>
      </tr>

      <tr>
        <td align="left">&nbsp;</td>
        <td align="left">&nbsp;</td>
      </tr>

      <tr>
        <td align="left">&nbsp;</td>
        <td align="right"><button type="button" class="btn btn-info save_notes">Save</button></td>
      </tr>
    </table>


    </div>

    </div>
    </div>
    </div>        
    <!-- Notes modal end -->

    <!-- Job start date modal start -->
    <div class="modal fade" id="addto_calender-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:410px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">ADD JOB START DATE</h4>
    <div class="clearfix"></div>
    </div>

    <div class="modal-body">
    <div id="start_date_loader" style="text-align: center; padding-bottom: 10px;"><!-- Show loader --></div>
    <input type="hidden" id="calender_client_id" name="calender_client_id">
    <input type="hidden" id="calender_tab" name="calender_tab">
    <table>
      <tr>
        <td align="left" width="20%">&nbsp;</td>
        <td align="left" width="20%"><strong>Date : </strong></td>
        <td align="left"><input id="calender_date" name="calender_date" class="form-control addto_date"></td>
      </tr>
      <tr>
        <td align="left" colspan="3">&nbsp;</td>
      </tr>

      <tr>
        <td align="left" width="20%">&nbsp;</td>
        <td align="left" width="20%"><strong>Time : </strong></td>
        <td align="left"><input id="calender_time" name="calender_time" class="form-control"></textarea></td>
      </tr>

      <tr>
        <td align="left" colspan="3">&nbsp;</td>
      </tr>

      <tr>
        <td align="left" colspan="2" width="20%"></td>
        <td align="right"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-info save_job_start_date">Save</button></td>
      </tr>
    </table>


    </div>

    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>        
    <!-- Notes modal start -->

    <!-- Auto send modal start -->
    <div class="modal fade" id="auto_send-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:370px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"></h4>
    <div class="clearfix"></div>
    </div>

    <div class="loader_show"></div>
    <div class="modal-body">
    <div class="form-group">
        <div class="tab_topcon">
          <div class="send_task auto_send" style="padding:10px 10px;">
            <div style="width:73%; float:left;">Auto send to task management</div> 
            <div style="float:left;"><input type='checkbox' id="manage_check" {{ (isset($autosend['days']) && $autosend['days'] != "")?"checked":"" }} value='1'/></div>
            <!-- <div class="chk_cont01">

              <label for="manage_check"> Auto Send To Task </label></div> 
                <div class="chk_cont02"><input type="text" name="dead_line" id="dead_line" style="width:18%; padding: 0; text-align: center; height: 19px;" value="{{ $autosend['days'] or "" }}" /> <label for="" style="width:0px;"> Days Before Deadline </label></div>
          </div> -->
          <div class="clearfix"></div>
        </div>     
    </div>

    <div class="auto_modal_footer clearfix">
      <div class="email_btns">
        <!-- <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-info pull-left save_t2" data-client_type="org" id="manage_check" name="save">Save</button> -->
      </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- Auto send modal end -->

    <!-- Job start date modal start -->
    <div class="modal fade" id="job_start_date-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:400px;">
    <div class="modal-content">
    <div class="loader_show"></div>
    <div class="modal-body">
    <div class="form-group">
        <div class="tab_topcon">
          <div class="send_task job_start_date">
            <div class="jsd_cont01">
              <label for="manage_check"> Auto Set Job Start Date at SEND Date Plus </label></div> 
            <div class="jsd_cont02"><input type="text" name="job_start_date" id="job_start_date" style="width:40%; padding: 0; text-align: center; height: 19px;" value="{{ (isset($jobs_start_days) && $jobs_start_days != "")?$jobs_start_days:"" }}" /> Days</div>
          </div>
          <div class="clearfix"></div>
        </div>     
    </div>

    <div class="auto_modal_footer clearfix" style="margin-right: 22px;">
      <div class="email_btns">
        <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-info pull-left save_t2" id="jsd_save">Save</button>
      </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    <!-- Job start date modal end -->

    <!-- Email Client modal start -->
    <div class="modal fade" id="email_client-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:515px;">
    <div class="modal-content">
    <div class="loader_show"></div>
    <div class="modal-body">
    <div class="form-group">
        <div class="tab_topcon">
          <div class="email_client">
            <div class="days_count">
              <label for="manage_check" class="auto_t">Auto Send</label>
                <select class="form-control newdropdown float_c" id="email_tmplt_id">
                  @if(isset($email_templates) && count($email_templates) >0)
                    @foreach($email_templates as $key=>$temp_row)
                      <option value="{{ $temp_row['email_template_id'] or "" }}" {{ (isset($email_clients['template_id']) && $email_clients['template_id'] == $temp_row['email_template_id'])?"selected":"" }}>{{ $temp_row['name'] or "" }}</option>
                    @endforeach
                  @endif
                </select>
               <div class="days_box"><input type="text" id="email_days" class="small_box" value="{{ (isset($email_clients['days']) && $email_clients['days'] != "")?$email_clients['days']:"" }}" /> </div>
                <label for="" class="auto_t"> Days</label>
                <select class="form-control newdropdown deadline_box" id="email_deadline">
                  <option value="before" {{ (isset($email_clients['deadline']) && $email_clients['deadline'] == "before")?"selected":"" }}>Before</option>
                  <option value="after"{{ (isset($email_clients['deadline']) && $email_clients['deadline'] == "after")?"selected":"" }}>After</option>
                </select>
                <label for="manage_check" class="auto_t">deadline date</label>

            </div> 

          </div>

          <div class="email_client">
            <div class="days_count">
              <label for="manage_check" class="auto_t">Remind Client Every</label>
              <div class="days_box"><input type="text" name="remind_days" id="remind_days" class="small_box" value="{{ (isset($email_clients['remind_days']) && $email_clients['remind_days'] != "")?$email_clients['remind_days']:"" }}" /></div>
                <label for="" class="auto_t"> Days after email date</label>
            </div> 

          </div>


          <div class="clearfix"></div>
        </div>     
    </div>

    <div class="auto_modal_footer clearfix" style="margin-right: 5px;">
      <div class="email_btns">
        <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-info pull-left save_t2" id="save_send_email">Save</button>
      </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    <!-- Email Client modal end -->

    <!-- Send Template modal start -->
    <div class="modal fade" id="send_template-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">SEND EMAIL TEMPLATE</h4>
    <div class="clearfix"></div>
    </div>

    {{ Form::open(array('url' => '/jobs/save-jobs-email', 'enctype'=> 'multipart/form-data')) }}
    <input type="hidden" name="template_client_id" id="template_client_id">
    <input type="hidden" name="template_id" id="template_id">
    <input type="hidden" name="goto_url" value="{{ $goto_url }}">
    <input type="hidden" name="encode_page_open" value="{{ $encode_page_open }}">
    <input type="hidden" name="encode_staff_id" value="{{ $encode_staff_id }}">
    <div class="modal-body">
    <div class="form-group" style="margin-bottom: 0px;">
      <div style="margin-left: 200px;">
        <strong>Repeat Every</strong> <input style="width:50px" type="text" id="repeat_days" name="repeat_days" class="remindevery"> <strong>Days</strong>
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="form-group">
      <div class="input_box_g">
        <label for="exampleInputEmail1">Template Name</label>
        <input type="text" class="form-control" name="template_name" id="template_name" placeholder="Template Name">
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="form-group">
      <div class="input_box_g">
        <label for="exampleInputEmail1">Message Subject</label>
        <input type="text" name="template_subject" id="template_subject" class="form-control" placeholder="Message Subject">
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="form-group">
      <textarea name="template_message" id="template_message" class="form-control" placeholder="Message" style="height: 250px;"></textarea>
      <div class="clearfix"></div>
    </div>

    <div class="form-group new_temp">                                
        <div class="btn-file search_t">
            <!-- <i class="fa fa-paperclip"></i> --> Attachment
            <input type="file" name="template_file" id="template_file">
        </div>
        <!-- <p class="help-block">Max. 32MB</p> -->
        <div class="clearfix"></div>
    </div>

    <div class="form-group">
      <table class="table table-bordered" id="send_email_tick">

      </table>
      <!-- <div class="clearfix"></div> -->
    </div>

    </div>

    <div class="modal-footer clearfix" style="border-top: none; padding-top: 0; margin-top: 0px;">
    <!-- <div class="form-group new_temp">                                
        <div class="btn-file search_t">
            <i class="fa fa-paperclip"></i> Attachment
            <input type="file" name="add_file" id="add_file">
        </div>
        <p class="help-block">Max. 32MB</p>
    </div> -->
    <div class="email_btns">
      <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
      <button type="submit" class="btn btn-info pull-left save_t2 save_jobs_email">Save</button>
    </div>
    </div>
    {{ Form::close() }}
    </div>
    </div>
    </div>
    <!-- Send Template modal end -->

    <!-- Enter Email Address modal start -->
    <div class="modal fade" id="enter_email-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header" style="border-bottom: none; padding-bottom: 0">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
    <!-- <h4 class="modal-title">ENTER EMAIL ADDRESS</h4> -->
    <div class="clearfix"></div>
    </div>

    <div class="loader_show"></div>

    <div class="modal-body">
    <div class="enter_email_box">
      <table>
        <tr>
          <td width="60%"><h4 class="modal-title">ENTER EMAIL ADDRESS</h4></td>
          <td class="stop_email">Stop Email Reminders</td>
          <td><input type='checkbox'></td>
        </tr>
      </table>


      <table width="100%" class="table table-bordered" style="margin-top: 10px;">
        <tbody>
          <tr>
            <td width="6%">&nbsp;</td>
            <td width="47%" align="center"><strong>Contact Name</strong></td>
            <td width="47%" align="center"><strong>Email Address</strong></td>
          </tr>

          <tr id="database_tr145">
            <td><a href="javascript:void(0)" class="delete_database_rel"><img src="/img/cross_icon.png" height="15"></a></td>
            <td align="center"><input type="text" class="form-control" placeholder="Search"></td>
            <td align="center"><input type="text" class="form-control"></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="modal-footer clearfix" style="padding: 10px 0 0; border-top: none;">
    <div class="form-group new_temp">                                
        <button type="button" class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new</p></button>
    </div>
    <div class="email_btns">
      <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
      <button type="button" class="btn btn-info pull-left save_t2">Save</button>
    </div>


    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- Enter Email Address modal end -->

    <!-- Job start date modal start -->
    <div class="modal fade" id="sign_off_date-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:250px;">
    <div class="modal-content">
    <div class="modal-header" style="border-bottom: none; padding-bottom: 0">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title">ADD SIGN OFF DATE</h4>
    <div class="clearfix"></div>
    </div>

    <div class="loader_class"></div>
    <div class="modal-body">
    <input type="hidden" id="sod_client_id">
    <input type="hidden" id="sod_client_type">
    <input type="hidden" id="sod_data_type" value="sign_off_date">
    <div class="form-group">
      <label for="manage_check">Day</label>
      <select class="form-control" id="sod_day">
        @for($i = 1;$i<=31;$i++)
        <option value="{{ ($i<10)?'0'.$i:$i }}">{{ ($i<10)?'0'.$i:$i }}</option>
        @endfor
      </select>
      <div class="clearfix"></div>
    </div>

    <div class="form-group">
      <label for="manage_check">Month</label>
      <select class="form-control" id="sod_month">
        @if(isset($months) && count($months)>0)
          @foreach($months as $key=>$month)
          <option value="{{ $key }}">{{ $month }}</option>
          @endforeach
        @endif
      </select>
      <div class="clearfix"></div>
    </div>

    <div class="auto_modal_footer clearfix" style="margin-right: 22px;">
      <div class="email_btns">
        <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-info pull-left save_t2" id="sod_save">Save</button>
      </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    <!-- Job start date modal end -->

    <!-- TAX RETURN PERIOD MODAL START -->
    <div class="modal fade" id="tax_return-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">ADD/EDIT TAX RETURN PERIOD</h4>
    <div class="clearfix"></div>
    </div>

    <div class="modal-body">
    <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
    <input type="hidden" id="tax_client_id" name="tax_client_id">
    <input type="hidden" id="tax_data_type" name="tax_data_type" value="tax_return_start">
    <input type="hidden" id="tax_action" name="tax_action">
    <div class="form-group">
      <label for="exampleInputPassword1">start date</label>
      <input type="text" id="pop_tax_start" name="pop_tax_start" class="form-control">
      <div class="clearfix"></div>
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">End date</label>
      <input type="text" id="pop_tax_end" name="pop_tax_end" class="form-control">
      <div class="clearfix"></div>
    </div>
    </div>

    <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
    <div class="email_btns">
      <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
      <button type="button" id="save_tax_return" class="btn btn-info pull-left save_t2">Save</button>
    </div>
    </div>

    </div>
    </div>
    </div>        
    <!-- TAX RETURN PERIOD MODAL END -->

    <!-- JOB FREQUENCY MODAL START -->
    <div class="modal fade" id="job_freq-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">JOB FREQUENCY TEMPLATE</h4>
    <div class="clearfix"></div>
    </div>
    <input type="hidden" id="freq_client_id" name="freq_client_id">
    <div class="modal-body">
    <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
    <div class="form-group">
      <div style="float:left;width:80px; margin: 5px 15px 0 0;font-weight:bold">Repeat Every </div>
      <div style="float:left;width:40px; margin-right: 15px;"><input type="text" id="repeat_day" name="repeat_day" class="form-control" style="width:40px;"></div>
      <div style="float:left;width:50px; margin: 5px 0 0 0;font-weight:bold">Day(s)</div>
      <!-- <div style="float:left;width:40px; margin-right: 15px">
        <input type="text" id="repeat_no" name="repeat_no" class="form-control">
      </div>
      <div style="float:left;width:200px;">
        <select class="form-control" id="repeat_day" name="repeat_day">
          <option value="Day(s)">Day(s)</option>
          <option value="Week(s)">Week(s)</option>
          <option value="Month(s)">Month(s)</option>
        </select>
      </div> -->
    </div>

    <div style="float:left;width:200px; margin-right: 15px">
    <div class="form-group">
      <label for="exampleInputPassword1">First Due Date</label>
      <input type="text" id="first_due_date" name="first_due_date" class="form-control">
      </div>
    </div>

    <div style="float:left;width:40px;">
    <div class="form-group">
      <label for="exampleInputPassword1">Hrs/Wk</label>
      <input type="text" id="hrs_wk" name="hrs_wk" class="form-control">
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="form-group">
      <label for="exampleInputPassword1">End Date (Optional)</label>
      <input type="text" id="end_date_opt" name="end_date_opt" class="form-control">
    </div>

    </div>

    <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
    <div class="email_btns">
      <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
      <button type="button" id="save_job_freq" class="btn btn-info pull-left save_t2">Save</button>
    </div>
    </div>

    </div>
    </div>
    </div>        
    <!-- JOB FREQUENCY MODAL END -->

    <!-- JOB SEND MODAL START -->
    <div class="modal fade" id="job_send_pop-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"></h4>
    <div class="clearfix"></div>
    </div>

    <div class="modal-body">
    <input type="hidden" id="last_month">
    <input type="hidden" id="last_year">
    <div class="loader_show"></div>
    <div class="form-group">
    <table id="vat_send_div">

    </table>
    </div>
    <div class="clearfix"></div>
    </div>

    <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
    <div class="email_btns">
      <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
      <button type="button" id="send_jobs_to_task" class="btn btn-info pull-left save_t2">OK</button>
    </div>
    </div>

    </div>
    </div>
    </div>        
    <!-- JOB SEND MODAL END -->

    <!-- TAX YEAR MODAL START -->
    <div class="modal fade" id="taxyear_pop-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:315px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title"></h4>
    <div class="clearfix"></div>
    </div>

    <div class="modal-body">
    <div class="loader_show"></div>
    <div class="form-group">
      <input type="hidden" id="send_type">
    <table>
      <tr>
        <td width="37%"><strong>Select Tax Year</strong></td>
        <td id="income_send_div"></td>
      </tr>
    </table>
    </div>
    <div class="clearfix"></div>
    </div>

    <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
    <div class="email_btns">
      <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
      <button type="button" id="save_send_popup" class="btn btn-info pull-left save_t2">SEND</button>
    </div>
    </div>

    </div>
    </div>
    </div>        
    <!-- TAX YEAR MODAL END -->

    <!-- TAX YEAR MODAL START -->
    <div class="modal fade" id="audit_pop-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:250px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">PERIOD END</h4>
    <div class="clearfix"></div>
    </div>

    <div class="modal-body">
    <div class="loader_show"></div>
    <div class="form-group">
      <input type="text" id="period_end" name="period_end" class="form-control">
    </div>
    <div class="clearfix"></div>
    </div>

    <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
    <div class="email_btns">
      <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
      <button type="button" id="send_audits_popup" class="btn btn-info pull-left save_t2">SEND</button>
    </div>
    </div>

    </div>
    </div>
    </div>        
    <!-- TAX YEAR MODAL END -->

    <!-- AUDITS COMPLETION DATE MODAL START -->
    <div class="modal fade" id="audit_completion-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:250px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">COMPLETION DATE</h4>
    <div class="clearfix"></div>
    </div>

    <div class="modal-body">
    <div class="loader_show"></div>
    <div class="form-group">
      <input type="text" id="completion_date" name="completion_date" class="form-control">
    </div>
    <div class="clearfix"></div>
    </div>

    <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
    <div class="email_btns">
      <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
      <button type="button" id="save_completion_popup" class="btn btn-info pull-left save_t2">SEND</button>
    </div>
    </div>

    </div>
    </div>
    </div>        
    <!-- AUDITS COMPLETION DATE MODAL END -->

    <!-- ADD TABLE HEADING MODAL START -->
    <div class="modal fade" id="add_heading-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title">ADD/EDIT HEADING</h4>
    <div class="clearfix"></div>
    </div>

    <div class="modal-body">
    <input type="hidden" id="pop_heading_id" value="0">
    <div class="loader_show"></div>
    <div class="form-group">
      <label for="exampleInputPassword1">Field Name</label>
      <input type="text" id="heading" name="heading" class="form-control">
    </div>

    <div class="form-group">
      <label for="exampleInputPassword1">Field Type</label>
      <select class="form-control user_field_type" id="field_type" name="field_type">
        <option value="1">Text</option>
        <option value="4">Dropdown</option>
        <option value="5">Date</option>
      </select>
    </div>
    <div class="form-group" style="display:none;" id="show_select_option">
      <label for="exampleInputPassword1">Options</label>
      <textarea id="select_option" cols="35" rows="3"></textarea>
      Give options width ',' separator
    </div>
    <div class="clearfix"></div>
    </div>

    <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
    <div class="email_btns">
      <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
      <button type="button" id="save_heading_popup" class="btn btn-info pull-left save_t2">Save</button>
    </div>
    </div>

    </div>
    </div>
    </div>        
    <!-- ADD TABLE HEADING MODAL END -->

    <!-- Edit Task Name -->
    <div class="modal fade" id="edit_task-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" style="width:300px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Edit Task Name</h4>
            <div class="clearfix"></div>
          </div>

          <div class="modal-body">
            <div class="loader_show"></div>
            <div class="form-group">
              <label for="Taskname">Task Name</label>
              <input type="text" id="task_name" name="task_name" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="modal-footer clearfix" style="border-top: none; padding-top: 0; margin-top: 0">
            <div class="email_btns">
              <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
              <button type="button" id="save_task_popup" class="btn btn-info pull-left save_t2">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div> 
    
    @include('../../jobs/includes/modal_popup')

    @include("home.include.services_modal")

    @include("staff.timesheet.includes.timesheet_popup")
    
    @include("settings.include.allocation_modal")
    
@stop



