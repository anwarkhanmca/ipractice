@if(isset($services) && count($services) >0)
    @foreach($services as $key=>$value)
      @if($value['is_archive'] == 'N')
        <tr id="change_service_tr_{{ $value['service_id'] or "" }}">
          <td align="center">
            <span class="custom_chk"><input type="checkbox" id="service_{{ $value['service_id']}}" class="heading_service_check" {{ (isset($value['table_show']) && $value['table_show'] > 0)?"checked":'' }} value="{{ $value['service_id'] or '' }}" data-service_id="{{ $value['service_id'] }}" /><label style="width:0px!important" for="service_{{ $value['service_id'] or "" }}">&nbsp;</label></span>
          </td>
          <td align="center">
            @if($value['added_before'] > 0)
              <div class="blue_leave"></div>
            @endif
          </td>
          <td>
            <span id="service_span{{$value['service_id'] or ''}}">{{$value['service_name'] or ""}}</span>
          </td>
          <td align="right">
            <span id="service_base_span{{$value['service_id'] or ''}}">{{$value['base_fee'] or ""}}</span>
          </td>
          <td align="center">
            <span id="service_action_{{ $value['service_id'] or ''}}"><a href="javascript:void(0)" class="editServices" data-service_id="{{ $value['service_id'] or "" }}" data-status="{{ $value['status'] or "" }}"><img src="/img/edit_icon.png"></a> 
            <!-- @if($value['status'] == 'new')
              <a href="javascript:void(0)" class="deleteServices" data-service_id="{{ $value['service_id'] or "" }}"><img src="/img/cross.png" height="12"></a>
            @endif -->
            </span>
          </td>
        </tr>
      @endif
    @endforeach
@endif