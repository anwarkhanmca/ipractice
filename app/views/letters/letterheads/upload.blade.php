@extends('layouts.layout')

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
    <section class="content">
      <div class="practice_mid">
        <div class="show_loader"><!-- Ajax Loader --></div>
        <div class="tabarea">
        	
        	<form action="/letters/letter-head/add" method="post" enctype="multipart/form-data">
        		<label for="file">Select pdf: </label>
        		<input type="file" name="pdf" id="file" accept="application/pdf"> <br>
        		<input type="submit" name="submit" value="Upload">
        	</form>

        </div>
	    <div class="clearfix"></div>
	  </div>
    </section>
    <!-- /.content -->
  </aside>
            <!-- /.right-side -->
        
  </div>

        <!-- ./wrapper --> 

@stop