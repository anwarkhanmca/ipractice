<select class="form-control" name="edit_rel_type_id" id="edit_rel_type_id">
@if(!empty($relationship))
@foreach($relationship as $key=>$type_row)
<option value="{{ $type_row->relation_type_id }}" {{ (isset($relation_type) && ($relation_type == $type_row->relation_type))?'selected':'' }}>{{ $type_row->relation_type }}</option>
@endforeach
@endif
</select>

              