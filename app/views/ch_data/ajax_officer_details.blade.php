<table width="100%" border="1" bordercolor="60aad2">
  <tr class="td_color">
    <td colspan="2"><span class="table_tead_t">PERSONAL DETAILS</span></td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Name</strong></td><td align="left">{{ $officers['name'] or "" }}</td>
  </tr>
  @if(isset($officers['dob']) && $officers['dob'] != "")
    <tr>
      <td class="td_color" align="left"><strong>DOB</strong></td><td align="left">{{ $officers['dob'] }}</td>
    </tr>
  @endif
  <tr>
    <td class="td_color" align="left"><strong>Nationality</strong></td><td align="left">{{ $officers['nationality'] or "" }}</td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Occupation</strong></td><td align="left">{{ $officers['occupation'] or "" }}</td>
  </tr>
    <tr>
        <td class="td_color" align="left"><strong>Country of residence</strong></td><td align="left">{{ $officers['country_of_residence'] or "" }}</td>
    </tr>
    <tr>
        <td class="td_color" align="left"><strong>Officer Role</strong></td><td align="left">{{ ucwords($officers['officer_role']) }}</td>
    </tr>
    <tr>
        <td class="td_color" align="left"><strong>Appointed on</strong></td><td align="left">{{ date("d F Y", strtotime($officers['appointed_on'])) }}</td>
    </tr>
    <!-- <tr>
        <td class="td_color" align="left"><strong>Resigned on</strong></td><td align="left">{{ date("d F Y", strtotime($officers['resigned_on'])) }}</td>
    </tr> -->
 
    <tr class="td_color">
        <td colspan="2"><span class="table_tead_t">ADDRESS</span></td>
    </tr>

    <tr>
        <td class="td_color" align="left"><strong>Address</strong></td><td align="left">{{ $officers['address']->address_line_1 or "" }}</td>
    </tr>
    <tr>
        <td class="td_color" align="left"><strong>Premises</strong></td><td align="left">{{ $officers['address']->premises or "" }}</td>
    </tr>
    <tr>
        <td class="td_color" align="left"><strong>Town</strong></td><td align="left">{{ $officers['address']->locality or "" }}</td>
    </tr>
    <tr>
        <td class="td_color" align="left"><strong>Post Code</strong></td><td align="left">{{ $officers['address']->postal_code or "" }}</td>
    </tr>
    <tr>
        <td class="td_color" align="left"><strong>Country</strong></td><td align="left">{{ $officers['address']->country or "" }}</td>
    </tr>
</table>