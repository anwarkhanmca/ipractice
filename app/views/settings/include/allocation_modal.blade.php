<div class="modal fade" id="allocation-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:95%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="modal_title_center popup_client_name"><!-- Ajax Call --></div>
        <h4 class="modal-title">
          <div style="float: left; width: 100%">
            <div class="modal_title_left popup_service_name"><!-- Ajax Call --></div>
            @if($page_name != 'org_client' && $page_name != 'ind_client')
              <div class="modal_title_right">Remove From Service 
                @if($page_name == 'client_list_allocation')
                  <input type="checkbox" id="removeAllocCheck" checked>
                @else
                  <input type="checkbox" id="removeTaskCheck" checked>
                @endif
              </div>
            @endif
          </div>
        </h4>
        <!-- <div class="modal_title_center"><a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></div> -->
        <div class="clearfix"></div>
      </div>

      <div class="modal-body" id="modal_body">
        <div class="show_loader"></div>
        <form action="/save-client-allocation" method="post" enctype="multipart/form-data" id="AllocationForm">
        <div class="modal-body">
          <input type="hidden" class="staff_service_id" id="staff_service_id" name="staff_service_id" value="">
          <input type="hidden" class="staff_client_id" id="staff_client_id" name="staff_client_id" value="">
          <input type="hidden" class="staff_client_type" id="staff_client_type" name="staff_client_type">
          <input type="hidden" id="edit_id" name="edit_id" value="0">
          <input type="hidden" class="page_name_modal" id="page_name_modal" name="page_name_modal" value="">
          <input type="hidden" id="input_type" name="input_type" value="">
          <table width="100%" class="table table-bordered allocationPopTable" id="BoxTableResp">
            <thead>
              <tr>
                <th width="5%">&nbsp;</th>
                @if(isset($headings) && count($headings) > 0)
                  @foreach($headings as $key=>$head)
                    <th width="19%" class="head_{{ $head['alloc_head_id'] }}" colspan="2">
                      <div style="float: left;">{{ $head['heading'] }}</div>
                      <div style="float: right;">Budgeted hr/yr</div>
                    </th>
                  @endforeach
                @endif
              </tr>
            </thead>
            <tbody>
              <tr id="TemplateRow_final" class="makeCloneClass TemplateRow1"> 
                <td width="5%" class="deleteAllocation"></td>
                @for($i=1; $i <=5; $i++)
                <td align="left" width="11%" class="staffDrop_{{$i}}">
                  <select class="form-control newdropdown allocationSubmit" name="staff_id{{$i}}[]" id="staff_id{{$i}}1" data-column_name="staff_id{{$i}}" data-index="1" >
                    <option value="">None</option>
                    @if(isset($staff_details) && count($staff_details) >0)
                      @foreach($staff_details as $key=>$staff_row)
                      <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] }} {{ $staff_row['lname'] }}</option>
                      @endforeach
                    @endif
                  </select>
                </td>
                <td width="8%"><input type="text" class="smallBx allocationSave" name="staff{{$i}}_hrs[]" id="staff{{$i}}1_hrs" data-column_name="staff{{$i}}1_hrs" data-index="1"></td>
                @endfor
              </tr>
            </tbody>
            </table>
        </div>
        <div class="">
          <div class="left_side" id="addNewLineBut">
            <button class="addnew_line_btn addnew_responsible"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button>
          </div>

          <div class="right_side"> 
            <button type="button" class="addnew_line_btn" style="width: 130px;" id="AllocationSubmit">
              <p class="add_line_t">Close & Notify Staff</p>
            </button>
            <button type="button" class="addnew_line_btn" style="width: 48px;" data-dismiss="modal">
              <p class="add_line_t">Close</p>
            </button>
          </div>
          <div class="clearfix"></div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Allocation settings pop up -->
<div class="modal fade" id="heading-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Heading</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '', 'id'=>'field_form')) }}
      <div class="modal-body">
      <div class="show_loader" id="showLoadHead"></div>
      <table class="table table-bordered table-hover dataTable add_heading_table">
        <thead>
          <tr>
            <th >Heading Name</th>
            <th style="text-align: center;" width="20%">Action</th>
          </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all" >
          <!-- @if(isset($jobs_steps) && count($jobs_steps) >0)
            @foreach($jobs_steps as $key=>$value)
              <tr id="change_status_tr_{{ $value['step_id'] or "" }}">
                <td align="center"><input type="checkbox" id="step_check_2{{ $value['step_id']}}" class="status_check" {{ ($value['status'] == "S")?"checked":"" }} value="{{ $value['step_id'] or "" }}" data-step_id="{{ $value['step_id'] }}" {{ ((isset($value['count']) && $value['count'] !=0) || $value['step_type'] == 'filed')?"disabled":"" }} /></td>
                <td><span id="status_span{{ $value['step_id'] or "" }}">{{ $value['title'] or "" }}</span></td>
                <td align="center"><span id="action_{{ $value['step_id'] or "" }}"><a href="javascript:void(0)" class="edit_status" data-step_id="{{ $value['step_id'] or "" }}"><img src="/img/edit_icon.png"></a></span></td>
              </tr>
            @endforeach
          @endif -->
        </tbody>
      </table>
    </div>
  {{ Form::close() }}
  </div>
  </div>
</div>
