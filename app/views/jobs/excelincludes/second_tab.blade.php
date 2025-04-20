@if($page_open == '21')
<div>

@if($service_id == 1 || $service_id == 2)
<!-- <div class="table_property_inner">
  <strong>Current Return :</strong> October 2015 &nbsp;&nbsp;
  <strong>Due Date :</strong> 21st of November 2015 &nbsp;&nbsp;
  <strong>Count Down :</strong> 6 Days
</div> -->
@endif

  
    <thead>
      <tr role="row">
      @if($service_id == 1)
        <th width="8%">D0R</th>
        <th width="15%">BUSINESS NAME</th>
        <th width="5%">STAGGER</th>
        <th width="5%">FREQUENCY</th>
        <th width="5%">RETURN</th>
      @endif

      @if($service_id == 2)
        <th width="8%">D0R</th>
        <th width="15%">BUSINESS NAME</th>
        <th width="10%">VAT STAGGER</th>
        <th width="5%">ECSL FREQUENCY</th>
        <th width="5%">RETURN</th>
      @endif

      @if($service_id == 3)
        <th width="8%">DOI</th>
        <th width="15%">BUSINESS NAME</th>
        <th width="5%">YEAR END</th>
        <th width="5%">NEXT ACCTS DUE ON</th>
        <th width="5%">DAYS</th>
      @endif

      @if($service_id == 4)
        <th width="5%">BUSINESS NAME</th>
        <th width="5%">JOB DUE DATE</th>
      @endif

      @if($service_id == 5)
        <th width="15%">DOI</th>
        <th width="25%">BUSINESS NAME</th>
        <th width="15%">TAX RETURN PERIOD</th>
        <th width="15%">DUE DATE</th>
        <th width="15%">COUNT DOWN</th>
      @endif

      @if($service_id == 7)
        <th width="8%">CLIENT TYPE</th>
        <th width="15%">BUSINESS NAME</th>
        <th width="7%">NI NUMBER</th>
        <th width="9%">TAX REFERENCE</th>
        <th width="7%">RETURN</th>        
      @endif

      @if($service_id == 8)
        <th width="30%">BUSINESS NAME</th>
        <th width="15%">JOB DUE DATE</th>
      @endif

      @if($service_id == 9)
        <th width="8%">DOI</th>
        <th width="15%">BUSINESS NAME</th>
        <th width="5%">AUTHEN CODE</th>
        <th width="15%">NEXT RETURN DUE ON</th>
        <th width="5%">DAYS</th>
      @endif

        <th width="11%">JOB START DATE</th>
      @if($service_id == 7)
        <th width="7%">VIEW DATA</th>
      @endif
        
        
      </tr>
    </thead>

   
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
        
          <tr class="data_tr_{{ $details['client_id'] }}_21">
            

        @if($service_id == 1)
            <td align="left">{{ isset($details['effective_date'])?date("d-m-Y", strtotime($details['effective_date'])):"" }}</td>
            <td align="left">{{ $details['business_name'] or "" }}</td>
            <td align="left">{{ $details['vat_stagger'] or "" }}</td>
            <td align="left">{{ isset($details['ret_frequency'])?ucwords($details['ret_frequency']):"" }}</td>
            <td align="left"></td>
        @endif

        @if($service_id == 2)
            <td align="left">{{ isset($details['effective_date'])?date("d-m-Y", strtotime($details['effective_date'])):"" }}</td>
            <td align="left">{{ $details['business_name'] or "" }}</td>
            <td align="left">{{ $details['vat_stagger'] or "" }}</td>
            <td align="left">{{ isset($details['ecsl_freq'])?ucwords($details['ecsl_freq']):"" }}</td>
            <td align="left"></td>
        @endif

        @if($service_id == 3)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left">{{ $details['business_name'] or "" }}</td>
            <td align="left">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
            <td align="left">{{ isset($details['next_acc_due'])?date("d-m-Y", strtotime($details['next_acc_due'])):"" }}</td>
            <td align="left">
              @if( isset($details['deadacc_count']) && $details['deadacc_count'] < 0 )
                <span style="color:red">{{ $details['deadacc_count'] or "" }}</span>
              @else
                 {{ $details['deadacc_count'] or "" }}
              @endif
            </td>
        @endif

        @if($service_id == 4)
          <td>{{ $details['business_name'] or "" }}</td>
          <td>{{ $details['job_due_date'] or "" }}</td>
        @endif

        @if($service_id == 5)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left">{{ $details['business_name'] or "" }}</td>
            <td align="center">
             {{ (isset($details['jobs_acc_details']['roll_fwd_start']) && $details['jobs_acc_details']['roll_fwd_start'] != "")?$details['jobs_acc_details']['roll_fwd_start'].' - '.$details['jobs_acc_details']['roll_fwd_end']:"Add.." }}
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
            <td>Individual</td>
            <td>{{ $details['client_name'] or "" }}</td>
            <td>{{ $details['ni_number'] or "" }}</td>
            <td>{{ $details['tax_reference'] or "" }}</td>
          @else
            <td>Organisation</td>
            <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
            <td>N/A</td>
            <td>
              @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
                {{ $details['tax_reference'] or "" }}
              @endif
            </td>
          @endif
          
          <th></th>
        @endif

        @if($service_id == 8)
          <td>{{ $details['business_name'] or "" }}</td>
          <td width="10%"></td>
        @endif

            <td align="center">
               {{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}
            </td> 
        @if($service_id == 7)
          <td></td>
        @endif
           
            
            
          </tr>
        @endif 
      @endforeach
    @endif
      
    </tbody>
  </table>
  </div>
  @endif
  @if($page_open == '22')
  <div>
  @if($service_id == 1)
  <div class="table_property_inner">
    <strong>Current Return :</strong> October 2015 &nbsp;&nbsp;
    <strong>Due Date :</strong> 21st of November 2015 &nbsp;&nbsp;
    <strong>Count Down :</strong> 6 Days
  </div>
  @endif
   
    <thead>
      <tr role="row">
        
      @if($service_id == 1)
        <th width="8%">D0I</th>
        <th width="15%">BUSINESS NAME</th>
        <th width="10%">STAGGER</th>
        <th width="5%">FREQUENCY</th>
        <th width="5%">RETURN</th>
      @endif

      @if($service_id == 2)
        <th width="8%">D0I</th>
        <th width="15%">BUSINESS NAME</th>
        <th width="5%">VAT NUMBER</th>
        <th width="10%">STAGGER</th>
        <th width="5%">RETURN</th>
      @endif

      @if($service_id == 3)
        <th width="8%">DOI</th>
        <th width="5%">BUSINESS NAME</th>
        <th width="5%">YEAR END</th>
        <th width="5%">NEXT ACCTS DUE ON</th>
        <th width="5%">DAYS</th>
      @endif

      @if($service_id == 4)
        <th width="15%">BUSINESS NAME</th>
        <th width="5%">JOB DUE DATE</th>
        <th width="12%">JOB START DATE </th>
      @endif

      @if($service_id == 5)
        <th width="10%">DOI</th>
        <th width="25%">BUSINESS NAME</th>
        <th width="10%">CT. REFERENCE</th>
        <th width="10%">TAX RETURN PERIOD</th>
        <th width="10%">DUE DATE</th>
        <th width="10%">COUNT DOWN</th>
      @endif

      @if($service_id == 7)
        <th width="8%">CLIENT TYPE</th>
        <th>BUSINESS NAME</th>
        <th width="7%">NI NUMBER</th>
        <th width="9%">TAX REFERENCE</th>
        <th width="7%">RETURN</th>       
        <th width="11%">JOB START DATE </th>
        <th>VIEW DATA</th>       
      @endif

      @if($service_id == 8)
        <th width="30%">BUSINESS NAME</th>
        <th width="15%">JOB DUE DATE</th>
        <th width="15%">JOB START DATE</th>
      @endif

      @if($service_id == 9)
        <th width="8%">DOI</th>
        <th>BUSINESS NAME</th>
        <th>AUTHEN CODE</th>
        <th>NEXT RETURN DUE ON</th>
        <th>COUNT DOWN</th>
      @endif
        
      @if($service_id == 4 || $service_id == 8)
        <th width="8%">EMAIL CLIENT</th>
      @endif
        
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
          @if(!isset($details['job_status'][$service_id]['status_id']))
          <tr class="data_tr_{{ $details['client_id'] }}_22">
            
        @if($service_id == 1)
          <td>{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td>{{ $details['business_name'] or "" }}</td>
          <td>{{ isset($details['vat_stagger'])?$details['vat_stagger']:"" }}</td>
          <td>{{ isset($details['ret_frequency'])?ucwords($details['ret_frequency']):""}}</td>
          <td>&nbsp;</td>
        @endif

        @if($service_id == 2)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
          <td align="left">{{ $details['vat_number'] or "" }}</td>
          <td align="left">{{ isset($details['vat_stagger'])?ucwords($details['vat_stagger']):"" }}</td>
          <td align="left"></td>
        @endif

        @if($service_id == 3)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
          <td align="left">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
          <td align="left">{{ isset($details['next_acc_due'])?date("d-m-Y", strtotime($details['next_acc_due'])):"" }}</td>
          <td align="left">
            @if( isset($details['deadacc_count']) && $details['deadacc_count'] < 0 )
              <span style="color:red">{{ $details['deadacc_count'] or "" }}</span>
            @else
               {{ $details['deadacc_count'] or "" }}
            @endif
          </td>
      @endif

      @if($service_id == 4)
        <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
        <td>{{ $details['job_due_date'] or "" }}</td>
        <td align="center">
          <div id="edit_calender_{{ $details['client_id'] }}_21" class="edit_cal">
            <a href="javascript:void(0)" id="date_view_{{ $details['client_id'] }}_21" />{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</a>
            <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"></span>
            <div class="cont_add_to_date open_dropdown_{{ $details['client_id'] }}_21" style="display:none;">
            <ul> 
              <li><a href="javascript:void(0)" class="open_calender_pop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21">Add/Edit Start Date</a></li>
              <li>
              <span id="view_calender_{{ $details['client_id'] }}_21" class="addtocalendar atc-style-blue">
                <var class="atc_event">
                  <var class="atc_date_start">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</var>
                  <var class="atc_date_end">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("Y-m-d H:i:s", strtotime('+1 hour', strtotime($details['jobs_notes']['job_start_date'])) ):"" }}</var>
                  <var class="atc_timezone">Europe/London</var>
                  <var class="atc_title">{{$title}} - {{$details['business_name'] or ""}}</var>
                  <var class="atc_description">{{$title}} - {{$details['business_name'] or ""}}</var>
                  <var class="atc_location">Office</var>
                  <var class="atc_organizer">{{ $admin_name }}</var>
                  <var class="atc_organizer_email">{{ $logged_email }}</var>
                </var>
              </span>
              </li>
            </ul>
          </div>
        </div>
        </td> 
      @endif

      @if($service_id == 5)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left">{{ $details['business_name'] or "" }}</td>
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
          <td>Individual</td>
          <td>{{ $details['client_name'] or "" }}</td>
          <td>{{ $details['ni_number'] or "" }}</td>
          <td>{{ $details['tax_reference'] or "" }}</td>
        @else
          <td>Organisation</td>
          <td>{{ $details['business_name'] or "" }}</td>
          <td>N/A</td>
          <td>
            @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
              {{ $details['tax_reference'] or "" }}
            @endif
          </td>
        @endif
        <td></td>
        <td align="center">
          {{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}
        </td>
        <td></td>
      @endif

      @if($service_id == 8)
        <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
        <td>&nbsp;</td>
        <td align="center">
          <div id="edit_calender_{{ $details['client_id'] }}_21" class="edit_cal">
            <a href="javascript:void(0)" id="date_view_{{ $details['client_id'] }}_21" />{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</a>
            <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"></span>
            <div class="cont_add_to_date open_dropdown_{{ $details['client_id'] }}_21" style="display:none;">
            <ul> 

              <li><a href="javascript:void(0)" class="open_calender_pop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21">Add/Edit Start Date</a></li>
              <li>
              <span id="view_calender_{{ $details['client_id'] }}_21" class="addtocalendar atc-style-blue">
                <var class="atc_event">
                  <var class="atc_date_start">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</var>
                  <var class="atc_date_end">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("Y-m-d H:i:s", strtotime('+1 hour', strtotime($details['jobs_notes']['job_start_date'])) ):"" }}</var>
                  <var class="atc_timezone">Europe/London</var>
                  <var class="atc_title">{{$title}} - {{$details['business_name'] or ""}}</var>
                  <var class="atc_description">{{$title}} - {{$details['business_name'] or ""}}</var>
                  <var class="atc_location">Office</var>
                  <var class="atc_organizer">{{ $admin_name }}</var>
                  <var class="atc_organizer_email">{{ $logged_email }}</var>
                </var>
              </span>
              </li>
            </ul>
          </div>
        </div>
        </td> 
        @endif
         
        @if($service_id == 4 || $service_id == 8)
          <td>
            <div class="email_client_selectbox" style="height:24px;">
              <span>SEND</span>
              <div class="small_icon" data-id="{{ $details['client_id'] }}"></div><div class="clr"></div>
              <div class="select_toggle" id="status{{ $details['client_id'] }}" style="display: none;">
                <ul>
                  @if(isset($email_templates) && count($email_templates) >0)
                    @foreach($email_templates as $key=>$temp_row)
                      <li><a href="javascript:void(0)" data-client_id="{{ $details['client_id'] }}" data-template_id="{{ $temp_row['email_template_id'] or "" }}" class="send_template-modal">{{ $temp_row['name'] or "" }}</a></li>
                    @endforeach
                  @endif
                </ul>
              </div>
            </div>

          </td>
        @endif    
            
          </tr>
          @endif
        @endif 
      @endforeach
    @endif
      
    </tbody>
   
  </div>
   @endif
  @for($k=3; $k <= 9;$k++)   
  @if ($page_open == '2'.$k)                      
  <div >
    @if($service_id == 1)
    <div class="table_property_inner">
      <strong>Current Return :</strong> October 2015 &nbsp;&nbsp;
      <strong>Due Date :</strong> 21st of November 2015 &nbsp;&nbsp;
      <strong>Count Down :</strong> 6 Days
    </div>
    @endif

   
     <thead>
      <tr role="row">
        
      @if($service_id == 1)
        <th width="8%">D0I</th>
        <th width="15%">BUSINESS NAME</th>
        <th>VAT NUMBER</th>
        <th>FREQUENCY</th>
        <th>RETURN</th>
      @endif

      @if($service_id == 2)
        <th width="8%">D0I</th>
        <th>BUSINESS NAME</th>
        <th>VAT NUMBER</th>
        <th width="10%">STAGGER</th>
        <th>RETURN</th>
      @endif

      @if($service_id == 3)
        <th width="8%">DOI</th>
        <th>BUSINESS NAME</th>
        <th>YEAR END</th>
        <th>NEXT ACCTS DUE ON</th>
        <th>DAYS</th>
      @endif

      @if($service_id == 4)
        <th>BUSINESS NAME</th>
        <th>JOB DUE DATE</th>
        <th width="12%">JOB START DATE <a href="javascript:void(0)" class="job_start_date-modal"  style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
      @endif

      @if($service_id == 5)
        <th width="15%">DOI</th>
        <th width="25%">BUSINESS NAME</th>
        <th width="15%">CT. REFERENCE</th>
        <th width="15%">TAX RETURN PERIOD</th>
        <th width="15%">DUE DATE</th>
        <th width="15%">COUNT DOWN</th>
      @endif
      
      @if($service_id == 7)
        <th width="8%">CLIENT TYPE</th>
        <th>BUSINESS NAME</th>
        <th width="7%">NI NUMBER</th>
        <th width="9%">TAX REFERENCE</th>
        <th width="7%">RETURN</th>       
        <th width="11%">JOB START DATE </th>
        <th>VIEW DATA</th>       
      @endif

      @if($service_id == 8)
        <th width="30%">BUSINESS NAME</th>
        <th width="15%">JOB DUE DATE</th>
        <th width="15%">JOB START DATE</th>
      @endif

      @if($service_id == 9)
        <th width="8%">DOI</th>
        <th>BUSINESS NAME</th>
        <th>AUTHEN CODE</th>
        <th>NEXT RETURN DUE ON</th>
        <th>COUNT DOWN</th>
      @endif
        
      @if($service_id == 4 || $service_id == 8)
        <th width="10%">EMAIL CLIENT</th>
      @endif
       
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
            @if(isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $step_id)
            <tr class="data_tr_{{ $details['client_id'] }}_2{{ $page_open }}">
              
          @if($service_id == 1)
            <td>{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
            <td>{{ isset($details['vat_number'])?$details['vat_number']:"" }}</td>
            <td>{{ isset($details['ret_frequency'])?ucwords($details['ret_frequency']):"" }}</td>
            <td>&nbsp;</td>
          @endif

          @if($service_id == 2)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
            <td align="left">{{ $details['vat_number'] or "" }}</td>
            <td align="left">{{ isset($details['vat_stagger'])?ucwords($details['vat_stagger']):"" }}</td>
            <td align="left"></td>
          @endif

          @if($service_id == 3)
              <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
              <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
              <td align="left">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
              <td align="left">{{ isset($details['next_acc_due'])?date("d-m-Y", strtotime($details['next_acc_due'])):"" }}</td>
              <td align="left">
                @if( isset($details['deadacc_count']) && $details['deadacc_count'] < 0 )
                  <span style="color:red">{{ $details['deadacc_count'] or "" }}</span>
                @else
                   {{ $details['deadacc_count'] or "" }}
                @endif
              </td>
          @endif

          @if($service_id == 4)
          <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
          <td>{{ $details['job_due_date'] or "" }}</td>
          <td align="center">
            {{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}
          </td> 
        @endif

        @if($service_id == 5)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left">{{ $details['business_name'] or "" }}</td>
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

        @if($service_id == 8)
        <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
        <td>&nbsp;</td>
        <td align="center">
          <div id="edit_calender_{{ $details['client_id'] }}_21" class="edit_cal">
            <a href="javascript:void(0)" id="date_view_{{ $details['client_id'] }}_21" />{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</a>
            <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"></span>
            <div class="cont_add_to_date open_dropdown_{{ $details['client_id'] }}_21" style="display:none;">
            <ul> 

              <li><a href="javascript:void(0)" class="open_calender_pop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21">Add/Edit Start Date</a></li>
              <li>
              <span id="view_calender_{{ $details['client_id'] }}_21" class="addtocalendar atc-style-blue">
                <var class="atc_event">
                  <var class="atc_date_start">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</var>
                  <var class="atc_date_end">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("Y-m-d H:i:s", strtotime('+1 hour', strtotime($details['jobs_notes']['job_start_date'])) ):"" }}</var>
                  <var class="atc_timezone">Europe/London</var>
                  <var class="atc_title">{{$title}} - {{$details['business_name'] or ""}}</var>
                  <var class="atc_description">{{$title}} - {{$details['business_name'] or ""}}</var>
                  <var class="atc_location">Office</var>
                  <var class="atc_organizer">{{ $admin_name }}</var>
                  <var class="atc_organizer_email">{{ $logged_email }}</var>
                </var>
              </span>
              </li>
            </ul>
          </div>
        </div>
        </td> 
      @endif

      @if($service_id == 7)
        @if(isset($details['type']) && $details['type'] == 'ind')
          <td>Individual</td>
          <td>{{ $details['client_name'] or "" }}</td>
          <td>{{ $details['ni_number'] or "" }}</td>
          <td>{{ $details['tax_reference'] or "" }}</td>
        @else
          <td>Organisation</td>
          <td>{{ $details['business_name'] or "" }}</td>
          <td>N/A</td>
          <td>
            @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
              {{ $details['tax_reference'] or "" }}
            @endif
          </td>
        @endif
        <td></td>
        <td align="center">
          <div id="edit_calender_{{ $details['client_id'] }}_21" class="edit_cal">
            <a href="javascript:void(0)" id="date_view_{{ $details['client_id'] }}_21" />{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</a>
            <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"></span>
            <div class="cont_add_to_date open_dropdown_{{ $details['client_id'] }}_21" style="display:none;">
            <ul> 
              <li><a href="javascript:void(0)" class="open_calender_pop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21">Add/Edit Start Date</a></li>
              <li>
              <span id="view_calender_{{ $details['client_id'] }}_21" class="addtocalendar atc-style-blue">
                <var class="atc_event">
                  <var class="atc_date_start">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</var>
                  <var class="atc_date_end">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("Y-m-d H:i:s", strtotime('+1 hour', strtotime($details['jobs_notes']['job_start_date'])) ):"" }}</var>
                  <var class="atc_timezone">Europe/London</var>
                  <var class="atc_title">{{$title}} - {{$details['business_name'] or ""}}</var>
                  <var class="atc_description">{{$title}} - {{$details['business_name'] or ""}}</var>
                  <var class="atc_location">Office</var>
                  <var class="atc_organizer">{{ $admin_name }}</var>
                  <var class="atc_organizer_email">{{ $logged_email }}</var>
                </var>
              </span>
              </li>
            </ul>
          </div>
        </div>
        </td>
        <td></td>
      @endif

       
      

      @if($service_id == 4 || $service_id == 8)
        <td>
          <div class="email_client_selectbox" style="height:24px;">
            <span>SEND</span>
            <div class="small_icon" data-id="{{ $details['client_id'] }}"></div><div class="clr"></div>
            <div class="select_toggle" id="status{{ $details['client_id'] }}" style="display: none;">
              <ul>
                @if(isset($email_templates) && count($email_templates) >0)
                  @foreach($email_templates as $key=>$temp_row)
                    <li><a href="javascript:void(0)" data-client_id="{{ $details['client_id'] }}" data-template_id="{{ $temp_row['email_template_id'] or "" }}" class="send_template-modal">{{ $temp_row['name'] or "" }}</a></li>
                  @endforeach
                @endif
              </ul>
            </div>
          </div>
        </td>
      @endif  
              
              
            </tr>
            @endif
          @endif
      @endforeach
    @endif
      
    </tbody>

  </div>
  @endif
  @endfor   
    @if($page_open == '210')
  <div>
    @if($service_id == 1)
    <div class="table_property_inner">
      <strong>Current Return :</strong> October 2015 &nbsp;&nbsp;
      <strong>Due Date :</strong> 21st of November 2015 &nbsp;&nbsp;
      <strong>Count Down :</strong> 6 Days
    </div>
    @endif
    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
    <thead>
      <tr role="row">
        
      @if($service_id == 1)
        <th width="8%">D0I</th>
        <th>BUSINESS NAME</th>
        <th>VAT NUMBER</th>
        <th>FREQUENCY</th>
        <th>RETURN</th>
        <th width="5%">NOTES</th>
      @endif

      @if($service_id == 2)
        <th width="8%">D0I</th>
        <th>BUSINESS NAME</th>
        <th>VAT NUMBER</th>
        <th width="10%">STAGGER</th>
        <th>RETURN</th>
        <th width="5%">NOTES</th>
      @endif

      @if($service_id == 3)
        <th width="8%">DOI</th>
        <th>BUSINESS NAME</th>
        <th>YEAR END</th>
        <th>NEXT ACCTS DUE ON</th>
        <th>DAYS</th>
        <th width="5%">NOTES</th>
        <th>SYNC DATA</th>
      @endif

      @if($service_id == 5)
        <th width="8%">DOI</th>
        <th>BUSINESS NAME</th>
        <th>CT. REFERENCE</th>
        <th>TAX RETURN PERIOD</th>
        <th>DUE DATE</th>
        <th>COUNT DOWN</th>
        <th width="5%">NOTES</th>
        <th>ROLL FWD</th>
      @endif
      
      @if($service_id == 7)
        <th width="8%">CLIENT TYPE</th>
        <th>BUSINESS NAME</th>
        <th width="7%">NI NUMBER</th>
        <th width="9%">TAX REFERENCE</th>
        <th width="7%">RETURN</th>       
        <th width="11%">JOB START DATE <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
        <th>VIEW DATA</th>       
      @endif

      @if($service_id == 9)
        <th width="8%">DOI</th>
        <th>BUSINESS NAME</th>
        <th>AUTHEN CODE</th>
        <th>NEXT RETURN DUE ON</th>
        <th>COUNT DOWN</th>
        <th width="5%">NOTES</th>
        <th>SYNC DATA</th>
      @endif
        
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
          @if(isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $step_id)
          <tr class="data_tr_{{ $details['client_id'] }}_2{{ $page_open }}">
           
          
          @if($service_id == 1)
            <td>{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
            <td>{{ isset($details['vat_number'])?$details['vat_number']:"" }}</td>
            <td>{{ isset($details['ret_frequency'])?ucwords($details['ret_frequency']):"" }}</td>
            <td>&nbsp;</td>
            <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="210"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
            </td>
          @endif

          @if($service_id == 2)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
            <td align="left">{{ $details['vat_number'] or "" }}</td>
            <td align="left">{{ isset($details['vat_stagger'])?ucwords($details['vat_stagger']):"" }}</td>
            <td align="left"></td>
            <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
            </td>
          @endif

          @if($service_id == 3)        
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>

            <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>

            <td align="left">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>

            <td align="left">{{ isset($details['next_acc_due'])?date("d-m-Y", strtotime($details['next_acc_due'])):"" }}</td>

            <td align="left">
              @if( isset($details['deadacc_count']) && $details['deadacc_count'] < 0 )
                <span style="color:red">{{ $details['deadacc_count'] or "" }}</span>
              @else
                 {{ $details['deadacc_count'] or "" }}
              @endif
            </td>

            <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>Notes</span></a>
            </td>

            <td align="center"><a href="javascript:void(0)" class="notes_btn sync_chreturn_data" data-client_id="{{ $details['client_id'] or "" }}" data-action="single">Sync</a>
            </td>
        @endif

        @if($service_id == 5)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td> 
            <td>
              @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'C')
                {{ $details['tax_reference'] or "" }}
              @endif
            </td>
            <td align="center">
              <a href="javascript:void(0)" class="tax_return_modal tax_return_{{ $details['client_id'] or '0' }}" data-client_id="{{ $details['client_id'] or '0' }}" data-action="TRP">{{ (isset($details['jobs_acc_details']['roll_fwd_start']) && $details['jobs_acc_details']['roll_fwd_start'] != "")?$details['jobs_acc_details']['roll_fwd_start'].' - '.$details['jobs_acc_details']['roll_fwd_end']:"Add.." }}</a>
            </td>
            <td><span class="tax_return_end_{{ $details['client_id'] or '0' }}">{{ (isset($details['jobs_acc_details']['roll_fwd_date']) && $details['jobs_acc_details']['roll_fwd_date'] != "")?$details['jobs_acc_details']['roll_fwd_date']:"" }}</span></td>
            <td align="center" class="count_tax_{{ $details['client_id'] or '0' }}">
              @if( isset($details['jobs_acc_details']['roll_count']) && $details['jobs_acc_details']['roll_count'] < 0 )
                <span style="color:red">{{ $details['jobs_acc_details']['roll_count'] or "" }}</span>
              @else
                 {{ $details['jobs_acc_details']['roll_count'] or "" }}
              @endif
            </td>
            <td align="center">
              <a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>Notes</span></a>
            </td>
            <td>
              <a href="javascript:void(0)" class="notes_btn tax_return_modal" data-client_id="{{ $details['client_id'] or "" }}" data-action="RF">Roll fwd</a><!-- jobs_roll_fwd sync_chreturn_data -->
            </td>
        @endif

        @if($service_id == 7)
          @if(isset($details['type']) && $details['type'] == 'ind')
          <td>Individual</td>
          <td><a href="/client/edit-ind-client/{{ $details['client_id'] }}/{{ base64_encode('ind_client') }}" target="_blank">{{ $details['client_name'] or "" }}</a></td>
          <td>{{ $details['ni_number'] or "" }}</td>
          <td>{{ $details['tax_reference'] or "" }}</td>
          @else
          <td>Organisation</td>
          <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
          <td>N/A</td>
          <td>
            @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
              {{ $details['tax_reference'] or "" }}
            @endif
          </td>
          @endif
          <td></td>
          <td align="center">
            <div id="edit_calender_{{ $details['client_id'] }}_21" class="edit_cal">
              <a href="javascript:void(0)" id="date_view_{{ $details['client_id'] }}_21" />{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</a>
              <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"></span>
              <div class="cont_add_to_date open_dropdown_{{ $details['client_id'] }}_21" style="display:none;">
              <ul> 
                <li><a href="javascript:void(0)" class="open_calender_pop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21">Add/Edit Start Date</a></li>
                <li>
                <span id="view_calender_{{ $details['client_id'] }}_21" class="addtocalendar atc-style-blue">
                  <var class="atc_event">
                    <var class="atc_date_start">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</var>
                    <var class="atc_date_end">{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("Y-m-d H:i:s", strtotime('+1 hour', strtotime($details['jobs_notes']['job_start_date'])) ):"" }}</var>
                    <var class="atc_timezone">Europe/London</var>
                    <var class="atc_title">{{$title}} - {{$details['business_name'] or ""}}</var>
                    <var class="atc_description">{{$title}} - {{$details['business_name'] or ""}}</var>
                    <var class="atc_location">Office</var>
                    <var class="atc_organizer">{{ $admin_name }}</var>
                    <var class="atc_organizer_email">{{ $logged_email }}</var>
                  </var>
                </span>
                </li>
              </ul>
            </div>
          </div>
          </td>
          <td></td>
        @endif
            
           
          </tr>
          @endif
        @endif
      @endforeach
    @endif
      

  </div>
 @endif

</div>