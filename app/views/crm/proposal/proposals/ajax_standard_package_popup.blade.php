<thead>
  <tr>
    <th >Package Name</th>
    <th style="text-align: center; width: 15%">Add Services</th>
    <th style="text-align: center; width: 15%">Package Type</th>
    <th style="text-align: center; width: 15%"><a href="javascript:void(0)" id="showArchive" class="showArchive" data-is_archive="show">Show Archive</a></th>
  </thead>

<tbody role="alert" aria-live="polite" aria-relevant="all">
@if(isset($tableHeadings) && count($tableHeadings) >0)
  @foreach($tableHeadings as $key=>$value)
    <tr id="change_status_tr_{{ $value['heading_id'] or "" }}" class="packageTr_{{ $value['heading_id']}} {{(isset($value['is_archive']) && $value['is_archive'] == 'Y')?'rowColor':'' }}">
      <td>
        <div style="float: left;" id="status_span{{$value['heading_id']}}">{{$value['heading_name'] or ""}}</div>
        <div style="float: right;">
          <!-- <a href="javascript:void(0)" class="viewTableServicePop" data-heading_id="{{ $value['heading_id'] or '' }}" data-heading_name="{{$value['heading_name'] or ''}}"><i class="fa fa-list tiny-icon"></i></a> -->
          
        </div>
      </td>

      <td align="center">
        <a href="javascript:void(0)" class="viewProposalServicePop" data-crm_proptbl_id="{{$value['crm_proptbl_id'] or ""}}" data-heading_name="{{$value['heading_name'] or ''}}" data-heading_id="{{$value['heading_id'] or ''}}" data-proposal_id="{{$value['proposal_id'] or ''}}" data-is_show="G"><i class="fa fa-list tiny-icon"></i></a>
      </td>

      <td align="center">
        {{ $value['package_name'] or '' }}
      </td>

      <td align="center">
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
              <li><a href="javascript:void(0)" class="delete_status" data-heading_id="{{ $value['heading_id']}}"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
              <li>
                <a href="javascript:void(0)" id="arcPackage_{{ $value['heading_id']}}" data-heading_id="{{ $value['heading_id']}}" class="arcPackage" data-update_value="{{($value['is_archive'] == 'Y')?'N':'Y' }}" data-event="{{($value['is_archive'] == 'Y')?'unarchive':'archive' }}"><i class="fa fa-edit tiny-icon"></i>{{($value['is_archive'] == 'Y')?'Un Archive':'Archive' }}</a>
              </li>
          </ul>
        </div>
      </td>
    </tr>
  @endforeach
@endif
</tbody>
ipractice