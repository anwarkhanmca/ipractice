

<div class="modal fade" id="contact_report-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div  style="border: 3px solid #00acd6; margin: 20px;">
        <div class="modal-header" style="border-bottom: none;">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="contact_title">Report a Problem</h4>
          <div class="clearfix"></div>
        </div>
        <div style="background-color: #e5e5e5; height: 2px; width: 96%; margin-left: 13px"></div>
        <!-- {{ Form::open(array('url' => '/save-details', 'id'=>'contact_form')) }} -->
        <form method="post" id="contact_form" action="/save-details">
        <input type="hidden" id="msg_type" name="msg_type" value="" />
        <input type="hidden" name="back_url" id="back_url" value="" />
        <div class="show_loader"></div>
        <div class="modal-body" id="modalBody">
            <div class="col-md-4">
              <label for="exampleInputPassword1">Email</label>
              <input type="text" id="field_email" name="field_email" class="form-control">
            </div>
            <div class="col-md-4">
              <label for="exampleInputPassword1">Name</label>
              <input type="text" id="field_name" name="field_name" class="form-control">
            </div>
            <div class="col-md-4">
              <label for="exampleInputPassword1">Phone</label>
              <input type="text" id="field_phone" name="field_phone" class="form-control">
            </div>

          <div class="col-md-12">
            <label for="exampleInputPassword1">Subject</label>
            <input type="text" id="field_subject" name="field_subject" class="form-control">
          </div>
          <div class="col-md-12">
            <label for="exampleInputPassword1">Description</label>
            <textarea class="form-control" cols="40" rows="3" name="field_desc" id="field_desc"></textarea>
          </div>
          <div class="col-md-12">
            <div class="file_border">
              <label for="exampleInputPassword1">Attach File</label>
              <input type="file" name="add_file" id="add_file">
            </div>
          </div>
          
          <div class="modal-footer" style="border-top: none; padding-right: 13px;">
            <div class="email_btns">
              <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button> -->
              <button type="button" class="btn btn-info save_contact_form" name="save">Send</button>
            </div>
          </div>
        </div>
      </div>
    </form>
    </div>
  </div>
</div>