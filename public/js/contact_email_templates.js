$(document).ready(function(){
	$('#getPlaceholder').change(function(){
		var module = $(this).val();
		
		$('#showPlaceholders').empty();
		
		$.ajax({
			url:'/placeholder/by-module/'+module,
			dataType:'json',
			success:function(data){
				jQuery.each(data, function(k,v){
					var link = '<a class="addThisPlaceholder">['+ v.table +'.'+ v.field +']</a>';
					var optn = '<li>'+ link + ' - ' + v.display_name +'</li>';
					$('#showPlaceholders').append(optn);
				});
			},
			error:function(data){
				alert(data);
			},
			fail:function(data){
				alert(data);
			}
		});
	});

	/*$('.edit_template').click(function(){
		var template_id=$(this).data('template_id');
		var url=$(this).data('url');
		
		$.ajax({
			url:url,
			type: "GET",
	    	dataType: "json",
			success:function(tpl){
				var data=tpl['0'];
				$('#template_id').val(data.id);
				$('#template_name').val(data.name);
				$('#template_subject').val(data.subject);
				console.log(data);
				jQuery.get('../../email_templates/' + data.name+'.txt?'+(new Date()).getTime(), function(f) {
					//process text file line by line
					//$('#template_message').val(f);

					// add template data to the CK Editor 
					CKEDITOR.instances['template_message'].setData(f)
				});
				
				$("select#template_type")[0].selectedIndex = data.type;
				
				$('#compose-modal').modal('show');
			},
			error:function(e){
				alert('e');
			}
		});	
	});	*/

	$('.do-with-ajax').click(function(e){
		var url=$(this).attr('href');
		e.preventDefault();
		$.ajax({
			url:url,
			success:function(d){
				alert(d);
				location.reload();
			},
			error:function(e){
				alert(e);
			}
		});
	});

	$('#changePlaceHolder').change(function() {
    	var dropValue 	= $(this).val();
    	var page_name 	= $(this).data('page_name');

    	if(dropValue != ''){
    		$.ajax({
	            type: "POST",
	            url: '/letters/generate-letter-action',
	            dataType:'json',
	            data: { 'dropValue' : dropValue, 'action' : 'getPlaceHolder' },
	            beforeSend : function(){
		          $(".placeholderList").html('<li style="text-align:center;"><img src="/img/spinner.gif" /></li>');
		        },
	            success : function(resp){
	            	var list = '';
					$.each(resp, function(key, value){
						if(dropValue == 'staff' || dropValue == 'org' || dropValue == 'general' || dropValue == 'ind' || dropValue == 'practice' || dropValue == 'address')
	            			list += '<li><a href="javascript:void(0)" class="addNewPlaceholder" data-paceholdId="'+value.placeholder_id+'" data-short_name="'+value.short_name+'">'+value.view_name+'</a></li>';
	            		else if(dropValue == 'proposal_general'){
	            			if(page_name == 'proposal'){
	            				list += '<li><a href="javascript:void(0)" class="addProposalPlaceholder" data-paceholdId="'+value.placeholder_id+'" data-short_name="'+value.short_name+'">'+value.view_name+'</a></li>';
	            			}else{
	            				list += '<li><a href="javascript:void(0)" class="addLetterPlaceholder" data-paceholdId="'+value.placeholder_id+'" data-short_name="'+value.short_name+'">'+value.view_name+'</a></li>';
	            			}
	            		}
	            		else
	            			list += '<li><a href="javascript:void(0)" class="" data-paceholdId="'+value.placeholder_id+'" data-short_name="'+value.short_name+'">'+value.view_name+'</a></li>';
	            	});
	            	$('.placeholderList').html(list);
	            }
	        });
    	}else{
    		$('.placeholderList').html('');
    	}
	});

	$('body').on('click', '.EditContactTemplate', function(){
		var template_id = $(this).data('template_id');
		window.open('/email/template/edit/'+template_id, '_blank');
	});

	$('body').on('click', '.copyContactTemplate', function(){
		var template_id = $(this).data('template_id');
		//window.open('/email/template/add/'+template_id, '_blank');
		window.open('/letters/generate-letter/2/0/'+template_id+'-0/T', '_blank');

	});

	$('.deleteContactTemplate').click(function() {
		var val = [];
		val[0] = $(this).data('template_id');
    
	    deleteContactTemplate(val);
	});




});





$.fn.insertAtCaret = function (CKEi,myValue) {
    myValue = myValue.trim();
    CKEDITOR.instances[CKEi].insertText(myValue);
};

$(document).on('click','.addThisPlaceholder',function(){
		//Insert Placeholder to CK Editor at cursor possition
		$.fn.insertAtCaret('template_message',$(this).html());
});

$(document).on('click','.addNewPlaceholder',function(){
	$.fn.insertAtCaret('template_message_body', '['+$(this).html()+']');
});

$(document).on('click','.addLetterPlaceholder',function(){
	$.fn.insertAtCaret('pnTempDesc', '['+$(this).html()+']');
});

$(document).on('click','.addProposalPlaceholder',function(){
	//$.fn.insertAtCaret('coverLtrText', '['+$(this).html()+']');
	var contact_type 	= $('#NewPropContctType').val();
	var client_id 		= $('#propContactList').val();
	var short_name 		= $(this).data('short_name');

	var coverLtrText = '';
	var index = 0;
	if(short_name == 'client_name'){
		coverLtrText = $('#propContactList option:selected').text();
		index = 1
	}else if(short_name == 'client_contact'){
		coverLtrText = $('#propContactDrop option:selected').text();
		coverLtrText = (coverLtrText=='Select Contact')?'':coverLtrText;
		index = 1
	}else if(short_name == 'proposal_id'){
		coverLtrText = $('#ProposalID').val();
		index = 1
	}else if(short_name == 'proposal_title'){
		coverLtrText = $('#PropTitle').val();
		index = 1
	}else if(short_name == 'proposal_validity'){
		coverLtrText = $('#propValidity').val();
		index = 1
	}else if(short_name == 'proposa_start_date'){
		coverLtrText = $('#ProsStartDate').val();
		index = 1
	}else if(short_name == 'proposal_end_date'){
		coverLtrText = $('#ProsEndDate').val();
		index = 1
	}else if(short_name == 'today_date'){
		var months = [ "January", "February", "March", "April", "May", "June", 
               "July", "August", "September", "October", "November", "December" ];
		var d 		= new Date();
		//var month 	= d.getMonth()+1;
		var month 	= months[d.getMonth()];
		var day 	= d.getDate();
		//var coverLtrText = (day<10 ? '0' : '') + day +'-' +month+'-' + d.getFullYear();
		var coverLtrText = month+' '+(day<10 ? '0' : '') + day +', '+d.getFullYear();
		index = 1
	}

	if(coverLtrText == ''){
		$.ajax({
	        type: "POST",
	        dataType:'json',
	        url: '/template/email-templates-action',
	        data: { 'contact_type':contact_type, 'client_id':client_id, 'short_name':short_name, 'action':'nameByplaceHolder' },
	        beforeSend:function(){
	        	//$('.show_loader').html('<img src="/img/spinner.gif">');
	        },
	        success:function(resp){
	        	var details = resp.details;
	        	var content = details.replace(/,/g, '\n');//console.log(content)
	        	//content = details.replace(/\n/g, ',');
	        	$.fn.insertAtCaret('coverLtrText', content);
	        }
	    });
	}else{
		$.fn.insertAtCaret('coverLtrText', coverLtrText);
	}
});

function insertAtCaret(areaId,text) {
	var txtarea = document.getElementById(areaId);
	var scrollPos = txtarea.scrollTop;
	var strPos = 0;
	var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ? 
		"ff" : (document.selection ? "ie" : false ) );
	if (br == "ie") { 
		txtarea.focus();
		var range = document.selection.createRange();
		range.moveStart ('character', -txtarea.value.length);
		strPos = range.text.length;
	}
	else if (br == "ff") strPos = txtarea.selectionStart;
	
	var front = (txtarea.value).substring(0,strPos);  
	var back = (txtarea.value).substring(strPos,txtarea.value.length); 
	txtarea.value=front+text+back;
	strPos = strPos + text.length;
	if (br == "ie") { 
		txtarea.focus();
		var range = document.selection.createRange();
		range.moveStart ('character', -txtarea.value.length);
		range.moveStart ('character', strPos);
		range.moveEnd ('character', 0);
		range.select();
	}
	else if (br == "ff") {
		txtarea.selectionStart = strPos;
		txtarea.selectionEnd = strPos;
		txtarea.focus();
	}
	txtarea.scrollTop = scrollPos;
}


function deleteContactTemplate(idArray)
{
	if(idArray.length>0){
        if(confirm("Do you want to delete?")){
            $.ajax({
                type: "POST",
                url: '/template/email-templates-action',
                data: { 'delete_ids' : idArray, 'action' : 'deleteContactTemplate' },
                beforeSend:function(){
                	$('.show_loader').html('<img src="/img/spinner.gif">');
                },
                success : function(resp){
                	$('.show_loader').html('');
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
