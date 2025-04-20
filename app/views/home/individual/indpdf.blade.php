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
					
                        
                    
                    	{{ "Individual Clients List" }}
                    
                        
                        
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


<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
            <input type="hidden" id="client_type" value="ind">  
            <thead>
              <tr role="row">
                
                <!-- <th>#</th> -->
                <!-- <th>STAFF</th> -->
                <th><span id="dob_text">DOB</span>
                 
                </th>
                <th>Client Name</th>
                
                <th width="15%"><span id="business_name_text">Business Name</span>
                  
                </th>
                
                <th><span id="ni_number_text">NI Number</span>
                  
                </th>
                <th><span id="tax_reference_text">Tax Reference</span>
                  
                </th>
                <th><span id="acting_text">PTR</span>
                  
                </th>
                <th><span id="res_address_text">Residential Address</span>
                 
                </th>
              
              </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
              @if(!empty($client_details))
              <?php $i=1; ?>
              @foreach($client_details as $key=>$client_row)
                <tr class="all_check" {{ ($client_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                  
                  <!-- <td align="left">{{ $client_row['staff_name'] or "" }}</td> -->
                  <td align="center">{{ isset($client_row['dob'])?date("d-m-Y", strtotime($client_row['dob'])):"" }}</td>
                  <td align="left">{{ (!empty($client_row['client_name']))? $client_row['client_name']: '' }}</td>
                  <td align="left">
                    
                    @if(isset($client_row['relationship']) && count($client_row['relationship']) >0 )
                   
                      
                     
                      @foreach($client_row['relationship'] as $key=>$relation_row)
                      
                        {{ $relation_row['name'] or "" }}
                    
                      @endforeach
                   
                   
                      
                    @endif
                    
                  </td>
                  <td align="center">{{ (!empty($client_row['ni_number']))? $client_row['ni_number']: '' }}</td>
                  <td align="center">{{ (!empty($client_row['tax_reference']))? $client_row['tax_reference']: '' }}</td>
                  <td align="center">{{ (isset($client_row['other_services']) && in_array(10, unserialize($client_row['other_services'])))?"Yes":"No" }} </td>

                  <td align="left">
                    @if(isset($client_row['address']) && $client_row['address'] != "" )
                    <span title="{{ $client_row['address'] }}">{{ (strlen($client_row['address']) > 45)? substr($client_row['address'], 0, 42)."...": $client_row['address'] }}</span>
                    @endif
                  </td>
                </tr>
                <?php $i++; ?>
                @endforeach
                
              @endif
              
            </tbody>
          </table>