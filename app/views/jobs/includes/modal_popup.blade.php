<!-- Task related user pop up start -->
<div class="modal fade" id="openTaskPop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:600px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center"><a href="javascript:void(0)" id="ClientTitle" style="color: white;"></a></h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body" style="padding-bottom: 0px;">
        <div class="loader_show"></div>
        <table class="table table-bordered table-hover dataTable" width="100%" id="notificationTable">
            <tbody>
                <tr>
                    <th colspan="4">Notification Type</th>
                </tr>
                @if(isset($service_id) && $service_id != 4 && $service_id != 5 && $service_id != 6)
                <tr>
                    <td width="30%">Enable Deadline Reminders</td>
                    <!-- <td>
                    <div style="float: left; margin-right: 5px">Stop Reminders at </div>
                    <div style="float: left;  margin-right: 5px; width: 50%">
                      <select class="form-control newdropdown showStatusDrop">
                        <option>-- Select --</option>
                      </select>
                      </div>
                      <div style="float: left;">Stage</div>
                    </td> -->
                    <td width="22%">
                      <div style="float: left; margin-right: 20px" id="freqdata1">
                        <a href="javascript:void(0)" class="openFreqPop" data-value="1" data-freq_id="0">Add reminder message..</a>
                      </div>
                      <div class="left viewDelete">
                        <!-- <a href="javascript:void(0)" class="" data-value="1"><img src="/img/cross.png" height="12"></a> -->
                      </div>
                    </td>
                    <td width="9%">
                      <div class="custom_chk" style="float:left;">
                        <input type="checkbox" id="checkbox1" class="notification_check disable_click" value="1" data-is_notification="T"><label for='checkbox1' style="width:0!important">&nbsp;</label>
                      </div>
                      <div class="left">
                        <a href="javascript:void(0)" class="popupQuestionMsg1" data-value="1" title="Tick box will be enabled after adding and saving an email message. If ticked deadline reminder messages will be sent to the client on a periodic basis anytime jobs are moved to the task management section to be worked on.">
                          <img src="/img/question_frame.png" height="15">
                        </a>
                      </div>

                      <div class="red_box"></div>
                    </td>
                </tr>
                @endif
                <tr>
                    <td>Enable Client Task Status Notification</td>
                    <!-- <td>
                    <div style="float: left; margin-right: 5px">Start Notification at </div>
                    <div style="float: left;  margin-right: 5px; width: 50%">
                      <select class="form-control newdropdown showStatusDrop">
                        <option>-- Select --</option>
                      </select>
                      </div>
                      <div style="float: left;">Stage</div>
                    </td> -->
                    <td>
                      <div style="float: left; margin-right: 20px" id="freqdata2">
                        <a href="javascript:void(0)" class="openFreqPop" data-value="2" data-freq_id="0">Add emails addresses..</a>
                      </div>
                    </td>
                    <td>
                    <div class="custom_chk" style="float: left;">
                      <input type="checkbox" id="checkbox2" class="notification_check disable_click" value="2" data-is_notification="T"><label for='checkbox2' style="width:0!important">&nbsp;</label>
                    </div>
                    <div class="left">
                      <a href="javascript:void(0)" class="popupQuestionMsg1" data-value="2" title="Tick box will be enabled after adding an email address. If ticked task status notifications messages will be sent to the client anytime the task status for jobs are changed in the task management section.">
                        <img src="/img/question_frame.png" height="15">
                      </a>
                    </div>
                    <div class="blue_box"></div>
                    <!-- <input type="checkbox" id="checkbox2" class="notification_check" value="2" data-is_notification="T"> -->
                    </td>
                </tr>
                <!-- <tr>
                    <th colspan="4">Notification Emails</th>
                </tr> -->
                
            </tbody>
        </table>
        <div class="clearfix"></div>
      </div>

      <!-- <div class="modal-footer clearfix" style="margin-top: 0px;">
        <div style="text-align: center;">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" id="save_completion_popup">Save</button>
        </div>
      </div> -->
    
    </div>
  </div>
</div>

<div class="modal fade" id="editEmail-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center"><a href="javascript:void(0)" id="ClientTitle"></a></h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
          <input type="hidden" name="editClientId" id="editClientId">
          <input type="hidden" name="PopEmailType" id="PopEmailType">
        <div class="loader_show"></div>
        <table class="table table-bordered table-hover dataTable" width="100%" id="notificationTable">
            <tbody>
                <tr>
                    <td>Email</td>
                    <td><input type="text" id="PopEmail" name="PopEmail" class="form-control"></td>
                </tr>
            </tbody>
        </table>
        <div class="clearfix"></div>
      </div>

      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" id="save_email_popup" class="btn btn-info pull-left save_t2">Save</button>
        </div>
      </div>
    
    </div>
  </div>
</div>
<!-- Task related user pop up end -->

<!-- Task related user pop up start -->
<div class="modal fade" id="clockPop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:450px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center"><a href="javascript:void(0)"><img src="/img/icon_clock.png" height="32" style="margin-right: 5px;"><span style="color: #00c0ef; margin-top: 5px; font-size: 20px;">Client Reminders!</span></a></h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="loader_show">To setup individual reminders, click on the client's name in the table</div>
        <table  width="100%">
            <tr>
                <th style="height: 40px;">Enable Deadline Reminders for all Clients</th>
                <th width="10%"><input type="checkbox" class="global_reminder" id="global_reminder1" value="1"></th>
            </tr>
            <tr>
                <th style="height: 20px;">Enable Client Task Status Notification for all Clients</th>
                <th width="10%"><input type="checkbox" class="global_reminder" id="global_reminder2" value="2"></th>
            </tr>
        </table>
        <div class="clearfix"></div>
      </div>
        
      <div class="modal-footer">
        
      </div>

    </div>
  </div>
</div>        
<!-- Task related user pop up end -->

<!-- Tasks View reminder message popup start -->
<div class="modal fade" id="openFreqPop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header" style="background:#0866c6; color: white;">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">DEADLINE REMINDER EMAIL</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="loader_show"></div>
        <input type="hidden" id="freq_id" name="freq_id" value="" />
        <input type="hidden" id="position" name="position" value="" />
        <div class="form-group">
          Please note that the first email will be sent when task is first sent to the task management tab
        </div>
        <div class="form-group">
          <table width="100%">
            <tr>
                <td style="width: 12%">Repeat Every </td>
                <td width="7%"><input type="text" id="repeat_every" name="repeat_every" class="form-control" style="width:85%"></td>
                <td style="width: 10%;">Day(s)</td>
                <td style="width: 31%;">
                <select class="form-control newdropdown" name="stop_reminder" id="stop_reminder">
                  <option value="">-- Stop reminders at --</option>
                  @if(isset($jobs_steps) && count($jobs_steps) >0)
                    @foreach($jobs_steps as $key=>$v)
                      <option value="{{ $v['step_id'] or "" }}">{{ $v['title'] or "" }}</option>
                    @endforeach
                  @endif 
                </select>
                </td>
                <td style="width: 63%"></td>
            </tr>
          </table>
        </div>
        <div class="clearfix"></div>

        <div class="form-group">
          <div class="col-md-6" style="padding-left:0px;">
            <input type="text" class="form-control" name="resp_email" id="resp_email" placeholder="eg abc@me.com;efd@mine.com" >
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <div class="col-md-6" style="padding-left: 0px;">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Message Subject" >
          </div>
          <div class="col-md-6">
            <a href="javascript:void(0)" style="text-decoration: underline">Insert Placeholder <i class="caret"></i></a>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <textarea class="form-control" name="frequency_message" id="frequency_message"></textarea>
        </div>


      </div>

      <div class="modal-footer" style="border-top:none; padding-top: 0; margin-top: 0px;">
        <div style="text-align: center;">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="button" id="saveFreqPop" class="btn btn-info">Save</button>
        </div>
      </div>
    
    </div>
  </div>
</div>

<!-- Tasks E-Reminder popup start -->
<div class="modal fade" id="sendChaserEmail-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <div class="modal-header" style="background:#0866c6; color: white;">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">CHASER EMAIL</h4>
        <div class="clearfix"></div>
      </div>
      <!-- <form method="post" action="/jobs/tasks-action" id="chaser_form"> -->
      <div class="modal-body">
        <div class="loader_show"></div>
        <input type="hidden" id="chaser_id" name="chaser_id" value="0" />
        <input type="hidden" id="action" name="action" value="saveChaserDetails" />
        <div class="form-group">
          Please note that the first email will be sent when task is first sent to the task management tab
        </div>
        <div class="form-group">
          <table width="100%">
            <tr>
                <td style="width: 12%">Repeat Every </td>
                <td width="7%"><input type="text" id="chaser_every" name="chaser_every" class="form-control" style="width:85%"></td>
                <td style="width: 10%;">Day(s)</td>
                <td style="width: 19%;"><input type="text" class="form-control chaserStopCheck" placeholder="Stop Email" id="stop_date" name="stop_date"></td>
                <!-- <td style="width: 10%;">Stop Email</td>
                <td style="width: 21%;"><input type="checkbox" class="chaserStopCheck" value="Y"></td> -->
                <td style="width: 63%"></td>
            </tr>
          </table>
        </div>
        <div class="clearfix"></div>

        <div class="form-group">
          <div class="col-md-12" style="padding-left:0px;">
            <input type="text" class="form-control" name="chaser_email" id="chaser_email" placeholder="eg abc@me.com;efd@mine.com" >
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <div class="col-md-6" style="padding-left: 0px;">
            <input type="text" class="form-control" name="chaser_subject" id="chaser_subject" placeholder="Message Subject" >
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <textarea class="form-control" name="chaser_message" id="chaser_message"></textarea>
        </div>

      </div>

      <div class="modal-footer" style="border-top:none; padding-top: 0; margin-top: 0px;">
        <div style="text-align: center;">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="button" id="sendChaserEmail" class="btn btn-info">Send</button>
        </div>
      </div>
      <!-- </form> -->
    </div>
  </div>
</div>


<!-- Add new todo pop up -->
<div class="modal fade" id="edittaskcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:625px;">
    <div class="modal-content" >
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <!-- <h4 class="modal-title">FREQUENCY</h4> -->
        <div class="clearfix"></div>
      </div>
      <!-- <form action="#" method="post"> -->
      {{ Form::open(array('url' => '/savetask', 'files' => true, 'id'=>'basicform')) }}
      <input type="hidden" name="page_open" value="{{ $page_open }}">
      <input type="hidden" name="editrowid" id="editrowid" value="">
      <input type="hidden" name="redirect_url" id="redirect_url" value="{{ $goto_url }}/{{ $encode_page_open }}/{{ $encode_staff_id }}">
      <input type="hidden" name="added_from" id="added_from" value="tasks">

        <div class="modal-body" >
          <div class="loader_show"><!-- Show Loader --></div>
          <div class="error" id="editerrormsg" style="color: red;"></div>
          <div class="success" id="editsuccessmsg" style="color: #0866c6; font-size: 18px;"></div>

          <div style="padding: 0px 15px 15px 15px;" class="content_part">
            <table width="100%" border="0">
              <tr>
                <td width="25%"><strong>Add New Task</strong></td>
                <td>
                    <span class="urgnt_con">Urgent?</span>
                    <span class="rad_butt editurgent">
                      <input type="radio" name="editurgent" value="Yes" id="yess"  /> Yes</span>
                    <span class="rad_butt editurgent"><input type="radio" name="editurgent" value="No" id="noo" checked  /> No</span>
                </td>
              </tr>
              <tr><td>&nbsp;</td></tr>

              <tr>
                <td width="25%"> <strong>Task Name </strong></td>
                <td><input type="text" id="edittaskname" name="edittaskname" class="form-control"></td>
              </tr>
              
              <tr><td>&nbsp;</td></tr>
              
              <tr>
                <td><strong>Task Date </strong></td>
                <td><input type="text" id="edittaskdate" name="edittaskdate" class="form-control"></td>
                </tr>

                <tr>
                  <td>&nbsp;</td>
                </tr>

                <tr>
                  <td><strong>Task Time </strong></td>
                  <td><input type="text" id="edittask_time" name="edittask_time" class="form-control"></td>
                </tr>

                <tr>
                  <td>&nbsp;</td>
                </tr>

                <tr>
                  <td><strong>Client Name </strong></td>
                  <td>
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
                  </td>
                </tr>

                <tr>
                  <td>&nbsp;</td>
                </tr>

                <tr>
                  <td><strong>Allocate to </strong></td>
                  <td><select class="form-control" name="staff_id_edit" id="staff_id_edit">
                    <option value="">Leave blank if own task</option>
                      @if(!empty($staff_details))
                        @foreach($staff_details as $key=>$staff_row)
                        <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                        @endforeach
                      @endif
                    </select>
                  </td>
                </tr>

                <tr>
                  <td>&nbsp;</td>
                </tr>

                <tr>
                  <td><strong>Note </strong></td>
                  <td><textarea rows="5" cols="30" name="editnotes" id="notesid" class="form-control"></textarea></td>
                </tr>
            </table>

          <input type="hidden" name="editattacment" id="editattachmentfile" value="">
          <div class="save_btncon">
            <div class="left_side">
              <span class="urgnt_con">Attachment</span>
              <span ><input type="file" name="add_file_edit" id="add_file_edit" /></span>
              <p class="help-block" id="attachfilename"></p>
              <div class="clr"></div>
            </div>
            <div class="email_btns2" style="width:130px;">
              <button data-dismiss="modal" class="btn btn-danger pull-left save_t"  type="button">Cancel</button>
              <button  class="btn btn-info" id="editsavetaskbtn" name="save" type="submit">Save</button>
            </div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    {{ Form :: close() }}
  <!--    </form> -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="deadline_date-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add Single Deadline Date</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/jobs/save-job-account-details')) }}
      <div class="modal-body">
        <input type="hidden" name="deadClientId" id="deadClientId">
        <input type="hidden" name="CustomField" id="CustomField">
        <div class="loader_show"></div>
        <div id="DeadlineDateDiv">
          <div class="form-group">
            <label for="exampleInputPassword1">Job Frequency</label>
            <select id="JobReturnDt" name="JobReturnDt" class="form-control">
              <option value="">Choose One</option>
              <option value="Monthly">Monthly</option>
              <option value="Quarterly">Quarterly</option>
              <option value="Yearly">Yearly</option>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Date</label>
            <input type="text" id="DeadlineDate" name="DeadlineDate" class="form-control">
          </div>
        </div>
        

        <div class="form-group" id="JobNameDiv">
          <label for="exampleInputPassword1">Name</label>
          <input type="text" id="JobName" name="JobName" class="form-control">
        </div>
        <div class="clearfix"></div>
      </div>

      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" id="save_deadline_popup" class="btn btn-info pull-left save_t2">Save</button>
        </div>
      </div>
    {{ Form :: close() }}
    </div>
  </div>
</div>


<div class="modal fade" id="openTasksEmailPop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to list</h4>
        <div class="clearfix"></div>
      </div>

      <div class="modal-body">
        <input type="hidden" id="taskClientId">
        <div class="loader_show"></div>
        <div class="form-group">
          <div class="col-md-9">
            <input type="text" id="popTasksEmail" name="popTasksEmail" class="form-control" placeholder="Add new email address">
          </div>
          <div class="col-md-3">
            <button type="button" id="saveTasksEmail" class="btn btn-info">Save</button>
          </div>
          <div class="clearfix"></div>
        </div>

        <div id="openTasksEmailBody"></div>

      </div>
    </div>
  </div>
</div>