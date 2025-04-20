$(document).ready(function () {
  var address_type  = $('#address_type').val();
  var tab_id        = $('#tab_id').val();
  if(tab_id == 1){
    /*$('#OrgTableContainer').jtable({
      //title: 'Student List',
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'client_name ASC',
      
      actions: {
        listAction: '/contacts/get-contact-org?address_type='+address_type
      },
      fields: {
        client_id: {
          title:'<input type="checkbox" class="allCheckSelect"/>',
          width: '2%',
          sorting:false,
          display:function(data){
            return'<input type="checkbox" class="ads_Checkbox" name="client_ids[]" value="'+data.record.client_id+'" />';
          }
        },
        client_name: {
          title: 'Name',
          width: '10%',
          display:function(data){
            return'<a target="_blank" href="/client/edit-org-client/'+data.record.client_id+'/'+data.record.org_client+'">'+data.record.client_name+'</a>';
          }
        },
        type: {
          title: 'Address Type',
          width: '10%',
          sorting:false,
          display:function(data){
            var option = '<select class="form-control newdropdown address_type" data-key="'+data.record.key+'" data-client_id="'+data.record.client_id+'">';
            $.each(data.record.address_types, function(k,v){
              var selected = (v.short_name == address_type)?'selected':'';
              option += '<option value="'+v.short_name+'" '+selected+'>'+v.title+'</option>';
            });
            option += '</select>';
            return option;
          } 
        },
        telephone: {
          title: 'Telephone',
          width: '10%',
          display: function(data) {
            return '<span class="teleAddr'+data.record.client_id+'">'+data.record.telephone+'</span>';
          }
        },
        fax: {
          title: 'Fax',
          width: '10%',
          display: function(data) {
           return '<span class="faxAddr'+data.record.client_id+'">'+data.record.fax+'</span>';
          }
        },
        email: {
          title: 'Email',
          width: '10%',
          display: function(data) {
            return '<span class="emailAddr'+data.record.client_id+'">'+data.record.email+'</span>';
          }
        },
        website: {
          title: 'Website',
          width: '10%',
          display: function(data) {
           return '<span class="websiteAddr'+data.record.client_id+'">'+data.record.website+'</span>';
          }
        },
        address: {
          title: 'Address',
          width: '10%',
          sorting:false,
          display: function(data) {
            var string = data.record.address;
            var address = (string.length > '45')?string.substring(0,45)+'...<a href="javascript:void(0)" class="more_address" data-client_id="'+data.record.client_id+'" data-client_type="'+data.record.type+'">more</a>':string;

            return '<span class="fullAddr'+data.record.client_id+'">'+address+'</span>';
          }
        },
        notes: {
          title: 'Notes',
          width: '4%',
          sorting:false,
          display: function(data) {
            var dotted = (data.record.notes!='')?'style="border-bottom:3px dotted #3a8cc1 !important"':''
            var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-contact_type="'+data.record.type+'"><span '+dotted+'>notes</span></a>';
            text += '<input type="hidden" name="corres_add_'+data.record.client_id+'" id="corres_add_'+data.record.client_id+'" value="'+data.record.address+'">';
            return text;
          }
        }
      }
    });*/
    $('#OrgTableContainer').jtable({
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'client_name ASC',
      
      actions: {
        listAction: '/contacts/get-contact-org?client_type=org&address_type='+address_type
      },
      fields: {
        client_id: {
          title:'<input type="checkbox" class="allCheckSelect"/>',
          width: '2%',
          sorting:false,
          display:function(data){
            return'<input type="checkbox" class="ads_Checkbox" name="client_ids[]" value="'+data.record.client_id+'" />';
          }
        },
        client_name: {
          title: 'Name',
          width: '10%',
          display:function(data){
            return'<a target="_blank" href="/client/edit-org-client/'+data.record.client_id+'/'+data.record.org_client+'">'+data.record.client_name+'</a>';
          }
        },
        type: {
          title: 'Address Type',
          width: '10%',
          sorting:false,
          display:function(data){
            var option = '<select class="form-control newdropdown address_type" data-key="'+data.record.key+'" data-client_id="'+data.record.client_id+'">';
            $.each(data.record.address_types, function(k,v){
              var selected = (v.short_name == address_type)?'selected':'';
              option += '<option value="'+v.short_name+'" '+selected+'>'+v.title+'</option>';
            });
            option += '</select>';
            return option;
          } 
        },
        contact_person: {
          title: 'Contact Person',
          width: '10%',
          display: function(data) {
           return '<span class="contName'+data.record.client_id+'">'+data.record.contact_person+'</span>';
          }
        },
        telephone: {
          title: 'Telephone',
          width: '10%',
          display: function(data) {
            return '<span class="teleAddr'+data.record.client_id+'">'+data.record.telephone+'</span>';
          }
        },
        mobile: {
          title: 'Mobile',
          width: '10%',
          display: function(data) {
            return '<span class="mobAddr'+data.record.client_id+'">'+data.record.mobile+'</span>';
          }
        },
        email: {
          title: 'Email',
          width: '10%',
          display: function(data) {
            return '<span class="emailAddr'+data.record.client_id+'">'+data.record.email+'</span>';
          }
        },
        address: {
          title: 'Address',
          width: '10%',
          sorting:false,
          display: function(data) {
            var string = data.record.address;
            var address = (string.length > '45')?string.substring(0,45)+'...<a href="javascript:void(0)" class="more_address" data-client_id="'+data.record.client_id+'" data-client_type="'+data.record.type+'">more</a>':string;

            return '<span class="fullAddr'+data.record.client_id+'">'+address+'</span>';
          }
        },
        notes: {
          title: 'Notes',
          width: '4%',
          sorting:false,
          display: function(data) {
            var dotted = (data.record.notes!='')?'style="border-bottom:3px dotted #3a8cc1 !important"':''
            var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-contact_type="'+data.record.type+'"><span '+dotted+'>notes</span></a>';
            text += '<input type="hidden" name="corres_add_'+data.record.client_id+'" id="corres_add_'+data.record.client_id+'" value="'+data.record.address+'">';
            return text;
          }
        }
      }
    });
  }//end tab 1

  if(tab_id == 2){
    $('#OrgTableContainer').jtable({
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'client_name ASC',
      
      actions: {
        listAction: '/contacts/get-contact-org?client_type=ind&address_type=res'
      },
      fields: {
        client_id: {
          title:'<input type="checkbox" class="allCheckSelect" />',
          width: '2%',
          sorting:false,
          display:function(data){
            var text = '<input type="hidden" name="serv_add_'+data.record.client_id+'" id="serv_add_'+data.record.client_id+'" value="'+data.record.serv_address+'">';
            text += '<input type="hidden" name="reg_add_'+data.record.client_id+'" id="reg_add_'+data.record.client_id+'" value="'+data.record.address+'">';
            text +='<input type="checkbox" class="ads_Checkbox" name="client_delete_id[]" value="'+data.record.client_id+'" />';
            return text;
          }
        },
        client_name: {
          title: 'Name',
          width: '10%',
          display:function(data){
            return'<a target="_blank" href="/client/edit-ind-client/'+data.record.client_id+'/'+data.record.ind_client+'">'+data.record.client_name+'</a>';
          }
        },
        res_telephone: {
          title: 'Telephone',
          width: '10%',
          display: function(data) {
            return '<span class="teleAddr'+data.record.client_id+'">'+data.record.res_telephone+'</span>';
          }
        },
        res_mobile: {
          title: 'Mobile',
          width: '10%',
          display: function(data) {
            return '<span class="mobAddr'+data.record.client_id+'">'+data.record.res_mobile+'</span>';
          }
        },
        res_email: {
          title: 'Email',
          width: '10%',
          display: function(data) {
            return '<span class="emailAddr'+data.record.client_id+'">'+data.record.res_email+'</span>';
          }
        },
        address: {
          title: 'Address',
          width: '10%',
          sorting:false,
          display: function(data) {
            var string = data.record.address;
            var address = (string.length > '45')?string.substring(0,45)+'...<a href="javascript:void(0)" class="more_address" data-client_id="'+data.record.client_id+'" data-address_type="reg" data-client_type="'+data.record.type+'">more</a>':string;

            return '<span class="fullAddr'+data.record.client_id+'">'+address+'</span>';
          }
        },
        serv_address: {
          title: 'Service Address',
          width: '10%',
          sorting:false,
          display: function(data) {
            var string = data.record.serv_address;
            var address = (string.length > '45')?string.substring(0,45)+'...<a href="javascript:void(0)" class="more_address" data-client_id="'+data.record.client_id+'" data-address_type="serv" data-client_type="'+data.record.type+'">more</a>':string;

            return '<span class="fullAddr'+data.record.client_id+'">'+address+'</span>';
          }
        },
        notes: {
          title: 'Notes',
          width: '4%',
          sorting:false,
          display: function(data) {
            var dotted = (data.record.notes!='')?'style="border-bottom:3px dotted #3a8cc1 !important"':''
            var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-contact_type="'+data.record.type+'"><span '+dotted+'>notes</span></a>';
            return text;
          }
        }
      }
    });
  }//tab_id 2 end

  if(tab_id == 3){
    $('#OrgTableContainer').jtable({
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'staff_name ASC',
      
      actions: {
        listAction: '/contacts/get-tab-details?tab_id='+tab_id
      },
      fields: {
        user_id: {
          title:'<div style="padding-left:5px;"><input type="checkbox" class="allCheckSelect" /></div>',
          width: '.5%',
          sorting:false,
          display:function(data){
            var text = '<input type="hidden" name="address_'+data.record.user_id+'" id="corres_add_'+data.record.user_id+'" value="'+data.record.address+'">';
            text += '<input type="checkbox" class="ads_Checkbox" name="user_ids[]" value="'+data.record.user_id+'" />';
            return '<div style="padding-left:5px;">'+text+'</div>';
          }
        },
        staff_name: {
          title: 'Name',
          width: '10%',
          display:function(data){
            return data.record.staff_name;
          }
        },
        telephone: {
          title: 'Telephone',
          width: '10%',
          display: function(data) {
            return data.record.telephone;
          }
        },
        mobile: {
          title: 'Mobile',
          width: '10%',
          display: function(data) {
            return data.record.mobile;
          }
        },
        email: {
          title: 'Email',
          width: '10%',
          display: function(data) {
            return data.record.email;
          }
        },
        address: {
          title: 'Address',
          width: '10%',
          sorting:false,
          display: function(data) {
            var string = data.record.address;
            var address = (string.length > '45')?string.substring(0,45)+'...<a href="javascript:void(0)" class="more_address" data-client_id="'+data.record.client_id+'" data-address_type="reg" data-client_type="'+data.record.type+'">more</a>':string;

            return '<span class="fullAddr'+data.record.staff_id+'">'+address+'</span>';
          }
        },
        notes: {
          title: 'Notes',
          width: '4%',
          sorting:false,
          display: function(data) {
            var dotted = (data.record.notes!='')?'style="border-bottom:3px dotted #3a8cc1 !important"':''
            var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-staff_id="'+data.record.user_id+'" data-contact_type="staff"><span '+dotted+'>notes</span></a>';
            return text;
          }
        }
      }
    });
  }//tab_id 3 end

  if(tab_id == 4){
    $('#OrgTableContainer').jtable({
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'name ASC',
      
      actions: {
        listAction: '/contacts/get-tab-others?tab_id='+tab_id
      },
      fields: {
        user_id: {
          title:'Delete',
          width: '.5%',
          sorting:false,
          display:function(data){
            var text = '<input type="hidden" name="other_address_'+data.record.contact_id+'" id="other_address_'+data.record.contact_id+'" value="'+data.record.address+'">';
            text += '<a href="javascript:void(0)" class="delete_contact" data-contact_id="'+data.record.contact_id+'" data-delete_from="contact"><img src="/img/cross.png" height="13"></a>';
            return '<div class="center">'+text+'</div>';
          }
        },
        name: {
          title: 'Name',
          width: '10%',
          display:function(data){
            var text = '<a href="javascript:void(0)" class="add_contact-modal" data-contact_id="'+data.record.contact_id+'" data-added_from="contact">'+data.record.name+'</a>';
            return text;
          }
        },
        contact_name: {
          title: 'Contact Person',
          width: '10%',
          display:function(data){
            var text = '<a href="javascript:void(0)" class="add_contact-modal" data-contact_id="'+data.record.contact_id+'" data-added_from="contact">'+data.record.contact_name+'</a>'
            return text;
          }
        },
        telephone: {
          title: 'Telephone',
          width: '3%',
          display: function(data) {
            return data.record.telephone;
          }
        },
        mobile: {
          title: 'Mobile',
          width: '3%',
          display: function(data) {
            return data.record.mobile;
          }
        },
        email: {
          title: 'Email',
          width: '7%',
          display: function(data) {
            return data.record.email;
          }
        },
        address: {
          title: 'Address',
          width: '12%',
          sorting:false,
          display: function(data) {
            var string = data.record.address;
            var address = (string.length > '45')?string.substring(0,45)+'...<a href="javascript:void(0)" class="more_address" data-contact_id="'+data.record.contact_id+'" data-client_type="other">more</a>':string;

            return address;
          }
        },
        notes: {
          title: 'Notes',
          width: '3%',
          sorting:false,
          display: function(data) {
            var dotted = (data.record.notes!='')?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
            var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-contact_id="'+data.record.contact_id+'" data-contact_type="other"><span '+dotted+'>notes</span></a>';
            return '<div class="center">'+text+'</div>';
          }
        }
      }
    });
  }//tab_id 4 end



  //Re-load records when user click 'load records' button.
  $('#LoadRecordsButton').click(function (e) {
    e.preventDefault();
    refresh_table();
  });

  $('#search').keyup(function (e) {
    e.preventDefault();
    refresh_table();
  });

  //Load all records when page is first shown
  $('#LoadRecordsButton').click();









});//end document


function refresh_table()
{
  var address_type  = $('#address_type').val();
  var tab_id        = $('#tab_id').val();

  var search    = $('#search').val();
  $('#OrgTableContainer').jtable('load', { search: search });
}