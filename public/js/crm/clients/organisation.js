$(document).ready(function () {
  var page_open   = $('#page_open').val();
  var client_type = $('#client_type').val();

  $('#OrgTableContainer').jtable({
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'count_down ASC',

      actions: {
        listAction: '/crm/clients/get-org-client?page_open='+page_open+'&client_type='+client_type
      },
      fields: {
          client_id: {
            title:'<input type="checkbox" class="allCheckSelect">',
            width: '0.5%',
            sorting:false,
            display:function(data){
              return '<input type="checkbox" class="ads_Checkbox" name="client_ids[]" value="'+data.record.client_id+'" />';
            }
          },
          engagement_date: {
            title: 'Engagement Date',
            width: '5%',
            sorting:false,
            display:function(data){
              var text = '<div style="text-align:center;">';
              if(data.record.crm_leads_id != 0){
                text += '<a href="javascript:void(0)" class="open_joining_pop" data-joining="'+data.record.created+'" data-client_id="'+data.record.client_id+'" data-table="client" id="joining_div_'+data.record.client_id+'">'+data.record.created+'</a>';
              }else{
                text += '<a href="javascript:void(0)" class="open_joining_pop" data-joining="'+data.record.engagement_date+'" data-client_id="'+data.record.client_id+'" data-table="crm" id="joining_div_'+data.record.client_id+'">';
                text += (data.record.engagement_date != '')?data.record.engagement_date:'Add..';
                text += '</a>';
              }
              return text+'</div>';
            }
          },
          client_name: {
            title: 'Client Name',
            //width: '10%',
            display:function(data){
              return '<a href="/renewals/'+data.record.client_id+'/'+data.record.type_url+'" target="_blank">'+data.record.client_name+'</a>';
            } 
          },
          recurring_contracts: {
            title: 'Recurring Contracts',
            width: '12%',
            sorting:false,
            display: function(data) {
              var selectArray = data.record.recurring_contracts;
              var option = '';
              if(selectArray.length > 0){
                option += '<select class="form-control newdropdown recurringDropdown" id="recurringDropdown_'+data.record.client_id+'" data-key="'+data.record.key+'" data-client_id="'+data.record.client_id+'">';
                $.each(selectArray, function(k,v){
                  var selected = '';
                  //var selected = (v.short_name == address_type)?'selected':'';
                  option += '<option value="'+v.proposal_id+'" '+selected+'>'+v.proposal_title+'</option>';
                });
                option += '</select>';
              }
              return option;
            }
          },
          annual_fee: {
            title: 'Annual Fee',
            width: '5%',
            display: function(data) {
              var recurring = data.record.recurring_contracts;
              var text = '<div style="text-align:center;" class="annual_fee_'+data.record.client_id+'">';
              /*if(recurring.length >0){
                text += data.record.annual_fee;
              }else{
                text += '<a href="javascript:void(0)" class="open_amount_pop billing_amount_'+data.record.client_id+'" data-amount="'+data.record.annual_fee+'" data-client_id="'+data.record.client_id+'">';
                text += (data.record.annual_fee != '')?data.record.annual_fee:'Add..';
                text += '</a>';
              }*/
              text += data.record.annual_fee;
              text += '</div>';
              return text;
            }
          },
          monthly_fee: {
            title: 'Monthly Fees',
            width: '5%',
            display: function(data) {
              return '<div class="monthly_amount_'+data.record.client_id+'" style="text-align:right;">'+data.record.monthly_fee+'</div>';
            }
          },
          startdate: {
            title: 'Start Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              var recurring = data.record.recurring_contracts;
              var text = '<div style="text-align:center;" class="startdate_outer_'+data.record.client_id+'">';
              /*if(recurring.length >0){
                text += data.record.startdate;
              }else{
                text += '<a href="javascript:void(0)" class="open_startdate_pop startdate_'+data.record.client_id+'" data-startdate="'+data.record.startdate+'" data-client_id="'+data.record.client_id+'">';
                text += (data.record.startdate != '')?data.record.startdate:'Add..';
                text += '</a>';
              }*/
              text += data.record.startdate;
              text += '</div>';
              return text;
            }
          },
          enddate: {
            title: 'End Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              return '<div class="enddate_'+data.record.client_id+'" style="text-align:center;">'+data.record.enddate+'</div>';
            }
          },
          count_down: {
            title: 'Count Down',
            width: '5%',
            display: function(data) {
              var text = '<div class="countdown_'+data.record.client_id+'" style="text-align:center;">';
              if(data.record.count_down > 0){
                text += data.record.count_down;
              }else{
                if(data.record.count_down == 0)
                  text += '<p style="color:red;">'+data.record.count_down+'</p>';
                else
                  text += '<p style="color:red;">-</p>';
              }
              return text+'</div>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var recurring = data.record.recurring_contracts;
              var text = '<div class="btn-group" style="float: left; margin-left:6px;">';
              text += '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';

              if(recurring.length >0){
                text += '<li><a href="javascript:void(0)" class="goToPreview" data-client_id="'+data.record.client_id+'"><i class="fa fa-eye tiny-icon"></i>Preview</a></li>';
                text += '<li><a href="javascript:void(0)" class="openSendEmailPopUp" data-client_id="'+data.record.client_id+'" data-name="'+data.record.client_name+'"><i class="fa fa-envelope"></i><span class="sendText_'+data.record.client_id+'">Send</span></a></li>';
                text += '<li><a href="javascript:void(0)"><i class="fa fa-download tiny-icon"></i>Download</a></li>';
              }else{
                text += '<li><a href="javascript:void(0)" class="deleteOrgTab" data-client_id="'+data.record.client_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              }

              text += '</ul></div>';
              return text;
            }
          },
          manage_renewals: {
            title: 'Send to Renewals <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '7%',
            sorting:false,
            display: function(data) {
              $('.countClient').html(data.record.client_count);
              var count_down = data.record.count_down;
              var button = '';
              if(count_down <= 90){
                if(data.record.manage_renewals == 'N' ){
                  if($.isNumeric(count_down) && count_down >=0 ){//console.log(count_down)
                    button += '<button type="button" class="job_send_btn send_renewals" data-client_id="'+data.record.client_id+'" data-from_page="prop_client_org"><i class="fa fa-refresh"></i> RENEW</button>';
                  }else{
                    button += '<button type="button" class="job_send_btn" data-client_id="'+data.record.client_id+'">EXPIRED</button>';
                  }
                }else{
                  button += '<button type="button" class="job_sent_btn send_renewals" data-client_id="'+data.record.client_id+'" data-from_page="prop_client_org">RENEWED</button>';
                }
              }

              if(data.record.startdate == ''){
                button = '';
              }
              text = '<div style="text-align:center" id="after_send_'+data.record.client_id+'">'+button+'</div>';
              return text;
            }
          }
      }
  });

  //Re-load records when user click 'load records' button.
  $('#LoadRecordsButton').click(function (e) {
      e.preventDefault();
      $('#OrgTableContainer').jtable('load', {
          search: $('#search').val()
      });
  });

  $('#search').keyup(function (e) {
      e.preventDefault();
      $('#OrgTableContainer').jtable('load', {
          search: $('#search').val()
      });
  });

  //Load all records when page is first shown
  $('#LoadRecordsButton').click();


  $('body').on('change', '.recurringDropdown', function(){
    var client_id     = $(this).data('client_id');
    var key           = $(this).data('key');
    var proposal_id   = $(this).val();
    $.ajax({
      url: "/proposal/action",
      type:"POST",
      dataType : 'json',
      data:{'proposal_id':proposal_id, 'client_id':client_id, 'action':'recurringDetails' },
      beforeSend : function(){
        $('#message_div').html('<div class="show_loader"><img src="/img/spinner.gif"></div>');
      },
      success:function(resp){
        $('#message_div').html('');
        var count_down = resp.count_down;
        var start_date = resp.start_date;

        $('.annual_fee_'+client_id).html(resp.annual_fee);
        $('.monthly_amount_'+client_id).html(resp.monthly_fee);
        $('.startdate_outer_'+client_id).html(start_date);
        $('.enddate_'+client_id).html(resp.end_date);
        $('.countdown_'+client_id).html(count_down);

        var button = '';
        if(start_date != '')
        {
          if($.isNumeric(count_down) && count_down <= 90){
            if(resp.renewals == 'N' ){
              if($.isNumeric(count_down) && count_down >=0 ){//console.log(count_down)
                button += '<button type="button" class="job_send_btn send_renewals" data-client_id="'+client_id+'" data-from_page="prop_client_org"><i class="fa fa-refresh"></i> RENEW</button>';
              }else{
                button += '<button type="button" class="job_send_btn" data-client_id="'+client_id+'">EXPIRED</button>';
              }
            }else{
              button += '<button type="button" class="job_sent_btn send_renewals" data-client_id="'+client_id+'" data-from_page="prop_client_org">RENEWED</button>';
            }
          }
        }
        $('#after_send_'+client_id).html(button);

        /*var option = '';
        $.each(resp.contracts, function(k,v){
          option += '<option value="'+v.proposal_id+'">'+v.proposal_title+'</option>';
        });
        $('#recurringDropdown_'+client_id).html(option);*/
        
        
      },
      error:function(data){
        alert('error'+data);
      }
    }); 
  });

  $('body').on('click', '.openSendEmailPopUp', function(){
      var postData = [];
      var client_id   = $(this).data('client_id');
      $("#client_id").val(client_id);

      var name        = $(this).data('name');
      var proposal_id = $('#recurringDropdown_'+client_id+' :selected').val();
      var title       = $('#recurringDropdown_'+client_id+' :selected').text();
      $(".PTitle").html(name+' - '+title);

      $.ajax({
        url: "/proposal/action",
        type:"POST",
        dataType : 'json',
        data:{'proposal_id':proposal_id, 'action':'checkProposalId' },
        beforeSend : function(){
          $('.show_loader').html('<img src="/img/spinner.gif">');
        },
        success:function(resp){
          $('.show_loader').html('');
          $("#crm_proposal_id").val(resp.crm_proposal_id);
          var content = $("#SendTextAreaHide").html();
          $("#sending_page").val('client_list');
          
          postData['crm_proposal_id'] = resp.crm_proposal_id;
          postData['content']         = content;
          getProposalEmailContent(postData);
          
        },
        error:function(data){
          alert('error'+data);
        }
      }); 

  });

  $('body').on('click', '.deleteOrgTab', function (e) {
      var client_id = $(this).data('client_id');
      if(!confirm('Do you want to delete?')){
        return false;
      }
      $.ajax({
      url: "/proposal/action",
      type:"POST",
      dataType : 'json',
      data:{'client_id':client_id, 'action':'deleteOrgTab' },
      beforeSend : function(){
        $('#message_div').html('<div class="show_loader"><img src="/img/spinner.gif"></div>');
      },
      success:function(resp){
        $('#message_div').html('');
        $('#OrgTableContainer').jtable('load');
      },
      error:function(data){
        alert('error'+data);
      }
    });
  });



/* Manage renewal tab */
  $('#manageRenewalContainer').jtable({
    paging: true,
    sorting: true,
    pageSize: 10,
    defaultSorting: 'client_name ASC',

    actions: {
      listAction: '/jtable/action?action=manageRenewalContainer'
    },
    fields: {
        /*client_id: {
          title:'<input type="checkbox" class="allCheckSelect">',
          width: '0.5%',
          sorting:false,
          display:function(data){
            return '<input type="checkbox" class="ads_Checkbox" name="client_ids[]" value="'+data.record.client_id+'" />';
          }
        },*/
        client_name: {
          title: 'Client Name',
          //width: '10%',
          display:function(data){
            return data.record.client_name;
          } 
        },
        contract: {
          title: 'Contracts',
          width: '8%',
          display: function(data) {
            return data.record.contract;
          }
        },
        proposal_id: {
          title: 'Proposal ID',
          width: '3%',
          display: function(data) {
            return '<div style="text-align:center;">'+data.record.proposal_id+'</div>';
          }
        },
        annual_fee: {
          title: 'Annual Fee',
          width: '3%',
          display: function(data) {
            return '<div style="text-align:center;">'+data.record.annual_fee+'</div>';
          }
        },
        startdate: {
          title: 'Start Date',
          width: '3%',
          sorting:false,
          display: function(data) {
            return '<div style="text-align:center;">'+data.record.startdate+'</div>';
          }
        },
        enddate: {
          title: 'End Date',
          width: '3%',
          sorting:false,
          display: function(data) {
            return '<div style="text-align:center;">'+data.record.enddate+'</div>';
          }
        },
        status: {
          title: 'Status',
          width: '4%',
          sorting:false,
          display: function(data) {
            var status = '';
            if(data.record.status != ''){
              status = '<span class="p_send_btn">'+data.record.status+'</span>';
            }
            return '<div style="text-align:center;" class="renewalStatus_'+data.record.manage_id+'">'+status+'</div>';
          }
        },
        action: {
          title: 'Action',
          width: '1%',
          sorting:false,
          display: function(data) {
            var text = '<div class="btn-group" style="float: left; margin-left:6px;">';
            text += '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
            text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';

            if(data.record.proposal_id == 'N/A'){
              text += '<li><a href="javascript:void(0)" class="changeContractStatus" data-save_type="D" data-manage_id="'+data.record.manage_id+'" data-client_id="'+data.record.client_id+'"><i class="fa fa-check-square-o"></i>Mark as Draft</a></li>';
              text += '<li><a href="javascript:void(0)" class="changeContractStatus" data-save_type="F" data-manage_id="'+data.record.manage_id+'" data-client_id="'+data.record.client_id+'"><i class="fa fa-check-square-o"></i>Mark as Final</a></li>';
              text += '<li><a href="javascript:void(0)" class="changeContractStatus" data-save_type="E" data-manage_id="'+data.record.manage_id+'" data-client_id="'+data.record.client_id+'"><i class="fa fa-check-square-o"></i>Mark as Sent</a></li>';
              text += '<li><a href="javascript:void(0)" class="changeContractStatus" data-save_type="A" data-manage_id="'+data.record.manage_id+'" data-client_id="'+data.record.client_id+'"><i class="fa fa-check-square-o"></i>Mark as Accepted</a></li>';
              text += '<li><a href="javascript:void(0)" class="changeContractStatus" data-save_type="L" data-manage_id="'+data.record.manage_id+'" data-client_id="'+data.record.client_id+'"><img src="/img/cross-box.png" style="height: 11px; padding-right: 10px;">Mark as Lost</a></li>';
            }

            text += '<li><a href="javascript:void(0)" class="actionManageContract" data-action_type="delete" data-manage_id="'+data.record.manage_id+'" data-client_id="'+data.record.client_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
            if(data.record.is_archive == 'N'){
              text += '<li><a href="javascript:void(0)" class="actionManageContract" data-action_type="archive" data-manage_id="'+data.record.manage_id+'" data-client_id="'+data.record.client_id+'"><i class="fa fa-archive" aria-hidden="true"></i>Archive</a></li>';
            }else{
              text += '<li><a href="javascript:void(0)" class="actionManageContract" data-action_type="unarchive" data-manage_id="'+data.record.manage_id+'" data-client_id="'+data.record.client_id+'"><i class="fa fa-archive" aria-hidden="true"></i>Un Archive</a></li>';
            }
            text += '</ul></div>';
            return text;
          }
        }
    }
  });

  //Re-load records when user click 'load records' button.
  $('#manageRenewalSearchBtn').click(function (e) {
      e.preventDefault();
      $('#manageRenewalContainer').jtable('load', {
        search: $('#manageRenewalText').val()
      });
  });

  $('#manageRenewalText').keyup(function (e) {
      e.preventDefault();
      $('#manageRenewalContainer').jtable('load', {
        search: $('#manageRenewalText').val()
      });
  });

  $('#renewalStatusDrop').change(function (e) {
      e.preventDefault();
      $('#manageRenewalContainer').jtable('load', {
        save_type: $('#renewalStatusDrop').val()
      });
  });

  $('#manageRenewalSearchBtn').click();

  $('body').on('click', '.changeContractStatus', function (e) {
      var client_id = $(this).data('client_id');
      var manage_id = $(this).data('manage_id');
      var save_type = $(this).data('save_type');
      $.ajax({
      url: "/proposal/action",
      type:"POST",
      dataType : 'json',
      data:{'save_type':save_type, 'manage_id':manage_id, 'client_id':client_id, 'action':'recurringStatusChange' },
      beforeSend : function(){
        $('#message_div').html('<div class="show_loader"><img src="/img/spinner.gif"></div>');
      },
      success:function(resp){
        $('#message_div').html('');
        $('.renewalStatus_'+manage_id).html('<span class="p_send_btn">'+resp.save_type+'</span>');

        refreshStatusDropdown(resp)
      },
      error:function(data){
        alert('error'+data);
      }
    });
  });

  $('body').on('click', '.actionManageContract', function (e) {
      var client_id   = $(this).data('client_id');
      var manage_id   = $(this).data('manage_id');
      var action_type = $(this).data('action_type');

      if(!confirm('Do you want to '+action_type+'?')){
        return false;
      }
      $.ajax({
      url: "/proposal/action",
      type:"POST",
      dataType : 'json',
      data:{'manage_id':manage_id, 'client_id':client_id, 'action_type':action_type, 'action':'actionManageContract' },
      beforeSend : function(){
        $('#message_div').html('<div class="show_loader"><img src="/img/spinner.gif"></div>');
      },
      success:function(resp){
        $('#message_div').html('');
        $('#manageRenewalContainer').jtable('load');

        refreshStatusDropdown(resp);
        /*var option = "<option value=''>Show All ["+resp.total_count+"]</option>";

        $.each(resp.status_dropdown, function(k,v){
          option += "<option value='"+v.short_name+"'>"+v.status+" ["+v.count+"]</option>";
        })
        $('#renewalStatusDrop').html(option);*/

      },
      error:function(data){
        alert('error'+data);
      }
    });
  });
  











});


function refreshStatusDropdown(resp)
{
  var option = "<option value=''>Show All ["+resp.total_count+"]</option>";
  $.each(resp.status_dropdown, function(k,v){
    option += "<option value='"+v.short_name+"'>"+v.status+" ["+v.count+"]</option>";
  })
  $('#renewalStatusDrop').html(option);
}