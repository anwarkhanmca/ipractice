$(document).ready(function(){
  $('.goToProposalPreview').click(function(){
    var proposal_id = $('#ProposalID').val();
    $.ajax({
      type: "POST",
      url: "/proposal/action",
      dataType:'json',
      data: { 'proposal_id' : proposal_id, 'action' : 'checkProposalId' },
      success : function(resp){
        if(resp.length != 0 && resp.crm_proposal_id > 0){
          window.open('/proposal-preview/'+resp.entrpt_crm_prop_id+'/add/'+resp.is_rejected, 'name');
        }else{
          alert('Please save the proposal details before view.');
          return false;
        }
      }
    });
  });

  $('.openDropdown').click(function(){
    var d_no = $(this).data('d_no');
    $('.dropdown-menu').hide();
    $('.dropdownAttact'+d_no).show();
  });

  $(".attach_file_readme").click(function(e){
    e.preventDefault();
    var notes = $(this).data('notes');
    var title = $(this).data('title');
    $("#contentArea").html(notes);
    $(".addNewName").html(title);
    $("#notesReadme-modal").modal('show');
  });

  $('.clickArro_a').click(function(){
    var id = $(this).data('id');
    if($('#service_'+id).is(':hidden')) {
      $(this).html('<i class="fa fa-angle-up upDownArrow"></i>');
    }else{
      $(this).html('<i class="fa fa-angle-down upDownArrow"></i>');
    }
    /*$('.actvCont').slideToggle();
    $('.clickArro_a').html('<i class="fa fa-angle-down upDownArrow"></i>');
    $(this).html('<i class="fa fa-angle-up upDownArrow"></i>');*/
    $('#service_'+id).slideToggle();
  });

  /*$('#postComment').click(function(){
    var crm_proposal_id   = $('#crm_proposal_id').val();
    var comment_text      = $('#comment_text').val();
    if(comment_text == ''){
      alert('Please enter comment.');
      $('#comment_text').focus();
      return false;
    }

    $("#commentForm").ajaxForm({
      dataType: 'json',
      data:{'crm_proposal_id':crm_proposal_id, 'comment_text':comment_text},
      beforeSend : function(){
        $("#postCommentArea").html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
        $('.classyedit .editor').html('');
        $('#comment_text').val('');
      },
      success: function(resp) {
        $("#postCommentArea").html('');
        var comments = resp.comments;
        var content = '';
        $.each(comments, function(k, v){
          content += '<div class="singleComment">';
          content += '<div class="col-md-1"><i class="fa fa-user user-icon" aria-hidden="true"></i></div>';
          content += '<div class="col-md-11"><p><strong>'+v.previewSender+'</strong>&nbsp;&nbsp; '+v.created_format+'</p>';
          content += '<div>'+v.comment+'</div>';
          content += '</div></div>';
        });
        
        $('#postCommentArea').html(content);

        
      }
    }).submit();
  });*/

  


});//main document end