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
<?php
/*if(isset($practice['use_color']) && $practice['use_color'] == 'A'){
    $color = $practice['crm_auto_color'];
}else if(isset($practice['use_color']) && $practice['use_color'] == 'M'){
    $color = $practice['crm_manual_color'];
}else{
    $color = '#12A5F4';
}*/
?>



<style type="text/css">
    body, html{ width:100%; height:100%; padding: 0; margin: 0;background-color: #E3E3E3;}
    /*body {top: 0; left: 0; min-width: 100%;min-height: 100%;background-color: #E3E3E3;}*/
    .nav-item{width: 100%; background-color: #fff; margin-bottom: 10px!important; border-top: 1px solid <?=$color;?>; padding-top: 4px; cursor: pointer;}
    .nav-tabs{width: 100%; margin-top: 180px; border-bottom: 0!important}
    .tab-pane{background-color: #fff; min-height: 1136px; padding-top: 5px; float: left; width: 100%;}
    .nav-link{background-color: <?=$color;?>; margin: 7px; color: #fff; cursor: pointer; font-size: 16px; font-weight: bold;}

    .blue_line{width: 100%; background-color: <?=$color;?>; height: 2px; float: left; margin-bottom: 5px}
    .blue_smallline{width: 100%; background-color: <?=$color;?>; height: 2px; float: left; margin-bottom: 5px;}
    .blue_boldline{width: 100%; background-color: <?=$color;?>; height: 7px; float: left; margin-bottom: 5px}
    .blue_footer{width: 100%; background-color: <?=$color;?>; height: 35px; float: left;}
    a:hover, a:active, a:focus{color: #ccc;}
    .gray_icon1{position: absolute; left: 9px; top: 180px}
    .gray_icon2{position: absolute; left: 9px; top: 390px}
    .menu-left{float: left; padding: 8px 11px; background-color: <?=$color;?>; color:#fff; width:14%; height:36px;}
    .menu-right{float: left; padding: 7px 2px; background-color: <?=$color;?>; color: #fff; margin-left: 1%; width: 85%; cursor: pointer; height: 36px;}

    .logo_div{text-align: center; margin-top: 20px;}
    .logo_div p{font-weight: bold;}
    .cntTitle{ margin-top:100px; text-align:center; font-size:30px; color:<?=$color;?>;text-transform:uppercase}
    .cntName{margin-top: 100px; text-align: center;font-size: 20px;}
    .fileImage1{font-size: 20px; color: white; width: 28px; height: 30px; padding: 5px 0px 5px 7px; position: absolute; left: 9px; top: 180px; background-color: <?=$color;?>;}
    .fileImage2{font-size: 20px; color: white; width: 28px; height: 30px; padding: 5px 0px 5px 7px; position: absolute; left: 9px; top: 395px; background-color: <?=$color;?>;}
    .shadow1{position: absolute; top: 210px; left: 9px; width: 0px; height: 0px; border-top: 5px solid #272822; border-left: 6px solid transparent;}
    .shadow2{position: absolute; top: 425px; left: 9px; width: 0px; height: 0px; border-top: 5px solid #272822; border-left: 6px solid transparent;}
    .attachul{float: left; width: 100%; border:1px solid <?=$color;?>; padding: 0 0 3px 7px;margin-bottom:5px;}
    .h3dot{ font-size:15px; cursor:pointer; position:relative; top:0px; color:<?=$color;?>; }
    .dropdown-menu1{ position: relative; top: 0; left: 312px; z-index: 1000; float: left; min-width: 160px;
        padding: 5px 0; margin: 2px 0 0; font-size: 14px; list-style: none; background-color: #fff; border: 1px solid #ccc; border: 1px solid rgba(0,0,0,0.15); border-radius: 4px; -webkit-box-shadow: 0 6px 12px rgba(0,0,0,0.175); box-shadow: 0 6px 12px rgba(0,0,0,0.175); background-clip: padding-box;}
    .fullAttachArea{float: left; width: 100%;}
    .nav>li>a{ padding: 5px 4px 4px 5px; }
    .dropdown-menu{min-width: 120px;}


    .quoteBox{min-height:1015px;width:92%;float:left;border:1px solid <?=$color;?>; margin: 0 20px 25px 26px; padding: 5px 10px;}

    .fillheader{ width: 100%; height: 36px; background-color: <?=$color;?>; padding-left: 15px; float: left;font-family: 'Bookman Old Style'; font-style: normal; font-variant: normal; font-weight: 800; }
    
    .quoteSummaryBox{min-height:1015px;width:100%;float:left;border:1px solid <?=$color;?>;}
    .quoteMainBox{width:100%;float:left;border:1px solid <?=$color;?>;}

    .fillfooter{ width: 100%; height: 36px; background-color: <?=$color;?>; padding-left: 20px; float: left;font-family: 'Bookman Old Style'; font-style: normal; font-variant: normal; font-weight: 800;}


    /* Activity */
    .servCnt{float: left;width: 100%;font-family: 'Bookman Old Style'; font-style: normal; font-variant: normal;  border-bottom: 1px solid <?=$color;?>;}
    .servCntTotal{float: left;width: 100%;font-family: 'Bookman Old Style'; font-style: normal; font-variant: normal;  border-bottom: 3px solid <?=$color;?>;}
    
    .plainLineH{height: 5px; width: 100%; border-top: 1px solid <?=$color;?>;float: left;}
    
    .upDownArrow{font-size: 23px; color: <?=$color;?>}

    .MainBodyFirst{width:100%;float:left;border:1px solid <?=$color;?>; padding: 3px 7px; height: 460px; margin-bottom: 10px; overflow-y: scroll;}
    .MainBodySec{width:100%;float:left;border:1px solid <?=$color;?>; padding: 3px 7px; height: 460px; overflow-y: scroll;}
    
    .attachTitle{color: <?=$color;?>;}

    .feesTable{width: 100%; border:1px solid <?=$color;?>; float: left;margin: 8px 0;}
    .feesTable tr td{ border:1px solid <?=$color;?>; padding: 3px 8px;}
    .sign-btn{ width:100%; height: 50px; background-color:<?=$color;?>; border-color:<?=$color;?>; color:#fff; font-weight: bold; font-size: 16px;font-family: 'Bookman Old Style'; }
    .commentIcon{ color:<?=$color;?>;}
    
    .signedText{font-family: 'PRISTINA';font-size:40px; color: <?=$color;?>;}
    .thineLine{height: 1px; width: 100%; background: <?=$color;?>; margin-top: 5px; float: left;}
    
</style>


<body class="skin-blue">
    <input type="hidden" name="base_url" value="{{ url() }}" id="base_url">
    <input type="hidden" id="proposal_id" value="{{$proposal_id}}">
    <input type="hidden" id="crm_proposal_id" value="{{$crm_proposal_id}}">

    <div class="col-md-10 col-md-offset-1" style="height: 100%;">
        <div class="col-md-3">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
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
                    <div class="menu-right"><a class="nav-link" data-toggle="tab" href="#panel5" role="tab">TERMS AND CONDITIONS</a></div>
                </li> -->
                <li class="nav-item">
                    <div class="menu-left"><i class="fa fa-list tiny-icon"></i></div>
                    <div class="menu-right">
                        <a class="nav-link" data-toggle="tab" href="#panel6" role="tab" id="menu-panel6">
                            @if(isset($signedData['save_type']) && ($signedData['save_type']=='A' || $signedData['save_type']=='MA'))
                                ACCEPTED
                            @elseif(isset($signedData['save_type']) && ($signedData['save_type']=='L' || $signedData['save_type']=='ML'))
                                DECLINED
                            @else
                                SIGN & ACCEPT
                            @endif
                        </a>
                    </div>
                </li>
            </ul>
        </div>

        <div class="col-md-7">
            <!-- Tab panels -->
            <div class="tab-content vertical" style="min-height: 100%;">
                <i class="fa fa-file-text-o fileImage1"></i>
                <i class="fa fa-file-text-o fileImage2"></i>
                <div class="shadow1"></div>
                <div class="shadow2"></div>
                <!--Panel 1-->
                <div class="tab-pane fade in active" id="panel1" role="tabpanel" >
                    <div class="blue_line"></div>
                    <div class="blue_boldline"></div>
                    <div class="col-md-8 col-md-offset-2" style="height: 1028px; float: left;">
                        <div class="logo_div">
                        <!-- @if(isset($cover['practice']['crm_branding_logo']) && $cover['practice']['crm_branding_logo'] != "")
                          @if(file_exists("colorextract/images/".$cover['practice']['crm_branding_logo']))
                            <img src="/colorextract/images/{{$cover['practice']['crm_branding_logo']}}" width="150">
                          @endif
                        @endif -->
                            @if(isset($logo) && $logo != "")
                              @if(file_exists("colorextract/images/".$logo))
                                <img src="/colorextract/images/{{$logo}}" width="150">
                              @endif
                            @endif
                            
                            <p style="margin-top: 20px;font-size: 18px">PROPOSAL</p>
                            <p style="font-size: 17px;">ID {{$proposal_id}}</p>
                        </div>
                        <div class="cntTitle">{{ $cover['proposal']['proposal_title'] or ''}}</div>
                        <p style="text-align: center;">
                            {{ date('d F Y', strtotime($cover['proposal']['start_date'])) }} - 
                            {{ date('d F Y', strtotime($cover['proposal']['end_date'])) }}
                        </p>

                        @if(isset($cover['proposal']['save_type']) && ($cover['proposal']['save_type']!='A' && $cover['proposal']['save_type']!='MA' && $cover['proposal']['save_type']!='L' && $cover['proposal']['save_type']!='ML'))
                        <p class="valip" id="valip">Validity : {{ $cover['proposal']['validity'] }} days</p>
                        @endif

                        <div class="cntName">{{ $cover['proposal']['prospect_name'] or ''}}</div>
                        <p style="text-align: center; font-weight: bold">
                        @if($cover['proposal']['contact_type']=='p_org' || $cover['proposal']['contact_type']== 'c_org')
                            {{ (!empty($cover['proposal']['contact_name']) && $cover['proposal']['contact_name'] != 'Select Contact')?'FAO '.$cover['proposal']['contact_name']:''}}
                        @endif
                        </p>
                        <p class="center">{{ date('d F Y', strtotime($cover['proposal']['created'])) }}</p>
                    </div>
                    <!-- <div class="col-md-10 col-md-offset-1"><div class="blue_smallline"></div></div> -->
                    <div style="float: left; width: 100%">
                        <div class="center">{{ $cover['practice']['display_name'] or '' }}</div>
                        <div class="center">{{ $cover['practice']['phyAddr']['address_line1'] or '' }}</div>
                        <div class="center">{{ $cover['practice']['phyAddr']['address_line2'] or '' }}</div>
                        <div class="center">{{ $cover['practice']['phyAddr']['zip'] or '' }}</div>
                        <div class="center">{{ $cover['practice']['phyAddr']['country_name'] or '' }}</div>
                        <p class="center">
                        <!-- {{ $cover['practice']['display_name'] or ''}} -->
            {{!empty($cover['practice']['practiceemail'])?$cover['practice']['practiceemail']:''}}
            {{!empty($cover['practice']['telephone_no'])?' | '.$cover['practice']['telephone_no']:''}}
            {{!empty($cover['practice']['practicewebsite'])?' | '.$cover['practice']['practicewebsite']:''}}
                        </p>
                    </div>
                    <div class="blue_boldline"></div>
                    <div class="blue_footer"></div>
                </div>
                <!--/.Panel 1-->

                <!--Panel 2-->
                <div class="tab-pane fade" id="panel2" role="tabpanel">
                    <div class="blue_line"></div>
                    <div class="blue_boldline"></div>
                    <div class="conTentBox" style="margin-bottom: 25px;">

                        <div class="headText">Introduction</div>
                        <p>Please review the proposal.</p>
                        <div class="MainBodyFirst">
                            {{ $coverLetter['desc'] or '' }}
                        </div>
                        <div class="clearfix"></div>

                        <div class="headText">Terms and Conditions</div>
                        <p>Please review the terms and conditions of this proposal.</p>
                        <div class="MainBodySec">
                            {{ $terms['terms'] or '' }}
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="blue_boldline"></div>
                    <div class="blue_footer"></div>
                </div>
                <!--/.Panel 2-->

                <!--Panel 3-->
    <div class="tab-pane fade" id="panel3" role="tabpanel">
        <div class="blue_line"></div>
        <div class="blue_boldline"></div>
        <div class="conTentBox" style="min-height: 1065px;">
            <div class="headQtText">QUOTE SUMMARY</div>

        <?php $Grand1 = $optional_total = $optional_total1 = $grang_total = 0; ?>
        @if(isset($groupTableShow) && $groupTableShow > 0)
            <div class="plainLineH">&nbsp;</div>
            <div class="quoteMainBox">
                <div class="fillheader">
                    <div class="headcont" style="width: 89%;">SUMMARY</div>
                    <div class="headcont">Fee (&pound;)</div>
                    <div class="clearfix"></div>
                </div>

                <div class="inneQMquoteBox">
                <?php //echo "<pre>";print_r($grandTotals);die;?>
                
                @foreach($grandTotals as $k=>$v)
                  @if(isset($v['show_group']) && $v['show_group'] =='Y')
                    <?php 
                        if($v['package_type'] != 'O' && $v['package_type'] != 'C'){
                            $grang_total += str_replace(',','',$v['preview_fees']);
                        }
                    ?>
                    <div class="servCnt">
                        <div class="borderbottom">
                            <div class="servText">{{ $v['heading_name'] or '' }}</div>
                            <div class="clickArro">
                                <a href="javascript:void(0)" class="clickArro_a" data-id="{{ $v['id'] or ''}}"><i class="fa fa-angle-down upDownArrow"></i></a>
                            </div>
                            <div class="servPrc"> 
                            @if($v['package_type'] != 'O' && $v['package_type'] != 'C')
                                {{ !empty($v['preview_fees'])?number_format($v['preview_fees'], 2):'0.00'}}
                            @endif
                            </div>
                        </div>

                    <div class="col-md-12 actvCont" style="display: none;" id="service_{{ $v['id'] or ''}}">
                        @if(isset($v['services']) && count($v['services']) > 0)
                          @foreach($v['services'] as $k=>$vs)
                            <?php $num = 1;?>
                                <div class="actvHead">
                                    <div class="actvTitle">{{ ucwords(strtolower($vs['service_name'])) }} 
                                        @if(isset($vs['notes']) && $vs['notes'] != '')
                                            <sup><?= $num;$num++;?></sup>
                                        @endif
                                    </div>
                                    <div class="actvPnd">&pound;</div>
                                    <div class="tblSumDrpType">
                                    {{(!empty($vs['feesTableDtls']['table_type']))?$vs['feesTableDtls']['table_type']:''}}
                                    </div>
                                    <div class="right">
                                    @if($vs['is_show_fees']=='N')
                                      @if($v['package_type'] != 'O' && $v['package_type'] != 'C')
                                       {{!empty($vs['preview_fees'])?number_format($vs['preview_fees'],2):'0.00'}}
                                      @endif
                                    @endif
                                        
                                    </div>
                                </div>

                                            
                            <!-- @if(isset($vs['fee_type']) && $vs['fee_type'] == 'fee_table')
                                <table class="feesTable">
                                @if(isset($vs['feesTableDtls']) && count($vs['feesTableDtls']) >0)
                                    @foreach($vs['feesTableDtls'] as $k=>$vt) 
                                    <tr>
                                        <td>{{ $vt['desc'] or '' }}</td>
                                        <td>{{ $vt['fees'] or '' }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                                </table>
                            @endif -->
                        @if(isset($vs['feesTableDtls']['details']) && count($vs['feesTableDtls']['details'])>0)
                            <table class="feesTable">
                                @foreach($vs['feesTableDtls']['details'] as $k=>$vt) 
                                <tr>
                                    <td>{{ $vt['desc'] or '' }}</td>
                                    <td>{{ $vt['fees'] or '' }}</td>
                                </tr>
                                @endforeach
                            </table>
                        @endif
                                            
                        <?php $option1 = $option2 = $option3 = 0;?>
                        @if(isset($vs['activities']) && count($vs['activities'])>0)
                            @foreach($vs['activities'] as $k=>$vsa)
                                <?php 
                                    if($vsa['activity_option'] == 1)$option1 = 1;
                                    if($vsa['activity_option'] == 2)$option2 = 2;
                                    if($vsa['activity_option'] == 3)$option3 = 3;
                                ?>
                            @endforeach
                        @endif

                        @if($option1 == 1)
                            <div class="actsubcont">
                                <div class="actsubcontTl">This service includes :-</div>
                                <ul class="actsubsub">
                                @if(isset($vs['activities']) && count($vs['activities'])>0)
                                  @foreach($vs['activities'] as $k=>$vsa)
                                    @if($vsa['activity_option'] == 1)
                                        <li>
                                            <div class="actsubimg"><img src="/img/black_right.png"></div>
                                            <div class="lileft">{{$vsa['name'] or ''}} 
                                                @if(isset($vsa['notes']) && $vsa['notes'] != '')
                                                    <sup><?= $num;$num++;?></sup>
                                                @endif
                                            </div>
                                            <div class="liright">
                                            @if($vsa['is_show_fees'] != 'Y')
                                                {{ !empty($vsa['fees'])?number_format($vsa['fees'],2):'0.00'}}
                                            @endif
                                            </div>
                                        </li>
                                    @endif
                                  @endforeach
                                @endif
                                </ul>
                            </div>
                        @endif

                        @if($option2 == 2)
                            <div class="actsubcont">
                                <div class="actsubcontTl">Disbursement & Recharges :-</div>
                                <ul class="actsubsub">
                                @if(isset($vs['activities']) && count($vs['activities'])>0)
                                  @foreach($vs['activities'] as $k=>$vsa)
                                    @if($vsa['activity_option'] == 2)
                                        <li>
                                            <div class="actsubimg"><img src="/img/black_right.png"></div>
                                            <div class="lileft">{{$vsa['name'] or ''}} 
                                                @if(isset($vsa['notes']) && $vsa['notes'] != '')
                                                    <sup><?= $num;$num++;?></sup>
                                                @endif
                                            </div>
                                            <div class="liright">
                                            @if($vsa['is_show_fees'] != 'Y')
                                                {{ !empty($vsa['fees'])?number_format($vsa['fees'],2):'0.00'}}
                                            @endif
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                                @endif
                                </ul>
                            </div>
                        @endif

                        @if($option3 == 3)
                            <div class="actsubcont">
                                <div class="actsubcontTl">Optional Services :-</div>
                                <ul class="actsubsub">
                                @if(isset($vs['activities']) && count($vs['activities'])>0)
                                  @foreach($vs['activities'] as $k=>$vsa)
                                    @if($vsa['activity_option'] == 3)
                                    <li>
                                        <div class="actsubimg"><img src="/img/black_right.png"></div>
                                        <div class="lileft">{{$vsa['name'] or ''}} 
                                            @if(isset($vsa['notes']) && $vsa['notes'] != '')
                                                <sup><?= $num;$num++;?></sup>
                                            @endif
                                        </div>
                                        <div class="liright">{{ !empty($vsa['fees'])?number_format($vsa['fees'],2):'0.00'}}</div>
                                    </li>
                                    <?php $optional_total += str_replace(',', '', $vsa['fees']);?>
                                    @endif
                                @endforeach
                                @endif
                                </ul>
                            </div>
                        @endif

                        @if($num >1)
                            <div class="actsubcont">
                                <div class="notesHead">Notes:</div>
                                <ul class="notesHeadUl">
                                <?php $not=1;?>
                                @if(isset($vs['notes']) && $vs['notes'] != '')
                                    <li><?= $not;$not++;?>. {{ $vs['notes'] or '' }}</li>
                                @endif
                                @if(isset($vs['activities']) && count($vs['activities'])>0)
                                  @foreach($vs['activities'] as $k=>$vsa)
                                    @if(isset($vsa['notes']) && $vsa['notes'] != '')
                                        <li><?= $not;$not++;?>. {{ $vsa['notes'] or '' }}</li>
                                    @endif
                                  @endforeach
                                @endif
                                </ul>
                            </div>
                        @endif
                        
                      @endforeach
                    @endif
                </div>
            </div>
          @endif
        @endforeach
                            
            </div>

            <div class="fillfooter">
                <div class="headcont" style="width: 70%;">GRAND TOTAL</div>
                <div class="pricecont">&pound;<?= number_format($grang_total,2);?></div>
            </div>
        </div>
    @endif


    <div class="plainLineF">&nbsp;</div>
    <div class="clearfix"></div>
    <?php $tableNo = 1;?>
    @if(isset($content) && count($content) > 0)
      @foreach($content as $k=>$v)
      <?php $Grand1 = 0;//echo "<pre>";print_r($content);?>
        @if(isset($v['show_other']) && $v['show_other'] =='Y')
        <?php $tableNo++;?>
        <div id="anotherTable">
            <!-- <div class="plainLineH">&nbsp;</div> -->
            <div class="quoteMainBox">
                <div class="fillheader">
                    <div class="headcont" style="width:56%;">
                        {{ !empty($v['heading_name'])?strtoupper(strtolower($v['heading_name'])):'' }}
                    </div>
                @if(isset($v['package_type']) && $v['package_type'] != 'C')
                    <div class="headcont" style="width:33%;">Billed</div>
                    <div class="headcont">Fee (&pound;)</div>
                @endif
                    <div class="clearfix"></div>
                </div>
                <div class="inneOquoteBox">
                <?php $variable = $estimate = $amntDrop = $vat = 0;?>   
                @if(isset($v['services']) && count($v['services']) > 0)
                    @foreach($v['services'] as $k=>$vs)
                        <?php $num = 1;?>

                        <?php 
                            $Grand1 += $vs['preview_fees'];

                        ?>
                        

                        <!-- Calculation vat start -->
                        @if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee')
                            <?php $vat = $vat + ($vs['taxPercent']*$vs['preview_fees'])/100;?>
                        @endif
                        <!-- Calculation vat end -->

                        <div class="servCnt">
                            <div class="borderbottom">
                                <div class="actText">
                                    {{ !empty($vs['service_name'])?ucwords(strtolower($vs['service_name'])):'' }} 
                                    @if(isset($vs['notes']) && $vs['notes'] != '')
                                        <sup><?= $num;$num++;?></sup>
                                    @endif
                                </div>
                                <div class="billed">{{$vs['billing_freq'] or ''}}</div>
                                <div class="clickArro">
                                    <a href="javascript:void(0)" class="clickArro_a" data-id="{{ $v['id']}}_{{ $vs['p_service_id']}}"><i class="fa fa-angle-down upDownArrow"></i></a>
                                </div>
                                <div class="tblDrpType">
                                    {{ (!empty($vs['feesTableDtls']['table_type']))?$vs['feesTableDtls']['table_type']:'' }}
                                </div>
                                <div class="servPrc"> 
                                    <!-- {{ !empty($vs['preview_fees'])?number_format($vs['preview_fees'],2):'0.00'}} -->
            <!-- @if(isset($vs['feesTableDtls']['table_type']) && $vs['feesTableDtls']['table_type']=='Variable')
                <?php $variable = 1;?>Variable
            @elseif(isset($vs['feesTableDtls']['table_type']) && $vs['feesTableDtls']['table_type']=='Estimate')
                <?php $estimate = 1;?>Estimate
            @endif&nbsp;&nbsp; -->
            <?php $amntDrop = 1;?>
            @if($vs['is_show_fees']=='N')
                <!-- {{(!empty($vs['preview_fees']))?number_format($vs['preview_fees'],2):'0.00'}} -->
                @if($v['package_type'] != 'O' && $v['package_type'] != 'C')
                   {{!empty($vs['preview_fees'])?number_format($vs['preview_fees'],2):'0.00'}}
                @endif
            @endif
            
                                </div>
                            </div>

                        <div class="col-md-12 actvCont" style="display:none;" id="service_{{ $v['id']}}_{{ $vs['p_service_id']}}">
                        @if(isset($vs['feesTableDtls']['details']) && count($vs['feesTableDtls']['details'])>0)
                            <table class="feesTable">
                                @foreach($vs['feesTableDtls']['details'] as $k=>$vt) 
                                <tr>
                                    <td>{{ $vt['desc'] or '' }}</td>
                                    <td>{{ $vt['fees'] or '' }}</td>
                                </tr>
                                @endforeach
                            </table>
                        @endif

                            <?php $option1 = $option2 = $option3 = 0;?>
                            @if(isset($vs['activities']) && count($vs['activities'])>0)
                                @foreach($vs['activities'] as $k=>$vsa)
                                    <?php 
                                        if($vsa['activity_option'] == 1)$option1 = 1;
                                        if($vsa['activity_option'] == 2)$option2 = 2;
                                        if($vsa['activity_option'] == 3)$option3 = 3;
                                    ?>
                                @endforeach
                            @endif

                        @if($option1 == 1)
                            <div class="actsubcontOthr">
                                <div class="actsubcontTl">This service includes :-</div>
                                <ul class="actsubsub">
                                @if(isset($vs['activities']) && count($vs['activities'])>0)
                                  @foreach($vs['activities'] as $k=>$vsa)
                                    @if($vsa['activity_option'] == 1)
                                    <li>
                                        <div class="actsubimg"><img src="/img/black_right.png"></div>
                                        <div class="lileft">{{$vsa['name'] or ''}} 
                                        @if(isset($vsa['notes']) && $vsa['notes'] != '')
                                            <sup><?= $num;$num++;?></sup>
                                        @endif
                                        </div>
                                        <div class="liright">
                                            @if($vsa['is_show_fees'] != 'Y')
                                                {{ !empty($vsa['fees'])?number_format($vsa['fees'],2):'0.00'}}
                                            @endif
                                        </div>
                                    </li>
                                    @endif
                                  @endforeach
                                @endif
                                </ul>
                            </div>
                        @endif

                        @if($option2 == 2)
                            <div class="actsubcont">
                                <div class="actsubcontTl">Disbursement & Recharges :-</div>
                                <ul class="actsubsub">
                                @if(isset($vs['activities']) && count($vs['activities'])>0)
                                  @foreach($vs['activities'] as $k=>$vsa)
                                    @if($vsa['activity_option'] == 2)
                                    <li>
                                        <div class="actsubimg"><img src="/img/black_right.png"></div>
                                        <div class="lileft">{{$vsa['name'] or ''}} 
                                        @if(isset($vsa['notes']) && $vsa['notes'] != '')
                                            <sup><?= $num;$num++;?></sup>
                                        @endif
                                        </div>
                                        <div class="liright">
                                        @if($vsa['is_show_fees'] != 'Y')
                                            {{ !empty($vsa['fees'])?number_format($vsa['fees'],2):'0.00'}}
                                        @endif
                                        </div>
                                    </li>
                                    @endif
                                @endforeach
                                @endif
                                </ul>
                            </div>
                        @endif

                        @if($option3 == 3)
                            <div class="actsubcontOthr">
                                <div class="actsubcontTl">Optional Services :-</div>
                                <ul class="actsubsub">
                                @if(isset($vs['activities']) && count($vs['activities'])>0)
                                  @foreach($vs['activities'] as $k=>$vsa)
                                    @if($vsa['activity_option'] == 3)
                                    <li>
                                        <div class="actsubimg"><img src="/img/black_right.png"></div>
                                        <div class="lileft">{{$vsa['name'] or ''}} 
                                            @if(isset($vsa['notes']) && $vsa['notes'] != '')
                                                <sup><?= $num;$num++;?></sup>
                                            @endif
                                        </div>
                                        <div class="liright">{{ !empty($vsa['fees'])?number_format($vsa['fees'],2):'0.00'}}</div>
                                    </li>
                                    <?php $optional_total1 += str_replace(',', '', $vsa['fees']);?>
                                    @endif
                                @endforeach
                                @endif
                                </ul>
                            </div>
                        @endif

                        @if($num > 1)    
                            <div class="actsubcontOthr">
                                <div class="notesHead">Notes:</div>
                                <ul class="notesHeadUl">
                                <?php $not=1;?>
                                @if(isset($vs['notes']) && $vs['notes'] != '')
                                    <li><?= $not;$not++;?>. {{ $vs['notes'] or '' }}</li>
                                @endif
                                @if(isset($vs['activities']) && count($vs['activities'])>0)
                                  @foreach($vs['activities'] as $k=>$vsa)
                                    @if(isset($vsa['notes']) && $vsa['notes'] != '')
                                        <li><?= $not;$not++;?>. {{ $vsa['notes'] or '' }}</li>
                                    @endif
                                  @endforeach
                                @endif
                                </ul>
                            </div>
                        @endif

                        </div>
                    </div>
                  @endforeach
                @endif

                <!-- Total Section start -->
            @if(isset($v['package_type']) && $v['package_type'] != 'C' && $v['package_type'] != 'O')
                <div class="servCntTotal">
                    <div class="borderbottom" style="margin-top: 10px;">
                        <div class="actText"><strong>TOTAL</strong></div>
                        <div class="net"><strong>NET</strong></div>
                        <div class="clickArro">
                            <a href="javascript:void(0)" class="clickArro_a" data-id="<?=$tableNo?>"><i class="fa fa-angle-down upDownArrow"></i></a>
                        </div>
                        <div class="servPrc"><strong>{{number_format($Grand1,2)}}</strong></div>
                    </div>
                    <div class="col-md-12 actvCont" style="display:none;" id="service_<?=$tableNo?>">
                        <table style="width: 100%;float: left;">
                            <tr>
                                <td style="width: 57%">&nbsp;</td>
                                <td width="28%" style="font-style: italic;">VAT</td>
                                <td align="right">{{number_format($vat,2)}}</td>
                            </tr>
                            <tr>
                                <td style="width: 57%">&nbsp;</td>
                                <td><strong style="font-style: italic;">GROSS</strong></td>
                                <td align="right">
                                <?php $gross = $Grand1+$vat;?>
                                <strong>{{number_format($gross,2)}}</strong></td>
                            </tr>

                        @if(isset($v['billing']) && count($v['billing']) > 0)
                            <tr>
                                <td colspan="3"><span style="text-decoration: underline; float: left;margin-top: 25px;">Billing Schedule</span></td>
                            </tr>
                            @foreach($v['billing'] as $kb=>$bv)
                            <tr>
                                <td colspan="2">
                                    <div style="float: left; width: 50%">To be paid {{$kb}}</div>
                                    <div style="float:left;width:8%;text-align:right">{{$bv['left']}}</div>
                                    <div style="float:left;width:3%;text-align:right; margin-right: 5px;">x</div>
                                    <div style="float:left;min-width:15%;text-align:right;width: auto;">{{$bv['right']}}</div>
                                </td>
                                
                                <td align="right"><strong>{{$bv['amount']}}</strong></td>
                            </tr>
                            @endforeach
                        @endif
                        </table>
                                                    
                    </div>
                </div>
            @endif
                <!-- Total Section end -->


                                      
            </div>



                <!-- <div class="fillfooter">
                    <div class="headcont" style="width: 20%;">TOTAL</div>
                    <div class="pricecont">&pound;

                    <?php if($amntDrop == 1)echo number_format($Grand1,2);?>  
                    <?php if($estimate == 1 || $variable == 1)echo ' + ';?>  
                    <?php if($estimate == 1)echo 'Estimate';?>
                    <?php if($estimate == 1 && $variable == 1)echo ' / ';?>
                    <?php if($variable == 1)echo 'Variable';?>
                    </div>
                </div> -->
            </div>
            <div class="thineLine">&nbsp;</div>
            <div class="plainLineF">&nbsp;</div>
            
            <div class="clearfix"></div>
        </div>
        @endif
      @endforeach
    @endif
    </div>
    <div class="blue_boldline"></div>
    <div class="blue_footer"></div>
</div>
                <!--/.Panel 3-->

                <!--Panel 4-->
                <div class="tab-pane fade" id="panel4" role="tabpanel">
                    <div class="blue_line"></div>
                    <div class="blue_boldline"></div>
                    <div class="conTentBox" style="margin-bottom: 25px;">
                        <div class="headText">&nbsp;</div>
                        <div class="attachBox">
                            @if(isset($attachments) && count($attachments) >0)
                                @foreach($attachments as $k=>$v)
                                <ul class="nav attachul">
                                    <li style="width: 90%; float: left;"><a href="javascript:void(0)" class="attachTitle">{{ $v['title'] or '' }}</a></li>
                                  <li class="dropdown open" style="float: right;">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle h3dot"><b>⋮</b></a>
                                    <ul class="dropdown-menu">
                                      <li><a href="javascript:void(0)" class="attach_file_readme" data-title="{{ $v['title'] or '' }}" data-notes="{{ $v['notes'] or '' }}"><i class="fa fa-edit tiny-icon"></i>Readme</a></li>
                                      <li><a href="javascript:void(0)" data-file="{{ $v['file'] or '' }}" class="btn btn-xs btn-primary attach_file_preview"><i class="fa fa-eye tiny-icon"></i> Preview</a></li>                 
                                    </ul>
                                  </li> 
                                </ul>
                                @endforeach
                            @endif
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="blue_boldline"></div>
                    <div class="blue_footer"></div>
                </div>
                <!--/.Panel 4-->

                <!--Panel 5-->
                <div class="tab-pane fade" id="panel5" role="tabpanel">
                    <div class="blue_line"></div>
                    <div class="blue_boldline"></div>
                    <div class="conTentBox" style="margin-bottom: 25px;">
                        <div class="headText">Terms and Conditions</div>
                        <p>Please review the terms and conditions of this proposal.</p>
                        <div class="quoteSummaryBox" style="padding: 0px 10px;">
                            {{ $terms['description'] or '' }}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="blue_boldline"></div>
                    <div class="blue_footer"></div>
                </div>
                <!--/.Panel 5-->

                <!--Panel 6-->
                <div class="tab-pane fade" id="panel6" role="tabpanel">
                    <div class="blue_line"></div>
                    <div class="blue_boldline"></div>
                    <div class="conTentBox" style="margin-bottom: 25px;">
                      <div class="attachBox">
                        <div class="signArea" id="signatureSection">
                        <div class="show_loader"></div>
                        @if(isset($signedData) && count($signedData) >0)
                            <!-- <p class="signedAccept">{{($signedData['save_type']=='A' || $signedData['save_type']=='MA')?'Signed & Accepted':'Declined'}}</p>
                            <div class="col-md-12">
                                <p class="signedText">
                                    @if($signedData['save_type'] == 'MA')
                                        Marked as Accepted
                                    @elseif($signedData['save_type'] == 'ML')
                                        Marked as Lost
                                    @else
                                        {{ $signedData['signature'] or '' }}
                                    @endif
                                </p>
                                <p>{{ $signedData['added'] or '' }}</p>
                                <p>Ip Address : {{ $signedData['ip_address'] or '' }}</p>
                                <p><a href="#">View Signed Engagement Letter</a></p>
                            </div> -->
                            @include('crm/proposal/proposals/ajax_signed_popup')
                        @else
                            <div class="headText" style="margin-bottom: 30px;">Add Your Signature</div>
                            <p>Type your signature below.</p>
                            <p><input type="text" class="form-control signatureText" placeholder="Type your name" value="{{ $signedName or '' }}" id="signatureText" /></p>
                            <p>By clicking accept, you agree to the terms of this proposal. If you have any questions please don't accept and submit your question in the section below.</p>

                            <p style="margin-top: 30px;"><button type="button" class="btn sign-btn acceptSigned"data-action_type="A"><i class="fa fa-check"></i> Accept Proposal</button></p>
                            <p><button type="button" class="btn reject-btn acceptSigned" id="rejectSigned" data-action_type="L"><i class="fa fa-times" aria-hidden="true"></i> Decline proposal</button></p> 
                        @endif
                        </div>

                        <div class="cmntArea">
                            <p class="smallCmntHead">Comments</p>
                            <p>Please submit any questions you have and we wi'll get back to you shortly.</p>
                        <form method="post" action="/proposal-preview/action" id="commentForm">
                            <input type="hidden" name="crm_proposal_id" value="{{$crm_proposal_id}}">
                            <input type="hidden" name="action" value="saveCommentInPreview">
                            <input type="hidden" name="added_from" value="preview">
                            <p><textarea class="form-control classy-editor" rows="3" name="comment_text" id="comment_text"></textarea></p>
                            <p><button type="button" class="commentIcon" id="postComment"><i class="fa fa-comment "></i> Post Comment</button></p>
                        </form>
                            <div class="clearfix"></div>
                        </div>

                            <div class="col-md-12" id="postCommentArea" style="padding: 0;">
                                @include('crm/proposal/proposals/ajax_comment_preview')
                            </div>

                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="blue_boldline"></div>
                    <div class="blue_footer"></div>
                </div>
                <!--/.Panel 5-->

            </div>
        </div>

    </div>

    </body>
@include('crm/modal/attachment_preview')
<div class="modal fade" id="notesReadme-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><a href="javascript:void(0)"><span class="addNewName"></span></a></h4>
        <div class="clearfix"></div>
      </div>
      <div class="modal-body">
        <div class="show_loader"></div>
        <div class="form-group" id="contentArea">
          
        </div>
      </div>
    </div>
  </div>
</div>

<script src="{{ URL :: asset('js/jquery-1.11.0.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery-ui-1.10.3.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/proposal_preview.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/proposal.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/summernote.js') }}"></script>

<script type="text/javascript">
    var base_url = $('#base_url').val();
</script>

<!-- Editor -->
<script src="{{ URL :: asset('classy-editor/js/jquery.classyedit.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL :: asset('classy-editor/css/jquery.classyedit.css') }}" />
<script type="text/javascript">
$(document).ready(function() {
    $(".classy-editor").ClassyEdit();
});
</script>
</html>