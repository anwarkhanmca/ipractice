$(document).ready(function(){
  var client_type = $('#client_type').val();

  if(client_type == 'org'){
    $('#clientListsTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 50,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=clientLists&client_type=org'
        },
        rowInserted : function(event, data) 
        {
          if(data.record.show_archive == 'Y'){
            $('.archiveRow_'+data.record.client_id).closest('.jtable-data-row').css({'background':'#ccc'});
          }
        },
        fields: {
          client_id: {
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead" id="allCheckSelect"></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){
              
              var text = '<input type="checkbox" data-archive="'+data.record.show_archive+'" class="for_autologin ads_Checkbox" name="client_delete_id[]" value="'+data.record.client_id+'" data-client_number="'+data.record.registration_number+'" />';
              text += '<input type="hidden" id="clnt_no_'+data.record.client_id+'" value="'+data.record.registration_number+'">';
              return '<div class="align_center archiveRow_'+data.record.client_id+'">'+text+'</div>';
            }
          },
          business_type: {
            title: 'Business Type',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.business_type;
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            display:function(data){
              var crn = data.record.registration_number;
              return '<a href="/chdata-details/'+crn+'" target="_blank">'+crn+'</a>';
            }
          },
          client_name: {
            title: 'Client Name',
            display:function(data){
              return '<a href="/client/edit-org-client/'+data.record.client_id+'/'+data.record.org_client+'">'+data.record.client_name+'</a>';
            }
          },
          year_end: {
            title: 'Year End',
            width: '2%',
            sorting:false,
            display:function(data){
              var text = data.record.year_end;
              return '<div class="center">'+text+'</div>';
            }
          },
          deadacc_count: {
            title: 'Accounts',
            width: '2%',
            display: function(data) {
              var count = data.record.deadacc_count;
              if(count.length > 0){
                if(count < 0){
                  count = '<span style="color:red">'+count+'</span>';
                }
              }else{
                count = '<span style="color:red">-</span>';
              }
              return '<div class="center">'+count+'</div>';
            }
          },
          deadret_count: {
            title: 'CS01',
            width: '2%',
            display: function(data) {
              var count = data.record.deadret_count;
              if(count.length > 0){
                if(count < 0){
                  count = '<span style="color:red">'+count+'</span>';
                }
              }else{
                count = '<span style="color:red">-</span>';
              }
              return '<div class="center">'+count+'</div>';
            }
          },
          tax_reference: {
            title: 'Tax Reference',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = "";
              var small = data.record.utrsamllbox;
              var big   = data.record.tax_reference;
              if(small.length > 0){
                text += data.record.utrsamllbox;
              }
              if(small.length > 0 && big.length >0){
                text += ' / ';
              }

              text += data.record.tax_reference;
              return "<div class='center'>"+text+"</div>";
            }
          },
          vat_number: {
            title: 'Vat Number',
            width: '4%',
            display:function(data){
              return '<div class="center">'+data.record.vat_number+'</div>';
            }
          },
          vat_stagger: {
            title: 'Stagger',
            width: '3%',
            display: function(data) {
              return data.record.vat_stagger;
            }
          },
          address: {
            title: 'Correspondence Address',
            width: '6%',
            sorting:false,
            display: function(data) {
              return data.record.address;
            }
          }
        }
    });
  }//org table end

  if(client_type == 'ind'){
    $('#clientListsTable').jtable({
      paging: true,
      sorting: true,
      pageSize: 50,
      defaultSorting: 'client_name ASC',

      actions: {
        listAction: '/jtable/action?action=clientLists&client_type=ind'
      },
      rowInserted : function(event, data) 
      {
        if(data.record.show_archive == 'Y'){
          $('.archiveRow_'+data.record.client_id).closest('.jtable-data-row').css({'background':'#ccc'});
        }
      },
      fields: {
        client_id: {
          title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead" id="allCheckSelect"></div>',
          width: '0.5%',
          sorting:false,
          display:function(data){
            var text = '<input type="checkbox" data-archive="'+data.record.show_archive+'" class="ads_Checkbox" name="client_delete_id[]" value="'+data.record.client_id+'" />';
            return '<div class="align_center archiveRow_'+data.record.client_id+'">'+text+'</div>';
          }
        },
        dob: {
          title: 'DOB',
          width: '2%',
          sorting:false,
          display:function(data){
            var text = data.record.dob;
            return '<div class="center">'+text+'</div>';
          }
        },
        client_name: {
          title: 'Client Name',
          width: '6%',
          display:function(data){
            return '<a href="/client/edit-ind-client/'+data.record.client_id+'/'+data.record.ind_client+'">'+data.record.client_name+'</a>';
          }
        },
        relationship: {
          title: 'Business Name',
          width: '6%',
          sorting:false,
          display:function(data){
            var relationship = data.record.relationship;
            var select = '';
            if(relationship.length >0){
              select = '<select class="form-control newdropdown">';
              $.each(relationship, function(k,v){
                select += '<option value="'+v.client_id+'">'+v.name+'</option>';
              });
              select    += '</select>';
            }
            return '<div class="center">'+select+'</div>';
          }
        },
        ni_number: {
          title: 'NI Number',
          width: '2%',
          display: function(data) {
            var text = data.record.ni_number;
            return '<div class="center">'+text+'</div>';
          }
        },
        tax_reference: {
          title: 'UTR',
          width: '2%',
          sorting:false,
          display: function(data) {
            var text = data.record.tax_reference;
            return "<div class='center'>"+text+"</div>";
          }
        },
        address: {
          title: 'Residential Address',
          sorting:false,
          display: function(data) {
            return data.record.address;
          }
        },
        invitation_status: {
          title: 'Client Portal',
          width: '3%',
          sorting:false,
          display: function(data) {
            var invitation_status   = data.record.invitation_status;
            if(invitation_status == 'Y'){
              var text = '<button type="button" class="job_send_btn invited_popup" data-client_id="'+data.record.client_id+'" data-send_type="single" data-client_type="ind" data-status="pending">PENDING</button>';
            }else if(invitation_status == 'N'){
              var text = '<button type="button" class="job_send_btn invited_popup" data-client_id="'+data.record.client_id+'" data-send_type="single" data-client_type="ind" data-status="invited">INVITED</button>';
            }else{
              var text = '<button type="button" class="job_send_btn invite_send_popup" data-client_id="'+data.record.client_id+'" data-send_type="single" data-client_type="ind" data-status="invite">INVITE</button>';
            }
            return '<div class="center" id="after_send_'+data.record.client_id+'">'+text+'</div>';
          }
        }
      }
    });
  }

  $('#clientListsSearchButton').click(function (e) {
      e.preventDefault();
      $('#clientListsTable').jtable('load', { search: $('#clientListsSearchText').val() });
  });

  $('#clientListsSearchText').keyup(function (e) {
      e.preventDefault();
      $('#clientListsTable').jtable('load', { search: $(this).val() });
  });

  $('#clientListsSearchButton').click();

// check all check box
  $('.CheckHead').click(function (e) {
    if ($(this).is(':checked')) {
      $("input[type=checkbox]").each(function () {
        $(this).prop("checked", true);
      });
    } else {
      $("input[type=checkbox]").each(function () {
        $(this).attr("checked", false);
      });
    }
  });





  


  
  











});

function refresh_table()
{
  $('#clientListsTable').jtable('load', { search: $('#clientListsSearchText').val() });
}

