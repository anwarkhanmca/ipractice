
@if($service_id == 1 || $service_id == 2)
<!-- <div class="jobs_tab_list">
  <a href="#">All</a>
  <a href="#">Previous</a>
  <a href="#" class="tab_list_active">Current Period</a>
  <a href="#">Next</a>
  <div class="clr"></div>
</div>

<div class="table_property">
  <strong>Current Return :</strong> October 2015 &nbsp;&nbsp;
  <strong>Due Date :</strong> 21st of November 2015 &nbsp;&nbsp;
  <strong>Count Down :</strong> 6 Days
</div> -->

@endif

<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
  <thead>
    <tr role="row">
    @if($service_id == 1)
      <th width="8%">D0R</th>
      <th width="15%">BUSINESS NAME</th>
      <th>VAT SCHEME</th>
      <th>TYPE</th>
      <th>VAT NUMBER</th>
      <th>STAGGER</th>
      <th>FREQUENCY</th>
    @endif

    @if($service_id == 2)
      <th width="8%">D0R</th>
      <th width="15%">BUSINESS NAME</th>
      <th>VAT SCHEME</th>
      <th>TYPE</th>
      <th>VAT NUMBER</th>
      <th>VAT STAGGER</th>
      <th>ECSL FREQUENCY</th>
     @endif

    @if($service_id == 3)
      <th width="8%">D0I</th>
      <th>CRN</th>
      <th width="15%">BUSINESS NAME</th>
      <th>YEAR END</th>
      <th>AUTHEN CODE</th>
      <th>LAST ACCTS FILED</th>
      <th>NEXT ACCOUNTS DUE</th>
      <th>S/OFF DATE</th>
      <th width="3%">DAYS</th>
    @endif

    @if($service_id == 4)
      <th>BUSINESS NAME</th>
      <th>VAT SCHEME</th>
      <th width="6%">TYPE</th>
      <th width="10%">STAGGER</th>
      <th width="11%">JOB FREQ</th>
      <th width="5%">Hrs/Wk</th>
    @endif

    @if($service_id == 5)
      <th width="8%">D0I</th>
      <th width="15%">BUSINESS NAME</th>
      <th>YEAR END</th>
      <th>LAST ACCTS FILED</th>
      <th>CT. REFERENCE</th>
      <th>TAX RETURN PERIOD</th>
      <th>DUE DATE</th>
      <th>COUNT DOWN</th>
    @endif

    @if($service_id == 7)
      <th width="7%">DOB/DOI</th>
      <th width="8%">CLIENT TYPE</th>
      <th>NAME</th>
      <th width="8%">NI NUMBER</th>
      <th width="10%">TAX REFERENCE</th>
      <th>ADDRESS</th>
    @endif

    @if($service_id == 8)
      <th>BUSINESS NAME</th>
      <th width="7%">YEAR END</th>
      <th width="12%">CLIENT CONTACT</th>
      <th>EMAIL</th>
      <th>PHONE</th>
      <th width="10%">FREQUENCY</th>
      <th width="8%">DUE DATE</th>
      
    @endif
   
    @if($service_id == 9)
      <th width="8%">D0I</th>
      <th>CRN</th>
      <th width="15%">BUSINESS NAME</th>
      <th>YEAR END</th>
      <th>AUTHEN CODE</th>
      <th>LAST RETURN DATE</th>
      <th>NEXT RETURN DUE ON</th>
      <th>COUNT DOWN</th>
    @endif

      
    </tr>
  </thead>
<tbody role="alert" aria-live="polite" aria-relevant="all">
  @if(isset($company_details) && count($company_details) >0)
    @foreach($company_details as $key=>$details)
      <tr class="even">
    @if($service_id == 1)
      <td>{{ isset($details['effective_date'])?date("d-m-Y", strtotime($details['effective_date'])):"" }}</td>
      <td align="left">{{ $details['business_name'] or "" }}</td>
      <td>{{ $details['vat_scheme_type'] or "" }}</td>
      <td>{{ isset($details['vat_scheme'])?ucfirst($details['vat_scheme']):'' }}</td>
      <td>{{ $details['vat_number'] or "" }}</td>
      <td>{{ $details['vat_stagger'] or "" }}</td>
      <td>{{ isset($details['ret_frequency'])?ucfirst($details['ret_frequency']):'' }}</td>
      <td align="center" id="after_send_{{ $details['client_id'] }}">
        @if(isset($details['manage_task']) && $details['manage_task'] == "N")
          <button type="button" class="job_send_btn job_send_pop" data-client_id="{{ $details['client_id'] }}" data-field_name="manage_task">SEND</button>
        @else
          <button type="button" class="job_sent_btn">SENT</button>
        @endif
      </td><!-- send_manage_task -->
    @endif

    @if($service_id == 2)
      <td>{{ isset($details['effective_date'])?date("d-m-Y", strtotime($details['effective_date'])):"" }}</td>
      <td align="left">{{ $details['business_name'] or "" }}</td>
      <td>{{ $details['vat_scheme_type'] or "" }}</td>
      <td>{{ isset($details['vat_scheme'])?ucfirst($details['vat_scheme']):'' }}</td>
      <td>{{ $details['vat_number'] or "" }}</td>
      <td>{{ $details['vat_stagger'] or "" }}</td>
      <td>{{ isset($details['ecsl_freq'])?ucfirst($details['ecsl_freq']):'' }}</td>
      
    @endif

    @if($service_id == 3)
        <td class="sorting_1" align="center">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
        <td align="center">{{ $details['registration_number'] or "" }}</td>
        <td align="left">{{ $details['business_name'] or "" }}</td>
        <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
        <td align="center">{{ $details['ch_auth_code'] or "" }}</td>
        <td align="center">{{ isset($details['last_acc_madeup_date'])?date("d-m-Y", strtotime($details['last_acc_madeup_date'])):"" }}</td>
        <td align="center">{{ isset($details['next_acc_due'])?date("d-m-Y", strtotime($details['next_acc_due'])):"" }}</td>
        <td>
          
          <span class="sign_off_span_{{ $details['client_id'] }}">
              @if(isset($details['sign_off_date']) && $details['sign_off_date'] != "")
              {{ $details['sign_off_date'] }}
          @else
              {{""}}
          @endif
          </span>
        </td>
        <td align="center">
          @if( isset($details['deadacc_count']) && $details['deadacc_count'] < 0 )
            <span style="color:red">{{ $details['deadacc_count'] or "" }}</span>
          @else
             {{ $details['deadacc_count'] or "" }}
          @endif
        </td>
        
    @endif

    @if($service_id == 4)
      <td align="left">{{ $details['business_name'] or "" }}</td>
      <td>{{ $details['vat_scheme_type'] or "" }}</td>
      <td>{{ isset($details['vat_scheme'])?ucfirst($details['vat_scheme']):'' }}</td>
      <td>{{ $details['vat_stagger'] or "" }}</td>
      <td>
        <div class="freq_div_{{ $details['client_id'] or '' }}">
        @if(isset($details['jobs_acc_details']['repeat_day']) && $details['jobs_acc_details']['repeat_day'] !='')
                      Every {{ $details['jobs_acc_details']['repeat_day'] }} Day(s)
           
        @else
          
           {{""}}
          
        @endif
        <div>
        </td>
      <td><span class="hrs_{{ $details['client_id'] or "" }}">{{ $details['jobs_acc_details']['hrs_wk'] or "" }}</span></td>
          @endif

    @if($service_id == 5)
      <td class="sorting_1" align="center">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
      <td align="left">{{ $details['business_name'] or "" }}</td>
      <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
      <td align="center">{{ isset($details['last_acc_madeup_date'])?date("d-m-Y", strtotime($details['last_acc_madeup_date'])):"" }}</td>
      <td>
        @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'C')
          {{ $details['tax_reference'] or "" }}
        @endif
      </td>
      <td align="center">
       {{ (isset($details['jobs_acc_details']['roll_fwd_start']) && $details['jobs_acc_details']['roll_fwd_start'] != "")?$details['jobs_acc_details']['roll_fwd_start'].' - '.$details['jobs_acc_details']['roll_fwd_end']:" " }}
      </td>
      <td><span class="tax_return_end_{{ $details['client_id'] or '0' }}">{{ (isset($details['jobs_acc_details']['roll_fwd_date']) && $details['jobs_acc_details']['roll_fwd_date'] != "")?$details['jobs_acc_details']['roll_fwd_date']:"" }}</span></td>
      <td align="center" class="count_tax_{{ $details['client_id'] or '0' }}">
        @if( isset($details['jobs_acc_details']['roll_count']) && $details['jobs_acc_details']['roll_count'] < 0 )
          <span style="color:red">{{ $details['jobs_acc_details']['roll_count'] or "" }}</span>
        @else
           {{ $details['jobs_acc_details']['roll_count'] or "" }}
        @endif
      </td>
      
    @endif

    @if($service_id == 7)
      @if(isset($details['type']) && $details['type'] == 'ind')
        <td>{{ isset($details['dob'])?date("d-m-Y", strtotime($details['dob'])):"" }}</td>
        <td>Individual</td>
        <td>{{ $details['client_name'] or "" }}</td>
        <td>{{ $details['ni_number'] or "" }}</td>
        <td>
          {{ $details['tax_reference'] or "" }}
        </td>
        <td>{{ $details['address'] or "" }}</td>
      @else
        <td>{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
        <td>Organisation</td>
        <td>{{ $details['business_name'] or "" }}</td>
        <td>N/A</td>
        <td>
          @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
            {{ $details['tax_reference'] or "" }}
          @endif
        </td>
        <td>{{ $details['address'] or "" }}</td>
      @endif
      
    @endif

    @if($service_id == 8)
      <td width="15%"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
      <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
      <td>
        <select class="form-control newdropdown" data-client_id="{{ $details['client_id'] or '0' }}">
          <option value="0" selected="">None</option>
          @if(isset($details['contact_persons']) && count($details['contact_persons']) >0)
            @foreach($details['contact_persons'] as $key=>$contacts)
              <option value="{{ $contacts['client_id'] or "" }}_{{ $contacts['address_type'] or "" }}">{{ $contacts['contact_name'] or "" }}</option>
            @endforeach
          @endif
        </select>
      </td>
      <td>{{ $details['corres_cont_email'] or "" }}</td>
      <td>{{ $details['corres_cont_telephone'] or "" }}</td>
      <td>
        <select class="form-control newdropdown save_details" data-client_id="{{ $details['client_id'] or '0' }}" data-field_name="frequency">
          <option value="">None</option>
          <option value="Monthly" {{ (isset($details['jobs_notes']['frequency']) && $details['jobs_notes']['frequency'] == "Monthly")?'selected':'' }}>Monthly</option>
          <option value="Mar-Jun - Sep-Dec" {{ (isset($details['jobs_notes']['frequency']) && $details['jobs_notes']['frequency'] == "Mar-Jun - Sep-Dec")?'selected':'' }}>Mar-Jun - Sep-Dec</option>
          <option value="Jan-Apr - Jul-Oct" {{ (isset($details['jobs_notes']['frequency']) && $details['jobs_notes']['frequency'] == "Jan-Apr - Jul-Oct")?'selected':'' }}>Jan-Apr - Jul-Oct</option>
          <option value="Feb-May - Aug-Nov" {{ (isset($details['jobs_notes']['frequency']) && $details['jobs_notes']['frequency'] == "Feb-May - Aug-Nov")?'selected':'' }}>Feb-May - Aug-Nov</option>
        </select>
      </td>
      <td>
        <select class="form-control newdropdown save_details" data-client_id="{{ $details['client_id'] or '0' }}" data-field_name="due_date">
          <option value="0">None</option>
          @for($i = 1; $i <=31;$i++)
            <option value="{{ $i }}" {{ (isset($details['jobs_notes']['due_date']) && $details['jobs_notes']['due_date'] == $i)?'selected':'' }}>{{ $i }}</option>
          @endfor
        </select>
      </td>
      
    @endif
        
        
      </tr>
    @endforeach
  @endif
  
</tbody>
</table>
