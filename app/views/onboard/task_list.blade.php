<script type="text/javascript">
    console.log("on init");
    (function () {
      $("#calenderjs").remove();
      delete window.addtocalendar;
      delete window.ifaddtocalendar;
      if (window.addtocalendar)if(typeof window.addtocalendar.start == "function") {
        /*console.log("enter");
        $("#calenderjs").remove();
        delete window.addtocalendar;
        delete window.ifaddtocalendar;*/
        //return
      }/*else{
        console.log("else");
      }*/
      if (window.ifaddtocalendar == undefined) { window.ifaddtocalendar = 1;
          var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
          s.type = 'text/javascript';s.charset = 'UTF-8';s.async = true;
          s.setAttribute("id", "calenderjs");
          //s.src = ('https:' == window.location.protocol ? 'https' : 'http')+'://addtocalendar.com/atc/1.5/atc.min.js';
          s.src = '/js/atc.min.js';
          var h = d[g]('body')[0];h.appendChild(s); }})();

</script>
<style>
    .cont_add_to_date{width: 210px!important;}
</style>
<div class="tab_topcon">
    <div class="top_bts" style="float:left;">
      <ul style="padding:0;">
        <li><strong class="onboardBName"></strong></li>
        <li>
            <div style="margin-left: 150px;"><strong>Remind Every</strong> <input style="width:50px; padding-left:5px" type="text" id="reminddays" name="reminddays" class="remindevery" value="{{ $autosend_dtls['days'] or '' }}" /> <strong> Days</strong></div>
        </li>
        <div class="clearfix"></div>
      </ul>
    </div>
    <div class="top_search_con">
     <div class="top_bts">
      <ul style="padding:0;">
        <li>
          <button class="btn btn-success" style="margin-left: 200px;" onclick="pdfchecklist();"><i class="fa fa-download"></i> Generate PDF</button>
        </li>
        <div class="clearfix"></div>
      </ul>
    </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="tab_topcon">
    <textarea rows="5" class="form-control" name="global_notes" placeholder="Add Notes...">{{ $autosend_dtls['notes'] or '' }}</textarea>
    <div class="clearfix"></div>
</div>

<table class="table table-bordered table-hover dataTable staff_holidays" id="example2" width="100%">
    <thead>
        <tr>
          <th width="3%">
<!--<p class="custom_chk"><input type="checkbox" id="allCheck"><label for="allCheck" style="width: 5px!important; margin: 1px 0 0 1px;">&nbsp;</label></p>-->
          </th>
          <th width="27%">Checklist</th>
          <th width="22%" align="center">Email Address of Task Owner</th>
          <th width="13%" align="center">Attachment</th>
          <th width="17%" align="center">Task Date</th>
          <th width="6%" align="center">Notes</th>
          <th width="12%" align="center">Status</th>
        </tr>
    </thead> 
    <tbody>

@if(isset($check_list) && count($check_list) > 0)
  @foreach($check_list as $key=>$check_row)
    @if(isset($check_row['custom_check_id']) && $check_row['custom_check_id'] == '0')
      <tr id="TemplateRow_{{ $check_row['checklist_id'] }}">
        <td align="left"><p class="custom_chk"><input type="checkbox" data-checklist_id="{{ $check_row['checklist_id'] }}" class="addto_task" name="addto_task[]" id="addto_task{{ $check_row['checklist_id'] }}" value="{{ $check_row['checklist_id'] }}" {{ (isset($check_row['task_details']['check_list']) && $check_row['task_details']['check_list'] == $check_row['checklist_id'])?'checked':'' }}><label for="addto_task{{ $check_row['checklist_id'] }}" style="width: 5px!important; margin: 1px 0 0 1px;">&nbsp;</label></p></td>
        
        <td align="left">{{ $check_row['name'] or "" }}</td>
        <td align="left">
            <input type="text" name="owner[]" id="owner{{$check_row['checklist_id'] }}" value="{{ $check_row['task_details']['task_owner_email'] or '' }}" {{ (isset($check_row['task_details']['status']) && $check_row['task_details']['status'] != "")?'':'disabled' }} style="width:100%;">
        </td>

        <td align="left">
          <div style="float: left; margin-right: 10px">
            <input type="hidden" name="attach_hidd[]" value="{{ $check_row['task_details']['attachment'] or "" }}">
            <span class="btn btn-default btn-file p_details" style="padding: 2px 6px; width: 65px; height: 30px; margin-bottom: 0px;">
              Browse {{ Form::file('attachment[]', ['multiple' => 'multiple']) }}
              <!-- <input type="file" name="attachment[]"> -->
            </span>
          </div>
          <div style="float: left;">
          @if(isset($check_row['task_details']['attachment']) && $check_row['task_details']['attachment'] != "")
            <img src="/img/attachment.png" style="height: 18px; margin-top: 5px;">
          @endif
          </div>
        </td>
     
        <!-- <td align="left" id="ownerdrop_{{ $check_row['checklist_id'] }}">
          <select class="form-control newdropdown status_dropdown" name="owner[]" id="owner" {{ (isset($check_row['task_details']['check_list']) && $check_row['task_details']['check_list'] == $check_row['checklist_id'])?'':'disabled' }}>
            <option value="">None</option>
            @if(!empty($owner_list))
              @foreach($owner_list as $key=>$staff_row)
              <option value="{{ $staff_row['owner_id'] }}_{{ $staff_row['contact_type'] }}" {{ (isset($check_row['task_details']['task_owner']) && $check_row['task_details']['task_owner'] == $staff_row['owner_id'].'_'.$staff_row['contact_type'])?'selected':'' }}>{{ ucwords($staff_row['name']) }}</option>
              @endforeach
            @endif
          </select>
        </td> -->
        <td align="left">
          @if(isset($check_row['task_details']['taskdate']) && $check_row['task_details']['taskdate'] != "")
          <div style="position: relative;" class="edit_cal">
            <a href=""><span id="frequency">{{ (isset($check_row['task_details']['taskdate']) && $check_row['task_details']['taskdate'] != "")?date('d-m-Y', strtotime($check_row['task_details']['taskdate'])):'' }}</span> </a>
            <span class="glyphicon glyphicon-chevron-down open_adddrop" data-checklist_id="{{ $check_row['checklist_id'] }}" data-cleinttaskdate_id="{{ $check_row['task_details']['cleinttaskdate_id'] or "" }}" data-client_id="{{ $check_row['task_details']['client_id'] or "" }}" style="disabled='disabled'"></span> 
           <span></span>
            <div class="cont_add_to_date open_dropdown" id="idopen_dropdown_{{ $check_row['checklist_id'] }}" style="display: none;">
              <ul>
                <li>
                  <a href="javascript:void(0)" id="addeditshow" class="open_calender_pop" data-cleinttaskdate_id="cleinttaskdate_id">Add/Edit Start Date</a>
                </li>
                @if(isset($check_row['task_details']))
                <li>
                  <span id="view_calender_{{ $check_row['checklist_id'] }}_21" class="addtocalendar atc-style-blue">
                    <var class="atc_event">
                      <var class="atc_date_start">{{ (isset($check_row['task_details']['taskdate']) && $check_row['task_details']['taskdate'] != "")?date("d-m-Y H:i", strtotime($check_row['task_details']['taskdate']) ):"" }}</var>
                      <var class="atc_date_end">{{ (isset($check_row['task_details']['taskdate']) && $check_row['task_details']['taskdate'] != "")?date("Y-m-d H:i:s", strtotime('+1 hour', strtotime($check_row['task_details']['taskdate'])) ):"" }}</var>
                      <var class="atc_timezone">Europe/London</var>
                      <var class="atc_title">{{$title}} - {{ $check_row['name'] or ""}}</var>
                      <var class="atc_description">{{$title}} - {{ $check_row['name'] or ""}}</var>
                      <var class="atc_location">Office</var>
                      <var class="atc_organizer">{{ $admin_name }}</var>
                      <var class="atc_organizer_email">{{ $logged_email }}</var>
                    </var>
                  </span>
                 </li>
                 @else
                 <li>
                  <a href="javascript:void(0)">Add To Calender</a>
                </li>
                @endif
              </ul>
            </div>
          </div>
          @else
          <script type="text/javascript">
            $("#new_task_date_{{ $check_row['checklist_id'] }}").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });
          </script>
            <input type="text" name="new_task_date[]" id="new_task_date_{{ $check_row['checklist_id'] }}" disabled>
          @endif
        </td>

        <td align="center">
          <input type="hidden" name="message[]" id="message_{{ $check_row['checklist_id'] }}" value="{{ $check_row['task_details']['message'] or '' }}">
          <a href="javascript:void(0)" id="notes_button_{{ $check_row['checklist_id'] }}" class="notes_btn notesmodal  {{ (isset($check_row['task_details']['check_list']) && $check_row['task_details']['check_list'] == $check_row['checklist_id'])?'':'disable_click' }}" data-tablechecklist_id="{{ $check_row['task_details']['cleinttaskdate_id'] or '' }}" data-position="pop" data-key="{{ $check_row['checklist_id'] }}"><span {{ (isset($check_row['task_details']['message']) && $check_row['task_details']['message'] != "")?'style="border-bottom:3px dotted #3a8cc1 !important"':'' }} class="requ_t">Message</span></a>
        </td>

        <td align="left" id="statusdrop_{{ $check_row['checklist_id'] }}">
          <select class="form-control newdropdown status_dropdown" name="status[]" id="status" {{ (isset($check_row['task_details']['check_list']) && $check_row['task_details']['check_list'] == $check_row['checklist_id'])?'':'disabled' }}>
            <option value="N" {{ (isset($check_row['task_details']['status']) && $check_row['task_details']['status'] == 'N')?'selected':'' }}>Not Started</option>
            <option value="D" {{ (isset($check_row['task_details']['status']) && $check_row['task_details']['status'] == 'D')?'selected':'' }}>Done</option>
            <option value="W" {{ (isset($check_row['task_details']['status']) && $check_row['task_details']['status'] == 'W')?'selected':'' }}>WIP</option>
          </select>
        </td>

      </tr>
    @endif
  @endforeach
@endif
</tbody>
</table>