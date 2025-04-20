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

<!-- page script -->
<script type="text/javascript">

var oTable;

$(function() {
    oTable = $('#example2').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "aoColumns":[
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false}
        ]

    });
    oTable.fnSort( [ [1,'asc'] ] );

});

</script>
@stop

@section('content')
<input type="hidden" id="client_number" value="">
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
          <!-- <ul>
            <li>
            
           <button class="btn btn-success" onclick="pdforgclient();"><i class="fa fa-download" style=" padding-right: 4px;"></i>Generate PDF</button> 
           
            </li>
            <li>
            <button class="btn btn-primary" onclick="excelorgclient();"><i class="fa fa fa-file-text-o" ></i> Excel</button>
            </li>
            <li>
              <a class="btn btn-danger sync_jobs_data" href="javascript:void(0)">SYNC DATA</a>
            </li>
            <li>
                    
              <div class="import_fromch_main">
                <div class="import_fromch1">
                  <a href="/onboard" class="import_fromch_link">CLIENT ON-BOARDING</a>
                  <a href="javascript:void(0)" class="i_selectbox" id="select_onboard"><img src="/img/arrow_icon.png"></a>
                  <div class="clearfix"></div>
                </div>
               <div class="i_dropdown onopen_toggle" id="onboard_drop"><a href="#"></a>On-Board New Client</div>
              </div>
          
            </li>

            <div class="clearfix"></div>
          </ul> -->
        </div>
        <div id="message_div" style="margin-left: 700px;"><!-- Loader image show while sync data --></div>
        <div style="float: right; margin-right: 43px;">
          <!-- <table width="100%" border="0">
              <tr>
                <td>COMPANIES HOUSE </td>
                <td>&nbsp;</td>
                <td><a href="javascript:void(0)" class="btn btn-info autologin_button">AUTO LOGIN</a></td>
                <td>&nbsp;</td>
                <td><a class="btn btn-danger sync_jobs_data" href="javascript:void(0)">SYNC DATA</a></td>
                <td>&nbsp;</td>
                <td><a href="javascript:void(0)" class="btn btn-info webcheckButton">WEB CHECK</a></td>
              </tr>
            </table> -->
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
                  
                  
                  <div class="clearfix"></div>
                </ul>
              </div>
              <div class="top_search_con">
               <div class="top_bts">
                <ul style="padding:0;">
                  <li>
                    <a href="/upload" class="btn btn-info">Add New Document</a>
                  </li>
                  <div class="clearfix"></div>
                </ul>
              </div>
              </div>
              <div class="clearfix"></div>

            </div>
            
            <div class="box-body table-responsive">
            <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
            <table class="table table-bordered table-hover dataTable" id="example2">
              <input type="hidden" id="client_type" value="org"> 
                <thead>
                  <tr role="row">
                    <th>Date</th>
                    <th>Request Title</th>
                    <th>Document</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>

                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(!empty($client_details))
                        <?php $i=1; ?>
                        @foreach($client_details as $key=>$client_row)
                          <tr class="all_check">
                            <td align="center"></td>
                            <td align="left"></td>
                            <td align="left"></td>
                            <td align="center"></td>
                            <td align="center"></td>
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

@stop