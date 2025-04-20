<div class="col-4">
        <h1 style="color:blue">{{ $title or "" }}</h1>
    </div>

<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
      <thead>
        <tr role="row">
         
          <th width="20%">Name</th>
          <th width="13%">Address Type <span class="glyphicon glyphicon-chevron-down down_arrow" data-client_id="531" data-tab="21">
          
            <div class="address_type_down" style="display: none;">
              <ul>
                @if(isset($address_types) && count($address_types) >0)
                  @foreach($address_types as $key=>$type_row)
                    <li><a href="/contacts-letters-emails/{{ $step_id }}/{{ base64_encode($type_row['short_name']) }}">{{ $type_row['title'] }}</a></li>
                  @endforeach
                @endif
              </ul>
            </div>
          </span>
          </th>
          <th width="13%">Contact Person</th>
          <th width="7%">Telephone</th>
          <th width="7%">Mobile</th>
          <th width="10%">Email</th>
          <th>Address</th>
          
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($org_details) && count($org_details) >0)
            @foreach($org_details as $key=>$client_row)
              <tr class="all_check tr_no_{{ $key }}">
                <input type="hidden" name="corres_add_{{ $client_row['client_id'] }}" id="corres_add_{{ $client_row['client_id'] }}" value="{{ (isset($client_row['other_details']['address']) && $client_row['other_details']['address'] != "")?$client_row['other_details']['address']:'' }}">

                
                <td align="left"><a target="_blank" href="/client/edit-org-client/{{ $client_row['client_id'] }}/{{ base64_encode('org_client') }}">{{ $client_row['business_name'] or "" }}</a></td>
                <td align="left">
                
                  <select class="form-control newdropdown address_type" data-key="{{ $key }}" data-client_id="{{ $client_row['client_id'] }}">
                    @if(isset($address_types) && count($address_types) >0)
                      @foreach($address_types as $key=>$type_row)
                        <option value="{{ $type_row['short_name'] }}" {{ (isset($address_type) && $address_type == $type_row['short_name'])?"selected":"" }}>{{ $type_row['title'] }}</option>
                      @endforeach
                    @endif
                   </select>
                   {{ $type_row['title'] or "" }}
                </td>
                <td align="left">{{ $client_row['other_details']['contact_person'] or "" }}</td>
                <td align="center">{{ $client_row['other_details']['telephone'] or "" }}</td>
                <td align="center">{{ $client_row['other_details']['mobile'] or "" }}</td>
                <td align="center">{{ $client_row['other_details']['email'] or "" }}</td>
                <td align="center">{{ (strlen($client_row['other_details']['address']) > 48)? substr($client_row['other_details']['address'], 0, 45)."...<a href='javascript:void(0)' class='more_address' data-client_id='".$client_row['client_id']."' data-client_type='org'>more</a>": $client_row['other_details']['address'] }}</td>
                
              
              </tr>
            @endforeach
          @endif
        
        
      </tbody>
    </table>