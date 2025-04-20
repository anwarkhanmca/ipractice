<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
        
<tr>

                <td><h5>Date:{{$cdate or ""}}</h5></td>
                <td>&nbsp;</td>
                <td colspan="2" height="30px" align="center">
                
               	{{ "CRM - CLOSED DEAL REPORTS" }}
                
                
                </td>
                <td>&nbsp;</td>
</tr>

<tr>

                <td><h5>Time:		{{$ctime or ""}}</h5></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
</tr>
<tr>

                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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










