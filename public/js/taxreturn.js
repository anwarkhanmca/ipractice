$(document).ready(function(){

  $("#employment_incomebody").hide();
  $("#self_incomebody").hide();
  $("#pension_incomebody").hide();
  $("#property_incomebody").hide();
  $("#other_incomebody").hide();
  $("#ukinvestment_incomebody").hide();
  $("#foreign_incomebody").hide();
  $("#trust_estatesbody").hide();
  $("#reliefsbody").hide();
  $("#capital_gainsbody").hide();
  $("#lloyedsbody").hide();
  $("#residence_statusbody").hide();
  $("#misscellaneousbody").hide();
  $("#other_informationbody").hide();

});

/* ================== Browse Document Start ===================== */
var options = { 
    beforeSend: function(){
    },
    uploadProgress: function(event, position, total, percentComplete){
    },
    success: function(){
      
    },
    complete: function(response){
      var obj = JSON.parse(response.responseText);
      //console.log(obj.client_id);
      var html = '<li data-value="non"><a href="javascript:void(0)" data-client="'+obj.client_id+'" data-file="'+obj.file_name+'" id="'+obj.id+'" class="filename">'+obj.file_name+'</a><strong style="float: right;"><a href="javascript:void(0)" class="deldoc" data-delid="delid_'+obj.id+'" ><img src="/img/cross.png"></a></strong></li>';
      $('.doc_list').append(html);
    },
    error: function(){
        $("#message").html("<font color='red'> ERROR: unable to upload files</font>");
    }
}; 

$(".staffupload_file").change(function() {
  var tax_year = $('#change_tax_year').val();
  if( tax_year == ''){
    alert('Please select tax year');
    $('#change_tax_year').focus();
    return false;
  }else{
    $('#upload_tax_year').val(tax_year);
    $("#clientpdfeform14").submit();
  }
  
});

$("#clientpdfeform14").ajaxForm(options);

/* ================Browse Document End =================== */

// Add individual client
$(".open").click(function(){
  var data_id = $(this).data('id');
  if(data_id == 2){
    if($("#fname").val() == ""){
      alert("First name can not be null");
      $("#fname").focus();
      return false;
    }else if($("#lname").val() == ""){
      alert("Last name can not be null");
      $("#lname").focus();
      return false;
    }

  }
  var remove_id = data_id-1;
  $("#tab_"+data_id).addClass("active");
  $("#tab_"+remove_id).removeClass("active");
  $(".tab-pane").fadeOut("fast");
  $("#step"+data_id).fadeIn("slow");
});

$(".open_header").click(function(){
  var data_id = $(this).data('id');
  ///////////Validation//////////////
  if(data_id == 2){
    if($("#fname").val() == ""){
      alert("First name can not be null");
      $("#fname").focus();
      return false;
    }else if($("#lname").val() == ""){
      alert("Last name can not be null");
      $("#lname").focus();
      return false;
    }

  }
  ///////////Validation//////////////

  $("#header_ul li").parent().find('li').removeClass("active");
  $(this).parent('li').addClass('active');
  $(".tab-pane").fadeOut("fast");
  $("#step"+data_id).fadeIn("slow");
});

$(".back").click(function(){
  var data_id = $(this).data('id');
  var remove_id = Number(data_id)+Number(1);
  $("#tab_"+data_id).addClass("active");
  $("#tab_"+remove_id).removeClass("active");
  $(".tab-pane").fadeOut("fast");
  $("#step"+data_id).fadeIn("slow");
});




 $('#employment_income').on('ifChecked', function(event){
      $("#employment_incomebody").show();
  });
  $('#employment_income').on('ifUnchecked', function(event){
      $("#employment_incomebody").hide();
  });
  
  
 $('#self_income').on('ifChecked', function(event){
      $("#self_incomebody").show();
  });
  $('#self_income').on('ifUnchecked', function(event){
      $("#self_incomebody").hide();
  });
  
  $('#pension_income').on('ifChecked', function(event){
      $("#pension_incomebody").show();
  });
  $('#pension_income').on('ifUnchecked', function(event){
      $("#pension_incomebody").hide();
  });
  
  
  $('#property_income').on('ifChecked', function(event){
      $("#property_incomebody").show();
  });
  $('#property_income').on('ifUnchecked', function(event){
      $("#property_incomebody").hide();
  });
   
  $('#other_income').on('ifChecked', function(event){
      $("#other_incomebody").show();
  });
  $('#other_income').on('ifUnchecked', function(event){
      $("#other_incomebody").hide();
  });
   $('#ukinvestment_income').on('ifChecked', function(event){
      $("#ukinvestment_incomebody").show();
  });
  $('#ukinvestment_income').on('ifUnchecked', function(event){
      $("#ukinvestment_incomebody").hide();
  });
  
  $('#foreign_income').on('ifChecked', function(event){
      $("#foreign_incomebody").show();
  });
  $('#foreign_income').on('ifUnchecked', function(event){
      $("#foreign_incomebody").hide();
  });
  
    $('#trust_estates').on('ifChecked', function(event){
      $("#trust_estatesbody").show();
  });
  $('#trust_estates').on('ifUnchecked', function(event){
      $("#trust_estatesbody").hide();
  });
    $('#capital_gains').on('ifChecked', function(event){
      $("#capital_gainsbody").show();
  });
  $('#capital_gains').on('ifUnchecked', function(event){
      $("#capital_gainsbody").hide();
  });
    $('#reliefs').on('ifChecked', function(event){
      $("#reliefsbody").show();
  });
  $('#reliefs').on('ifUnchecked', function(event){
      $("#reliefsbody").hide();
  });
  
  $('#lloyeds').on('ifChecked', function(event){
      $("#lloyedsbody").show();
  });
  $('#lloyeds').on('ifUnchecked', function(event){
      $("#lloyedsbody").hide();
  });
  
  $('#residence_status').on('ifChecked', function(event){
      $("#residence_statusbody").show();
  });
  $('#residence_status').on('ifUnchecked', function(event){
      $("#residence_statusbody").hide();
  });
  
  $('#misscellaneous').on('ifChecked', function(event){
      $("#misscellaneousbody").show();
  });
  $('#misscellaneous').on('ifUnchecked', function(event){
      $("#misscellaneousbody").hide();
  });
  
  $('#other_information').on('ifChecked', function(event){
      $("#other_informationbody").show();
  });
  $('#other_information').on('ifUnchecked', function(event){
      $("#other_informationbody").hide();
  });
  
  
  
  
  $(document).click(function() {
    $(".open_toggle").hide();
  });
  
  $(".select_icon").click(function(event) {
    $(this).siblings('.open_toggle').toggle();
    event.stopPropagation();
  });
  
  $(".select_title").change(function(){
    var value   = $(this).val();
    //alert(value);
    var male = ['Mr', 'Rev', 'Sir', 'Lord', 'Captain'];
    var female = ['Mrs', 'Miss', 'Dame', 'Lady'];
    if($.inArray(value, male) != -1){
      $("#gender").val('Male');
    }else if($.inArray(value, female) != -1){
      $("#gender").val('Female');
    }else{
      $("#gender").val('');
    }
  });

$("#res_country").on("change", function(){
    
  var value   = $(this).val();
  console.log(value);
  
  $("#res_tele_code").val(value);
  //alert(value);

 });




/*$(".staffupload_file").click(function() {
	var id = $(this).attr("id").match(/\d+/);
//	alert(id);return false;
   	$('#add_pdffile' + id).on('change', function() {
		//alert("#pdfeform"+id);return false;
		$("#clientpdfeform" + id).ajaxForm(
		{
			success: function(response) {
			 console.log(response);//return false;
            location.reload();
			}
		}).submit();
        
        	
	});
});*/


$("body").on("click",".filename",function(){
    var clinet_id=$(this).attr("data-client");
    var id= $(this).attr("id");
    var file= $(this).attr("data-file");
    
    var path = '/uploads/client_doc/'+file;
    //console.log(path); return false;
    $('#clienttaxpdfviwer').attr('src', path)
   
});

$("body").on("click",".deldoc",function(){
  var id= $(this).attr("data-delid");
  var res = id.split("_");
  var delid =res['1'];
   
  $.ajax({
    type: "POST",
    url: '/pdfclientdelete',
    data: { 'delid' : delid },
    success : function(resp){
      window.location.reload();
    }
  });
}); 



$("body").on("click",".notesmodalcall",function(){
  $('#notess').val('');
  var notesid= $(this).attr('data-nid');
  $('#notesid').val(notesid);
  $('#composenotes-modal').modal('show');
});

$("body").on("click","#save_notes",function(){
  var note  =   $('#notess').val();
  var level =   $('#notesid').val();
  $.ajax({
    type: "POST",
    url: '/notessave',
    data: { 'note' : note ,'level' : level},
    success : function(resp){
      location.reload();
    }
  });
});



$(document).ready(function(){


/* ============== Tax return dropdown change ============= */
$("body").on("change",".change_tax_year",function(){

  var TaxYear     = $(this).val();
  var tax_year    = TaxYear.replace("/", "-");
  var service_id  = 7;
  var client_id   = $('#main_client_id').val();
  var page_open   = $('#page_open').val();
  var encoded_page_name = $('#encoded_page_name').val();
  
  if(page_open == 2){
    if(TaxYear == ''){
      window.location.href="/tsxreturninfromation/"+client_id+"/"+encoded_page_name+"/2/0";
    }else{
      window.location.href="/tsxreturninfromation/"+client_id+"/"+encoded_page_name+"/"+page_open+'/'+tax_year;
    }
  }

    return false;

  /*if(tax_year == ''){
    if(page_open == 1){
      $('#non_clickable').addClass('avoid-clicks');
    }else{
      var encoded_page_name = $('#encoded_page_name').val();
      window.location.href="/tsxreturninfromation/"+client_id+"/"+encoded_page_name+"/"+page_open+'/'+tax_year;
    }
    return false;
  }else{
    if(page_open == 1){
      $('#non_clickable').removeClass('avoid-clicks');
      return false;
    }
  }

  $.ajax({
      type:'POST',
      dataType : 'json',
      url : '/ic/get-taxreturn-details',
      data : {'service_id':service_id, 'tax_year':tax_year, 'client_id':client_id},
      beforeSend : function(){
          $("#progress").hide();
      },
      success : function(resp){
        var taxyear = tax_year.split('/');//alert(taxyear);
        var text_year = '6th April '+taxyear[0]+' - 5th April 20'+taxyear[1]
        $('.show_date').html(text_year);

          if(resp.details.checklist_id){
              var ul_li = '';
              $.each(resp.details.documents, function(index, value){
                  ul_li += '<li><a href="/uploads/tax_return_doc/'+resp.details.documents[index].document_name+'" download>'+resp.details.documents[index].document_name+'</a></li>';
              });
              
              $("#document_list").html(ul_li);
              $('#checklist_id').val(resp.details.checklist_id);
              $('#tax_remind_days').val(resp.details.remind_days);
          }else{
              $("#document_list").html('');
              $('#tax_remind_days').val('');
          }
      }
  });*/
});


  $("#header_ul a").on("click", function(){
    var client_id         = $('#main_client_id').val();
    var encoded_page_name = $('#encoded_page_name').val();
    var tax_year          = $('#change_tax_year').val();
    tax_year = tax_year.replace("/", "-");

    var page_open = $(this).data('open_id');
    if(page_open == 2 && tax_year == ''){
      alert('Please select tax year');
    }else{


    window.location.href="/tsxreturninfromation/"+client_id+"/"+encoded_page_name+"/"+page_open+'/'+tax_year;
    }
  });

  $('.reminder_check').on('ifChecked', function(event){
    var chechlist_id = $(this).data('checklist_id');
    update_checklist('is_reminder', 'Y', chechlist_id);
  });
  $('.reminder_check').on('ifUnchecked', function(event){
    var chechlist_id = $(this).data('checklist_id');
    update_checklist('is_reminder', 'N', chechlist_id);
  });


  $("body").on("click", ".save_message", function(){
    var initial_badge = $('#initial_badge').val();
    var reply_id      = $(this).data('reply_id');
    var service_id    = $("#service_id").val();//alert(service_id);return false;
    var tax_year      = $("#change_tax_year").val();
    var checklist_id  = $("#checklist_id").val();
    var subject       = $("#subject").val();
    var message       = $("#message"+reply_id).val();
    var client_id     = $("#main_client_id").val();
    

    if(tax_year == ''){
      alert('Please select tax year');
      $("#change_tax_year").focus();
      return false;
    }/*else if(message == ''){
      alert('Please enter message');
      $("#message").focus();
      return false;  
    }*/else{
      $.ajax({
        type:'POST',
        dataType : 'json',
        url : '/ic/save-messages',
        data : {  'service_id' : service_id, 'client_id':client_id, 'subject':subject, 'message':message, 'tax_year':tax_year, 'checklist_id':checklist_id, 'reply_id':reply_id},
        beforeSend : function(){
            $("#loader"+reply_id).html('<img src="/img/spinner.gif" />');//return false;
            $('.classyedit .editor').html('');
        },
        success : function(resp){
            $("#loader"+reply_id).html('');
            var message     = "";
            var textarea    = "";
            //message += '<div class="form-group messagePrepend" ><h3 class="blue_color">'+resp.subject+'</h3>';
            message += '<div id="msg_div'+resp.message_id+'"><div class="input_icon" style="height: 50px;">';
            message += '<a href="javascript:void(0)" class="btn btn-info" style="font-size: 18px; font-weight: bold;">'+resp.from_bladge+'</a></div>';
            message += '<div class="col-xs-10 no-pad"><div class="col-xs-8"><p>'+resp.message+'</p></div>';
            message += '<div class="col-xs-2"><p>'+resp.created+'</p></div></div><div class="clearfix"></div></div>';
            
            if(reply_id == '0'){
                textarea += '<div class="form-group"><div class="col-xs-8 no-pad"><div class="input_icon blank_box"></div>';
                textarea += '<div class="col-xs-10 no-pad">';
                textarea += '<textarea placeholder="Write a message.." id="message'+resp.message_id+'" rows="3" class="form-control classy-editor"></textarea>';
                textarea += '<button class="btn btn-primary input_textbox save_message" style="float: right;" type="button" data-reply_id="'+resp.message_id+'">Send Message</button></div><div class="col-xs-1 msg_loader" id="loader'+resp.message_id+'"></div></div><div class="clearfix"></div></div>';

                var content = message+textarea;
                $('#blankMsgDiv').after(content);
                $('#subject').val('');
                $('#message0').val('');
            }else{
                $('#msg_div'+reply_id).after(message);
                //$('.messagePrepend:last').after(message);
                $('#message'+reply_id).val('');
            }
          //window.location.reload();
        }
      });
    }

    
});


  $("#open_msg_box").on("click", function(){
    //$('#hidd_reply_id').val('0');
    $('#subject').val('');
    $('#message').val('');

    //$('#reply_box').show();
    $('#msg_box').toggle();
  });

  $(".open_reply").on("click", function(){
    var reply_id = $(this).data('message_id');
    $('#hidd_reply_id').val(reply_id);
    $('#message').val('');
    $('#msg_box').hide();
    $('#reply_box').show();
  });

  $(".delete_message").on("click", function(){
    var message_id = $(this).data('message_id');
    $.ajax({
      type:'POST',
      dataType : 'json',
      url : '/ic/action-messages',
      data : { 'message_id' : message_id, 'action' : 'delete' },
      success : function(resp){
        window.location.reload();
      }
   });
 });
 
 



});//end document


function update_checklist(field_name, field_value, checklist_id)
{
  var service_id  = $("#service_id").val();
  var client_id   = $("#main_client_id").val();
  var tax_year    = $("#change_tax_year").val();

  $.ajax({
      type:'POST',
      dataType : 'json',
      url : '/ic/update-checklist',
      data : {'service_id':service_id, 'client_id':client_id, 'tax_year':tax_year, 'field_name':field_name, 'field_value':field_value, 'checklist_id':checklist_id},
      beforeSend : function(){
         
      },
      success : function(resp){
        
      }
  });
}

