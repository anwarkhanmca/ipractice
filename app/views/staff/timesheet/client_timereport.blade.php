@if(!empty($cfinal_array))

<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse; margin-top:20px;">
	<tr>
		<td align="center" >
			<table class="" width="100%" >
				<tr>
					<td width="25%" align="center">Service </td>
					<td width="20%" align="left">Staff Name</td>
					<td width="10%" align="center">Date</td>
					<td width="30%" align="center">Client Name </td>
					<td width="15%" align="right" style="padding-right: 10px;">Hrs</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php $y = 0; ?>
 	@if(isset($cfinal_array))
  	@foreach($cfinal_array as $key=>$nstaff_row)
	<tr>
		<td align="center">
			<table width="100%" >
				<tr>
					<td width="20%" align="center">{{ $key }}</td>
					<td width="80%" align="center">
						<table width="100%" align="center">
							<?php $i = 0; ?>
							@foreach($nstaff_row as $eachRE)
							<tr>
								<td width="25%" align="center">{{ $eachRE['staff_name'] }}</td>
								<td width="30%" align="center"> {{ $eachRE['date'] }}</td>
								<td width="30%" align="left">{{ $eachRE['client_name'] }}</td>
								<td width="15%" align="right" style="padding-right: 10px;">
									{{ number_format($eachRE['hrs'], 2, '.', '')}}
								</td>
							</tr>
							<?php $i = $i + $eachRE['hrs'];?>
							@endforeach
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
								<td width="30%" align="center">&nbsp;</td>
								<td width="30%" align="right"><b>Total</b></td>
								<td width="15%" align="right" style="padding-right: 10px;"><b>{{number_format($i, 2, '.', '') }}</b></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php $y = $y + $i; ?>
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
								<td width="30%" align="center">&nbsp;</td>
								<td width="30%" align="right"><b>GRAND TOTAL</td>
								<td width="15%" align="right" style="padding-right: 10px;"><b>{{ number_format($y, 2, '.', '') }}</b></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
 @endif