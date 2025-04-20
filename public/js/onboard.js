$(document).ready(function(){

  $('.onboard_autosend').on('ifChecked', function(event){
    $('#txtboxToFilter').removeAttr("disabled");
  });

  $('.onboard_autosend').on('ifUnchecked', function(event){
    $('#txtboxToFilter').attr("disabled","disabled");
  });

  $('#BoxTable').on('click', '.addto_task', function(event){
    var checklist_id = $(this).data('checklist_id');
    if($(this).is(':checked')){
        $('#ownerdrop_'+checklist_id+' select').removeAttr("disabled");
        $('#statusdrop_'+checklist_id+' select').removeAttr("disabled");
        $('#new_task_date_'+checklist_id).removeAttr("disabled");
        $('#owner'+checklist_id).removeAttr("disabled");
        $('#notes_button_'+checklist_id).removeClass("disable_click");
    } else {
        $('#ownerdrop_'+checklist_id+' select').attr("disabled","disabled");
        $('#statusdrop_'+checklist_id+' select').attr("disabled","disabled");
        $('#new_task_date_'+checklist_id).attr("disabled","disabled");
        $('#owner'+checklist_id).attr("disabled","disabled");
        $('#notes_button_'+checklist_id).addClass("disable_click");
    }
    
  });

  $('#BoxTable').on('click', '.notesmodal', function(event){
    var key = $(this).data('key');
    $('#key').val(key);

    var message = $('#message_'+key).val();
    $('#table_notes').val(message);

    $('#checknotes-modal').modal('show');
  });

  $('#save_table_notes').click(function(event){
    var message = $('#table_notes').val();
    var key     = $('#key').val();
    $('#message_'+key).val(message);
    $('#checknotes-modal').modal('hide');
  });



  $('.addnew_line').click(function() {
      var client_id =$('#c_id').val();
      $.ajax({
        type: "POST",
        //url: '/client/getowner',
        url: '/onboarding/ajax-new-task',
        data: { 'client_id' : client_id },
        success : function(resp){
          $('#BoxTable > tbody:last-child').append(resp);
          //var r = resp.split('|||');
          //$("#ownerdrop").html(r[1]);
        }
      });
  });

  $(document).on("click", ".DeleteBoxRow", function(){
    var cleinttaskdate_id = $(this).data('cleinttaskdate_id');
    if(cleinttaskdate_id == 0){
      $(this).closest("tr").remove();
    }else{
      $.ajax({
        type: "POST",
        url: '/onboarding/delete-task-details',
        data: { 'cleinttaskdate_id' : cleinttaskdate_id },
        success : function(resp){
          $("#TemplateRow_"+cleinttaskdate_id).hide();
        }
      });
      
    }
  });

});

$(document).on("click", "#businessclient", function(event){
  $("#idopen_dropdown").hide();
  
  
    var client_id     = $(this).data("clientid");
    var businessname  = $(event.target).attr("data-businessname");
   // console.log(client_id);return false;
    
    $("#clientspanid").html(client_id)
    $("#c_id").val(client_id)
    $("#hiddenclient").val(client_id);
    $("#businessname").html( businessname );
    
    $.ajax({
      type: "POST",
      //url: '/client/getowner',
      url: '/onboarding/ajax-task-details',
      data: { 'client_id' : client_id },
      beforeSend: function() {
        $('#compose-modal').modal('show');
        $("#BoxTable").html('<img src="/img/spinner.gif" style="margin-left:450px" />');
      },
      success : function(resp){//return false;
      //console.log(resp);
        $("#BoxTable").html('');
        $('#BoxTable').html(resp);
        $(".onboardBName").html( businessname );
      }
    });

});
function pdfchecklist(){
    var client_id = $("#c_id").val()
    console.log(client_id);//return false;
    
    var hiturl ='/pdfdownloadajax-task-details/'+client_id
    window.location.href='/pdfdownloadajax-task-details/'+client_id
    console.log(hiturl);
    
    
}



$('#BoxTable').on("click", ".open_adddrop", function(event){
    var checklist_id = $(this).data("checklist_id");//alert(onboarding_id);
    $("#idopen_dropdown_"+checklist_id).toggle();

    var client_id = $(this).data("client_id");
    $("#calender_client_id").val(client_id);
    var cleinttaskdate_id = $(this).data("cleinttaskdate_id");
    $("#cleinttaskdate_id").val(cleinttaskdate_id);
    event.stopPropagation();
});

$('#BoxTable').on("click", ".save_job_start_date", function(event){
    var onboarding_id = $(this).data("onboarding_id");//alert(onboarding_id);
    //$("#idopen_dropdown_"+onboarding_id).toggle();
    //event.stopPropagation();
});

$('#BoxTable').on("click", ".open_calender_pop", function(event){
  $('.open_dropdown').hide();
  $("#addto_calender-modal").modal("show");
});

$("#add_position_type").click(function(){
    var type_name       = $("#checklist").val();
    var client_id       = $("#hiddenclient").val();
    var custom_check_id = $("#custom_check_id").val();
        
    if(type_name !=""){
      $.ajax({
        type: "POST",
        url: '/client/add-checklist',
        dataType:'json',
        data: { 'type_name':type_name, 'client_id':client_id, 'custom_check_id':custom_check_id },
        beforeSend: function() {
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          //window.location.reload();
          $("#checklist").val("");
          $(".show_loader").html('');
          var content = '<div class="form-group bottom0" id="hide_div_'+resp['last_id']+'"><a href="javascript:void(0)" title="Delete Field ?" class="delete_checklist_name" data-field_id="'+resp['last_id']+'"><img src="/img/cross.png" width="12"></a><label>'+type_name+'</label></div>';
          
          $("#append_position_type").append(content);
        }
      });
    }
    
});

$("#positionopen").click(function(){
    $("#checklist").html("");
    
    $('#checklist-modal').modal('show');
});
    

$("#append_position_type").on("click", ".delete_checklist_name", function(){
  var field_id = $(this).data('field_id');
  if (confirm("Do you want to delete this field ?")) {
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/delete-checklist-type',
      data: { 'field_id' : field_id },
      beforeSend: function() {
        $(".show_loader").html('<img src="/img/spinner.gif" />');
      },
      success : function(resp){
        if(resp != ""){
          //window.location.reload();
          $(".show_loader").html('');
          
          $("#hide_div_"+field_id).hide();
          
          //$("#checklist_type option[value='"+field_id+"']").remove();
        
        }else{
          alert("There are some error to delete this type, Please try again");
        }
      }
    });
  }
  
}); 


$(document).ready(function() {
  $("#txtboxToFilter").keydown(function(event) {
    if ( event.keyCode == 46 || event.keyCode == 8 ) {

		}else{

		  if($("#txtboxToFilter").val().length>=3){
			   event.preventDefault();	
         return false;
      }

			if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
        event.preventDefault();
      }	

		}
  });

  $(".change_last_date").click(function(){
    var key         = $(this).data('key');
    var tab         = $(this).data('tab');
    var prev_date   = $(this).data('prev_date');
    $(this).hide();
    $("."+tab+"_save_made_span_"+key).show();
    $("#"+tab+"_made_up_date_"+key).val(prev_date); 
  });
  $(".cancel_made_date").click(function(){
      var key   = $(this).data('key');
      var tab   = $(this).data('tab');
      $("#"+tab+"_dateanchore_"+key).show();
      $("."+tab+"_save_made_span_"+key).hide();
  });
      
  $(".save_made_date").click(function(){
    var client_id   = $(this).data('client_id');
    var tab         = $(this).data('tab');
    var key         = $(this).data('key');
    var date        = $("#"+tab+"_made_up_date_"+key).val();
    $.ajax({
      type: "POST",
      //dataType : "json",
      url: "/onboardsave-made-up-date",
      data: { 'client_id': client_id, 'date': date },
      success: function (resp) {
        window.location = "/onboard";
      }
    });
  });

//=========== Delete Onboarding Client Start ===========//
  $('#deleteOnboarding').click(function() {
    var val = [];
        //alert('val');return false;
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    //alert(val.length);return false;
    if(val.length>0){
      var client_type = $("#client_type").val();
      if(confirm("Do you want to delete??")){
        $.ajax({
            type: "POST",
            url: '/onboarding/delete-onboarding-clients',
            data: { 'client_delete_id' : val },
            success : function(resp){
              window.location.reload();
            }
        });
      }

    }else{
      alert('Please select atleast one clients');
    }
  });
//=========== Delete Onboarding Client End ===========//

//=========== Auto Send Email Remind Days Start ===========//
  $('#compose-modal').on('blur', '#reminddays', function() {
    var remind_days = $(this).val();
    $.ajax({
        type: "POST",
        url: '/onboarding/autosend-days',
        data: { 'remind_days' : remind_days },
        success : function(resp){
          //window.location.reload();
        }
    });
  });
//=========== Auto Send Email Remind Days End ===========//

//=========== Add Task Date Start ===========//
  $('#addto_calender-modal').on('click', '.save_job_start_date', function(event) {
    event.preventDefault();
    var cleinttaskdate_id = $('#cleinttaskdate_id').val();
    var calender_date = $('#calender_date').val();
    var calender_time = $('#calender_time').val();
    var client_id = $('#c_id').val();
    $.ajax({
        type: "POST",
        url: '/onboarding/add-task-date',
        data: { 'cleinttaskdate_id':cleinttaskdate_id, 'calender_date':calender_date, 'calender_time':calender_time },
        success : function(resp){
          $('#calender_date').val('');
          $('#calender_time').val('');
          $("#BoxTable").html('');
          $('#addto_calender-modal').modal('hide');
          open_checklist_popup(client_id);
          
        }
    });
  });
//=========== Add Task Date End ===========//

    $("body").on("click", ".select_icon", function(event){
        var visable = 0;
        event.stopPropagation();
        //var id = $(this).data("id");
        /*if($(".open_toggle").is(':visible')){
            visable = 1;
        }*/
        $(".open_toggle").toggle();

        /*if(visable == 1){
            $("#status"+id).hide();
        }else{
            $("#status"+id).show();
        }    */
        
    });

/* ============= CUSTOM CHECKLIST SECTION ================= */
    $(document).click(function() {
        $(".open_toggle").hide();
    });
    
    $("#add_new_tasks").click(function(){
        $("#custom_name").val("");
        $('#new_check-modal').modal('show');
    });
    
    $('body').on("click", ".positionopen", function(){
        $("#checklist").val("");//append_position_type
        var custom_check_id = $(this).data('custom_check_id');
        $("#custom_check_id").val(custom_check_id);
        
        $.ajax({
            type: "POST",
            url: '/onboarding/custom-checklist-action',
            data: { 'custom_check_id':custom_check_id, 'action':'getByCheckId' },
            beforeSend: function(){
                $("#append_position_type").html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
            },
            success : function(data){
                var resp = $.parseJSON(data);
                var content = '';//alert(resp.length)
                
                if (resp.length != 0) {
                    $.each(resp, function(key){
                      content+= '<div class="form-group bottom0" id="hide_div_'+resp[key].checklist_id+'">';
                      if(resp[key].status == 'new'){
                        content+= '<a href="javascript:void(0)" title="Delete Field ?" class="delete_checklist_name" data-field_id="'+resp[key].checklist_id+'"><img src="/img/cross.png" width="12"></a>';
                      }
                      content += '<label>'+resp[key].name+'</label></div>';
                    });
                }
                $("#append_position_type").html(content);
                $('#new_check-modal').modal('hide');
            }
        });
        
        $('#checklist-modal').modal('show');
    });
    
    $("#save_new_checklist").click(function(){
        var custom_name = $("#custom_name").val();
        if(custom_name == ""){
            alert('Please enter custom checklist name');
            $("#custom_name").focus();
            return false;
        }
        
        $.ajax({
            type: "POST",
            url: '/onboarding/custom-checklist-action',
            data: { 'custom_name':custom_name, 'action':'add' },
            beforeSend: function() {
                $(".show_loader").html('<img src="/img/spinner.gif" />');
            },
            success : function(resp){
                var obj = $.parseJSON(resp);
                $(".show_loader").html('');
                var content = "";
                content += '<div class="l_task_contain" id="hide'+obj.custom_check_id+'">';
                content += '<div class="l_select_con"><a href="javascript:void(0)" class="positionopen" data-custom_check_id="'+obj.custom_check_id+'">'+obj.custom_name+'</a></div>';
                content += '<div class="delete_task_name"><a href="javascript:void(0)" class="remove_checklist" data-custom_check_id="'+obj.custom_check_id+'">';
                content += '<img src="../img/cross.png" height="12"></a></div><div class="clearfix"></div></div>';
                $('#custom_list').append(content);
                $('#new_check-modal').modal('hide');

            }
        });
    });//
    
    $('body').on("click", ".remove_checklist", function(){
        var custom_check_id = $(this).data('custom_check_id');
        $.ajax({
            type: "POST",
            url: '/onboarding/custom-checklist-action',
            data: { 'custom_check_id':custom_check_id, 'action':'delete' },
            success : function(resp){
                $('#hide'+custom_check_id).remove();
            }
        });
        
    });
    


});//end document

function open_checklist_popup(client_id)
{
  $.ajax({
      type: "POST",
      //url: '/client/getowner',
      url: '/onboarding/ajax-task-details',
      data: { 'client_id' : client_id },
      beforeSend: function() {
        $('#compose-modal').modal('show');
        $("#BoxTable").html('<img src="/img/spinner.gif" style="margin-left:450px" />');
      },
      success : function(resp){//return false;
        $("#BoxTable").html('');
        $('#BoxTable').html(resp);
      }
    });
}

function notes(){
  var notes      = $("#notess").val();
  var client_id      = $("#notescid").val();
  $.ajax({
    type: "POST",
    url: '/client/onboardsnotes',
    data: { 'client_id':client_id,'notes':notes },
    success : function(resp){
      
      console.log(resp);
      
     $("#composenotes-modal").modal("hide");

    }
  });
}

$(document).on("click", "#notesmodal", function(event){
  $("#notess").val("");
  var client_id =$(this).attr('data-cid');
  $("#notescid").val(client_id);
  $.ajax({
    type: "POST",
    url: '/client/getonboardsnotes',
    data: { 'client_id':client_id },
    success : function(resp){
      $("#notess").val(resp);
    }
  });
  $("#composenotes-modal").modal("show");
  event.preventDefault();
});



