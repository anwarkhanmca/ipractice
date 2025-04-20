$(document).ready(function () {
  $(".open_adddrop").click(function(event) {
    var client_id = $(this).data("client_id");
    var tab = $(this).data("tab");
    $(".open_dropdown_"+client_id+"_"+tab).toggle();
    event.stopPropagation();
  });

  /* ################# Job Start Date in job section start ################### */
  $(".open_calender_pop").click(function(){
      var task_id       = $(this).data('task_id');
      var task_type     = $(this).data('task_type');
      var tab           = $(this).data('tab');
      var date          = $(this).data('calender_date');
      var time          = $(this).data('calender_time');
      if(date == "" || date == 'undefined'){
        var calender_date = "";
      }else{
        var new_date      = date.split('-');
        var calender_date = new_date[2]+'-'+new_date[1]+'-'+new_date[0];
      }
      if(time == "" || time == 'undefined'){
        var calender_time = "";
      }else{
        var new_time      = time.split(':');
        var calender_time = new_time[0]+' : '+new_time[1];
      }
      
      $("#calender_task_id").val(task_id);
      $("#calender_tab").val(tab);
      $("#calender_date").val(calender_date);
      $("#calender_time").val(calender_time);
      $("#calender_task_type").val(task_type)

      $(".open_dropdown_"+task_id+"_"+tab).hide();
      $("#addto_calender-modal").modal("show");
  });

  $(".save_calender_date").click(function(){
    var calender_time   = $("#calender_time").val();
    var calender_date   = $("#calender_date").val();
    var task_id         = $("#calender_task_id").val();
    var task_type       = $("#calender_task_type").val();

    $.ajax({
      type: "POST",
      url: '/ajax-save-task',
      data: { 'task_id' : task_id, 'task_type' : task_type, 'calender_date' : calender_date, 'calender_time': calender_time },
      beforeSend : function(){
          $("#start_date_loader").html('<img src="/img/spinner.gif" />');
      },
      success : function(resp){
        window.location.reload();
      }
    });
  }); 
/* ################# Job Start Date in job section end ################### */

/* ################# Delete Task Start ################### */
  $("body").on('click', ".deltask", function(){
    var task_id       = $(this).data('task_id');
    var task_type     = $(this).data('task_type');
    if(!confirm("Do you want to delete this task?")){
      return false;
    }
    $.ajax({
      type: "POST",
      //url: '/ajax-save-task',
      url: '/ajax-delete-task',
      data: { 'task_id' : task_id, 'task_type' : task_type },
      success : function(resp){
        //window.location.reload();
        if(task_type == 'todo'){
          $('#todoTable').jtable('load', { search: $('#todoSearchText').val(), timeline:$('#todoSearchDrop').val() });
        }else{
          $('.del_tr_'+task_id).hide();
        }
      }
    });
  }); 
/* ################# Delete Task end ################### */

});//document end

$("body").on("click", "#tasknotesopen", function(){ 
  var tasknotesid = $(this).attr('data-id');
  $.ajax({
		type: "POST",
		//dataType: "html",
		url: '/view-tasknotes',
		data: { 'tasknotesid': tasknotesid },
    beforeSend: function() {
      // $("#notes_font").html('<img src="/img/ajax-loader1.gif" />');
    },
    success: function(resp) {
		  $("#notestask").html(resp);
    }
	});
});

$("body").on("click", ".tasknamed", function(){ 
  $('#wipActionDrop').removeClass('open');

  var edittasknotesid =$(this).attr('data-taskid');

  if(edittasknotesid == '0'){
    $('#editrowid').val(edittasknotesid);
    $('.actionType').html('Add New Task');
    $('#edittaskname').val('');
    $('#notesid').val('');
    $('#rel_client_id_edit').val('');
    $('#staff_id_edit').val('');
    $('#attachfilename').empty().html('');
    $('#editattachmentfile').val('');
    $('#FeeAmount').val('');

    $("#edittaskcompose-modal #editnotesArea").html('<textarea class="form-control classy-editor" rows="5" name="editnotes" id="notesid"></textarea>');
    $(".classy-editor").ClassyEdit();

    $("#edittaskcompose-modal").modal("show");
    return false;
  }
  $.ajax({
    type: "POST",
    url: '/gettaskdetais',
    data: { 'edittasknotesid': edittasknotesid },
    beforeSend : function(){
      $('.actionType').html('Edit Task');
      $('#editrowid').val(edittasknotesid);
      $("#edittaskcompose-modal").modal("show");
    },
    success: function(resp) {
      $('#edittaskname').val(resp.taskname);
    	$('#edittaskcompose-modal #amount').val(resp.amount);
      $('#edittaskdate').val(resp.taskdate);
      $('#edittask_time').val(resp.task_time);
      $('#rel_client_id_edit').val(resp.rel_client_id);
      $('#staff_id_edit').val(resp.staff_id);
      $('#attachfilename').empty().html(resp.add_file);
      $('#editattachmentfile').val(resp.add_file);
      $('#FeeAmount').val(resp.amount);

      $("#edittaskcompose-modal #editnotesArea").html('<textarea class="form-control classy-editor" rows="5" name="editnotes" id="notesid">'+resp.notes+'</textarea>');
      $(".classy-editor").ClassyEdit();
      
      if(resp.urgent =="Y"){
        $("#yess").iCheck('check')
      }else{
        $("#noo").iCheck('check')
      }

      if(resp.is_billable =="Y"){
        $("#billYes").iCheck('check')
      }else{
        $("#billNo").iCheck('check')
      }
    }
  });
});

$("body").on("change", "#taskstatus", function(){ 
  var statusid =$(this).attr('data-statusid');
  var status =$(this).val();
  $.ajax({
		type: "POST",
		//dataType: "html",
		url: '/statuschange',
		data: { 'statusid': statusid, 'status': status },
    beforeSend: function() {
      // $("#notes_font").html('<img src="/img/ajax-loader1.gif" />');
    },
    success: function(resp) {
		  //window.location.reload();
      $('#todoTable').jtable('load',{ search:$('#todoSearchText').val(), timeline:$('#todoSearchDrop').val() });
    }
	});
    
});
$("body").on("click", "#savetaskbtn", function(){
  var task=  $("#taskname").val();
  var date= $("#taskdate").val();
    
  if(task == "" || date=="" ){
    $("#errormsg").html('Task Name and Task Date fields are compulsory')
    return false;
  }else{
    return true;
  }
});



$("#editsavetaskbtn").click(function() {
  var added_from  = $("#added_from").val();
  var amount      = $("#FeeAmount").val();
  var task        = $("#edittaskname").val();
  var date        = $("#edittaskdate").val();
  var task_time   = $("#edittask_time").val();
  var client_id   = $("#rel_client_id_edit").val();
  var staff_id    = $("#staff_id_edit").val();

  if(added_from == 'todo'){
    var billable = $('#billYes').is(':checked');
    if(billable == true && amount == ''){
      $("#editerrormsg").html('Please enter the fee');
      return false;
    }
  }

  if(added_from == 'wip'){
    if(amount == ''){
      $("#editerrormsg").html('Please enter the fee');
      return false;
    }
  }

  if(task == ''){
    $("#editerrormsg").html('Please enter task name');
    return false;
  }else if(date=="" ){
    $("#editerrormsg").html('Task date field is compulsory')
    return false;
  }else if(task_time=="" ){
    $("#editerrormsg").html('Task time field is compulsory')
    return false;
  }else if(client_id=="" ){
    $("#editerrormsg").html('Please select client name');
    return false;
  }else{
    $("#basicform").ajaxForm({
      beforeSend : function(){
        clearTimeout(window.timeoutId);
        $("#editerrormsg").html('');
        $('.loader_show').html('<img src="/img/spinner.gif">');
      },
      success: function(response) {
        $('.loader_show').html('');
        if(added_from == 'todo'){
          $('#todoTable').jtable('load', { search: $('#todoSearchText').val(), timeline:$('#todoSearchDrop').val() });
          //$('.content_part').hide();
          //$('#editsuccessmsg').html('Job added to TODO list');
          //setTimeout(function(){ window.location.reload(); }, 5000);
        }
        if(added_from == 'wip' || added_from == 'tasks'){
          $('#wipTable').jtable('load', { search: $('#wipSearchText').val() });
        }
        $("#edittaskcompose-modal").modal("hide");

        window.timeoutId = setTimeout(viewSentEmail, window.setTime);
      }
    });
  }

});

$(".taskViaemail").click(function() {

  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/todolist/action',
    data: { 'action': 'getTodoEmail' },
    beforeSend: function() {
      $("#taskViaemail-modal .show_loader").html('<img src="/img/spinner.gif" />');
      $('#todoEmailDisplay tbody').html('');
      $("#taskViaemail-modal").modal("show");
    },
    success: function(resp) {
      $("#taskViaemail-modal .show_loader").html('');
      var details = resp.details;
      var td = '';
      $.each(details, function(k, v){
        td += '<tr>';
        td += '<td>'+v.user_name+'</td>';
        td += '<td>'+v.todo_email+'</td>';
        td += '</tr>';
      });
      $('#todoEmailDisplay tbody').html(td);
    }
  });
  
});


$(".billable").on('ifChecked', function(event){
  var value =  $(this).val();
  if(value == "Y"){
    $('#billableEvent').show();
  }else{
    $('#billableEvent').hide();
  }
});