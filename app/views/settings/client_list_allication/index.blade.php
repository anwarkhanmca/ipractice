@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .nav-tabs-custom > .nav-tabs > li{ margin-right: -3px;}
</style>

@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/client_list_allocation.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/client_allocation.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('js/jtablejs/client_allocation.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
var Table1, Table2;
$(function() {
  /*Table1 = $('#example1').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
    "iDisplayLength": 50,
    "language": {
      "lengthMenu": "Show _MENU_ entries",
      "zeroRecords": "Nothing found - sorry",
      "info": "Showing page _PAGE_ of _PAGES_",
      "infoEmpty": "No records available",
      "infoFiltered": "(filtered from _MAX_ total records)"
    },
    "oLanguage": { "sSearch": "" },

    "aoColumns":[
      {"bSortable": false},
      {"bSortable": false},
      {"bSortable": true},
      {"bSortable": false},
      {"bSortable": false},
      {"bSortable": false},
      {"bSortable": false},
      {"bSortable": false},
      {"bSortable": false}
    ]

  });*/

  /*Table2 = $('#example2').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
    "iDisplayLength": 50,
    "language": {
      "lengthMenu": "Show _MENU_ entries",
      "zeroRecords": "Nothing found - sorry",
      "info": "Showing page _PAGE_ of _PAGES_",
      "infoEmpty": "No records available",
      "infoFiltered": "(filtered from _MAX_ total records)"
    },
    "oLanguage": { "sSearch": "" },
    "aoColumns":[
      {"bSortable": false},
      {"bSortable": true},
      {"bSortable": false},
      {"bSortable": false},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true}
    ]

  });*/

  //Table1.fnSort( [ [2,'asc'] ] );
  //Table2.fnSort( [ [1,'asc'] ] );

});

</script>

@stop

@section('content')
<input type="hidden" id="service_id" value="{{ $service_id or '0' }}">
<div class="wrapper row-offcanvas row-offcanvas-left">
  <aside class="left-side sidebar-offcanvas {{ $left_class }}">
    <section class="sidebar">
      <ul class="sidebar-menu">
        @include('layouts.outer_leftside')
      </ul>
    </section>
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
            
            <a href="/pdfclistallocation/{{$service_id}}/{{$client_type}}" class="btn btn-success" style=""><i style="padding-right: 4px;" class="fa fa-download"></i> Generate PDF</a>
            
             <!--  <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button> -->
            </li>
            <li>
            <a href="/excelclistallocation/{{$service_id}}/{{$client_type}}" class="btn btn-primary" style=""><i class="fa fa fa-file-text-o"></i> Excel</a>
             <!-- <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button> -->
            </li>
            <!-- <li>
              <a href="/chdata/index" class="btn btn-info">PERMANENT DATA</a>
            </li>
            <li>
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
              <td><!-- COMPANIES HOUSE --></td>
              <td>&nbsp;</td>
              <td><!-- <button class="btn btn-danger">SYNC DATA</button> --></td>
              <td>&nbsp;</td>
              <td>
                <!-- <a href="#" data-toggle="modal" data-target="#bulk_allocation-modal" class="btn btn-info">Bulk Allocation</a> -->
                <a href="javascript:void(0)" class="btn btn-info bulk_allocation">Bulk Staff Allocation</a>
              </td>
            </tr>
          </tbody></table>
        </div>
        <div class="clearfix"></div>
      </div>

<div class="practice_mid">
        

<div class="tabarea">
  
  <div class="nav-tabs-custom">
      <ul class="nav nav-tabs nav-tabsbg" id="header_ul">
        <li class="{{ ($client_type == 'org')?'active':'' }}" id="tab_1"><a class="open_header client_allocate" data-id="1" data-type="org" href="javascript:void(0)">ORGANISATIONAL CLIENT LIST</a></li>
        <li id="tab_2" class="{{ ($client_type == 'ind')?'active':'' }}"><a class="open_header client_allocate" data-id="2" data-type="ind" href="javascript:void(0)">INDIVIDUAL CLIENT LIST</a></li>
       </ul>
<div class="tab-content">
<input type="hidden" id="client_type" name="client_type" value="{{ $client_type }}">
  <div id="step1" class="tab-pane" style="display:{{ ($client_type == 'org')?'block':'none' }};">
    {{ Form::open(array('url'=>'/allocationClientsByService')) }}
      <table width="100%">
        <tr>
          <td style="width: 10%;"><input type="hidden" name="type" value="org"></td>
          <td style="width: 4%;">Select Service:</td>
          <td style="width: 12%;">
            <select class="form-control newdropdown service_dropdown" name="org_service_id" id="org_service_id"><!--.service_dropdown-->
              <option value="0">None</option>
              @if( isset($old_services) && count($old_services)>0 )
                @foreach($old_services as $key=>$service_row)
                  @if( isset($service_row->client_type) && $service_row->client_type == "org" )
                    <option value="{{ $service_row->service_id }}" {{ (isset($service_id) && $service_id == $service_row->service_id)?"selected":"" }}>{{ $service_row->service_name }}</option>
                  @endif
                @endforeach
              @endif

              @if( isset($new_services) && count($new_services)>0 )
                @foreach($new_services as $key=>$service_row)
                  @if( isset($service_row->client_type) && $service_row->client_type == "org" )
                    <option value="{{ $service_row->service_id }}" {{ (isset($service_id) && $service_id == $service_row->service_id)?"selected":"" }}>{{ $service_row->service_name }}</option>
                  @endif
                @endforeach
              @endif
            </select>
          </td>
          <td style="width: 1%;"></td>
          <td style="width: 15%;">
            <select class="form-control newdropdown clientAddToList">
              <option value="">Select 1 or more clients</option>
            </select>
          </td>
          <td style="width: 10%;"></td>
        </tr>
      </table>
    {{ Form::close() }}
    <!-- <div style="width: 50%; margin-left: 400px;">
      {{ Form::open(array('url'=>'/allocationClientsByService')) }}
      <input type="hidden" name="type" value="org">
      <div class="selctbox_containor1">
        <div class="select_t" style="padding-top: 0px;">Select Service :</div>
        <div class="sel_box">
          <select class="form-control newdropdown" name="org_service_id" id="org_service_id">
            <option value="0">None</option>
            @if( isset($old_services) && count($old_services)>0 )
              @foreach($old_services as $key=>$service_row)
                @if( isset($service_row->client_type) && $service_row->client_type == "org" )
                  <option value="{{ $service_row->service_id }}" {{ (isset($service_id) && $service_id == $service_row->service_id)?"selected":"" }}>{{ $service_row->service_name }}</option>
                @endif
              @endforeach
            @endif

            @if( isset($new_services) && count($new_services)>0 )
              @foreach($new_services as $key=>$service_row)
                @if( isset($service_row->client_type) && $service_row->client_type == "org" )
                  <option value="{{ $service_row->service_id }}" {{ (isset($service_id) && $service_id == $service_row->service_id)?"selected":"" }}>{{ $service_row->service_name }}</option>
                @endif
              @endforeach
            @endif
          </select>
        </div>
        <button type="submit" class="search_t" style="margin-left: 10px; height: 25px; padding: 0 10px;">Update</button>
      </div>
      {{ Form::close() }}
      <div class="clearfix"></div>
    </div> -->

    <div id="orgclient_table">
      @include('home/include/client_lists')
    <!-- <table class="table table-bordered table-hover dataTable org_alocation" id="example1" aria-describedby="example1_info">
      
      <thead>
        <tr role="row">
          <th width="2%"><span class="custom_chk"><input type='checkbox' class="CheckorgCheckbox" /></span></th>allCheckSelect
          <th width="%8">Type</th>
          <th>Business Name</th>
          <th style="text-align: center;">Action <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
          @if(isset($headings) && count($headings) > 0)
            @foreach($headings as $key=>$head)
              <th width="12%" class="head_{{ $head['alloc_head_id'] }}">{{ $head['heading'] }}</th>
            @endforeach
          @endif
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">

        @if(isset($client_details) && count($client_details) >0)
          @foreach($client_details as $key=>$details)
            <tr class="even" id="client_{{ $details['client_id'] }}">
              <td>
                <span class="custom_chk"><input type='checkbox' class="checkbox applicable_Checkbox org_Checkbox" name="applicable_checkbox[]" value="{{ $details['client_id'] or "" }}" id="applicable_checkbox{{ $details['client_id'] }}" {{ (isset($details['services_id']) && in_array($service_id, $details['services_id']))?"checked":"" }} /></span>
              </td>
              
              <td align="left">{{ $details['business_type'] or "" }}</td>
              <td align="left">
                  <a target="_blank" href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}">{{ $details['business_name'] or "" }}</a>
              </td>
              <?php $k = 0;?>
              @for($i=1; $i <=5; $i++)
                @if(isset($details['allocationStaff']) && count($details['allocationStaff']) >0)
                  @foreach($details['allocationStaff'] as $key=>$value)
                    @if(isset($value['staff_name'.$i]) && $value['staff_name'.$i] != '')
                      <?php $k = 1;break;?>
                    @endif
                  @endforeach
                @endif
              @endfor

              <td align="center"><a href="javascript:void(0)" class="openServicesStaff openAllocation openAllocation_{{ $details['client_id'] }} {{ (isset($details['services_id']) && in_array($service_id, $details['services_id']))?'':'disable_click' }}" data-client_id="{{ $details['client_id'] }}" data-service_id="{{$service_id or '0'}}" data-page_name="allocation">Edit</a></td>

              @for($i=1; $i <=5; $i++)
                <td align="left" class="orgStaff_{{$i}}_{{ $details['client_id'] }}">
                  <?php $k = 0;?>
                  @if(isset($details['allocationStaff']) && count($details['allocationStaff']) >0)
                    @foreach($details['allocationStaff'] as $key=>$value)
                      @if(isset($value['staff_name'.$i]) && $value['staff_name'.$i] != '')
                        <?php $k = 1;?>
                      @endif
                    @endforeach
                  @endif

                  @if( $k == 1 )
                    <select class="form-control newdropdown">
                      @foreach($details['allocationStaff'] as $key=>$value)
                        @if(isset($value['staff_name'.$i]) && $value['staff_name'.$i] != '')
                          <option value="{{$value['staff_id'.$i]}}">{{$value['staff_name'.$i]}}</option>
                        @endif
                      @endforeach
                    </select>
                  @endif
                  
                </td>
                @endfor
              </tr>
            
          @endforeach
        @endif
        
      </tbody>
    </table> -->
  </div>
    <div class="clearfix"></div>
  </div>

  <div id="step2" class="tab-pane" style="display:{{ ($client_type == 'ind')?'block':'none' }};">
    <!-- <div style="width: 50%; margin-left: 400px;">
      {{ Form::open(array('url'=>'/allocationClientsByService')) }}
      <input type="hidden" name="type" value="ind">
      <div class="selctbox_containor1">
        <div class="select_t" style="padding-top: 0px;">Select Service :</div>
        <div class="sel_box">
          <select class="form-control newdropdown" name="ind_service_id" id="ind_service_id">
            <option value="0">None</option>
            @if( isset($old_services) && count($old_services)>0 )
              @foreach($old_services as $key=>$service_row)
                @if( isset($service_row->client_type) && $service_row->client_type == "ind" )
                  <option value="{{ $service_row->service_id }}" {{ (isset($service_id) && $service_id == $service_row->service_id)?"selected":"" }} >{{ $service_row->service_name }}</option>
                @endif
              @endforeach
            @endif

            @if( isset($new_services) && count($new_services)>0 )
              @foreach($new_services as $key=>$service_row)
                @if( isset($service_row->client_type) && $service_row->client_type == "ind" )
                  <option value="{{ $service_row->service_id }}" {{ (isset($service_id) && $service_id == $service_row->service_id)?"selected":"" }}>{{ $service_row->service_name }}</option>
                @endif
              @endforeach
            @endif
          </select>
        </div>
        <button type="submit" class="search_t" style="margin-left: 10px; height: 25px; padding: 0 10px;">Update</button>
      </div>
      {{ Form::close() }}
      
      <div class="clearfix"></div>
    </div> -->
    {{ Form::open(array('url'=>'/allocationClientsByService')) }}
      <table width="100%">
        <tr>
          <td style="width: 10%;"><input type="hidden" name="type" value="ind"></td>
          <td style="width: 4%;">Select Service:</td>
          <td style="width: 12%;">
            <select class="form-control newdropdown service_dropdown" id="ind_service_id">
              <option value="0">None</option>
              @if( isset($old_services) && count($old_services)>0 )
                @foreach($old_services as $key=>$service_row)
                  @if( isset($service_row->client_type) && $service_row->client_type == "ind" )
                    <option value="{{ $service_row->service_id }}" {{ (isset($service_id) && $service_id == $service_row->service_id)?"selected":"" }} >{{ $service_row->service_name }}</option>
                  @endif
                @endforeach
              @endif

              @if( isset($new_services) && count($new_services)>0 )
                @foreach($new_services as $key=>$service_row)
                  @if( isset($service_row->client_type) && $service_row->client_type == "ind" )
                    <option value="{{ $service_row->service_id }}" {{ (isset($service_id) && $service_id == $service_row->service_id)?"selected":"" }}>{{ $service_row->service_name }}</option>
                  @endif
                @endforeach
              @endif
            </select>
          </td>
          <td style="width: 1%;"></td>
          <td style="width: 15%;">
            <select class="form-control newdropdown clientAddToList">
              <option value="">Select 1 or more clients</option>
            </select>
          </td>
          <td style="width: 10%;"></td>
        </tr>
      </table>
    {{ Form::close() }}
    @include('settings/client_list_allication/client_ind_lists')
    <!-- <table class="table table-bordered table-hover dataTable org_alocation" id="example2">
      <thead>
        <tr role="row">
          <th width="3%"><span class="custom_chk"><input type='checkbox' class="CheckorgCheckbox allCheckSelect" /></span></th>allCheckSelect 
          <th>Client Name</th>
          <th style="text-align: center;">Action <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
          @if(isset($headings) && count($headings) > 0)
            @foreach($headings as $key=>$head)
              <th width="12%" class="head_{{ $head['alloc_head_id'] }}">{{ $head['tableHeading'] }}</th>
            @endforeach
          @endif
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">

        @if(isset($client_details) && count($client_details) >0)
          @foreach($client_details as $key=>$details)
            
              <tr class="even" id="client_{{ $details['client_id'] }}">
                <td><span class="custom_chk"><input type='checkbox' class="checkbox applicable_Checkbox ind_Checkbox" name="applicable_checkbox[]" value="{{ $details['client_id'] or "" }}" id="applicable_checkbox{{ $details['client_id'] }}" {{ (isset($details['services_id']) && in_array($service_id, $details['services_id']))?"checked":"" }} /></span>
                </td>
                <td align="left"><a target="_blank" href="/client/edit-ind-client/{{ $details['client_id'] }}">{{ $details['client_name'] or "" }}</a></td>

                <td align="center"><a href="javascript:void(0)" class="openAllocation openAllocation_{{ $details['client_id'] }} {{ (isset($details['services_id']) && in_array($service_id, $details['services_id']))?'' : 'disable_click' }}" data-client_id="{{ $details['client_id'] }}" data-service_id="{{$service_id or '0'}}" data-page_name="allocation">Edit</a></td>

                @for($i=1; $i <=5; $i++)
                <td align="left" class="orgStaff_{{$i}}_{{ $details['client_id'] }}">
                  <?php $k = 0;?>
                  @if(isset($details['allocationStaff']) && count($details['allocationStaff']) >0)
                    @foreach($details['allocationStaff'] as $key=>$value)
                      @if(isset($value['staff_name'.$i]) && $value['staff_name'.$i] != '')
                        <?php $k = 1;?>
                      @endif
                    @endforeach
                  @endif

                  @if( $k == 1 )
                    <select class="form-control newdropdown">
                      @foreach($details['allocationStaff'] as $key=>$value)
                        @if(isset($value['staff_name'.$i]) && $value['staff_name'.$i] != '')
                          <option value="{{$value['staff_id'.$i]}}">{{$value['staff_name'.$i]}}</option>
                        @endif
                      @endforeach
                    </select>
                  @endif
                </td>
                @endfor
              </tr>
            
          @endforeach
        @endif
        
      </tbody>
    </table> -->
  </div>
      

</div>

</div>
          

</div>
        
    
</div>
</section>

  </aside>
</div>



<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="bulk_allocation-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:900px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">BULK ALLOCATION</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="font-size: 18px; color: #008d4c; text-align: center;" id="success_msg"></div>
        <div class="show_loader"></div>
      <table class="table table-bordered table-hover dataTable" width="100%">
        <tr>
          <td width="40%" colspan="2"><strong style="font-size: 16px; float: right;">Select Staff : </strong></td>
          <td colspan="2" width="40%">
            <select class="form-control newdropdown bulkStaffDrop" name="staff_id" id="staff_id">
              <option value="">None</option>
              @if(!empty($staff_details))
                @foreach($staff_details as $key=>$staff_row)
                <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                @endforeach
              @endif
            </select>
          </td>
          <td width="20%"></td>
        </tr>

        <tr>
        @if(isset($headings) && count($headings) > 0)
          <?php $m = 1;?>
          @foreach($headings as $key=>$head)
            <td width="20%" class="head_{{ $head['alloc_head_id'] }}">
              <strong>{{ $head['heading'] }}</strong> <input type="radio" name="column" value="{{ $head['alloc_head_id'] }}" data-column_no="{{$m}}" class="radio_column">
            </td>
            <?php $m++;?>
          @endforeach
        @endif
        </tr>

        <!-- <tr>
          <td width="30%">&nbsp;</td>
          <td width="35%">
            <strong>Column 1</strong> <input type="radio" name="column" value="1" class="radio_column">
          </td>
          <td width="35%">
            <strong>Column 3</strong> <input type="radio" name="column" value="3" class="radio_column">
          </td>
        </tr>

        <tr>
          <td width="30%">&nbsp;</td>
          <td width="35%">
            <strong>Column 2</strong> <input type="radio" name="column" value="2" class="radio_column">
          </td>
          <td width="35%">
            <strong>Column 4</strong> <input type="radio" name="column" value="4" class="radio_column">
          </td>
        </tr> -->

        <!-- <tr>
          <td width="30%">&nbsp;</td>
          <td width="35%">
            <strong>Column 5</strong> <input type="radio" name="column" value="5" class="radio_column">
          </td>
          <td width="35%"></td>
        </tr> -->
    
    </table>

        <div class="modal-footer clearfix" style="padding-right: 0px;">
          <div class="email_btns">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info save_bulk_client_allocation" name="save" data-save_type="S">Save</button>
            <button type="button" class="btn btn-info save_bulk_client_allocation" name="save_notify" data-save_type="SN">Save & Notify Staff</button>
          </div>
        </div>


      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


@include("settings.include.allocation_modal")

@stop