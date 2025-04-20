

@if(!empty($final_array))




             <table class="table table-bordered" style="margin-top:20px;">

<tr>
<td align="center" >
<table class="" width="100%" >
<tr>
<td width="25%" align="center">Client Name</td>
<td width="20%" align="left">Staff Name</td>
<td width="20%" align="left">Date</td>
<td width="20%" align="left">Service</td>
<td width="15%" align="right">Hrs</td>
</tr>
</table>
</td>
</tr>
<?php $y=0; ?>
 @if(isset($final_array))
  @foreach($final_array as $key=>$nstaff_row)
<tr>
<td align="center">
<table width="100%" >
<tr>
<td width="20%" align="center">  {{$key}}</td>
<td width="80%" align="center">
<table width="100%" align="center">
<?php $i=0; ?>
@foreach($nstaff_row as $eachRE)
<tr>
<td width="25%" align="center">{{ $eachRE['staff_name'] }}</td>
<td width="15%" align="center"> {{ $eachRE['date'] }}</td>
<td width="45%" align="center">{{ $eachRE['service'] }}</td>
<td width="15%" align="right">{{ number_format($eachRE['hrs'], 2, '.', ''); }}</td>
</tr>
<?php $i=$i+$eachRE['hrs']; ?>
@endforeach

 <!--   
<tr>
<td align="center">Staff Name</td>
<td align="center">Date</td>
<td align="center">Service</td>
<td align="center">HRS</td>
</tr>
<tr>
<td align="center">Staff Name</td>
<td align="center">Date</td>
<td align="center">Service</td>
<td align="center">HRS</td>
</tr> -->
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
<td width="40%" align="center">&nbsp;</td>
<td width="20%" align="right"><b>Total&nbsp;&nbsp;&nbsp;<?php echo number_format($i, 2, '.', ''); $y=$y+$i; ?> </b></td>


</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
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
<td width="30%" align="center">&nbsp;</td>
<td width="30%" align="right"><b>GRAND TOTAL&nbsp;&nbsp;&nbsp;<?php echo number_format($y, 2, '.', ''); ?></b> </td>


</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
 @endif