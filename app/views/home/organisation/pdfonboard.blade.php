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
					
                        @if(($page_open == 1)
                            {{"STATUTORY ACCOUNTS - CLIENT DETAILS"}}
                        @endif
                    
	
                    
                        
                        
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
      <input type="hidden" id="client_type" value="org"> 
        <thead>
            <tr role="row">
             
                <td align="center" style="font-size: 15px;"><strong>Join Date</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Client Type</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Client Name</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Contact Name</strong></td>
                <td align="center" style="font-size: 15px;"><strong>% Completed</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Telephone</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Email</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Mobile</strong></td>
            </tr>
        </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(!empty($client_details))
              <?php $i=1; ?>
              @foreach($client_details as $key=>$client_row)
                <tr class="all_check" {{ ($client_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                
                  <td align="center">
                   {{ date('d-m-Y',strtotime($client_row['created'])) }}
                  </td>
                  
                  @if( isset($client_row['business_type']))
                  <td align="center">{{ isset($client_row['business_type'])?$client_row['business_type']:"" }}</td>
                  @endif
                    
                  @if( isset($client_row['client_name']))
                    <td align="center">{{ isset($client_row['client_name'])?"Individual":"" }}</td>
                  @endif
                    
                 <!--   <td align="center">{{ $client_row['registration_number'] or "" }}</td> -->
                    
                    
                    @if( isset($client_row['business_name']))
                    
                    
                    <td align="left">{{ isset($client_row['business_name'])?$client_row['business_name']:"" }}</td>          
                     @endif
                     @if( isset($client_row['client_name']))
                     <td align="left">{{isset($client_row['client_name'])?$client_row['client_name']:"" }}</td>
                    
                    @endif
                    <!--
                    <td align="left"><a href="/client/edit-org-client/{{ $client_row['client_id'] }}/{{ base64_encode('org_client') }}">{{ isset($client_row['business_name'])?$client_row['business_name']:"" }}</a></td> -->
                    
                    <td align="center">
                    
                    {{ isset($client_row['corres_cont_name'])?$client_row['corres_cont_name']:"" }}
                    
                    
                    </td>
                    
                    <td align="center">
                    {{ $client_row['avg'] }} %
                    <!--  @if( isset($client_row['deadacc_count']) && $client_row['deadacc_count'] == "OVER DUE" )
                        <span style="color:red">{{ $client_row['deadacc_count'] or "" }}</span>
                      @else
                         {{ $client_row['deadacc_count'] or "" }}
                      @endif -->
                    </td>
                    
                    <td align="center">
                    @if( isset($client_row['corres_cont_telephone']))
                      {{ isset($client_row['corres_cont_telephone'])?$client_row['corres_cont_telephone']:"" }}
                    @endif

                    @if( isset($client_row['res_telephone']))
                      {{ isset($client_row['res_telephone'])?$client_row['res_telephone']:"" }}
                    @endif
                    
                    </td>
                  
                 
                    <td align="center">
                     @if( isset($client_row['corres_cont_email']))
                    {{ isset($client_row['corres_cont_email'])?$client_row['corres_cont_email']:"" }}
                      @endif
                      
                      @if( isset($client_row['res_email']))
                    {{ isset($client_row['res_email'])?$client_row['res_email']:"" }}
                      @endif
                      
                    </td>
                   
                    
                    <td align="center">
                   @if( isset($client_row['corres_cont_mobile']))
                    {{ isset($client_row['corres_cont_mobile'])?$client_row['corres_cont_mobile']:"" }}
                      @endif
                    
                  @if( isset($client_row['res_mobile']))
                    {{ isset($client_row['res_mobile'])?$client_row['res_mobile']:"" }}
                      @endif
                  
                    </td>
                    
                    
                    
                    
                    
                  </tr>
                <?php $i++; ?>
              @endforeach
            @endif
          
          
        </tbody>
      </table>