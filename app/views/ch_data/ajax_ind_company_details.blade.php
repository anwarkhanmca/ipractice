
<table width="100%" border="1" bordercolor="60aad2">
  <tr class="td_color">
    <td align="center"><span class="table_tead_t">RELATED COMPANY</span></td>
  </tr>

  <tr>
    <td width="60%" align="left"><a href="#">{{ $details->CompanyName or "" }}</a></td>
  </tr>
    
</table>

<br />

<table width="100%" border="1" bordercolor="60aad2">
  <tr class="td_color">
    <td align="center" colspan="3"><span class="table_tead_t">OFFICERS</span></td>
  </tr>
  <tr class="td_color">
    <td align="left" class="sub_header">Name</td>
    <!-- <td align="left" class="sub_header">Appointment Date</td> -->
    <td align="left" class="sub_header">Role</td>
    <td align="center" width="17%" class="sub_header">Client List</td>
  </tr>

  @if(isset($officers) && count($officers)>0)
    @foreach($officers as $key=>$field_row)
      @if(!isset($field_row->resigned_on))
      <tr>
        <td align="left"><a href="javascript:void(0)" data-key="{{ $key }}" data-number="{{ $details->CompanyNumber }}" class="link_color get_officers">{{ ucwords($field_row->name) }}</a></td>
        <!-- <td align="left">{{ date("d F Y", strtotime($field_row->appointed_on)) }}</td> -->
        <td align="left">{{ ucwords(str_replace("-", " ", $field_row->officer_role)) }}</td>
        <td align="center"><a href="javascript:void(0)" class="add_client_officers" id="goto{{ $key }}" data-role="{{ $field_row->officer_role or "" }}" data-key="{{ $key }}" data-company_number="{{ $details->CompanyNumber or "" }}"  data-goto_url="{{ base64_encode('ind_client') }}"><button class="btn btn-default btn-sm imp_but" type="button">+ Add</button></a></td>
      </tr>
      @endif
    @endforeach
  @endif
</table>