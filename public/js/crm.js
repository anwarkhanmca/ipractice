$(document).ready(function () {

  $('.CheckallCheckbox').on('ifChecked', function(event){
      $(".crm input[class='ads_Checkbox']").iCheck('check');
  });

  $('.CheckallCheckbox').on('ifUnchecked', function(event){
      $(".crm input[class='ads_Checkbox']").iCheck('uncheck');
  });

  $(".ads_Checkbox").on('ifChecked', function(event){
    $(".ads_Checkbox:checked").each( function (i) {
        if($(this).data("archive") == "Y"){
          $(".archivedButton").html('Un-Archive');
        }else{
          $(".archivedButton").html('Archive');
        }
    });
    
  });
  $(".ads_Checkbox").on('ifUnchecked', function(event){
    $(".ads_Checkbox:checked").each( function (i) {
        if($(this).data("archive") == "Y"){
          $(".archivedButton").html('Un-Archive');
        }else{
          $(".archivedButton").html('Archive');
        }
    });
    
  });

  $('body').on('click', '.allCheckSelect', function(){
    if($(this).is(':checked')){
      $('input:checkbox').prop("checked", true);
    }else{
      $('input:checkbox').prop("checked", false);
    }
  });

  $(document).click(function() {
      $(".open_toggle").hide();
      $(".open_lead_drop").hide();
  });
  $("#select_icon").click(function(event) {
      $(".open_toggle").toggle();
      event.stopPropagation();
  });

  $("#new_select_icon").click(function(event) {
      $(".open_toggle").toggle();
      event.stopPropagation();
  });

  $("#select_new_lead").click(function(event) {
      $(".open_toggle").toggle();
      event.stopPropagation();
  });
  $(".select_leads_list").click(function(event) {
    var leads_id = $(this).data('leads_id');
      $("#open_toggle_"+leads_id).toggle();
      event.stopPropagation();
  });

  $(".small_icon").click(function(event) {
      var id = $(this).data("id");
      var tab = $(this).data("tab");
      $("#status"+id+"_"+tab).toggle();
      event.stopPropagation();
  });

  $('body').on('click', ".open_form-modal", function(){
      var type      = $(this).data("type");
      var leads_id  = $(this).data("leads_id");
      var open_from = $(this).data("open_from");
      $("#client_type").val(type);
      //$(".is_exists").val('N');

      if(open_from == "CD"){
        var lead_status = $(this).data("lead_status");
        if(lead_status == '8'){
          get_field_disable();
        }else{
          get_field_enable();
        }
      }else{
        get_field_enable();
      }
      
      /*if(type == "org"){
        $("#prospect_name_div").hide();
        $("#contact_name_div").show();
        $("#org_name_div").show();

        $("#org_bsn_typ").show();
        $("#org_cont_prsn").hide();
        $("#industry_div").show();
        $("#not_exists_div").show();

      }else{
        $("#contact_name_div").hide();
        $("#org_name_div").hide();
        $("#prospect_name_div").show();

        $("#org_bsn_typ").hide();
        $("#org_cont_prsn").hide();
        $("#industry_div").show();
        $("#not_exists_div").show();
      }*/
      //openOpportunityPopUp(type, 'N');

      put_new_opportunity(leads_id, type);
  });

  $(".open_new_lead-modal").click(function(){
    var type      = $(this).data("type");
    var leads_id  = $(this).data("leads_id");
    
    $("#new_type").val(type);
    $("#new_leads_id").val(leads_id);
    if(type == "org"){
      $("#lead_name_div").hide();
      $("#lead_contact_name_div").show();
      $("#lead_org_name_div").show();
    }else{
      $("#lead_contact_name_div").hide();
      $("#lead_org_name_div").hide();
      $("#lead_name_div").show();
    }

    $.ajax({
      type: "POST",
      url: '/crm/get-form-dropdown',
      dataType : 'json',
      data: { 'type' : type, 'leads_id' : leads_id },
      success : function(resp){
        if(type == 'ind'){
          $("#new_prospect_title").val(resp['leads_details'].prospect_title);
          $("#new_prospect_fname").val(resp['leads_details'].prospect_fname);
          $("#new_prospect_lname").val(resp['leads_details'].prospect_lname);
        }else{
          if(typeof resp['leads_details'].business_type !== "undefined"){
            $("#new_business_type").val(resp['leads_details'].business_type);
          }else{
            $("#new_business_type").val('2');
          }
          $("#new_prospect_name").val(resp['leads_details'].prospect_name);
          $("#new_contact_title").val(resp['leads_details'].contact_title);
          $("#new_contact_fname").val(resp['leads_details'].contact_fname);
          $("#new_contact_lname").val(resp['leads_details'].contact_lname);
        }

        if(typeof resp['leads_details'].deal_owner !== "undefined"){
          $("#new_deal_owner").val(resp['leads_details'].deal_owner);
        }else{
          $("#new_deal_owner").val('');
        }
        if(typeof resp['leads_details'].lead_source !== "undefined"){
          $("#new_lead_source").val(resp['leads_details'].lead_source);
        }else{
          $("#new_lead_source").val('0');
        }
        if(typeof resp['leads_details'].industry !== "undefined"){
          $("#new_industry").val(resp['leads_details'].industry);
        }else{
          $("#new_industry").val('0');
        }
        $("#new_lead_date").val(resp['leads_details'].date);
        $("#new_phone").val(resp['leads_details'].phone);
        $("#new_mobile").val(resp['leads_details'].mobile);
        $("#new_email").val(resp['leads_details'].email);
        $("#new_website").val(resp['leads_details'].website);
        $("#new_notes").val(resp['leads_details'].notes);
        $("#res_address").val(resp['leads_details'].address_id);

        $("#open_new_lead-modal").modal("show");
      }
    });
  });

  $(".saveNewLeadOppor").click(function(){
    /*var saved_from  = $("#saved_from").val();
    if(saved_from == 'OPT'){alert(saved_from)
      var title  = $("#saveProspectsForm #contact_title").val();
      var fname  = $("#saveProspectsForm #contact_fname").val();
      var lname  = $("#saveProspectsForm #contact_lname").val();
    }else{
      var title  = $("#new_contact_title").val();
      var fname  = $("#new_contact_fname").val();
      var lname  = $("#new_contact_lname").val();
    }*/
    var new_type  = $("#new_type").val();
    var title     = $("#new_contact_title").val();
    var fname     = $("#new_contact_fname").val();
    var lname     = $("#new_contact_lname").val();
    
    if(title == '' && new_type == 'org'){
      alert('Please select contact title');
      $("#new_contact_title").focus();
      return false;
    }else if(fname == '' && new_type == 'org'){
      alert('Please enter contact first name');
      $("#new_contact_fname").focus();
      return false;
    }if(lname == '' && new_type == 'org'){
      alert('Please enter contact last name');
      $("#new_contact_lname").focus();
      return false;
    }else{
      $('#saveNewLeadOpporForm').submit();
    }
  });

// Save Business type while add organization client start //
$("#add_business_type").click(function(){
    var org_name      = $("#org_name").val();
    var client_type   = $(this).data("client_type");
    
    $.ajax({
      type: "POST",
      url: '/client/add-business-type',
      data: { 'org_name':org_name, 'client_type' : client_type },
      success : function(field_id){
        var append = '<div class="pop_list form-group" id="hide_div_'+field_id+'"><a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_org_name" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a>'+org_name+'</div>';
        $("#append_bussiness_type").append(append);

        $("#org_name").val("");
        $("#business_type").append('<option value="'+field_id+'">'+org_name+'</option>');

      }
    });
});
// Save Business type while add organization client end //

//Delete Business Type end start //
$("#append_bussiness_type").on("click", ".delete_org_name", function(){
  var field_id = $(this).data('field_id');
  if (confirm("Do you want to delete this field ?")) {
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/client/delete-org-name',
      data: { 'field_id' : field_id },
      success : function(resp){//console.log(resp);return false;
        if(resp != ""){
          //location.reload();
          $("#hide_div_"+field_id).hide();
          $("#business_type option[value='"+field_id+"']").remove();
        }else{
          alert("There are some error to delete this type, Please try again");
        }
      }
    });
  }
  
}); 
//Delete Business Type end //

$(".lead_source-modal").click(function(){
    $("#lead_source-modal").modal("show");
});

// Save Lead Source start //
$("#add_lead_source").click(function(){
    var source_name     = $("#new_source").val();
    var client_type      = $("#client_type").val();
    
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
// Save Lead Source end //

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

/* ================== Manage Tasks ================== */
  $(".lead_status-modal").click(function(){
    var is_show = $(this).data('is_show');
    if(is_show == 'L'){
      $(".is_show_O").hide();
    }else{
      $(".is_show_L").hide();
    }
    $(".is_show_"+is_show).show();
    $("#lead_status-modal").modal("show");
  });

  $("#lead_status-modal").on("click", ".edit_status", function(){
      var step_id = $(this).data("step_id");
      var status_name = $("#status_span"+step_id).html();
      var text_field = "<input type='text'  maxlength='13' id='status_name"+step_id+"' value='"+status_name+"' style='width:37%; height:30px'>";
      var action = "<a href='javascript:void(0)' class='save_new_status' data-step_id='"+step_id+"'>Save</a>&nbsp;&nbsp;<a href='javascript:void(0)' class='cancel_edit' data-step_id='"+step_id+"'>Cancel</a>";
      $("#status_span"+step_id).html(text_field);
      $("#action_"+step_id).html(action);
  });

  $("#lead_status-modal").on("click", ".cancel_edit", function(){
      var step_id = $(this).data("step_id");
      var status_name = $("#status_name"+step_id).val();
      var action = "<a href='javascript:void(0)' class='edit_status' data-step_id='"+step_id+"'><img src='/img/edit_icon.png'></a>";
      $("#status_span"+step_id).html(status_name);
      $("#action_"+step_id).html(action);
  });

  $("#lead_status-modal").on("click", ".save_new_status", function(){
      var step_id = $(this).data("step_id");
      var status_name = $("#status_name"+step_id).val();
      //alert(status_name+" "+step_id);
      $.ajax({
          type: "POST",
          url: "/crm/save-edit-status",
          //dataType: "json",
          data: { 'step_id': step_id, 'status_name' : status_name, 'type' : 'title' },
          beforeSend: function() {
              //$("#goto"+key).html('<img src="/img/spinner.gif" />');
          },
          success: function (resp) {
              if(resp != ""){
                  var action = "<a href='javascript:void(0)' class='edit_status' data-step_id='"+step_id+"'><img src='/img/edit_icon.png'></a>";
                  $("#status_span"+step_id).html(status_name);
                  $("#action_"+step_id).html(action);

                  $("#step_field_"+step_id).text(status_name);
                  $(".status_dropdown option[value='"+step_id+"']").html(status_name);

              }else{
                  alert("There are some problem to update status");
              }
              
          }
      });

  });

/* ################# Send to Task Management End ################### */

/* ################# View Notes Start ################### */
  $(".open_notes_popup").click(function(){
    var leads_id  = $(this).data("leads_id");
    var notes     = $("#notes_"+leads_id).val();
    $("#show_full_notes").html(notes);
    $("#full_notes-modal").modal("show");
  });
/* ################# View Notes End ################### */

/* ################# Delete Leads Details Start ################### */
$(".deleteLeads").click(function(){
    var val = [];
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();//alert(val[i]);
      }
    });
    //alert(val.length);return false;
    if(val.length>0){
      var page_open = $("#encode_page_open").val();
      var owner_id = $("#encode_owner_id").val();
      if(confirm("Do you want to delete??")){
        $.ajax({
            type: "POST",
            url: '/crm/delete-leads-details',
            data: { 'leads_delete_id' : val },
            success : function(resp){
              //window.location = '/crm/'+page_open+"/"+owner_id;
              window.location.reload();
            }
        });
      }

    }else{
      alert('Please select atleast one details');
    }
  });
  
  $('body').on('click', "#deleteSingleLeads", function(){
    var val = [];
    val[0] = $(this).data('leads_id');

    //alert(val.length);return false;
    if(confirm("Do you want to delete??")){
      $.ajax({
          type: "POST",
          url: '/crm/delete-leads-details',
          data: { 'leads_delete_id' : val },
          success : function(resp){
            $(".LeadsTr_"+val[0]).hide();
          }
      });
    }
  });
/* ################# Delete Leads Details End ################### */

/* ################# Status change Start ################### */
  $(".status_dropdown").change(function(){
    var tab_id    = $(this).val();
    var leads_id  = $(this).data('leads_id');
    var page_open = $("#encode_page_open").val();
    var owner_id  = $("#encode_owner_id").val();
    var close_date = $('#close_date_'+leads_id).val();

    if( (tab_id == 8 || tab_id == 9) && close_date == '0000-00-00'){
      $("#add_date_leads_id").val(leads_id);
      $("#add_date_tab_id").val(tab_id);
      $("#add_close_date-modal").modal("show");
      return false;
    }else{
      save_lead_status(tab_id, leads_id);
    }
  });
  $(".sendto_invoiced").click(function(){
      var tab_id = $(this).data('tab_id');
      var leads_id = $(this).data('leads_id');
      var page_open = $("#encode_page_open").val();
      var owner_id = $("#encode_owner_id").val();

      $.ajax({
          type: "POST",
          url: '/crm/sendto-another-tab',
          data: { 'tab_id' : tab_id, 'leads_id' : leads_id },
          beforeSend : function(){
            $(".select_toggle").hide();
          },
          success : function(resp){
            window.location = '/crm/'+page_open+"/"+owner_id;
          }
      });
  });

  $(".save_close_date").click(function(){
      var tab_id      = $("#add_date_tab_id").val();
      var leads_id    = $("#add_date_leads_id").val();
      var close_date  = $("#add_close_date").val();
      $.ajax({
          type: "POST",
          url: '/crm/save-close-date',
          data: { 'close_date' : close_date, 'leads_id' : leads_id },
          beforeSend : function(){
            $(".show_loader").html('<img src="/img/spinner.gif" />');
          },
          success : function(resp){
            save_lead_status(tab_id, leads_id);
          }
      });
  });

  
/* ################# Status change End ################### */

/* ################# Existing Client Start ################### */
  /*$("#existing_client").change(function(){
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
      }
      
  });*/

  $("#existing_client").change(function(){
    $("#contactNameHid").val('');
    yesContactName();
  });

  $(".is_exists").change(function(){
    var is_exists   = $(this).val();

    openOpportunityPopUp(is_exists);
    //hideDisplayContactName();
      
  });
/* ################# Existing Client End ################### */

/* ################# Graphs Modal Start #################### */
  $(".graphs-modal").click(function(){
    $("#show_graph").html('');
    $("#show_graph_loader").html('');
    $("#from_date").val('');
    $("#to_date").val('');
    $("#graphs-modal").modal("show");
  });

  $("#show_graph_button").click(function(){
    var month = $("#month").val();
    var year = $("#year").val();
    var compare = $("#compare").val();

    $.ajax({
          type: "POST",
          url: '/crm/show-graph',
          data: { 'month' : month, 'year' : year, 'compare' : compare },
          beforeSend: function() {
            $("#show_graph").html('');
            $("#show_graph_loader").html('<img src="/img/spinner.gif" />');
          },
          success : function(resp){
            $("#show_graph_loader").html('');
            $("#show_graph").html(resp);
          }
      });
      
  });

/* ################# Graphs Modal Start #################### */

//Show Archived in add individual client
  $(".archive_div").click(function(){
    var page_open = $("#encode_page_open").val();
    var owner_id = $("#encode_owner_id").val();

    var tab_id = $(this).data('tab_id');
    var html = $(this).html();
    if($.trim(html) == 'Show Archived'){
      var is_archive = 'N';
    }else{
      var is_archive  = 'Y';
    }
    $.ajax({
      type: "POST",
      url: '/crm/show-archive-leads',
      data: { 'is_archive' : is_archive, 'tab_id' : tab_id },
      success : function(resp){
        //window.location = '/crm/'+page_open+"/"+owner_id;
        window.location.reload();
      }
    });
  });

// Archive and Un-Archive client start //
  $('body').on('click', '.archivedButton', function(){
    var page_open = $("#encode_page_open").val();
    var owner_id = $("#encode_owner_id").val();
    var tab_id = $(this).data('tab_id');

    var val = [];
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    if(val.length>0){
      var status = $.trim($(this).html());
      if(confirm("Do you want to "+status+" the items?")){
        $.ajax({
            type: "POST",
            url: '/crm/archive-leads',
            data: { 'leads_ids' : val, 'status' : status, 'tab_id' : tab_id },
            success : function(resp){
              //window.location = '/crm/'+page_open+"/"+owner_id;
              window.location.reload();
            }
        });
      }
    }else{
      alert('Please select atleast one item');
    }
  
  });
// Archive and Un-Archive client start //

  $('body').on('click', '#display', function(){
    //var page_open = $("#encode_page_open").val();
    //var owner_id = $("#encode_owner_id").val();
    var status_id   = $("#status_id").val();
    var user_id     = $("#user_id").val();
    var date_from   = $("#date_from").val();
    var date_to     = $("#date_to").val();

    if($("#is_deleted").is(':checked')){
      var is_deleted  = 'Y';
    }else{
      var is_deleted  = 'N';
    }
    if($("#is_archive").is(':checked')){
      var is_archive  = 'Y';
    }else{
      var is_archive  = 'N';
    }

    if(status_id == ""){
      alert("Please select The status");
      $("#status_id").focus();
      return false;
    }
    if(date_from == ""){
      alert("Please select Date form field");
      $("#date_from").focus();
      return false;
    }
    if(date_to == ""){
      alert("Please select Date to field");
      $("#date_to").focus();
      return false;
    }

    $.ajax({
      type: "POST",
      url: '/crm/show-leads-report',
      //dataType:'json',
      data: { 'status_id' : status_id, 'user_id' : user_id, 'is_deleted' : is_deleted, 'is_archive' : is_archive, 'date_from' : date_from, 'date_to' : date_to },
      beforeSend: function() {
        $("#display_result").html('');
        $("#display_result").html('<div style="text-align:center;"><img src="/img/spinner.gif" /></div>');
      },
      success : function(resp){//return false;
        $("#display_result").html(resp);
      }
    });
  });

//===============Client Onboarding Start ============== //
  $('body').on('click', '.sendto_client_list', function(){
      var client_type = $(this).data('client_type');
      var leads_id = $(this).data('leads_id');
      if(!confirm('Client details will be added to the Client list and the On-boarding pages')){
        return false;
      }
      //$("#onboard_td_"+leads_id).html('<img src="/img/spinner.gif" height="25" />');return false;
      $.ajax({
        type: "POST",
        url: '/crm/sendto-client-list',
        //dataType:'json',
        data: { 'client_type' : client_type, 'leads_id' : leads_id },
        beforeSend: function() {
          //$("#display_result").html('');
          $("#onboard_td_"+leads_id).html('<img src="/img/spinner.gif" height="25" />');
        },
        success : function(resp){//console.log(resp);return false;
          var start = '<a href="javascript:void(0)" class="send_btn sendto_client_list" data-leads_id="'+leads_id+'" data-client_type="'+client_type+'">START</a>';
          if(resp == 'spell_check'){
            $("#onboard_td_"+leads_id).html(start);
            alert("Please check the company name spelling");
          }else if(resp >0){
            window.location.reload();
          }else{
            $("#onboard_td_"+leads_id).html(start);
            alert("There are some error, Please try again.");
          }
          
        }
      });
  });
//===============Client Onboarding End ============== //

//=============== Change Payment Method Start ============== //
$('body').on('click', '.change_payment', function(){
  var text        = $(this).val();
  var data_type   = $(this).data('data_type');
  var client_id   = $(this).data('client_id');
  var page_open   = $('#page_open').val();
  $.ajax({
    type: "POST",
    url: '/renewals/save-account-details',
    //dataType:'json',
    data: {'data_type':data_type, 'page_open':page_open, 'text':text, 'client_id':client_id },
    success : function(resp){
      
    }
  });
});
//=============== Change Payment Method End ============== //  

//=============== Start Date Pop Up Start ============== //
$('body').on('click', '.open_startdate_pop', function(){
  var startdate   = $(this).html();
  if($.trim(startdate) == 'Add..'){
    $("#pop_startdate").val('');
  }else{
    $("#pop_startdate").val($.trim(startdate));
  }
  var client_id   = $(this).data('client_id');
  $("#startdate_client_id").val(client_id);

  $("#startdate_pop-modal").modal("show");
});

$('body').on('click', '#save_startdate', function(){
  var text        = $('#pop_startdate').val();
  var client_id   = $('#startdate_client_id').val();
  var data_type   = $('#start_data_type').val();

  save_acc_details(data_type, text, client_id)
});
//=============== Start Date Pop Up End ============== //

//=============== Annual Fee Pop Up Start ============== //
$('body').on('click', '.open_amount_pop', function(){
  var amount      = $(this).html();
  var client_id   = $(this).data('client_id');
  if($.trim(amount) == 'Add..'){
    $("#pop_amount").val('');
  }else{
    $("#pop_amount").val($.trim(amount));
  }
  $("#amount_client_id").val(client_id);
  $("#amount_pop-modal").modal("show");
});

$('body').on('click', '#save_amount', function(){
  var text        = $('#pop_amount').val();
  var client_id   = $('#amount_client_id').val();
  var data_type   = $('#amount_data_type').val();

  save_acc_details(data_type, text, client_id)
});
//=============== Annual Fee Pop Up End ============== // 

//=============== Annual Fee Pop Up Start ============== //
$('body').on('click', '.open_joining_pop', function(){
  var joining     = $(this).attr('data-joining');
  var client_id   = $(this).data('client_id');
  var table       = $(this).data('table');
  $("#pop_joining").val(joining);
  $("#joining_client_id").val(client_id);
  $("#joining_table").val(table);

  $("#joining_pop-modal").modal("show");
});

$('body').on('click', '#save_joining', function(){
  var text        = $('#pop_joining').val();
  var client_id   = $('#joining_client_id').val();
  var data_type   = $('#joining_data_type').val();
  var table       = $('#joining_table').val();
  if(table == 'crm'){
    save_acc_details(data_type, text, client_id);
  }else{
    save_client_details('created', text, client_id);
  }
  
});
//=============== Annual Fee Pop Up End ============== // 

/* ################# Send to Manage Contract Renewals Start ################### */
  $('body').on('click', '.send_renewals', function(){
    var client_id   = $(this).data("client_id");
    var proposal_id = $('#recurringDropdown_'+client_id).val();
    var from_page   = $(this).attr('data-from_page');
    //alert(proposal_id);return false;
    $.ajax({
        type: "POST",
        url: "/renewals/send-manage-task",
        dataType:"json",
        data: { 'client_id': client_id, 'proposal_id': proposal_id, 'from_page':from_page },
        beforeSend: function() {
          $("#message_div").html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
        },
        success: function (resp) {
          var data = resp.crm_details;
          $("#message_div").html('');
          $("#OrgTableContainer #after_send_"+client_id).html('<button type="button" class="job_sent_btn send_renewals" data-client_id="'+client_id+'" data-from_page="prop_client_org"><i class="fa fa-refresh"></i> Renewed</button>');              
          if(proposal_id > 0){
            window.location.href = '/proposal/edit-proposal/'+resp.crm_proposal_id+'/'+from_page;
          }else{
            $('.startdate_outer_'+client_id).html('<a href="javascript:void(0)" class="open_startdate_pop startdate_'+client_id+'" data-startdate="'+data.startdate+'" data-client_id="'+client_id+'">'+data.startdate+'</a>');
            $('.enddate_'+client_id).html(data.enddate);
            $('.countdown_'+client_id).html(data.count_down);
          }
        }
    });
      
  });
/* ################# Send to Manage Contract Renewals End ################### */

/* ################# Status Change Start ################### */
  $("#status-modal").on("click", ".edit_status", function(){
    var renewal_status_id = $(this).data("renewal_status_id");
    var status_name = $("#status_span"+renewal_status_id).html();
    var text_field = "<input type='text' id='status_name"+renewal_status_id+"' value='"+status_name+"' style='width:100%; height:30px'>";
    var action = "<a href='javascript:void(0)' class='save_new_status' data-renewal_status_id='"+renewal_status_id+"'>Save</a>&nbsp;&nbsp;<a href='javascript:void(0)' class='cancel_edit' data-renewal_status_id='"+renewal_status_id+"'>Cancel</a>";
    $("#status_span"+renewal_status_id).html(text_field);
    $("#action_"+renewal_status_id).html(action);
  });

  $("#status-modal").on("click", ".cancel_edit", function(){
    var renewal_status_id = $(this).data("renewal_status_id");
    var status_name = $("#status_name"+renewal_status_id).val();
    var action = "<a href='javascript:void(0)' class='edit_status' data-renewal_status_id='"+renewal_status_id+"'><img src='/img/edit_icon.png'></a>";
    $("#status_span"+renewal_status_id).html(status_name);
    $("#action_"+renewal_status_id).html(action);
  });

  $("#status-modal").on("click", ".save_new_status", function(){
    var renewal_status_id = $(this).data("renewal_status_id");
    var status_name = $("#status_name"+renewal_status_id).val();
    $.ajax({
      type: "POST",
      url: "/crm/ajax-save-status",
      //dataType: "json",
      data: { 'renewal_status_id': renewal_status_id, 'status_name' : status_name, 'type' : "title" },
      beforeSend: function() {
          //$("#goto"+key).html('<img src="/img/spinner.gif" />');
      },
      success: function (resp) {
        if(resp != ""){
          var action = "<a href='javascript:void(0)' class='edit_status' data-renewal_status_id='"+renewal_status_id+"'><img src='/img/edit_icon.png'></a>";
          $("#status_span"+renewal_status_id).html(status_name);
          $("#action_"+renewal_status_id).html(action);

          $("#step_field_"+renewal_status_id).text(status_name);
          $(".change_renewal_status option[value='"+renewal_status_id+"']").html(status_name);

        }else{
          alert("There are some problem to update status");
        }
      }
    });
  });

  $('#status-modal .status_check').on('ifChecked', function(event){
    var renewal_status_id = $(this).data("renewal_status_id");
    //alert(renewal_status_id);return false;
    if(renewal_status_id != ""){
      $.ajax({
        type: "POST",
        url: "/crm/ajax-save-status",
        data: { 'renewal_status_id': renewal_status_id, 'type' : "status" },
        success: function (resp) {
          $(".change_renewal_status option[value='"+renewal_status_id+"']").show();    
          $(".header_step_"+renewal_status_id).show();           
        }
      });
    }
  });

  $('#status-modal .status_check').on('ifUnchecked', function(event){
    var renewal_status_id = $(this).data("renewal_status_id");
    //alert(renewal_status_id);return false;
    if(renewal_status_id != ""){
      $.ajax({
        type: "POST",
        url: "/crm/ajax-save-status",
        data: { 'renewal_status_id': renewal_status_id, 'type' : "status" },
        success: function (resp) {
          $(".change_renewal_status option[value='"+renewal_status_id+"']").hide();   
          $(".header_step_"+renewal_status_id).hide();              
        }
      });
    }
  });

  $('.change_renewal_status').change(function(){
    var client_id         = $(this).data('client_id');
    var renewal_status_id = $(this).val();

    if(renewal_status_id == 7 && confirm("Do you want to rollforward the clients contract?")){
      copyto_Contract_renewal_history(client_id, renewal_status_id);
    }
    change_renewal_status(client_id, renewal_status_id);
 
  });
/* ################# Status Change End ################### */

/* ################# Delete Archived Client Start ################### */
$('.delete_archived').click(function(){
    var archive_id  = $(this).data('archive_id');
    if(!confirm('Do you want to delete permanently?')){
      return false;
    }
    $.ajax({
      type : 'POST',
      url : '/crm/delete-archived-client',
      data : { 'archive_id' : archive_id },
      success : function(resp){
        window.location.reload();
      }
    });
 
  });
/* ################# Delete Archived Client End ################### */

/* ################# Change Invoiced Start ################### */
$('.change_invoiced').change(function(){
    var client_id    = $(this).data('client_id');
    var text         = $(this).val();
    save_acc_details('is_invoiced', text, client_id)
 
  });
/* ################# Change Invoiced Start ################### */

/* ################# Change Invoiced Start ################### */
$('.roll_fwd_button').click(function(){
    var client_id    = $(this).data('client_id');
    $('#fwd_client_id').val(client_id);
    var startdate = $('.startdate_'+client_id).html();
    var enddate   = $('.enddate_'+client_id).html();
    var countdown   = $('.countdown_'+client_id).html();

    if($.trim(startdate) == 'Add..'){
      alert('There are no existing contracts');
      return false;
    }else if(countdown > 180){
      alert('Contract renewal not due yet');
      return false;
    }else{
      $.ajax({
        type: "POST",
        url: '/renewals/get-date-format',
        dataType:'json',
        data: {'startdate':startdate, 'enddate':enddate, 'client_id' : client_id },
        success : function(resp){
          $('#pop_fwd_date').val(resp.startdate);
          $('#pop_fwd_end').val(resp.enddate);
          $('#roll_amount').val(resp.billing_amount);
        }
      });
      $('#roll_fwd-modal').modal('show');
    }
});
$('#save_fwddate').click(function(){
  var client_id    = $('#fwd_client_id').val();
  var text         = $('#pop_fwd_date').val();
  var enddate      = $('#pop_fwd_end').val();
  var data_type    = $('#fwd_data_type').val();
  var roll_amount  = $('#roll_amount').val();
  var client_type = $("#client_type").val();
  var page_open   = $('#page_open').val();

  $.ajax({
    type: "POST",
    url: '/renewals/save-account-details',
    dataType:'json',
    beforeSend : function(){
      $(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
    },
    data: {'data_type':data_type, 'page_open':page_open, 'text':text, 'client_id':client_id, 'client_type':client_type, 'enddate':enddate, 'roll_amount':roll_amount },
    success : function(resp){
      $(".loader_class").html('');

      $('.startdate_'+client_id).html(resp.startdate);
      $('.startdate_'+client_id).attr( "data-startdate", resp.startdate );
      $('.enddate_'+client_id).html(resp.enddate);
      $('.countdown_'+client_id).html(resp.count_down);

      $('.billing_amount_'+client_id).html(resp.billing_amount);
      $('.billing_amount_'+client_id).attr( "data-amount", resp.billing_amount );
      $('.monthly_amount_'+client_id).html( resp.monthly_amount );

      //header value change//
      $('#ann_amnt_head').html( resp.ann_amnt );
      $('#ann_avg_head').html( resp.ann_avg );
      $('#mnth_amnt_head').html( resp.mon_amnt );
      $('#mnth_avg_head').html( resp.mon_avg );

      $('#roll_fwd-modal').modal('hide');
    }
  });
});
/* ################# Change Invoiced Start ################### */

/* ################# Global Task Management Start ################### */
$('#manage_check').click(function(event){
  var dead_line = $("#dead_line").val();
  var page_open = $("#page_open").val();

  if(dead_line == ""){
      alert("Please Put The Days Before Deadline value");
      return false;
  }else{
    $.ajax({
      type: "POST",
      dataType : 'json',
      url: "/renewals/send-global-task",
      data: { 'dead_line' : dead_line, 'page_open' : page_open },
      beforeSend : function(){
          $(".loader_show").html('<img src="/img/spinner.gif" />');
      },
      success : function(resp){ 
          $.each(resp, function(key, value){
              $("#after_send_"+value.client_id).html('<button type="button" class="job_sent_btn">SENT</button>');
          });
          $("#auto_send-modal").modal("hide");
          $(".loader_show").html('');
      }
    });
  }
});
/* ################# Global Task Management End ################### */

/* ################# Delete Single Task Management Start ################### */
  $(".delete_crm_task").click(function(){
    var client_id   = $(this).data('client_id');
    var tab         = $(this).data('tab');
    var page_open   = $("#page_open").val();
    var prev_status = $("#prev_status_"+client_id).val();
    var status_id   = $("#"+page_open+"_prev_status_"+client_id).val();

    //if(confirm("Do you want to Delete the task?")){
      $.ajax({
        type: "POST",
        url: '/renewals/delete-single-task',
        data: { 'client_id' : client_id, 'tab' : tab },
        success : function(resp){
          var count_1 = $("#task_count_1").html();
          $("#task_count_1").html(parseInt(count_1-1));

          var count_del = $("#task_count_"+status_id).html();
          $("#task_count_"+status_id).html(parseInt(count_del-1));
          $(".data_tr_"+client_id+"_"+page_open).hide(); 
        }
      });
    //}
  });
/* ################# Delete Single Task Management End ################### */

/* ################# SYNC from xero start ################### */
  $('body').on('click', '.amount_mdd', function(){
    var id          = $(this).data('id');
    var contact_id  = $(this).data('contact_id');
    //alert(contact_id)
    $.ajax({
      type : 'POST',
      url : '/crm/invoice-by-contactid',
      dataType:'json',
      data : { 'id' : id, 'contact_id' : contact_id },
      beforeSend : function(){
        $('#pop_contact_id').val('');
        $('#invoice_popup tr:not(:first)').remove();
        $('.xero_title strong').html('');
        $('#amount_mdd-modal').modal('show');
        //$('#invoice_popup tr:last').html('<tr><tdcolspan="11" style="text-align:center;"><img src="/img/spinner.gif" /></td></tr>');
      },
      success : function(resp){//return false;
        $('.xero_title strong').html(resp.name);
        if(resp.check_box == 1){
          $('.autosend_invoice_check').iCheck('check');
        }else{
          $('.autosend_invoice_check').iCheck('uncheck');
        }
        $('#pop_contact_id').val(contact_id);

        var value = "";
        $.each(resp.details, function(i, val){//alert(resp[i].InvoiceNumber)
          value +='<tr class="xero_pop_'+resp.details[i].crm_invoice_id+'"><td align="center">'+resp.details[i].InvoiceNumber+'</td>';
          value +='<td align="center" style="height:33px">'+resp.details[i].Date+'</td>';
          value +='<td align="left">'+resp.details[i].Reference+'</td>';
          value +='<td align="center">'+resp.details[i].DueDate+'</td>';
          value +='<td align="right">'+resp.details[i].Total+'</td>';
          value +='<td align="right">'+resp.details[i].AmountPaid+'</td>';
          value +='<td align="right">'+resp.details[i].AmountCredited+'</td>';
          value +='<td align="right" class="xero_due_'+resp.details[i].crm_invoice_id+'">'+resp.details[i].AmountDue+'</td>';
          if(resp.details[i].is_send == 'Y'){
            value +='<td align="center"><button type="button" class="job_sent_btn">SENT</button></td>';
          }else{
            value +='<td align="center" class="xero_send_'+resp.details[i].crm_invoice_id+'"><button type="button" class="job_send_btn crm_send_collect" data-inv_no="'+resp.details[i].InvoiceNumber+'" data-invoice_id="'+resp.details[i].crm_invoice_id+'" data-status="open">SEND</button></td>';
          }
          //value +='<td align="center"><input type="text" class="form-control" id="collected_'+resp.details[i].crm_invoice_id+'" value="'+resp.details[i].ToBeCollected+'" name="collected_'+resp.details[i].crm_invoice_id+'" style="width:90px"></td>';
          //value +='<td align="center"><input type="text" class="form-control collection_date" value="'+resp.details[i].collection_date+'" name="collection_date_'+resp.details[i].crm_invoice_id+'"></td>';
          //value +='<td align="center"><p class="custom_chk"><input type="checkbox" class="xero_check_pop" data-invoice_id="'+resp.details[i].crm_invoice_id+'" value="'+resp.details[i].ToBeCollected+'" id="j_'+resp.details[i].crm_invoice_id+'"/><label style="width:0px!important;" for="j_'+resp.details[i].crm_invoice_id+'"></label></p></td>';
          value += '</tr>';
        });
        value +='<tr><th colspan="4" style="text-align:right;">TOTAL</th>';
        value +='<th style="text-align:right;">'+resp.total+'</th>';
        value +='<th style="text-align:right;">'+resp.paid+'</th>';
        value +='<th style="text-align:right;">'+resp.credited+'</th>';
        value +='<th style="text-align:right;">'+resp.due+'</th>';
        //value +='<th style="text-align:right;" class="total_collect">'+resp.tobecollect+'</th>';
        value +='<th></th>';
        value += '</tr>';
        $('#invoice_popup tr:last').after(value);
        //$('#invoice_popup tbody').html(value);
      }
    });
    
  });

  $('body').on('click', '.crm_send_collect', function(){
    var invoice_id    = $(this).data('invoice_id');
    var status        = $(this).data('status');
    var collect_date  = $('#tobecollect_date').val();
    var amount        = $('#tobecollect_amount').val();
    if(status == 'send'){
      invoice_id = $("#invoice_id").val();
    }

    $.ajax({
      type : 'POST',
      url : '/crm/send-to-collect',
      dataType : 'json',
      data : {'invoice_id':invoice_id, 'status':status, 'collect_date':collect_date, 'amount':amount},
      beforeSend : function(){
        $(".show_loader").html('');
        if(status == 'open'){
          $("#invoice_id").val(invoice_id);
          $("#tobecollect_date").val('');
          $('#tobe_collected-modal').modal('show');
        }else{
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        }
      },
      success : function(resp){
        $('#tobecollect_amount').val(resp.details.AmountDue);

        if(status == 'send'){
          $(".show_loader").html('');
          $(".xero_send_"+invoice_id).html('<a class="job_sent_btn">SENT</a>');
          $('#tobe_collected-modal').modal('hide');
        }
      }
    });
    
  });


  $('.autosend_invoice_check').on('ifChecked', function(e){
    
    //var click_element = e.target;
    var contact_id = $('#pop_contact_id').val();
    if(contact_id != ""){
      $.ajax({
        type : 'POST',
        url : '/crm/send-to-collect',
        dataType : 'json',
        data : {'contact_id':contact_id, 'status':'multiple'},
        success : function(resp){
          $.each(resp.details, function(index, value){
            var invoice_id = resp.details[index].crm_invoice_id;
            $(".xero_due_"+invoice_id).html(resp.details[index].AmountDue);
            $(".xero_send_"+invoice_id).html('<a class="job_sent_btn">SENT</a>');
          });
        }
      });
    }
  });

  $('.autosend_invoice_check').on('ifUnchecked', function(e){
    //var click_element = e.target;
    var contact_id = $('#pop_contact_id').val();
    if(contact_id != ""){
      $.ajax({
        type : 'POST',
        url : '/crm/send-to-collect',
        dataType : 'json',
        data : {'contact_id':contact_id, 'status':'uncheck'},
        success : function(resp){
          
        }
      });
    }
  });

  $('.delete_invoice').click(function(e){
    var invoice_id    = $(this).data('invoice_id');
    var invoice_no    = $(this).data('invoice_no');
    var click_element = e.target;

    $.ajax({
      type : 'POST',
      url : '/crm/delete-invoice',
      dataType : 'json',
      data : {'invoice_id':invoice_id, 'invoice_no':invoice_no},
      success : function(resp){
        $(click_element).closest("tr").hide();
      }
    });
  });

  $('body').on('focus', '.collection_date', function(){
    $(this).datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
  });

  $('#amount_mdd-modal').on('click', '.xero_check_pop', function(){
    var invoice_id  = $(this).data('invoice_id');
    var total_collect  = $('.total_collect').text();
    
    if($(this).is(':checked')){
      var dueprice  = $('.xero_due_'+invoice_id).text();
      var remain_collect = parseFloat(total_collect) + parseFloat(dueprice);
    }else{
      var dueprice    = 0;
      var minus_price = $('#collected_'+invoice_id).val();
      var remain_collect = parseFloat(total_collect) - parseFloat(minus_price);
    }
    $('#collected_'+invoice_id).val(dueprice);
    $('.total_collect').text(remain_collect.toFixed(2));
    
  });
  
  /*$(".save_invoice").click(function(){
    var contact_id  = $('#pop_contact_id').val();
    var arrText= new Array();
    $('#invoice_popup input[type=text]').each(function(){
        arrText.push($(this).val());
    })
    console.log(arrText)
  });*/

  $(".open_edit_pop").click(function(){
    var invoice_id    = $(this).data('id');
    var contact_id    = $(this).data('contact_id');
    var client_id     = $(this).data('client_id');
    var client_type   = $(this).data('client_type');

    $.ajax({
      type : 'POST',
      url : '/client/all-org-clients',
      dataType:'json',
      data : {'invoice_id':invoice_id, 'contact_id':contact_id, 'client_type':client_type, 'client_id':client_id },
      beforeSend : function(){
        $('#edit_contact_id').val(contact_id);
        $('#edit_id').val(invoice_id);
        $('#edit_client_id').val(client_id);
        $('#edit_client_type').val(client_type);
        $('.inv_client').html('');
        $('.client_area').html('<div style="text-align:center;"><img src="/img/spinner.gif" /></div>');
      },
      success : function(resp){
        $('.client_area').html('');
        $('.inv_client').html(resp.inv_client);
        var value = '';
        if(client_type == 'xero'){
          value += '<label>Merge with existing client</label><select class="form-control exist_clients"><option value="">-- NONE --</option>';
          $.each(resp.clients, function(i, val){//alert(resp[i].InvoiceNumber)
            value +='<option value="'+resp.clients[i].client_id+'">'+resp.clients[i].client_name+'</option>';
          });
          value +='</select>';
        }else{
          if(resp.invoices['Name'] !== undefined){
            value += '<label>Imported client</label>';
            value += resp.invoices.Name+' <a href="javascript:void(0)" title="Delete Field ?" class="merge_invoice" data-contact_id="'+resp.invoices.ContactID+'"><img src="/img/cross.png" width="12"></a>';
            $('#edit_contact_id').val(resp.invoices.ContactID);
            $('#edit_id').val(resp.invoices.crm_invoice_id);
          }
        }
        $('.client_area').html(value);
      }
    });

    $('#open_edit_pop-modal').modal('show');
  });

  $("body").on('click', '.merge_invoice', function(){
    var invoice_id    = $('#edit_id').val();
    var contact_id    = $('#edit_contact_id').val();
    var client_id     = $('#edit_client_id').val();
    var client_type   = $('#edit_client_type').val();
    var org_client_id = $('.exist_clients').val();

    $.ajax({
      type : 'POST',
      url : '/crm/merge-xero-clients',
      dataType:'json',
      data : {'org_client_id':org_client_id, 'invoice_id':invoice_id, 'contact_id':contact_id, 'client_type':client_type, 'client_id':client_id },
      beforeSend : function(){
        $('.show_loader').html('<img src="/img/spinner.gif" />');
      },
      success : function(resp){
        $('.show_loader').html('');
        if(client_type == 'xero'){
          $('.inv_tr_'+invoice_id).hide();
          var anc = '<a href="javascript:void(0)" class="amount_mdd" data-contact_id="'+contact_id+'" data-type="org">'+resp.AmountDue+'</a>';
          $('.inv_tr_'+org_client_id+' td:nth-child(6)').html(anc);
          $('.inv_tr_'+org_client_id+' td:nth-child(7)').text(resp.ToBeCollected);
          //$('.inv_tr_'+org_client_id+' td:nth-child(9)').html('<a href="javascript:void(0)" class="notes_btn autocollect_pop" data-client_type="org" data-client_id="'+org_client_id+'">Action</a>');
        }else{
          $('.inv_tr_'+invoice_id).css("display","block");
          $('.client_area').html('');
        }
        $('#open_edit_pop-modal').modal('hide');
      }
    });
  });

/* ################# SYNC from xero End ################### */

/* ################# Show Contact Name/Email Start ################### */
  $('.select_acc_details').change(function(){
    var client_type = $(this).data('client_type');
    var client_id   = $(this).data('client_id');
    var value       = $(this).val();
    if(value != ""){
      $.ajax({
        type : 'POST',
        url : '/crm/address-by-client-type',
        dataType:'json',
        data : {'client_id':client_id, 'value':value },
        success : function(resp){
          $(".inv_tr_"+client_id+" td:nth-child(4)").text(resp.email);
          $(".inv_tr_"+client_id+" td:nth-child(5)").text(resp.telephone);
        }
      });
    }else{
      $(".inv_tr_"+client_id+" td:nth-child(4)").text('');
      $(".inv_tr_"+client_id+" td:nth-child(5)").text('');
    }
      
  });
/* ################# Show Contact Name/Email End ################### */

/* ################# Show  Auto Collect Start ################### */
  $('#exampletab4').on('click', '.autocollect_pop', function(){
    var invoice_id    = $(this).data('invoice_id');
    var contact_id    = $(this).data('contact_id');
    var client_id     = $(this).data('client_id');
    var client_type   = $(this).data('client_type');
    
    $('#edit_id').val(invoice_id);
    $('#edit_client_id').val(client_id);
    $('#edit_client_type').val(client_type);

    $.ajax({
      type : 'POST',
      url : '/crm/get-auto-collect',
      dataType:'json',
      data : {'invoice_id':invoice_id, 'contact_id':contact_id, 'client_type':client_type, 'client_id':client_id },
      beforeSend : function(){
        $('#autocollect_pop-modal').modal('show');
      },
      success : function(resp){console.log(resp.auto_collect);
        $('#edit_contact_id').val(resp.ContactID);
        if(resp.auto_collect == 'Y'){
          $('#autocollect_check').iCheck('check');
        }else{
          $('#autocollect_check').iCheck('uncheck');
        }
      }
    }); 
  });

  $('#autocollect_pop-modal').on('click', '.save_auto_collect', function(){
    var invoice_id    = $('#edit_id').val();
    var contact_id    = $('#edit_contact_id').val();
    var client_id     = $('#edit_client_id').val();
    var client_type   = $('#edit_client_type').val();

    var auto_collect = 'N';
    if($('#autocollect_check').prop("checked") == true){
      auto_collect = 'Y';
    }
    // =========== Past collection date check ============ //
    $.ajax({
      type : 'POST',
      url : '/crm/check-collection-date',
      dataType:'json',
      data : {'contact_id':contact_id},
      success : function(resp){
        if(resp.check >0){
          if(confirm('One or more invoices have collection dates in the past')){
            save_auto_collect(auto_collect, invoice_id, contact_id, client_type, client_id);
          }else{
            return false;
          }
        }else{
          save_auto_collect(auto_collect, invoice_id, contact_id, client_type, client_id)
        }
      }
    }); 
    // =========== Past collection date check ============ //

      
  });
/* ################# Show  Auto Collect End ################### */

  $(".allocate_to_wip").click(function(event) {
    $(this).html('Allocated TO WIP');
  });

  /*====================== Save Prospects =========================== */
  $("#saveProspectsPop").click(function(event) {
    var saved_from = $('#saved_from').val();

    var is_exists   = $('#saveProspectsForm #is_exists').val();
    var type        = $('#saveProspectsForm #type').val();
    var title       = $("#saveProspectsForm #contact_title").val();
    var fname       = $("#saveProspectsForm #contact_fname").val();
    var lname       = $("#saveProspectsForm #contact_lname").val();
    var addContact  = $("#saveProspectsForm #addContact").val();

    if(title == '' && type == 'org' && is_exists == 'N' && addContact == 'N'){
      alert('Please select contact title');
      $("#saveProspectsForm #contact_title").focus();
      return false;
    }
    else if(fname == '' && type == 'org' && is_exists == 'N' && addContact == 'N'){
      alert('Please enter contact first name');
      $("#saveProspectsForm #contact_fname").focus();
      return false;
    }
    else if(lname == '' && type == 'org' && is_exists == 'N' && addContact == 'N'){
      alert('Please enter contact last name');
      $("#saveProspectsForm #contact_lname").focus();
      return false;
    }else{
      $("#saveProspectsForm").ajaxForm({
        dataType: 'json',
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function(resp) {
          $(".show_loader").html('');
          if(saved_from == 'new_proposal'){
            //location.reload();
            if(resp.client_type == 'org'){
              var prospect_name = resp.prospect_name;
            }else{
              var prospect_name = resp.prospect_title+' '+resp.prospect_fname+' '+resp.prospect_lname;
            }
            $('#propContactList').append('<option value="'+resp.leads_id+'">'+prospect_name+'</option>');
            $('#open_form-modal').modal('hide');
          }else{
            location.reload();
          }
          
        }
      }).submit();
    }

  });

  $('body').on('click', '.goToPreview', function(){
    var client_id     = $(this).data('client_id');
    var proposal_id   = $('#recurringDropdown_'+client_id).val();
    if(proposal_id == null){
      alert('Please select recurring contract');
      return false;
    }
    $.ajax({
      type: "POST",
      url: "/proposal/action",
      dataType:'json',
      data: { 'proposal_id' : proposal_id, 'action' : 'checkProposalId' },
      beforeSend : function(){
        $("#message_div").html('<div class="show_loader"><img src="/img/spinner.gif" height="25" /></div>');
      },
      success : function(resp){
        $("#message_div").html('');
        window.open('/proposal-preview/'+resp.entrpt_crm_prop_id+'/add/'+resp.is_rejected, 'name');
      }
    });
  });

  $('body').on('change', '.addContactType', function(){
    hideDisplayContactName();
  });

  $('body').on('change', '.contactPerson', function(){
    contactPersonDetails();
  });

	
});//document end 

function open_new_opportunity()
{
  $("#deal_owner").val('');
  $("#existing_client").val('');
  $("#prospect_name").val('');
  $("#business_type").val('2');
  $("#contact_title").val('');
  $("#contact_fname").val('');
  $("#contact_lname").val('');
  $("#prospect_lname").val('');
  $("#deal_owner").val('');
  $("#lead_source").val('0');
  $("#industry").val('0');
  $("#lead_date").val('');
  $("#phone").val('');
  $("#mobile").val('');
  $("#email").val('');
  $("#website").val('');
  $("#notes").val('');
  $("#open_new_lead-modal").modal("show");
}

function save_auto_collect(auto_collect, invoice_id, contact_id, client_type, client_id){
  $.ajax({
    type : 'POST',
    url : '/crm/save-auto-collect',
    dataType:'json',
    data : {'auto_collect':auto_collect, 'invoice_id':invoice_id, 'contact_id':contact_id, 'client_type':client_type, 'client_id':client_id },
    beforeSend : function(){
      //$('#autocollect_pop-modal').modal('hide');
    },
    success : function(resp){
      $('.inv_tr_'+client_id+' td:nth-child(7)').html(resp.ToBeCollected);
      $('#autocollect_pop-modal').modal('hide');
    }
  });
}

function copyto_Contract_renewal_history(client_id, renewal_status_id)
{
  //alert("This is For Contract Renewal History")
}

function change_renewal_status(client_id, renewal_status_id)
{
  var page_open   = $("#page_open").val();
  var prev_status = $("#"+page_open+"_prev_status_"+client_id).val();
  var status_id   = renewal_status_id;

  $.ajax({
    type : 'POST',
    url : '/crm/change-renewal-status',
    data : { 'client_id' : client_id, 'renewal_status_id' : status_id },
    success : function(resp){
      //window.location.reload();
      if(page_open != 3){
        $(".data_tr_"+client_id+"_"+page_open).hide();
      }
        var task_count = $("#task_count_"+prev_status).html();
        var total_cnt = parseInt(task_count-1);
        $("#task_count_"+prev_status).html(total_cnt);

        var count_2 = $("#task_count_"+status_id).html();
        var total = parseInt(count_2)+parseInt(1);
        $("#task_count_"+status_id).html(total); 

        $("#"+page_open+"_prev_status_"+client_id).val(status_id);
      
    }
  });
}

function save_acc_details(data_type, text, client_id)
{//alert(data_type);return false;
  var client_type = $("#client_type").val();
  var page_open   = $("#page_open").val();
  
  $.ajax({
    type: "POST",
    url: '/renewals/save-account-details',
    dataType:'json',
    beforeSend : function(){
      $(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
    },
    data: {'data_type':data_type, 'page_open':page_open, 'text':text, 'client_id':client_id, 'client_type':client_type },
    success : function(resp){
      $(".loader_class").html('');
      if(data_type == 'startdate'){
        var count_down = resp.count_down;
        $('#OrgTableContainer .startdate_'+client_id).html(resp.startdate);
        $('#OrgTableContainer .startdate_'+client_id).attr( "data-startdate", resp.startdate );
        $('#OrgTableContainer .enddate_'+client_id).html(resp.enddate);
        $('#OrgTableContainer .countdown_'+client_id).html(resp.count_down);
        $('#startdate_pop-modal').modal('hide');

        /*var button = '';
        if(start_date != '')
        {
          if($.isNumeric(count_down) && count_down <= 90){
            if(resp.renewals == 'N' ){
              if($.isNumeric(count_down) && count_down >=0 ){//console.log(count_down)
                button += '<button type="button" class="job_send_btn send_renewals" data-client_id="'+client_id+'" data-from_page="prop_client_org"><i class="fa fa-refresh"></i> RENEW</button>';
              }else{
                button += '<button type="button" class="job_send_btn" data-client_id="'+client_id+'">EXPIRED</button>';
              }
            }else{
              button += '<button type="button" class="job_sent_btn send_renewals" data-client_id="'+client_id+'" data-from_page="prop_client_org">RENEWED</button>';
            }
          }
        }
        $('#after_send_'+client_id).html(button);*/

        var renewBtn = $('#after_send_'+client_id).html();
        if(renewBtn == ''){
          $('#after_send_'+client_id).html('<button type="button" class="job_send_btn send_renewals" data-client_id="'+client_id+'" data-from_page="prop_client_org"><i class="fa fa-refresh"></i> Renew</button>');
        }

      }else if(data_type == 'billing_amount'){
        $('#OrgTableContainer .billing_amount_'+client_id).html(resp.billing_amount);
        $('#OrgTableContainer .billing_amount_'+client_id).attr( "data-amount", resp.billing_amount );
        $('#OrgTableContainer .monthly_amount_'+client_id).html( resp.monthly_amount );

        //header value change//
        $('#ann_amnt_head').html( resp.ann_amnt );
        $('#ann_avg_head').html( resp.ann_avg );
        $('#mnth_amnt_head').html( resp.mon_amnt );
        $('#mnth_avg_head').html( resp.mon_avg );

        $('#amount_pop-modal').modal('hide');
      }else if(data_type == 'engagement_date'){
        $('#OrgTableContainer #joining_div_'+client_id).html(resp.engagement_date);
        $('#OrgTableContainer #joining_div_'+client_id).attr( "data-joining", resp.engagement_date );
        $('#joining_pop-modal').modal('hide');
      }else{
        window.location.reload();
      }
    }
  });
}

function save_client_details(data_type, text, client_id)
{
  var client_type = $("#client_type").val();

  $.ajax({
    type: "POST",
    url: '/renewals/save-client-details',
    //dataType:'json',
    beforeSend : function(){
      $(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
    },
    data: {'data_type':data_type, 'text':text, 'client_id':client_id, 'client_type':client_type },
    success : function(resp){
      $(".loader_class").html('');

      if(data_type == 'created'){
        $('#joining_div_'+client_id).html(resp);
        $('#joining_div_'+client_id).attr( "data-joining", resp );
        $('#joining_pop-modal').modal('hide');
      }else{
        window.location.reload();
      }
    }
  });
}

function save_lead_status(tab_id, leads_id)
{
  var page_open = $("#encode_page_open").val();
  var owner_id = $("#encode_owner_id").val();
  $.ajax({
    type: "POST",
    url: '/crm/sendto-another-tab',
    data: { 'tab_id' : tab_id, 'leads_id' : leads_id },
    success : function(resp){
      //window.location = '/crm/'+page_open+"/"+owner_id;
      window.location.reload();
    }
  });
}

function get_field_disable()
{
  $("#existing_client").attr('disabled', 'disabled');
  $("#prospect_title").attr('disabled', 'disabled');
  $("#prospect_fname").attr('disabled', 'disabled');
  $("#prospect_lname").attr('disabled', 'disabled');
  $("#leads_id").attr('disabled', 'disabled');
  $("#date").attr('disabled', 'disabled');
  $("#deal_certainty").attr('disabled', 'disabled');
  $("#deal_owner").attr('disabled', 'disabled');
  $("#business_type").attr('disabled', 'disabled');
  $("#prospect_name").attr('disabled', 'disabled');
  $("#contact_title").attr('disabled', 'disabled');
  $("#contact_fname").attr('disabled', 'disabled');
  $("#contact_lname").attr('disabled', 'disabled');
  $("#phone").attr('disabled', 'disabled');
  $("#mobile").attr('disabled', 'disabled');
  $("#email").attr('disabled', 'disabled');
  $("#website").attr('disabled', 'disabled');
  $("#annual_revenue").attr('disabled', 'disabled');
  $("#quoted_value").attr('disabled', 'disabled');
  $("#lead_source").attr('disabled', 'disabled');
  $("#industry").attr('disabled', 'disabled');
  $("#street").attr('disabled', 'disabled');
  $("#city").attr('disabled', 'disabled');
  $("#county").attr('disabled', 'disabled');
  $("#postal_code").attr('disabled', 'disabled');
  $("#country_id").attr('disabled', 'disabled');
  $("#notes").attr('disabled', 'disabled');
}  

function get_field_enable(){
  $("#existing_client").prop("disabled", false);
  $("#prospect_title").prop("disabled", false);
  $("#prospect_fname").prop("disabled", false);
  $("#prospect_lname").prop("disabled", false);
  $("#leads_id").prop("disabled", false);
  $("#date").prop("disabled", false);
  $("#deal_certainty").prop("disabled", false);
  $("#deal_owner").prop("disabled", false);
  $("#business_type").prop("disabled", false);
  $("#prospect_name").prop("disabled", false);
  $("#contact_title").prop("disabled", false);
  $("#contact_fname").prop("disabled", false);
  $("#contact_lname").prop("disabled", false);
  $("#phone").prop("disabled", false);
  $("#mobile").prop("disabled", false);
  $("#email").prop("disabled", false);
  $("#website").prop("disabled", false);
  $("#annual_revenue").prop("disabled", false);
  $("#quoted_value").prop("disabled", false);
  $("#lead_source").prop("disabled", false);
  $("#industry").prop("disabled", false);
  $("#street").prop("disabled", false);
  $("#city").prop("disabled", false);
  $("#county").prop("disabled", false);
  $("#postal_code").prop("disabled", false);
  $("#country_id").prop("disabled", false);
  $("#notes").prop("disabled", false);
} 

function put_client_details(client_id, client_type)
{//alert(client_id+"==="+client_type)
  /*if(client_type == "org"){
    $("#prospect_name_div").hide();
    $("#contact_name_div").show();
    $("#org_name_div").show();
  }else{
    $("#contact_name_div").hide();
    $("#org_name_div").hide();
    $("#prospect_name_div").show();
  }*/

  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/crm/get-client-address',
    data: { 'client_id' : client_id, 'client_type' : client_type },
    success : function(resp){

      var client_dropdown = "<option value=''>-- None --</option>";
      $.each(resp['existing_clients'], function(key){
        client_dropdown+= "<option value='"+resp['existing_clients'][key].client_id+"'>"+resp['existing_clients'][key].client_name+"</option>";
      });
      $("#existing_client").html(client_dropdown);

      var contacts = "<option value=''>-- None --</option>";
      $.each(resp['contacts'], function(k,v){
        contacts += "<option value='"+v.contact_id+"_C'>"+v.contact_name+"</option>";
      });
      $.each(resp['relationship'], function(k,v){
        contacts += "<option value='"+v.client_id+"_R'>"+v.name+"</option>";
      });
      $("#contact_person").html(contacts);

      if(client_type=="org"){
        $("#business_type").val(resp['address'].business_type);
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

function put_new_opportunity(leads_id, type)
{
  $.ajax({
    type: "POST",
    url: '/crm/get-form-dropdown',
    dataType : 'json',
    data: { 'type' : type, 'leads_id' : leads_id },
    beforeSend : function(){
      $("#type").val(type);
      $("#leads_id").val(leads_id);
      $('.open_drop').hide();
      $(".show_loader").html('<img src="/img/spinner.gif" />');
      if(leads_id == 0){
        $("#is_exists").val('N');
      }
      $("#open_form-modal").modal("show");
    },
    success : function(resp){
      var contPrsn = '';
      $(".show_loader").html('');
      var client_dropdown = "<option value=''>-- None --</option>";
      $.each(resp['existing_clients'], function(key){
        var client_name = resp['existing_clients'][key].client_name;
        if($.trim(client_name) != ''){
          client_dropdown += "<option value='"+resp['existing_clients'][key].client_id+"'>"+resp['existing_clients'][key].client_name+"</option>";
        }
      });
      $("#saveProspectsForm #existing_client").html(client_dropdown);


      //==================Edit =================//
      if(leads_id != "0" && resp['leads_details'].existing_client != "0"){
        $("#existing_client").val(resp['leads_details'].existing_client);
      }
      if(type == 'ind'){
        $("#prospect_title").val(resp['leads_details'].prospect_title);
        $("#prospect_fname").val(resp['leads_details'].prospect_fname);
        $("#prospect_lname").val(resp['leads_details'].prospect_lname);
      }
      
      $("#leads_id").val(resp['leads_details'].leads_id);
      $("#date").val(resp['leads_details'].date);
      $("#deal_certainty").val(resp['leads_details'].deal_certainty);
      $("#deal_owner").val(resp['leads_details'].deal_owner);
      $("#business_type").val( (leads_id >0)?resp['leads_details'].business_type:'2' );
      $("#prospect_name").val(resp['leads_details'].prospect_name);
      $("#contact_title").val(resp['leads_details'].contact_title);
      $("#contact_fname").val(resp['leads_details'].contact_fname);
      $("#contact_mname").val(resp['leads_details'].contact_mname);
      $("#contact_lname").val(resp['leads_details'].contact_lname);
      $("#addContact").val( (leads_id >0)?resp['leads_details'].add_contact:'N' );
      $("#contactType").val( (leads_id >0)?resp['leads_details'].contact_type:'A' );
      $("#position").val(resp['leads_details'].position);
      $("#proposal_title").val(resp['leads_details'].proposal_title);
      
      $("#website").val(resp['leads_details'].website);
      $("#annual_revenue").val(resp['leads_details'].annual_revenue);
      $("#quoted_value").val(resp['leads_details'].quoted_value);
      $("#lead_source").val( (leads_id >0)?resp['leads_details'].lead_source:'0' );
      $("#industry").val( (leads_id >0)?resp['leads_details'].industry:'0' );
      $("#res_address").val(resp['leads_details'].address_id);
      $("#notes").val(resp['leads_details'].notes);
      $("#contactNameHid").val(resp['leads_details'].contact_name);
      
      if(leads_id >0){
        contPrsn = resp['leads_details'].contact_person+'_'+resp['leads_details'].person_type;
      }
      openOpportunityPopUp((leads_id >0)?resp['leads_details'].is_exists:'N');
      hideDisplayContactName(contPrsn);

      $("#phone").val(resp['leads_details'].phone);
      $("#mobile").val(resp['leads_details'].mobile);
      $("#email").val(resp['leads_details'].email);
      
    }
  });
}   


function openOpportunityPopUp( is_exists )
{
  $("#is_exists").val(is_exists);
  var client_type = $("#type").val();
  console.log(client_type+'='+is_exists)

  if(client_type == 'org'){
    $("#row10").show();
    $("#row11, #row5, #row12, #row13").hide();
    if(is_exists == 'N'){
      $("#row3").hide();
      $("#row1, #row2, #row4, #row6, #row7, #row8, #row9, #row12, #row13").show();
    }else{
      $("#row2, #row6, #row8, #row9").hide();
      $("#row1, #row3, #row4, #row7").show();
      yesContactName();
    }
  }else{
    $("#row2, #row5, #row10, #row12, #row13").hide();
    if(is_exists == 'N'){
      $("#row3").hide();
      $("#row1, #row4, #row6, #row7, #row8, #row9, #row11").show();
    }else{
      $("#row6, #row8, #row9, #row11").hide();
      $("#row1, #row3, #row4, #row7").show();
    }
  }
}

function yesContactName()
{
  var contact_name  = $("#contactNameHid").val();
  var client_id     = $("#existing_client").val();
  var leads_id      = $("#leads_id").val();

  var option = '<option value="">--Select --</option>';
  if(client_id != ''){
    $.ajax({
      type: "POST",
      url: '/crm/action',
      dataType:'json',
      data: { 'client_id':client_id, 'action':'contactDetailsByClientId' },
      beforeSend: function() {
        
      },
      success : function(resp){
        var details = resp.details;
        $.each(details, function(k,v){
          option += '<option value="'+v.item_id+'_'+v.item_type+'">'+v.item_name+'</option>';
        });
        $('#open_form-modal #contact_name').html(option);
        $("#open_form-modal #contact_name").val(contact_name);
      }
    });
  }
}

function hideDisplayContactName(contPrsn='')
{
  var addContact  = $("#addContact").val();
  var contactType = $("#contactType").val();
  var client_type = $("#type").val();
  var is_exists   = $("#is_exists").val();

  if(addContact == 'N'){
    if(is_exists == 'N' && client_type == 'org'){
      $("#row5").hide();
      $("#row13").show();
    }
    
  }else{
    $.ajax({
      type: "POST",
      url: "/crm/action",
      dataType:'json',
      data: { 'contactType':contactType, 'action':'getContactNameByType' },
      beforeSend : function(){
        $('#saveProspectsForm #phone, #mobile, #email').val('');
        $("#row13").hide();
        $("#row5").show();
      },
      success : function(resp){
        var select = '<option value="">-- Select Contact --</option>';
        $.each(resp.details, function(k, v){
          if(contactType == 'NA'){
            select += '<option value="'+v.contact_id+'_C">'+v.contact_name+'</option>';
          }else{
            select += '<option value="'+v.client_id+'_R">'+v.client_name+'</option>';
          }
        });
        $('#saveProspectsForm #contact_person').html(select);
        $("#saveProspectsForm #contact_person").val(contPrsn);
      }
    });
    
  }
}

function contactPersonDetails()
{
  var contactType = $('#saveProspectsForm .contactPerson').val();
  if(contactType == ''){
    $('#saveProspectsForm #phone').val('');
    $('#saveProspectsForm #mobile').val('');
    $('#saveProspectsForm #email').val('');
  }else{
    var contact       = contactType.split('_');
    var contact_id    = contact[0];
    var contact_type  = contact[1];
    $.ajax({
      type: "POST",
      url: "/crm/action",
      dataType:'json',
      data: {'contact_id':contact_id, 'contact_type':contact_type, 'action':'getContactDetailsByType' },
      beforeSend : function(){
        $("#row13").hide();
        $("#row5").show();
      },
      success : function(resp){
        var dtls = resp.details;
        var phone       = (contact_type=='R')?dtls.res_telephone:dtls.telephone;
        var mobile      = (contact_type=='R')?dtls.res_mobile:dtls.mobile;
        var email       = (contact_type=='R')?dtls.res_email:dtls.email;
        //var website     = (contact_type=='R')?dtls.res_website:dtls.website;
        //var address_id  = (contact_type=='R')?dtls.res_address:dtls.address_id;

        $('#saveProspectsForm #phone').val(phone);
        $('#saveProspectsForm #mobile').val(mobile);
        $('#saveProspectsForm #email').val(email);
        //$('#saveProspectsForm #mobile').val(website);
        //$('#saveProspectsForm #email').val(address_id);
      }
    });
  }
}