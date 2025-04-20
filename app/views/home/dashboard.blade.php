@extends('layouts.layout')

@section('myjsfile')
<script src="{{ URL :: asset('js/dashboard.js') }}" type="text/javascript"></script>
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
<?php $session =  Session::get('admin_details');
    //echo "<pre>";print_r($session);die;
?>
<section class="content">
  <div class="row icon_section">
    <div class="left_section">
      <ul>

        <!-- <li class="hvr-grow">
          <div class="circle_icons_inner">
            <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
            <p class="c_tagline2">
              <div class="j_selectdash">
                <span style="color: #0080ff; font-weight: bold;">CLIENT LIST</span>
                <div class="select_drop" id="select_icon"></div>
                <div class="clr"></div>
                <div class="toggle_drop" id="tasks_list">
                    <div class="l_task_contain">
                        <div class="l_select_drop">
                            <a href="/organisation-clients">Organisation List</a>
                        </div> 
                        <div class="l_select_drop">
                            <a href="/individual-clients">Individual List</a>
                        </div> 
                        <div class="clearfix"></div>
                    </div>
                </div>
              </div>
            </p>
            <div class="clearfix"></div>
          </div>
        </li> -->
        <li class="hvr-grow">
          <a href="javascript:void(0)" class="openClientListPop">
            <div class="circle_icons_inner">
              <div class="circle_icon"><img src="{{URl::asset('img/dashboard_circle.png')}}"/></div>
              <p class="c_tagline2">CLIENT LIST</p>
              <div class="clearfix"></div>
            </div>
          </a>
        </li>

<!-- <li class="hvr-grow">
    <a  href="/organisation-clients">
        <div class="circle_icons_inner">
            <div class="circle_icon"><img src="{{ URl :: asset('img/dashboard_circle.png') }}" /></div>
            <p class="c_tagline">CLIENT LIST - <br>
            ORGANISATIONS</p>
            <div class="clearfix"></div>
        </div>
    </a>
</li> -->


<li class="hvr-grow">
@if(isset($access['tm']) && $access['tm'] == 1)
    <a  href="/jobs-dashboard">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="tm">
@endif
        <div class="circle_icons_inner">
            <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
            <p class="c_tagline2">TASK MANAGER</p>
            <div class="clearfix"></div>
        </div>
    </a>
</li>

<li class="hvr-grow">
@if(isset($access['sm']) && $access['sm'] == 1)
    <a  href="/staff-management">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="sm">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline">STAFF<br> MANAGEMENT</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<li class="hvr-grow">
@if(isset($access['crm']) && $access['crm'] == 1)
    <a  href="{{url()}}/crm/{{ base64_encode('11') }}/{{ base64_encode('all') }}/crm">
@else
    <a href="javascript:void(0)" class="checkUserAccess" data-name="crm">
@endif
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}"/></div>
      <p class="c_tagline2">PROPOSALS</p>
      <div class="clearfix"></div>
    </div>
    </a>
</li>

<li class="hvr-grow">
    <a  href="/letters">
        <div class="circle_icons_inner">
            <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
            <p class="c_tagline">LETTERS &<br>CONTACTS</p>
            <div class="clearfix"></div>
        </div>
    </a>
</li>

<li class="hvr-grow">
  <a  href="/knowledgebase">
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
      <p class="c_tagline">IN- HOUSE <br> KNOWLEDGE BASE</p>
      <div class="clearfix"></div>
    </div>
  </a>
</li>

<!-- <li class="hvr-grow">
    <a  href="/hmrc/taxrates">
        <div class="circle_icons_inner">
            <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
            <p class="c_tagline2">TAX CARDS</p>
            <div class="clearfix"></div>
        </div>
    </a>
</li> -->
<!-- <li class="hvr-grow">
<a  href="/individual-clients">
  <div class="circle_icons_inner">
    <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
    <p class="c_tagline">CLIENT LIST - <br> INDIVIDUALS</p>
    <div class="clearfix"></div>
  </div>
</a>
</li> -->

<li class="hvr-grow">
<a href="{{url()}}/esigns/gateway/{{$_token}}/{{$userinfo['fname']}}-{{$userinfo['lname']}}/{{$userinfo['email']}}/{{$practice_name or ''}}">
<div class="circle_icons_inner">
<div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
<p class="c_tagline2">E - SIGN</p>
<div class="clearfix"></div>
</div></a>
</li>

<li class="hvr-grow">
  <a  href="/noticeboard/1">
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
      <p class="c_tagline2">E - BOARD</p>
      <div class="clearfix"></div>
    </div>
  </a>
</li>

<li class="hvr-grow">
  <a  href="/file-share"><!-- fileandsign and /file-and-sign/share-document.php-->
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{URl::asset('img/dashboard_circle.png')}}"/></div>
      <p class="c_tagline2">FILE SHARE</p>
      <div class="clearfix"></div>
    </div>
  </a>
</li>  

<!-- <li class="hvr-grow">
<a  href="/chdata/index">
<div class="circle_icons_inner">
<div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
<p class="c_tagline2">COMPANIES' HOUSE</p>
<div class="clearfix"></div>
</div></a>
</li> -->



<!-- <li class="hvr-grow">
  <a  href="{{url()}}/hmrc">
    <div class="circle_icons_inner">
      <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
      <p class="c_tagline2">HMRC</p>
      <div class="clearfix"></div>
    </div>
  </a>
</li> -->





<!-- <li class="hvr-grow">
<a  href="/contacts-letters-emails/1/{{ base64_encode('corres') }}">
<div class="circle_icons_inner">
<div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
<p class="c_tagline">CONTACTS,<br>
LETTERS & EMAILS</p>
<div class="clearfix"></div>
</div></a>
</li> -->

<!-- <li class="hvr-grow">
<a  href="/settings-dashboard">
<div class="circle_icons_inner">
<div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
<p class="c_tagline2">SETTINGS</p>
<div class="clearfix"></div>
</div></a>
</li> -->






        

          </ul>
        </div>
 
      </div>
    </section>
  </aside>
</div>



<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="openClientListPop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:230px;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Please Select</h4>
        <div class="clearfix"></div>
      </div>
      <div class="modal-body" >
        <div style="margin-left: 32px;">
          <div class="form-group">
            <div class="areaBtn">
              <a href="/organisation-clients">Organisation List</a>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="areaBtn">
              <a href="/individual-clients">Individual List</a>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@stop