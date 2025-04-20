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
					
                    	{{ "CRM - CLOSED DEAL REPORTS" }}
                       
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

<div class="select_con1">
	<div class="selec_seclf2">
	    <span class="slct_con"><strong>Average Deal Age : </strong>{{ number_format($avg_age, 2, '.', '') }}</span>
	    
	</div>
	<div class="selec_seclf3" >
        <span class="slct_con"><strong>Conversion Rate : </strong>{{ number_format($converson_rate, 2, '.', '') }}</span>
       
  	</div>
  	<div class="clr"></div>
</div>
<div style="margin-bottom:4px;" class="clr"></div>
<table>
<tr>
<td>&nbsp;</td>
</tr>

</table>
<table class="table table-bordered" style="width: 100%;margin-bottom: 20px; border-collapse: collapse; border: 1px solid #ccc; ">
<tr>
	<td width="25%" align="left" style="border-bottom: 1px solid #ccc; padding: 10px;">Deal Owner </td>
	<td width="20%" align="left" style="border-bottom: 1px solid #ccc; padding: 10px;">Prospect Name</td>
	<td width="15%" align="left" style="border-bottom: 1px solid #ccc; padding: 10px;">Close Date</td>
	<td width="10%" align="left" style="border-bottom: 1px solid #ccc; padding: 10px;">Age</td>
	<td width="10%" align="left" style="border-bottom: 1px solid #ccc; padding: 10px;">Status</td>
	<td width="20%" align="center" style="border-bottom: 1px solid #ccc; padding: 10px;">Amount</td>
</tr>
<?php $grand_total = 0;?>
@if(isset($outer_details) && count($outer_details) >0)
	@foreach($outer_details as $key=>$outer)
	<?php $total = 0;?>
    
  @if(isset($details) && count($details) >0)
								@foreach($details as $key=>$value)
									@if(isset($value['deal_owner']) && $value['deal_owner'] == $outer->deal_owner)
									<tr>
										<td align="left" style="padding: 10px;">{{ $value['deal_owner_name'] or "" }}</td>
										<td align="left" style="padding: 10px;">{{ $value['prospect_name'] or "" }}</td>
										<td align="left" style="padding: 10px;">{{ $value['close_date'] or "" }}</td>
										<td align="left" style="padding: 10px;">{{ $value['age'] or "" }}</td>
										<td align="left" style="padding: 10px;">{{ $value['tab_name'] or "" }}</td>
										<td align="center" style="padding: 10px;"><b>{{ $value['quoted_value'] or '0.00' }}</b></td>
									</tr>
									<?php 
										$total_val = str_replace(',', '', $value['quoted_value']);
										$total += $total_val;
									?>
									@endif
								@endforeach
							@endif  
<tr>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="center" style="border-top: 1px solid #ccc; padding: 10px;"><b>Total&nbsp;:&nbsp; <?php echo number_format($total, 2);?> </b></td>
</tr>
	<?php $grand_total += $total;?>
	@endforeach
@endif
<tr>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="left" style="border-top: 1px solid #ccc; padding: 10px;">&nbsp;</td>
	<td align="center" style="border-top: 1px solid #ccc; padding: 10px;"><b>Grand Total&nbsp;:&nbsp; <?php echo number_format($grand_total, 2);?></b></td>
</tr>



</table>










