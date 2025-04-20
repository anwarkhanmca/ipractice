$(document).ready(function(){

	/*$('.CheckorgCheckbox').on('ifChecked', function(event){
		var client_type = $("#client_type").val();
    $("."+client_type+"_Checkbox").iCheck('check');
  });

  $('.CheckorgCheckbox').on('ifUnchecked', function(event){
  	var client_type = $("#client_type").val();
    $("."+client_type+"_Checkbox").iCheck('uncheck');
  });*/

  $('.CheckorgCheckbox').on('ifChecked', function(event){
    $(".applicable_Checkbox").iCheck('check');
  });

  $('.CheckorgCheckbox').on('ifUnchecked', function(event){
    $(".applicable_Checkbox").iCheck('uncheck');
  });

  $(".client_allocate").click(function(){
  	var client_type = $(this).data("type");
  	$("#client_type").val(client_type);
  	refresh_table();
  });

	$('.bulk_allocation').click(function() {
		var client_type = $("#client_type").val();
		var val = [];
    $("."+client_type+"_Checkbox:checked").each( function (i) {
			if($(this).is(':checked')){
				val[i] = $(this).val();
			}
    });
		
		var service_id = $("#"+client_type+"_service_id").val();
		if(val.length <=0){
			alert("Please select atleast one client.");
			return false;
		}else if(service_id == ""){
			alert("Please select Service.");
			return false;
		}else{
			$('.show_loader').html('');
			$('#bulk_allocation-modal').modal('show');
		}
		
	});

	$(".service_dropdown").change(function(){
		var postData = [];
		postData['client_type'] = $("#client_type").val();
		postData['service_id'] 	= $("#"+postData['client_type']+"_service_id").val();
		service_dropdown(postData);
	});

	$("body").on('change', '.clientAddToList', function(){
		var postData = [];
		var client_type = $("#client_type").val();
		var client_id 	= $(this).val();
		
		if(client_id >0){
			postData['client_type'] = client_type;
			postData['service_id'] 	= $("#"+client_type+"_service_id").val();
			postData['client_id'] 	= client_id;
			clientAddToList(postData);
		}
	});

	$('body').on('ifUnchecked', '#removeAllocCheck', function(event){
		var postData = [];
    var client_type = $("#client_type").val();
    var service_id  = $("#"+client_type+"_service_id").val();
    var client_id   = $(".staff_client_id").val();

    $.ajax({
	    type: "POST",
	    url: '/cla/action',
    	data: { 'service_id':service_id, 'client_id':client_id, 'client_type':client_type, 'action':'removeAllocCheck' },
	    success : function(resp){
	    	var data = resp.split('ipractice');
	    	//var clients 	= data[0];
	    	var lists 		= data[1];
	    	//$("#example1 tbody").html( $.trim(clients) );
	    	$(".clientAddToList").html( $.trim(lists) );
	    	refresh_table();
	      $('#allocation-modal').modal('hide');
	    }
  	});
	});

	$('.save_bulk_client_allocation').on('click', function(event){
		var column_id 	= $('input[name=column]:checked').val();
		var column_no 	= $('input[name=column]:checked').attr('data-column_no');
		var client_type = $("#client_type").val();
		var service_id 	= $("#"+client_type+"_service_id").val();
		var staff_id 		= $("#staff_id").val();
		var save_type 	= $(this).attr('data-save_type');

		var val = [];
	    $("."+client_type+"_Checkbox:checked").each( function (i) {
			if($(this).is(':checked')){
				val[i] = $(this).val();
			}
	    });

	    if(staff_id == ""){
    		alert("Please Select Staff name");
    		return false;
    	}else if(column_id === undefined){
	    	alert('Please select any one heading');
	    	return false;
	    }else{
	    	$.ajax({
			    type: "POST",
			    url: '/save-bulk-client-allocation',
			    data: { 'service_id':service_id, 'client_type':client_type, 'clients':val, 'staff_id':staff_id, 'column_no':column_no, 'save_type':save_type },
			    beforeSend: function() {
            $('.show_loader').html('<img src="/img/spinner.gif" />');
	        },
			    success : function(resp){//alert(resp);return false;
			    	refresh_table();
			    	$('.show_loader').html('');
			    	$('#bulk_allocation-modal').modal('hide');
			    	//location.reload();
			    	
			    }
			});
	    }
	});

	/*$('.radio_column').on('ifChecked', function(event){
		var column 		= $(this).val();
		var client_type = $("#client_type").val();
		var val = [];
	    $("."+client_type+"_Checkbox:checked").each( function (i) {
			if($(this).is(':checked')){
				val[i] = $(this).val();
			}
	    });
		
		
        
    });*/

    $(".save_bulk_allocation").click(function(){
    	var client_type = $("#client_type").val();
    	var column 		= $('input:radio[name=column]:checked').val();
    	var staff_id 	= $('#staff_id').val();
    	var service_id 	= $("#"+client_type+"_service_id").val();
    	//alert(service_id+", "+staff_id+", "+client_type);

    	if(staff_id == ""){
    		alert("Please Select Staff name");
    		return false;
    	}else if(column == "undefined" || column == ""){
    		alert("Please select column");
    		return false;
    	}else{
    		var val = [];
		    $("."+client_type+"_Checkbox:checked").each( function (i) {
				if($(this).is(':checked')){
					val[i] = $(this).val();
				}
		    });
    		$.ajax({
			    type: "POST",
			    url: '/save-bulk-allocation',
			    data: { 'service_id':service_id,'column':column,'client_type':client_type,'staff_id':staff_id,'client_array':val },
			    success : function(resp){
			    	//$("#success_msg").html("Successfully added bulk allocation");
			    	$("."+client_type+"_Checkbox:checked").each( function (i) {
						if($(this).is(':checked')){
							client_id = $(this).val();
							$('#'+client_id+"_"+client_type+'_staff_id'+column).val(staff_id);
						}
				    });
			    	
			    	$('#bulk_allocation-modal').modal('hide');
			    }
			});
    	}

    });

	$("body").on("change", ".save_manual_user", function(){ 
		var client_type = $("#client_type").val();
  	var column 		= $(this).data("column");
  	var client_id 	= $(this).data("client_id");
  	var staff_id 	= $(this).val();
  	var service_id 	= $("#"+client_type+"_service_id").val();

  	if(service_id == ""){
  		alert("Please Select Service name");
  		return false;
  	}else{
  		$.ajax({
		    type: "POST",
		    url: '/save-manual-staff',
		    data: { 'service_id':service_id,'column':column,'client_type':client_type,'staff_id':staff_id,'client_id':client_id },
		    success : function(resp){
		    	
		    }
			});
  	}
	});


	/* Change services from client start*/
	$('.applicable_Checkbox').on('ifChecked', function(event){
		var client_type = $("#client_type").val();
		var service_id = $("#"+client_type+"_service_id").val();
    var client_id = $(this).val();
    $.ajax({
	    type: "POST",
	    url: '/edit-service-id',
	    data: { 'service_id':service_id,'action_type':'add','client_id':client_id },
	    beforeSend : function(){
	    	$(".openAllocation_"+client_id).removeClass('disable_click');
	    },
	    success : function(resp){
	    	$("#client_"+client_id).find('select').prop('disabled', false);
	    	$("#"+client_type+"_checkbox"+client_id).iCheck('enable');
	    	//$("#client_"+client_id+" input[type=checkbox]").prop('disabled', false);
	    }
		});
  });

  $('.applicable_Checkbox').on('ifUnchecked', function(event){
  	var client_type = $("#client_type").val();
		var service_id = $("#"+client_type+"_service_id").val();
    var client_id = $(this).val();
    $.ajax({
	    type: "POST",
	    url: '/edit-service-id',
	    data: { 'service_id':service_id,'action_type':'delete','client_id':client_id },
	    success : function(resp){
	    	//$("#client_"+client_id).find('select').prop('disabled', true);
	    	//$("#"+client_type+"_checkbox"+client_id).iCheck('disable');

	    	$(".openAllocation_"+client_id).addClass('disable_click');
	    	$("#client_"+client_id+" td:nth-last-child(5)").html('');
	    	$("#client_"+client_id+" td:nth-last-child(4)").html('');
	    	$("#client_"+client_id+" td:nth-last-child(3)").html('');
	    	$("#client_"+client_id+" td:nth-last-child(2)").html('');
	    	$("#client_"+client_id+" td:nth-last-child(1)").html('');
	    }
		});
  });
    /* Change services from client end*/


});


function clientAddToList(postData)
{
	var service_id 	= postData['service_id'];
	var client_type = postData['client_type'];
	var client_id 	= postData['client_id'];

	$.ajax({
    type: "POST",
    dataType:'json',
    url: '/cla/action',
    data: { 'service_id':service_id, 'client_id':client_id, 'client_type':client_type, 'action':'clientAddToList' },
    success : function(resp){
    	if(resp.last_id > 0){
    		//$(".del_li_"+client_id).hide();
    		postData['client_type'] = client_type;
				postData['service_id'] 	= service_id;
    		service_dropdown(postData);
    	}
    }
	});
}

function service_dropdown(postData)
{
	var service_id 	= postData['service_id'];
	var client_type = postData['client_type'];

	if(service_id != "0"){
		$.ajax({
	    type: "POST",
	    url: '/cla/action',
	    //dataType:'json',
	    data: { 'service_id':service_id, 'client_type':client_type, 'action':'getClientLists' },
	    beforeSend:function(){
	    	$('.show_loader').html('<img src="/img/spinner.gif" />');
	    },
	    success : function(resp){
	    	var data = resp.split('ipractice');
	    	//var clients 	= data[0];
	    	var lists 		= data[1];
	    	//$("#example1 tbody").html( $.trim(clients) );
	    	$(".clientAddToList").html( $.trim(lists) );
	    	refresh_table();
	    }
		});
	}else{
		refresh_table();
		$(".clientAddToList").html('<option value="">Select 1 or more clients</option>');
	}
}