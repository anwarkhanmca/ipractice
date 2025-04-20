$(document).ready(function () {
  $(window).load(function() {
    $(".page_loader").fadeOut("slow");
  });

  $('.head_tab').click(function(){
    $(".page_loader").show();
    window.location = $(this).data('url');
  })

});//document end
