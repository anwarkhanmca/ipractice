@extends('layouts.layout')
@section('myjsfile')
<script src="{{ URL :: asset('js/onboard.js') }}" type="text/javascript"></script>
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
    <a  href="/practice-details">
        <div class="circle_icons_inner">
            <div class="circle_icon">
                <img src="{{ URl::asset('img/dashboard_circle.png') }}" />
            </div>
        <p class="c_tagline2">PRACTICE DETAILS</p>
        <div class="clearfix"></div>
        </div>
    </a>
</li>

<!-- <li class="hvr-grow">
    <a  href="/email-settings">
        <div class="circle_icons_inner">
            <div class="circle_icon">
                <img src="{{ URl::asset('img/dashboard_circle.png') }}" />
            </div>
        <p class="c_tagline">EMAIL & LETTER<br>TEMPLATES</p>
        <div class="clearfix"></div>
        </div>
    </a>
</li> -->

<li class="hvr-grow">
    <a href="/user-list">
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline2">MANAGE USERS</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<!-- <li class="hvr-grow">
    <a href="/reminder-notification/11">
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline">REMIDERS &<br>NOTIFICATIONS</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li> -->

<li class="hvr-grow">
@if(isset($access['ms']) && $access['ms'] == 1)
    <a href="/billings-subscriptions">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="ms">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline">MANAGE<br>SUBSCRIPTION</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<li class="hvr-grow">
    <a  href="/client-list-allocation/0/{{ base64_encode('org')}}">
        <div class="circle_icons_inner">
            <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
            <p class="c_tagline">CLIENT LIST<br>ALLOCATION</p>
            <div class="clearfix"></div>
        </div>
    </a>
</li>

<li style="display: inline-block;vertical-align: middle;">
  <div class="circle_icons_inner">
    <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
    <p class="c_tagline2">
      <div class="j_selecttask">
        <span style="color: #0080ff; font-weight: bold; font-size: 12px; padding-left: 3px;">CUSTOM CHECKLIST</span>
        <div class="select_icon" id="select_icon" style="width: 20px;"></div>
        <div class="clr"></div>
        <div class="open_toggle" id="custom_list">
          
        <div class="l_task_contain">
            <div class="l_select_con">
                <a href="javascript:void(0)" id="add_new_tasks">ADD NEW...</a>
            </div> 
          <div class="clearfix"></div>
        </div>
            
        <div class="l_task_contain">
            <div class="l_select_con">
                <a href="javascript:void(0)" class="positionopen" data-custom_check_id="0">ON BOARDING CHECKLIST</a><!--small_tagline-->
            </div>
            <div class="clearfix"></div>
        </div>

        @if(isset($custom_checklist) && count($custom_checklist) >0)
          @foreach($custom_checklist as $key=>$value)
          <div class="l_task_contain" id="hide{{ $value['custom_check_id'] or '' }}">
            <div class="l_select_con">
              <a href="javascript:void(0)" class="positionopen" data-custom_check_id="{{$value['custom_check_id'] or ''}}">{{$value['custom_name'] or ''}}</a>
            </div>
            <div class="delete_task_name">
              <a href="javascript:void(0)" class="remove_checklist" data-custom_check_id="{{ $value['custom_check_id'] or '' }}">
                  <img src="../img/cross.png" height="12"></a>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="clearfix"></div>
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
        
         <!-- Client -->
<div class="modal fade" id="checklist-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
      <input type="hidden" id="hiddenclient" value="staff" />
              
   {{ Form::open(array('url' => '/client/add-checklist', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <input type="hidden" id="custom_check_id" value="0" />
    <div class="modal-body">
      <div class="show_loader"></div>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="checklist" id="checklist" placeholder="Checklist" class="form-control">
      </div>
      
      <div id="append_position_type">
      <!--@if( isset($old_postion_types) && count($old_postion_types) >0 )
        @foreach($old_postion_types as $key=>$old_org_row)
        <div class="form-group bottom0">
          <label for="{{ $old_org_row->name }}">{{ $old_org_row->name }}</label>
        </div>
        @endforeach
      @endif

      @if( isset($new_postion_types) && count($new_postion_types) >0 )
        @foreach($new_postion_types as $key=>$new_org_row)
        <div class="form-group bottom0" id="hide_div_{{ $new_org_row->checklist_id }}">
          <a href="javascript:void(0)" title="Delete Field ?" class="delete_checklist_name" data-field_id="{{ $new_org_row->checklist_id }}"><img src="/img/cross.png" width="12"></a>
          <label for="{{ $new_org_row->name }}">{{ $new_org_row->name }}</label>
        </div>
        @endforeach
      @endif-->
      </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
         
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="add_position_type" name="save">Save</button>
          
          
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }} 
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>  
         

<div class="modal fade in" id="new_check-modal" tabindex="-1" role="dialog" aria-hidden="false">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">New Checklist Name</h4>
        <div class="clearfix"></div>
      </div>
      <input type="hidden" name="client_type" id="client_type" value="org">
      <div class="modal-body">
        <div class="show_loader"></div>
        <div class="form-group">
          <label for="exampleInputPassword1">Add New</label>
          <input type="text" class="form-control" name="custom_name" id="custom_name">
        </div>

        <div class="modal-footer1">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info" name="save" id="save_new_checklist">Save</button>
        </div>
      </div>

  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
        

@stop