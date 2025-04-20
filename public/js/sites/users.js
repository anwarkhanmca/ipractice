$(document).ready(function(){

	$('#allCheckSelect').on('ifChecked', function(event){
		$('input').iCheck('check');
	});

	$('#allCheckSelect').on('ifUnchecked', function(event){
		$('input').iCheck('uncheck');
	});

	$('.iradio_minimal').on('ifChecked', function(event){
		
		var value = $(this).find(".handle-change-user").data('type');
	  	if(value == "admin"){
			$("#user_permissions").show();
		}else if(value == "staff"){
			$("#user_permissions").show();
		}else{
			$("#user_permissions").hide();
		}
	});


	$('.handle-change-user').on('ifChecked', function(event){
		var value = $(this).data('type');
	  	if(value == "client"){
			$("input[name='user_access[]']").each( function (i) {
				$(this).parent().addClass("check_gray");
				$(this).iCheck('uncheck');
				$(this).iCheck('disable');

			});

       		$("input[name='permission[]']").each( function (i) {
       			$(this).parent().addClass("check_gray");
				$(this).iCheck('uncheck');
				$(this).iCheck('disable');
			});

       		<!-- SHOW CLIENT USER FIELD START -->
       		$("#staff_user_div").hide();
       		$("#client_user_div").show();
       		<!-- SHOW CLIENT USER FIELD END -->



		}else if(value == "staff"){
			$("input[name='user_access[]']").each( function (i) {
				$(this).parent().removeClass("check_gray");
				$(this).iCheck('check');
				$(this).iCheck('enable');
			});

       		$("input[name='permission[]']").each( function (i) {
       			$(this).parent().removeClass("check_gray");
				$(this).iCheck('check');
				$(this).iCheck('enable');
			});

			<!-- SHOW CLIENT USER FIELD START -->
       		$("#staff_user_div").show();
       		$("#client_user_div").hide();
       		<!-- SHOW CLIENT USER FIELD END -->
		}
	});

	$("input[name='user_access[]']").on('ifChecked', function(event){
		var value = $(this).data('name');
	  	if(value == "TASK MANAGEMENT"){
			$("input[name='permission[]']").each( function (i) {
				$(this).parent().removeClass("check_gray");
				$(this).iCheck('enable');
				$(this).iCheck('check');
       		});

		}
	});

	$("input[name='user_access[]']").on('ifUnchecked', function(event){
		var value = $(this).data('name');
	  	if(value == "TASK MANAGEMENT"){
			$("input[name='permission[]']").each( function (i) {
				$(this).parent().addClass("check_gray");
				$(this).iCheck('disable');
				$(this).iCheck('uncheck');
       		});

		}
	});




	$('#deleteUsers').click(function() {
	  	var val = [];
        $("input[name='user_delete_id[]']").each( function (i) {
			if($(this).is(':checked'))
       			val[i] = $(this).val();
                //alert(val);return false;

   		});

		//alert(val.length);return false;
		if(val.length>0){
		  //console.log(val);
			if(confirm("Do you want to delete?")){
				$.ajax({
				    type: "POST",
				    url: '/delete-users',
				    data: { 'user_delete_id' : val },
				    success : function(resp){
				    	//window.location = 'http://mpm.com/user-list';
				    	window.location = '/user-list';
				    }
				});
			}

 		}else{
 			alert('Please select atleast one user');
 		}
 	});

	
 	$('#allCheckSelect').on('ifChecked', function(event){
		$('#example2 input[type=checkbox]').attr('checked', 'checked');
		$('.odd div').addClass('checked');
		
	});

 	$('#allCheckSelect').on('ifUnchecked', function(event){
		$('.odd div').removeClass('checked');
		$('#example2 input[type=checkbox]').removeAttr('checked');
	});


 	$("input[name='user_delete_id[]']").on('ifUnchecked', function(event){
		$(this).removeAttr('checked');
	});


 	//##############User active/Inactive Portion start ################//
 	$('.active_t').click(function() {
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
				    	$("#user_status_"+user_id).html(resp);
				    }
				});
			}

 		}else{
 			alert('This is invalid user');
 		}
 	});
 	//##############User active/Inactive Portion start ################//


 	//############## Get relationship client portion start ################//
 	$('.get_relation_client').change(function() {
 		var client_id = $(this).val();
 		if(client_id != "" ){
 			$.ajax({
			    type: "GET",
			    dataType: "json",
			    url: '/user/get-relation-client/'+client_id+"=ajax",
			    //data: { 'client_id' : client_id },
			    success : function(resp){
			    	if(resp.length > 0){
			    		var content = '';
			    		$.each(resp, function(key){
			    			content += '<li><div class="job_checkbox">';
			    			content += '<span class="custom_chk"><input type="checkbox" value="'+resp[key]['client_id']+'" name="related_client[]" id="'+resp[key]['client_id']+'" />';
			    			content += '<label for="'+resp[key]['client_id']+'"><a href="#" class="hover">'+resp[key]['client_name']+'</a></label></span></div></li>'
			    		});

			    		$(".show_org_client ul").html(content);
			    	}else{
			    		$(".show_org_client ul").html("");
			    	}
			    }
			});
 		}else{
    		$(".show_org_client ul").html("");
    	}
 	});
 	//############## Get relationship client portion end ################//

	// Archive and Un-Archive staff start //
	  $("#archivedButton").click(function(){
	    var val = [];
	    $(".ads_Checkbox:checked").each( function (i) {
	      if($(this).is(':checked')){
	        val[i] = $(this).val();
	      }
	    });
	    
	    if(val.length>0){
	      var status = $.trim($(this).html());
	      if(confirm("Do you want to change the status of the staff?")){
	        $.ajax({
            type: "POST",
            url: '/staff/archive-staff',
            data: { 'users_id' : val, 'status' : status },
            success : function(resp){
              //window.location = '/staff-details';
              refresh_table();
            }
	        });
	      }

	    }else{
	      alert('Please select atleast one staff');
	    }
	  
	});

	$("#archive_div").click(function(){
	    var is_archive;
	    var html = $(this).html();
	    if($.trim(html) == 'Show Archived'){
	      is_archive  = 'N';
	      $("#archive_div").html('Hide Archived');
	    }else{
	      is_archive  = 'Y';
	      $("#archive_div").html('Show Archived');
	    }
	    //alert(is_archive);return false;
	    $.ajax({
	      type: "POST",
	      url: '/staff/show-archive-staff',
	      data: { 'is_archive' : is_archive },
	      success : function(resp){//return false;
	        //window.location = '/staff-details';
	        refresh_table();
	      }
	    });
	      
	});

	/*$(".ads_Checkbox").on('ifChecked', function(event){
	    $(".ads_Checkbox:checked").each( function (i) {
	        if($(this).data("archive") == "Y"){
	          $("#archivedButton").html('Un-Archive');
	        }else{
	          $("#archivedButton").html('Archive');
	        }
	    });
	});

	$(".ads_Checkbox").on('ifUnchecked', function(event){
		$(".ads_Checkbox:checked").each( function (i) {
		    if($(this).data("archive") == "Y"){
		      $("#archivedButton").html('Un-Archive');
		    }else{
		      $("#archivedButton").html('Archive');
		    }
		});
	});*/
	$("body").on('click', '.ads_Checkbox', function(event){
    $(".ads_Checkbox:checked").each( function (i) {
      if($(this).data("archive") == "Y"){
        $("#archivedButton").html('Un-Archive');
        //$("#archiveClients").html('Un-Archive');
      }else{
        $("#archivedButton").html('Archive');
        //$("#archiveClients").html('Archive');
      }
    });
    
  });

// Archive and Un-Archive client start //


});

