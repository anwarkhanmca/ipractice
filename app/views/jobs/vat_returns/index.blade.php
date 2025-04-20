@extends('layouts.layout')

@section('mycssfile')
  <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/jobs.js') }}" type="text/javascript"></script>
<!-- <script src="{{ URL :: asset('js/ch_data.js') }}" type="text/javascript"></script> -->
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
var Table1, Table3;
$(function() {
  Table1 = $('#example1').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[10, 25, 50, -1], [25, 50, 100, 200]],
    "iDisplayLength": 25,

    "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false}
    ]

  });
  Table1.fnSort( [ [6,'asc'] ] );

  for(var k=1; k<=10;k++){
    //var table = Table2+""+k;
    var table = $('#example2'+k).dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[10, 25, 50, -1], [25, 50, 100, 200]],
        "iDisplayLength": 25,

        "aoColumns":[
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false}
        ]

    });
    table.fnSort( [ [3,'asc'] ] );
  }


  Table3 = $('#example3').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[10, 25, 50, -1], [25, 50, 100, 200]],
        "iDisplayLength": 25,

        "aoColumns":[
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true}
        ]

    });
    Table3.fnSort( [ [3,'asc'] ] );

    

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
  <input type="hidden" name="service_id" id="service_id" value="{{ $service_id }}">
    <!-- Content Header (Page header) -->
    @include('layouts.below_header')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="practice_hed">
        <div class="top_bts">
          <ul>
            <!-- <li>
              <button class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            </li>-->
            <li>
              <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button>
            </li>
            <li>
              <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button>
            </li>
            <!-- <li>
              <button class="btn btn-danger">SYNC DATA</button>
            </li>
            
            <li>
              <a href="https://beta.companieshouse.gov.uk" target="_blank" class="btn btn-info">WEBCHECK</a>
            </li> -->

            <div class="clearfix"></div>
          </ul>
        </div>

        <div style="float: right;">
          <table>
            <tr>
              <td width="30%" class="head_txt">Filter By Staff</td>
              <td width="2%">&nbsp;</td>
              <td width="68%">
                <select class="form-control filter_by_staff" name="filter_by_staff" id="filter_by_staff">
                  <option value="{{ base64_encode('all') }}">Show All</option>
                  @if(!empty($staff_details))
                    @foreach($staff_details as $key=>$staff_row)
                      <option value="{{ base64_encode($staff_row['user_id']) }}" {{ (isset($staff_id) && $staff_id == $staff_row['user_id'])?"selected":"" }}>{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                    @endforeach
                  @endif
                  <option value="{{ base64_encode('none') }}">Unassigned</option>
                </select>
              </td>
            </tr>
          </table>
        </div>
      </div>

      </div>
      <div class="practice_mid">
      <input type="hidden" name="page_open" id="page_open" value="{{ $page_open }}">
      <input type="hidden" name="encode_page_open" id="encode_page_open" value="{{ $encode_page_open }}">

          <div class="tabarea">
  
  <div class="nav-tabs-custom">
      <ul class="nav nav-tabs nav-tabsbg">
        <!-- <li class="active"><a data-toggle="tab" href="#tab_1">ANNUAL RETURNS - PERMANENT DATA</a></li>
        <li><a data-toggle="tab" href="#tab_2">ANNUAL RETURNS - TASK MANAGEMENT</a></li>
        <li><a data-toggle="tab" href="#tab_3">COMPLETED TASKS</a></li> -->
        <li class="{{ ($page_open == 1)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('1') }}/{{ base64_encode($staff_id) }}">ANNUAL RETURNS - PERMANENT DATA</a></li>
        <li class="{{ ($page_open != 1 && $page_open != 3)?'active':'' }}"><a href="/vat-returns/{{ base64_encode('21') }}/{{ base64_encode($staff_id) }}">ANNUAL RETURNS - TASK MANAGEMENT</a></li>
        <li class="{{ ($page_open == 3)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('3') }}/{{ base64_encode($staff_id) }}">COMPLETED TASKS</a></li>
      </ul>
<div class="tab-content">
  <div id="tab_1" class="tab-pane {{ ($page_open == 1)?'active':'' }}">
    <div class="tab_topcon" style="position:relative; height: 7px">

      <div class="send_task auto_send">
        <div class=" chk_cont01"><input type='checkbox' id="manage_check" {{ (isset($autosend['days']) && $autosend['days'] != "")?"checked":"" }} /><label for="manage_check"> Auto Send To Task </label></div> 

         <div class="chk_cont02"><input type="text" name="dead_line" id="dead_line" style="width:18%; padding: 0; text-align: center; height: 18px;" value="{{ $autosend['days'] or "" }}"  {{ (isset($autosend['days']) && $autosend['days'] != "")?"disabled":"" }} /> <label for=""> Days Before Deadline </label></div>
      </div>

      <div class="clearfix"></div>
    </div>
    <table class="table table-bordered table-hover dataTable jobs" id="example1" aria-describedby="example1_info">
      <thead>
        <tr role="row">
          <th><span class="custom_chk"><input type='checkbox' id="CheckallCheckbox" /></span></th>
          <th>STAFF</th>
          <th>DOR</th>
          <th>VAT SCHEME</th>
          <th>VAT NUMBER</th>
          <th>RETURN FREQUENCY</th>
          <th>BUSINESS NAME</th>
          <th>VAT STAGGER</th>
          <th>LAST PERIOD FILED</th>
          <th>SEND TO TASKS</th>
        </tr>
      </thead>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if((isset($details['services_id']) && in_array($service_id, $details['services_id'])))
            <tr class="even">
                <td><span class="custom_chk"><input type='checkbox' class="checkbox" name="checkbox[]" value="{{ $details['client_id'] or "" }}"/></span></td>
                <td class="sorting_1" align="center"></td>
                <td align="center">{{ isset($details['effective_date'])?date("d-m-Y", strtotime($details['effective_date'])):"" }}</td>
                <td align="left">{{ $details['vat_scheme'] or "" }}</td>
                <td align="center">{{ $details['vat_number'] or "" }}</td>
                <td align="center">{{ isset($details['ret_frequency'])?ucwords($details['ret_frequency']):"" }}</td>
                <td align="center"><a href="/client/edit-org-client/{{ $details['client_id'] }}">{{ $details['business_name'] or "" }}</a></td>
                <td align="center">{{ $details['vat_stagger'] or "" }}</td>
                <td align="center"></td>
                <td align="center" id="after_send_{{ $details['client_id'] }}">
                  @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "N")
                    <button type="button" class="send_btn send_manage_task" data-client_id="{{ $details['client_id'] }}" data-field_name="ch_manage_task">Send</button>
                  @else
                    <button type="button" class="sent_btn">Sent</button>
                  @endif
                </td>
            </tr>
          @endif 
        @endforeach
      @endif
      
    </tbody>
  </table>

  </div>

  <div id="tab_2" class="tab-pane {{ ($page_open != 1 && $page_open != 3)?'active':'' }}">
    <ul class="nav nav-tabs nav-tabsbg">
        <li class="{{ ($page_open == 21)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('21') }}/{{ base64_encode($staff_id) }}">All [<span id="task_count_21">{{ $all_count }}</span>]</a></li>
        <li class="{{ ($page_open == 22)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('22') }}/{{ base64_encode($staff_id) }}">Not Started [<span id="task_count_22">{{ ($not_started_count >0 )?$not_started_count:"0" }}</span>]</a></li>
        @if(isset($jobs_steps) && count($jobs_steps) >0)
          <?php $i = 3;?>
            @foreach($jobs_steps as $key=>$value)
              <li class="header_step_{{ $value['step_id']}} {{ ($page_open == '2'.$i)?'active':'' }}" style="display: {{ ($value['status'] == 'H')?'none':'block'}}"><a href="{{ $goto_url }}/{{ base64_encode('2'.$i) }}/{{ base64_encode($staff_id) }}"><span id="step_field_{{ $value['step_id']}}">{{ $value['title'] or "" }}</span> [<span id="task_count_2{{$i}}">{{ $value['count'] or "0" }}</span>]</a></li>
              <?php $i++;?>
            @endforeach
        @endif
        
    </ul>
    
  <div class="tab-content">

  <div id="tab_21" class="tab-pane top_margin {{ ($page_open == '21')?'active':'' }}">
    
    <table class="table table-bordered table-hover dataTable ch_returns" id="example21" aria-describedby="example21_info">
      <thead>
        <tr role="row">
          <th>DELETE</th>
          <th>STAFF</th>
          <th>BUSINESS TYPE</th>
          <th>BUSINESS NAME</th>
          <th>VAT NUMBER</th>
          <th>VAT STAGGER</th>
          <th>VAT PERIOD</th>
          <th width="13%">STATUS <a href="#" data-toggle="modal" data-target="#status-modal">Add/Edit list</a></th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if((isset($details['services_id']) && in_array($service_id, $details['services_id'])))
            @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y")
              <tr id="data_tr_{{ $details['client_id'] }}_21">
                <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-tab="1"><img src="/img/cross.png"></a></td>
                <td align="left"></td>
                <td align="left">{{ $details['business_type'] or "" }}</td>
                <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}">{{ $details['business_name'] or "" }}</a></td>
                <td align="left">{{ $details['vat_number'] or "" }}</td>
                <td align="left">{{ $details['vat_stagger'] or "" }}</td>
                <td align="left"></td>
                <td align="center" width="12%">
                  <input type="hidden" name="prev_status_{{ $details['client_id'] }}" id="prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$service_id]['status_id'] or "" }}">
                  <select class="table_select status_dropdown" id="status_dropdown" data-client_id="{{ $details['client_id'] }}">
                    <option value="2">Not Started</option>
                    @if(isset($jobs_steps) && count($jobs_steps) >0)
                      @foreach($jobs_steps as $key=>$value)
                        <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $value['step_id']) && (isset($details['job_status'][$service_id]['client_id']) && $details['job_status'][$service_id]['client_id'] == $details['client_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                      @endforeach
                    @endif
                  </select>
                </td>
              </tr>
            @endif 
          @endif
        @endforeach
      @endif
        
      </tbody>
    </table>
    </div>
           
    <div id="tab_22" class="tab-pane top_margin {{ ($page_open == '22')?'active':'' }}">
      <table class="table table-bordered table-hover dataTable ch_returns" id="example22" aria-describedby="example22_info">
      <thead>
        <tr role="row">
          <th>DELETE</th>
          <th>STAFF</th>
          <th>BUSINESS TYPE</th>
          <th>BUSINESS NAME</th>
          <th>VAT NUMBER</th>
          <th>VAT STAGGER</th>
          <th>VAT PERIOD</th>
          <th width="13%">STATUS <a href="#" data-toggle="modal" data-target="#status-modal">Add/Edit list</a></th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if((isset($details['services_id']) && in_array($service_id, $details['services_id'])))
            @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y")
              @if(!isset($details['job_status'][$service_id]['status_id']))
              <tr id="data_tr_{{ $details['client_id'] }}_21">
                <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-tab="1"><img src="/img/cross.png"></a></td>
                <td align="left"></td>
                <td align="left">{{ $details['business_type'] or "" }}</td>
                <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}">{{ $details['business_name'] or "" }}</a></td>
                <td align="left">{{ $details['vat_number'] or "" }}</td>
                <td align="left">{{ $details['vat_stagger'] or "" }}</td>
                <td align="left"></td>
                <td align="center" width="12%">
                  <input type="hidden" name="prev_status_{{ $details['client_id'] }}" id="prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$service_id]['status_id'] or "" }}">
                  <select class="table_select status_dropdown" id="status_dropdown" data-client_id="{{ $details['client_id'] }}">
                    <option value="2">Not Started</option>
                    @if(isset($jobs_steps) && count($jobs_steps) >0)
                      @foreach($jobs_steps as $key=>$value)
                        <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $value['step_id']) && (isset($details['job_status'][$service_id]['client_id']) && $details['job_status'][$service_id]['client_id'] == $details['client_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                      @endforeach
                    @endif
                  </select>
                </td>
              </tr>
              @endif
            @endif 
          @endif
        @endforeach
      @endif
        
      </tbody>
    </table>  
    </div>
     
    @for($k=3; $k <= 9;$k++)                          
    <div id="tab_2{{$k}}" class="tab-pane top_margin {{ ($page_open == '2'.$k)?'active':'' }}">
      <table class="table table-bordered table-hover dataTable ch_returns" id="example2{{$k}}" aria-describedby="example2{{$k}}_info">
      <thead>
        <tr role="row">
          <th>DELETE</th>
          <th>STAFF</th>
          <th>BUSINESS TYPE</th>
          <th>BUSINESS NAME</th>
          <th>VAT NUMBER</th>
          <th>VAT STAGGER</th>
          <th>VAT PERIOD</th>
          <th width="13%">STATUS <a href="#" data-toggle="modal" data-target="#status-modal">Add/Edit list</a></th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if((isset($details['services_id']) && in_array($service_id, $details['services_id'])))
            @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y")
              @if(isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $k)
              <tr id="data_tr_{{ $details['client_id'] }}_21">
                <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-tab="1"><img src="/img/cross.png"></a></td>
                <td align="left"></td>
                <td align="left">{{ $details['business_type'] or "" }}</td>
                <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}">{{ $details['business_name'] or "" }}</a></td>
                <td align="left">{{ $details['vat_number'] or "" }}</td>
                <td align="left">{{ $details['vat_stagger'] or "" }}</td>
                <td align="left"></td>
                <td align="center" width="12%">
                  <input type="hidden" name="prev_status_{{ $details['client_id'] }}" id="prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$service_id]['status_id'] or "" }}">
                  <select class="table_select status_dropdown" id="status_dropdown" data-client_id="{{ $details['client_id'] }}">
                    <option value="2">Not Started</option>
                    @if(isset($jobs_steps) && count($jobs_steps) >0)
                      @foreach($jobs_steps as $key=>$value)
                        <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $value['step_id']) && (isset($details['job_status'][$service_id]['client_id']) && $details['job_status'][$service_id]['client_id'] == $details['client_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                      @endforeach
                    @endif
                  </select>
                </td>
              </tr>
              @endif
            @endif
          @endif
        @endforeach
      @endif
        
      </tbody>
    </table> 
    </div>
    @endfor     
    <div id="tab_210" class="tab-pane {{ ($page_open == '210')?'active':'' }} top_margin">
      <table class="table table-bordered table-hover dataTable ch_returns" id="example210" aria-describedby="example210_info">
      <thead>
        <tr role="row">
          <th>DELETE</th>
          <th>STAFF</th>
          <th>BUSINESS TYPE</th>
          <th>BUSINESS NAME</th>
          <th>VAT NUMBER</th>
          <th>VAT STAGGER</th>
          <th>VAT PERIOD</th>
          <th width="13%">STATUS <a href="#" data-toggle="modal" data-target="#status-modal">Add/Edit list</a></th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if((isset($details['services_id']) && in_array($service_id, $details['services_id'])))
            @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "N")
              @if(isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == 10)
              <tr id="data_tr_{{ $details['client_id'] }}_21">
                <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-tab="1"><img src="/img/cross.png"></a></td>
                <td align="left"></td>
                <td align="left">{{ $details['business_type'] or "" }}</td>
                <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}">{{ $details['business_name'] or "" }}</a></td>
                <td align="left">{{ $details['vat_number'] or "" }}</td>
                <td align="left">{{ $details['vat_stagger'] or "" }}</td>
                <td align="left"></td>
                <td align="center" width="12%">
                  <input type="hidden" name="prev_status_{{ $details['client_id'] }}" id="prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$service_id]['status_id'] or "" }}">
                  <select class="table_select status_dropdown" id="status_dropdown" data-client_id="{{ $details['client_id'] }}">
                    <option value="2">Not Started</option>
                    @if(isset($jobs_steps) && count($jobs_steps) >0)
                      @foreach($jobs_steps as $key=>$value)
                        <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $value['step_id']) && (isset($details['job_status'][$service_id]['client_id']) && $details['job_status'][$service_id]['client_id'] == $details['client_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                      @endforeach
                    @endif
                  </select>
                </td>
              </tr>
              @endif
            @endif
          @endif
        @endforeach
      @endif
        
      </tbody>
    </table>
    </div>
   

  </div>


  </div>

  <div id="tab_3" class="tab-pane {{ ($page_open == '3')?'active':'' }}">
    <table class="table table-bordered table-hover dataTable ch_returns" id="example3" aria-describedby="example3_info">
      <thead>
        <tr role="row">
          <th>DELETE</th>
          <th>STAFF</th>
          <th>CRN</th>
          <th>BUSINESS NAME</th>
          <th>LAST RETURN DATE</th>
          <th>FILING DATE</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if((isset($details['services_id']) && in_array($service_id, $details['services_id'])))
            @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "N")
              @if(isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == 10)
              <tr id="data_tr_{{ $details['client_id'] }}_3">
                <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-tab="3"><img src="/img/cross.png"></a></td>
                <td align="left"></td>
                <td align="left">{{ $details['registration_number'] or "" }}</td>
                <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}">{{ $details['business_name'] or "" }}</a></td>
                <td align="center">{{ isset($details['last_acc_madeup_date'])?date("d-m-Y", strtotime($details['last_acc_madeup_date'])):"" }}</td>
                <td align="center" width="12%">
                  {{ isset($details['job_status'][$service_id]['created'])?date("d-m-Y", strtotime($details['job_status'][$service_id]['created'])):"" }}
                </td>
              </tr>
              @endif
            @endif
          @endif
        @endforeach
      @endif
        
      </tbody>
        
      </tbody>
    </table>

  </div>
      

</div>

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
                <td align="center"><input type="checkbox" class="status_check" {{ ($value['status'] == "S")?"checked":"" }} value="{{ $value['step_id'] or "" }}" data-step_id="{{ $value['step_id'] }}"></td>
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
      
@stop



