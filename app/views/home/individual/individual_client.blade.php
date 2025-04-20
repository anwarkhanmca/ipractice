@extends('layouts.layout')

@section('mycssfile')
    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/indonboarding.js') }}" type="text/javascript"></script>

<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- jTable -->
<script src="{{ URL :: asset('js/jtablejs/client_lists.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
/*var oTable;
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

   oTable.fnSort( [ [2,'asc'] ] );

});*/



function pdfindclient(){
    
    
    var search_value = $("#example2_filter input").val();
    
    if(search_value!= ""){
        
       var search = search_value;
        
        
    }else{
        
        var search = "NONE";
        
    }
   var hiturl ='/indpdf/'+search+'/pdf'
   
   window.location.href='/indpdf/'+search+'/pdf'
    
    console.log(hiturl);return false;
    
    
    
}

function excelindclient(){
    
    
    var search_value = $("#example2_filter input").val();
    
    if(search_value!= ""){
        
       var search = search_value;
        
        
    }else{
        
        var search = "NONE";
        
    }
   var hiturl ='/indpdf/'+search+'/excel'
   
   window.location.href='/indpdf/'+search+'/excel'
    
    console.log(hiturl);return false;
    
    
    
}



/*$(document).ready(function(){
  $("#archivedButton").click(function(){
        var oSettings = oTable.fnSettings();
        oSettings._iDisplayLength = -1;
        oTable.fnDraw();
  })
})*/
</script>
@stop

@section('content')
<input type="hidden" id="client_type" value="ind"> 

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
            <!-- <li>
            <button class="btn btn-success" onclick="pdfindclient();"><i class="fa fa-download" style=" padding-right: 4px;"></i>Generate PDF</button> </li>
            <li>
              <button class="btn btn-primary" onclick="excelindclient();"><i class="fa fa fa-file-text-o" ></i> Excel</button>
            </li> -->
            <li>
            
             <div class="import_fromch_main">
                      <div class="import_fromch1">
                        <a href="/onboard" class="import_fromch_link">CLIENT ON-BOARDING</a>
                        <a href="javascript:void(0)" class="i_selectbox" id="selectclient_onboard"><img src="/img/arrow_icon.png"></a>
                        <div class="clearfix"></div>
                      </div>
                     <div class="i_dropdown onopen_toggle" id="onboardind_drop"><a href="#"></a>On-Board New Client</div>
                    </div>
             
             
            </li>
            
            
           
            
            
            <!-- <li>
            
              <button class="btn btn-warning" type="button" id="edit_but"><i class="fa fa-edit"></i> Edit</button>
              <button class="btn btn-success" type="button" style="display:none;" id="save_but">Save</button>
            
            </li> -->

            

            <div class="clearfix"></div>
          </ul>
        </div>

        <!-- <div style="float: right; margin-right: 43px;"><a href="javascript:void(0)" id="archive_div">Show Archived</a></div> -->
      </div>
      <div class="practice_mid">          
          <div class="tabarea">
            <div class="tab_topcon">
              <div class="top_bts">
                <ul style="padding:0;">
                  <li>
                    <a href="/individual/add-client" class="btn btn-info">+ CLIENT - KEY IN</a>
                  </li>
                  <li>
                    <a href="/import-from-ch/{{ base64_encode('ind_list') }}" class="btn btn-info">IMPORT FROM CH</a>
                  </li>
                  <li>
                    <a href="/chdata/bulk-company-upload-page/{{ base64_encode('ind_list') }}" class="btn btn-info">CSV IMPORT</a>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              <div class="top_search_con">
               <div class="top_bts">
                <ul style="padding:0;">
                  
                  <li style="margin-top: 8px;">
                    <!-- <button type="button" id="show_search" class="btn btn-success">Search</button> -->
                    <?php $value = Session::get('show_archive');?>
                    <a href="javascript:void(0)" id="archive_div">
                      {{ (isset($value) && $value == "Y") ? "Show Archived Clients":"Hide Archived Clients" }}</a>
                  </li>
                  
                  <li>
                    <button type="button" id="archivedButton" class="btn btn-warning">Archive</button>
                  </li>
                  <li>
                    <button type="button" id="deleteClients" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              </div>
              <div class="clearfix"></div>
            </div>
            
    <div class="box-body table-responsive">
      @include('home/include/client_lists')

      <!--<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
        <div class="row">
          <div class="col-xs-6"></div>
          <div class="col-xs-6"></div>
        </div>
          <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info" width="100%">
            <input type="hidden" id="client_type" value="ind">  
            <thead>
              <tr role="row">
                <th width="3%"><input type="checkbox" id="allCheckSelect"/></th>
                <th>DOB</th>
                <th>Client Name</th>
                <th width="15%">Business Name</th>
                <th>NI Number</th>
                <th width="6%">UTR</th>
                <th><span id="acting_text" title="Personal Tax Return">PTR</span></th>
                <th><span id="res_address_text">Residential Address</span>
                  <span id="res_address_select" style="display:none;">
                    <select id="ten" style="width:100px;">
                      @if(!empty($client_fields))
                        @foreach($client_fields as $key=>$field_row)
                        <option value="{{ $field_row->field_name }}-{{ $field_row->field_label }}" {{ ($field_row->field_name == 'res_address') ? 'selected':"" }} >{{ $field_row->field_label }}</option>
                        @endforeach
                      @endif
                    </select>
                  </span>
                </th>
                
                <th width="9%">Client Portal</th>
              
              </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
              @if(!empty($client_details))
              <?php $i=1; ?>
              @foreach($client_details as $key=>$client_row)
                <tr class="all_check" {{ ($client_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                  <td align="center">
                    <input type="checkbox" data-archive="{{ $client_row['show_archive'] }}" class="ads_Checkbox" name="client_delete_id[]" value="{{ $client_row['client_id'] or "" }}" id="client_delete_id"/>
                  </td>
                  <td align="center">{{ isset($client_row['dob'])?date("d-m-Y", strtotime($client_row['dob'])):"" }}</td>
                  <td align="left"><a href="/client/edit-ind-client/{{ $client_row['client_id'] }}/{{ base64_encode('ind_client') }}">{{ $client_row['client_name'] or '' }}</a></td>
                  <td align="left">
                    @if(isset($client_row['relationship']) && count($client_row['relationship']) >0 )
                      <select class="form-control newdropdown">
                      @foreach($client_row['relationship'] as $key=>$relation_row)
                        <option value="{{ $relation_row['client_id'] or "" }}">{{ $relation_row['name'] or "" }}</option>
                      @endforeach
                      </select>
                    @endif
                    
                  </td>
                  <td align="center">{{ (!empty($client_row['ni_number']))? $client_row['ni_number']: '' }}</td>
                  <td align="center">{{ (!empty($client_row['tax_reference']))? $client_row['tax_reference']: '' }}</td>
                  <td align="center">{{(isset($client_row['other_services']) && in_array(10, unserialize($client_row['other_services'])))?"Yes":"No"}}</td>

                  <td align="left">
                    @if(isset($client_row['address']) && $client_row['address'] != "" )
                    <span title="{{ $client_row['address'] }}">{{ $client_row['address'] or '' }}</span>
                    @endif
                  </td>
                  <td align="center">
                    <div id="after_send_{{ $client_row['client_id'] or '' }}">
                    @if(isset($client_row['invitation_status']) && $client_row['invitation_status'] == "Y" )
                         <button type="button" class="job_send_btn invited_popup" data-client_id="{{ $client_row['client_id'] or '' }}" data-send_type="single" data-client_type="ind" data-status="pending">PENDING</button>
                    @elseif(isset($client_row['invitation_status']) && $client_row['invitation_status'] == "N" )
                        <button type="button" class="job_send_btn invited_popup" data-client_id="{{ $client_row['client_id'] or '' }}" data-send_type="single" data-client_type="ind" data-status="invited">INVITED</button>
                    @else
                     <button type="button" class="job_send_btn invite_send_popup" data-client_id="{{ $client_row['client_id'] or '' }}" data-send_type="single" data-client_type="ind" data-status="invite">INVITE</button>
                    @endif
                    </div>
                  </td>
                </tr>
                <?php $i++; ?>
                @endforeach
                
              @endif
              
            </tbody>
          </table>
        </div> -->

      </div>
            
     </div>
      </div>
    </section>
               
            </aside>
        </div>
        
        
        
<!-- POP UP SECTION START -->
<div class="modal fade" id="invite_client-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title" id="pop_client_name"></h3>
        <div class="clearfix"></div>
      </div>
{{ Form::open(array('url' => '/user_process', 'files' => true)) }}
<input type="hidden" name="section" id="section" value="C">
<input type="hidden" name="client_id" id="client_id" value="">
<input type="hidden" name="user_type" id="user_type" value="C">

    <div class="modal-body" style="padding-top: 0px;">
      <div class="show_loader"></div>
      <div id="client_user_div">
        <div class="user_field">
          <div class="form-group">
            <label for="l_name">Email</label>
            <input type="text" placeholder="Email" id="client_email" name="client_email" class="form-control">
          </div>
        </div>

        <div class="user_field">
          <div class="form-group">
            <label for="email">Related Companies</label>
            <div class="clearfix"></div>
              <div class="client_chkbox show_org_client">
                <ul>
                    <!--<li>
                        <div class="job_checkbox"><span class="custom_chk">
                            <input type="checkbox" value="470" name="related_client[]" id="470">
                            <label for="470" style="width: 290px!important;margin-top: 0px;">
                            <a href="#" class="hover">ARAPSYS LIMITED</a></label></span>
                        </div>
                    </li>-->
                </ul>
             </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
        
    <div class="modal-footer">
        <button type="button" class="btn btn-info pull-left save_t invite_client" name="save">Invite to Client Portal</button>
        <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
    </div>
{{ Form::close() }}
  </div>
  </div>
</div>

<div class="modal fade" id="invited_send-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:60%;">
    <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <!--<h3 class="modal-title" id="pop_client_name"></h3>-->
          <div class="clearfix"></div>
        </div>
        <div class="modal-body" style="padding-top: 0px;">
          <div class="show_loader"></div>
            <div id="show_other_user_client">
              <table width="100%" class="table table-bordered table-hover dataTable" id="myOtherTable">
                <tr>
                  <td align="center"><strong>Email Address</strong></td>
                  <td align="center" width="15%"><strong>Password</strong></td>
                  <td align="center" width="20%"><strong>Related Organisations</strong></td>
                  <td align="center" width="10%"><strong>Status</strong></td>
                  <td align="center" width="15%"><strong>Remove Access</strong></td>
                </tr>
                <tr id="other_action_tr">
                  <!--<td align="center"></td>
                  <td align="center"></td>
                  <td align="center"><a href="#" data-target="#relation_client-modal" data-toggle="modal">View</a></td>
                  <td align="center"><a href="javascript:void(0)" data-user_id="{{ $user_id or "" }}" data-client_id="{{ $client_id or "" }}" class="active_t" data-status="A" id="client_user_status">Active</a></td>
                  <td align="center"><a href="javascript:void(0)" data-user_id="{{ $user_id or "" }}" data-client_id="{{ $client_id or "" }}" class="delete_invited_client"><img src="/img/cross.png" height="15"></a></td>-->
                </tr>
              </table>
           </div>
        </div>
        
    </div>
  </div>
</div>

<div class="modal fade" id="relation_pop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:25%;">
    <div class="modal-content">
        <div class="modal-header" style="border-bottom: none;">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h3 class="modal-title" id="pop_client_name">Related Organisations</h3>
          <div class="clearfix"></div>
        </div>
        <div class="modal-body" style="padding-top: 0px;">
          <div class="show_loader"></div>
          <div class="client_chkbox" id="show_related_div"><!-- Ajax Call --></div>
          <div class="clearfix"></div>
        </div>
    </div>
  </div>
</div>

<!-- Archive Organisation client Modal Start-->
<div class="modal fade" id="archive_client-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:20%;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <!-- <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div> -->
      </div>

    <div class="modal-body">
      <div class="show_loader"></div>
        <div class="form-group">
          <label for="name">Please selected one of the below :</label>
          <select class="form-control" name="archive_reason" id="archive_reason">
              <option value="1">Found a new Accounant</option>
              <option value="2">Involuntory Attrition</option>
              <option value="3">Other</option>
          </select>
        </div>
       
        <div class="modal-footer1 clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-warning" id="archiveClients" name="save">Archive</button>
            <!--<button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>-->
          </div>
        </div>
    </div>

  </div>
  </div>
</div>
<!-- Archive Organisation client Modal End-->

@stop