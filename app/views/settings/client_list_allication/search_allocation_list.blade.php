@if(isset($org_client_details) && count($org_client_details) >0)
  @foreach($org_client_details as $key=>$details)
    @if(isset($details['other_services']) && in_array($service_id, unserialize($details['other_services'])))
      <tr class="even">
        <td><span class="custom_chk"><input type='checkbox' class="checkbox org_Checkbox" name="org_checkbox[]" value="{{ $details['client_id'] or "" }}" id="org_checkbox{{ $details['client_id'] }}" /><label for="org_checkbox{{ $details['client_id'] }}"></label></span></td>
        <td align="left">{{ $details['business_type'] or "" }}</td>
        <td align="left"><a target="_blank" href="/client/edit-org-client/{{ $details['client_id'] }}">{{ $details['business_name'] or "" }}</a></td>
        @for($i=1; $i <=5; $i++)
        <td align="left">
          <select class="form-control save_manual_user" data-client_id="{{ $details['client_id'] }}" data-column="{{ $i }}" name="org_staff_id{{ $i }}" id="{{ $details['client_id'] }}_org_staff_id{{ $i }}">
            <option value="">None</option>
            @if(!empty($staff_details))
              @foreach($staff_details as $key=>$staff_row)
              <option value="{{ $staff_row->user_id }}" {{ (isset( $details['allocation'][$service_id]['staff_id'.$i] ) && ($details['allocation'][$service_id]['staff_id'.$i] == $staff_row->user_id) && isset( $details['allocation'][$service_id]['service_id'] ) && ($details['allocation'][$service_id]['service_id'] == $service_id))?"selected":""}} >{{ $staff_row->fname }} {{ $staff_row->lname }}</option>
              @endforeach
            @endif
          </select>
        </td>
        @endfor
      </tr>
    @endif
  @endforeach
@endif

@if(isset($ind_client_details) && count($ind_client_details) >0)
  @foreach($ind_client_details as $key=>$details)
    @if(isset($details['other_services']) && in_array($service_id, unserialize($details['other_services'])))
      <tr class="even">
        <td><span class="custom_chk"><input type='checkbox' class="checkbox ind_Checkbox" name="ind_checkbox[]" value="{{ $details['client_id'] or "" }}" id="ind_checkbox{{ $details['client_id'] }}" /><label for="ind_checkbox{{ $details['client_id'] }}"></label></span></td>
        <!-- <td align="left">{{ $details['business_type'] or "" }}</td> -->
        <td align="left"><a target="_blank" href="/client/edit-ind-client/{{ $details['client_id'] }}">{{ $details['client_name'] or "" }}</a></td>
        @for($i=1; $i <=5; $i++)
        <td align="left">
          <select class="form-control save_manual_user" data-client_id="{{ $details['client_id'] }}" data-column="{{ $i }}" name="ind_staff_id{{ $i }}" id="{{ $details['client_id'] }}_ind_staff_id{{ $i }}">
            <option value="">None</option>
            @if(!empty($staff_details))
              @foreach($staff_details as $key=>$staff_row)
              <option value="{{ $staff_row->user_id }}" {{ (isset( $details['allocation'][$service_id]['staff_id'.$i] ) && ($details['allocation'][$service_id]['staff_id'.$i] == $staff_row->user_id) && isset( $details['allocation'][$service_id]['service_id'] ) && ($details['allocation'][$service_id]['service_id'] == $service_id))?"selected":""}} >{{ $staff_row->fname }} {{ $staff_row->lname }}</option>
              @endforeach
            @endif
          </select>
        </td>
        @endfor
      </tr>
    @endif
  @endforeach
@endif