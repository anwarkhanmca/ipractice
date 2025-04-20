<div class="col-4">
        <h1 style="color:black">{{ "Client Time Report" }}</h1>
    </div>


@if(!empty($cfinal_array))



<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
<tr>
<td align="center" >
<table class="" width="100%" >
<tr>
<td width="20%" align="center">Service </td>
<td width="20%" align="center">Staff Name</td>
<td width="10%" align="center">Date</td>
<td width="40%" align="center">Client Name </td>
<td width="10%" align="center">HRS</td>
</tr>
</table>
</td>
</tr>
<?php $y=0; ?>
 @if(isset($cfinal_array))
  @foreach($cfinal_array as $key=>$nstaff_row)
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
<td width="45%" align="center">{{ $eachRE['client_name'] }}</td>
<td width="15%" align="center">{{ number_format($eachRE['hrs'], 2, '.', '')}}</td>
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
<td width="20%" align="center"><b>Total&nbsp;&nbsp;&nbsp;{{number_format($i, 2, '.', '') }} <?php $y=$y+$i; ?> </b> </td>


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
<td width="30%" align="center"><b>GRAND TOTAL&nbsp;&nbsp;&nbsp;{{ number_format($y, 2, '.', '') }}</b> </td>


</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
 @endif