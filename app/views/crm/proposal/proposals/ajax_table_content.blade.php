<?php
//echo "<pre>";print_r($content);die;
?>

<?php $ids = array();$grandTotal = $tableHeading = 0;$headings = array();?>
@if(isset($content) && count($content) > 0)
    @foreach($content as $k=>$v)
        <?php //$Grand1 = 0;?>
        @if(isset($v['is_show']) && $v['is_show'] == 'G')
        <?php $Grand1 = 0;?>
        <?php $vat = 0;?>  
        @if(isset($v['show_group']) && $v['show_group'] =='Y') 
            @if(isset($v['services']) && count($v['services']) > 0)
                @foreach($v['services'] as $k=>$vs)
                    <?php $vat = 0;?>  
                    <?php $Grand1 = $vs['preview_fees'];?>
                    @if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee')
                        <?php $vat = $vat + ($vs['taxPercent']*$vs['preview_fees'])/100;?>
                    @endif
                @endforeach
            @endif
        @endif

        @if(isset($v['show_other']) && $v['show_other'] =='Y') 
            @if(isset($v['services']) && count($v['services']) > 0)
                @foreach($v['services'] as $k=>$vs)
                    <?php $vat = 0;?>  
                    <?php $Grand1 = $vs['preview_fees'];?>
                    @if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee')
                        <?php $vat = $vat + ($vs['taxPercent']*$vs['preview_fees'])/100;?>
                    @endif
                @endforeach
            @endif
        @endif

        <div class="row connectedSortable" data-id="{{$v['id'] or ''}}">
            <div class="col-md-12 bottom_5">
                <table style="width:100%">
                    <?php if($tableHeading==0){?>
                    <tr>
                        <td width="50%" style="padding-left: 12px;"><b>PACKAGE</b></td>
                        <td width="18%"><b>TYPE</b></td>
                        <td width="10%"><b>SERVICES</b></td>
                        <td colspan="2" style="padding-left: 120px;"><b>SUB TOTAL</b></td>
                    </tr>
                    <?php $tableHeading++;}?>
                    <tr style="background-color: #eaeae1;">
                        <td width="50%">
                            <div class="tableTabheader" data-no="{{$v['heading_id'] or ''}}" data-type="up">
                            {{ $v['heading_name'] or ''}}</div>
                        </td>
                        <td width="18%" style="font-weight: bold; font-style: italic;">
                        @if($v['package_type'] == 'R')Recurring
                        @elseif($v['package_type'] == 'F')One - off
                        @elseif($v['package_type'] == 'O')Optional
                        @elseif($v['package_type'] == 'C')Complementary
                        @else
                            {{ $v['package_type'] or ''}}
                        @endif
                        </td>
                        <td style="width:10%;">
                            <div style="float: left;margin-top: 2px; margin-left: 20px;">
                                <a href="javascript:void(0)" class="viewProposalServicePop" data-crm_proptbl_id="{{ $v['id'] or ''}}" data-heading_name="{{ $v['heading_name'] or ''}}" data-heading_id="{{ $v['heading_id'] or ''}}" data-proposal_id="{{$v['proposal_id'] or ''}}" data-is_show="G"><i class="fa fa-list tiny-icon"></i></a>
                            </div>
                        </td>

                        <td style="width:15%">
                            <div class="tablePrice" id="table_fees_{{ $v['id'] or ''}}">
                                <?php $gross = $Grand1+$vat;?>
                                <!-- {{ !empty($v['fees'])?number_format($v['fees'], 2):''}} -->
                        {{($v['package_type']=='O' || $v['package_type']=='C')?'':'£ '.number_format($gross,2)}}
                            </div>
                            <!-- <input type="text" class="priceRound" id="table_fees_{{ $v['id'] or ''}}" value="{{ !empty($v['fees'])?number_format($v['fees'], 2):''}}" readonly> -->
                        </td>
                        <!-- <td style="width:5%; border-right: 1px solid #fff; text-align: center;">
                            <span class="custom_chk"><input type="checkbox" id="table_2{{$v['heading_id'] or ''}}" class="heading_service_check" value="{{$v['heading_id'] or ''}}" data-heading_id="{{$v['heading_id'] or ''}}" /><label style="width:0px!important" for="table_2{{$v['heading_id'] or ''}}">&nbsp;</label></span> <img src="/img/question_frame.png" title="Do not display fee seperately in proposal"> 
                        </td> -->
                        <td style="width:4%; text-align: center; cursor: move;">
                            <a href="javascript:void(0)"><img src="/img/dotted_icon.png" height="12"></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php 
            $ids[] = $v['id'];
            $grandTotal += $v['fees'];
            array_push($headings, $v['heading_id']);
        ?>
        @endif
    @endforeach
@endif

<!-- <div class="row">
    <div class="col-md-12 bottom_5">
        <table style="width:100%">
            <tr style="background-color: #eaeae1;">
                <td><div class="tableTabheader">GRAND TOTAL</div></td>
                <td style="width:9%">&nbsp;</td>
                <td style="width:7%">
                    Total &nbsp;&nbsp;&nbsp;£
                </td>
                <td style="width:14%; text-align: right; padding-right: 9px;">
                    <strong id="grandTotal">{{ number_format($grandTotal, 2) }}</strong>
                </td>

                <td style="width:4%; text-align: center; cursor: move;">
                    <a href="javascript:void(0)"><img src="/img/dotted_icon.png" height="12"></a>
                </td>
            </tr>
        </table>
    </div>
</div> -->

@if(isset($content) && count($content) > 0)
  @foreach($content as $k=>$v)
    <?php //$Grand1 = 0;?>
    <?php $vat = 0;?>
    @if(isset($v['is_show']) && $v['is_show'] == 'O')
    <?php $Grand1 = 0;?>
    <?php $vat = 0;?>  
        <!-- @if(isset($v['show_group']) && $v['show_group'] =='Y') 
            @if(isset($v['services']) && count($v['services']) > 0)
                @foreach($v['services'] as $k=>$vs)
                    <?php $Grand1 = $vs['preview_fees'];?>
                    @if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee')
                        <?php $vat = $vat + ($vs['taxPercent']*$vs['preview_fees'])/100;?>
                    @endif
                @endforeach
            @endif
        @endif -->

        @if(isset($v['show_other']) && $v['show_other'] =='Y') 
            @if(isset($v['services']) && count($v['services']) > 0)
                @foreach($v['services'] as $k=>$vs)
                    <?php $vat = 0;?>
                    <?php $Grand1 = $vs['preview_fees'];?>
                    @if(isset($vs['fee_type']) && $vs['fee_type'] == 'fixed_fee')
                        <?php $vat = $vat + ($vs['taxPercent']*$vs['preview_fees'])/100;?>
                    @endif
                @endforeach
            @endif
        @endif

      @if(!in_array($v['heading_id'], $headings))
        <div class="row connectedSortable" data-id="{{$v['id'] or ''}}">
            <div class="col-md-12 bottom_5">
                <table style="width:100%">
                    <?php if($tableHeading==0){?>
                    <tr>
                        <td width="50%" style="padding-left: 12px;"><b>PACKAGE</b></td>
                        <td width="18%"><b>TYPE</b></td>
                        <td width="10%"><b>SERVICES</b></td>
                        <td colspan="2" style="padding-left: 120px;"><b>SUB TOTAL</b></td>
                    </tr>
                    <?php $tableHeading++;}?>
                    <tr style="background-color: #eaeae1;">
                        <td width="50%">
                            <div class="tableTabheader" data-no="{{$v['heading_id'] or ''}}" data-type="up">
                            {{ $v['heading_name'] or ''}}</div>
                        </td>
                        <td width="18%" style="font-weight: bold; font-style: italic;">
                            @if($v['package_type'] == 'R')Recurring
                            @elseif($v['package_type'] == 'F')One - off
                            @elseif($v['package_type'] == 'O')Optional
                            @elseif($v['package_type'] == 'C')Complementary
                            @else
                                {{ $v['package_type'] or ''}}
                            @endif
                        </td>
                        <td style="width:10%;">
                            <div style="float: left;margin-top: 2px; margin-left: 20px;">
                                <a href="javascript:void(0)" class="viewProposalServicePop" data-crm_proptbl_id="{{ $v['id'] or ''}}" data-heading_name="{{ $v['heading_name'] or ''}}" data-heading_id="{{ $v['heading_id'] or ''}}" data-proposal_id="{{$v['proposal_id'] or ''}}" data-is_show="O"><i class="fa fa-list tiny-icon"></i></a>
                            </div>
                        </td>
                        <td style="width:15%">
                            <div class="tablePrice" id="table_fees_{{ $v['id'] or ''}}">
                                <?php $gross = $Grand1+$vat;?>
                                <!-- {{ !empty($v['fees'])?number_format($v['fees'], 2):''}} -->
                        {{($v['package_type']=='O' || $v['package_type']=='C')?'':'£ '.number_format($gross,2)}}
                            </div>
                        </td>
                        <!-- <td style="width:5%; border-right: 1px solid #fff; text-align: center;">
                            <span class="custom_chk"><input type="checkbox" id="table_2{{$v['heading_id'] or ''}}" class="heading_service_check" value="{{$v['heading_id'] or ''}}" data-heading_id="{{$v['heading_id'] or ''}}" /><label style="width:0px!important" for="table_2{{$v['heading_id'] or ''}}">&nbsp;</label></span> <img src="/img/question_frame.png" title="Do not display fee seperately in proposal"> 
                        </td> -->
                        <td style="width:4%; text-align: center; cursor: move;">
                            <a href="javascript:void(0)"><img src="/img/dotted_icon.png" height="12"></a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
      @endif
    @endif
  @endforeach
@endif

<input type="hidden" id="ids" value="<?php echo implode(',', $ids);?>">
<input type="hidden" id="table" value="crm_proposal_tables">
<input type="hidden" id="sort_column" value="sorting">
<input type="hidden" id="id_name" value="id">