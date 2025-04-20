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
					
                        
                    
                    	{{ "ORGANISATIONS CLIENTS LIST" }}
                    
                        
                        
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
             
                 <td align="center" style="font-size: 15px;"><strong>Business Type</strong></td>
                <td align="center" style="font-size: 15px;"><strong>CRN</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Business Name</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Year End</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Accounts</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Annual returns</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Tax reference</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Vat number</strong></td>
                <td align="center" style="font-size: 15px;"><strong>VAT Stagger</strong></td>
                <td align="center" style="font-size: 15px;"><strong>Correspondence Address</strong></td>
            </tr>
        </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(!empty($client_details))
                <?php $i=1; ?>
                @foreach($client_details as $key=>$client_row)
                  <tr class="all_check" {{ ($client_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                    
                    <td align="center" style="font-size: 15px;">{{ isset($client_row['business_type'])?$client_row['business_type']:"" }}</td>
                    <td align="center" style="font-size: 15px;">{{ $client_row['registration_number'] or "" }}</td>
                    <td align="left" style="font-size: 15px;">{{ isset($client_row['business_name'])?$client_row['business_name']:"" }}</td>
                    <td align="center" style="font-size: 15px;">{{ $client_row['acc_ref_day'] or "" }}-{{ $client_row['ref_month'] or "" }}</td>
                    <td align="center" style="font-size: 15px;">
                      @if( isset($client_row['deadacc_count']) && $client_row['deadacc_count'] == "OVER DUE" )
                        <span style="color:red">{{ $client_row['deadacc_count'] or "" }}</span>
                      @else
                         {{ $client_row['deadacc_count'] or "" }}
                      @endif
                    </td>
                    <td align="center" style="font-size: 15px;">
                      @if( isset($client_row['deadret_count']) && $client_row['deadret_count'] == "OVER DUE" )
                        <span style="color:red">{{ $client_row['deadret_count'] or "" }}</span>
                      @else
                         {{ $client_row['deadret_count'] or "" }}
                      @endif
                    </td>
                    <td align="center" style="font-size: 15px;">{{ isset($client_row['tax_reference'])?$client_row['tax_reference']:"" }}</td>
                    <td align="center" style="font-size: 15px;">{{ isset($client_row['vat_number'])?$client_row['vat_number']:"" }}</td>
                    <td align="center" style="font-size: 15px;">{{ $client_row['vat_stagger'] or "" }}</td>
                    <td align="left" style="font-size: 15px;">{{ (isset($client_row['corres_address']['fullAddress']) && $client_row['corres_address']['fullAddress'] != '')?$client_row['corres_address']['fullAddress']:'' }}</td>
                  </tr>
                <?php $i++; ?>
              @endforeach
            @endif
          
          
        </tbody>
      </table>