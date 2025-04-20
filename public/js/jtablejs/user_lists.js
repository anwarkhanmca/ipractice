$(document).ready(function(){

  $('#userListsTable').jtable({
    paging: true,
    sorting: true,
    pageSize: 10,
    defaultSorting: 'staffName ASC',

    actions: {
      listAction: '/jtable/action?action=userLists'
    },
    rowInserted : function(event, data) 
    {
      if(data.record.show_archive == 'Y'){
        $('.archiveRow_'+data.record.user_id).closest('.jtable-data-row').css({'background':'#ccc'});
      }
    },
    fields: {
      user_id: {
        title: '<div style="padding-left:8px;"><input type="checkbox" class="CheckHead" id="allCheckSelect"></div>',
        width: '0.5%',
        sorting:false,
        display:function(data){
          var text = '<input type="checkbox" data-archive="'+data.record.show_archive+'" class="ads_Checkbox" name="staff_delete_id[]" value="'+data.record.user_id+'">';
          return '<div class="align_center archiveRow_'+data.record.user_id+'">'+text+'</div>';
        }
      },
      staffName: {
        title: 'Staff Name',
        width: '5%',
        display:function(data){
          var text = '<a href="/my-details/'+data.record.user_id+'/'+data.record.staff_encode+'">'+data.record.staff_name+'</a>';
          return text;
        }
      },
      position_name: {
        title: 'Position/Job Title',
        width: '3%',
        display:function(data){
          var text = data.record.position_name;
          return text;
        }
      },
      start_date: {
        title: 'Date Joined',
        width: '2%',
        sorting:false,
        display:function(data){
          var text = data.record.start_date;
          return '<div class="center">'+text+'</div>';
        }
      },
      ni_number: {
        title: 'NI Number',
        width: '2%',
        display:function(data){
          var text = data.record.ni_number;
          return '<div class="center">'+text+'</div>';
        }
      },
      dob: {
        title: 'DOB',
        width: '2%',
        sorting:false,
        display: function(data) {
          var text = data.record.dob;
          return '<div class="center">'+text+'</div>';
        }
      },
      department_name: {
        title: 'Department',
        width: '4%',
        display: function(data) {
          var text = data.record.department_name;
          return text;
        }
      },
      address: {
        title: 'Address',
        width: '10%',
        sorting:false,
        display: function(data) {
          //var string = data.record.address;
          //var address = (string.length > '45')?string.substring(0,45)+'...<a href="javascript:void(0)" class="more_address" data-user_id="'+data.record.user_id+'">more</a>':string;
          var address = data.record.address;
          return '<span class="fullAddr'+data.record.user_id+'">'+address+'</span>';
        }
      },
    }
  });

  $('#userListsSearchButton').click(function (e) {
    e.preventDefault();
    refresh_table();
  });

  $('#userListsSearchText').keyup(function (e) {
    e.preventDefault();
    refresh_table();
  });

  $('#userListsSearchButton').click();

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
  $('#userListsTable').jtable('load', { search: $('#userListsSearchText').val() });
}

