<?php $p_activity_ids = array();?>
@if(isset($activities) && count($activities) > 0)
  @foreach($activities as $k=>$vs)
    <tr data-p_activity_id="{{$vs['p_activity_id'] or ''}}" id="activityRowPop_{{$vs['p_activity_id'] or ''}}">
      <td>
        <div style="float: left; width: 95%">{{ $vs['name'] or '' }}</div>
      </td>
      <td>
        <select class="form-control newdropdown crmActivityOption" data-p_activity_id="{{$vs['p_activity_id'] or ''}}" data-p_service_id="{{$vs['p_service_id'] or ''}}">
          <option value="1" {{(isset($vs['activity_option']) && $vs['activity_option']==1)?'selected':''}}>Chargeable</option>
          <option value="2" {{(isset($vs['activity_option']) && $vs['activity_option']==2)?'selected':''}}>Disbursement and Recharges</option>
          <option value="3" {{(isset($vs['activity_option']) && $vs['activity_option']==3)?'selected':''}}>Optional</option>
        </select>                                            
      </td>
      <td align="center">
        <input type="number" class="flexFees changeFlexFees" data-type="activity" data-column_name="flex_fees" data-table_id="{{$vs['p_activity_id'] or ''}}" value="{{ $vs['flex_fees'] or '0'}}" step=1 min="1" id="changeFlexFees_{{$vs['p_activity_id'] or ''}}" data-p_service_id="{{$vs['p_service_id'] or ''}}" data-isFeeAdded="{{ $isFeeAdded or '' }}">
      </td>

      <td>
        <input type="text" class="priceRound proposalHrsFees" data-type="activity" data-column_name="fees" data-table_id="{{$vs['p_activity_id'] or ''}}" value="{{ $vs['fees'] or ''}}" id="ActAnnualFee_{{$vs['p_activity_id'] or ''}}" data-p_service_id="{{$vs['p_service_id'] or ''}}" data-isFeeAdded="{{ $isFeeAdded or '' }}">
      </td><!-- fees -->

      <td style="width:6%; text-align: center;">
          <span class="custom_chk" style="float: left; margin-top: 3px;"><input type="checkbox" id="acttable_{{$vs['p_activity_id'] or ''}}" class="show_fees_check" value="{{$vs['p_activity_id'] or ''}}" data-popup="activity" {{(isset($vs['is_show_fees']) && $vs['is_show_fees']=='Y')?'checked':''}} {{ ($package_type=='C')?'disabled':'' }}/><label style="width:0px!important" for="acttable_{{$vs['p_activity_id'] or ''}}">&nbsp;</label></span> <img src="/img/question_frame.png" title="Do not display fee seperately in proposal"> 
      </td>
      <td align="center"><a href="javascript:void(0)" class="notes_btn proposalNotes" data-table_id="{{$vs['p_activity_id'] or ''}}" data-name="{{$vs['name'] or ''}}" data-type="activity">notes</a></td>
      <td align="center">
        <a href="javascript:void(0)" class="deletePopupRow" data-table_id="{{$vs['p_activity_id'] or ''}}" data-type="activity"><img src="/img/cross.png" height="12"></a>
      </td>
    </tr>
    <?php $p_activity_ids[] = $vs['p_activity_id'];?>
  @endforeach
@endif

<input type="hidden" id="p_activity_ids" value="<?php echo implode(',', $p_activity_ids);?>">
<input type="hidden" id="act_table_name" value="crm_proposal_activities">
<input type="hidden" id="tableIdName" value="p_activity_id">

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
anwar
{{ $isFeeAdded or '' }}
anwar
{{ $TotalServiceFees or '' }}
anwar
{{ $p_table_id or '' }}
anwar
{{ $TotalTableFees or '' }}