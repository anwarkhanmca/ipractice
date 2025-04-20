<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="27%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="26%">
									<strong>
										Date :
									</strong>
								</td>
								<td width="74%">
									{{$cdate or ""}}
								</td>
							</tr>
							<tr>
								<td>
									<strong>
										Time :
									</strong>
								</td>
								<td>
									{{$ctime or ""}}
								</td>
							</tr>
						</table>
					</td>
					<td width="38%" style="font-size:20px; text-align:center; font-weight:bold; text-decoration:underline;">
					
                    	{{ "CRM-" }}
                        @if($page_open == 2 || $page_open == 21)
                        {{"ORGANISATION"}}
                        @endif
                      @if($page_open == 22) 
                        {{"INDIVIDUALS"}}
                        @endif
                        
                        {{"CLIENT DETAILS"}}
					</td>
					<td width="35%">
						&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;
		</td>
	</tr>
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>




<div class="col_m2">
  <div class="nav-tabs-custom">
   <!-- <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;">
      <li class="{{ ($page_open == 2 || $page_open == 21)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('21') }}/{{ base64_encode($owner_id) }}">ORGANISATION</a></li>
      <li class="{{ ($page_open == 22)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('22') }}/{{ base64_encode($owner_id) }}">INDIVIDUALS</a></li>
    </ul> -->
    <div class="tab-content">
    @if($page_open == 2 || $page_open == 21)
     <div id="tab_21">
     <!--  <div id="tab_21" class="tab-pane {{ ($page_open == 2 || $page_open == 21)?'active':'' }}"> -->
        <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
            <thead>
              <tr>
                
                <th><strong>Joining Date</strong></th>
                <th align="left"><strong>Client Name</strong></th>
                <th align="left"><strong>Payment Method</strong></th>
                <th align="left"><strong>Billing Cycle</strong></th>
                <th align="left"><strong>Annual Fee</strong></th>
                <th align="left"><strong>Monthly Fees</strong></th>
                <th align="left"><strong>Contract End Date</strong></th>
                <th align="left"><strong>Count Down</strong></th>
                
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
                  
                  @if(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '0')
                  None
                  @endif
                   @if(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '1')
                  Direct Debit
                  @endif
                   @if(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '2')
                  Invoice Basis
                  @endif
                   @if(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '3')
                  Standing Order
                  @endif
                  @if(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '4')
                  Other
                  @endif
                    
                  </td>
                  
                  <td align="left">
                  
                  
                  @if(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '0')
                  None
                  @endif
                  @if(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '1')
                  Weekly
                  @endif
                  @if(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '2')
                  Monthly
                  @endif
                  @if(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '3')
                  Yearly
                  @endif
                  @if(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '4')
                  Adhoc
                  @endif

                    
                    
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
      </div>
         @endif  
         @if($page_open == 22) 
         <div id="tab_22">        
     <!-- <div id="tab_22" class="tab-pane {{ ($page_open == 22)?'active':'' }}"> -->
        <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
            <thead>
              <tr>
                
                <th><strong>Joining Date</strong></th>
                <th align="left"><strong>Client Name</strong></th>
                <th align="left"><strong>Payment Method</strong></th>
                <th align="left"><strong>Billing Cycle</strong></th>
                <th align="left"><strong>Annual Fee</strong></th>
                <th align="left"><strong>Monthly Fees</strong></th>
                <th align="left"><strong>Contract End Date</strong></th>
                <th align="left"><strong>Count Down</strong></th>
                
              </tr>
            </thead>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(isset($tab22_details['client_details']) && count($tab22_details['client_details']) >0)
              @foreach($tab22_details['client_details'] as $key=>$client_rowtab2)
                <tr>
                
                  <td>
                    @if(isset($client_rowtab2['crm_leads_id']) && $client_rowtab2['crm_leads_id'] != "0")
                      {{ date('d-m-Y', strtotime($client_rowtab2['created'])) }}
                    @else
                      {{ $client_rowtab2['accounts']['engagement_date'] or "" }}
                    @endif
                  </td>
                  <td align="left">{{ $client_rowtab2['client_name'] or "" }}</td>
                  <td align="left">
                   
                       @if(isset($client_rowtab2['accounts']['payment_method']) && $client_rowtab2['accounts']['payment_method'] == '0')
                      None
                      @endif
                       @if(isset($client_rowtab2['accounts']['payment_method']) && $client_rowtab2['accounts']['payment_method'] == '1')
                      Direct Debit
                      @endif
                       @if(isset($client_rowtab2['accounts']['payment_method']) && $client_rowtab2['accounts']['payment_method'] == '2')
                      Invoice Basis
                      @endif
                       @if(isset($client_rowtab2['accounts']['payment_method']) && $client_rowtab2['accounts']['payment_method'] == '3')
                      Standing Order
                      @endif
                      @if(isset($client_rowtab2['accounts']['payment_method']) && $client_rowtab2['accounts']['payment_method'] == '4')
                      Other
                      @endif
                    
                  </td>
                  <td align="left">
                  
                        @if(isset($client_rowtab2['accounts']['billing_cycle']) && $client_rowtab2['accounts']['billing_cycle'] == '0')
                      None
                      @endif
                      @if(isset($client_rowtab2['accounts']['billing_cycle']) && $client_rowtab2['accounts']['billing_cycle'] == '1')
                      Weekly
                      @endif
                      @if(isset($client_rowtab2['accounts']['billing_cycle']) && $client_rowtab2['accounts']['billing_cycle'] == '2')
                      Monthly
                      @endif
                      @if(isset($client_rowtab2['accounts']['billing_cycle']) && $client_rowtab2['accounts']['billing_cycle'] == '3')
                      Yearly
                      @endif
                      @if(isset($client_rowtab2['accounts']['billing_cycle']) && $client_rowtab2['accounts']['billing_cycle'] == '4')
                      Adhoc
                      @endif
                      
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
      </div>
      @endif
      <!-- /.tab-pane -->
    </div>
  </div>
  <!--end sub tab-->
</div>