@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .nav-tabs-custom > .nav-tabs > li{ margin-right: -3px;}
</style>

@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/ch_data.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
var Table1;
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
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            
            {"bSortable": false}
        ]

    });

   Table1.fnSort( [ [4,'asc'] ] );

});

</script>

@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @include('layouts.outer_leftside')
                        
                    </ul>
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
        <div class="top_bts">
          <ul>
            <li>
              <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button>
            </li>
            <li>
              <button class="btn btn-primary"><i class="fa fa-print"></i> Print</button>
            </li>
            <li>
              <a href="/chdata/index" class="btn btn-info">PERMANENT DATA</a>
            </li>
            <!-- <li>
              <button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
            </li>
            <li>
              <button class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button>
            </li>
            <li>
              <button class="btn btn-success">IMPORT FROM CSV</button>
            </li> -->
            <!-- <li>
              <button class="btn btn-primary">REQUEST FROM CLIENT</button>
            </li>
            <li>
              <button class="btn btn-danger">REQUEST FROM OLD ACCOUNTANT</button>
            </li> -->
            <div class="clearfix"></div>
          </ul>
        </div>

        <div class="top_search_con" style="margin-right: 38px;">
          <table width="100%" border="0">
            <tbody><tr>
              <td>COMPANIES HOUSE</td>
              <td>&nbsp;</td>
              <td><button class="btn btn-danger">SYNC DATA</button></td>
              <td>&nbsp;</td>
              <td><a href="https://beta.companieshouse.gov.uk" target="_blank" class="btn btn-info">WEBCHECK</a></td>
            </tr>
          </tbody></table>
        </div>
        <div class="clearfix"></div>
      </div>

<div class="practice_mid">
        

<div class="tabarea">
  
  <div class="nav-tabs-custom">
      <ul class="nav nav-tabs nav-tabsbg" id="header_ul">
        <li class="active" id="tab_1"><a class="open_header" data-id="1" href="javascript:void(0)">All [1]</a></li>
        <li id="tab_2"><a class="open_header" data-id="2" href="javascript:void(0)">Not Started [2]</a></li>
        @if(isset($jobs_steps) && count($jobs_steps) >0)
          <?php $i = 3;?>
            @foreach($jobs_steps as $key=>$value)
              <li id="tab_{{ $i }}" class="header_step_{{ $value->step_id}}" style="display: {{ ($value->status == 'H')?'none':'block'}}"><a class="open_header" data-id="{{ $i }}" href="javascript:void(0)"><span id="step_field_{{ $value->step_id}}">{{ $value->title or "" }}</span> [0]</a></li>
              <?php $i++;?>
            @endforeach
        @endif
        
        <!-- <li id="tab_3"><a class="open_header" data-id="3" href="javascript:void(0)">Information Requested [3]</a></li>
        <li id="tab_4"><a class="open_header" data-id="4" href="javascript:void(0)">Information Received [4]</a></li>
        <li id="tab_5"><a class="open_header" data-id="5" href="javascript:void(0)">Progress [5]</a></li>
        <li id="tab_6"><a class="open_header" data-id="6" href="javascript:void(0)">Drafted [6]</a></li>
        <li id="tab_7"><a class="open_header" data-id="7" href="javascript:void(0)">Firm Review [7]</a></li>
        <li id="tab_8"><a class="open_header" data-id="8" href="javascript:void(0)">Client Review [8]</a></li>
        <li id="tab_9"><a class="open_header" data-id="9" href="javascript:void(0)">Finals Sent [9]</a></li>
        <li id="tab_10"><a class="open_header" data-id="10" href="javascript:void(0)">Filed [10]</a></li> -->
      </ul>
<div class="tab-content">

  <div id="step1" class="tab-pane active" style="display:block;">
    <div class="tab_topcon">
      <div class="top_bts">
        <ul style="padding:0;">
          <li>
            <a href="javascript:void(0)" class="btn btn-danger delete_manage_task">Delete</a>
          </li>
        <div class="clearfix"></div>
        </ul>
      </div>
      <!-- <div class="top_search_con">
       <div class="top_bts">
        <ul style="padding:0;">
          <li style="margin-right: 0px">
            <button class="btn btn-info">HMRC PAYMENT PLANS</button>
          </li>
          
          <div class="clearfix"></div>
        </ul>
      </div>
      </div> -->
      <div class="clearfix"></div>
    </div>
    <table class="table table-bordered table-hover dataTable ch_returns" id="example1" aria-describedby="example1_info">
      <thead>
        <tr role="row">
          <th><span class="custom_chk"><input type='checkbox' id="CheckallCheckbox" /></span></th><!-- allCheckSelect -->
          <th>STAFF</th>
          <th>DO1</th>
          <th>BUSINESS TYPE</th>
          <th>BUSINESS NAME</th>
          <th>AUTHEN CODE</th>
          <th>LAST RETURN DATE</th>
          <!-- <th>DEADLINE</th> -->
          <th>COUNT DOWN</th>
          <th>STATUS <a href="#" data-toggle="modal" data-target="#status-modal">Add/Edit list</a></th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">

        @if(isset($client_details) && count($client_details) >0)
        @foreach($client_details as $key=>$details)
          @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "Y")
            <tr class="even">
                <td><span class="custom_chk"><input type='checkbox' class="checkbox" name="checkbox[]" value="{{ $details['client_id'] or "" }}"/></span></td>
                <td align="left"></td>
                <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
                <td align="left">{{ $details['business_type'] or "" }}</td>
                <td align="left"><a href="/chdata-details/{{ $details['registration_number'] }}">{{ $details['business_name'] or "" }}</a></td>
                <td align="left">{{ $details['ch_auth_code'] or "" }}</td>
                <td align="left">{{ isset($details['last_acc_madeup_date'])?date("d-m-Y", strtotime($details['last_acc_madeup_date'])):"" }}</td>
                <!-- <td align="left"></td> -->
                <td align="center">{{ $details['count_down'] or "" }}</td>
                <td align="center" width="12%">
                  <select class="table_select" id="status_dropdown">
                    <option value="2">Not Started</option>
                    @if(isset($jobs_steps) && count($jobs_steps) >0)
                      @foreach($jobs_steps as $key=>$value)
                        <option value="{{ $value->step_id or "" }}"  style="display: {{ ($value->status == 'H')?'none':'block'}}">{{ $value->title or "" }}</option>
                      @endforeach
                    @endif
                  </select>
                </td>
              </tr>
          @endif 
        @endforeach
      @endif
        
      </tbody>
    </table>
  </div>
         
  <div id="step2" class="tab-pane" style="display:none;">
                  
  </div>
                              
  <div id="step3" class="tab-pane" style="display:none;">
    
  </div>
         
  <div id="step4" class="tab-pane" style="display:none;">
    
  </div>

  <div id="step5" class="tab-pane" style="display:none;">
    
  </div>

  <div id="step6" class="tab-pane" style="display:none;">
    
  </div>

  <div id="step7" class="tab-pane" style="display:none;">
    
  </div>

  <div id="step8" class="tab-pane" style="display:none;">
    
  </div>

  <div id="step9" class="tab-pane" style="display:none;">
    
  </div>

  <div id="step10" class="tab-pane" style="display:none;">
    
  </div>
       

</div>

</div>
          

</div>
        
    
</div>
</section>


        <!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->



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
              <tr id="change_status_tr_{{ $value->step_id or "" }}">
                <td align="center"><input type="checkbox" class="status_check" {{ ($value->status == "S")?"checked":"" }} value="{{ $value->step_id or "" }}" data-step_id="{{ $value->step_id }}"></td>
                <td><span id="status_span{{ $value->step_id or "" }}">{{ $value->title or "" }}</span></td>
                <td align="center"><span id="action_{{ $value->step_id or "" }}"><a href="javascript:void(0)" class="edit_status" data-step_id="{{ $value->step_id or "" }}"><img src="/img/edit_icon.png"></a></span></td>
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


<!-- @include("home.include.client_modal_page") -->

@stop