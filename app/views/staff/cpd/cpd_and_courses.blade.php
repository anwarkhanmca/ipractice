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
<script src="{{ URL :: asset('js/cpd.js') }}" type="text/javascript"></script>

<script type="text/javascript">
 
var Table1, Table2;
$(function() {
  $("#calender_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-5:+100" });
  $("#editcalender_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-5:+100" });

$('#courses_time').timepicki({
  show_meridian:false,
  max_hour_value:23,
  increase_direction:'up'
});

$('#editcourses_time').timepicki({
  show_meridian:false,
  max_hour_value:23,
  increase_direction:'up'
});
    
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

    ]

  });
  Table1.fnSort( [ [1,'desc'] ] );
  
  

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
      {"bSortable": true},
      {"bSortable": false},
      {"bSortable": false},

    ]

  });
  Table2.fnSort( [ [1,'desc'] ] );
  
 })
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

 <script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript"></script>
@stop

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
          <div class="top_bts">
            <ul>
            <!--  <li>
                <button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
              </li> -->
              <li>
<a href="/pdfbookedcourses" class="btn btn-success" style=""><i class="fa fa-download"></i> Generate PDF</a>
             <!--   <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button> -->
            
              </li>
              <li>
               <!-- <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button> -->
<a href="/excelbookedcourses" class="btn btn-primary" style=""><i class="fa fa fa-file-text-o"></i> Excel</a>
              </li> 
              <div class="clearfix"></div>
            </ul>
          </div>
        </div>
                                       
        <div style="float:right;"><button class="btn btn-default requ_t" data-toggle="modal" data-target="#compose-modal"> + New Course</button></div>
        
        <div class="clearfix"></div>
          <div class="tabarea">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
                <li class="{{ ($page_open == 1)?'active':'' }}"><a href="{{ $goto_url }}/{{$type}}/{{ '1' }}">Booked Courses</a></li>
                  
                <li class="{{ ($page_open == 2)?'active':'' }}"><a href="{{ $goto_url }}/{{$type}}/{{ '2' }}">
                  @if($staff_type== 'staff')
                    Courses Log
                  @else
                    CPD Tracker
                  @endif
                  </a>
                </li>
              </ul>



<div class="tab-content">
  <div id="tab_1" class="tab-pane {{ ($page_open == 1)?'active':'' }}">
    <!--table area-->
     @if($staff_type== 'staff')
    <div class="box-body table-responsive">
      <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
        <div class="row">
          <div class="col-xs-6"></div>
          <div class="col-xs-6"></div>
        </div>
        <div class="row">
          <div class="col-xs-12">
            <!--start table-->
            <table width="100%" border="0" class="staff_holidays">
              <tr>
                <td valign="top">
                  <table class="table table-bordered table-hover dataTable" id="example1" width="100%">
                    <thead>
                      <tr class="table_heading_bg" style="background-color: #fff; color:#000;">
                        <td width="3%"> Action</td>
                        <td width="15%"><strong>Courses Date</strong></td>
                        <td width="5%"><strong>Hrs</strong></td>
                        <td align="center"><strong>Courses Name</strong></td>
                        <td width="20%" align="center"><strong>Attendees</strong></td>
                        <td width="5%" align="center"><strong>Attachments</strong></td>
                        <td width="8%" align="center">Notes</td>
                      </tr>
                      </thead>
                     <tbody> 
                      @if(!empty($course_report))
						            @foreach($course_report as $key=>$staff_row)
                          @if($staff_row['is_booked'] == 'Y')    
                            <tr>
                              <td align="center"><a href="javascript:void(0)" class="delcourses" data-id="{{ $staff_row['cpd_id'] or "" }}" data-field_name="is_booked"><img src="/img/cross.png"></a></td>
                              <!-- <td align="left">
                                <div id="edit_calender_" class="edit_cal">
                                  <a href="javascript:void(0)" />{{$staff_row['created'] or ""}}</a>
                                    <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="" data-tab=""></span>
                                </div>
                              </td> -->
                              <td align="center">
                                <div id="edit_calender_{{ $staff_row['cpd_id'] }}_1" class="edit_cal">
                                  <a href="javascript:void(0)" id="date_view_{{ $staff_row['cpd_id'] }}_1" />
                                  {{ (isset($staff_row['course_date']) && $staff_row['course_date'] != "")?date("d-m-Y", strtotime($staff_row['course_date']) ):"" }}

                                  {{ (isset($staff_row['course_time']) && $staff_row['course_time'] != "")?date("H:i", strtotime($staff_row['course_time']) ):"" }}

                                  </a>
                                  <span class="glyphicon glyphicon-chevron-down open_adddrop" data-cpd_id="{{ $staff_row['cpd_id'] or "" }}" data-tab="1"></span>
                                  <div class="cont_add_to_date open_dropdown_{{ $staff_row['cpd_id'] }}_1" style="display:none;">
                                    <ul> 

                                    <!-- <li><a href="javascript:void(0)" class="open_calender_pop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="1">Add/Edit Start Date</a></li> -->
                                   <li>
                                    <span id="view_calender_{{ $staff_row['cpd_id'] }}_1" class="addtocalendar atc-style-blue">
                                      <var class="atc_event">
                                        <var class="atc_date_start">
                                          {{ (isset($staff_row['course_date'] ) && $staff_row['course_date']  != "")?date("d-m-Y", strtotime($staff_row['course_date'] ) ):"" }}

                                          {{ (isset($staff_row['course_time'] ) && $staff_row['course_time'] != "")?date("H:i", strtotime($staff_row['course_time'] ) ):"" }}
                                        </var>
                                        <var class="atc_date_end">
                                          {{ (isset($staff_row['course_date'] ) && $staff_row['course_date']  != "")?date("Y-m-d", strtotime($staff_row['course_date'] ) ):"" }}

                                          {{ (isset($staff_row['course_time'] ) && $staff_row['course_time'] != "")?date("H:i:s", strtotime('+1 hour', strtotime($staff_row['course_time'] )) ):"" }}
                                        </var>
                                        <var class="atc_timezone">Europe/London</var>
                                        <var class="atc_title">{{$title}} - {{$staff_row['course_name'] or ""}}</var>
                                        <var class="atc_description">{{$title}} - {{$staff_row['course_name'] or ""}}</var>
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

                              <td align="center"> {{ $staff_row['course_duration'] or ""}}</td>
                              <td align="left"><a href="#" id="coursename" data-courseid= "{{ $staff_row['cpd_id'] }}">{{ $staff_row['course_name'] or ""}}</a></td>
                              
                              <td align="center">
                                @if(!empty($staff_row['attendees']))
                                 <select class="form-control newdropdown" name="staff_id" id="staff_id">
                                  @foreach($staff_row['attendees'] as $key=>$staff_rows)
                                  
                                  <option value="{{ $key}}">{{ $staff_rows['name'] }}</option>
                                  @endforeach
                                </select> 
                                @endif
                              </td>
                                      
                              <td align="center">
                                @if ( (isset($staff_row['add_file'])) && (!empty($staff_row['add_file'])) )
                                <a href="/uploads/cpd/{{ $staff_row['add_file'] or '' }}" download target="_blank">
                                  <img src="/img/attachment.png" width="15">
                                </a>
                                @endif
                              </td>
                                      
                              <td align="center">
                                @if(empty($staff_row['notes']))
                                  <a href="javascript:void(0)" id="coursesnotesopen" data-id="{{ $staff_row['cpd_id'] or "" }}"  data-target="#coursesnotes-modal"><span class="notes_btn">notes</span></a>
                                    @endif
                                @if(!empty($staff_row['notes']))
                                  <a href="javascript:void(0)" id="coursesnotesopen" data-id="{{ $staff_row['cpd_id'] or "" }}"  data-target="#coursesnotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="notes_btn">notes</span></a>
                                @endif       
                              </td>
                            </tr>
                                    @endif
                                  
                                  @endforeach  
                                       @endif
                                  </tbody>
                                </table></td>
                            </tr>
                          </table>
                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  @if($staff_type== 'profile')
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                          <!--start table-->
                          <table width="100%" border="0" class="staff_holidays">
                            
                            <tr>
                              <td valign="top">
                              
                               <table class="table table-bordered table-hover dataTable" id="example1" width="100%">
                               
                                  <thead>
                                    <tr class="table_heading_bg" style="background-color: #fff; color:#000;">
                                      <td width="3%"> Action</td>
                                      <td width="15%"><strong>Courses Date</strong></td>
                                      <td width="5%"><strong>Hrs</strong></td>
                                      <td align="center"><strong>Courses Name</strong></td>
                                      <td width="20%" align="center"><strong>Attendees</strong></td>
                                      <td width="5%" align="center"><strong>Attachments</strong></td>
                                      <td width="8%" align="center">Notes</td>
                                    </tr>
                                    </thead>
                                   <tbody> 
                                              
                                                   
                        @if(!empty($profcourse_report))
						  @foreach($profcourse_report as $key=>$staff_row)
                                   @if($staff_row['is_booked'] == 'Y')    
                                   
                                <tr>
                                  <td align="center"><a href="javascript:void(0)" class="delcourses" data-id="{{ $staff_row['cpd_id'] or "" }}" data-field_name="is_booked"><img src="/img/cross.png"></a></td>
                                  <td align="center">
                                    <div id="edit_calender_{{ $staff_row['cpd_id'] }}_1" class="edit_cal">
                                      <a href="javascript:void(0)" id="date_view_{{ $staff_row['cpd_id'] }}_1" />
                                      {{ (isset($staff_row['course_date']) && $staff_row['course_date'] != "")?date("d-m-Y", strtotime($staff_row['course_date']) ):"" }}

                                      {{ (isset($staff_row['course_time']) && $staff_row['course_time'] != "")?date("H:i", strtotime($staff_row['course_time']) ):"" }}
                                      </a>
                                      <span class="glyphicon glyphicon-chevron-down open_adddrop" data-cpd_id="{{ $staff_row['cpd_id'] or "" }}" data-tab="1"></span>
                                      <div class="cont_add_to_date open_dropdown_{{ $staff_row['cpd_id'] }}_1" style="display:none;">
                                        <ul> 

                                        <!-- <li><a href="javascript:void(0)" class="open_calender_pop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="1">Add/Edit Start Date</a></li> -->
                                       <li>
                                        <span id="view_calender_{{ $staff_row['cpd_id'] }}_1" class="addtocalendar atc-style-blue">
                                          <var class="atc_event">
                                            <var class="atc_date_start">
                                              {{ (isset($staff_row['course_date'] ) && $staff_row['course_date']  != "")?date("d-m-Y", strtotime($staff_row['course_date'] ) ):"" }}

                                              {{ (isset($staff_row['course_time'] ) && $staff_row['course_time'] != "")?date("H:i", strtotime($staff_row['course_time'] ) ):"" }}
                                            </var>
                                            <var class="atc_date_end">
                                              {{ (isset($staff_row['course_date'] ) && $staff_row['course_date']  != "")?date("Y-m-d", strtotime($staff_row['course_date'] ) ):"" }}

                                              {{ (isset($staff_row['course_time'] ) && $staff_row['course_time'] != "")?date("H:i:s", strtotime('+1 hour', strtotime($staff_row['course_time'] )) ):"" }}
                                            </var>
                                            <var class="atc_timezone">Europe/London</var>
                                            <var class="atc_title">{{$title}} - {{$staff_row['course_name'] or ""}}</var>
                                            <var class="atc_description">{{$title}} - {{$staff_row['course_name'] or ""}}</var>
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
                              
                                    <td align="center"> {{ $staff_row['course_duration'] or ""}}</td>
                                    
                                    
  
                                    
                                    
                                  <td align="left"><a href="#" id="coursename" data-courseid= "{{ $staff_row['cpd_id'] }}">{{ $staff_row['course_name'] or ""}}</a></td>
                                  <td align="center">
                                    @if(!empty($staff_row['attendees']))
                                      <select class="form-control newdropdown" name="staff_id" id="staff_id">
                                      @foreach($staff_row['attendees'] as $key=>$staff_rows)
                                        <option value="{{ $key}}">{{ $staff_rows['name'] }}</option>
                                      @endforeach
                                      </select> 
                                    @endif
                                  </td>
                                      
                                                                   
                        <td align="left">
                          @if ( (isset($staff_row['add_file'])) && (!empty($staff_row['add_file'])) )
                            <a href="/uploads/cpd/{{ $staff_row['add_file'] or '' }}" target="_blank" download>
                              <img src="/img/attachment.png" width="15">
                            </a>
                          @endif
                        </td>
                                      
                      <td align="center">
                                     
                                     
              
                                   @if(empty($staff_row['notes']))
                                    
                                    <a href="javascript:void(0)" id="coursesnotesopen" data-id="{{ $staff_row['cpd_id'] or "" }}"  data-target="#coursesnotes-modal"><span class="notes_btn">notes</span></a>
                                    @endif
                                     
                                    
                                    
                                   @if(!empty($staff_row['notes']))
                                    <a href="javascript:void(0)" id="coursesnotesopen" data-id="{{ $staff_row['cpd_id'] or "" }}"  data-target="#coursesnotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="notes_btn">notes</span></a>
                                    
                                  
                                    
                                     
                                   @endif       
                                     
                                     
                                     
                                     
                                     
                                     
                                     </td>
              
                                </tr>
                                    
                                  @endif
                                  @endforeach  
                                       @endif
                                  </tbody>
                                </table></td>
                            </tr>
                          </table>
                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  
                  
                  <!--end table-->
                </div>
                <!-- /.tab-pane -->
                <div id="tab_2" class="tab-pane {{ ($page_open == 2)?'active':'' }}">
                  @if($staff_type== 'staff')
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                          <!--start table-->
                          <table width="100%" border="0" class="staff_holidays">
                            <tr>
                              <td valign="top">
                                <table class="table table-bordered table-hover dataTable" id="example2" width="100%">
                                  <thead>
                                    <tr class="table_heading_bg" style="background-color: #fff; color:#000;">
                                      <td width="3%"> Action</td>
                                      <td width="15%"><strong>Courses Date</strong></td>
                                      <td width="5%"><strong>Hrs</strong></td>
                                      <td align="center"><strong>Courses Name</strong></td>
                                      <td width="20%" align="center"><strong>Attendees</strong></td>
                                      <td width="5%" align="center"><strong>Attachments</strong></td>
                                      <td width="8%" align="center">Notes</td>
                                    </tr>
                                    </thead>
                                   <tbody> 
                                @if(!empty($course_report))
                                  @foreach($course_report as $key=>$report_row)
                                    @if(isset($report_row['is_log']) && $report_row['is_log'] == 'Y' && is_array($report_row['user_id']) && in_array($user_id, $report_row['user_id']) ) {
                                    <tr>
                                      <td align="center"><a href="javascript:void(0)" class="delcourses" data-id="{{ $report_row['cpd_id'] or '' }}" data-field_name="is_log"><img src="/img/cross.png"></a></td>

                                      <td align="left">
                                        <div id="edit_calender_" class="edit_cal">
                                          <a href="javascript:void(0)" id="date_view_" />{{ $report_row['course_date'] or ""}} {{ $report_row['course_time'] or ""}}</a>
                                        </div>
                                      </td>
                                      <td align="center">{{ $report_row['course_duration'] or ""}}</td>
                                      <td align="left">{{ $report_row['course_name'] or ""}}</td>
                                      <td align="center">
                                        <select class="form-control newdropdown" name="staff_id" id="staff_id">
                                          @if(!empty($staff_details))
                                            @foreach($staff_details as $key=>$staff_row)
                                            <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                                            @endforeach
                                          @endif
                                        </select> 
                                      </td>
                                                          
                                      <td align="center">
                                        @if( isset($report_row['add_file']) && $report_row['add_file'] != "" )
                                          <a href="/uploads/cpd/{{ $report_row['add_file'] or '' }}" target="_blank" download>
                                            <img src="/img/attachment.png" width="15">
                                          </a>
                                        @endif
                                      </td>
                                      <td align="center"><a href="javascript:void(0)" class="tasknotesopen" data-id="{{ $report_row['cpd_id'] or ''}}"><span class="notes_btn">Notes</span></a>
                                      </td>
                                    </tr>
                                    @endif
                                    @endforeach  
                                  @endif
                                  </tbody>
                                </table></td>
                            </tr>
                          </table>
                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
                  
                  @if($staff_type== 'profile')
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                          <!--start table-->
                          <table width="100%" border="0" class="staff_holidays">
                            
                            <tr>
                              
                              
                               <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
                               
                                  <thead>
                                    <tr class="table_heading_bg" style="background-color: #fff; color:#000;">
                                      <td width="3%"> Action</td>
                                      <td width="15%"><strong>Courses Date</strong></td>
                                      <td width="5%"><strong>Hrs</strong></td>
                                      <td align="center"><strong>Courses Name</strong></td>
                                      <td width="20%" align="center"><strong>Attendees</strong></td>
                                      <td width="5%" align="center"><strong>Attachments</strong></td>
                                      <td width="8%" align="center">Notes</td>
                                    </tr>
                                    </thead>
                                   <tbody>
                                   
                                   
                        @if(!empty($course_report))
            						  @foreach($course_report as $key=>$report_row)
                            @if($report_row['is_tracker'] == 'Y')
                            <tr>
                              <td align="center"><a href="javascript:void(0)" class="delcourses" data-id="{{ $report_row['cpd_id'] or ""}}" data-field_name="is_tracker"><img src="/img/cross.png"></a></td>

                              <td align="left">
                                <div id="edit_calender_" class="edit_cal">
                                  <a href="javascript:void(0)" id="date_view_" />{{ $report_row['course_date'] or ""}} {{ $report_row['course_time'] or ""}}</a>
                                </div>
                              </td>
                              <td align="center">{{ $report_row['course_duration'] or ""}}</td>
                              <td align="left">{{ $report_row['course_name'] or ""}}</td>
                              <td align="center">
                                <select class="form-control newdropdown" name="staff_id" id="staff_id">
                                  @if(!empty($staff_details))
                                    @foreach($staff_details as $key=>$staff_row)
                                    <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                                    @endforeach
                                  @endif
                                </select> 
                              </td>
                                                  
                              <td align="center">
                                @if( isset($report_row['add_file']) && $report_row['add_file'] != "" )
                                  <a href="/uploads/cpd/{{ $report_row['add_file'] or '' }}" target="_blank" download>
                                    <img src="/img/attachment.png" width="15">
                                  </a>
                                @endif
                              </td>
                              <td align="center"><a href="javascript:void(0)" class="tasknotesopen" data-id="{{ $report_row['cpd_id'] or ''}}"><span class="notes_btn">Notes</span></a>
                              </td>
                            </tr>
                            @endif                   
                                              
                                @endforeach  
                                     @endif
                                                                                                        
                                </tbody>
                              </table></td>
                          </tr>
                          </table>
                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
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
<!-- ./wrapper -->
<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:600px;">
    <div class="modal-content">
      {{ Form::open(array('url' => '/insertcpd', 'files' => true, 'id'=>'insertcpdform')) }}
      <input type="hidden" name="page_open" value="{{ $page_open or '' }}">
      <input type="hidden" name="type" value="{{ $type or '' }}">
    <!--  <form action="#" method="post"> -->
      <div class="modal-body" >
      <div class="show_loader"></div>
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span class="tsk_con">Add New Course</span>
               <div class="clr"></div>
            <hr />

              <!-- <span class="crs_con"><strong>Course Name</strong></span>
              <span><input id="name" class="form-control" name="coursename" type="text" style="height: 29px; width:300px; float:left; margin-bottom: 20px;"></span>
              <div class="clr"></div> -->
              <span class="crs_con"><strong>Course Name <a href="javascript:void(0)" class="course_name-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></strong></span>
              <span>
                <select class="form-control" id="name" name="coursename" style="height: 32px; width:300px; float:left; margin-bottom: 20px;">
                  <option value="">-- select --</option>
                  @if(isset($courses_name) && count($courses_name) > 0)
                    @foreach($courses_name as $key=>$value)   
                      <option value="{{ $value['cname_id'] or '' }}">{{ $value['course_name'] or '' }}</option>  
                    @endforeach
                  @endif
                </select>
              </span>
              <div class="clr"></div>
                     
                    
                    <span class="crs_con"><strong>Course Date</strong></span>
                    <span><input id="calender_date" class="form-control" name="coursedate" type="text" style="height: 29px; width:300px; float:left; margin-bottom: 20px;"  placeholder=""></span>
                    <div class="clr"></div>
                    
                    
                    <span class="crs_con"><strong>Course Time</strong></span>
                    <span><input id="courses_time" name="coursetime" class="form-control" type="text" style="height: 29px; width:100px; float:left; margin-bottom: 20px;"></span>
                    
                    <span class="crs_con" style="padding-left: 10px;"><strong>Duration</strong></span>
                    <span><input id="courseduration" name="courseduration" class="form-control" type="text" style="height: 29px; width:100px; float:left; margin-bottom: 20px;" ></span>
                    <span class="crs_con" style="padding-left: 10px;">hrs</span>
                    <div class="clr"></div>
                    
                    
                    <span class="crs_con"><strong>Note</strong></span>
                    <span><textarea id="notesid" style="width:300px; float:left; background: #fff; border:#ccc solid 1px;" name="coursenotes" cols="30" rows="5"></textarea></span>
                    <div class="clr"></div>      
        
        

          <div class="save_btncon">
            <div class="left_side" style="padding-bottom: 22px;">

              <span class="urgnt_con">Attachment</span>
              <span><input type="file" name="add_file" /></span>


              <div class="clr"></div>
            </div>
            <div class="email_btns2" style="width:272px;">

          <button data-dismiss="modal" class="btn btn-danger pull-left save_t" id="save" name="save" type="button">Cancel</button>


           <button  class="btn btn-primary saveCpdCource" type="button">Save</button>



        </div>
            <div class="clearfix"></div>
          </div>
         <strong>Attendees</strong>
          
          @if(!empty($staff_details))
            @foreach($staff_details as $key=>$staff_row)
            <input type="checkbox" name="satff[]" id="" value="{{ $staff_row['user_id'] }}" />
            {{ $staff_row['fname'] }} {{ $staff_row['lname'] }}
            @endforeach
          @endif
          

          </div>
          
          {{ Form :: close() }}
     <!-- </form> -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="coursesnotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
      <div style="width:100%;">
        <label for="f_name" style="font-size: 18px;">Notes</label>
          <textarea rows="4" cols="52" class="notescourse" name="notescourse" id="notescourse" ></textarea>
         
         
     <!--     <button class="btn btn-primary" onclick="return fetchnotes()" id="fetchsave_notes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%; ">Save</button> -->  
          <div class="clr"></div>       
         </div>
        </div>
        
       
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="editcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:600px;">
    <div class="modal-content">
      {{ Form::open(array('url' => '/editcpd', 'files' => true, 'id'=>'basicform')) }}
    <!--  <form action="#" method="post"> -->
      <div class="modal-body" >
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <div style="">
          <div style="top_con1">

                <span class="tsk_con">Edit New Course</span>
               <!-- <span class="urgnt_con">Urgent?</span>
                <span class="rad_butt"><input type="radio" name="urgent" value="Yes"  />Yes</span>
                <span class="rad_butt"><input type="radio" name="urgent" value="No"  />No</span>
                <span></span> -->
                <div class="clr"></div>

              </div>
          </div>
          <hr />

          <div style="">

              <form>
              <input type="hidden" name="edit_id" id="editid" value="" />
                    <!-- <span class="crs_con"><strong>Course Name</strong></span>
                    <span><input id="edittaskname" class="form-control" name="editcoursename" type="text" style="height: 29px; width:300px; float:left; margin-bottom: 20px;" name="edittaskname" placeholder=""></span> -->
                    <span class="crs_con"><strong>Course Name <a href="javascript:void(0)" class="course_name-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></strong></span>
                    <span>
                      <select class="form-control" id="edittaskname" name="editcoursename" style="height: 32px; width:300px; float:left; margin-bottom: 20px;">
                        <option value="">-- select --</option>
                        @if(isset($courses_name) && count($courses_name) > 0)
                          @foreach($courses_name as $key=>$value)   
                            <option value="{{ $value['cname_id'] or '' }}">{{ $value['course_name'] or '' }}</option>  
                          @endforeach
                        @endif
                      </select>
                    </span>
                    <div class="clr"></div>
                     
                    
                    <span class="crs_con"><strong>Course Date</strong></span>
                    <span><input id="editcalender_date" class="form-control" name="editcoursedate" type="text" style="height: 29px; width:300px; float:left; margin-bottom: 20px;"  placeholder=""></span>
                    <div class="clr"></div>
                    
                    
                    <span class="crs_con"><strong>Course Time</strong></span>
                    <span><input id="editcourses_time" name="editcoursetime" class="form-control" type="text" style="height: 29px; width:100px; float:left; margin-bottom: 20px;"></span>
                    
                    <span class="crs_con" style="padding-left: 10px;"><strong>Duration</strong></span>
                    <span><input id="editcourseduration" name="editcourseduration" class="form-control" type="text" style="height: 29px; width:100px; float:left; margin-bottom: 20px;" ></span>
                    <span class="crs_con" style="padding-left: 10px;">hrs</span>
                    <div class="clr"></div>
                    
                    
                    <span class="crs_con"><strong>Note</strong></span>
                    <span><textarea id="editnotesid" style="width:300px; float:left; background: #fff; border:#ccc solid 1px;" name="editcoursenotes" cols="30" rows="5"></textarea></span>
                    <div class="clr"></div>
             
        
        
        
              </form>
        
        
        

          <div class="save_btncon">
            <div class="left_side" style="padding-bottom: 22px;">

              <span class="urgnt_con">Attachment</span>
              <span><input type="file" name="edit_file" /></span>


              <div class="clr"></div>
            </div>
            <div class="email_btns2" style="width:272px;">

          <button data-dismiss="modal" class="btn btn-danger pull-left save_t" id="save" name="save" type="button">Cancel</button>


           <button  class="btn btn-primary" type="submit">Save</button>



        </div>
            <div class="clearfix"></div>
          </div>
         <strong>Attendees</strong>
          
         @if(!empty($staff_details))
            @foreach($staff_details as $key=>$staff_row)
              <input type="checkbox" class="attendeess" name="attendeeschecked[]" id="attendees{{ $staff_row['user_id'] }}" value="{{ $staff_row['user_id'] }}" <?php //if($val['user_id']==$check){ checked; } ?> />
                        
                        
                 <!--    <input type="hidden" name="chknotify[]" id="chknotify{{ $staff_row['user_id'] }}" value="{{ $staff_row['user_id'] }}" />
							
                     <input type="hidden" name="chknotifychk[]" id="chknotifychknotifychk" value="{{ $staff_row['user_id'] }}" /> -->
                      {{ $staff_row['fname'] }} {{ $staff_row['lname'] }}
								
                  
                  
                  
                  
                  <!--
                  <input type="checkbox" name="satff" id="" value="{{ $staff_row['user_id'] }}" id="staffchk" />
                  {{ $staff_row['fname'] }} {{ $staff_row['lname'] }} -->
          @endforeach
                @endif
          
          </div>
          </div>
          
          {{ Form :: close() }}
     <!-- </form> -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade in" id="opencoursename-modal" tabindex="-1" role="dialog" aria-hidden="false">
  <div class="modal-dialog" style="width:400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    <form method="POST" action="/cpd/add-course-name" accept-charset="UTF-8" id="field_form">
    <!-- <input type="hidden" name="client_type" id="client_type" value="org"> -->
    <div class="show_loader"></div>
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Course Name</label>
        <input type="text" id="course_name" name="course_name" class="txtlft form-control">
        <button type="button" class="btn btn-info pull-left save_t" id="save_course_name" name="save">Add</button>
        <div class="clearfix"></div>
      </div>
      
      <div id="append_bussiness_type">
        <div class="pop_list form-group">
          Course Name List
        </div>
      
        @if(isset($courses_name) && count($courses_name) > 0)
          @foreach($courses_name as $key=>$value)      
        <div class="pop_list form-group" id="hide_div_{{ $value['cname_id'] or '' }}">
          <a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_org_name" data-field_id="{{ $value['cname_id'] or '' }}"><img src="/img/cross.png" width="12"></a>
          {{ $value['course_name'] or '' }}
        </div>
          @endforeach
        @endif
      </div>
      
      <!-- <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="add_business_type" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div> -->
    </div>
    </form>
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@stop