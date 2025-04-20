  <option value="">None</option>
  @if( isset($old_services) && count($old_services)>0 )
    @foreach($old_services as $key=>$scheme_row)
      <option value="{{ $scheme_row->stafftasks_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->stafftasks_id)?"selected":"" }}>{{ $scheme_row->name }}</option>
    @endforeach
  @endif
  @if( isset($new_services) && count($new_services)>0 )
    @foreach($new_services as $key=>$scheme_row)
      <option value="{{ $scheme_row->stafftasks_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->stafftasks_id)?"selected":"" }}>{{ $scheme_row->name }}</option>
    @endforeach
  @endif

|||

@if( isset($old_services) && count($old_services) )
  @foreach($old_services as $key=>$scheme_row)
    <div class="form-group">
      <label for="{{ $scheme_row->name }}">{{ $scheme_row->name }}</label>
    </div>
  @endforeach
@endif

@if( isset($new_services) && count($new_services) )
  @foreach($new_services as $key=>$scheme_row)
    <div class="form-group" id="hide_task{{ $scheme_row->stafftasks_id }}">
      <a href="javascript:void(0)" title="Delete Field ?" class="deletetergetobject" data-field_id="{{ $scheme_row->stafftasks_id }}"><img src="/img/cross.png" width="12"></a>
      <label for="{{ $scheme_row->name }}">{{ $scheme_row->name }}</label>
    </div>
  @endforeach
@endif
|||
<select class="form-control newdropdown" id="csi2">
  <option value="">None</option>
  @if( isset($comold_services) && count($comold_services)>0 )
    @foreach($comold_services as $key=>$scheme_row)
      <option value="{{ $scheme_row->stafftasks_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->stafftasks_id)?"selected":"" }}>{{ $scheme_row->name }}</option>
    @endforeach
  @endif
  @if( isset($comnew_services) && count($comnew_services)>0 )
    @foreach($comnew_services as $key=>$scheme_row)
      <option value="{{ $scheme_row->stafftasks_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->stafftasks_id)?"selected":"" }}>{{ $scheme_row->name }}</option>
    @endforeach
  @endif
</select>
|||
@if( isset($comold_services) && count($comold_services) )
  @foreach($comold_services as $key=>$scheme_row)
    <div class="form-group">
      <label for="{{ $scheme_row->name }}">{{ $scheme_row->name }}</label>
    </div>
  @endforeach
@endif

@if( isset($comnew_services) && count($comnew_services) )
  @foreach($comnew_services as $key=>$scheme_row)
    <div class="form-group" id="hide_task{{ $scheme_row->stafftasks_id }}">
      <a href="javascript:void(0)" title="Delete Field ?" class="deletetergetobject" data-field_id="{{ $scheme_row->stafftasks_id }}"><img src="/img/cross.png" width="12"></a>
      <label for="{{ $scheme_row->name }}">{{ $scheme_row->name }}</label>
    </div>
  @endforeach
@endif

|||

{{ $appraisee }} |||
{{ $appraisee_title }} |||
{{ $appraiser }} |||
{{ $appraiser_title }} |||
{{ $dateofmeeting }} |||
{{ $timeofmeeting }} ||| 

<tr id="TemplateRow1" class="makeCloneClass1">
  <td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" data-target_id="0" id="date_picker" class="DeleteBoxRow1"></a></td>
  <td>
    <select class="form-control drop_height newdropdown" id="newtarget" name="newtarget[]">
    <option value="">None</option>
    @if(isset($staff_tasks) && count($staff_tasks)>0 )
      @foreach($staff_tasks as $key=>$scheme_row)
      @if(isset($scheme_row['for_task']) && $scheme_row['for_task'] == 'per')
        <option value="{{ $scheme_row['stafftasks_id'] }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row['stafftasks_id'])?"selected":"" }}>{{ $scheme_row['name'] }}</option>
      @endif
      @endforeach
    @endif
    </select>
  </td>
  <td><input type="text" name="perform_notes[]" id="notes1" class="form-control"></td>
  <td><input type="text" name="measured_notes[]" id="notes2" class="form-control"></td>
  <td>
    <input type="text" id="completion" name="completion_date[]" class="form-control date_of_meeting dpick">
  </td>
</tr>  
|||
<tr id="TemplateRow2" class="makeCloneClass2">
  <td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" data-skill_id="0" id="date_picker2" class="DeleteBoxRow2"></a></td>
  <td>
    <select class="form-control drop_height newdropdown" id="csi2" name="competency_skill[]">
      <option value="">None</option>
      @if(isset($staff_tasks) && count($staff_tasks)>0 )
        @foreach($staff_tasks as $key=>$scheme_row)
        @if(isset($scheme_row['for_task']) && $scheme_row['for_task'] == 'com')
          <option value="{{ $scheme_row['stafftasks_id'] }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row['stafftasks_id'])?"selected":"" }}>{{ $scheme_row['name'] }}</option>
        @endif
        @endforeach
      @endif
    </select>
  </td>

  <td>
    <select class="form-control drop_height newdropdown" id="clr2" name="competency_level[]">
      @if(isset($CompetencyLevel) && count($CompetencyLevel) >0)
        @foreach($CompetencyLevel as $key=>$level_row)
          <option value="{{ $level_row['level_id'] }}">{{ $level_row['name'] }}</option>
        @endforeach
      @endif
    </select>
  </td>

  <td>
    <select class="form-control drop_height newdropdown" id="pcl2" name="prev_competency[]">
      @if(isset($CompetencyLevel) && count($CompetencyLevel) >0)
        @foreach($CompetencyLevel as $key=>$level_row)
          <option value="{{ $level_row['level_id'] }}">{{ $level_row['name'] }}</option>
        @endforeach
      @endif
    </select>
  </td>

  <td>
    <select class="form-control drop_height newdropdown" id="ccl2" name="cur_competency[]">
      @if(isset($CompetencyLevel) && count($CompetencyLevel) >0)
        @foreach($CompetencyLevel as $key=>$level_row)
          <option value="{{ $level_row['level_id'] }}">{{ $level_row['name'] }}</option>
        @endforeach
      @endif
    </select>
  </td>
  <td><input type="text" name="supporting_notes[]" class="form-control supporting_notes"></td>
</tr>     
      
      