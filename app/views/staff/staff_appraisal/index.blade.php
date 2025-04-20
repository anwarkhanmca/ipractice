@extends('layouts.layout') 
@section('mycssfile')
<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
  <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

@if($tab_no == 1)  
  <!-- Time picker script -->
  <link rel="stylesheet" href="{{ URL :: asset('css/timepicki.css') }}" />
  <!-- Time picker script -->
@endif

@stop

@section('myjsfile')

<script src="{{ URL :: asset('js/staff_appraisal.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="{{ URL :: asset('js/jquery-ui.min.js') }}"></script>
<!-- Date picker script -->

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->

<!-- page script -->
<script type="text/javascript">
  $(".date_of_meeting").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
  //$("#completion").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});

  /*$('body').on('focus',"#completion", function(){alert('dd')
      $(this).datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
  });​*/

  $(function() {
    $('#example1').dataTable({
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
      "aaSorting": [[1, 'asc']],
      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true}
      ]

      });
    
    $('#example2').dataTable({
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
      "aaSorting": [[2, 'asc']],
      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false}
      ]
    });

    $('#example3').dataTable({
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
      "aaSorting": [[2, 'asc']],
      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false}
      ]
    });

  });

  $(document).ready(function(){
   $('#timeofmeeting').timepicki({
    show_meridian:false,
    max_hour_value:23,
    increase_direction:'up'
  });
});

function pdfstaffappraisal(){
    alert('dadadad');
}

function validation(){
  if($('#appraiser1').val() == "" && $('#appraiser2').val() == ""){
    alert('Please select atleast one appraiser');
    $('#appraiser1').focus();
    return false;
  }else if($('#dateofmeeting').val() == ""){
    alert('Please select meeting date');
    $('#dateofmeeting').focus();
    return false;
  }else if($('#timeofmeeting').val() == ""){
    alert('Please select meeting time');
    $('#timeofmeeting').focus();
    return false;
  }else{
    return true;
  }
  
}


</script>
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
      <div class="row">
        <!--<div class="top_bts">
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
        </div>-->
      </div>
      <div class="practice_mid">

          <div class="tabarea">
          <!--<div class="tab_topcon">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="notes_top_btns">
  <tr>
    <td width="11%">COMPANIES HOUSE</td>
    <td width="35%"><button class="btn btn-danger">SYNC DATA</button></td>
    <td width="0%">&nbsp;</td>
    <td width="4%"><button class="btn btn-info">AM</button></td>
    <td width="26%">ADE MCADIO LIMITED</td>
    <td width="13%">&nbsp;</td>
    <td width="11%"><button class="btn btn-success">GENERATE PDF</button></td>
  </tr>
</table>
              <div class="clearfix"></div>
            </div>-->
            
            
<div class="nav-tabs-custom">
  <ul class="nav nav-tabs nav-tabsbg">
    <li class="{{ ($tab_no == 1)?'active':'' }}"><a href="/staff-appraisal/{{ base64_encode('1') }}">CURRENT APPRAISALS</a></li>
    <!-- <li class="{{ ($tab_no == 2)?'active':'' }}"><a href="/staff-appraisal/{{ base64_encode('2') }}">APPRAISALS</a></li>
    <li class="{{ ($tab_no == 3)?'active':'' }}"><a href="/staff-appraisal/{{ base64_encode('3') }}">ARCHIVED</a></li> -->
    <!--<li><a href="#" class=" btn-block btn-primary " data-toggle="modal" data-target="#compose-modal"><i class="fa fa-plus"></i> New Field </a></li>-->
  </ul>
  <div class="tab-content">


<div id="tab_1" class="tab-pane {{ ($tab_no == 1)?'active':'' }}">
<form name="appraisal_form" method="post" action="/sm/save-appraisal" onsubmit="return validation();">
<input type="hidden" name="encoded_tab" id="encoded_tab" value="{{ $encoded_no or "" }}">
<input type="hidden" name="tab_no" id="tab_no" value="{{ $tab_no or "" }}">
<input type="hidden" name="last_perform_id" id="last_perform_id" value="0">
<input type="hidden" name="page_open" id="page_open" value="{{ $page_open or "" }}">
<input type="hidden" name="encoded_page_open" id="encoded_page_open" value="{{ $encoded_page_open or "" }}">
<input type="hidden" name="staffdropdown" id="staffdropdown" value="{{ $user_id or '' }}" />
<input type="hidden" name="action" id="action" value="add" />
<input type="hidden" name="appraisal_id" id="appraisal_id" value="0" />
<input type="hidden" name="staff_sign_id" id="staff_sign_id" value="0" />

      <!--table area-->
  <div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
      <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
      </div>

      <div class="row">
        <div class="col-xs-12">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
          @if($page_open == 'staff')
            <td width="25%">
              <span style="float: left;">Select Staff &nbsp;</span>
              <span style="float: left;" >
                <select class="form-control2 select_dropdown staffdata" id="staffdata" name="str_staff" style=" width: 200px; height:30px; cursor: pointer;">
                  <option value="">None</option>
              	  @if(!empty($staff_details))
                    @foreach($staff_details as $key=>$staff_row)
                      <option value="{{ $staff_row['user_id'] }}" data-value="{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                    @endforeach
                  @endif
                </select>
              </span>
            </td>
            <td width="2%">&nbsp;</td>
            <td width="10%"><button type="button" class="btn btn-default" id="updateForm"><span class="requ_t">Update</span></button></td>

            <td width="10%">
              <button class="btn btn-default show_new_form" type="button" id="newform"><span class="requ_t">+ New Form</span></button>
            </td>
            <td width="7%">
              <div class="j_selectbox2">
                <span>Roll Forward from Previous</span>
                <div class="select_icon disable_click" id="select_icon"></div>
                <div class="clr"></div>
                <div class="open_toggle" style="display:none;">
                  <ul id="open_toggle_ul">
                    <!-- @if(isset($previous_roll) && count($previous_roll) >0)
                      @foreach($previous_roll as $key=>$row)
                        <li value="{{ $row['appraisal_id'] }}">{{ $row['staff_name'] or "" }} - {{$row['meeting_date'] or ""}} {{$row['meeting_time'] or ""}}</li>
                      @endforeach
                    @endif -->
                  </ul>
                </div>
              </div>
            </td>
          @else
            <td width="28%">&nbsp;</td>
          @endif  
            <td width="32%">
              <div class="j_selectbox2">
                <span>View Previous Appraisals</span>
                <div class="select_icon {{ ($page_open == 'profile')?'':'disable_click' }}" id="view_prev_app"></div>
                <div class="clr"></div>
                <div class="open_view_prev">
                  <ul id="open_view_prev">
                    @if($page_open == 'profile')
                      @if(isset($previous_roll) && count($previous_roll) >0)
                        @foreach($previous_roll as $key=>$value)
                          <li class='vd_{{ $value['appraisal_id'] }}'>
                            <a href='javascript:void(0)' data-action='V' class='roll_fwd_drop' data-staff_id='{{ $value['staff_id'] }}' data-appraisal_id='{{ $value['appraisal_id'] }}'>{{ $value['staff_name'] }}</a> - {{ $value['meeting_date'] }} {{ $value['meeting_time'] }}</li>
                        @endforeach
                      @endif
                    @endif
                  </ul>
                </div>
              </div>
            </td>
            <td width="24%"></td>
          </tr>
        </table>
                        
                        
        <div class="col_m2">
        <div class="notes_top_btns">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="10%"><button class="btn btn-success download_btn" onclick="pdfstaffappraisal();"><i class="fa fa-download"></i> Generate PDF</button></td>
              <td width="1%">&nbsp;</td>
              <td width="22%">&nbsp;</td>
              <td width="2%">&nbsp;</td>
              <td width="30%"><strong><h4>PERFORMANCE APPRAISAL FORM</h4></strong></td>
              <td width="2%">&nbsp;</td>
              <td width="21%" align="right">
              @if($page_open == 'staff')
                <a class="btn btn-danger right_side small_right" href="/staff-appraisal/{{ $encoded_no }}/{{ $encoded_page_open }}">Cancel</a>
                <button class="btn btn-info right_side small_right" type="submit">Save</button>

                <a href="javascript:void(0)" class="btn btn-info" id="openEditAppraisal" data-action="V" style="display: none">Edit</a>

              @endif
              </td>
            </tr>
          </table>
        </div>
  
        <div id="show_form_content" style="display: none;">
          <table width="100%" border="1" cellspacing="0" cellpadding="0" class="table table-bordered table_content">
            <tr>
              <td width="21%"><strong>Appraisee</strong></td>
              <td width="30%" id="appraisee"></td>
              <td width="19%"><strong>Appraiser(s)</strong></td>
              <td width="15%" id="appraiser_1">
                <select class="form-control select_dropdown getJobTitle" name="appraiser1" id="appraiser1" style="width: 200px; height:30px; cursor: pointer;">
                  <option value="">-- Select --</option>
                  @if(!empty($staff_details))
                    @foreach($staff_details as $key=>$staff_row)
                      <option value="{{ $staff_row['user_id'] }}" data-value="{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                    @endforeach
                  @endif
                </select>
              </td>
              <td width="15%">
                <select class="form-control select_dropdown getJobTitle" name="appraiser2" id="appraiser2" style="width: 200px; height:30px; cursor: pointer;">
                  <option value="">-- Select --</option>
                  @if(!empty($staff_details))
                    @foreach($staff_details as $key=>$staff_row)
                      <option value="{{ $staff_row['user_id'] }}" data-value="{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                    @endforeach
                  @endif
                </select>
              </td>
            </tr>

            <tr>
              <td><strong>Job Title</strong></td>
              <td id="appraisee_title"></td>
              <td><strong>Job Title</strong></td>
              <td id="appraiser_title1"></td>
              <td id="appraiser_title2"></td>
            </tr>
            <tr>
              <td><strong>Date of Meeting</strong></td>
              <td><input type="text" id="dateofmeeting" name="dateofmeeting" class="form-control date_of_meeting"></td>
              <td><strong>Time of Meeting</strong></td>
             <td colspan="2"><input type="text" placeholder="" id="timeofmeeting" name="timeofmeeting" class="form-control" style="height: 30px; width: 200px"></td>
            </tr>
            <input type="hidden" id="typedata" value="per">
          </table>

          <ul class="nav nav-tabs nav-tabsbg">
            <li class="active"><a data-toggle="tab" id="per" href="#tab_5">Performance – Objectives and targets</a></li>
            <li class=""><a data-toggle="tab" id="com" href="#tab_6">Competency and Skill Development</a></li>
            <li class=""><a data-toggle="tab" href="#tab_7">Additional Comments</a></li>
          </ul>
        <div class="tab-content">
          <div id="tab_5" class="tab-pane active">
          <!--table area-->
          <div class="box-body table-responsive" style="padding-top: 10px;">
            <ul class="nav nav-tabs nav-tabsbg">
              <li class="active">
                <a data-toggle="tab" href="#tab_p1">Set objectives and targets for the coming year</a>
              </li>
              <li class="">
                <a data-toggle="tab" href="#tab_p2">Review of last performance – Objectives and targets</a>
              </li>
            </ul>
            <div class="tab-content">
              <div id="tab_p1" class="tab-pane active">
                <div class="review_last" style="">
              <table width="100%" border="1" cellspacing="0" cellpadding="0" style="margin-top: 20px;" id="BoxTable" class="table table-bordered table_content">
                <thead>
                  <tr>
                    <td width="3%">&nbsp;</td>
                    <td width="20%">New targets / objectives 
                    <a href="javascript:void(0)" class="" title="An appropriate and manageable number" style="float:right;"><img src="/img/question_frame.png"></a>
                    @if($page_open == 'staff')
                     <a href="#" data-toggle="modal" id="newtargetpopup" data-target="#newtargetpopup-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
                    @endif
                    </td>
                    <td width="32%">How are these linked to personal / team performance improvements ?</td>
                    <td width="32%">How will success be measured?<a href="javascript:void(0)" class="" title="e.g Performance Indicators Supporting Evidence" style="float:right;"><img src="/img/question_frame.png"></a></td>
                    <td width="13%">Completion Date</td>
                  </tr>
                </thead>
                <tbody> 
                  <tr id="TemplateRow1" class="makeCloneClass1">
                    <td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" id="date_picker" class="DeleteBoxRow1"></a></td>
                    <td>
                      <select class="form-control drop_height newdropdown" id="newtarget" name="newtarget[]">
                    <option value="">None</option>
                    @if(isset($staff_tasks) && count($staff_tasks)>0 )
                      @foreach($staff_tasks as $key=>$scheme_row)
                      @if(isset($scheme_row['for_task']) && $scheme_row['for_task'] == 'per')
                        <option value="{{ $scheme_row['stafftasks_id'] }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row['stafftasks_id'])?"selected":"" }}>{{ $scheme_row['name'] }}</option>
                      @endif
                      @endforeach
                    @endif
                    </select>
                    </td>
                    <td><input type="text" name="perform_notes[]" id="notes1" class="form-control"></td>
                    <td><input type="text" name="measured_notes[]" id="notes2" class="form-control"></td>
                    <td>
                      <input type="text" id="completion" name="completion_date[]" class="form-control date_of_meeting dpick">
                    </td>
                  </tr>
                </tbody>
              </table>
              <a href="javascript:void(0)" id="addline1">
              <div class="left_side">
                
                <button class="addnew_line" type="button"><i class="add_icon_img">
                  <img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button>
                
              </div></a>
              <div class="clr"></div>
              </div>
                <!--contentp1 -->
              </div>

              <div id="tab_p2" class="tab-pane">
                <table width="100%" border="1" cellspacing="0" cellpadding="0" style="margin-top: 20px;" class="table table-bordered table_content set_objective" style="">
                  <thead>
                    <tr>
                      <th width="30%">Objectives /targets from last appraisal</th>
                      <th width="20%">Objective met</th>
                      <th>Supporting evidence<a href="javascript:void(0)" class="" title="Please note any other factors affecting performance (positive or negative)" style="float:right;"><img src="/img/question_frame.png"></a></th>
                    </tr>
                  </thead>
                  <tbody></tbody>
                </table>
                <!-- contentp2 -->
              </div>
            </div>
          </div>

<!-- This is only for getting add new -->
  <table id="11addNew" style="display: none;">
    <tr id="TemplateRow1" class="makeCloneClass1">
      <td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" id="date_picker" class="DeleteBoxRow1"></a></td>
      <td>
        <select class="form-control drop_height newdropdown" id="newtarget" name="newtarget[]">
      <option value="">None</option>
      @if(isset($staff_tasks) && count($staff_tasks)>0 )
        @foreach($staff_tasks as $key=>$scheme_row)
        @if(isset($scheme_row['for_task']) && $scheme_row['for_task'] == 'per')
          <option value="{{ $scheme_row['stafftasks_id'] }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row['stafftasks_id'])?"selected":"" }}>{{ $scheme_row['name'] }}</option>
        @endif
        @endforeach
      @endif
      </select>
      </td>
      <td><input type="text" name="perform_notes[]" id="notes1" class="form-control"></td>
      <td><input type="text" name="measured_notes[]" id="notes2" class="form-control"></td>
      <td>
        <input type="text" id="completion" name="completion_date[]" class="form-control date_of_meeting dpick">
      </td>
    </tr>
  </table>

  <table id="21addNew" style="display: none;">
      <tr id="TemplateRow2" class="makeCloneClass2">
      <td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" id="date_picker2" class="DeleteBoxRow2"></a></td>
      <td>
        <select class="form-control drop_height newdropdown" id="csi2" name="competency_skill[]">
          @if(isset($staff_tasks) && count($staff_tasks)>0 )
            @foreach($staff_tasks as $key=>$scheme_row)
            @if(isset($scheme_row['for_task']) && $scheme_row['for_task'] == 'com')
              <option value="{{ $scheme_row['stafftasks_id'] }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row['stafftasks_id'])?"selected":"" }}>{{ $scheme_row['name'] }}</option>
            @endif
            @endforeach
          @endif
        </select>
      </td>

      <td>
        <select class="form-control drop_height newdropdown" id="clr2" name="competency_level[]">
          @if(isset($CompetencyLevel) && count($CompetencyLevel) >0)
            @foreach($CompetencyLevel as $key=>$level_row)
              <option value="{{ $level_row['level_id'] }}">{{ $level_row['name'] }}</option>
            @endforeach
          @endif
        </select>
      </td>

      <td>
        <select class="form-control drop_height newdropdown" id="pcl2" name="prev_competency[]">
          @if(isset($CompetencyLevel) && count($CompetencyLevel) >0)
            @foreach($CompetencyLevel as $key=>$level_row)
              <option value="{{ $level_row['level_id'] }}">{{ $level_row['name'] }}</option>
            @endforeach
          @endif
        </select>
      </td>

      <td>
        <select class="form-control drop_height newdropdown" id="ccl2" name="cur_competency[]">
          @if(isset($CompetencyLevel) && count($CompetencyLevel) >0)
            @foreach($CompetencyLevel as $key=>$level_row)
              <option value="{{ $level_row['level_id'] }}">{{ $level_row['name'] }}</option>
            @endforeach
          @endif
        </select>
      </td>
      <td><input type="text" name="supporting_notes[]" class="form-control supporting_notes"></td>
    </tr>
  </table>

</div>
                              <!-- /.tab-pane -->


            <div id="tab_6" class="tab-pane">
            <div class="box-body table-responsive" style="padding-top: 10px;">
            <ul class="nav nav-tabs nav-tabsbg">
              <li class="active"><a data-toggle="tab" href="#tab_c1">
              Identifying competencies /skills for development in the coming year</a></li>
              <li class=""><a data-toggle="tab" href="#tab_c2">Review of last performance</a></li>
            </ul>
             <div class="tab-content">
              <div id="tab_c1" class="tab-pane active">
              <table width="100%" border="1" cellspacing="0" cellpadding="0" style="margin-top: 20px;" id="BoxTable1" class="table table-bordered table_content">
              <thead>
              <tr>
                <td>&nbsp;</td>
                <td width="25%">Competencies / Skills identified for development
                @if($page_open == 'staff')
                  <a href="#" data-toggle="modal" data-target="#competencies-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
                @endif
                </td>
                
                <td width="15%">Competency level required</td>
                
                <td width="15%">Previous Competency level</td>
                
                <td width="15%">Current Competency level</td>
                
                <td width="30%">Supporting evidence <a href="javascript:void(0)" class="" title="note other factors affrecting performance (Positive or negative)" style="float:right;"><img src="/img/question_frame.png"></a> </td>
              </tr>
            </thead>
            <tbody>
              <tr id="TemplateRow2" class="makeCloneClass2">

              <td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" id="date_picker2" class="DeleteBoxRow2"></a></td>
              <td>
                <select class="form-control drop_height newdropdown" id="csi2" name="competency_skill[]">
                  @if(isset($staff_tasks) && count($staff_tasks)>0 )
                    @foreach($staff_tasks as $key=>$scheme_row)
                    @if(isset($scheme_row['for_task']) && $scheme_row['for_task'] == 'com')
                      <option value="{{ $scheme_row['stafftasks_id'] }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row['stafftasks_id'])?"selected":"" }}>{{ $scheme_row['name'] }}</option>
                    @endif
                    @endforeach
                  @endif
                </select>
              </td>
              
              <td>
                <select class="form-control drop_height newdropdown" id="clr2" name="competency_level[]">
                  @if(isset($CompetencyLevel) && count($CompetencyLevel) >0)
                    @foreach($CompetencyLevel as $key=>$level_row)
                      <option value="{{ $level_row['level_id'] }}">{{ $level_row['name'] }}</option>
                    @endforeach
                  @endif
                </select>
              </td>
      
              <td>
                <select class="form-control drop_height newdropdown" id="pcl2" name="prev_competency[]">
                  @if(isset($CompetencyLevel) && count($CompetencyLevel) >0)
                    @foreach($CompetencyLevel as $key=>$level_row)
                      <option value="{{ $level_row['level_id'] }}">{{ $level_row['name'] }}</option>
                    @endforeach
                  @endif
                </select>
              </td>

              <td>
                <select class="form-control drop_height newdropdown" id="ccl2" name="cur_competency[]">
                  @if(isset($CompetencyLevel) && count($CompetencyLevel) >0)
                    @foreach($CompetencyLevel as $key=>$level_row)
                      <option value="{{ $level_row['level_id'] }}">{{ $level_row['name'] }}</option>
                    @endforeach
                  @endif
                </select>
              </td>
              <td><input type="text" name="supporting_notes[]" class="form-control supporting_notes"></td>
            </tr>
          </tbody>
          </table>

          <div class="left_side"><button id="addline2" class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button></div>
          <div class="clr"></div>
        </div>

        <div id="tab_c2" class="tab-pane">
        <table width="100%" border="1" cellspacing="0" cellpadding="0" style="margin-top: 20px;" class="table table-bordered table_content">
          <thead>
            <tr>
              <th>Competencies / Skills identified for development</th>
              <th>Competency level required</th>
              <th>Current Competency level</th>
              <th>How will competencies be developed <a href="javascript:void(0)" class="" title="(e.g coaching,specific task,training course,shadowing a colleague)" style="float:right;"><img src="/img/question_frame.png"></a></th>
              <th>Suporting Evidence <a href="javascript:void(0)" class="" title="Please note any other factors affecting performance (positive or negative)" style="float:right;"><img src="/img/question_frame.png"></a> .</th>
            </tr>
          </thead>
          <tbody> </tbody>
        </table>
        <div class="clr"></div>
                    <!-- content2 -->
                </div>
               </div>
                  </div>
                </div>


<div id="tab_7" class="tab-pane">
  <div class="box-body table-responsive" style="padding-top: 10px;">
    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
      <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="col_m2">
            <h3 class="box-title">ADDITIONAL COMMENTS</h3>
            <table width="60%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table_content">
              <tr>
                <td>Appraisee's Comments</td>
                <td><textarea cols="50" rows="4" name="appraisee_comment" id="appraisee_comment"></textarea></td>
              </tr>
              <tr>
                <td>Appraiser's Comments</td>
                <td><textarea  cols="50" rows="4" name="appraiser_comment" id="appraiser_comment"></textarea></td>
              </tr>

               <tr>
                <td> Appraisee Signature</td>
                <td id="profile_sign_text" style="font-style: italic;">
                @if($page_open == 'profile')
                  <a href="javascript:void(0)" class="sign_modal" id="appraisee_sign">Sign... </a>
                @else
                  <a href="javascript:void(0)">Sign... </a>
                @endif
                </td>
              </tr>
               <tr>
                <td>Appraiser Signature</td>
                <td id="staff_sign_text" style="font-style: italic;">
                @if($page_open == 'profile')
                  <a href="javascript:void(0)">Sign... </a>
                @else
                  <a href="javascript:void(0)" class="sign_modal" id="appraiser_sign">Sign... </a>
                @endif
                </td>
              </tr>
              <!-- <tr>
                <td>Date & Time :</td>
                <td></td>
              </tr> -->
            </table>

                </div>
              
              
            </div>
           
          </div>
        </div>
      </div>
    </div>
    
  </div>
</div>
<!--end sub tab-->


         </div>
        </div>
        
      </div>
    </div>
  </div>
<!--end table-->
{{ Form::close() }}
</div>
<!-- /.tab-pane -->



<div id="tab_2" class="tab-pane {{ ($tab_no == 2)?'active':'' }}">
  <div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
      <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="col_m2">
  <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
    <thead>
      <tr role="row">
        <th><strong>Date Joined</strong></th>
        <th><strong>Staff Name</strong></th>
        <th><strong>Review Date</strong></th>
        <th><strong>Department</strong></th>
        <th><strong>Job Title</strong></th>
        <th width="5%"><strong>Notes</strong></th>
        <th width="10%"><strong>Action</strong></th>
      </tr>
    </thead>

    <tbody>
      @if(isset($prev_appriasals) && count($prev_appriasals) >0)
        @foreach($prev_appriasals as $key=>$prev_row)
          @if(isset($prev_row['is_archive']) && $prev_row['is_archive'] != 'A')
          <tr class="{{ $tab_no }}_hide_appraisal_{{ $prev_row['appraisal_id'] or "" }}">
            <!-- <td align="center"><a href="javascript:void(0)" data-appraisal_id="{{ $prev_row['appraisal_id'] or "" }}" class="delete_appraisal"><img src="/img/cross.png" /></td> -->
            <td align="left">{{ (isset($prev_row['start_date']) && $prev_row['start_date'] != '')?date('d-m-Y', strtotime($prev_row['start_date'])):'' }}</td>
            <td align="left">{{ $prev_row['staff_name'] or "" }}</td>
            <td align="left">{{ (isset($prev_row['meeting_date']) && $prev_row['meeting_date'] != '0000-00-00')?date('d-m-Y', strtotime($prev_row['meeting_date'])):'' }} {{ $prev_row['meeting_time'] or '' }}</td>
            <td align="left">{{ $prev_row['department'] or "" }}</td>
            <td align="left">{{ $prev_row['job_title'] or "" }}</td>
            <td align="center"><a href="javascript:void(0)" class="notes_btn" data-appraisal_id="{{ $prev_row['appraisal_id'] or "" }}"><span>notes</span></a></td>
            <td>
              <select class="form-control newdropdown change_action" data-appraisal_id="{{ $prev_row['appraisal_id'] or "" }}">
                <option value="N">None</option>
                <option value="D">Delete</option>
                <option value="A">Archive</option>
              </select>
            </td>
          </tr>
          @endif
        @endforeach
      @endif
    </tbody>
  </table>                          
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>


<div id="tab_3" class="tab-pane {{ ($tab_no == 3)?'active':'' }}">
  <div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
      <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="col_m2">
    <table class="table table-bordered table-hover dataTable ch_returns" id="example3" aria-describedby="example3_info">
      <thead>
        <tr role="row">
          <th><strong>Date Joined</strong></th>
          <th><strong>Staff Name</strong></th>
          <th><strong>Review Date</strong></th>
          <th><strong>Department</strong></th>
          <th><strong>Job Title</strong></th>
          <th align="center"><strong>Notes</strong></th>
          <th width="10%" align="center">Action</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($prev_appriasals) && count($prev_appriasals) >0)
          @foreach($prev_appriasals as $key=>$prev_row)
            @if(isset($prev_row['is_archive']) && $prev_row['is_archive'] == 'A')
              <tr class="{{ $tab_no }}_hide_appraisal_{{ $prev_row['appraisal_id'] or "" }}">
                <!-- <td align="center"><a href="javascript:void(0)" data-appraisal_id="{{ $prev_row['appraisal_id'] or "" }}" class="delete_appraisal"><img src="/img/cross.png" /></td> -->
                <td align="left">{{ (isset($prev_row['start_date']) && $prev_row['start_date'] != '')?date('d-m-Y', strtotime($prev_row['start_date'])):'' }}</td>
                <td align="left">{{ $prev_row['staff_name'] or "" }}</td>
                <td align="left">{{ (isset($prev_row['meeting_date']) && $prev_row['meeting_date'] != '0000-00-00')?date('d-m-Y', strtotime($prev_row['meeting_date'])):'' }} {{ $prev_row['meeting_time'] or '' }}</td>
                <td align="left">{{ $prev_row['department'] or "" }}</td>
                <td align="left">{{ $prev_row['job_title'] or "" }}</td>
                <td align="center"><a href="javascript:void(0)" class="notes_btn" data-appraisal_id="{{ $prev_row['appraisal_id'] or "" }}"><span>notes</span></a></td>
                <td>
              <select class="form-control newdropdown change_action" data-appraisal_id="{{ $prev_row['appraisal_id'] or "" }}">
                <option value="N">None</option>
                <option value="D">Delete</option>
                <option value="U">Un Archive</option>
              </select>
            </td>
              </tr>
            @endif
          @endforeach
        @endif
      </tbody>
    </table>
                          
          </div>
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
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>
<!-- ./wrapper -->


<div class="modal fade" id="newtargetpopup-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD to List</h4>
        <div class="clearfix"></div>
      </div>
      <input type="hidden" id="hiddenclient" value="staff" />
              
   {{ Form::open(array('url' => '/addnewtergetobject', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="newtergetobject" id="newtergetobject" placeholder="New targets / objectives" class="form-control">
      </div>
      
      <div id="append_task">
      <!--
        @if( isset($old_services) && count($old_services) )
          @foreach($old_services as $key=>$scheme_row)
            <div class="form-group">
              <label for="{{ $scheme_row->name }}">{{ $scheme_row->name }}</label>
            </div>
          @endforeach
        @endif

        @if( isset($new_services) && count($new_services) )
          @foreach($new_services as $key=>$scheme_row)
            <div class="form-group" id="hide_task{{ $scheme_row->stafftasks_id }}">
              <a href="javascript:void(0)" title="Delete Field ?" class="deletetergetobject" data-field_id="{{ $scheme_row->stafftasks_id }}"><img src="/img/cross.png" width="12"></a>
              <label for="{{ $scheme_row->name }}">{{ $scheme_row->name }}</label>
            </div>
          @endforeach
        @endif
     
     -->
             
      </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
         
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="savenewtergetobject" name="save">Save</button>
          
          
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }} 
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>  






<div class="modal fade" id="competencies-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD to List</h4>
        <div class="clearfix"></div>
      </div>
      <input type="hidden" id="hiddenclient" value="staff" />
              
   {{ Form::open(array('url' => '/addcompetencies', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="competencies" id="textcompetencies" placeholder="competencies" class="form-control">
      </div>
      
      <div id="append_competencies"> <!--
      @if( isset($old_postion_types) && count($old_postion_types) >0 )
        @foreach($old_postion_types as $key=>$old_org_row)
        <div class="form-group">
          <label for="{{ $old_org_row->name }}">{{ $old_org_row->name }}</label>
        </div>
        @endforeach
      @endif

      @if( isset($new_postion_types) && count($new_postion_types) >0 )
        @foreach($new_postion_types as $key=>$new_org_row)
        <div class="form-group" id="hide_div_{{ $new_org_row->checklist_id }}">
          <a href="javascript:void(0)" title="Delete Field ?" class="delete_checklist_name" data-field_id="{{ $new_org_row->checklist_id }}"><img src="/img/cross.png" width="12"></a>
          <label for="{{ $new_org_row->name }}">{{ $new_org_row->name }}</label>
        </div>
        @endforeach
      @endif -->
      </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
         
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="addcompetencies" name="save">Save</button>
          
          
          <button type="button" class="btn btn-danger pull-left save_t2"  data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }} 
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>  




<div class="modal fade" id="sign-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px; ">
  <form method="post" action="/sm/save-appraisal-sign" id="signPop">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Sign</h4>
        <div class="clearfix"></div>
      </div>
      <div class="show_loader"></div>
      <div class="modal-body">
        <input type="hidden" id="page_type" name="page_type" value="{{ $page_open }}" />
        <input type="hidden" id="pop_appraisal_id" name="pop_appraisal_id" />

        <div style="padding: 10px 40px;" id="staff_modal_text">
          <p>I agree that the Appraisal dated on <span class="meetpopupdate"></span>, is a true and</p>
          <p>assessment of <span class="apprse_name"></span> skills competences.</p><br>
          <p class="clickName"></p>
        </div>
       <!-- <table style="  margin-left: 31px;">
       
       <tr>
       <td><strong>User Name</strong></td>
       <td><input type="text" style="  width: 226px;" id="appre_sign"></td>
       </tr>
        <tr>
       <td>&nbsp;</td>
        <td>&nbsp;</td>
       </tr>
       <tr style="padding-top: 4px;">
       <td><strong>Password</strong></td>
       <td><input type="text" style="  width: 226px;" id="appr_sign" ></td>
       </tr>
       </table> -->
        <div class="modal-footer clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-info" id="add_sigature" name="save">Sign</button>
            <button type="button" class="btn btn-danger pull-left newlist" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>
  </form>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- Notes modal start -->
<div class="modal fade in" id="notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">SAVE NOTES</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <input type="hidden" id="field_name" name="field_name" value="">
        <input type="hidden" id="table_id" name="table_id" value="">
        <input type="hidden" id="type" name="type" value="">
        <table>
          <tbody><tr>
            <td align="left" width="20%"><strong>Notes : </strong></td>
            <td align="left"><textarea class="form-control" cols="56" rows="4" id="notes" name="notes"></textarea></td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="right"><button type="button" class="btn btn-info save_notes">Save</button></td>
          </tr>
        </tbody></table>

        
      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div> 
<!-- Notes modal end -->

@stop
<!-- staff-->