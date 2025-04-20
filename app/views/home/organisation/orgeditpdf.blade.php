<style>
.page-break {
page-break-after: always;
}
.footer { position: fixed; bottom: 5px; border-bottom: 2px solid #00ACD6; padding-bottom: -25px; font-size:14px;  }
.divider {color:#ccc; padding: 0 10px 0 10px ;}
.hmrc { position: fixed;  }
</style>
<!--<div style="border-top: #00ACD6 solid 30px; "></div>
<div style="position: relative;">
	<div style="height: 150px;"></div>
	<h2 style="font-size: 50px; color:#00ACD6 ; text-align: center;  ">{{ "THOMAS A'BECKETT CLOSE" }}</h2>
	<div style="height: 15px;"></div>
	<h1 style="font-size: 30px; text-align: center; font-weight: normal; ">{{ "CLIENT OVERVIEW"}}</h1>
	<div style="height: 180px;"></div>
	<div style="border-top: #00ACD6 solid 30px; position: fixed; bottom:0; "></div>
</div>-->
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
	<tr>
		<td style="border-top: #00ACD6 solid 30px; ">&nbsp;</td>
	</tr>
	<tr>
		<!-- <td style="height: 220px;">&nbsp;</td> -->
		@if(strlen($client_details['business_name']) > 20)
		<td style="height: 220px;">&nbsp;</td>
		@else
		<td style="height: 240px;">&nbsp;</td>
		@endif
		<!--
		<td style="height: 270px;">&nbsp;</td> -->
	</tr>
	<tr>
		<td style="font-size: 50px; color:#00ACD6 ; text-align: center;  ">{{ $client_details['business_name']  or "" }}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 30px; text-align: center; font-weight: normal; ">{{ "CLIENT OVERVIEW"}}</td>
	</tr>
	<tr>
		@if(strlen($client_details['business_name']) > 20)
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

	<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>BUSINESS INFORMATION</strong></p>

	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
		<tr>
			<td width="25%">
				<strong>
				Client Code
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['client_code'] or "" }}
			</td>
		</tr>


		<tr>
			<td width="25%">
				<strong>
				Business Type
				</strong>
			</td>
			<td width="75%">
				{{ $businessname or "" }}
			</td>
		</tr>


		<tr>
			<td width="25%">
				<strong>
				Registration Number
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['registration_number'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Incorporation Date
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['incorporation_date'] or "" }}
			</td>
		</tr>


		<tr>
			<td width="25%">
				<strong>
				Registered In
				</strong>
			</td>
			<td width="75%">
				{{ $regname or "" }}
			</td>
		</tr>


		<tr>
			<td width="25%">
				<strong>
				Business Description
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['business_desc'] or "" }}
			</td>
		</tr>



		<tr>
			<td width="25%">
				<strong>
				Made up Date
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['made_up_date'] or "" }}
			</td>
		</tr>


		<tr>
			<td width="25%">
				<strong>
				Next Return Due
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['next_ret_due'] or "" }}
			</td>
		</tr>


		<tr>
			<td width="25%">
				<strong>
				CH Authentication Code
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['ch_auth_code'] or "" }}
			</td>
		</tr>


		<tr>
			<td width="25%">
				<strong>
				Accounting Ref Date
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['acc_ref_day'] or "" }}{{$client_details['acc_ref_month'] or ""}}
			</td>
		</tr>




		<tr>
			<td width="25%">
				<strong>
				Last Account Made Up Date
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['last_acc_madeup_date'] or "" }}
			</td>
		</tr>



		<tr>
			<td width="25%">
				<strong>
				Next Account Due
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['next_acc_due'] or "" }}
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

<div class="footer">{{ "CLIENT OVERVIEW"}}  <span class="divider">| </span>{{ $client_details['business_name'] or ""}} <span class="divider">| </span> {{$today or ""}} {{$time or ""}}
</div>

<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>TAX INFORMATION</strong></p>

<div >


<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
	<tr>
		<td width="25%">
			<strong>
			<font color="#00ACD6">VAT </font>
			</strong>
		</td>
		<td width="75%">
			&nbsp;
		</td>
	</tr>



	<tr>
		<td width="25%" style="padding-top: 5px;">
			<strong>
			Effective Date of Registration
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['effective_date'] or "" }}
		</td>
	</tr>


	<tr>
		<td width="25%">
			<strong>
			Vat Number
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['vat_number'] or "" }}
		</td>
	</tr>

	<tr>
		<td width="25%">
			<strong>
			Vat Scheme
			</strong>
		</td>
		<td width="75%">
			{{ $vat_scheme or "" }}
		</td>
	</tr>


	<tr>
		<td width="25%">
			<strong>
			Return Frequency
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['ret_frequency'] or "" }}
		</td>
	</tr>


	<tr>
		<td width="25%">
			<strong>
			Vat Stagger
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['vat_stagger'] or "" }}
		</td>
	</tr>
	<tr>




		<td width="25%" style="padding-top: 10px;">
			<strong>
			<font color="#00ACD6">	Tax </font>
			</strong>
		</td>
		<td width="75%">
			&nbsp;
		</td>
	</tr>



	<tr>
		<td width="25%">
			<strong>
			Tax Type
			</strong>
		</td>
		<td width="75%">
            @if(!empty($client_details['tax_reference_type']))
			@if($client_details['tax_reference_type'] == "N")
			{{ (isset($client_details['tax_reference_type']) && $client_details['tax_reference_type'] == "N")?"None":""}}
			@endif

			@if($client_details['tax_reference_type'] == "I")
			{{ (isset($client_details['tax_reference_type']) && $client_details['tax_reference_type'] == "I")?"Income Tax":""}}
			@endif

			@if($client_details['tax_reference_type'] == "C")
			{{ (isset($client_details['tax_reference_type']) && $client_details['tax_reference_type'] == "C")?"Corporation Tax":""}}
			@endif
            @endif
			<!--	 {{ $client_details['tax_reference_type'] or "" }} -->
		</td>
	</tr>


	<tr>
		<td width="25%">
			<strong>
			Tax Reference(UTR)
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['tax_reference'] or "" }}
		</td>
	</tr>


	<tr>
		<td width="25%">
			<strong>
			Tax District
			</strong>
		</td>
		<td width="75%">
			{{ $taxoffice_name or "" }}
		</td>
	</tr>

	<tr>
		<td width="25%">
			<strong>
			Postal Address
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['tax_address'] or "" }}
		</td>
	</tr>


	<tr>
		<td width="25%">
			<strong>
			Post Code
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['tax_zipcode'] or "" }}
		</td>
	</tr>





	<tr>
		<td width="25%" style="padding-top: 10px;">
			<strong>
			<font color="#00ACD6">PAYE</font>
			</strong>
		</td>
		<td width="75%">
			&nbsp;
		</td>
	</tr>

	<tr>



		<td width="25%">
			<strong>
			Account Office Reference
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['acc_office_ref'] or "" }}
		</td>
	</tr>


	<tr>
		<td width="25%">
			<strong>
			PAYE Reference
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['paye_reference'] or "" }}
		</td>
	</tr>


	<tr>
		<td width="25%">
			<strong>
			PAYE District
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['paye_district'] or "" }}
		</td>
	</tr>
	<tr>
		<td width="25%">
			<strong>
			Employer Office
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['employer_office'] or "" }}
		</td>
	</tr>



	<tr>
		<td width="25%">
			<strong>
			Post Code
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['employer_postcode'] or "" }}
		</td>
	</tr>

	<tr>
		<td width="25%">
			<strong>
			Telephone
			</strong>
		</td>
		<td width="75%">
			{{ $client_details['employer_telephone'] or "" }}
		</td>
	</tr>


	<tr class="hmrc">
		<td width="25%" valign="top">
			<strong>
			<font color="#00ACD6">	HMRC Log-in Details </font>
			</strong>
		</td>
		<td width="75%" valign="top">
			{{ $client_details['hmrc_login_details'] or "" }}
		</td>
	</tr>



</table>

</div>
<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>CONTACT INFORMATION</strong></p>
<div >
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">


	<tr>  <td width="25%">
		<strong>

		<font color="#00ACD6">	Trading Address  </font>

		</strong>
	</td>
	<td width="75%">
		&nbsp;
	</td>

</tr>

<tr>
	<td width="25%">
		<strong>
		Address Line1
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_addr_line1'] or "" }}
	</td>
</tr>

<tr>
	<td width="25%">
		<strong>
		Address Line2
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_addr_line2'] or "" }}
	</td>
</tr>

<tr>
	<td width="25%">
		<strong>
		City/Town
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_city'] or "" }}
	</td>
</tr>

<tr>
	<td width="25%">
		<strong>
		County
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_county'] or "" }}
	</td>
</tr>
<tr>
	<td width="25%">
		<strong>
		Postcode
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_postcode'] or "" }}
	</td>
</tr>

<tr>
	<td width="25%">
		<strong>
		Country
		</strong>
	</td>
	<td width="75%">
		{{ $trad_country or "" }}
	</td>
</tr>

<tr>
	<td width="25%">
		<strong>
		Website
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_website'] or "" }}
	</td>

</tr>

<tr>
	<td width="25%">
		<strong>
		Contact Name
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_name'] or "" }}
	</td>

</tr>

<tr>
	<td width="25%">
		<strong>
		Telephone
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_telephone'] or "" }}
	</td>

</tr>
<tr>
	<td width="25%">
		<strong>
		Mobile
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_mobile'] or "" }}
	</td>

</tr>


<tr>
	<td width="25%">
		<strong>
		Email
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_email'] or "" }}
	</td>

</tr>
<tr>
	<td width="25%">
		<strong>
		Skype
		</strong>
	</td>
	<td width="75%">
		{{ $client_details['trad_cont_skype'] or "" }}
	</td>

</tr>






</table>



</div>


<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>CONTACT INFORMATION</strong></p>
<div >
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">




<tr>  <td width="25%">
	<strong>
	<font color="#00ACD6">	Correspondence Address </font>

	</strong>
</td>
<td width="75%">
	&nbsp;
</td>

</tr>






<tr>
<td width="25%">
	<strong>
	Address Line1
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_addr_line1'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
	<strong>
	Address Line2
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_addr_line2'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
	<strong>
	City/Town
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_city'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
	<strong>
	County
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_county'] or "" }}
</td>
</tr>
<tr>
<td width="25%">
	<strong>
	Postcode
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_postcode'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
	<strong>
	Country
	</strong>
</td>
<td width="75%">
	{{ $corres_country or "" }}
</td>
</tr>

<tr>
<td width="25%">
	<strong>
	Website
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_website'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
	<strong>
	Contact Name
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_name'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
	<strong>
	Telephone
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_telephone'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
	<strong>
	Mobile
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_mobile'] or "" }}
</td>

</tr>


<tr>
<td width="25%">
	<strong>
	Email
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_email'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
	<strong>
	Skype
	</strong>
</td>
<td width="75%">
	{{ $client_details['corres_cont_skype'] or "" }}
</td>

</tr>








</table>



</div>












<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>CONTACT INFORMATION</strong></p>
<div >
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">


<tr>  <td width="25%">
<strong>

<font color="#00ACD6">	Bankers </font>

</strong>
</td>
<td width="75%">
&nbsp;
</td>

</tr>






<tr>
<td width="25%">
<strong>
Address Line1
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_addr_line1'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Address Line2
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_addr_line2'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
City/Town
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_city'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
County
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_county'] or "" }}
</td>
</tr>
<tr>
<td width="25%">
<strong>
Postcode
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_postcode'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Country
</strong>
</td>
<td width="75%">
{{ $banker_country or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Website
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_website'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
<strong>
Contact Name
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_name'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
<strong>
Telephone
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_telephone'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Mobile
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_mobile'] or "" }}
</td>

</tr>


<tr>
<td width="25%">
<strong>
Email
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_email'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Skype
</strong>
</td>
<td width="75%">
{{ $client_details['banker_cont_skype'] or "" }}
</td>

</tr>

  <tr>
<td width="25%">
<strong>
Bank Name
</strong>
</td>
<td width="75%">
{{ $client_details['bank_name'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Sort Code
</strong>
</td>
<td width="75%">
{{ $client_details['bank_short_code'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Account Number
</strong>
</td>
<td width="75%">
{{ $client_details['bank_acc_no'] or "" }}
</td>

</tr>
 
   
   
   
   
   
   
   


</table>



</div>






<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>CONTACT INFORMATION</strong></p>
<div >
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">




<tr>  <td width="25%">
<strong>
<font color="#00ACD6">Old Accountants </font>
</strong>
</td>
<td width="75%">
&nbsp;
</td>

</tr>






<tr>
<td width="25%">
<strong>
Address Line1
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_addr_line1'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Address Line2
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_addr_line2'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
City/Town
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_city'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
County
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_county'] or "" }}
</td>
</tr>
<tr>
<td width="25%">
<strong>
Postcode
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_postcode'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Country
</strong>
</td>
<td width="75%">
{{ $oldacc_country or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Website
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_website'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
<strong>
Contact Name
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_name'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
<strong>
Telephone
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_telephone'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Mobile
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_mobile'] or "" }}
</td>

</tr>


<tr>
<td width="25%">
<strong>
Email
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_email'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Skype
</strong>
</td>
<td width="75%">
{{ $client_details['oldacc_cont_skype'] or "" }}
</td>

</tr>


</table>



</div>




<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>CONTACT INFORMATION</strong></p>
<div >
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">




<tr>  <td width="25%" >
<strong>
<font color="#00ACD6">	Auditors </font>
</strong>
</td>
<td width="75%">
&nbsp;
</td>

</tr>






<tr>
<td width="25%">
<strong>
Address Line1
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_addr_line1'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Address Line2
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_addr_line2'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
City/Town
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_city'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
County
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_county'] or "" }}
</td>
</tr>
<tr>
<td width="25%">
<strong>
Postcode
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_postcode'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Country
</strong>
</td>
<td width="75%">
{{ $auditors_country or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Website
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_website'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
<strong>
Contact Name
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_name'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
<strong>
Telephone
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_telephone'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Mobile
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_mobile'] or "" }}
</td>

</tr>


<tr>
<td width="25%">
<strong>
Email
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_email'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Skype
</strong>
</td>
<td width="75%">
{{ $client_details['auditors_cont_skype'] or "" }}
</td>

</tr>


</table>



</div>





<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>CONTACT INFORMATION</strong></p>
<div >
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">



<tr>  <td width="25%" >
<strong>
<font color="#00ACD6">	Solicitors </font>
</strong>
</td>
<td width="75%">
&nbsp;
</td>

</tr>






<tr>
<td width="25%">
<strong>
Address Line1
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_addr_line1'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Address Line2
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_addr_line2'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
City/Town
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_city'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
County
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_county'] or "" }}
</td>
</tr>
<tr>
<td width="25%">
<strong>
Postcode
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_postcode'] or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Country
</strong>
</td>
<td width="75%">
{{ $solicitors_country or "" }}
</td>
</tr>

<tr>
<td width="25%">
<strong>
Website
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_website'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
<strong>
Contact Name
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_name'] or "" }}
</td>

</tr>

<tr>
<td width="25%">
<strong>
Telephone
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_telephone'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Mobile
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_mobile'] or "" }}
</td>

</tr>


<tr>
<td width="25%">
<strong>
Email
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_email'] or "" }}
</td>

</tr>
<tr>
<td width="25%">
<strong>
Skype
</strong>
</td>
<td width="75%">
{{ $client_details['solicitors_cont_skype'] or "" }}
</td>

</tr>




</table>



</div>


<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>RELATIONSHIPS</strong></p>

<div>




<table width="100%" class="table table-bordered table-hover dataTable" id="myRelTable">
<tr>
<td width="40%"><strong>Name</strong></td>
<td width="40%" align="center"><strong>Relationship Type</strong></td>

</tr>
@if(isset($relationship) && count($relationship) >0 )
@foreach($relationship as $key=>$relation_row)
<tr id="database_tr{{ $relation_row['client_relationship_id'] }}">
<td width="40%">
@if((isset($relation_row['type']) && $relation_row['type'] == "non") || (isset($relation_row['is_archive']) && $relation_row['is_archive'] == "Y") || (isset($relation_row['is_deleted']) && $relation_row['is_deleted'] == "Y") || isset($user_type) && $user_type == "C" )
{{ $relation_row['name'] or "" }}
@else
{{ $relation_row['name'] or "" }}
@endif
</td>
<td width="40%" align="center">{{ $relation_row['relation_type'] }}</td>

</tr>
@endforeach
@endif
</table>







</div>

<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>SERVICES</strong></p>
<div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">

<tr>
<td width="25%" style="padding-top: 70px;">
<strong>
&nbsp;
</strong>
</td>
<td width="75%">
&nbsp;
</td>

</tr>

<!--
<table  width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
        @if( isset($old_services) && count($old_services)>0 )
          @foreach($old_services as $key=>$service_row)
        <tr>
          <td align="center" width="40%"><span class="custom_chk"><input type="checkbox" value="{{ $service_row->service_id }}" name="other_services[]" {{ (isset($services_id) && in_array($service_row->service_id, $services_id))?"checked":"" }} /><label><strong>{{ $service_row->service_name }}</strong></label></span></td>
        </tr>
          @endforeach
        @endif

        @if( isset($new_services) && count($new_services)>0 )
          @foreach($new_services as $key=>$service_row)
          <tr id="hide_service_tr_{{ $service_row->service_id }}">
            <td align="center" width="40%"><span class="custom_chk"><input type="checkbox" value="{{ $service_row->service_id }}" name="other_services[]" {{ (isset($services_id) && in_array($service_row->service_id, $services_id))?"checked":"" }} /><label><strong>{{ $service_row->service_name }}</strong></label></span></td>
            
          </tr>
          @endforeach
        @endif
        
        
      </table> -->
</table>
</div>