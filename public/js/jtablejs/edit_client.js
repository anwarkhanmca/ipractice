$(document).ready(function(){

  $('#actHstryTable').jtable({
    paging: true,
    sorting: true,
    pageSize: 10,
    defaultSorting: 'date_time DESC',

    actions: {
      listAction: '/jtable/action?action=actHstryLists'
    },
    fields: {
      date_time: {
        title: 'Date &amp; Time',
        width: '2%',
        //sorting:false,
        display:function(data){
          var text = data.record.date_time;
          return text;
        }
      },
      client_type: {
        title: 'Item',
        width: '1%',
        sorting:false,
        display:function(data){
          var text = data.record.client_type;
          return '<div class="center">'+text+'</div>';
        }
      },
      staff_name: {
        title: 'User Name',
        width: '3%',
        display:function(data){
          var text = data.record.staff_name;
          return text;
        }
      },
      /*client_name: {
        title: 'Client Name',
        width: '4%',
        display:function(data){
          var text = data.record.client_name;
          return text;
        }
      },
      job_name: {
        title: 'Job Name',
        width: '4%',
        display:function(data){
          var text = data.record.job_name;
          return text;
        }
      },*/
      notes: {
        title: 'Notes',
        sorting:false,
        display:function(data){//alert(data.record.added_from)
          var text = data.record.notes;
          var client_type = data.record.client_type;
          if(client_type == 'Client Details'){
            text = '<a href="javascript:void(0)" class="openNotification" data-store_id="'+data.record.store_id+'" data-client_id="'+data.record.client_id+'">View Details >></a>';
          }else if(client_type == 'Files'){
            if(data.record.added_from == 'file_upload'){
              text = '<a href="/uploads/client_doc/'+text+'" target="_blank" data-store_id="'+data.record.store_id+'">['+text+'] Uploaded</a>';
            }else{
              text = '['+text+'] Deleted';
            }
          }
          //text += '<a href="javascript:void(0)" class="notes_btn activity_notes" data-store_id="'+data.record.store_id+'" data-notes="'+data.record.notes+'"><span style="">Notes</span></a>';
          return text;
        }
      }
    }
  });

  $('#actHstrySearchText').keyup(function (e) {
    e.preventDefault();
    refresh_table();
  });

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
  var client_id = $('#client_id').val();
  var search    = $('#actHstrySearchText').val();

  $('#actHstryTable').jtable('load', { search:search, client_id:client_id });
}

