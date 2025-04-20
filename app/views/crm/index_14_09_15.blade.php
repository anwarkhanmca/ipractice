@extends('layouts.layout')

@section('mycssfile')
  <link href="{{URL :: asset('css/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/crm.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<!-- page script -->

<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<!-- <script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script> -->
<script src="{{ URL :: asset('js/jquery.price_format.2.0.js') }}" type="text/javascript"></script>

<script>
$(document).ready(function(){
    $("#date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#from_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#to_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    //$('.money').mask('000.000.000.000.000,00');
    $('#quoted_value').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit: '',
    });
    $('#annual_revenue').priceFormat({
        prefix: '',
        centsSeparator: '.',
        thousandsSeparator: ',',
        centsLimit: '',
    });
});

</script>
<script type="text/javascript">
  $(function() {
    $('#example11').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'desc']]
    });

  for(var k=2; k<=11;k++){
    $('#example1'+k).dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'desc']]
    });
  }

  $('#example112').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        //{"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'desc']]
    });
        

});

</script>

<script src="{{ URL :: asset('js/graph.js') }}" type="text/javascript"></script>
<script>
/*$(function () {
  var bar = new GraphBar({
    attachTo: '#graph',
    special: 'combo',
    height: 475,
    width: '100%',
    yDist: 30,
    xDist: 50,
    showPoints: false,
    xGrid: false,
    legend: true,
    averageLineColor:false,
    points: [
      [17, 21, 51, 74, 12, 49, 100, 17, 21, 51, 74, 12],
      [32, 15, 75, 20, 45, 90, 52, 15, 75, 20, 45, 90]
    ],
    colors: ['red', 'orange'],
    dataNames: ['Total', 'Won'],
    xName: 'Month',
    tooltipWidth: 15,
    design: {
        tooltipColor: '#fff',
        gridColor: 'black',
        tooltipBoxColor: 'green',
        averageLineColor: 'blue',
    }
  });
  bar.init();
});*/
</script>
<style type="text/css">
  svg:not(:root){overflow: inherit; margin-right: 20px; float:right;}

</style>
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
        <div class="practice_hed">
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

        <div id="message_div"><!-- Loader image show while sync data --></div>
      </div>

      

      </div>
      <div class="practice_mid">
      <input type="hidden" name="page_open" id="page_open" value="{{ $page_open }}">
      <input type="hidden" name="encode_page_open" id="encode_page_open" value="{{ $encode_page_open }}">
      <input type="hidden" name="encode_owner_id" id="encode_owner_id" value="{{ $encode_owner_id }}">
      
    <div class="tabarea">
  
  <div class="nav-tabs-custom">
      <ul class="nav nav-tabs nav-tabsbg">
        <li class="{{ ($page_open != 2)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('11') }}/{{ base64_encode($owner_id) }}">LEADS & PROSPECTS</a></li>
        <li class="{{ ($page_open == 2)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('2') }}/{{ base64_encode($owner_id) }}">ENGAGEMENT LETTER / CONTRACT RENEWALS</a></li>
      </ul>
<div class="tab-content">
  <div id="tab_1" class="tab-pane {{ ($page_open != 2)?'active':'' }}">

    <div class="tab_topcon">
      <div class="top_bts" style="float:left;">
        <ul style="padding:0;">
          <li>
            <a class="btn btn-danger deleteLeads" href="javascript:void(0)">DELETE</a>
          </li>
          <li>
            <div class="import_fromch_main" style="width:182px;">
              <div class="import_fromch">
                <a href="javascript:void(0)" class="import_fromch_link">+ NEW OPPORTUNITY</a>
                <a href="javascript:void(0)" class="i_selectbox" id="select_icon"><img src="/img/arrow_icon.png"></a>
                <div class="clearfix"></div>
              </div>
              <div class="crm_dropdown open_toggle">
              <ul>
                <li><href="javascript:void(0)" data-type="ind" data-leads_id="0" class="open_form-modal">Individual</a></li>
                <li><href="javascript:void(0)" data-type="org" data-leads_id="0" class="open_form-modal">Organisation</a></li>
              </ul>
            </div>
          </div>
          </li>
          <li>
            <!-- <a class="btn btn-info graphs-modal" href="javascript:void(0)">GRAPHS</a> -->
            <a class="btn btn-info" href="/crm/graph-page" target="_blank">GRAPHS</a>
          </li>
          <li>
            <a class="btn btn-info" href="/crm/report" target="_blank">REPORT</a>
          </li>
        <div class="clearfix"></div>
        </ul>
      </div>
      <div class="top_search_con">
       <div class="top_bts">
        <ul style="padding:0;">
          <!-- <li style="margin-top: 8px;">Filter per deal owner</li>
          <li>
            <select class="form-control" style="width:150px;" name="filter_by_staff" id="filter_by_staff">
              <option value="{{ base64_encode('all') }}" {{ (isset($owner_id) && $owner_id == 'all')?"selected":"" }}>Show All</option>
              @if(isset($staff_details) && count($staff_details) >0)
                @foreach($staff_details as $key=>$staff_row)
                <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                @endforeach
              @endif
            </select>
          </li> -->
        
          <li style="margin-top: 8px;">
            <a href="javascript:void(0)" id="archive_div">{{ $archive }}</a>
          </li>
          <li>
            <button type="button" id="archivedButton" class="btn btn-warning">Archive</button>
          </li>
          <div class="clearfix"></div>
        </ul>
      </div>
      </div>
      <div class="clearfix"></div>
    </div>

    <!-- <ul class="nav nav-tabs nav-tabsbg">
        <li class="{{ ($page_open == 11)?'active':'' }}">
          <a href="{{ $goto_url }}/{{ base64_encode('11') }}/{{ base64_encode($owner_id) }}">
            <span style="background: #000;" class="{{($page_open==11)?'active_text':''}}">ALL [<span id="task_count_11">1</span>]</span>
            <div>&#163;50.000.00<br>&#163;50.000.00<br>&#163;50.000.00</div></a>
        </li>
    
        <li class="{{ ($page_open == 12)?'active':'' }}">
          <a href="{{ $goto_url }}/{{ base64_encode('12') }}/{{ base64_encode($owner_id) }}">
            <span class="{{ ($page_open == 12)?'active_text':'' }}">INCOMING [<span id="task_count_21">1</span>]</span>
            <div>&#163;50.000.00<br>&#163;50.000.00<br>&#163;50.000.00</div></a>
          </a>
        </li>
    </ul> -->

    <ul class="leads_tab">
        <li style="width:6%;" class="{{ ($page_open == 11)?'active_leads':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('11') }}/{{ base64_encode($owner_id) }}"><h3 style="background:#0066FF;">All [<span id="task_count_11">{{ count($leads_details) }}</span>]</h3></a>
          <p>&#163;{{ $all_total or "0.00" }}</p>
          <p>&#163;{{ $all_average or "0.00" }}</p>
          <p>&#163;{{ $all_likely or "0.00" }}</p>
        </li>

        @if(isset($leads_tabs) && count($leads_tabs) >0)
          <?php 
            $i = 2;
            $total    = 0;
            $average  = 0;
            $likely   = 0;
          ?>
          @foreach($leads_tabs as $key=>$tab_row)
          <li class="{{ ($page_open == '1'.$i)?'active_leads':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('1'.$i) }}/{{ base64_encode($owner_id) }}"><h3 style="background:#{{ $tab_row['color_code'] or "" }};"><span id="step_field_{{ $tab_row['tab_id'] or "" }}">{{ $tab_row['tab_name'] or "" }}</span> [<span id="task_count_1.$i">{{ $tab_row['count'] or "0" }}</span>]</h3></a>
          <p>&#163;{{ $tab_row['table_value']['total'] or "0.00" }}</p>
          <p>&#163;{{ $tab_row['table_value']['average'] or "0.00" }}</p>
          <p>&#163;{{ $tab_row['table_value']['likely'] or "0.00" }}</p>
        </li>
          <?php $i++;?>
          @endforeach
        @endif

        <li style="width:6%;"><h3 style="background:#0866c6;">&nbsp;</h3>
          <p style="border-right: 0px"><strong>Total</strong></p>
          <p style="border-right: 0px"><strong>Average</strong></p>
          <p style="border-right: 0px"><strong>Likely</strong></p>
        </li>

        <div class="clearfix"></div>
    </ul>
    
  <div class="tab-content">

  <div id="tab_11" class="tab-pane top_margin {{ ($page_open == '11')?'active':'' }}">
    <table class="table table-bordered table-hover dataTable crm" id="example11" aria-describedby="example11_info">
      <thead>
        <tr role="row">
          <th width="3%"><input type='checkbox' id="CheckallCheckbox"></th>
          <th width="7%">Date</th>
          <th width="12%">Deal Owner</th>
          <th width="12%">Prospect Name</th>
          <th>Contact Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th width="3%">Age</th>
          <th width="9%">Quote</th>
          <th width="6%">Emails <a href="javascript:void(0)" class="" style="float:right;"><img src="/img/question_frame.png"></a></th>
          <th width="9%">Lead Status <a href="javascript:void(0)" class="lead_status-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
          <th width="8%">Quoted Value</th>
          <th width="5%">Notes</th>
          <th width="6%">Client Onboarding</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($leads_details) && count($leads_details) >0)
          @foreach($leads_details as $key=>$leads_row)
            <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
              <td><input type='checkbox' data-archive="{{ $leads_row['show_archive'] }}" class="ads_Checkbox" name="leads_delete_id[]" value="{{ $leads_row['leads_id'] or "" }}"></td>
              <td align="left">{{ $leads_row['date'] or "" }}</td>
              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
              <td align="left">
                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                  <a href="javascript:void(0)" data-type="org" data-leads_id="{{ $leads_row['leads_id'] }}" class="open_form-modal">{{ $leads_row['prospect_name'] or "" }}</a>
                @else
                  <a href="javascript:void(0)" data-type="ind" data-leads_id="{{ $leads_row['leads_id'] or "" }}" class="open_form-modal">{{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}</a>
                @endif
              </td>
              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
              <td align="left">{{ $leads_row['phone'] or "" }}</td>
              <td align="left">{{ $leads_row['email'] or "" }}</td>
              <td align="center">{{ $leads_row['deal_age'] or "0" }}</td>
              <td align="center">
                <div class="email_client_selectbox" style="height:24px; width:93px!important">
                  <span>{{ (isset($leads_row['is_invoiced']) && $leads_row['is_invoiced'] == 'Y')?'Invoiced':'SEND' }}</span>
                  <div class="small_icon" data-id="{{ $leads_row['leads_id'] or "" }}" data-tab="11"></div><div class="clr"></div>
                  <div class="select_toggle" id="status{{ $leads_row['leads_id'] or "" }}_11" style="display: none;">
                    <ul>
                      <li><a href="/quotes" class="send_template-modal">+ New</a></li>
                      <li><a href="javascript:void(0)" class="send_template-modal">Resend</a></li>
                      <li><a href="javascript:void(0)" class="send_template-modal">View</a></li>
                      <li><a href="javascript:void(0)" class="sendto_invoiced" data-tab_id="12" data-leads_id="{{ $leads_row['leads_id'] or "" }}">Generate Invoice</a></li>
                    </ul>
                  </div>
                </div>
              </td>
              <td align="center">
                <a href="javascript:void(0)" class="notes_btn" data-leads_id="{{ $leads_row['leads_id'] or "" }}" data-tab="11">View</a>
              </td>
              <td align="center">
                <select class="form-control newdropdown status_dropdown" id="11_status_dropdown_{{ $leads_row['leads_id'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}">
                  @if(isset($leads_tabs) && count($leads_tabs) >0)
                    @foreach($leads_tabs as $key=>$tab_row)
                      <option value="{{ $tab_row['tab_id'] or "" }}" {{ (isset($leads_row['lead_status']) && $leads_row['lead_status'] == $tab_row['tab_id'])?'selected':'' }}>{{ $tab_row['tab_name'] or "" }}</option>
                    @endforeach
                  @endif
                </select>
              </td>
              <td align="center">{{ $leads_row['quoted_value'] or "" }}</td>
              <td>
                <input type="hidden" id="notes_{{ $leads_row['leads_id'] or "" }}" value="{{ $leads_row['notes'] or "" }}">
                <a href="javascript:void(0)" class="notes_btn open_notes_popup" data-leads_id="{{ $leads_row['leads_id'] or "" }}" data-tab="11"><span style="{{ (isset($leads_row['notes']) && $leads_row['notes'] != '')?'border-bottom:3px dotted #3a8cc1 !important':''}}">notes</span></a>
              </td>
              <td align="center">
                @if(isset($leads_row['existing_client']) && $leads_row['existing_client'] != '0')
                  {{ "N/A" }}
                @else
                  <button type="button" class="send_btn send_manage_task" data-client_id="{{ $leads_row['leads_id'] or "" }}" data-field_name="ch_manage_task">START</button>
                @endif
              </td>
            </tr>
          @endforeach
        @endif
        
      </tbody>
    </table>
    </div>
           
    @for($k=2; $k <=11;$k++)                          
    <div id="tab_1{{$k}}" class="tab-pane top_margin {{ ($page_open == '1'.$k)?'active':'' }}">
      <table class="table table-bordered table-hover dataTable crm" id="example1{{$k}}" aria-describedby="example1{{$k}}_info">
      <thead>
        <tr role="row">
          <th width="3%"><input type='checkbox' id="CheckallCheckbox"></th>
          <th width="7%">Date</th>
          <th width="12%">Deal Owner</th>
          <th width="12%">Prospect Name</th>
          <th>Contact Name</th>
          <th>Phone</th>
          <th>Email</th>
          <th width="3%">Age</th>
          <th width="6%">Quote</th>
          <th width="6%">Emails <a href="javascript:void(0)" class="" style="float:right;"><img src="/img/question_frame.png"></a></th>
          <th width="9%">Lead Status <a href="javascript:void(0)" class="lead_status-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
          <th width="8%">Quoted Value</th>
          <th width="5%">Notes</th>
          <th width="6%">Client Onboarding</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($leads_details) && count($leads_details) >0)
          @foreach($leads_details as $key=>$leads_row)
            @if(isset($leads_row['lead_status']) && $leads_row['lead_status'] == $k)
            <tr>
              <td><input type='checkbox' class="ads_Checkbox" name="leads_delete_id[]" value="{{ $leads_row['leads_id'] or "" }}"></td>
              <td align="left">{{ $leads_row['date'] or "" }}</td>
              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
              <td align="left">
                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                  <a href="javascript:void(0)" data-type="org" data-leads_id="{{ $leads_row['leads_id'] }}" class="open_form-modal">{{ $leads_row['prospect_name'] or "" }}</a>
                @else
                  <a href="javascript:void(0)" data-type="ind" data-leads_id="{{ $leads_row['leads_id'] or "" }}" class="open_form-modal">{{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}</a>
                @endif
              </td>
              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
              <td align="left">{{ $leads_row['phone'] or "" }}</td>
              <td align="left">{{ $leads_row['email'] or "" }}</td>
              <td align="center">{{ $leads_row['deal_age'] or "0" }}</td>
              <td align="center">
                <div class="email_client_selectbox" style="height:24px;">
                  <span>SEND</span>
                  <div class="small_icon" data-id="{{ $leads_row['leads_id'] or "" }}" data-tab="11"></div><div class="clr"></div>
                  <div class="select_toggle" id="status{{ $leads_row['leads_id'] or "" }}_11" style="display: none;">
                    <ul>
                      <li><a href="/quotes" class="send_template-modal">+ New</a></li>
                      <li><a href="javascript:void(0)" class="send_template-modal">Resend</a></li>
                      <li><a href="javascript:void(0)" class="send_template-modal">View</a></li>
                      <li><a href="javascript:void(0)" class="send_template-modal">Generate Invoice</a></li>
                    </ul>
                  </div>
                </div>
              </td>
              <td align="center">
                <a href="javascript:void(0)" class="notes_btn" data-leads_id="{{ $leads_row['leads_id'] or "" }}" data-tab="11">View</a>
              </td>
              <td align="center">
                <select class="form-control newdropdown status_dropdown" id="11_status_dropdown_{{ $leads_row['leads_id'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}">
                  @if(isset($leads_tabs) && count($leads_tabs) >0)
                    @foreach($leads_tabs as $key=>$tab_row)
                      <option value="{{ $tab_row['tab_id'] or "" }}" {{ (isset($leads_row['lead_status']) && $leads_row['lead_status'] == $tab_row['tab_id'])?'selected':'' }}>{{ $tab_row['tab_name'] or "" }}</option>
                    @endforeach
                  @endif
                </select>
              </td>
              <td align="center">{{ $leads_row['quoted_value'] or "" }}</td>
              <td>
                <input type="hidden" id="notes_{{ $leads_row['leads_id'] or "" }}" value="{{ $leads_row['notes'] or "" }}">
                <a href="javascript:void(0)" class="notes_btn open_notes_popup" data-leads_id="{{ $leads_row['leads_id'] or "" }}" data-tab="11"><span style="{{ (isset($leads_row['notes']) && $leads_row['notes'] != '')?'border-bottom:3px dotted #3a8cc1 !important':''}}">notes</span></a>
              </td>
              <td align="center">
                @if(isset($leads_row['existing_client']) && $leads_row['existing_client'] != '0')
                  {{ "N/A" }}
                @else
                  <button type="button" class="send_btn send_manage_task" data-client_id="{{ $leads_row['leads_id'] or "" }}" data-field_name="ch_manage_task">START</button>
                @endif
              </td>
            </tr>
            @endif
          @endforeach
        @endif
        
      </tbody>
    </table> 
    </div>
    @endfor  

  </div>


  </div>

  <div id="tab_2" class="tab-pane {{ ($page_open == '2')?'active':'' }}">
    <table class="table table-bordered table-hover dataTable ch_returns" id="example3" aria-describedby="example3_info">
      <!-- <thead>
        <tr role="row">
          <th width="6%">DELETE</th>
          <th width="13%">STAFF</th>
          <th>CRN</th>
          <th>BUSINESS NAME</th>
          <th width="22%">LAST RETURN DATE</th>
          <th>NOTES</th>
          <th>FILING DATE</th>
        </tr>
      </thead> -->

      
        <tbody role="alert" aria-live="polite" aria-relevant="all">
          <?php $i = 1;?>
        @if(isset($completed_task) && count($completed_task) >0)
          @foreach($completed_task as $key=>$details)
            <tr id="data_tr_{{ $details['client_id'] }}_3">
              <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-tab="3"><img src="/img/cross.png"></a></td>
              <td align="left">
                @if(isset($details['allocated_staffs']) && count($details['allocated_staffs']) >0)
                <select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_{{ $details['client_id'] }}" data-client_id="{{$details['client_id']}}">
                  @foreach($details['allocated_staffs'] as $key=>$staff_row)
                    <option value="{{ $staff_row['staff_id'] or "" }}">{{ $staff_row['staff_name'] or "" }}</option>
                  @endforeach
                </select>
              @endif
              </td>
              <td align="left">{{ $details['registration_number'] or "" }}</td>
              <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}">{{ $details['business_name'] or "" }}</a></td>
              <td align="center">
                <a href="javascript:void(0)" class="change_last_date" data-client_id="{{ $details['client_id'] or "" }}" data-tab="3" data-key="{{ $key }}" id="3_dateanchore_{{ $key }}" data-prev_date="{{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}">{{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}</a>
                <span class="3_save_made_span_{{ $key }}"  style="display:none;">
                  <input type="text" class="made_up_date" id="3_made_up_date_{{ $key }}" />
                  <a href="javascript:void(0)" class="search_t save_made_date" data-client_id="{{ $details['client_id'] or "" }}" data-tab="3" data-key="{{ $key }}">Save</a>
                  <a href="javascript:void(0)" class="search_t cancel_made_date" data-client_id="{{ $details['client_id'] or "" }}" data-tab="3" data-key="{{ $key }}">Cancel</a>
                </span>
              </td>
              <td align="center"><a href="javascript:void(0)" class="search_t open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
              </td>
              <td align="center" width="12%">
                {{ isset($details['job_status'][$service_id]['filling_date'])?date("d-m-Y", strtotime($details['job_status'][$service_id]['filling_date'])):"" }}
              </td>
            </tr>
            <?php $i++;?>
          @endforeach
        @endif
        
      </tbody>
        
      
    </table>

  </div>
      

</div>

</div>
          

</div>
        
      </div>
    </section>


</aside><!-- /.right-side -->
            
<!-- Send Template modal start -->
<div class="modal fade" id="open_form-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">NEW - LEAD ENQUIRY & PROSPECT</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/crm/save-leads-data')) }}
      <input type="hidden" name="encode_page_open" value="{{ $encode_page_open }}">
      <input type="hidden" name="encode_owner_id" value="{{ $encode_owner_id }}">
      <input type="hidden" name="type" id="type" value="">
      <input type="hidden" name="leads_id" id="leads_id" value="">
      <div class="modal-body">
        <div class="form-group" style="margin:0;">
           <div class="n_box12">
           
              <div class="form-group">
                <label for="exampleInputPassword1">Date</label>
                <input type="text" id="date" name="date" value="{{ $staff_row['date'] or '' }}" class="form-control">
              </div>
            
          </div>
          <div class="n_box11">
            <div class="form-group">
              <label for="deal_certainty">Deal Certainty</label>
              <input type="text" id="deal_certainty" name="deal_certainty" value="100" class="form-control box_60" maxlength="3"><span style="margin-top: 7px; float:left;">%</span>
            </div>
          </div>

          

          <div class="f_namebox2">
            <label for="exampleInputPassword1">Deal Owner</label>
              <select class="form-control" name="deal_owner" id="deal_owner">
                <option value="">-- None --</option>
                @if(isset($staff_details) && count($staff_details) >0)
                  @foreach($staff_details as $key=>$staff_row)
                  <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                  @endforeach
                @endif
             </select>
          </div>
          <div class="f_namebox3">
            <label for="exampleInputPassword1">Attach Opportunity to Existing Client</label>
            <select class="form-control" name="existing_client" id="existing_client">
              <option value="0">-- None --</option>
              
             </select>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox" id="org_name_div">
          <div class="twobox_1">
            <div class="form-group" style="width:57%">
              <label for="exampleInputPassword1">Business Type <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"> Add/Edit list</a></label>
              <select class="form-control" name="business_type" id="business_type">
                @if( isset($old_org_types) && count($old_org_types) >0 )
                  @foreach($old_org_types as $key=>$old_org_row)
                  <option value="{{ $old_org_row->organisation_id }}">{{ $old_org_row->name }}</option>
                  @endforeach
                @endif

                @if( isset($new_org_types) && count($new_org_types) >0 )
                  @foreach($new_org_types as $key=>$new_org_row)
                  <option value="{{ $new_org_row->organisation_id }}">{{ $new_org_row->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Prospect Name</label>
              <input type="text" class="form-control" name="prospect_name" id="prospect_name">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" id="contact_name_div">
          <label for="exampleInputPassword1">Contact Name</label>
          <div class="clearfix"></div>
          <div class="n_box1">
            <select class="form-control select_title" id="contact_title" name="contact_title">
              <option value="">-- Title --</option>
              @if(!empty($titles))
                @foreach($titles as $key=>$title_row)
                <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="f_namebox">
            <input type="text" id="contact_fname" name="contact_fname" class="form-control" placeholder="First Name">
          </div>
          <div class="f_namebox">
            <input type="text" id="contact_lname" name="contact_lname" class="form-control" placeholder="Last Name">
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" id="prospect_name_div">
          <label for="exampleInputPassword1">Prospect Name</label>
          <div class="clearfix"></div>
          <div class="n_box1">
            <select class="form-control select_title" id="prospect_title" name="prospect_title">
              <option value="">-- Title --</option>
              @if(!empty($titles))
                @foreach($titles as $key=>$title_row)
                <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="f_namebox">
            <input type="text" id="prospect_fname" name="prospect_fname" class="form-control" placeholder="First Name">
          </div>
          <div class="f_namebox">
            <input type="text" id="prospect_lname" name="prospect_lname" class="form-control" placeholder="Last Name">
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Phone</label>
                <input type="text" id="phone" name="phone" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Mobile</label>
                <input type="text" id="mobile" name="mobile" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <input type="text" id="email" name="email" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Website</label>
                <input type="text" id="website" name="website" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Annual Revenue</label>
                <input type="text" id="annual_revenue" name="annual_revenue" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Quoted Value</label>
                <input type="text" id="quoted_value" name="quoted_value" class="form-control money" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Lead Source <a href="javascript:void(0)" class="lead_source-modal"> Add/Edit list</a></label>
                <select class="form-control select_title" id="lead_source" name="lead_source">
                  <option value="0">-- None --</option>
                  @if(isset($old_lead_sources) && count($old_lead_sources) >0)
                    @foreach($old_lead_sources as $key=>$lead_row)
                      <option value="{{ $lead_row['source_id'] }}">{{ $lead_row['source_name'] }}</option>
                    @endforeach
                  @endif
                  @if(isset($new_lead_sources) && count($new_lead_sources) >0)
                    @foreach($new_lead_sources as $key=>$lead_row)
                      <option value="{{ $lead_row['source_id'] }}">{{ $lead_row['source_name'] }}</option>
                    @endforeach
                  @endif
                </select>
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Industry</label>
              <select class="form-control select_title" id="industry" name="industry">
                <option value="0">-- None --</option>
                @if(isset($industry_lists) && count($industry_lists) >0)
                  @foreach($industry_lists as $key=>$industry_row)
                    <option value="{{ $industry_row['industry_id'] }}">{{ $industry_row['industry_name'] }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Street</label>
                <input type="text" id="street" name="street" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">City</label>
                <input type="text" id="city" name="city" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">County</label>
                <input type="text" id="county" name="county" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Postal Code</label>
                <input type="text" id="postal_code" name="postal_code" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
         <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Country</label>
                <select class="form-control" name="country_id" id="country_id">
                @if(!empty($countries))
                  @foreach($countries as $key=>$country_row)
                  @if(!empty($country_row->country_code) && $country_row->country_code == "GB")
                    <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
                  @endif
                  @endforeach
                @endif
                @if(!empty($countries))
                  @foreach($countries as $key=>$country_row)
                  @if(!empty($country_row->country_code) && $country_row->country_code != "GB")
                    <option value="{{ $country_row->country_id }}">{{ $country_row->country_name }}</option>
                  @endif
                  @endforeach
                @endif
                </select>
              </div> 
          </div>
          <!--<div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Mobile</label>
                <input type="text" id="" class="form-control" >
            </div>
          </div>-->
          <div class="clearfix"></div>
        </div>

        <div class="form-group" style="width:98%;">
          <label for="exampleInputPassword1">Notes</label>
          <textarea class="form-control" rows="4" name="notes" id="notes"></textarea>
        </div>
        <div class="clearfix"></div>
      </div>
      
      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-info pull-left save_t2">Save</button>
        </div>
      </div>
      {{ Form::close() }}
    
  </div>
  </div>
</div>
<!-- Send Template modal end -->

<!-- add/edit list -->
<div class="modal fade" id="addcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="org_name" name="org_name" placeholder="Business Type" class="form-control">
      </div>
      
      <div id="append_bussiness_type">
      @if( isset($old_org_types) && count($old_org_types) >0 )
        @foreach($old_org_types as $key=>$old_org_row)
        <div class="form-group">
          <label for="{{ $old_org_row->name }}">{{ $old_org_row->name }}</label>
        </div>
        @endforeach
      @endif

      @if( isset($new_org_types) && count($new_org_types) >0 )
        @foreach($new_org_types as $key=>$new_org_row)
        <div class="form-group" id="hide_div_{{ $new_org_row->organisation_id }}">
          <a href="javascript:void(0)" title="Delete Field ?" class="delete_org_name" data-field_id="{{ $new_org_row->organisation_id }}"><img src="/img/cross.png" width="12"></a>
          <label for="{{ $new_org_row->name }}">{{ $new_org_row->name }}</label>
        </div>
        @endforeach
      @endif
      </div>
      
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="add_business_type" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- add/edit list -->
<div class="modal fade" id="lead_source-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD LEAD SOURCE</h4>
        <div class="clearfix"></div>
      </div>
    
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Lead Source</label>
        <input type="text" id="new_source" name="new_source" class="form-control">
      </div>
      
      <div id="append_new_source">
      @if( isset($old_lead_sources) && count($old_lead_sources) >0 )
        @foreach($old_lead_sources as $key=>$source_row)
        <div class="form-group">
          <label for="{{ $source_row['source_id'] }}">{{ $source_row['source_name'] }}</label>
        </div>
        @endforeach
      @endif
      @if( isset($new_lead_sources) && count($new_lead_sources) >0 )
        @foreach($new_lead_sources as $key=>$source_row)
        <div class="form-group" id="hide_div_{{ $source_row['source_id'] }}">
          <a href="javascript:void(0)" title="Delete Field ?" class="delete_source" data-field_id="{{ $source_row['source_id'] }}"><img src="/img/cross.png" width="12"></a>
          <label for="{{ $source_row['source_name'] }}">{{ $source_row['source_name'] }}</label>
        </div>
        @endforeach
      @endif
      </div>
      
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="add_lead_source" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="lead_status-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">EDIT LEAD STATUS</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '', 'id'=>'field_form')) }}
      <div class="modal-body">
      <table class="table table-bordered table-hover dataTable add_status_table">
        <thead>
          <tr>
            <!-- <th align="center" width="20%">Show/Unshow</th> -->
            <th >Status Name</th>
            <th align="center">Action</th>
          </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($leads_tabs) && count($leads_tabs) >0)
            @foreach($leads_tabs as $key=>$value)
              <tr id="change_status_tr_{{ $value['tab_id'] or "" }}">
                <!-- <td align="center"><input type="checkbox" id="step_check_2{{ $value['tab_id']}}" class="status_check" {{ ($value['status'] == "S")?"checked":"" }} value="{{ $value['tab_id'] or "" }}" data-step_id="{{ $value['tab_id'] }}" {{ ((isset($value['count']) && $value['count'] !=0) || $value['tab_id'] == 10)?"disabled":"" }} /></td> -->
                <td><span id="status_span{{ $value['tab_id'] or "" }}">{{ $value['tab_name'] or "" }}</span></td>
                <td align="center"><span id="action_{{ $value['tab_id'] or "" }}"><a href="javascript:void(0)" class="edit_status" data-step_id="{{ $value['tab_id'] or "" }}"><img src="/img/edit_icon.png"></a></span></td>
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


<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="full_address-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">FULL ADDRESS</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body" id="show_full_address">
        
      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="full_notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NOTES</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body" id="show_full_notes">
        
      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- GRAPHS MODAL -->
<div class="modal fade" id="graphs-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:790px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">GRAPHS</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">From Date</label>
                <input type="text" id="from_date" name="from_date" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">To Date</label>
                <input type="text" id="to_date" name="to_date" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <input type="button" id="show_graph_button" class="btn btn-info" value="Show Graph">
        </div> 
        <div id="show_graph_loader" style="text-align: center;"></div>
        <div class="clearfix"></div>

        <div class="form-group" id="show_graph"></div>
         <div class="clearfix"></div>
      </div>
    
    </div>
  </div>
</div>

@stop



