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
<!-- page script -->


<script type="text/javascript">
$(function() {
                $("#strdpick2s").datepicker({dateFormat: 'dd-mm-yy'});
});

$(function() {
                $("#dpickclients").datepicker({dateFormat: 'dd-mm-yy'});
});

function pdfstaff(){
    
    var str_staff= $("#str_staffs").val(); 
    
    if($("#str_clients").val()){
        var str_client = $("#str_clients").val();
    }else{
         var str_client = "";
    }
   
    
    
    
    
    var strdpick2= $("#strdpick2s").val();
    var dpickclient = $("#dpickclients").val();
     
     
    
    console.log(str_staff);
    console.log(str_client);
    console.log(strdpick2);
    console.log(dpickclient);
    
    if((strdpick2!="" && dpickclient!="" && str_staff!="") && str_client =="" ){
        
        var hiturl = '/pdfstaffnoclient-time-sheet/'+str_staff+'/'+strdpick2+'/'+dpickclient
        console.log(hiturl);
        window.location.href='/pdfstaffnoclient-time-sheet/'+str_staff+'/'+strdpick2+'/'+dpickclient;
        
        
    }
    
    if(strdpick2!="" && dpickclient!="" && str_staff!="" && str_client !="" ){
        
        var hiturl = '/pdfstaff-time-sheet/'+str_staff+'/'+str_client+'/'+strdpick2+'/'+dpickclient
        console.log(hiturl);
        window.location.href='/pdfstaff-time-sheet/'+str_staff+'/'+str_client+'/'+strdpick2+'/'+dpickclient;
        
        
    }
    
    
    
}



function excelstaff(){
    
    var str_staff= $("#str_staffs").val(); 
    
    if($("#str_clients").val()){
        var str_client = $("#str_clients").val();
    }else{
         var str_client = "";
    }
   
    
    
    
    
    var strdpick2= $("#strdpick2s").val();
    var dpickclient = $("#dpickclients").val();
     
     
    
    console.log(str_staff);
    console.log(str_client);
    console.log(strdpick2);
    console.log(dpickclient);
    //return false;
    if((strdpick2!="" && dpickclient!="" && str_staff!="") && str_client =="" ){
        
        var hiturl = '/excelstaffnoclient-time-sheet/'+str_staff+'/'+strdpick2+'/'+dpickclient
        console.log(hiturl);
        window.location.href='/excelstaffnoclient-time-sheet/'+str_staff+'/'+strdpick2+'/'+dpickclient;
        
        
    }
    
    if(strdpick2!="" && dpickclient!="" && str_staff!="" && str_client !="" ){
        
        var hiturl = '/excelstaff-time-sheet/'+str_staff+'/'+str_client+'/'+strdpick2+'/'+dpickclient
        console.log(hiturl);
        window.location.href='/excelstaff-time-sheet/'+str_staff+'/'+str_client+'/'+strdpick2+'/'+dpickclient;
        
        
    }
    
    
    
}





function newstaffdisplay(){
    
   //alert('sfsfsfsf');return false;

    
     var str_staff= $("#str_staffs").val();
    
    var str_client = $("#str_clients").val();
    
    var strdpick2= $("#strdpick2s").val();
    
    var dpickclient = $("#dpickclients").val();
    
    
    console.log(str_staff);
    console.log(str_client);
    console.log(strdpick2);
    console.log(dpickclient);
    //return false;
    if(strdpick2!="" && dpickclient!="" && str_staff!="" ){
     $.ajax({
    	type: "POST",
        //dataType: "html",/timesheet/fetcheditstaff-time-sheet
        url: '/timesheet/insertstaff-time-sheet',
        data: {

			'str_staff': str_staff,'str_client': str_client,'strdpick2': strdpick2,'dpickclient': dpickclient

		},

		success: function(resp) {
		  
        
               // alert(resp);
           
			console.log(resp);
            if(resp){
                $("#dropstrs").html(resp);
                $("#dropstrerrors").html("")
            }
            else{
                $("#dropstrs").html("");
                $("#dropstrerrors").html('<span style="color:red">No Records Found</span>');
            }
            //$("#dropstr").html(resp);

				}

	});
    }else{
        $("#dropstrs").html("");
         $("#dropstrerrors").html('<span style="color:red">Please Select Fields</span>');
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
            <div class="top_bts" style="margin-left: 467px;" >
              <ul>
                <li>
               <!--   <button class="btn btn-success" onclick="window.print();"><i class="fa fa-trash-o fa-fw"></i> Print</button> -->
                </li> 
                <li>
                  <button class="btn btn-success" onclick="pdfstaff();"><i class="fa fa-download"></i> Generate PDF</button>
                </li>
                <li>
                  <button class="btn btn-primary" onclick="excelstaff();"><i class="fa fa fa-file-text-o"></i> Excel</button>
                </li>
              </ul>
            </div>
            <div class="clearfix"></div>
          </div>
<div class="modal-content" style="width: 59%; margin: 30px auto;">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <!--<form action="#" method="post">-->
    <!--  {{ Form::open(array('url' => '/timesheet/insertstaff-time-sheet')) }} -->
      
        <div class="modal-body">
        <!--  <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button> -->
          
          <div class="popupclienttime">
          
          <input type="hidden" name="type" id="str" value="staff_tr">
                 <p class="clnt_con">STAFF TIME REPORT</p>
                 
              <div class="selec_seclf">
          
                  <span class="slct_con">Select Staff</span>
                   
                       <select class="form-control2 newdropdown" name="str_staff" id="str_staffs">
    				<option value="">None</option>
    					@if(!empty($staff_details))
                  @foreach($staff_details as $key=>$staff_row)
                  <option value="{{ $staff_row->user_id }}">{{ $staff_row->fname }} {{ $staff_row->lname }}</option>
                  @endforeach
                @endif
                       </select>
                     
                  <div class="clr"></div>
                    </div>
                    
              <div class="selec_seclf_r">
              
                <span class="slct_con">Select Client</span>
                 <select class="form-control2 newdropdown" name="str_client" id="str_clients">
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
                  <input class="dpick dpick1" type="text" id="strdpick2s" name="strfromdate"  />
                    <div class="clr"></div>
                </div>
              
              
              
              <div class="selec_seclf3" >
          
                  <span class="slct_con"><strong>to</strong></span>
                  <input class="dpick dpick1" type="text" id="dpickclients" name="strtodate"  />
                   <button class="clnt_button" onclick="return newstaffdisplay()">Display</button>   
                   <div class="clr"></div>
          
          
              </div>
              
              </div>
              <div class="clr"></div>
          
          <div id="dropstrs" ></div>
          <div class="clr"></div>
          
           <div id="dropstrerrors" style="text-align: center; padding: 20px 10px 10px 10px;" ></div>
           
          
          </div>
          
          
         
          
          
         
        </div>
      <!--  {{ Form::close() }} -->
      <!--</form>-->
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