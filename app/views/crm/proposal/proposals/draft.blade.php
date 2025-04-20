<div id="tab_421" class="tab-pane active">
    <div class="nav-tabs-custom">
        <div class="tab-content">
<table class="table table-bordered table-striped table-hover" id="proposal_table" width="100%">
<thead>
    <tr>
        <th>Date</th>
        <th>Proposal ID</th>
        <th>Name</th>
        <th>Title</th>
        <th>Amount</th>
        <th>Status</th>
        <th width="5%">Action</th>
    </tr>
</thead>
<tbody>
@if(isset($draftProposals) && count($draftProposals)>0 )
    @foreach($draftProposals as $k=>$v)
    <tr>
        <td>{{ date('d-m-Y', strtotime($v['created'])) }}</td>
        <td>{{ $v['crm_proposal_id'] or '' }}</td>
        <td>{{ $v['prospect_name'] or '' }}</td>
        <td>{{ $v['proposal_title'] or '' }}</td>
        <td></td>
        <td></td>
        <td>
        <div class="btn-group">
            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                <li><a href="/"><i class="fa fa-eye tiny-icon"></i>Preview</a></li>
                <li><a href="/"><i class="fa fa-envelope"></i>Email</a></li>
                <li><a href="/"><i class="fa fa-download tiny-icon"></i>Download</a></li>
                <li><a href="/"><i class="fa fa-copy tiny-icon"></i>Copy</a></li>
                <li><a href="/"><i class="fa fa-edit tiny-icon"></i>Comments</a></li>
                <li><a href="/" ><i class="fa fa-file-text tiny-icon"></i>History</a></li>
                <li><a href="/" ><i class="fa fa-file-text tiny-icon"></i>Mark as Lost</a></li>
                <li><a href="/" class="delete" ><i class="fa fa-trash-o tiny-icon"></i>Mark as Acepted</a></li>
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