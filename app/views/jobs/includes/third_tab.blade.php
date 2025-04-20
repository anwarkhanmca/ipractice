<table class="table table-bordered table-hover dataTable ch_returns" id="example3">
  <thead>
    <tr role="row">
      <th width="6%">Action</th>
      
    @if($service_id == 1)
      <th>CRN</th>
      <th>Business Name</th>
      <th>VAT Number</th>
      <th>Frequency</th>
      <th>Return</th>
      <th width="5%">Notes</th>
      <th>Filing Date</th>
    @endif

    @if($service_id == 2)
      <th>CRN</th>
      <th>Business Name</th>
      <th>VAT Number</th>
      <th>Frequency</th>
      <th>Quarter</th>
      <th width="5%">Notes</th>
      <th>Filing Date</th>
    @endif

    @if($service_id == 3)
      <th>CRN</th>
      <th>Business Name</th>
      <th width="22%">Last Accounts Date</th>
      <th width="5%">Notes</th>
      <th>Filing Date</th>
    @endif

    @if($service_id == 4)
      <th>Business Name</th>
      <th>Job Due Date</th>
      <th>Completion Date</th>
    @endif

    @if($service_id == 5)
      <th>CRN</th>
      <th>Business Name</th>
      <th>CT. Reference</th>
      <th>Tax Return Period</th>
      <th width="5%">Notes</th>
      <th>Filing Date</th>
    @endif

    @if($service_id == 6)
      <th>CRN</th>
      <th>Business Name</th>
      <th width="22%">Period End</th>
      <th width="5%">Notes</th>
      <th>Completion Date</th>
    @endif

    @if($service_id == 7)
      <th>CRN</th>
      <th>Business Name</th>
      <th>NI Number</th>
      <th>Tax Reference</th>
      <th>Tax Year</th> 
      <th width="5%">Notes</th>
      <th>Filing Date</th>
    @endif

    @if($service_id == 8)
      <th>Business Name</th>
      <th>Job</th>
      <th>Completion Date</th>
    @endif

    @if($service_id == 9)
      <th>CRN</th>
      <th>Business Name</th>
      <th width="20%">Last Return Date</th>
      <th width="7%">Notes</th>
      <th>Filing Date</th>
    @endif
      <th>Time Sheet</th>
    </tr>
  </thead>

  
    <tbody role="alert" aria-live="polite" aria-relevant="all">
    <?php $i = 1;?>
    @if(isset($completed_task) && count($completed_task) >0)
      @foreach($completed_task as $key=>$details)
        <tr id="data_tr_{{ $details['completed_tasks']['task_id'] }}">
          <td align="center"><a href="javascript:void(0)" class="delete_completed_task" data-client_id="{{ $details['client_id'] or "" }}" data-tab="3" data-task_id="{{ $details['completed_tasks']['task_id'] }}" data-manage_id="{{ $details['completed_tasks']['job_manage_id'] }}"><img src="/img/cross.png"></a></td>
        @if($service_id == 1)
          <td>{{ $details['registration_number'] or "" }}</td>
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or ""}}</a></td>
          <td>{{ $details['vat_number'] or "" }}</td>
          <td>{{ $details['ret_frequency'] or "" }}</td>
          <td>{{ $details['return_date'] or "" }}</td>
          <td align="center"><a href="javascript:void(0)" class="search_t open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
          </td>
          <td>{{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}</td>
        @endif

        @if($service_id == 2)
          <td>{{ $details['registration_number'] or "" }}</td>
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or ""}}</a></td>
          <td>{{ $details['vat_number'] or "" }}</td>
          <td>{{ $details['ret_frequency'] or "" }}</td>
          <td></td>
          <td align="center"><a href="javascript:void(0)" class="search_t open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
          </td>
          <td>{{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}</td>
        @endif

        @if($service_id == 3)  
          <td align="left">{{ $details['registration_number'] or "" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or ""}}</a></td>
          <td align="center">
            <a href="javascript:void(0)" class="change_last_date" data-client_id="{{ $details['client_id'] or "" }}" data-tab="3" data-key="{{ $key }}" id="3_dateanchore_{{ $key }}" data-prev_date="{{ isset($details['completed_tasks']['last_acc_madeup_date'])?$details['completed_tasks']['last_acc_madeup_date']:"" }}">{{ isset($details['completed_tasks']['last_acc_madeup_date'])?$details['completed_tasks']['last_acc_madeup_date']:"" }}</a>
            <span class="3_save_made_span_{{ $key }}"  style="display:none;">
              <input type="text" class="made_up_date" id="3_made_up_date_{{ $key }}" />
              <a href="javascript:void(0)" class="search_t save_made_date" data-client_id="{{ $details['client_id'] or "" }}" data-tab="3" data-key="{{ $key }}" data-field_name="last_acc_madeup_date" data-step_id="1">Save</a>
              <a href="javascript:void(0)" class="search_t cancel_made_date" data-client_id="{{ $details['client_id'] or "" }}" data-tab="3" data-key="{{ $key }}">Cancel</a>
            </span>
          </td>

          <td align="center"><a href="javascript:void(0)" class="search_t open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
          </td>

          <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif

        @if($service_id == 4)
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
          <td>{{ $details['job_due_date'] or "" }}</td>
          <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif

        @if($service_id == 5)
          <td align="left">{{ $details['registration_number'] or "" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
          <td>
            @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'C')
              {{ $details['tax_reference'] or "" }}
            @endif
          </td>
          <td align="center">
            <a href="javascript:void(0)" class="tax_return_modal tax_return_{{ $details['client_id'] or '0' }}" data-client_id="{{ $details['client_id'] or '0' }}" data-tax_return_start="{{ (isset($details['jobs_acc_details']['tax_return_start']) && $details['jobs_acc_details']['tax_return_start'] != "")?$details['jobs_acc_details']['tax_return_start']:"" }}">{{ (isset($details['jobs_acc_details']['tax_return_start']) && $details['jobs_acc_details']['tax_return_start'] != "")?$details['jobs_acc_details']['tax_return_start'].' - '.$details['jobs_acc_details']['tax_return_end']:"Add.." }}</a>
          </td>
          <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
          </td>

          <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif

        @if($service_id == 6)  
          <td align="left">{{ $details['registration_number'] or "" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
          <td align="left">{{ isset($details['period_end'])?date("d-m-Y", strtotime($details['period_end'])):"" }}</td>

          <td align="center"><a href="javascript:void(0)" class="search_t open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
          </td>

          <td align="center" width="12%">
            {{ isset($details['jobs_acc_details']['completion_date'])?$details['jobs_acc_details']['completion_date']:"" }}
          </td>
        @endif

        @if($service_id == 7)
          @if(isset($details['type']) && $details['type'] == 'ind')
            <td></td>
            <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['client_name'] or "" }}</a></td>
            <td>{{ $details['ni_number'] or "" }}</td>
            <td>{{ $details['tax_reference'] or "" }}</td>
          @else
            <td>{{ $details['registration_number'] or "" }}</td>
            <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
            <td>N/A</td>
            <td>
              @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
                {{ $details['tax_reference'] or "" }}
              @endif
            </td>
          @endif
          <td>{{ $details['return_date'] or "" }}</td>
          <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
          </td>

          <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif
        
        @if($service_id == 8)
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
          <td align="center" width="12%">{{ $details['return_date'] or "" }}</td>
          <td align="center" width="12%">
            {{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}
          </td>
        @endif

        @if($service_id == 9)
          <td>{{ $details['registration_number'] or "" }}</td>
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or ""}}</a></td>
          <td align="center">{{ isset($details['made_up_date'])?date("d-m-Y", strtotime($details['made_up_date'])):"" }}</td>
          <td align="center"><a href="javascript:void(0)" class="search_t open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-is_completed="{{ (isset($details['jobs_notes']['is_completed']))?$details['jobs_notes']['is_completed']:'N' }}" data-job_status_id="{{ (isset($details['jobs_notes']['job_status_id']))?$details['jobs_notes']['job_status_id']:'0' }}" data-tab="3"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
          </td>
          <td>{{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}</td>
        @endif


          <td id="addTimeSheet{{$details['completed_tasks']['task_id']}}">
        @if(isset($details['timesheet_check']) && $details['timesheet_check'] != 'Y')  
            <a href="javascript:void(0)" class="addTimeSheet" data-client_id="{{ $details['client_id'] or '' }}" data-completed_id="{{ $details['completed_tasks']['task_id'] }}" data-filling_date="{{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}">Add..</a>
        @else
            <a href="javascript:void(0)" data-client_id="{{ $details['client_id'] or '' }}" data-completed_id="{{ $details['completed_tasks']['task_id'] }}" class="viewTimeSheet">Completed</a>
        @endif
          </td>

        </tr>
        <?php $i++;?>
      @endforeach
    @endif
    
  </tbody>
    
  
</table>