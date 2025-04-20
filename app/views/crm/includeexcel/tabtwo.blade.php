<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
        
<tr>

                <td><h5>Date:{{$cdate or ""}}</h5></td>
                <td>&nbsp;</td>
                <td colspan="2" height="30px" align="center">
                
                	{{ "CRM-" }}
                        @if($page_open == 2 || $page_open == 21)
                        {{"ORGANISATION"}}
                        @endif
                      @if($page_open == 22) 
                        {{"INDIVIDUALS"}}
                        @endif
                        
                        {{"CLIENT DETAILS"}}
                
                
                </td>
                <td>&nbsp;</td>
</tr>

<tr>

                <td><h5>Time:		{{$ctime or ""}}</h5></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
</tr>
<tr>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
</tr>
           
            </table>
            
            
            @if($page_open == 2 || $page_open == 21)
            <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
            <thead>
              <tr>
                
                <th width="15%">Joining Date</th>
                <th width="15%" align="left"><strong>Client Name</strong></th>
                <th width="15%" align="left"><strong>Payment Method</strong></th>
                <th width="15%" align="left"><strong>Billing Cycle</strong></th>
                <th width="15%"  align="left"><strong>Annual Fee</strong></th>
                <th width="15%" align="left"><strong>Monthly Fees</strong></th>
                <th width="15%" align="left"><strong>Contract End Date</strong></th>
                <th width="15%" align="left"><strong>Count Down</strong></th>
                
              </tr>
            </thead>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(isset($tab21_details['client_details']) && count($tab21_details['client_details']) >0)
              @foreach($tab21_details['client_details'] as $key=>$client_row)
                <tr>
                  
                  <td>
                    @if(isset($client_row['crm_leads_id']) && $client_row['crm_leads_id'] != "0")
                      {{ date('d-m-Y', strtotime($client_row['created'])) }}
                    @else
                      {{ $client_row['accounts']['engagement_date'] or "" }}
                    @endif
                  </td>
                  <td align="left">{{ $client_row['business_name'] or "" }}</td>
                  <td align="left">
                    <select class="form-control newdropdown change_payment" data-client_id="{{ $client_row['client_id'] or '' }}" data-data_type="payment_method">
                      <option value="0" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '0')?'selected':''}}>None</option>
                      <option value="1" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '1')?'selected':''}}>Direct Debit</option>
                      <option value="2" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '2')?'selected':''}}>Invoice Basis</option>
                      <option value="3" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '3')?'selected':''}}>Standing Order</option>
                      <option value="4" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '4')?'selected':''}}>Other</option>
                    </select>
                  </td>
                  <td align="left">
                    <select class="form-control newdropdown change_payment" data-client_id="{{ $client_row['client_id'] or '' }}" data-data_type="billing_cycle">
                      <option value="0" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '0')?'selected':''}}>None</option>
                      <option value="1" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '1')?'selected':''}}>Weekly</option>
                      <option value="2" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '2')?'selected':''}}>Monthly</option>
                      <option value="3" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '3')?'selected':''}}>Yearly</option>
                      <option value="4" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '4')?'selected':''}}>Adhoc</option>
                    </select>
                  </td>
                  <td align="left"></td>
                  <td align="left"></td>
                  <td align="left"></td>
                  <td align="left"></td>
                  
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
            @endif
            

@if($page_open == 22) 
<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
            <thead>
              <tr>
                
                <th width="15%"><strong>Joining Date</strong></th>
                <th width="15%" align="left"><strong>Client Name</strong></th>
                <th width="15%" align="left"><strong>Payment Method</strong></th>
                <th width="15%" align="left"><strong>Billing Cycle</strong></th>
                <th width="15%" align="left"><strong>Annual Fee</strong></th>
                <th width="15%" align="left"><strong>Monthly Fees</strong></th>
                <th width="15%" align="left"><strong>Contract End Date</strong></th>
                <th width="15%" align="left"><strong>Count Down</strong></th>
                
              </tr>
            </thead>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(isset($tab22_details['client_details']) && count($tab22_details['client_details']) >0)
              @foreach($tab22_details['client_details'] as $key=>$client_row)
                <tr>
                
                  <td>
                    @if(isset($client_row['crm_leads_id']) && $client_row['crm_leads_id'] != "0")
                      {{ date('d-m-Y', strtotime($client_row['created'])) }}
                    @else
                      {{ $client_row['accounts']['engagement_date'] or "" }}
                    @endif
                  </td>
                  <td align="left">{{ $client_row['client_name'] or "" }}</td>
                  <td align="left">
                    <select class="form-control newdropdown change_payment" data-client_id="{{ $client_row['client_id'] or '' }}" data-data_type="payment_method">
                      <option value="0" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '0')?'selected':''}}>None</option>
                      <option value="1" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '1')?'selected':''}}>Direct Debit</option>
                      <option value="2" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '2')?'selected':''}}>Invoice Basis</option>
                      <option value="3" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '3')?'selected':''}}>Standing Order</option>
                      <option value="4" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '4')?'selected':''}}>Other</option>
                    </select>
                  </td>
                  <td align="left">
                    <select class="form-control newdropdown change_payment" data-client_id="{{ $client_row['client_id'] or '' }}" data-data_type="billing_cycle">
                      <option value="0" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '0')?'selected':''}}>None</option>
                      <option value="1" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '1')?'selected':''}}>Weekly</option>
                      <option value="2" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '2')?'selected':''}}>Monthly</option>
                      <option value="3" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '3')?'selected':''}}>Yearly</option>
                      <option value="4" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '4')?'selected':''}}>Adhoc</option>
                    </select>
                  </td>
                  <td align="left"></td>
                  <td align="left"></td>
                  <td align="left"></td>
                  <td align="left"></td>
                  
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        
        @endif