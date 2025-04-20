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
					
                        @if((isset($step_id) && $step_id == 1))
                    
                    	{{ "CONTACT -ORGANISATIONS" }}
                        
                        @endif
                        
                        @if((isset($step_id) && $step_id == 2))
                    
                    	{{ "CONTACT -INDIVIDUALS" }}
                        
                        @endif
                        
                        @if((isset($step_id) && $step_id == 3))
                    
                    	{{ "CONTACTS - STAFF" }}
                        
                        @endif
                        
                        @if((isset($step_id) && $step_id == 4))
                    
                    	{{ "CONTACT- OTHERS" }}
                        
                        @endif
                        
                         @if((isset($step_id) && $step_id == 5))
                    
                    	{{ "CONTACT- GROUPS" }}
                        
                        @endif
                        
                        @if((isset($step_id) && $step_id != 1 && $step_id != 2 && $step_id != 3 && $step_id != 4))
                        
                        
                            @if(isset($step_name) && $step_name != "")
                           {{ "CONTACT-" }} {{ $step_name or "" }}
                            @endif
                                            
                        
     
                            
                            
                            
                            
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




@if((isset($step_id) && $step_id == 1))

<div>

<!--	<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>ORGANISATIONS - CLIENTS</strong></p> -->
<table width="100%" border="1" cellspacing="0"  cellpadding="0" style="line-height: 25px; border: 1px solid #00ACD6; ">  
   <thead>
        <tr role="row">
         
          <th width="20%">Name</th>
          <th width="13%">Address Type</th>
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

                
                <td align="center">{{$client_row['business_name'] or "" }}</td>
               
                <td align="center">
                
                 
                    @if(isset($address_types) && count($address_types) >0)
                      
                      
                      @if(isset($address_type) && $address_type == "trad")
                      {{"Trading Address"}}
                      @endif
                      
                      @if(isset($address_type) && $address_type == "reg")
                      {{"Registered Office address"}}
                      @endif
                      
                      
                      @if(isset($address_type) && $address_type == "corres")
                      {{"Correspondence address"}}
                      @endif
                      
                      @if(isset($address_type) && $address_type == "bankers")
                      {{"Bankers"}}
                      @endif
                      
                      @if(isset($address_type) && $address_type == "old_acc")
                      {{"Old Accounts"}}
                      @endif
                      
                      @if(isset($address_type) && $address_type == "auditors")
                      {{"Auditors"}}
                      @endif
                        
                      @if(isset($address_type) && $address_type == "solicitors")
                      {{"Solicitors"}}
                      @endif
                      @if(isset($address_type) && $address_type == "tax_office")
                      {{"Tax Office"}}
                      @endif
                      @if(isset($address_type) && $address_type == "paye_emp")
                      {{"Paye Employer Office"}}
                      @endif
                    @endif
                   
                   
                </td>
                
                
                <td align="left">&nbsp;{{ $client_row['other_details']['contact_person'] or "" }}</td>
                <td align="left">&nbsp;{{ $client_row['other_details']['telephone'] or "" }}</td>
                <td align="left">&nbsp;{{ $client_row['other_details']['mobile'] or "" }}</td>
                <td align="left">&nbsp;{{ $client_row['other_details']['email'] or "" }}</td>
                <td align="left">&nbsp;{{ $client_row['other_details']['address'] }}</td>
                
              
              </tr>
            @endforeach
          @endif
        
        
      </tbody>
    </table>
	

</div>

@endif
@if((isset($step_id) && $step_id == 2))
<div>
<!--
	<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>INDIVIDUAL - CLIENTS </strong></p> -->

	<table width="100%" border="1" cellspacing="0"  cellpadding="0" style="line-height: 25px; border: 1px solid #00ACD6; ">
		
        
        
      <thead>
        <tr role="row">
          <th><strong>Name</strong></th>
          <th><strong>Telephone</strong></th>
          <th><strong>Mobile</strong></th>
          <th><strong>Email</strong></th>
          <th><strong>Residential Address</strong></th>
          <th><strong>Service Address</strong></th>
          
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($ind_details) && count($ind_details) >0)
          @foreach($ind_details as $key=>$client_row)
            <tr class="all_check">
              <input type="hidden" name="serv_add_{{ $client_row['client_id'] }}" id="serv_add_{{ $client_row['client_id'] }}" value="{{ $client_row['serv_address'] or "" }}">
              <input type="hidden" name="reg_add_{{ $client_row['client_id'] }}" id="reg_add_{{ $client_row['client_id'] }}" value="{{ $client_row['address'] or "" }}">

              
              
              <td align="left">&nbsp;{{ $client_row['client_name'] or "" }}</td>
              <td align="left">&nbsp;{{ $client_row['serv_telephone'] or "" }}</td>
              <td align="left">&nbsp;{{ $client_row['serv_mobile'] or "" }}</td>
              <td align="left">&nbsp;{{ $client_row['serv_email'] or "" }}</td>
              <td align="left">&nbsp;{{ $client_row['address']}}</td>
              <td align="left">&nbsp;{{ $client_row['serv_address']}}</td>
              
            </tr>
          @endforeach
        @endif
        
      </tbody>
  
        
        
	</table>

</div>

@endif
@if((isset($step_id) && $step_id == 3))

<!--<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>STAFF</strong></p> -->

<div >


<table width="100%" border="1" cellspacing="0" cellpadding="0" style="line-height: 25px;">

      <thead>
        <tr role="row">
          
          <th width="20%"><strong>Name</strong></th>
          <th width="10%"><strong>Telephone</strong></th>
          <th width="10%"><strong>Mobile</strong></th>
          <th width="20%"><strong>Email</strong></th>
          <th><strong>Address</strong></th>
         
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($staff_details) && count($staff_details) >0)
            @foreach($staff_details as $key=>$staff_row)
              <tr class="all_check">
                <input type="hidden" name="address_{{ $staff_row['user_id'] }}" id="corres_add_{{ $staff_row['user_id'] }}" value="{{ $staff_row['address'] or "" }}">
                
                <td align="left">&nbsp;{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</td>
                <td align="left">&nbsp;{{ $staff_row['step_data']['serv_telephone'] or "" }}</td>
                <td align="left">&nbsp;{{ $staff_row['step_data']['serv_mobile'] or "" }}</td>
                <td align="left">&nbsp;{{ $staff_row['email'] or "" }}</td>
                <td align="left">&nbsp;{{ $staff_row['step_data']['address'] }}</td>
                
                
                
              </tr>
            @endforeach
          @endif
        
        
      </tbody>
    

</table>

</div>
@endif
@if((isset($step_id) && $step_id == 4))
<!--
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>OTHERS</strong></p> -->
<div >
<table width="100%" border="1" cellspacing="0" cellpadding="0" style="line-height: 25px;">


      <thead>
        <tr role="row">
        
          <td align="left"><strong>Name</strong></td>
          <td align="left"><strong>Contact Person</strong></td>
          <td align="left"><strong>Telephone</strong></td>
         <td align="left"><strong>Mobile</strong></td>
          <td align="left"><strong>Email</strong></td>
          <td align="left"><strong>Address</strong></td>
         
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($contact_details) && count($contact_details) >0)
              @foreach($contact_details as $key=>$client_row)
                <tr class="all_check">
                  <input type="hidden" name="other_address_{{ $client_row['contact_id'] }}" id="other_address_{{ $client_row['contact_id'] }}" value="{{ $client_row['address'] or "" }}">
                  
                  <td align="left">&nbsp;{{ $client_row['name'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['contact_person'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['telephone'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['mobile'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['email'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['address'] }}</td>
                 
                  
                </tr>
            @endforeach
          @endif
        
        
      </tbody>
    

</table>



</div>

@endif

@if((isset($step_id) && $step_id == 5))
<!--
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>OTHERS</strong></p> -->
<div >


<table width="100%" border="1" cellspacing="0" cellpadding="0" style="line-height: 25px;">
      <thead>
        <tr role="row">
         
          <th width="20%">Date/Time</th>
          <th width="3%">Count</th>
          <th width="20%">Created By</th>
          <th width="35%">Name</th>
         
        </tr>
      </thead>
      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($step_details) && count($step_details) >0)
          @foreach($step_details as $key=>$client_row)
          <tr class="all_check">
            
            <td align="left">{{ date('d-m-Y H:i:s', strtotime($client_row['created'])) }}</td>
            <td align="left">{{ $client_row['count'] or "0" }}</td>
            <td align="left">{{ $client_row['created_by'] or "" }}</td>
            <td align="left">{{ $client_row['title'] or "" }}</td>
            
          </tr>
          @endforeach
        @endif
      </tbody>
    </table>



</div>

@endif





@if((isset($step_id) && $step_id != 1 && $step_id != 2 && $step_id != 3 && $step_id != 4 && $step_id != 5))

 <table width="100%" border="1" cellspacing="0" cellpadding="0" style="line-height: 25px;">
      <thead>
        <tr role="row">
         
          <th>Name</th>
          <th width="15%">Contact Person</th>
          <th>Telephone</th>
          <th>Mobile</th>
          <th>Email</th>
          <th>Correspondence Address</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($group_details) && count($group_details) >0)
              @foreach($group_details as $key=>$client_row)
                <tr class="all_check">
                  <input type="hidden" name="custom_address_{{ $client_row['client_id'] }}" id="custom_address_{{ $client_row['client_id'] }}" value="{{ $client_row['address'] or "" }}">

                 
                  <td align="left">&nbsp;{{ $client_row['client_name'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['contact_person'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['telephone'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['mobile'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['email'] or "" }}</td>
                  <td align="left">&nbsp;{{ $client_row['address'] or "" }}</td>
                </tr>
            @endforeach
          @endif
        
        
      </tbody>
    </table>


@endif