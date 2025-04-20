@extends('layouts.layout')

@section('mycssfile')
    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/webcheck.js') }}" type="text/javascript"></script>

<!-- jTable -->
<script src="{{ URL :: asset('js/jtablejs/client_lists.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">

function pdforgclient(){
  var search_value = $("#example2_filter input").val();
  if(search_value!= ""){
     var search = search_value;        
  }else{
      var search = "NONE";
  }
  window.location.href = '/orgpdf/'+search+'/pdf';
  return false;
}
function excelorgclient(){
  var search_value = $("#example2_filter input").val();
  if(search_value!= ""){
    var search = search_value;        
  }else{
    var search = "NONE";
  }
  var hiturl ='/orgpdf/'+search+'/excel'
  window.location.href = hiturl;
  console.log(hiturl);return false;
}



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
        "aoColumns":[
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": true},
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
    oTable.fnSort( [ [3,'asc'] ] );

});*/

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
<input type="hidden" id="client_number" value="">
<input type="hidden" id="client_type" value="org"> 

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
              <button class="btn btn-success" onclick="pdforgclient();"><i class="fa fa-download" style=" padding-right: 4px;"></i>Generate PDF</button> 
            </li>
            <li>
            <button class="btn btn-primary" onclick="excelorgclient();"><i class="fa fa fa-file-text-o" ></i> Excel</button>
            </li> -->
            <!-- <li>
              <a class="btn btn-danger sync_jobs_data" href="javascript:void(0)">SYNC DATA</a>
            </li> -->

            <li style="margin-right: 40px;">
       
         <!--   <div class="import_fromch_main">
                      <div class="import_fromch">
                        <a href="/onboard" class="import_fromch_link1">ON-BOARD NEW CLIENT</a>
                        <a href="javascript:void(0)" class="i_selectbox" id="select_onboard"><img src="/img/arrow_icon.png"></a>
                        <div class="clearfix"></div>
                      </div>
                      <div class="i_dropdown onopen_toggle" id="onboard_drop"><a href="#"></a>MOVE TO ONBOARD</div>
                    </div> -->
                    
              <div class="import_fromch_main">
                <div class="import_fromch1">
                  <a href="/onboard" class="import_fromch_link">CLIENT ON-BOARDING</a>
                  <a href="javascript:void(0)" class="i_selectbox" id="select_onboard"><img src="/img/arrow_icon.png"></a>
                  <div class="clearfix"></div>
                </div>
               <div class="i_dropdown onopen_toggle" id="onboard_drop"><a href="#"></a>On-Board New Client</div>
              </div>
            </li>

            <li>
              <a href="/hmrc/emails" class="btn btn-info">HMRC Structured Emails</a>
            </li>
            <li>
              <a href="/hmrc/tool" class="btn btn-info">HMRC Calculators</a>
            </li>

            <!-- <li>
              <button type="button" id="deleteClients" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
            </li> -->
            <!-- <li>
              <button class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button>
            </li> -->
            

            <div class="clearfix"></div>
          </ul>
        </div>
        <div id="message_div" style="margin-left: 700px;"><!-- Loader image show while sync data --></div>
        <div style="float: right; margin-right: 43px;">
          <table width="100%" border="0">
              <tr>
                <td>COMPANIES HOUSE </td>
                <td>&nbsp;</td>
                <td><a href="javascript:void(0)" class="btn btn-info autologin_button">AUTO LOGIN</a></td>
                <td>&nbsp;</td>
                <td><a class="btn btn-danger sync_jobs_data" href="javascript:void(0)">SYNC DATA</a></td>
                <td>&nbsp;</td>
                <td><a href="javascript:void(0)" class="btn btn-info webcheckButton">WEB CHECK</a></td>
              </tr>
            </table>
        </div>

      </div>
      <div class="practice_mid">
        <form>
          <!--<div class="row box_border2 row_cont">
 <div class="col-xs-12 col-xs-6 p_left">
 <h2 class="res_t">USERS <small>General Settings</small></h2>

 </div>
 <div class="col-xs-12 col-xs-6">
 <div class="setting_con">
 <button class="btn btn-success btn-lg"><i class="fa fa-cog fa-fw"></i>Settings</button>
 </div>
 </div>
 <div class="clearfix"></div>
</div>-->
          <!--<div class="add_usercon">
<p><a href="#">What's this?</a></p>
<button class="btn btn-success"><i class="fa fa-edit"></i> Add User</button>
</div>-->
          <div class="tabarea">
            <div class="tab_topcon">
              <div class="top_bts" style="float:left; width:700px;">
                <ul style="padding:0; width:700px;">
                  <!-- <li>
                    <a href="javascript:void(0)" id="deletePopup" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</a>
                  </li> -->
                  <li>
                    <a href="/organisation/add-client" class="btn btn-info">+ CLIENT - KEY IN</a>
                  </li>
                  <li>
                    <div class="import_fromch_main">
                      <div class="import_fromch" style="width:190px;">
                        <a href="/import-from-ch/{{ base64_encode('org_list') }}" class="import_fromch_link"> IMPORT COMPANY/LLP</a>
                        <a href="javascript:void(0)" class="i_selectbox" id="select_icon"><img src="/img/arrow_icon.png"></a>
                        <div class="clearfix"></div>
                      </div>
                      <div class="i_dropdown open_toggle"><a href="/chdata/bulk-company-upload-page/{{ base64_encode('org_list') }}">BULK COMPANY UPLOAD</a></div>
                    </div>


                    <!-- <div class="import_fromch">
                      <a href="/import-from-ch/{{ base64_encode('org_list') }}" class="import_fromch_link">IMPORT FROM CH</a>
                      <a href="/chdata/bulk-company-upload-page/{{ base64_encode('org_list') }}" class="i_selectbox"><img src="img/arrow_icon.png" /></a>
                    </div> -->
                    <!-- <a href="/import-from-ch/{{ base64_encode('org_list') }}" class="btn btn-info">IMPORT FROM CH</a> -->
                  </li>
                  <li></li>
                  <li></li>
                  
                  <li>
                  <!-- <a href="/orgunicorporated" class="btn btn-info">IMPORT - UNINCORPORATED</a> -->
                  <a href="/chdata/bulk-company-upload-page/{{ base64_encode('org_unin') }}" class="btn btn-info">IMPORT - UNINCORPORATED</a>
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
                    <a href="javascript:void(0)" id="deletePopup" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</a>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              </div>
              <div class="clearfix"></div>

            </div>
            
<div class="box-body table-responsive">
  @include('home/include/client_lists')
  <!-- <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
    <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
      
        <thead>
            <tr role="row">
                <th><input type="checkbox" id="allCheckSelect"/></th>
                <th>Business Type</th>
                <th>CRN</th>
                <th>Business Name</th>
                <th>Year End</th>
                <th>Accounts</th>
                <th>Confirmation Statement</th>
                <th>Tax reference</th>
                <th>Vat number</th>
                <th>VAT Stagger</th>
                <th>Correspondence Address</th>
            </tr>
        </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(!empty($client_details))
                <?php $i=1; ?>
                @foreach($client_details as $key=>$client_row)
                  <tr class="all_check" {{ ($client_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                    <td align="center">
                      <input type="checkbox" data-archive="{{ $client_row['show_archive'] }}" class="for_autologin ads_Checkbox" name="client_delete_id[]" value="{{ $client_row['client_id'] or "" }}" data-client_number="{{ $client_row['registration_number'] or "" }}" />

                      <input type="hidden" id="clnt_no_{{ $client_row['client_id'] or '' }}" value="{{ $client_row['registration_number'] or "" }}">
                    </td>
                    <td align="center">{{ isset($client_row['business_type'])?$client_row['business_type']:"" }}</td>
                    <td align="center"><a href="/chdata-details/{{ $client_row['registration_number'] or '' }}">{{ $client_row['registration_number'] or "" }}</a></td>
                    <td align="left"><a href="/client/edit-org-client/{{ $client_row['client_id'] }}/{{ base64_encode('org_client') }}">{{ isset($client_row['business_name'])?$client_row['business_name']:"" }}</a></td>
                    <td align="center">{{ $client_row['acc_ref_day'] or "" }}-{{ $client_row['ref_month'] or "" }}</td>
                    <td align="center">
                      @if( isset($client_row['deadacc_count']) && ($client_row['deadacc_count'] == "OVER DUE" || $client_row['deadacc_count'] <= 0 ) )
                        <span style="color:red">{{ $client_row['deadacc_count'] or "" }}</span>
                      @else
                         {{ $client_row['deadacc_count'] or "" }}
                      @endif
                    </td>
                    <td align="center">
                      @if( isset($client_row['deadret_count']) && ($client_row['deadret_count'] == "OVER DUE" || $client_row['deadret_count'] <= 0 ))
                        <span style="color:red">{{ $client_row['deadret_count'] or "" }}</span>
                      @else
                         {{ $client_row['deadret_count'] or "" }}
                      @endif
                    </td>
                    <td align="center">{{ isset($client_row['tax_reference'])?$client_row['tax_reference']:"" }}</td>
                    <td align="center">{{ isset($client_row['vat_number'])?$client_row['vat_number']:"" }}</td>
                    <td align="center">{{ $client_row['vat_stagger'] or "" }}</td>
                    <td align="left">{{ (isset($client_row['corres_address']) && strlen($client_row['corres_address']) > 48)? substr($client_row['corres_address'], 0, 45)."...": isset($client_row['corres_address'])?$client_row['corres_address']:'' }}</td>
                  </tr>
                <?php $i++; ?>
              @endforeach
            @endif
          
          
        </tbody>
      </table>

        </div> -->
    </div>
            
            
            

            
                      
                      
          </div>
        </form>
      </div>
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
        
        
<!-- Delete Organisation client Modal Start-->
<div class="modal fade" id="delete_client-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:20%;">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom: none;">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <!-- <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div> -->
      </div>

    <div class="modal-body">
        <div class="form-group">
          <label for="name">Please selected one of the below :</label>
          <select class="form-control" name="deleted_type" id="deleted_type">
              <option value="1">Found a new Accounant</option>
              <option value="2">Involuntory Attrition</option>
              <option value="3">Other</option>
          </select>
        </div>
       
        <div class="modal-footer1 clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-danger" id="deleteClients" name="save">Delete</button>
            <!--<button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>-->
          </div>
        </div>
    </div>

  </div>
  </div>
</div>
<!-- Delete Organisation client Modal End-->


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