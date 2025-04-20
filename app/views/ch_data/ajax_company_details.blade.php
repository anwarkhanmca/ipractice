<div style="float: center; margin-bottom: 5px;"><a href="javascript:void(0)" data-number="{{ $details->CompanyNumber or "" }}" class="btn btn-info import_client" data-goto_url="{{ base64_encode('org_client') }}">IMPORT</a></div>
<div id="message_div"></div>
<table width="100%" border="1" bordercolor="60aad2">
  <tr class="td_color">
    <td colspan="2" align="center"><span class="table_tead_t">OVERVIEW</span></td>
  </tr>
  <tr>
    <td width="40%" class="td_color" align="left"><strong>Company Name</strong></td>
    <td width="60%" align="left">{{ $details->CompanyName or "" }}</td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Registration Number</strong></td>
    <td align="left">{{ $details->CompanyNumber or "" }}</td>
  </tr>
  <!-- <tr>
    <td class="td_color" align="left"><strong>Registered in</strong></td>
    <td align="left">{{ $client_data['registered_in'] or "" }}</td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Web Filing Authentication Code</strong></td>
    <td align="left">{{ $client_data['ch_auth_code'] or "" }}</td>
  </tr> -->
  <tr>
    <td class="td_color" align="left"><strong>Company Category</strong></td>
    <td align="left">{{ $details->CompanyCategory or "" }}</td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Company Status</strong></td>
    <td align="left">{{ $details->CompanyStatus or "" }}</td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Country of Origin</strong></td>
    <td align="left">{{ $details->CountryOfOrigin or "" }}</td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Incorporation Date</strong></td>
    <td align="left">{{ $details->IncorporationDate or "" }}</td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Nature of Business</strong></td>
    <td align="left">{{ $nature_of_business or "" }}</td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Accounting Reference Date</strong></td>
    <td align="left">{{ $details->Accounts->AccountRefDay or "" }}/{{ $details->Accounts->AccountRefMonth or "" }}</td>
  </tr>
  <tr>
    <td class="td_color" align="left"><strong>Last Accounts made Up Date</strong></td>
    <td align="left">{{ $details->Accounts->LastMadeUpDate or "" }}</td>
  </tr>
    <tr>
    <td class="td_color" align="left"><strong>Next Accounts Due</strong></td>
    <td align="left">{{ $details->Accounts->NextDueDate or "" }}</td>
  </tr>
    <tr>
    <td class="td_color" align="left"><strong>Last Return Made Up To</strong></td>
    <td align="left">{{ $details->Returns->LastMadeUpDate or "" }}</td>
  </tr>
    <tr>
    <td class="td_color" align="left"><strong>Next Return Due</strong></td>
    <td align="left">{{ $details->Returns->NextDueDate or "" }}</td>
  </tr>
  
</table>

<table width="100%" border="1" bordercolor="60aad2" class="register_top">
  <tr class="td_color">
    <td align="center"><span class="table_tead_t">REGISTERED OFFICE</span></td>
  </tr>
  <tr>
    <td align="left">
    {{ $registered_office->address_line_1 or "" }}<br>
    {{ $registered_office->address_line_2 or "" }}<br>
    {{ $registered_office->locality or "" }}<br>
    {{ $registered_office->country or "" }}<br>
    {{ $registered_office->postal_code or "" }}
    </td>
  </tr>
</table>

<table width="100%" border="1" bordercolor="60aad2">
  <tr class="td_color">
    <td align="center" colspan="3"><span class="table_tead_t">OFFICERS</span></td>
  </tr>
  <tr class="td_color">
    <td align="left" class="sub_header">Name</td>
    <td align="left" class="sub_header">Appointment Date</td>
    <td align="left" class="sub_header">Role</td>
    <!-- <td align="center" class="sub_header">Client List</td> -->
  </tr>

  @if(isset($officers) && count($officers)>0)
    @foreach($officers as $key=>$field_row)
      @if(!isset($field_row->resigned_on))
      <tr>
        <td align="left"><a href="javascript:void(0)" data-key="{{ $key }}" data-number="{{ $details->CompanyNumber }}" class="link_color get_officers">{{ ucwords($field_row->name) }}</a></td>
        <td align="left">{{ date("d F Y", strtotime($field_row->appointed_on)) }}</td>
        <td align="left">{{ ucwords(str_replace("-", " ", $field_row->officer_role)) }}</td>
        <!-- <td align="center"><a href="javascript:void(0)" class="add_client_officers" id="goto{{ $key }}" data-role="{{ $field_row->officer_role or "" }}" data-key="{{ $key }}" data-company_number="{{ $details->CompanyNumber or "" }}" target="_blank"><button type="button">+ Add</button></a></td> -->
      </tr>
      @endif
    @endforeach
  @endif
</table>