@extends('layouts.layout')
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
    <a href="#">
        <div class="circle_icons_inner">
            <div class="circle_icon"><img src="{{ URl :: asset('img/dashboard_circle.png') }}" /></div>
            <p class="c_tagline2">FORMS</p>
            <div class="clearfix"></div>
        </div>
    </a>
</li>


<li class="hvr-grow">
    <a  href="#">
        <div class="circle_icons_inner">
            <div class="circle_icon"><img src="{{ URl::asset('img/dashboard_circle.png') }}" /></div>
            <p class="c_tagline">TASK RATES &<br>THRESHOLDS</p>
            <div class="clearfix"></div>
        </div>
    </a>
</li>

    </ul>
    </div>
 
    </div>
    
    
      
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

@stop