@extends('layouts.layout') @section('mycssfile')

@stop
 @section('myjsfile')
 <!-- <script type="text/javascript" src="js/email_settings.js"></script> -->
@stop
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
        <div class="row icon_section">
          <div class="left_section">
            <ul>
              <li class="hvr-grow" style="margin-right:40px;"> 
              
              
              
                <a  href="/my-details/{{ $user_id }}/{{ base64_encode('profile') }}">
                  <div class="circle_icons_inner">
                    <div class="circle_icon">
                      <img alt="" src="img/dashboard_circle.png">
                    </div>
                    <p class="c_tagline2">MY DETAILS</p>
                    <div class="clearfix"></div>
                  </div>
                </a> 
              </li>

              <li class="hvr-grow" style="margin-right:40px;"> 
                <a  href="/todo-list/{{ base64_encode('11') }}">
                  <div class="circle_icons_inner">
                    <div class="circle_icon"> <img alt="" src="img/dashboard_circle.png"> </div>
                    <p class="c_tagline2">TO DO LIST</p>
                    <div class="clearfix"></div>
                  </div>
                </a> 
              </li>

              <li class="hvr-grow" style="margin-right:40px;"> 
                <a  href="/staff-holidays/{{ base64_encode('profile') }}/1/{{ base64_encode($start_date) }}">
                  <div class="circle_icons_inner">
                    <div class="circle_icon"> 
                      <img alt="" src="img/dashboard_circle.png"> 
                    </div>
                    <p class="c_tagline">HOLIDAYS<br>& TIME OFF</p>
                    <div class="clearfix"></div>
                  </div>
                </a> 
              </li>

              <li class="hvr-grow" style="margin-right:40px;"> 
                <a  href="/profile-notes">
                  <div class="circle_icons_inner">
                    <div class="circle_icon"> 
                      <img alt="" src="img/dashboard_circle.png"> 
                    </div>
                    <p class="c_tagline">NOTES</p>
                    <div class="clearfix"></div>
                  </div>
                </a> 
              </li>

              <li class="hvr-grow" style="margin-right:40px;"> 
                <a  href="/time-sheet-reports/1/{{ base64_encode('profile') }}">
                  <div class="circle_icons_inner">
                    <div class="circle_icon"> 
                      <img alt="" src="img/dashboard_circle.png"> 
                    </div>
                    <p class="c_tagline">TIMESHEET <br>& EXPENSES</p>
                    <div class="clearfix"></div>
                  </div>
                </a> 
              </li> 

              <li class="hvr-grow" style="margin-right:40px;"> 
                <a  href="/cpd-and-courses/{{ base64_encode('profile') }}/{{'1'}}">
                  <div class="circle_icons_inner">
                    <div class="circle_icon"> 
                      <img alt="" src="img/dashboard_circle.png"> 
                    </div>
                    <p class="c_tagline2">CPD & COURSES</p>
                    <div class="clearfix"></div>
                  </div>
                </a> 
              </li>  

              <li class="hvr-grow"> 
                <a  href="/staff-appraisal/{{ base64_encode('1') }}/{{ base64_encode('profile') }}">
                <div class="circle_icons_inner">
                  <div class="circle_icon"> <img alt="" src="img/dashboard_circle.png"> </div>
                  <p class="c_tagline2">STAFF APPRAISAL</p>
                  <div class="clearfix"></div>
                </div>
                </a> 
              </li>

            </ul>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>
@stop
<!--staff -->