$(document).ready(function () {
    $('.clockPop').click(function() {
        var service_id = $("#service_id").val();
        $.ajax({
            type: "POST",
            url: "/reminder/template-action",
            dataType: "json",
            data: { 'service_id': service_id, 'action':'getGlobalReminder' },
            beforeSend: function() {
                //$("#goto"+key).html('<img src="/img/spinner.gif" />');
                $('#clockPop-modal').modal('show');
            },
            success: function (resp) {//console.log(resp.details.taskstatus);return false;
                if(resp.details.deadline == 'Y'){
                    $('#global_reminder1').iCheck('check');
                }else{
                    $('#global_reminder1').iCheck('uncheck');
                }
                if(resp.details.taskstatus == 'Y'){
                    $('#global_reminder2').iCheck('check');
                }else{
                    $('#global_reminder2').iCheck('uncheck');
                }
            }
        });
        return false;
    });
    $('body').on('click', ".open_adddrop", function(event) {
      var client_id = $(this).data("client_id");
      var manage_id = $(this).data("manage_id");
      var tab = $(this).data("tab");
      //$(".atc-style-blue a").css("pointer-events", "pointer");
      
      //$(".cont_add_to_date").hide();
      $(".open_dropdown_"+manage_id+"_"+tab).toggle();
      event.stopPropagation();
    });

/* ================== Manage Tasks ================== */
    $(document).on("click", ".edit_status", function(){
        var step_id = $(this).data("step_id");
        var status_name = $("#status_span"+step_id).html();
        var text_field = "<input type='text' id='status_name"+step_id+"' value='"+status_name+"' style='width:100%; height:30px'>";
        var action = "<a href='javascript:void(0)' class='save_new_status' data-step_id='"+step_id+"'>Save</a>&nbsp;&nbsp;<a href='javascript:void(0)' class='cancel_edit' data-step_id='"+step_id+"'>Cancel</a>";
        $("#status_span"+step_id).html(text_field);
        $("#action_"+step_id).html(action);
    });

    $("#status-modal").on("click", ".cancel_edit", function(){
        var step_id = $(this).data("step_id");
        var status_name = $("#status_name"+step_id).val();
        var action = "<a href='javascript:void(0)' class='edit_status' data-step_id='"+step_id+"'><img src='/img/edit_icon.png'></a>";
        $("#status_span"+step_id).html(status_name);
        $("#action_"+step_id).html(action);
    });

    $("#status-modal").on("click", ".save_new_status", function(){
      var step_id = $(this).data("step_id");
      var status_name = $("#status_name"+step_id).val();
      //alert(status_name+" "+step_id);
      $.ajax({
        type: "POST",
        url: "/chdata/save-edit-status",
        //dataType: "json",
        data: { 'step_id': step_id, 'status_name' : status_name, 'type' : "title" },
        beforeSend: function() {
          //$("#goto"+key).html('<img src="/img/spinner.gif" />');
          
        },
        success: function (resp) {
          if(resp != ""){
              var action = "<a href='javascript:void(0)' class='edit_status' data-step_id='"+step_id+"'><img src='/img/edit_icon.png'></a>";
              $("#status_span"+step_id).html(status_name);
              $("#action_"+step_id).html(action);

              $("#step_field_"+step_id).text(status_name);
              $("#status_dropdown option[value='"+step_id+"']").html(status_name);
              $(".job_status_change option[value='"+step_id+"']").html(status_name);

              var StatusName = $("#statusFilterDrop option[value='"+step_id+"']").html();
              var lastItem = StatusName.split(" ").pop(-1);
              $("#statusFilterDrop option[value='"+step_id+"']").html(status_name+' '+lastItem);
              refresh_table();
          }else{
              alert("There are some problem to update status");
          }
            
        }
      });
    });

    $('#status-modal .status_check').on('ifChecked', function(event){
        var step_id = $(this).data("step_id");
        //alert(step_id);return false;
        if(step_id != ""){
            $.ajax({
                type: "POST",
                url: "/chdata/save-edit-status",
                data: { 'step_id': step_id, 'type' : "status" },
                success: function (resp) {
                  $("#statusFilterDrop option[value='"+step_id+"']").show();  
                  refresh_table();
                  /*$("#status_dropdown option[value='"+step_id+"']").show();    
                  $(".header_step_"+step_id).show();  
                  $(".task_status_change option[value='"+step_id+"']").show();   */    
                }
            });
        }
        
    });

    $('#status-modal .status_check').on('ifUnchecked', function(event){
        var step_id = $(this).data("step_id");
        //alert(step_id);return false;
        if(step_id != ""){
            $.ajax({
                type: "POST",
                url: "/chdata/save-edit-status",
                data: { 'step_id': step_id, 'type' : "status" },
                success: function (resp) {
                  $("#statusFilterDrop option[value='"+step_id+"']").hide();  
                  refresh_table();
                  /*$("#status_dropdown option[value='"+step_id+"']").hide();   
                  $(".header_step_"+step_id).hide();  
                  $(".task_status_change option[value='"+step_id+"']").hide();*/             
                }
            });
        }
    });

/* ################# Send to Task Management Start ################### */
    /*$(".send_manage_task").click(function(){
        var client_id = $(this).data("client_id");
        var field_name = $(this).data("field_name");
        //alert(step_id);return false;
        //if(confirm("Do you want to send the client to manage task ?")){
            $.ajax({
                type: "POST",
                url: "/chdata/send-manage-task",
                data: { 'client_id': client_id, 'field_name' : field_name },
                success: function (resp) {
                    $("#after_send_"+client_id).html('<button type="button" class="sent_btn">Sent</button>');              
                }
            });
        //}
        
    });*/
/* ################# Send to Task Management End ################### */


/* ################# Delete to Task Management Start ################### */
    $(".delete_manage_task").click(function(){
        var val = [];
        $(".checkbox:checked").each( function (i) {
            if($(this).is(':checked')){
                val[i] = $(this).val();
            }
        });
        //alert(val.length);return false;
        if(val.length>0){
            if(confirm("Do you want to Change the status?")){
                $.ajax({
                    type: "POST",
                    url: '/chdata/delete-manage-task',
                    data: { 'client_delete_id' : val },
                    success : function(resp){
                        
                            
                    }
                });
            }

        }else{
            alert('Please select atleast one clients');
        }
        
    });
/* ################# Delete to Task Management End ################### */

/* ################# Delete Single Task Management Start ################### */
    $(".delete_single_task").click(function(e){

        var client_id   = $(this).data('client_id');
        var manage_id   = $(this).data('manage_id');
        var tab         = $(this).data('tab');
        var service_id  = $("#service_id").val();
        var page_open   = $("#page_open").val();
        var prev_status = $("#prev_status_"+client_id).val();
        var click_element = e.target;
        //$(click_element).closest("tr").hide();return false;
        //if(confirm("Do you want to Delete the task?")){
            $.ajax({
                type: "POST",
                dataType:'json',
                url: '/jobs/delete-single-task',
                data: {'client_id':client_id,'service_id':service_id,'tab':tab,'manage_id':manage_id },
                success : function(resp){
                    if(page_open == 3){
                        //$("#data_tr_"+client_id+"_"+tab).hide();
                        $(this).closest("tr").hide();
                    }

                    var count_21 = $("#task_count_21").html();
                    $("#task_count_21").html(parseInt(count_21-1));

                    var prev_status = $("#"+tab+"_status_dropdown_"+client_id).val();
                    var task_count = $("#task_count_2"+prev_status).html();
                    $("#task_count_2"+prev_status).html(parseInt(task_count-1));

                    //$(".data_tr_"+client_id+"_"+tab).hide();
                    $(click_element).closest("tr").hide();

                    /*if(tab == 21){
                        var count_21 = $("#task_count_"+tab).html();
                        $("#task_count_"+tab).html(parseInt(count_21-1));

                        var prev_status = $("#"+tab+"_status_dropdown_"+client_id).val();
                        var task_count = $("#task_count_2"+prev_status).html();
                        $("#task_count_2"+prev_status).html(parseInt(task_count-1));

                        $(".data_tr_"+client_id+"_"+tab).hide(); 
                    }else{
                        var count_21 = $("#task_count_21").html();
                        $("#task_count_21").html(parseInt(count_21-1));

                        var prev_status = $("#"+tab+"_status_dropdown_"+client_id).val();
                        var task_count = $("#task_count_2"+prev_status).html();
                        $("#task_count_2"+prev_status).html(parseInt(task_count-1));

                        $(".data_tr_"+client_id+"_"+tab).hide();
                    }*/
                    
                }
            });
        //}
    });
/* ################# Delete Single Task Management End ################### */

/* ################# Delete Single Task Management Start ################### */
    $("body").on('click', '.delete_completed_task', function(){
        var client_id   = $(this).data('client_id');
        var tab         = $(this).data('tab');
        var task_id     = $(this).data('task_id');
        var service_id  = $("#service_id").val();
        var manage_id   = $("#manage_id").val();
        var page_open   = $("#page_open").val();
        var step_id     = $("#step_id").val();
        var prev_status = $("#prev_status_"+client_id).val();

        if(confirm("Do you want to Delete the task?")){
          $.ajax({
            type: "POST",
            url: '/jobs/delete-completed-task',
            data: { 'manage_id' : manage_id, 'client_id' : client_id, 'service_id' : service_id, 'task_id' : task_id },
            success : function(resp){
              if(page_open == 3){
                $("#data_tr_"+task_id).hide();
                var count = $("#task_count_2"+step_id).html();
                $("#task_count_2"+step_id).html(parseInt(count-1));
                refresh_table();
              }
            }
          });
        }
    });
/* ################# Delete Single Task Management End ################### */

/* ################# Job Status Change Start ################### */
    $(".status_dropdown").change(function(){
        var service_id  = $("#service_id").val();
        var client_id   = $(this).data("client_id");
        var status_id   = $(this).val();
        var page_open   = $("#page_open").val();
        //alert("val.length");return false;
        if(status_id != 2)
        {
            $.ajax({
                type: "POST",
                url: '/jobs/change-job-status',
                data: { 'service_id' : service_id, 'client_id' : client_id, 'status_id' : status_id },
                success : function(resp){
                    
                    /* ============Current Page ========== */
                    if(page_open != 21){
                        var task_count = $("#task_count_"+page_open).html();
                        var total_cnt = parseInt(task_count-1);
                        $("#task_count_"+page_open).html(total_cnt);
                        $("#data_tr_"+client_id+"_"+page_open).hide(); 

                        if(total_cnt>0){
                            $("#step_check_"+page_open).iCheck("disable");
                        }else{
                            $("#step_check_"+page_open).iCheck("enable");
                        }
                    }else{
                        var prev_status = $("#"+page_open+"_prev_status_"+client_id).val();
                        var task_count = $("#task_count_2"+prev_status).html();
                        var total_cnt = parseInt(task_count-1);
                        $("#task_count_2"+prev_status).html(total_cnt);
                        $("#"+page_open+"_prev_status_"+client_id).val(status_id);

                        if(total_cnt>0){
                            $("#step_check_2"+prev_status).iCheck("disable");
                        }else{
                            $("#step_check_2"+prev_status).iCheck("enable");
                        }
                    }
                    /* ============Current Page ========== */

                    var count_2 = $("#task_count_2"+status_id).html();
                    var total = parseInt(count_2)+parseInt(1);
                    $("#task_count_2"+status_id).html(total); 

                    if(total>0){
                        $("#step_check_2"+status_id).iCheck("disable");
                    }else{console.log("7false"+status_id)
                        $("#step_check_2"+status_id).iCheck("enable");
                    }
                        
                }
            });
        }else{
            alert("This is some problem to change status");
            return false;
        }
    });
/* ################# Delete to Task Management End ################### */

/* ################# Job Status Change Start ################### */
    $("body").on('change', '.job_status_change', function(){
        var service_id  = $("#service_id").val();
        var client_id   = $(this).data("client_id");
        var manage_id   = $(this).data("manage_id");
        var status_id   = $(this).val();
        var page_open   = $("#page_open").val();

        var prev_status = $("#"+page_open+"_prev_status_"+client_id).val();
        //alert("val.length");return false;
        if(status_id != 2)
        {
            $.ajax({
                type: "POST",
                url: '/jobs/change-job-status',
                data: { 'service_id' : service_id, 'manage_id' : manage_id, 'client_id' : client_id, 'status_id' : status_id },
                success : function(resp){
                    console.log("#data_tr_"+client_id+"_2"+page_open)
                    //return false;
                    
                    /* ============Current Page ========== */
                    if(page_open != 21){
                        var task_count = $("#task_count_2"+prev_status).html();
                        var total_cnt = parseInt(task_count-1);
                        $("#task_count_2"+prev_status).html(total_cnt);
                        $("#"+page_open+"_prev_status_"+client_id).val(status_id);
                        if(page_open == '22'){
                            $(".data_tr_"+client_id+"_"+page_open).hide();
                        }else{
                            $(".data_tr_"+client_id+"_2"+page_open).hide();
                        }
                        
                        if(total_cnt>0){
                            $("#step_check_"+page_open).iCheck("disable");
                        }else{
                            $("#step_check_"+page_open).iCheck("enable");
                        }
                    }else{
                        var task_count = $("#task_count_2"+prev_status).html();
                        var total_cnt = parseInt(task_count-1);
                        $("#task_count_2"+prev_status).html(total_cnt);
                        $("#"+page_open+"_prev_status_"+client_id).val(status_id);

                        if(total_cnt>0){
                            $("#step_check_2"+prev_status).iCheck("disable");
                        }else{
                            $("#step_check_2"+prev_status).iCheck("enable");
                        }
                    }
                    
                    /* ============Current Page ========== */

                    var count_2 = $("#task_count_2"+status_id).html();
                    var total = parseInt(count_2)+parseInt(1);
                    $("#task_count_2"+status_id).html(total); 

                    if(total>0){
                        $("#step_check_2"+status_id).iCheck("disable");
                    }else{
                        $("#step_check_2"+status_id).iCheck("enable");
                    }
                }
            });
        }else{
            $('#'+page_open+'_status_dropdown_'+client_id).val(prev_status);
            alert("This is some problem to change status");
            return false;
        }
    });
/* ################# Delete to Task Management End ################### */

/* ################# Global Task Management Start ################### */
    $('#manage_check').on('ifChecked', function(event){
        //$("#dead_line").prop("disabled", true);
      var dead_line = 1;
      var service_id = $("#service_id").val();
      $.ajax({
        type: "POST",
        dataType : 'json',
        url: '/jobs/send-global-task',
        data: { 'dead_line':dead_line, 'service_id':service_id },
        success : function(resp){ 
          /*$.each(resp, function(key, value){
            $("#after_send_"+value.client_id).html('<button type="button" class="sent_btn">SENT</button>');
          });*/
        }
      });
    });

    $('#manage_check').on('ifUnchecked', function(event){
        var dead_line = 0;
        var service_id = $("#service_id").val();
        $.ajax({
            type: "POST",
            dataType : 'json',
            url: '/jobs/send-global-task',
            data: { 'dead_line' : dead_line, 'service_id' : service_id },
            success : function(resp){ 
                
            }
        });
    });

    /*$('#manage_check').click(function(event){
        var dead_line = $("#dead_line").val();
        var service_id = $("#service_id").val();
        if(dead_line == ""){
            alert("Please Put The Days Before Deadline value");
            return false;
        }else{
            $.ajax({
                type: "POST",
                dataType : 'json',
                url: '/jobs/send-global-task',
                data: { 'dead_line' : dead_line, 'service_id' : service_id },
                beforeSend : function(){
                    $(".loader_show").html('<img src="/img/spinner.gif" />');
                },
                success : function(resp){ 
                    $.each(resp, function(key, value){
                        $("#after_send_"+value.client_id).html('<button type="button" class="job_sent_btn">SENT</button>');
                    });
                    $("#auto_send-modal").modal("hide");
                    $(".loader_show").html('');
                }
            });
        }
    });*/
/* ################# Global Task Management End ################### */


/* ################# Filter By Staff Start ################### */
    /*$(".filter_by_staff").change(function(){
        var staff_id = $(this).val();
        var service_id = $("#service_id").val();
        var page_open = $("#encode_page_open").val();
        $.ajax({
            type: "POST",
            url: '/jobs/update-staff-filter',
            data: { 'staff_id' : staff_id, 'service_id' : service_id },
            success : function(resp){ 
                //window.location = "/ch-annual-return/"+service_id+"/"+page_open+"/"+staff_id;
                window.location.reload();
            }
        });
        
    });*/
/* ################# Filter By Staff Start ################### */

  $('#CheckallCheckbox').on('ifChecked', function(event){
        $(".jobs input[class='checkbox']").iCheck('check');
  });

  $('#CheckallCheckbox').on('ifUnchecked', function(event){
      $(".jobs input[class='checkbox']").iCheck('uncheck');
  });
	
/* ################# Send to Task Management Start ################### */
    $("body").on('click', '.send_manage_task', function(){
      var client_id = $(this).data("client_id");
      var service_id = $("#service_id").val();
      $.ajax({
        type: "POST",
        url: "/jobs/send-manage-task",
        data: { 'client_id': client_id, 'service_id' : service_id },
        success: function (resp) {
          $("#after_send_"+client_id).html('<button type="button" class="job_sent_btn">SENT</button>');              
        }
      });
    });

    $("body").on('click', '.job_send_pop', function(){
      var client_id   = $(this).data("client_id");
      var service_id  = $("#service_id").val();
      
      $.ajax({
        type: "POST",
        dataType : "json",
        url: "/jobs/ajax-vat-stagger",
        data: { 'client_id': client_id, 'service_id' : service_id },
        beforeSend : function(){
          $("#job_send_pop-modal h4").html('');
          $("#client_id").val(client_id);
          $("#job_send_pop-modal").modal("show");
        },
        success: function (resp) {//alert(resp.past_data.month);
          $("#job_send_pop-modal h4").html(resp.full_text);
          $("#last_month").val(resp.past_data.month);
          $("#last_year").val(resp.past_data.year);

          var data = '';
          if(resp.months.length >0){
            $.each(resp.months, function(index, value){
              var select = '';
              if(value == resp.past_data.month){
                  select = 'checked';
              }
              data += '<tr><td class="van_send_table"><span class="custom_radio">';
              data += '<input type="radio" class="change_return" data-month="'+value+'" name="send_month"  id="'+index+'" '+select+'><label for="'+index+'">'+value+'</label></span></td></tr>';
            });
          }
          $("#vat_send_div").html(data);  
        }
      });
    });

    $('#send_jobs_to_task').click(function(){
        var client_id   = $("#client_id").val();
        var service_id  = $("#service_id").val();
        var last_month  = $("#last_month").val();
        //var last_year   = $("#last_year").val();
        var full_text   = $("#job_send_pop-modal h4").html();
        //alert(full_text)
        //var return_data = check_already_sent(client_id, service_id, full_text);
        $.ajax({
            type: "POST",
            url: '/jobs/check-already-sent',
            dataType:'json',
            data: { 'client_id':client_id, 'service_id':service_id, 'last_month':last_month, 'full_text':full_text },
            success : function(resp){//alert(resp.return_value);
                if(resp.return_value == 1){
                    if(confirm('The data is already been sent.Do you want to resend?')){
                        send_jobs_to_task(client_id, service_id, last_month, full_text)
                    }
                }else{
                    send_jobs_to_task(client_id, service_id, last_month, full_text)
                }
            }
        });
        //console.log(return_data);
        /*if(return_data == 1){
            $.ajax({
                type: "POST",
                dataType : "json",
                url: "/jobs/send-jobs-to-task",
                data: {'client_id':client_id,'service_id':service_id,'last_month':last_month,'last_year':last_year,'full_text':full_text},
                beforeSend : function(){
                    $(".loader_show").html('<img src="/img/spinner.gif" />');
                },
                success: function (resp) {//alert(resp.return)
                    $(".loader_show").html('');
                    $("#after_send_"+client_id).html('<button type="button" class="job_send_btn job_send_pop" data-client_id="'+client_id+'" data-field_name="manage_task">SEND MORE</button>');
                    $("#job_send_pop-modal").modal("hide");
                }
            });
        }*/
        
        
    });
/* ################# Send to Task Management End ################### */

    $("body").on('change', '.change_return', function(){
        var month       = $(this).data('month');
        $("#last_month").val(month);        
    });


/* ################# Send to Task Management Start ################### */
    /*$(".job_send_button").click(function(){
        var client_id = $(this).data("client_id");
        var service_id = $("#service_id").val();
        $.ajax({
            type: "POST",
            url: "/jobs/send-job-to-task",
            data: { 'client_id': client_id, 'service_id' : service_id },
            success: function (resp) {
                $("#after_send_"+client_id).html('<button type="button" class="job_sent_btn">Sent</button>');              
            }
        });
    });*/
/* ################# Send to Task Management End ################### */

/* ################# Open Notes Popup Start ################### */
    $("body").on("click", ".open_notes_popup", function(){
      var client_id         = $(this).data("client_id");
      var manage_id         = $(this).data("manage_id");
      var tab               = $(this).data("tab");
      var service_id        = $("#service_id").val();
      var job_status_id     = $(this).data("job_status_id");
      var page_open         = $("#page_open").val();

      $.ajax({
          type: "POST",
          dataType : "json",
          url: "/jobs/show-jobs-notes",
          data: { 'manage_id':manage_id, 'client_id':client_id, 'service_id':service_id, 'tab':tab, 'job_status_id' : job_status_id },
          beforeSend : function(){
            $("#notes-modal").modal("show"); 
            if(page_open == 3){
              $('#notes').addClass('disable_click');
            }else{
              $('#notes').removeClass('disable_click');
            }
          },
          success: function (resp) {
            $("#notes_client_id").val(client_id);
            $("#notes_manage_id").val(manage_id);
            $("#notes_tab").val(tab);

            $("#notes").val(resp['notes']);
                        
          }
      });
        
    });
/* ################# Save Notes Popup End ################### */

/* ################# Save Notes Start ################### */
    $(".save_notes").click(function(){
      var client_id   = $("#notes_client_id").val();
      var manage_id   = $("#notes_manage_id").val();
      var tab         = $("#notes_tab").val();
      var service_id  = $("#service_id").val();
      var notes       = $("#notes").val();

      $.ajax({
        type: "POST",
        //dataType : "json",
        url: "/jobs/save-jobs-notes",
        data: { 'client_id':client_id, 'manage_id':manage_id, 'service_id':service_id, 'notes' : notes, 'type':'note' },
        success: function (resp) {
          if(service_id <= 9){
            refresh_table();
          }
          $("#notes-modal").modal("hide");             
        }
      });
        
    });
/* ################# Save Notes End ################### */

/* ################# Save Other Details Start ################### */
    $('body').on('change', ".save_details", function(){
        var client_id   = $(this).data('client_id');
        var manage_id   = $(this).data('manage_id');
        var type        = $(this).data('field_name');
        var service_id  = $("#service_id").val();
        var value       = $(this).val();
      
        $.ajax({
          type: "POST",
          //dataType : "json",
          url: "/jobs/save-jobs-notes",
          data: { 'client_id': client_id, 'manage_id': manage_id, 'service_id' : service_id, 'value' : value, 'type':type },
          success: function (resp) {
                   
          }
      });
        
    });
/* ################# Save Other Details End ################### */

/* ################# Open date text in job completed section Start ################### */
    $('body').on('change', ".change_last_date", function(){
      var key         = $(this).data('key');
      var tab         = $(this).data('tab');
      var prev_date   = $(this).data('prev_date');
      $(this).hide();
      $("."+tab+"_save_made_span_"+key).show();
      $("#"+tab+"_made_up_date_"+key).val(prev_date); 
    });
    $('body').on('change', ".cancel_made_date", function(){
      var key   = $(this).data('key');
      var tab   = $(this).data('tab');
      $("#"+tab+"_dateanchore_"+key).show();
      $("."+tab+"_save_made_span_"+key).hide();
    });

    $('body').on('change', ".save_made_date", function(){
      var client_id   = $(this).data('client_id');
      var service_id  = $(this).data('service_id');
      var tab         = $(this).data('tab');
      var key         = $(this).data('key');
      var date        = $("#"+tab+"_made_up_date_"+key).val();
      var field_name  = $(this).data('field_name');
      var step_id     = $(this).data('step_id');

      $.ajax({
        type: "POST",
        //dataType : "json",
        url: "/jobs/save-made-up-date",
        data: { 'client_id': client_id, 'service_id': service_id, 'date': date, 'field_name':field_name, 'step_id':step_id },
        success: function (resp) {
          $("#"+tab+"_dateanchore_"+key).html(date);
          $("#"+tab+"_made_up_date_"+key).val(date);
          $("#"+tab+"_dateanchore_"+key).show();
          $("."+tab+"_save_made_span_"+key).hide();         
        }
      });
    });
/* ################# Open date text in job completed section Start ################### */

/* ################# SYNC data in job section start ################### */
    $("body").on("click", ".sync_chreturn_data",function(){
      var service_id          = $("#service_id").val();
      var encode_staff_id     = $("#encode_staff_id").val();
      var encode_page_open    = $("#encode_page_open").val();
      var action              = $(this).data('action');
      var val = [];
      //alert('val');return false;
      if(action == 'multiple'){
        $(".ads_Checkbox:checked").each( function (i) {
          if($(this).is(':checked')){
            val[i] = $(this).val();
          }
        });
      }else{
        var client_id   = $(this).data('client_id');
        val.push(client_id);
      }
      
      //alert(val.length);return false;
      if(val.length>0){
        $.ajax({
          type: "POST",
          url: '/jobs/sync-jobs-clients',
          data: { 'client_ids' : val, 'service_id' : service_id },
          beforeSend : function(){
            $(".sync_jobs_data").attr('disabled', 'disabled');
            $("#message_div").html('<img src="/img/spinner.gif" />');
          },
          success : function(resp){
            $("#message_div").html('');
            //window.location = '/ch-annual-return/'+service_id+'/'+encode_page_open+'/'+encode_staff_id;
            //window.location.reload();
            refresh_table();
          }
        });
          
      }else{
          alert('Please select atleast one job');
      }
    });
/* ################# SYNC data in job section end ################### */

/* ################# Job Start Date in job section start ################### */
    $("body").on("click", ".open_calender_pop", function(){
      var client_id   = $(this).data('client_id');
      var manage_id   = $(this).data('manage_id');//alert(manage_id)
      var service_id  = $("#service_id").val();
      var tab         = $(this).data('tab');
      $("#calender_client_id").val(client_id);
      $("#calender_tab").val(tab);
      $("#job_manage_id").val(manage_id);

      $(".open_dropdown_"+client_id+"_"+tab).hide();
      $("#addto_calender-modal").modal("show");
    });

    $(".save_job_start_date").click(function(){
      var encode_staff_id     = $("#encode_staff_id").val();
      var encode_page_open    = $("#encode_page_open").val();
      var hour            = $("#calender_time").data('timepicki-tim');
      var date            = $("#calender_date").val();
      var service_id      = $("#service_id").val();
      var minute          = $("#calender_time").data('timepicki-mini');
      var client_id       = $("#calender_client_id").val();
      var tab             = $("#calender_tab").val();

      var res = date.split("-");

      var job_start_date  = res[2]+"-"+res[1]+'-'+res[0]+" "+hour+":"+minute+':00';
      var manage_id       = $("#job_manage_id").val();
      //alert(job_start_date);return false;
      $.ajax({
        type: "POST",
        url: '/jobs/save-jobs-notes',
        data: { 'client_id':client_id, 'manage_id':manage_id, 'service_id':service_id, 'job_start_date' : job_start_date, 'type':'startdate' },
        beforeSend : function(){
          $("#start_date_loader").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          $("#start_date_loader").html('');
          $("#addto_calender-modal").modal('hide');
          //window.location = '/ch-annual-return/'+service_id+'/'+encode_page_open+'/'+encode_staff_id;
          //window.location.reload(); 
          refresh_table();
        }
      });

      /*$("#date_view_"+client_id+"_"+tab).html(date+" "+hour+":"+minute);
      $("#addto_calender-modal").modal("hide");*/
    });

    $("body").on("click", ".atcb-item a", function(){
      $(".cont_add_to_date").hide();
    });
/* ################# Job Start Date in job section end ################### */


    $("body").on("click", ".job_start_date-modal", function(){
      $("#job_start_date-modal").modal("show");
    });

    $(".email_client-modal").click(function(){
      $("#email_client-modal").modal("show");
    });

    $(".send_template-modal").click(function(){
      var client_id = $(this).data('client_id');
      $("#template_client_id").val(client_id);
      var template_id = $(this).data('template_id');
      $("#template_id").val(template_id);

      $.ajax({
        type: "POST",
        url: '/jobs/get-all-contacts',
        dataType:'json',
        data: { 'client_id' : client_id, 'template_id' : template_id },
        beforeSend : function(){
            $("#send_email_tick").html("");
            $("#send_template-modal").modal("show");
            //$("#start_date_loader").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          $('#repeat_days').val(resp['details'].repeat_days);
          $('#template_name').val(resp['details'].template_name);
          $('#template_subject').val(resp['details'].template_subject);
          $('#template_message').val(resp['details'].template_message);


          if (resp['contact'].length != 0) {
            var checked = '';
            var content = '<tr><td width="5%" align="left">&nbsp;</td><td width="30%" align="left"><strong>Name</strong></td><td width="23%" align="left"><strong>Email</strong></td></tr>';
            $.each(resp['contact'], function(key){
                
                if(resp['details'].length != 0){ 
                    var email_array = resp['details'].email;
                    var index = email_array.indexOf(resp['contact'][key].email);
                    if(index != -1){
                        checked = 'checked';
                    }
                }
                

                content+= "<tr><td align='center'><span class='custom_chk'>";
                content+= "<input type='checkbox' name='email[]' "+checked+" value='"+resp['contact'][key].email+"' id='"+key+"'/>";
                content+= "<label for='"+key+"' style='width:0!important'>&nbsp;</label></span><td>"+resp['contact'][key].contact_name+"</td><td>"+resp['contact'][key].email+"</td></tr>";
            });

            $("#send_email_tick").html(content);
            //$("#show_search_client").show();
          }
        }
      });
    });

    /*$(".save_jobs_email").click(function(){
        var client_id  = $("#template_client_id").val();
        var repeat_days         = $("#repeat_days").val();
        var template_name       = $("#template_name").val();
        var template_subject    = $("#template_subject").val();
        var template_message    = $("#template_message").val();
        var template_file       = $("#template_file").val();
        $.ajax({
            type: "POST",
            url: '/jobs/save-jobs-email',
            //dataType:'json',
            data: { 'template_client_id':client_id, 'repeat_days':repeat_days, 'template_name':template_name, 'template_subject':template_subject, 'template_message':template_message, 'template_file':template_file },
            beforeSend : function(){

            },
            success : function(resp){//alert(resp);return false;
              //window.location.reload();
            }
        });
        
    });*/

    $(".enter_email-modal").click(function(){
      $("#enter_email-modal").modal("show");
    });

    $(".ch_returns").on("click", ".small_icon", function(event){
      var visable = 0;
      event.stopPropagation();
      var id = $(this).data("id");
      if($(".select_toggle").is(':visible')){
          visable = 1;
      }
      $(".select_toggle").hide();

      if(visable == 1){
          $("#status"+id).hide();
      }else{
          $("#status"+id).show();
      }    
    });

    $(document).click(function() {
      $(".select_toggle").hide();
    });

    /* ################# Job start date in job section start ################### */
    $("#jsd_save").click(function(){
      var service_id          = $("#service_id").val();
      var encode_staff_id     = $("#encode_staff_id").val();
      var encode_page_open    = $("#encode_page_open").val();

      var days  = $("#job_start_date").val();
      if(days == ""){
        alert("Please enter the days");
        return false;
      }
      //alert(days);return false;
      $.ajax({
        type: "POST",
        url: '/jobs/save-start-days',
        data: { 'days' : days, 'service_id' : service_id },
        beforeSend : function(){
          $(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          $(".loader_show").html('');
          if(resp > 0){
            //window.location = '/ch-annual-return/'+service_id+'/'+encode_page_open+'/'+encode_staff_id;
            //window.location.reload();
            refresh_table();
            $('#job_start_date-modal').modal('hide');
          }else{
            $(".loader_show").html('There are some error..Please try again...');
          }
            
        }
      });
    });
    /* ################# Job start date in job section end ################### */


/* ################# Email Client in job section start ################### */
$("#save_send_email").click(function(){
    var service_id          = $("#service_id").val();
    var encode_staff_id     = $("#encode_staff_id").val();
    var encode_page_open    = $("#encode_page_open").val();

    var template_id  = $("#email_tmplt_id").val();
    var days         = $("#email_days").val();
    var deadline     = $("#email_deadline").val();
    var remind_days  = $("#remind_days").val();

    $.ajax({
        type: "POST",
        url: '/jobs/save-email-client-days',
        data: { 'template_id' : template_id, 'days' : days, 'deadline' : deadline, 'remind_days' : remind_days, 'service_id' : service_id },
        beforeSend : function(){
            $(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
            if(resp > 0){
                //window.location = '/ch-annual-return/'+service_id+'/'+encode_page_open+'/'+encode_staff_id;
                window.location.reload();
            }else{
                $(".loader_show").html('There are some error..Please try again...');
            }
            
        }
    });
});
/* ################# Email Client in job section end ################### */
    
/* ################# Sign off date in job section start ################### */ 
$("body").on('click', ".sign_off_date", function(){
    var client_id   = $(this).data('client_id');
    var client_type = $(this).data('client_type');
    var action      = $(this).data('action');
    $("#sod_client_id").val(client_id);
    $("#sod_client_type").val(client_type);
    if(action == 'old'){
        $.ajax({
            type: "POST",
            url: '/renewals/get-sign-off-date',
            dataType:'json',
            beforeSend : function(){
              //$(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
            },
            data: {'client_id':client_id },
            success : function(resp){
                console.log(resp.soffdate);
                var resultDate = resp.soffdate.split("-");
                $("#sod_day").val(resultDate[0]);
                $("#sod_month").val(resultDate[1]);

                $("#sign_off_date-modal").modal("show");
            }
        });
    }else{
        $("#sign_off_date-modal").modal("show");
    }
    
});
/* ################# Sign off date in job section end ################### */    

$('#sod_save').click(function(){
  var client_id     = $('#sod_client_id').val();
  var day           = $('#sod_day').val();
  var month         = $('#sod_month').val();
  var text          = day+'-'+month;
  var client_type   = $("#sod_client_type").val();
  var data_type     = $("#sod_data_type").val();

  $.ajax({
    type: "POST",
    url: '/renewals/save-account-details',
    dataType:'json',
    beforeSend : function(){
      $(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
    },
    data: {'data_type':data_type, 'text':text, 'client_id':client_id, 'client_type':client_type },
    success : function(resp){
      $(".loader_class").html('');

      $('.sign_off_a_'+client_id).hide();
      var SoffDate = '<a href="javascript:void(0)" class="sign_off_date sign_off_a_'+client_id+'" data-client_id="'+client_id+'" data-action="old">'+resp.sign_off_date+'</a>';
      $('.sign_off_span_'+client_id).html(SoffDate);

      $('#sign_off_date-modal').modal('hide');
      refresh_table();
    }
  });
});


/* Corporation Tax */
$("body").on("click", ".tax_return_modal", function(){
    var client_id   = $(this).data('client_id');
    var data_type   = $('#tax_data_type').val();
    var client_type = $(this).data('client_type');
    var action      = $(this).data('action');

    $("#tax_client_id").val(client_id);
    $("#tax_action").val(action);

    $.ajax({
    type: "POST",
    url: '/jobs/ajax-tax-return-period',
    dataType:'json',
    data: {'client_id':client_id, 'action':action },
    success : function(resp){
      $('#pop_tax_start').val(resp.start_date);  
      $('#pop_tax_end').val(resp.end_date);  
      $("#tax_return-modal").modal("show");
    }
  });
});

$("#save_tax_return").click(function(){
    var client_id   = $("#tax_client_id").val();
    var service_id  = $("#service_id").val();
    var data_type   = $('#tax_data_type').val();
    var start_date  = $("#pop_tax_start").val();
    var end_date    = $('#pop_tax_end').val();
    var action      = $('#tax_action').val();

    $.ajax({
    type: "POST",
    url: '/jobs/save-account-details',
    dataType:'json',
    beforeSend : function(){
      $(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
    },
    data: {'action':action, 'data_type':data_type, 'text':start_date, 'end_date':end_date, 'client_id':client_id, 'service_id':service_id },
    success : function(resp){
      $(".loader_class").html('');
      if(action == 'TRP'){
          $('.tax_return_'+client_id).html(resp.tax_return_start+' - '+resp.tax_return_end);
          $('.tax_return_'+client_id).attr("data-tax_return_start", resp.tax_return_start);
          $('.tax_return_end_'+client_id).html(resp.tax_return_date);
          $('.count_tax_'+client_id).html(resp.count_down);
      }

      $('#tax_return-modal').modal('hide');
    }
  });
});

$("body").on('click', '.job_freq_pop', function(){
    var client_id   = $(this).data('client_id');
    var service_id  = $('#service_id').val();
    var repeat_day  = $('#repeat_day').val();
    var due_date    = $("#first_due_date").val();
    var hrs_wk      = $('#hrs_wk').val();
    var end_date    = $('#end_date_opt').val();
    
    $.ajax({
        type: "POST",
        url: '/jobs/get-account-details',
        dataType:'json',
        data: {'client_id':client_id, 'service_id':service_id },
        beforeSend : function(){
          $('#freq_client_id').val(client_id);
        },
        success : function(resp){
            $("#repeat_day").val(resp.repeat_day);
            $("#first_due_date").val(resp.first_due_date);
            $("#hrs_wk").val(resp.hrs_wk);
            $("#end_date_opt").val(resp.end_date_opt);
            $('#job_freq-modal').modal('show');
        }
    });


    
});

$("#save_job_freq").click(function(){
    var client_id       = $("#freq_client_id").val();
    var service_id      = $("#service_id").val();
    var repeat_day      = $('#repeat_day').val();
    var first_due_date  = $("#first_due_date").val();
    var hrs_wk          = $('#hrs_wk').val();
    var end_date_opt    = $('#end_date_opt').val();

    $.ajax({
        type: "POST",
        url: '/jobs/save-bookkeeping',
        dataType:'json',
        data: {'client_id':client_id, 'service_id':service_id, 'repeat_day':repeat_day,'first_due_date':first_due_date,'hrs_wk':hrs_wk,'end_date_opt':end_date_opt },
        beforeSend : function(){
          $(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
        },
        success : function(resp){
            $(".loader_class").html('');
            $(".hrs_"+client_id).html(hrs_wk);
            if(repeat_day != ''){
                var text = '<a href="javascript:void(0)" class="job_freq_pop" id="job_freq_'+client_id+'" data-client_id="'+client_id+'">';
                text +='Every '+repeat_day+' Day(s)</a>';
                $('.freq_div_'+client_id).html(text+'<a href="javascript:void(0)" class="delete_job_freq" data-client_id="'+client_id+'"><img src="/img/cross.png" width="10"></a>');
            }
            $('#job_freq-modal').modal('hide');
            $('#tasksFirstTable').jtable('load', { search: $('#tasksFirstSearchText').val() });
        }
    });
});

$("body").on('click', ".delete_job_freq", function(){
  var client_id = $(this).data('client_id');
  if(confirm('Do you want to delete?')){
    $.ajax({
      type: "POST",
      url: '/jobs/delete-job-freq',
      dataType:'json',
      data: { 'client_id':client_id },
      success : function(resp){
          $('.freq_div_'+client_id).html('<a href="javascript:void(0)" class="job_freq_pop" id="job_freq_'+client_id+'" data-client_id="'+client_id+'">Add..</a>');
          $(".hrs_"+client_id).html('');
          $('#tasksFirstTable').jtable('load', { search: $('#tasksFirstSearchText').val() });
      }
    });
  }
});

/* ============== INCOME TAX RETURNS ============== */
$('body').on('click', '.open_send_popup', function(){
    var send_type = $(this).data('send_type');
    var client_id = $(this).data('client_id');
    $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/jobs/ajax-get-taxyear',
        data : {'client_id' : client_id},
        beforeSend : function(){
            $('#client_id').val(client_id);
            $('#send_type').val(send_type);
            if(send_type == 'single'){
                $("#taxyear_pop-modal h4").html("SEND TO TASK MANAGEMENT");
            }else{
                $("#taxyear_pop-modal h4").html("BULK SEND TO TASK MANAGEMENT");
            }
        },
        success : function(resp){
            var select = '<select class="form-control newdropdown" id="incometax_year">';
            $.each(resp.year, function(index, value){
                select += '<option value="'+value+'">'+value+'</option>';
            });
            select += '</select>';
            $('#income_send_div').html(select);
            $("#taxyear_pop-modal").modal("show");
        }
    });
  });

  $('body').on('click', '#save_send_popup', function(){
    var send_type   = $('#send_type').val();
    var service_id  = $('#service_id').val();
    var tax_year    = $('#incometax_year').val();

    var client_array = [];
    if(send_type == 'single'){
      client_array[0] = $('#client_id').val();
    }else{
      $(".checkbox:checked").each( function (i) {
        if($(this).is(':checked')){
          client_array[i] = $(this).val();
        }
      });
    }
    //console.log(client_array);return false;
    if(client_array.length>0){
      send_incometax_returns(client_array, service_id, tax_year, send_type);
    }else{
      alert('Please select atleast one job');
    }
    /*$.ajax({
        type:'POST',
        dataType : 'json',
        url : '/jobs/save-taxyear',
        data : {'client_array' : client_array, 'send_type' : send_type},
        success : function(resp){
            $("#taxyear_pop-modal").modal("hide");
        }
    });*/
  });

  $('body').on('click', '.open_audit_popup', function(){
    var send_type = $(this).data('send_type');
    var client_id = $(this).data('client_id');
    
    $.ajax({
      type:'POST',
      dataType : 'json',
      url : '/jobs/ajax-tax-return-period',
      data : {'client_id' : client_id, 'action' : 'getNextAccountDue'},
      beforeSend : function(){
        $('#client_id').val(client_id);
        $("#audit_pop-modal").modal("show");
        $("#audit_pop-modal .loader_show").html('<img src="/img/spinner.gif" />');
      },
      success : function(resp){
        $("#audit_pop-modal .loader_show").html('');
        //$("#period_end").val(resp.next_acc_due);
      }
    });
    
  });

  $('body').on('click', '#send_audits_popup', function(){
    var service_id  = $('#service_id').val();
    var client_id   = $('#client_id').val();
    var period_end  = $('#period_end').val();
    if(period_end == ''){
      alert('Please select the period end date');
      $('#period_end').focus();
      return false;
    }else{
      send_audits_popup(client_id, service_id, period_end);
    }
      
  });

  $('body').on('click', '.open_completion_pop', function(){
    var client_id = $(this).data('client_id');
    var service_id  = $('#service_id').val();
    $('#client_id').val(client_id);
    $.ajax({
      type:'POST',
      dataType : 'json',
      url : '/jobs/get-account-details',
      data : {'client_id':client_id, 'service_id':service_id},
      success : function(resp){
        $('#completion_date').val(resp.completion_date);
        $("#audit_completion-modal").modal("show");
      }
    });
      
  });

  $('body').on('click', '#save_completion_popup', function(){
    var service_id      = $('#service_id').val();
    var client_id       = $('#client_id').val();
    var completion_date = $('#completion_date').val();
    if(completion_date == ''){
      alert('Please select completion date');
      $('#completion_date').focus();
      return false;
    }else{
      $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/jobs/save-account-details',
        data : {'action':'AUDITS', 'client_id':client_id, 'service_id':service_id, 'completion_date':completion_date},
        beforeSend : function(){
          $(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          $(".loader_show").html('');
          $('.completion_span_'+client_id).html(resp.completion_date);
          if(resp.completion_days <0){
              $('.count_compl_'+client_id).html('<span style="color:red">'+resp.completion_days+'</span>');
          }else{
              $('.count_compl_'+client_id).html(resp.completion_days);
          }
          $("#audit_completion-modal").modal("hide");
        }
      });
    }
  });

  $('body').on('click', '.return_data_modal', function(){
    var service_id = $('#service_id').val();
    $.ajax({
      type:'POST',
      dataType : 'json',
      url : '/jobs/ajax-taxreturn-details',
      data : {'service_id' : service_id},
      beforeSend : function(){
      
      },
      success : function(resp){
        //var resp = JSON.parse(data);
        var select = '<option value="">-- Select Tax Year --</option>';
        $.each(resp.year, function(index, value){
          //if(resp.details.tax_year == value){var selected = 'selected';}else{var selected = '';}
          select += '<option value="'+value+'">'+value+'</option>';
        });
        $('#tax_year').html(select);

        
        $("#return_data-modal").modal("show");
      }
    });
  });


  $("#tax_year").change(function(event) {
    var tax_year    = $(this).val();
    var service_id  = $('#service_id').val();
    $.ajax({
      type:'POST',
      dataType : 'json',
      url : '/jobs/get-taxreturn',
      data : {'service_id' : service_id, 'tax_year' : tax_year},
      beforeSend : function(){
          $("#progress").hide();
      },
      success : function(resp){
        if(resp.details.checklist_id){
          var ul_li = '';
          $.each(resp.details.documents, function(index, value){
              ul_li += '<li><a href="/uploads/tax_return_doc/'+resp.details.documents[index].document_name+'" download>'+resp.details.documents[index].document_name+'</a> <a href="javascript:void(0)" data-document_id="'+resp.details.documents[index].document_id+'" class="delete_files"><img src="/img/cross.png" height="12"></a></li>';
          });
          
          $("#document_list").html(ul_li);
          $('#checklist_id').val(resp.details.checklist_id);
          $('#tax_remind_days').val(resp.details.remind_days);
        }else{
          //$('#checklist_id').val('0');
          $("#document_list").html('');
          $('#tax_remind_days').val('');
        }
      }
    });
  });

  $("#save_tax_button").click(function(event) {
    var tax_year    = $('#tax_year').val();
    var service_id  = $('#service_id').val();
    var remind_days = $('#tax_remind_days').val();
    $.ajax({
      type:'POST',
      dataType : 'json',
      url : '/jobs/save-taxreturn-checklist',
      data : {'service_id':service_id, 'tax_year':tax_year, 'remind_days':remind_days, 'action':'save'},
      beforeSend : function(){
          
      },
      success : function(resp){
          window.location.reload();
      }
    });
  });

  $("body").on('click', '.viewClientMessage', function() {
    //alert('To enable viewing please invite client to the client  portal via new user invitation');
    alert('Please, first ,Invite Client to Client Portal.');
    return false;
  });
    
  $("body").on("click", ".openTaskPop", function(event) {
      var client_id   = $(this).data("client_id");
      var service_id  = $("#service_id").val();
    
      $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/jobs/notification-modal',
        data : {'service_id':service_id, 'client_id':client_id, 'action':'getData'},
        beforeSend : function(){
          //$('#checkbox1').iCheck('uncheck');
          //$('#checkbox2').iCheck('uncheck');
          //$('#freqdata1').html('<a href="javascript:void(0)" class="openFreqPop" data-value="1" data-freq_id="0">Add reminder message..</a>');
          //$('#freqdata2').html('<a href="javascript:void(0)" class="openFreqPop" data-value="2" data-freq_id="0">Add emails addresses..</a>');
          
          $("#ClientTitle").html('');
          $("#client_id").val(client_id);
          $('#taskClientId').val(client_id);
          $("#notificationTable").find("tr:not(:nth-child(1)):not(:nth-child(2)):not(:nth-child(3)):not(:nth-child(4))").remove();
          $("#openTaskPop-modal").modal('show');
        },
        success : function(resp){    
          $("#ClientTitle").html(resp.heading);            
          var msgCount    = resp.msgCount;
          var emailCount  = resp.emailCount;

          if(msgCount >0){
            $('#openTaskPop-modal #checkbox1').prop("disabled", false);
            $('#openTaskPop-modal #freqdata1 a').html('View reminder message');
            $('#openTaskPop-modal .viewDelete').html('<a href="javascript:void(0)" class="deleteTaskMessage" data-value="1"><img src="/img/cross.png" height="12"></a>');
          }else{
            $('#openTaskPop-modal #checkbox1').prop("disabled", true);
            $('#openTaskPop-modal #freqdata1 a').html('Add reminder message..');
            $('#openTaskPop-modal .viewDelete').html('');
          }

          if(emailCount >'0'){
            $('#openTaskPop-modal #checkbox2').prop("disabled", false);
            $('#openTaskPop-modal #freqdata2 a').html('View emails addresses');
          }else{
            $('#openTaskPop-modal #checkbox2').prop("disabled", true);
            $('#openTaskPop-modal #freqdata2 a').html('Add emails addresses..');
          }

          /* ================ Individual Notification Type ================ */
          if(resp.reminders.is_enable == '1'){
            $('#checkbox1').iCheck('check');
          }else{
            $('#checkbox1').iCheck('uncheck');
          }
          if(resp.taskstatus.is_enable == '2'){
            $('#checkbox2').iCheck('check');
          }else{
            $('#checkbox2').iCheck('uncheck');
          }
          /* ================ Individual Notification Type ================ */

          return false;


              
          var email_check = 0;
          if(resp.other_email == ''){
              var othemail = "Add.."
              var othclient_email = '';
              var othdisabled = 'disabled';
          }else{
              var othemail = resp.other_email;
              var othclient_email = resp.other_email;
              var othdisabled = '';
              email_check++;
          }
          var content = '<tr><td colspan="2">Other</td><td><a href="javascript:void(0)" data-client_email="'+othclient_email+'" class="openEditEmail" data-client_id="'+client_id+'" data-email_type="other" id="putEmail'+client_id+'">'+othemail+'</a></td>';
          content += '<td><span class="custom_chk"><input type="checkbox" id="other" '+othdisabled+' class="notify_email check_'+client_id+'"><label for="other" style="width:0!important">&nbsp;</label></span></td></tr>';

          if(resp.relations.length > 0){
            $.each(resp.relations, function(index, value){
                if(resp.relations[index].client_email == ''){
                    var email = "Add.."
                    var client_email = '';
                    var disabled = 'disabled';
                }else{
                    var email = resp.relations[index].client_email;
                    var client_email = resp.relations[index].client_email;
                    var disabled = '';
                    email_check++;
                }
                content += '<tr><td colspan="2">'+resp.relations[index].client_name+'</td>';
                content += '<td><a href="javascript:void(0)" data-client_email="'+resp.relations[index].client_email+'" class="openEditEmail" data-client_id="'+resp.relations[index].client_id+'" data-email_type="normal" id="putEmail'+resp.relations[index].client_id+'">'+email+'</a></td>';
                content += '<td><span class="custom_chk"><input type="checkbox" id="'+index+'" '+disabled+' class="notify_email check_'+resp.relations[index].client_id+'">';
                content += '<label for='+index+' style="width:0!important">&nbsp;</label></span></td></tr>';
            });
          }
          $('#notificationTable > tbody:last tr:eq(3)').after(content);
          if(service_id == 1){  
          /* ================ Individual Notification Type ================ */
          if(resp.reminders.is_enable == '1'){
              $('#checkbox1').iCheck('check');
          }else{
              $('#checkbox1').iCheck('uncheck');
          }
          if(resp.taskstatus.is_enable == '2'){
              $('#checkbox2').iCheck('check');
          }else{
              $('#checkbox2').iCheck('uncheck');
          }
          /* ================ Individual Notification Type ================ */
          if(email_check >0){
            $('.notification_check').prop("disabled", false);
          }else{
            $('.notification_check').iCheck('uncheck');
            $('.notification_check').prop("disabled", 'disabled');
          }

          /* ================ Stop Reminder Dropdown ================ */
          var dropdown = '<option value="2">Not Started</option>';
          if(resp.job_steps.length > 0){
            $.each(resp.job_steps, function(index, value){
              dropdown += '<option value="'+resp.job_steps[index].step_id+'">'+resp.job_steps[index].title+'</option>';
            });
          }
          $('.showStatusDrop').html(dropdown);

          if(resp.freq_details.length > 0){
            $.each(resp.freq_details, function(index, value){
              if(resp.freq_details[index].notification_type == '1'){
                var freq_content = '<a href="javascript:void(0)" class="openFreqPop" data-value="1" data-freq_id="'+resp.freq_details[index].id+'">Every '+resp.freq_details[index].repeat_day+' Day(s)</a>';
                freq_content += '&nbsp;<a href="javascript:void(0)" class="deleteFreq" data-position="1" data-freq_id="'+resp.freq_details[index].id+'"><img src="/img/cross.png" height="14"></a>';
                $('#freqdata1').html(freq_content);
              }
              if(resp.freq_details[index].notification_type == '2'){
                var freq_content = '<a href="javascript:void(0)" class="openFreqPop" data-value="2" data-freq_id="'+resp.freq_details[index].id+'">Every '+resp.freq_details[index].repeat_day+' Day(s)</a>';
                freq_content += '&nbsp;<a href="javascript:void(0)" class="deleteFreq" data-position="2" data-freq_id="'+resp.freq_details[index].id+'"><img src="/img/cross.png" height="14"></a>';
                $('#freqdata2').html(freq_content);
              }
            });
          }
        }

      }
    });
  });
    
    $("body").on("click", ".openEditEmail", function(event) {
        var client_id   = $(this).data("client_id");
        $('#editClientId').val(client_id);
        
        var client_email = $(this).data('client_email');
        $('#PopEmail').val(client_email);
        
        var email_type = $(this).data('email_type');
        $('#PopEmailType').val(email_type);
        
        
        $("#editEmail-modal").modal('show');
    });
    
    $("body").on("click", "#save_email_popup", function(event) {
        var client_id       = $('#editClientId').val();
        var client_email    = $('#PopEmail').val();
        var service_id      = $('#service_id').val();
        var email_type      = $('#PopEmailType').val();
        
        $.ajax({
            type:'POST',
            dataType : 'json',
            url : '/jobs/notification-modal',
            data : {'client_id':client_id, 'service_id':service_id, 'client_email':client_email, 'email_type':email_type, 'action':'saveEmail'},
            beforeSend : function(){
                $('.check_'+client_id).prop("disabled", false);
                $('.notification_check').prop("disabled", false);
            },
            success : function(resp){
                $('#PopEmail').val('');
                $('#putEmail'+client_id).html(client_email);
                $('#putEmail'+client_id).data('client_email', client_email);
                
                $("#editEmail-modal").modal('hide');

                //window.location.reload();
            }
        });
        
    });
    
    $('.notification_check').on('ifChecked', function(event){
      var is_enable = $(this).val();
	    notification_check('check', is_enable);
    });

	$('.notification_check').on('ifUnchecked', function(event){
    var is_enable = $(this).val();
		notification_check('uncheck', is_enable);
	});
    
  $('.global_reminder').on('ifChecked', function(event){
      var value = $(this).val();
	  globalReminderCheck('check', value);
  });

	$('.global_reminder').on('ifUnchecked', function(event){
        var value = $(this).val();
		globalReminderCheck('uncheck', value);
	});
    
    $("body").on("click", ".openFreqPop", function(event) {
      var client_id       = $('#client_id').val();
      var service_id      = $('#service_id').val();
      var freq_id         = $(this).data('freq_id');
      var position        = $(this).data('value');
      $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/reminder/template-action',
        data : {'position':position, 'client_id':client_id, 'service_id':service_id, 'action':'getNotificationFreq', 'event':'get'},
        beforeSend : function(){
          if(position == 1){
            $("#openFreqPop-modal").modal('show');
          }else{
            $("#openTasksEmailPop-modal").modal('show');
          }

          $('#position').val(position);
          $('#repeat_every').val('');
          $('#stop_reminder').val('');
          $('#resp_email').val('');
          $('#subject').val('');
          tinyMCE.get('frequency_message').setContent('');
          //$(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          $('#repeat_every').val(resp.details.repeat_day);
          //$('#first_send_day').val(resp.details.first_send_day);

          if(position == 2){
            var append = '';
            $.each(resp.emails, function(k,v){
              append += '<div class="popup_list form-group" id="hide_div_'+v.id+'"><a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_tasks_email" data-field_id="'+v.id+'"><img src="/img/cross.png" width="12"></a>'+v.email+'</div>';
            });
            $("#openTasksEmailBody").html(append);
          }else{
            var details = resp.details;
            if(details.length != '0'){
              $('#repeat_every').val(details.repeat_day);
              $('#stop_reminder').val(details.stop_reminder);
              $('#resp_email').val(details.resp_email);
              $('#subject').val(details.subject);
              tinyMCE.get('frequency_message').setContent(details.message);
              $('#freq_id').val(details.id);
            }
          }
        }
      });
    });

    $("body").on("click", "#saveFreqPop", function(event) {
      tinyMCE.triggerSave();
      var client_id       = $('#client_id').val();
      var service_id      = $('#service_id').val();
      var repeat_day      = $('#repeat_every').val();
      var stop_reminder   = $('#stop_reminder').val();
      var resp_email      = $('#resp_email').val();
      var subject         = $('#subject').val();
      var message         = $('#frequency_message').val();
      var freq_id         = $('#freq_id').val();
      var position        = $('#position').val();
      //alert(message);return false;

      if(repeat_day == ''){
        alert('Please enter repeat day');
        $('#repeat_every').focus();
        return false;
      }else if(stop_reminder == ''){
        alert('Please select stop reminder');
        $('#stop_reminder').focus();
        return false;
      }else if(resp_email == ''){
        alert('Please select recipient email');
        $('#resp_email').focus();
        return false;
      }else if(!validateEmail(resp_email)){
        alert("Please enter valid email");
        $('#resp_email').focus();
        return false;
      }else if(subject == ''){
        alert('Please enter message subject');
        $('#subject').focus();
        return false;
      }else if(message == ''){
        alert('Please enter message');
        $('#frequency_message').focus();
        return false;
      }

      $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/reminder/template-action',
        data : {'freq_id':freq_id, 'position':position, 'client_id':client_id, 'service_id':service_id,
        'repeat_day':repeat_day, 'stop_reminder':stop_reminder, 'action':'getNotificationFreq', 
        'resp_email':resp_email, 'subject':subject, 'message':message, 'event':'save'},
        beforeSend : function(){
          $("#openFreqPop-modal").modal('hide');
          //$('#period_end').val('');
          //$(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          /*var freq_content = '<a href="javascript:void(0)" class="openFreqPop" data-value="'+position+'" data-freq_id="'+resp.details.id+'">Every '+resp.details.repeat_day+' Day(s)</a>';
          freq_content += '&nbsp;<a href="javascript:void(0)" class="deleteFreq" data-position="'+position+'" data-freq_id="'+resp.details.id+'"><img src="/img/cross.png" height="14"></a>';
          $('#freqdata'+position).html(freq_content);*/
          $('#openTaskPop-modal #checkbox1').prop("disabled", false);
          $('#openTaskPop-modal #freqdata1 a').html('View reminder message');
          $('#openTaskPop-modal .viewDelete').html('<a href="javascript:void(0)" class="deleteTaskMessage" data-value="1"><img src="/img/cross.png" height="12"></a>');
        }
      });
    });

    $("body").on("click", ".deleteFreq", function(event) {
        var client_id       = $('#client_id').val();
        var service_id      = $('#service_id').val();
        var freq_id         = $(this).data('freq_id');
        var position        = $(this).data('position');

        $.ajax({
            type:'POST',
            dataType : 'json',
            url : '/reminder/template-action',
            data : {'client_id':client_id, 'service_id':service_id, 'freq_id':freq_id, 'action':'getNotificationFreq', 'event':'delete'},
            success : function(resp){
                var freq_content = '<a href="javascript:void(0)" class="openFreqPop" data-value="'+position+'" data-freq_id="0">Add..</a>';
                $('#freqdata'+position).html(freq_content);
            }
        });
    });
    
    $("body").on("click", ".open_newtask_pop", function(event) {
        var task_name   = $(this).data('task_name');
        var client_id   = $(this).data('client_id');
        var service_id  = $('#service_id').val();
        var manage_id   = $(this).data('manage_id');

        $.ajax({
            type:'POST',
            dataType : 'json',
            url : '/jobs/tasks-action',
            data : {'task_name':task_name, 'manage_id':manage_id, 'client_id':client_id, 'service_id':service_id, 'action':'getClientById'},
            beforeSend : function(){
                $('#edittaskname').val(task_name);
                $('#rel_client_id_edit').val(client_id);
                $("#edittaskcompose-modal").modal('show');
                //$(".loader_show").html('<img src="/img/spinner.gif" />');
            },
            success : function(resp){
                $('#edittaskdate').val(resp.job_start_date);
                $('#edittask_time').val(resp.job_start_time);
            }
        });
    });

    $("#saveTasksEmail").click(function(){
      var email       = $("#popTasksEmail").val();
      var service_id  = $("#service_id").val();
      var client_id   = $("#client_id").val();

      $.ajax({
        type: "POST",
        dataType : 'json',
        url: '/jobs/tasks-email',
        data: { 'email':email, 'service_id':service_id, 'client_id':client_id, 'action':'add' },
        beforeSend : function(){
          $('#popTasksEmail').val('');
          $("#openTasksEmailPop-modal .loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          $("#openTasksEmailPop-modal .loader_show").html('');
          $('#openTaskPop-modal #checkbox2').prop("disabled", false);
          $('#openTaskPop-modal #freqdata2 a').html('View emails addresses');

          var field_id = resp.id;
          var append = '<div class="popup_list form-group" id="hide_div_'+field_id+'"><a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_tasks_email" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a>'+email+'</div>';
          $("#openTasksEmailBody").append(append);
        }
      });
    });

    $("body").on('click', '.delete_tasks_email', function(){
      var id          = $(this).attr('data-field_id');
      var service_id  = $('#service_id').val();
      var client_id   = $('#client_id').val();

      if(!confirm('Do you want to delete?')){
        return false;
      }
      $.ajax({
        type: "POST",
        url: '/jobs/tasks-email',
        data: { 'id':id, 'action':'delete', 'client_id':client_id, 'service_id':service_id },
        success : function(resp){
          if(resp.emailCount >0){
            $('#openTaskPop-modal #checkbox2').prop("disabled", false);
            $('#openTaskPop-modal #freqdata2 a').html('View emails addresses');
          }else{
            $('#openTaskPop-modal #checkbox2').prop("disabled", true);
            $('#openTaskPop-modal #freqdata2 a').html('Add emails addresses..');
            $('#openTaskPop-modal #checkbox2').iCheck('uncheck');
          }
          if(resp.id != ""){
            $("#openTasksEmailBody #hide_div_"+id).hide();
          }else{
            alert("There are some error to delete this type, Please try again");
          }

        }
      });
    });

    $(".viewDelete").on('click', '.deleteTaskMessage', function(){
      var service_id  = $('#service_id').val();
      var client_id   = $('#client_id').val();
      if(!confirm('Do you wanr to delete?')){
        return false;
      }
      $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/reminder/template-action',
        data : {'client_id':client_id, 'service_id':service_id, 'action':'getNotificationFreq', 'event':'delete'},
        success : function(resp){
          $('#openTaskPop-modal #checkbox1').prop("disabled", true);
          $('#openTaskPop-modal #freqdata1 a').html('Add emails addresses..');
          $('#openTaskPop-modal .viewDelete').html('');
          $('#openTaskPop-modal #checkbox1').iCheck('uncheck');
        }
      });
    });

    $("body").on('click', '.openChaserEmail', function(){
      var service_id  = $('#service_id').val();
      var client_id   = $(this).attr('data-client_id');
      var manage_id   = $(this).attr('data-manage_id');

      $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/jobs/tasks-action',
        data : {'client_id':client_id, 'manage_id':manage_id, 'service_id':service_id, 'action':'getChaserDetails'},
        beforeSend : function(){
          $("#sendChaserEmail-modal").modal('show');
          $('#client_id').val(client_id);
          $('#job_manage_id').val(manage_id);

          $('#chaser_id').val('0');
          $('#chaser_every').val('');
          //$('.chaserStopCheck').iCheck('uncheck');
          $('#stop_date').val('');
          $('#chaser_email').val('');
          $('#chaser_subject').val('');
          tinyMCE.get('chaser_message').setContent('');
          $("#sendChaserEmail-modal .loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          $("#sendChaserEmail-modal .loader_show").html('');

          var details = resp.details;
          if(details.length != '0'){
            $('#chaser_every').val(details.repeat_day);
            $('#stop_date').val(details.stop_date);
            $('#chaser_email').val(details.resp_email);
            $('#chaser_subject').val(details.subject);
            tinyMCE.get('chaser_message').setContent(details.message);
            $('#chaser_id').val(details.id);
          }else{
            $('#chaser_email').val(resp.res_email);
          }
        }
      });
    });

    $("body").on('click', '#sendChaserEmail', function(){
      tinyMCE.triggerSave();
      var client_id       = $('#client_id').val();
      var service_id      = $('#service_id').val();
      var manage_id       = $('#job_manage_id').val();
      var repeat_day      = $('#chaser_every').val();
      //var stop_email      = ($('.chaserStopCheck').is(':checked'))?'Y':'N';
      var stop_date       = $('#stop_date').val();
      var resp_email      = $('#chaser_email').val();
      var subject         = $('#chaser_subject').val();
      var message         = $('#chaser_message').val();
      var chaser_id       = $('#chaser_id').val();

      //alert(stop_email);return false;

      if(repeat_day == ''){
        alert('Please enter repeat day');
        $('#chaser_every').focus();
        return false;
      }else if(stop_date == ''){
        alert('Please select stop email date');
        $('#stop_date').focus();
        return false;
      }else if(resp_email == ''){
        alert('Please select recipient email');
        $('#chaser_email').focus();
        return false;
      }/*else if(!validateEmail(resp_email)){
        alert("Please enter valid email");
        $('#chaser_email').focus();
        return false;
      }*/else if(subject == ''){
        alert('Please enter message subject');
        $('#chaser_subject').focus();
        return false;
      }else if(message == ''){
        alert('Please enter message');
        $('#chaser_message').focus();
        return false;
      }
      $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/jobs/tasks-action',
        data : {'client_id':client_id, 'manage_id':manage_id, 'service_id':service_id, 
        'repeat_day':repeat_day, 'stop_date':stop_date, 'resp_email':resp_email, 
        'subject':subject, 'message':message, 'chaser_id':chaser_id, 'action':'saveChaserDetails'
        },
        beforeSend : function(){
          $("#sendChaserEmail-modal .loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){ 
          $("#sendChaserEmail-modal .loader_show").html('');
          $("#sendChaserEmail-modal").modal('hide');
        }
      });
    });


    //
	
});//document end 

function globalReminderCheck(click_type, value)
{
    var service_id      = $('#service_id').val();
    $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/reminder/template-action',
        data : {'service_id':service_id, 'click_type':click_type, 'value':value, 'action':'addReminder'},
        beforeSend : function(){
            //$('#period_end').val('');
            //$(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
            
        }
    });
}

function notification_check(click_type, is_enable)
{
  var client_id       = $('#client_id').val();
  var service_id      = $('#service_id').val();
  $.ajax({
    type:'POST',
    dataType : 'json',
    url : '/reminder/template-action',
    data : {'client_id':client_id, 'service_id':service_id, 'click_type':click_type, 'action':'addNotificationType', 'is_enable':is_enable},
    beforeSend : function(){
      //$('#period_end').val('');
      //$(".loader_show").html('<img src="/img/spinner.gif" />');
    },
    success : function(resp){
      if(click_type == 'check'){
        if(is_enable == '1'){
          $('.red_box_'+client_id).show();
        }else{
          $('.blue_box_'+client_id).show();
        }
      }else{
        if(is_enable == '1'){
          $('.red_box_'+client_id).hide();
        }else{
          $('.blue_box_'+client_id).hide();
        }
      }

      if ($('#checkbox1').is(':checked') || $('#checkbox2').is(':checked')) {
        $('.notify_email').prop("disabled", false);
      }else{
        $('.notify_email').prop("disabled", "disabled");
      }
    }
  });
}

function send_audits_popup(client_id, service_id, period_end)
{
    $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/jobs/send-audits-job',
        data : {'client_id':client_id, 'service_id':service_id, 'period_end':period_end},
        beforeSend : function(){
            $('#period_end').val('');
            $(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
            $(".loader_show").html('');
            $("#after_send_"+client_id).html('<button type="button" class="job_send_btn open_audit_popup" data-client_id="'+client_id+'" data-send_type="single">SEND MORE</button>');
            $("#audit_pop-modal").modal("hide");
        }
    });
}

function send_jobs_to_task(client_id, service_id, last_month, full_text)
{
    $.ajax({
        type: "POST",
        dataType : "json",
        url: "/jobs/send-jobs-to-task",
        data: {'client_id':client_id,'service_id':service_id, 'last_month':last_month,'full_text':full_text},
        beforeSend : function(){
            $(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {//alert(resp.return)
            $(".loader_show").html('');
            $("#after_send_"+client_id).html('<button type="button" class="job_send_btn job_send_pop" data-client_id="'+client_id+'" data-field_name="manage_task">SEND MORE</button>');
            $("#job_send_pop-modal").modal("hide");

            $('#tasksFirstTable').jtable('load', { search: $('#tasksFirstSearchText').val() });
        }
    });
}

function send_incometax_returns(client_array, service_id, tax_year, send_type)
{
  $.ajax({
    type:'POST',
    dataType : 'json',
    url : '/jobs/save-taxyear',
    data : {'service_id':service_id, 'client_array':client_array, 'tax_year':tax_year, 'send_type':send_type},
    beforeSend : function(){
      $(".loader_show").html('<img src="/img/spinner.gif" height="25" />');
    },
    success : function(resp){
      $(".loader_show").html('');
      $.each(client_array, function(index, client_id){
        $("#after_send_"+client_id).html('<button type="button" class="job_send_btn open_send_popup" data-client_id="'+client_id+'" data-send_type="single">SEND MORE</button>');
      });
      $("#taxyear_pop-modal").modal("hide");
    }
  });
}

function validateEmail(email) {
  var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
  return re.test(email);
}
