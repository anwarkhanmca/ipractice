$(document).ready(function(){
  var page_open = $('#page_open').val();

  $('#proposalListTable').jtable({
    paging: true,
    sorting: true,
    pageSize: 10,
    defaultSorting: 'date DESC',

    actions: {
      listAction: '/jtable/action?action=proposalLists'
    },
    fields: {
      date: {
        title: 'Date',
        width: '3%',
        display:function(data){
          var text = data.record.date;
          return '<div class="deep_blue center">'+text+'</div>';
        }
      },
      proposalID: {
        title: 'Proposal ID',
        width: '1%',
        display:function(data){
          var text = data.record.proposalID;
          return '<div class="deep_blue center">'+text+'</div>';
        }
      },
      prospect_name: {
        title: 'Name',
        width: '6%',
        display:function(data){
          var text = data.record.prospect_name;
          return '<div class="deep_blue">'+text+'</div>';
        }
      },
      proposal_title: {
        title: 'Title',
        display:function(data){
          var text = data.record.proposal_title;
          return '<div class="deep_blue">'+text+'</div>';
        }
      },
      gross_fees: {
        title: 'Amount',
        width: '1%',
        display:function(data){
          var text = data.record.gross_fees;
          return '<div class="right deep_blue">'+text+'</div>';
        }
      },
      status: {
        title: '<div class="center">Status</div>',
        width: '1%',
        sorting:false,
        display: function(data) {
          var status  = data.record.status;
          var text    = '<span class="center p_send_btn Status_'+data.record.crm_proposal_id+'">'+status.toUpperCase()+'</span>';
          return '<div class="center">'+text+'</div>';
        }
      },
      action: {
        title: 'Action',
        width: '1%',
        sorting:false,
        display: function(data) {
          var save_type       = data.record.save_type;
          var crm_proposal_id = data.record.crm_proposal_id;
          var proposalID      = data.record.proposalID;
          var prospect_name   = data.record.prospect_name;
          var proposal_title  = data.record.proposal_title;
          var entrpt_crm_prop_id = data.record.entrpt_crm_prop_id;
          var is_rejected     = data.record.is_rejected;
          var caps_title      = data.record.caps_title;
          var is_signed       = data.record.is_signed;
          var display         = (is_signed != 'Y')?'show':'hide';
          var status          = data.record.status;
          var unread_count    = data.record.unread_count;
          
          var text = '<div class="btn-group" style="float: left; margin-right: 5px;"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
          text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
          
          text += '<li><a href="/proposal-preview/'+entrpt_crm_prop_id+'/list/'+is_rejected+'" target="_blank"><i class="fa fa-eye tiny-icon"></i>Preview</a></li>';
          text += '<li><a href="javascript:void(0)" class="openActionSendPopUp" data-crm_proposal_id="'+crm_proposal_id+'" data-name="'+prospect_name+'"  data-title="'+caps_title+'"><i class="fa fa-envelope"></i><span class="sendText_'+crm_proposal_id+'">';
          if(status == 'Draft' || status == 'Final'){
            text += 'Send';
          }else{
            text += 'Re-Send';
          }
          text += '</span></a></li>';
          text += '<li><a href="/"><i class="fa fa-download tiny-icon"></i>Download</a></li>';
          text += '<li><a href="javascript:void(0)" class="copyProposal" data-crm_proposal_id="'+crm_proposal_id+'" data-from_page="proposal"><i class="fa fa-copy tiny-icon"></i>Copy</a></li>';
          text += '<li><a href="javascript:void(0)" class="openCommentPopUp" data-crm_proposal_id="'+crm_proposal_id+'" data-name="'+prospect_name+'"  data-title="'+caps_title+'"><i class="fa fa-comment tiny-icon"></i>Comments</a></li>';
          text += '<li><a href="javascript:void(0)" class="openHistoryPopUp" data-proposal_id="'+proposalID+'" data-crm_proposal_id="'+crm_proposal_id+'"><i class="fa fa-file-text tiny-icon"></i> History</a></li>';
          text += '<li class="matkLostLi_'+crm_proposal_id+' '+display+'"><a href="javascript:void(0)" class="markedSigned" data-proposal_id="'+proposalID+'" data-crm_proposal_id="'+crm_proposal_id+'" data-action_type="ML"><img src="/img/cross-box.png" style="height: 11px; padding-right: 10px;">Mark as Lost</a></li>';
          text += '<li class="matkAcceptLi_'+crm_proposal_id+' '+display+'"><a href="javascript:void(0)" class="markedSigned" data-proposal_id="'+proposalID+'" data-crm_proposal_id="'+crm_proposal_id+'" data-action_type="MA"><i class="fa fa-check-square-o"></i>Mark as Acepted</a></li>';

          text += '<li class="revokeLi_'+crm_proposal_id+'">';
          if(save_type=='E' || save_type=='V' || save_type=='A' || save_type=='MA' || save_type=='L' || save_type=='ML'){
            text += '<a href="javascript:void(0)" class="doRevoked" data-crm_proposal_id="'+crm_proposal_id+'"><i class="fa fa-edit tiny-icon"></i>Revoke & Edit</a>';
          }else{
            text += '<a href="/proposal/edit-proposal/'+crm_proposal_id+'/proposal"><i class="fa fa-edit tiny-icon"></i>Edit</a>';
          }
          text += '</li>';

          text += '<li><a href="javascript:void(0)" id="deleteProposalFinal" data-crm_proposal_id="'+crm_proposal_id+'" data-proposal_id="'+proposalID+'" ><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
          text += '</ul></div>';
          if(unread_count >0){
            text += '<div class="UnresdIcon" id="UnresdIcon'+crm_proposal_id+'"><i class="fa fa-envelope" aria-hidden="true"></i></div>';
          }
          return '<div class="center">'+text+'</div>';
        }
      }
    }
  });

  $('#proposalListSearchText').keyup(function (e) {
    e.preventDefault();
    refresh_table();
  });

  if(page_open == 'proposal'){
    refresh_table();
  }



  


  
  











});

function refresh_table()
{
  var page_open = $('#page_open').val();
  if(page_open == 'proposal'){
    var search  = $('#proposalListSearchText').val();
    $('#proposalListTable').jtable('load', { search:search, page_open:page_open });
  }
}

