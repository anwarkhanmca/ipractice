<tr>
    <td class="col-xs-7">
        <div class="events_head">Services</div>
    </td>
    <td class="col-xs-5" style="text-align: center;">
        <div class="events_head">Outstanding Jobs</div>
    </td>
</tr>
@if(!empty($services))
    @foreach($services as $key=>$value)
        <tr>
            <td class="col-xs-7">
                <div class="events_cont">
                    {{ $value['service_name'] or '' }}
                    <div class="clearfix"></div>
                </div>
            </td>
            <td class="col-xs-5" align="center">
                <div class="events_cont">
                    <a href="javascript:void(0)" class="showTasks" data-service_id="{{ $value['service_id'] or '' }}" data-status="{{ $value['status'] or '' }}">Click here</a>
                    <div class="clearfix"></div>
                </div>
                
            </td>
        </tr>
    @endforeach
@endif