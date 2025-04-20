@if(!empty($staff_details))
    @foreach($staff_details as $key=>$staff_row)
        <div class="col-xs-3 position_none">
            <div class="events_cont">
                <div class="events_head">{{ ucwords(strtolower($staff_row['staff_name'])) }}</div>
                <div class="clearfix"></div>
            </div>
            @if(isset($staff_row['events']) && count($staff_row['events']) >0)
    			@foreach($staff_row['events'] as $key=>$event_row)
		            <ul class="event_ul" data-id="{{ $event_row['id'] }}">
		                <li>
		                    <div class="font_size underline"><strong>Date: </strong>{{ $event_row['date_show'] or '' }}</div>
		                    <div class="ann_leave pull-left" style="background:#{{ $event_row['color_code'] }};"></div> 
		                    <div class="text">{{ $event_row['type_name'] or '' }}</div><br>
		                    
		                    <div class="font_size"><strong>Time: </strong>{{ $event_row['duration'] or '' }}</div>
		                </li>
		            </ul>
		        @endforeach
		    @endif
        </div>
    @endforeach
@endif