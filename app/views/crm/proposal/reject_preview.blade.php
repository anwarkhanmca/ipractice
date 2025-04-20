<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        
        <title>i-Practice
            @if(isset($title) && $title != "")
            {{ "| ".$title }}
            @endif
        </title>
        
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
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

        <link rel="stylesheet" href="{{ URL :: asset('css/pristina_fonts.css') }}">

        <link rel="icon" type="image/png" href="/img/favicon.ico" />
    </head>

<?php $color = '#ccc';?>

<style type="text/css">
    body, html{ width:100%; height:100%; padding: 0; margin: 0;background-color: #E3E3E3;}

    .nav-tabs{width: 100%; margin-top: 180px; border-bottom: 0!important}
    .tab-pane{background-color: #fff; padding-top: 5px; float: left; width: 100%;}
    
    .cntName{ text-align: center;font-size: 20px; padding: 75px 0;}
    



    
</style>


<body class="skin-blue">

    <div class="col-md-10 col-md-offset-1" style="height: 100%; margin-top: 200px;">
        <div class="col-md-3">
        </div>

        <div class="col-md-7">
            <!-- Tab panels -->
            <div class="tab-content vertical">
                <!--Panel 1-->
                <div class="tab-pane fade in active" id="panel1" role="tabpanel" >

                        <div class="cntName">
                            {{$message or ''}}
                        </div>


                <!--/.Panel 1-->

                

            </div>
        </div>

    </div>

    </body>



</html>