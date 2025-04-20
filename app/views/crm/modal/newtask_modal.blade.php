<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="edittaskcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="clearfix"></div>
      </div>
      {{ Form::open(array('url' => '/savetask', 'files' => true, 'id'=>'basicform')) }}
      <input type="hidden" name="page_open" value="{{ $page_open or '' }}">
      <input type="hidden" name="editrowid" id="editrowid" value="">
      <input type="hidden" name="redirect_url" id="redirect_url" value="{{$goto_url or ''}}/{{base64_encode('11')}}">
      <input type="hidden" name="added_from" id="added_from" value="{{$added_from or 'tasks'}}">
      <input type="hidden" name="editattacment" id="editattachmentfile" value="">

      <div class="modal-body" >
        <div class="loader_show"><!-- Show Loader --></div>
        <div class="error" id="editerrormsg" style="color: red; margin-left: 38px;"></div>
        <div class="success" id="editsuccessmsg" style="color:#0866c6;margin-left: 38px;font-size:18px;"></div>

        <div class="row content_part" style="padding: 0px 40px 20px 40px;">
          <div class="form-group">
            <div class="col-md-3"><strong class="actionType">Add New Task</strong></div>
            <div class="col-md-9">
              <span class="urgnt_con">Urgent?</span>
              <span class="rad_butt editurgent">
                <input type="radio" name="editurgent" value="Y" id="yess" /> Yes</span>
              <span class="rad_butt editurgent">
                <input type="radio" name="editurgent" value="N" id="noo" checked /> No</span>
            </div>
            <div class="clearfix"></div>
          </div>

          @if(isset($added_from) && $added_from == 'wip')
            <input type="hidden" name="is_billable" id="is_billable" value="Y">
          @else
          <div class="form-group">
            <div class="col-md-3"><strong>Billable</strong></div>
            <div class="col-md-9">
              <span class="rad_butt editurgent">
                <input type="radio" name="is_billable" value="Y" id="billYes" class="billable" /> Yes
              </span>
              <span class="rad_butt editurgent">
                <input type="radio" name="is_billable" value="N" id="billNo" class="billable" checked/> No
              </span>
            </div>
            <div class="clearfix"></div>
          </div>
          @endif

          <div class="form-group" id="billableEvent" style="display:{{(isset($added_from) && $added_from=='todo')?'none':'block'}}">
            <div class="col-md-3"><strong>Fee</strong></div>
            <div class="col-md-9">
              <input type="text" id="FeeAmount" name="amount" class="form-control" style="width: 40%">
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Task Name </strong></div>
            <div class="col-md-9">
              <input type="text" placeholder="" id="edittaskname" name="edittaskname" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Task Date </strong></div>
            <div class="col-md-9">
              <input type="text" value="<?= date('d-m-Y');?>" id="edittaskdate" name="edittaskdate" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Task Time </strong></div>
            <div class="col-md-9">
              <input type="text" value="<?= date('H:i');?>" id="edittask_time" name="edittask_time" class="form-control">
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Client Name</strong></div>
            <div class="col-md-9">
              <select class="form-control" name="rel_client_id_edit" id="rel_client_id_edit">
                <option value="">None</option>
                @if(isset($allClients) && count($allClients)>0)
                  @foreach($allClients as $key=>$client_row)
                    @if($client_row['client_name'] != "")
                      <option value="{{ $client_row['client_id'] }}">{{ $client_row['client_name'] }}</option>
                    @endif
                  @endforeach
                @endif
              </select>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Allocate to</strong></div>
            <div class="col-md-9">
              <select class="form-control" name="staff_id_edit" id="staff_id_edit">
                <option value="">Leave blank if own task</option>
                  @if(!empty($staff_details))
                    @foreach($staff_details as $key=>$staff_row)
                    <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                    @endforeach
                  @endif
                </select>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Note</strong></div>
            <div class="col-md-9" id="editnotesArea">
              <!-- <textarea rows="4" name="editnotes" id="notesid" class="form-control"></textarea> -->
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3"><strong>Attachment</strong></div>
            <div class="col-md-9">
              <input type="file" name="add_file_edit" id="add_file_edit" /></span>
              <p class="help-block" id="attachfilename"></p>
            </div>
            <div class="clearfix"></div>
          </div>

          <div class="form-group">
            <div class="col-md-3">&nbsp;</div>
            <div class="col-md-9">
              <div class="email_btns2" style="width:130px;">
                <button data-dismiss="modal" class="btn btn-danger pull-left save_t"  type="button">Cancel</button>
                <button  class="btn btn-info" id="editsavetaskbtn" name="save" type="submit">Save</button>
              </div>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    {{ Form :: close() }}
    </div>
  </div>
</div>