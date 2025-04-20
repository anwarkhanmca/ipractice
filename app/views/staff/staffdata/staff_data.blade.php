@extends('layouts.layout') 
@section('mycssfile')
  <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/sites/users.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('js/jtablejs/user_lists.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
/*var Table1;
$(function() {
  Table1 = $('#example1').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[90], [90]],
    "iDisplayLength": 90,
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
      {"bSortable": false},
      {"bSortable": false},
      {"bSortable": false}
    ]

  });
  Table1.fnSort( [ [1,'asc'] ] );
});*/
</script>
@stop

@section('content')
 <div class="wrapper row-offcanvas row-offcanvas-left">
    <aside class="left-side sidebar-offcanvas {{ $left_class }}">
      <section class="sidebar">
        @include('layouts/inner_leftside')
      </section>
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
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
              <button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
            </li>
            <li>
           <!--   <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button> -->
         
           <a href="/staffpdf/{{"NONE"}}" class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</a>
         
            </li>
            <li>
             <!-- <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button> -->
              <a href="/staffexcel" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</a>
              
            </li>
            <li>
              <a href="/add-user" class="btn btn-info"><!--<i class="fa fa fa-file-text-o"></i>--> Invite Staff User</a>
            </li>
            
            <div class="clearfix"></div>
          </ul>
        </div>

        <div class="top_search_con">
          <div class="top_bts">
            <ul style="padding:0;">
              <li>
                <button type="button" id="archivedButton" class="btn btn-warning">Archive</button>
              </li>
              <li>
                <?php $value = Session::get('show_staff_archive');?>
                <a href="javascript:void(0)" id="archive_div">
                  {{ (isset($value) && $value == "Y") ? "Show Archived":"Hide Archived" }}</a>
              </li>
              <div class="clearfix"></div>
            </ul>
          </div>
        </div>
        <div class="clearfix"></div>

      </div>
      <div class="tabarea">

        <div class="row">
          <div class="col-xs-12">
              <div class="row bottom_space">
                <div class="col-xs-offset-6 col-xs-6">
                  <div id="example2_filter" class="dataTables_filter">
                    <form>
                      <input type="text" name="userListsSearchText" id="userListsSearchText" placeholder="Search" class="tableSearch" />
                      <button type="submit" id="userListsSearchButton" style="display:none;">Search</button>
                    </form>
                  </div>
                </div>
              </div>
              <div id="userListsTable"></div>
          </div>
        </div>

        <!-- <table class="table table-bordered table-hover dataTable" id="example1" width="100%">
          <thead>
            <tr role="row">
              <th width="3%"><input type="checkbox" id="allCheckSelect"/></th>
              <th width="15%"><strong>Staff Name</strong></th>
              <th width="12%"><strong>Position/Job Title</strong></th>
              <th width="8%"><strong>Date Joined</strong></th>
              <th width="10%"><strong>Ni Number</strong></th>
              <th width="10%"><strong>DOB</strong></th>
              <th width="10%"><strong>Department</strong></th>
              <th><strong>Address</strong></th>
            </tr>
          </thead>

          <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if( isset($staff_details) && count($staff_details) >0 )
              @foreach($staff_details as $key=>$value)
              <tr class="all_check" {{ ($value['show_archive']=="Y")?'style="background:#ccc"':"" }}>
                <td><input type="checkbox" data-archive="{{ $value['show_archive'] }}" class="ads_Checkbox" name="staff_delete_id[]" value="{{ $value['user_id'] }}"></td>
                <td align="left"><a href="/my-details/{{ $value['user_id'] }}/{{ base64_encode('staff') }}">{{ $value['fname'] or "" }} {{ $value['lname'] or "" }}</a></td>
                <td align="left">{{ $value['position_name'] or "" }}</td>
                <td align="left">{{ isset($value['step_data']['start_date'])?date("d-m-Y", strtotime($value['step_data']['start_date'])):"" }}</td>
                <td>{{ $value['step_data']['ni_number'] or "" }}</td>
                <td>{{ $value['step_data']['dob'] or "" }}</td>
                <td align="left">{{ $value['department_name'] or "" }}</td>
                <td align="left">{{ $value['fulladdress'] }}</td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table> -->
      </div>
        
      </div>
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>
<!-- ./wrapper -->
<!-- popup content -->
<!-- add new calendar event modal -->
<!--start popup-->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">INVITE STAFF</h4>
        <div class="clearfix"></div>
      </div>
      <form action="#" method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputPassword1">Name</label>
            <input type="text" id="" class="form-control">
          </div>
          <div class="twobox">
            <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Start Date</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>
            <div class="twobox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Holiday Entitlement</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Residential Address</label>
            <input type="text" id="" class="form-control">
          </div>
          <div class="form-group">
            <!--<label for="exampleInputPassword1">Residential Address</label>-->
            <input type="text" id="" class="form-control">
          </div>
          
          <div class="form-group">
            <div class="n_box2">
            <label for="exampleInputPassword1">Post Code</label>
            <input type="text" id="" class="form-control">
            </div>
            <div class="n_box2">
            <label for="exampleInputPassword1">Date of Birth</label>
              <input type="text" id="" class="form-control">
            </div>
            <div class="n_box2" style="margin-right:0;">
            <label for="exampleInputPassword1">NINO</label>
              <input type="text" id="" class="form-control">
            </div>
            
            <div class="clearfix"></div>
          </div>
          
          <div class="form-group">
            <label for="exampleInputPassword1">Bank Name</label>
            <input type="text" id="" class="form-control">
          </div>
          
          <div class="form-group">
            <label for="exampleInputPassword1">Sort Code</label>
            <div class="clearfix"></div>
            <div class="n_box2">
             <input type="text" id="" class="form-control">
            </div>
            <div class="n_box2">
              <input type="text" id="" class="form-control">
            </div>
            <div class="n_box2" style="margin-right:0;">
              <input type="text" id="" class="form-control">
            </div>
            
            <div class="clearfix"></div>
          </div>
          
          <div class="twobox">
            <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Account Number</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>
            <div class="twobox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Mobile Number</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          
          <div class="twobox">
            <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>
            <div class="twobox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Salary</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          
          <div class="twobox">
            <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Leaving Date</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>
            <div class="twobox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Qualifications</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          
          <div class="twobox">
            <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Department</label>
                <select class="form-control">
                <option>wqdwqd</option>
                <option>weqfewqf</option>
              </select>
              </div>
            </div>
            <div class="twobox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Emergency Contact Name</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
          
          <div class="twobox">
            <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Emergency Contact Tel</label>
               <input type="text" id="" class="form-control">
              </div>
            </div>
            <!--<div class="twobox_2">
              <div class="form-group">
                <label for="exampleInputPassword1">Emergency Contact Name</label>
                <input type="text" id="" class="form-control">
              </div>
            </div>-->
            <div class="clearfix"></div>
          </div>
          
          <div class="form-group">
          <h3 class="box-title">Documents</h3>
            <div class="n_box2">
            <div class="form-group">
                <label for="exampleInputPassword1" class="label_width">CV</label>
               <button class="btn btn-success"><i class="fa fa-download"></i> Download</button>
              </div>
            </div>
            <div class="n_box2">
            <div class="form-group">
                <label for="exampleInputPassword1" class="label_width">ID</label>
               <button class="btn btn-success"><i class="fa fa-download"></i> Download</button>
              </div>
            </div>
            
            <div class="n_box2" style="margin-right:0;">
            <div class="form-group">
               <label for="exampleInputPassword1" class="label_width">Employment Contract</label>
               <button class="btn btn-success"><i class="fa fa-download"></i> Download</button>
              </div>
            </div>
            
            <div class="clearfix"></div>
          </div>
           <div class="clearfix"></div>
                        
                            
    
          
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!--end popup-->

@stop
<!-- staff-->