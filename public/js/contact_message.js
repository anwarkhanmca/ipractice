$(document).ready(function () {

  $('.contact_form').click(function(){
    refreshForm();

    var msg_type = $(this).data('msg_type');
    $('#msg_type').val(msg_type);
    if(msg_type == 'S'){
      $('#contact_title').html('Suggestion Box');
    }else if(msg_type == 'R'){
      $('#contact_title').html('Report a Problem');
    }else{
      $('#contact_title').html('Contact Us');
    }

    $("#contact_report-modal").modal("show");
  });

  $('.save_contact_form').click(function(){
    var email = $('#field_email').val();
    var name  = $('#field_name').val();
    var desc  = $('#field_desc').val();
    if(email == ''){
      alert('Please enter email address');
      $('#field_email').focus();
      return false;
    } else if(!validateEmail(email)){
        alert("Please enter valid email");
        $('#field_email').focus();
        return false;
    }else if(name == ''){
      alert('Please enter name');
      $('#field_name').focus();
      return false;
    }else if(desc == ''){
      alert('Please enter description');
      $('#field_desc').focus();
      return false;
    } else {
      $("#contact_form").ajaxForm({
        //dataType: 'json',
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function(resp) {
          //window.location.reload();
          $('#modalBody').hide();
          $(".show_loader").html('<div style="color:#00acd6; padding-bottom:15px;">Thank you! We will review your message and get back to you as soon as possible</div>');
        }
      }).submit();
    }
  }); 
  
  $("body").on("click", ".delete_report", function(){
    var report_id  = $(this).data('report_id');

    if(confirm('Do you want to delete?')){
      $.ajax({
        type: "POST",
        url: '/delete-contact-report',
        data: { 'report_id' : report_id },
        success : function(resp){
          if(resp !=""){
            window.location.reload();
          }
        }
      });
    }
  });

  $('.open_message').click(function(){
    var report_id = $(this).data('report_id');
    $('.new_msg_'+report_id).hide();

    $.ajax({
        type: "POST",
        dataType: 'json',
        url: '/get-contact-report',
        data: { 'report_id' : report_id },
        success : function(resp){
          var notesMsg = $('#notesMsg_'+report_id).val();
          $("#open_message-modal").modal("show");
          $('#notesMsg').val(notesMsg);
          $('#subjectPop').val(resp.subject);
        }
      });

    
  });

});//document end





function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);
}

function refreshForm()
{
  $(".show_loader").html('');
  $('#modalBody').show();

  $('#field_email').val('');
  $('#field_name').val('');
  $('#field_desc').val('');
  $('#field_subject').val('');
  $('#field_desc').val('');
  $('#add_file').val('');

}