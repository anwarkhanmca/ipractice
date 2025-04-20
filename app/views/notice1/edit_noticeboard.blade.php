 <div class="modal fade" id="compose-modal1" tabindex="-1" role="dialog" aria-hidden="true">


{{ Form::open(array('url' => '/edit-notice-template', 'files' => true)) }}

<input type="hidden" name="edit_notice_template_id" id="edit_notice_template_id" value=""> 
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Notice</h4>
        <div class="clearfix"></div>
      </div>
    <form action="#" method="post">
      <div class="modal-body">
        <div class="form-group">
          
                                
       
          <div class="clearfix"></div>      
        </div>


<div class="input_dropdown" id="type_dropdown">
             <!-- <label>Type</label>
              <select class="form-control" name="typecatagory[]" id="typecatagory1" >
                <option value="P">Postal</option>
              <option value="B">Board</option>
              
              </select> -->
          </div>
        <div class="form-group">
            <div class="input_box_g">
              <label for="exampleInputEmail1">Subject</label>
              <input name="message_subject" id="message_subject1" type="text" class="form-control" value="">
            </div>
           
          <div class="clearfix"></div>     
        </div>

        <div class="form-group">
            <textarea name="edit_message" id="edit_message1" class="form-control" style="height: 250px;"></textarea>
        </div>
        <div class="twobox_1">
<i class="fa fa-attach"></i> Attachment
<input type="file" name="edit_attach_file" id="edit_attach_file1" />
<div id="att"> </div>
</div>
      </div>
      <div class="modal-footer clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" name="save" id="save1" class="btn btn-primary pull-left save_t">Save</button>
        </div>
      </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
{{ Form :: close() }}

