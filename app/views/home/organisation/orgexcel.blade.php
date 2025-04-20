


<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
  <input type="hidden" id="client_type" value="org"> 
  <tr>
    <td><h5>Date:{{$cdate or ""}}</h5></td>
    <td>&nbsp;</td>
    <td colspan="2" height="30px" align="center"><p style="font-size: 18; text-decoration:underline; font-weight:bold;">{{strtoupper($title) }} </p></td>
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
    <thead>
      <tr role="row">
        <td width="5%"><strong>Business Type</strong></td>
        <th width="5%">CRN</th>
        <td width="15%"><strong>Business Name</strong></td>
        <th width="5%">Year End</th>
        <th width="5%">Accounts</th>
        <th width="5%">Annual returns</th>
        <th width="5%">Tax reference</th>
        <th width="5%">Vat number</th>
        <th>VAT Stagger</th>
        <th>Correspondence Address</th>
        <th>reg_cont_name</th>
        
        <th>Account Office Reference</th>
        <th>PAYE Reference</th>
        <th>Employer Office</th>
         <th>Post Code</th>
         <th>Telephone</th>
        <th>HMRC Log-in Details</th>
        <th>Bank Name</th>
        <th>Sort Code</th>
        <th>Account Number</th>
        <th>Marketing Source</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(!empty($client_details))
            <?php $i=1; ?>
            @foreach($client_details as $key=>$client_row)
              <tr class="all_check" {{ ($client_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                
                <td >{{ isset($client_row['business_type'])?$client_row['business_type']:"" }}</td>
                <td >{{ $client_row['registration_number'] or "" }}</td>
                <td >{{$client_row['business_name']  or "" }}</td>
                <td >{{ $client_row['acc_ref_day'] or "" }}-{{ $client_row['ref_month'] or "" }}</td>
                <td >
                  @if( isset($client_row['deadacc_count']) && $client_row['deadacc_count'] == "OVER DUE" )
                    <span style="color:red">{{ $client_row['deadacc_count'] or "" }}</span>
                  @else
                     {{ $client_row['deadacc_count'] or "" }}
                  @endif
                </td>
                <td >
                  @if( isset($client_row['deadret_count']) && $client_row['deadret_count'] == "OVER DUE" )
                    <span style="color:red">{{ $client_row['deadret_count'] or "" }}</span>
                  @else
                     {{ $client_row['deadret_count'] or "" }}
                  @endif
                </td>
                <td >{{ isset($client_row['tax_reference'])?$client_row['tax_reference']:"" }}</td>
                <td >{{ isset($client_row['vat_number'])?$client_row['vat_number']:"" }}</td>
                <td >{{ $client_row['vat_stagger'] or "" }}</td>
                <td >{{ (strlen($client_row['corres_address']) > 48)? substr($client_row['corres_address'], 0, 45)."...": $client_row['corres_address'] }}</td>
            <td >{{ $client_row['reg_cont_name'] or "" }}</td>
            
            <td >{{ $client_row['acc_office_ref'] or "" }}</td>
            <td >{{ $client_row['paye_reference'] or "" }}</td>
             <td >{{ $client_row['employer_office'] or "" }}</td>
             <td >{{ $client_row['employer_postcode'] or "" }}</td>
             <td >{{ $client_row['employer_telephone'] or "" }}</td>
             <td >{{ $client_row['hmrc_login_details'] or "" }}</td>
              <td >{{ $client_row['bank_name'] or "" }}</td>
              <td >{{ $client_row['bank_short_code'] or "" }}</td>
              <td >{{ $client_row['bank_acc_no'] or "" }}</td>
              <td>{{ $client_row['bank_mark_source'] or "" }}</td>
          
              </tr>
            <?php $i++; ?>
          @endforeach
        @endif
      
      
    </tbody>
  </table>