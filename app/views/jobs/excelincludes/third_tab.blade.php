
  <thead>
    <tr role="row">
     
      
    @if($service_id == 1)
      <th>CRN</th>
      <th>BUSINESS NAME</th>
      <th>VAT NUMBER</th>
      <th>FREQUENCY</th>
      <th>RETURN</th>
      <th width="5%">NOTES</th>
      <th>FILING DATE</th>
    @endif

    @if($service_id == 2)
      <th>CRN</th>
      <th>BUSINESS NAME</th>
      <th>VAT NUMBER</th>
      <th>FREQUENCY</th>
      <th>QUARTER</th>
      <th width="5%">NOTES</th>
      <th>FILING DATE</th>
    @endif

    @if($service_id == 3)
      <th width="10%">CRN</th>
      <th width="25%">BUSINESS NAME</th>
      <th width="22%">LAST ACCOUNTS DATE</th>
      
      <th width="10%">FILING DATE</th>
    @endif

    @if($service_id == 4)
      <th width="20%">BUSINESS NAME</th>
      <th width="10%">JOB DUE DATE</th>
      <th width="10%">COMPLETION DATE</th>
    @endif

    @if($service_id == 5)
      <th width="10%">CRN</th>
      <th width="20%">BUSINESS NAME</th>
      <th width="10%">CT. REFERENCE</th>
      <th width="10%">TAX RETURN PERIOD</th>
      <th width="10%">FILING DATE</th>
    @endif

    @if($service_id == 7)
      <th width="15%">CRN</th>
      <th width="20%">BUSINESS NAME</th>
      <th width="15%">NI NUMBER</th>
      <th width="15%">TAX REFERENCE</th>
      <th width="15%">RETURN</th> 
      <th width="15%">FILING DATE</th>
    @endif

    @if($service_id == 8)
      <th>BUSINESS NAME</th>
      <th>JOB DUE DATE</th>
      <th>COMPLETION DATE</th>
    @endif

    @if($service_id == 9)
      <th>CRN</th>
      <th>BUSINESS NAME</th>
      <th width="22%">LAST RETURN DATE</th>
      <th width="5%">NOTES</th>
      <th>FILING DATE</th>
    @endif
      
    </tr>
  </thead>

  
    
    <?php $i = 1;?>
    @if(isset($completed_task) && count($completed_task) >0)
      @foreach($completed_task as $key=>$details)
        <tr id="data_tr_{{ $details['completed_tasks']['task_id'] }}">
         
        @if($service_id == 1)
          <td>{{ $details['registration_number'] or "" }}</td>
          <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
          <td>{{ $details['vat_number'] or "" }}</td>
          <td>{{ $details['ret_frequency'] or "" }}</td>
          <td></td>
          <td align="center"><a href="javascript:void(0)" class="search_t open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
          </td>
          <td>{{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}</td>
        @endif

        @if($service_id == 2)
          <td>{{ $details['registration_number'] or "" }}</td>
          <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
          <td>{{ $details['vat_number'] or "" }}</td>
          <td>{{ $details['ret_frequency'] or "" }}</td>
          <td></td>
          <td align="center"><a href="javascript:void(0)" class="search_t open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
          </td>
          <td>{{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}</td>
        @endif

        @if($service_id == 3)  
          <td align="left">{{ $details['registration_number'] or "" }}</td>
          <td align="left">{{ $details['business_name'] or "" }}</td>
          <td align="center">
         {{ isset($details['completed_tasks']['last_acc_madeup_date'])?$details['completed_tasks']['last_acc_madeup_date']:"" }}
           
          </td>
         <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif

        @if($service_id == 4)
          <td><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
          <td>{{ $details['job_due_date'] or "" }}</td>
          <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif

        @if($service_id == 5)
          <td align="left">{{ $details['registration_number'] or "" }}</td>
          <td align="left">{{ $details['business_name'] or "" }}</td>
          <td>
            @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'C')
              {{ $details['tax_reference'] or "" }}
            @endif
          </td>
          <td align="center">
            {{ (isset($details['jobs_acc_details']['tax_return_start']) && $details['jobs_acc_details']['tax_return_start'] != "")?$details['jobs_acc_details']['tax_return_start'].' - '.$details['jobs_acc_details']['tax_return_end']:" " }}
          </td>
          <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif

        @if($service_id == 7)
          @if(isset($details['type']) && $details['type'] == 'ind')
            <td></td>
            <td>{{ $details['client_name'] or "" }}</td>
            <td>{{ $details['ni_number'] or "" }}</td>
            <td>{{ $details['tax_reference'] or "" }}</td>
          @else
            <td>{{ $details['registration_number'] or "" }}</td>
            <td>{{ $details['business_name'] or "" }}</td>
            <td>N/A</td>
            <td>
              @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
                {{ $details['tax_reference'] or "" }}
              @endif
            </td>
          @endif
          <td></td>
         

          <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif
        
        @if($service_id == 8)
          <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a></td>
          <td align="center" width="12%"></td>
          <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif

        </tr>
        <?php $i++;?>
      @endforeach
    @endif
