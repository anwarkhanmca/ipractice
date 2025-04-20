$(document).ready(function(){
  $('body').on('click', ".open_adddrop", function(event) {
      var cpd_id = $(this).data("cpd_id");
      var tab = $(this).data("tab");
      //$(".atc-style-blue a").css("pointer-events", "pointer");
      
      //$(".cont_add_to_date").hide();
      $(".open_dropdown_"+cpd_id+"_"+tab).toggle();
      event.stopPropagation();
  });

  $("body").on("click", "#coursesnotesopen", function(){ 
    var cpdid = $(this).attr('data-id');
    $.ajax({
      type: "POST",
      url: '/getcpdnotes',
      data: { 'cpdid' : cpdid },
      beforeSend:function(){
        $("#coursesnotes-modal").modal("show");
        //$("#notescourse").removeClass("disable_click");
        $("#notescourse").addClass("disable_click");
      },
      success : function(resp){
        $('#notescourse').val(resp);
      }
    });
  });

  $("body").on("click", ".tasknotesopen", function(){
    var cpdid = $(this).attr('data-id');
    $.ajax({
      type: "POST",
      url: '/getcpdnotes',
      data: { 'cpdid' : cpdid },
      beforeSend:function(){
        $("#coursesnotes-modal").modal("show");
        $("#notescourse").addClass("disable_click");
      },
      success : function(resp){
        $('#notescourse').val(resp);
      }
    });
  })
    
  $("body").on("click", ".delcourses", function(){
    var cpddelid    = $(this).attr('data-id');
    var field_name  = $(this).attr('data-field_name');
    if(confirm('Do you want to delete?')){
      $.ajax({
        type: "POST",
        url: '/delcourses',
        data: { 'cpddelid' : cpddelid, 'field_name':field_name },
        success : function(resp){
          if(resp !=""){
            window.location.reload();
          }
        }
      });
    }
  })
  
  $("body").on("click", "#coursename", function(){
    var cpdid = $(this).attr('data-courseid');
    $.ajax({
      type: "POST",
      url: '/getcourses',
      data: { 'cpdid' : cpdid },
      success : function(resp){
        if(resp !=""){
          $('#editid').val(resp.cpd_id);
          $('#edittaskname').val(resp.course_name);
          $('#editnotesid').val(resp.notes);
          $('#editcalender_date').val(resp.course_date);
          $('#editcourseduration').val(resp.course_duration);
          $('#editcourses_time').val(resp.course_time);
          $("#editcompose-modal").modal("show");
             
          var str = resp.attendees;

  				$(".user_id").each(function(index, element) {
  					var box = $(this).val();
  					$("#attendees" + box).iCheck('uncheck');
  					if (str.indexOf(box) != -1) {
  					 $("#attendees" + box).iCheck('check');
  					}
  				});
        }
        //window.location.reload();
      }
    });
       
  });

  $('.saveCpdCource').click(function(){

    $("#insertcpdform").ajaxForm({
      dataType: 'json',
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
      },
      success: function(resp) {
        window.location.reload();
      }
    }).submit();
  });

  $('.course_name-modal').click(function(){
    $("#opencoursename-modal").modal("show");
  });

  $("#save_course_name").click(function(){
    var course_name   = $("#course_name").val();
    
    $.ajax({
      type: "POST",
      url: '/cpd/add-course-name',
      data: { 'course_name':course_name },
      beforeSend:function(){
        $('.show_loader').html('<img src="/img/spinner.gif" />');
      },
      success : function(field_id){
        $('.show_loader').html('');
        //window.location.reload();
        var append = '<div class="pop_list form-group" id="hide_div_'+field_id+'"><a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_org_name" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a>'+course_name+'</div>';
        $("#append_bussiness_type").append(append);

        $("#course_name").val("");
        $("#name").append('<option value="'+field_id+'">'+course_name+'</option>');

      }
    });
  });

  $("#append_bussiness_type").on("click", ".delete_org_name", function(){
  var field_id = $(this).data('field_id');
  if (confirm("Do you want to delete this field ?")) {
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/cpd/delete-course-name',
      data: { 'field_id' : field_id },
      success : function(resp){//console.log(resp);return false;
        if(resp != ""){
          $("#hide_div_"+field_id).hide();
          $("#name option[value='"+field_id+"']").remove();
        }else{
          alert("There are some error to delete this type, Please try again");
        }
      }
    });
  }
  
}); 


});//end document