<!-- By PK -->

<div id="add_new_template_type_model" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content  col-md-8">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create New Template Type</h4>
      </div>
      <div class="modal-body">
			{{ Form::open(array('url' => 'template/type/add', 'id'=>'add_new_template_type_form', 'name'=>'add_new_template_type_form', 'class'=>'form')) }}
				<div class="form-group"> 
					{{Form::label('type_name', 'Type Name')}}
					{{Form::text('type_name', $value = null, $attributes = array('class'=>'type_name','id'=>'type_name'))}}
					{{Form::submit('Add')}}
					{{ Form::close() }}
		  		</div>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<script src="{{ URL :: asset('js/template_type.js') }}" type="text/javascript"></script>