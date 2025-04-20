function CountCharacters() {
    var body = tinymce.get("add_message").getBody();
    var content = tinymce.trim(body.innerText || body.textContent);
    return content.length;
}

function openModal(noticefont_id) {
    tinymce.remove();
    tinymce.init({
	    selector: "#edit_message1",
	   // elements : "notesmsg",
	    plugins: [
	        "advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste"
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code" ]
	});
    
	$.ajax({
		type: "POST",
		url: '/editnotice-template',
		data: {
			'noticefont_id': noticefont_id
		},
		beforeSend : function(){
			$("#compose-modal1").modal("show");
		},
		success: function(resp) {
			
			setTimeout(function() {
				//alert(resp['file'])
				if (resp['file'] != null) {
					var attachment = resp['file'];
					var res = attachment.substring(2);
				}
				$('#typecatagory1').val(resp.typecatagory);
				$('#edit_notice_template_id1').val(resp.noticefont_id);
				$('#message_subject1').val(resp.message_subject); //
				$('#edit_attach_file2').empty().html(res);
				$('#hidd_file').empty().val(resp['file']);
                
                var tyn = tinyMCE.activeEditor.setContent(resp.message);
                $('#edit_message1').val(tyn);
				var ch = resp.checkbox;
				var str_array = ch.split(',');
				var gid = resp.group;
				var content = '';
				$.each(gid, function(key, value) {
					var groupids = value.user_id;
					console.log(groupids);
				});
				var str = resp.checkbox;
				$(".chknotifys").each(function(index, element) {
					var box = $(this).val();
					if (str.indexOf(box) != -1) {
						$("#notifycheck" + box).iCheck('check');
					}
				});
				$('#edit_attach_file1').empty().html(resp['file']);
			}, 1000);
		}
	});
}

function addNotesValidation()
{
	var noticeMaxLength = $('#noticeMaxLength').val();
	var writtenWords = $.parseHTML( $.trim(tinymce.get('add_message').getContent()) );
    writtenWords = $(writtenWords).text();
    if(writtenWords.length > noticeMaxLength){
		alert("You can't exceed "+noticeMaxLength+" character for the text");
		return false;
	}else{
		return true;
	}
}

$("#fixed_add").click(function(){
    
    tinymce.remove();
     tinymce.init({
     	/*setup: function (ed) {
            ed.on('keyup', function (e) {
                var count = CountCharacters();
                document.getElementById("character_count").innerHTML = "Characters: " + count;
                if (count > 5) {
			        //alert("Maximum " + 5 + " characters allowed.")
			        //return false;
			    }
            });
        },*/
    	selector: "#add_message",
	   // elements : "notesmsg",
	    plugins: [
	        "advlist autolink lists link image charmap print preview anchor",
	        "searchreplace visualblocks code fullscreen",
	        "insertdatetime media table contextmenu paste"
	    ],
	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code" ]
});
    
});
$("#fixed_add2").click(function(){
    
    tinymce.remove();
     tinymce.init({
    selector: "#add_message",
   // elements : "notesmsg",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code" ]
});
    
});



function openbodyModal(noticefont_id,e) {
    if (!e) e = window.event;
    $.ajax({
		type: "POST",
		//dataType: "html",
		url: '/editnotice-template',
		data: {
			'noticefont_id': noticefont_id
		},
		success: function(resp) {
			$("#compose-msgmodal").modal("show");
            
			setTimeout(function(event) {
			 //alert( event.type );
				if (resp['file'] != null) {
					var attachment = resp['file'];
					var res = attachment.substring(2);
				}
				var msg = (resp.message);
                
               // console.log(msg);
				$('#edit_msgmessage').html(msg);
				$('#noticeTitle').html(resp.message_subject);
				
			});
		}
	});
 
}
$(function() {
	$('#edit_msgmessage').attr('disabled', 'disabled');
});

$(".chknotifys").on('ifUnchecked', function(event) {
	var num = parseInt($(this).attr('id').match(/\d+/)[0], 10);
	$("#chknotify" + num).val('');
	// alert(num);
});
$(".chknotifys").on('ifChecked', function(event) {
	var num = parseInt($(this).attr('id').match(/\d+/)[0], 10);
	$("#chknotify" + num).val(num);
	//alert(num);
});

function delfun(id) {
   	return confirm("You want to delete??");
}

function delattachfun() {
	return confirm("You want to delete Attachment??");
}

var looper = $(".upload-buttons");
$.each(looper, function(key, value) {
	//console.log(value); return false;

	$(value).on('change', function() {
		var control = $(this);
		var loop = $(this).attr("data-looper");

		$("#prev").html('');
		$("#prev").html('Uploading.....');
		$("#imageform" + loop).ajaxForm({
			success: function(response) {
				control.replaceWith(control = control.clone(true));
				x = response;
				$("#file_value" + loop).html('<img src="img/attachment.png" />');
				$("#prev").html('');
			}
		}).submit();
	});
}); /*;*/
//upload
// upload pdf


$(".upbutton").click(function() {
	$("#upform").ajaxForm({
		beforeSend : function(){
			$('.show_loader').html('<img src="/img/spinner.gif" />');
		},
		success: function(response) {
			//var bno = $("#board_no").val();
           	//window.location='/noticeboard/'+bno;
           	window.location.reload();	
		}
	});
});


$(".pdf").click(function() {
	var id = $(this).attr("id").match(/\d+/);
	
	$('#add_pdffile' + id).on('change', function() {
		$("#pdfeform" + id).ajaxForm({
			beforeSend : function(){
				$('#show_notice').html('<img src="/img/spinner.gif" />');
			},
			success: function(resp) {
				
				$('#show_notice').html('<iframe width="900"  height="500" src="/uploads/46/noticepdf/'+resp+'"></iframe>');
			}
		}).submit();
	});
});

$(".open").click(function() {
	var data_id = $(this).data('id');
	///////////Validation//////////////
	var remove_id = data_id - 1;
	$("#tab_" + data_id).addClass("active");
	$("#tab_" + remove_id).removeClass("active");
	$(".tab-pane").fadeOut("fast");
	$("#step" + data_id).fadeIn("slow");
});
$(".open_header").click(function() {
	var data_id = $(this).data('id');
	$('#board_no').val(data_id);
	///////////Validation//////////////
	if (data_id == 3) {
		if ($("#ni_number").val() == "") {
			alert("ni_number name can not be null");
			$("#ni_number").focus();
			return false;
		}
	}
	///////////Validation//////////////
	$("#header_ul li").parent().find('li').removeClass("active");
	$(this).parent('li').addClass('active');
	$(".tab-pane").fadeOut("fast");
	$("#step" + data_id).fadeIn("slow");
});
$(".back").click(function() {
	var data_id = $(this).data('id');
	var remove_id = Number(data_id) + Number(1);
	$("#tab_" + data_id).addClass("active");
	$("#tab_" + remove_id).removeClass("active");
	$(".tab-pane").fadeOut("fast");
	$("#step" + data_id).fadeIn("slow");
});
//board 1 8 adding
$(".add_new").click(function() {
	var numItems = $('.limitboard').length;
	if (numItems < 8) {
		$("#compose-modal").modal("show");
	} else {
		alert("Delete existing  post first before adding New");
	}
});
//board 1 8 adding

//board 2 8 adding
$(".add_new2").click(function() {
	var numItems = $('.limitboard2').length;
    if (numItems < 8) {
		$("#compose-modal").modal("show");
	} else {
		alert("Delete existing  post first before adding New");
	}
});
//board 2 8 adding



// sortable
$(function() {
    
	$("#sortable").sortable({
		stop: function(event, ui) {
            var toSend = [], param = {};
            var sorted = $( "#sortable" ).sortable( "toArray" );
            //alert(sorted);
            for(var i in sorted){
                //console.log(sorted[i]);
                var each = parseInt(sorted[i]);
                if(each){
                    toSend.push(each);
                }
            }
            param = {
                order: toSend.join(",")
            }
            
            console.log(param);
            $.ajax({
                url: '/swap-board1',
                type: 'POST',
                data: param,
                success: function(){
                   console.log("updated");
                },
                error: function(data){
                    console.log("ERROR", data);
                }
            });
        }
	});
	$("#sortable").sortable({
        helper:'clone',
        //revert:true
        }).disableSelection();

 
});


$(function() {
	$("#sortable2").sortable({
    
        stop: function(event, ui) {
            var toSend = [], param = {};
            var sorted = $( "#sortable2" ).sortable( "toArray" );
            
            for(var i in sorted){
                //console.log(sorted[i]);
                var each = parseInt(sorted[i]);
                if(each){
                    toSend.push(each);
                }
            }
            param = {
                order: toSend.join(",")
            }
             console.log(param);
            $.ajax({
                url: '/swap-board1',
                type: 'POST',
                data: param,
                success: function(){
                     	
                    console.log("updated2");
                },
                error: function(data){
                    
                    console.log("ERROR2", data);
                }
            });
        }
            
            
    	});
        $("#sortable2").sortable({
        helper:'clone',
        //revert:true
        }).disableSelection();
	//$("#sortable2").disableSelection();
});
//save

//sortable

// ajax submit board 2 //////

$(document).ready(function(){
	$('#showpdfview').hide('');
});


$(function() {
	$('input').on('ifClicked', function (event) {
        //$('#showpdfview').show('');
        $(".pdfviwerclass").iCheck('uncheck')
        $(this).iCheck('check')
        var value = $(this).val();
        var file_type =	$("#pdf").val();
        $.ajax({
			type: "POST",
			//dataType: "html",
			url: '/viewfilenoticeboard',
			data: { 'file_type':file_type ,'value':value },
			success: function(resp) {
		  		if(resp != ""){
	                $('#showpdfview').attr('src', resp)
	                $('#showpdfview').show('');
	            }
	            else{
	                $('#showpdfview').hide('');
	            }
            }
		}); 
    });
});

$(document).click(function() {
	$(".open_toggle").hide();
});
$("#select_icon").click(function(event) {
  $(".open_toggle").toggle();
  event.stopPropagation();
});


$(document).click(function() {
	$(".open_toggle").hide();
});
$("#select_iconpdf").click(function(event) {
  $(".open_toggle").toggle();
  event.stopPropagation();
});
  
$(".pdfviewclass").on('click', function(event) {
    var fileid=$(this).attr('id');
   	var filename = $(this).text();
  	
  	$.ajax({
		type: "POST",
		//dataType: "html",
		url: '/viewfilenoticeboard',
		data: { 'fileid':fileid },
		beforeSend : function(){
			$('#show_notice').html('<img src="/img/spinner.gif" />');//return false;
		},
		success: function(resp) {
		  	if(resp != ""){
                $('#show_notice').html('<iframe id="showquotepdfview" width="900"  height="500" src="'+resp+'"></iframe>');
            }
            else{
                $('#show_notice').html('');
            }
        }
	});      
});

$("body").on('click', ".deleteNoticeFiles", function(event) {
	var file_id = $(this).attr('data-file_id');
	$.ajax({
		type: "POST",
		url: '/deletefilenoticeboard',
		data: { 'file_id':file_id },
		beforeSend : function(){
			$('#show_notice').html('<img src="/img/spinner.gif" />');//return false;
		},
		success: function(resp) {
			$('#show_notice').html('');
		  	$('.delete_'+file_id).hide();
        }
	});
});
  
