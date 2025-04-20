<tr>
    <td class="col-xs-2">
        <div class="events_head">Name</div>
    </td>
    <td class="col-xs-3">
        <div class="events_head">{{ $heading['prev_date'] or '' }}</div>
    </td>
    <td class="col-xs-3">
        <div class="events_head">{{ $heading['main_date'] or '' }}</div>
    </td>
    <td class="col-xs-3">
        <div class="events_head">{{ $heading['next_date'] or '' }}</div>
    </td>
</tr>
@if(!empty($events))
    @foreach($events as $key=>$value)
        <tr>
            <td class="col-xs-2" valign="top">
                <div class="events_cont"> {{ $value['staff_name'] or '' }}
                    <div class="clearfix"></div>
                </div>
            </td>
            <td class="col-xs-3" valign="top">
                <div class="events_cont">
                    <ul class="event_ul">
                    @if(!empty($value['prev_events']))
                        @foreach($value['prev_events'] as $key1=>$value1)
                        <li>
                            <div class="leave_box pull-left" style="background: #{{ isset($value1['color_code'])?$value1['color_code']:'' }};"></div> 
                            <div class="text">{{ isset($value1['type_name'])?$value1['type_name']:'' }}</div><br>
                            
                            <div class="font_size"><strong>Time: </strong>{{ isset($value1['duration'])?$value1['duration']:'' }}</div>
                        </li>
                        @endforeach
                    @endif
                    </ul>
                </div>
            </td>
            <td class="col-xs-3" valign="top">
                <div class="events_cont">
                    <ul class="event_ul">
                    @if(isset($value['main_events']) && count($value['main_events']) >0)
                        @foreach ($value['main_events'] as $key2 => $value2)
                            <li>
                                <div class="leave_box pull-left" style="background: #{{ isset($value2['color_code'])?$value2['color_code']:'' }};"></div> 
                                <div class="text">{{ isset($value2['type_name'])?$value2['type_name']:'' }}</div><br>
                                
                                <div class="font_size"><strong>Time: </strong>{{ isset($value2['duration'])?$value2['duration']:'' }}</div>
                            </li>
                        @endforeach
                    @endif
                    </ul>
                </div>
            </td>
            <td class="col-xs-3" valign="top">
                <div class="events_cont">
                    <ul class="event_ul">
                    @if(!empty($value['next_events']))
                        @foreach ($value['next_events'] as $key3 => $value3)
                            <li>
                                <div class="leave_box pull-left" style="background: #{{ isset($value3['color_code'])?$value3['color_code']:'' }};"></div> 
                                <div class="text">{{ isset($value3['type_name'])?$value3['type_name']:'' }}</div><br>
                                
                                <div class="font_size"><strong>Time: </strong>{{ isset($value3['duration'])?$value3['duration']:'' }}</div>
                            </li>
                        @endforeach
                    @endif
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
@endif