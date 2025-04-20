@extends('layouts.layout')

@section('mycssfile')
<!-- <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> -->
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .bottom_space{ height: 50px;}
</style>

<!-- google search -->
<link rel="stylesheet" href="{{ URL :: asset('css/address_search.css') }}" />
<!-- google search -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/letter_email.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>


<script src="{{ URL :: asset('js/contact_table.js') }}" type="text/javascript"></script>


<!-- page script -->
<script type="text/javascript">
$(function() {
    $('#example2').dataTable({
        "aaSorting": [[1, 'asc']],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
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

    $('#example3').dataTable({
        "aaSorting": [[1, 'asc']],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
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

    $('#example4').dataTable({
        "aaSorting": [[1, 'asc']],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
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

    $('#example5').dataTable({
        "aaSorting": [[1, 'desc']],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
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

  $('#example6').dataTable({
    "aaSorting": [[1, 'asc']],
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
    "iDisplayLength": 50,
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

</script>




<link href="{{ URL :: asset('css/jtable/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL :: asset('css/jtable/jtable.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ URL :: asset('js/jtable/jquery-ui-1.10.0.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jtable/jquery.jtable.js') }}" type="text/javascript"></script>

<!-- <link href="http://www.jtable.org/Content/themes/metroblue/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="http://www.jtable.org/Scripts/jtable/themes/lightcolor/orange/jtable.css" rel="stylesheet" type="text/css" />
<script src="http://www.jtable.org/Scripts/jquery-ui-1.10.0.min.js" type="text/javascript"></script>
<script src="http://www.jtable.org/Scripts/jtable/jquery.jtable.js" type="text/javascript"></script> -->


<!-- jtable -->
<script type="text/javascript" src="{{ URL :: asset('js/jtablejs/contacts.js') }}"></script>

<!-- google search -->
<script src="{{ URL :: asset('js/address_search.js') }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc7HTLVvrPyl_cJQGPIb1GuWwq0cTC4MY&libraries=places&callback=initAutocomplete" async defer></script>
<!-- google search -->
@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
  <aside class="left-side sidebar-offcanvas {{ $left_class }}">
    <section class="sidebar">
      <ul class="sidebar-menu">
        @include('layouts.outer_leftside')
      </ul>
    </section>
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
            <!-- <li>
              <button class="btn btn-info"><i class="fa fa-print"></i> Print</button>
            </li> -->
            
          
          
          <!-- @if((isset($step_id) && $step_id == 2))
          
          <a class="btn btn-success" href="/pdfindex/2/{{ $encoded_type }}"><i class="fa fa-download"></i> Generate PDF</a>
          @endif
          
          @if((isset($step_id) && $step_id == 3))
          
          <a class="btn btn-success" href="/pdfindex/3/{{ $encoded_type }}"><i class="fa fa-download"></i> Generate PDF</a>
          @endif
          @if((isset($step_id) && $step_id == 4))
          
          <a class="btn btn-success" href="/pdfindex/4/{{ $encoded_type }}"><i class="fa fa-download"></i> Generate PDF</a>
          @endif -->
          

            
            
            <div class="clearfix"></div>
          </ul>
        </div>
        <div id="message_div" style="margin-left: 700px;"><!-- Loader image show while sync data --></div>
        <div class="loading-div"><img src="/img/spinner.gif" ></div>
      </div>
      <div class="practice_mid">
        
          <div class="tabarea">
            <div class="tab_topcon">
              <div class="top_bts" style="float:left;">
                <ul style="padding:0;">
                  <!-- <li>
                    <a href="/send-letters-emails" class="btn btn-danger">SEND LETTER/EMAIL</a>
                  </li> -->

                  <li>
                    <a class="btn btn-success" href="/pdfindex/{{$step_id}}/{{ $encoded_type }}"><i class="fa fa-download"></i> Generate PDF</a>
                  </li>
                  <li>
                    <a class="btn btn-primary" href="/excelindex/{{$step_id}}/{{ $encoded_type }}"><i class="fa fa fa-file-text-o"></i> Excel</a>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              <div class="top_search_con">
               <div class="top_bts">
                <ul style="padding:0;">
                  <!-- <li>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#upload_letterhead-modal">UPLOAD LETTERHEAD</a>
                  </li> -->
                  @if($step_id == 4)
                  <li>
                    <a href="javascript:void(0)" class="btn btn-primary add_contact-modal" data-contact_id="0" data-added_from='contact'>NEW CONTACT</a>
                  </li>
                  @endif

                  @if($title == 'Contacts')
                    <!-- <li>
                      <a href="/email/template" target="_blank" class="btn btn-info">MAIL SETTINGS</a>
                    </li> -->
                  @endif
                  @if($title == 'Contact Group')
                    <!-- <li>
                      <a href="/massemail-settings" target="_blank" class="btn btn-info">MASS EMAIL</a>
                    </li> -->
                    <li style="float:right;">
                      <a href="#" class="btn btn-info open_addto_group"><i class="fa fa-minus"></i> GROUP</a>
                    </li>
                  @endif

                    <li style="float:right;"><a href="javascript:void(0)" class="btn btn-info create_group"><i class="fa fa-plus"></i> GROUP</a></li>

                  <div class="clearfix"></div>
                </ul>
              </div>
              </div>
              <div class="clearfix"></div>

            </div>
            
<div class="box-body table-responsive">
  <div class="tabarea">
  <input type="hidden" id="tab_id" value="{{ $step_id or "" }}"> 
  <input type="hidden" id="address_type" value="{{ $address_type or "" }}">
  <input type="hidden" id="encoded_type" value="{{ $encoded_type or "" }}">
  <input type="hidden" id="per_page" value="{{ $per_page or "0" }}"> 
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-tabsbg">
      @if(isset($steps) && count($steps) >0)
        @foreach($steps as $key=>$step_row)
        @if($title == 'Contacts')
          @if(isset($step_row['step_id']) && $step_row['step_id'] <= 4)
            <li {{ (isset($step_id) && $step_id == $step_row['step_id'])?'class="active"':''}}><a href="/contacts-letters-emails/{{ $step_row['step_id'] }}/{{ $encoded_type }}">{{ isset($step_row['title'])?strtoupper($step_row['title']):"" }} {{ (isset($step_row['count']) && $step_row['count'] != "")?"[".$step_row['count']."]":"" }}</a></li>
          @endif
        @else
          @if(isset($step_row['step_id']) && $step_row['step_id'] > 4 && $step_row['step_id'] <= 6)
            <li {{ (isset($step_id) && $step_id == $step_row['step_id'])?'class="active"':''}}><a href="/contacts-letters-emails/{{ $step_row['step_id'] }}/{{ $encoded_type }}">{{ isset($step_row['title'])?strtoupper($step_row['title']):"" }} {{ (isset($step_row['count']) && $step_row['count'] != "")?"[".$step_row['count']."]":"" }}</a></li>
          @endif
        @endif
        @endforeach
      @endif
      
      @if(isset($step_name) && $step_name != "")
        <li class="active"><a href="/contacts-letters-emails/{{ $step_id }}/{{ $encoded_type }}">{{ $step_name or "" }}</a></li>
      @endif
      <!-- <li style="float:right;"><a href="javascript:void(0)" class="btn-block btn-primary create_group"><i class="fa fa-plus"></i> GROUP</a></li> -->
    </ul>



<div class="tab-content">
  <div id="tab_1" class="tab-pane {{ ($step_id==1 || $step_id==2 || $step_id==3 || $step_id==4)?'active':''}}">
    <div class="row bottom_space">
      <div class="col-xs-6">
        @if($step_id == 1)
        <div class="dataTables_length" id="example2_length">
          <div style="float: left; margin-right: 5px;margin-top: 4px;">Select Address Type</div>
          <div style="float: left;width: 50%!important">
            <select id="addressTypeDrop" class="form-control input-sm" style="width: 56%!important">
              @if(isset($address_types) && count($address_types) >0)
                @foreach($address_types as $key=>$type_row)
                  <option value="/contacts-letters-emails/{{ $step_id }}/{{ base64_encode($type_row['short_name']) }}" {{($type_row['short_name']==$address_type)?'selected':''}}>{{ $type_row['title'] }}</option>
                @endforeach
              @endif
            </select>
          </div>
        </div>
        @endif
      </div>
      <div class="col-xs-6">
        <div id="example2_filter" class="dataTables_filter">
          <form>
            <input type="text" name="search" id="search" placeholder="Search" class="tableSearch" />
            <button type="submit" id="LoadRecordsButton" style="display: none;">Search</button>
            <!-- <button type="submit" id="LoadRecordsButton">Search</button> -->
          </form>
        </div>
      </div>
    </div>

    <div id="OrgTableContainer"></div>
    <!-- <table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">
      <thead>
        <tr role="row">
          <th width="2%"><input type="checkbox" class="allCheckSelect"/></th>
          <th width="20%">Name</th>
          <th width="13%">Address Type <span class="glyphicon glyphicon-chevron-down down_arrow" data-client_id="531" data-tab="21">
            <div class="address_type_down" style="display: none;">
              <ul>
                @if(isset($address_types) && count($address_types) >0)
                  @foreach($address_types as $key=>$type_row)
                    <li><a href="/contacts-letters-emails/{{ $step_id }}/{{ base64_encode($type_row['short_name']) }}">{{ $type_row['title'] }}</a></li>
                  @endforeach
                @endif
              </ul>
            </div>
          </span>
          </th>
          <th width="13%">Contact Person</th>
          <th width="7%">Telephone</th>
          <th width="7%">Mobile</th>
          <th width="10%">Email</th>
          <th>Address</th>
          <th width="6%">Notes</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all" id="results">
          include('contacts_letters/ajax/org_tab')
      </tbody>
    </table>-->
  </div>

  <div id="tab_2" class="tab-pane {{ (isset($step_id) && $step_id == 22)?'active':''}}">

    <!-- <div class="contact_email">
      <a href="javascript:void(0)" class="search_add open_addto_group">Add to group</a>
    </div> -->
    <table class="table table-bordered table-hover dataTable email_letter" id="example2" aria-describedby="example2_info">
      <thead>
        <tr role="row">
          <th width="3%"><input type="checkbox" class="allCheckSelect"/></th>
          <th>Name</th>
          <th>Telephone</th>
          <th>Mobile</th>
          <th>Email</th>
          <th>Residential Address</th>
          <th>Service Address</th>
          <th>Notes</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($ind_details) && count($ind_details) >0)
          @foreach($ind_details as $key=>$client_row)
            <tr class="all_check">
              <input type="hidden" name="serv_add_{{ $client_row['client_id'] }}" id="serv_add_{{ $client_row['client_id'] }}" value="{{ $client_row['serv_address'] or "" }}">
              <input type="hidden" name="reg_add_{{ $client_row['client_id'] }}" id="reg_add_{{ $client_row['client_id'] }}" value="{{ $client_row['address'] or "" }}">

              <td align="left">
                <input type="checkbox" class="ads_Checkbox" name="client_delete_id[]" value="{{ $client_row['client_id'] or "" }}" />
              </td>
              
              <td align="left"><a target="_blank" href="/client/edit-ind-client/{{ $client_row['client_id'] }}/{{ base64_encode('ind_client') }}">{{ $client_row['client_name'] or "" }}</a></td>
              <td align="left">{{ $client_row['res_telephone'] or "" }}</td>
              <td align="left">{{ $client_row['res_mobile'] or "" }}</td>
              <td align="left">{{ $client_row['res_email'] or "" }}</td>
              <td align="left">{{ (strlen($client_row['address']) > 48)? substr($client_row['address'], 0, 45)."...<a href='javascript:void(0)' class='more_address' data-client_id='".$client_row['client_id']."' data-address_type='reg' data-client_type='ind'>more</a>":$client_row['address']}}</td>
              <td align="left">{{ $client_row['serv_address'] or '' }}</td>

              <td align="left"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $client_row['client_id'] or "" }}" data-contact_type="{{ $client_row['client_type'] or "" }}"><span {{ (isset($client_row['notes']) && $client_row['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a></td>
              
            </tr>
          @endforeach
        @endif
        
      </tbody>
    </table>
  </div>

  <div id="tab_3" class="tab-pane {{ (isset($step_id) && $step_id == 33)?'active':''}}">
    <!-- <div class="contact_email">
      <a href="javascript:void(0)" class="search_add open_addto_group">Add to group</a>
    </div> -->
    <table class="table table-bordered table-hover dataTable email_letter" id="example3" aria-describedby="example3_info">
      <thead>
        <tr role="row">
          <th width="3%"><input type="checkbox" class="allCheckSelect"/></th>
          <th width="20%">Name</th>
          <th width="10%">Telephone</th>
          <th width="10%">Mobile</th>
          <th width="20%">Email</th>
          <th>Address</th>
          <th width="8%">Notes</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($staff_details) && count($staff_details) >0)
            @foreach($staff_details as $key=>$staff_row)
              <tr class="all_check">
                <input type="hidden" name="address_{{ $staff_row['user_id'] }}" id="corres_add_{{ $staff_row['user_id'] }}" value="{{ $staff_row['address'] or "" }}">
                <td align="left">
                  <input type="checkbox" class="ads_Checkbox" name="user_ids[]" value="{{ $staff_row['user_id'] or "" }}" />
                </td>
                <td align="left">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</td>
                <td align="left">{{ $staff_row['step_data']['serv_telephone'] or "" }}</td>
                <td align="left">{{ $staff_row['step_data']['serv_mobile'] or "" }}</td>
                <td align="left">{{ $staff_row['email'] or "" }}</td>
                <td align="left">{{ (isset($staff_row['step_data']['address']) && strlen($staff_row['step_data']['address']) > 48)? substr($staff_row['step_data']['address'], 0, 45)."...<a href='javascript:void(0)' class='more_address' data-staff_id='".$staff_row['user_id']."' data-client_type='staff'>more</a>": isset($staff_row['step_data']['address'])?$staff_row['step_data']['address']:''}}</td>
                
                <td align="left"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-staff_id="{{ $staff_row['user_id'] or "" }}" data-contact_type="staff"><span {{ (isset($staff_row['notes']) && $staff_row['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a></td>
                
              </tr>
            @endforeach
          @endif
        
        
      </tbody>
    </table>
  </div>

  <div id="tab_4" class="tab-pane {{ (isset($step_id) && $step_id == 44)?'active':''}}">
    <!-- <div class="contact_email">
      <a href="javascript:void(0)" class="search_add open_addto_group">Add to group</a>
      <a href="#" class="search_t" data-toggle="modal" data-target="#add_contact-modal">Add Contact</a>
    </div> -->
    <table class="table table-bordered table-hover dataTable email_letter" id="example4" aria-describedby="example4_info">
      <thead>
        <tr role="row">
          <th width="4%">Delete<!-- <input type="checkbox" class="allCheckSelect"/> --></th>
          <th>Name</th>
          <th width="15%">Contact Person</th>
          <th>Telephone</th>
          <th>Mobile</th>
          <th>Email</th>
          <th>Address</th>
          <th>Notes</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($contact_details) && count($contact_details) >0)
              @foreach($contact_details as $key=>$client_row)
                <tr class="all_check">
                  <input type="hidden" name="other_address_{{ $client_row['contact_id'] }}" id="other_address_{{ $client_row['contact_id'] }}" value="{{ $client_row['address'] or "" }}">
                  <td align="center">
                    <a href="javascript:void(0)" class="delete_contact" data-contact_id="{{ $client_row['contact_id'] or "" }}" data-delete_from="contact"><img src="/img/cross.png" height="13"></a>
                  </td>
                  <td align="left"><a href="javascript:void(0)" class="add_contact-modal" data-contact_id="{{ $client_row['contact_id'] }}" data-added_from="contact">{{ $client_row['name'] or "" }}</a></td>
                  <td align="left"><a href="javascript:void(0)" class="add_contact-modal" data-contact_id="{{ $client_row['contact_id'] }}" data-added_from="contact">{{ $client_row['contact_name'] or "" }}</a></td>
                  <td align="left">{{ $client_row['telephone'] or "" }}</td>
                  <td align="left">{{ $client_row['mobile'] or "" }}</td>
                  <td align="left">{{ $client_row['email'] or "" }}</td>
                  <td align="left">{{ (strlen($client_row['address']) > 48)? substr($client_row['address'], 0, 45)."...<a href='javascript:void(0)' class='more_address' data-contact_id='".$client_row['contact_id']."' data-client_type='other'>more</a>": $client_row['address'] }}</td>
                  <td align="left"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-contact_id="{{ $client_row['contact_id'] or "" }}" data-contact_type="other"><span {{ (isset($client_row['notes']) && $client_row['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a></td>
                  
                </tr>
            @endforeach
          @endif
        
        
      </tbody>
    </table>
  </div>
    <div id="tab_5" class="tab-pane {{ (isset($step_id) && $step_id == 5)?'active':''}}">
    <!-- <div class="contact_email">
      <a href="javascript:void(0)" class="search_add open_addto_group">Add to group</a>
    </div> -->
    <table class="table table-bordered table-hover dataTable email_letter" id="example5" aria-describedby="example5_info">
      <thead>
        <tr role="row">
          <th width="2%"><input type="checkbox" class="allCheckSelect"/></th>
          <th width="20%">Date/Time</th>
          <th width="3%">Count</th>
          <th width="20%">Created By</th>
          <th width="35%">Name</th>
          <th width="10%">Notes</th>
          <th width="10%">Email Group</th>
        </tr>
      </thead>
      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($step_details) && count($step_details) >0)
          @foreach($step_details as $key=>$client_row)
          <tr class="all_check">
            <td align="left">
              <input type="checkbox" class="ads_Checkbox" name="delete_id[]" value="{{ $client_row['step_id'] or "" }}"/>
            </td>
            <td align="left">{{ date('d-m-Y H:i:s', strtotime($client_row['created'])) }}</td>
            <td align="left">{{ $client_row['count'] or "0" }}</td>
            <td align="left">{{ $client_row['created_by'] or "" }}</td>
            <td align="left"><a href="/contacts-letters-emails/{{ $client_row['step_id'] }}/{{ $encoded_type }}">{{ $client_row['title'] or "" }}</a></td>
            <td align="left">
              <a href="#" id="coursesnotesopen" data-id="5" data-target="#groupssnotes-modal"><span class="notes_btn open_notes_popup">notes</span></a>
            </td>
            <td align="left">
              <button type="button" class="job_send_btn send_manage_task" data-client_id="1" data-field_name="ch_manage_task">SEND</button>
            </td>
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>
  </div>

  <div id="tab_6" class="tab-pane {{ (isset($step_id) && $step_id != 1 && $step_id != 2 && $step_id != 3 && $step_id != 4 && $step_id != 5)?'active':''}}">
    <!-- <div class="contact_email">
      <a href="javascript:void(0)" class="search_add open_addto_group">Add to group</a>
      <a href="#" class="search_t" data-toggle="modal" data-target="#add_contact-modal">Add Contact</a>
    </div> -->
    <table class="table table-bordered table-hover dataTable email_letter" id="example6" aria-describedby="example6_info">
      <thead>
        <tr role="row">
          <th width="3%">Delete</th>
          <th>Name</th>
          <th width="15%">Contact Person</th>
          <th>Telephone</th>
          <th>Mobile</th>
          <th>Email</th>
          <th>Correspondence Address</th>
        </tr> 
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($group_details) && count($group_details) >0)
              @foreach($group_details as $key=>$client_row)
                <tr class="all_check">
                  <input type="hidden" name="custom_address_{{ $client_row['client_id'] }}" id="custom_address_{{ $client_row['client_id'] or "" }}" value="{{ $client_row['address'] or "" }}">

                  <td align="center"><a href="javascript:void(0)" class="delete_group_client" data-client_id="{{ $client_row['client_id'] or "" }}" data-contact_type="{{ $client_row['client_type'] or "" }}"><img src="/img/cross.png" height="14" title="Delete Group?"></a></td>
                  <td align="left">
                  @if(isset($client_row['client_type']) && $client_row['client_type']=='ind')
                    <a target="_blank" href="/client/edit-ind-client/{{ $client_row['client_id'] }}/{{ base64_encode('ind_client') }}">{{ $client_row['client_name'] or "" }}</a>
                  @endif
                  @if(isset($client_row['client_type']) && $client_row['client_type']=='org')
                    <a target="_blank" href="/client/edit-org-client/{{ $client_row['client_id'] }}/{{ base64_encode('org_client') }}">{{ $client_row['client_name'] or "" }}</a>
                  @endif
                  </td>
                  <td align="left">{{ $client_row['contact_person'] or "" }}</td>
                  <td align="left">{{ $client_row['telephone'] or "" }}</td>
                  <td align="left">{{ $client_row['mobile'] or "" }}</td>
                  <td align="left">{{ $client_row['email'] or "" }}</td>
                  <td align="left">{{ (strlen($client_row['address']) > 48)? substr($client_row['address'], 0, 45)."...<a href='javascript:void(0)' class='more_address' data-client_id='".$client_row['client_id']."' data-client_type='custom'>more</a>": $client_row['address'] }}</td>
                </tr>
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
        
      </div>
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->


<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="upload_letterhead-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NEW FILE</h4>
        <div class="clearfix"></div>
      </div>
    
    <input type="hidden" name="client_type" value="org" />
    <input type="hidden" name="back_url" value="add_org" />
      <div class="modal-body">
        

        <div class="form-group">
          <label for="exampleInputPassword1">Upload your customised .docx letterhead</label>
          <input type="file" class="form-control" name="upload_name" id="upload_name">
        </div>
        
        <div class="modal-footer1 clearfix">
          <div class="email_btns1">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info" name="save">Save</button>
          </div>
        </div>
      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- Notes modal start -->
<div class="modal fade" id="notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">SAVE NOTES</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <input type="hidden" id="notes_client_id" name="notes_client_id">
        <input type="hidden" id="contact_type" name="contact_type">
        <table>
          <tr>
            <td align="left" width="20%"><strong>Notes : </strong></td>
            <td align="left"><textarea cols="56" rows="4" id="notes" name="notes"></textarea></td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="right"><button type="button" class="btn btn-info save_notes">Save</button></td>
          </tr>
        </table>

        
      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>        
<!-- Notes modal start -->

<!-- Create Group modal start -->
<div class="modal fade" id="create_group-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">GROUP CONTACTS</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="loader_class"><!-- Loader Image Show--></div>
        <input type="hidden" id="clients_array" value="">
        <div class="form-group">
          <label for="exampleInputPassword1"><strong>Add to an existing group</strong></label>
          <select class="form-control" id="group_step_id">
            <option value="">None</option>
            @if(isset($steps) && count($steps) >0)
              @foreach($steps as $key=>$step_row)
                @if(isset($step_row['step_type']) && $step_row['step_type'] == "new")
                  <option value="{{ $step_row['step_id'] or "" }}">{{ $step_row['title'] or "" }}</option>
                @endif
              @endforeach
            @endif
          </select>
        </div>

        <div class="form-group" id="group_show">
          <label for="exampleInputPassword1"><strong>Add to a new group</strong></label>
          <input type="text" name="group_name" id="group_name" maxlength="12" class="form-control">
        </div>

        <div class="modal-footer1 clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-info pull-left saveto_group">Save</button>
          </div>
        </div>

      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>        
<!-- Create Group modal end -->

<!-- Add to Group modal start -->
<div class="modal fade" id="addto_group-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">EDIT/DELETE GROUP</h4>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <div class="loader_class"><!-- Loader Image Show--></div>
        <table class="table table-bordered table-hover dataTable add_status_table">
          <thead>
            <tr>
              <th width="60%">Group Name</th>
              <th align="center">Action</th>
            </tr>
          </thead>
          
          <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(isset($steps) && count($steps) >0)
              @foreach($steps as $key=>$step_row)
                @if(isset($step_row['step_type']) && $step_row['step_type'] == "new")
                  <tr>
                    <td><span id="status_span{{ $step_row['step_id'] or "" }}">{{ $step_row['title'] or "" }}</span></td>
                    <td align="center">
                      <span id="action_{{ $step_row['step_id'] or "" }}"><a href="javascript:void(0)" class="edit_status" data-step_id="{{ $step_row['step_id'] or "" }}"><img src="/img/edit_icon.png" title="Edit Group?"></a>
                      <a href="javascript:void(0)" class="delete_group" data-step_id="{{ $step_row['step_id'] or "" }}"><img src="/img/cross.png" height="12" title="Delete Group?"></a>
                      </span>

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
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>        
<!-- Add to Group modal end -->

<!-- Add to Group modal start -->
<div class="modal fade" id="groupssnotes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-content">
        <div class="modal-header">
          
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <div class="loader_class"><!-- Loader Image Show--></div>
                </div>
  </div>
      
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="groupssemail-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-content">
        <div class="modal-header">
          
          <div class="clearfix"></div>
        </div>
        <div class="modal-body">
          <div class="loader_class"><!-- Loader Image Show--></div>
                </div>
  </div>
      
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

@include("contacts_letters.modal")
@stop