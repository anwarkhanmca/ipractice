<style>
.page-break {
page-break-after: always;
}
.footer { position: fixed; bottom: 5px; border-bottom: 2px solid #00ACD6; padding-bottom: -35px; font-size:14px;  }
.divider {color:#ccc; padding: 0 10px 0 10px ;}
</style>
<!--
<div style="border-top: #00ACD6 solid 30px; "></div>
<div style="height: 200px;"></div>
<h2 style="font-size: 50px; color:#00ACD6 ; text-align: center;  ">{{ $client_name or "" }} </h2>
<div style="height: 15px;"></div>
<h1 style="font-size: 30px; text-align: center; font-weight: normal; ">{{ "CLIENT OVERVIEW"}}</h1>
<div style="height: 220px;"></div>
<div style="border-top: #00ACD6 solid 30px; "></div>
-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td style="border-top: #00ACD6 solid 30px; ">&nbsp;</td>
	</tr>
	<tr>
		<!-- <td style="height: 220px;">&nbsp;</td> -->
		@if(strlen($title) > 20)
		<td style="height: 220px;">&nbsp;</td>
		@else
		<td style="height: 240px;">&nbsp;</td>
		@endif
		<!--
		<td style="height: 270px;">&nbsp;</td> -->
	</tr>
	<tr>
		<td style="font-size: 50px; color:#00ACD6 ; text-align: center;  ">{{ $practice_details->legal_name or '' }}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 30px; text-align: center; font-weight: normal; ">{{ "Practice Details"}}</td>
	</tr>
	<tr>
		@if(strlen($title) > 20)
		<td style="height: 220px;">&nbsp;</td>
		@else
		<td style="height: 260px;">&nbsp;</td>
		@endif
		<!--
		<td style="height: 220px;">&nbsp;</td>
		<td style="height: 250px;">&nbsp;</td>-->
	</tr>
	<tr>
		<td style="border-top: #00ACD6 solid 30px; position: fixed; bottom:0; ">&nbsp;</td>
	</tr>
</table>
<div class="clearfix"></div>
<div>
	<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>GENERAL</strong></p>
	<!-- <div style="padding-bottom: 7px; width:100%;">
		<div style="float: left; width:300px !important;"><strong>Client Code :</strong></div>
		<div style="float: left;">{{ $client_details['client_code'] or "" }}</div>
		<div class="clearfix"></div>
	</div>-->
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
		<tr>
			<td width="25%">
				<strong>
				Display Name
				</strong>
			</td>
			<td width="75%">
				{{ $practice_details->display_name or '' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Legal/Trading Name
				</strong>
			</td>
			<td width="75%">
				{{ $practice_details->legal_name or '' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Registration Number
				</strong>
			</td>
			<td width="75%">
				{{ (isset($practice_details->registration_no) && $practice_details->registration_no != 0)?$practice_details->registration_no:'' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Organisation Type
				</strong>
			</td>
			<td width="75%">
			{{$org_name or ""}}
			</td>
		</tr>
	
	</table>
</div>
<div class="page-break"></div>
<div class="footer">{{ "Practice Details"}}<span class="divider">| </span> {{$practice_details->legal_name or '' }}<span class="divider">| </span> {{$today or ""}} {{$time or ""}}
</div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>Companies’ House login</strong></p>
<div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
	<tr>
			<td width="25%">
				<strong>
				User Name
				</strong>
			</td>
			<td width="75%">
			{{ (isset($ch_logins['email']) && $ch_logins['email'] != '')?$ch_logins['email']:'' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Password
				</strong>
			</td>
			<td width="75%">
			{{ (isset($ch_logins['password']) && $ch_logins['password'] != '')?$ch_logins['password']:'' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Presenter ID
				</strong>
			</td>
			<td width="75%">
				{{ (isset($ch_logins['presenter_id']) && $ch_logins['presenter_id'] != '')?$ch_logins['presenter_id']:'' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Presenter Authentication codes
				</strong>
			</td>
			<td width="75%">
				{{ (isset($ch_logins['auth_code']) && $ch_logins['auth_code'] != '')?$ch_logins['auth_code']:'' }}
			</td>
		</tr>
        </table>
</div>
<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>HMRC Log In</strong></p>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
	<tr>
			<td width="25%">
				<strong>
				User Name
				</strong>
			</td>
			<td width="75%">
			&nbsp;
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Password
				</strong>
			</td>
			<td width="75%">
			&nbsp;
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Gateway Agent Identifier
				</strong>
			</td>
			<td width="75%">
			&nbsp;
			</td>
		</tr>
	
        </table>
</div>
<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>Agent IDS</strong></p>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
	<tr>
		<td width="25%"><strong>Paye</strong></td>
		<td width="75%">{{ $practice_details->agentpaye or '' }}</td>
	</tr>
	<tr>
		<td width="25%"><strong>CT</strong></td>
		<td width="75%">{{ $practice_details->agentct or '' }}</td>
	</tr>
	<tr>
		<td width="25%"><strong>SA</strong>
		</td>
		<td width="75%">{{ $practice_details->agentsa or '' }}</td>
	</tr>
	
        </table>
</div>
<div class="page-break"></div>

<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>Contact Details</strong></p>
<div>
<div id="condiv">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
		<tr>
			<td width="25%">
				<strong style="font-size: 20px;"><font color="#00ACD6">  Registered Address </font> </strong>
			</td>
			<td width="75%">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Attention
				</strong>
			</td>
			<td width="75%">
				{{ $practice_address['reg_attention'] or '' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Street Address or PO Box
				</strong>
			</td>
			<td width="75%">
			{{ $practice_address['reg_street_address'] or ''}}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Town/City
				</strong>
			</td>
			<td width="75%">
			{{ $practice_address['reg_city'] or '' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				State/Region
				</strong>
			</td>
			<td width="75%">
				{{ $practice_address['reg_state'] or '' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Postal/Zip Code
				</strong>
			</td>
			<td width="75%">
			{{ $practice_address['reg_zip'] or '' }}
			</td>
		</tr>
        	<tr>
			<td width="25%">
				<strong>
				Country
				</strong>
			</td>
			<td width="75%">
				{{$reg_country_name}}
			</td>
		</tr>
		<tr>
			<td width="25%">
				&nbsp;
			</td>
			<td width="75%">
				&nbsp;
			</td>
		</tr>
		
		<tr>
			<td width="25%">
				<strong style="font-size: 20px;"><font color="#00ACD6">Physical Address</font></strong>
			</td>
			<td width="75%">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Attention
				</strong>
			</td>
			<td width="75%">
				{{ $practice_address['phy_attention'] or '' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Street Address or PO Box
				</strong>
			</td>
			<td width="75%">
				{{ $practice_address['phy_street_address'] or ''}}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Town/City
				</strong>
			</td>
			<td width="75%">
					{{ $practice_address['phy_city'] or '' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				State/Region
				</strong>
			</td>
			<td width="75%">
					{{ $practice_address['phy_state'] or '' }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Postal/Zip Code
				</strong>
			</td>
			<td width="75%">
				{{ $practice_address['phy_zip'] or '' }}
			</td>
		</tr>
        	<tr>
			<td width="25%">
				<strong>
				Country
				</strong>
			</td>
			<td width="75%">
				{{$practice_address['phy_country_id']}}
			</td>
		</tr>
		<tr>
			<td width="25%">
				&nbsp;
			</td>
			<td width="75%">
				&nbsp;
			</td>
		</tr>
	
		<tr>
			<td width="25%">
				<strong>
				Telephone
				</strong>
			</td>
			<td width="75%">
				{{ $practice_details['telephone_no']['0'] or ""}}{{ $practice_details['telephone_no']['1'] or ""}}	{{ $practice_details['telephone_no']['2'] or ""}}
			</td>
		</tr>
	
		<tr>
			<td width="25%">
				<strong>
				FAX
				</strong>
			</td>
			<td width="75%">
				{{ $practice_details['fax_no']['0'] or ""}}{{ $practice_details['fax_no']['1'] or ""}}	{{ $practice_details['fax_no']['2'] or ""}}
			</td>
		</tr>    
		
	<tr>
			<td width="25%">
				<strong>
				MOBILE
				</strong>
			</td>
			<td width="75%">
				{{ $practice_details['mobile_no']['0'] or ""}}{{ $practice_details['mobile_no']['1'] or ""}}	{{ $practice_details['mobile_no']['2'] or ""}}
			</td>
		</tr>   
	
        
		
	
	
		
	</table>
</div>
</div>
<div class="page-break"></div>