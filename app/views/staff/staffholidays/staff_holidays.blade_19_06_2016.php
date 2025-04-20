@extends('layouts.layout')
@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Color picker -->
<link rel="stylesheet" href="/css/colorpicker/colorpicker.css" type="text/css" />
<link rel="stylesheet" href="/css/colorpicker/layout.css" media="screen" type="text/css" />
<!-- Color picker -->
@stop

@section('myjsfile')
<!-- Color picker -->
<script type="text/javascript" src="/js/colorpicker/colorpicker.js"></script>
<script type="text/javascript" src="/js/colorpicker/eye.js"></script>
<script type="text/javascript" src="/js/colorpicker/layout.js?ver=1.0.2"></script>
<!-- Color picker -->

<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!--<script src="{{ URL :: asset('js/org_clients.js') }}" type="text/javascript"></script> -->
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/relationship.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/holiday.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
<!-- Date picker script -->

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<!-- Date picker script -->
<script>
$(document).ready(function(){
    $("#holiday_start").datepicker({dateFormat:'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+100"});
    $("#holiday_end").datepicker({dateFormat:'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+100"});
});

/*$(function() {
    $( "#holiday_start" ).datepicker({
      //defaultDate: "+1w",
      dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+100",
      //numberOfMonths: 3,
      onClose: function( selectedDate ) {
        //$( "#holiday_end" ).datepicker( "option", "minDate", selectedDate );
        console.log("Start : "+selectedDate);
      }
    });
    $( "#holiday_end" ).datepicker({
      //defaultDate: "+1w",
      dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-100:+100",
      //numberOfMonths: 3,
      onClose: function( selectedDate ) {
        //$( "#holiday_start" ).datepicker( "option", "maxDate", selectedDate );
        //console.log("End : "+selectedDate);

      }
    });
  });*/
</script>

<!-- page script -->
<script type="text/javascript">
var Table1, Table2, Table3,Table6;
$(function() {
    
    
  Table6 = $('#example6').dataTable({
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
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
    ]

});

var staff_id= $("#staff_typeid").val();
    // console.log(staff_typeid);
    // alert(staff_id);
    if(staff_id=="staff"){
        
    
    $('#example1').dataTable({
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

      "aoColumns":[
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ],
        "aaSorting": [[3, 'desc']]

    });

    $('#example2').dataTable({
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

      "aoColumns":[
           {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ],
        "aaSorting": [[3, 'desc']]

    });

   
   //Table2.fnSort( [ [1,'asc'] ] );

   Table3 = $('#example3').dataTable({
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
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });
 // Table3.fnSort( [ [1,'asc'] ] );
  }
  else{
    
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
            //{"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
          //  {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });
 // Table1.fnSort( [ [1,'asc'] ] );

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
          // {"bSortable": false},
          //  {"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });

   
  // Table2.fnSort( [ [1,'asc'] ] );

   Table3 = $('#example3').dataTable({
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
          // {"bSortable": false},
            //{"bSortable": false},
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });
 // Table3.fnSort( [ [1,'asc'] ] );
    
    
    
  }
  
 // $("#stafdpick").datepicker({dateFormat: 'dd-mm-yy'});
  $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});
  
  
$('#snotes').click(function() {
    
   // alert('gigigi');
   // $("#staffcompose-modal").modal("hide");
    
    
    });
    
     //var client_id = $(this).val();
     //alert(client_id);
    $('#staffmDetails1').change(function() {
       
        var client_id = $(this).val();
        // alert(client_id);
         console.log(client_id);
         
         if(client_id != "" ){
            //$("#view_edit_company").show();
            
            $.ajax({
                type: "GET",
                //dataType: "json",
                //url: '/client/client-details-by-client_id/'+client_id+"=ajax",
                url: "/staffholidays",
               data: { 'client_id' : client_id },
                beforeSend: function() {
                   // $(".show_client_details").html('<img src="/img/spinner.gif" />');
                    //return false;
                },
                success : function(resp){
                  
                 if(resp!= "") {
                    var res = JSON.parse(resp);
                    var vsl=res.field_value;
                   
                    $("#shentitlement").val(vsl);
                    
                    //alert(vsl);
                  // console.log(resp);
                }
                else{
                    $("#shentitlement").val("");
                }
                
                }
                
                
                
                
            });
        }
        else{
            $("#shentitlement").val("");
            
        }
         
         
         
         
          });
    
});

$('.addnew_line').click(function() {
	$(".dpick").datepicker("destroy");  
        var $newstaffRow = $('#staffholi').clone(true);
        
        $newstaffRow.find('#sdate_picker').val('');
        $newstaffRow.find('.dpick').val('');
        $newstaffRow.find('#due').val('');
        $newstaffRow.find('#rtype').val('');
        $newstaffRow.find('#snotes').val('');
        
        var noOfDivs = $('.makeCloneClass').length + 1;
        
        $newstaffRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
        $('#sBoxTable tr:last').after($newstaffRow);
        $(".dpick").datepicker({dateFormat: 'dd-mm-yy'}); 
				
		return false;
	});
    
    
    $('.sDeleteBoxRow').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".sDeleteBoxRow").size();
		if(size>1){
        	$(this).closest('tr').remove();
		}
    });
    
    function addnotesmodal(){
        
        //alert('dsdsdsd');return false;
        
        $("#addfontnotes-modal").modal("hide");
    
    }
    function staffnotes(){
        
        
        
        var staffnotesval= $("#addfontnotesss").val();
        $('#notesstaff').val(staffnotesval);
        
        $("#addfontnotes-modal").modal("hide");
        //alert('fafafaf');return false;
    }



$(document).ready(function(){
    $("#emp_start_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#pop_holiday_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
});
</script>
@stop

@section('content')
<input type="hidden" id="staff_typeid" name="staff_type" value="{{ $staff_type }}" />
<input type="hidden" id="encode_staff_type" value="{{ base64_encode($staff_type) }}" />
<input type="hidden" id="logged_id" value="{{ $logged_id }}" />
<input type="hidden" id="start_date" value="{{ $start_date }}" />
<input type="hidden" id="encode_start_date" value="{{ base64_encode($start_date) }}" />
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

    <section class="content-header">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="5%">
                <div style="text-align: left; margin: 3px 12px 0 22px;">
                    <a href="/holidaypdf/{{ base64_encode($staff_type) }}/{{$page_open}}/{{'pdf'}}" class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</a>
                </div>
            </td>
            <td width="5%">
                <div style="text-align: left; margin: 3px 12px 0 0px;">
                    <a href="/holidaypdf/{{ base64_encode($staff_type) }}/{{$page_open}}/{{'excel'}}" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</a>
                </div>
            </td>

            <td width="25%">
                <div style="text-align: left; margin: 3px 12px 0 0px;">
                    <a class="btn btn-default openNewRequest"><span class="requ_t">New Request</span></a>
                </div>
            </td>
            <td width="65%"></td>
          </tr>
        </table>
        <div class="clearfix"></div>
    </section>

    <section class="content">
      <div class="practice_mid">

        <div class="top_buttons">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="4%">
            <div class="top_bts" style="padding-top: 12px;">
            <input type="hidden" id="stafftype" value="{{$staff_type}}" />
              <ul>
                <!-- <li>

                <a class="btn btn-default openNewRequest"><span class="requ_t">New Request</span></a>

                </li> -->
                <div class="clearfix"></div>
              </ul>
            </div>
        </td>
        <td align="center" width="26%">
            <div style="float:left; margin: 6px 5px 0 40px;">Current Holiday Year :&nbsp;</div>
            <!-- <div id="rcorners2" class="holiday_year_span">
                <a href="javascript:void(0)" class="{{ ($staff_type == 'staff')?'open_holiday_pop':'' }}" data-value="{{ (isset($holiday_details['holiday_date']) && $holiday_details['holiday_date'] != '')?$holiday_details['holiday_date']:'' }}">{{ (isset($holiday_details['holiday_date']) && $holiday_details['holiday_date'] != '')?$holiday_details['holiday_date']:'Add..' }}</a>{{ (isset($holiday_details['holiday_end']) && $holiday_details['holiday_end'] != '')?' - '.$holiday_details['holiday_end']:'' }}
            </div> -->
            <div style="float:left; margin: 6px 5px 0 0px;" class="showDate">
                @if(isset($start_date) && $start_date != 'new')
                <div id="rcorners2" class="holiday_year_span">
                    {{ (isset($start_date) && $start_date != '')?$start_date:'' }}
                    {{ (isset($start_date) && $start_date != '')?' - '.$end_date:'' }}
                </div>
                @else
                    <a href="javascript:void(0)" class="open_holiday_pop" data-value="{{ $start_date or 'new' }}" data-position="outer">Set Holiday year</a>
                @endif
            </div>
        </td>
    
    <td width="10%">
      @if($staff_type == "staff")
       <select style="width:145px;border-radius: 5px 5px 5px 5px !important;" id="staffmDetails" class="form-control header_select" >
          <option value="">--Select Staff-- </option>
          @if(!empty($staff_details))
            @foreach($staff_details as $key=>$staff_row)
              <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
            @endforeach
          @endif
        </select>
      @endif
    
    </td>
    <td width="13%">
      <select class="form-control header_select" name="requesttype" id="head_type_drop" style="width:160px;border-radius: 5px 5px 5px 5px !important;" >
        <option value="">--Select Leave Type-- </option>
        @if( isset($old_holiday_types) && count($old_holiday_types) >0 )
        @foreach($old_holiday_types as $key=>$old_row)
            <option value="{{ $old_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $old_row['type_id'])?'selected':'' }}>{{ $old_row['name'] or "" }}</option>
        @endforeach
        @endif

        @if( isset($new_holiday_types) && count($new_holiday_types) >0 )
        @foreach($new_holiday_types as $key=>$new_row)
            <option value="{{ $new_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $new_row['type_id'])?'selected':'' }}>{{ $new_row['name'] or "" }}</option>
        @endforeach
      @endif
        </select>
    </td>
    <!-- <td width="10%">Holidays Entitlement</td>
    <td width="3%"><input type="text" id="shentitlement" style="width:50px;text-align: center;" value="" disabled/></td> -->
    <td width="5%">Days Taken</td>
    <td width="6%"><input type="text" id="head_days_taken" style="width:50px;text-align: center;" disabled/></td>
    <td width="20%"><div id="remainDiv">Days Remaining <input type="text" id="head_days_remain" style="width:50px;text-align: center;" disabled></div></td>
    <!-- <td width="13%"></td> -->
  </tr>
</table>

      </div>
          <div class="tabarea">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
                
                <li class="{{ ($page_open == 1)?'active':'' }}"><a href="/staff-holidays/{{ base64_encode($staff_type) }}/1/{{ base64_encode($start_date) }}">NEW REQUESTS</a></li>
                
                
                <li class="{{ ($page_open == 2)?'active':'' }}"><a href="/staff-holidays/{{ base64_encode($staff_type) }}/2/{{ base64_encode($start_date) }}">APPROVED</a></li>
                <li class="{{ ($page_open == 3)?'active':'' }}"><a href="/staff-holidays/{{ base64_encode($staff_type) }}/3/{{ base64_encode($start_date) }}">DECLINED</a></li>
                <li class="{{ ($page_open == 4)?'active':'' }}"><a href="/staff-holidays/{{ base64_encode($staff_type) }}/4/{{ base64_encode($start_date) }}">ARCHIVE</a></li>
                <li class="{{ ($page_open == 5)?'active':'' }}"><a href="/staff-holidays/{{ base64_encode($staff_type) }}/5/{{ base64_encode($start_date) }}">EVENT CALENDER</a></li>
                
                @if($staff_type == "staff")
                <li style="float: right;" class="{{ ($page_open == 6)?'active':'' }}"><a href="/staff-holidays/{{ base64_encode($staff_type) }}/6/{{ base64_encode($start_date) }}">SETTINGS</a></li>
               <!-- <li style="float: right;"><a  data-toggle="modal" data-target="#staffsettings-modal" href="#">SETTINGS</a></li> -->
                 @endif
                
              </ul>
              <div class="tab-content">
              
              <div id="tab_1" class="tab-pane {{ ($page_open == 1)?'active':'' }}">
                
                  <!--table area-->
                  <div class="box-body table-responsive" style="position:relative;">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4"></div>
                      </div>
                    <!--  <div style="position:absolute; left: 50%; z-index: 10; margin-top: -4px;">
          <button class="btn btn-default" data-toggle="modal" data-target="#staffcompose-modal"><span class="requ_t">New Request</span></button>
          @if($staff_type == "staff")
          <button class="btn btn-default">Approve</button>
          <button class="btn btn-default"><span class="decline_t">Decline</span></button>
          @endif
                      </div> -->

                      <div class="row">
                        <div class="col-xs-12">
<table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">
  @if($staff_type == "staff")
    <thead>
      <tr role="row">
        <th align="left" width="5%"><input type="checkbox" id="allCheckSelect"/></th>
        <th align="center" width="15%">Staff Name</th>
        <th align="left">Time Off Type <!-- <a style="float:right;padding-right: 8px;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a> --></th>
        <th align="center" width="8%">Date</th>
        <th align="left" style="" >Duration</th> 
        <th align="center" width="10%">Status</th>
        <th align="center" style="padding: 9px 4px; width: 10%;">Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
    @if(!empty($awating_staff))
	    @foreach($awating_staff as $key=>$staff)
            <tr>
                <td align="left"><input type="checkbox" data-archive="{{ $value['show_archive'] or "" }}" class="ads_Checkbox" name="staff_delete_id[]" value="{{ $staff['staff_detail']['user_id'] }}"></td>
                <th align="center"><a href="#" class="editrequest" data-rowid="{{$staff['holidayrequest_id']}}">{{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}</a></th>
                <td align="left">{{$staff['type_name'] or ""}}</td>
                <td align="center">{{$staff['date'] or ""}}</td>
                <td align="left" style="">{{$staff['duration'] or ""}}</td> 
                <td align="center">
                 <input type="button" value="{{$staff['state'] or ""}}" class="awating_btn">
                </td>
                <td align="center" style="padding: 9px 0; width: 10%;">
                @if(empty($staff['notes']))
                    <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span class="btn btn-default note_t">Notes</span>
                    </a>
                @endif
                @if(!empty($staff['notes']))
                    <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="btn btn-default note_t">Notes</span>
                    </a>
                @endif
                </td>
               
               
        <td align="center">
            <select class="form-control statechage" >
                <option value="">-- Select --</option>
            @if($page_open != 1 && $page_open != 4)
                <!-- <option value="Awaiting Approval||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] == "Awaiting Approval")?"selected":"" }}>Withraw Decision</option> -->
            @endif
                <option value="Approved||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] == "Approved")?"selected":"" }}>Approve</option>
                <option value="Declined||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] =="Declined")?"selected":"" }}>Decline</option>
                <option value="delete||{{$staff['holidayrequest_id']}}" >Delete</option>
            </select>
        </td>
      </tr>
        @endforeach
    @endif
  
</tbody>
    
    
    
    
          
  @else
    <thead>
      <tr role="row">
       <!-- <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
       
        <th align="left">Time Off Type</th>
         <th align="center" width="10%">Date</th>
        <th align="left">Duration</th>
        <th align="center" width="10%">Status</th>
       <!--  <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        <th align="center" style="padding: 9px 4px; width: 10%;">Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
     
     @if(!empty($profilesection))
			 @foreach($profilesection as $key=>$prof)
    @if($prof->state == "Awaiting Approval" || $prof->state == "Request Withdrawn")
                  <tr>
                    
                   
                   
                    <td align="left">{{$prof->type_name or ""}}</td>
                      <td align="center">{{$prof->date or ""}}</td>
                   <td align="left" style="">{{$prof->duration or ""}}</td> 
                    <td align="center">
                     <input type="button" value="{{$prof->state or ""}}" class="awating_btn">
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                    <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
                   
                   
                     <td align="center"> <select class="form-control statechage">
                    <option value="None||{{$prof->holidayrequest_id}}">-- Select --</option>
                    <option value="Request Withdrawn||{{$prof->holidayrequest_id}}">Withdraw Request</option>
                    <!-- <option value="delete||{{$prof->holidayrequest_id}}" >Delete</option> -->
                    
                </select>
        
        
        </td>
                  </tr>
                   @endif
            @endforeach
        @endif
     

    </tbody>
  @endif                
</table>
  </div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                </div>
                <!-- /.tab-pane -->
                <div id="tab_2" class="tab-pane {{ ($page_open == 2)?'active':'' }}">
               
                
                
                
                
                  <!--table area-->
                  <div class="box-body table-responsive" style="position:relative;">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4"></div>
                      </div>
                    <!--  <div style="position:absolute; left: 50%; z-index: 10; margin-top: -4px;">
          <button class="btn btn-default" data-toggle="modal" data-target="#staffcompose-modal"><span class="requ_t">New Request</span></button>
          @if($staff_type == "staff")
          <button class="btn btn-default">Approve</button>
          <button class="btn btn-default"><span class="decline_t">Decline</span></button>
          @endif
                      </div> -->

                      <div class="row">
                        <div class="col-xs-12">
<table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
  @if($staff_type == "staff")
    <thead>
      <tr role="row">
       <th align="left" width="5%"><input type="checkbox" id="allCheckSelect"/></th>
       
        <th align="center" width="15%">Staff Name</th>
        <th align="left">Time Off Type <!-- <a style="float:right;padding-right: 8px;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a> --></th>
          <th align="left" width="8%">Date</th>
         <th align="left" style="" >Duration</th> 
        <th align="center" width="10%">Status</th>
       <!-- <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        <th align="center" style="padding: 9px 4px; width: 10%;">Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      
    	@if(!empty($awating_staff))
			 @foreach($awating_staff as $key=>$staff)
    
                  <tr>
                    <td align="left"><input type="checkbox" data-archive="{{ $value['show_archive'] or "" }}" class="ads_Checkbox" name="staff_delete_id[]" value="{{ $staff['staff_detail']['user_id'] }}"></td>
                     
                    <th align="center"><a href="#" class="editrequest" data-rowid="{{$staff['holidayrequest_id']}}">{{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}</a></th>
                    <td align="left">{{$staff['type_name'] or ""}}</td>
                    <td align="center">{{$staff['date'] or ""}}</td>
                   <td align="left" style="">{{$staff['duration'] or ""}}</td> 
                    <td align="center">
                     <input type="button" value="{{$staff['state'] or ""}}{{"!"}}" class="approved_btn">
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                    <td align="center" style="padding: 9px 0; width: 10%;">
                    
                     @if(empty($staff['notes']))
                                     <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span class="btn btn-default note_t">Notes</span>
                                    </a>
                                    @endif
                                    @if(!empty($staff['notes']))
                                    
                                    <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="btn btn-default note_t">Notes</span>
                                    </a>
                                   
                                   @endif
                    
                    
                    
                    </td>
                   
                   
                    <td align="center">
                            <select class="form-control statechage" >
                                <option value="">-- Select --</option>
                                <option value="Awaiting Approval||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] == "Awaiting Approval")?"selected":"" }}>Withraw Decision</option>
                                <!-- <option value="Approved||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] == "Approved")?"selected":"" }}>Approve</option> -->
                                <option value="Declined||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] =="Declined")?"selected":"" }}>Decline</option>
                                <!-- <option value="delete||{{$staff['holidayrequest_id']}}" >Delete</option> -->
                                <option value="archive||{{$staff['holidayrequest_id']}}" >Archive</option>
                            </select>
                    </td>
                  </tr>
            @endforeach
        @endif
      
    </tbody>
          
  @else
    <thead>
      <tr role="row">
       <!-- <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
        
        <th align="left">Time Off Type</th>
        <th align="center" width="10%">Date</th>
        <th align="left">Duration</th>
        <th align="center" width="10%">Status</th>
       <!--  <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        <th align="center" style="padding: 9px 4px; width: 10%;">Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

   <tbody role="alert" aria-live="polite" aria-relevant="all">
     
     @if(!empty($profilesection))
			 @foreach($profilesection as $key=>$prof)
    @if($prof->state == "Approved" && $prof->archive == "unarchive")
                  <tr>
                    
                    
                   
                    <td align="left">{{$prof->type_name or ""}}</td>
                     <td align="center">{{$prof->date or ""}}</td>
                   <td align="left" style="">{{$prof->duration or ""}}</td> 
                    <td align="center">
                     <input type="button" value="{{$prof->state or ""}}{{"!"}}" class="approved_btn">
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                    <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
                   
                   
                     <td align="center"> <select class="form-control statechage">
                    <option value="None||{{$prof->holidayrequest_id}}">-- Select --</option>
                    <option value="Request Withdrawn||{{$prof->holidayrequest_id}}">Withdraw Request</option>
                   <!-- <option value="delete||{{$prof->holidayrequest_id}}" >Delete</option> -->
                    <option value="archive||{{$prof->holidayrequest_id}}" >Archive</option>
                </select>
        
        
        </td>
                  </tr>
                  @endif
            @endforeach
        @endif
     

    </tbody>
  @endif                
</table>
  </div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                
                
                
                
                
                
                
                </div>
                <!-- /.tab-pane -->
                  <div id="tab_3" class="tab-pane {{ ($page_open == 3)?'active':'' }}">
                  <div class="box-body table-responsive" style="position:relative;">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4"></div>
                      </div>
                    <!--  <div style="position:absolute; left: 50%; z-index: 10; margin-top: -4px;">
          <button class="btn btn-default" data-toggle="modal" data-target="#staffcompose-modal"><span class="requ_t">New Request</span></button>
          @if($staff_type == "staff")
          <button class="btn btn-default">Approve</button>
          <button class="btn btn-default"><span class="decline_t">Decline</span></button>
          @endif
                      </div> -->

                      <div class="row">
                        <div class="col-xs-12">
<table class="table table-bordered table-hover dataTable" id="example3" aria-describedby="example3_info">
  @if($staff_type == "staff")
    <thead>
      <tr role="row">
        <th align="left" width="5%"><input type="checkbox" id="allCheckSelect"/></th>
        
        <th align="left" width="15%">Staff Name</th>
        <th align="left">Time Off Type <!-- <a style="float:right;padding-right: 8px;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a> --></th>
        <th align="center" width="8%">Date</th>
         <th align="center" style="" >Duration</th> 
        <th align="left" width="10%">Status</th>
       <!-- <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        <th align="center" style="padding: 9px 4px; width: 10%;">Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      
    	@if(!empty($awating_staff))
			 @foreach($awating_staff as $key=>$staff)
             @if( $staff['archive'] == "unarchive")
                  <tr>
                    <td align="left"><input type="checkbox" data-archive="{{ $value['show_archive'] or "" }}" class="ads_Checkbox" name="staff_delete_id[]" value="{{ $staff['staff_detail']['user_id'] }}"></td>
                    
                    <th align="center"><a href="#"  class="editrequest" data-rowid="{{$staff['holidayrequest_id']}}">{{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}</a></th>
                    <td align="left">{{$staff['type_name'] or ""}}</td>
                    <td align="left">{{$staff['date'] or ""}}</td>
                   <td align="left" style="">{{$staff['duration'] or ""}}</td> 
                    <td align="center">
                     <input type="button" value="{{$staff['state'] or ""}}" class="declined_btn">
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                    <td align="center" style="padding: 9px 0; width: 10%;">
                     @if(empty($staff['notes']))
                                     <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span class="btn btn-default note_t">Notes</span>
                                    </a>
                                    @endif
                                    @if(!empty($staff['notes']))
                                    
                                    <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="btn btn-default note_t">Notes</span>
                                    </a>
                                   
                                   @endif
                    
                    
                    
                    
                    
                    </td>
                   
                   
                    <td align="center">
                            <select class="form-control statechage" >
                                <option value="">-- Select --</option>
                                <option value="Awaiting Approval||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] == "Awaiting Approval")?"selected":"" }}>Withraw Decision</option>
                                <option value="Approved||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] == "Approved")?"selected":"" }}>Approve</option>
                                <!-- <option value="Declined||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] =="Declined")?"selected":"" }}>Decline</option>
                                <option value="delete||{{$staff['holidayrequest_id']}}" >Delete</option> -->
                                <option value="archive||{{$staff['holidayrequest_id']}}" >Archive</option>
                            </select>
                    </td>
                  </tr>
                  @endif
            @endforeach
        @endif
      
    </tbody>
          
  @else
    <thead>
      <tr role="row">
       <!-- <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
       
        <th align="left">Time Off Type</th>
         <th align="left" width="10%">Date</th>
        <th align="left">Duration</th>
        <th align="left" width="10%">Status</th>
       <!--  <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        <th align="left" style="padding: 9px 4px; width: 10%;">Notes</th>
        <th align="left">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
     
     @if(!empty($profilesection))
			 @foreach($profilesection as $key=>$prof)
    @if($prof->state == "Declined" &&  $prof->archive == "unarchive")
                  <tr>
                   
                    <td align="left">{{$prof->type_name or ""}}</td>
                     <td align="left">{{$prof->date or ""}}</td>
                   <td align="left" style="">{{$prof->duration or ""}}</td> 
                    <td align="left">
                     <input type="button" value="{{$prof->state or ""}}" class="declined_btn">
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                    <td align="left" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
                   
                   
                     <td align="center"> <select class="form-control statechage">
                    <option value="None||{{$prof->holidayrequest_id}}">-- Select --</option>
                    <option value="Request Withdrawn||{{$prof->holidayrequest_id}}">Withdraw Request</option>
                  <!--  <option value="delete||{{$prof->holidayrequest_id}}" >Delete</option> -->
                    <option value="archive||{{$prof->holidayrequest_id}}" >Archive</option>
                </select>
        
        
        </td>
                  </tr>
                  @endif
            @endforeach
        @endif
     

    </tbody>
  @endif                
</table>
  </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div id="tab_4" class="tab-pane {{ ($page_open == 4)?'active':'' }}">
               
                <div class="box-body table-responsive" style="position:relative;">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4"></div>
                      </div>
                    <!--  <div style="position:absolute; left: 50%; z-index: 10; margin-top: -4px;">
          <button class="btn btn-default" data-toggle="modal" data-target="#staffcompose-modal"><span class="requ_t">New Request</span></button>
          @if($staff_type == "staff")
          <button class="btn btn-default">Approve</button>
          <button class="btn btn-default"><span class="decline_t">Decline</span></button>
          @endif
                      </div> -->

                      <div class="row">
                        <div class="col-xs-12">
<table class="table table-bordered table-hover dataTable" id="example3" aria-describedby="example3_info">
  @if($staff_type == "staff")
    <thead>
      <tr role="row">
        <th align="left" width="5%"><input type="checkbox" id="allCheckSelect"/></th>
        
        <th align="left" width="15%">Staff Name</th>
        <th align="left">Time Off Type <!-- <a style="float:right;padding-right: 8px;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a> --></th>
        <th align="center" width="8%">Date</th>
         <th align="center" style="" >Duration</th> 
        <th align="left" width="10%">Status</th>
       <!-- <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        <th align="center" style="padding: 9px 4px; width: 10%;">Notes</th>
        <th align="center">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      
    	@if(!empty($awating_staff))
			 @foreach($awating_staff as $key=>$staff)
             
             @if($staff['archive'] == "archive")
             
                  <tr>
                    <td align="left"><input type="checkbox" data-archive="{{ $value['show_archive'] or "" }}" class="ads_Checkbox" name="staff_delete_id[]" value="{{ $staff['staff_detail']['user_id'] }}"></td>
                    
                    <th align="center">
                    
                    <a href="#"  class="editrequest" data-rowid="{{$staff['holidayrequest_id']}}">{{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}</a>
                    
                    <!--
                    <a href="/my-details/{{ $staff['staff_detail']['user_id'] }}/{{ base64_encode('staff') }}">{{$staff['staff_detail']['fname'] or ""}} {{$staff['staff_detail']['lname'] or ""}}</a> -->
                    
                    
                    
                    </th>
                    <td align="left">{{$staff['type_name'] or ""}}</td>
                    <td align="left">{{$staff['date'] or ""}}</td>
                   <td align="left" style="">{{$staff['duration'] or ""}}</td> 
                    <td align="center">
                     <input type="button" value="{{$staff['state'] or ""}}"
                     
                     @if( $staff['state']=="Approved")
                      class="approved_btn" />
                      @endif
                      @if($staff['state']=="Declined")
                      class="declined_btn" />
                      @endif
                      
                    </td>
                 <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                    
                    <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>
                   
                   
                    <td align="center">
                            <select class="form-control statechage" >
                                <option value="">-- Select --</option>
                                <!-- <option value="Approved||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] == "Approved")?"selected":"" }}>Approve</option>
                                <option value="Declined||{{$staff['holidayrequest_id']}}" {{ (isset($staff['state']) && $staff['state'] =="Declined")?"selected":"" }}>Decline</option>
                                <option value="delete||{{$staff['holidayrequest_id']}}" >Delete</option> -->
                                <option value="unarchive||{{$staff['holidayrequest_id']}}" >Unarchive</option>
                            </select>
                    </td>
                  </tr>
                  @endif
            @endforeach
        @endif
      
    </tbody>
          
  @else
    <thead>
      <tr role="row">
       <!-- <th align="left"><input type="checkbox" id="allCheckSelect"/></th> -->
       
        <th align="left">Time Off Type</th>
         <th align="left" width="10%">Date</th>
        <th align="left">Duration</th>
        <th align="left" width="10%">Status</th>
       <!--  <th align="center" style="padding: 6px 4px; width: 10%;" >Requester Notes</th> -->
        <th align="left" style="padding: 9px 4px; width: 10%;">Notes</th>
        <th align="left">Action</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
     
     @if(!empty($profilesection))
			 @foreach($profilesection as $key=>$prof)
    @if($prof->archive == "archive")
                  <tr>
                <td align="left">{{ $prof->type_name or "" }}</td>
                <td align="left">{{$prof->date or ""}}</td>
                <td align="left" style="">{{$prof->duration or ""}}</td> 
                <td align="left">
                    <input type="button" value="{{$prof->state or ""}}"
                      @if( $prof->state=="Approved")
                      class="approved_btn" />
                      @endif
                      @if($prof->state=="Declined")
                      class="declined_btn" />
                      @endif
                </td>
                <!--   <td align="center" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td> -->
                
                <td align="left" style="padding: 9px 0; width: 10%;"><button class="btn btn-default note_t">Notes</button></td>

                   
                <td align="center"> <select class="form-control statechage">
                    <option value="None||{{$prof->holidayrequest_id}}">-- Select --</option>
                    <option value="Request Withdrawn||{{$prof->holidayrequest_id}}">Withdraw Request</option>
                   <!-- <option value="delete||{{$prof->holidayrequest_id}}" >Delete</option> -->
                    <option value="unarchive||{{$prof->holidayrequest_id}}" >Unarchive</option>
                    </select>
                </td>
                  </tr>
                  @endif
            @endforeach
        @endif
     

    </tbody>
  @endif                
</table>
  </div>
          </div>
        </div>
      </div>
     
    </div>


<div id="tab_5" class="tab-pane {{ ($page_open == 5)?'active':'' }}">
    <div class="box-body table-responsive">
        <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
          <div class="row">  
           <div class="col-xs-12 m_top">          
            <div class="col_m2">
                <div class="col-xs-12 event_box">
                    <table width="100%">
                        <tr>
                            <td width="8%">
                                <strong>Search Events</strong>
                            </td>
                            <td width="10%" align="center">
                                <select class="form-control newdropdown" id="search_staff_id">
                                    <option value="">-- Select Staff --</option>
                                    @if(!empty($staff_details))
                                        @foreach($staff_details as $key=>$staff_row)
                                            <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>
                            <td width="3%">&nbsp;</td>
                            <td width="10%">
                                <input type="text" class="newdropdown" name="holiday_start" id="holiday_start" placeholder="Start Date">
                            </td>
                            <td width="3%" align="center">To</td>
                            <td width="10%">
                                <input type="text" class="newdropdown" name="holiday_end" id="holiday_end" placeholder="End Date">
                            </td>
                            <td width="3%">&nbsp;</td>
                            <td align="left">
                                <button type="button" class="btn btn-default" id="search_display" style="padding:3px 8px;"><span class="requ_t">Display</span></button><!--search_display-->
                            </td>
                        </tr>
                    </table>
                    <!-- <h4>Calendar Key :</h4> -->
                    <div class="clearfix"></div>
                </div>

                <div class="col-xs-10">
                    <div class="events_cont">
                        <div class="events_head">EVENTS</div>
                        <div class="search_date"></div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="staff_listing_con" id="search_data">

                        <!-- <ul>
                            <li>
                                <div class="ann_leave pull-left"></div> 
                                <div class="text">Annual leave</div><br>
                                <div class="font_size"><strong>Date: </strong>Sunday, February 13, 2016</div>
                                <div class="font_size"><strong>Times: </strong>Full Day, Half Day-PM</div>
                                <div class="font_size"><strong>Notes: </strong>Sunday, February 13, 2016</div>
                            </li>
                        </ul> -->
                    </div>
                    <div class="clearfix"></div>
                </div>
            
                <div class="col-xs-12 m_top">
                    <h5>Calender Key:</h5>
                </div>

                <div class="col-xs-12">
                    <table>
                        <tr>
                            @if(isset($holiday_types) && count($holiday_types) >0)
                                @foreach($holiday_types as $key=>$value)
                                <td>
                                    <div class="leave_box pull-left" style="background:#{{ $value['color'] or "" }};"></div> 
                                    <span class="text">{{ $value['name'] or "" }}</span>
                                </td>
                                @endforeach
                            @endif
                            <td>
                                <div class="leave_box pull-left" style="background:#228B22;"></div> 
                                <span class="text">Cpd & Courses</span>
                            </td>
                        </tr>
                    </table>
                </div>
               <div class="clearfix"></div>
            </div>
        </div>
      </div>
  </div>

</div>
</div>

<div id="tab_6" class="tab-pane {{ ($page_open == 6)?'active':'' }}">
<input type="hidden" id="hiddenclient" value="staff">
              
{{ Form::open(array('url' => '/save-holiday')) }}
<input type="hidden" id="type" name="type" value="{{ $staff_type }}">
<input type="hidden" id="page_open" name="page_open" value="{{ $page_open }}">
    <div style="padding-left: 76px;">
        <div class="clearfix"></div>
        <div style="margin-top: 20px;">
        <span style="float:left; margin-right: 58px; padding-top:9px" >
            <strong>Current Holiday Year</strong>
        </span>
        @if($start_date == 'new')
            <span style="float:left; margin-top: 9px">
                <a href="javascript:void(0)" class="open_holiday_pop" data-value="new" data-position="inner">Set Holiday year</a>
            </span>
        @else
        <span style="float:left; margin-top: 9px">
            @if(isset($holiday_details['holiday_date']) && $holiday_details['holiday_date'] < $start_date)
                <a href="/staff-holidays/{{ base64_encode($staff_type) }}/6/{{ base64_encode($roll_back) }}" class="notes_btn">Roll Back</a>
            @else
                <a href="javascript:void(0)" class="notes_btn not_roll_back">Roll Back</a>
            @endif
        </span>
        <div style="float:left; margin: 10px 15px 0 0;" class="holiday_year_span">
            <a href="javascript:void(0)" class="open_holiday_pop" data-value="{{ $start_date or '' }}" data-position="inner">{{ $start_date or 'Add..' }}</a>{{ (isset($start_date) && $start_date != '')?' - '.$end_date:'' }}
        </div>
        <!-- <div style="float:left; margin: 10px 15px 0 0;" class="holiday_year_span">
            <a href="javascript:void(0)" class="open_holiday_pop" data-value="{{ (isset($holiday_details['holiday_date']) && $holiday_details['holiday_date'] != '')?$holiday_details['holiday_date']:'' }}">{{ (isset($holiday_details['holiday_date']) && $holiday_details['holiday_date'] != '')?$holiday_details['holiday_date']:'Add..' }}</a>{{ (isset($holiday_details['holiday_end']) && $holiday_details['holiday_end'] != '')?' - '.$holiday_details['holiday_end']:'' }}
        </div> -->
        <span style="float:left; margin-top: 9px">
            <a href="javascript:void(0)" class="notes_btn current_roll_fwd" data-next_date="{{ $roll_fwd }}">Roll fwd</a> 
        </span>
        @endif
        <!-- <span style="float:left; margin-top: 9px">
            <a href="javascript:void(0)" class="notes_btn current_roll_fwd" data-next_date="{{ (isset($holiday_details['holiday_date']) && $holiday_details['holiday_date'] != '')?date('d-m-Y', strtotime('+1 year', strtotime($holiday_details['holiday_date']))):'' }}">Roll fwd</a> 
        </span> -->
        <!-- <span style="float:left">
        <select id='holiday_month' name="holiday_month" class="form-control" style="width: 100px;" >
            @if(isset($months) && count($months)>0)
              @foreach($months as $key=>$row)
                <option value="{{ $row['id'] or "" }}" {{ (isset($holiday_details['holiday_month']) && $holiday_details['holiday_month'] == $row['id'])?'selected':'' }}>{{ $row['full_name'] or "" }}</option>
              @endforeach
            @endif
        </select>  
        </span> -->
        
        <div style="padding-left: 860px;">
        <div style="float:left; padding-top:9px"><strong>Time Off Type </strong></div>
        <!-- <div style="float:left; padding-left: 22px;">
        <select class="form-control timeoff_type" name="timeoff_type_id">
            @if( isset($old_holiday_types) && count($old_holiday_types) >0 )
                @foreach($old_holiday_types as $key=>$old_row)
                <option value="{{ $old_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $old_row['type_id'])?'selected':'' }}>{{ $old_row['name'] or "" }}</option>
                @endforeach
            @endif
        
            @if( isset($new_holiday_types) && count($new_holiday_types) >0 )
                @foreach($new_holiday_types as $key=>$new_row)
                <option value="{{ $new_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $new_row['type_id'])?'selected':'' }}>{{ $new_row['name'] or "" }}</option>
                @endforeach
            @endif
        </select>
        </div> -->
        <div style="float:left;padding-left: 5px;padding-top: 10px;"><a class="open_holiday_type" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a></div>
        <div class="clearfix"></div>
    </div>        
        <!-- <div style="float: right; margin-right: 20px;">
            <button type="submit" class="btn btn-info pull-left save_t" data-client_type="org" id="savesettings" name="save">Save</button>          
            <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div> -->
        <div class="clearfix"></div>
        </div>
        <div style="margin-top: 20px; margin-bottom: 20px;">
          <span style="float:left; margin-right:98px;"><strong>Allow Rollover</strong></span>
            <span style="float:left">
                <input type="checkbox" name="allow_rollover" id="allow_rollover" value="Y" {{ (isset($holiday_details['allow_rollover']) && $holiday_details['allow_rollover'] == 'Y')?'checked':'' }} />
            </span>
            <div class="clearfix"></div>
        </div>
          
    </div>
    <div class="clearfix"></div>
        
    <!-- <div style="padding-left: 260px;padding-top: 30px;">
        <span style="float:left;"><strong>Time Off Type </strong>
            <a style="float:right;padding-left: 80px;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a>
        </span>
        <span style="float:left; padding-left: 22px;">
        <select class="form-control" id="rtype" name="timeoff_type_id">
            <option value="1" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == '1')?'selected':'' }}>Annual Leave</option>
            <option value="2" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == '2')?'selected':'' }}>Paternity/Maternity Leave </option>
            <option value="3" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == '3')?'selected':'' }}>Sickness</option>
        </select>
        </span>
        <div class="clearfix"></div>
    </div> -->
{{ Form::close() }} 
  
               
    <table class="table table-bordered table-hover dataTable" id="example6" aria-describedby="example6_info">
      @if($staff_type == "staff")
        <thead>
          <tr role="row">
            <th align="left" width="2%"><input type="checkbox" id="allCheckSelect"/></th>
            <th align="left">Staff Name</th>
            <th align="left"width="13%">Employment start date</th>
            <th align="center" width="8%">Entitlement/yr</th>
            <th align="center" width="16%">Days Taken</th><!-- pop --> 
            
            <th width="21%" colspan="3" style="padding:0;">
              <table width="100%">
               <tr style="border-bottom:1px solid #ccc;">
                 <td colspan="3" align="center">Holidays Balance</td>  

               </tr>  
               <tr>
                 <td align="center" width="30%" style="border-right:1px solid #ccc;" >Current Yr</td>  
                 <td align="center" width="40%" style="border-right:1px solid #ccc;">From Last Yr</td> 
                 <td align="center" width="30%">Total</td>   

               </tr>   

              </table>  
               
            </th>
            <!-- <th align="center" width="14%">Current Yr.</th>
            <th align="center" width="13%">From Last Yr</th>  
            <th align="center" width="9%">Total</th> -->

            <th align="center" width="4%">Notes</th>
            <th align="center" width="4%">Action</th>
          </tr>
        </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($settings) && count($settings) >0)
          @foreach($settings as $key=>$staff_row)
          <tr class="holi_list_{{ $staff_row['user_id'] }}">
            <input type="hidden" id="notes_{{ $staff_row['user_id'] }}" value="{{ (isset($staff_row['staff_holiday']['notes']))?$staff_row['staff_holiday']['notes']:'' }}">
            <td align="left" class="sorting_1"><input type="checkbox" /></td>
            <td align="center"><a href="javascript:void(0)">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</a></td>

            <td align="center" id="start_dt_{{ $staff_row['user_id']}}">{{ (isset($staff_row['step_data']['start_date']))?$staff_row['step_data']['start_date']:'' }}</td>

            <td align="center"><span id="ent_days_{{ $staff_row['user_id'] }}">{{ (isset($staff_row['staff_holiday']['ent_days']))?$staff_row['staff_holiday']['ent_days']:'0' }}</span></td> <!-- ent year -->

            <td align="center"><span id="days_taken_{{ $staff_row['user_id'] }}">{{ (isset($staff_row['current_days_taken']))?$staff_row['current_days_taken']:'0' }}</span></td> <!-- days taken -->

            <td align="center" width="6.4%"><span id="current_{{ $staff_row['user_id'] }}">{{ (isset($staff_row['remaining']))?$staff_row['remaining']:'' }}</span></td>

            <td align="center" width="8.4%"><span id="last_remain{{ $staff_row['user_id']}}">{{ (isset($staff_row['last_year_leave']))?$staff_row['last_year_leave']:'' }}</span></td>

            <td align="center"><span id="remaining{{ $staff_row['user_id']}}">{{ (isset($staff_row['total_leave']))?$staff_row['total_leave']:'' }}</span></td>
            <!-- total -->

            <td align="center">
                <a href="javascript:void(0)" data-staff_id="{{ $staff_row['user_id'] }}" class="notes_btn open_holiday_notes">Notes</a>   
            </td>
            <!-- <td align="center" style="padding: 9px 0; width: 10%;" class=" ">
                <a href="javascript:void(0)" onclick="return fetchnotesmodal('Notes')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="btn btn-default note_t">Notes</span></a>   
            </td> -->
            <td align="center"><a href="javascript:void(0)" data-staff_id="{{ $staff_row['user_id'] }}" class="notes_btn open_edit_holiday">Edit</a></td>
          </tr>
          @endforeach
        @endif
      @endif                
    </table>
    </div>
                <!-- /.tab-pane -->
                
              </div>
            </div>
          </div>
        
      </div>
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="staffcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      {{ Form::open(array('url' => '/staffholidaysrequest')) }}
     <!--  <form action="#" method="post"> -->
       <input type="hidden" name="stafftype" value="{{$staff_type}}" />
       <input type="hidden" name="start_date" value="{{$start_date}}" />
        <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <table width="100%" border="0" class="staff_holidays">
            <tr>
              <td>
               @if($staff_type != "staff")
               @if(!empty($staff_details))
              <input type="hidden" name="staff" value="0"/>
              @endif
              @endif
              
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="20%"><strong>HOLIDAY/TIME OFF REQUEST</strong></td>
                    
                    <td width="14%">
                      @if($staff_type != "staff")
                      <strong>Total Days Requested</strong> <input type="text" style="width:60px;">
                      @endif
                    </td>
                    <td width="12%">
                        @if($staff_type != "staff")
                        <strong>Days Remaining</strong> <input type="text" style="width:60px;">
                        @else
                        <strong>Staff Name </strong>
                    </td>
                    <td width="15%"><select class="form-control" name="staff" id="staff_id">

                    @if(!empty($staff_details))
                     @foreach($staff_details as $key=>$staff_row)
                        <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                     @endforeach
                    @endif

                    </select>
                    @endif
                    </td>
                    
                    
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td valign="top">
              <table width="100%" class="table table-bordered" id="sBoxTable" >
                  <tbody>
                   <tr>
                   
                     <td align="center">&nbsp;</td>
                      <td align="center"><strong>Date</strong></td>
                      <td align="center"><strong>Duration</strong></td>
                      <td align="center"><strong>Request type 
                     @if($staff_type == "staff")   
                      <a class="open_holiday_type" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a>
                      @endif
                      </strong></td>
                      <td align="center"><strong>Notes</strong></td>
                    </tr>
                   
                    <tr id="staffholi" class="makeCloneClass">
                    
                        <td><a href="#"><img src="/img/cross_icon.png" id="sdate_picker"  class="sDeleteBoxRow" /></a></td>
                      
                     <td> <input type="text" class="form-control dpick" id="stafdpick" name="date[]" style="width:86%; height: 33px;">
                      </td>
                      <td align="center">
                             
                                                          
                              <select class="form-control" id="due" name="duration[]">
                                <option value="Full Day">Full Day</option>
                                <option value="Half Day-AM">AM-Half Day </option>
                                <option value="Half Day-PM">PM-Half Day </option>
                                
                              </select>
                            </td>
                      <td align="center">
                      <select class="form-control" id="rtype" name="requesttype[]">
                        @if( isset($old_holiday_types) && count($old_holiday_types) >0 )
                            @foreach($old_holiday_types as $key=>$old_row)
                            <option value="{{ $old_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $old_row['type_id'])?'selected':'' }}>{{ $old_row['name'] or "" }}</option>
                            @endforeach
                        @endif

                        @if( isset($new_holiday_types) && count($new_holiday_types) >0 )
                            @foreach($new_holiday_types as $key=>$new_row)
                            <option value="{{ $new_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $new_row['type_id'])?'selected':'' }}>{{ $new_row['name'] or "" }}</option>
                            @endforeach
                        @endif
                       
                        </select></td>
                      <td align="center" style="padding: 9px 0; width: 14%;" ><button class="btn btn-default note_t" id="snotes" data-toggle="modal" data-target="#addfontnotes-modal" id="notesaddfont">Notes</button>
                      
                      
                      <input type="hidden" name="notes[]" id="notesstaff" value="">
                      </td>
                    </tr>
                    
                 
                     
                  </tbody>
                </table>
              </td>
            </tr>
          </table>
          <div class="save_btncon">
         <div class="left_side"><button class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new</p></button>
         
         
         </div>
         <div class="right_side"> <button class="btn btn-success">Submit for Approval</button></div>
         <div class="clearfix"></div>
         </div>
         
        </div>
        {{ Form::close() }}
   <!--   </form> -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="staffeditcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
  
 @if($page_open == 1)  
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      {{ Form::open(array('url' => '/editstaffholidaysrequest')) }}
     <!--  <form action="#" method="post"> -->
       <input type="hidden" name="stafftype" value="{{$staff_type}}" />
       <input type="hidden" name="start_date" value="{{$start_date}}" />
       <input type="hidden" name="editid" id="editid" value="" />
        <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <table width="100%" border="0" class="staff_holidays">
            <tr>
              <td>
               @if($staff_type != "staff")
               @if(!empty($staff_details))
              <input type="hidden" name="staff" value="0"/>
              @endif
              @endif
              
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="20%"><strong>HOLIDAY/TIME OFF REQUEST</strong></td>
                    
                    <td width="14%">
                      @if($staff_type != "staff")
                      <strong>Total Days Requested</strong> <input type="text" style="width:60px;">
                      @endif
                    </td>
                    <td width="12%">
                      @if($staff_type != "staff")
                      <strong>Days Remaining</strong> <input type="text" style="width:60px;">
                      @else
                      <strong>Staff Name </strong></td>
                      <td width="15%"><select class="form-control " name="staff" id="editstaff_id">
                      
                        @if(!empty($staff_details))
                         @foreach($staff_details as $key=>$staff_row)
                            <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                         @endforeach
                        @endif

                      </select>
                      @endif
                    </td>
                    
                    
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td valign="top">
              <table width="100%" class="table table-bordered" id="eBoxTable" >
                  <tbody>
                   <tr>
                   
                     
                      <td align="center"><strong>Date</strong></td>
                      <td align="center"><strong>Duration</strong></td>
                      <td align="center"><strong>Request type</strong></td>
                      <td align="center"><strong>Notes</strong></td>
                    </tr>
                   
                    <tr id="editstaffholi" class="makeCloneClass">
                    
                        
                      
                     <td> <input type="text" class="dpick" id="edittafdpick" name="date" style="width:86%; height: 33px;">
                      </td>
                      <td align="center">
                             
                                                          
                              <select class="form-control" id="editdue" name="duration">
                                <option value="Full Day">Full Day</option>
                                <option value="AM-Half Day">AM-Half Day </option>
                                <option value="PM-Half Day">PM-Half Day </option>
                                
                              </select>
                            </td>
                      <td align="center">
                      <select class="form-control" id="edittype" name="requesttype">
                        @if( isset($old_holiday_types) && count($old_holiday_types) >0 )
                            @foreach($old_holiday_types as $key=>$old_row)
                            <option value="{{ $old_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $old_row['type_id'])?'selected':'' }}>{{ $old_row['name'] or "" }}</option>
                            @endforeach
                        @endif

                        @if( isset($new_holiday_types) && count($new_holiday_types) >0 )
                            @foreach($new_holiday_types as $key=>$new_row)
                            <option value="{{ $new_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $new_row['type_id'])?'selected':'' }}>{{ $new_row['name'] or "" }}</option>
                            @endforeach
                        @endif
                       
                        </select></td>
                      <td align="center" style="padding: 9px 0; width: 14%;" ><button class="btn btn-default note_t" id="editnotes" data-toggle="modal" data-target="#editfontnotes-modal" id="notesaddfont">Notes</button>
                      
                      
                      <input type="hidden" name="notes" id="editnotesstaff" value="">
                      </td>
                    </tr>
                    
                 
                     
                  </tbody>
                </table>
              </td>
            </tr>
          </table>
          <div class="save_btncon">
         <div class="left_side">
         
         
         </div>
         <div class="right_side"> <button id="submitforapproval" class="btn btn-success">Submit for Approval</button></div>
         <div class="clearfix"></div>
         </div>
         
        </div>
        {{ Form::close() }}
   <!--   </form> -->
    </div>
    @endif
    
     @if($page_open == 2 || $page_open == 3 || $page_open == 4) 
    <div class="modal-content">
    
       <input type="hidden" name="stafftype" value="{{$staff_type}}" />
       <input type="hidden" name="editid" id="editid" value="" />
        <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <table width="100%" border="0" class="staff_holidays">
            <tr>
              <td>
               @if($staff_type != "staff")
               @if(!empty($staff_details))
              <input type="hidden" name="staff" value="0"/>
              @endif
              @endif
              
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="20%"><strong>HOLIDAY/TIME OFF REQUEST</strong></td>
                    
                    <td width="14%">
                      @if($staff_type != "staff")
                      <strong>Total Days Requested</strong> <input type="text" style="width:60px;">
                      @endif
                    </td>
                    <td width="12%">
                      @if($staff_type != "staff")
                      <strong>Days Remaining</strong> <input type="text" style="width:60px;">
                      @else
                      <strong>Staff Name </strong></td>
                      <td width="15%"><select class="form-control dropdowndisable" name="staff" id="editstaff_id">
                      
                        @if(!empty($staff_details))
                         @foreach($staff_details as $key=>$staff_row)
                            <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                         @endforeach
                        @endif

                      </select>
                      @endif
                    </td>
                    
                    
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td valign="top">
              <table width="100%" class="table table-bordered" id="eBoxTable" >
                  <tbody>
                   <tr>
                   
                     
                      <td align="center"><strong>Date</strong></td>
                      <td align="center"><strong>Duration</strong></td>
                      <td align="center"><strong>Request type</strong></td>
                      <td align="center"><strong>Notes</strong></td>
                    </tr>
                   
                    <tr id="editstaffholi" class="makeCloneClass">
                    
                        
                      
                     <td> <input type="text" class="dropdowndisable" id="edittafdpick" name="date" style="width:86%; height: 33px;" readonly>
                      </td>
                      <td align="center">
                             
                                                          
                              <select class="form-control dropdowndisable" id="editdue" name="duration" >
                                <option value="Full Day">Full Day</option>
                                <option value="AM-Half Day">AM-Half Day </option>
                                <option value="PM-Half Day">PM-Half Day </option>
                                
                              </select>
                            </td>
                      <td align="center">
                      <select class="form-control dropdowndisable" id="edittype" name="requesttype">
                        @if( isset($old_holiday_types) && count($old_holiday_types) >0 )
                            @foreach($old_holiday_types as $key=>$old_row)
                            <option value="{{ $old_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $old_row['type_id'])?'selected':'' }}>{{ $old_row['name'] or "" }}</option>
                            @endforeach
                        @endif

                        @if( isset($new_holiday_types) && count($new_holiday_types) >0 )
                            @foreach($new_holiday_types as $key=>$new_row)
                            <option value="{{ $new_row['type_id'] or "" }}" {{ (isset($holiday_details['timeoff_type_id']) && $holiday_details['timeoff_type_id'] == $new_row['type_id'])?'selected':'' }}>{{ $new_row['name'] or "" }}</option>
                            @endforeach
                        @endif
                       
                        </select></td>
                      <td align="center" style="padding: 9px 0; width: 14%;" ><button class="btn btn-default note_t" id="editnotes" data-toggle="modal" data-target="#editfontnotes-modal" id="notesaddfont">Notes</button>
                      
                      
                      <input type="hidden" name="notes" id="editnotesstaff" value="">
                      </td>
                    </tr>
                    
                 
                     
                  </tbody>
                </table>
              </td>
            </tr>
          </table>
         
         
        </div>
  
    </div>
    @endif
    
    
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- addfontnotes-modal-->
<div>
<div class="modal fade" id="editfontnotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    
    
        
    <div class="modal-content">
     
      
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
     
      <div style="width:100%;">
             <label for="f_name" style="font-size: 18px;">Notes</label>
             
              @if($page_open == 1 ) 
          <textarea rows="4" cols="60" style="width: 100%;" name="notes1[]" id="editfontnotesss" value="" ></textarea>
          <div class="clr"></div> 
        @endif
        
         @if($page_open == 2 || $page_open == 3 || $page_open == 4) 
        
        <textarea rows="4" cols="60" style="width: 100%;"  name="notes1[]" id="editfontnotesss" value="" class="dropdowndisable" readonly /></textarea>
          <div class="clr"></div> 
        @endif
        @if($page_open == 1 ) 
        <button class="btn btn-primary" onclick="return staffnotes()" id="editsave_staffnotes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%; ">Save</button>
        
        @endif
        
        
        
        
        
       <!--   <button class="btn btn-primary"   style="padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%;">Save</button>  -->
               
         </div>
         <div class="clr"></div> 
        </div>
        
       
      <!--</form>-->
    </div>
    
        
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</div>
<!-- addfontnotes-modal -->




<!-- addfontnotes-modal-->
<div>
<div class="modal fade" id="addfontnotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    
    <div class="modal-content">
     
      
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
     
      <div style="width:100%;">
             <label for="f_name" style="font-size: 18px;">Notes</label>
             
          <textarea rows="4" cols="60" style="width: 100%;"  name="notes1[]" id="addfontnotesss" value="" ></textarea>
         
         
     <!--     <button class="btn btn-primary" onclick="return fetchnotes()" id="fetchsave_notes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%; ">Save</button> -->  
          <div class="clr"></div> 
        
        
        
        <button class="btn btn-primary" onclick="return staffnotes()" id="save_staffnotes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%; ">Save</button>
        
       <!--   <button class="btn btn-primary"   style="padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%;">Save</button>  -->
               
         </div>
         <div class="clr"></div> 
        </div>
        
       
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</div>
<!-- addfontnotes-modal -->



<!-- Settings-modal-->
<div class="modal fade" id="staffsettings-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title">Holiday Settings</h4>
        <div class="clearfix"></div>
      </div>
      <input type="hidden" id="hiddenclient" value="staff">
              
   <form>
   
    <div class="modal-body">
     
      <div>
      
      <div style="margin-top: 20px;">
      <span style="float:left; margin-right: 170px;" > <strong>Allow rollover for all Staff</strong>
</span>
              <span style="float:left">
              <input type="checkbox" />
              </span>
              <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
      <div style="margin-top: 20px;">
     <span style="float:left; margin-right: 58px;" ><strong> Holiday  year for Staff </strong>
              </span>
      <span style="float:left; margin-right: 10px;" ><select class="form-control" id="acc_ref_day" name="acc_ref_day" >
                @for($i = 1; $i<=31;$i++)
                <option value="{{ $i }}">{{ $i }}</option>
                @endfor
              </select> 
              </span>
              <span style="float:left">
                <select id='' class="form-control" style="width: 100px;" >
                    <option value='1'>Janaury</option>
                    <option value='2'>February</option>
                    <option value='3'>March</option>
                    <option value='4'>April</option>
                    <option value='5'>May</option>
                    <option value='6'>June</option>
                    <option value='7'>July</option>
                    <option value='8'>August</option>
                    <option value='9'>September</option>
                    <option value='10'>October</option>
                    <option value='11'>November</option>
                    <option value='12'>December</option>
                </select>  
              </span>
              <div class="clearfix"></div>
      </div>
      </div>
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="savesettings" name="save">Save</button>          
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    </form> 
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div>
<div class="modal fade" id="fetchcomposenotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
      <div style="width:100%;">
             <label for="f_name" style="font-size: 18px;">Notes</label>
          <textarea rows="4" cols="65"  name="notes1[]" id="fetchnotess" value="" readonly ></textarea>
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
</div>

<!-- Holiday Notes -->
<div class="modal fade" id="holiday-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">

        <div class="modal-body">
            <div class="show_loader"><!-- Loder Show --></div>
            <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
            <div style="width:100%;">
                <input type="hidden" id="note_staff_id">
                <label for="f_name" style="font-size: 18px;">Notes</label>
                <textarea rows="4" cols="60" style="width: 100%;"  name="holiday_notes" id="holiday_notes"></textarea>
                <button class="btn btn-info" id="save_holiday_notes" style="margin-top: 15px; float: right;">Save</button>
            </div>
         <div class="clr"></div> 
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- Holiday Details -->
<div class="modal fade" id="holiday_details-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Edit Holiday</h4>
        </div>
        <div class="modal-body">
            <div class="show_loader"><!-- Loder Show --></div>
            <div class="form-group">
              <label for="exampleInputPassword1">Employment Start Date</label>
              <input type="text" class="form-control" id="emp_start_date" />
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Holiday Entitlement/Yr.</label>
              <input type="text" class="form-control" id="ent_per_year" />
            </div>
            <!-- <div class="form-group">
              <label for="exampleInputPassword1">Days Taken</label>
              <input type="text" class="form-control" id="pop_days_taken" />
              <div class="clearfix"></div>
            </div> -->
        </div>
        <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
            <div class="email_btns">
              <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-info pull-left save_t2 save_holiday_details">Save</button>
            </div>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- Holiday Details -->
<div class="modal fade" id="holiday_year-modal" tabindex="1"role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:400px;">
    {{ Form::open(array('url'=>'/sh/save-confirm-rollover', 'method'=>'post')) }}
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">ADD/EDIT START DATE</h4>
        </div>
        <div class="modal-body">
            <input type="hidden" id="field_name" value="holiday_date" />
            <input type="hidden" name="action" value="edit_date" />
            <input type="hidden" name="staff_type" value="{{ $staff_type }}" />
            <input type="hidden" name="start_date" value="{{ $start_date }}" />
            <input type="hidden" name="position" id="position" value="" />
            <div class="show_loader"><!-- Loder Show --></div>
            <div class="form-group">
              <label for="exampleInputPassword1">Enter Opening Holiday Year Start Date</label>
              <input type="text" class="form-control" id="pop_holiday_date" name="pop_holiday_date" style="width:65%" />
            </div>

            <div class="form-group">
              <div style="font-weight: bold">Enter total days taken by each employee as off the switch over date</div>
            </div>

            <div class="form-group">
              <table class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                      <th><strong>Staff Name</strong></th>
                      <th width="30%"><strong>Days Taken</strong></th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($settings) && count($settings) >0)
                    @foreach($settings as $key=>$staff_row)    
                    <tr>
                      <td>{{$staff_row['fname'] or ""}} {{$staff_row['lname'] or ""}}</td>
                      <td><input type="text" class="form-control days_taken_{{$staff_row['user_id'] or ''}}" name="days_taken_{{$staff_row['user_id'] or ""}}" /></td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
              </table>
            </div>

        </div>
        <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
            <div class="email_btns">
              <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button><!--save_holiday-->
              <button type="submit" class="btn btn-info pull-left save_t2">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
  </div>
</div>

<!-- Holiday Details -->
<div class="modal fade" id="confirm_balance_roll-modal" tabindex="1"role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:400px;">
    {{ Form::open(array('url'=>'/sh/save-confirm-rollover', 'method'=>'post')) }}
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">CONFIRM BALANCES TO ROLLOVER</h4>
        </div>
        <div class="modal-body">
            <input type="hidden" name="action" value="roll_fwd" />
            <input type="hidden" name="staff_type" value="{{ $staff_type }}" />
            <input type="hidden" name="start_date" value="{{ $start_date }}" />
            <div class="show_loader"><!-- Loder Show --></div>
            <div class="form-group">
              <table class="table table-bordered table-hover dataTable">
                <thead>
                    <tr>
                      <th><strong>Staff Name</strong></th>
                      <th width="30%"><strong>Days Taken</strong></th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($settings) && count($settings) >0)
                    @foreach($settings as $key=>$staff_row)    
                    <tr>
                      <td>{{$staff_row['fname'] or ""}} {{$staff_row['lname'] or ""}}</td>
                      <td><input type="text" class="form-control days_taken_{{$staff_row['user_id'] or ''}}" name="days_taken_{{$staff_row['user_id'] or ""}}" /></td>
                    </tr>
                    @endforeach
                @endif
                </tbody>
              </table>
            </div>

        </div>
        <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
            <div class="email_btns">
              <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-info pull-left save_t2">Save</button>
            </div>
        </div>
    </div>
    {{ Form::close() }}
  </div>
</div>

<div class="modal fade" id="open_holiday_type-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:400px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD TO LIST</h4>
        <div class="clearfix"></div>
      </div>
              
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="pop_holiday_type" class="txtlft form-control">
        <button type="button" class="btn btn-info pull-left save_t2 save_type" id="save_type" name="save">Add</button>
        <div class="clearfix"></div>
      </div>

      <div class="form-group">
        <label for="name">Color</label>
        <select id="pop_color" name="pop_color" class="form-control">
            <option value="">-- Select Color --</option>
            @if( isset($colors) && count($colors) >0 )
                @foreach($colors as $key=>$color_row)
                    <option value="{{ $color_row['color_code'] or "" }}">{{ $color_row['color_name'] or "" }}</option>
                @endforeach
            @endif
            
        </select>
      </div>

      <!-- <div id="colorSelector">
        <div style="background-color: #00ff00"></div>
      </div> -->
      
      <div id="append_type">
      @if( isset($old_holiday_types) && count($old_holiday_types) >0 )
        @foreach($old_holiday_types as $key=>$old_row)
           <div class="col-md-9"> <label style="margin-top: 0px;">{{ $old_row['name'] or "" }}</label></div>
            <div class="pop_right" style="background-color:#{{ $old_row['color'] or "" }};"></div>
            <div class="clearfix"></div>
        @endforeach
      @endif

      @if( isset($new_holiday_types) && count($new_holiday_types) >0 )
        @foreach($new_holiday_types as $key=>$new_row)
        <div id="hide_type_div_{{$new_row['type_id']}}">
         <div style="font-weight: bold; float:left;line-height: 25px;"><a href="javascript:void(0)" title="Delete Field ?" class="delete_holiday_type" data-field_id="{{ $new_row['type_id'] }}"><img src="/img/cross.png" width="12"></a>
          {{ $new_row['name'] or "" }}</div>
          <div class="pop_right" style="background-color:#{{ $new_row['color'] or "" }};"></div>
            <div class="clearfix"></div>
        </div>
        @endforeach
      @endif
      </div>
     
      <!-- <div class="modal-footer1 clearfix">
        <div class="email_btns">
            <button type="button" class="btn btn-danger pull-left save_t"  data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info pull-left save_t2 save_type" id="save_type" name="save">Save</button>
        </div>
      </div> -->
    </div>
   </div>
  </div>
</div>

@stop
<!-- staff-->