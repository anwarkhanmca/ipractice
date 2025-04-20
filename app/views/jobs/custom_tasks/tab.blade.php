<div id="tab" class="tab-pane top_margin {{ ($page_open == '1')?'active':'' }}" style="position:relative;">
  <table class="table table-bordered table-hover dataTable" id="example1" width="100%">
    <thead>
      <tr role="row">
        <th width="3%"><input type="checkbox"></th>
        <th width="20%">Name</th>
        <th width="13%">{{ ($headfield1 == 'none')?'Add Field Name':$headfield1 }}
          <span class="glyphicon glyphicon-chevron-down down_arrow" data-service_id="{{ $service_id }}" data-tab="21" data-no="1">
            <div class="address_type_down field_dropdown1" style="display: none;">
              <ul>
                <li><a href="{{ $goto_url }}/{{ base64_encode('1') }}/{{ base64_encode($staff_id) }}/none/{{$field1}}">None</a></li>
                @if(isset($field_names) && count($field_names) >0)
                  @foreach($field_names as $key=>$name)
                    <li><a href="{{ $goto_url }}/{{ base64_encode('1') }}/{{ base64_encode($staff_id) }}/{{$key}}/{{$field2}}">{{ $name }}</a></li>
                  @endforeach
                @endif
              </ul>
            </div>
          </span>
        </th>
        <th width="13%">{{ ($headfield2 == 'none')?'Add Field Name':$headfield2 }}
          <span class="glyphicon glyphicon-chevron-down down_arrow" data-service_id="{{ $service_id }}" data-tab="21" data-no="2">
            <div class="address_type_down field_dropdown2" style="display: none;">
              <ul>
                <li><a href="{{ $goto_url }}/{{ base64_encode('1') }}/{{ base64_encode($staff_id) }}/{{$field1}}/none">None</a></li>
                @if(isset($field_names) && count($field_names) >0)
                  @foreach($field_names as $key=>$name)
                    <li><a href="{{ $goto_url }}/{{ base64_encode('1') }}/{{ base64_encode($staff_id) }}/{{$field1}}/{{$key}}">{{ $name }}</a></li>
                  @endforeach
                @endif
              </ul>
            </div>
          </span>
        </th>
        <th width="8%">Job Name <a href="javascript:void(0)" class="openDeadlinePop" data-client_id="0" data-field_name="job_name"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
        </th>
        <th width="10%">Deadline Date <a href="javascript:void(0)" class="openDeadlinePop" data-client_id="0" data-field_name="deadline_date"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
          <!-- @if(isset($table_heading['heading']) && $table_heading['heading'] != "")
            <a href="javascript:void(0)" class="add_heading" data-heading_id="{{ $table_heading['heading_id'] or '0' }}">{{ $table_heading['heading'] or "" }}</a>
          @else
            <a href="javascript:void(0)" class="add_heading" data-heading_id="0">Add Heading..</a>
          @endif -->
        </th>
        <th width="10%">Count Down</th>
        <th width="7%">Notes</th>
        <!-- <th width="10%">EMAIL CLIENT</th> -->
        <th width="10%">
        <?php if($page_open == '1'){?>
            Send To Tasks <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
        <?php }else{?>
            Status <a href="#" data-toggle="modal" data-target="#status-modal" class="auto_send-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>
        <?php }?>
        </th>
        <th width="10%">Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        
          <tr class="data_tr_{{ $details['client_id'] }}_1">
            <td><span class="custom_chk">
              <input type='checkbox' class="checkbox ads_Checkbox" name="checkbox[]" value="{{ $details['client_id'] or '' }}"/></span>
            </td>
    
            <td align="left">
              <a href="javascript:void(0)" class="openTaskPop" style="float: left; margin-right: 5px;" data-client_id="{{ $details['client_id'] }}" data-service_id="{{ $service_id }}">{{ $details['client_name'] or "" }}</a>
              <div style="float: right;">
                <div class="red_box red_box_{{ $details['client_id'] or '' }}" style="{{ (isset($details['reminders']['is_enable']) && $details['reminders']['is_enable'] == 1)?'display: block':'display: none' }}"></div>

                <div class="blue_box blue_box_{{ $details['client_id'] or '' }}" style="{{ (isset($details['taskstatus']['is_enable']) && $details['taskstatus']['is_enable'] == '2')?'display: block':'display: none' }}"></div> 
                </div> 
            </td>
    
            <td align="center">{{ $details['field1_value'] or '' }}</td> 
            <td align="center">{{ $details['field2_value'] or '' }}</td>
            <td align="center">
            <a href="javascript:void(0)" class="openDeadlinePop" data-client_id="{{ $details['client_id'] }}" data-field_name="job_name">
              @if(isset($details['jobs_acc_details']['job_name']) && $details['jobs_acc_details']['job_name'] != '' )
                {{ $details['jobs_acc_details']['job_name'] }}
              @else
                Add..
              @endif
            </a>
            </td>
            <td align="center">
            <a href="javascript:void(0)" class="openDeadlinePop" data-client_id="{{ $details['client_id'] }}" data-field_name="deadline_date">
              @if(isset($details['jobs_acc_details']['deadline_date']) && $details['jobs_acc_details']['deadline_date'] != '' )
                {{ $details['jobs_acc_details']['deadline_date'] }}
              @else
                Add..
              @endif
            </a>
            </td>
            <td align="center" class="count_tax_{{ $details['client_id'] or '0' }}">
              @if( isset($details['count_down']) && $details['count_down'] < 0 )
                <span style="color:red">{{ $details['count_down'] or "" }}</span>
              @else
                 {{ $details['count_down'] or '' }}
              @endif
            </td>
            <td align="center">
              <a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or '' }}" data-manage_id="0" data-tab="1">notes</a>
            </td>
            <td align="center" id="after_send_{{ $details['client_id'] }}">
              @if(isset($details['manage_task']) && $details['manage_task'] == "N")
                <button type="button" class="job_send_btn" data-client_id="{{ $details['client_id'] }}">SEND</button>
              @else
                <button type="button" class="job_sent_btn">SENT</button>
              @endif
              </button>
            </td>
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
                  <!-- <a href="javascript:void(0);" class="openServicesStaff" data-service_id="{{ $service_id }}" data-client_id="{{ $details['client_id'] }}" data-service_name="{{ $title }}" data-client_name="{{ $details['client_name'] }}" data-page="tasks" data-client_type="org">Edit</a> -->
                  <a href="javascript:void(0);" class="openServicesStaff openAllocation openAllocation_{{ $details['client_id'] }}" data-service_id="{{ $service_id }}" data-client_id="{{ $details['client_id'] }}" data-page_name="{{ $page_name }}">Edit</a>
                </div>
              </div>
            </td>
          </tr>
        
      @endforeach
    @endif 
    </tbody>
  </table>
  </div>

<div id="tab2" class="tab-pane top_margin {{ ($page_open == 2)?'active':'' }}">
  @include('jobs/includes/tasks')
  <!-- <table class="table table-bordered table-hover dataTable" id="example2" width="100%">
    <thead>
      <tr role="row">
        <th width="5%" align="center">Action</th>
        <th width="21%">Client Name</th>
        <th width="15%" align="center">{{ ($headfield1 == 'none')?'Add Field Name':$headfield1 }}</th>
        <th width="15%" align="center">{{ ($headfield2 == 'none')?'Add Field Name':$headfield2 }}</th>
        <th width="10%" align="center">Deadline Date</th>
        <th width="8%" align="center">Count Down</th>
        <th width="10%">Job Start Date</th>
        <th width="6%" align="center">Notes</th>
        <th width="10%">Status <a href="#" data-toggle="modal" data-target="#status-modal" class="auto_send-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
    @if(isset($company_details) && count($company_details) >0)
      @foreach($company_details as $key=>$details)
        @if(isset($details['manage_task']) && $details['manage_task'] == "Y")
        <tr class="data_tr_{{ $details['client_id'] }}_{{ $page_open }}">
          <td><a href="javascript:void(0)" class="delete_single_task" data-client_id="{{ $details['client_id'] or "" }}" data-manage_id="{{ $details['job_manage_id'] or "" }}" data-tab="22"><img src="/img/cross.png"></a></td>
          <td><a href="javascript:void(0)">{{ $details['client_name'] or "" }}</a></td>
          <td align="center">{{ $details['field1_value'] or '' }}</td> 
          <td align="center">{{ $details['field2_value'] or '' }}</td>
          <td>
            {{(isset($details['jobs_acc_details']['deadline_date']) && $details['jobs_acc_details']['deadline_date']!='')?$details['jobs_acc_details']['deadline_date']:'' }}
          </td>
          <td align="center" class="count_tax_{{ $details['client_id'] or '0' }}">
            @if( isset($details['count_down']) && $details['count_down'] < 0 )
              <span style="color:red">{{ $details['count_down'] or "" }}</span>
            @else
               {{ $details['count_down'] or '' }}
            @endif
          </td>
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
                    <var class="atc_title">{{$title}} - {{$details['client_name'] or ""}}</var>
                    <var class="atc_description">{{$title}} - {{$details['client_name'] or ""}}</var>
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
          <td><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="{{ $details['client_id'] or '' }}">notes</a></td>
          <td align="center" width="12%">
            <input type="hidden" name="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" id="{{ $page_open }}_prev_status_{{ $details['client_id'] }}" value="{{ $details['job_status'][$service_id]['status_id'] or '2' }}">
            <select class="form-control newdropdown table_select job_status_change" id="{{ $page_open }}_status_dropdown_{{ $details['client_id'] }}" data-client_id="{{ $details['client_id']}}" data-manage_id="{{$details['job_manage_id'] or '0'}}">
              <option value="2">Not Started</option>
              @if(isset($jobs_steps) && count($jobs_steps) >0)
                @foreach($jobs_steps as $key=>$value)
                  <option value="{{ $value['step_id'] or "" }}" {{ ((isset($details['job_status'][$service_id]['status_id']) && $details['job_status'][$service_id]['status_id'] == $value['step_id']) && (isset($details['job_status'][$service_id]['client_id']) && $details['job_status'][$service_id]['client_id'] == $details['client_id']))?"selected":"" }}>{{ $value['title'] or "" }}</option>
                @endforeach
              @endif
            </select>
          </td>
        </tr>
        @endif
      @endforeach
    @endif
    </tbody>
  </table> -->
</div>
         
  <div id="tab_completed" class="tab-pane {{($page_open==3)?'active':'hide' }} top_margin">
    @include('jobs/includes/completed')
    <!-- <table class="table table-bordered table-hover dataTable" id="table_completed">
      <thead>
        <tr role="row">
          <th width="5%">DELETE</th>
          <th width="40%">BUSINESS NAME</th>
          <th width="20%">JOB DUE DATE</th>
          <th width="20%">COMPLETION DATE</th>
          <th width="15%">TIME SHEET</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($completed) && count($completed) >0)
        @foreach($completed as $key=>$details)
          <tr class="data_tr_{{ $details['client_id'] }}_{{ $page_open }}">
            <td><a href="javascript:void(0)" class="delete_completed" data-task_id="{{ $details['task_id'] or '0' }}"><img src="/img/cross.png"></a></td>
            <td>{{ $details['client_name'] or "" }}</td>
            <td></td>
            <td>{{ (isset($details['created']) && $details['created'] != "0000-00-00 00:00:00")?date("d-m-Y H:i", strtotime($details['created']) ):"" }}</td>
            <td id="addTimeSheet{{$details['completed_tasks']['task_id'] or ''}}">
          @if(isset($details['timesheet_check']) && $details['timesheet_check'] != 'Y')  
              <a href="javascript:void(0)" class="addTimeSheet" data-client_id="{{ $details['client_id'] or '' }}" data-completed_id="{{ $details['completed_tasks']['task_id'] }}" data-filling_date="{{ isset($details['completed_tasks']['date'])?$details['completed_tasks']['date']:"" }}">Add..</a>
          @else
              <a href="javascript:void(0)" data-client_id="{{ $details['client_id'] or '' }}" data-completed_id="{{ $details['completed_tasks']['task_id'] or ''}}" class="viewTimeSheet">Completed</a>
          @endif
            </td>
          </tr>
        @endforeach
      @endif
        
      </tbody>
    </table> -->
  </div>
 

</div>