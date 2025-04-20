$(document).ready(function(){

    $(".addcalarrow").click(function(event) {
      var task_id = $(this).data("task_id");
      $(".open_dropdown_"+task_id).toggle();
      event.stopPropagation();
    });

    $('.cont_radio').on('ifChecked', function(event){
      var value = $(this).val();
      var type = $(this).data('type');
      var client_id = $('#client_id').val();

      $.ajax({
        type: "POST",
        //dataType: 'json',
        url: "/renewals/get-contact-address",
        data: { 'type': type, 'value': value, 'client_id': client_id },
        success: function (resp) {
          if(value == 'none'){
            if(resp == ""){
              var content = '<a href="javascript:void(0)" data-billing_id="0" class="open_billing_form">Add..</a>';
            }else{
              var content = '<a href="javascript:void(0)" data-billing_id="1" class="open_billing_form">'+resp+'</a>';
            }
            $('#bill_address').html(content);
          }else{
            $('#bill_address').html(resp);
          }
        }
      });

    });

    // Open notes pop up in the crm renewals start //
    $(".notes-modal").click(function(){
        var renewal_id  = $(this).data('renewal_id');
        var action      = $(this).data('action');
        var added_from  = $(this).data('added_from');
        if(added_from == 'N'){
          $("#renewal_id").val(renewal_id);
          $("#action").val(action);
        }else{
          $("#log_renewal_id").val(renewal_id);
          $("#log_action").val(action);
        }
        
        if(action == 'add'){
          if(added_from == 'N'){
            $("#notes").val('');
            $("#notes-modal").modal("show");
          }else{
            $("#log_notes").val('');
            $("#calender_date").val('');
            $("#calender_time").val('');
            $("#logacall-modal").modal("show");
          }
        }else{
          $.ajax({
            type: "POST",
            dataType: 'json',
            url: "/renewals/get-renewals-details",
            data: { 'renewal_id': renewal_id },
            success: function (resp) {
              if(added_from == 'N'){
                $("#notes_title").val(resp['title']);
                $("#new_notes").val(resp['notes']);
                $("#notes-modal").modal("show"); 
              }else{
                $("#logacall_title").val(resp['title']);
                $("#log_notes").val(resp['notes']);
                $("#calender_date").val(resp['date']);
                $("#calender_time").val(resp['time']);
                $("#logacall-modal").modal("show");
              }
            }
          });
        }
    });
    // Open notes pop up in the crm renewals end //

    /* ################# Save Notes Start ################### */
    $(".save_notes").click(function(){
      var client_id     = $(this).data('client_id');
      var added_from    = $(this).data('added_from');

      if(added_from == 'N'){
        var date        = "";
        var time        = ""; 
        var title       = $("#notes_title").val();
        var notes       = $("#new_notes").val();
        var action      = $("#action").val();
        var renewal_id  = $("#renewal_id").val();
      }else{
        var title       = $("#logacall_title").val();
        var date        = $("#calender_date").val();
        var time        = $("#calender_time").val();
        var notes       = $("#log_notes").val();
        var action      = $("#log_action").val();
        var renewal_id  = $("#log_renewal_id").val();
      }

      $.ajax({
        type: "POST",
        url: "/renewals/save-notes",
        data: {'client_id':client_id, 'title':title, 'notes':notes, 'action':action, 'renewal_id':renewal_id, 'added_from':added_from, 'date':date, 'time':time },
        beforeSend: function() {
          $(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
        },
        success: function (resp) {
            window.location.reload();             
        }
      });
        
    });
    /* ################# Save Notes End ################### */

/* ################# Delete Notes Start ################### */
    $(".delete_renewal_notes").click(function(){
      var renewal_id    = $(this).data('renewal_id');
      if(!confirm("Do you want to delete the notes?")){
        return false;
      }
      $.ajax({
        type: "POST",
        url: "/renewals/delete-notes",
        data: { 'renewal_id':renewal_id },
        success: function (resp) {
            window.location.reload();             
        }
      });
        
    });
/* ################# Delete Notes End ################### */

/* ################# Open New Task pop up in the crm renewals start ################### */
  $(".newtask-modal").click(function(){
    var task_id     = $(this).data('task_id');
    var task_action = $(this).data('task_action');
    $("#task_id").val(task_id);
    $("#task_action").val(task_action);
    
    if(task_action == 'add'){
      $("#task_name").val('');
      $("#task_date").val('');
      $("#task_time").val('');
      $("#newtask-modal").modal("show");
    }else{
      $.ajax({
        type: "POST",
        dataType: 'json',
        url: "/renewals/get-task-details",
        data: { 'task_id': task_id },
        success: function (resp) {
          $("#task_name").val(resp['task_name']);
          $("#task_date").val(resp['task_date']);
          $("#task_time").val(resp['task_time']);
          $("#newtask-modal").modal("show");
        }
      });
    }
      
  });
/* ################# Open New Task pop up in the crm renewals end ################### */

/* ################# Save Notes Start ################### */
  $(".save_new_task").click(function(){
    var client_id     = $(this).data('client_id');
    var task_id       = $('#task_id').val();
    var task_date     = $("#task_date").val();
    var task_time     = $("#task_time").val();
    var task_name     = $("#task_name").val();
    var task_action   = $("#task_action").val();
    //alert(task_time);return false;
    $.ajax({
      type: "POST",
      url: "/renewals/save-tasks",
      data: {'client_id':client_id, 'task_id':task_id, 'task_date':task_date, 'task_time':task_time, 'task_name':task_name, 'task_action':task_action },
      beforeSend: function() {
        $(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
      },
      success: function (resp) {//return false;
          window.location.reload();             
      }
    });
      
  });
/* ################# Save Notes End ################### */

/* ################# Delete Notes Start ################### */
  $(".delete_tasks").click(function(){
    var task_id    = $(this).data('task_id');
    if(!confirm("Do you want to delete the task?")){
      return false;
    }
    $.ajax({
      type: "POST",
      url: "/renewals/delete-tasks",
      data: { 'task_id':task_id },
      success: function (resp) {
          window.location.reload();             
      }
    });
      
  });
/* ################# Delete Notes End ################### */

/* ################# Delete Opportunity Start ################### */
  $(".delete_opportunity").click(function(){
    var leads_id    = $(this).data('leads_id');
    var client_id    = $(this).data('client_id');
    if(!confirm("Do you want to delete the Opportunity?")){
      return false;
    }
    $.ajax({
      type: "POST",
      url: "/renewals/delete-opportunity",
      data: { 'leads_id':leads_id, 'client_id':client_id },
      success: function (resp) {
          window.location.reload();             
      }
    });
      
  });
/* ################# Delete Opportunity End ################### */

/* ################# Opportunity Notes Pop Up Start ################### */
  $(".opportunity_notes-modal").click(function(){
    var notes    = $(this).data('notes');
    $('#opp_notes_content').html('');
    $('#opp_notes_content').html(notes);
    $("#opportunity_notes-modal").modal("show");
  });
/* ################# Opportunity Notes Pop Up End ################### */

/* ################# +New Opportunity Pop Up Start ################### */
  $(".cd_opportunity-modal").click(function(){
    var client_id   = $("#client_id").val();
    var type        = $(this).data("type");
    var leads_id    = $(this).data("leads_id");
    var status_id   = $("#status_id").val();
    var lead_status = $(this).data("lead_status");
    $("#leads_id").val(leads_id);
    $("#type").val(type);

    if(type == "org"){
        $("#prospect_name_div").hide();
        $("#contact_name_div").show();
        $("#org_name_div").show();
        $("#org_cont_prsn").show();
      }else{
        $("#contact_name_div").hide();
        $("#org_name_div").hide();
        $("#prospect_name_div").show();
        $("#org_cont_prsn").hide();
      }
      $("#org_bsn_typ").hide();
      $("#industry_div").hide();
      $("#not_exists_div").hide();

      if(leads_id == '0'){
        put_client_details(client_id, type);
      }else{
        put_new_opportunity(leads_id, type);
        if(lead_status == '8'){
          get_field_disable(type);
        }else{
          get_field_enable(type);
        }
      }
      
    
    $("#open_form-modal").modal("show");
  });
/* ################# +New Opportunity Pop Up End ################### */

/* ################# Existing Client Start ################### */
  $("#existing_client").change(function(){
      var client_type = $("#type").val();
      var client_id = $(this).val();
      
      if(client_id != ''){
        put_client_details(client_id, client_type);
        $("#not_exists_div").hide();
        $("#industry_div").hide();

        if(client_type == 'org'){
          $("#org_bsn_typ").hide();
          $("#org_cont_prsn").show();
          
        }else{
          
        }
      }else{
        $("#org_bsn_typ").show();
        $("#org_cont_prsn").hide();
        $("#industry_div").show();
        $("#not_exists_div").show();

        get_blank_field();
      }
      
  });
/* ################# Existing Client End ################### */

/* ################# Select Contact Person Dropdown Start ################### */
  $(".contact_person").change(function(){
      var from          = $(this).data('from');
      var client_type   = $(this).data('type');
      var value  = $(this).val();
      var array = value.split('_');
      var client_id     = array[0];
      var address_type     = array[1];
      //alert(address_type+"=="+client_id);
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/renewals/get-contact-details',
        data: { 'client_id' : client_id, 'address_type' : address_type },
        success : function(resp){
          if(from == 'main'){
            $("#main_email").html(resp.email);
            $("#main_phone").html(resp.telephone);
          }else{
            if(client_type == 'org'){
              $("#contact_fname").val(resp.contact_fname);
              $("#contact_lname").val(resp.contact_lname);
            }else{

            }
            $("#phone").val(resp.telephone);
            $("#mobile").val(resp.mobile);
            $("#email").val(resp.email);
          }
          
        }
      });
      
  });
/* ################# Select Contact Person Dropdown End ################### */

//=============== Billing Address Start ============== //
  $(document).on('click', '.open_billing_form', function(){
      var client_type = $(this).data('client_type');
      var billing_id  = $(this).data('billing_id');
      var client_id   = $('#client_id').val();
      $("#billing_id").val(billing_id);

      if(billing_id == '0'){
        $("#billing-modal").modal("show");
      }else{
        $.ajax({
          type: "POST",
          url: '/renewals/ajax-billing-details',
          dataType:'json',
          data: { 'client_type':client_type, 'billing_id':billing_id, 'client_id':client_id },
          beforeSend : function(){
            $("#billing-modal").modal("show");
          },
          success : function(resp){//console.log(resp);return false;
            $('#bill_addr1').val(resp.address1);
            $('#bill_addr2').val(resp.address2);
            $('#bill_city').val(resp.city);
            $('#bill_county').val(resp.county);
            $('#bill_country').val(resp.country);
            $('#bill_postcode').val(resp.postcode);
            $('#billing_id').val(resp.billing_id);
          }
        });
      }
      
  });
//=============== Billing Address End ============== //


$(document).on('click', '.add_new_div', function(){
  var data_type = $(this).data('data_type');
  var acc_id    = $(this).data('acc_id');
  if(acc_id != "0"){
    var value = $(this).html();
    $('#'+data_type+'_txt').val(value);
  }
  $('#add_'+data_type+'_div').toggle();
  $('#'+data_type+'_div').toggle();
  //alert(data_type)
});

$(document).on('click', '.add_amount_div', function(){
  var data_type = $(this).data('data_type');
  var acc_id    = $(this).data('acc_id');
  if(acc_id != "0"){
    var value = $(this).html();
    $('#'+data_type+'_txt').val(value);
  }
  $('#add_'+data_type+'_div').toggle();
  $('#'+data_type+'_div').toggle();
  //alert(data_type)
});

$(document).on('click', '.add_startdate_div', function(){
  var data_type = $(this).data('data_type');
  var acc_id    = $(this).data('acc_id');
  if(acc_id != "0"){
    var value = $(this).html();
    $('#'+data_type+'_txt').val(value);
  }
  $('#add_'+data_type+'_div').toggle();
  $('#'+data_type+'_div').toggle();
  //alert(data_type)
});

$(document).on('click', '.save_acc_details', function(){
    var data_type = $(this).data('data_type');
    var text = $('#'+data_type+'_txt').val();
    save_acc_details(data_type, text);
});

$('.select_acc_details').change(function(){
    var data_type = $(this).data('data_type');
    var text      = $(this).val();
    save_acc_details(data_type, text);
});

$('.change_payment').change(function(){
  var text        = $(this).val();
  var data_type   = $(this).data('data_type');
  var client_id   = $(this).data('client_id');
  $.ajax({
    type: "POST",
    url: '/renewals/save-account-details',
    //dataType:'json',
    data: {'data_type':data_type, 'text':text, 'client_id':client_id },
    success : function(resp){
      
    }
  });
});

$('.delete_history').click(function(){
  var history_id  = $(this).data('history_id');
  if(!confirm('Do you want to delete permanently?')){
    return false;
  }
  $.ajax({
    type : 'POST',
    url : '/renewals/delete-renewal-history',
    data : { 'history_id' : history_id },
    success : function(resp){
      window.location.reload();
    }
  });

});

$(".lead_source-modal").click(function(){
    $("#lead_source-modal").modal("show");
});

$("#add_lead_source").click(function(){
    var source_name     = $("#new_source").val();
    var client_type     = $("#staff_client_type").val();
    
    $.ajax({
      type: "POST",
      url: '/crm/add-new-source',
      data: { 'source_name':source_name, 'client_type' : client_type },
      success : function(field_id){
        var append = '<div class="pop_list form-group" id="hide_div_'+field_id+'"><a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_source" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a>'+source_name+'</div>';
        $("#append_new_source").append(append);

        $("#new_source").val("");
        $("#lead_source").append('<option value="'+field_id+'">'+source_name+'</option>');

      }
    });
});

//Delete Lead Source end start //
$("#append_new_source").on("click", ".delete_source", function(){
  var field_id = $(this).data('field_id');
  if (confirm("Do you want to delete this field ?")) {
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/crm/delete-source-name',
      data: { 'field_id' : field_id },
      success : function(resp){
        if(resp != ""){
          $("#hide_div_"+field_id).hide();
          $("#lead_source option[value='"+field_id+"']").remove();
        }else{
          alert("There are some error to delete this type, Please try again");
        }
      }
    });
  }
  
}); 
//Delete Lead Source end //



});//end of main document ready 

function save_acc_details(data_type, text)
{
  var client_id   = $('#client_id').val();
  $.ajax({
    type: "POST",
    url: '/renewals/save-account-details',
    dataType:'json',
    data: {'data_type':data_type, 'text':text, 'client_id':client_id },
    success : function(resp){
      if(data_type == 'startdate'){
        $('#add_'+data_type+'_div a').html(resp.startdate);
        $('#ren_date_div').html(resp.enddate);
        $('#add_'+data_type+'_div').toggle();
        $('#'+data_type+'_div').toggle();
      }else{
        window.location.reload();
      }
    }
  });
}


function put_client_details(client_id, client_type)
{
  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/crm/get-client-address',
    data: { 'client_id' : client_id, 'client_type' : client_type },
    success : function(resp){
      if(client_type=="org"){
        $("#prospect_name").val(resp['address'].business_name);
        $("#contact_fname").val(resp['address'].contact_fname);
        $("#contact_lname").val(resp['address'].contact_lname);
      }else{
        $("#prospect_title").val(resp['address'].prospect_title);
        $("#prospect_fname").val(resp['address'].prospect_fname);
        $("#prospect_lname").val(resp['address'].prospect_lname);
      }
      $("#existing_client").val(client_id);
      $("#phone").val(resp['address'].telephone);
      $("#mobile").val(resp['address'].mobile);
      $("#email").val(resp['address'].email);
      $("#website").val(resp['address'].website);
      $("#street").val(resp['address'].address1);
      $("#city").val(resp['address'].city);
      $("#county").val(resp['address'].county);
      $("#postal_code").val(resp['address'].postcode);
      $("#country_id").val(resp['address'].country);
    }
  });
}

function get_blank_field()
{
  $('#deal_owner').val('');
  $('#business_type').val('');
  $('#prospect_name').val('');
  $('#contact_title').val('');
  $('#contact_fname').val('');
  $('#contact_lname').val('');
  $('#phone').val('');
  $('#mobile').val('');
  $('#email').val('');
  $('#quoted_value').val('');

  $('#lead_source').val('0');
  $('#industry').val('0');
  $('#annual_revenue').val('');
  $('#website').val('');
  $('#street').val('');
  $('#city').val('');
  $('#county').val('');
  $('#postal_code').val('');
  $('#country_id').val('');
  $('#notes').val('');
}

function put_new_opportunity(leads_id, type)
{
  $.ajax({
    type: "POST",
    url: '/crm/get-form-dropdown',
    dataType : 'json',
    data: { 'type' : type, 'leads_id' : leads_id },
    beforeSend : function(){
      $("#open_form-modal").modal("show");
    },
    success : function(resp){
      //==================Edit =================//
      $("#date").val(resp['leads_details'].date);
      $("#deal_certainty").val(resp['leads_details'].deal_certainty);
      $("#deal_owner").val(resp['leads_details'].deal_owner);
      $("#contact_person").val(resp['leads_details'].contact_person);

      if(type=="org"){
        $("#prospect_name").val(resp['leads_details'].prospect_name);
        $("#contact_title").val(resp['leads_details'].contact_title);
        $("#contact_fname").val(resp['leads_details'].contact_fname);
        $("#contact_lname").val(resp['leads_details'].contact_lname);
      }
      
      $("#phone").val(resp['leads_details'].phone);
      $("#mobile").val(resp['leads_details'].mobile);
      $("#email").val(resp['leads_details'].email);
      $("#quoted_value").val(resp['leads_details'].quoted_value);
      $("#lead_source").val(resp['leads_details'].lead_source);
      $("#notes").val(resp['leads_details'].notes);

    }
  });
}

function get_field_disable(type)
{
  $("#date").attr('disabled', 'disabled');
  $("#deal_certainty").attr('disabled', 'disabled');
  $("#deal_owner").attr('disabled', 'disabled');

  if(type == "org"){
    $("#prospect_name").attr('disabled', 'disabled');
    $("#contact_title").attr('disabled', 'disabled');
    $("#contact_fname").attr('disabled', 'disabled');
    $("#contact_lname").attr('disabled', 'disabled');
  }

  $("#contact_person").attr('disabled', 'disabled');
  $("#prospect_title").attr('disabled', 'disabled');
  $("#prospect_fname").attr('disabled', 'disabled');
  $("#prospect_lname").attr('disabled', 'disabled');

  $("#phone").attr('disabled', 'disabled');
  $("#mobile").attr('disabled', 'disabled');
  $("#email").attr('disabled', 'disabled');
  $("#quoted_value").attr('disabled', 'disabled');
  $("#lead_source").attr('disabled', 'disabled');
  $("#notes").attr('disabled', 'disabled');
  $("#save_oppor_button").attr('disabled', 'disabled');
}  

function get_field_enable(type)
{
  $("#date").prop("disabled", false);
  $("#deal_certainty").prop("disabled", false);
  $("#deal_owner").prop("disabled", false);

  if(type=="org"){
    $("#prospect_name").prop("disabled", false);
    $("#contact_title").prop("disabled", false);
    $("#contact_fname").prop("disabled", false);
    $("#contact_lname").prop("disabled", false);
  }

  $("#contact_person").prop("disabled", false);
  $("#prospect_title").prop("disabled", false);
  $("#prospect_fname").prop("disabled", false);
  $("#prospect_lname").prop("disabled", false);
  
  
  $("#phone").prop("disabled", false);
  $("#mobile").prop("disabled", false);
  $("#email").prop("disabled", false);
  $("#quoted_value").prop("disabled", false);
  $("#lead_source").prop("disabled", false);
  $("#notes").prop("disabled", false);
  $("#save_oppor_button").prop("disabled", false);
}