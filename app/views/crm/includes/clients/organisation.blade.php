<table class="table table-bordered table-hover dataTable" id="example21">
    <thead>
      <tr>
        <th><input type="checkbox" class="CheckallCheckbox"></th>
        <th><strong>Joining Date</strong></th>
        <th align="left"><strong>Client Name</strong></th>
        <th align="left"><strong>Payment Method</strong></th>
        <th align="left"><strong>Billing Cycle</strong></th>
        <th align="left"><strong>Annual Fee</strong></th>
        <th align="left"><strong>Monthly Fees</strong></th>
        <th align="left"><strong>Contract Start Date</strong></th>
        <th align="left"><strong>Contract End Date</strong></th>
        <th align="left"><strong>Count Down</strong></th>
        <th align="left" width="8%"><strong>Contract</strong></th>
        <th align="left"><strong>Send to Renewals</strong>
        <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
        </th>
      </tr>
    </thead>
    <tbody role="alert" aria-live="polite" aria-relevant="all">
    @if(isset($tab_details) && count($tab_details) >0)
      @foreach($tab_details as $key=>$client_row)
        <tr>
          <td><input type="checkbox" class="CheckallCheckbox"></td>
          <td>
            @if(isset($client_row['crm_leads_id']) && $client_row['crm_leads_id'] != "0")
              <a href="javascript:void(0)" class="open_joining_pop" data-joining="{{ date('d-m-Y', strtotime($client_row['created'])) }}" data-client_id="{{ $client_row['client_id'] or '0' }}" data-table="client" id="joining_div_{{ $client_row['client_id'] or '0' }}">{{ date('d-m-Y', strtotime($client_row['created'])) }}</a>
            @else
              <a href="javascript:void(0)" class="open_joining_pop" data-joining="{{ (isset($client_row['accounts']['engagement_date']) && $client_row['accounts']['engagement_date'] != '')?$client_row['accounts']['engagement_date']:''}}" data-client_id="{{ $client_row['client_id'] or '0' }}" data-table="crm" id="joining_div_{{ $client_row['client_id'] or '0' }}">{{ (isset($client_row['accounts']['engagement_date']) && $client_row['accounts']['engagement_date'] != '')?$client_row['accounts']['engagement_date']:'Add..'}}</a>
            @endif
          </td>
          <td align="left">
            @if(isset($client_row['client_type']) && $client_row['client_type'] == "ind")
              <a href="/renewals/{{ $client_row['client_id'] or '0' }}/{{ base64_encode('ind_client') }}/{{ base64_encode('1') }}" target="_blank">{{ $client_row['client_name'] or "" }}</a>
            @else
              <a href="/renewals/{{ $client_row['client_id'] or '0' }}/{{ base64_encode('org_client') }}/{{ base64_encode('1') }}" target="_blank">{{ $client_row['business_name'] or "" }}</a>
            @endif
          </td>
          <td align="left">
            <select class="form-control newdropdown change_payment" data-client_id="{{ $client_row['client_id'] or '0' }}" data-data_type="payment_method">
              <option value="0" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '0')?'selected':''}}>None</option>
              <option value="1" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '1')?'selected':''}}>Direct Debit</option>
              <option value="2" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '2')?'selected':''}}>Invoice Basis</option>
              <option value="3" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '3')?'selected':''}}>Standing Order</option>
              <option value="4" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '4')?'selected':''}}>Other</option>
            </select>
          </td>
          <td align="left">
            <select class="form-control newdropdown change_payment" data-client_id="{{ $client_row['client_id'] or '0' }}" data-data_type="billing_cycle">
              <option value="0" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '0')?'selected':''}}>None</option>
              <option value="1" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '1')?'selected':''}}>Weekly</option>
              <option value="2" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '2')?'selected':''}}>Monthly</option>
              <option value="3" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '3')?'selected':''}}>Yearly</option>
              <option value="4" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '4')?'selected':''}}>Adhoc</option>
            </select>
          </td>
          <td align="left">
            <a href="javascript:void(0)" class="open_amount_pop billing_amount_{{ $client_row['client_id'] or '0' }}" data-amount="{{ (isset($client_row['accounts']['billing_amount']) && $client_row['accounts']['billing_amount'] != '')?$client_row['accounts']['billing_amount']:''}}" data-client_id="{{ $client_row['client_id'] or '0' }}">{{ (isset($client_row['accounts']['billing_amount']) && $client_row['accounts']['billing_amount'] != '')?$client_row['accounts']['billing_amount']:'Add..'}}</a>
          </td>
          <td align="left" class="monthly_amount_{{ $client_row['client_id'] or '0' }}">
            {{(isset($client_row['accounts']['billing_amount']) && $client_row['accounts']['billing_amount'] != '')?number_format(str_replace(',', '', $client_row['accounts']['billing_amount'])/12, 2):''}}
          </td>

          <td align="left">
            <a href="javascript:void(0)" class="open_startdate_pop startdate_{{ $client_row['client_id'] or '0' }}" data-startdate="{{ (isset($client_row['accounts']['startdate']) && $client_row['accounts']['startdate'] != '')?$client_row['accounts']['startdate']:''}}" data-client_id="{{ $client_row['client_id'] or '0' }}">
              {{ (isset($client_row['accounts']['startdate']) && $client_row['accounts']['startdate'] != '')?$client_row['accounts']['startdate']:'Add..'}}</a>
          </td>

          <!-- <td align="left">
            <span class="enddate_{{ $client_row['client_id'] or '0' }}">{{ (isset($client_row['accounts']['startdate']) && $client_row['accounts']['startdate'] != "")?date("d-m-Y", strtotime('-1 day', strtotime('+1 years', strtotime($client_row['accounts']['startdate'])) )):"" }}</span>
          </td> -->
          <td align="left">
            <span class="enddate_{{ $client_row['client_id'] or '0' }}">{{ (isset($client_row['accounts']['enddate']) && $client_row['accounts']['enddate'] != '')?$client_row['accounts']['enddate']:''}}</span>
          </td>

          <td align="left">
            <span class="countdown_{{ $client_row['client_id'] or '0'}}">
              @if(isset($client_row['accounts']['count_down']) && $client_row['accounts']['count_down'] > 0)
                {{ $client_row['accounts']['count_down'] }}
              @else
                <p style="color:red">{{ $client_row['accounts']['count_down'] or "0" }}</p>
              @endif
            </span>
          </td>

          <td>
            <a href="javascript:void(0)" class="notes_btn roll_fwd_button" data-client_id="{{ $client_row['client_id'] or '0' }}">Roll fwd</a>
          </td>

          <td align="center" id="after_send_{{ $client_row['client_id'] or "" }}">
            @if(isset($client_row['manage_renewals']) && $client_row['manage_renewals'] == "N")
              <button type="button" class="job_send_btn send_renewals" data-client_id="{{ $client_row['client_id'] or '0' }}">SEND</button>
            @else
              <button type="button" class="job_sent_btn">SENT</button>
            @endif
          </td>
        </tr>
      @endforeach
    @endif
    </tbody>
    </table>