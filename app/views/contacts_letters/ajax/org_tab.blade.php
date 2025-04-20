@if(isset($org_details) && count($org_details) >0)
  @foreach($org_details as $key=>$client_row)
    <tr class="all_check tr_no_{{ $key }}">
      <input type="hidden" name="corres_add_{{ $client_row['client_id'] }}" id="corres_add_{{ $client_row['client_id'] }}" value="{{ (isset($client_row['other_details']['address']) && $client_row['other_details']['address'] != "")?$client_row['other_details']['address']:'' }}">

      <td align="left">
        <input type="checkbox" class="ads_Checkbox" name="client_ids[]" value="{{ $client_row['client_id'] or "" }}" />
      </td>
      <td align="left"><a target="_blank" href="/client/edit-org-client/{{ $client_row['client_id'] }}/{{ base64_encode('org_client') }}">{{ $client_row['client_name'] or "" }}</a></td>
      <td align="left">
        <select class="form-control newdropdown address_type" data-key="{{ $key }}" data-client_id="{{ $client_row['client_id'] }}">
          @if(isset($address_types) && count($address_types) >0)
            @foreach($address_types as $key=>$type_row)
              <option value="{{ $type_row['short_name'] }}" {{ (isset($address_type) && $address_type == $type_row['short_name'])?"selected":"" }}>{{ $type_row['title'] }}</option>
            @endforeach
          @endif
         </select>
      </td>
      <td align="left">{{ $client_row['other_details']['contact_person'] or "" }}</td>
      <td align="left">{{ $client_row['other_details']['telephone'] or "" }}</td>
      <td align="left">{{ $client_row['other_details']['mobile'] or "" }}</td>
      <td align="left">{{ $client_row['other_details']['email'] or "" }}</td>
      <td align="left">{{ (strlen($client_row['other_details']['address']) > 48)? substr($client_row['other_details']['address'], 0, 45)."...<a href='javascript:void(0)' class='more_address' data-client_id='".$client_row['client_id']."' data-client_type='org'>more</a>": $client_row['other_details']['address'] }}</td>
      <td align="left"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $client_row['client_id'] or "" }}" data-contact_type="{{ $client_row['client_type'] or "" }}"><span {{ (isset($client_row['notes']) && $client_row['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a></td>
    
    </tr>
  @endforeach
@endif

<!-- <tr class="all_check tr_no_{{ $key or '0' }}">
  <td colspan="9" align="center">
    {{$pagination or ''}}
  </td>
</tr> -->