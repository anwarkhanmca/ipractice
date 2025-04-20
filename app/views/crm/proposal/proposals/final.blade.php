<div id="tab_42" class="tab-pane {{ (isset($tab_level) && ($tab_level == '42'))?'active':'' }}">

  <div class="row">
    <div class="col-xs-12">
      <div class="col_m2">
        <div class="row bottom_space">
          <div class="col-xs-offset-6 col-xs-6">
            <div id="example2_filter" class="dataTables_filter">
              <form>
                <input type="text" name="proposalListSearchText" id="proposalListSearchText" placeholder="Search" class="tableSearch" />
                <button type="submit" id="proposalListSearchButton" style="display:none;">Search</button>
              </form>
            </div>
          </div>
        </div>
        <div id="proposalListTable"></div>
      </div>
    </div>
  </div>


<!-- <table class="table table-bordered table-striped table-hover" id="proposal_table" width="100%">
  <thead>
    <tr>
      <th width="12%" style="text-align: center;">Date</th>
      <th width="8%" style="text-align: center;">Proposal ID</th>
      <th width="20%">Name</th>
      <th>Title</th>
      <th width="7%" style="text-align: center;">Amount</th>
      <th width="7%" style="text-align: center;">Status</th>
      <th width="7%" style="text-align: center;">Action</th>
    </tr>
  </thead>
<tbody>
@if(isset($ProposalsData) && count($ProposalsData)>0 )
  @foreach($ProposalsData as $k=>$v)
    @if(isset($v['save_type']) && $v['save_type'] != 'T')
    <tr class="FiNalTableTr_{{ $v['crm_proposal_id'] or '' }}">
      <td align="center" class="deep_blue">{{ date('d-m-Y H:i:s', strtotime($v['created'])) }}</td>
      <td align="center" class="deep_blue">{{ $v['proposalID'] or '' }}</td>
      <td class="deep_blue">{{ $v['prospect_name'] or '' }}</td>
      <td class="deep_blue">{{ $v['proposal_title'] or '' }}</td>
      <td align="right" class="deep_blue">{{ $v['gross_fees'] }}</td>
      <td align="center">
        <span class="Status_{{ $v['crm_proposal_id'] or '' }} p_send_btn">{{ strtoupper($v['status']) }}</span>
      </td>
      <td align="center">
        <div class="btn-group" style="float: left; margin-right: 5px;">
          <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
          </button>
          <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
            <li><a href="/proposal-preview/{{ $v['entrpt_crm_prop_id'] or ''}}/list/{{ $v['is_rejected'] or '' }}" target="_blank"><i class="fa fa-eye tiny-icon"></i>Preview</a></li>

            <li><a href="javascript:void(0)" class="openActionSendPopUp" data-crm_proposal_id="{{ $v['crm_proposal_id'] or ''}}" data-name="{{ strtoupper(strtolower($v['prospect_name'])) }}"  data-title="{{ strtoupper(strtolower($v['proposal_title'])) }}"><i class="fa fa-envelope"></i><span class="sendText_{{$v['crm_proposal_id']}}">{{ ($v['status'] == 'Draft' || $v['status'] == 'Final')?'Send':'Re-Send'}}</span></a></li>

            <li><a href="/"><i class="fa fa-download tiny-icon"></i>Download</a></li>

            <li><a href="javascript:void(0)" class="copyProposal" data-crm_proposal_id="{{ $v['crm_proposal_id'] or ''}}" data-from_page="proposal"><i class="fa fa-copy tiny-icon"></i>Copy</a></li>

            <li><a href="javascript:void(0)" class="openCommentPopUp" data-crm_proposal_id="{{ $v['crm_proposal_id'] or ''}}" data-name="{{ strtoupper(strtolower($v['prospect_name'])) }}"  data-title="{{ strtoupper(strtolower($v['proposal_title'])) }}"><i class="fa fa-comment tiny-icon"></i>Comments</a></li>

            <li><a href="javascript:void(0)" class="openHistoryPopUp" data-proposal_id="{{ $v['proposalID'] or ''}}" data-crm_proposal_id="{{ $v['crm_proposal_id'] or ''}}"><i class="fa fa-file-text tiny-icon"></i> History</a></li>

            <li class="matkLostLi_{{$v['crm_proposal_id']}} {{($v['is_signed'] != 'Y')?'show':'hide'}}"><a href="javascript:void(0)" class="markedSigned" data-proposal_id="{{ $v['proposalID'] or ''}}" data-crm_proposal_id="{{ $v['crm_proposal_id'] or ''}}" data-action_type="ML"><img src="/img/cross-box.png" style="height: 11px; padding-right: 10px;">Mark as Lost</a></li>
            <li class="matkAcceptLi_{{$v['crm_proposal_id']}} {{($v['is_signed'] != 'Y')?'show':'hide'}}"><a href="javascript:void(0)" class="markedSigned" data-proposal_id="{{ $v['proposalID'] or ''}}" data-crm_proposal_id="{{ $v['crm_proposal_id'] or ''}}" data-action_type="MA"><i class="fa fa-check-square-o"></i>Mark as Acepted</a></li>

            <li class="revokeLi_{{ $v['crm_proposal_id'] or ''}}">
              @if($v['save_type']=='E' || $v['save_type']=='V' || $v['save_type']=='A' || $v['save_type']=='MA' || $v['save_type']=='L' || $v['save_type']=='ML')
                <a href="javascript:void(0)" class="doRevoked" data-crm_proposal_id="{{$v['crm_proposal_id'] or ''}}"><i class="fa fa-edit tiny-icon"></i>Revoke & Edit</a>
              @else
                <a href="/proposal/edit-proposal/{{ $v['crm_proposal_id'] or '' }}/proposal"><i class="fa fa-edit tiny-icon"></i>Edit</a>
              @endif
            </li>

            <li><a href="javascript:void(0)" id="deleteProposalFinal" data-crm_proposal_id="{{ $v['crm_proposal_id'] or '' }}" data-proposal_id="{{ $v['proposalID'] or '' }}" ><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
          </ul>
        </div>
        @if(isset($v['unread_count']) && $v['unread_count'] >0)
          <div class="UnresdIcon" id="UnresdIcon{{ $v['crm_proposal_id'] or ''}}"><i class="fa fa-envelope" aria-hidden="true"></i></div>
        @endif
      </td>
    </tr>
    @endif
  @endforeach
@endif
  </tbody>
</table> -->

</div>


<div class="modal fade" id="newLetterTemplate-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="col-md-12">
          <div class="col-md-11"><h4 class="modal-title">Add New Template</h4></div>
          <div class="col-md-1"><button type="submit" name="save" id="save" class="btn btn-info">SAVE</button></div>
        </div>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader" style="text-align: center;"></div>

        <div class="col-md-12" style="padding-left: 0px;">
          <div class="col-md-8">
            <input type="hidden" name="template_id" id="template_id" value="">

            <div class="form-group">
              <input name="template_subject" id="template_subject" type="text" class="form-control" placeholder="Subject Line">
              <div class="clearfix"></div>     
            </div>

            <div class="form-group">
              <textarea name="template_message" id="template_message_body" class="form-control" placeholder="Message" style="height: 250px; visibility: hidden; display: none;"></textarea>
            </div>
          </div>
        
          <div class="col-md-4" style="margin-top: -23px;">
          <div class="input_dropdownbn">
            <label style="margin-top: 0"><!-- Insert Placeholder -->&nbsp;</label>
            <select class="form-control newdropdown" id="changePlaceHolder">
              <option value="">Select Placeholder Type</option>
              <option value="general">General</option>
              <option value="org">Organisation Details</option>
              <option value="ind">Individual Details</option>
              <option value="staff">Staff Details</option>
              <option value="practice">Practice Details</option>
              <option value="address">Organisation Address Details</option>
              <option value="other">Other Contacts</option>
            </select>
            
            <ul class="placeholderList"><!-- Ajax Call --></ul>
          </div>
        </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>







<!-- History pop up -->
<div class="modal fade" id="openHistoryPopUp-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1000px;">
    <div class="modal-content">
      <div class="modal-header" style="padding-bottom: 0px;">
        <div class="col-md-12">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Document History for  proposal ID <span class="historyProposalId"></span></h4>
        </div>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader"></div>
        <div class="col-md-12">
          <table width="100%" class="table table-bordered table-striped table-hover proposalHistory">
          <thead>
            <th width="25%">Date</th>
            <th width="25%">Event</th>
            <th width="25%">IP Address</th>
            <th>User Name</th>
          </thead>
          <tbody>
            <!-- <tr>
              <td>A</td>
              <td>B</td>
              <td>C</td>
              <td>D</td>
            </tr> -->
          </tbody>  
          </table>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>


