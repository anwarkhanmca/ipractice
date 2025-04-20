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
		@if(strlen($client_name) > 20)
		<td style="height: 220px;">&nbsp;</td>
		@else
		<td style="height: 240px;">&nbsp;</td>
		@endif
		<!--
		<td style="height: 270px;">&nbsp;</td> -->
	</tr>
	<tr>
		<td style="font-size: 50px; color:#00ACD6 ; text-align: center;  ">{{ $client_name  or "" }}</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 30px; text-align: center; font-weight: normal; ">{{ "CLIENT OVERVIEW"}}</td>
	</tr>
	<tr>
		@if(strlen($client_name) > 20)
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
				Gender
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['gender'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Date of Birth
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['dob'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Marital Status
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['merital_status_id'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Spouse Date of Birth
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['spouse_dob'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Country
				</strong>
			</td>
			<td width="75%">
				{{ $countryname or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Occupation
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['occupation'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Nationality
				</strong>
			</td>
			<td width="75%">
				{{ $nationality_name or "" }}
			</td>
		</tr>
	</table>
</div>
<div class="page-break"></div>
<div class="footer">{{ "CLIENT OVERVIEW"}}<span class="divider">| </span> {{ $client_details['title'] or "" }} {{ $client_details['fname'] or "" }} {{ $client_details['mname'] or "" }}{{ $client_details['lname'] or "" }}<span class="divider">| </span> {{$today or ""}} {{$time or ""}}
</div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>TAX INFORMATION</strong></p>
<div>
<div id="taxdiv">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
		<tr>
			<td width="25%">
				<strong>
				NI Number
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['ni_number'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Tax Reference
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['tax_reference'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Tax Office
				</strong>
			</td>
			<td width="75%">
				{{ $taxoffice_name or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Address
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['tax_address'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Postal/Zip Code
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['tax_zipcode'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Telephone
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['tax_telephone'] or "" }}
			</td>
		</tr>
	</table>
</div>
</div>
<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>CONTACT INFORMATION</strong></p>
<div>
<div id="condiv">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" style="line-height: 25px;">
		<tr>
			<td width="25%">
				<strong style="font-size: 20px;"><font color="#00ACD6">  Service Address </font> </strong>
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
				{{ $client_details['serv_addr_line1'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Address Line2
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['serv_addr_line2'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				City/Town
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['serv_city'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				County
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['serv_county'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Country
				</strong>
			</td>
			<td width="75%">
				{{ $servcon or "" }}
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
				&nbsp;
			</td>
			<td width="75%">
				&nbsp;
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong style="font-size: 20px;"><font color="#00ACD6">Residential Address</font></strong>
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
				{{ $client_details['res_addr_line1'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Address Line2
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['res_addr_line2'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				City/Town
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['res_city'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				County
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['res_county'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Country
				</strong>
			</td>
			<td width="75%">
				{{ $rescon or "" }}
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
				{{ $client_details['res_telephone'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Mobile
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['res_mobile'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Email
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['res_email'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Website
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['res_website'] or "" }}
			</td>
		</tr>
		<tr>
			<td width="25%">
				<strong>
				Skype
				</strong>
			</td>
			<td width="75%">
				{{ $client_details['res_skype'] or "" }}
			</td>
		</tr>
	</table>
</div>
</div>
<div class="page-break"></div>
<p style="color: #00ACD6; font-size: 20px; border-bottom:#00ACD6 solid 2px" ><strong>RELATIONSHIPS</strong></p>
<div>
<div class="box-body table-responsive">
	<div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
	<table width="100%" class="table table-bordered table-hover dataTable" id="myRelTable">
		<tr>
			<td width="20%"><strong>Name</strong></td>
			<td width="20%" align="center"><strong>Relationship Type</strong></td>
		</tr>
		@if(isset($relationship) && count($relationship) >0 )
		@foreach($relationship as $key=>$relation_row)
		<tr id="database_tr{{ $relation_row['client_relationship_id'] }}">
			<td width="20%">
				@if((isset($relation_row['type']) && $relation_row['type'] == "non") || (isset($relation_row['is_archive']) && $relation_row['is_archive'] == "Y") || (isset($relation_row['is_deleted']) && $relation_row['is_deleted'] == "Y") || isset($user_type) && $user_type == "C" )
				{{ $relation_row['name'] or "" }}
				@else
				{{ $relation_row['name'] or "" }}
				@endif
			</td>
			<td width="20%" align="center">{{ $relation_row['relation_type'] }}</td>
		</tr>
		@endforeach
		@endif
	</table>
	<div class="clearfix"></div>
</div>
</div>
</div>