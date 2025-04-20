@if(isset($clients) && count($clients) >0)
  @foreach($clients as $key=>$details)
    <tr class="even" id="client_{{ $details['client_id'] }}">
      <td>
        <input type='checkbox' class="checkbox applicable_Checkbox org_Checkbox" name="applicable_checkbox[]" value="{{ $details['client_id'] or "" }}" id="applicable_checkbox{{ $details['client_id'] }}" />
      </td>
      
      <td align="left">{{ $details['business_type'] or "" }}</td>
      <td align="left">
        <a target="_blank" href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}">{{ $details['client_name'] or "" }}</a>
      </td>
      <?php $k = 0;?>
      @for($i=1; $i <=5; $i++)
        @if(isset($details['allocationStaff']) && count($details['allocationStaff']) >0)
          @foreach($details['allocationStaff'] as $key=>$value)
            @if(isset($value['staff_name'.$i]) && $value['staff_name'.$i] != '')
              <?php $k = 1;break;?>
            @endif
          @endforeach
        @endif
      @endfor

      <td align="center"><a href="javascript:void(0)" class="openServicesStaff openAllocation openAllocation_{{ $details['client_id'] }} {{ (isset($details['services_id']) && in_array($service_id, $details['services_id']))?'':'disable_click' }}" data-client_id="{{ $details['client_id'] }}" data-service_id="{{$service_id or '0'}}" data-page_name="allocation">Edit</a></td>

      @for($i=1; $i <=5; $i++)
        <td align="left" class="orgStaff_{{$i}}_{{ $details['client_id'] }}">
          <?php $k = 0;?>
          @if(isset($details['allocationStaff']) && count($details['allocationStaff']) >0)
            @foreach($details['allocationStaff'] as $key=>$value)
              @if(isset($value['staff_name'.$i]) && $value['staff_name'.$i] != '')
                <?php $k = 1;?>
              @endif
            @endforeach
          @endif

          @if( $k == 1 )
            <select class="form-control newdropdown">
              @foreach($details['allocationStaff'] as $key=>$value)
                @if(isset($value['staff_name'.$i]) && $value['staff_name'.$i] != '')
                  <option value="{{$value['staff_id'.$i]}}">{{$value['staff_name'.$i]}}</option>
                @endif
              @endforeach
            </select>
          @endif
        </td>
      @endfor
    </tr>
  @endforeach
@endif

ipractice

<option value="">Select 1 or more clients</option>
@if(isset($lists) && count($lists) >0)
  @foreach($lists as $k=>$v)
    <option value="{{$v['client_id'] or ''}}">{{$v['client_name'] or ''}}</option>
    <!-- <li class="del_li_{{$v['client_id'] or ''}}"><a href="javascript:void(0)" data-client_id="{{$v['client_id'] or ''}}" class="clientAddToList">{{$v['client_name'] or ''}}</a></li> -->
    

    <!-- <div class="l_task_contain">
      <div class="l_select_con"><a href="javascript:void(0)" data-client_id="{{$v['client_id'] or ''}}">{{$v['client_name'] or ''}}</a></div>
      <div class="delete_task_name">
        <a href="javascript:void(0)" class="remove_tasks" data-client_id="{{$v['client_id'] or ''}}" data-service_id="{{$service_id}}">
        <img src="/img/cross.png" height="12"></a>
      </div>
      <div class="clearfix"></div>
    </div> -->
  @endforeach
@endif