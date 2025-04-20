$(document).ready(function () {
  var client_id = $('#client_id').val();
  var page_name = $('#page_name').val();

  $('#recurringContracts').jtable({
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'status DESC',

      actions: {
        listAction: '/jtable/action?action=recurringContracts&table_type=recurring&client_id='+client_id
      },
      fields: {
          sort_date: {
            title: 'Sort Date',
            list: false
          },
          status: {
            title: 'Status',
            list: false
          },
          signed_date: {
            title: 'Signed Date',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.signed_date;
            }
          },
          proposal_title: {
            title: 'Contract Title',
            display:function(data){
              return data.record.proposal_title;
            }
          },
          proposal_id: {
            title: 'Proposal ID',
            width: '3%',
            display:function(data){
              return data.record.proposal_id;
            } 
          },
          annual_fee: {
            title: 'Annual Fee',
            width: '4%',
            display: function(data) {
              return data.record.annual_fee;
            }
          },
          startdate: {
            title: 'Start Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              return data.record.startdate;
            }
          },
          enddate: {
            title: 'End Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              return data.record.enddate;
            }
          },
          save_type: {
            title: 'Status',
            width: '3%',
            sorting:false,
            display: function(data) {
              var count_down = data.record.count_down;
              var button = '';
              if(count_down > 90){
                button += '<button type="button" class="job_send_btn" data-proposal_id="'+data.record.proposal_id+'">LIVE</button>';
              }else{
                if(data.record.manage_renewals == 'N' ){
                  if($.isNumeric(count_down) && count_down >=0 ){
                    var btnName = (page_name == 'client_portal')?'RENEWAL DUE':'RENEW';
                    button += '<button type="button" class="job_send_btn " data-proposal_id="'+data.record.proposal_id+'" data-from_page="prop_client_org">'+btnName+'</button>';
                  }else{
                    button += '<button type="button" class="job_send_btn" data-proposal_id="'+data.record.proposal_id+'">EXPIRED</button>';
                  }
                }else{
                  button += '<button type="button" class="job_sent_btn" data-client_id="'+data.record.client_id+'" data-from_page="prop_client_org">RENEWED</button>';
                }
              }

              if(data.record.startdate == ''){
                button = '';
              }
              text = '<div style="text-align:center" id="after_send_'+data.record.proposal_id+'">'+button+'</div>';
              return text;
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var text = '<div class="btn-group" style="float: left; margin-left:6px;">';
              text += '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';

              text += '<li><a href="/proposal-preview/'+data.record.entrpt_crm_prop_id+'/list/'+data.record.is_rejected+'" target="_blank"><i class="fa fa-eye tiny-icon"></i>Preview</a></li>';
              text += '<li><a href="javascript:void(0)" class="openActionSendPopUp" data-crm_proposal_id="'+data.record.crm_proposal_id+'" data-name="'+data.record.prospect_name+'"  data-title="'+data.record.proposal_title+'"><i class="fa fa-envelope"></i><span class="sendText_'+data.record.proposal_id+'">Send</span></a></li>';
              text += '<li><a href="javascript:void(0)"><i class="fa fa-download tiny-icon"></i>Download</a></li>';

              text += '</ul></div>';
              return text;
            }
          }
      }
  });

  $('#LoadrecurringButton').click(function (e) {
      e.preventDefault();
      $('#recurringContracts').jtable('load', {
          search: $('#recurringText').val()
      });
  });

  $('#recurringText').keyup(function (e) {
      e.preventDefault();
      $('#recurringContracts').jtable('load', {
          search: $('#recurringText').val()
      });
  });

  $('#LoadrecurringButton').click();


  $('#nonRecurringContracts').jtable({
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'sort_date ASC',

      actions: {
        listAction: '/jtable/action?action=recurringContracts&table_type=nonrecurring&client_id='+client_id
      },
      fields: {
          sort_date: {
            title: 'Sort Date',
            list: false
          },
          signed_date: {
            title: 'Signed Date',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.signed_date;
            }
          },
          proposal_title: {
            title: 'Contract Title',
            display:function(data){
              return data.record.proposal_title;
            }
          },
          proposal_id: {
            title: 'Proposal ID',
            width: '3%',
            display:function(data){
              return data.record.proposal_id;
            } 
          },
          annual_fee: {
            title: 'Amount',
            width: '4%',
            display: function(data) {
              return data.record.annual_fee;
            }
          },
          startdate: {
            title: 'Start Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              return data.record.startdate;
            }
          },
          enddate: {
            title: 'End Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              return data.record.enddate;
            }
          },
          save_type: {
            title: 'Status',
            width: '3%',
            sorting:false,
            display: function(data) {
              return '<span class="Status_25 p_send_btn">'+data.record.save_type+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var text = '<div class="btn-group" style="float: left; margin-left:6px;">';
              text += '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';

              text += '<li><a href="/proposal-preview/'+data.record.entrpt_crm_prop_id+'/list/'+data.record.is_rejected+'" target="_blank"><i class="fa fa-eye tiny-icon"></i>Preview</a></li>';
              text += '<li><a href="javascript:void(0)" class="openActionSendPopUp" data-crm_proposal_id="'+data.record.crm_proposal_id+'" data-name="'+data.record.prospect_name+'"  data-title="'+data.record.proposal_title+'"><i class="fa fa-envelope"></i><span class="sendText_'+data.record.proposal_id+'">Send</span></a></li>';
              text += '<li><a href="javascript:void(0)"><i class="fa fa-download tiny-icon"></i>Download</a></li>';

              text += '</ul></div>';
              return text;
            }
          }
      }
  });

  $('#LoadNonRecurringButton').click(function (e) {
    e.preventDefault();
    $('#nonRecurringContracts').jtable('load', {
        search: $('#nonRecurringText').val()
    });
  });

  $('#nonRecurringText').keyup(function (e) {
    e.preventDefault();
    $('#nonRecurringContracts').jtable('load', {
        search: $('#nonRecurringText').val()
    });
  });

  $('#LoadNonRecurringButton').click();


  
  











});


/*function refreshStatusDropdown(resp)
{
  var option = "<option value=''>Show All ["+resp.total_count+"]</option>";
  $.each(resp.status_dropdown, function(k,v){
    option += "<option value='"+v.short_name+"'>"+v.status+" ["+v.count+"]</option>";
  })
  $('#renewalStatusDrop').html(option);
}*/