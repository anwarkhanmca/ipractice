<style>
.page-break {
page-break-after: always;
}
.footer { position: fixed; bottom: 5px; border-bottom: 2px solid #00ACD6; padding-bottom: -25px; font-size:14px;  }
.divider {color:#ccc; padding: 0 10px 0 10px ;}
.hmrc { position: fixed;  }
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td style="border-top: #00ACD6 solid 30px; ">&nbsp;</td>
	</tr>
	<tr>
		
		@if(strlen($staff_details['staff_name']) > 20)
		<td style="height: 220px;">&nbsp;</td>
		@else
		<td style="height: 240px;">&nbsp;</td>
		@endif
		
	</tr>
	<tr>
		<td style="font-size: 50px; color:#00ACD6 ; text-align: center;  ">{{ $staff_details['staff_name']  or "" }}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 30px; text-align: center; font-weight: normal; ">{{ "STAFF DETAILS"}}</td>
	</tr>
	<tr>
		@if(strlen($staff_details['staff_name']) > 20)
		<td style="height: 220px;">&nbsp;</td>
		@else
		<td style="height: 260px;">&nbsp;</td>
		@endif
		
	</tr>
	<tr>
		<td style="border-top: #00ACD6 solid 30px; position: fixed; bottom:0; ">&nbsp;</td>
	</tr>
</table>
<div class="clearfix"></div>
<div>
	<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>GENERAL</strong></p>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
		<tr>
			<td width="25%">
				<strong>
				Gender
				</strong>
			</td>
			<td width="75%">
			{{ $staff_details['step_data']['gender'] or "" }}
			</td>
		</tr>


		<tr>
			<td width="25%">
				<strong>
				Date of Birth
				</strong>
			</td>
			<td width="75%">
				{{ (isset($staff_details['step_data']['dob']))?date('d-m-Y', strtotime($staff_details['step_data']['dob'])):"" }}
			</td>
		</tr>

        <tr>
			<td width="25%">
				<strong>
				Marital Status
				</strong>
			</td>
			<td width="75%">
				{{ $maritalstatus or ""}}
			</td>
		</tr>

	
		<tr>
			<td width="25%">
				<strong>
				Nationality
				</strong>
			</td>
			<td width="75%">
			{{	$nationalityname or "" }}
			</td>
		</tr>
        <tr>
			<td width="25%">
				<strong>
				Country
				</strong>
			</td>
			<td width="75%">
				{{$staffcountry or ""}}
			</td>
		</tr>
        <tr>
			<td width="25%">
				<strong>
				Position/Job Title
				</strong>
			</td>
			<td width="75%">
				{{$positionname or "" }}
			</td>
		</tr>
        <tr>
			<td width="25%">
				<strong>
				NI Number
				</strong>
			</td>
			<td width="75%">
				{{ $staff_details['step_data']['ni_number'] or "" }}
			</td>
		</tr>
        
        <tr>
			<td width="25%">
				<strong>
				Tax Reference
				</strong>
			</td>
			<td width="75%">
				{{ $staff_details['step_data']['tax_reference'] or "" }}
			</td>
		</tr>
        <tr>
			<td width="25%">
				<strong>
				Professional body
				</strong>
			</td>
			<td width="75%">
				{{ $staff_details['step_data']['professional_body'] or "" }}
			</td>
		</tr>
         <tr>
			<td width="25%">
				<strong>
				Membership/Student number
				</strong>
			</td>
			<td width="75%">
				{{ $staff_details['step_data']['student_number'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				&nbsp;
				</strong>
			</td>
			<td width="75%">
				&nbsp;
			</td>
		</tr>
	</table>

</div>
<div class="page-break"></div>

<div class="footer">{{ "STAFF DETAILS"}}  <span class="divider">| </span>{{ $staff_details['staff_name']  or ""}} <span class="divider">| </span> {{$today or ""}} {{$time or ""}}
</div>


<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>CONTACT INFORMATION</strong></p>

<div >


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
	
	<tr>
		<td width="25%" valign="top">
			<strong>
			<font color="#00ACD6">	Residential Address</font>
			</strong>
		</td>
		<td width="75%" valign="top">
			&nbsp;
		</td>
 	</tr>

    <tr>
		<td width="25%" valign="top">
			<strong>
			Address Line1
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['step_data']['res_addr_line1']  or "" }}
		</td>
 	</tr>
      <tr>
		<td width="25%" valign="top">
			<strong>
			Address Line2
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['step_data']['res_addr_line2']  or "" }}
		</td>
 	</tr>
    <tr>
		<td width="25%" valign="top">
			<strong>
			City/Town
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['step_data']['res_city']  or "" }}
		</td>
 	</tr>
    
    <tr>
		<td width="25%" valign="top">
			<strong>
			County
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['step_data']['res_county']  or "" }}
		</td>
 	</tr>
    
    <tr>
		<td width="25%" valign="top">
			<strong>
			Postcode
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['step_data']['res_postcode']  or "" }}
		</td>
 	</tr>
    
    <tr>
		<td width="25%" valign="top">
			<strong>
			Country
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $residentialcountry or "" }}
		</td>
 	</tr>
    
    <tr>
		<td width="25%" valign="top">
			<strong>
			Telephone
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['step_data']['serv_telephone']  or "" }}
		</td>
 	</tr>
    <tr>
		<td width="25%" valign="top">
			<strong>
			Mobile
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['step_data']['serv_mobile']  or "" }}
		</td>
 	</tr>
    
    <tr>
		<td width="25%" valign="top">
			<strong>
			Email (Personal)
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['email']  or "" }}
		</td>
 	</tr>
    
    <tr>
		<td width="25%" valign="top">
			<strong>
			Skype
			</strong>
		</td>
		<td width="75%" valign="top">
		{{ $staff_details ['step_data']['skype']  or "" }}
		</td>
 	</tr>
    
    <tr>
		<td width="25%" valign="top">
			<strong>
			<font color="#00ACD6">Emergency Contact</font>
			</strong>
		</td>
		<td width="75%" valign="top">
			&nbsp;
		</td>
 	</tr>
    
    <tr>
		<td width="25%" valign="top">
			<strong>
			Name
			</strong>
		</td>
		<td width="75%" valign="top">
		{{ $staff_details['step_data']['emer_name']  or "" }}
		</td>
 	</tr>
    <tr>
		<td width="25%" valign="top">
			<strong>
			Telephone
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['step_data']['emer_telephone']  or "" }}
		</td>
 	</tr>
    <tr>
		<td width="25%" valign="top">
			<strong>
			Mobile
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $staff_details['step_data']['emer_mobile']  or "" }}
		</td>
 	</tr>


</table>

</div>
<div class="page-break"></div>

<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>EMPLOYMENT DETAILS</strong></p>

<div >


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
	
<tr>
    <td width="25%" valign="top">
        <strong>
        Start Date
        </strong>
    </td>
    <td width="75%" valign="top">
       {{ $staff_details['step_data']['start_date']  or "" }}
    </td>
</tr>
<tr>
    <td width="25%" valign="top">
        <strong>
        Holiday Entitlement
        </strong>
    </td>
    <td width="75%" valign="top">
        {{ $staff_details['step_data']['holiday_entitlement']  or "" }}
    </td>
</tr>
<tr>
    <td width="25%" valign="top">
        <strong>
        Salary
        </strong>
    </td>
    <td width="75%" valign="top">
        {{ $staff_details['step_data']['salary']  or "" }}
    </td>
</tr>
<tr>
    <td width="25%" valign="top">
        <strong>
        Qualifications
        </strong>
    </td>
    <td width="75%" valign="top">
        {{ $staff_details['step_data']['qualifications']  or "" }}
    </td>
</tr>

<tr>
    <td width="25%" valign="top">
        <strong>
        Department
        </strong>
    </td>
    <td width="75%" valign="top">
        {{$deptname or ""}}
    </td>
</tr>

<tr>
    <td width="25%" valign="top">
        <strong>
        End Date
        </strong>
    </td>
    <td width="75%" valign="top">
        {{ $staff_details['step_data']['end_date']  or "" }}
    </td>
</tr>
</table>

</div>
<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>OTHERS</strong></p>

<div >


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
<tr>
    <td width="25%" valign="top">
        <strong>
        Bank Name
        </strong>
    </td>
    <td width="75%" valign="top">
        {{ $staff_details['step_data']['bank_name']  or "" }}
    </td>
</tr>
<tr>
    <td width="25%" valign="top">
        <strong>
        Sort code
        </strong>
    </td>
    <td width="75%" valign="top">
        {{ $staff_details['step_data']['short_code']  or "" }}
    </td>
</tr>
<tr>
    <td width="25%" valign="top">
        <strong>
        Account Number
        </strong>
    </td>
    <td width="75%" valign="top">
       {{ $staff_details['step_data']['acc_no']  or "" }}
    </td>
</tr>
</table>

</div>
