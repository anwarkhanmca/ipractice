<?php if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start('ob_gzhandler'); else ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  
  <title>i-Practice
      @if(isset($title) && $title != "")
      {{ "| ".$title }}
      @endif
  </title>
  <!-- @if(isset($previous_page))
  {{ "| ".strip_tags($previous_page) }}
  @endif
  @if(isset($sub_url))
  {{ "| ".$sub_url }}
  @endif -->
  
  <meta content='width=device-width,initial-scale=1,maximum-scale=1, user-scalable=no' name='viewport'>

  <!-- bootstrap 3.0.2 -->
  <link href="{{ URL :: asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- font Awesome -->
  <link href="{{ URL :: asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- Ionicons -->
  <link href="{{ URL :: asset('css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- Morris chart -->
  <link href="{{ URL :: asset('css/morris/morris.css') }}" rel="stylesheet" type="text/css" />
  <!-- jvectormap -->
  <link href="{{ URL :: asset('css/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
  <!-- fullCalendar -->
  <link href="{{ URL :: asset('css/fullcalendar/fullcalendar.css') }}" rel="stylesheet" type="text/css" />
  <!-- Daterange picker -->
  <link href="{{ URL :: asset('css/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
  <!-- bootstrap wysihtml5 - text editor -->
  <link href="{{ URL :: asset('css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
  <!-- Theme style -->
  <link href="{{ URL :: asset('css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ URL :: asset('css/mps_style.css') }}" rel="stylesheet" type="text/css" />

  <link href="{{ URL :: asset('css/checkbox.css') }}" rel="stylesheet" type="text/css" />

  <!-- COLOR BOX CSS -->
  <link href="/file-and-sign/colorbox/colorbox.css" rel="stylesheet" type="text/css" />


        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link rel="icon" type="image/png" href="/img/favicon.ico" />
    </head>
    <body class="skin-blue">
        @yield('mycssfile')

        <!--Header Start-->  
        @include('layouts/header')
        <!--Header End-->    
        
        <!-- Content Start -->
        @yield('content')
        <!-- Content End -->

        <!--Footer Start-->  
        @include('layouts/footer')
        <!--Footer End-->  
        
        @yield('myjsfile')
        
    </body>
</html>