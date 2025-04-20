@extends('layouts.layout')

@section('mycssfile')
    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/ch_data.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
var oTable;
$(function() {
    oTable = $('#example2').dataTable({
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
            {"bSortable": false},
            {"bSortable": false}
        ]

    });

    oTable.fnSort( [ [8,'asc'] ] );

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
              <button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
            </li> -->
            <div class="clearfix"></div>
          </ul>
        </div>
      </div>
      <div class="practice_mid">
      

          <div class="tabarea">
            <div class="tab_topcon">
              <div class="top_bts">
                <ul style="padding:0;">
                  <li>
                    <a href="/chdata/manage-tasks" class="btn btn-danger">MANAGE TASKS</a>
                  </li>
                  <li>
                    <div class="import_fromch_main">
                      <div class="import_fromch">
                        <a href="/import-from-ch/{{ base64_encode('ch_list') }}" class="import_fromch_link">IMPORT FROM CH</a>
                        <a href="javascript:void(0)" class="i_selectbox" id="select_icon"><img src="/img/arrow_icon.png"></a>
                        <div class="clearfix"></div>
                      </div>
                      <div class="i_dropdown open_toggle"><a href="/chdata/bulk-company-upload-page/{{ base64_encode('ch_list') }}">BULK COMPANY UPLOAD</a></div>
                    </div>
                    <!-- <a href="/import-from-ch/{{ base64_encode('ch_list') }}" class="btn btn-info">IMPORT FROM CH</a> -->
                  </li>
                  <!-- <li style="width:60%">
                    
                  </li> -->
                  
                </ul>
              </div>

              <div class="send_task">
                <input type="checkbox"> Send To Task Management (Deadlines) Section <input type="text" style="width:7%;"> Days Before Deadline
              </div>

              <div class="top_search_con">
                <table width="100%" border="0">
                  <tr>
                    <td>COMPANIES HOUSE</td>
                    <td>&nbsp;</td>
                    <td><button class="btn btn-danger">SYNC DATA</button></td>
                    <td>&nbsp;</td>
                    <td><a href="https://beta.companieshouse.gov.uk" target="_blank" class="btn btn-info">WEBCHECK</a></td>
                  </tr>
                </table>
              </div>
              <div class="clearfix"></div>
            </div>
            
  <table id="example2" class="table table-bordered table-hover ch_returns">
    <thead>
      <tr role="row">
          <th><span class="custom_chk"><input type='checkbox' id="CheckallCheckbox" /></span></th>
          <th>D01</th>
          <th>CRN</th>
          <th>NAME</th>
          <th>YEAR END</th>
          <th>AUTHEN CODE</th>
          <th>LAST RETURN DATE</th>
          <th>NEXT RETURN DATE</th>
          <th>COUNT DOWN</th>
          <th>SEND TO TASKS</th>
          <th>STAFF</th>
      </tr>
    </thead>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if(isset($details['registration_number']) && $details['registration_number']!= "")
            <tr class="even">
                <td><span class="custom_chk"><input type='checkbox' class="checkbox" name="checkbox[]" value="{{ $details['client_id'] or "" }}"/></span></td>
                <td class="sorting_1" align="center">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
                <td align="center">{{ $details['registration_number'] or "" }}</td>
                <td align="left"><a href="/chdata-details/{{ $details['registration_number'] }}">{{ $details['business_name'] or "" }}</a></td>
                <td align="center">{{ $details['acc_ref_day'] or "" }}/{{ $details['acc_ref_month'] or "" }}</td>
                <td align="center">{{ $details['ch_auth_code'] or "" }}</td>
                <td align="center">{{ isset($details['last_acc_madeup_date'])?date("d-m-Y", strtotime($details['last_acc_madeup_date'])):"" }}</td>
                <td align="center">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
                <td align="center">{{ $details['count_down'] or "" }}</td>
                <td align="center" id="after_send_{{ $details['client_id'] }}">
                  @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "N")
                    <button type="button" class="send_btn send_manage_task" data-client_id="{{ $details['client_id'] }}" data-field_name="ch_manage_task">Send</button>
                  @else
                    <button type="button" class="sent_btn">Sent</button>
                  @endif
                </td>
                <td align="center"></td>
            </tr>
          @endif 
        @endforeach
      @endif
      
    </tbody>
  </table>
            
            
          </div>
        
      </div>
    </section>


</aside><!-- /.right-side -->
            
        
      
@stop



