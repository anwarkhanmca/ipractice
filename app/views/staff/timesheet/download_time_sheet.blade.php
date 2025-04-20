@if($download_type == 'excel')
<div class="col-4">
  <h1 style="color:black">{{ $heading or '' }}</h1>
</div>
@endif

@if(!empty($cfinal_array))
  @if($download_type == 'pdf')
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
            <td width="38%" style="font-size:20px;text-align:center; font-weight:bold; text-decoration:underline;"> {{ $heading or '' }}</td>
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
            <td width="20%"><strong>Expense Type</strong></td>
            <td>{{ (isset($expense_type) && $expense_type != "")?$expense_type:"Zzzzzz"}}</td>
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
  @endif

<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse; margin-top:20px;">
  <tr>
    <td align="center" >
      <table class="" width="100%" >
        <tr>
          <td width="25%" align="center">Expense Type </td>
          <td width="20%" align="left">Staff Name</td>
          <td width="10%" align="center">Date</td>
          <td width="30%" align="center">Client Name </td>
          <td width="15%" align="right" style="padding-right: 10px;">Amount(£)</td>
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
              <!-- <td width="20%" align="center">{{ $key }}</td> -->
              <td width="100%" align="center">
                <table width="100%" align="center">
                  <?php $i = 0; ?>
                  @foreach($nstaff_row as $eachRE)
                  <tr>
                    <td width="20%" align="center">{{ $eachRE['scheme_name'] }}</td>
                    <td width="20%" align="center">{{ $eachRE['staff_name'] }}</td>
                    <td width="25%" align="center"> {{ $eachRE['date'] }}</td>
                    <td width="25%" align="left">{{ $eachRE['client_name'] }}</td>
                    <td width="10%" align="right" style="padding-right: 10px;">
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