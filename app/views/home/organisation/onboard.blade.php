@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<!-- Date picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/jquery-ui.css') }}" />
<!-- Date picker script -->

<!-- Time picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/timepicki.css') }}" />
<!-- Time picker script -->

<!-- Add To Calender Start -->
<link href="{{ URL :: asset('css/atc-style-blue.css') }}" rel="stylesheet" type="text/css">
<!-- Add To Calender End -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/onboard.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="{{ URL :: asset('js/jquery-ui.min.js') }}"></script>
<!-- Date picker script -->

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->

<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
function pdfonboard(){
        var search_value = $("#example2_filter input").val();
    if(search_value!= ""){
       var search = search_value;        
    }else{
        var search = "NONE";
    }
   var hiturl ='/pdfonboard/'+search+'/pdf'
    window.location.href='/pdfonboard/'+search+'/pdf'
    console.log(hiturl);return false;

}
function excelonboard(){
        var search_value = $("#example2_filter input").val();
    if(search_value!= ""){
       var search = search_value;        
    }else{
        var search = "NONE";
    }
      var hiturl ='/pdfonboard/'+search+'/excel'
   window.location.href='/pdfonboard/'+search+'/excel'
    console.log(hiturl);return false;

}



$(".made_up_date").datepicker({ minDate: new Date(1900, 12-1, 25), maxDate:0, dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: "-10:+10" });

$(".addto_date").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-5:+100" });

$(function() {
  $('#example2').dataTable({
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
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
      ],
      "aaSorting": [[1, 'asc']]

  });

});

$('#calender_time').timepicki({
  show_meridian:false,
  //min_hour_value:0,
  max_hour_value:23,
  //step_size_minutes:15,
  //overflow_minutes:true,
  increase_direction:'up',
  //disable_keyboard_mobile: true
});
</script>

@stop

@section('content')
<input type="hidden" id="custom_check_id" value="0">
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @include('layouts.outer_leftside')
                    </ul>
                </section>
                <!-- /.sidebar -->
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
              <button class="btn btn-success" onclick="pdfonboard();"><i class="fa fa-download"></i> Generate PDF</button> 
            </li>
            <li>
              <button class="btn btn-primary" onclick="excelonboard();"><i class="fa fa fa-file-text-o"></i> Excel</button> 
            </li> -->
            <li>
              <a href="/hmrc/authorisations/1" class="btn btn-success">64-8</a> 
            </li>
            <li>
              <a href="/hmrc/authorisations/2" class="btn btn-primary">FBI-2</a> 
            </li>
            <li>
              <a href="/hmrc/authorisations/3" class="btn btn-warning">VAT 484</a> 
            </li>
            <li>
              <a href="/hmrc/authorisations/4" class="btn btn-info">SA 401</a> 
            </li>
            <li>
              <a href="/hmrc/authorisations/5" class="btn btn-primary" style="background-color:#0866c6">VAT 600 FRS</a> 
            </li>
            <li>
              <a href="/hmrc/authorisations/6" class="btn btn-danger">SA1</a> 
            </li>
            <div class="clearfix"></div>
          </ul>
        </div>
        <div id="message_div" style="margin-left: 700px;"><!-- Loader image show while sync data --></div>
        <!-- <div style="float: right; margin-right: 43px;"><a href="javascript:void(0)" id="archive_div">Show Archived</a></div> -->

      </div>
      <div class="practice_mid">
        <form>
          <div class="tabarea">
            <div class="tab_topcon">
              <div class="top_bts" style="float:left;">
                <ul style="padding:0;">
                  <li>
                    <a href="javascript:void(0)" id="positionopen" class="btn btn-info">Onboarding Checklist</a>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              <div class="top_search_con">
               <div class="top_bts">
                <ul style="padding:0;">
                  <!-- <li>
                    <button type="button" id="" style="  width: 95px;" class="btn btn-warning">AML</button>
                  </li>
                  <li>
                    <a href="/hmrc/authorisations/1" class="btn btn-info">FORMS</a>
                  </li> -->
                  <li style="margin-right: 0px;">
                    <button type="button" id="deleteOnboarding" class="btn btn-danger" style="background-color: red;"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              </div>
              <div class="clearfix"></div>

            </div>
            
<div class="box-body table-responsive">
  <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
    <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
      <input type="hidden" id="client_type" value="org"> 
        <thead>
          <tr role="row">
            <td align="center"><input type="checkbox" id="allCheckSelect"/></td>
            <td align="center">Join Date</td>
            <td align="center">Client Type</td>
            <td align="center">Client Name</td>
            <td align="center">Contact Name</td>
            <td align="center">% Completed</td>
            <td align="center">Telephone</td>
            <td align="center">Email</td>
            <td align="center">Mobile</td>
            <td align="center">Notes</td>
          </tr>
        </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(!empty($client_details))
              <?php $i=1; ?>
              @foreach($client_details as $key=>$client_row)
                <tr class="all_check" {{ ($client_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                  <td align="center">
                    <input type="checkbox" data-archive="{{ $client_row['show_archive'] }}" class="ads_Checkbox" name="client_delete_id[]" value="{{ $client_row['client_id'] or "" }}" />
                  </td>
                  <td align="center">
                    <a href="javascript:void(0)" class="change_last_date" data-client_id="{{ $client_row['client_id'] or "" }}" data-tab="3" data-key="{{ $key }}" id="3_dateanchore_{{ $key }}"  data-prev_date="{{ date('d-m-Y',strtotime($client_row['created'])) }}"> {{ date('d-m-Y',strtotime($client_row['created'])) }}</a>
                
                    <span class="3_save_made_span_{{ $key }}"  style="display:none;">
                      <input type="text" class="made_up_date" id="3_made_up_date_{{ $key }}" />
                        <a href="javascript:void(0)" class="search_t save_made_date" data-client_id="{{ $client_row['client_id'] or "" }}" data-tab="3" data-key="{{ $key }}">Save</a>
                        <a href="javascript:void(0)" class="search_t cancel_made_date" data-client_id="{{ $client_row['client_id'] or "" }}" data-tab="3" data-key="{{ $key }}">Cancel</a>
                    </span>
                  </td>
                  
                  @if( isset($client_row['business_type']))
                  <td align="center">{{ isset($client_row['business_type'])?$client_row['business_type']:""}}</td>
                  @else
                    <td align="center">{{ isset($client_row['client_name'])?"Individual":"" }}</td>
                  @endif                    
                    
                  @if( isset($client_row['business_name']))
                    <td align="left"><a href="#" data-toggle="modal" id="businessclient" data-date="{{ date('d-m-Y',strtotime($client_row['created'])) }}" data-businessname="{{$client_row['business_name']}}" data-clientid= "{{ $client_row['client_id'] }}">{{ isset($client_row['business_name'])?$client_row['business_name']:"" }}</a></td> 
                  @else
                    <td align="left"><a href="#" data-toggle="modal" id="businessclient" data-date="{{ date('d-m-Y',strtotime($client_row['created'])) }}" data-businessname="{{$client_row['client_name']}}" data-clientid= "{{ $client_row['client_id'] }}" data-target="#compose-modal">{{ isset($client_row['client_name'])?$client_row['client_name']:"" }}</a></td>         
                  @endif

                    <!--
                    <td align="left"><a href="/client/edit-org-client/{{ $client_row['client_id'] }}/{{ base64_encode('org_client') }}">{{ isset($client_row['business_name'])?$client_row['business_name']:"" }}</a></td> -->
                    
                    <td align="center">
                    
                    {{ isset($client_row['corres_cont_name'])?$client_row['corres_cont_name']:"" }}
                    
                    
                    </td>
                    
                    <td align="center">
                    {{ $client_row['avg'] }} %
                    <!--  @if( isset($client_row['deadacc_count']) && $client_row['deadacc_count'] == "OVER DUE" )
                        <span style="color:red">{{ $client_row['deadacc_count'] or "" }}</span>
                      @else
                         {{ $client_row['deadacc_count'] or "" }}
                      @endif -->
                    </td>
                    
                    <td align="center">
                    @if( isset($client_row['corres_cont_telephone']))
                      {{ isset($client_row['corres_cont_telephone'])?$client_row['corres_cont_telephone']:"" }}
                    @endif

                    @if( isset($client_row['res_telephone']))
                      {{ isset($client_row['res_telephone'])?$client_row['res_telephone']:"" }}
                    @endif
                    
                    </td>
                  
                 
                    <td align="center">
                     @if( isset($client_row['corres_cont_email']))
                    {{ isset($client_row['corres_cont_email'])?$client_row['corres_cont_email']:"" }}
                      @endif
                      
                      @if( isset($client_row['res_email']))
                    {{ isset($client_row['res_email'])?$client_row['res_email']:"" }}
                      @endif
                      
                    </td>
                   
                    
                    <td align="center">
                   @if( isset($client_row['corres_cont_mobile']))
                    {{ isset($client_row['corres_cont_mobile'])?$client_row['corres_cont_mobile']:"" }}
                      @endif
                    
                  @if( isset($client_row['res_mobile']))
                    {{ isset($client_row['res_mobile'])?$client_row['res_mobile']:"" }}
                      @endif
                  
                    </td>
                    
                    
                    <td align="center">
                      <button class="notes_btn" data-cid="{{ $client_row['client_id'] }}" id="notesmodal"  ><span class="requ_t">notes</span></button>
                    </td>
                    
                    
                    
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
        

<div>
<div class="modal fade" id="composenotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    
    <div class="modal-content">
     <input type="hidden" id="notescid" value="">
      
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
     
      <div style="width:100%;">
      <h2 style="padding:0px; margin:0px;">
             <label for="f_name" >Notes</label></h2>
             
          <textarea rows="4" cols="50" style="width:100%"  name="notes1[]" id="notess" value="" ></textarea>
         
         <div class="clr"></div>   
          <button class="btn btn-primary" onclick="return notes()" id="save_notes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right;">Save</button>   
               
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
        
<!-- -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:70%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><p id="businessname" align="center" style="margin: 0px 0px -31px 0px;font-size: 18px; font-weight: bold;color:#00acd6"></p></h4>
        <div class="clearfix"></div>
      </div>
      <!--<form action="#" method="post">-->
      
      <div class="modal-body">
        {{ Form::open(array('url' => '/onboarding/insert-onboarding')) }} 
          <input type="hidden" name="cid" id="c_id" value="">     
          <div class="show_loader"><!-- Show loader --></div>
          <div class="practice_mid">
              <div class="tabarea" id="BoxTable">
                  <!-- Ajax Call -->
              </div> 
          </div>

          <div class="modal-footer1 clearfix">
            <div class="email_btns">
              <button type="submit" class="btn btn-info pull-left save_t" id="saveOnbording" name="save">Submit</button>
              <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
            </div>
          </div>
        {{ Form::close() }}
      </div>
        
        
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>  

 <!-- Client -->
<div class="modal fade" id="checklist-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
      <input type="hidden" id="hiddenclient" value="" />
              
   {{ Form::open(array('url' => '/client/add-checklist', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <div class="modal-body">
      <div id="add_to_msg" style="text-align:center;"><!-- Loader show --></div>
      <div class="form-group" style="float:right">
        <button type="button" class="btn btn-info pull-left save_t" data-client_type="org" id="add_position_type" name="save">ADD</button>
        <div class="clearfix"></div>
      </div>

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="checklist" id="checklist" placeholder="Checklist" class="form-control">
      </div>
      
      <div id="append_position_type">
      @if( isset($old_postion_types) && count($old_postion_types) >0 )
        @foreach($old_postion_types as $key=>$old_org_row)
        <div class="form-group">
          <label for="{{ $old_org_row->name }}">{{ $old_org_row->name }}</label>
        </div>
        @endforeach
      @endif

      @if( isset($new_postion_types) && count($new_postion_types) >0 )
        @foreach($new_postion_types as $key=>$new_org_row)
          @if( isset($new_org_row->custom_check_id) && $new_org_row->custom_check_id == '0' )
            <div class="form-group" id="hide_div_{{ $new_org_row->checklist_id }}">
              <a href="javascript:void(0)" title="Delete Field ?" class="delete_checklist_name" data-field_id="{{ $new_org_row->checklist_id }}"><img src="/img/cross.png" width="12"></a>
              <label for="{{ $new_org_row->name }}">{{ $new_org_row->name }}</label>
            </div>
          @endif
        @endforeach
      @endif
      </div>
     
      <!-- <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="add_position_type" name="save">ADD</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div> -->
    </div>
    {{ Form::close() }} 
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>      
<div class="modal fade" id="addto_calender-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:410px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD JOB START DATE</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/onboarding/add-task-date', 'id'=>'field_form')) }}
      <div class="modal-body">
        <div id="start_date_loader" style="text-align: center; padding-bottom: 10px;"><!-- Show loader --></div>
        <input type="hidden" id="calender_client_id" name="calender_client_id">
        <input type="hidden" id="cleinttaskdate_id" name="cleinttaskdate_id">
        <input type="hidden" id="calender_tab" name="calender_tab">
        <table>
          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left" width="20%"><strong>Date : </strong></td>
            <td align="left"><input id="calender_date" name="calender_date" class="form-control addto_date"></td>
          </tr>
          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" width="20%">&nbsp;</td>
            <td align="left" width="20%"><strong>Time : </strong></td>
            <td align="left"><input id="calender_time" name="calender_time" class="form-control"></textarea></td>
          </tr>

          <tr>
            <td align="left" colspan="3">&nbsp;</td>
          </tr>

          <tr>
            <td align="left" colspan="2" width="20%"></td>
            <td align="right"><button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> <button type="button" class="btn btn-info save_job_start_date">Save</button></td>
          </tr>
        </table>
      </div>
      {{ Form::close() }} 
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>   

<div class="modal fade" id="checknotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <input type="hidden" id="tablechecklist_id" name="tablechecklist_id" value="">
  <input type="hidden" id="position" name="position" value="">
  <input type="hidden" id="key" name="key" value="">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">      
      <div class="modal-body">
         <div class="show_loader"></div> 
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
      <div style="width:100%;">
      <h2 style="padding:0px; margin:0px;">
        <label for="f_name" >Notes</label></h2>
        <textarea rows="4"  class="form-control" name="table_notes" id="table_notes" ></textarea>
         <div class="clr"></div>   
          <button class="btn btn-info" id="save_table_notes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right;">Save</button>   
               
         </div>
          <div class="clr"></div>   
        </div>
    </div>
  </div>
</div>
@stop