$(document).ready(function() {
  $(".dropdowndisable").prop("disabled", true);

  $(".statechage").on('change', function(){
    var fncArray = [];
    var statevalue  = $(this).val();
    var res         = statevalue.split("||");
    var statename   = res[0]
    var holidayrequest_id=res[1]
    var stafftype   = $("#stafftype").val();
    var date        = $(this).data('date');
    var staff_name  = $(this).data('staff_name');
    var format_date = $(this).data('format_date');
    var staff_id    = $(this).data('staff_id');

    fncArray['date']        = date;
    fncArray['request_id']  = holidayrequest_id;
    fncArray['stafftype']   = stafftype;
    fncArray['staff_name']  = staff_name;
    fncArray['format_date'] = format_date;
    fncArray['staff_id']    = staff_id;

    if(statename == 'Who else is off'){
      getWhoElseIsOff(fncArray);
    }else if(statename == 'Check Tasks Deadlines'){
      getCheckTaskDeadlines(fncArray);
    }else{
      $.ajax({
    		type: "POST",
    		url: '/statechange',
    		data: {
    			'statename': statename,'holidayrequest_id': holidayrequest_id
    		},
    		success: function(resp) {
          //window.location.reload();
    			if(stafftype =="staff"){
            //window.location = '/staff-holidays/c3RhZmY=/1';
          }else{
            //window.location = '/staff-holidays/cHJvZmlsZQ==/1';
          }
    		}
    	});
    }
  });


  $(".editrequest").on('click', function(){
    var holidayrequest_id = $(this).attr('data-rowid');
    //console.log(holidayrequest_id);return false;
    $.ajax({
    	type: "POST",
    	url: '/getrequestdetails',
    	data: {'holidayrequest_id': holidayrequest_id },
    	success: function(resp) {
    	  $("#edittafdpick").val(resp.date);
        $("#editdue").val(resp.duration);
        $("#edittype").val(resp.requesttype);
        $("#editstaff_id").val(resp.staff);
        $("#editfontnotesss").val(resp.notes)
        $("#editnotesstaff").val(resp.notes)

        $("#editid").val(resp.holidayrequest_id)

        if(resp.state=="Declined" || resp.state=="Approved" ){

          $('#editstaff_id, #editdue, #edittype, #editnotes, #edittafdpick').addClass('disable_click');

          $("#submitforapproval").hide();
        }else{
          $('#editstaff_id, #editdue, #edittype, #editnotes, #edittafdpick').removeClass('disable_click')
          $("#submitforapproval").show();
        }
        $("#staffeditcompose-modal").modal("show");
      }
    });

  });


  $("#editsave_staffnotes").on('click', function(){
    var editnotes = $("#editfontnotesss").val();
    $("#editnotesstaff").val(editnotes);
    $("#editfontnotes-modal").modal("hide");
  });

  $(".notesaddfont").on('click', function(){
    var key = $(this).attr('data-key');
    var notesval = $('#notesstaff'+key).val();
    $('#addfontnotesss').val(notesval);
    $('#hidNoteKey').val(key);
    $("#addfontnotes-modal").modal("show");
  });

  $(".open_edit_holiday").on('click', function(){
    var staff_id = $(this).data("staff_id");
    $('#note_staff_id').val(staff_id);

    $('#emp_start_date').val($('#start_dt_'+staff_id).html());
    $('#ent_per_year').val($('#ent_days_'+staff_id).html());
    $('#pop_days_taken').val($('#days_taken_'+staff_id).html());
    
    $("#holiday_details-modal").modal("show");
  });

  $(".save_holiday_details").on('click', function(){
    var staff_id    = $('#note_staff_id').val();
    var start_date  = $('#emp_start_date').val();
    var ent_days    = $('#ent_per_year').val();
    var days_taken  = $('#pop_days_taken').val();
    var holiday_start  = $('#start_date').val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/save-staff-holiday',
      data: {'holiday_start': holiday_start, 'staff_id': staff_id, 'start_date': start_date, 'ent_days': ent_days, 'days_taken': days_taken, 'action':'1' },
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
      },
      success: function(resp) {
        window.location.reload();
        /*$(".show_loader").html('');
        $('#start_dt_'+staff_id).html(resp.start_date);
        $('#ent_days_'+staff_id).html(resp.ent_days);
        $('#days_taken_'+staff_id).html(resp.days_taken);
        $('#current_'+staff_id).html(resp.current_days_taken);
        $('#remaining'+staff_id).html(resp.remaining);
        $("#holiday_details-modal").modal("hide");*/
      }
    });
  });

  $(".open_holiday_notes").on('click', function(){
    var staff_id = $(this).data("staff_id");
    var notes = $('#notes_'+staff_id).val();
    $('#note_staff_id').val(staff_id);
    $('#holiday_notes').val(notes);
    
    $("#holiday-modal").modal("show");
  });

  $("#save_holiday_notes").on('click', function(){
    var notes     = $("#holiday_notes").val();
    var staff_id  = $('#note_staff_id').val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/save-staff-holiday',
      data: {'staff_id': staff_id, 'notes': notes, 'action':'2' },
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
      },
      success: function(resp) {
        $(".show_loader").html('');
        $('#notes_'+staff_id).val(notes);
        $("#holiday-modal").modal("hide");
      }
    });
  });

  $('body').on('click', ".open_holiday_pop", function(){
    var value       = $(this).data('value');
    var position    = $(this).data('position');
    var staff_type  = $('#staff_typeid').val();
    var start_date  = $('#encode_start_date').val();
    /*$.ajax({
      type: "POST",
      dataType: "json",
      url: '/sh/get-confirm-rollover',
      data: {'start_date': start_date, 'staff_type': staff_type },
      success: function(resp) {
        $("#pop_holiday_date").val(value);
        $("#holiday_year-modal").modal("show");
      }
    });*/
    
    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/sh/get-staff-holiday',
      data: {'start_date': start_date, 'action':'2' },
      beforeSend : function(){
        $("#position").val(position);
      },
      success: function(resp) {
        $("#pop_holiday_date").val(resp.holiday_details.holiday_date);
        $.each(resp.staff_holiday, function(index, value){
          var staff_id = resp.staff_holiday[index].staff_id;
          $(".days_taken_"+staff_id).val(resp.staff_holiday[index].days_taken);
        });
        $("#holiday_year-modal").modal("show");
      }
    });
  });

  $(".save_holiday").on('click', function(){
    var field_value = $("#pop_holiday_date").val();
    var field_name  = $('#field_name').val();
    if(confirm("Please note this will zero out 'Days Taken - opening balances' and the 'Days Remaining - Last Year'")){
      save_holiday_details(field_name, field_value);
    }
  });

  $(".timeoff_type").on('change', function(){
    var field_value = $(this).val();
    var field_name  = 'timeoff_type_id';
    save_holiday_details(field_name, field_value);
  });
  $('#allow_rollover').on('ifChecked', function(event){
    save_holiday_details('allow_rollover', 'Y');
  });

  $('#allow_rollover').on('ifUnchecked', function(event){
    save_holiday_details('allow_rollover', 'N');
  });

  $(".open_holiday_type").on('click', function(){
    $("#open_holiday_type-modal").modal("show");
  });
  $(".save_type").on('click', function(){
    var name = $('#pop_holiday_type').val();
    var color = $('#pop_color').val();
    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/sh/save-holiday-type',
      data: {'name': name, 'color': color },
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
      },
      success: function(resp) {
        $(".show_loader").html('');
        $('#pop_holiday_type').val('');
        $('#pop_color').val('');

        var type_value = "<div id='hide_type_div_"+resp.type_id+"'>";
        type_value += '<div class="pop_left">';
        type_value += '<a href="javascript:void(0)" title="Delete Field ?" class="delete_holiday_type" data-field_id="'+resp.type_id+'"><img src="/img/cross.png" width="12"></a> ';
        type_value += resp.name+'</div><div class="pop_right" style="background-color:#'+resp.color+';"></div><div class="clearfix"></div></div>';
        //alert(type_value)
        $('#append_type').append(type_value);
        var option = '<option value="'+resp.type_id+'">'+resp.name+'</option>';
        $('.timeoff_type option:last').after(option);
        $('.requesttype option:last').after(option);
        //$("#open_holiday_type-modal").modal("hide");


          
      }
    });
  });
  $('body').on('click', ".delete_holiday_type", function(){
    var type_id = $(this).data('field_id');
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/sh/delete-holiday-type',
      data: {'type_id': type_id },
      success: function(resp) {
        $('#hide_type_div_'+type_id).hide();
      }
    });
  });

  $('.header_select').on('change', function(){
    var staff_type  = $('#staff_typeid').val();
    if(staff_type == 'staff'){
      var staff_id  = $('#staffmDetails').val();
    }else{
      var staff_id  = $('#logged_id').val();
    }
    var type_id     = $('#head_type_drop').val();
    var start_date  = $('#start_date').val();

    if(staff_id != "" && type_id != ""){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/sh/get-holiday-details',
        data: {'staff_id': staff_id, 'type_id': type_id, 'start_date': start_date },
        beforeSend : function(){

        },
        success: function(resp) {
          
          if(type_id == 1){
            $('#head_days_taken').val(resp.current_days_taken);
            $('#remainDiv').show();
            $('#head_days_remain').val(resp.total_leave);
          }else{
            $('#head_days_taken').val(resp.holiday_days_taken);
            $('#head_days_remain').val('');
            $('#remainDiv').hide();
          }
        }
      });
    }else{
      $('#head_days_taken').val('');
      $('#head_days_remain').val('');
    }
  });

  $(".current_roll_fwd").on('click', function(){
    var staff_type = $('#encode_staff_type').val();
    var start_date = $('#encode_start_date').val();

    var field_value = $(this).data('next_date');
    if(field_value == ""){
      alert("Please add current holiday date first");
      return false;
    }else{//allow_rollover
      if(confirm("Do you want to start a new holiday year?")){
        if($("#allow_rollover").is(':checked')){
          $.ajax({
            type: "POST",
            dataType: "json",
            url: '/sh/get-confirm-rollover',
            data: {'start_date': start_date, 'staff_type': staff_type },
            success: function(resp) {
              $.each(resp, function(index, value){
                $(".days_taken_"+resp[index].user_id).val(resp[index].total_leave);
              });
              $("#confirm_balance_roll-modal").modal("show");
            }
          });
        }else{
          window.location = '/sh/goto-rollfwd/'+staff_type+'/'+field_value;
        }
      }
    }

    //$("#confirm_balance_roll-modal").modal("show");
    //save_holiday_details('roll_date', field_value);
    //window.location = '/staff-holidays/'+staff_type+'/6/'+start_date;
  });

  $(".not_roll_back").on('click', function(){
    alert('Holiday year can not be rolled back beyond current year');
    return false;
  });

  $("#search_display").on('click', function(){
    var val = [];
    $(".search_staff_id:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });

    var staff_id    = val;
    var start_date  = $('#holiday_start').val();
    var end_date    = $('#holiday_end').val();
    //alert(staff_id);return false;
    
    if(staff_id.length == '0'){
      alert('Please select staff name');
      $('#search_staff_id').focus();
      return false;
    }else if(start_date == ''){
      alert('Please select Start date');
      $('#holiday_start').focus();
      return false;
    }else if(end_date == ''){
      alert('Please select end date');
      $('#holiday_end').focus();
      return false;
    }else{
      $.ajax({
        type: "POST",
        dataType: "html",
        url: '/sh/search-holiday',
        data: {'start_date': start_date, 'end_date': end_date, 'staff_id': staff_id },
        beforeSend : function(){
          $("#search_data").html('<div align="center"><img src="/img/spinner.gif" /></div>');
        },
        success: function(resp) {
          $("#search_data").html(resp);
        }
      });
    }
  });

  /*$("#search_display").on('click', function(){
    var val = [];
    $(".search_staff_id:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });

    var staff_id    = val;
    var start_date  = $('#holiday_start').val();
    var end_date    = $('#holiday_end').val();
    
    if(staff_id.length == '0'){
      alert('Please select staff name');
      $('#search_staff_id').focus();
      return false;
    }else if(start_date == ''){
      alert('Please select Start date');
      $('#holiday_start').focus();
      return false;
    }else if(end_date == ''){
      alert('Please select end date');
      $('#holiday_end').focus();
      return false;
    }else{
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/sh/search-holiday',
        data: {'start_date': start_date, 'end_date': end_date, 'staff_id': staff_id },
        beforeSend : function(){
          $("#search_data").html('<div align="center"><img src="/img/spinner.gif" /></div>');
        },
        success: function(resp) {
          $(".search_date").html(resp.search_date);

          var content = "<ul>";
          $.each(resp.details, function(index, value){
            content += '<li>';
            content += '<div class="leave_box pull-left" style="background:#'+resp.details[index].color_code+';"></div>'; 
            content += '<div class="text">'+resp.details[index].type_name+'</div><br>';
            content += '<div class="font_size"><strong>Date: </strong>'+resp.details[index].date_show+'</div>';
            content += '<div class="font_size"><strong>Time: </strong>'+resp.details[index].duration+'</div>';
            content += '<div class="font_size"><strong>Notes: </strong>'+resp.details[index].notes+'</div></li>';
          });
          content += '</ul>';
          $("#search_data").html(content);
        }
      });
    }
  });*/

  $(".openNewRequest").on('click', function(){
    var start_date = $("#start_date").val();
    if(start_date == 'new'){
      alert('Please, first , Set holiday year date in settings');
      return false;
    }else{
      $("#staffcompose-modal").modal("show");
    }
  });


  $("body").on('click', '.showTasks', function(){
    var service_id  = $(this).data('service_id');
    var status      = $(this).data('status');
    var staff_id    = $('#tasks_staff_id').val();
    var heading     = $("#tasks_heading").val();

    $.ajax({
      type: "POST",
      url: '/sh/show-tasks',
      data: {'service_id':service_id, 'staff_id':staff_id, 'status':status },
      beforeSend : function(){
        $("#show_tasks-modal .show_loader").html('<img src="/img/spinner.gif" />');
        $("#show_tasks-modal").modal("show");
      },
      success: function(resp) {
        $("#show_tasks-modal .show_loader").html(heading);
        $('.show_tasks').html(resp);   
      }
    });
  });

  /*$('body').on('click', ".open_adddrop", function(event) {
      var client_id = $(this).data("client_id");
      var tab = $(this).data("tab");
      $(".open_dropdown_"+client_id+"_"+tab).toggle();
      event.stopPropagation();
  });*/

  /* ################# Open Notes Popup Start ################### */
  $("body").on('click', '.open_notes_popup', function(){
    var client_id = $(this).data("client_id");
    var tab = $(this).data("tab");
    var service_id = $("#service_id").val();
    var job_status_id = $(this).data("job_status_id");

    $.ajax({
        type: "POST",
        dataType : "json",
        url: "/jobs/show-jobs-notes",
        data: { 'client_id': client_id, 'service_id' : service_id, 'tab' : tab, 'job_status_id' : job_status_id },
        success: function (resp) {
          $("#notes_client_id").val(client_id);
          $("#notes_tab").val(tab);

          $("#notes").val(resp['notes']);
          $("#notes-modal").modal("show");             
        }
    });
      
  });
/* ################# Save Notes Popup End ################### */


  $('body').on('click', ".open_adddrop", function(event) {
    var client_id = $(this).data("client_id");
    var tab = $(this).data("tab");
    $(".open_dropdown_"+client_id+"_"+tab).toggle();
    event.stopPropagation();
  });
  


  

});//document end

function fetchnotesmodal(value)
{
  $.ajax({
    type: "POST",
    url: '/getrequestdetails',
    data: {'holidayrequest_id': value },
    beforeSend : function(){
      $(".show_loader").html('<img src="/img/spinner.gif" />');
    },
    success: function(resp) {
      $(".show_loader").html('');
      $("#fetchnotess").val(resp.notes);
      $("#fetchcomposenotes-modal").modal("show");
    }
  });  
}

function save_holiday_details(field_name, field_value)
{
  var staff_type = $('#encode_staff_type').val();

  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/save-holiday',
    data: {'field_name': field_name, 'field_value': field_value },
    beforeSend : function(){
      $(".show_loader").html('<img src="/img/spinner.gif" />');
    },
    success: function(resp) {
      $(".show_loader").html('');
      if(field_name == 'holiday_date'){
        var date_value = '<a href="javascript:void(0)" class="open_holiday_pop" data-value="'+resp.holiday_date+'">'+resp.holiday_date+'</a> - '+resp.holiday_end;
        //alert(date_value)
        $('.holiday_year_span').html(date_value);
        window.location.reload();
      }
      if(field_name == 'roll_date'){
        window.location = '/staff-holidays/'+staff_type+'/6/'+resp.encode_start_date;
      }
      
      $("#holiday_year-modal").modal("hide");
    }
  });
}


function getWhoElseIsOff(fncArray)
{
  var date        = fncArray['date'];
  var request_id  = fncArray['request_id'];
  var stafftype   = fncArray['stafftype'];
  var staff_name  = fncArray['staff_name'];
  var format_date = fncArray['format_date'];

  $.ajax({
    type: "POST",
    //dataType: "json",
    url: '/sh/get-who-else-is-off',
    data: {'date': date, 'stafftype' : stafftype },
    beforeSend : function(){
      $('.show_who_else').html('');   
      $(".show_loader").html('<img src="/img/spinner.gif" />');
      $("#whoelseis-modal").modal("show");
    },
    success: function(resp) {
      $(".show_loader").html('<strong>Time off Request for '+staff_name+' on '+format_date+'</strong>');
      $('.show_who_else').html(resp);   
    }
  });
}

function getCheckTaskDeadlines(fncArray)
{
  var date        = fncArray['date'];
  var request_id  = fncArray['request_id'];
  var stafftype   = fncArray['stafftype'];
  var staff_name  = fncArray['staff_name'];
  var format_date = fncArray['format_date'];
  var staff_id    = fncArray['staff_id'];

  $.ajax({
    type: "POST",
    //dataType: "json",
    url: '/sh/get-check-task-deadlines',
    data: {'date': date, 'stafftype' : stafftype },
    beforeSend : function(){
      $('#tasks_staff_id').val(staff_id);
      $('.show_deadlines').html('');   
      $(".show_loader").html('<img src="/img/spinner.gif" />');
      $("#task_deadline-modal").modal("show");
    },
    success: function(resp) {
      var heading = '<strong>Time off Request for '+staff_name+' on '+format_date+'</strong>';
      $(".show_loader").html(heading);
      $("#tasks_heading").val(heading);
      $('.show_deadlines').html(resp);   
    }
  });
}
      