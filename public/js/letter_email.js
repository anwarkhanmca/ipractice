$(document).ready(function (e) {
  /* ================== Pagination Start ==================== */
  $("#results").on( "click", ".pagination1 a", function (e){
    e.preventDefault();
    $(".loading-div").show();//return false;
    var page          = $(this).attr("data-page"); //get page number from link
    var address_type  = $('#address_type').val();
    var per_page      = $('#per_page').val();

    $.ajax({
        type: "POST",
        //dataType : "json",
        url: "/contacts/pagination",
        data: { 'page': page, 'page_name':'org', 'per_page':per_page, 'address_type':address_type },
        success: function (resp) {
          $(".loading-div").hide(); 
          $("#results").html(resp);         
        }
    });
  });
  /* ================== Pagination End ==================== */

  $(document).click(function() {
    $(".address_type_down").hide();
  });

  $(".down_arrow").click(function(event) {
      $(".address_type_down").toggle();
      event.stopPropagation();
  });

  $('.allCheckSelect').on('ifChecked', function(event){
        $(".email_letter input[class='ads_Checkbox']").iCheck('check');
  });

  $('.allCheckSelect').on('ifUnchecked', function(event){
      $(".email_letter input[class='ads_Checkbox']").iCheck('uncheck');
  });

  $('body').on('click', '.allCheckSelect', function(){
    if($(this).is(':checked')){
      $('input:checkbox').prop("checked", true);
    }else{
      $('input:checkbox').prop("checked", false);
    }
  });

  $('body').on('change', '#addressTypeDrop', function(){
    var value = $(this).val();
    window.location.href = value;
  });
  

  	$("body").on("click", ".more_address", function(){

        var client_id   = $(this).data('client_id');
        var client_type   = $(this).data('client_type');
        if(client_type == "org"){
            var address = $("#corres_add_"+client_id).val();
        }else if(client_type == "ind"){
            var address_type   = $(this).data('address_type');
            if(address_type == "reg"){
              var address = $("#reg_add_"+client_id).val();
            }else{
              var address = $("#serv_add_"+client_id).val();
            }
        }else if(client_type == "staff"){

        }else if(client_type == "other"){
          var contact_id   = $(this).data('contact_id');
          var address = $("#other_address_"+contact_id).val();
        }else if(client_type == "custom"){
          var client_id   = $(this).data('client_id');
          var address = $("#custom_address_"+client_id).val();
        }

        $("#show_full_address").html(address);
        $("#full_address-modal").modal("show");
    });

  /* ################# Open Notes Popup Start ################### */
    $("body").on("click", ".open_notes_popup", function(){
      var client_id     = $(this).data("client_id");
      var contact_type  = $(this).data("contact_type");
      $.ajax({
          type: "POST",
          dataType : "json",
          url: "/contacts/show-contacts-notes",
          data: { 'client_id': client_id, 'contact_type' : contact_type },
          success: function (resp) {
            $("#notes_client_id").val(client_id);
            $("#contact_type").val(contact_type);
            $("#notes").val(resp['notes']);
            $("#notes-modal").modal("show");             
          }
      });
        
    });
/* ################# Save Notes Popup End ################### */
	
/* ################# Save Notes Start ################### */
    $(".save_notes").click(function(){
      var client_id     = $("#notes_client_id").val();
      var contact_type  = $("#contact_type").val();
      var notes         = $("#notes").val();
      var step_id       = $("#step_id").val();
      var address_type  = $("#encoded_type").val();

      $.ajax({
          type: "POST",
          //dataType : "json",
          url: "/contacts/save-contacts-notes",
          data: { 'client_id': client_id, 'contact_type' : contact_type, 'notes' : notes },
          success: function (resp) {
            //$("#notes-modal").modal("hide");  
            window.location = '/contacts-letters-emails/'+step_id+"/"+address_type;           
          }
      });
        
    });
    
    
    
/* ################# Save Notes End ################### */

/* ################# Create Group Start ################### */
    $(".create_groups").click(function(){
      var step_id       = $("#create_group_step_id").val();
      var tab_id        = $("#tab_id").val();
      var group_name    = $("#group_name").val();
      var address_type  = $("#encoded_type").val();

      $.ajax({
          type: "POST",
          dataType : "json",
          url: "/contacts/save-contacts-group",
          beforeSend : function(){
            $(".loader_class").html('<img src="/img/spinner.gif" />');
          },
          data: { 'step_id': step_id, 'group_name' : group_name },
          success: function (resp) {
            if(resp > 0){
              window.location = '/contacts-letters-emails/'+tab_id+'/'+address_type;            
            }else{
              $(".loader_class").html('');
              alert("There are some error..., Please try again.");
              return false;
            }
          }
      });
        
    });
/* ################# Create Group End ################### */

/* ################# Open Group Popup Start ################### */
  $(".create_group").click(function(){
    var val = [];
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    //alert(val.length);return false;
    if(val.length>0){
      $("#clients_array").val(val);
      $("#create_group-modal").modal("show");
    }else{
      alert('You have not selected any contacts to group');
    }
  });

  $(".open_addto_group").click(function(){
      $("#addto_group-modal").modal("show");
  });

  $("#group_step_id").change(function(){
      var group_id = $(this).val();
      if(group_id == ""){
        $("#group_show").show();
      }else{
        $("#group_name").val("");
        $("#group_show").hide();
      }
  });

  $(".saveto_group").click(function(){
      var tab_id        = $("#tab_id").val();
      var address_type  = $("#encoded_type").val();

      var group_name  = $("#group_name").val();
      var group_id    = $("#group_step_id").val();
      var client_ids  = $("#clients_array").val();
      //alert(client_ids+", "+group_name);return false;
      if(group_name == "" && group_id == ""){
        alert("Please select or enter the group name");
        return false;
      }

      $.ajax({
          type: "POST",
          url: "/contacts/copy-to-group",
          beforeSend : function(){
            $(".loader_class").html('<img src="/img/spinner.gif" />');
          },
          data: { 'group_id':group_id, 'group_name':group_name, 'tab_id':tab_id, 'client_ids':client_ids },
          success: function (resp) {
            if(resp > 0){
              window.location = '/contacts-letters-emails/'+tab_id+'/'+address_type;            
            }else{
              $(".loader_class").html('There are some error..., Please try again.');
              //alert("There are some error..., Please try again.");
              //return false;
            }
          }
      });
        
    });
/* ################# Open Group Popup End ################### */

/* ################# Search Client By Address Type Start ################### */
    $('body').on('change', ".address_type", function(){
        
      var address_type  = $(this).val();
      //alert(address_type);return false;
      var client_id = $(this).data('client_id');
      var key = $(this).data('key');
      $.ajax({
          type: "POST",
          dataType : "json",
          url: "/contacts/search-address",
          data: { 'address_type' : address_type, 'client_id' : client_id },
          success: function (resp) {
            if(resp['address'].length > '48'){
              var small_addr = resp['address'].substring(0,45)
              var address = small_addr+"...<a href='javascript:void(0)' class='more_address' data-client_id='"+client_id+"' data-client_type='org'>more</a>"
            }else{
              var address = resp['address'];
            }
            $("#tab_1 #corres_add_"+client_id).val(resp['address']);
            /*$("#example1 .tr_no_"+key+" td:nth-child(3)").html(resp['contact_person']);   
            $("#example1 .tr_no_"+key+" td:nth-child(4)").html(resp['telephone']);
            $("#example1 .tr_no_"+key+" td:nth-child(5)").html(resp['mobile']);   
            $("#example1 .tr_no_"+key+" td:nth-child(6)").html(resp['email']);
            $("#example1 .tr_no_"+key+" td:nth-child(7)").html(address);  */
            $("#tab_1 .contName"+client_id).html(resp['contact_person']);
            $("#tab_1 .teleAddr"+client_id).html(resp['telephone']);
            $("#tab_1 .mobAddr"+client_id).html(resp['mobile']);
            $("#tab_1 .emailAddr"+client_id).html(resp['email']);
            $("#tab_1 .fullAddr"+client_id).html(address);     
          }
      });
        
    });
/* ################# Search Client By Address Type End ################### */

/* ################# Search Client By Address Type Start ################### */
    $("#addto_group-modal").on("click", ".edit_status", function(){
        var step_id = $(this).data("step_id");
        var status_name = $("#status_span"+step_id).html();
        var text_field = "<input type='text' maxlength='12' id='status_name"+step_id+"' value='"+status_name+"' style='width:100%; height:30px'>";
        var action = "<a href='javascript:void(0)' class='save_new_status' data-step_id='"+step_id+"'>Save</a>&nbsp;&nbsp;<a href='javascript:void(0)' class='cancel_edit' data-step_id='"+step_id+"'>Cancel</a>";
        $("#status_span"+step_id).html(text_field);
        $("#action_"+step_id).html(action);
    });

    $("#addto_group-modal").on("click", ".cancel_edit", function(){
        var step_id = $(this).data("step_id");
        var status_name = $("#status_name"+step_id).val();
        var action = "<a href='javascript:void(0)' class='edit_status' data-step_id='"+step_id+"'><img src='/img/edit_icon.png'></a>";
        action += ' <a href="javascript:void(0)" class="delete_group" data-step_id="'+step_id+'"><img src="/img/cross.png" height="12" title="Delete Group?"></a>';
        $("#status_span"+step_id).html(status_name);
        $("#action_"+step_id).html(action);
    });

    $("#addto_group-modal").on("click", ".save_new_status", function(){
        var step_id       = $(this).data("step_id");
        var address_type  = $("#encoded_type").val();
        var tab_id        = $("#tab_id").val();
        var group_name    = $("#status_name"+step_id).val();
        //alert(group_name+" "+step_id);
        $.ajax({
            type: "POST",
            url: "/contacts/save-edit-group",
            //dataType: "json",
            data: { 'step_id': step_id, 'group_name' : group_name },
            beforeSend: function() {
                $(".loader_class").html('<img src="/img/spinner.gif" />');
            },
            success: function (resp) {
                if(resp != ""){
                  window.location = '/contacts-letters-emails/'+tab_id+'/'+address_type; 
                  /*var action = "<a href='javascript:void(0)' class='edit_status' data-step_id='"+step_id+"'><img src='/img/edit_icon.png'></a>";
                  $("#status_span"+step_id).html(status_name);
                  $("#action_"+step_id).html(action);

                  $("#step_field_"+step_id).text(status_name);*/
                }else{
                    alert("There are some problem to update status");
                }
                
            }
        });

    });
    
    $("#addto_group-modal").on("click", ".delete_group", function(){
        var address_type  = $("#encoded_type").val();
        var tab_id        = $("#tab_id").val();
        var step_id       = $(this).data("step_id");

        if(confirm("Do you want to delete this group?")){
          $.ajax({
            type: "POST",
            url: "/contacts/delete-group",
            data: { 'step_id': step_id },
            beforeSend: function() {
                $(".loader_class").html('<img src="/img/spinner.gif" />');
            },
            success: function (resp) {
                if(resp == 1){
                  window.location = '/contacts-letters-emails/'+tab_id+'/'+address_type; 
                }else{
                    $(".loader_class").html("There are some problem to delete the group.");
                }
                
            }
          });
        }
    });

/* ################# Search Client By Address Type End ################### */ 

/* ################# Delete Client From group Type Start ################### */ 
  $(".delete_group_client").click(function(){
      var address_type  = $("#encoded_type").val();
      var tab_id        = $("#tab_id").val();
      var contact_type  = $(this).data("contact_type");
      var client_id     = $(this).data("client_id");

      if(confirm("Do you want to delete this address from the group?")){
          $.ajax({
            type: "POST",
            url: "/contacts/delete-from-group",
            data: { 'contact_type': contact_type, 'client_id' : client_id, 'tab_id' : tab_id },
            beforeSend: function() {
                $(".loader_class").html('<img src="/img/spinner.gif" />');
            },
            success: function (resp) {
                if(resp == 1){
                  window.location = '/contacts-letters-emails/'+tab_id+'/'+address_type; 
                }else{
                    $(".loader_class").html("There are some problem to delete the group contact.");
                }
                
            }
          });
        }
  });
/* ################# Delete Client From group Type End ################### */ 

/* ################# Delete Client From group Type Start ################### */ 
  $(".change_address").change(function(){
      var contact_type  = $(this).val();
      
      $.ajax({
        type: "POST",
        url: "/contacts/show-contact-group",
        dataType: "json",
        data: { 'contact_type': contact_type },
        success: function (resp) {
            $("#addr_line1").val(resp['address1']);
            $("#addr_line2").val(resp['address2']);
            $("#city").val(resp['city']);
            $("#county").val(resp['county']);
            $("#postcode").val(resp['postcode']);
            $("#country").val(resp['country']);
        }
      });
       
  });
/* ################# Delete Client From group Type End ################### */ 
   
    $('body').on('click', ".add_contact-modal", function(){
      var contact_id  = $(this).data("contact_id");
      var added_from = $(this).data("added_from");
      
      save_contact_details(contact_id, added_from);
    });

    $(".edit_contact-modal").click(function(){
      var value       = $("#org_contacts").val();
      var added_from  = $(this).data("added_from");
      if(value == ''){
        alert('Please select contact first.');
        return false;
      }else{
        var items = value.split('_');
        if(items[1] == 'C'){
          save_contact_details(items[0], added_from);
        }else{
          edit_popup_populate(items[0], added_from);
        }
      }
    });

    $("body").on('click', '.editContactRelation', function(){
      var value       = $(this).attr("data-id");
      var added_from  = $(this).attr("data-added_from");
      var items = value.split('_');
      if(items[1] == 'C'){
        save_contact_details(items[0], added_from);
      }else{
        edit_popup_populate(items[0], added_from);
      }
    });

/* ################# Save Other Contact Details Start ################### */ //AddContactForm
    $(".SaveNewContact").click(function(){
      var added_from      = $("#AddedFrom").val();
      var contact_id      = $("#contact_id").val();
      var change_contact  = $("#change_contact").val();
      var addOtherEntity  = $("#addOtherEntity").val();

      /*var title  = $("#contact_title").val();
      var fname  = $("#contact_fname").val();
      var mname  = $("#contact_mname").val();
      var lname  = $("#contact_lname").val();
      var position  = $("#position").val();*/

      $("#AddContactForm").ajaxForm({
        dataType: 'json',
        //data: { 'client_id':client_id },
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
          /*var name = title+' '+fname+' '+mname+' '+lname;
          $("#database_tr"+resp.contact_id+"_C").children('td:first').html(name);
          $("#database_tr"+resp.contact_id+"_C").find('td:nth-child(2)').html(position);*/
        },
        success: function(resp) {
          $(".show_loader").html('');
          if(added_from == 'contact' || addOtherEntity == 'other_entity'){
            location.reload();
          }else{
            var option = '<option value="'+resp.contact_id+'_'+resp.contact_type+'">'+resp.contact_name+'</option>';
            if(resp.contact_type == 'C'){
              if(contact_id == '0'){
                $(".viewContactsList").append(option);
                $(".Pcontacts").append(option);

                var tr = '<tr id="database_tr'+resp.contact_id+'_C">\
                  <td width="40%">'+resp.contact_name+'</td>\
                    <td width="40%" align="center">'+resp.position+'</td>\
                    <td width="20%" align="center">\
                      <div class="action_box">\
                        <a href="javascript:void(0)" class="editContactRelation" data-id="'+resp.contact_id+'_C" data-copy_from="edit_org">Edit</a> | \
                        <a href="javascript:void(0)" class="delete_database_rel" data-contact_id="'+resp.contact_id+'" data-delete_index="'+resp.contact_id+'" data-contact_type="C">Delete</a> | \
                        <a href="javascript:void(0)" class="ViewContactPop" data-id="'+resp.contact_id+'_C" data-copy_from="edit_org" data-client_type="other">View</a>\
                      </div>\
                    </td>\
                  </tr>';
                $("#myRelTable").append(tr);
              }else{
                if(change_contact == 'Y'){
                  $("#database_tr"+resp.contact_id+"_C").hide();
                }else{
                  $(".viewContactsList option[value='"+resp.contact_id+"_C']").text(resp.contact_name);
                  $(".Pcontacts option[value='"+resp.contact_id+"_C']").text(resp.contact_name);
                  $("#database_tr"+resp.contact_id+"_C").children('td:first').html(resp.contact_name);
                  $("#database_tr"+resp.contact_id+"_C").find('td:nth-child(2)').html(resp.position);
                }
              }
            }
            if(resp.contact_type == 'R'){
              var reference_client_id  = $("#reference_client_id").val();
              name = '<a href="'+resp.link+'" target="_blank">'+resp.contact_name+'</a>';
              if(reference_client_id >0){
                $(".viewContactsList option[value='"+resp.contact_id+"_"+resp.contact_type+"']").text(resp.contact_name);
                $(".Pcontacts option[value='"+resp.contact_id+"_"+resp.contact_type+"']").text(resp.contact_name);
                $("#database_tr"+resp.rel_id+"_"+resp.contact_type).children('td:first').html(name);
                $("#database_tr"+resp.rel_id+"_"+resp.contact_type).find('td:nth-child(2)').html(resp.position);
              }else{
                if(change_contact == 'Y'){
                  $("#database_tr"+contact_id+"_C").hide();
                }

                tr = '<tr id="database_tr'+resp.rel_id+'_'+resp.contact_type+'">\
                  <td width="40%">'+name+'</td>\
                    <td width="40%" align="center">'+resp.position+'</td>\
                    <td width="20%" align="center">\
                      <div class="action_box">\
                        <a href="javascript:void(0)" class="editContactRelation" data-id="'+resp.contact_id+'_'+resp.contact_type+'" data-copy_from="edit_org">Edit</a> | \
                        <a href="javascript:void(0)" class="delete_database_rel" data-link="'+resp.link+'" data-rel_client_id="'+resp.contact_id+'" data-delete_index="'+resp.rel_id+'" data-contact_type="'+resp.contact_type+'">Delete</a> | \
                        <a href="javascript:void(0)" class="ViewContactPop" data-id="'+resp.contact_id+'_'+resp.contact_type+'" data-copy_from="edit_org" data-client_type="ind">View</a>\
                      </div>\
                    </td>\
                  </tr>';
                $("#myRelTable").append(tr);
              }

            }
          }
          $("#add_contact-modal").modal("hide");

            return false;

            /*var option = '<option value="'+resp.contact_id+'_'+resp.contact_type+'">'+resp.contact_name+'</option>';
            if(contact_id == '0'){
              $(".viewContactsList").append(option);
              $(".Pcontacts").append(option);
              var tr = '';
              if(resp.contact_type == 'C'){
                tr = '<tr id="database_tr'+resp.contact_id+'_C">\
                  <td width="40%">'+resp.contact_name+'</td>\
                    <td width="40%" align="center">'+resp.position+'</td>\
                    <td width="20%" align="center">\
                      <div class="action_box">\
                        <a href="javascript:void(0)" class="editContactRelation" data-id="'+resp.contact_id+'_C" data-copy_from="edit_org">Edit</a> | \
                        <a href="javascript:void(0)" class="delete_database_rel" data-contact_id="'+resp.contact_id+'" data-delete_index="'+resp.contact_id+'" data-contact_type="C">Delete</a> | \
                        <a href="javascript:void(0)" class="ViewContactPop" data-id="'+resp.contact_id+'_C" data-copy_from="edit_org" data-client_type="other">View</a>\
                      </div>\
                    </td>\
                  </tr>';
              }else{
                name = '<a href="'+resp.link+'" target="_blank">'+resp.contact_name+'</a>';
                tr = '<tr id="database_tr'+resp.contact_id+'_'+resp.contact_type+'">\
                  <td width="40%">'+name+'</td>\
                    <td width="40%" align="center">'+resp.position+'</td>\
                    <td width="20%" align="center">\
                      <div class="action_box">\
                        <a href="javascript:void(0)" class="editContactRelation" data-id="'+resp.contact_id+'_'+resp.contact_type+'" data-copy_from="edit_org">Edit</a> | \
                        <a href="javascript:void(0)" class="delete_database_rel" data-link="'+resp.link+'" data-rel_client_id="'+resp.contact_id+'" data-delete_index="'+resp.rel_id+'" data-contact_type="'+resp.contact_type+'">Delete</a> | \
                        <a href="javascript:void(0)" class="ViewContactPop" data-id="'+resp.contact_id+'_'+resp.contact_type+'" data-copy_from="edit_org" data-client_type="ind">View</a>\
                      </div>\
                    </td>\
                  </tr>';
              }
              $("#myRelTable").append(tr);
            }else{
              $(".viewContactsList option[value='"+resp.contact_id+"_C']").text(resp.contact_name);
              $(".Pcontacts option[value='"+resp.contact_id+"_C']").text(resp.contact_name);
              $("#database_tr"+resp.contact_id+"_C").children('td:first').html(resp.contact_name);
              $("#database_tr"+resp.contact_id+"_C").find('td:nth-child(2)').html(resp.position);
            }*/

        }
      }).submit();
    });
/* ################# Delete Other Contact Details Start ################### */ 
  $("body").on('click', '.delete_contact', function(){
      var address_type  = $("#encoded_type").val();
      var tab_id        = $("#tab_id").val();
      var contact_id     = $(this).data("contact_id");
      var delete_from     = $(this).data("delete_from");
      delete_contact_details(contact_id, delete_from);

      
  });

  $(".DeleteContactL").click(function(){
    var value  = $("#org_contacts").val();
    var delete_from   = $(this).data("delete_from");
    if(value == ''){
      alert('Please select contact first.');
      return false;
    }else{
      var items = value.split('_');
      if(items[1] == 'C'){
        var contact_id = items[0];
        delete_contact_details(contact_id, delete_from);
      }else{
        alert('You can not delete relationship contact.');
        return false;
      }
    }    
  });

  $(".CopyContactPop").click(function(){
    var value  = $("#org_contacts").val();
    var copy_from   = $(this).data("copy_from");
    if(value == ''){
      alert('Please select contact first.');
      return false;
    }else{
      var items = value.split('_');
      if(items[1] == 'C'){
        view_contact_details(items[0], copy_from);
      }else{
        view_client_contacts(items[0], copy_from);
      }
    }    
  });

  $("body").on('click', '.ViewContactPop', function(){
    var value       = $(this).data("id");
    var copy_from   = $(this).data("copy_from");

    var items = value.split('_');
    if(items[1] == 'C'){
      view_contact_details(items[0], copy_from);
    }else{
      view_client_contacts(items[0], copy_from);
    } 
  });
  
/* ################# Delete Other Contact Details End ################### */ 

/*###################### Arrange contacts alphabetcally ############### */
function sort(){
	var $people = $('ul#ckient_data'),
	$peopleli = $people.children('li');

$peopleli.sort(function(a,b){
	var an = a.getAttribute('data-name'),
		bn = b.getAttribute('data-name');

	if(an > bn) {
		return 1;
	}
	if(an < bn) {
		return -1;
	}
	return 0;
});

$peopleli.detach().appendTo($people);
}

function sort2(){
	var $people = $('ul#ckient_data2'),
	$peopleli = $people.children('li');

$peopleli.sort(function(a,b){
	var an = a.getAttribute('data-name'),
		bn = b.getAttribute('data-name');

	if(an > bn) {
		return 1;
	}
	if(an < bn) {
		return -1;
	}
	return 0;
});

$peopleli.detach().appendTo($people);
}
    
/* ################# Send Template/Email Actions start (pk) ################### */ 
	
$('#add_template_type').change(function(){
	var type=$(this).val();
	var ths=$(this);
	$.ajax({
          type: "GET",
          url: window.location + "../../email/template/getByType/"+type+"/json",
         // dataType: "json",
          success: function (data) {
		//data = data[0];
		$('#tamplatenamefromdrop').html(data);
          }
        });
});

$('#tamplatenamefromdrop').change(function(){
	var templateID=$(this).val();
	var url = $('#base_url').val();
	$.ajax({
          type: "GET",
          url: url + "/email/template/getdetails/"+templateID,
          dataType: "json",
          success: function (data) {
		data = data[0];
		$('#template_name').val(data.name);
		$('#template_mail_subject').val(data.subject);
		jQuery.get(url + '/email_templates/' + data.name+'.txt?'+(new Date()).getTime(), function(f) {
					//process text file line by line
					//$('#template_message_body').val(f);
					CKEDITOR.instances['template_message_body'].setData(f);
				});
          }
        });
});

$('#send_template_mail').click(function(){
	var typeID = $("#add_template_type").val();
	var template = $("#template_name").val();
	var subject = $("#template_mail_subject").val();
	var message_body = CKEDITOR.instances['template_message_body'].getData(); //$("#template_message_body").val();
	var url = $('#base_url').val();
	
	var emails = [];
	$('#ckient_data2 li').each(function(){
		var email = $(this).find('a').data('email');
		emails.push(email); 
	});
	
	$.ajax({
		type: "post",
		url: url + "/send-letters-emails/send",
		data:{typeID:typeID, template:template, subject:subject, message_body:message_body, emails : emails.toString()},
		// dataType: "json",
		success: function (data) {
			//data = data[0];
			alert(data);
		},
		error: function (data) {
			alert(data);
		},
		fail: function (data) {
			alert(data);
		}
        });
});


$('#select_client').change(function() {
        var client_type = $(this).val();
		$("#ckient_data,#ckient_data2").hide();
		$("#ckient_data2").html("");
		$(".sel_multi > img").show();
		$(".sel_multi > span").text("Loading...");
        console.log(client_type); //return false;
        if (client_type != "") {
            $.ajax({
                type: "POST",
                url: "/demo",
                dataType: "JSON",
                data: {
                    'client_type': client_type
                },
               // beforeSend: function()  {},
                success: function(resp) {
					//console.log(resp);
					//var parsed = $.parseJSON(resp);
					$("#ckient_data").html("");
					 $(".sel_multi > img").hide();
					 $(".sel_multi > span").text("Select 1 or more");
					$.each(resp, function(i, item) {
					    var id = resp[i][0];
					    var name =resp[i][2];
						var email=resp[i][3];
						if(email==""){
							email="not available";
						}
					     $("#ckient_data").append("<li class='sel_con' id='"+id+"' data-name='"+name+"' data-email='"+email+"'>"+name+"</li>"); 
						 sort();

				})
                }
            });
        }
		else{
		$(".sel_multi > img").hide();
		$(".sel_multi > span").text("Select 1 or more");
		}
 });
 
 //display contact list to choose multiple contacts
 $(".sel_multi").click(function(){
	 var f=$("#ckient_data").find("li").text();
	 if(f!=""){
		 $("#ckient_data").slideToggle();
	 }
	 else{
		  $("#ckient_data").hide();
		 alert("Select contact type first");
	 }
 });
 
  $(".selected-clients").click(function(){
	 var f=$("#ckient_data2").find("li").text();
	 if(f!=""){
		 $("#ckient_data2").slideToggle();
	 }
	 else{
		 $("#ckient_data2").hide();
		 alert("Select contacts first");	 
	 }
 });
 $('#client_data').change(function() {
        var client_dropdown = $("#client_data").text();
        //var client_text = $(this).text();
        //var strUser = document.getElementById("client_data").text
        //var e = document.getElementById("client_data");
		//var strUser = e.options[e.selectedIndex].text;
        alert(client_dropdown);
       
        console.log(client_dropdown); //return false;
        
       // $.each(resp, function(i, item) {
					   // var id = resp[i][0];
					    // var name =resp[i][2];
					    // $("#client_data").append($("<option></option>").val(id).html(name)); 
				//})
        if (client_dropdown != "") {
            
        } 
 });


$("#ckient_data").on('click','.sel_con',function(){
	 var txt=$(this).text();
	 var id=$(this).attr("id");
	 var email=$(this).attr("data-email");
	 var name=$(this).attr("data-name");
	 var url = $('#base_url').val();
	  //alert("id:"+id+", Text:"+txt);
	  $("#ckient_data2").append("<li class='sel_con'><a id='"+id+"' data-name='"+name+"' data-email='"+email+"' href='javascript:void(0)'><img src='"+url+"/img/shapes.png'></a>"+txt+"</li>");
	  $(this).remove();
	  sort();
	  sort2();
 });
 
 $("#ckient_data2").on('click','.sel_con',function(){
	var txt=$(this).text();
	var id=$(this).find("a").attr("id");
	var email=$(this).find("a").attr("data-email");
	var name=$(this).find("a").attr("data-name");
	var url = $('#base_url').val();
	  //alert("id:"+id+", Text:"+txt+", Remove ID:"+f);
	  $("#ckient_data").append("<li class='sel_con' id='"+id+"' data-name='"+name+"' data-email='"+email+"'>"+txt+"</li>");
	  $(this).remove();
	   sort();
	   sort2();
 });

$('#download_template_mail').click(function(){
	var typeID = $("#add_template_type").val();
	var template = $("#template_name").val();
	var subject = $("#template_mail_subject").val();
	var message_body = CKEDITOR.instances['template_message_body'].getData(); //$("#template_message_body").val();
	var url = $('#base_url').val();
	
	//alert(typeID);
	//alert(template);
	//alert(subject);
	//alert(message_body);
	//alert(url);
	
	$.ajax({
		type: "post",
		url: url + "/send-letters-emails/email-pdf-download",
		data:{typeID:typeID, template:template, subject:subject, message_body:message_body},
		// dataType: "json",
		success: function (data) {
			//data = data[0];
			window.location = '/send-letters-emails/generate-email/pdf';
		},
		error: function (data) {
			alert("error : " + data);
		},
		fail: function (data) {
			alert("fail : " + data);
		}
        });
});
	
$('#preview_template_mail').click(function(){
	var typeID = $("#add_template_type").val();
	var template = $("#template_name").val();
	var subject = $("#template_mail_subject").val();
	var message_body = CKEDITOR.instances['template_message_body'].getData(); //$("#template_message_body").val();
	var url = $('#base_url').val();
	
	//alert(typeID);
	//alert(template);
	//alert(subject);
	//alert(message_body);
	//alert(url);
	
	$.ajax({
		type: "post",
		url: url + "/send-letters-emails/email-pdf-preview",
		data:{typeID:typeID, template:template, subject:subject, message_body:message_body},
		// dataType: "json",
		success: function (data) {
			//data = data[0];
			window.location = '/send-letters-emails/generate-email/preview';
		},
		error: function (data) {
			alert("error : " + data);
		},
		fail: function (data) {
			alert("fail : " + data);
		}
        });
});

/* ################# Send Template/Email Actions end (pk) ################### */ 

});



function save_contact_details(contact_id, added_from)
{
  $("#contact_id").val(contact_id);
  $("#reference_client_id").val('0');
  $("#AddedFrom").val(added_from);
  $("#popupType").val('C');
  if(added_from == 'edit_org'){
    $("#fileCntctASDv").hide();
  }   
  $("#addOtherEntity").val('');

  if(contact_id > 0){
    $.ajax({
      type: "POST",
      url: "/contacts/get-contact-details",
      dataType: "json",
      data: { 'contact_id': contact_id, 'contact_type': "other", 'added_from':added_from },
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
        //$("#change_contact").removeClass('disable_click');
        $("#add_contact-modal").modal("show");
      },
      success: function (resp) {
        $(".show_loader").html('');
        $("#contact_type").val(resp['contact_type']);
        $("#contact_title").val(resp['contact_title']);
        $("#contact_fname").val(resp['contact_fname']);
        $("#contact_mname").val(resp['contact_mname']);
        $("#contact_lname").val(resp['contact_lname']);
        $("#telephone").val(resp['telephone']);
        $("#mobile").val(resp['mobile']);
        $("#email").val(resp['email']);
        $("#other_address").val(resp['address_id']);
        $("#position").val(resp['position']);
        $("#Company_id").val(resp['client_id']);
        //$("#change_contact").val(resp['change_contact']);
      }
    });
  }else{
    popup_null();
    $("#add_contact-modal").modal("show");
  }
}

function edit_popup_populate(client_id, added_from)
{
  $("#contact_id").val('0');
  $("#reference_client_id").val(client_id);
  $("#AddedFrom").val(added_from);
  var org_client_id = $('#client_id').val();
  if(added_from == 'edit_org'){
    $("#fileCntctASDv").hide();
  }   
  $("#addOtherEntity").val('');

  $.ajax({
    type: "POST",
    url: "/contacts/view-client-address",
    dataType: "json",
    data: { 'client_id': client_id },
    beforeSend : function(){
      $(".show_loader").html('<img src="/img/spinner.gif" />');
      popup_null();
      $("#popupType").val('R');
      //$("#change_contact").addClass('disable_click');
      $("#add_contact-modal").modal("show");
    },
    success: function (resp) {
      $(".show_loader").html('');
      $("#contact_type").val('company_name');
      $("#contact_title").val(resp['contact_title']);
      $("#contact_fname").val(resp['contact_fname']);
      $("#contact_mname").val(resp['contact_mname']);
      $("#contact_lname").val(resp['contact_lname']);
      $("#telephone").val(resp['telephone']);
      $("#mobile").val(resp['mobile']);
      $("#email").val(resp['email']);
      $("#other_address").val(resp.address.address_id);
      $("#Company_id").val(org_client_id);
      $("#position").val(resp.position);
      //$("#change_contact").val('Y');
    }
  });
}

function popup_null()
{
  $("#contact_type").val('company_name');
  $("#contact_title").val('Mr');
  $("#contact_fname").val('');
  $("#contact_mname").val('');
  $("#contact_lname").val('');
  $("#telephone").val('');
  $("#mobile").val('');
  $("#email").val('');
  $("#other_address").val('');
  $("#position").val('');
  $("#change_contact").val('N');
}

function delete_contact_details(contact_id, delete_from)
{
  if(confirm("Do you want to delete this contact address?")){
    $.ajax({
      type: "POST",
      url: "/contacts/delete-contact-address",
      data: { 'contact_type': 'other', 'contact_id' : contact_id },
      success: function (resp) {
        if(delete_from == 'contact'){
          if(resp == 1){
            //location.reload(); 
            refresh_table();
          }else{
              alert("There are some problem to delete the contact.");
          }
        }else{
          $(".viewContactsList option[value='"+contact_id+"_C']").remove();
        }  
      }
    });
  }
}

function view_contact_details(contact_id, copy_from)
{
  $.ajax({
    type: "POST",
    dataType : 'json',
    url: "/contacts/view-contact-address",
    data: { 'contact_type': 'other', 'contact_id' : contact_id },
    success: function (resp) {
      var address = resp.address;
      var text = '';
      var newchar = '<br>';
      var full_address = address.address;
      text += '<b>'+address.contact_name+'</b><br><b>'+address.name+'</b><br>'+full_address.split(',').join(newchar);
      text += '<br><br>'+address.email+'<br>'+address.telephone+'<br>'+address.website;
      $('#show_full_address').html(text);
      $("#full_address-modal").modal("show");
    }
  });
}

function view_client_contacts(client_id, copy_from)
{
  $.ajax({
    type: "POST",
    dataType : 'json',
    url: "/contacts/view-client-address",
    data: { 'client_id' : client_id },
    beforeSend:function(){
      $('#show_full_address').html('<img src="/img/spinner.gif" />');
      $("#full_address-modal").modal("show");
    },
    success: function (resp) {
      var company_name = $('#business_name').val();
      var address = resp.address;
      var text = '';
      var newchar = '<br>';
      var full_address = address.fullAddress;
      text += '<b>'+resp.contact_name+'</b><br><b>'+company_name+'</b><br>';
      if(typeof full_address !== 'undefined'){
        text += full_address.split(',').join(newchar);
      }
      text += '<br><br>'+resp.email+'<br>'+resp.telephone+'<br>'+resp.website;
      $('#show_full_address').html(text);
    }
  });
}
