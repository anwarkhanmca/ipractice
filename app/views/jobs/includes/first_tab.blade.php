<?php
$dor            = 'DOR';
$business_name  = 'Business Name';
$vat_scheme     = 'VAT Scheme';
$type           = 'Type';
$vat_number     = 'VAT Number';
$stagger        = 'Stagger';
$frequency      = 'Frequency';
$send_to_task   = 'Send To Tasks';
$count_down     = 'Count Down';
$due_date       = 'Due Date';
$year_end       = 'Year End';
$last_accts_filed = 'Last Accts Filed';
$reference      = 'Reference';
$next_acc_due   = 'Next Accounts Due';
$tax_return_period = 'Tax Return Period';
?>
<table class="table table-bordered table-hover dataTable ch_returns" id="example1" aria-describedby="example1_info">
  <thead>
    <tr role="row">
      <th width="2%"><span class="custom_chk"><input type='checkbox' id="CheckallCheckbox" /></span></th>
    @if($service_id == 1)
      <th width="8%">D0R</th>
      <th width="15%"><?=$business_name;?></th>
      <th><?=$vat_scheme;?></th>
      <th><?=$type;?></th>
      <th><?=$vat_number;?></th>
      <th><?=$stagger;?></th>
      <th><?=$frequency;?></th>
      <th width="11%"><?=$send_to_task;?> <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
    @endif

    @if($service_id == 2)
      <th width="8%">DOR</th>
      <th width="15%"><?=$business_name;?></th>
      <th><?=$vat_scheme;?></th>
      <th><?=$type;?></th>
      <th><?=$vat_number;?></th>
      <th>VAT <?=$stagger;?></th>
      <th>ECSL <?=$frequency;?></th>
      <th width="11%"><?=$send_to_task;?> <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
    @endif

    @if($service_id == 3)
      <th width="8%">D0I</th>
      <th>CRN</th>
      <th width="15%"><?=$business_name;?></th>
      <th>Year End</th>
      <th>Authen code</th>
      <th><?=$last_accts_filed;?></th>
      <th><?= $next_acc_due;?></th>
      <th>S/Off Date</th>
      <th width="3%">Days</th>
      <th width="11%"><?=$send_to_task;?> <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
    @endif

    @if($service_id == 4)
      <th><?=$business_name;?></th>
      <th><?=$vat_scheme;?></th>
      <th width="6%"><?=$type;?></th>
      <th width="10%"><?=$stagger;?></th>
      <th width="11%">Job Freq</th>
      <th width="5%">Hrs/Wk</th>
      <th width="5%">Notes</th>
    @endif

    @if($service_id == 5)
      <th width="8%">D0I</th>
      <th width="15%"><?=$business_name;?></th>
      <th><?=$year_end;?></th>
      <th><?=$last_accts_filed;?></th>
      <th>CT. <?=$reference;?></th>
      <th><?= $tax_return_period;?></th>
      <th><?=$due_date;?></th>
      <th><?=$count_down;?></th>
      <th width="11%"><?=$send_to_task;?> <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
    @endif

    @if($service_id == 6)
      <th width="8%">D0I</th>
      <th>CRN</th>
      <th width="15%"><?=$business_name;?></th>
      <th><?=$year_end;?></th>
      <th><?=$last_accts_filed;?></th>
      <th>Next Accounts Due</th>
      <th>Completion Date</th>
      <th width="3%">Days</th>
      <th width="11%"><?=$send_to_task;?></th>
    @endif

    @if($service_id == 7)
      <!-- <th width="7%">DOB/DOI</th> -->
      <th width="8%">Client Type</th>
      <th width="18%">Name</th>
      <th width="8%">NI Number</th>
      <th width="10%">Tax Reference</th>
      <th>Address</th>
      <th width="13%">View Tax Return Data</th>
      <th width="10%"><?=$send_to_task;?> <a href="javascript:void(0)" class="open_send_popup" data-send_type="multiple"><i class="fa fa-cog fa-fw settings_icon"></i></a>
      <!-- <div style="text-align: center;"><button type="button" class="bulk_send_btn open_send_popup" data-send_type="multiple">BULK SEND</button></div> -->
      </th>
    @endif

    @if($service_id == 8)
      <th><?=$business_name;?></th>
      <th width="7%"><?=$year_end;?></th>
      <th width="11%">VAT <?=$stagger;?></th>
      <th width="13%">Bookkeeping Status</th>
      <th width="10%"><?=$frequency;?></th>
      <th width="8%"><?=$due_date;?></th>
      <th width="11%"><?=$send_to_task;?> <!-- <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i> --></th>
    @endif
   
    @if($service_id == 9)
      <th width="8%">D0I</th>
      <th>CRN</th>
      <th width="15%"><?=$business_name;?></th>
      <th><?=$year_end;?></th>
      <th>Authen Code</th>
      <th>Last Return Date</th>
      <th>Next Return Due On</th>
      <th>Count Down</th>
      <th width="11%"><?=$send_to_task;?> <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
    @endif

      <th width="10%">Staff
      @if($service_id == 1)
        <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
      @endif
      </th>
    </tr>
  </thead>
<tbody role="alert" aria-live="polite" aria-relevant="all">
  @if(isset($company_details) && count($company_details) >0)
    @foreach($company_details as $key=>$details)
      <tr id="hide_client_tr_{{ $details['client_id'] }}">
        <td><span class="custom_chk">
        <input type='checkbox' class="checkbox ads_Checkbox" name="checkbox[]" value="{{ $details['client_id'] or '' }}"/></span>

        <input type="hidden" id="clnt_no_{{ $details['client_id'] or '' }}" value="{{ $details['registration_number'] or "" }}">
        </td>
    @if($service_id == 1)
      <td>{{ isset($details['effective_date'])?date("d-m-Y", strtotime($details['effective_date'])):"" }}</td>
      <td align="left">
    <!--<a href="/client/edit-org-client/{{$details['client_id']}}/{{base64_encode('org_client')}}" target="_blank">{{$details['business_name'] or ""}}</a>-->
    <a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" style="float: left; margin-right: 5px;" data-service_id="{{ $service_id }}">{{ $details['business_name'] or "" }}</a>
    <div style="float: right;">
     <div class="red_box" id="red_box_{{ $details['client_id'] or '' }}" style="{{ (isset($details['reminders']['is_enable']) && $details['reminders']['is_enable'] == 1)?'display: block':'display: none' }}"></div>
 
     <div class="blue_box" id="blue_box_{{ $details['client_id'] or '' }}" style="{{ (isset($details['taskstatus']['is_enable']) && $details['taskstatus']['is_enable'] == '2')?'display: block':'display: none' }}"></div> 
    </div>     
      </td>
      <td>{{ $details['vat_scheme_type'] or "" }}</td>
      <td>{{ isset($details['vat_scheme'])?ucfirst($details['vat_scheme']):'' }}</td>
      <td>{{ $details['vat_number'] or "" }}</td>
      <td>{{ $details['vat_stagger'] or "" }}</td>
      <td>{{ isset($details['ret_frequency'])?ucfirst($details['ret_frequency']):'' }}</td>
      <td align="center" id="after_send_{{ $details['client_id'] }}">
        <button type="button" class="job_send_btn job_send_pop" data-client_id="{{ $details['client_id'] }}" data-field_name="manage_task">
        @if(isset($details['manage_task']) && $details['manage_task'] == "N")
          SEND
        @else
          SEND MORE
        @endif
        </button>
      </td><!-- send_manage_task -->
    @endif

    @if($service_id == 2)
      <td>{{ isset($details['effective_date'])?date("d-m-Y", strtotime($details['effective_date'])):"" }}</td>
      <td align="left">
      <!--<a href="/client/edit-org-client/{{$details['client_id']}}/{{base64_encode('org_client')}}" target="_blank">{{$details['business_name'] or ""}}</a>-->
      <a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or "" }}</a>
      </td>
      <td>{{ $details['vat_scheme_type'] or "" }}</td>
      <td>{{ isset($details['vat_scheme'])?ucfirst($details['vat_scheme']):'' }}</td>
      <td>{{ $details['vat_number'] or "" }}</td>
      <td>{{ $details['vat_stagger'] or "" }}</td>
      <td>{{ isset($details['ecsl_freq'])?ucfirst($details['ecsl_freq']):'' }}</td>
      <td align="center" id="after_send_{{ $details['client_id'] }}">
        <button type="button" class="job_send_btn job_send_pop" data-client_id="{{ $details['client_id'] }}" data-field_name="manage_task">
        @if(isset($details['manage_task']) && $details['manage_task'] == "N")
          SEND
        @else
          SEND MORE
        @endif
        </button>
      </td>
    @endif

    @if($service_id == 3)
        <td class="sorting_1" align="center">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
        <td align="center">{{ $details['registration_number'] or "" }}</td>
        <td align="left">
        <!--<a href="/client/edit-org-client/{{ $details['client_id'] }}/{{base64_encode('org_client')}}" target="_blank">{{$details['business_name'] or ""}}</a>-->
            <a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a>
        </td>
        <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
        <td align="center">{{ $details['ch_auth_code'] or "" }}</td>
        <td align="center">{{ isset($details['last_acc_madeup_date'])?date("d-m-Y", strtotime($details['last_acc_madeup_date'])):"" }}</td>
        <td align="center">{{ isset($details['next_acc_due'])?date("d-m-Y", strtotime($details['next_acc_due'])):"" }}</td>
        <td>
          
          <span class="sign_off_span_{{ $details['client_id'] }}">
          @if(isset($details['sign_off_date']) && $details['sign_off_date'] != "")
            <a href="javascript:void(0)" class="sign_off_date sign_off_a_{{ $details['client_id'] }}" data-client_id="{{ $details['client_id'] }}" data-action="old">{{ $details['sign_off_date'] }}</a>
          @else
            <a href="javascript:void(0)" class="sign_off_date sign_off_a_{{ $details['client_id'] }}" data-client_id="{{ $details['client_id'] }}" data-action="new">Add..</a>
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
        <td align="center" id="after_send_{{ $details['client_id'] }}">
          @if(isset($details['manage_task']) && $details['manage_task'] == "N")
            <button type="button" class="job_send_btn send_manage_task" data-client_id="{{ $details['client_id'] }}" data-field_name="manage_task">SEND</button>
          @else
            <button type="button" class="job_sent_btn">SENT</button>
          @endif
        </td>
    @endif

    @if($service_id == 4)
      <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
      <td>{{ $details['vat_scheme_type'] or "" }}</td>
      <td>{{ isset($details['vat_scheme'])?ucfirst($details['vat_scheme']):'' }}</td>
      <td>{{ $details['vat_stagger'] or "" }}</td>
      <td>
        <div class="freq_div_{{ $details['client_id'] or '' }}">
        @if(isset($details['jobs_acc_details']['repeat_day']) && $details['jobs_acc_details']['repeat_day'] !='')
          <a href="javascript:void(0)" class="job_freq_pop" id="job_freq_{{ $details['client_id'] or '' }}" data-client_id="{{ $details['client_id'] or '' }}">
            Every {{ $details['jobs_acc_details']['repeat_day'] }} Day(s)
          </a>
          <a href="javascript:void(0)" class="delete_job_freq" data-client_id="{{ $details['client_id'] or "" }}"><img src="/img/cross.png" width="10"></a>
        @else
          <a href="javascript:void(0)" class="job_freq_pop" id="job_freq_{{ $details['client_id'] or '' }}" data-client_id="{{ $details['client_id'] or '' }}">
            Add..
          </a>
        @endif
        <div>
        </td>
      <td><span class="hrs_{{ $details['client_id'] or "" }}">{{ $details['jobs_acc_details']['hrs_wk'] or "" }}</span></td>
      <td><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or '0' }}" data-tab="1">notes</a></td>
    @endif

    @if($service_id == 5)
      <td class="sorting_1" align="center">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
      <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
      <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
      <td align="center">{{ isset($details['last_acc_madeup_date'])?date("d-m-Y", strtotime($details['last_acc_madeup_date'])):"" }}</td>
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
      <td align="center" id="after_send_{{ $details['client_id'] }}">
        @if(isset($details['manage_task']) && $details['manage_task'] == "N")
          <button type="button" class="job_send_btn send_manage_task" data-client_id="{{ $details['client_id'] }}" data-field_name="manage_task">SEND</button>
        @else
          <button type="button" class="job_sent_btn">SENT</button>
        @endif
      </td>
    @endif

    @if($service_id == 6)
        <td class="sorting_1" align="center">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
        <td align="center">{{ $details['registration_number'] or "" }}</td>
        <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
        <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
        <!-- <td align="center">{{ $details['ch_auth_code'] or "" }}</td> -->
        <td align="center">{{ isset($details['last_acc_madeup_date'])?date("d-m-Y", strtotime($details['last_acc_madeup_date'])):"" }}</td>
        <td align="center">{{ isset($details['next_acc_due'])?date("d-m-Y", strtotime($details['next_acc_due'])):"" }}</td>
        <td>
          <a href="javascript:void(0)" class="open_completion_pop completion_span_{{ $details['client_id'] }}" data-client_id="{{ $details['client_id'] }}">
          {{ (isset($details['jobs_acc_details']['completion_date']) && $details['jobs_acc_details']['completion_date'] != "")?$details['jobs_acc_details']['completion_date']:'Add..' }}</a>
        </td>
        <td align="center" class="count_compl_{{ $details['client_id'] or '0' }}">
          @if( isset($details['jobs_acc_details']['completion_days']) && $details['jobs_acc_details']['completion_days'] < 0 )
            <span style="color:red">{{$details['jobs_acc_details']['completion_days']}}</span>
          @else
             {{ $details['jobs_acc_details']['completion_days'] or "0" }}
          @endif
        </td>
        <td align="center">
          <div id="after_send_{{ $details['client_id'] }}">
            <button type="button" class="job_send_btn open_audit_popup" data-client_id="{{ $details['client_id'] }}" data-send_type="single">
            @if(isset($details['manage_task']) && $details['manage_task'] == "N")
              SEND
            @else
              SEND MORE
            @endif
            </button>
          </div>
        </td>
    @endif

    @if($service_id == 7)
      @if(isset($details['type']) && $details['type'] == 'ind')
        <!-- <td>{{ isset($details['dob'])?date("d-m-Y", strtotime($details['dob'])):"" }}</td> -->
        <td>Individual</td>
        <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['client_name'] or "" }}</a></td>
        <td>{{ $details['ni_number'] or "" }}</td>
        <td>
          {{ $details['tax_reference'] or "" }}
        </td>
        <td>{{ $details['address'] or "" }}</td>
      @else
        <!-- <td>{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td> -->
        <td>Organisation</td>
        <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
        <td>N/A</td>
        <td>
          @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
            {{ $details['tax_reference'] or "" }}
          @endif
        </td>
        <td>{{ $details['address'] or "" }}</td>
      @endif
      <td align="center">
        @if(isset($details['type']) && $details['type'] == 'ind')
          @if( in_array($details['client_id'], $client_users) )
            <a href="/tsxreturninfromation/{{$details['client_id']}}/{{ base64_encode('client_portal') }}/1/0" target="_blank">View</a>
          @else
              <a href="javascript:void(0)" class="viewClientMessage">View</a>
          @endif
        @endif
      </td>
      <td align="center">
        <div id="after_send_{{ $details['client_id'] }}">
          <button type="button" class="job_send_btn open_send_popup" data-client_id="{{ $details['client_id'] }}" data-send_type="single">
          @if(isset($details['manage_task']) && $details['manage_task'] == "N")
            SEND
          @else
            SEND MORE
          @endif
          </button>
        </div>
      </td>
    @endif

    @if($service_id == 8)
      <td width="15%"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or "" }}</a></td>
      <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
      <td>{{ $details['vat_stagger'] or "" }}</td>
      <td>
        <!-- <select class="form-control newdropdown" data-client_id="{{ $details['client_id'] or '0' }}">
          <option value="">Status</option>
          @if(isset($details['contact_persons']) && count($details['contact_persons']) >0)
            @foreach($details['contact_persons'] as $key=>$contacts)
              <option value="{{ $contacts['client_id'] or "" }}_{{ $contacts['address_type'] or "" }}">{{ $contacts['contact_name'] or "" }}</option>
            @endforeach
          @endif
        </select> -->
      </td>
      
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
      <td align="center" id="after_send_{{ $details['client_id'] }}">
        <button type="button" class="job_send_btn job_send_pop" data-client_id="{{ $details['client_id'] }}" data-field_name="manage_task">
          @if(isset($details['manage_task']) && $details['manage_task'] == "N")
            SEND
          @else
            SEND MORE
          @endif
        </button>
      </td>
    @endif
    
    @if($service_id == 9)
        <td class="sorting_1" align="center">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
        <td align="center">{{ $details['registration_number'] or "" }}</td>
        <td align="left"><a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}">{{ $details['business_name'] or "" }}</a></td>
        <td align="center">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
        <td align="center">{{ $details['ch_auth_code'] or "" }}</td>
        <td align="center">{{ isset($details['made_up_date'])?date("d-m-Y", strtotime($details['made_up_date'])):"" }}</td>
        <td align="center">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
        <td align="center">
          @if( isset($details['deadret_count']) && $details['deadret_count'] < 0 )
            <span style="color:red">{{ $details['deadret_count'] or "" }}</span>
          @else
             {{ $details['deadret_count'] or "" }}
          @endif
        </td>
        <td align="center" id="after_send_{{ $details['client_id'] }}">
          @if(isset($details['ch_manage_task']) && $details['ch_manage_task'] == "N")
            <button type="button" class="job_send_btn send_manage_task" data-client_id="{{ $details['client_id'] }}" data-field_name="ch_manage_task">SEND</button>
          @else
            <button type="button" class="job_sent_btn">SENT</button>
          @endif
        </td>
    @endif
       
      <td align="center" width="10%">
        <div style="float: left; width: 100%">
          <div class="left_d {{ $details['client_id'] }}_staff_table_drop_{{ $service_id }}">
          @if(isset($details['allocated_staffs']) && count($details['allocated_staffs']) >0)
            <select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_{{ $details['client_id'] }}" data-client_id="{{$details['client_id']}}">
              @foreach($details['allocated_staffs'] as $key=>$staff_row)
                <option value="{{ $staff_row['staff_id'] or "" }}">{{ $staff_row['staff_name'] or "" }}</option>
              @endforeach
            </select>
          @endif
          </div>
          <div class="text_r">
          @if($service_id == '3')
            <a href="javascript:void(0);" class="openServicesStaff openAllocation openAllocation_{{ $details['client_id'] }}" data-service_id="{{ $service_id }}" data-client_id="{{ $details['client_id'] }}" data-page_name="{{ $page_name }}">Edit</a>
          @else
            <a href="javascript:void(0);" class="openServicesStaff" data-service_id="{{ $service_id }}" data-client_id="{{ $details['client_id'] }}" data-service_name="{{ $title }}" data-client_name="{{ $details['client_name'] or '' }}" data-page="tasks" data-client_type="org">Edit</a>
          @endif
          </div>
        </div>
      </td>
    

    </tr>
    @endforeach
  @endif
  
</tbody>
</table>
