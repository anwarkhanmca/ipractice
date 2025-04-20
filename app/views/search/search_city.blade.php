
@if(!empty($city_lists) && count($city_lists) > 0)
    @foreach($city_lists as $key=>$city_row)
    	<li id="{{ $city_row->state_id }}" onclick="ajaxGetState('{{ $city_row->city_id }}', '{{ $city_row->state_id }}', '{{ $city_row->city_name }}', '{{ $div_id }}')"><a href="javascript:void(0)">{{ $city_row->city_name }}</a></li>
    @endforeach
@else
<li>No result found...</li>
@endif
