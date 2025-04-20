@if(isset($activities) && count($activities) >0)
  @foreach($activities as $key=>$value)
    @if($value['is_archive'] == 'N')
      <tr id="change_activity_tr_{{ $value['activity_id'] or "" }}">
        <td align="center">
          <span class="custom_chk"><input type="checkbox" id="act_check_{{ $value['activity_id']}}" class="activity_check" {{ (isset($value['table_show']) && $value['table_show'] > 0)?"checked":'' }} value="{{ $value['activity_id'] or '' }}" data-activity_id="{{ $value['activity_id'] }}" /><label style="width:0px!important" for="act_check_{{ $value['activity_id'] or "" }}">&nbsp;</label></span>
        </td>
        <td>
          <span id="activity_span{{$value['activity_id'] or ""}}">{{$value['name'] or ""}}</span>
        </td>
        <td align="right"><span id="activity_base_span{{$value['activity_id'] or ""}}">{{$value['base_fee'] or ""}}</span></td>
        <td align="center">
          <span id="activity_action_{{ $value['activity_id'] or "" }}"><a href="javascript:void(0)" class="editActivity" data-activity_id="{{ $value['activity_id'] or "" }}"><img src="/img/edit_icon.png"></a> 
          <!-- <a href="javascript:void(0)" class="deleteActivity" data-activity_id="{{ $value['activity_id'] or "" }}"><img src="/img/cross.png" height="12"></a> -->
      </span>
        </td>
      </tr>
    @endif
  @endforeach
@endif