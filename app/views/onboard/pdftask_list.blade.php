<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td valign="top" width="27%">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="26%">
									<strong>
										Date :
									</strong>
								</td>
								<td width="74%">
									{{$cdate or ""}}
								</td>
							</tr>
                            
							<tr>
								<td>
									<strong>
										Time :
									</strong>
								</td>
								<td>
									{{$ctime or ""}}
								</td>
							</tr>
                            
                            <tr>
								<td>
									<strong>
										Remind Every:
									</strong>
								</td>
								<td>
									{{$autosend_days or ""}}
								</td>
							</tr>
						</table>
					</td>
					<td width="38%" style="font-size:20px; text-align:center; font-weight:bold; text-decoration:underline;">
					
                        
                    
                    	{{ "On Boarding Checklist" }}
                    
                        
                        
					</td>
					<td width="35%">
						&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			&nbsp;
		</td>
	</tr>
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						&nbsp;
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>


<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td width="5%" align="left">
      <!-- Add to Calender -->
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
    </td>
    <td width="30%" align="left"><strong>Checklist</strong>
    <!-- <a href="#" class="add_to_list" data-toggle="modal" id="positionopen" data-target="#checklist-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
    </td> -->
    <td width="23%" align="left"><strong>Task Owner</strong></td>
    <td width="20%" align="left"><strong>Task Date</strong></td>
    <td width="22%" align="left"><strong>Status</strong></td>
    <!-- <td width="5%" align="left">Delete</td> -->
  </tr>

@if(isset($check_list) && count($check_list) > 0)
  @foreach($check_list as $key=>$check_row)
  <tr id="TemplateRow_{{ $check_row['checklist_id'] }}">
    <td align="left"><p class="custom_chk"><input type="checkbox" data-checklist_id="{{ $check_row['checklist_id'] }}" class="addto_task" name="addto_task[]" id="addto_task{{ $check_row['checklist_id'] }}" value="{{ $check_row['checklist_id'] }}" {{ (isset($check_row['task_details']['check_list']) && $check_row['task_details']['check_list'] == $check_row['checklist_id'])?'checked':'' }}><label for="addto_task{{ $check_row['checklist_id'] }}" style="width: 5px!important; margin: 1px 0 0 1px;">&nbsp;</label></p></td>
    
    <td align="left">{{ $check_row['name'] or "" }}</td>
 
    <td align="left" >
      <select >
        <option value="">None</option>
        @if(!empty($owner_list))
          @foreach($owner_list as $key=>$staff_row)
          <option value="{{ $staff_row['owner_id'] }}_{{ $staff_row['contact_type'] }}" {{ (isset($check_row['task_details']['task_owner']) && $check_row['task_details']['task_owner'] == $staff_row['owner_id'].'_'.$staff_row['contact_type'])?'selected':'' }}>{{ ucwords($staff_row['name']) }}</option>
          @endforeach
        @endif
      </select>
    </td>
    <td align="left">
      @if(isset($check_row['task_details']['taskdate']) && $check_row['task_details']['taskdate'] != "")
     <span id="frequency">{{ (isset($check_row['task_details']['taskdate']) && $check_row['task_details']['taskdate'] != "")?date('d-m-Y', strtotime($check_row['task_details']['taskdate'])):'' }}</span> 
      @else
      <script type="text/javascript">
        $("#new_task_date_{{ $check_row['checklist_id'] }}").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true });
      </script>
        <input type="text" name="new_task_date[]" id="new_task_date_{{ $check_row['checklist_id'] }}" >
      @endif
    </td>

    <td>
    @if(isset($check_row['task_details']['status']) && $check_row['task_details']['status'] == 'N')
   {{ "Not Started"}}    
    @endif
    
    @if(isset($check_row['task_details']['status']) && $check_row['task_details']['status'] == 'D')
    {{"Done"}}
    @endif
    @if(isset($check_row['task_details']['status']) && $check_row['task_details']['status'] == 'W')
   {{"WIP"}}
    @endif                
      
    </td>

    <!-- <td align="left">
      <a href="javascript:void(0)" class="DeleteBoxRow" data-checklist_id="{{ $check_row['checklist_id'] }}"><img src="/img/cross.png"></a>
    </td> -->

  </tr>
  @endforeach
  @endif
  
</table>