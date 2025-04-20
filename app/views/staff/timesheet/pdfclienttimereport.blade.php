

<div class="col-4" >
        <center><h2 style="color:black" ></h2></center>
    </div>


@if(!empty($cfinal_array))
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top" width="27%">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="26%"><strong>Date  :</strong></td>

    <td width="74%">{{$cdate or ""}}</td>

  </tr>

  <tr>

    <td><strong>Time  :</strong></td>

    <td>{{$ctime or ""}}</td>

  </tr>

</table>
    </td>
    <td width="38%" style="font-size:20px; text-align:center; font-weight:bold; text-decoration:underline;">{{ "Client Time Report" }}</td>
      <td width="35%">&nbsp;</td>
  </tr>
</table>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">

    <table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td width="14%"><strong>Date From :</strong></td>

    <td width="60%">{{$from}}</td>

    <td width="20%"><strong>Service</strong></td>

    <?php if(count($cfinal_array)>1)
 { ?>
  
    <td>{{"Zzzzzz"}}</td>
<?php
 }else{
    ?>
     @foreach($cfinal_array as $key=>$nstaff_row)
     <td>{{$key or ""}}</td>
  @endforeach
  
   <?php 
 }
  ?>

  </tr>

  <tr>

    <td width="14%"><strong>Date To :</strong></td>
    <td width="46%">{{$to}}</td> 
    <td width="20%"> <strong>Client</strong></td>
    <td width="20%">{{$cname or ""}}</td>
  </tr>
<tr>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

    <td>&nbsp;</td>

  </tr>
</table>



    </td>

  </tr>

  

</table>


<!--
<table class="" width="100%" >
<tr>
<td width="20%">Date From</td>
<td width="20%">09/02/2015</td>
<td width="10%" >Staff</td>
<td width="40%">zzzzzz </td>
</tr>
<tr>
<td width="20%">Date To </td>
<td width="20%">09/02/2015</td>
<td width="10%" >Client</td>
<td width="40%">{{$cname or ""}}</td>
</tr>
</table>
<h3>{{"Date:"}}{{$cdate or ""}}</h3>
<h3>{{"Time:"}}{{$ctime or ""}}</h3>
 -->
<!--<div>
<h3>{{"Date:"}}</h3>
<h3>{{"Time:"}}</h3>
<span style="float:left;">

<h3>{{ "Staff:ZZZZ XXXXX"  }}</h3>
<h3>{{ "Client:AAAA Limited"  }}</h3>
</span>

<span style="float:right ;">
<h3>{{"Date From:" }}{{$from}}</h3>
<h3>{{"Date To:" }}{{$to}}</h3>
</span>
</div>-->




<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
<tr>
<td align="center" >
<table class="" width="100%" >
<tr>
<td width="20%" align="center" style="font-size:11pt">Service </td>
<td width="20%" align="center" style="font-size:11pt">Staff Name</td>
<td width="10%" align="center" style="font-size:11pt">Date</td>
<td width="40%" align="center" style="font-size:11pt">Client Name </td>
<td width="10%" align="center" style="font-size:11pt">Hrs</td>
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
<td width="20%" align="center" style="font-size:11pt">  {{$key}}</td>
<td width="80%" align="center">
<table width="100%" align="center">
<?php $i=0; ?>
@foreach($nstaff_row as $eachRE)
<tr>
<td width="25%" align="center" style="font-size:11pt">{{ $eachRE['staff_name'] }}</td>
<td width="15%" align="center" style="font-size:11pt"> {{ $eachRE['date'] }}</td>
<td width="45%" align="center" style="font-size:11pt">{{ $eachRE['client_name'] }}</td>
<td width="15%" align="center" style="font-size:11pt">{{ number_format($eachRE['hrs'], 2, '.', '');    }}<?php $i=$i+$eachRE['hrs']; ?></td>
</tr>
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
<td width="20%" align="center" style="font-size:11pt"><b>Total&nbsp;&nbsp;&nbsp;<?php echo number_format($i, 2, '.', '') ;  $y=$y+$i; ?> </b> </td>


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
<td width="30%" align="center" style="font-size:11pt"><b>GRAND TOTAL&nbsp;&nbsp;&nbsp;<?php echo number_format($y, 2, '.', '') ; ?></b> </td>


</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>
 @endif 