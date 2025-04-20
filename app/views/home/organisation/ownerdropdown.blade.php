@if(isset($date_g))
 {{$date_g or ""}}|||
 @endif 

<select class="form-control newdropdown status_dropdown" name="owner[]" id="owner">

    			
                	<option value="">None</option>
    					@if(!empty($data))
                  @foreach($data as $key=>$staff_row)
                  <option value="{{ $staff_row['owner_id'] }}_{{ $staff_row['contact_type'] }}">{{ ucwords($staff_row['name']) }}</option>
                  @endforeach
                @endif
                      
                       </select>