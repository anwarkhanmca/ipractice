$(document).ready(function () {
  window.setTime = 10000;
  $('#todoTable').jtable({
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'created DESC',

      actions: {
        listAction: '/jtable/action?action=todoPendingTable'
      },
      fields: {
        id: {
          title: 'Action',
          width: '0.5%',
          sorting:false,
          display:function(data){
            //return '<input type="checkbox" class="WipCheckbox" name="wipCheck[]" value="'+data.record.id+'"></div>';
            return '<div class="align_center"><a href="javascript:void(0)" class="deltask"  data-task_id="'+data.record.id+'" data-task_type="todo" ><img src="/img/cross.png" height="12" /></a></div>';
          }
        },
        created: {
          title: 'Task Date',
          width: '5%',
          //sorting:false,
          display:function(data){
            return data.record.created;
          }
        },
        service_name: {
          title: 'Task Name',
          display:function(data){
            if(data.record.status == 'Allocate Job'){
              return '<a href="javascript:void(0)">'+data.record.service_name+'</a>';
            }else{
              return '<a href="javascript:void(0)" class="tasknamed" data-taskid="'+data.record.id+'">'+data.record.service_name+'</a>';
            }
          }
        },
        client_name: {
          title: 'Client Name',
          display:function(data){
            return data.record.client_name
          }
        },
        staff_name: {
          title: 'Staff Name',
          width: '4%',
          display: function(data) {
            return data.record.staff_name;
          }
        },
        attachment: {
          title: 'Attachment',
          width: '3%',
          sorting:false,
          display: function(data) {
            var text = '';
            var attachment = data.record.attachment
            if(attachment.length >0){
              text = '<a href="uploads/todolist/'+data.record.group_id+'/'+data.record.attachment+'" download="'+data.record.attachment+'"><img src="/img/attachment.png" width="15"></a>';
            }
            return text;
          }
        },
        status: {
          title: 'Status',
          width: '5%',
          sorting:false,
          display: function(data) {
            var statusDrop = data.record.statusDrop;
            var option = '<select id="taskstatus" data-statusid="'+data.record.id+'" name="status" class="form-control newdropdown">';
            $.each(statusDrop, function(k,v){
              var selected = (v == data.record.status)?'selected':'';
              option += '<option value="'+k+'" '+selected+'>'+v+'</option>';
            });
            option += '</select>';
            
            return option;
          }
        },
        timeline: {
          title: 'Timeline',
          width: '5%',
          sorting:false,
          display: function(data) {
            return data.record.timeline;
          }
        },
        notes: {
          title: 'Notes',
          width: '2%',
          sorting:false,
          display: function(data) {
            var notes = data.record.notes;
            if(notes.length >0){
              var text = '<a href="#" id="tasknotesopen" data-id="'+data.record.id+'" data-toggle="modal" data-target="#tasknotes-modal"><span style="border-bottom:3px dotted #3a8cc1 !important" class="notes_btn">Notes</span></a>';
            }else{
              var text = '<a href="#" id="tasknotesopen" data-id="'+data.record.id+'" data-toggle="modal" data-target="#tasknotes-modal"><span class="notes_btn">Notes</span></a>';
            }
            return text;
          }
        }
      }
  });

  $('#todoSearchButton').click(function (e) {
      e.preventDefault();
      $('#todoTable').jtable('load', { search: $('#todoSearchText').val(), timeline:$('#todoSearchDrop').val() });
  });

  $('#todoSearchText').keyup(function (e) {
    e.preventDefault();
    clearTimeout(window.timeoutId);
    $('#todoTable').jtable('load', { search: $(this).val(), timeline:$('#todoSearchDrop').val() });
    window.timeoutId = setTimeout(viewSentEmail, window.setTime);
  });

  $('#todoSearchDrop').change(function (e) {
    e.preventDefault();
    clearTimeout(window.timeoutId);
    $('#todoTable').jtable('load', { search: $('#todoSearchText').val(), timeline:$('#todoSearchDrop').val() });
    window.timeoutId = setTimeout(viewSentEmail, window.setTime);
  });

  $('#todoSearchButton').click();

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




// notes pop up 
  /*$("body").on('click', ".openWipNotesPopup", function(){
    var id = $(this).data("id");
    
    $.ajax({
      url: "/proposal/action",
      type: "POST",
      dataType : 'json',
      data : {'id':id, 'action':'getWipNotes' },
      beforeSend : function(){
        $("#wipNotesTextareaTd").html('');
        $("#openWipNotesPopup-modal").modal("show");
      },
      success: function (resp) {
        $('#wipNotesTextareaTd').html(resp.notes);
      }
    });
  });*/



  


  
  









//viewSentEmail();

});

$(window).load(function() {
  //viewSentEmail();
  window.timeoutId = setTimeout(viewSentEmail, window.setTime);
});

function viewSentEmail()
{
  var page_open = $("input[name=page_open]").val();
  if(page_open == '11'){
    //var timeoutId = setTimeout(viewSentEmail, 10000);
    $.ajax({
      type: "POST",
      //dataType: "json",
      //url: '/todolist/action',
      url:'/email_context/todolist.php',
      //data: { 'action': 'viewSentEmail' },
      success: function(resp) {
        if(resp > 0){console.log('get'+resp);
          $('#todoTable').jtable('load', { search: $('#todoSearchText').val(), timeline:$('#todoSearchDrop').val() });
        }
      }
    });
  }
}