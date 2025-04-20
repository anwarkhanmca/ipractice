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
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/checklist.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="{{ URL :: asset('js/jquery-ui.min.js') }}"></script>
<!-- Date picker script -->

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->

<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
$(".made_up_date").datepicker({ minDate: new Date(1900, 12-1, 25), maxDate:0, dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: "-10:+10" });

$(".addto_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-5:+100" });

$(function() {
  $('#example2').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
      "iDisplayLength": 50,
      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false}
      ],
      //"aaSorting": [[1, 'desc']]

  });


$('#calender_time').timepicki({
  show_meridian:false,
  //min_hour_value:0,
  max_hour_value:23,
  //step_size_minutes:15,
  //overflow_minutes:true,
  increase_direction:'up'
  //disable_keyboard_mobile: true
});



});

</script>

<script src="{{ URL :: asset('js/jquery.form.js') }}"></script>
@stop

@section('content')
<input type="hidden" id="custom_check_id" value="{{ $check_id or '0' }}" />
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @include('layouts.outer_leftside')
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side  {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')

                <!-- Main content -->
                <section class="content">
                <div class="row">
                  <div class="top_bts">
                    <ul>
                        <li>
                            <button class="btn btn-success" onclick="pdfonboard();"><i class="fa fa-download"></i> Generate PDF</button> 
                        </li>
                        <li>
                            <button class="btn btn-primary" onclick="excelonboard();"><i class="fa fa fa-file-text-o"></i> Excel</button> 
                        </li>
                        <div class="clearfix"></div>
                    </ul>
                  </div>
                  <div id="message_div" style="margin-left: 700px;"><!-- Loader image show while sync data --></div>
                  <!-- <div style="float: right; margin-right: 43px;"><a href="javascript:void(0)" id="archive_div">Show Archived</a></div> -->

                </div>
      <div class="practice_mid">
          <div class="tabarea">
            <div class="tab_topcon">
              <div class="top_bts" style="float:left;">
                <ul style="padding:0;">
                  <li>
                    <button type="button" id="deleteOnboarding" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
                  </li>
                  <li>
                    <a href="javascript:void(0)" class="btn btn-warning positionopen" data-custom_check_id="{{ $check_id or '0' }}">Checklist</a>
                  </li>
                  <li>
                    <a href="javascript:void(0)" id="TablePopOpen" class="btn btn-info">Add To Table</a>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              <!--<div class="top_search_con">
               <div class="top_bts">
                <ul style="padding:0;">
                  <li>
                    <button type="button" id="" style="  width: 95px;" class="btn btn-warning">AML</button>
                  </li>
                  <li>
                    <a href="/hmrc/authorisations"  class="btn btn-info" style="width: 95px;">64-8</a>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              </div>-->
              <div class="clearfix"></div>

            </div>
            
    <div class="box-body table-responsive">
     <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
         <div class="row">
             <div class="col-xs-6"></div>
             <div class="col-xs-6"></div>
         </div>
        <table class="table table-bordered table-hover dataTable" id="example2" width="100%">
            <thead>
              <tr role="row">
                <th align="center" width="3%"><input type="checkbox" id="allCheckSelect"/></th>
                <th align="center" width="8%">Add Date</th>
                <th align="center" width="20%">Added By</th>
                <th align="center">Checklist Item</th>
                <th align="center" width="8%">% Completed</th>
                <th align="center" width="6%">Notes</th>
              </tr>
            </thead>
            @if(isset($checkDetails) && count($checkDetails) >0)
                @foreach($checkDetails as $key=>$value)
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    <td align="center"><input type="checkbox" class="ads_Checkbox" name="delete_id[]" value="{{ $value['checklist_id'] or '' }}"/></td>
                    <td align="left">{{ $value['created'] or '' }}</td>
                    <td align="left">{{ $value['staff_name'] or '' }}</td>
                    <td align="left"><a href="javascript:void(0)" class="openCheckPop" data-date="{{ date('d-m-Y',strtotime($value['created'])) }}" data-itemName="{{ $value['name'] or ''}}" data-checklist_id= "{{ $value['checklist_id'] }}">{{ $value['name'] or '' }}</a></td>
                    <td align="center">{{ $value['percentage'] or '' }}%</td>
                    <td align="center"><button class="notes_btn notesmodal" data-tablechecklist_id="{{ $value['checklist_id'] or '' }}" data-position="table"><span class="requ_t">notes</span></button></td>
                </tbody>
                @endforeach
            @endif
          </table>
        </div>
    </div>
            
            
            
</div>
      </div>
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
     
        
        
        
<div class="modal fade" id="openCheckPop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1100px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align: center;" id="check_title"></h4>
        <div class="clearfix"></div>
      </div>

    {{ Form::open(array('url' => '/checklist/insert-onboarding', 'id'=>'onboardingForm')) }}
    <input type="hidden" id="popchecklist_id" name="popchecklist_id" value="0">
    <input type="hidden" id="custom_checklist_id" name="custom_checklist_id" value="{{ $check_id or '0' }}">
    <input type="hidden" id="checklist_id" name="checklist_id" value="0">
      <div class="modal-body">
        <div class="show_loader"><!-- Show loader --></div>
        <div class="practice_mid">
            <div class="tabarea" id="BoxTable">
                <!-- Ajax Call -->
            </div> 
        </div>
        <div class="modal-footer1 clearfix">
            <div class="email_btns">
              <button type="button" class="btn btn-info pull-left save_t" id="saveOnbording" name="save">Submit</button>
              <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
            </div>
        </div>
      </div>
      {{ Form::close() }} 
    
    </div>
  </div>
</div>      

<div class="modal fade" id="checklist-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>              
   {{ Form::open(array('url' => '/client/add-checklist', 'id'=>'field_form')) }}
    <div class="modal-body">
      <div class="show_loader"></div>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="checklist" id="checklist" placeholder="Checklist" class="form-control">
      </div>
      
      <div id="append_position_type">
      
      </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <a href="javascript:void(0)" class="btn btn-info pull-left save_t" data-client_type="org" id="add_sub_checklist">Save</a>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }} 
    </div>
  </div>
</div> 
        
<div class="modal fade" id="checkTable-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to Table</h4>
        <div class="clearfix"></div>
      </div>              
   {{ Form::open(array('url' => '/checklist/add-checklist', 'id'=>'field_form')) }}
    <div class="modal-body">
      <div class="show_loader"></div>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="table_item" id="table_item" placeholder="Checklist Item" class="form-control">
      </div>
      
     <!-- <div id="append_position_type">
      
      </div>-->
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <a href="javascript:void(0)" class="btn btn-info pull-left save_t" data-client_type="org" id="add_table_data">Save</a>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }} 
    </div>
  </div>
</div>
        
<div class="modal fade" id="checknotes-modal" tabindex="1" role="dialog" aria-hidden="true">
    <input type="hidden" id="tablechecklist_id" name="tablechecklist_id" value="">
    <input type="hidden" id="position" name="position" value="">
    <input type="hidden" id="key" name="key" value="">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">      
      <div class="modal-body">
         <div class="show_loader"></div> 
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
      <div style="width:100%;">
      <h2 style="padding:0px; margin:0px;">
        <label for="f_name" >Notes</label></h2>
        <textarea rows="4"  class="form-control" name="table_notes" id="table_notes" ></textarea>
         <div class="clr"></div>   
          <button class="btn btn-info" id="save_table_notes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right;">Save</button>   
               
         </div>
          <div class="clr"></div>   
        </div>
    </div>
  </div>
</div>
        
<div class="modal fade" id="addto_calender-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:410px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD JOB START DATE</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/onboarding/add-task-date', 'id'=>'field_form')) }}
      <div class="modal-body">
        <div id="start_date_loader" style="text-align: center; padding-bottom: 10px;"><!-- Show loader --></div>
        <input type="hidden" id="calender_client_id" name="calender_client_id">
        <input type="hidden" id="cleinttaskdate_id" name="cleinttaskdate_id">
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
            <td align="right">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> 
                <button type="button" class="btn btn-info save_job_start_date">Save</button></td>
          </tr>
        </table>
      </div>
      {{ Form::close() }} 
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div> 

<!-- Edit Checklist Name -->
    <div class="modal fade" id="edit_task-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" style="width:300px;">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Edit Checklist Name</h4>
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

    

@stop