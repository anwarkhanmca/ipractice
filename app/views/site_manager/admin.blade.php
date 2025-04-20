@extends('layouts.layout')

@section('mycssfile')
<link href="/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<style type="text/css">
  .message{font-size: 16px;}
</style>
@stop

@section('myjsfile')
<!-- DATA TABES SCRIPT -->
<script src="/js/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

<script src="/js/site_manager.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
  $('#example').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[10, 50, 100, 200], [10, 50, 100, 200]],
    "iDisplayLength": 50,
    "language": {
      "lengthMenu": "Show _MENU_ entries",
      "zeroRecords": "Nothing found - sorry",
      "info": "Showing page _PAGE_ of _PAGES_",
      "infoEmpty": "No records available",
      "infoFiltered": "(filtered from _MAX_ total records)"
    },
    "aaSorting": [[0, 'asc']],
    "aoColumns":[
      /*{"bSortable": true},*/
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": false}
    ]
  });

  $('#example4').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[10, 50, 100, 200], [10, 50, 100, 200]],
    "iDisplayLength": 50,
    "language": {
      "lengthMenu": "Show _MENU_ entries",
      "zeroRecords": "Nothing found - sorry",
      "info": "Showing page _PAGE_ of _PAGES_",
      "infoEmpty": "No records available",
      "infoFiltered": "(filtered from _MAX_ total records)"
    },
    "aaSorting": [[5, 'desc']],
    "aoColumns":[
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": false}
    ]
  });



});
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
    
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs nav-tabsbg">
        <li class="{{ ($page_open == 1)?'active':'' }}"><a href="/admin/1">Users</a></li>
        <li class="{{ ($page_open == 2)?'active':'' }}"><a href="/admin/2">Pricing</a></li>
        <li class="{{ ($page_open == 3)?'active':'' }}"><a href="/admin/3">Paypal</a></li>
        <li class="{{ ($page_open == 4)?'active':'' }}"><a href="/admin/4">Problems</a></li>
        <li class="{{ ($page_open == 5)?'active':'' }}"><a href="/admin/5">Suggestion box</a></li>
        <li class="{{ ($page_open == 6)?'active':'' }}"><a href="/admin/6">Contact us</a></li>
        <!--<li><a href="#" class=" btn-block btn-primary " data-toggle="modal" data-target="#compose-modal"><i class="fa fa-plus"></i> New Field </a></li>-->
      </ul>
<div class="tab-content">

<div id="tab_1" class="tab-pane  {{ ($page_open == 1)?'active':'' }}">
  <h1>Users</h1>
  <div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
      <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <table class="table table-bordered table-hover dataTable" id="example" width="100%">
            <thead>
              <tr role="row">
                <!-- <td align="center" width="5%"><strong>ID</strong></td> -->
                <td align="left"><strong>Subscriber</strong></td>
                <td align="left" width="12%"><strong>Staff User</strong></td>
                <td align="left" width="12%"><strong>Client User</strong></td>
                <td align="left"><strong>Practice Name</strong></td>
                <td align="left"><strong>Phone</strong></td>
                <td align="left"><strong>Date Registered</strong></td>
                <td align="left"><strong>Website Address</strong></td>
                <td align="left" width="10%"><strong>Package Name</strong></td>
                <td align="left" width="5%"><strong>Action</strong></td>
              </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(isset($users) && count($users) >0)
              @foreach($users as $key=>$user_row)
              <tr class="user_{{ $user_row['user_id'] or '' }}">
                <!-- <td align="center">{{ $user_row['user_id'] or "" }}</td> -->
                <td align="left">{{ $user_row['email'] or "" }}</td>
                <td align="left">
                <select class="form-control newdropdown getStaffDetails" data-user_type="S">
                  <option value="">-- Select --</option>
                  @if(!empty($user_row['groupStaffs']))
                    @foreach($user_row['groupStaffs'] as $key=>$staffs)
                      <option value="{{ $staffs['user_id'] or '' }}">{{ $staffs['email'] or '' }}</option>
                    @endforeach
                  @endif
                </select>
                </td>
                <td align="left">
                  <select class="form-control newdropdown getStaffDetails" data-user_type="C">
                    <option value="">-- Select --</option>
                    @if(!empty($user_row['groupclients']))
                      @foreach($user_row['groupclients'] as $key=>$staffs)
                        <option value="{{ $staffs['user_id'] or '' }}">{{ $staffs['email'] or '' }}</option>
                      @endforeach
                    @endif
                </select>
                </td>
                <td align="left">{{ $user_row['practice_name'] or "" }}</td>
                <td align="left">{{ $user_row['phone'] or "" }}</td>
                <td align="left">{{ (isset($user_row['created']) && $user_row['created'] != "")?date('d-m-Y', strtotime($user_row['created'])):'' }}</td>
                <td align="left">{{ $user_row['website'] or "" }}</td>
                <td align="left">&nbsp;</td>
                <td align="center"><a href="javascript:void(0)" title="Delete ?" class="delete_user" data-user_id="{{ $user_row['user_id'] or "" }}"><img src="/img/cross.png" width="12"></a></td>
              </tr>
              @endforeach
            @endif
            </tbody>
          </table>

        <!--end table-->
      </div>
    </div>
  </div>
</div>
</div>

<div id="tab_2" class="tab-pane {{ ($page_open == 2)?'active':'' }}">
  <h1>Pricing</h1>
</div>

<div id="tab_3" class="tab-pane {{ ($page_open == 3)?'active':'' }}">
  <h1>Paypal Settings</h1>
  <div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
      <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <div class="message"></div>
          <form action="" method="post" name="paypal_form">
          <table>
            <tr role="row">
              <td align="left" width="20%"><strong>Paypal Server:</strong></td>
              <td align="left">
                <div style="width:147px; margin:5px 0 5px 0;">
                  <select id="server" class="form-control">
                    <option value="S" {{ (isset($paypal_details['server']) && $paypal_details['server'] == 'S')?'selected':'' }}>Sandbox</option>
                    <option value="L" {{ (isset($paypal_details['server']) && $paypal_details['server'] == 'L')?'selected':'' }}>Live</option>
                  </select> 
                </div>
              </td>
            </tr>
            <tr role="row">
              <td align="left"><strong>Paypal Email:</strong></td>
              <td align="left">
                <input type="text" id="email" name="email" class="form-control" style="width:250px; margin:5px 0 5px 0;" value="{{ $paypal_details['email'] or ''}}">
              </td>
            </tr>
            <tr role="row">
              <td align="left"><strong>Price Per Client:</strong></td>
              <td align="left">
                <input type="text" id="price" name="price" class="form-control" style="width:147px; margin:5px 0 5px 0;" value="{{ $paypal_details['perclient_price'] or ''}}">
              </td>
            </tr>

            <tr role="row">
              <td align="left">&nbsp;</td>
              <td align="left">
                <button type="button" id="update_paypal" class="btn btn-info">Update</button>
                <input type="reset" class="btn btn-danger" value="Reset">
              </td>
            </tr>
          </table>
          </form>
        <!--end table-->
      </div>
    </div>
  </div>
</div>
      
      
      
      <!-- /.tab-pane -->
    </div>


<div id="tab_4" class="tab-pane {{ ($page_open == 4 || $page_open == 5 || $page_open == 6)?'active':'' }}">
  <div class="box-body table-responsive">
    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
      <div class="row">
        <div class="col-xs-6"></div>
        <div class="col-xs-6"></div>
      </div>
      <div class="row">
        <div class="col-xs-12">
          <table class="table table-bordered table-hover dataTable" id="example4" aria-describedby="example_info">
            <thead>
              <tr role="row">
                <td align="left" width="20%"><strong>Email</strong></td>
                <td align="left" width="20%"><strong>Name</strong></td>
                <td align="left" width="20%"><strong>Telephone</strong></td>
                <td align="left"><strong>Message</strong></td>
                <td align="left" width="5%"><strong>Attachment</strong></td>
                <td align="left" width="10%"><strong>Date</strong></td>
                <td align="left" width="5%"><strong>Action</strong></td>
              </tr>
            </thead>
            <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(isset($contact_reports) && count($contact_reports) >0)
              @foreach($contact_reports as $key=>$report_row)
                
                <input type="hidden" id="notesMsg_{{ $report_row['report_id'] or "" }}" value="{{ $report_row['description'] or "" }}">
                <tr class="user_{{ $report_row['report_id'] or "" }}">
                  <td align="left">{{ $report_row['email'] or "" }}</td>
                  <td align="left">{{ $report_row['name'] or "" }}</td>
                  <td align="left">{{ $report_row['phone'] or "" }}</td>
                  <td align="left">
                    <a href="javascript:void(0)" class="open_message" data-report_id="{{ $report_row['report_id'] or "" }}"><span class="notes_btn">Messages</span></a> &nbsp; 
                    @if($report_row['is_view'] == 'N')
                    <a href="javascript:void(0)" class="new_msg_{{ $report_row['report_id'] or "" }}"><span style="color: orange">New!</span></a>
                    @endif

                  </td>
                  <td align="center">
                    @if( isset($report_row['file']) && $report_row['file'] != "" )
                      <a href="/uploads/reports/{{ $report_row['file'] or '' }}" target="_blank" download>
                        <img src="/img/attachment.png" width="15">
                      </a>
                    @endif
                  </td>
                  <td align="center">{{ (isset($report_row['created']) && $report_row['created'] != "")?date('d-m-Y', strtotime($report_row['created'])):'' }}</td>
                  <td align="center"><a href="javascript:void(0)" title="Delete ?" class="delete_report" data-report_id="{{ $report_row['report_id'] or "" }}"><img src="/img/cross.png" width="12"></a></td>
                </tr>

              @endforeach
            @endif
            </tbody>
          </table>

          <!--end table-->
        </div>
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


<!-- =================== Modal Start ================== -->
<div class="modal fade" id="open_message-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <!-- <h4 class="modal-title" id="contact_title">Report a Problem</h4> -->
          <div class="clearfix"></div>
        </div>

        <div class="modal-body" style="padding-top: 0px;">
        <div class="col-md-12">
          <label for="exampleInputPassword1">Subject</label>
          <input type="text" id="subjectPop" name="field_email" class="form-control">
        </div>

        <div class="col-md-12">
          <label for="exampleInputPassword1">Notes</label>
          <textarea rows="4" class="form-control" name="notesMsg" id="notesMsg" ></textarea>
        </div>
            
          
          <div class="modal-footer" style="border-top: none; padding-right: 13px;">
            <!-- <div class="email_btns">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-info save_contact_form" name="save">Send</button>
            </div> -->
          </div>
        </div>

    </div>
  </div>
</div>


<!-- <div class="modal fade" id="open_message-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">
      <div class="modal-body">
        <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>

        
        <div class="col-md-12" style="width:100%;">
          <label for="f_name" style="font-size: 18px;">Notes</label>
          <textarea rows="4" cols="52" class="form-control" name="notesMsg" id="notesMsg" ></textarea>
          <div class="clr"></div>       
        </div>
        </div>
    </div>
  </div>
</div> -->

@stop
<!--staff -->