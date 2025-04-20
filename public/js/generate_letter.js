$(document).ready(function(){
	$('.allCheckSelect').on('ifChecked', function(event){
		$('#tab1 input').iCheck('check');
	});

	$('.allCheckSelect').on('ifUnchecked', function(event){
		$('#tab1 input').iCheck('uncheck');
	});

	

	/*$(document).click(function(event) {
        $(".open_toggle").hide();
        event.stopPropagation();
    });
    $(document).on('click', '#searchText', function () {
	    $(".open_toggle").show();
	    event.stopPropagation();
	});*/
	$(document).on('click',function(e){
	    if(e.target.id == 'searchText'){
	    	$(".open_toggle").show();
	    }else{
	    	$(".open_toggle").hide();
	    }
	    e.stopPropagation();
	})

    $("#select_icon").click(function(event) {
        $(".open_toggle").toggle();
        event.stopPropagation();
    });

	$('.selectContactType').change(function(){
		var dropValue = $(this).val(); 
		if(dropValue == ''){
			$("#select_icon").addClass('avoid-clicks');
			$(".open_toggle").hide();
		}else{
			var dataArray=[];
			dataArray['dropValue'] 		= dropValue;
			dataArray['action'] 		= 'changeDropdown';
			dataArray['searchValue'] 	= '';
			generate_letter_action(dataArray);
		}
	});

	$('#searchText').keyup(function(){
		//$(".open_toggle").show();
		var dropValue 	= $('.selectContactType').val(); 
		var searchValue = $('#searchText').val(); 

		var dataArray=[];
		dataArray['dropValue'] 		= dropValue;
		dataArray['action'] 		= 'getSearchValue';
		dataArray['searchValue'] 	= searchValue;
		generate_letter_action(dataArray);
	});

	$("body").on('click', ".addToTable", function(event) {
		//$(".open_toggle").show();
        var item_id 	= $(this).data('item_id');
        var item_type 	= $(this).data('item_type');
        if(item_type != 'group'){
        	$('.del_li_'+item_id+'_'+item_type).hide();
        }
        add_new_client(item_id, item_type)
	});

    $('#deleteItems').click(function() {
		var val = [];
        $(".ads_Checkbox:checked").each( function (i) {
			if($(this).is(':checked')){
				val[i] = $(this).val();
			}
	    });
    
	    deleteGenerateLetterContact(val);
	});

	$('.deleteLetterContact').click(function() {
		var val = [];
		val[0] = $(this).data('template_id');//alert(val.length)
    
	    deleteLetterContact(val);
	});

	
	$('.saveTemplateButton').click(function(){
		var postData = [];
		var page_open = $('#page_open').val();
		if(page_open == '2'){
			$("#page_open").val('2');
			postData['content'] = CKEDITOR.instances['template_message_body'].getData();
			postData['subject'] = $('#template_mail_subject').val();
		}else{
			$("#page_open").val('3');
			tinyMCE.triggerSave();
			postData['content'] = $('#editor3').val();
			postData['subject'] = $('.newsubject').html();
		}
		
		postData['save_as'] 	= $(this).data('save_as');
		postData['status'] 		= $(this).data('status');
		postData['page_open'] 	= page_open;
		saveTemplate(postData);
	});

	$('body').on('click', '.dynamicView', function(){
		alert('You need to save the letter first');
		return false;
	});

	$('body').on('click', '#closeGeneratePage', function(){
		if(confirm("Do you want to close the page?")){
			window.location.href = '/letters';
		}
	});
	
	$('body').on('click', '.viewLetterData', function(){
		var template_id = $(this).data('template_id');
		window.location.href = '/letters/view-letter/31-'+template_id;
	});

	$('body').on('click', '.copyLetterContact', function(){
		var copy_id = $(this).data('copy_id');
		window.location.href = '/letters/generate-letter/2/0/'+copy_id;
	});

	$('.checkConfidential').on('ifChecked', function(event){
		var template_id = $(this).val();
		var postData = [];
		postData['template_id'] = template_id;
		postData['checkbox'] 	= 'checked';
		checkConfidential(postData);
	});

	$('.checkConfidential').on('ifUnchecked', function(event){
		var template_id = $(this).val();
		var postData = [];
		postData['template_id'] = template_id;
		postData['checkbox'] 	= 'unchecked';
		checkConfidential(postData);
	});

	$('.templateDrop').change(function(){
		var dropValue 	= $(this).val();
		var type 		= $(this).data('type'); 

		if(dropValue != ''){
			var dataArray=[];
			dataArray['dropValue'] 		= dropValue;
			dataArray['action'] 		= 'getTemplateData';
			dataArray['type'] 			= type;
			getTemplateData(dataArray);
		}else{
			CKEDITOR.instances['template_message_body'].setData('');
		}
	});

	$('#saveAsTemplateBtn').click(function(){
		var postData = [];
		postData['content'] = CKEDITOR.instances['template_message_body'].getData();
		postData['subject'] = $('#template_mail_subject').val();
		postData['save_as'] = $(this).data('save_as');
		postData['status'] 	= $(this).data('status');
		saveAsTemplateDetails(postData);
	});

	$('.previewLetterDrop').change(function(){
		var recipient_id = $(this).val();
		var page_open	 = $('#page_open').val();
		var template_id  = $('#template_id').val();
		if(recipient_id != ''){
			if(page_open == '2'){
				window.location.href = '/letters/generate-letter/3-'+recipient_id+'/'+template_id+'/0/L';
			}else{
				$.ajax({
			        type: "POST",
			        dataType:'json',
			        url: '/letters/generate-letter-action',
			        data: { 'recipient_id':recipient_id, 'template_id':template_id, 'action':'getPreviewData' },
			        beforeSend : function(){
			          $(".show_loader").html('<img src="/img/spinner.gif" />');
			        },
			        success : function(resp){
			        	$(".show_loader").html('');
			        	tinyMCE.get('editor3').setContent(resp.details.newcontent);
			        	$('.newsubject').html(resp.details.newsubject);
			        	$('#template_id').val(resp.details.template_id);
			        	//tinyMCE.triggerSave();
						//$('#editor3').val(resp.templateBody);
			        }
			    });
			}
		}
	});

	$('.downloadTemplatePdf').click(function(e){
		var template_id  	= $('#template_id').val();
		//var content  		= tinymce.get('#editor3').getContent();
		tinyMCE.triggerSave();
		var content 	= $('#editor3').val();
		var subject 	= $('.newsubject').html();
		var item_name 	= $('#previewLetterDrop2  option:selected').text();
		var lhead = $('select[name=lheads]').val();

		$.ajax({
	        type: "POST",
	        dataType:'json',
	        url: '/letters/generate-letter-action',
	        data: { 'template_id':template_id, 'content':content, 'subject':subject, 'item_name':item_name, 'lhead':lhead, 'action':'generatePdfTemplate' },
	        beforeSend : function(){
	          	$(".show_loader").html('<img src="/img/spinner.gif" />');
	        },
	        success : function(resp){
	        	$(".show_loader").html('');
	        	window.open('/uploads/emailTemplates/'+resp.templateName, '_blank');
	        }
	    });
	});

	$('.writeTab').click(function(e){
		var url  			= $(this).data('url');
		var template_id  	= $('#template_id').val();
		var isCopyId  		= $('#isCopyId').val();
		var type  			= $('#type').val();
		
		$.ajax({
	        type: "POST",
	        dataType:'json',
	        url: '/letters/generate-letter-action',
	        data: { 'template_id':template_id,'isCopyId':isCopyId,'type':type, 'action':'checkContactSession' },
	        beforeSend : function(){
	          $("#page_open").val('2');
	          $('#tabli_3').addClass('hide');
	          //$(".previewLetterDrop").removeClass('disable_click');
	          $('#saveTemplateButton1 span').html('Preview');
	        },
	        success : function(resp){console.log(resp.contacts)
	        	var option = '';
	        	if( resp.contacts.length !== undefined && resp.contacts.length !== null && resp.contacts.length > 0){
					$.each(resp.contacts, function(k, v){
						option += '<option value="'+v.recipient_id+'">'+v.item_name+'</option>';
					});
					$(".previewLetterDrop").html(option);
				}

				if(resp.count > 0){
	        		$('.TAB, #tab_1, #tab_3').removeClass('active');
	        		$('#tabli_2, #tab_2').addClass('active');

	        		$('.tab1_view, .tab3_view').hide();
	        		$('.tab2_view, .tab23_view').show();
	        		//window.location.href = url;
	        	}else{
	        		alert('Please add atleast one contact');
	        		return false;
	        	}
	        }
	    });
	});

	$('.contactTab').click(function(e){
		var url  			= $(this).data('url');
		var template_id  	= $('#template_id').val();
		var isCopyId  		= $('#isCopyId').val();
		var type  			= $('#type').val();

		$('.TAB, #tab_2, #tab_3').removeClass('active');
		$('#tabli_1, #tab_1').addClass('active');
		$('#tabli_3').addClass('hide');

		$('.tab1_view').show();
		$('.tab2_view, .tab3_view, .tab23_view').hide();
		$("#page_open").val('1');
	});

	$('.viewForPreviewBtn').click(function(e){
		var url  		 = $(this).data('url');
		var template_id  = $('#template_id').val();
		var recipient_id = $(this).data('recipient_id');

		$.ajax({
	        type: "POST",
	        dataType:'json',
	        url: '/letters/generate-letter-action',
	        beforeSend : function(){
	          $(".show_loader").html('<img src="/img/spinner.gif" />');
	        },
	        data: { 'template_id':template_id, 'recipient_id':recipient_id, 'action':'generatePdfForView' },
	        success : function(resp){
	        	window.location.href = url;
	        }
	    });
	});

	$('#exportToWord').click(function(e){
		var template_id  	= $('#template_id').val();
		
		tinyMCE.triggerSave();
		var content 	= $('#editor3').val();
		var subject 	= $('.newsubject').html();
		var item_name 	= $('#previewLetterDrop2  option:selected').text();
		var lhead 		= $('select[name=lheads]').val();
		//alert(content);return false;
		$.ajax({
	        type: "POST",
	        dataType:'json',
	        //url: '/letters/generate-letter-action',
	        url : '/vsword/exportToWord.php',
	        data: { 'template_id':template_id, 'content':content, 'subject':subject, 'item_name':item_name, 'lhead':lhead, 'action':'exportToWord' },
	        beforeSend : function(){
	          	$(".show_loader").html('<img src="/img/spinner.gif" />');
	        },
	        success : function(resp){
	        	$(".show_loader").html('');
	        	window.open('/vsword/'+resp.name, '_blank');
	        }
	    });
	});






});

function getTemplateData(postData)
{
	$.ajax({
        type: "POST",
        dataType:'json',
        url: '/letters/generate-letter-action',
        data: { 'dropValue':postData['dropValue'], 'type':postData['type'], 'action':postData['action'] },
        success : function(resp){
        	CKEDITOR.instances['template_message_body'].setData(resp.templateBody);
        }
    });
}

function checkConfidential(postData)
{
	$.ajax({
        type: "POST",
        dataType:'json',
        url: '/letters/generate-letter-action',
        data: { 'template_id':postData['template_id'], 'checkbox':postData['checkbox'], 'action':'confidential' },
        success : function(resp){
        	
        }
    });
}

function saveTemplate(postData)
{
	/*if(postData['page_open'] == 2){
		var recipient_id = 0;
	}else{
		var recipient_id = $('#previewLetterDrop2').val();
	}*/
	var recipient_id = $('#previewLetterDrop2').val();

	if(postData['subject'] == ''){
		alert('Please enter subject line');
		$('#template_mail_subject').focus();
		return false;
	}else if(postData['content'] == ''){
		alert('Please enter content');
		return false;
	}else{
		$("#TemplateTextForm").ajaxForm({
	        dataType: 'json',
	        data : {'subject':postData['subject'], 'content':postData['content'], 'save_as':postData['save_as'], 'status':postData['status'], 'page_open':postData['page_open'], 'recipient_id':recipient_id},
	        beforeSend : function(){
				$(".show_loader").html('<img src="/img/spinner.gif" />');
				$(".previewLetterDrop").removeClass('disable_click');
				$("#page_open").val('3');
				$('.TAB, #tab_2, #tab_1').removeClass('active');
				$('#tabli_3, #tab_3').addClass('active');
				$('#tabli_3').removeClass('hide');

				$('.tab3_view, .tab23_view').show();
				$('.tab2_view, .tab1_view').hide();
	        },
	        success: function(resp) {
	        	$(".show_loader").html('');
	        	if(resp.message == 'error'){
	        		$(".show_loader").html('');
	        		alert('Please add atleast one contact');
	        		return false;
	        	}else{
	        		if(postData['save_as'] == 'F')
	        			window.location.href = '/letters/view-letter/1';
	        		else{
	        			$('#template_id').val(resp.template_id);
	        			$('#saveTemplateButton1 span').html('Save');
	        		}
				}

	        	//var content = CKEDITOR.instances['template_message_body'].getData();
	        	//var subject = $('#template_mail_subject').val();
	        	tinyMCE.activeEditor.setContent(resp.previews.newcontent);
				$('.newsubject').html(resp.previews.newsubject);

				/*$pageOpen 		= explode('-', $page_open);
				$recipient_id 	= $pageOpen[1];
				$data['recipient_id']	= $recipient_id;

				$newData = $this->getPreviewData($data);
				$data['newsubject'] = $newData['newsubject'];
				$data['newcontent'] = $newData['newcontent'];*/

	        }
	    }).submit();
	}
	
}

function saveAsTemplateDetails(postData)
{
	if(postData['subject'] == ''){
		alert('Please enter subject line');
		$('#template_mail_subject').focus();
		return false;
	}else if(postData['content'] == ''){
		alert('Please enter content');
		return false;
	}else{
		$("#TemplateTextForm").ajaxForm({
	        dataType: 'json',
	        data : {'subject':postData['subject'], 'content':postData['content'], 'save_as':postData['save_as'], 'status':postData['status']},
	        beforeSend : function(){
	          $(".show_loader").html('<img src="/img/spinner.gif" />');
	        },
	        success: function(resp) {
	        	$(".show_loader").html('');

	        	if(resp.message == 'error'){
	        		$(".show_loader").html('');
	        		alert('Please add atleast one contact');
	        		return false;
	        	}
	        }
	    }).submit();
	}
	
}


function generate_letter_action(dataArray)
{
	var dropValue 	= dataArray['dropValue'];
	var action 		= dataArray['action'];
	var searchValue = dataArray['searchValue'];
	var template_id = $('#template_id').val();

	$.ajax({
		type: "POST",
		url: '/letters/generate-letter-action',
		dataType:'json',
		data: {'dropValue':dropValue,'action':action,'searchValue':searchValue,'template_id':template_id },
		beforeSend : function(){
			$("#select_icon").removeClass('avoid-clicks');
			$("#custom_list").html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
		},
		success : function(resp){
			var option = '';
			$.each(resp, function(key, value){
				
			    if(dropValue == 'org' || dropValue == 'ind'){
			    	option += '<li style="margin-bottom:0px;" class="del_li_'+value.client_id+'_'+dropValue+'">';
			    	option += '<a href="javascript:void(0)" class="addToTable" data-item_type="'+dropValue+'" data-item_id="'+value.client_id+'">'+value.client_name+'</a>';
			    }else if(dropValue == 'staff'){
			    	option += '<li style="margin-bottom:0px;" class="del_li_'+value.user_id+'_'+dropValue+'">';
			    	option += '<a href="javascript:void(0)" class="addToTable" data-item_type="'+dropValue+'" data-item_id="'+value.user_id+'">'+value.staff_name+'</a>';
			    }else if(dropValue == 'other'){
			    	option += '<li style="margin-bottom:0px;" class="del_li_'+value.contact_id+'_'+dropValue+'">';
			    	option += '<a href="javascript:void(0)" class="addToTable" data-item_type="'+dropValue+'" data-item_id="'+value.contact_id+'">'+value.company_name+'</a>';
			    }else if(dropValue == 'group'){
			    	option += '<li style="margin-bottom:0px;" class="del_li_'+value.step_id+'_'+dropValue+'">';
			    	option += '<a href="javascript:void(0)" class="addToTable" data-item_type="'+dropValue+'" data-item_id="'+value.step_id+'">'+value.title+'</a>';
			    }
			    option += '</li>';
			});


			$("#custom_list").html("");
			$("#custom_list").html(option);
		}
	});
}

function add_new_client(item_id, item_type)
{
  var template_id = $('#template_id').val();
  $.ajax({
    type: "POST",
    url: '/letters/generate-letter-action',
	dataType:'json',
    data: { 'dropValue':item_type, 'action':'addToTable', 'item_id':item_id, 'template_id':template_id },
    beforeSend : function(){
		$("#tab1 tbody").html('<tr><td class="show_loader" colspan="2"><img src="/img/spinner.gif" /></td></tr>');
	},
    success : function(resp){
    	var list = '';
		$.each(resp, function(key, value){
			list += '<tr class="del_tabletr_'+value.recipient_id+'">';
			list += '<td align="center"><span class="custom_chk"><input type="checkbox" class="checkbox ads_Checkbox" name="checkbox[]" id="cst_'+value.recipient_id+'" value="'+value.recipient_id+'" data-item_type="'+value.item_type+'" /><label style="width:0px!important;margin-top:0px;" for="cst_'+value.recipient_id+'">&nbsp;</label></span></td>';
			list += '<td><a href="javascript:void(0)" class="openTaskPop" data-item_id="'+value.item_id+'">'+value.item_name+'</a></td>';
			//list += '<td align="center"><a target="_blank" href="javaecript:void(0)" class="job_sent_btn dynamicView">VIEW</a></td>';
			list += '</tr>';
    	});
    	$('#tab1 tbody').html(list);

		//refresh_datatable();
		//location.reload();
    }
  });
}

function refresh_datatable()
{
	$('#tab1').dataTable();
}

function deleteLetterContact(delete_ids)
{
	if(delete_ids.length>0){
        if(confirm("Do you want to delete?")){
            $.ajax({
                type: "POST",
                url: '/letters/generate-letter-action',
                data: { 'delete_ids' : delete_ids, 'action' : 'deleteItem' },
                success : function(resp){
                	$.each(delete_ids, function(key, value){
                		$('.del_tabletr_'+value).hide();
                	});
                }
            });
        }

	}else{
		alert('Please select atleast one clients');
	}
}

function deleteGenerateLetterContact(idArray)
{
	if(idArray.length>0){
        if(confirm("Do you want to delete?")){
            $.ajax({
                type: "POST",
                url: '/letters/generate-letter-action',
                data: { 'delete_ids' : idArray, 'action' : 'deleteGenerateLetter' },
                success : function(resp){
                	$.each(idArray, function(key, value){
                		$('.del_tabletr_'+value).hide();
                	});
                }
            });
        }

	}else{
		alert('Please select atleast one clients');
	}
}