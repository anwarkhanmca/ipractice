$(document).ready(function () {
    $('body').on('focus', '.task_date', function(){
        $(this).datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
    });
    
    $('#allCheckSelect').on('ifChecked', function(event){
		$('input').iCheck('check');
	});

	$('#allCheckSelect').on('ifUnchecked', function(event){
		$('input').iCheck('uncheck');
	});
    
    $('#deleteOnboarding').click(function() {
      var val = [];
      //alert('val');return false;
      $(".ads_Checkbox:checked").each( function (i) {
              if($(this).is(':checked')){
                  val[i] = $(this).val();
              }
      }); 
      if(val.length>0){
        if(confirm('Do you want to delete?')){
          $.ajax({
            type: "POST",
            url: '/onboarding/custom-checklist-action',
            data: { 'checklist_ids':val, 'action':'deleteTableChecklist' },
            success : function(resp){
              window.location.reload();
            }
          });
         }
      }else{  
 			alert('Please select atleast one checklist');
 		}
 	});

  $('#BoxTable').on('click', '.addto_task', function(event){
    var checklist_id = $(this).data('checklist_id');
      if($(this).is(':checked')){
          $('#owner'+checklist_id).removeAttr("disabled");
          $('#new_task_date_'+checklist_id).removeAttr("disabled");
          $('#statusdrop_'+checklist_id).removeAttr("disabled");
          $('#notes_button_'+checklist_id).css("pointer-events", 'auto');
      } else {
          $('#owner'+checklist_id).attr("disabled","disabled");
          $('#new_task_date_'+checklist_id).attr("disabled","disabled");
          $('#statusdrop_'+checklist_id).attr("disabled","disabled");
          $('#notes_button_'+checklist_id).css("pointer-events", 'none');
      }
    
  });
  
  $(".openCheckPop").click(function(event) {
    var checklist_id    = $(this).data('checklist_id');
    var itemname        = $(this).data('itemname');
    
    open_checklist_popup(checklist_id, itemname)
    
  });
  
  $('#BoxTable').on("click", ".open_adddrop", function(event){
    var checklist_id = $(this).data("checklist_id");//alert(onboarding_id);
    $("#idopen_dropdown_"+checklist_id).toggle();

    /*var client_id = $(this).data("client_id");
    $("#calender_client_id").val(client_id);
    var cleinttaskdate_id = $(this).data("cleinttaskdate_id");
    $("#cleinttaskdate_id").val(cleinttaskdate_id);*/
    event.stopPropagation();
  });
  
  $('#BoxTable').on("click", ".open_calender_pop", function(event){
    $('.open_dropdown').hide();
    var checklist_id    = $(this).data('checklist_id');
    $('#checklist_id').val(checklist_id);
    $("#addto_calender-modal").modal("show");
  });
  
  //=========== Add Task Date Start ===========//
  $('#addto_calender-modal').on('click', '.save_job_start_date', function(event) {
    event.preventDefault();
    var checklist_id    = $('#checklist_id').val();
    var calender_date   = $('#calender_date').val();
    var calender_time   = $('#calender_time').val();
    var popchecklist_id = $('#popchecklist_id').val();
    var itemname        = $('#check_title').html();

    $.ajax({
        type: "POST",
        url: '/checklist/add-task-date',
        data: { 'checklist_id':checklist_id, 'popchecklist_id':popchecklist_id, 'calender_date':calender_date, 'calender_time':calender_time },
        success : function(resp){
          $('#calender_date').val('');
          $('#calender_time').val('');
          $("#BoxTable").html('');
          $('#addto_calender-modal').modal('hide');
          
          open_checklist_popup(popchecklist_id, itemname)
          
        }
    });
  });
//=========== Add Task Date End ===========//
  
  $('body').on("click", ".positionopen", function(){
        $("#checklist").val("");
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
                var content = '';
                
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
                $(".show_loader").html('');
                $("#hide_div_"+field_id).hide();
              }else{
                alert("There are some error to delete this type, Please try again");
              }
            }
          });
        }

      });
  
  $('body').on('click', ".notesmodal", function(event) {
      var tablechecklist_id  = $(this).data('tablechecklist_id');
      var position           = $(this).data('position');
      var key                = $(this).data('key');
      var message            = $('#message_'+key).val();
      
      $.ajax({
        type: "POST",
        url: '/onboarding/custom-checklist-action',
        data: { 'tablechecklist_id':tablechecklist_id, 'position':position, 'action':'getChecklistTables' },
        beforeSend: function(){
            $("#tablechecklist_id").val(tablechecklist_id);
            $("#position").val(position);
            $("#key").val(key);
            //$("#append_position_type").html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
        },
        success : function(data){
            var resp = $.parseJSON(data);
            if(message == ''){
              $("#table_notes").val(resp.notes);
            }else{
              $("#table_notes").val(message);
            }
            
            $('#checknotes-modal').modal('show');
        }
    });
  });
  
  $("#save_table_notes").click(function(event) {
      var tablechecklist_id  = $('#tablechecklist_id').val();
      var notes              = $('#table_notes').val();
      var position           = $('#position').val();
      var key                = $('#key').val();
      
      $.ajax({
        type: "POST",
        url: '/onboarding/custom-checklist-action',
        data: { 'tablechecklist_id':tablechecklist_id, 'position':position, 'notes':notes, 'action':'saveTablNnotes' },
        beforeSend: function(){
            $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success : function(data){
            $(".show_loader").html('');
            $("#message_"+key).val(notes);
            $('#checknotes-modal').modal('hide');
        }
    });
      
  });

  $("#saveOnbording").click(function(event) {
      $("#onboardingForm").ajaxForm({
        //dataType: 'json',
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function(resp) {
          location.reload();      
        }
      }).submit();
      
  });
  
  
/* ================ Save Add to List Pop up ================ */
  $("#add_sub_checklist").click(function(){
        var type_name       = $("#checklist").val();
        var client_id       = '0';
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
  
  $("#TablePopOpen").click(function(event) {
    $('#checkTable-modal').modal('show');
  });
/* ================ Save Add to Table Pop up ================ */
  $("#add_table_data").click(function(){
    var type_name       = $("#table_item").val();
    var custom_check_id = $("#custom_check_id").val();
        
    if(type_name !=""){
        $.ajax({
          type: "POST",
          url: '/checklist/add-checklist',
          dataType:'json',
          data: { 'type_name':type_name, 'custom_check_id':custom_check_id },
          beforeSend: function() {
            $(".show_loader").html('<img src="/img/spinner.gif" />');
          },
          success : function(resp){
            window.location.reload();
            /*$("#table_item").val("");
            $(".show_loader").html('');
            var content = '<div class="form-group bottom0" id="hide_div_'+resp['last_id']+'"><a href="javascript:void(0)" title="Delete Field ?" class="delete_checklist_name" data-field_id="'+resp['last_id']+'"><img src="/img/cross.png" width="12"></a><label>'+type_name+'</label></div>';

            $("#append_position_type").append(content);*/
          }
        });
      }   
    });

  /* Edit task name pop up */
  $(".openEditJobPop").click(function(){
    var check_id   = $('#custom_check_id').val();
    var check_name = $('#taskTitleSpan').html();
    $('#task_name').val(check_name);
    $('#edit_task-modal').modal('show');
  }); 

  $("#save_task_popup").click(function(){
    var check_id   = $('#custom_check_id').val();
    var check_name = $('#task_name').val();
    $.ajax({
      type: "POST",
      url: '/checklist/save-check-details',
      dataType:'json',
      data: { 'check_id':check_id, 'check_name':check_name, 'action':'save' },
      beforeSend:function(){
        $(".loader_show").html('<img src="/img/spinner.gif" />');
      },
      success : function(resp){ 
        $(".loader_show").html('');
        $('#taskTitleSpan').html(check_name);
        $('#edit_task-modal').modal('hide');
      }
    });
  });







});





function open_checklist_popup(checklist_id, itemname)
{
    $.ajax({
      type: "POST",
      url: '/checklist/ajax-check-details',
      data: { 'checklist_id' : checklist_id },
      beforeSend: function() {
        $('#openCheckPop-modal').modal('show');
        $('#check_title').html(itemname);
        $('#popchecklist_id').val(checklist_id);
        $("#BoxTable").html('<img src="/img/spinner.gif" style="margin-left:450px" />');
      },
      success : function(resp){//return false;
        $("#BoxTable").html('');
        $('#BoxTable').html(resp);
      }
    });
}