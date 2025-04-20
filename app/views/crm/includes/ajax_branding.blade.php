<?php

if(isset($practice['use_color']) && $practice['use_color'] == 'M'){
    $color = $practice['crm_manual_color'];
}else if(isset($practice['use_color']) && $practice['use_color'] == 'A'){
    $color = $practice['crm_auto_color'];
}else{
    $color = '#12A5F4';
}
//echo $color;//die;
?>

<style type="text/css">
    #brandPrev .nav-item{width: 100%; background-color: #fff; margin-bottom: 6px!important; border-top: 1px solid <?=$color;?>; padding-top: 2px; cursor: pointer;}
    #brandPrev .nav-tabs{width: 100%; margin-top: 180px; border-bottom: 0!important}
    #brandPrev .tab-pane{background-color: #fff; min-height: 528px; padding: 5px;}
    #brandPrev .nav-link{background-color: <?=$color;?>; margin: 3px; color: #fff; cursor: pointer; font-size: 11px; font-weight: bold;}

    .blue_line{width: 100%; background-color: <?=$color;?>; height: 2px; float: left; margin-bottom: 5px}
    .blue_smallline{width: 100%; background-color: <?=$color;?>; height: 2px; float: left; margin-bottom: 5px;}
    .blue_boldline{width: 100%; background-color: <?=$color;?>; height: 7px; float: left; margin-bottom: 5px}
    .blue_footer{width: 100%; background-color: <?=$color;?>; height: 35px; float: left;}
    a:hover, a:active, a:focus{color: #ccc;}
    .gray_icon1{position: absolute; left: 9px; top: 180px}
    .gray_icon2{position: absolute; left: 9px; top: 390px}
    .menu-left{float: left; padding: 2px 2px; background-color: <?=$color;?>; color:#fff; width:14%; height:23px;}
    .menu-right{float: left; padding: 1px 0px; background-color: <?=$color;?>; color: #fff; margin-left: 1%; width: 85%; cursor: pointer; height: 23px;}

    .logo_div{text-align: center; margin-top: 20px;}
    .logo_div p{font-weight: bold;}
    .cntTitle{ margin-top: 100px; text-align: center; font-size: 30px; color: #b2b1b1;text-transform:uppercase}
    .cntName{margin-top: 100px; text-align: center;font-size: 20px;}
    .fileImage1{font-size: 20px; color: white; width: 28px; height: 30px; padding: 5px 0px 5px 7px; position: absolute; left: 9px; top: 99px; background-color: <?=$color;?>;}
    .fileImage2{font-size: 20px; color: white; width: 28px; height: 30px; padding: 5px 0px 5px 7px; position: absolute; left: 9px; top: 257px; background-color: <?=$color;?>;}
    .shadow1{position: absolute; top: 129px; left: 9px; width: 0px; height: 0px; border-top: 5px solid #272822; border-left: 6px solid transparent;}
    .shadow2{position: absolute; top: 287px; left: 9px; width: 0px; height: 0px; border-top: 5px solid #272822; border-left: 6px solid transparent;}
    .attachdiv{float: left; width: 100%; border:1px solid <?=$color;?>; padding: 0 0 3px 7px; margin-top:15px;}
    .h3dot{ font-size:15px; cursor:pointer; position:relative; top:0px; color:<?=$color;?>; }
    #brandPrev .dropdown-menu1{ position: relative; top: 0; left: 312px; z-index: 1000; float: left; min-width: 160px;
        padding: 5px 0; margin: 2px 0 0; font-size: 14px; list-style: none; background-color: #fff; border: 1px solid #ccc; border: 1px solid rgba(0,0,0,0.15); border-radius: 4px; -webkit-box-shadow: 0 6px 12px rgba(0,0,0,0.175); box-shadow: 0 6px 12px rgba(0,0,0,0.175); background-clip: padding-box;}
    .fullAttachArea{float: left; width: 100%;}
    #brandPrev .nav>li>a{ padding: 5px 4px 4px 5px; }
    #brandPrev .dropdown-menu{min-width: 120px;}
</style>

<div class="col-xs-12">PREVIEW</div>
<div class="col-md-12" id="brandPrev">
    <div class="col-md-4">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" style="margin-top: 100px;">
            <li class="nav-item ">
                <div class="menu-left"><i class="fa fa-list tiny-icon"></i></div>
                <div class="menu-right"><a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">COVER</a></div>
            </li>
            <li class="nav-item">
                <div class="menu-left"><i class="fa fa-list tiny-icon"></i></div>
                <div class="menu-right"><a class="nav-link" data-toggle="tab" href="#panel2" role="tab">MAIN BODY</a></div>
            </li>
            <li class="nav-item">
                <div class="menu-left"><i class="fa fa-list tiny-icon"></i></div>
                <div class="menu-right"><a class="nav-link" data-toggle="tab" href="#panel3" role="tab">QUOTE SUMMARY</a></div>
            </li>
            <li class="nav-item">
                <div class="menu-left"><i class="fa fa-list tiny-icon"></i></div>
                <div class="menu-right"><a class="nav-link" data-toggle="tab" href="#panel4" role="tab">ATTACHMENTS</a></div>
            </li>
            <!-- <li class="nav-item">
                <div class="menu-left"><i class="fa fa-list tiny-icon"></i></div>
                <div class="menu-right"><a class="nav-link" data-toggle="tab" href="#panel5" role="tab">TERMS & CONDITIONS</a></div>
            </li> -->
            <li class="nav-item">
                <div class="menu-left"><i class="fa fa-list tiny-icon"></i></div>
                <div class="menu-right"><a class="nav-link" data-toggle="tab" href="#panel6" role="tab">SIGN & ACCEPT</a></div>
            </li>
        </ul>
    </div>

    <div class="col-md-8">
        <i class="fa fa-file-text-o fileImage1"></i>
        <i class="fa fa-file-text-o fileImage2"></i>
        <div class="shadow1"></div>
        <div class="shadow2"></div>

        <div class="tab-pane fade in active" id="panel1" role="tabpanel" >
            <div class="blue_line"></div>
            <div class="blue_boldline"></div>
            <div class="col-md-8 col-md-offset-2" style="height: 400px; float: left;">
                <div class="logo_div">
                @if(isset($practice['crm_branding_logo']) && $practice['crm_branding_logo'] != "")
                  @if(file_exists("colorextract/images/".$practice['crm_branding_logo']))
                    <img src="/colorextract/images/{{$practice['crm_branding_logo']}}" width="150">
                  @endif
                @endif
                    
                    <p style="margin-top: 20px;font-size: 18px">PROPOSAL</p>
                </div>
                <div class="cntTitle">{{ $practice['proposal_title'] or ''}}</div>
                <div class="cntName">{{ $practice['prospect_name'] or ''}}</div>
                <p style="text-align: center; font-weight: bold">{{ !empty($cover['proposal']['contact_name'])?'FAO '.$cover['proposal']['contact_name']:''}}</p>
                <p style="text-align: center;">{{ date('d F Y') }}</p>
            </div>
            <div class="col-md-10 col-md-offset-1"><div class="blue_smallline"></div></div>
            <div style="float: left; width: 100%; font-size: 11px">
                <p style="text-align: center;">
                    {{ $practice['display_name'] or ''}}
                    {{ !empty($practice['practiceemail'])?' | '. $practice['practiceemail']:''}}
                    {{ !empty($practice['telephone_no'])?' | '. $practice['telephone_no']:''}}
                </p>
            </div>
            <div class="blue_boldline"></div>
            <div class="blue_footer"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>