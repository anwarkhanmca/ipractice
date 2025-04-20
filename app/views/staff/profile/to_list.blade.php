@extends('layouts.layout')

@section('mycssfile')
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

<!-- Editor -->
<link rel="stylesheet" type="text/css" href="{{ URL :: asset('classy-editor/css/jquery.classyedit.css') }}" />

@stop

@section('myjsfile')

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->
<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/jquery.quicksearch.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<!-- page script -->

<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<!-- <script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script> -->
<script src="{{ URL :: asset('js/jquery.price_format.2.0.js') }}" type="text/javascript"></script>

<!-- page script -->
<script src="{{ URL :: asset('js/todolist.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/jtablejs/todo_list.js') }}" type="text/javascript"></script>

<script type="text/javascript">
$(function() {
  $("#taskdate").datepicker({dateFormat: 'dd-mm-yy'});
  $("#edittaskdate").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-5:+100" });
  $("#calender_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-5:+100" });
});
$('#task_time').timepicki({
  show_meridian:false,
  max_hour_value:23,
  increase_direction:'up'
});

$('#edittask_time').timepicki({
  show_meridian:false,
  max_hour_value:23,
  increase_direction:'up'
});


var Table1, Table2;
$(function() {
  Table1 = $('#example1').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
    "iDisplayLength": 50,
    "language": {
      "lengthMenu": "Show _MENU_ entries",
      "zeroRecords": "Nothing found - sorry",
      "info": "Showing page _PAGE_ of _PAGES_",
      "infoEmpty": "No records available",
      "infoFiltered": "(filtered from _MAX_ total records)"
    },

    "aoColumns":[
      {"bSortable": false},

      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": false},
      {"bSortable": false},
      {"bSortable": false}
    ]

  });
  Table1.fnSort( [ [2,'asc'] ] );

  Table2 = $('#example2').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
            {"bSortable": false},

            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });


   Table2.fnSort( [ [2,'asc'] ] );

});

</script>

<!-- Add to Calender -->
<script type="text/javascript">
(function () {
  if (window.addtocalendar)if(typeof window.addtocalendar.start == "function")return;
  if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
      var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
      s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
      //s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
      s.src = '/js/atc.min.js';
      var h = d[g]('body')[0];h.appendChild(s); }})();
</script>
<!-- Add to Calender -->
<script type="text/javascript">
$('#calender_time').timepicki({
  show_meridian:false,
  max_hour_value:23,
  increase_direction:'up'
});
</script>

<!-- Editor -->
<script src="{{ URL :: asset('classy-editor/js/jquery.classyedit.js') }}"></script>

@stop

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
    <section class="content">
      <div class="practice_mid">
        <form>
          <div class="top_buttons">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="30%"><div class="top_bts">
                    <ul>
                 <!--     <li>
                        <button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
                      </li> -->
                      <li>
                       <a href="/pdfpendingtask/{{ base64_encode($page_open) }}" class="btn btn-success" style=""><i class="fa fa-download"></i> Generate PDF</a>
                      </li>
                      <li>
                       <a href="/excelpendingtask/{{base64_encode($page_open)}}" class="btn btn-primary" style=""><i class="fa fa fa-file-text-o"></i> Excel</a>
                      </li>
                      <div class="clearfix"></div>
                    </ul>
                  </div>
                </td>
                <td width="30%">
                  <div class="center">Add tasks to your todo list by sending emails to this address</div>
                  <div class="center"><a href="javascript:void(0)">{{$todo_email or ''}}</a></div>
                </td>
                <td width="20%">&nbsp;</td>
                <td width="10%"><a href="javascript:void(0)" class="btn btn-default taskViaemail"><span class="requ_t">Add Tasks Via Email</span></a></td>
                <td width="2%">&nbsp;</td>
                <td width="5%"><a href="javascript:void(0)" class="btn btn-default tasknamed" data-taskid="0"><span class="requ_t">New Task</span></a></td>
              </tr>
            </table>
          </div>
          <div class="tabarea">
            <div class="nav-tabs-custom">

            <!--
              <ul class="nav nav-tabs nav-tabsbg">
                <li class="active"><a data-toggle="tab" href="#tab_1">Pending Tasks</a></li>
                <li><a data-toggle="tab" href="#tab_2">Closed Task</a></li>
              </ul>

                -->
<input type="hidden" id="tab_no" value="{{ $page_open }}">      
<ul class="nav nav-tabs nav-tabsbg">
  <li class="{{ ($page_open == 11 || $page_open == 12 || $page_open == 13 || $page_open == 14 || $page_open == 15 || $page_open == 16)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('11') }}">Pending Tasks</a></li>
  <li class="{{ ($page_open == 2)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('2') }}">Closed Task</a></li>
</ul>
<div class="tab-content">




  <div id="tab_1" class="tab-pane {{ ( $page_open == 11)?'active':'' }}">
    <div class="row">
      <div class="col-xs-6"></div>
      <div class="col-xs-6"></div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="row bottom_space">
          <div class="col-xs-6">
            <!-- <div class="dataTables_length" id="example2_length">
              <div style="float: left; margin-right: 5px;">TimeLine</div> 

              <div class="btn-group" style="float: left;" id="wipActionDrop">
                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                  <li class="{{ ($page_open == 11)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('11') }}">Due Today</a></li>
                  <li class="{{ ($page_open == 12)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('12') }}">Due in 7 Days</a></li>
                  <li class="{{ ($page_open == 13)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('13') }}">Due in 30 Days</a></li>
                  <li class="{{ ($page_open == 14)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('14') }}">Due in 3 Months</a></li>
                  <li class="{{ ($page_open == 15)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('15') }}">Due in 6 Months</a></li>
                  <li class="{{ ($page_open == 16)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('16') }}">Due After 6 Months</a></li>
                </ul>
              </div>
            </div> -->
            <select class="form-control tableSearch" id="todoSearchDrop" style="padding-top: 4px;">
              @if(isset($timelines) && count($timelines) >0)
                @foreach($timelines as $k=>$v)
                  <option value="{{ $k+1 }}">{{ $v['name'] or '' }} [{{ $v['count'] or '0' }}]</option>
                @endforeach
              @endif
              <!-- <option value="1">Due Today [0]</option>
              <option value="2">Due in 7 Days [0]</option>
              <option value="3">Due in 30 Days [0]</option>
              <option value="4">Due in 3 Months [0]</option>
              <option value="5">Due in 6 Months [0]</option>
              <option value="6">Due After 6 Months [0]</option>
              <option value="7">Over Due [0]</option> -->
            </select>
          </div>
          <div class="col-xs-6">
            <div id="example2_filter" class="dataTables_filter">
              <form>
                <input type="text" name="todoSearchText" id="todoSearchText" placeholder="Search" class="tableSearch">
                <button type="submit" id="todoSearchButton" style="display: none;">Search</button>
              </form>
            </div>
          </div>
        </div>
        <div id="todoTable"></div>
      </div>
    </div>  
  </div>






  <div id="tab_1" class="tab-pane {{ ( $page_open == 12 || $page_open == 13 || $page_open == 14 || $page_open == 15 || $page_open == 16)?'active':'' }}">
    <div class="tabarea">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs nav-tabsbg">
          <li class="{{ ($page_open == 11)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('11') }}">Due Today</a></li>
          <li class="{{ ($page_open == 12)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('12') }}">Due in 7 Days</a></li>
          <li class="{{ ($page_open == 13)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('13') }}">Due in 30 Days</a></li>
          <li class="{{ ($page_open == 14)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('14') }}">Due in 3 Months</a></li>
          <li class="{{ ($page_open == 15)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('15') }}">Due in 6 Months</a></li>
          <li class="{{ ($page_open == 16)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('16') }}">Due After 6 Months</a></li>
        </ul>
  <div class="tab-content">
    <div id="tab_11" class="tab-pane {{ ($page_open != 2)?'active':'' }}" >
      <div id="" class="box-body table-responsive">
        <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
          <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6"></div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">
                <thead>
                  <tr role="row">
                    <td align="center" width="5%">Action</td>
                    <td align="left">Task Date</td>
                    <td align="left">Task Name</td>
                    <td align="left">Client Name</td>
                    <td align="left">Staff Name</td>
                    <td align="left">Attachment</td>
                    <td align="left" width="10%">Status</td>
                    <td align="left">Notes</td>
                  </tr>
                </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(isset($task_report) && count($task_report) >0)
							@foreach($task_report as $key=>$staff_row)
                @if($staff_row['showin_tab'] == $tab_no)
                
                
                <tr class="del_tr_{{ $staff_row['todolistnewtasks_id'] }}">
                  <td align="center">
                    <a href="javascript:void(0)" class="deltask"  data-task_id="{{ $staff_row['todolistnewtasks_id'] }}" data-task_type="{{ $staff_row['task_type'] }}" ><img src="/img/cross.png" /></a>
                  </td>
                
                  <td align="left">
                    <div id="edit_calender_{{ $staff_row['todolistnewtasks_id'] }}_{{ $key }}" class="edit_cal">
                      <a href="javascript:void(0)" id="date_view_{{ $staff_row['todolistnewtasks_id'] }}_{{ $key }}" />{{ (isset($staff_row['taskdate']) && $staff_row['taskdate'] != "")?date("d-m-Y", strtotime($staff_row['taskdate']) ):"" }} {{ (isset($staff_row['task_time']) && $staff_row['task_time'] != "")?date('H:i', strtotime($staff_row['task_time'])):"00:00" }}</a>
                      <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="{{ $staff_row['todolistnewtasks_id'] or "" }}" data-tab="{{ $key }}"></span>
                      <div class="cont_add_to_date open_dropdown_{{ $staff_row['todolistnewtasks_id'] }}_{{ $key }}" style="display:none;">
                      <ul> 

                      <li><a href="javascript:void(0)" class="open_calender_pop" data-task_id="{{ $staff_row['todolistnewtasks_id'] }}" data-task_type="{{ $staff_row['task_type'] }}" data-tab="{{ $page_open }}" data-calender_date="{{ $staff_row['taskdate'] or "" }}" data-calender_time="{{ $staff_row['task_time'] or '' }}">Add/Edit Start Date</a></li>
                     <li>
                      <span id="view_calender_{{ $staff_row['todolistnewtasks_id'] }}_{{ $key }}" class="addtocalendar atc-style-blue">
                        <var class="atc_event">
                          <var class="atc_date_start">{{ (isset($staff_row['taskdate']) && $staff_row['taskdate'] != "")?date("d-m-Y", strtotime($staff_row['taskdate']) ):"" }} {{ (isset($staff_row['task_time']) && $staff_row['task_time'] != "")?date('H:i', strtotime($staff_row['task_time'])):"00:00" }}</var>
                          <var class="atc_date_end">{{ (isset($staff_row['taskdate']) && $staff_row['taskdate'] != "")?$staff_row['taskdate']:"" }} {{ (isset($staff_row['task_time']) && $staff_row['task_time'] != "")?date("H:i:s", strtotime('+1 hour', strtotime($staff_row['task_time'])) ):"00:00" }}</var>
                          <var class="atc_timezone">Europe/London</var>
                          <var class="atc_title">{{$title}} - {{ $staff_row['taskname'] or ""}}</var>
                          <var class="atc_description">{{$title}} - {{ $staff_row['taskname'] or ""}}</var>
                          <var class="atc_location">Office</var>
                          <var class="atc_organizer">{{ $admin_name }}</var>
                          <var class="atc_organizer_email">{{ $logged_email }}</var>
                        </var>
                      </span>
                     </li>
                    </ul>
                  </div>
                </div>
                </td>
                
                <td align="left" >
                @if($staff_row['urgent'] == "Yes")
                <a href="#" style="color: #FA5858;" class="tasknamed" data-taskid="{{ $staff_row['todolistnewtasks_id'] or "" }}">{{ $staff_row['taskname'] or "" }}</a>
                @else
                  @if(isset($staff_row['task_type']) && $staff_row['task_type'] == 'todo')
                  <a href="javascript:void(0)" class="tasknamed" data-taskid= "{{ $staff_row['todolistnewtasks_id'] }}">{{ $staff_row['taskname'] or "" }}</a>
                  @else
                    {{ $staff_row['taskname'] or "" }}
                  @endif
                @endif
                </td> 
                
                <td align="left"><a href="#">{{ $staff_row['client_name'] or "" }}</a></td>
                <td align="left">{{ $staff_row['staff_name'] or "" }}</td>
                
                <td align="left">
                
                @if ( (isset($staff_row['add_file'])) && (!empty($staff_row['add_file'])) )
<a href="uploads/todolist/{{ $group_id }}/{{$staff_row['add_file']}}" download="{{$staff_row['add_file']}}"><img src="/img/attachment.png" width="15"></a>
                @endif
                </td>
                <td align="left">
                  @if(isset($staff_row['task_type']) && $staff_row['task_type'] == 'todo')
                  <select id="taskstatus" data-statusid="{{ $staff_row['todolistnewtasks_id']}}" name="status" class="form-control newdropdown">
                    <option value="not_started" {{ (isset($staff_row['status']) && $staff_row['status'] == "not_started")?"selected":"" }}>Not Started</option>
                    <option value="in_progress" {{ (isset($staff_row['status']) && $staff_row['status'] == "in_progress")?"selected":"" }}>In Progress</option>
                    <option value="completed" {{ (isset($staff_row['status']) && $staff_row['status'] == "completed")?"selected":"" }}>Completed</option>
                    <option value="close" {{ (isset($staff_row['status']) && $staff_row['status'] == "close")?"selected":"" }}>Close</option>
                  </select>
                  @else
                    {{ $staff_row['status'] }}
                  @endif
                </td>
                
                <td align="center"> 
                @if(empty($staff_row['notes']))
                      <a href="#" id="tasknotesopen" data-id="{{ $staff_row['todolistnewtasks_id'] or "" }}" data-toggle="modal" data-target="#tasknotes-modal"><span class="notes_btn">Notes</span></a>
                 @endif
                 @if(!empty($staff_row['notes']))
                  <a href="#" id="tasknotesopen" data-id="{{ $staff_row['todolistnewtasks_id'] }}" data-toggle="modal" data-target="#tasknotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="notes_btn">Notes</span></a>
                 @endif
                </td>
              
              </tr>
              @endif
            @endforeach
				  @endif
              
              

            </tbody>
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                  
                </div>

        <div id="tab_12" class="tab-pane">
          <div class="box-body table-responsive">
            <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
              <div class="row">
                <div class="col-xs-6"></div>
                <div class="col-xs-6"></div>
              </div>
              <div class="row">
                <div class="col-xs-12">


        <table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">

            <thead>
                  <tr role="row">
                    <td align="left">Action</td>
                    <td align="left">Task Date</td>
                    <td align="left">Task Name</td>
                    <td align="left">Client Name</td>
                    <td align="left">Staff Name</td>
                    <td align="left">Attachment</td>
                    <td align="left" width="10%">Status</td>
                    <td align="left">Notes</td>
                  </tr>
                </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
            
            </tbody>
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="tab_13" class="tab-pane">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">


        <table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">

            <thead>
                  <tr role="row">
                    <td align="left">Action</td>
                    <td align="left">Task Date</td>
                    <td align="left">Task Name</td>
                    <td align="left">Client Name</td>
                    <td align="left">Staff Name</td>
                    <td align="left">Attachment</td>
                    <td align="left" width="10%">Status</td>
                    <td align="left">Notes</td>
                  </tr>
                </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
            
            </tbody>
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="tab_14" class="tab-pane">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">


        <table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">

            <thead>
                  <tr role="row">
                    <td align="left">Action</td>
                    <td align="left">Task Date</td>
                    <td align="left">Task Name</td>
                    <td align="left">Client Name</td>
                    <td align="left">Staff Name</td>
                    <td align="left">Attachment</td>
                    <td align="left" width="10%">Status</td>
                    <td align="left">Notes</td>
                  </tr>
                </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
            
            </tbody>
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="tab_15" class="tab-pane">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">


        <table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">

            <thead>
                  <tr role="row">
                    <td align="left">Action</td>
                    <td align="left">Task Date</td>
                    <td align="left">Task Name</td>
                    <td align="left">Client Name</td>
                    <td align="left">Staff Name</td>
                    <td align="left">Attachment</td>
                    <td align="left" width="10%">Status</td>
                    <td align="left">Notes</td>
                  </tr>
                </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
            
            </tbody>
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="tab_16" class="tab-pane">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">


        <table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">

            <thead>
                  <tr role="row">
                    <td align="left">Actionq</td>
                    <td align="left">Task Date</td>
                    <td align="left">Task Name</td>
                    <td align="left">Client Name</td>
                    <td align="left">Staff Name</td>
                    <td align="left">Attachment</td>
                    <td align="left" width="10%">Status</td>
                    <td align="left">Notes</td>
                  </tr>
                </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
            </tbody>
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.tab-pane -->
              </div>
            </div>
          </div>
          
                </div>





  <div id="tab_2" class="tab-pane {{ ($page_open == 2)?'active':'' }}">
    <div class="box-body table-responsive">
      <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
        <div class="row">
          <div class="col-xs-6"></div>
          <div class="col-xs-6"></div>
        </div>
        <div class="row">
          <div class="col-xs-12">


        <table class="table table-bordered table-hover dataTable" id="example" aria-describedby="example_info">

            <thead>
              <tr role="row">
                <td align="center">Action</td>
                <td align="left">Task Date</td>
                <td align="left">Task Name</td>
                <td align="left">Client Name</td>
                <td align="left">Staff Name</td>
                 
                <td align="left">Attachment</td>
                <td align="left" width="10%">Status</td>
                <td align="left">Notes</td>
              </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
              
          @if(!empty($closetask_report))
					  @foreach($closetask_report as $key=>$staff_row)
              <tr class="del_tr_{{ $staff_row['todolistnewtasks_id'] }}">
                <td align="left">
                  <!-- <a href="/deletetask/{{ $staff_row['todolistnewtasks_id'] }}" id="deltask" ><img src="/img/cross.png" /></a> -->
                  <div class="align_center"><a href="javascript:void(0)" class="deltask" data-task_id="{{ $staff_row['todolistnewtasks_id'] }}" data-task_type="close"><img src="/img/cross.png" height="12"></a></div>
                </td>
                <td align="left">{{ $staff_row['taskdate'] or ""  }} &nbsp;{{ $staff_row['task_time'] or "" }}</td>
                <td align="left">
                
                  <a href="#" id="tasknamed" data-taskid= "{{ $staff_row['todolistnewtasks_id'] }}">{{ $staff_row['taskname'] or "" }}</a>
                 
                </td> 
                
                <td align="left"><a href="#">{{ $staff_row['client_detail']['field_value'] or "" }}</a></td>
                <td align="left">{{ $staff_row['staff_detail']['fname'] }} {{ $staff_row['staff_detail']['lname'] }}</td>
                
                <td align="left">
                
                @if ( (isset($staff_row['add_file'])) && (!empty($staff_row['add_file'])) )

                    <a href="uploads/todolist/{{ $group_id }}/{{$staff_row['add_file']}}" download="{{$staff_row['add_file']}}"><img src="/img/attachment.png" width="15"></a>
                @endif
                
                
                </td>
                <td align="left">
                  <select id="taskstatus" data-statusid="{{ $staff_row['todolistnewtasks_id']}}" name="status" class="form-control newdropdown">
                    <option value="not_started" {{ (isset($staff_row['status']) && $staff_row['status'] == "not_started")?"selected":"" }}>Not Started</option>
                    <option value="in_progress" {{ (isset($staff_row['status']) && $staff_row['status'] == "in_progress")?"selected":"" }}>In Progress</option>
                    <option value="completed" {{ (isset($staff_row['status']) && $staff_row['status'] == "completed")?"selected":"" }}>Completed</option>
                    <option value="close" {{ (isset($staff_row['status']) && $staff_row['status'] == "close")?"selected":"" }}>Close</option>
                </select>
                </td>
                <td align="center"> 
                
                
                @if(empty($staff_row['notes']))
                                    
                                    <a href="#" id="tasknotesopen" data-id="{{ $staff_row['todolistnewtasks_id'] or "" }}" data-toggle="modal" data-target="#tasknotes-modal"><span class="notes_btn">Notes</span></a>
                                    @endif
                                     
                                    
                                    
                                   @if(!empty($staff_row['notes']))
                                    
                                                                        <a href="#" id="tasknotesopen" data-id="{{ $staff_row['todolistnewtasks_id'] }}" data-toggle="modal" data-target="#tasknotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="notes_btn">Notes</span></a>
                                    
                                    
                                   @endif
              
              
              
              
              
              
              
              
              
              </td>
              
              </tr>
              
              	@endforeach
								@endif
              
              

            </tbody>
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
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

@include('crm.modal.newtask_modal')

<div class="modal fade" id="tasknotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NOTES</h4>
        <div class="clearfix"></div>
      </div>

      <div class="modal-body">     
        <div class="col-md-12">
          <!-- <textarea rows="4" cols="52"  name="notestask" id="notestask" value="" ></textarea> -->
          <div id="notestask"></div>
         
      <!--<button class="btn btn-primary" onclick="return fetchnotes()" id="fetchsave_notes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%; ">Save</button> -->  
        </div>
        <div class="clearfix"></div> 
      </div>
    </div>
  </div>
</div>

</div>

<!-- ADD JOB START DATE MODAL START -->
<div class="modal fade" id="addto_calender-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:410px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">EDIT TASK DATE & TIME</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div id="start_date_loader" style="text-align: center; padding-bottom: 10px;"><!-- Show loader --></div>
        <input type="hidden" id="calender_task_id" name="calender_task_id">
        <input type="hidden" id="calender_task_type" name="calender_task_type">
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
            <td align="right"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-info save_calender_date">Save</button></td>
          </tr>
        </table>
      </div>
    
    </div>
  </div>
</div>        
<!-- ADD JOB START DATE MODAL END -->

<!-- Add Tasks Via Email -->
<div class="modal fade" id="taskViaemail-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Tasks by sending emails to the address below</h4>
        <div class="clearfix"></div>
      </div>

      <div class="modal-body">
        <div class="show_loader"></div>    
        <div class="col-md-12">
          <table class="table table-bordered table-hover dataTable" width="100%" id="todoEmailDisplay">
            <thead>
              <tr>
                <th>Staff Name</th>
                <th>Email Address</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
         
        </div>
        <div class="clearfix"></div> 
      </div>
    </div>
  </div>
</div>
@stop
<!--staff -->