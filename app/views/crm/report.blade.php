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

<script>
$(document).ready(function(){
    $("#date_to").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#date_from").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
});

function pdfreport(){
    
    var status    = $("#status_id").val();
    var owner     = $("#user_id").val();
    var date_from = $("#date_from");
    var date_to   = $("#date_to").val();
    
    /*if($("#is_deleted").is(':checked')){
      var is_deleted  = 'Y';
    }else{
      var is_deleted  = 'N';
    }
    if($("#is_archive").is(':checked')){
      var is_archive  = 'Y';
    }else{
      var is_archive  = 'N';
    }*/
    var is_deleted  = 'N';
    var is_archive  = 'N';


    if(status == ""){
      alert("There is nothing to display. Please generate a report first.");
      $("#status_id").focus();
      return false;
    }
    if(owner == ""){
      alert("There is nothing to display. Please generate a report first.");
      $("#owner").focus();
      return false;
    }
    if(date_from == ""){
      alert("Please select Date form field");
      $("#There is nothing to display. Please generate a report first.").focus();
      return false;
    }
    if(date_to == ""){
      alert("Please select Date to field");
      $("#There is nothing to display. Please generate a report first.").focus();
      return false;
    }
       
       var hiturl = '/pdfreport/'+status+'/'+owner+'/'+date_from+'/'+date_to+'/'+is_deleted+'/'+is_archive ;
        console.log(hiturl);//return false;
        window.location.href = hiturl
    
}


function excelreport(){
     
    var status    = $("#status_id").val();
    var owner     = $("#user_id").val();
    var date_from = $("#date_from");
    var date_to   = $("#date_to").val();
    

    if(status == ""){
      alert("Please select The status");
      $("#status_id").focus();
      return false;
    }
    if(date_from == ""){
      alert("Please select Date form field");
      $("#date_from").focus();
      return false;
    }
    if(owner == ""){
      alert("There is nothing to display. Please generate a report first.");
      $("#owner").focus();
      return false;
    }
    if(date_to == ""){
      alert("Please select Date to field");
      $("#date_to").focus();
      return false;
    }
       
       var hiturl = '/excelreport/'+status+'/'+owner+'/'+from+'/'+to+'/'+is_deleted+'/'+is_archive ;
       // console.log(hiturl);return false;
        window.location.href='/excelreport/'+status+'/'+owner+'/'+from+'/'+to+'/'+is_deleted+'/'+is_archive;
    
}

</script>
@stop
 
@section('content')
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
    <section class="content">
      <div class="practice_mid">
          <div class="top_buttons">
            <div class="top_bts" style="margin-left: 419px;">
              <ul>
                <!-- <li>
                  <button class="btn btn-success" onclick="window.print();"><i class="fa fa-trash-o fa-fw"></i> Print</button>
                </li>  -->
                <li>
                  <button class="btn btn-success" onclick="pdfreport();"><i class="fa fa-download"></i> Generate PDF</button>
                </li>
                <li>
                 <button class="btn btn-primary" onclick="excelreport();"><i class="fa fa fa-file-text-o"></i> Excel</button>
                <!--
                  <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button>
                  -->
                </li>
              </ul>
            </div>
            <div class="clearfix"></div>
          </div>

	<div class="modal-content" style="width: 59%; margin: 30px auto;">
		<div class="modal-header" style="padding-bottom: 0px; border-bottom: none;">
	        <button onclick="window.history.back(-1)" type="button" class="close save_btn">×</button>
	        <!-- <h4 class="modal-title">NEW - LEAD ENQUIRY & PROSPECT</h4> -->
	        <div class="clearfix"></div>
      	</div>

		<div class="modal-body" style="padding-top: 0px">
        <!--  <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button> -->
          
          <div class="popupclienttime">
          	<input type="hidden" name="type" id="ctr" value="client_tr">
          	<p class="clnt_con">CLOSED DEAL REPORTS</p>
             	<div class="selec_seclf">
          			<span class="slct_con"><strong>Select Status</strong></span>
                  	<select class="form-control2 newdropdown" name="status_id" id="status_id">
    					<option value="">None</option>
    					<option value="9">LOST</option>
    					<option value="8">WON</option>
    				</select>
                  	<div class="clr"></div>
          		</div>
              
              	<div class="selec_seclf_r">
          			<span class="slct_con"><strong>Deal Owner</span>
                  <select class="form-control2 newdropdown" name="user_id" id="user_id">
          					<option value="">None</option>
          					@if(isset($staff_details) && count($staff_details) >0)
		                  @foreach($staff_details as $key=>$staff_row)
		                  <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
		                  @endforeach
		                @endif
                    <option value="unassigned">Unassigned</option>
    				      </select>
                  	<div class="clr"></div>
          		</div>
              	<div class="clr"></div>

              	<!-- <div class="select_con1">
          				<div class="selec_seclf2">
        				    <span class="slct_con"><input type="checkbox" id="is_deleted" name="is_deleted" class="form-control" value="Y" checked></span>
        				    <label for="exampleInputPassword1" style="width: 75%!important; margin:6px 0 0 5px;">Include Deleted Items</label>
          				</div>
              	<div class="selec_seclf3" >
                  <span class="slct_con"><input type="checkbox" id="is_archive" name="is_archive" class="form-control" value="Y" checked></span>
                  <label for="exampleInputPassword1" style="width: 75%!important; margin:6px 0 0 5px;">Include Archived Items</label>
              	</div>
              	<div class="clr"></div>
              </div> -->
              
              	<div class="select_con1">
					<div class="selec_seclf2">
					    <span class="slct_con"><strong>Date From</strong></span>
					    <input class="dpick dpick1" type="text" id="date_from" name="date_from" />
					</div>
	            	<div class="selec_seclf3" >
	                    <span class="slct_con"><strong>Date To</strong></span>
	                    <input class="dpick dpick1" type="text" id="date_to" name="date_to" />
	                    <button type="button" class="clnt_button" id="display">Display</button>   
	              	</div>
	              	<div class="clr"></div>
                </div>

                
              
                <div id="display_result"><!-- Result Display --></div>
	              	<div class="clr"></div>
	              	<div id="dropctrerror" style="text-align: center; padding: 20px 10px 10px 10px; ">
                </div>
            </div>
        </div>
    </div>
         
      </div>
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>

@stop
<!-- time-->