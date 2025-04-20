$(document).ready(function(){

  //show_datatables_data();

  $(".open_toggle").hide();

  $("#test").click(function(event) {
      refresh_datatable();
  });

  $("#select_icon").click(function(event) {
      $(".open_toggle").toggle();
      event.stopPropagation();
  });

  $('#select_client_type').on('change', function(){
    var client_type = $(this).val();
    if(client_type == ''){
      $('.open_toggle').hide();
      $('#select_icon').addClass('avoid-clicks');
      $('#clients_list').html('');
    }else{
      $('#select_icon').removeClass('avoid-clicks');
      get_client_list(client_type);
    }
  });

  $('body').on('click', ".client_check_task", function(event){
    var client_id   = $(this).val();
    var client_type = $('#select_client_type').val();
    
    if($(this).is(":checked")){
      $('.del_li_'+client_id).hide();

      increseTabCount(1);
      //increseNotStartedCount();
    }
    add_new_client(client_id, client_type)
  });

  $('body').on('click', ".delete_client", function(event){
    var client_id     = $(this).data('client_id');
    var service_id    = $('#service_id').val();
    var client_type   = $('#select_client_type').val();
    var $event_action = $(this).closest("tr");
    var status_id     = $('#page_open').val();
    var page_open     = $("#page_open").val();

    $.ajax({
      type: "POST",
      url: '/ct/custom-task-action',
      data: { 'service_id':service_id,'action':'delete','client_id':client_id, 'page_open' : page_open },
      success : function(resp){
        $event_action.remove();
        refresh_datatable();

        decreseTabCount(1);
        decreseStatusCount(client_id, service_id, status_id);
        

        if(client_type != ""){
          get_client_list(client_type);
        }
      }
    });
  });

  $('body').on('keyup', "#search_text", function(event){
    var client_type   = $('#select_client_type').val();
    get_client_list(client_type);
  });

  /* ################# Job Status Change Start ################### */
    $("body").on('change', '.task_status_change', function(){
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
                url: '/ct/change-task-status',
                data: { 'service_id' : service_id, 'manage_id' : manage_id, 'client_id' : client_id, 'status_id' : status_id },
                success : function(resp){

                  decreseStatusCount(client_id, service_id, status_id);
                  increseTabCount(status_id);
                  //decreseTabCount(prev_status)

                  /*if(total>0){
                      $("#step_check_2"+status_id).iCheck("disable");
                  }else{
                      $("#step_check_2"+status_id).iCheck("enable");
                  }*/
                }
            });
        }else{
            $('#'+page_open+'_status_dropdown_'+client_id).val(prev_status);
            alert("This is some problem to change status");
            return false;
        }
    });
/* ################# Delete to Task Management End ################### */
  
/* ################# Filter By Staff Start ################### */
    $("body").on('change', '.search_by_staff', function(){
        var staff_id          = $(this).val();
        var service_id        = $("#service_id").val();
        var encode_page_open  = $("#encode_page_open").val();
        var page_open         = $("#page_open").val();

        $.ajax({
            type: "POST",
            url: '/jobs/update-staff-filter',
            data: { 'staff_id' : staff_id, 'service_id' : service_id },
            success : function(resp){ 
              //refresh_datatable();
              if(page_open == 1){
                var goto_url = $("#goto_url").val();
                window.location.href = goto_url+'/'+encode_page_open+'/'+staff_id+'/none/none';
              }else{
                window.location.reload();
              }
            }
        });
        
    });
/* ################# Filter By Staff End ################### */

/* ################# Filter By Staff Start ################### */
    $("body").on('click', '.delete_completed', function(){
        var task_id = $(this).data('task_id');
        var service_id = $("#service_id").val();
        var page_open = $("#encode_page_open").val();
        var $event_action = $(this).closest("tr");
        $.ajax({
            type: "POST",
            url: '/ct/custom-task-action',
            data: { 'task_id' : task_id, 'action' : 'delete_completed' },
            success : function(resp){ 
              $event_action.remove();
            }
        });
    });
/* ################# Filter By Staff Start ################### */

/* ################# Table Heading Add/Edit Start ################### */
    $("body").on('click', '.add_heading', function(){
      var heading_id = $(this).attr('data-heading_id');
      $('#pop_heading_id').val(heading_id);
      var heading = $(this).html();
      if(heading_id == 0){
        $('#heading').val('');
      }else{
        $('#heading').val(heading);
      }
      $('#add_heading-modal').modal('show');
    });

    $("body").on('click', '#save_heading_popup', function(){
      var service_id  = $("#service_id").val();
      var step_id     = $("#step_id").val();

      var heading_id      = $('#pop_heading_id').val();
      var heading         = $('#heading').val();
      var field_type      = $('#field_type').val();
      var select_option   = $('#select_option').val();      

      $.ajax({
          type: "POST",
          url: '/ct/custom-task-action',
          //dataType:'json',
          data: {'heading_id':heading_id, 'step_id':step_id, 'service_id':service_id, 'heading':heading, 'field_type':field_type, 'select_option':select_option, 'action':'add_heading'  },
          beforeSend:function(){
              $(".loader_show").html('<img src="/img/spinner.gif" />');
          },
          success : function(resp){ 
            $(".loader_show").html('');
            $('.add_heading').html(heading);
            $('.add_heading').attr('data-heading_id', resp)
            $('#add_heading-modal').modal('hide');
            refresh_datatable();
          }
      });

      
    });
/* ################# Table Heading Add/Edit End ################### */

//Show select option while adding client start
$(".user_field_type").change(function(){
  var field_type   = $(this).val();
  if(field_type == "4"){
    $('#show_select_option').show();
  }else{
    $('#show_select_option').hide();
  }
}); 
//Show select option while adding client end

$('body').on('focus',".date_field", function(){
    $(this).datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-10:+10" });
});

$('body').on('click',".job_send_btn", function(){
    var client_id   = $(this).data('client_id');
    var service_id  = $('#service_id').val();
    var page_open = $('#page_open').val();
    
    $(this).html('SENT');
    $(this).removeClass('job_send_btn');
    $(this).addClass('job_sent_btn');
    
    $.ajax({
        type: "POST",
        dataType : "json",
        url: "/ct/send-jobs-to-task",
        data: {'client_id':client_id,'service_id':service_id, 'page_open' : page_open},
        beforeSend : function(){
            //$(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {//alert(resp.return)
            //$(".loader_show").html('');
            //$("#after_send_"+client_id).html('<button type="button" class="job_send_btn job_send_pop" data-client_id="'+client_id+'" data-field_name="manage_task">SEND MORE</button>');
            //$("#job_send_pop-modal").modal("hide");
        }
    });
});

/* Edit task name pop up */
$(".openEditJobPop").click(function(){
  var service_id   = $('#service_id').val();
  var service_name = $('#service_name').val();
  $('#task_name').val(service_name);
  $('#edit_task-modal').modal('show');
  /*$.ajax({
      type: "POST",
      url: '/ct/task-details-by-id',
      dataType:'json',
      data: { 'service_id':service_id },
      beforeSend:function(){
          $('#edit_task-modal').modal('show');
      },
      success : function(resp){ 
        $('#task_name').val(resp.service_name);
      }
  });*/
}); 

$("#save_task_popup").click(function(){
  var service_id   = $('#service_id').val();
  var service_name = $('#task_name').val();
  //$('#task_name').val(service_name);
  //$('#edit_task-modal').modal('show');
  $.ajax({
      type: "POST",
      url: '/ct/save-task-details',
      dataType:'json',
      data: { 'service_id':service_id, 'service_name':service_name, 'action':'save' },
      beforeSend:function(){
        $(".loader_show").html('<img src="/img/spinner.gif" />');
      },
      success : function(resp){ 
        $(".loader_show").html('');
        $('#service_name').val(service_name);
        $('#taskTitleSpan').html(service_name);
        $('#edit_task-modal').modal('hide');
      }
  });
});

$(".down_arrow").click(function(){
  var no = $(this).data('no');
  if(no == 1){
    $(".field_dropdown2").hide();
    $(".field_dropdown1").toggle();
  }else{
    $(".field_dropdown1").hide();
    $(".field_dropdown2").toggle();
  }
}); 

$("body").on("click", ".openDeadlinePop", function(){///jobs/get-account-details
  var client_id   = $(this).data('client_id');
  var field_name   = $(this).data('field_name');
  var service_id  = $('#service_id').val();
  $.ajax({
    type:'POST',
    dataType : 'json',
    //url : '/jobs/save-account-details',
    url : '/jobs/get-account-details',
    data : {'client_id':client_id, 'service_id':service_id, 'field_name':field_name},
    beforeSend : function(){
      if(field_name == 'deadline_date'){
        $('#JobNameDiv').hide();
        $('#DeadlineDateDiv').show();
        $('#deadline_date-modal .modal-title').html('Add Single Deadline Date');
      }else{
        $('#DeadlineDateDiv').hide();
        $('#JobNameDiv').show();
        $('#deadline_date-modal .modal-title').html('Add Single Job Name');
      }
      $('#deadline_date-modal').modal('show');
      $('#deadClientId').val(client_id);
      $('#CustomField').val(field_name);
    },
    success : function(resp){
      if(field_name == 'deadline_date'){
        $('#DeadlineDate').val(resp.deadline_date);
        $('#JobReturnDt').val(resp.job_frequency);
      }else{
        $('#JobName').val(resp.job_name);
      }
      
    }
  });
}); 

$('body').on('click', '#save_deadline_popup', function(){
  var service_id      = $('#service_id').val();
  var client_id       = $('#deadClientId').val();
  var field_name      = $('#CustomField').val();
  var DeadlineDate    = $('#DeadlineDate').val();
  var job_frequency   = $('#JobReturnDt').val();
  var job_name        = $('#JobName').val();

  if(DeadlineDate == '' && field_name == 'deadline_date'){
    alert('Please select completion date');
    $('#DeadlineDate').focus();
    return false;
  }else if(job_frequency == '' && field_name == 'deadline_date'){
    alert('Please select job frequency');
    $('#JobReturnDt').focus();
    return false;
  }else if(job_name == '' && field_name == 'job_name'){
    alert('Please enter job name');
    $('#jobName').focus();
    return false;
  }else{
      $.ajax({
          type:'POST',
          dataType : 'json',
          url : '/jobs/save-job-account-details',
          data : {'action':'CUSTOM_TASK','client_id':client_id,'service_id':service_id,
            'DeadlineDate':DeadlineDate,'job_name':job_name,'field_name':field_name, 'job_frequency':job_frequency},
          beforeSend : function(){
              $(".loader_show").html('<img src="/img/spinner.gif" />');
          },
          success : function(resp){
              $(".loader_show").html('');
              location.reload();
              //$("#deadline_date-modal").modal("hide");
          }
      });
  }
});




});//end of main document ready 


function add_new_client(client_id, client_type)
{
  var service_id  = $("#service_id").val();
  
  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/edit-service-id',
    data: { 'service_id':service_id, 'action_type':'custom_add', 'client_id':client_id },
    success : function(resp){
      var client_name = resp.details.client_name;
      if(client_type == 'org'){
        client_name = resp.details.business_name;
      }
      var list = '<tr>';

      list += '<td><span class="custom_chk"><input type="checkbox" class="checkbox ads_Checkbox" name="checkbox[]" id="cst_'+client_id+'" value="'+client_id+'"/><label style="width:0px!important;margin-top:0px;" for="cst_'+client_id+'">&nbsp;</label></span></td>';
      list += '<td align="left"><a href="javascript:void(0)" class="openTaskPop" data-client_id="'+resp.details.client_id+'" data-service_id="'+service_id+'">'+client_name+'</a></td>';
      list += '<td>'+resp.field1_value+'</td>';
      list += '<td>'+resp.field2_value+'</td>';
      list += '<td align="center"><a href="javascript:void(0)" class="openDeadlinePop" data-client_id="'+client_id+'">Add..</a></td>';
      list += '<td align="center">-</td>';
      list += '<td align="center"><a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+client_id+'">notes</a></td>';
      list += '<td align="center"><button type="button" class="job_send_btn" data-client_id="'+client_id+'">SEND</button></td>';
      list += '<td><div style="float: left; width: 100%"><div class="left_d '+client_id+'_staff_table_drop_'+service_id+'">'
      list += '</div><div class="text_r"><a href="javascript:void(0);" class="openServicesStaff" data-service_id="'+service_id+'" data-client_id="'+client_id+'" data-service_name="{{ $title }}" data-client_name="'+client_name+'" data-page="tasks" data-client_type="'+client_type+'">Edit</a>';
      list += '</div></div></td>';

      list += '</tr>';

      $('#example1 tbody').prepend(list);
      //refresh_datatable();
      //location.reload();
    }
  });
}

function get_client_list(client_type)
{
  var search_value = $('#search_text').val();
  var service_id  = $('#service_id').val();

  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/ct/get-all-clients',
    data: { 'client_type':client_type, 'search_value':search_value, 'service_id':service_id },
    beforeSend : function(){
      $("#clients_list").html('<div style="text-align:center"><img src="/img/spinner.gif" /></div>');
    },
    success : function(resp){
      var client_list = '';
      $.each(resp.client_details, function(index, value){
        client_list +='<li class="del_li_'+resp.client_details[index].client_id+'"><div class="custom_chk drop_box">';
        client_list +='<input type="checkbox" class="client_check_task" value="'+resp.client_details[index].client_id+'" id="'+resp.client_details[index].client_id+'"/> ';
        client_list +='<label for="'+resp.client_details[index].client_id+'">'+resp.client_details[index].client_name+'</label></div></li>';
      });
      $('#clients_list').html(client_list);
    }
  });
}

function refresh_datatable()
{
  window.table.destroy();
  show_datatables_data();
}


function show_datatables_data()
{
    var service_id          = $('#service_id').val();
    var encode_page_open    = $('#encode_page_open').val();
    var page_open           = $('#page_open').val();
    var service_name        = $('#service_name').val();
    var staff_id            = $('#search_by_staff').val();
    var org_client          = $('#encode_org_client').val();
    var client_type         = '';

    window.table = $('#example1').DataTable({
      "processing": true,
      "serverSide": true,
      "searching" : true,
      'bFilter': true,
      "bInfo": true,
      "bSortable": true,
      "bRetrieve": true,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'asc']],

      "ajax": {
        "url" : '/ct/get-table-data',
        "type" : "POST",
        "data" : {'service_id': service_id, 'page_open': page_open, 'staff_id': staff_id}
      },

      "columnDefs": [
      {
        "targets": 0,
        "render": function ( data, type, full, meta ) {
          return '<input type="checkbox">';
        }
      },{
        "targets": 1,
        "render": function ( data, type, full, meta ) {
          //return '<a href="/client/edit-org-client/'+full[0]+'/'+org_client+'" target="_blank">'+data+'</a>';
          return '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+full[0]+'" data-service_id="8">'+data+'</a>';
        }
      },{
        "targets": 2,
        "render": function ( data, type, full, meta ) {
          var text = '';
          if(data.length >0){
            text = '';
          }
          return text;
        }
      },{
        "targets": 3,
        "render": function ( data, type, full, meta ) {//alert(data.heading);
          var text;
          if(typeof data.heading === "undefined"){
            text = '';
          }else{
            if(data.field_type == 1){
              text = '<input type="text">';
            }else if(data.field_type == 4){
              var res = data.select_option.split(",");
              text = '<select class="form-control newdropdown">';
              $.each(res, function(index, value){
                text += '<option value="'+value+'">'+value+'</option>';
              });
              text += '</select>';
            }else{
              text = '<input type="text" class="date_field">';
            }
            
          }
          return text;
        }
      },{
        "targets": 4,
        "render": function ( data, type, full, meta ) {
          var text = 'Add..';
          return text;
        }
      },{
        "targets": 5,
        "render": function ( data, type, full, meta ) {
          var text = '';
          return text;
        }
      },{
        "targets": 6,
        "render": function ( data, type, full, meta ) {
          var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+full[0]+'">notes</a>';
          return text;
        }
      }/*,{
        "targets": 6,
        "render": function ( data, type, full, meta ) {
          var text = '<div class="email_client_selectbox" style="height:21px;">';
          text += '<span>SEND</span>';
          text += '<div class="small_icon" data-id="'+full[0]+'"></div><div class="clr"></div>';
          text += '<div class="select_toggle" id="status268" style="display: none;">';
          text += '<ul>';
          text += '<li><a href="javascript:void(0)" data-client_id="'+full[0]+'" data-template_id="18" class="send_template-modal">Professional Clearance</a></li>';
          text += '</ul></div></div>';
          return text;
        }
      }*/,{
        "targets": 7,
        "render": function ( data, type, full, meta ) {//console.log(full[9]);//alert(full[9])
            if(page_open == '1'){
                if(full[10] == 'Y'){
                    var text = '<button type="button" class="job_sent_btn">SENT</button>';
                }else{
                    var text = '<button type="button" class="job_send_btn" data-client_id="'+full[0]+'">SEND</button>';
                }
            }else{
                
            var text = '<input type="hidden" name="'+page_open+'_prev_status_'+full[0]+'" id="'+page_open+'_prev_status_'+full[0]+'" value="'+full[9]+'">';
                text += '<select class="form-control newdropdown table_select task_status_change" id="'+page_open+'_status_dropdown_'+full[0]+'" data-client_id="'+full[0]+'" data-manage_id="'+full[8]+'"><option value="2">Not Started</option>';
                if(data.length >0){
                  $.each(data, function(index, value){
                    var selected = "";
                    var display = 'style="display:block"';
                    if(data[index].step_id == full[9]){
                      selected = 'selected';
                    }
                    if(data[index].status == 'H'){
                      var display = 'style="display:none"';
                    }
                    text +='<option value="'+data[index].step_id+'" '+selected+' '+display+'>'+data[index].title+'</option>';

                  });
                }
                text +='<option value="completed">Completed Task</option></select>';
            } 
          
          return text;
        }
      },{
        "targets": 8,
        "render": function ( data, type, full, meta ) {console.log(data)
          var text = '<div style="float: left; width: 100%"><div class="left_d '+full[0]+'_staff_table_drop_'+service_id+'">';
          if(data.length >0){
            text += '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+full[0]+'" data-client_id="'+full[0]+'">';
            $.each(data, function(index, value){
              text +='<option value="'+data[index].staff_id+'">'+data[index].staff_name+'</option>';
            });
            text +='</select>';
          }

          text +='</div><div class="text_r"><a href="javascript:void(0);" class="openServicesStaff" data-service_id="'+service_id+'" data-client_id="'+full[0]+'" data-service_name="'+service_name+'" data-client_name="'+full[1]+'" data-page="tasks" data-client_type="'+full[11]+'">Edit</a></div></div>';

          return text;
        }
      }       
    ]
  }); 

}

function increseTabCount(status_id)
{
  var count1  = $("#task_count_"+status_id).html();
  var total1   = parseInt(count1)+parseInt(1);
  $("#task_count_"+status_id).html(total1);
}

function increseNotStartedCount()
{
  var count2  = $("#task_count_2").html();
  var total2   = parseInt(count2)+parseInt(1);
  $("#task_count_2").html(total2);
}

function decreseTabCount(status_id)
{
  var count1  = $("#task_count_"+status_id).html();
  var total1   = parseInt(count1)-parseInt(1);
  $("#task_count_"+status_id).html(total1);
}

function decreseStatusCount(client_id, service_id, status_id)
{
  var page_open = $("#page_open").val();
  var prev_status = $("#"+page_open+"_prev_status_"+client_id).val();

  var task_count = $("#task_count_"+prev_status).html();
  var total_cnt = parseInt(task_count-1);
  $("#task_count_"+prev_status).html(total_cnt);
  $("#"+page_open+"_prev_status_"+client_id).val(status_id);

  if(page_open != 1){
    //$("#"+page_open+"_prev_status_"+client_id).val(status_id);
  }

}


