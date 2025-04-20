@extends('layouts.layout')

@section('mycssfile')
    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />

<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
<!-- page script -->


<script type="text/javascript">
$(function() {
                $("#fromdpick2c").datepicker({dateFormat: 'dd-mm-yy'});
});

$(function() {
                $("#todpickc").datepicker({dateFormat: 'dd-mm-yy'});
});

function pdfnewclientdisplay(){
     //alert('faffafaf');
    var ctr_client= $("#ctr_clientc").val();
   // var ctr_serv = $("#ctr_servc").val();
    
    if($("#ctr_servc").val()){
        var ctr_serv = $("#ctr_servc").val();
        
    }else{
        var ctr_serv ="";
    }
    
    var fromdpick2= $("#fromdpick2c").val();
    var todpick = $("#todpickc").val();
     
     if((fromdpick2!="" && todpick!="" && ctr_client!="") && ctr_serv =="" ){
    
        var hiturl = '/pdfclientnotstaff-time-sheet/'+ctr_client+'/'+fromdpick2+'/'+todpick
        console.log(hiturl);
        window.location.href='/pdfclientnotstaff-time-sheet/'+ctr_client+'/'+fromdpick2+'/'+todpick;
     } 
     
     
     if(fromdpick2!="" && todpick!="" && ctr_client!="" && ctr_serv!="" ){
    
        var hiturl = '/pdfclient-time-sheet/'+ctr_client+'/'+ctr_serv+'/'+fromdpick2+'/'+todpick
        console.log(hiturl);
        window.location.href='/pdfclient-time-sheet/'+ctr_client+'/'+ctr_serv+'/'+fromdpick2+'/'+todpick;
     }
     
     
     
     //console.log(url);return false;
     
  /*   if(fromdpick2!="" && todpick!="" && ctr_client!="" ){
     
     $.ajax({
    	type: "POST",
        
        url: '/pdfclient-time-sheet',
        data: {

			'ctr_client': ctr_client,'ctr_serv': ctr_serv,'fromdpick2': fromdpick2,'todpick': todpick

		},

		success: function(resp) {
		  
          console.log(resp);
          //return false;
            window.location.href='/pdfclient-time-sheet/'+ctr_client+'/'+ctr_serv+'/'+fromdpick2+'/'+todpick+   ;
		  
        }

	});  
    
     
    
    
} */


}


function excelnewclientdisplay(){
     //alert('faffafaf');
    var ctr_client= $("#ctr_clientc").val();
   // var ctr_serv = $("#ctr_servc").val();
    
    if($("#ctr_servc").val()){
        var ctr_serv = $("#ctr_servc").val();
        
    }else{
        var ctr_serv ="";
    }
    
    var fromdpick2= $("#fromdpick2c").val();
    var todpick = $("#todpickc").val();
     
     if((fromdpick2!="" && todpick!="" && ctr_client!="") && ctr_serv =="" ){
    
        var hiturl = '/excelclientnotstaff-time-sheet/'+ctr_client+'/'+fromdpick2+'/'+todpick
        console.log(hiturl);
        window.location.href='/excelclientnotstaff-time-sheet/'+ctr_client+'/'+fromdpick2+'/'+todpick;
     } 
     
     
     if(fromdpick2!="" && todpick!="" && ctr_client!="" && ctr_serv!="" ){
    
        var hiturl = '/excelclient-time-sheet/'+ctr_client+'/'+ctr_serv+'/'+fromdpick2+'/'+todpick
        console.log(hiturl);
        window.location.href='/excelclient-time-sheet/'+ctr_client+'/'+ctr_serv+'/'+fromdpick2+'/'+todpick;
     }
     
     
     
     //console.log(url);return false;
     


}


function newclientdisplay(){
    //alert('fsfsf');
    var ctr_client= $("#ctr_clientc").val();
    
    var ctr_serv = $("#ctr_servc").val();
    
    var fromdpick2= $("#fromdpick2c").val();
    
    var todpick = $("#todpickc").val();
    
    
    console.log(ctr_client);
    console.log(ctr_serv);
    console.log(fromdpick2);
    console.log(todpick);
    
    //return false;

    if(fromdpick2!="" && todpick!="" && ctr_client!="" ){
        
  

    $.ajax({
    	type: "POST",
        //dataType: "html",/timesheet/fetcheditstaff-time-sheet
        url: '/timesheet/insertclient-time-sheet',
        data: {

			'ctr_client': ctr_client,'ctr_serv': ctr_serv,'fromdpick2': fromdpick2,'todpick': todpick

		},

		success: function(resp) {
		  
        
               // alert(resp);
           
			console.log(resp);
            if(resp){
                $("#dropctrc").html(resp);
                $("#dropctrerror").html("")
            }
            else{
                $("#dropctrc").html("");
                $("#dropctrerror").html('<span style="color:red">No Records Found</span>');
            }

				}

	});  
    }else{
        $("#dropctrc").html("");
        $("#dropctrerror").html('<span style="color:red">Please Select Fields</span>');
    }





}
</script>
<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
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
            <div class="top_bts" style="margin-left: 467px;">
              <ul>
                <li>
               <!--   <button class="btn btn-success" onclick="window.print();"><i class="fa fa-trash-o fa-fw"></i> Print</button> -->
                </li> 
                <li>
                
                              
              <!-- <a href="/pdfclient-time-sheet" target="_blank" class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</a> -->
                  <button class="btn btn-success" onclick="pdfnewclientdisplay();"><i class="fa fa-download"></i> Generate PDF</button> 
                </li>
                <li>
                  <button class="btn btn-primary" onclick="excelnewclientdisplay();"><i class="fa fa fa-file-text-o"></i> Excel</button>
                </li>
              </ul>
            </div>
            <div class="clearfix"></div>
          </div>
<div class="modal-content" style="width: 59%; margin: 30px auto;">
<div class="modal-body">
        <!--  <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button> -->
          
          <div class="popupclienttime">
          
          <input type="hidden" name="type" id="ctr" value="client_tr">
             
                 <p class="clnt_con">CLIENT TIME REPORT</p>
             
              <div class="selec_seclf">
          
                  <span class="slct_con">Select Client</span>
                  
                       <select class="form-control2 newdropdown" name="ctr_client" id="ctr_clientc">
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
                  
                       <select class="form-control2 newdropdown" name="ctr_serv" id="ctr_servc">
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
                     
                  <div class="clr"></div>
          
          
              </div>
              <div class="clr"></div>
              
              <div class="select_con1">
              <div class="selec_seclf2">
                    <span class="slct_con"><strong>Display activity from</strong></span>
                  <input class="dpick dpick1" type="text" id="fromdpick2c" name="fromdate"  />
              </div>
            <div class="selec_seclf3" >
                    <span class="slct_con"><strong>to</strong></span>
                  <input class="dpick dpick1" type="text" id="todpickc" name="todate"  />
                  <button class="clnt_button" id="newclient_display" onclick="return newclientdisplay();">Display</button>   
              </div></div>
              
              
              <div class="clr"></div>
              <div class="clr"></div>
              <div id="dropctrc">
              </div>
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