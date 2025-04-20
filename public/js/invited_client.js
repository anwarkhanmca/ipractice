$(document).ready(function(){
    //$('#content').attr("disabled", "disabled");


    $(document).click(function() {
        $(".open_toggle").hide();
    });
    $("#select_icon").click(function(event) {
        $(".open_toggle").toggle();
        $('#content').hide();
        $('.showdocument').show();
        event.stopPropagation();
    });
    $('body').on('click', ".upload_new", function(event) {
        $('.showdocument').hide();
        $('#content .jFiler-items-grid').html('');
        $('#content').show();

        //$('#select_icon').addClass('disable_click');
        //$('#select_icon_type').removeClass('disable_click');
    });
    
    $("#select_icon_type").click(function(event) {
    	//$('#search_client').html('');
        $('#client_name').val('');
    	$('.open_client_drop').toggle();

    });

    $('#client_name').keyup(function(){
        var client_id   = $('#client_id').val();
        var postData = [];
        postData['client_name'] = $(this).val();
        postData['portal']      = $('#portal').val();
        postData['action']      = 'search_client';

        search_client(postData);

        /*if(client_name == ''){
            $('#search_client').html('');
        }else{
            $.ajax({
			    type: "POST",
			    //dataType : 'json',
                dataType : 'html',
			    url: '/file-and-sign/ajax-documents.php',
			    data: { 'client_name' : client_name, 'portal':portal, 'action' : 'search_client' },
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
        }*/
        
    });

    $('body').on('click', '#select_icon_type', function(){
        var postData = [];
        postData['client_name'] = '';
        postData['portal']      = $('#portal').val();
        postData['action']      = 'search_client';

        search_client(postData);
    });
    

    $('body').on('change', '.putClientName', function(){
        var client_id   = $(this).val();
        $('#client_id').val(client_id);
		//var client_name = $(this).data('client_name');
		
		//$('#showClientName').html(client_name);
		//$('.open_client_drop').hide();
        
        if(client_id != "")
            $( "#content" ).removeClass( "avoid-clicks" );
        
        $.ajax({
            type: "POST",
            dataType : 'html',
            url: '/file-and-sign/ajax-documents.php',
            data: { 'client_id' : client_id, 'action' : 'all' },
            success : function(resp){
                var content = $.trim(resp);
                $('#select_icon').removeClass('disable_click');
                if(content == ''){
                    $('#select_icon').addClass('disable_click');
                    //$('#select_icon_type').removeClass('disable_click');
                    $('.showdocument').hide();
                    $('#content').show();
                }else{
                    $('#select_icon').removeClass('disable_click');
                    //$('#select_icon_type').addClass('disable_click');
                    $('#content').hide();
                    $('#showdocument').attr('src', '');
                    $('.showdocument').show();
                }
                $(".jFiler-items-list").html('');
                $('#document_ul').html(content);
            },
            error: function (jqXHR, textStatus, error) {
                alert("ERROR");
            }
        });
    });

    $('body').on('click', '.view_document', function(){
        var file_id = $(this).data('file_id');
        var title   = $(this).data('title');
        $.ajax({
            type: "POST",
            dataType : 'text',
            url: '/file-and-sign/ajax-documents.php',
            data: { 'file_id' : file_id, 'action' : 'name' },
            beforeSend : function(){
                $('#document_name').val(title);
                $('#search_file').html('');
                $('#showdocument').attr('src', '/img/spinner.gif');
                $('.select2-container').removeClass('disable_click');
            },
            success : function(resp){

                if(resp == ''){
                    $('#showdocument').attr('src', '');
                }else{
                    $('#showdocument').attr('src', '/uploads/client_doc/'+$.trim(resp));
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

    

//############## Get Client details portion start ################//
    $("#view_edit_company").hide();
    $('#getClientDetails').change(function() {
        var client_id = $(this).val();
        //alert(client_id);return false;
        if(client_id != "" ){
            $("#view_edit_company").show();
            
            $.ajax({
                type: "POST",
                //dataType: "json",
                url: '/ic/ajax-client-details',
                data: { 'client_id' : client_id },
                beforeSend: function() {
                    $(".show_client_details").html('<img src="/img/spinner.gif" />');
                    //return false;
                },
                success : function(resp){
                    if(resp != ""){
                        $(".show_client_details").html(resp);
                    }else{
                        $(".show_client_details").html("");
                    }
                }
            });
        }else{
            $("#view_edit_company").hide();
            $(".show_client_details").html("");
        }
    });
    //############## Get Client details portion end ################//

    //############## Go to view/edit details portion start ################//
    $('#view_edit_company').click(function() {
        var type_id = $(this).data('type');
        //console.log(type_id);
        var client_id = $("#getClientDetails").val();
        if(client_id == ""){
            alert("Please select client first");
            //return false;
        }else{
            
            window.location.href = "/client/edit-org-client/"+client_id+"/"+type_id;
        }
    });
    //############## Go to view/edit details portion end ################//
    
    

    
});


function search_client(postData)
{
    $.ajax({
        type: "POST",
        //dataType : 'json',
        dataType : 'html',
        url: '/file-and-sign/ajax-documents.php',
        data: { 'client_name' : postData['client_name'], 'portal':postData['portal'], 'action' : postData['action'] },
        beforeSend : function(){
            $('#search_client').html('<li style="text-align:center"><a href="#"><img src="/img/spinner.gif" /></a></li>');
        },
        success : function(resp){
           $("#search_client").html(resp);
        },
        error: function (jqXHR, textStatus, error) {
            console.log("ERROR");
        }
    });
}


function saveDocument(client_id, doc_name)
{
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