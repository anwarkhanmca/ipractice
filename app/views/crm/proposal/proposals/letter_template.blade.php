<div id="tab_4341" class="tab-pane  {{ (isset($tab_level) && ($tab_level == '4341'))?'active':'' }}">
    <div class="nav-tabs-custom">
        <div class="pageHead">LETTER TEMPLATE</div>
        <div class="tab-content">

            <table class="table table-bordered table-striped table-hover" id="letterTemplate" width="100%">
                <thead>
                    <tr>
                        <th width="15%" align="center">Date</th>
                        <th width="15%" align="center">Created By</th>
                        <th>Title</th>
                        <th width="5%">Action</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($templates) && count($templates) >0)
                    @foreach($templates as $k=>$v)
                    <tr class="ptempTr_{{ $v['template_id'] or '' }}">
                        <td>{{ $v['created'] or '' }}</td>
                        <td>{{ $v['user_name'] or '' }}</td>
                        <td>{{ $v['title'] or '' }}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i><span class="caret"></span></button>
                                <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                    <li><a href="javascript:void(0)" data-template_id="{{ $v['template_id'] or '' }}" class="viewTemp"><i class="fa fa-files-o"></i>View</a></li>
                                    <li><a href="javascript:void(0)" data-template_id="{{ $v['template_id'] or '' }}" class="deleteTemp"><i class="fa fa-trash-o"></i>Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
