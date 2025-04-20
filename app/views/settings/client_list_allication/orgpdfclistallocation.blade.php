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
					
                        
                    
                    	{{ "Organization Clients List Allocation" }}
                    
                        
                        
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


<div id="orgclient_table">
    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
      
      <thead>
        <tr role="row">
          
          <th width="">Type</th>
          <th>BUSINESS NAME</th>
          <th width="">APPLICABLE?</th>
          <th width="">STAFF NAME</th>
          <th width="">STAFF NAME</th>
          <th width="">STAFF NAME</th>
          <th width="">STAFF NAME</th>
          <th width="">STAFF NAME</th>
        </tr>
      </thead>

     

        @if(isset($org_client_details) && count($org_client_details) >0)
          @foreach($org_client_details as $key=>$details)
             
              <tr class="even" id="client_{{ $details['client_id'] }}">
               
                
                
                
                
                <!-- allCheckSelect -->
          <td align="left">{{ $details['business_type'] or "" }}</td>
                <td align="left"><a target="_blank" href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}">{{ $details['business_name'] or "" }}</a></td>
                <td><span class="custom_chk"><input type='checkbox' class="checkbox applicable_Checkbox" name="applicable_checkbox[]" value="{{ $details['client_id'] or "" }}" id="applicable_checkbox{{ $details['client_id'] }}" {{ (isset($details['services_id']) && in_array($service_id, $details['services_id']))?"checked":"" }} />
                
               <!-- <label for="applicable_checkbox{{ $details['client_id'] }}"></label> -->
                
                
                </span></td>
                
                
                
                
                @for($i=1; $i <=5; $i++)
                <td align="left">
                  <select class="form-control save_manual_user" data-client_id="{{ $details['client_id'] }}" data-column="{{ $i }}" name="org_staff_id{{ $i }}" id="{{ $details['client_id'] }}_org_staff_id{{ $i }}" {{ (isset($details['services_id']) && in_array($service_id, $details['services_id']))?"":"disabled" }} >
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
            
          @endforeach
        @endif
        
      
    </table>
  </div>