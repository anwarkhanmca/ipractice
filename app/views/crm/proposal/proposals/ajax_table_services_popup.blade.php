<?php $p_service_ids = array();?>
@if(isset($services) && count($services) > 0)
  @foreach($services as $k=>$vs)
    <tr data-p_service_id="{{$vs['p_service_id'] or ''}}" id="serviceRowPop_{{$vs['p_service_id'] or ''}}">
      <td>
        <div style="float: left; width: 95%">{{ $vs['service_name'] or '' }}</div>
        <!-- <div class="left"><a href="javascript:void(0)" class="innerSubTable" data-sub_no="{{$vs['p_service_id'] or ''}}" data-type="down"><img src="/img/arrows-down.png"></a></div> -->
      </td>

      <td style="width:12%">
        <div style="float: left;margin-right: 5px;">Add Activities</div>
        <!-- <div style="float: left; margin-right: 2px; width: 32px;">
          <a href="javascript:void(0)" class="round_plus newProposalActivityPop" data-p_service_id="{{$vs['p_service_id'] or ''}}" data-service_id="{{$vs['service_id'] or ''}}" data-service_name="{{$vs['service_name'] or ''}}"><img src="/img/plus_1.png"></a>
        </div> -->
        <div style="float: left;margin-top: 2px;">
          <a href="javascript:void(0)" class="viewProposalActivityPop" data-p_service_id="{{$vs['p_service_id'] or ''}}" data-service_id="{{$vs['service_id'] or ''}}" data-service_name="{{ $vs['service_name'] or ''}}"><i class="fa fa-list tiny-icon"></i></a>
        </div>
      </td>

      <td>
        <select class="form-control newdropdown singleFieldChange {{ ($package_type=='C')?'disable_click':'' }}" data-id_name="p_service_id" data-id_value="{{$vs['p_service_id']}}" data-table_name="crm_proposal_services" data-update_column="billing_freq" >
          <option value="">None</option>
          <option value="Monthly" {{(isset($vs['billing_freq']) && $vs['billing_freq']=='Monthly')?'selected':''}}>Monthly</option>
          <option value="Six Monthly" {{(isset($vs['billing_freq']) && $vs['billing_freq']=='Six Monthly')?'selected':''}}>Six Monthly</option>
          <option value="Quarterly" {{(isset($vs['billing_freq']) && $vs['billing_freq']=='Quarterly')?'selected':''}}>Quarterly</option>
          <option value="Yearly" {{(isset($vs['billing_freq']) && $vs['billing_freq']=='Yearly')?'selected':''}}>Yearly</option>
          <option value="In Advance" {{(isset($vs['billing_freq']) && $vs['billing_freq']=='In Advance')?'selected':''}}>In Advance</option>
          <option value="On Completion" {{(isset($vs['billing_freq']) && $vs['billing_freq']=='On Completion')?'selected':''}}>On Completion</option>
        </select>
      </td>

      <td>
        <select class="form-control newdropdown singleFieldChange {{ ($package_type=='C')?'disable_click':'' }}" data-id_name="p_service_id" data-id_value="{{$vs['p_service_id']}}" data-table_name="crm_proposal_services" data-update_column="tax_rate">
          <option value="">Tax Rate</option>
          @if(isset($tax_rates) && count($tax_rates) >0)
            @foreach($tax_rates as $k=>$v)
              <option value="{{ $v['tax_rate_id'] or '' }}" {{ (isset($vs['taxRate']) && $vs['taxRate'] == $v['tax_rate_id'])?'selected':'' }}>{{ $v['name'] or '' }}</option>
            @endforeach
          @endif
        </select>
      </td>

      <td id="AddServTableTd_{{$vs['p_service_id'] or ''}}">
        <!-- <select class="form-control newdropdown activityFeeType" id="activityFeeType_{{$vs['p_service_id'] or ''}}" data-p_service_id="{{ $vs['p_service_id'] or ''}}" data-fees="{{ $vs['fees'] or ''}}">
          <option value="fixed_fee" {{ ($vs['fee_type'] == 'fixed_fee')?'selected':'' }}>No Table</option>
          <option value="fee_table" {{ ($vs['fee_type'] == 'fee_table')?'selected':'' }}>New Table</option>
          @if(isset($tables) && count($tables) >0)
            @foreach($tables as $k=>$v)
              <option value="{{ $v['id'] or '' }}" {{ (isset($vs['fee_type']) && $vs['fee_type'] == $v['id'])?'selected':'' }}>{{ $v['table_name'] or '' }}</option>
            @endforeach
          @endif
        </select>  --> 
        @if($vs['table_id'] > 0) 
          <a href="javascript:void(0)" class="center openAddOpperFee" data-p_service_id="{{$vs['p_service_id'] or ''}}" data-id="0" data-action_type="view_proposal_table">View Table</a> &nbsp;
          <a href="javascript:void(0)" class="delete_service_table" data-p_service_id="{{$vs['p_service_id'] or ''}}" data-id="{{$vs['table_id'] or '0'}}" data-delete_type="proposal_service_table"><img src="/img/cross.png" height="12"></a>
        @else
          <a href="javascript:void(0)" class="openViewServiceTales" data-p_service_id="{{$vs['p_service_id'] or ''}}" data-action_type="add_service_table">Add..</a>  
        @endif                                   
      </td>

      <td align="center">
        <?php $disabled = '';?>
        @if(isset($vs['fee_type']) && $vs['fee_type'] == 'fee_table')
          <?php $disabled = 'disabled';?>
        @elseif(isset($vs['fee_type']) && is_numeric($vs['fee_type']) && $vs['fee_type'] > '0')
          <?php $disabled = 'disabled';?>
        @endif
        <!-- <input type="text" class="priceRound proposalHrsFees" data-type="service" data-column_name="hrs" data-table_id="{{$vs['p_service_id'] or ''}}" value="{{ $vs['hrs'] or ''}}" id="service_hrs_{{$vs['p_service_id'] or ''}}" disabled> -->
        <input type="number" class="flexFees changeFlexFees" data-type="service" data-column_name="flex_fees" data-table_id="{{$vs['p_service_id'] or ''}}" value="{{ $vs['flex_fees'] or '0'}}" id="service_flexFees_{{$vs['p_service_id'] or ''}}" step=1 min="1"  {{ $disabled }}>
      </td>

      <td id="servPopFeesCol_{{$vs['p_service_id'] or ''}}">
        @if(isset($vs['fee_type']) && $vs['fee_type'] == 'free_text')
          <input type="text" class="priceRound proposalHrsFees" data-type="service" data-column_name="fees"  data-table_id="{{$vs['p_service_id'] or ''}}" value="{{ $vs['fees'] or ''}}" id="service_fees_{{$vs['p_service_id'] or ''}}" >
        @else
          <input type="text" class="priceRound proposalHrsFees" data-type="service" data-column_name="fees"  data-table_id="{{$vs['p_service_id'] or ''}}" value="{{ $vs['fees'] or ''}}" id="service_fees_{{$vs['p_service_id'] or ''}}" {{($vs['isFeeAdded'] == 'Y')?'disabled':''}}>
        @endif
      <!-- @if(isset($vs['fee_type']) && $vs['fee_type'] == 'free_text')
        <input type="text" class="priceRound proposalHrsFees" data-type="service" data-column_name="fees"  data-table_id="{{$vs['p_service_id'] or ''}}" value="{{ $vs['fees'] or ''}}" id="service_fees_{{$vs['p_service_id'] or ''}}" >
      @elseif(isset($vs['fee_type']) && $vs['fee_type'] == 'fee_table')
        <?php $disabled = 'disabled';?>
        <a href="javascript:void(0)" class="openAddOpperFee" data-p_service_id="{{$vs['p_service_id'] or ''}}" data-action="add">Add..</a>
      @elseif(isset($vs['fee_type']) && is_numeric($vs['fee_type']) && $vs['fee_type'] > '0')
        <?php $disabled = 'disabled';?>
        <div style="float: left;">
          <a href="javascript:void(0)" class="openAddOpperFee" data-p_service_id="{{$vs['p_service_id'] or ''}}" data-action="view" style="text-align: left;">View Table</a>
        </div>
        <div style="float: right;">
          <a href="javascript:void(0)" class="deleteServiceTable" data-p_service_id="{{$vs['p_service_id'] or ''}}" style="text-align: right;"><img src="/img/cross.png" height="12"></a>
        </div>  
      @else
        <input type="text" class="priceRound proposalHrsFees" data-type="service" data-column_name="fees"  data-table_id="{{$vs['p_service_id'] or ''}}" value="{{ $vs['fees'] or ''}}" id="service_fees_{{$vs['p_service_id'] or ''}}" {{($vs['isFeeAdded'] == 'Y')?'disabled':''}}>
      @endif -->
      
      </td>

      <td style="width:6%; text-align: center;">
          <span class="custom_chk" style="float: left; margin-top: 3px;">
            <!-- <input type="checkbox" id="ServTable_{{$vs['p_service_id'] or ''}}" class="service_fees_check" value="{{$v['heading_id'] or ''}}" data-heading_id="{{$v['heading_id'] or ''}}" {{ $disabled }} /> -->
            <input type="checkbox" id="ServTable_{{$vs['p_service_id'] or ''}}" class="show_fees_check" value="{{$vs['p_service_id'] or ''}}" data-popup="service" {{(isset($vs['is_show_fees']) && $vs['is_show_fees']=='Y')?'checked':''}} {{ $disabled }} {{ ($package_type=='C')?'disabled':'' }}/>
            <label style="width:0px!important" for="ServTable_{{$vs['p_service_id'] or ''}}">&nbsp;</label>
          </span> <img src="/img/question_frame.png" title="Do not display fee seperately in proposal"> 
      </td>

      <td align="center"><a href="javascript:void(0)" class="notes_btn proposalNotes" data-table_id="{{$vs['p_service_id'] or ''}}" data-name="{{$vs['service_name'] or ''}}" data-type="service">notes</a>
      </td>

      <td align="center">
          <a href="javascript:void(0)" class="deletePopupRow" data-table_id="{{$vs['p_service_id'] or ''}}" data-type="service"><img src="/img/cross.png" height="12"></a>
      </td>
    </tr>
    <?php $p_service_ids[] = $vs['p_service_id'];?>
  @endforeach
@endif

<input type="hidden" id="p_service_ids" value="<?php echo implode(',', $p_service_ids);?>">
<input type="hidden" id="table_name" value="crm_proposal_services">
<input type="hidden" id="table_id_name" value="p_service_id">

<script type="text/javascript">
$(document).ready(function(){
  $('.priceRound').priceFormat({
    prefix: '',
  });

  $('input[type="number"]').keydown(function (e) {
    e.preventDefault();
  });

});
</script>
ipractice
{{ $totalAmnt or '0.00' }}
ipractice
{{ $package_type or '' }}