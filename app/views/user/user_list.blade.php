@extends('layouts.layout')

@section('myjsfile')
<script src="{{ URL :: asset('js/sites/users.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
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
<!-- {{ Form::open(array('url' => '/delete-users', 'files' => true)) }} -->                 
<section class="content">
<div class="row">
<div class="top_bts">
<ul>
<!-- <li><button class="btn btn-info" onClick="javascript:printDiv('printArea')"><i class="fa fa-print"></i> Print</button></li> -->
<li><a href="/pdf" class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</a></li>
<li><a href="/download/downloadExcel" class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</a></li>
<!-- <li><a href="javascript:void(0)" id="deleteUsers" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</a></li>
<li><button class="btn btn-warning"><i class="fa fa-edit"></i> Add Client - Key In</button></li>
<li><button class="btn btn-success"><i class="fa fa-edit"></i> Improve CSV Or Excel</button></li>
<li><button class="btn btn-primary"><i class="fa fa-edit"></i> Import From CH </button></li> 
<li><button class="btn btn-warning"><i class="fa fa-edit"></i> Edit</button></li>-->
<div class="clearfix"></div>
</ul>
  
</div>
</div>


<div class="practice_mid">
<form>
<div class="row box_border6 row_cont">
 <div class="col-xs-12 col-xs-6 p_left">
 <!-- <h2 class="res_t">USERS <small>General Settings</small></h2> -->

 </div>
 <div class="col-xs-12 col-xs-6">
 <div class="setting_con">
 <!-- <a href="/settings-dashboard" class="btn btn-success btn-lg"><i class="fa fa-cog fa-fw"></i>Settings</a>  -->
 </div>
 </div>
 <div class="clearfix"></div>
</div>
@if(Session::has('message'))
    <p style="color:#00a65a; font-size:15px;">{{ Session::get('message') }}</p>
@endif

<div class="add_usercon">
@if(isset($access['mu']) && $access['mu'] == 1)
<a href="/add-user" class="btn btn-success"><i class="fa fa-edit"></i> Add User </a>&nbsp;
<a href="javascript:void(0)" id="deleteUsers" class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</a>
@endif

</div>

<div class="tabarea" id="printArea">
<div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab_1">Users</a></li>
                    <!-- <li class=""><a data-toggle="tab" href="#tab_2">Users2</a></li> -->
                    
                    <!-- <li class="pull-right"><a class="text-muted" href="#"><i class="fa fa-gear"></i></a></li> -->
                </ul>
                <div class="tab-content">
                    <div id="tab_1" class="tab-pane active">
                      <!--table area-->
                        <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
                    <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
                        <thead>
                            <tr role="row">
                                <th><input type="checkbox" value="1" name="allCheckSelect" id="allCheckSelect"></th>
                                <th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Name</th>
                                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Permissions</th>
                                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Status</th>
                                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Last Login</th>
                                <!-- <th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Login this week </th> -->
                            </tr>
                        </thead>
                        
                        <!--<tfoot>
                            <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>
                        </tfoot>-->
                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(!empty($user_lists) && count($user_lists) > 0)
                        @foreach($user_lists as $user_row)
                            <tr class="odd">
                                <td><input type="checkbox" value="{{$user_row->user_id}}" name="user_delete_id[]" id="user_delete_id"></td>
                                <td class="sorting_1">
                                    @if(isset($access['mu']) && $access['mu'] == 1)
                                        <a href="/edit-user/{{$user_row->user_id}}">{{ $user_row->fname or ""}} {{ $user_row->lname or "" }}
                                    </a>
                                    @else
                                        <a href="javascript:void(0)">{{ $user_row->fname or ""}} {{ $user_row->lname or "" }}
                                    </a>
                                    @endif

                                </td>
                                <td class=" ">{{ $user_row->permission or "" }}</td>
                                <td class=" ">
                                    @if($user_row->status == 'A')
                                        <a href="javascript:void(0)" id="user_status_{{ $user_row->user_id }}" data-user_id="{{ $user_row->user_id or "" }}" data-status="{{ $user_row->status or "" }}" class="{{ ($manage_user == 'Y')? 'active_t':''}}">Active</a>
                                    @else
                                        <a href="javascript:void(0)" id="user_status_{{ $user_row->user_id }}" data-user_id="{{ $user_row->user_id or "" }}" data-status="{{ $user_row->status or "" }}" class="{{ ($manage_user == 'Y')? 'active_t':''}}">Inactive</a>
                                    @endif
                                </td>
                                <td class=" ">{{ $user_row->last_login or '' }}<!-- 1 May 2013 9:13 p.m. --></td>
                                <!-- <td class=" ">{{ $user_row->login_count or '0' }}</td> -->
                            </tr>
                        @endforeach
                    @endif
                           
                    </tbody></table>
                    <!-- <div class="row">
                        <div class="col-xs-6">
                            <div class="dataTables_info" id="example2_info">Showing 1 to 10 of 57 entries</div>
                        </div>
                        <div class="col-xs-6">
                            <div class="dataTables_paginate paging_bootstrap">
                                <ul class="pagination">
                                    <li class="prev disabled"><a href="#">← Previous</a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">4</a></li>
                                    <li><a href="#">5</a></li>
                                    <li class="next"><a href="#">Next → </a></li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
                      <!--end table--> 
                    </div><!-- /.tab-pane -->
                                    <!-- <div id="tab_2" class="tab-pane">
                                       <div class="box-body table-responsive">
                                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
                                    <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
                                        <thead>
                                            <tr role="row"><th class="sorting_asc" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Name1</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Permissions</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Status</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Last Login</th><th class="sorting" role="columnheader" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">Login this week </th></tr>
                                        </thead>
                                        
                                        <tfoot>
                                            <tr><th rowspan="1" colspan="1">Rendering engine</th><th rowspan="1" colspan="1">Browser</th><th rowspan="1" colspan="1">Platform(s)</th><th rowspan="1" colspan="1">Engine version</th><th rowspan="1" colspan="1">CSS grade</th></tr>
                                        </tfoot>
                                    <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <tr class="odd">
                                                <td class="  sorting_1">Abel Asiamah</td>
                                                <td class=" ">Financial Adviser + Manage User + Provide Support</td>
                                                <td class=" "><a href="#" class="active_t">Active</a></td>
                                                <td class=" ">1 May 2013 9:13 p.m.</td>
                                                <td class=" ">3</td>
                                            </tr>
                                            <tr class="even">
                                                <td class="  sorting_1">Ben Abraham</td>
                                                <td class=" ">Financial Adviser</td>
                                                 <td class=" "><a href="#" class="active_t">Active</a></td>
                                                <td class=" ">2 May 2013 10:31 p.m.</td>
                                                <td class=" ">3</td>
                                            </tr>
                                            
                                             <tr class="odd">
                                                <td class="  sorting_1">Abel Asiamah</td>
                                                <td class=" ">Financial Adviser + Manage User + Provide Support</td>
                                                <td class=" "><a href="#" class="active_t">Active</a></td>
                                                <td class=" ">1 May 2013 9:13 p.m.</td>
                                                <td class=" ">3</td>
                                            </tr>
                                            <tr class="even">
                                                <td class="  sorting_1">Ben Abraham</td>
                                                <td class=" ">Financial Adviser</td>
                                                 <td class=" "><a href="#" class="active_t">Active</a></td>
                                                <td class=" ">2 May 2013 10:31 p.m.</td>
                                                <td class=" ">3</td>
                                            </tr>
                                             <tr class="odd">
                                                <td class="  sorting_1">Abel Asiamah</td>
                                                <td class=" ">Financial Adviser + Manage User + Provide Support</td>
                                                <td class=" "><a href="#" class="active_t">Active</a></td>
                                                <td class=" ">1 May 2013 9:13 p.m.</td>
                                                <td class=" ">3</td>
                                            </tr>
                                            <tr class="even">
                                                <td class="  sorting_1">Ben Abraham</td>
                                                <td class=" ">Financial Adviser</td>
                                                 <td class=" "><a href="#" class="active_t">Active</a></td>
                                                <td class=" ">2 May 2013 10:31 p.m.</td>
                                                <td class=" ">3</td>
                                            </tr>
                                             <tr class="odd">
                                                <td class="  sorting_1">Abel Asiamah</td>
                                                <td class=" ">Financial Adviser + Manage User + Provide Support</td>
                                                <td class=" "><a href="#" class="active_t">Active</a></td>
                                                <td class=" ">1 May 2013 9:13 p.m.</td>
                                                <td class=" ">3</td>
                                            </tr>
                                            <tr class="even">
                                                <td class="  sorting_1">Ben Abraham</td>
                                                <td class="gray_y">Financial Adviser</td>
                                                 <td class=""><a href="#" class="gray_y">Pending</a></td>
                                                <td class=" "></td>
                                                <td class=" "></td>
                                            </tr>
                                           
                                           </tbody></table>
                                           <div class="row"><div class="col-xs-6"><div class="dataTables_info" id="example2_info">Showing 1 to 10 of 57 entries</div></div><div class="col-xs-6"><div class="dataTables_paginate paging_bootstrap"><ul class="pagination"><li class="prev disabled"><a href="#">← Previous</a></li><li class="active"><a href="#">1</a></li><li><a href="#">2</a></li><li><a href="#">3</a></li><li><a href="#">4</a></li><li><a href="#">5</a></li><li class="next"><a href="#">Next → </a></li></ul></div></div></div></div>
                                                                    </div>
                                    </div> --><!-- /.tab-pane -->
                                </div><!-- /.tab-content -->
                            </div>
</div>

</form>
</div>






    </section><!-- /.content -->
<!-- {{ Form::close() }} -->    
</aside><!-- /.right-side -->
            
        
      
@stop



