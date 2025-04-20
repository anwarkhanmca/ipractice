

$('#sharefiles').hide();
$(document).on("click", "#tab4sharefile", function(){
   $('#sharefiles').show();
});
$(document).on("click", "#tab3signdocs", function(){
   $('#sharefiles').hide();
});
$(document).on("click", "#tab2send", function(){
   $('#sharefiles').hide();
});
$(document).on("click", "#tab1signanddoc", function(){
   $('#sharefiles').hide();
});


$(document).ready(function(){
	$('#content').attr("disabled", "disabled");
	var user_type = $('#user_type').val();
	if(user_type == 'C'){
		var url = '/file-and-sign/';
	}else{
		var url = '';
	}
	
	$('#client_name').keyup(function(event){
        event.preventDefault()
		var client_name = $(this).val();
		if(client_name == ''){
			$('#search_client').html('');
		}else{
			$.ajax({
			    type: "POST",
			    //dataType : 'json',
                dataType : 'html',
			    url: url+'ajax-documents.php',
			    data: { 'client_name' : client_name, 'action' : 'search_client' },
			    beforeSend : function(){
			    	$('#search_client').html('<li style="text-align:center"><a href="#"><img src="/img/spinner.gif" /></a></li>');
			    },
			    success : function(resp){
                   $("#search_client").html(resp);
                   //$( "#content" ).removeClass( "avoid-clicks" );
			    },
			    error: function (jqXHR, textStatus, error) {
			        console.log("ERROR");
			    }
			});
		}
		
	});

	$('body').on('click', '.putClientName', function(){
		var client_id   = $(this).data('client_id');
		var client_name = $(this).data('client_name');
		$('#client_id').val(client_id);
		$('#showClientName').html(client_name);
		$('.open_client_drop').hide();
        
        if($('#client_id').val() != "")
            $( "#content" ).removeClass( "avoid-clicks" );
        
        $.ajax({
		    type: "POST",
		    dataType : 'html',
		    url: url+'ajax-documents.php',
		    data: { 'client_id' : client_id, 'action' : 'all' },
		    success : function(resp){
		    	$('#document_ul').html($.trim(resp));
		    },
		    error: function (jqXHR, textStatus, error) {
		        alert("ERROR");
		    }
		});
	});

	$('#document_name').keyup(function(){
		var client_id 	= $('#client_id').val();
		var value 		= $(this).val();
		searchDocument(url, client_id, value);
	});

	$('#document_name').focus(function(){
		var client_id 	= $('#client_id').val();
		searchDocument(url, client_id, '');
	});


	/*$('#client_id').on('change', function(){
		var client_id = $(this).val();
		$.ajax({
		    type: "POST",
		    dataType : 'html',
		    url: url+'ajax-documents.php',
		    data: { 'client_id' : client_id, 'action' : 'all' },
		    success : function(resp){
		    	$('.document_ul').html(resp);
		    },
		    error: function (jqXHR, textStatus, error) {
		        alert("ERROR");
		    }
		});
	});*/

	$('body').on('click', '.view_document', function(){
		var file_id = $(this).data('file_id');
		var title 	= $(this).data('title');
		$.ajax({
		    type: "POST",
		    dataType : 'text',
		    url: url+'ajax-documents.php',
		    data: { 'file_id' : file_id, 'action' : 'name' },
		    beforeSend : function(){
		    	$('#document_name').val(title);
				$('#search_file').html('');
                $('#showdocument').attr('src', '../img/spinner.gif');
            },
		    success : function(resp){//console.log('../uploads/client_doc/'+resp);
		    	if(resp == ''){
		    		$('#showdocument').attr('src', '');
		    	}else{
		    		$('#showdocument').attr('src', '../uploads/client_doc/'+$.trim(resp));
		    	}
		    	
		    },
		    error: function (jqXHR, textStatus, error) {
		        console.log("ERROR");
		    }
		});
	});

	$('body').on('click', ".delete_files", function(event) {
        var file_id = $(this).data('file_id');
        //var click = event.triger;
        $.ajax({
            type: "POST",
            dataType : 'text',
            url: '/file-and-sign/ajax-documents.php',
            data: { 'file_id' : file_id, 'action' : 'delete' },
            success : function(resp){
                $('.file_hide_'+file_id).hide();
            },
            error: function (jqXHR, textStatus, error) {
                alert("ERROR");
            }
        });
    });

    $("#select_icon").click(function(event) {
    	$('#content').hide();
    	$('.showdocument').show();
    });
    
    $("#select_icon_type").click(function(event) {
    	//$('#search_client').html('');
        $('#client_name').val('');
    	$('.open_client_drop').toggle();
    });
    
    $('body').on('click', ".upload_new", function(event) {
    	$('.showdocument').hide();
    	$('#content').show();
        $('#content .jFiler-items-grid').html('');
        if($('#client_id').val() != "")
            $( "#content" ).removeClass( "avoid-clicks" );
    });
	
	
});//main document end


function searchDocument(url, client_id, search_text)
{
	$.ajax({
	    type: "POST",
	    dataType : 'html',
	    url: url+'ajax-documents.php',
	    data: {'client_id':client_id, 'search_text':search_text, 'action':'all' },
	    beforeSend : function(){
	    	$('#search_file').html('<ul class="search_content"><li style="text-align:center"><a href="#"><img src="/img/spinner.gif" /></a></li></ul>');
	    },
	    success : function(resp){
	    	var content = '';
	    	if (resp != '') {
	            $("#search_file ul").html(resp);
			}else{
				$('#search_file').html('');
			}	    	
	    },
	    error: function (jqXHR, textStatus, error) {
	        console.log("ERROR");
	    }
	});
}

function saveDocument(client_id, doc_name)
{
	console.log('saveDocument : '+doc_name);
	$.ajax({
	    type: "POST",
	    dataType : 'html',
	    url: '/file-and-sign/ajax-documents.php',
	    data: {'client_id':client_id, 'doc_name':doc_name, 'action':'insert_doc' },
	    success : function(resp){
	    	$('#document_ul').append(resp);
	    },
	    error: function (jqXHR, textStatus, error) {
	        console.log("ERROR");
	    }
	});
}

function removeDocument(client_id, doc_name)
{
	$.ajax({
	    type: "POST",
	    dataType : 'html',
	    url: '/file-and-sign/ajax-documents.php',
	    data: {'client_id':client_id, 'doc_name':doc_name, 'action':'delete_doc' },
	    success : function(resp){
	    	//$('.document_ul').append(resp);
	    },
	    error: function (jqXHR, textStatus, error) {
	        console.log("ERROR");
	    }
	});
}