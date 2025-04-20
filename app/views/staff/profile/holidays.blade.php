@extends('layouts.layout')

@section('mycssfile')
    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
var Table1, Table2;
$(function() {
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
            {"bSortable": false},
            
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });
  Table1.fnSort( [ [2,'asc'] ] );

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
            {"bSortable": false},
            
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": false},
            {"bSortable": false},
            {"bSortable": false}
        ]

    });

   
   Table2.fnSort( [ [2,'asc'] ] );

});


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
        <form>
          <div class="top_buttons">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%"><div class="top_bts">
                    <ul>
                      <li>
                        <button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
                      </li>
                      <li>
                        <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button>
                      </li>
                      <li>
                        <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button>
                      </li>
                      <div class="clearfix"></div>
                    </ul>
                  </div></td>
                <td width="40%">&nbsp;</td>
                <td width="5%"><button class="btn btn-default" data-toggle="modal" data-target="#compose-modal"><span class="requ_t">New Task</span></button></td>
              </tr>
            </table>
          </div>
          <div class="tabarea">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
                <li class="active"><a data-toggle="tab" href="#tab_1">Pending Tasks</a></li>
                <li><a data-toggle="tab" href="#tab_2">Closed Task</a></li>
              </ul>
              <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                  <!--table area-->
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">


        <table class="table table-bordered table-hover dataTable" id="example1" aria-describedby="example1_info">
            
            <thead>
              <tr role="row">
                <th align="center"><input type="checkbox" id="allCheckSelect"/></th>
                <th align="center">Completion Date</th>
                <th align="center">Client Name</th>
                <th>Description</th>
                <th>Attachment</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
              <tr>
                <td align="center"><input type="checkbox" /></td>
                <td align="center">21-07-2015 10:00am</td>
                <td align="center"><a href="#">Anwar</a></td>
                <td align="center">20/07/2015</td>
                <td align="center"><a href="#"><img src="/img/attachment.png" width="15"></a></td>
                <td align="center">
                  <select class="form-control">
                    <option></option>
                  </select>
                </td>
                <td align="center"><a href="#"><img src="/img/edit_icon.png" width="15"></a></td>
              </tr>
              
            </tbody>
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
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
                          <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
            
            <thead>
              <tr role="row">
                <th><input type="checkbox" id="allCheckSelect"/></th>
                <th>Completion Date</th>
                <th>Client Name</th>
                <th>Description</th>
                <th>Attachment</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
              <tr>
                <td align="center"><input type="checkbox" /></td>
                <td align="center">21-07-2015 10:00am</td>
                <td align="center"><a href="#">Anwar</a></td>
                <td align="center">20/07/2015</td>
                <td align="center"><a href="#"><img src="/img/attachment.png" width="15"></a></td>
                <td align="center">
                  <select class="form-control">
                    <option></option>
                  </select>
                </td>
                <td align="center"><a href="#"><img src="/img/edit_icon.png" width="15"></a></td>
              </tr>
              
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
        </form>
      </div>
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>


<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      
      <form action="#" method="post">
        <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <table width="100%" border="0" class="staff_holidays">
            <tr>
              <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><strong>New Task</strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>Select Staff</td>
                    <td>Select Client</td>
                  </tr>
                  <tr>
                    <td>Urgent?</td>
                    <td><input type="radio">
                      Yes</td>
                    <td><input type="radio">
                      No</td>
                    <td><select class="form-control">
                        <option>efeq </option>
                        <option>rewgr </option>
                        <option>ergre rg</option>
                        <option>erg eragerg</option>
                      </select></td>
                    <td><select class="form-control">
                        <option>efeq </option>
                        <option>rewgr </option>
                        <option>ergre rg</option>
                        <option>erg eragerg</option>
                      </select></td>
                  </tr>
                </table></td>
            </tr>
            <tr>
              <td valign="top"><table width="100%" class="table table-bordered">
                  <tbody>
                    <tr>
                      <td align="center">&nbsp;</td>
                      <td align="center"><strong>Completion date and time</strong></td>
                      <td align="center"><strong>Attachment</strong></td>
                      <td align="center"><strong>Description</strong></td>
                    </tr>
                    <tr>
                      <td><a href="#"><img src="/img/cross_icon.png" /></a></td>
                      <td align="center"><select class="form-control">
                          <option>21/08/2015 10:00am</option>
                          <option>22/08/2015 10:00am</option>
                          <option>23/08/2015 10:00am</option>
                          <option>24/08/2015 10:00am</option>
                        </select></td>
                      <td align="center"><a href="#"><img src="/img/attachment.png" height="20" /></a></td>
                      <td align="center"><input type="text" id="" class="form-control"></td>
                    </tr>
                    <tr>
                      <td><a href="#"><img src="/img/cross_icon.png" /></a></td>
                      <td align="center"><select class="form-control">
                          <option>21/08/2015 10:00am</option>
                          <option>22/08/2015 10:00am</option>
                          <option>23/08/2015 10:00am</option>
                          <option>24/08/2015 10:00am</option>
                        </select></td>
                      <td align="center"><a href="#"><img src="/img/attachment.png" height="20" /></a></td>
                      <td align="center"><input type="text" id="" class="form-control"></td>
                    </tr>
                    <tr>
                      <td><a href="#"><img src="/img/cross_icon.png" /></a></td>
                      <td align="center"><select class="form-control">
                          <option>21/08/2015 10:00am</option>
                          <option>22/08/2015 10:00am</option>
                          <option>23/08/2015 10:00am</option>
                          <option>24/08/2015 10:00am</option>
                        </select></td>
                      <td align="center"><a href="#"><img src="/img/attachment.png" height="20" /></a></td>
                      <td align="center"><input type="text" id="" class="form-control"></td>
                    </tr>
                  </tbody>
                </table></td>
            </tr>
          </table>
          <div class="save_btncon">
            <div class="left_side">
              <button class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i>
              <p class="add_line_t">Add new line</p>
              </button>
            </div>
            <div class="right_side">
              <button class="btn btn-success">Submit for Approval</button>
            </div>
            <div class="clearfix"></div>
          </div>
          
          </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
@stop
<!--staff -->