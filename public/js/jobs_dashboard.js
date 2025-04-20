$(document).ready(function(){ 
    $('#tasks_list').hide();
    $('#custom_list').hide();
    
    $('#select_icon').click(function() {
      $('#tasks_list').toggle();
    });

    $('#add_new_tasks').click(function() {
      $('#newtasks-modal').modal("show");
    });
    
    $('#select_dropdown').click(function() {
      $('#custom_list').toggle();
    });

    $('#add_new_check').click(function() {
      $('#new_check-modal').modal("show");
    });

    $('#save_new_tasks').click(function() {
      var tasks_name  = $('#tasks_name').val();
      var client_type = $('#client_type').val();

      $.ajax({
        type: "POST",
        url: '/jobs/save-task-name',
        data: { 'tasks_name':tasks_name, 'client_type' : client_type },
        beforeSend: function() {
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          var obj = JSON.parse(resp);
          //console.log(obj.service_name);
          var append = '<div class="l_task_contain" id="hide'+obj.service_id+'">';
          append += '<div class="l_select_con"><a href="'+obj.url+'">'+obj.service_name+'</a></div>';
          append += '<div class="delete_task_name"><a href="javascript:void(0)" class="remove_tasks" data-service_id="'+obj.service_id+'"><img src="../img/cross.png" height="12"></a></div>';
          append += '<div class="clearfix"></div></div>';
          $("#tasks_list").append(append);

          $("#tasks_name").val("");
          $(".show_loader").html('');
          $('#newtasks-modal').modal("hide");

        }
      });
    });

    $('body').on('click', '.remove_tasks', function() {
      var service_id = $(this).data('service_id');
      //var $event_action = $(this).closest("div");
      if(confirm('Do you want to delete this task?')){
        $.ajax({
          type: "POST",
          url: '/ct/delete-task-name',
          data: { 'service_id':service_id, 'action': 'delete' },
          success : function(resp){
            //var obj = JSON.parse(resp);
            $('#hide'+service_id).remove();
          }
        });
      }
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
    });
    
    $('body').on("click", ".remove_checklist", function(){
      var custom_check_id = $(this).data('custom_check_id');
      if(confirm('Do you want to delete this checklist?')){
        $.ajax({
          type: "POST",
          url: '/onboarding/custom-checklist-action',
          data: { 'custom_check_id':custom_check_id, 'action':'delete' },
          success : function(resp){
              $('#hide'+custom_check_id).remove();
          }
        });
      }
    });
    
    
    
    
    
    
}); 