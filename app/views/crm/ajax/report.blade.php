<div class="select_con1">
	<div class="selec_seclf2">
	    <span class="slct_con"><strong>Average Deal Age : </strong></span>
	    <div style="width: 25%!important; margin:6px 0 0 5px; float:left;"><input type="text" value="{{ number_format($avg_age, 2, '.', '') }}" style="width:65px; height:25px; padding:5px" id="avg_age"></div>
	</div>
	<div class="selec_seclf3" >
        <span class="slct_con"><strong>Conversion Rate : </strong></span>
        <div style="width: 25%!important; margin:6px 0 0 5px; float:left;"><input type="text" value="{{ number_format($converson_rate, 2, '.', '') }}" style="width:65px; height:25px; padding:5px" id="converson_rate"> %</div>
  	</div>
  	<div class="clr"></div>
</div>

<table class="table table-bordered" style="margin-top:20px;">

	<tr>
		<td align="left" >
			<table class="" width="100%" >
				<tr>
					<td width="25%" align="left">Deal Owner </td>
					<td width="30%" align="left">Prospect Name</td>
					<td width="15%" align="left">Close Date</td>
					<td width="10%" align="left">Age</td>
					<td width="10%" align="left">Status</td>
					<td width="10%" align="left">Amount</td>
				</tr>
			</table>
		</td>
	</tr>
<?php $grand_total = 0;?>
@if(isset($outer_details) && count($outer_details) >0)
	@foreach($outer_details as $key=>$outer)
	<?php $total = 0;?>
	<tr>
		<td align="left">
			<table width="100%" >
				<tr>
					<td width="100%" align="left">
						<table width="100%" align="left">
							@if(isset($details) && count($details) >0)
								@foreach($details as $key=>$value)
									@if(isset($value['deal_owner']) && $value['deal_owner'] == $outer->deal_owner)
									<tr>
										<td width="25%" align="left">{{ $value['deal_owner_name'] or "" }}</td>
										<td width="30%" align="left">{{ $value['prospect_name'] or "" }}</td>
										<td width="15%" align="left">{{ $value['close_date'] or "" }}</td>
										<td width="10%" align="left">{{ $value['age'] or "" }}</td>
										<td width="10%" align="left">{{ $value['tab_name'] or "" }}</td>
										<td width="10%" align="right"><b style="margin-right: 15px">{{ $value['quoted_value'] or '0.00' }}</b></td>
									</tr>
									<?php 
										$total_val = str_replace(',', '', $value['quoted_value']);
										$total += $total_val;
									?>
									@endif
								@endforeach
							@endif
						</table>

					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr>
		<td align="center">
			<table width="100%" align="center" >
				<tr>
					<td width="20%" align="center">&nbsp;</td>
					<td width="80%" align="center">
						<table width="100%">
							<tr>
								<td width="25%" align="center">&nbsp;</td>
								<td width="15%" align="center">&nbsp;</td>
								<td width="40%" align="right"><b style="margin-right: 15px;">Total&nbsp;:&nbsp; <?php echo number_format($total, 2);?> </b> </td>

							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php $grand_total += $total;?>
	@endforeach
@endif

	<tr>
		<td align="center">
			<table width="100%" align="center" >
				<tr>
					<td width="20%" align="center">&nbsp;</td>
					<td width="80%" align="center">
						<table width="100%">
							<tr>
								<td width="25%" align="center">&nbsp;</td>
								<td width="15%" align="center">&nbsp;</td>
								<td width="55%" align="right"><b style="margin-right: 15px;">Grand Total&nbsp;:&nbsp; <?php echo number_format($grand_total, 2);?></b> </td>

							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
