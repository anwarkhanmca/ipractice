<div class="modal fade" id="newTimeSheet-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <!-- <h4 class="modal-title">ADD COURSE</h4> -->
        <div class="clearfix"></div>
      </div>
      <!--<form action="#" method="post">-->
      <div style="color: #00c0ef; font-size: 20px; text-align: center; margin: 20px;" id="modal_body1"></div>
      <div class="modal-body" id="modal_body2">
        <div class="show_loader"></div>
          <table width="100%" border="0" class="staff_holidays">
            <tr>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="30%"><strong id="HeadingDiv">NEW TIME SHEET</strong></td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table>

              </td>
            </tr>
            <tr>
              <td valign="top">
      <form action="/timesheet/insert-time-sheet" method="post" enctype="multipart/form-data" id="timeSheetForm">
        <input type="hidden" name="entry_type" id="entry_type" value="T">
        <input type="hidden" name="page_type_pop" id="page_type_pop" value="tasks">
        <input type="hidden" id="edit_id" name="edit_id" value="0" />

        <input type="hidden" name="tasks_service_id" id="tasks_service_id" value="{{ $service_id or '0' }}">
        <input type="hidden" id="tasks_client_id" name="tasks_client_id" value="0" />
        <input type="hidden" id="completed_id" name="completed_id" value="0" />
        
      <table width="100%" class="table table-bordered" id="BoxTable1">
      <thead>
        <tr>
          <th width="15%" align="center">Date</th>
          <th align="center">Staff Name</strong></th>
          <th width="20%" align="center">Client Name</strong></th>
          <th width="20%" align="center"><span id="servDiv">Service <a href="#" class="add_to_list" data-toggle="modal" data-target="#vatScheme-modal">Add/Edit List</a></span></th>
          <th width="8%" align="center"><span id="hrsDiv">Hrs</span></th>
          <th width="8%" align="center">Notes</th>
          <th id="attachTh" width="12%">Attachment</th>
        </tr>
      </thead>
      <tbody>
        <tr id="TemplateRow" class="makeCloneClass">
          <td align="left"><a href="#"><img src="/img/cross_icon.png" width="15" id="date_picker"  class="DeleteBoxRow" ></a>
        <input class="dpick" type="text" id="dpick1" name="date[]"  style="width:86%; height: 33px; padding-left: 12px;"/>
        </td>
        <td align="center">
          <select class="form-control" name="staff_id[]" id="staff_id">
            <option value="">None</option>
        @if(!empty($staff_details))
          @foreach($staff_details as $key=>$staff_row)
            <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
          @endforeach
        @endif
        </select></td>
        <td align="center">
        <select class="form-control" name="rel_client_id[]" id="rel_client_id">
            <option value="">None</option>
          @if(isset($allClients) && count($allClients)>0)
            @foreach($allClients as $key=>$client_row)
            <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
            @endforeach
          @endif
                </select>
            </td>
                <td align="center">
                <div id="schemeDropRow">
                    <select class="form-control" name="vat_scheme_type[]" id="vat_scheme_type">
                    <option value="">None</option>
                    @if( isset($old_services) && count($old_services)>0 )
                      @foreach($old_services as $key=>$scheme_row)
                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                      @endforeach
                    @endif
                    @if( isset($new_services) && count($new_services)>0 )
                      @foreach($new_services as $key=>$scheme_row)
                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                      @endforeach
                    @endif
                    </select>
                </div>
                <div id="expenseDropRow">
                  <select class="form-control" name="expense_type[]" id="expense_type">
                    <option value="">None</option>
                    @if( isset($expense_types) && count($expense_types)>0 )
                      @foreach($expense_types as $key=>$scheme_row)
                        <option value="{{ $scheme_row['expense_id'] }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row['expense_id'])?"selected":"" }}>{{ $scheme_row['expense_type'] }}</option>
                      @endforeach
                    @endif
                    </select>
                </div>
                </td>
                <td align="center"><input type="text" name="hrs[]" id="hrs" size="5%" class="form-control"></td>
                
                <td align="center">
                    <a href="javascript:void(0)" class="btn btn-default openNotesPop" data-key="1"><span class="requ_t">Notes</span></a>  
                    <input type="hidden" class="notesPop" name="notes[]" id="notes1" >
                </td> 

                <td id="attachTd">
                    <span class="btn btn-default btn-file" style="width: 73px; height: 34px; float: left">
                    Browse <input type="file" name="attachment1" class="attachFile" id="attachment1" data-key="1">
                    </span>
                    <div id="attachDivPop1" class="attachDivPop" style="float: left; margin: 7px 0 0 5px;"></div>
                </td>
              </tr>
            </tbody>
          </table>
              </td>
            </tr>
          </table>
          <div class="save_btncon">
            <div class="left_side" id="addNewLineBut"><button class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p></button></div>
            <div class="right_side"> <a href="javascript:void(0)" class="btn btn-info" id="timeSheetSubmit">Submit</a></div>
            <div class="clearfix"></div>
            </div>
         
        </div>
        
        {{ Form::close() }}
    </div>
  </div>
</div>


<div class="modal fade" id="vatScheme-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-vat-scheme', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <input type="hidden" name="added_from" id="added_from" value="timesheet">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="vat_scheme_name" id="vat_scheme_name" placeholder="Service" class="form-control">
      </div>
       
      <div id="append_vat_scheme">
        @if( isset($old_services) && count($old_services) )
          @foreach($old_services as $key=>$scheme_row)
            <div class="form-group">
              <label for="{{ $scheme_row->service_name }}">{{ $scheme_row->service_name }}</label>
            </div>
          @endforeach
        @endif

        @if( isset($new_services) && count($new_services) )
          @foreach($new_services as $key=>$scheme_row)
            <div class="form-group" id="hide_vat_div_{{ $scheme_row->service_id }}">
              <a href="javascript:void(0)" title="Delete Field ?" class="delete_vat_scheme" data-field_id="{{ $scheme_row->service_id }}"><img src="/img/cross.png" width="12"></a>
              <label for="{{ $scheme_row->service_name }}">{{ $scheme_row->service_name }}</label>
            </div>
          @endforeach
        @endif
        </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-info pull-left save_t" id="add_vat_scheme" data-client_type="org" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
  </div>
</div>

<div class="modal fade" id="composenotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">
      <div class="modal-body">
      <button class="close" aria-hidden="true" data-dismiss="modal" type="button">&times;</button>
     
      <div style="width:100%;">
        <input type="hidden" name="NotesKey" id="NotesKey">
        <label for="f_name" style="font-size: 18px;">Notes</label>
        <textarea rows="4" cols="59"  name="notes1[]" id="notess" class="form-control" ></textarea>
        <button class="btn btn-info" onclick="return notes()" id="save_notes" style="margin-top: 15px; float: right;">Save</button>   
        <div class="clr"></div>       
       </div>
        </div>
    </div>
  </div>
</div>


<!-- View this pop up if we click on Completed in completed tasks tab in tasks-->
<div class="modal fade" id="viewTimeSheet-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:80%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">VIEW TIMESHEET</h4>
        <div class="clearfix"></div>
      </div>
      
      <div class="modal-body">
        <table class="table table-bordered table-hover dataTable" id="ViewTimesheetTable" width="100%">
          <thead>
            <tr>
              <th width="10%" align="center">Date</th>
              <th width="25%">Staff Name</strong></th>
              <th width="25%" align="center">Client Name</strong></th>
              <th width="20%" align="center">Service</th>
              <th width="10%" align="center">Hrs</th>
              <th width="10%" align="center">Notes</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="fontfetchcomposenotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    <div class="modal-content">
      <div class="modal-body">
        <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
        <div style="width:100%;">
          <label for="f_name" style="font-size: 18px;">Notes</label>
          <textarea rows="4" cols="59"  name="notes1[]" id="fontfetchnotess" value="" ></textarea>
          <div class="clr"></div>       
        </div>
      </div>
    </div>
  </div>
</div>