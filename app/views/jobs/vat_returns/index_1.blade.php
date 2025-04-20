@extends('layouts.layout')

@section('mycssfile')
  <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/vat_returns.js') }}" type="text/javascript"></script>
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

   oTable.fnSort( [ [6,'asc'] ] );

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
              <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button>
            </li>
            
            <div class="clearfix"></div>
          </ul>
        </div>

        <!-- <div style="float: right; margin-right: 43px;"><a href="javascript:void(0)" id="archive_div">Show Archived</a></div> -->
      </div>
      <div class="practice_mid">
        <form>
          
          <div class="tabarea">
            <div class="tab_topcon">
              <div class="top_bts">
                <ul style="padding:0;">
                  <li>
                    <a href="/vatreturn/manage-tasks" class="btn btn-danger">MANAGE TASKS</a>
                  </li>
                  <li>
                    <span style="margin-left: 240px"><input type="checkbox"> SEND TO <b>TASK MANAGEMENT</b> <input type="text" style="width:5%;"> DAYS before filling date</span>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              <div class="top_search_con">
               <div class="top_bts">
                <ul style="padding:0;">
                  <li style="margin-right: 0px">
                    <button class="btn btn-info">HMRC PAYMENT PLANS</button>
                  </li>
                  
                  <div class="clearfix"></div>
                </ul>
              </div>
              </div>
              <div class="clearfix"></div>
            </div>
            
    <div class="box-body table-responsive">
      <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
        <div class="row">
          <div class="col-xs-6"></div>
          <div class="col-xs-6"></div>
        </div>
          <table class="table table-bordered table-hover dataTable vat_returns" id="example2" aria-describedby="example2_info">
            <thead>
              <tr role="row">
                <th><input type="checkbox" id="allCheckSelect"/></th>
                <th>STAFF</th>
                <th>DOR</th>
                <th>VAT SCHEME</th>
                <th>VAT NUMBER</th>
                <th>RETURN FREQUENCY</th>
                <th>BUSINESS NAME</th>
                <th>VAT STAGGER</th>
                <th>SEND TO TASKS</th>
              </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
              @if( isset($client_details) && count($client_details) >0 )
              <?php $i=1; ?>
              @foreach($client_details as $key=>$client_row)
                <tr class="all_check">
                  <td><input type="checkbox" name="checkbox[]" value="{{ $client_row['client_id'] }}" /></td>
                  <td align="left"><a href="/client/edit-ind-client/{{ $client_row['client_id'] }}">{{ $client_row['vat_staff_name'] or "" }}</a></td>
                  <td align="left">{{ isset($client_row['effective_date'])?date("d-m-Y", strtotime($client_row['effective_date'])):"" }}</td>
                  <td align="left">{{ $client_row['vat_scheme_name'] or '' }}</td>
                  <td align="left">{{ (!empty($client_row['vat_number']))? $client_row['vat_number']: '' }}</td>
                  <td align="left">{{ $client_row['ret_frequency'] or '' }}</td>
                  <td align="left"><a href="/client/edit-org-client/{{ $client_row['client_id'] }}" target="_blank">{{ $client_row['business_name'] or '' }}</a></td>
                  <td align="left">{{ (!empty($client_row['vat_stagger'])) ? ucwords($client_row['vat_stagger']): '' }}</td>
                  <td align="center"><button type="button" class="sent_btn" />SENT</button>
                    <button type="button" class="send_btn" />SEND</button></td>
                </tr>
                <?php $i++; ?>
                @endforeach
                
              @endif
              
            </tbody>
          </table>
      </div>
    </div>
            
            
            

            
                      
                      
          </div>
        </form>
      </div>
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

@stop