@extends('layouts.layout')

@section('mycssfile')
   <!-- <link href="http://cdn.datatables.net/1.10.7/css/jquery.dataTables.css" rel="stylesheet" type="text/css" /> -->
   <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/ch_data.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/webcheck.js') }}" type="text/javascript"></script>

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
        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 500, 100]],
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
        ],

        "aaSorting": [[8, 'asc']]
        
            

    });


    //Table1.fnSort( [ [8,'asc'] ] );

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
          <!--    <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button> -->
              <a href="/chdatapdf" class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</a>
              
              
            </li>
            <li>
            
              <a href="/chdataexcel" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</a>
             <!--  <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button> -->
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
                  <!-- <li>
                    <a href="/chdata/manage-tasks" class="btn btn-danger">MANAGE TASKS</a>
                  </li> -->
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
                  <li style="margin-left: 450px;">
                    <div id="message_div"><!-- Loader image show while sync data --></div>
                  </li>
                  
                </ul>
              </div>

              <!-- <div class="send_task">
                <input type="checkbox"> Send To Task Management (Deadlines) Section <input type="text" style="width:7%;"> Days Before Deadline
              </div> -->

              <div class="top_search_con">
                <table width="100%" border="0">
                  <tr>
                    <td>COMPANIES HOUSE</td>
                    <td>&nbsp;</td>
                    <td><a href="javascript:void(0)" class="btn btn-info autologin_button">AUTOLOGIN</a></td>
                    <td>&nbsp;</td>
                    <td><a class="btn btn-danger sync_jobs_data" href="javascript:void(0)">SYNC DATA</a></td>
                    <td>&nbsp;</td>
                    <td><a href="javascript:void(0)" class="btn btn-info webcheckButton">WEB CHECK</a></td>
                  </tr>
                </table>
              </div>
              <div class="clearfix"></div>
            </div>

      
            
  <table class="table table-bordered table-hover dataTable ch_returns" id="example1" width="100%">
  
    <thead>
      <tr role="row">
          <th width="3%"><span class="custom_chk"><input type='checkbox' id="CheckallCheckbox" /></span></th>
          <th width="7%">D0I</th>
          <th>CRN</th>
          <th width="20%">Name</th>
          <th width="6%">Year End</th>
          <th width="8%">Authen Code</th>
          <th width="11%">Last Return Date</th>
          <th width="11%">Next Return Date</th>
          <th width="8%">Count Down</th>
          <th>Address</th>
      </tr>
      
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
        @foreach($company_details as $key=>$details)
          @if(isset($details['display_in_ch']) && $details['display_in_ch'] == "Y")
            <tr class="{{ (isset($details['deadret_count']) && $details['deadret_count'] < 0 )?'sorting_disabled':"" }}">
                <td>
                  <span class="custom_chk"><input type='checkbox' class="checkbox for_autologin ads_Checkbox" name="checkbox[]" value="{{ $details['client_id'] or "" }}"/></span>

                  <input type="hidden" id="clnt_no_{{ $details['client_id'] or '' }}" value="{{ $details['registration_number'] or "" }}">
                  </td>
                <td align="center">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
                <td align="center">{{ $details['registration_number'] or "" }}</td>
                <td align="left"><a href="/chdata-details/{{ $details['registration_number'] or "" }}">{{ $details['business_name'] or "" }}</a></td>
                <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
                <td align="center">{{ $details['ch_auth_code'] or "" }}</td>
                <td align="center">{{ isset($details['made_up_date'])?date("d-m-Y", strtotime($details['made_up_date'])):"" }}</td>
                <td align="center">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
                <td align="center">
                  @if( isset($details['deadret_count']) && $details['deadret_count'] < 0 )
                    <span style="color:red">{{ $details['deadret_count'] or "" }}</span>
                  @else
                     <p>{{ $details['deadret_count'] or "" }}</p>
                  @endif
                </td>
                <td align="center">
                @if(isset($details['registered_address']['fullAddress']))
                  {{ (strlen($details['registered_address']['fullAddress']) > 48)? substr($details['registered_address']['fullAddress'], 0, 45)."...": $details['registered_address']['fullAddress'] }}
                @endif
                
                </td>
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



