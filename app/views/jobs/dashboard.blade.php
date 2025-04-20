@extends('layouts.layout')

@section('myjsfile')
<script src="{{ URL :: asset('js/jobs_dashboard.js') }}" type="text/javascript"></script>
@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="{{ URL :: asset('img/user3.jpg') }}" class="img-circle" alt="User Image" />
                        </div>
                        
                    </div>
                    
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
    <div class="row icon_section">
    <div class="left_section">
    <ul>

<li class="hvr-grow">
@if(isset($permission['vr']) && $permission['vr'] == 1)
    <a  href="/jobs/1/{{ base64_encode('1') }}/{{ base64_encode('all') }}">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="vr">
@endif
        <div class="circle_icons_inner">
            <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
            <p class="c_tagline2">VAT RETURNS</p>
            <div class="clearfix"></div>
        </div>
    </a>
</li>


<li class="hvr-grow">
@if(isset($permission['sa']) && $permission['sa'] == 1)
    <a  href="/jobs/3/{{ base64_encode('1') }}/{{ base64_encode('all') }}">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="sa">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline2">ACCOUNTS</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>



<li class="hvr-grow">
@if(isset($permission['bk']) && $permission['bk'] == 1)
    <a  href="/jobs/4/{{ base64_encode('1') }}/{{ base64_encode('all') }}">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="bk">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline2">BOOKKEEPING</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>


<li class="hvr-grow">
@if(isset($permission['ct']) && $permission['ct'] == 1)
    <a  href="/jobs/5/{{ base64_encode('1') }}/{{ base64_encode('all') }}">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="ct">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline2">CORPORATION TAX</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<li class="hvr-grow">
@if(isset($permission['pds']) && $permission['pds'] == 1)
    <a  href="/jobs/6/{{ base64_encode('1') }}/{{ base64_encode('all') }}">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="pds">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline2">AUDITS</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<li class="hvr-grow">
@if(isset($permission['it']) && $permission['it'] == 1)
    <a  href="/jobs/7/{{ base64_encode('1') }}/{{ base64_encode('all') }}">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="it">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline">INCOME TAX<br>RETURN</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<li class="hvr-grow">
@if(isset($permission['car']) && $permission['car'] == 1)
  <!-- <a  href="/ch-annual-return/9/{{ base64_encode('1') }}/{{ base64_encode('all') }}"> -->
  <a  href="/jobs/9/{{ base64_encode('1') }}/{{ base64_encode('all') }}">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="car">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline">CONFIRMATION<br> STATEMENT</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<li class="hvr-grow">
@if(isset($permission['ma']) && $permission['ma'] == 1)
    <a  href="/jobs/8/{{ base64_encode('1') }}/{{ base64_encode('all') }}">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="ma">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline">MANAGEMENT<br>ACCOUNTS</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<li class="hvr-grow">
@if(isset($permission['ecsl']) && $permission['ecsl'] == 1)
    <a  href="/jobs/2/{{ base64_encode('1') }}/{{ base64_encode('all') }}">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="ecsl">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline2">EC SALES LIST</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<!-- <li style="display: inline-block;"> -->
<li class="hvr-grow">
  <div class="circle_icons_inner">
    <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
    <p class="c_tagline2">
      <div class="j_selecttask">
        <span style="color: #0080ff; font-weight: bold;">CUSTOM TASKS</span>
        <div class="select_icon" id="select_icon"></div>
        <div class="clr"></div>
        <div class="open_toggle" id="tasks_list">
          
          <div class="l_task_contain">
              <div class="l_select_con">
                <a href="javascript:void(0)" id="add_new_tasks">ADD NEW...</a>
              </div> 
              <div class="clearfix"></div>
          </div>

          @if(isset($custom_tasks) && count($custom_tasks) >0)
            @foreach($custom_tasks as $key=>$value)
            <div class="l_task_contain" id="hide{{ $value['service_id'] or "" }}">
              <div class="l_select_con"><a href="/custom-tasks/{{ $value['service_id'] or "" }}/{{base64_encode('1')}}/{{ base64_encode('all') }}/{{ $value['custom_head']['field1'] or 'none' }}/{{ $value['custom_head']['field2'] or 'none' }}">{{ $value['service_name'] or "" }}</a></div>
              <div class="delete_task_name">
                <a href="javascript:void(0)" class="remove_tasks" data-service_id="{{ $value['service_id'] or "" }}"><img src="../img/cross.png" height="12"></a>
              </div>
              <div class="clearfix"></div>
            </div>
            @endforeach
          @endif
        </div>
      </div>
    </p>
    <div class="clearfix"></div>
  </div>

</li>

<li class="hvr-grow">
  <div class="circle_icons_inner">
    <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
    <p class="c_tagline2">
      <div class="j_selecttask">
        <span style="color: #0080ff; font-weight: bold; font-size: 11px;">CUSTOM CHECKLIST</span>
        <div class="select_icon" id="select_dropdown"></div>
        <div class="clr"></div>
        <div class="open_toggle" id="custom_list">
          
          <div class="l_task_contain">
              <div class="l_select_con">
                <a href="javascript:void(0)" id="add_new_check">ADD NEW...</a>
              </div> 
              <div class="clearfix"></div>
          </div>

          @if(isset($custom_checklist) && count($custom_checklist) >0)
            @foreach($custom_checklist as $key=>$value)
            <div class="l_task_contain" id="hide{{ $value['custom_check_id'] or '' }}">
              <div class="l_select_con">
              <a href="/checklist-details/{{$value['custom_check_id'] or ''}}" class="positionopen" data-custom_check_id="{{$value['custom_check_id'] or ''}}">{{$value['custom_name'] or ''}}</a>
              </div>
              <div class="delete_task_name">
                <a href="javascript:void(0)" class="remove_checklist" data-custom_check_id="{{ $value['custom_check_id'] or '' }}">
                    <img src="../img/cross.png" height="12"></a>
              </div>
              <div class="clearfix"></div>
            </div>
            @endforeach
          @endif
        </div>
      </div>
    </p>
    <div class="clearfix"></div>
  </div>

</li>



    </ul>
    </div>
 
    </div>
    
    
      
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

@stop

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="newtasks-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:250px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NEW TASK NAME</h4>
        <div class="clearfix"></div>
      </div>
      <input type="hidden" name="client_type" id="client_type" value="org" />
      <div class="modal-body">
        <div class="show_loader"></div>
        <div class="form-group">
          <label for="exampleInputPassword1">Add New</label>
          <input type="text" class="form-control" name="tasks_name" id="tasks_name">
        </div>

        <div class="modal-footer1" style="border-top: none;">
          <div class="email_btns">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info" name="save" id="save_new_tasks">Save</button>
            
          </div>
        </div>
      </div>

  </div>
  </div>
</div>

<div class="modal fade" id="new_check-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:250px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NEW CHECKLIST</h4>
        <div class="clearfix"></div>
      </div>
      <input type="hidden" name="client_type" id="client_type" value="org" />
      <div class="modal-body">
        <div class="show_loader"></div>
        <div class="form-group">
          <label for="exampleInputPassword1">Add New</label>
          <input type="text" class="form-control" name="custom_name" id="custom_name">
        </div>

        <div class="modal-footer1" style="border-top: none;">
          <div class="email_btns">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info" name="save" id="save_new_checklist">Save</button>
            
          </div>
        </div>
      </div>

  </div>
  </div>
</div>