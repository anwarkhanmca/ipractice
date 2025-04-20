$(document).ready(function () {
  /*$('.ads_Checkbox').on('ifChecked', function(event){
      $(".ads_Checkbox").iCheck('disable');
      $(".ads_Checkbox:checked").iCheck('enable');
      var client_id = $(".ads_Checkbox:checked").val();
      var client_number = $("#clnt_no_"+client_id).html();
      $("#client_number").val(client_number);
      //alert(client_number)
  });

  $('.ads_Checkbox').on('ifUnchecked', function(event){
      $(".ads_Checkbox").iCheck('enable');
      $("#client_number").val('');
  });*/

  $('.webcheckButton').click(function(){
      //var client_number = $("#client_number").val();
    var val = [];
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    //alert(val.length);return false;
    if(val.length == 0){
      alert("Please select atleast one client.");
      return false;
    }else if(val.length > 1){
      alert("You can't select more than one client.");
      return false;
    }else{
      var client_id = $(".ads_Checkbox:checked").val();
      var client_number = $("#clnt_no_"+client_id).val();
      if(client_number == ''){
        var win = window.open('https://beta.companieshouse.gov.uk', '_blank');
      }else{
        var win = window.open('https://beta.companieshouse.gov.uk/company/'+client_number, '_blank');
      }
      win.focus();
    }
  });

  $('.webcheckEditOrg').click(function(){
    var client_number = $("#registration_number").val();
    if(client_number == ''){
      var win = window.open('https://beta.companieshouse.gov.uk', '_blank');
    }else{
      var win = window.open('https://beta.companieshouse.gov.uk/company/'+client_number, '_blank');
    }
    win.focus();
  });
  
  



//https://beta.companieshouse.gov.uk
});//document end
