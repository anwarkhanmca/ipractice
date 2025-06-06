@extends('layouts.layout')

@section('myjsfile')
    <script src="{{ URL :: asset('js/sites/users.js') }}" type="text/javascript"></script>
    
    
        <script type="text/javascript">
    
    $(function() {
        
        $('#pclient_id').on('change', function() {
            
            var clientid= $(this).val();
            console.log(clientid);
            //return false; // or $(this).val()
            
            
            	$.ajax({
		type: "POST",
		//dataType: "html",
		url: '/getmailid',
		data: {
			'clientid': clientid
		},
		success: function(resp) {
		  
          
          $('#client_email').val(resp);
          //console.log(resp);
		}
	});
            
            
});
        
    })
    
    </script>
@stop

@section('content')       
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    @include('layouts.inner_leftside')
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')
                
                <!-- Main content -->


{{ Form::open(array('url' => '/user_process', 'files' => true)) }}
<input type="hidden" name="section" value="U">
<section class="content">
<div class="row">
<div class="top_bts">
<ul>
<!-- <li><button type="button" class="btn btn-info"><i class="fa fa-print"></i> Print</button></li>
<li><button type="button" class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button></li>
<li><button type="button" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button></li>
<li><button type="button" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button></li> -->
<!-- <li><button class="btn btn-warning"><i class="fa fa-edit"></i> Add Client - Key In</button></li>
<li><button class="btn btn-success"><i class="fa fa-edit"></i> Improve CSV Or Excel</button></li>
<li><button class="btn btn-primary"><i class="fa fa-edit"></i> Import From CH </button></li>
<li><button class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button></li> -->
<div class="clearfix"></div>
</ul>
  
</div>
</div>


<div class="practice_mid">

<!-- <div class="row box_border5 row_cont">
 <div class="col-xs-12 col-xs-6 p_left">
 <h2 class="res_t">Add User  Details <small>General Settings</small></h2>
  </div>
 <div class="col-xs-12 col-xs-6">
 <div class="setting_con">
 <a href="/settings-dashboard" class="btn btn-success btn-lg"><i class="fa fa-cog fa-fw"></i>Settings</a>
 </div>
 </div>
 <div class="clearfix"></div>
</div> -->




<div class="tabarea">
    <div class="box-header">
      @if(Session::has('message'))
        <p style="color:#00a65a; font-size:15px;">{{ Session::get('message') }}</p>
      @endif
      
      @if(Session::has('error_msg'))
        <p style="color:red; font-size:15px;">{{ Session::get('error_msg') }}</p>
      @endif
      
      @if ( $errors->count() > 0 )
        <ul>
            @foreach( $errors->all() as $message )
              <li style="color:red; font-size:15px;">{{ $message }}</li>
            @endforeach
        </ul>
      @endif
        <!-- <h3 class="box-title">Access to the accounts</h3> -->  
        <h3 class="box-title">USER ACCESS LEVEL</h3>  
                                     
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">
    <!-- <p>Choose the user's level of access to this organisation's accounts:</p>  -->    

        <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
        <table class="table table-bordered table-hover dataTable" id="example2" style="margin-bottom: 10px;" aria-describedby="example2_info">
        <thead>
          <tr  role="row">
            <th align="center" class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending"></th>
            @if(!empty($access_list) && count($access_list) > 0)
              @foreach($access_list as $key=>$list)
                <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending" style="text-align: center;">{{ $list->access_name }}</th>
              @endforeach
            @endif
            <!-- <th align="center" class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">CRM</th>
            <th align="center" class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">JOBS</th>
            <th align="center" class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">SETTING</th>
            
            <th align="center" class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">STAFF MANAGEMENT</th>
            <th align="center" class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">MANAGE USERS</th> -->
          </tr>
        </thead>
                                        
                                        
        <tbody role="alert" aria-live="polite" aria-relevant="all">
        <tr class="odd">
          <td class="sorting_1">
            <div class="form-group"> 
              <div class="radio">
                <label>
                    <input type="radio" checked name="user_type" id="optionsRadios1" value="S" class="handle-change-user" data-type="staff">
                   STAFF
                </label>
              </div>
            </div>
          </td>

          @if(!empty($access_list) && count($access_list) > 0)
            @foreach($access_list as $key=>$list)
              <td align="center"><input type="checkbox" name="user_access[]" data-name="{{ $list->access_name }}" value="{{ $list->access_id }}" checked /></td>
            @endforeach
          @endif
        </tr>
        <tr class="even">
          <td class="sorting_1">
            <div class="radio">
            <label>
                <input type="radio" name="user_type" id="optionsRadios2" value="C" class="handle-change-user" data-type="client">
                CLIENT
            </label>
            </div>
          </td>
          <td class=" " align="center"></td>
          <td class=" " align="center"></td>
          <td class=" " align="center"></td>
          <td class=" " align="center"></td>
          <td class=" " align="center"></td>
        </tr>
      </tbody>
    </table>
              </div>
    </div><!-- /.box-body -->
                          
</div>

<h4>TASK MANAGEMENT</h4>

<div class="clearfix"></div>
      <div class="jobs_chkbox">
        <ul>
          @if(isset($permission_list) && count($permission_list) > 0)
            @foreach($permission_list as $key=>$list)
              <li><div class="job_checkbox"><label><input type="checkbox" value="{{ $list['service_id'] }}" name="permission[]" checked="checked" /> {{ $list['service_name'] or "" }}</label></div></li>
            @endforeach
          @endif

        </ul>
      </div>
      <div class="clearfix"></div>
      
<h4>USER DETAILS</h4>     
<div class="user_account" id="staff_user_div">
  <div class="user_ncon">
    <div class="form-group">
      <label for="f_name">First Name</label>
      <input type="text" placeholder="First Name" id="fname" name="fname" class="form-control">
    </div>
  </div>

  <div class="user_ncon">
    <div class="form-group">
      <label for="l_name">Last Name</label>
      <input type="text" placeholder="Last Name" id="lname" name="lname" class="form-control">
    </div>
  </div>

  <div class="user_ncon">
    <div class="form-group">
      <label for="email">Email</label>
      <input type="text" placeholder="Email" id="email" name="email" class="form-control">
    </div>
  </div>
  <div class="clearfix"></div>
</div>    
      
<div class="user_account" style="display: none;" id="client_user_div">
  <div class="user_ncon">
    <div class="form-group">
      <label for="f_name">Select Client</label>
      <select class="form-control get_relation_client" name="client_id" id="pclient_id">
        <option value="">-- Please Select --</option>
        @if(!empty($individual_client) && count($individual_client) > 0)
          @foreach($individual_client as $key=>$list)
            <option value="{{ $list['client_id'] }}">{{ $list['client_name'] }}</option>
          @endforeach
        @endif
      </select>
    </div>
  </div>

  <div class="user_ncon">
    <div class="form-group">
      <label for="l_name">Email</label>
      <input type="text" placeholder="Email" id="client_email" name="client_email" class="form-control">
    </div>
  </div>

  <div class="user_ncon">
    <div class="form-group">
      <label for="email">Related Companies</label>
      <div class="clearfix"></div>
        <div class="client_chkbox show_org_client">
          <ul>
            <!-- @if(!empty($relation_list) && count($relation_list) > 0)
              @foreach($relation_list as $key=>$list)
                <li><div class="job_checkbox"><label><input type="checkbox" value="{{ $list['client_id'] }}" name="related_client[]" />{{ $list['client_name'] }}</label></div></li>
              @endforeach
            @endif -->
          </ul>
        </div>
    </div>
  </div>
  <div class="clearfix"></div>
</div>     
      
      

<div class="row btn_row">
<div class="col-xs-12 col-xs-9 chk_cont">
<!-- <div class="checkbox allow_user">
<label>
<input type="checkbox"/>
<strong> Manage Users </strong> &nbsp;Allows this user to add remove users and change permissions
</label>                                                
</div> -->
<!-- <div class="checkbox">
<label>
                                               <input type="checkbox"/>
                                                    <strong> Payroll Admin</strong> You do not have permission to change this
                                                    </label>                                            
</div> -->   
 </div>
  <div class="col-xs-12 col-xs-3 chk_cont" style="margin-top: -20px;">
<div class="save_con">
  <button type="button" onClick="history.back(-1)" class="btn btn-danger" type="Save">Cancel</button>
  <button type="submit" class="btn btn-info" type="Save">Send</button>

</div>

 </div>
</div>

</div>


    </section><!-- /.content -->
{{ Form::close() }}
            </aside><!-- /.right-side -->
    
@stop