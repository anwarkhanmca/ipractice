$('body').on('focus',".app_date", function(){
    $(this).datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-10:+10" });
});


$(document).ready(function(){
    $('#onboard_drop').hide();
    
	$('#allCheckSelect').on('ifChecked', function(event){
		/*$('#example2 input[type=checkbox]').attr('checked', 'checked');
		$('.all_check div').addClass('checked');*/
		$('input').iCheck('check');
	});

	$('#allCheckSelect').on('ifUnchecked', function(event){
		/*$('.all_check div').removeClass('checked');
		$("input[name='client_delete_id[]']").removeAttr('checked');*/
		$('input').iCheck('uncheck');
	});

  $('#AllCkeck').on('ifChecked', function(event){
    $('.myServTable input').iCheck('check');
  });

  $('#AllCkeck').on('ifUnchecked', function(event){
    $('.myServTable input').iCheck('uncheck');
  });

  $('#ec_scale_list').on('ifChecked', function(event){
    $('#ecsl_hide_div').show("slow");
  });

  $('#ec_scale_list').on('ifUnchecked', function(event){
    $('#ecsl_hide_div').hide("slow");
  });

  $('.serviceCheck').on('ifChecked', function(event){
    var service_id = $(this).val();
    $("#service_edit_td_"+service_id+' a').removeClass('disable_click');
    $("#staff_dropdown_"+service_id).removeClass('disable_click');
  });

  $('.serviceCheck').on('ifUnchecked', function(event){
    var service_id = $(this).val();
    $("#service_edit_td_"+service_id+' a').addClass('disable_click');
    $("#staff_dropdown_"+service_id).addClass('disable_click');
  });

	/*$(".ads_Checkbox").on('ifChecked', function(event){
    $(".ads_Checkbox:checked").each( function (i) {
        if($(this).data("archive") == "Y"){
          $("#archivedButton").html('Un-Archive');
          $("#archiveClients").html('Un-Archive');
        }else{
          $("#archivedButton").html('Archive');
          $("#archiveClients").html('Archive');
        }
    });
		
	});
  $(".ads_Checkbox").on('ifUnchecked', function(event){
    $(".ads_Checkbox:checked").each( function (i) {
        if($(this).data("archive") == "Y"){
          $("#archivedButton").html('Un-Archive');
          $("#archiveClients").html('Un-Archive');
        }else{
          $("#archivedButton").html('Archive');
          $("#archiveClients").html('Archive');
        }
    });
    
  });*/

  $("body").on('click', '.ads_Checkbox', function(event){
    $(".ads_Checkbox:checked").each( function (i) {
        if($(this).data("archive") == "Y"){
          $("#archivedButton").html('Un-Archive');
          $("#archiveClients").html('Un-Archive');
        }else{
          $("#archivedButton").html('Archive');
          $("#archiveClients").html('Archive');
        }
    });
    
  });


  $('#deleteClients').click(function() {
		var val = [];
        //alert('val');return false;
    $(".ads_Checkbox:checked").each( function (i) {
			if($(this).is(':checked')){
				val[i] = $(this).val();
			}
    });
    
    var client_type = $('#client_type').val();
    if(client_type == 'org'){
        var deleted_type = $('#deleted_type').val();
    }else{
        var deleted_type = 0;
    }
    
    //alert(val.length);return false;
	  if(val.length>0){
      var client_type = $("#client_type").val();
      if(confirm("Do you want to delete??")){
        $.ajax({
          type: "POST",
          url: '/delete-individual-clients',
          data: { 'client_delete_id' : val, 'deleted_type' : deleted_type },
          success : function(resp){
            $('#delete_client-modal').modal("hide");
            refresh_table();
            /*if(client_type == "org"){
              window.location = '/organisation-clients';
            }else{
               window.location = '/individual-clients';
            }*/
          }
        });
      }

 		}else{
 			alert('Please select atleast one clients');
 		}
 	});
    
  $('#deletePopup').click(function() {
    var val = [];
    //alert('val');return false;
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    if(val.length>0){
      $('#delete_client-modal').modal("show");
    }else{
 			alert('Please select atleast one clients');
 		}
 	});

 	$('#show_search').click(function() {
		$('#example2_filter').toggle();
 	});

 	$('#search_client_text').keyup(function() {
    var search_value = $(this).val();
		$.ajax({
      type: "POST",
      dataType: "json",
      url: '/individual/search-individual-client',
      data: { 'search_value' : search_value, 'client_type' : "ind" },
      success : function(resp){
        if (resp.length != 0) {
          var content = '';
          $.each(resp, function(key){
            content+= "<tr class='all_check odd'><td align='center'><input type='checkbox' class='ads_Checkbox' name='client_delete_id[]' value='1' id='client_delete_id'/><td>"+resp[key].staff_name+"</td><td>"+resp[key].dob+"</td><td><a href='#'>"+resp[key].name+"</a></td><td>"+resp[key].business_name+"</td><td>"+resp[key].ni_number+"</td><td>"+resp[key].tax_reference+"</td><td>"+resp[key].acting+"</td><td>"+resp[key].res_address+", "+resp[key].res_city+", "+resp[key].res_zipcode+"</td></tr>";
            //console.log(resp[key].client_name); 
          });

          $("#example2 tbody").html(content);
          //$("#show_search_client").show();
        }
        
      }
    });
 	});





// Add individual client
$(".open").click(function(){
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
  }else if($("#business_name").val() == ""){
    alert("Business name can not be null");
    $("#business_name").focus();
    return false;
  }

}
///////////Validation//////////////

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
    }else if($("#business_name").val() == ""){
      alert("Business name can not be null");
      $("#business_name").focus();
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

 
    
  $("#tax_office_id").change(function(){
    var client_type = $('#client_type').val();
    if(client_type == 'ind'){
      var tax_ref_type   = $('#tax_reference_type').val();
      var office_id   = $(this).val();
    }else{
      var taxtext = $("#tax_office_id option:selected").text();
      var taxtype = $(this).val();
      var splitpart= taxtype.split(",");
      var tax_ref_type = splitpart['0'];
      var office_id =splitpart['1'];
    }

    if(tax_ref_type || office_id ==""){
      $('#tax_address').val("");
      $('#tax_zipcode').val("");
      $('#tax_telephone').val("");
    }
    
    if(tax_ref_type=="C"){
      var smallbox =taxtext.split(",")
      var digit=smallbox['0'];
      $('#utrsamllbox').val(digit)
    }
    else{
      $('#utrsamllbox').val("")
    }
    if(tax_ref_type == "I"){
      var tax_type   = $('#tax_reference_type').val();
      if(office_id == "4"){
        $('#tax_address').val("");
        $('#tax_zipcode').val("");
        $('#tax_telephone').val("");

        $('#show_other_office').fadeIn();
      }else{
        $.ajax({
          type: "POST",
          dataType: "json",
          url: '/individual/get-office-address',
          data: { 'office_id' : office_id },
          success : function(resp){
            $('#show_other_office').fadeOut();
            $('#other_office_id').val('');
            $('#tax_address').val(resp['address']);
            $('#tax_zipcode').val(resp['zipcode']);
            $('#tax_telephone').val(resp['telephone']);
          }
        });
      }
    }

    if(tax_ref_type == "C"){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/client/get-corporation-address',
        data: { 'office_id' : office_id },
        success : function(resp){
          //$('#show_other_office').fadeOut();

          $('#tax_address').val(resp['address']);
          $('#tax_zipcode').val(resp['zipcode']);
          $('#tax_telephone').val(resp['telephone']);
        }
      });
    }
  });

  $("#other_office_id").change(function(){
    var office_id   = $(this).val();
    
    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/individual/get-office-address',
      data: { 'office_id' : office_id },
      success : function(resp){
        $('#tax_address').val(resp['address']);
        $('#tax_zipcode').val(resp['zipcode']);
        $('#tax_telephone').val(resp['telephone']);
      }
    });

    
  });

  $(".org_relclient_search").keyup(function(){
    var search_value  = $(this).val();
    var client_type   = $("#search_client_type").val();
    //alert(search_value+", "+client_type);
    if(search_value == ""){
      $("#show_search_client").hide();
    }else{
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/search/search-client',
        //url: '/search/search-all-client',
        data: { 'search_value' : search_value, 'client_type' : client_type },
        success : function(resp){
          var content = '<ul>';
          if (resp.length != 0) {
            $.each(resp, function(key){
              content+= "<li class='putClientName' data-client_name='"+resp[key].client_name+"' data-client_id='"+resp[key].client_id+"'>"+resp[key].client_name+"</li>";
            });
          }else{
            content+= "<li>No result found...</li>";
          }
          content+= '</ul>';
          $("#show_search_client").html(content);
          $("#show_search_client").show();
          
        }
      });

    }
  });

  $(".all_relclient_search").keyup(function(){
    var search_value  = $(this).val();
    var client_type   = $("#search_client_type").val();
    //alert(search_value+", "+client_type);
    if(search_value == ""){
      $("#show_search_client").hide();
    }else{
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/search/search-all-client',
        data: { 'search_value' : search_value, 'client_type' : client_type },
        success : function(resp){
          var content = '<ul>';
          if (resp.length > 0) {
            
            $.each(resp, function(key){
              content+= "<li class='putClientName' data-client_name='"+resp[key].client_name+"' data-client_id='"+resp[key].client_id+"'>"+resp[key].client_name+"</li>";
              //console.log(resp[key].client_name); 
            });
          }else{
            content+= "<li>No result found...</li>";
          }
          content+= '</ul>';

          $("#show_search_client").html(content);
          $("#show_search_client").show();
          
        }
      });

    }
  });


  //Relationship client search result
  $("body").on("click",".putClientName", function(){
      var client_id  = $(this).data('client_id');
      var client_name  = $(this).data('client_name');
      var client_type  = $("#search_client_type").val();//alert(client_type)
      if(client_name != ""){
        if(client_type == "ind"){
          $(".all_relclient_search").val(client_name);
        }else{
          $(".org_relclient_search").val(client_name);
        }
        

        $("#rel_client_id").val(client_id);
        $(".show_search_client").hide();
      }
  });



//Individual table edited
  $("#edit_but").click(function(){
    $("#edit_but").hide();
    $("#save_but").show();

    $("#dob_select").show();
    $("#dob_text").hide();

    $("#business_name_select").show();
    $("#business_name_text").hide();

    $("#ni_number_select").show();
    $("#ni_number_text").hide();

    $("#tax_reference_select").show();
    $("#tax_reference_text").hide();

    $("#acting_select").show();
    $("#acting_text").hide();

    $("#res_address_select").show();
    $("#res_address_text").hide();

  });

//Individual table Save
  $("#save_but").click(function(){

    var four_col    = $("#four").val();
    var four        = four_col.split('-');
    var six_col     = $("#six").val();
    var six         = six_col.split('-');
    var seven_col   = $("#seven").val();
    var seven       = seven_col.split('-');
    var eight_col   = $("#eight").val();
    var eight       = eight_col.split('-');
    var nine_col    = $("#nine").val();
    var nine        = nine_col.split('-');
    var ten_col     = $("#ten").val();
    var ten         = ten_col.split('-');

    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/individual/show-new-tables',
      data: { 'four' : four[0], 'six' : six[0], 'seven' : seven[0], 'eight' : eight[0], 'nine' : nine[0], 'ten' : ten[0] },
      success : function(resp){

        var content = '';
        var i = 1;
        $.each(resp, function(key){//alert(resp[key][four[0]])
          if(resp[key][four[0]].length != 0 || resp[key][four[0]] == "undefined"){
            resp[key][four[0]] = "";
          }
          if(resp[key][six[0]].length != 0 || resp[key][six[0]] == "undefined"){
            resp[key][six[0]] = "";
          }
          if(resp[key][seven[0]].length != 0 || resp[key][seven[0]] == "undefined"){
            resp[key][seven[0]] = "";
          }
          if(resp[key][eight[0]].length != 0 || resp[key][eight[0]] == "undefined"){
            resp[key][eight[0]] = "";
          }
          if(resp[key][nine[0]].length != 0 || resp[key][nine[0]] == "undefined"){
            resp[key][nine[0]] = "";
          }
          if(resp[key][ten[0]].length != 0 || resp[key][ten[0]] == "undefined"){
            resp[key][ten[0]] = "";
          }
          content += '<tr class="all_check"><td align="center"><input type="checkbox" class="ads_Checkbox" name="client_delete_id[]" value="1" id="client_delete_id"/></td><td>'+i+'</td><td>'+resp[key].staff_name+'</td><td>'+resp[key][four[0]]+'</td><td><a href="#">'+resp[key].name+'</a></td><td>'+resp[key][six[0]]+'</td><td>'+resp[key][seven[0]]+'</td><td>'+resp[key][eight[0]]+'</td><td>'+resp[key][nine[0]]+'</td><td>'+resp[key][ten[0]]+'</td></tr>';
          //console.log(resp[key].client_name); 
          i++;
        });

        $("#example2 tbody").html(content);

        $("#edit_but").show();
        $("#save_but").hide();

        $("#dob_select").hide();
        $("#dob_text").show();
        $("#dob_text").html(four[1]);

        $("#business_name_select").hide();
        $("#business_name_text").show();
        $("#business_name_text").html(six[1]);

        $("#ni_number_select").hide();
        $("#ni_number_text").show();
        $("#ni_number_text").html(seven[1]);

        $("#tax_reference_select").hide();
        $("#tax_reference_text").show();
        $("#tax_reference_text").html(eight[1]);

        $("#acting_select").hide();
        $("#acting_text").show();
        $("#acting_text").html(nine[1]);

        $("#res_address_select").hide();
        $("#res_address_text").show();
        $("#res_address_text").html(ten[1]);
      }
    });

  });


//Show Archived in add individual client
  $("#archive_div").click(function(){
    var client_type = $("#client_type").val();
    var is_archive;
    var html = $(this).html();
    if($.trim(html) == 'Show Archived Clients'){
      is_archive  = 'N';
      $(this).html('Hide Archived Clients');
    }else{
      is_archive  = 'Y';
      $(this).html('Show Archived Clients');
    }
    //alert(is_archive);return false;
    $.ajax({
      type: "POST",
      url: '/client/show-archive-client',
      data: { 'is_archive' : is_archive },
      success : function(resp){//return false;
        refresh_table();
        /*if(client_type == "org"){
          window.location = '/organisation-clients';
        }else{
          window.location = '/individual-clients';
        }*/
      }
    });
      
      //$("#archivedButton").toggle();
  });

// Archive and Un-Archive client start //
  $("#archivedButton").click(function(){
    var val = [];
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    //alert(val.length);return false;
    if(val.length>0){
      var client_type = $("#client_type").val();
      var status      = $.trim($(this).html());
      //alert(status);return false;
      if(confirm("Do you want to change the status of the client?")){
        if(status == 'Archive'){
          $('#archive_client-modal').modal("show");
        }else{
          archiveClientsFunction(val, status, '0', client_type);
        }
      }
    }else{
      alert('Please select atleast one clients');
    }
  });

  $('#archiveClients').click(function() {
      var val = [];
      $(".ads_Checkbox:checked").each( function (i) {
        if($(this).is(':checked')){
          val[i] = $(this).val();
        }
      });

      var client_type     = $("#client_type").val();
      var status          = $.trim($(this).html());
      var archive_reason  = $("#archive_reason").val();

      archiveClientsFunction(val, status, archive_reason, client_type);
  });
// Archive and Un-Archive client start //  


  $(document).click(function() {
    $("#onboard_drop").hide();
  });
  $("#select_onboard").click(function(event) {
    $("#onboard_drop").toggle();
    event.stopPropagation();
  });


  $("#onboard_drop").click(function(){
    var val = [];
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    
    if(val.length>0){
      var client_type = $("#client_type").val();
      var status = $.trim($(this).html());
      $.ajax({
        type: "POST",
        url: '/client/onboard-client',
        data: { 'client_id' : val},
        success : function(resp){
          window.location = '/onboard';
        }
      });
    }else{
      alert('Please select atleast one clients');
    }
  });




//Get Service country code
$(".service_country").change(function(){
    //alert('code');
    var country_id   = $(this).val();
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/individual/get-country-code',
      data: { 'country_id' : country_id },
      success : function(resp){
        $('#serv_tele_code').val(resp);
        $('#emer_mobile_code').val(resp);
        $('#emer_tele_code').val(resp);
        
        $('#serv_mobile_code').val(resp);
      }
    });
});

//Get same address as residential address start
$('#res_service_same').on('ifChecked', function(event){
  $(this).iCheck('check');
  $("#res_address").val($("#serv_address").val()); 
  /*$("#res_addr_line1").val($("#serv_addr_line1").val()); 
  $("#res_addr_line2").val($("#serv_addr_line2").val());
  $("#res_city").val($("#serv_city").val());
  $("#res_county").val($("#serv_county").val());
  $("#res_postcode").val($("#serv_postcode").val());*/
});

$('#res_service_same').on('ifUnchecked', function(event){
  /*$("#res_addr_line1").val(""); 
  $("#res_addr_line2").val("");
  $("#res_city").val("");
  $("#res_county").val("");
  $("#res_postcode").val("");*/
  $(this).iCheck('uncheck');
  $("#res_address").val(''); 
});
//Get same address as residential address start

//Get office address in add individual client Contact information portion start
$(".office_address").change(function(){
  var data_name = $(this).data('name');
  var office_id   = $(this).val();
  if(office_id == "4"){
    $('#'+data_name+'_address').val("");
    $('#'+data_name+'_zipcode').val("");
    
    $('#show_other_'+data_name+'office').fadeIn();

    }else{
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/individual/get-office-address',
        data: { 'office_id' : office_id },
        success : function(resp){
          if(office_id <= 4){
            $('#show_other_'+data_name+'office').fadeOut();
          }

          $('#'+data_name+'_address').val(resp['address']);
          /*$('#res_city').val(resp['city']);
          $('#res_region').val(resp['region']);*/
          $('#'+data_name+'_zipcode').val(resp['zipcode']);
        }
      });

    }
}); 
//Get office address in add individual client Contact information portion end

//Delete user added field while add individual/organisation user start
$(".delete_user_field").click(function(){
  var field_id = $(this).data('field_id');
  if (confirm("Do you want to delete this field ?")) {
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/individual/delete-user-field',
      data: { 'field_id' : field_id },
      success : function(resp){
        if(resp != ""){
          location.reload();
        }
      }
    });
  }
  
}); 
//Delete user added field while add individual/organisation user end

//Delete Section individual/organisation user start
$(".delete_section").click(function(){
  var step_id = $(this).data('step_id');
  if (confirm("Do you want to delete this section ?")) {
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/client/delete-section',
      data: { 'step_id' : step_id },
      success : function(resp){
        if(resp != ""){
          location.reload();
        }
      }
    });
  }
  
}); 
//Delete Section individual/organisation user end


//Show select option while adding client start
$(".user_field_type").change(function(){
  var field_type   = $(this).val();
  if(field_type == "4"){
    $('#show_select_option').show();
  }else{
    $('#show_select_option').hide();
  }
}); 
//Show select option while adding client end

//Add sub section name while add individual/organisation user start
$("#subsec_name").focusin(function(){
  $(".search_value").show(); 
}); 
/*$("#subsec_name").focusout(function(){
  $(".search_value").hide(); 
});*/
//Add sub section name while add individual/organisation user end

//Add new header section name while add individual/organisation user start
$(".add_subsec_name").on("click", function(){
  var parent_id   = $("#step_id").val();
  var subsec_name = $("#subsec_name").val();
  var client_type = $(this).data('client_type');

  if(subsec_name == ""){
    alert("Please enter sub section name");
    $("#subsec_name").focus();
    return false;
  }
    $.ajax({
      type: "POST",
        dataType: "json",
        url: '/client/insert-section',
        data: { 'subsec_name' : subsec_name, 'parent_id' : parent_id, 'client_type' : client_type },
        success : function(resp){
          if (resp.length != 0) {
            var content = "<option value=''>-- Select sub section --</option>";
            $.each(resp, function(key){
              content+= "<option value='"+resp[key].step_id+"'>"+resp[key].title+"</option>";
            });
            content+= '<option value="new">Add new ...</option>';

            $("#substep_id").html(content);
            $(".show_new_div").hide();
            $("#subsec_name").val("");

          }
        }
    });
});
//Add new header section name while add individual/organisation user end

$('.toUpperCase').keyup(function() {
    $(this).val($(this).val().toUpperCase());
});


//Show old Contact address while adding client start
//$(".get_oldcont_address").change(function(){
////alert('sds');
//  var client_id   = $(this).val();
//  var type   = $(this).data("type");
//  if(client_id != "")
//  {
//    $.ajax({
//      type: "POST",
//      dataType: "json",
//      url: '/client/get-oldcont-address',
//      data: { 'client_id' : client_id },
//      success : function(resp){
//        //var value = $.parseJSON(resp);
//        //alert(value.client_code);
//        if (resp.length != 0) {
//          $.each(resp, function(key){
//            //console.log(resp[key].client_id); 
//            $("#"+type+"_addr_line1").val(resp[key].cont_addr_line1);
//            $("#"+type+"_addr_line2").val(resp[key].cont_addr_line2);
//            $("#"+type+"_city").val(resp[key].cont_city);
//            $("#"+type+"_county").val(resp[key].cont_county);
//            $("#"+type+"_postcode").val(resp[key].cont_postcode);
//            
//          });
//
//        }
//
//      }
//    });
//  }else{
//    $("#"+type+"_addr_line1").val("");
//    $("#"+type+"_addr_line2").val("");
//    $("#"+type+"_city").val("");
//    $("#"+type+"_county").val("");
//    $("#"+type+"_postcode").val("");
//  }
//  
//}); 
//Show old Contact address while adding client end




//new address
$(".get_oldcont_address").change(function(){
  var value   = $(this).val();
  var type    = $(this).data("type");
  split_value = value.split("_");

  var client_id   = split_value[0];
  var address_type   = split_value[1];
  //alert(type);
  if(client_id != "")
  {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/client/get-oldcont-address',
      data: { 'client_id' : client_id, 'address_type':address_type },
      success : function(resp){
       if (resp.length != 0) {
          $.each(resp, function(key){
            if(address_type == "res"){
                $("#"+type+"_addr_line1").val(resp[key].res_addr_line1);
                $("#"+type+"_addr_line2").val(resp[key].res_addr_line2);
                $("#"+type+"_city").val(resp[key].res_city);
                $("#"+type+"_county").val(resp[key].res_county);
                $("#"+type+"_postcode").val(resp[key].res_postcode);
                $("#"+type+"_country").val(resp[key].res_country);
            }
            if(address_type == "serv"){
              $("#"+type+"_addr_line1").val(resp[key].serv_addr_line1);
              $("#"+type+"_addr_line2").val(resp[key].serv_addr_line2);
              $("#"+type+"_city").val(resp[key].serv_city);
              $("#"+type+"_county").val(resp[key].serv_county);
              $("#"+type+"_postcode").val(resp[key].serv_postcode);
              $("#"+type+"_country").val(resp[key].serv_country);
            }
          });

        }

      }
    });
  }else{
    $("#"+type+"_addr_line1").val("");
    $("#"+type+"_addr_line2").val("");
    $("#"+type+"_city").val("");
    $("#"+type+"_county").val("");
    $("#"+type+"_postcode").val("");
  }
  
}); 
//new address

//new org

$(".get_orgoldcont_address").change(function(){
  var address_id   = $(this).val();
  var type = $(this).data("type");//alert(address_type+'dddd'+address_id)
  //split_value = value.split("_");

  //var client_id   = split_value[0];
  //var address_type   = split_value[1];
  //alert(type);
  if(address_id != "")
  {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/client/get-orgoldcont-address',
      data: { 'address_id' : address_id, 'address_type' : type },
      success : function(resp){
       
        if (resp.length != 0) {
            
            if(type == "trad"){
                
                $("#"+type+"_cont_addr_line1").val(resp.trad_cont_addr_line1);
                $("#"+type+"_cont_addr_line2").val(resp.trad_cont_addr_line2);
                $("#"+type+"_cont_city").val(resp.trad_cont_city);
                $("#"+type+"_cont_county").val(resp.trad_cont_county);
                $("#"+type+"_cont_postcode").val(resp.trad_cont_postcode);
                $("#"+type+"_cont_country").val(resp.trad_cont_country);
            }
            
            if(type == "reg"){
                
                $("#"+type+"_cont_addr_line1").val(resp.reg_cont_addr_line1);
                $("#"+type+"_cont_addr_line2").val(resp.reg_cont_addr_line2);
                $("#"+type+"_cont_city").val(resp.reg_cont_city);
                $("#"+type+"_cont_county").val(resp.reg_cont_county);
                $("#"+type+"_cont_postcode").val(resp.reg_cont_postcode);
                $("#"+type+"_cont_country").val(resp.reg_cont_country);
            }
            
            
             if(type == "corres"){
                
                $("#"+type+"_cont_addr_line1").val(resp.corres_cont_addr_line1);
                $("#"+type+"_cont_addr_line2").val(resp.corres_cont_addr_line2);
                $("#"+type+"_cont_city").val(resp.corres_cont_city);
                $("#"+type+"_cont_county").val(resp.corres_cont_county);
                $("#"+type+"_cont_postcode").val(resp.corres_cont_postcode);
                $("#"+type+"_cont_country").val(resp.corres_cont_country);
            }
            
            if(type == "banker"){
                
                $("#"+type+"_cont_addr_line1").val(resp.banker_cont_addr_line1);
                $("#"+type+"_cont_addr_line2").val(resp.banker_cont_addr_line2);
                $("#"+type+"_cont_city").val(resp.banker_cont_city);
                $("#"+type+"_cont_county").val(resp.banker_cont_county);
                $("#"+type+"_cont_postcode").val(resp.banker_cont_postcode);
                $("#"+type+"_cont_country").val(resp.banker_cont_country);
            }
            
            if(type == "oldacc"){
                
                $("#"+type+"_cont_addr_line1").val(resp.oldacc_cont_addr_line1);
                $("#"+type+"_cont_addr_line2").val(resp.oldacc_cont_addr_line2);
                $("#"+type+"_cont_city").val(resp.oldacc_cont_city);
                $("#"+type+"_cont_county").val(resp.oldacc_cont_county);
                $("#"+type+"_cont_postcode").val(resp.oldacc_cont_postcode);
                $("#"+type+"_cont_country").val(resp.oldacc_cont_country);
            }
            
            
            
             if(type == "auditors"){
                
                $("#"+type+"_cont_addr_line1").val(resp.auditors_cont_addr_line1);
                $("#"+type+"_cont_addr_line2").val(resp.auditors_cont_addr_line2);
                $("#"+type+"_cont_city").val(resp.auditors_cont_city);
                $("#"+type+"_cont_county").val(resp.auditors_cont_county);
                $("#"+type+"_cont_postcode").val(resp.auditors_cont_postcode);
                $("#"+type+"_cont_country").val(resp.auditors_cont_country);
            }
            
            
            if(type == "solicitors"){
                
                $("#"+type+"_cont_addr_line1").val(resp.solicitors_cont_addr_line1);
                $("#"+type+"_cont_addr_line2").val(resp.solicitors_cont_addr_line2);
                $("#"+type+"_cont_city").val(resp.solicitors_cont_city);
                $("#"+type+"_cont_county").val(resp.solicitors_cont_county);
                $("#"+type+"_cont_postcode").val(resp.solicitors_cont_postcode);
                $("#"+type+"_cont_country").val(resp.solicitors_cont_country);
            }
          

        }

      }
    });
  }else{
    $("#"+type+"_cont_addr_line1").val("");
    $("#"+type+"_cont_addr_line2").val("");
    $("#"+type+"_cont_city").val("");
    $("#"+type+"_cont_county").val("");
    $("#"+type+"_cont_postcode").val("");
    $("#"+type+"_cont_country").val("");
    
  }
  
}); 
//new org

// Select title for gender change while adding client start //
$(".select_title").change(function(){
  var value   = $(this).val();
  //alert(value);
  var male = ['Mr', 'Rev', 'Sir', 'Lord', 'Captain'];
  var female = ['Mrs', 'Miss', 'Dame', 'Lady', 'Ms'];
  if($.inArray(value, male) != -1){
    $("#gender").val('Male');
  }else if($.inArray(value, female) != -1){
    $("#gender").val('Female');
  }else{
    $("#gender").val('');
  }
  
});
// Select title for gender change while adding client end //

// Show add subsection text while adding client start //
$(".subsec_change").change(function(){
  var value   = $(this).val();
  //alert(value);
  if(value == "new"){
    $(".show_new_div").show();
  }else{
    $(".show_new_div").hide();
  }
  
});
// Show add subsection text while adding client end //

// Show subsection dropdown while adding client start //
$(".show_subsec").change(function(){
  var step_id     = $(this).val();
  var client_type = $(this).data("client_type");
  //alert(value);
  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/client/get-subsection',
    data: { 'step_id' : step_id, 'client_type' : client_type },
    success : function(resp){
      var content = "<option value=''>-- Select sub section --</option>";
      if (resp.length != 0) {
        $.each(resp, function(key){
          content+= "<option value='"+resp[key].step_id+"'>"+resp[key].title+"</option>";
        });
      }
      content+= '<option value="new">Add new ...</option>';
      $("#substep_id").html(content);
    }
  });
  
});
// Show subsection dropdown while adding client end //

// Delete relationship while adding client start //
$("#myRelTable").on("click", ".delete_rel", function(){

  if(confirm("Do you want to delete this relationship ?") === false){
    return false;
  }


  var delete_index       = $(this).data("delete_index");
  var rel_client_id      = $(this).data("rel_client_id");

  if(relationship_array.length > 0){
    for (var j = 0; j < relationship_array.length; j++) { 
        //console.log(relationship_array[j]) + "<br>";
        var element     = relationship_array[j];
        var rand_value  = element.split("mpm");
        if(rand_value[0] == delete_index){
        //  var index = relationship_array.indexOf(relationship_array[j]);
          relationship_array.splice(j, 1);
          break;
        }
    }
  }

  // delete added from add to list client start //
  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/client/delete-addtolist-client',
    data: { 'client_id' : rel_client_id },
    success : function(resp){
      
    }
  });
  // delete added from add to list client end //

  $('#app_hidd_array').val(relationship_array);
  $("#added_tr"+delete_index).hide();

  //$("#acting_client_id option[value='"+rel_client_id+"']").remove();
  
});
// Delete relationship while adding client end //

$("#myRelTable").on("click", ".edit_rel", function(){
  var edit_index  = $(this).data("edit_index");
  var link  = $(this).data("link");
  var rel_client_id  = $(this).data("rel_client_id");

  var client_type   = $("#search_client_type").val();
  if(client_type == 'org'){
    var text_class = 'org_relclient_search';
  }else{
    var text_class = 'all_relclient_search';
  }

  //var first_value   = $("#added_tr"+edit_index+" td:nth-child(1)").html();
  var first_value = $("#client_dropdown #rel_client_id").html();
  var name_dropdown = '<select class="form-control" name="edit_rel_client_id" id="edit_rel_client_id">';
  name_dropdown += first_value+"</select>";

  var second_value  = $("#added_tr"+edit_index+" td:nth-child(2)").html();

  var fourth = '<button class="btn btn-success rel_save" data-rel_client_id="'+rel_client_id+'" data-edit_index="'+edit_index+'" data-link="'+link+'" type="button">Save</button>';

  $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/client/edit-relation-type',
      data: { 'relation_type' : second_value, 'client_type' : client_type },
      success : function(resp){
        $("#added_tr"+edit_index+" td:nth-child(1)").html(name_dropdown);//alert(rel_client_id);
        $("#added_tr"+edit_index+" td:nth-child(1) > select").val(rel_client_id)
        $("#added_tr"+edit_index+" td:nth-child(2)").html(resp);
        $("#added_tr"+edit_index+" td:nth-child(4)").html(fourth);
      }
  });


});


$("#myRelTable").keyup(".org_relclient_search", function(){

    var search_value  = $("#editrelname").val();
    var client_type   = $("#search_client_type").val();
    console.log(search_value+", "+client_type);
    if(search_value == ""){
      $(".search_relation").hide();
    }else{
      $.ajax({
        type: "POST",
        dataType: "json",
        //url: '/search/search-client',
        url: '/search/search-all-client',
        data: { 'search_value' : search_value, 'client_type' : client_type },
        success : function(resp){
          if (resp.length != 0) {
            var content = '<ul>';
            $.each(resp, function(key){
              content+= "<li class='putClientName' data-client_name='"+resp[key].client_name+"' data-client_id='"+resp[key].client_id+"'>"+resp[key].client_name+"</li>";
              //console.log(resp[key].client_name); 
            });

            content+= '</ul>';

            $(".search_relation").html(content);
            $(".search_relation").show();
          }
          
        }
      });

    }
  });

$("#myRelTable").on("click", ".rel_save", function(){
  var edit_index  = $(this).data("edit_index");

  // Edit client option dropdown start //
  var edit_client_id  = $(this).data("rel_client_id");
  $("#acting_client_id option[value='" + edit_client_id + "']").remove();
  // Edit client option dropdown start //

  var app_date = "";

  var rel_client_id = $("#edit_rel_client_id").val();
  var action  = '<a href="javascript:void(0)" class="edit_rel" data-rel_client_id="'+rel_client_id+'" data-edit_index="'+edit_index+'"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete_rel" data-delete_index="'+edit_index+'"><i class="fa fa-trash-o fa-fw"></i></a>'
  var type_id = $("#edit_rel_type_id").val();

  if(relationship_array.length > 0){
    for (var j = 0; j < relationship_array.length; j++) { 
        //console.log(relationship_array[j]) + "<br>";
        var element     = relationship_array[j];
        var rand_value  = element.split("mpm");
        if(rand_value[0] == edit_index){
          var string = edit_index+"mpm"+type_id+"mpm"+rel_client_id;
          relationship_array[j] = string;
          break;
        }
    }
  }

  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/individual/save-relationship',
    data: { 'rel_client_id' : rel_client_id, 'rel_type_id' : type_id },
    success : function(resp){
      var name = "";
      if(resp['client_details']['business_name'] !== undefined ){
        name = resp['client_details']['business_name'];
      }else{
        name = resp['client_details']['client_name'];
      }
      $('#app_hidd_array').val(relationship_array);
      $("#added_tr"+edit_index+" td:nth-child(1)").html(name);
      $("#added_tr"+edit_index+" td:nth-child(2)").html(resp['relation_type']);
      $("#added_tr"+edit_index+" td:nth-child(4)").html(action);

      $('#acting_client_id').append($('<option>', {
          value: rel_client_id,
          text: name
      }));

    }
  });
  
    
});


// Delete relationship while edit client start //
$("#myRelTable").on("click", ".delete_database_rel", function(){
//$(".delete_database_rel").click(function(){
  var delete_index    = $(this).data("delete_index");
  var client_type     = $("#search_client_type").val();
  var rel_client_id   = $(this).data("rel_client_id");
  var contact_type    = $(this).data("contact_type");

  if(confirm("Do you want to delete?"))
  {
    $.ajax({
      type: "POST",
      url: '/client/delete-relationship',
      data: { 'delete_index':delete_index, 'client_type':client_type, 'contact_type':contact_type },
      success : function(resp){
        if(resp > 0){
          $("#database_tr"+delete_index+'_'+contact_type).hide();
          $("#acting_client_id option[value='"+rel_client_id+"']").remove();
        }
          
      }
    });
  }
  
});
// Delete relationship while edit client end //

// Delete Acting Client while edit client start //
$(".delete_database_acting").click(function(){
  var delete_index  = $(this).data("delete_index");

  var acting_client_id = $(this).data('acting_client_id');
  var client_name = $("#rel_client_id option[value='"+acting_client_id+"']").text();
  
  if(confirm("Do you want to delete?"))
  {
    $.ajax({
      type: "POST",
      url: '/client/delete-acting',
      data: { 'delete_index' : delete_index },
      success : function(resp){
        if(resp > 0){
          $("#database_acting_tr"+delete_index).hide(); 
          $('#acting_client_id').append($('<option>', {
              value: acting_client_id,
              text: client_name
          })); 
        }else{
          alert("Acting client is not deleted");
        }
          
      }
    });
  }
  
});
// Delete Acting Client while edit client end //

// Edit relationship while edit client start //
$("#myRelTable").on("click", ".edit_database_rel", function(){
  var edit_index    = $(this).data("edit_index");
  var client_id     = $(this).data("officer_id");
  var client_type   = $("#search_client_type").val();
  if(client_type == 'org'){
    var text_class  = 'org_relclient_search';
  }else{
    var text_class  = 'all_relclient_search';
  }

  var name      = $("#database_tr"+edit_index+" td:nth-child(1)").html();
  var app_date  = $("#database_tr"+edit_index+" td:nth-child(2)").html();
  var rel_type  = $("#database_tr"+edit_index+" td:nth-child(3)").html();

  var first_name = '<input type="text" placeholder="Search..." value="'+name+'" class="form-control '+text_class+'" id="editrelname" name="editrelname"><div class="search_relation show_search_client" id="show_search_client"></div>';
  var second_date = '<input type="text" id="edit_app_date" value="'+app_date+'" name="edit_app_date" class="form-control app_date edit_app_date">';
  var action = '<button class="btn btn-success database_rel_save" data-edit_index="'+edit_index+'" data-client_id="'+client_id+'" type="button">Save</button>';

  $.ajax({
      type: "POST",
      url: '/client/edit-relation-type',
      data: { 'relation_type' : rel_type, 'client_type' : client_type },
      success : function(resp){
        $("#database_tr"+edit_index+" td:nth-child(1)").html(first_name);
        $("#database_tr"+edit_index+" td:nth-child(2)").html(second_date);
        $("#database_tr"+edit_index+" td:nth-child(3)").html(resp);

        if(client_type == 'ind'){
          $("#database_tr"+edit_index+" td:nth-child(5)").html(action);
          $("#rel_acting_"+client_id).iCheck('enable');
        }else{
          $("#database_tr"+edit_index+" td:nth-child(4)").html(action);
        }

      }
  });


});
// Edit relationship while edit client end //


// Edit Acting client while edit client start //
$("#myActTable").on("click", ".edit_database_acting", function(){
  var link              = $(this).data("link");
  var edit_index        = $(this).data("edit_index");
  var acting_client_id  = $(this).data("acting_client_id");
  
  var first_value = $("#new_relationship_acting #acting_client_id").html();
  var name_dropdown = '<select class="form-control" name="edit_act_client_id" id="edit_act_client_id">';
  name_dropdown += first_value+"</select>";

  var action = '<button class="btn btn-success database_acting_save" data-edit_index="'+edit_index+'" data-link="'+link+'" type="button">Save</button>';
  
  $("#database_acting_tr"+edit_index+" td:nth-child(1)").html(name_dropdown);
  $("#database_acting_tr"+edit_index+" td:nth-child(1) > select").val(acting_client_id)
  $("#database_acting_tr"+edit_index+" td:nth-child(2)").html(action);


});
// Edit acting client while edit client end //

// Save relationship while edit client start //
$("#myRelTable").on("click", ".database_rel_save", function(){
  var edit_index    = $(this).data("edit_index");
  var client_id = $(this).data("client_id");
  var first_value   = $("#editrelname").val();
  var rel_type_id   = $("#edit_rel_type_id").val();
  var fourth  = '<a href="javascript:void(0)" class="edit_database_rel" data-edit_index="'+edit_index+'" data-officer_id="'+client_id+'"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete_database_rel" data-delete_index="'+edit_index+'"><i class="fa fa-trash-o fa-fw"></i></a>';

  var rel_client_id = $("#rel_client_id").val();
  var app_date      = $(".edit_app_date").val();
  var type_id       = $("#edit_rel_type_id").val();
  //var acting    = $("#database_tr"+edit_index+" td:nth-child(4)").html();

  
  var client_type = "chd";
  var acting = "N";
  if($('#rel_acting_'+client_id).prop("checked") == true){
    client_type = "change";
    var acting = "Y";
  }
//alert(client_id+", "+client_type);return false;
  $.ajax({
    type: "POST",
    url: '/client/save-database-relationship',
    data: { 'acting':acting, 'client_type':client_type, "name":first_value, 'client_id':client_id, 'edit_id':edit_index, 'app_date':app_date, 'rel_client_id':rel_client_id, "rel_type_id":rel_type_id },
    success : function(resp){//alert(client_type);return false;
      $("#database_tr"+edit_index+" td:nth-child(1)").html(first_value);
      $("#database_tr"+edit_index+" td:nth-child(2)").html(app_date);
      $("#database_tr"+edit_index+" td:nth-child(3)").html(resp);
      
      if(client_type == 'ind'){
        $("#database_tr"+edit_index+" td:nth-child(5)").html(fourth);
        $("#rel_acting_"+client_id).iCheck('disable');
      }else{
        $("#database_tr"+edit_index+" td:nth-child(4)").html(fourth);
      }
      
    }
  });

});
// Save relationship while edit client end //

// Save Acting while edit client start //
$("#myActTable").on("click", ".database_acting_save", function(){
  var edit_index  = $(this).data("edit_index");
  var link  = $(this).data("link");
  var acting_client_id  = $("#edit_act_client_id").val();
  var action  = '<a href="javascript:void(0)" class="edit_database_acting" data-acting_client_id="'+acting_client_id+'" data-edit_index="'+edit_index+'"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete_database_acting" data-delete_index="'+edit_index+'"><i class="fa fa-trash-o fa-fw"></i></a>';

  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/client/save-database-acting',
    data: { 'acting_client_id' : acting_client_id, 'acting_id' : edit_index },
    success : function(resp){
      $("#database_acting_tr"+edit_index+" td:nth-child(1)").html('<a href="'+link+'" target="_blank">'+resp['name']+'</a>');
      $("#database_acting_tr"+edit_index+" td:nth-child(2)").html(action);
    }
  });

});
// Save Acting while edit client end //


// Relationship checkbox click to open acting function start //
  $("#myRelTable").on("click", ".acting_check", function(){
    if($(this).is(':checked')){
      $("#new_relationship_acting").show();
      $("#acting_client_id").val($("#acting_client_id option:first").val());
      $("#relation_index").val($(this).data("edit_index"));
    }else{
      $("#new_relationship_acting").hide();
    }
  });
// Relationship checkbox click to open acting function end //  


// Delete Acting while adding client start //
$("#myActTable").on("click", ".delete_acting", function(){
  var delete_index       = $(this).data("delete_index");

  var acting_client_id = $(this).data('acting_client_id');
  var client_name = $("#rel_client_id option[value='"+acting_client_id+"']").text();console.log(client_name)
  $('#acting_client_id').append($('<option>', {
      value: acting_client_id,
      text: client_name
  }));

  if(acting_array.length > 0){
    for (var k = 0; k < acting_array.length; k++) { 
        var element     = acting_array[k];
        var rand_value  = element.split("mpm");
        if(rand_value[0] == delete_index){
          acting_array.splice(k, 1);
          break;
        }
    }
  }
  
  $('#acting_hidd_array').val(acting_array);
  $("#added_acting_tr"+delete_index).hide();
  
});
// Delete Acting while adding client end //

// Edit Acting while adding client end //
$("#myActTable").on("click", ".edit_acting", function(){
  var edit_index  = $(this).data("edit_index");
  var link  = $(this).data("link");
  var acting_client_id  = $(this).data("acting_client_id");

  var first_value = $("#new_relationship_acting #acting_client_id").html();
  var name_dropdown = '<select class="form-control" name="edit_act_client_id" id="edit_act_client_id">';
  name_dropdown += first_value+"</select>";

  var action = '<button class="btn btn-success acting_save" data-edit_index="'+edit_index+'" data-link="'+link+'" type="button">Save</button>';

  $("#added_acting_tr"+edit_index+" td:nth-child(1)").html(name_dropdown);
  $("#added_acting_tr"+edit_index+" td:nth-child(1) > select").val(acting_client_id)
  $("#added_acting_tr"+edit_index+" td:nth-child(2)").html(action);
});
// Edit Acting while adding client end //


// Save Acting while adding client start //
$("#myActTable").on("click", ".acting_save", function(){
  var edit_index  = $(this).data("edit_index");

  var relation_index      = $('#relation_index').val();
  var relation_client_id  = $('#acting_'+relation_index).data('rel_client_id');

  var acting_client_id = $("#edit_act_client_id").val();
  var action  = '<a href="javascript:void(0)" class="edit_acting" data-acting_client_id="'+acting_client_id+'" data-edit_index="'+edit_index+'"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete_acting" data-delete_index="'+edit_index+'"><i class="fa fa-trash-o fa-fw"></i></a>';

  if(acting_array.length > 0){
    for (var j = 0; j < acting_array.length; j++) { 
        var element     = acting_array[j];
        var rand_value  = element.split("mpm");
        if(rand_value[0] == edit_index){
          var string = edit_index+"mpm"+acting_client_id+"mpm"+relation_client_id;
          acting_array[j] = string;
          break;
        }
    }
  }

  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/client/acting-relationship',
    data: { 'acting_client_id' : acting_client_id },
    success : function(resp){
      $('#acting_hidd_array').val(acting_array);
      $("#added_acting_tr"+edit_index+" td:nth-child(1)").html('<a href="'+resp['link']+'" target="_blank">'+resp['name']+'</a>');
      $("#added_acting_tr"+edit_index+" td:nth-child(2)").html(action);
    }
  });
  
    
});
// Edit Acting Save End //


// Add to list in relationship section start //
$(".relation_add_client").click(function(){
  var type          = $("#add_to_type").val();
  var name          = $("#add_to_name").val();
  var title         = $("#add_to_title").val();
  var fname         = $("#add_to_fname").val();
  var mname         = $("#add_to_mname").val();
  var lname         = $("#add_to_lname").val();
  var relation_type = $("#officer_rel__type_id").val();
  var client_id     = $("#client_id").val();

  $.ajax({
      type: "POST",
      url: "/client/add-to-client",
      data: { 'client_id': client_id, 'type': type, 'name': name, 'title': title, 'fname': fname, 'mname': mname, 'lname': lname, 'relation_type': relation_type },
      beforeSend: function() {
          $("#add_to_msg_div").html('<img src="/img/spinner.gif" />');
      },
      success: function (resp) {
        if(resp != 0){
          $("#add_to_msg_div").html("Your details has been added.");

          $("#add_to_name").val("");
          $("#add_to_title").val($("#add_to_title option:first").val());
          $("#add_to_fname").val("");
          $("#add_to_mname").val("");
          $("#add_to_lname").val("");


          $('#rel_type_id').val(relation_type);
          $('#non_rel_client_id').val(resp);

          $('#addOtherEntity').val('other_entity');
          saveRelationship('add_org');


        }else{
          $("#add_to_msg_div").html("There are some errot to add the client");
        }
        
      }
  });

});
// Add to list in relationship section end // 


// Click Add To Link button to open acting function start //
  $(".open_acting").click(function(){
    $("#new_relationship_acting").show();

    /*var first_value = $("#new_relationship_acting #acting_client_id").html();
    var name_dropdown = '<select class="form-control" name="edit_act_client_id" id="edit_act_client_id">';
    name_dropdown += first_value+"</select>";*/

    if(acting_array.length > 0){
      for (var j = 0; j < acting_array.length; j++) { 
          var element     = acting_array[j];
          var rand_value  = element.split("mpm");
          $('#acting_client_id option[value="'+rand_value[1]+'"]').remove();
      }
    }
    

      $("#new_relationship_acting #acting_client_id").val($("#acting_client_id option:first").val());
      $("#relation_index").val($(this).data("edit_index"));
  });
// Click Add To Link button to open acting function end //   

// Click Add To Link button to close acting function start //
  $(".close_acting").click(function(){
    $("#acting_client_id").val($("#acting_client_id option:first").val());
    $("#new_relationship_acting").hide();
  });
// Click Add To Link button to close acting function end // 


// Add new entity dropdown start //
  /*$(".add_new_entity").change(function(){
    var value = $(this).val();
    if (value == "org") {
      window.open('/organisation-clients', '_blank');
    }else if(value == "ind"){
      window.open('/individual-clients', '_blank');
    }else if(value == "non"){
      $('#add_to_list-modal').modal("show");
    }
  });*/

  $(document).click(function() {
    $(".open_toggle").hide();
  });
  $("#select_icon").click(function(event) {
      $(".open_toggle").toggle();
      event.stopPropagation();
  });

  $(".open_toggle li").click(function(event) {
    var value = $(this).data("value");
    if (value == "org") {
      window.open('/organisation-clients', '_blank');
    }else if(value == "ind"){
      window.open('/individual-clients', '_blank');
    }else if(value == "non"){
      $('#add_to_list-modal').modal("show");
    }
  });

  $(".add_other_entities").click(function(event) {
    $('#add_to_list-modal').modal("show");
  });
// Add new entity dropdown end // 


// Add to client from relationship non client select start //
$("#add_to_type").change(function(){
    var value = $(this).val();
    if (value == "org") {
      $("#add_to_client_text").hide();
      $("#add_to_business").show();
    }else if(value == "ind"){
      $("#add_to_business").hide();
      $("#add_to_client_text").show();
    }
  });
// Add to client from relationship non client select end //


// Other section in individual select start //
$("body").on("click", ".delete_invited_client", function(){
    var user_id   = $(this).data('user_id');
    var client_id = $(this).data('client_id');
    if(confirm("Do you want to delete the user?")){
      $.ajax({
        type: "POST",
        url: "/user/delete-user-client",
        data: { 'user_id': user_id, 'client_id': client_id },
        success: function (resp) {
          if(resp == 1){
            $("#other_action_tr").html('');
            $('#after_send_'+client_id).html('<button type="button" class="job_send_btn invite_send_popup" data-client_id="'+client_id+'" data-send_type="single" data-client_type="ind" data-status="invite">INVITE</button>');
          }
        }
      });
    }
    
});
// Other section in individual select end //

//##############User active/Inactive Portion start ################//
  $("body").on("click", "#client_user_status", function(){
      var user_id = $(this).data('user_id');
      var status = $(this).data('status');
      
      //alert(status);return false;
    if(user_id >0 ){
      if(confirm("Do you want to change the status?")){
        $.ajax({
            type: "POST",
            url: '/update-status',
            data: { 'user_id' : user_id, 'status' : status },
            success : function(resp){
              $('#client_user_status').html(resp);
            }
        });
      }

    }else{
      alert('This is invalid user');
    }
  });
  //##############User active/Inactive Portion start ################//

  $('#showclientuser').on('ifChecked', function(event){
    $("#show_other_user_client").show();
  });

  $('#showclientuser').on('ifUnchecked', function(event){
    $("#show_other_user_client").hide();
  });
  /*$('#showclientuser').click(function(event){
      $("#show_other_user_client").toggle();
  });*/
//############## Change user relation status  in the other Portion start ################//
  $('.user_client_relation').on('ifChecked', function(event){
    var related_company_id = $(this).data('related_company_id');
    $.ajax({
        type: "POST",
        url: '/user/update-related-company-status',
        data: { 'related_company_id' : related_company_id, 'status' : "A" },
        success : function(resp){
          //$('#client_user_status').html(resp);
        }
    });
  });

  $('.user_client_relation').on('ifUnchecked', function(event){
    var related_company_id = $(this).data('related_company_id');
    $.ajax({
        type: "POST",
        url: '/user/update-related-company-status',
        data: { 'related_company_id' : related_company_id, 'status' : "I" },
        success : function(resp){
          //$('#client_user_status').html(resp);
        }
    });
  });
//############## Change user relation status  in the other Portion end ################//

//##############User active/Inactive Portion start ################//
$("#other_upload_table").on("click", ".delete_files", function(){
  //$('.delete_files').click(function() {
    var column = $(this).data('column');
    var client_id = $("#client_id").val();
    var path = $(this).data('path');
      
      //alert(status);return false;
    if(client_id >0 ){
      if(confirm("Do you want to delete the file?")){
        $.ajax({
            type: "POST",
            url: '/client/delete-files',
            data: { 'column' : column, 'client_id' : client_id, 'path' : path },
            success : function(resp){
              $('#a'+column).hide();
            }
        });
      }

    }else{
      alert('This is invalid user');
    }
  });
  //##############User active/Inactive Portion start ################//

  //Add Services while add individual/organisation user start
  $("#save_services").click(function(){
      var service_name  = $("#service_name").val();
      var client_type   = $("#client_type").val();
      var client_id     = $("#client_id").val();
      var client_name   = $("#client_name").val();
     // console.log('service_name:'+service_name+'client_type'+client_type+'client_id'+client_id)
      
      $.ajax({
        type: "POST",
        url: '/client/add-services',
        dataType : 'json',
        data: { 'service_name' : service_name, 'client_type' : client_type, 'client_id' : client_id },
        beforeSend : function(){
          $(".loader_show").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          $(".loader_show").html('');
          var field_id = resp['last_id'];
          var content = "";
          content += '<tr id="hide_service_tr_'+field_id+'">';
          content += '<td align="center"><span class="custom_chk chk_fixed">';
          content += '<input type="checkbox" value="'+field_id+'" checked id="srvs_'+field_id+'" /><label style="width:0px!important" for="srvs_'+field_id+'">&nbsp;</label></span></td>';
          content += '<td><strong>'+service_name+'</strong></td>';
          content += '<td class="'+client_id+'_staff_table_drop_'+field_id+'"></td>';
          content += '<td align="center"><a href="javascript:void(0);" class="" data-service_id="'+field_id+'" data-client_id="'+client_id+'" data-service_name="'+service_name+'" data-client_name="'+client_name+'" data-page="edit_client" data-client_type="'+client_type+'">Edit</a></td>';

          $("#myServTable").last().append(content);

          var append = "";
          append += '<div class="pop_list form-group" id="hide_service_div_'+field_id+'">';
          append += '<a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_services" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a>'+service_name+'</div>';
          $("#append_services").last().append(append);

          $("#service_name").val("");
          //$("#service_id").append('<option value="'+field_id+'">'+service_name+'</option>');

        }
      });
  });
  //Add Services while add individual/organisation user end

  //Delete services name while add individual/organisation user start
  $("body").on("click", ".delete_services", function(){
    var field_id = $(this).data('field_id');
    if (confirm("Do you want to delete this field ?")) {
      $.ajax({
        type: "POST",
        url: '/client/delete-services',
        data: { 'field_id' : field_id },
        success : function(resp){
          if(resp != ""){
            $("#hide_service_div_"+field_id).hide();
            $("#hide_service_tr_"+field_id).hide();
            //$("#service_id option[value='"+field_id+"']").remove();
          }else{
            alert("There are some error to delete this service, Please try again");
          }
        }
      });
    }
    
  }); 
  //Delete services name while add individual/organisation user end

  /* ################# SYNC data in job section start ################### */
  $(".sync_jobs_data").click(function(){
    var val = [];
    //alert('val');return false;
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    //alert(val.length);return false;
    if(val.length>0){
      var client_type = $("#client_type").val();
      $.ajax({
        type: "POST",
        url: '/jobs/sync-jobs-clients',
        data: { 'client_ids' : val },
        beforeSend : function(){
          $(".sync_jobs_data").attr('disabled', 'disabled');
          $("#message_div").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          if(client_type == "org"){
            $("#message_div").html('');
            $(".sync_jobs_data").attr('disabled', false);
            refresh_table();
            //window.location = '/organisation-clients';
          }
        }
      });
    }else{
      alert('Please select atleast one client');
    }
  });
  /* ################# SYNC data in job section end ################### */

  /*$(".for_autologin").on('ifChecked', function(event){
    $('.for_autologin').iCheck('disable');
    $(this).iCheck('enable');
    $('#allCheckSelect').iCheck('disable');
  });

  $(".for_autologin").on('ifUnchecked', function(event){
    $('.for_autologin').iCheck('enable');
    $('#allCheckSelect').iCheck('enable');
    
  });*/
/* ################# Auto login start ################### */
  $('.autologin_button').click(function(event){
    var val = [];
    $(".for_autologin:checked").each( function (i) {
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
      $.ajax({
        type: "POST",
        url: '/client/ajax-client-details',
        dataType: 'json',
        data: { 'client_id' : val[0] },
        success : function(resp){
          if(resp.ch_username == "" || resp.ch_password == ""){
            alert("Please enter the Companies' house logins detail under practice settings");
            return false;
          }else{
            if(resp.ch_auth_code === undefined){
              var ch_auth_code = '123456';
            }else{
              var ch_auth_code = resp.ch_auth_code;
            }
            window.open('/chdata/autologin/'+resp.registration_number+'/'+ch_auth_code, '_blank');
          }
        }
      });
    }
  });
/* ################# Auto login end ################### */

/* ################# INVITE TO CLIENT USER ################### */
  $('body').on('click', '.invite_send_popup', function(){  
    var client_id   = $(this).data('client_id');
    var client_type = $(this).data('client_type');
    var send_type   = $(this).data('send_type');
    $.ajax({
        type: "POST",
        url: '/client/invite-client-action',
        dataType: 'json',
        data: { 'client_id':client_id, 'client_type':client_type, 'send_type':send_type, 'action':'getDetails' },
        beforeSend : function(){
            $('#client_id').val(client_id);
            $(".show_org_client ul").html('');
            $('#pop_client_name').html('');
            $('#client_email').val('');
            $('#invite_client-modal').modal('show');
            $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
            $(".show_loader").html('');
            $('#pop_client_name').html(resp.client_name);
            $('#client_email').val(resp.email);
            
            var content = '';
            if (resp.relation.length > 0) {
              $.each(resp.relation, function(key, value){//console.log(resp.relation[key].client_name);
                content+= '<li><div class="job_checkbox"><span class="custom_chk">';
                content+= '<input type="checkbox" class="ads_Checkbox" value="'+resp.relation[key].client_id+'" name="related_client[]" id="'+key+'">';
                content+= '<label for="'+key+'" style="width: 290px!important;margin-top: 0px;">';
                content+= '<a href="#" class="hover">'+resp.relation[key].client_name+'</a></label></span></div></li>';
              });
            }
            $(".show_org_client ul").html(content);
        }
    });
  });
  
  $('.invite_client').click(function(){
    var client_id       = $('#client_id').val();
    var section         = $('#section').val();
    var user_type       = $('#user_type').val();
    var client_email    = $('#client_email').val();
    var related_client = [];
    $(".ads_Checkbox:checked").each( function (i) {
        if($(this).is(':checked')){
            related_client[i] = $(this).val();
        }
    });
    //console.log(related_client);return false;
    $.ajax({
        type: "POST",
        url: '/user_process',
        //dataType: 'json',
        data: { 'client_id':client_id, 'section':section, 'user_type':user_type, 'client_email':client_email, 'related_client':related_client },
        beforeSend : function(){
            $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
            $(".show_loader").html('');
            if(resp == 'email_blank'){
                $(".show_loader").html('<p style="color:red">Please enter email address</p>');
            }else if(resp == 'email_exists'){
                $(".show_loader").html('<p style="color:red">The email is already exists, please check with different email.</p>');
            }else{
                $(".show_loader").html('<p style="color:green">The email has been sent to the new user.</p>');
                $('#after_send_'+client_id).html('<button type="button" class="job_send_btn invited_popup" data-client_id="'+client_id+'" data-send_type="single" data-client_type="ind" data-status="pending">PENDING</button>');
            }
        }
    });
  });
  
  $('body').on('click', '.invited_popup', function(){
    var client_id   = $(this).data('client_id');
    var status      = $(this).data('status');
    
    $.ajax({
        type: "POST",
        url: '/user/invited-user-action',
        dataType: 'json',
        data: { 'client_id':client_id, 'action':'userDetails' },
        beforeSend : function(){
            $(".show_loader").html('<img src="/img/spinner.gif" />');
            $('#other_action_tr').html('');
            $('#invited_send-modal').modal('show');
        },
        success : function(resp){
            if(status == 'invited'){
                var show_pass = '********';
            }else{
                var show_pass = resp.details.show_pass;
            }
            $(".show_loader").html('');
            var content = '';
            content += '<td align="center">'+resp.details.email+'</td><td align="center">'+show_pass+'</td>';
            content += '<td align="center"><a href="javascript:void(0)" class="relation_pop" data-client_id="'+resp.details.client_id+'">View</a></td>';
            content += '<td align="center"><a href="javascript:void(0)" data-user_id="'+resp.details.user_id+'" data-client_id="'+resp.details.client_id+'" class="active_t" data-status="A" id="client_user_status">Active</a></td>';
            content += '<td align="center"><a href="javascript:void(0)" data-user_id="'+resp.details.user_id+'" data-client_id="'+resp.details.client_id+'" class="delete_invited_client"><img src="/img/cross.png" height="15"></a></td>';
            $('#other_action_tr').html(content);
            
            /* ============= Relation Show ============== */
            var content = '<ul>';
            if (resp.relation.length > 0) {
              $.each(resp.relation, function(key, value){
                  var checked = '';
                  if(resp.relation[key].status == 'A'){
                      checked = 'checked';
                  }
                content+= '<li><div class="job_checkbox"><span class="custom_chk">';
                content+= '<input type="checkbox" class="ads_Checkbox change_relation_status" data-user_id="'+resp.details.user_id+'" value="'+resp.relation[key].client_id+'" name="related_client" id="'+key+'" '+checked+'>';
                content+= '<label for="'+key+'" style="width: 290px!important;margin-top: 0px;">';
                content+= '<a href="#" class="hover">'+resp.relation[key].client_name+'</a></label></span></div></li>';
              });
              content+= '</ul>';
            }
            $("#show_related_div").html(content);
            
            
        }
    });
  });
  
  $('body').on('click', '.relation_pop', function(){
    var client_id = $(this).data('client_id');
    $('#relation_pop-modal').modal('show');
  });
  
  $('body').on('click', '.change_relation_status', function(event){
      var client_id   = $(this).val();
      var user_id     = $(this).data('user_id');
      
      if($(this).is(':checked')){
          var status = 'A';
      }else{
          var status = 'I';
      }
      $.ajax({
          type: "POST",
          url: '/user/invited-user-action',
          dataType: 'json',
          data: { 'client_id':client_id, 'user_id':user_id, 'status':status, 'action':'relationStatusChange' },
          success : function(resp){
              
          }
      });
  });

  $('body').on('click', '.newAddress', function(){
    var address_type  = $(this).data('address_type');
    var page_name     = $(this).data('page_name');
    $('#address_type').val(address_type);
    $('#address_id').val('0');
    $('#address_page_open').val(page_name);

    refreshAddressField();

    $('#new-address-modal').modal('show');
  });

    $('body').on('click', '.editAddress', function(){
    var address_type  = $(this).data('address_type');
    var page_name     = $(this).data('page_name');
    $('#address_page_open').val(page_name);

    var address_id    = $('#'+address_type+'_address').val();
    if(address_id == ''){
      alert('Please select any address from the dropdown to edit');
      return false;
    }else{

      $.ajax({
        type: "POST",
        url: '/client/gat-client-address-by-id',
        dataType: 'json',
        data: { 'address_id':address_id },
        beforeSend : function(){
          refreshAddressField();
        },
        success : function(resp){//alert(resp.address.address1);
          $('#address1').val(resp.address.address1);
          $('#address2').val(resp.address.address2);
          $('#address_city').val(resp.address.city);
          $('#address_county').val(resp.address.county);
          $('#address_postcode').val(resp.address.postcode);
          $('#address_country').val(resp.address.country);

          $('#address_type').val(address_type);
          $('#address_id').val(address_id);
          $('#new-address-modal').modal('show');
        }
      });
    }
  });

  $('body').on('click', '.save_new_address', function(){
    var address_type = $('#address_type').val();
    var address_id = $('#'+address_type+'_address').val();
    var editaddress_id = $('#address_id').val();

    if(editaddress_id == '0'){
      $("#address_form").ajaxForm({
        dataType: 'json',
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function(resp) {
          refreshAddressField();
          if(resp.message == 'success'){
            $('#new-address-modal').modal('hide');
            var option = '<option value="'+resp.address_id+'">'+resp.address1+', '+resp.address2+', '+resp.city+', '+resp.county+', '+resp.postcode+', '+resp.country_name+'</option>';
            $('.get_orgoldcont_address').append(option);
          }else{
            $(".show_loader").html('<span style="color:red">Address exists please select from drop down</span>');
          }
          
        }
      }).submit();
    }else{
      if(confirm('Please note deleting/editing this address will affect all clients sharing this address')){
          $("#address_form").ajaxForm({
            dataType: 'json',
            beforeSend : function(){
              $(".show_loader").html('<img src="/img/spinner.gif" />');
            },
            success: function(resp) {
              $(".show_loader").html('');
              if(resp.message == 'success'){
                $('#new-address-modal').modal('hide');
                var option = resp.address1+', '+resp.address2+', '+resp.city+', '+resp.county+', '+resp.postcode+', '+resp.country_name;
                $(".get_orgoldcont_address option[value='"+address_id+"']").text(option);
              }else{
                $(".show_loader").html('<span style="color:red">Address exists please select from drop down</span>');
              }
              
            }
          }).submit();
      }
    }
  });

  
  $('body').on('click', '.deleteAddress', function(){
      var type  = $(this).data('address_type');
      var address_id = $('#'+type+'_address').val();//alert(address_id+'=='address_type)
      if(address_id == ''){
        alert('Please select address to delete');
        return false;
      }else{
        if(confirm('Please note deleting/editing this address will affect all clients sharing this address')){
          $.ajax({
            type: "POST",
            url: '/client/delete-client-address',
            //dataType: 'json',
            data: { 'address_id':address_id },
            success : function(resp){
              if(resp == 1){
                $(".get_orgoldcont_address option[value='" + address_id + "']").remove();
                //refreshAddressField();
              }
            }
          });
        }
      }
  });

  $('body').on('click', '.copyAddress', function(){
    var address_type  = $(this).data('address_type');
    var address_id    = $('#'+address_type+'_address').val();
    if(address_id == ""){
      alert('Please select any address from the dropdown to view');
      return false;
    }else{
      var address = $('#'+address_type+"_address option[value='"+address_id+"']").text();
      $("#show_full_address").html(address);

      $('#full_address-modal').modal('show');
    }
    
  });

  $('body').on('click', '.activity_history', function(){
    var client_name = $('#client_name').val();
    $('#activity_history-modal .modal-title').html(client_name);

    $('#activity_history-modal').modal('show');
    refresh_table();
  });

  $('body').on('click', '.activity_notes', function(){
    var store_id  = $(this).attr('data-store_id');
    var notes     = $(this).attr('data-notes');

    $('#activity_notes-modal #store_id').val(store_id);
    $('#activity_notes-modal #activity_notes').val(notes);
    $('#activity_notes-modal').modal('show');
  });

  $('body').on('click', '.saveActivityNotes', function(){
    var store_id  = $('#store_id').val();
    var notes     = $('#activity_notes').val();
    if(notes == ''){
      alert('Please enter notes');
      return false;
    }else{
      $.ajax({
        type: "POST",
        url: '/client/store-data-action',
        data: { 'notes':notes, 'store_id':store_id, 'action':'notes_update' },
        success : function(resp){
          refresh_table();
          $('#activity_notes-modal').modal('hide');
        }
      });
    }
  });

  $('body').on('change', '.Pcontacts', function(event){
    var value   = $(this).val();

    
    if(value == ''){
      $('#contactmobile, #contactemail, #contacttelephone').val('');
    }else{
      var dropVal       = value.split('_');
      var contact_id    = dropVal[0];
      var address_type  = dropVal[1];

      $.ajax({
        type: "POST",
        url: '/client/action',
        dataType: 'json',
        data: { 'contact_id':contact_id, 'address_type':address_type, 'action':'getContactById' },
        success : function(resp){
          var d = resp.details;
          var mobile = email = telephone = '';
          if(address_type == 'C'){
            var mobile    = d.mobile;
            var email     = d.email;
            var telephone = d.telephone;
          }else{
            var mobile    = d.res_mobile;
            var email     = d.res_email;
            var telephone = d.res_telephone;
          }
          $('#contactmobile').val(mobile);
          $('#contactemail').val(email);
          $('#contacttelephone').val(telephone);
        }
      });
    }
    
  });




  

});//end of main document ready





function refreshAddressField()
{
  $(".show_loader").html('');
  $('#address1').val('');
  $('#address2').val('');
  $('#address_city').val('');
  $('#address_county').val('');
  $('#address_postcode').val('');
  $('#address_country').val('225');
}

function show_div()
{
  var edit_client_id = $("#client_id").val();
  $.ajax({
    type: "POST",
    url: "/client/get-name-and-type",
    dataType: "json",
    //data: { 'add_to_type': add_to_type, 'add_to_name': add_to_name },
    beforeSend: function() {
        //$("#add_to_msg_div").html('<img src="/img/spinner.gif" />');
    },
    success: function (resp) {
      if(resp['allClients'].length > 0){
        var option = '';
        for (var j = 0; j < resp['allClients'].length; j++) { 
          var client_id     = resp['allClients'][j].client_id;
          var client_name   = resp['allClients'][j].client_name;
          if(client_id != "" && client_name != ""){
            option += '<option value="'+client_id+'">'+client_name+'</option>';
          }
        }
      }//alert(option);
      $("#rel_client_id").html(option);
      
    }
  });

  $("#rel_type_id").val($("#rel_type_id option:first").val());
  $("#rel_client_id").val($("#rel_client_id option:first").val());
  $("#new_relationship").show();
}

function hide_relationship_div()
{
  $("#new_relationship").hide();
}

var relationship_array = [];
var i = 0;
function saveRelationship(process_type)
{
  if($('#non_rel_client_id').val() != ""){
    var rel_client_id = $('#non_rel_client_id').val();
  }else{
    var rel_client_id = $('#rel_client_id').val();
  }

    var rel_type_id = $('#rel_type_id').val();

    var client_id = $('#client_id').val();
    //alert(rel_client_id+"etet"+rel_type_id);
    //var rel_client_id = $('#rel_client_id').val();
    //var checkbox = '<span class="custom_chk"><input type="checkbox" class="acting_check" value="Y" name="acting_'+i+'" id="acting_'+i+'" data-edit_index="'+i+'" data-rel_client_id="'+rel_client_id+'"/><label for="acting_'+i+'"></label></span>';

    if(rel_client_id == ""){
      alert("Please select business name/name");
      return false;
    }else{
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/individual/save-relationship',
        data: { 'rel_type_id' : rel_type_id, 'rel_client_id' : rel_client_id, 'client_id':client_id },
        beforeSend: function() {
            $('#non_rel_client_id').val("");
        },
        success : function(resp){ //console.log(resp.client_relship_id)
          var client_relship_id = resp.client_relship_id;
          if(client_relship_id > 0){
            //location.reload();
          }
          var name = "";
          var disable_click = '';
          if(resp['client_details']['business_name'] !== undefined ){
            name = resp['client_details']['business_name'];
            disable_click = 'disable_click';
          }else{
            name = resp['client_details']['client_name'];
          }

          if(resp['client_details']['type'] != "non"){
            name = '<a href="'+resp['client_details']['link']+'" target="_blank">'+name+'</a>';
          }
          var content = "";
          content += '<tr id="added_tr'+i+'"><td width="40%">'+name+'</td>';
          content += '<td width="40%" align="center">'+resp['relation_type']+'</td>';
          //content += '<td width="10%" align="center">'+checkbox+'</td>';
          //content += '<td width="20%" align="center"><a href="javascript:void(0)" class="edit_rel" data-rel_client_id="'+rel_client_id+'" data-edit_index="'+i+'" data-link="'+resp['link']+'"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" data-rel_client_id="'+rel_client_id+'" class="delete_rel" data-delete_index="'+i+'"><i class="fa fa-trash-o fa-fw"></i></a></td></tr>';
          content += '<td width="20%" align="center">\
              <div class="action_box">\
                <a href="javascript:void(0)" class="editContactRelation '+disable_click+'" data-id="'+rel_client_id+'_R" data-copy_from="edit_org">Edit</a> | \
                <a href="javascript:void(0)" data-rel_client_id="'+rel_client_id+'" class="delete_rel" data-delete_index="'+i+'">Delete</a> | \
                <a href="javascript:void(0)" class="ViewContactPop" data-id="'+rel_client_id+'_R" data-copy_from="edit_org" data-client_type="'+resp.client_details.type+'">View</a>\
              </div>\
            </td>';

          $("#myRelTable").last().append(content);
          
          var itemselected = i+"mpm"+rel_type_id+"mpm"+rel_client_id;
          if(itemselected !== undefined && itemselected !== null){
              relationship_array.push(itemselected);
          }
        
          $('#app_hidd_array').val(relationship_array);
          $('#relname').val("");
          $("#new_relationship").hide();

          i++;


          /*if(resp['client_details']['is_relation_add'] == "Y" ){
            $('#acting_client_id').append($('<option>', {
              value: rel_client_id,
              text: name
            }));
          }else{
            saveActing("by_own", rel_client_id);
          }*/


        }
      });
    }
    
}

acting_array = [];
var act_i = 0;
function saveActing(status, rel_client_id)
{
  if(status == "by_own"){
    var acting_client_id    = rel_client_id;
  }else{
    var acting_client_id    = $('#acting_client_id').val();
  }
  
  var relation_index      = $('#relation_index').val();
  //var relation_client_id  = $('#acting_'+relation_index).data('rel_client_id');
  
  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/client/acting-relationship',
    data: { 'acting_client_id' : acting_client_id },
    success : function(resp){
      var content = "";
      content += '<tr id="added_acting_tr'+act_i+'"><td width="35%"><a href="'+resp['link']+'" target="_blank">'+resp['name']+'</a></td>';
      //content += '<td width="20%" align="center"><a href="javascript:void(0)" class="edit_acting" data-acting_client_id="'+acting_client_id+'" data-edit_index="'+act_i+'" data-link="'+resp['link']+'"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete_acting" data-delete_index="'+act_i+'"><i class="fa fa-trash-o fa-fw"></i></a></td></tr>';
      content += '<td width="20%" align="center"><a href="javascript:void(0)" class="delete_acting" data-acting_client_id="'+acting_client_id+'" data-delete_index="'+act_i+'"><img src="/img/cross.png" height="15"></a></td>';
      $("#myActTable").last().append(content);

      //var itemselected = act_i+"mpm"+acting_client_id+"mpm"+relation_client_id;
      var itemselected = act_i+"mpm"+acting_client_id;
      if(itemselected !== undefined && itemselected !== null){
          acting_array.push(itemselected);
      }
    
      $('#acting_hidd_array').val(acting_array);
      
      $("#new_relationship_acting").hide();

      act_i++;
    }
  });
}

function archiveClientsFunction(val, status, archive_reason, client_type)
{//alert(archive_reason+""+client_type);return false;
  $.ajax({
    type: "POST",
    url: '/client/archive-client',
    data: { 'client_id':val, 'status':status, 'archive_reason':archive_reason },
    beforeSend: function() {
        $(".show_loader").html('<img src="/img/spinner.gif" />');
    },
    success : function(resp){
      $("#archive_client-modal").modal('hide');
      refresh_table();
      /*if(client_type == "org"){
        window.location = '/organisation-clients';
      }else{
        window.location = '/individual-clients';
      }*/
    }
  });
}