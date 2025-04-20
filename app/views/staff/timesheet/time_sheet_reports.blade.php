@extends('layouts.layout')

@section('mycssfile')
    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="{{ URL :: asset('js/org_clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/relationship.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/timesheet.js') }}" type="text/javascript"></script>
<!-- page script -->
<script type="text/javascript">
$(function() {
    var page_open = '{{ $page_open }}';
    if(page_open == 1 || page_open == 2){
        $('#example1').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false,
          "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
          "iDisplayLength": 25,

          "aoColumns":[
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
          ],
          "aaSorting": [[2, 'asc']]
        });
    }else{
        $('#example1').dataTable({
          "bPaginate": true,
          "bLengthChange": true,
          "bFilter": true,
          "bSort": true,
          "bInfo": true,
          "bAutoWidth": false,
          "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
          "iDisplayLength": 25,

          "aoColumns":[
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
          ],
          "aaSorting": [[2, 'asc']]
        });
    }

});

$(function() {
    /*$(".dpick").datepicker({dateFormat: 'dd-mm-yy'});
    $("#eddpick").datepicker({dateFormat: 'dd-mm-yy'});*/
});	    



function editnotesmodal(){
    $("#compose-edit-modal").modal("hide");
}

function editnotes(){
    var editnotesval= $("#notes").val(); 
    $("#notesedit").val(editnotesval);

    $("#composeeditnotes-modal").modal("hide");
    $("#compose-edit-modal").modal("show");
}




function openeditctrModal(ctr_id) {
    $.ajax({
    	type: "POST",
        //dataType: "html",
        url: '/timesheet/fetcheditclient-time-sheet',
        data: {

			'ctr_id': ctr_id

		},

		success: function(resp) {
		  
        
           var clientfromdate = resp.fromdate.split('-');
	       var date_from = clientfromdate[2] + '-' + clientfromdate[1] + '-' + clientfromdate[0];
           
           var clienttodate = resp.todate.split('-');
           var date_to = clienttodate[2] + '-' + clienttodate[1] + '-' + clienttodate[0];
               
          
		  $("#composeeditclienttr-modal").modal("show");
          
          
            	$('#ctredit_client').val(resp.ctr_client);
                $('#ctredit_serv').val(resp.ctr_serv);
                $('#editfromdpick').val(date_from);
                
                $('#edittodpick').val(date_to);
                $('#editctrid').val(resp.ctr_id);
                
                
                
           // alert(resp);
           
			console.log(resp);

				}

	});
    
}

function openstaffModal(str_id) {
    $.ajax({
    	type: "POST",
        //dataType: "html",/timesheet/fetcheditstaff-time-sheet
        url: '/timesheet/fetcheditstaff-time-sheet',
        data: { 'str_id': str_id },

		success: function(resp) {
		    var stafffromdate = resp.strfromdate.split('-');
	        var strdate_from = stafffromdate[2] + '-' + stafffromdate[1] + '-' + stafffromdate[0];
           
            var stafftodate = resp.strtodate.split('-');
            var strdate_to = stafftodate[2] + '-' + stafftodate[1] + '-' + stafftodate[0];
            $("#composeditestr-modal").modal("show");
            $('#editstr_client').val(resp.str_client);
            $('#editstr_staff').val(resp.str_staff);
            $('#editstrfromdate').val(strdate_from);
            $('#editstrtodate').val(strdate_to);
            $('#editstrid').val(resp.str_id);
        }

	});
}

function lmtdelfun($del_id)
{
    var delid=$del_id;
    var page_open   = $('#page_open').val();
    var encode_type = $('#encode_type').val();
    
    if (confirm("Do you want to delete ?")) {
        $.ajax({
        	type: "POST",
            url: '/timesheet/delete-time-sheet',
            data: { 'delid': delid },
            success: function(resp) {
    		    window.location='/time-sheet-reports/'+page_open+'/'+encode_type;
    		}
        });
    }
}

function clientdisplay(){
    var ctr_client  = $("#ctr_client").val();
    var ctr_serv    = $("#ctr_serv").val();
    var fromdpick2  = $("#fromdpick2").val();
    var todpick     = $("#todpick").val();
    
    if(fromdpick2!="" && todpick!="" && ctr_client!="" ){
        $.ajax({
        	type: "POST",
            //dataType: "html",/timesheet/fetcheditstaff-time-sheet
            url: '/timesheet/insertclient-time-sheet',
            data: {'ctr_client':ctr_client, 'ctr_serv':ctr_serv, 'fromdpick2':fromdpick2, 'todpick':todpick},
            success: function(resp) {
    		    if(resp){
                    $("#dropctr").html(resp);
                }
                else{
                    $("#dropctrerror").html('<span style="color:red">No Records Found</span>');
                }

    		}
        });  
    }else{
        
        $("#dropctrerror").html('<span style="color:red">Please Select Fields</span>');
    }
}

function staffdisplay(){
    var str_staff   = $("#str_staff").val();
    var str_client  = $("#str_client").val();
    var strdpick2   = $("#strdpick2").val();
    var dpickclient = $("#dpickclient").val();
    
    if(strdpick2!="" && dpickclient!="" && str_client!="" ){
         $.ajax({
        	type: "POST",
            //dataType: "html",/timesheet/fetcheditstaff-time-sheet
            url: '/timesheet/insertstaff-time-sheet',
            data: {'str_staff':str_staff,'str_client':str_client,'strdpick2':strdpick2,'dpickclient':dpickclient},
            success: function(resp) {
    		    if(resp){
                    $("#dropstr").html(resp);
                }else{
                    $("#dropstrerror").html('<span style="color:red">No Records Found</span>');
                }
            }
        });
    }else{
        $("#dropstrerror").html('<span style="color:red">Please Select Fields</span>');
    }
}

$("#clienttimereset").click(function(){
    $("#ctr_client").val("");
    $("#ctr_serv").val("");
    $("#fromdpick2").val("");
    $("#todpick").val("");
    $("#dropctr").html("");
    $("#dropctrerror").html("");
 
});

$("#stafftimereset").click(function(){
    $("#str_staff").val("");
    $("#str_client").val("");
    $("#strdpick2").val("");
    $("#dpickclient").val("");
    $("#dropstr").html("");
    $("#dropstrerror").html("");
 
});


function fetchnotesmodal(value){
    var notesvalue=value;
    $("#fetchnotess").val(notesvalue);
    $("#fetchcomposenotes-modal").modal("show");
}


</script>
<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<script src="/js/upload_expense.js" type="text/javascript"></script>
@stop
 
@section('content')
<input type="hidden" id="page_open" value="{{ $page_open }}">
<input type="hidden" id="encode_type" value="{{ $encode_type }}">

<div class="wrapper row-offcanvas row-offcanvas-left">
    <aside class="left-side sidebar-offcanvas {{ $left_class }}">
        <section class="sidebar">
            @include('layouts/inner_leftside')
        </section>
    </aside>

    <aside class="right-side {{ $right_class }}">
        <!-- Content Header (Page header) -->
        @include('layouts.below_header')
    <!-- Main content -->
<section class="content">
  <div class="practice_mid">
      <div class="top_buttons">
        <div class="top_bts">
          <ul>
            <li>
              <a href="/timesheetpdf" class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</a>
            </li>
            <li>
              <a href="/timesheetexcel" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</a>
            </li>

            <li style="margin-left: 120px"><a class="btn btn-default" href='/timesheet/client-timereport' target="_blank"><span class="decline_t">Client Time Report</a></span></li>
            <li><a class="btn btn-default" href='/timesheet/staff-timereport' target="_blank"><span class="decline_t">Staff Time Report</span></a></li>
            <li><a class="btn btn-default" href="/timesheet/view-timesheet-report/{{$encode_type}}/{{ base64_encode('expense') }}" target="_blank"><span class="decline_t">Client Expenses Report</span></a></li>

        @if($staff_type == 'staff')
            <li><a class="btn btn-default" href='#' target="_blank"><span class="decline_t">Staff Load Report</span></a></li>
        @endif

            <li style="margin-left: 100px"><a href="javascript:void(0)" data-entry_type="T" class="btn btn-default newPopupOpen"><span class="requ_t">New Time Sheet</span></a></li>
        @if($staff_type == 'staff')
            <li><a href="javascript:void(0)" data-entry_type="E" class="btn btn-default newPopupOpen"><span class="requ_t">New Expense Entry</span></a></li>
        @else
            <li><a href="javascript:void(0)" data-entry_type="E" class="btn btn-default"><span class="requ_t">New Expense Entry</span></a></li>
        @endif
          </ul>
        </div>
        <div class="clearfix"></div>
      </div>

  <div class="tabarea">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs nav-tabsbg">
        <li class="{{ ($page_open == 1)?'active':'' }}"><a href="{{ $goto_url }}/1/{{ $encode_type }}">RECENT TIME SHEET</a></li>
        <li class="{{ ($page_open == 2)?'active':'' }}"><a href="{{ $goto_url }}/2/{{ $encode_type }}">TIME SHEET LOG</a></li>
        <li class="{{ ($page_open == 3)?'active':'' }}"><a href="{{ $goto_url }}/3/{{ $encode_type }}">CLIENT EXPENSE RECHARGE</a></li>
        <li class="{{ ($page_open == 4)?'active':'' }}"><a href="{{ $goto_url }}/4/{{ $encode_type }}">EXPENSES LOG</a></li>
      </ul>
              
<div class="tab-content">
    <div id="tab_1" class="tab-pane active">      
      <table class="table table-bordered table-hover dataTable" id="example1" width="100%">
        <thead>
          <tr role="row">
            <th width="6%"><strong>Date</strong></th>
            <th><strong>Staff Name</strong></th>
            <th><strong>Client Name</strong></th>
            <th><strong>{{ ($page_open == 1 || $page_open == 2)?'Service':'Expense Type' }}</strong></th>
            <th style="text-align: center;" width="6%"><strong>{{ ($page_open == 1 || $page_open == 2)?'Hrs':'Amount(£)' }}</strong></th>
            <th style="text-align: center;" width="6%"><strong>Notes</strong></th>
            @if($page_open == 3 || $page_open == 4)
                <th style="text-align: center;" width="10%"><strong>Attachment</strong></th>
            @endif
            <th style="text-align: center;" width="5%"><strong>Action</strong></th>
          </tr>
        </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
		@if(!empty($report_details))
	      @foreach($report_details as $key=>$report_row)
            <tr>
				<td>{{ $report_row['created_date'] }}</td>
				<td>{{ $report_row['staff_name'] }}</td>
				<td  align="left">{{ $report_row['client_name'] }}</td>
				<td align="left">{{ $report_row['scheme_name'] }}</td>
				<td style="text-align: center;">{{ number_format($report_row['hrs'], 2, '.', '')  }}</td>
				<td style="text-align: center;">
                    @if(empty($report_row['notes']))
                        <a href="javascript:void(0)" onclick="return fontfetchnotesmodal('{{ $report_row['notes'] }}')" data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="notes_btn">Notes</span></a>
                    @endif
                    @if(!empty($report_row['notes']))
                        <a href="javascript:void(0)" onclick="return fontfetchnotesmodal('{{ $report_row['notes'] }}')" data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="notes_btn">Notes</span></a>
                    @endif
                </td>
                @if($page_open == 3 || $page_open == 4)
                <td style="text-align: center;">
                {{ Form::open(array('url' => '/timesheet/update-file', 'id'=>'UpdtAttch'.$report_row['timesheet_id'], 'files' => true ) ) }}
                    <input type="hidden" name="tableHidId" id="tableHidId{{ $report_row['timesheet_id'] }}" value="{{ $report_row['timesheet_id'] }}">
                    <span class="btn btn-default btn-file" style="width: 73px; height: 34px; float: left; margin-bottom: 0px;">
                        Browse <input type="file" name="attachmentTbl" class="attachTableFile" id="attachment{{ $report_row['timesheet_id'] }}" data-key="{{ $report_row['timesheet_id'] }}">
                    </span>
                {{ Form::close() }}
                    <div id="attachTable{{ $report_row['timesheet_id'] }}" class="attachTable" style="float: left; margin: 7px 0 0 5px;">
                    @if(!empty($report_row['attachment']))
                        <a href="/uploads/expense_files/{{ $report_row['attachment'] }}" download><img src="/img/pdficon.png" height="20"></a>
                        <a href="javascript:void(0)" class="deleteAttachment" data-timesheet_id="{{ $report_row['timesheet_id'] }}" ><img src="/img/cross.png" width="13" ></a>
                    @endif
                    </div>
                    </td>
                @endif
				<td style="text-align: center;">
                    <a href="javascript:void(0)" data-toggle="modal" data-template_id="{{ $report_row['timesheet_id'] }}" onclick="openModal('{{ $report_row['timesheet_id'] }}', '{{ $report_row['entry_type'] }}')"><img src="/img/edit_icon.png" width="15"></a>
                    <a href="#" onClick="return lmtdelfun('{{ $report_row['timesheet_id'] }}')" ><img src="/img/cross.png" width="15" ></a>
                </td>
				</tr>
			  @endforeach
			@endif
        </tbody>
      </table>
    </div>
                
                <!-- /.tab-pane -->
    <div id="tab_2" class="tab-pane">
      <div class="box-body table-responsive">
        <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
          <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6"></div>
          </div>
          <div class="row">
            <div class="col-xs-12">
			    <table class="table table-bordered table-hover dataTable" id="example2">

                <thead>
                  <tr role="row">
                  <!-- <th align="center"><input type="checkbox" id="allCheckSelect"/></th> -->
                    <th><strong>Date</strong></th>
                    <th><strong>Staff Name</strong></th>
                    <th><strong>Client Name</strong></th>
                    <th><strong>Service</strong></th>
                    <th style="text-align: center;"><strong>Hrs</strong></th>
                    <th style="text-align: center;"><strong>Notes</strong></th>
                    <th style="text-align: center;"><strong>Action</strong></th>
                  </tr>
                </thead>

                <tbody role="alert" aria-live="polite" aria-relevant="all">
				
				@if(!empty($time_sheet_report))
				  @foreach($time_sheet_report as $key=>$staff_row)
                    @if(isset($staff_row['entry_type']) && $staff_row['entry_type'] == 'T')
					 <tr>
					<!--	<td align="center"><input type="checkbox" /></td> -->
						<td>{{ $staff_row['created_date'] }}</td>
						<td>{{ $staff_row['staff_detail']['fname'] }} {{ $staff_row['staff_detail']['lname'] }}</td>
						<td>{{ $staff_row['client_detail']['field_value'] }}</td>
						<td>{{ $staff_row['old_services']['service_name'] }}</td>
						<td style="text-align: center;">{{ number_format((float)$staff_row['hrs'], 2, '.', '')}}</td>
					
                    
                    	<td style="text-align: center;">
                        @if(empty($staff_row['notes']))
                         <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff_row['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span class="notes_btn">Notes</span>
                        </a>
                        @endif
                        @if(!empty($staff_row['notes']))
                        
                        <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff_row['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="notes_btn">Notes</span>
                        </a>
                       
                       @endif
                        
                        </td>
						<td style="text-align: center;"><a href="#" data-toggle="modal" data-template_id="{{ $staff_row['timesheet_id'] }}" onclick="openModal('{{ $staff_row['timesheet_id'] }}', '{{ $report_row['entry_type'] }}')"><img src="/img/edit_icon.png" width="15"></a>
                        <a href="#" onClick="return lmtdelfun('{{ $staff_row['timesheet_id'] }}')"  ><img src="/img/cross.png" width="15" ></a>
						</tr>
                        @endif
					  @endforeach
					@endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div id="tab_3" class="tab-pane">
      <div class="box-body table-responsive">
        <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
          <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6"></div>
          </div>
          <div class="row">
            <div class="col-xs-12">
            <table class="table table-bordered table-hover dataTable" id="example3">
                <thead>
                  <tr role="row">
                  <!-- <th align="center"><input type="checkbox" id="allCheckSelect"/></th> -->
                    <th align="center"><strong>Date</strong></th>
                    <th><strong>Staff Name</strong></th>
                    <th><strong>Client Name</strong></th>
                    <th><strong>Expense Type</strong></th>
                    <th><strong>Amount(£)</strong></th>
                    <th><strong>Notes</strong></th>
                    <th><strong>Action</strong></th>
                  </tr>
                </thead>

                <tbody role="alert" aria-live="polite" aria-relevant="all">
                @if(!empty($time_sheet_reportlmt))
                  @foreach($time_sheet_reportlmt as $key=>$staff_row)
                    @if(isset($staff_row['entry_type']) && $staff_row['entry_type'] == 'E')
                    <tr>
                    <!--    <td align="center"><input type="checkbox" /></td> -->
                        <td>{{ $staff_row['created_date'] }}</td>
                        <td>{{ $staff_row['staff_detail']['fname'] }} {{ $staff_row['staff_detail']['lname'] }}</td>
                        <td  align="left">{{ $staff_row['client_detail']['field_value'] }}</td>
                        <td align="left">{{ $staff_row['old_services']['service_name'] }}</td>
                        <td>{{ number_format((float)$staff_row['hrs'], 2, '.', '')  }}</td>
                        <td align="center">
                            @if(empty($staff_row['notes']))
                                <a href="javascript:void(0)" onclick="return fontfetchnotesmodal('{{ $staff_row['notes'] }}')" data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="notes_btn">Notes</span></a>
                            @endif
                            @if(!empty($staff_row['notes']))
                                <a href="javascript:void(0)" onclick="return fontfetchnotesmodal('{{ $staff_row['notes'] }}')" data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="notes_btn">Notes</span></a>
                            @endif
                        </td>
                        <td align="center">
                            <a href="javascript:void(0)" data-toggle="modal" data-template_id="{{ $staff_row['timesheet_id'] }}" onclick="openModal('{{ $staff_row['timesheet_id'] }}', '{{ $report_row['entry_type'] }}')"><img src="/img/edit_icon.png" width="15"></a>
                            <a href="#" onClick="return lmtdelfun('{{ $staff_row['timesheet_id'] }}')"  ><img src="/img/cross.png" width="15" ></a>
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
      </div>
    </div>

    <div id="tab_4" class="tab-pane">
      <div class="box-body table-responsive">
        <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
          <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6"></div>
          </div>
          <div class="row">
            <div class="col-xs-12">
            <table class="table table-bordered table-hover dataTable" id="example4">
                <thead>
                  <tr role="row">
                  <!-- <th align="center"><input type="checkbox" id="allCheckSelect"/></th> -->
                    <th align="center"><strong>Date</strong></th>
                    <th><strong>Staff Name</strong></th>
                    <th><strong>Client Name</strong></th>
                    <th><strong>Expense Type</strong></th>
                    <th><strong>Amount(£)</strong></th>
                    <th><strong>Notes</strong></th>
                    <th><strong>Action</strong></th>
                  </tr>
                </thead>

                <tbody role="alert" aria-live="polite" aria-relevant="all">
                @if(!empty($time_sheet_report))
                  @foreach($time_sheet_report as $key=>$staff_row)
                    @if(isset($staff_row['entry_type']) && $staff_row['entry_type'] == 'X')
                     <tr>
                    <!--    <td align="center"><input type="checkbox" /></td> -->
                        <td align="center">{{ $staff_row['created_date'] }}</td>
                        <td>{{ $staff_row['staff_detail']['fname'] }} {{ $staff_row['staff_detail']['lname'] }}</td>
                        <td>{{ $staff_row['client_detail']['field_value'] }}</td>
                        <td>{{ $staff_row['old_services']['service_name'] }}</td>
                        <td>{{ number_format((float)$staff_row['hrs'], 2, '.', '')}}</td>
                        <td align="center">
                        @if(empty($staff_row['notes']))
                         <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff_row['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span class="notes_btn">Notes</span>
                        </a>
                        @endif
                        @if(!empty($staff_row['notes']))
                        
                        <a href="javascript:void(0)" onclick="return fetchnotesmodal('{{ $staff_row['notes'] }}')" data-toggle="modal" data-target="#fetchcomposenotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="notes_btn">Notes</span>
                        </a>
                       
                       @endif
                        
                        </td>
                        <td align="center"><a href="#" data-toggle="modal" data-template_id="{{ $staff_row['timesheet_id'] }}" onclick="openModal('{{ $staff_row['timesheet_id'] }}', '{{ $report_row['entry_type'] }}')"><img src="/img/edit_icon.png" width="15"></a>
                        <a href="#" onClick="return lmtdelfun('{{ $staff_row['timesheet_id'] }}')"  ><img src="/img/cross.png" width="15" ></a>
                        </tr>
                        @endif
                      @endforeach
                    @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
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

<!-- COMPOSE EDIT MESSAGE MODAL -->
<div class="modal fade" id="compose-edit-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <!--<form action="#" method="post">-->
      
      <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <table width="100%" border="0" class="staff_holidays">
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="30%"><strong>NEW TIME SHEET</strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>
               </td>
            </tr>
            <tr>
            <td valign="top">
			{{ Form::open(array('url' => '/timesheet/edit-time-sheet')) }}
            <table width="100%" class="table table-bordered" >
            <tbody>
              <tr>
                <th width="15%" align="center">Date</th>
                <th align="center">Staff Name</strong></th>
                <th width="18%" align="center">Client Name</strong></th>
                <th width="18%" align="center">Service <a href="#" class="add_to_list" data-toggle="modal" data-target="#vatScheme-modal">Add/Edit List</a></th>
                <th width="6%" align="center">Hrs</th>
                <th width="6%" align="center">Notes</th>
                <th width="12%">Attachment</th>
              </tr>
              <tr >
                <td align="left"><a href="#"><img src="/img/cross_icon.png" width="15" id="date_picker" ></a>
				<input class="dpick" type="text" id="eddpick" name="date" size="10" style="width:86%; height: 33px;"/>
				<input type="hidden" id="editid" name="editid" value="" />
				</td>
                <td align="center">
                <select class="form-control" name="staff_id" id="staff_id_edit">
                <option value="">None</option>
                @if(!empty($staff_details))
                  @foreach($staff_details as $key=>$staff_row)
                  <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                  @endforeach
                @endif
              </select>
              
              </td>
                <td align="center">
				<select class="form-control" name="rel_client_id" id="rel_client_id_edit">
				<option value="">None</option>
					@if(isset($allClients) && count($allClients)>0)
					  @foreach($allClients as $key=>$client_row)
						
						  <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
					
					  @endforeach
					@endif
          </select>
		  </td>
            <td align="center">
                <select class="form-control" name="vat_scheme_type[]" id="vat_scheme_type">
                <option value="">None</option>
                @if( isset($old_services) && count($old_services)>0 )
                  @foreach($old_services as $key=>$scheme_row)
                    <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                  @endforeach
                @endif
                @if( isset($new_services) && count($new_services)>0 )
                  @foreach($new_services as $key=>$scheme_row)
                    <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                  @endforeach
                @endif
                </select>
            </td>
                <td align="center"><input type="text" name="hrs" id="hrs_edit" style="width:90%; height: 33px;"></td>
                <td align="center">
                
                <button class="btn btn-default" onclick="return editnotesmodal()" data-toggle="modal" data-target="#composeeditnotes-modal"><span class="requ_t">Notes</span></button> 
                 <!--<input type="hidden" name="notes[]" id="notes12" value=""> -->

                <input type="hidden" name="notes" id="notesedit" style="width:90%; height: 33px;">
                
                </td>
              </tr>
            </tbody>
          </table>
        </td>
            </tr>
          </table>
          <div class="save_btncon">
            <div class="left_side"><!--<button class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button>--></div>
            <div class="right_side"> <button class="btn btn-info">Submit</button></div>
            <div class="clearfix"></div>
            </div>
       

        </div>
        
        {{ Form::close() }}
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<!-- composeclienttr -->
<div class="modal fade" id="composeclienttr-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:56%;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <!--<form action="#" method="post">-->
     <!--  {{ Form::open(array('url' => '/timesheet/insertclient-time-sheet')) }} -->
      <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          
          <div class="popupclienttime">
          
          <input type="hidden" name="type" id="ctr" value="client_tr">
             
                 <p class="clnt_con">CLIENT TIME REPORT</p>
             
              <div class="selec_seclf">
          
                  <span class="slct_con">Select Client</span>
                  
                       <select class="form-control2 newdropdown" name="ctr_client" id="ctr_client">
    				<option value="">None</option>
    					@if(isset($allClients) && count($allClients)>0)
    					  @foreach($allClients as $key=>$client_row)
    						
    						  <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
    					
    					  @endforeach
    					@endif
                       </select>
                     
                  <div class="clr"></div>
          
              </div>
              
              <div class="selec_seclf_r">
          
                  <span class="slct_con">Select Service</span>
                  
                  
                       <select class="form-control2 newdropdown" name="ctr_serv" id="ctr_serv">
    				<option value="">None</option>
    					@if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                       </select>
                     
                  <div class="clr"></div>
          
          
              </div>
              <div class="clr"></div>
              
              <div class="select_con1">
              <div class="selec_seclf2">
                    <span class="slct_con"><strong>Display activity from</strong></span>
                  <input class="dpick dpick1" type="text" id="fromdpick2" name="fromdate"  />
              </div>
            <div class="selec_seclf3" >
                    <span class="slct_con"><strong>to</strong></span>
                  <input class="dpick dpick1" type="text" id="todpick" name="todate"  />
                  <button class="clnt_button" id="client_display" onclick="return clientdisplay()">Display</button>   
              </div></div>
              
              
              <div class="clr"></div>
              <div id="dropctr">
              </div>
              <div class="clr"></div>
              <div id="dropctrerror" style="text-align: center; padding: 20px 10px 10px 10px; ">
              </div>
          </div>
          </div>
        
      <!--  {{ Form::close() }} -->
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- composeclienttr -->

<!--composeeditclienttr edit -->
<div class="modal fade" id="composeeditclienttr-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:56%;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <!--<form action="#" method="post">-->
       {{ Form::open(array('url' => '/timesheet/editclient-time-report')) }}
      <div class="modal-body">
      
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          
          <div class="popupclienttime">
          
          <input type="hidden" name="type" id="ctr" value="client_tr">
                 <p class="clnt_con">EDIT CLIENT TIME REPORT</p>
             
             
             <input type="hidden" id="editctrid" name="editctrid" value="" />
             
              <div class="selec_seclf">
          
          
          
                  <span class="slct_con">Select Client</span>
                  
                       <select class="form-control2 newdropdown" name="ctredit_client" id="ctredit_client">
    				<option value="">None</option>
    					@if(isset($allClients) && count($allClients)>0)
    					  @foreach($allClients as $key=>$client_row)
    						
    						  <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
    					
    					  @endforeach
    					@endif
                       </select>
                     
                  <div class="clr"></div>
          </div>
              
              
              
              <div class="selec_seclf_r" >
          
                  <span class="slct_con">Select Service</span>
                  
                       <select class="form-control2 newdropdown" name="ctredit_serv" id="ctredit_serv">
    				<option value="">None</option>
    					@if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    
                                    
         
         	
         
         
                                    
                                    
                       </select>
                     
                  <div class="clr"></div>
          
          
              </div>
              <div class="clr"></div>
              
              
              
              
              <div class="select_con1">
              <div class="selec_seclf2" >
                    <span class="slct_con"><strong>Display activity from</strong></span>
                  <input class="dpick dpick1" type="text" id="editfromdpick" name="editfromdpick"  />
                  <div class="clr"></div>
              </div>
              
              
              
              <div class="selec_seclf3" >
                    <span class="slct_con"><strong>to</strong></span>
                  <input class="dpick dpick1" type="text" id="edittodpick" name="edittodpick"  />
                  <button class="clnt_button">Display</button>   
                  <div class="clr"></div>
              </div> 
              </div>
              
              <div class="clr"></div>
          </div>
          </div>
        
        {{ Form::close() }}
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!--composeeditclienttr edit -->


<!-- strmodal -->
<div class="modal fade" id="composestr-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:56%;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <!--<form action="#" method="post">-->
    <!--  {{ Form::open(array('url' => '/timesheet/insertstaff-time-sheet')) }} -->
      
        <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          
          <div class="popupclienttime">
          
          <input type="hidden" name="type" id="str" value="staff_tr">
                 <p class="clnt_con">STAFF TIME REPORT</p>
                 
              <div class="selec_seclf">
          
                  <span class="slct_con">Select Staff</span>
                  
                       <select class="form-control2 newdropdown" name="str_staff" id="str_staff">
    				<option value="">None</option>
    					@if(!empty($staff_details))
                          @foreach($staff_details as $key=>$staff_row)
                          <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                          @endforeach
                        @endif
                       </select>
                     
                  <div class="clr"></div>
                    </div>
                    
              <div class="selec_seclf_r">
              
                <span class="slct_con">Select Client</span>
                 <select class="form-control2 newdropdown" name="str_client" id="str_client">
    				<option value="">None</option>
    					@if(isset($allClients) && count($allClients)>0)
					       @foreach($allClients as $key=>$client_row)
						      <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
					       @endforeach
					   @endif
                </select>
                   <div class="clr"></div>
                   
                   
                   
            </div>
              <div class="clr"></div>
              
              
              
              
              <div class="select_con1">
              <div class="selec_seclf2" >
          
                  <span class="slct_con"><strong>Display activity from</strong></span>
                  <input class="dpick dpick1" type="text" id="strdpick2" name="strfromdate"  />
                    <div class="clr"></div>
                </div>
              
              
              
              <div class="selec_seclf3" >
          
                  <span class="slct_con"><strong>to</strong></span>
                  <input class="dpick dpick1" type="text" id="dpickclient" name="strtodate"  />
                   <button class="clnt_button" onclick="return staffdisplay()">Display</button>   
                   <div class="clr"></div>
          
          
              </div>
              
              </div>
              <div class="clr"></div>
          
          <div id="dropstr" ></div>
          <div class="clr"></div>
          
           <div id="dropstrerror" style="text-align: center; padding: 20px 10px 10px 10px;" ></div>
           
          
          </div>
          
          
         
          
          
         
        </div>
      <!--  {{ Form::close() }} -->
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- strmodal -->



<!-- strmodaledit -->
<div class="modal fade" id="composeditestr-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:56%;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <!--<form action="#" method="post">-->
      {{ Form::open(array('url' => '/timesheet/editstaff-time-report')) }}
      
        <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          
          <div class="popupclienttime">
          <input type="hidden" name="editstrid" id="editstrid" value="">
                 <p class="clnt_con">EDIT STAFF TIME REPORT</p>
             
              <div class="selec_seclf">
          
                  <span class="slct_con">Select Staff</span>
                  
                       <select class="form-control2 newdropdown" name="editstr_staff" id="editstr_staff">
    				<option value="">None</option>
    					@if(!empty($staff_details))
                          @foreach($staff_details as $key=>$staff_row)
                          <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                          @endforeach
                        @endif
                       </select>
                     
                  <div class="clr"></div>
                    </div>
              <div class="selec_seclf_r">
                <span class="slct_con">Select Client</span>
                 <select class="form-control2 newdropdown" name="editstr_client" id="editstr_client">
    				<option value="">None</option>
    					@if(isset($allClients) && count($allClients)>0)
					       @foreach($allClients as $key=>$client_row)
						      <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
					       @endforeach
					   @endif
                </select>
                     
                  <div class="clr"></div>
            </div>
              <div class="clr"></div>
              
              
              
              
              <div class="select_con1">
              <div class="selec_seclf2">
          
                  <span class="slct_con"><strong>Display activity from</strong></span>
                  <input class="dpick dpick1" type="text" id="editstrfromdate" name="editstrfromdate"  />
                    <div class="clr"></div>
                </div>
              
              
              
              <div class="selec_seclf3">
          
                  <span class="slct_con"><strong>to</strong></span>
                  <input class="dpick dpick1" type="text" id="editstrtodate" name="editstrtodate"  />
                   <button class="clnt_button">Display</button>   
                   <div class="clr"></div>
          
          
              </div>
              </div>
              <div class="clr"></div>
          
          
          
          
          
          </div>

         
        </div>
        {{ Form::close() }}
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- strmodal -->


<div class="modal fade" id="composenotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    
    <div class="modal-content">
     
      
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
     
      <div style="width:100%;">
        <input type="hidden" name="NotesKey" id="NotesKey">
             <label for="f_name" style="font-size: 18px;">Notes</label>
             
          <textarea rows="4" cols="65"  name="notes1[]" id="notess" value="" ></textarea>
         
         
          <button class="btn btn-info" onclick="return notes()" id="save_notes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%; ">Save</button>   
          <div class="clr"></div>       
         </div>
        </div>
        
       
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- fetchcomposenotes-modal-->
<div class="modal fade" id="fetchcomposenotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    
    <div class="modal-content">
     
      
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
     
      <div style="width:100%;">
             <label for="f_name" style="font-size: 18px;">Notes</label>
             
          <textarea rows="4" cols="65"  name="notes1[]" id="fetchnotess" value="" ></textarea>
         
         
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
<!-- fetchcomposenotes-modal -->


<!-- fontfetchcomposenotes-modal-->
<div class="modal fade" id="fontfetchcomposenotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    
    <div class="modal-content">
     
      
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
     
      <div style="width:100%;">
             <label for="f_name" style="font-size: 18px;">Notes</label>
             
          <textarea rows="4" cols="65"  name="notes1[]" id="fontfetchnotess" value="" ></textarea>
         
         
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
<!-- fontfetchcomposenotes-modal -->

<!-- edit notes-->
<div style="z-index: 999;">
<div class="modal fade" id="composeeditnotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content" >
     
      
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
      <div style="width:100%;">
             <label for="f_name" style="font-size: 18px;">Notes</label>
             
          <!-- <input type="text" name="notes1[]" id="notess" value="" style="padding: 5px 5px;"> -->
          <textarea rows="4" cols="65" name="notes" id="notes" ></textarea>
          
        <!--  <input type="text" name="notes1[]" id="editnotess" value="" style="padding: 5px 5px;"> -->
         
          <button class="btn btn-info" onclick="return editnotes()" id="save_notes" style="padding:4px 20px; text-align: center; margin-top: 15px; float: right; margin-right: 6%;">Save</button>  
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
<!-- edit notes -->

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <!--<form action="#" method="post">-->
      
      <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <table width="100%" border="0" class="staff_holidays">
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="30%"><strong id="HeadingDiv">NEW TIME SHEET</strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
            <td valign="top">
            <form action="/timesheet/insert-time-sheet" method="post" enctype="multipart/form-data" id="timeSheetForm">
            <input type="hidden" name="entry_type" id="entry_type" value="T">
            <input type="hidden" name="page_type_pop" id="page_type_pop" value="{{ $staff_type }}">
            <input type="hidden" id="edit_id" name="edit_id" value="0" />

            <input type="hidden" name="tasks_service_id" id="tasks_service_id" value="0">
            <input type="hidden" id="tasks_client_id" name="tasks_client_id" value="0" />
            <input type="hidden" id="completed_id" name="completed_id" value="0" />
            
            <table width="100%" class="table table-bordered" id="BoxTable1">
            <thead>
              <tr>
                <th width="15%" align="center">Date</th>
                <th align="center">Staff Name</strong></th>
                <th width="18%" align="center">Client Name</strong></th>
                <th width="18%" align="center"><span id="servDiv">Service <a href="#" class="add_to_list" data-toggle="modal" data-target="#vatScheme-modal">Add/Edit List</a></span></th>
                <th width="6%" align="center"><span id="hrsDiv">Hrs</span></th>
                <th width="6%" align="center">Notes</th>
                <th id="attachTh" width="12%">Attachment</th>
              </tr>
            </thead>
            <tbody>
              <tr id="TemplateRow" class="makeCloneClass">
                <td align="left"><a href="#"><img src="/img/cross_icon.png" width="15" id="date_picker"  class="DeleteBoxRow" ></a>
				<input class="dpick" type="text" id="dpick1" name="date[]"  style="width:86%; height: 33px; padding-left: 12px;"/>
				</td>
                <td align="center"><select class="form-control" name="staff_id[]" id="staff_id">
                    <option value="">None</option>
                @if(!empty($staff_details))
                  @foreach($staff_details as $key=>$staff_row)
                  <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                  @endforeach
                @endif
                </select></td>
                <td align="center">
				<select class="form-control" name="rel_client_id[]" id="rel_client_id">
				    <option value="">None</option>
					@if(isset($allClients) && count($allClients)>0)
					  @foreach($allClients as $key=>$client_row)
						<option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
					  @endforeach
					@endif
                </select>
		        </td>
                <td align="center">
                <div id="schemeDropRow">
                    <select class="form-control" name="vat_scheme_type[]" id="vat_scheme_type">
                    <option value="">None</option>
                    @if( isset($old_services) && count($old_services)>0 )
                      @foreach($old_services as $key=>$scheme_row)
                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                      @endforeach
                    @endif
                    @if( isset($new_services) && count($new_services)>0 )
                      @foreach($new_services as $key=>$scheme_row)
                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                      @endforeach
                    @endif
                    </select>
                </div>
                <div id="expenseDropRow">
                    <select class="form-control" name="expense_type[]" id="expense_type">
                    <option value="">None</option>
                    @if( isset($expense_types) && count($expense_types)>0 )
                      @foreach($expense_types as $key=>$scheme_row)
                        <option value="{{ $scheme_row['expense_id'] }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row['expense_id'])?"selected":"" }}>{{ $scheme_row['expense_type'] }}</option>
                      @endforeach
                    @endif
                    </select>
                </div>
                </td>
                <td align="center"><input type="text" name="hrs[]" id="hrs" size="5%" class="form-control"></td>
                
                <td align="center">
                    <a href="javascript:void(0)" class="btn btn-default openNotesPop" data-key="1"><span class="requ_t">Notes</span></a>  
                    <input type="hidden" class="notesPop" name="notes[]" id="notes1" >
                </td> 

                <td id="attachTd">
                    <span class="btn btn-default btn-file" style="width: 73px; height: 34px; float: left">
                    Browse <input type="file" name="attachment1" class="attachFile" id="attachment1" data-key="1">
                    </span>
                    <div id="attachDivPop1" class="attachDivPop" style="float: left; margin: 7px 0 0 5px;"></div>
                </td>
              </tr>
            </tbody>
          </table>
              </td>
            </tr>
          </table>
          <div class="save_btncon">
            <div class="left_side" id="addNewLineBut"><button class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button></div>
            <div class="right_side"> <a href="javascript:void(0)" class="btn btn-info" id="timeSheetSubmit">Submit</a></div>
            <div class="clearfix"></div>
            </div>
         
        </div>
        
        {{ Form::close() }}
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- Vat Scheme Modal -->
<div class="modal fade" id="vatScheme-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-vat-scheme', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <input type="hidden" name="added_from" value="timesheetreport">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="vat_scheme_name" id="vat_scheme_name" placeholder="Service" class="form-control">
      </div>
       
      <div id="append_vat_scheme">
        @if( isset($old_services) && count($old_services) )
          @foreach($old_services as $key=>$scheme_row)
            <div class="form-group">
              <label for="{{ $scheme_row->service_name }}">{{ $scheme_row->service_name }}</label>
            </div>
          @endforeach
        @endif

        @if( isset($new_services) && count($new_services) )
          @foreach($new_services as $key=>$scheme_row)
            <div class="form-group" id="hide_vat_div_{{ $scheme_row->service_id }}">
              <a href="javascript:void(0)" title="Delete Field ?" class="delete_vat_scheme" data-field_id="{{ $scheme_row->service_id }}"><img src="/img/cross.png" width="12"></a>
              <label for="{{ $scheme_row->service_name }}">{{ $scheme_row->service_name }}</label>
            </div>
          @endforeach
        @endif
        </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-info pull-left save_t" id="add_vat_scheme" data-client_type="org" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="expenseType-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-vat-scheme', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <input type="hidden" name="added_from" id="added_from" value="timesheetreport">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="expense_type_name" id="expense_type_name" placeholder="Expense Type" class="form-control">
      </div>
       
      <div id="append_expense_type">
        @if( isset($expense_types) && count($expense_types) )
          @foreach($expense_types as $key=>$scheme_row)
            <div class="form-group" id="hide_vat_div_{{ $scheme_row['expense_id'] }}">
              <a href="javascript:void(0)" title="Delete Field ?" class="delete_expense_type" data-field_id="{{ $scheme_row['expense_id'] }}"><img src="/img/cross.png" width="12"></a>
              <label for="{{ $scheme_row['expense_type'] }}">{{ $scheme_row['expense_type'] }}</label>
            </div>
          @endforeach
        @endif
        </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-info pull-left save_t" id="add_expense_type" data-client_type="org" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


@stop
<!-- time-->