<!-- By PK -->

<!-- COMPOSE MESSAGE MODAL -->
{{ Form::open(array('url' => '/placeholder/add', 'files' => true)) }}
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add an email template</h4>
        <div class="clearfix"></div>
      </div>
    <form action="{{url('/email/template/add')}}" method="POST">
      <div class="modal-body">
		  <input type="hidden" name="template_id" id="template_id" value="">
        <div class="form-group">
          <div class="input_box_g">
            <label for="">Template Name</label>
            <input type="text" class="form-control" name="template_name" id="template_name" placeholder="Template Name">
          </div>
                                
          <div class="input_dropdown">
			  <label>Type <a href="javascript:void(0);" data-baseurl="{{url()}}" id="add_new_template_type" >Add New</a> </label>
              <select class="form-control" name="template_type" id="template_type" >
                <option>Select Template Type</option>
               
                @if(!empty($template_types))
					@foreach($template_types as $key=>$type_row)
						<option value="{{ $type_row->template_type_id }}" >{{ $type_row->template_type_name }}</option>
					@endforeach
                @endif
				  
              </select>
          </div>
          <div class="clearfix"></div>      
        </div>

        <div class="form-group">
            <div class="input_box_g">
              <label for="template_subject">Message Subject</label>
              <input name="template_subject" id="template_subject" type="text" class="form-control" placeholder="Message Subject">
            </div>
            <div class="input_dropdown">
                <label>Insert Placeholder</label>
                <select class="form-control" id="getPlaceholder">
					<optgroup label="Modules">
						<option value="">Select Placeholder</option>
						<?PHP $module=''; ?>
					@if( isset($placeholders) && count($placeholders)>0 )
						@foreach($placeholders as $k => $placeholder)
							@if($placeholder->module != $module )
								<?PHP $module = $placeholder->module; ?>
								</optgroup>
								<optgroup label="{{$module}}">
							@endif
								<option value="[{{$placeholder->table}}.{{$placeholder->field}}]"> {{$placeholder->field}} </option>	
						@endforeach
							</optgroup>
					@endif
                </select>
            </div>
          <div class="clearfix"></div>     
        </div>
		
		  <div class="form-group">
			  <label for="placeHolder">Copy this Placeholder and Paste</label>
              <input name="placeHolder" id="placeHolder" type="text" class="form-control">
		  </div>
		  
        <div class="form-group">
            <textarea name="template_message" id="template_message" class="form-control" placeholder="Message" style="height: 250px;"></textarea>
        </div>
        
      </div>
      <div class="modal-footer clearfix">
        <div class="email_btns2">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="submit" name="save" id="save" class="btn btn-primary pull-left save_t">Save</button>
        </div>
      </div>
    </form>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
{{ Form :: close() }}




