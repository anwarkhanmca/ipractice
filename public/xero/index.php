<?php
include('../../app/library/XeroApi.php');
include ('../file-and-sign/connect.php');

$_SESSION['admin_details'] = XeroApi::get_session();

//$dtls = XeroApi::getWipInvoiceDetailsByIds( $_REQUEST['ids'] );
//echo '<pre>';print_r($_SESSION);die;
?>
<?php include('public.php');//die;?>

<?php 
    if(!isset($_SESSION['access_token'])){
        if(isset($_REQUEST['page_name']) && $_REQUEST['page_name'] == 'wip'){
            echo "<script>top.window.location = '/crm/apps'</script>";
        }
        
    }else{?>
    <script>
    if (window.opener) {
      window.opener.location.href = window.opener.location.href;
      if (window.opener.progressWindow){
          window.opener.progressWindow.close()
      }
      window.close();    
    } 
    </script>
<?php }?>

<!-- Main html content start -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>i-Practice | xero import</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="../css/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="../css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- fullCalendar -->
    <link href="../css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap wysihtml5 - text editor -->
    <link href="../css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="../css/mps_style.css" rel="stylesheet" type="text/css" />
   
    <link rel="icon" type="image/png" href="../img/favicon.ico" />
</head>
<body class="skin-blue pace-done">
    <div class="pace  pace-inactive">
        <div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
            <div class="pace-progress-inner"></div>
        </div>
        <div class="pace-activity"></div>
    </div>
    <!--Header Start-->  
    <?php include('header.php'); ?>
    <!--Header End-->    

        <!-- Content Start -->
<div class="wrapper row-offcanvas row-offcanvas-left" style="min-height: 667px;"> 
    <aside class="right-side  strech">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="col-4">
                <h1>CRM</h1>
            </div>
            <div class="col-4 logo_con">
                <img src="../colorextract/images/<?php echo $result['practice_logo'];?>" class='browse_img' width="150">
            </div>
                <div class="home_right">
                <ol class="breadcrumb ">
                    <li><a href="/dashboard"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li class="active">Crm</li>
                                
                </ol>
            </div>
                <div class="clearfix"></div>
        </section>
        <!-- Main content -->
        
        <section class="content">
            <div class="row">
                <div class="practice_hed">
                    <div class="top_bts">
                      <ul>
                        <li>
                            <a href="/pdfcrm/NA==/YWxs" class="btn btn-success" style=""><i class="fa fa-download"></i> Generate PDF</a>
                        </li>
                        <li>
                            <a href="/excelcrm/NA==/YWxs" class="btn btn-primary" style=""><i class="fa fa fa-file-text-o"></i> Excel</a>
                        </li>
                        <div class="clearfix"></div>
                      </ul>
                    </div>

                    <div id="message_div"><!-- Loader image show while sync data --></div>
                </div>
            </div>

            <div class="practice_mid">
                <div class="tabarea">
                    <div class="nav-tabs-custom">
                        <?php include('menu.php');?>

                        <div class="tab-content">
                            <!-- Tab 1 Start-->
                            <div id="tab_11" class="tab-pane active">
                                <?php if(!isset($_SESSION['access_token'])){?>

                                    <div class="contact_xero">
                                        <div class="i_con"><img src="../img/i.png"></div>
                                        <button onclick="import_from_xero();" class="btn-xero" id="Connect_to_Xero" alt="Connect to Xero" style=""></button>
                                    </div>

                                
                                <?php }else{?>
                                <script>
                                if (window.opener) {
                                  window.opener.location.href = window.opener.location.href;
                                  if (window.opener.progressWindow){
                                      window.opener.progressWindow.close()
                                  }
                                  window.close();    
                                } 
                                </script>
                                <?php }?>
                            </div>
                            <!-- Tab 1 End-->
                        </div>
                        <div class="clr"></div>
                    </div>
                </div>
            </div>
        </section>        
    </aside>
</div>   
</body>
</html>


<!-- <div class="practice_mid" style="margin-top: 50px;">
    <div class="tabarea">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs nav-tabsbg">
              <li class=""><a href="/crm/MTE=/YWxs">DASHBOARD</a></li>
              <li class=""><a href="/crm/Mg==/YWxs">CLIENT DETAILS</a></li>
              <li class=""><a href="/crm/Mw==/YWxs">MANAGE CONTRACT RENEWALS</a></li>
              <li class="active"><a href="/crm/NA==/YWxs">INVOICES &amp; DIRECT DEBITS</a></li>
              <li class=""><a href="/crm/NTE=/YWxs">LEADS</a></li>
              <li class=""><a href="/crm/NjEx/YWxs">OPPORTUNITIES</a></li>
             <li class=""> <a href="/crm/Nw==/YWxs">QUOTES</a>

                <span style="position: absolute; right:0; top:10px;"><a class="lead_QUOTES_modal" href="javascript:void(0)"><i style="color:#00c0ef;" class="fa fa-cog fa-fw"></i></a></span>
            </li>

             <li class=""><a href="/crm/OA==/YWxs">QUOTES</a></li>
            </ul>
        </div>
    </div>
<?php if(!isset($_SESSION['access_token'])){?>
<div class="tab-content">
    <div class="contact_xero">
        <div class="i_con"><img src="../img/i.png"></div>
        <button onclick="import_from_xero();" class="btn-xero" id="Connect_to_Xero" alt="Connect to Xero" style=""></button>
    </div>
</div>
    <div class="clr"></div>
<?php }else{?>
<script>
if (window.opener) {
  window.opener.location.href = window.opener.location.href;
  if (window.opener.progressWindow){
      window.opener.progressWindow.close()
  }
  window.close();    
} 
</script>
<?php }?>
</div> -->



<script>
function import_from_xero(){
    url='/xero/public.php?authenticate=1';
    newwindow=window.open(url,'name','left=300,top=100,height=600,width=750,scrollbars=1');
    if (window.focus) {newwindow.focus();}
    return false;
}
</script>
    
<style type="text/css">
.btn-xero{
    background: url("../img/connect_xero_button_blue1.png") no-repeat 0 0 #fff;
    width: 148px;
    height: 39px;
    border: 0;
    cursor: pointer;
}
</style>

<!-- jQuery 2.0.2 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<!--<script src="{{ URL :: asset('js/jquery.min.js') }}"></script>-->
<!-- jQuery UI 1.10.3 -->
<script src="../js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<!-- Morris.js charts -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
<script src="../js/plugins/morris/morris.min.js" type="text/javascript"></script>
<!-- Sparkline -->
<script src="../js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<!-- jvectormap -->
<script src="../js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
<script src="../js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
<!-- iCheck -->
<script src="../js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="../js/AdminLTE/app.js" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="{{ URL :: asset('js/AdminLTE/dashboard.js') }}" type="text/javascript"></script> -->

<!-- Add By User -->


<script type="text/javascript" src="../js/sites/jquery.autoSuggest.js"></script>