{{ Form::open(array('url' => '/template/edit-email-template', 'files' => true)) }}
<input type="hidden" name="edit_email_template_id" id="edit_email_template_id" value="{{ $emailTemplates->email_template_id or "" }}"> 
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit an email template</h4>
        <div class="clearfix"></div>
      </div>
    <form action="#" method="post">
      <div class="modal-body">
        <div class="form-group">
          <div class="input_box_g">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" id="edit_name" name="edit_name" value="{{ $emailTemplates->name or "" }}">
          </div>
                                
          <div class="input_dropdown">
              <label>Type</label>
              <select class="form-control" name="edit_template_type" id="edit_template_type" onChange="getTemplate(this.value)">
                <option>Select Template Type</option>
                @if(!empty($template_types))
                @foreach($template_types as $key=>$type_row)
                <option value="{{ $type_row->template_type_id }}" {{ (isset($emailTemplates->email_template_id) && ($emailTemplates->email_template_id == $type_row->template_type_id))?'selected':'' }}>{{ $type_row->template_type_name }}</option>
                @endforeach
                @endif
              </select>
          </div>
          <div class="clearfix"></div>      
        </div>

        <div class="form-group">
            <div class="input_box_g">
              <label for="exampleInputEmail1">Title</label>
              <input name="edit_title" id="edit_title" type="text" class="form-control" value="{{ $emailTemplates->title or "" }}">
            </div>
            <div class="input_dropdown">
                <label>Insert Placeholder</label>
                <select class="form-control">
                    <option>option 1</option>
                    <option>option 2</option>
                    <option>option 3</option>
                    <option>option 4</option>
                    <option>option 5</option>
                </select>
            </div>
          <div class="clearfix"></div>     
        </div>

        <div class="form-group">
            <textarea name="edit_message" id="edit_message" class="form-control" style="height: 250px;">{{ $emailTemplates->message or "" }}</textarea>
        </div>
      </div>
      <div class="modal-footer clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" name="save" id="save" class="btn btn-primary pull-left save_t">Save</button>
        </div>
      </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
{{ Form :: close() }}

