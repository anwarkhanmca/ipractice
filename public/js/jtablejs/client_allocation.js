$(document).ready(function(){
  
  $('#clientListsTable').jtable({
    paging: true,
    sorting: true,
    pageSize: 10,
    defaultSorting: 'client_name ASC',

    actions: {
      listAction: '/jtable/action?action=clientAllocationLists&client_type=org'
    },
    fields: {
      client_id: {
        title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead" id="CheckorgCheckbox"></div>',
        width: '0.5%',
        sorting:false,
        display:function(data){
          var text = '<input type="checkbox" class="checkbox applicable_Checkbox org_Checkbox" name="applicable_checkbox[]" value="'+data.record.client_id+'" id="applicable_checkbox'+data.record.client_id+'" />';
          return '<div style="padding-left:7px;" class="archiveRow_'+data.record.client_id+'">'+text+'</div>';
        }
      },
      business_type: {
        title: 'Type',
        width: '2%',
        sorting:false,
        display:function(data){
          var text = data.record.business_type;
          return '<div class="align_center">'+text+'</div>';
        }
      },
      client_name: {
        title: 'Business Name',
        display:function(data){
          return '<a href="/client/edit-org-client/'+data.record.client_id+'/'+data.record.org_client+'">'+data.record.client_name+'</a>';
        }
      },
      action: {
        title: 'Action <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
        width: '1%',
        sorting:false,
        display:function(data){
          var service_id    = data.record.service_id;
          var disable_click = data.record.disable_click;

          var text = '<a href="javascript:void(0)" class="openServicesStaff openAllocation openAllocation_'+data.record.client_id+' '+disable_click+'" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'" data-page_name="allocation">Edit</a>';
          return '<div class="center">'+text+'</div>';
        }
      },
      staff1: {
        title: '<div class="head_">Responsible staff</div>',
        //title: '/jtable/action?action=getHeading&location=1',
        width: '4%',
        sorting:false,
        display: function(data) {
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              var staff = v.staff_name1;
              if(v.staff_name1 != '' && v.staff_name1 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name1 != ''){
                text += '<option value="'+v.staff_id1+'">'+v.staff_name1+'</option>';
              }
            })
            text += '</select>';
          }
          return '<div class="center orgStaff_1_'+data.record.client_id+'">'+text+'</div>';
        }
      },
      staff2: {
        title: 'Junior',
        width: '4%',
        sorting:false,
        display: function(data) {
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              if(v.staff_name2 != '' && v.staff_name2 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name2 != ''){
                text += '<option value="'+v.staff_id2+'">'+v.staff_name2+'</option>';
              }
            })
            text += '</select>';
          }
          return "<div class='center'>"+text+"</div>";
        }
      },
      staff3: {
        title: 'Reviewer',
        width: '4%',
        sorting:false,
        display: function(data) {
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              if(v.staff_name3 != '' && v.staff_name3 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name3 != ''){
                text += '<option value="'+v.staff_id3+'">'+v.staff_name3+'</option>';
              }
            })
            text += '</select>';
          }
          return "<div class='center'>"+text+"</div>";
        }
      },
      staff4: {
        title: 'Manager',
        width: '4%',
        sorting:false,
        display:function(data){
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              if(v.staff_name4 != '' && v.staff_name4 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name4 != ''){
                text += '<option value="'+v.staff_id4+'">'+v.staff_name4+'</option>';
              }
            })
            text += '</select>';
          }
          return "<div class='center'>"+text+"</div>";
        }
      },
      staff5: {
        title: 'Partner',
        width: '4%',
        sorting:false,
        display: function(data) {
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              if(v.staff_name5 != '' && v.staff_name5 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name5 != ''){
                text += '<option value="'+v.staff_id5+'">'+v.staff_name5+'</option>';
              }
            })
            text += '</select>';
          }
          return "<div class='center'>"+text+"</div>";
        }
      }
    }
  });

  $('#indClientListsTable').jtable({
    paging: true,
    sorting: true,
    pageSize: 50,
    defaultSorting: 'client_name ASC',

    actions: {
      listAction: '/jtable/action?action=clientAllocationLists&client_type=ind'
    },
    fields: {
      client_id: {
        title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead" id="allCheckSelect"></div>',
        width: '0.5%',
        sorting:false,
        display:function(data){
          var text = '<input type="checkbox" class="checkbox applicable_Checkbox ind_Checkbox" name="applicable_checkbox[]" value="'+data.record.client_id+'" id="applicable_checkbox'+data.record.client_id+'" />';
          return '<div style="padding-left:7px;" class="archiveRow_'+data.record.client_id+'">'+text+'</div>';
        }
      },
      client_name: {
        title: 'Client Name',
        width: '6%',
        display:function(data){
          return '<a href="/client/edit-ind-client/'+data.record.client_id+'/'+data.record.ind_client+'">'+data.record.client_name+'</a>';
        }
      },
      action: {
        title: 'Action <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
        width: '1%',
        sorting:false,
        display:function(data){
          var service_id    = data.record.service_id;
          var disable_click = data.record.disable_click;

          var text = '<a href="javascript:void(0)" class="openServicesStaff openAllocation openAllocation_'+data.record.client_id+' '+disable_click+'" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'" data-page_name="allocation">Edit</a>';
          return '<div class="center">'+text+'</div>';
        }
      },
      staff1: {
        title: '<div class="head_">Responsible staff</div>',
        //title: '/jtable/action?action=getHeading&location=1',
        width: '4%',
        sorting:false,
        display: function(data) {
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              if(v.staff_name1 != '' && v.staff_name1 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name1 != ''){
                text += '<option value="'+v.staff_id1+'">'+v.staff_name1+'</option>';
              }
            })
            text += '</select>';
          }
          return '<div class="center orgStaff_1_'+data.record.client_id+'">'+text+'</div>';
        }
      },
      staff2: {
        title: 'Junior',
        width: '4%',
        sorting:false,
        display: function(data) {
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              if(v.staff_name2 != '' && v.staff_name2 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name2 != ''){
                text += '<option value="'+v.staff_id2+'">'+v.staff_name2+'</option>';
              }
            })
            text += '</select>';
          }
          return "<div class='center'>"+text+"</div>";
        }
      },
      staff3: {
        title: 'Reviewer',
        width: '4%',
        sorting:false,
        display: function(data) {
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              if(v.staff_name3 != '' && v.staff_name3 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name3 != ''){
                text += '<option value="'+v.staff_id3+'">'+v.staff_name3+'</option>';
              }
            })
            text += '</select>';
          }
          return "<div class='center'>"+text+"</div>";
        }
      },
      staff4: {
        title: 'Manager',
        width: '4%',
        sorting:false,
        display:function(data){
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              if(v.staff_name4 != '' && v.staff_name4 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name4 != ''){
                text += '<option value="'+v.staff_id4+'">'+v.staff_name4+'</option>';
              }
            })
            text += '</select>';
          }
          return "<div class='center'>"+text+"</div>";
        }
      },
      staff5: {
        title: 'Partner',
        width: '4%',
        sorting:false,
        display: function(data) {
          var text = "";
          var allocationStaff = data.record.allocationStaff;
          var i = 0;
          if(allocationStaff.length >0){
            $.each(allocationStaff, function(k,v){
              if(v.staff_name5 != '' && v.staff_name5 !== undefined){
                i = parseInt(i) + 1;
              }
            })
          }

          if(i >0){
            text += '<select class="form-control newdropdown">';
            $.each(allocationStaff, function(k,v){
              if(v.staff_name5 != ''){
                text += '<option value="'+v.staff_id5+'">'+v.staff_name5+'</option>';
              }
            })
            text += '</select>';
          }
          return "<div class='center'>"+text+"</div>";
        }
      }
      
    }
  });

  $('#clientListsSearchButton').click(function (e) {
    e.preventDefault();
    var client_type = $('#client_type').val();
    var client_type = $('#client_type').val();
    if(client_type == 'org'){
      refresh_table();
    }else{
      refresh_ind_table();
    }
  });

  $('#clientListsSearchText, #indClientListsSearchText').keyup(function (e) {
    e.preventDefault();
    var client_type = $('#client_type').val();
    if(client_type == 'org'){
      refresh_table();
    }else{
      refresh_ind_table();
    }
  });

  $('#clientListsSearchButton').click();

// check all check box
  $('#CheckorgCheckbox').click(function (e) {
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
  var client_type = $('#client_type').val();
  var service_id  = $("#"+client_type+"_service_id").val();
  if(client_type == 'org'){
    var search    = $('#clientListsSearchText').val();
    $('#clientListsTable').jtable('load', { search: search, 'service_id':service_id });
  }else{
    var search    = $('#indClientListsSearchText').val();
    $('#indClientListsTable').jtable('load', { search: search, 'service_id':service_id });
  }
  
}

function refresh_ind_table()
{
  var client_type = $('#client_type').val();
  var search      = $('#indClientListsSearchText').val();
  var service_id  = $("#"+client_type+"_service_id").val();
  $('#indClientListsTable').jtable('load', { search: search, 'service_id':service_id });
}