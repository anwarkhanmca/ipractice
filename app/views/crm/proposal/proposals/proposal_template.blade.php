<div id="tab_4342" class="tab-pane  {{ (isset($tab_level) && ($tab_level == '4342'))?'active':'' }}">
    
    <table class="table table-bordered table-striped table-hover" id="proposalTemplate" width="100%">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Title</th>
                <th width="8%" style="text-align: center;">Amount</th>
                <th width="5%">Action</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($details['templates']) && count($details['templates']) >0)
                @foreach($details['templates'] as $k=>$v)
                <tr class="FiNalTableTr_{{ $v['crm_proposal_id'] or '' }}">
                    <td>{{ date('d-m-Y', strtotime($v['created'])) }}</td>
                    <td>{{ ($v['contact_type'] == 'template')?$v['template_name']:'Template - [ '.$v['prospect_name'].' ]' }}</td>
                    <td>{{ $v['proposal_title'] or '' }}</td>
                    <td align="right">{{ number_format($v['fees'], 2) }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                                <li><a href="/proposal/edit-proposal/{{$v['crm_proposal_id'] or ''}}/{{ ($v['contact_type'] == 'template')?'template':'proposal'}}"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>
                                <li><a href="javascript:void(0)" class="copyProposal" data-crm_proposal_id="{{ $v['crm_proposal_id'] or ''}}" data-from_page="{{ ($v['contact_type'] == 'template')?'template':'proposal'}}"><i class="fa fa-copy tiny-icon"></i>Copy</a></li>
                                <li><a href="javascript:void(0)" id="deleteProposalFinal" data-proposal_id="{{ $v['crm_proposal_id'] or '' }}" ><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
        

</div>