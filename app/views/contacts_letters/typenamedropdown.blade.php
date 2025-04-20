@if(isset($data) && count($data) >0)
         <select class="form-control">
                @foreach($data as $key=>$name_row)
                  <option value="{{ $name_row->email_template_id}}">{{ $name_row->name }}</option>
                  @endforeach
         </select>
  @endif