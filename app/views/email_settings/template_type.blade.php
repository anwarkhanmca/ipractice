<option>Select Template Type</option>
@if(!empty($template_types))
@foreach($template_types as $key=>$type_row)
<option value="{{ $type_row->template_type_id }}" {{ (isset($template_type_id) && ($template_type_id == $type_row->template_type_id))?'selected':'' }}>{{ $type_row->template_type_name }}</option>
@endforeach
@endif

              