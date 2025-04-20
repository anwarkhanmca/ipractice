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
					
                        
                    
                    	{{ "STAFF LIST" }}
                    
                        
                        
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
            
            <thead>
              <tr role="row">
                <th><strong>Staff Name</strong></th>
                <th><strong>Position/Job Title</strong></th>
                <th><strong>Date Joined</strong></th>
                <th><strong>Holidays Left</strong></th>
                <th><strong>Department</strong></th>
                <th><strong>Address</strong></th>
              </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
              @if( isset($staff_details) && count($staff_details) >0 )
                @foreach($staff_details as $key=>$value)
                <tr class="all_check" {{ ($value['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                  <td align="center">{{ $value['fname'] or "" }} {{ $value['lname'] or "" }}</td>
                  <td align="center">{{ $value['position_name'] or "" }}</td>
                  <td align="center">{{ isset($value['created'])?date("d-m-Y", strtotime($value['created'])):"" }}</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">{{ $value['department_name'] or "" }}</td>
                  
                 <!-- <td align="center">{{ $value['step_data']['res_addr_line1'] or "" }},{{ $value['step_data']['res_addr_line2'] or "" }},{{ $value['step_data']['res_city'] or "" }},{{ $value['step_data']['res_county'] or "" }},{{ $value['step_data']['res_postcode'] or "" }} </td>
                -->
         <td align="center">{{ (strlen($value['fulladdress']) > 20)? substr(strip_tags($value['fulladdress']), 0, 20)."...": strip_tags($value['fulladdress']) }}</td>
              <!-- <td align="center">{{ $value['fulladdress']['res_addr'] or "" }} </td> -->
               
                </tr>
                @endforeach
              @endif
            </tbody>
          </table>