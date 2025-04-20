
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

<link href="{{ URL :: asset('css/checkbox.css') }}" rel="stylesheet" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    
<script>
function featuresfun() {
  $("html, body").animate({ scrollTop: 450 }, 2000);
}

function pricingfun() {
    $('html, body').animate({
        scrollTop: $("#pricing_div").offset().top
    }, 2000);
}
</script>


<div class="header">
<div class="wrapper1">

 <div class="main_logo"><a href="/"><img src="/img/logo.jpg" alt="" /></a></div>
 <div class="hdr_menu">
 
    <ul>
        <li><a href="/" {{ ($page_title == "Home")?'class="menu_active"':"" }}>home</a></li>
        <li ><a href="#" {{ ($page_title == "Features")?'  class="menu_active"':"" }} onclick="return featuresfun()"> Features </a></li>
        <li><a href="#" {{ ($page_title == "Pricing")?'class="menu_active"':"" }} onclick="return pricingfun()">Pricing</a></li>
        <!-- <li><a href="/contact" {{ ($page_title == "Contact")?'class="menu_active"':"" }}>Contact</a></li> -->
        <li><a href="javascript:void(0)" class="contact_form" data-msg_type="C">Contact</a></li>
        <li><a href="/login">sign In</a></li>
        <li><a href="/admin-signup">Sign up</a></li>

 
    </ul>
    <div class="clr"></div>
 </div>
 <div class="clr"></div>
 
  </div>
</div>
