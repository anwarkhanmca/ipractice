<thead>
  <tr>
    <th style="text-align: center; width: 15%">Select Package</th>
    <th style="text-align: center; width: 15%">Group Packages</th>
    <th >Package Name</th>
    <th style="text-align: center; width: 15%">Add Services</th>
    <th style="text-align: center; width: 15%">Package Type</th>
    <th style="text-align: center; width: 15%"><a href="javascript:void(0)" id="packages_modal" class="packages_modal" data-is_archive="show">Show Archive</a></th>
  </thead>

<tbody role="alert" aria-live="polite" aria-relevant="all">

@if(isset($tableHeadings) && count($tableHeadings) >0)
  @foreach($tableHeadings as $key=>$value)
    <tr id="change_status_tr_{{ $value['heading_id'] or "" }}" class="packageTr_{{ $value['heading_id']}} {{(isset($value['is_archive']) && $value['is_archive'] == 'Y')?'rowColor':'' }}">
      <td align="center"><span class="custom_chk">
        <input type="checkbox" name="step_check_2{{ $value['heading_id']}}" id="step_check_3{{ $value['heading_id']}}" class="heading_check" {{ (isset($value['separate_table']) && $value['separate_table'] == 'Y')?"checked":"" }} value="{{ $value['heading_id'] or "" }}" data-heading_id="{{ $value['heading_id'] }}" data-is_show="O" /><label style="width:0px!important" for="step_check_3{{ $value['heading_id'] or "" }}">&nbsp;</label></span>
      </td>
      
      <td align="center"><span class="custom_chk">
        <input type="checkbox" name="step_check_2{{ $value['heading_id']}}" id="step_check_2{{ $value['heading_id']}}" class="heading_check" {{ (isset($value['group_table']) && $value['group_table'] == 'Y')?"checked":"" }} value="{{ $value['heading_id'] or "" }}" data-heading_id="{{ $value['heading_id'] }}" data-is_show="G" {{ (isset($value['separate_table']) && $value['separate_table'] == 'Y')?"":"disabled" }}/><label style="width:0px!important" for="step_check_2{{ $value['heading_id'] or '' }}">&nbsp;</label></span>
      </td>

      <td>
        <span id="status_span{{$value['heading_id'] or ""}}">{{$value['heading_name'] or ""}}</span>
      </td>

      <td align="center">
        <a href="javascript:void(0)" class="viewProposalServicePop" data-crm_proptbl_id="{{$value['crm_proptbl_id'] or ""}}" data-heading_name="{{$value['heading_name'] or ''}}" data-heading_id="{{$value['heading_id'] or ''}}" data-proposal_id="{{$value['proposal_id'] or ''}}" data-is_show="G"><i class="fa fa-list tiny-icon"></i></a>
      </td>

      <td align="center">
        {{ $value['package_name'] or '' }}
      </td>

      <td align="center">
        <!-- <span id="action_{{ $value['heading_id'] or "" }}"><a href="javascript:void(0)" class="edit_status" data-heading_id="{{ $value['heading_id'] or "" }}"><img src="/img/edit_icon.png"></a> 
        <a href="javascript:void(0)" class="delete_status" data-heading_id="{{ $value['heading_id'] or "" }}"><img src="/img/cross.png" height="12"></a>
        </span> -->
        <div class="btn-group">
          <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
              <li><a href="javascript:void(0)" class="delete_status" data-heading_id="{{ $value['heading_id']}}"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
              <li>
                <a href="javascript:void(0)" id="arcPackage_{{ $value['heading_id']}}" data-heading_id="{{ $value['heading_id']}}" class="arcPackage" data-update_value="{{($value['is_archive'] == 'Y')?'N':'Y' }}" data-event="{{($value['is_archive'] == 'Y')?'unarchive':'archive' }}"><i class="fa fa-edit tiny-icon"></i>{{($value['is_archive'] == 'Y')?'Un Archive':'Archive' }}</a>

                <!-- <a href="javascript:void(0)" id="arcAttachment_4" data-attachment_id="4" class="arcAttachment" data-update_value="N" data-event="unarchive"><i class="fa fa-edit tiny-icon"></i>Un Archive</a> -->

              </li>
          </ul>
        </div>
      </td>
    </tr>
  @endforeach
@endif
</tbody>