<script type="text/javascript">
/*var service_id    = $('#service_id').val();
if(service_id == 8){

  for(var k=1; k<=6;k++){
    $('#example2'+k).dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
          {"bSortable": false},
          {"bSortable": true},
          {"bSortable": true},
          {"bSortable": false},
          {"bSortable": true},
          {"bSortable": false}
      ],
      "aaSorting": [[2, 'asc']]
    });
  }
}*/
</script>

<div id="tab_2" class="tab-pane top_margin {{ ($page_open == '2')?'active':'' }}" style=" position: relative;">
  <table class="table table-bordered table-hover dataTable ch_returns" id="example21">
    <thead>
      <tr role="row">
        <th width="5%">Action</th>
      @if($service_id == 1)
        <th width="8%">D0R</th>
        <th width="15%">Business Name</th>
        <th>Stagger</th>
        <th>Frequency</th>
        <th>Return</th>
      @endif

      @if($service_id == 2)
        <th width="8%">D0R</th>
        <th>Business Name</th>
        <th width="10%">VAT Stagger</th>
        <th>ECSL Frequency</th>
        <th>Return</th>
      @endif

      @if($service_id == 3)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Year End</th>
        <th>Next Accts Due On</th>
        <th>Days</th>
      @endif

      @if($service_id == 4)
        <th>Business Name</th>
        <th>Job Due Date</th>
      @endif

      @if($service_id == 5)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Tax Return Period</th>
        <th>Due Date</th>
        <th>Count Down</th>
      @endif

      @if($service_id == 6)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Year End</th>
        <th>Period End</th>
        <th>Completion Date</th>
        <th>Days</th>
      @endif

      @if($service_id == 7)
        <th>Business Name</th>
        <th width="11%">Email</th>
        <th width="13%">Request Information</th>
        <th width="7%">Tax Year</th>        
      @endif

      @if($service_id == 8)
        <th width="30%">Business Name</th>
        <th width="15%">Job</th>
      @endif

      @if($service_id == 9)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Authen Code</th>
        <th>Next Return Due On</th>
        <th>Days</th>
      @endif

        <th width="11%">Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
      @if($service_id == 7)
        <th width="7%">View Data</th>
      @endif
        <th width="5%">Notes</th>
        <!-- <th width="8%">EMAIL CLIENT</th> -->
        <th width="10%">Status <a href="#" data-toggle="modal" data-target="#status-modal" class="auto_send-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
        
          <tr class="data_tr_{{ $details['client_id'] }}_21">
            <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-manage_id="{{ $details['job_manage_id'] or "" }}" data-tab="21"><img src="/img/cross.png"></a></td>

        @if($service_id == 1)
            <td align="left">{{ isset($details['effective_date'])?date("d-m-Y", strtotime($details['effective_date'])):"" }}</td>
            <td align="left">
                <!--<a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a>-->
            <a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a>
            </td>
            <td align="left">{{ $details['vat_stagger'] or "" }}</td>
            <td align="left">{{ isset($details['ret_frequency'])?ucwords($details['ret_frequency']):"" }}</td>
            <td align="left">{{ $details['return_date'] or "" }}</td>
        @endif

        @if($service_id == 2)
            <td align="left">{{ isset($details['effective_date'])?date("d-m-Y", strtotime($details['effective_date'])):"" }}</td>
            <td align="left">
            <!--<a href="/client/edit-org-client/{{$details['client_id']}}/{{base64_encode('org_client')}}" target="_blank">{{$details['business_name'] or ""}}</a>-->
            <a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a>
            </td>
            <td align="left">{{ $details['vat_stagger'] or "" }}</td>
            <td align="left">{{ isset($details['ecsl_freq'])?ucwords($details['ecsl_freq']):"" }}</td>
            <td align="left">{{ $details['return_date'] or "" }}</td>
        @endif

        @if($service_id == 3)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left">
            <!--<a href="/client/edit-org-client/{{ $details['client_id'] }}/{{ base64_encode('org_client') }}" target="_blank">{{ $details['business_name'] or "" }}</a>-->
            <a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a>
            </td>
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
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
          <td>{{ $details['job_due_date'] or "" }}</td>
        @endif

        @if($service_id == 5)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
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
        @endif

        @if($service_id == 6)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
            <td align="left">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
            <td align="left">{{ isset($details['period_end'])?date("d-m-Y", strtotime($details['period_end'])):"" }}</td>
            <td align="left">{{ (isset($details['jobs_acc_details']['completion_date']) && $details['jobs_acc_details']['completion_date'] != "")?$details['jobs_acc_details']['completion_date']:"" }}</td>
            <td align="left">
              @if( isset($details['jobs_acc_details']['completion_days']) && $details['jobs_acc_details']['completion_days'] < 0 )
                <span style="color:red">{{$details['jobs_acc_details']['completion_days']}}</span>
              @else
                 {{ $details['jobs_acc_details']['completion_days'] or "0" }}
              @endif
            </td>
        @endif

        @if($service_id == 7)
          @if(isset($details['type']) && $details['type'] == 'ind')
            
            <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['client_name'] or "" }}</a></td>
            <td>{{ $details['res_email'] or "" }}</td>
            <!--<td>{{ $details['tax_reference'] or "" }}</td>-->
          @else
            
            <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
            <td>{{ $details['contactemail'] or "" }}</td>
            <!--<td>
              @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
                {{ $details['tax_reference'] or "" }}
              @endif
            </td>-->
          @endif
          <td align="center"><button type="button" class="job_send_btn" data-client_id="" data-send_type="">SEND</button></td>
          <td>{{ $details['return_date'] or "" }}</td>
        @endif

        @if($service_id == 8)
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
          <td width="10%">{{ $details['return_date'] or "" }}</td>
        @endif

        @if($service_id == 9)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
          <td align="left">{{ $details['ch_auth_code'] or "" }}</td>
          <td align="left">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
          <td align="left">
            @if( isset($details['deadret_count']) && $details['deadret_count'] < 0 )
              <span style="color:red">{{ $details['deadret_count'] or "" }}</span>
            @else
               {{ $details['deadret_count'] or "" }}
            @endif
          </td>
        @endif

            <td align="center">
              <div id="edit_calender_{{ $details['client_id'] }}_21" class="edit_cal">
                <a href="javascript:void(0)" id="date_view_{{ $details['client_id'] }}_21" />{{ (isset($details['jobs_notes']['job_start_date']) && $details['jobs_notes']['job_start_date'] != "")?date("d-m-Y H:i", strtotime($details['jobs_notes']['job_start_date']) ):"" }}</a>
                <span class="glyphicon glyphicon-chevron-down open_adddrop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"></span>
                <div class="cont_add_to_date open_dropdown_{{ $details['client_id'] }}_21" style="display:none;">
                <ul> 
                  <li><a href="javascript:void(0)" class="open_newtask_pop" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21" data-task_name="{{ $title or '' }}">
                  {{ (isset($details['tasksadded']) && $details['tasksadded'] == 1)?'Added':'Add'}} to TODO List</a></li>
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
        @if($service_id == 7)
          <td align="center">
              @if(isset($details['type']) && $details['type'] == 'ind')
                @if(isset($details['return_date']) && $details['return_date'] != '')
                  @if( in_array($details['client_id'], $client_users) )
                      <a href="/tsxreturninfromation/{{$details['client_id']}}/{{ base64_encode('client_portal') }}/1/{{ str_replace('/', '-', $details['return_date']) }}" target="_blank">View</a>
                  @else
                      <a href="javascript:void(0)" class="viewClientMessage">View</a>
                  @endif
                @endif
              @endif
          </td>
        @endif
            <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or '' }}" data-tab="21"><span {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
            </td>
            <!-- <td>
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

            </td> -->
            
            <td align="center" width="12%">
              @if($service_id== 1 || $service_id== 2 || $service_id== 4 || $service_id== 6 || $service_id == 7 || $service_id == 8)
                <input type="hidden" name="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" id="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$details['job_manage_id']]['status_id'] or '2' }}">
              @else
                <input type="hidden" name="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" id="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$service_id]['status_id'] or '2' }}">
              @endif
              <select class="form-control newdropdown table_select job_status_change" id="{{ $page_open }}_status_dropdown_{{ $details['client_id'] }}" data-client_id="{{ $details['client_id']}}" data-manage_id="{{$details['job_manage_id'] or '0'}}">
                <option value="2">Not Started</option>
                @if(isset($jobs_steps) && count($jobs_steps) >0)
                  @foreach($jobs_steps as $key=>$value)
                    @if($service_id == 1 || $service_id == 2 || $service_id== 4 || $service_id== 6 || $service_id == 7 || $service_id == 8)
                      <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$details['job_manage_id']]['status_id']) && $details['job_status'][$details['job_manage_id']]['status_id'] == $value['step_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                    @else
                      <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $value['step_id']) && (isset($details['job_status'][$service_id]['client_id']) && $details['job_status'][$service_id]['client_id'] == $details['client_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                    @endif
                  @endforeach
                @endif
              </select>
            </td>
          </tr>
        @endif 
      @endforeach
    @endif
       <!-- && (isset($details['job_status'][$details['job_manage_id']]['job_manage_id']) && $details['job_status'][$details['job_manage_id']]['job_manage_id'] == $details['job_manage_id']) -->
    </tbody>
  </table>
  </div>
         
<div id="tab_22" class="tab-pane top_margin {{ ($page_open == '22')?'active':'' }}" style=" position: relative;">
  <table class="table table-bordered table-hover dataTable ch_returns" id="example22">
    <thead>
      <tr role="row">
        <th width="5%">Action</th>
      @if($service_id == 1)
        <th width="8%">D0I</th>
        <th>Business Name</th>
        <th width="10%">Stagger</th>
        <th>Frequency</th>
        <th>Return</th>
      @endif

      @if($service_id == 2)
        <th width="8%">D0I</th>
        <th>Business Name</th>
        <th>VAT Number</th>
        <th width="10%">Stagger</th>
        <th>Return</th>
      @endif

      @if($service_id == 3)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Year End</th>
        <th>Next Accts Due On</th>
        <th>Days</th>
      @endif

      @if($service_id == 4)
        <th>Business Name</th>
        <th>Job Due Date</th>
        <th width="12%">Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
      @endif

      @if($service_id == 5)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>CT. Reference</th>
        <th>Tax Return Period</th>
        <thDue Date</th>
        <th>Count Down</th>
      @endif

      @if($service_id == 6)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Year End</th>
        <th>Period End</th>
        <!-- <th>COMPLETION DATE</th> -->
        <th>Days</th>
      @endif

      @if($service_id == 7)
        <th>Business Name</th>
        <th width="7%">NI Number</th>
        <th width="9%">Tax Reference</th>
        <th width="7%">Tax Year</th>       
        <th width="11%">Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
        <th>View Data</th>       
      @endif

      @if($service_id == 8)
        <th width="30%">Business Name</th>
        <th width="15%">Job</th>
        <th width="15%">Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
      @endif

      @if($service_id == 9)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Authen Code</th>
        <th>Next Return Due On</th>
        <th>Count Down</th>
      @endif
        <th width="5%">Notes</th>
      @if($service_id == 4 || $service_id == 8)
        <!-- <th width="8%">EMAIL CLIENT</th> -->
      @endif
        <th width="10%">Status <a href="#" data-toggle="modal" data-target="#status-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
          @if(!isset($details['job_status'][$details['job_manage_id']]['status_id']))
          <tr class="data_tr_{{ $details['client_id'] }}_22">
            <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-manage_id="{{ $details['job_manage_id'] or "" }}" data-tab="22" ><img src="/img/cross.png"></a></td>
        @if($service_id == 1)
          <td>{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
          <td>{{ isset($details['vat_stagger'])?$details['vat_stagger']:"" }}</td>
          <td>{{ isset($details['ret_frequency'])?ucwords($details['ret_frequency']):""}}</td>
          <td>{{ $details['return_date'] or "" }}</td>
        @endif

        @if($service_id == 2)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
          <td align="left">{{ $details['vat_number'] or "" }}</td>
          <td align="left">{{ isset($details['vat_stagger'])?ucwords($details['vat_stagger']):"" }}</td>
          <td align="left">{{ $details['return_date'] or "" }}</td>
        @endif

        @if($service_id == 3)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
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
        <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
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
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
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
      @endif

      @if($service_id == 6)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
          <td align="left">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
          <td align="left">{{ isset($details['period_end'])?date("d-m-Y", strtotime($details['period_end'])):"" }}</td>
          <!-- <td align="left">{{ (isset($details['jobs_acc_details']['completion_date']) && $details['jobs_acc_details']['completion_date'] != "")?$details['jobs_acc_details']['completion_date']:"" }}</td> -->
          <td align="left">
            @if( isset($details['jobs_acc_details']['completion_days']) && $details['jobs_acc_details']['completion_days'] < 0 )
                <span style="color:red">{{$details['jobs_acc_details']['completion_days']}}</span>
              @else
                 {{ $details['jobs_acc_details']['completion_days'] or "0" }}
              @endif
          </td>
      @endif

      @if($service_id == 7)
        @if(isset($details['type']) && $details['type'] == 'ind')
          
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['client_name'] or "" }}</a></td>
          <td>{{ $details['ni_number'] or "" }}</td>
          <td>{{ $details['tax_reference'] or "" }}</td>
        @else
          
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
          <td>N/A</td>
          <td>
            @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
              {{ $details['tax_reference'] or "" }}
            @endif
          </td>
        @endif
        <td>{{ $details['return_date'] or "" }}</td>
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
        <td>
            @if(isset($details['type']) && $details['type'] == 'ind')
                @if(isset($details['return_date']) && $details['return_date'] != '')
                  @if( in_array($details['client_id'], $client_users) )
                      <a href="/tsxreturninfromation/{{$details['client_id']}}/{{ base64_encode('client_portal') }}/1/{{ str_replace('/', '-', $details['return_date']) }}" target="_blank">View</a>
                  @else
                      <a href="javascript:void(0)" class="viewClientMessage">View</a>
                  @endif
                @endif
            @endif
        </td>
      @endif

      @if($service_id == 8)
        <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
        <td>{{ $details['return_date'] or "" }}</td>
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
    
      @if($service_id == 9)
        <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
        <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
        <td align="left">{{ $details['ch_auth_code'] or "" }}</td>
        <td align="left">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
        <td align="center" class="count_tax_{{ $details['client_id'] or '0' }}">
          @if( isset($details['jobs_acc_details']['roll_count']) && $details['jobs_acc_details']['roll_count'] < 0 )
            <span style="color:red">{{ $details['jobs_acc_details']['roll_count'] or "" }}</span>
          @else
             {{ $details['jobs_acc_details']['roll_count'] or "" }}
          @endif
        </td>
      @endif

        <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a></td>
        @if($service_id == 4 || $service_id == 8)
          <!-- <td>
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

          </td> -->
        @endif    
            <td align="center" width="12%">
              @if($service_id == 1 || $service_id == 2 || $service_id == 4 || $service_id== 6 || $service_id == 7 || $service_id == 8)
                <input type="hidden" name="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" id="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$details['job_manage_id']]['status_id'] or '2' }}">
              @else
                <input type="hidden" name="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" id="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$service_id]['status_id'] or '2' }}">
              @endif
              <select class="form-control newdropdown table_select job_status_change" id="2{{ $page_open }}_status_dropdown_{{ $details['client_id'] }}" data-client_id="{{ $details['client_id'] }}" data-manage_id="{{$details['job_manage_id'] or '0'}}">
                <option value="2">Not Started</option>
                @if(isset($jobs_steps) && count($jobs_steps) >0)
                  @foreach($jobs_steps as $key=>$value)
                    @if($service_id == 1 || $service_id == 2 || $service_id == 4 || $service_id== 6 || $service_id == 7 || $service_id == 8)
                      <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$details['job_manage_id']]['status_id']) && $details['job_status'][$details['job_manage_id']]['status_id'] == $value['step_id']) && (isset($details['job_status'][$details['job_manage_id']]['job_manage_id']) && $details['job_status'][$details['job_manage_id']]['job_manage_id'] == $details['job_manage_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                    @else
                      <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $value['step_id']) && (isset($details['job_status'][$service_id]['client_id']) && $details['job_status'][$service_id]['client_id'] == $details['client_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                    @endif
                  @endforeach
                @endif
              </select>
            </td>
          </tr>
          @endif
        @endif 
      @endforeach
    @endif
      
    </tbody>
  </table>  
  </div>
   
  @for($k=3; $k <= 9;$k++)                          
  <div id="tab_2{{$k}}" class="tab-pane top_margin {{ ($page_open == '2'.$k)?'active':'' }}" style=" position: relative;">
    @if($service_id == 1)
    <!-- <div class="table_property_inner">
      <strong>Current Return :</strong> October 2015 &nbsp;&nbsp;
      <strong>Due Date :</strong> 21st of November 2015 &nbsp;&nbsp;
      <strong>Count Down :</strong> 6 Days
    </div> -->
    @endif

    <table class="table table-bordered table-hover dataTable ch_returns" id="example2{{$k}}" aria-describedby="example2{{$k}}_info">
    <thead>
      <tr role="row">
        <th width="5%">Action</th>
      @if($service_id == 1)
        <th width="8%">D0I</th>
        <th width="15%">Business Name</th>
        <th>VAT Number</th>
        <th>Frequency</th>
        <th>Return</th>
      @endif

      @if($service_id == 2)
        <th width="8%">D0I</th>
        <th>Business Name</th>
        <th>VAT Number</th>
        <th width="10%">Stagger</th>
        <th>Return</th>
      @endif

      @if($service_id == 3)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Year End</th>
        <th>Next Accts Due On</th>
        <th>Days</th>
      @endif

      @if($service_id == 4)
        <th>Business Name</th>
        <th>Job Due Date</th>
        <th width="12%">Job Start Date <a href="javascript:void(0)" class="job_start_date-modal"  style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
      @endif

      @if($service_id == 5)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>CT. Reference</th>
        <th>Tax Return Period</th>
        <th>Due Date</th>
        <th>Count Down</th>
      @endif

      @if($service_id == 6)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Year End</th>
        <th>Period End</th>
        <!-- <th>COMPLETION DATE</th> -->
        <th>Days</th>
      @endif
      
      @if($service_id == 7)
        <th>Business Name</th>
        <th width="7%">NI Number</th>
        <th width="9%">Tax Reference</th>
        <th width="7%">Tax Year</th>       
        <th width="11%">Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
        <th>VIEW DATA</th>       
      @endif

      @if($service_id == 8)
        <th width="30%">Business Name</th>
        <th width="15%">Job</th>
        <th width="15%">Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
      @endif

      @if($service_id == 9)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Authen Code</th>
        <th>Next Return Due On</th>
        <th>Count Down</th>
      @endif
        <th width="7%">Notes</th>
      @if($service_id == 4 || $service_id == 8)
        <!-- <th width="10%">EMAIL CLIENT</th> -->
      @endif
        <th width="10%">Status <a href="#" data-toggle="modal" data-target="#status-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
          @if(isset($details['job_status'][$details['job_manage_id']]['status_id']) && $details['job_status'][$details['job_manage_id']]['status_id'] == $step_id)
            <tr class="data_tr_{{ $details['client_id'] }}_2{{ $page_open }}">
              <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-manage_id="{{ $details['job_manage_id'] or "" }}" data-tab="2{{ $page_open }}"><img src="/img/cross.png"></a></td>
          @if($service_id == 1)
            <td>{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
            <td>{{ isset($details['vat_number'])?$details['vat_number']:"" }}</td>
            <td>{{ isset($details['ret_frequency'])?ucwords($details['ret_frequency']):"" }}</td>
            <td>{{ $details['return_date'] or "" }}</td>
          @endif

          @if($service_id == 2)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or ""}}</a></td>
            <td align="left">{{ $details['vat_number'] or "" }}</td>
            <td align="left">{{ isset($details['vat_stagger'])?ucwords($details['vat_stagger']):"" }}</td>
            <td align="left">{{ $details['return_date'] or "" }}</td>
          @endif

          @if($service_id == 3)
              <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
              <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or ""}}</a></td>
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
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
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
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
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
      @endif

      @if($service_id == 6)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
          <td align="left">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
          <td align="left">{{ isset($details['period_end'])?date("d-m-Y", strtotime($details['period_end'])):"" }}</td>
          <!-- <td align="left">{{ (isset($details['jobs_acc_details']['completion_date']) && $details['jobs_acc_details']['completion_date'] != "")?$details['jobs_acc_details']['completion_date']:"" }}</td> -->
          <td align="left">
            @if( isset($details['jobs_acc_details']['completion_days']) && $details['jobs_acc_details']['completion_days'] < 0 )
                <span style="color:red">{{$details['jobs_acc_details']['completion_days']}}</span>
              @else
                 {{ $details['jobs_acc_details']['completion_days'] or "0" }}
              @endif
          </td>
      @endif

      @if($service_id == 8)
        <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
        <td>{{ $details['return_date'] or "" }}</td>
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
          
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['client_name'] or "" }}</a></td>
          <td>{{ $details['ni_number'] or "" }}</td>
          <td>{{ $details['tax_reference'] or "" }}</td>
        @else
          
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
          <td>N/A</td>
          <td>
            @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
              {{ $details['tax_reference'] or "" }}
            @endif
          </td>
        @endif
        <td>{{ $details['return_date'] or "" }}</td>
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

      @if($service_id == 9)
        <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
        <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
        <td align="left">{{ $details['ch_auth_code'] or "" }}</td>
        <td align="left">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
        <td align="center" class="count_tax_{{ $details['client_id'] or '0' }}">
          @if( isset($details['jobs_acc_details']['roll_count']) && $details['jobs_acc_details']['roll_count'] < 0 )
            <span style="color:red">{{ $details['jobs_acc_details']['roll_count'] or "" }}</span>
          @else
             {{ $details['jobs_acc_details']['roll_count'] or "" }}
          @endif
        </td>
      @endif

        <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a></td>
      

      @if($service_id == 4 || $service_id == 8)
        <!-- <td>
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
        </td> -->
      @endif  
              
            <td align="center" width="12%">
              @if($service_id == 1 || $service_id == 2 || $service_id == 4 || $service_id== 6 || $service_id == 7 || $service_id == 8)
                <input type="hidden" name="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" id="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$details['job_manage_id']]['status_id'] or '2' }}">
              @else
                <input type="hidden" name="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" id="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$service_id]['status_id'] or '2' }}">
              @endif
              <select class="form-control newdropdown table_select job_status_change" id="2{{ $page_open }}_status_dropdown_{{ $details['client_id'] }}" data-client_id="{{ $details['client_id'] }}" data-manage_id="{{$details['job_manage_id'] or '0'}}">
                <option value="2">Not Started</option>
                @if(isset($jobs_steps) && count($jobs_steps) >0)
                  @foreach($jobs_steps as $key=>$value)
                    @if($service_id == 1 || $service_id == 2 || $service_id == 4 || $service_id== 6 || $service_id == 7 || $service_id == 8)
                    <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$details['job_manage_id']]['status_id']) && $details['job_status'][$details['job_manage_id']]['status_id'] == $value['step_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                  @else
                    <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $value['step_id']) && (isset($details['job_status'][$service_id]['client_id']) && $details['job_status'][$service_id]['client_id'] == $details['client_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                  @endif
                  @endforeach
                @endif
              </select>
            </td>
          </tr>
          @endif
        @endif
      @endforeach
    @endif
      
    </tbody>
  </table> 
  </div>
  @endfor   

  <div id="tab_210" class="tab-pane {{ ($page_open == '210')?'active':'' }} top_margin" style=" position: relative;">
    <table class="table table-bordered table-hover dataTable ch_returns" id="example210" aria-describedby="example210_info" width="100%">
    <thead>
      <tr role="row">
        <th width="5%">Action</th>
      @if($service_id == 1)
        <th width="8%">D0I</th>
        <th>Business Name</th>
        <th>VAT Number</th>
        <th>Frequency</th>
        <th>Return</th>
        <th width="5%">Notes</th>
      @endif

      @if($service_id == 2)
        <th width="8%">D0I</th>
        <th>Business Name</th>
        <th>VAT Number</th>
        <th width="10%">Stagger</th>
        <th>Retuen</th>
        <th width="5%">Notes</th>
      @endif

      @if($service_id == 3)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Year End</th>
        <th>Next Accts Due On</th>
        <th>Days</th>
        <th width="5%">Notes</th>
        <th>Sync Data</th>
      @endif

      @if($service_id == 4)
        <th>Business Name</th>
        <th>Job Due Date</th>
        <th width="20%">Job Start Date <a href="javascript:void(0)" class="job_start_date-modal"  style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
        <th>Notes</th>
      @endif

      @if($service_id == 5)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>CT. Reference</th>
        <th>Tax Return Period</th>
        <th>Due Date</th>
        <th>Count Down</th>
        <th width="5%">Notes</th>
        <th>Roll Fwd</th>
      @endif

      @if($service_id == 6)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Year End</th>
        <th>Period End</th>
        <!-- <th>COMPLETION DATE</th> -->
        <th>Days</th>
        <th>Notes</th>
      @endif
      
      @if($service_id == 7)
        <th>Business Name</th>
        <th width="7%">NI Number</th>
        <th width="9%">Tax Reference</th>
        <th width="7%">Tax Year</th>       
        <th width="11%">Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
        <th>View Data</th>       
      @endif

      @if($service_id == 9)
        <th width="8%">DOI</th>
        <th>Business Name</th>
        <th>Authen Code</th>
        <th>Next Return Due On</th>
        <th>Count Down</th>
        <th width="5%">Notes</th>
        <th>Sync Data</th>
      @endif
        <th width="10%">Status <a href="#" data-toggle="modal" data-target="#status-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
          @if(isset($details['job_status'][$details['job_manage_id']]['status_id']) && $details['job_status'][$details['job_manage_id']]['status_id'] == $step_id)
          <tr class="data_tr_{{ $details['client_id'] }}_2{{ $page_open }}">
            <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-manage_id="{{ $details['job_manage_id'] or "" }}" data-tab="2{{ $page_open }}"><img src="/img/cross.png"></a></td>
          
          @if($service_id == 1)
            <td>{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or ""}}</a></td>
            <td>{{ isset($details['vat_number'])?$details['vat_number']:"" }}</td>
            <td>{{ isset($details['ret_frequency'])?ucwords($details['ret_frequency']):"" }}</td>
            <td>{{ $details['return_date'] or "" }}</td>
            <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="210"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
            </td>
          @endif

          @if($service_id == 2)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or ""}}</a></td>
            <td align="left">{{ $details['vat_number'] or "" }}</td>
            <td align="left">{{ isset($details['vat_stagger'])?ucwords($details['vat_stagger']):"" }}</td>
            <td align="left">{{ $details['return_date'] or "" }}</td>
            <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a>
            </td>
          @endif

          @if($service_id == 3)        
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>

            <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['business_name'] or ""}}</a></td>

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

        @if($service_id == 4)
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td>
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

          <td align="center">
              <a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>Notes</span></a>
            </td>
        @endif

        @if($service_id == 5)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or ""}}</a></td> 
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

        @if($service_id == 6)
            <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
            <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
            <td align="left">{{ $details['acc_ref_day'] or "" }}-{{ $details['ref_month'] or "" }}</td>
            <td align="left">{{ isset($details['period_end'])?date("d-m-Y", strtotime($details['period_end'])):"" }}</td>
            <!-- <td align="left">{{ (isset($details['jobs_acc_details']['completion_date']) && $details['jobs_acc_details']['completion_date'] != "")?$details['jobs_acc_details']['completion_date']:"" }}</td> -->
            <td align="left">
              @if( isset($details['jobs_acc_details']['completion_days']) && $details['jobs_acc_details']['completion_days'] < 0 )
                <span style="color:red">{{$details['jobs_acc_details']['completion_days']}}</span>
              @else
                 {{ $details['jobs_acc_details']['completion_days'] or "0" }}
              @endif
            </td>
            <td><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or '0'}}"><span>notes</span></a></td>
        @endif

        @if($service_id == 7)
          @if(isset($details['type']) && $details['type'] == 'ind')
          <td>Individual</td>
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['client_name'] or "" }}</a></td>
          <td>{{ $details['ni_number'] or "" }}</td>
          <td>{{ $details['tax_reference'] or "" }}</td>
          @else
          <td>Organisation</td>
          <td><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
          <td>N/A</td>
          <td>
            @if(isset($details['tax_reference_type']) && $details['tax_reference_type'] == 'I')
              {{ $details['tax_reference'] or "" }}
            @endif
          </td>
          @endif
          <td>{{ $details['return_date'] or "" }}</td>
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
        
        @if($service_id == 7)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
        @endif   

        @if($service_id == 9)
          <td align="left">{{ isset($details['incorporation_date'])?date("d-m-Y", strtotime($details['incorporation_date'])):"" }}</td>
          <td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{$details['business_name'] or "" }}</a></td>
          <td align="left">{{ $details['ch_auth_code'] or "" }}</td>
          <td align="left">{{ isset($details['next_ret_due'])?date("d-m-Y", strtotime($details['next_ret_due'])):"" }}</td>
          <td align="center" class="count_tax_{{ $details['client_id'] or '0' }}">
            @if( isset($details['jobs_acc_details']['roll_count']) && $details['jobs_acc_details']['roll_count'] < 0 )
              <span style="color:red">{{ $details['jobs_acc_details']['roll_count'] or "" }}</span>
            @else
               {{ $details['jobs_acc_details']['roll_count'] or "" }}
            @endif
          </td>
          <td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or "" }}" data-tab="21"><span  {{ (isset($details['jobs_notes']['notes']) && $details['jobs_notes']['notes'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }}>notes</span></a></td>
          <td></td>
        @endif 


            <td align="center" width="12%">
              @if($service_id == 1 || $service_id == 2 || $service_id == 4 || $service_id== 6 || $service_id == 7 || $service_id == 8)
                <input type="hidden" name="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" id="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$details['job_manage_id']]['status_id'] or '2' }}">
              @else
                <input type="hidden" name="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" id="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$service_id]['status_id'] or '2' }}">
              @endif
              <select class="form-control newdropdown table_select job_status_change" id="2{{ $page_open }}_status_dropdown_{{ $details['client_id'] }}" data-client_id="{{ $details['client_id'] }}" data-manage_id="{{$details['job_manage_id'] or '0'}}">
                <option value="2">Not Started</option>
                @if(isset($jobs_steps) && count($jobs_steps) >0)
                  @foreach($jobs_steps as $key=>$value)
                    @if($service_id == 1 || $service_id == 2 || $service_id == 4 || $service_id== 6 || $service_id == 7 || $service_id == 8)
                      <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$details['job_manage_id']]['status_id']) && $details['job_status'][$details['job_manage_id']]['status_id'] == $value['step_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                    @else
                      <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $value['step_id']) && (isset($details['job_status'][$service_id]['client_id']) && $details['job_status'][$service_id]['client_id'] == $details['client_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                    @endif
                  @endforeach
                @endif
              </select>
            </td>
          </tr>
          @endif
        @endif
      @endforeach
    @endif
      
    </tbody>
  </table>
  </div>
 

</div>