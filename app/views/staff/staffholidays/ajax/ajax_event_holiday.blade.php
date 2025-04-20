<table border="0" style="width: 1400px;">
@if(!empty($staff_details))
    @foreach($staff_details as $key=>$value)
       <tr>
            @foreach ($value as $key1 => $value1)
             <td class="col-xs-3 position_none" style="width: 310px" valign="top">
                
                    @if(is_array($value1))
                        <div class="events_cont">
                        <ul class="event_ul">
                            @foreach ($value1 as $key2 => $value2)
                                <li>
                                    <div class="leave_box pull-left" style="background: #{{ isset($value2['color_code'])?$value2['color_code']:'' }};"></div> 
                                    <div class="text">{{ isset($value2['type_name'])?$value2['type_name']:'' }}</div><br>
                                    
                                    <div class="font_size"><strong>Time: </strong>{{ isset($value2['duration'])?$value2['duration']:'' }}</div>
                                </li>
                            @endforeach
                        </ul>
                        </div>
                    @else
                        @if($key == 0)
                            <div class="events_head">{{ $value1 or '' }}</div>
                        @else
                            <div class="events_cont">
                                <div class="events_head">{{ $value1 or '' }}</div>
                                <div class="clearfix"></div>
                            </div>
                        @endif
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
@endif

</table>