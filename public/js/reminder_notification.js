$(document).ready(function(){
	$('.CheckallCheckbox').on('ifChecked', function(event){
		$('.reminderTable input').iCheck('check');
	});

	$('.CheckallCheckbox').on('ifUnchecked', function(event){
		$('.reminderTable input').iCheck('uncheck');
	});
    
    $('.open_template').click(function(){
        var service_id  = $(this).data('service_id');
        var template_no = $(this).data('template_no');
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '/reminder/template-action',
            data: { 'service_id':service_id, 'template_no':template_no, 'action':'get', 'id':'0' },
            beforeSend:function(){
              tinymce.get("template_message").setContent('');  
              $('.show_loader').html('<img src="/img/spinner.gif" />');
              $('#template11-modal').modal('show');
            },
            success : function(resp){
                $('.show_loader').html('');
                $('#id').val(resp.details.reminder_template_id);
                var service_name    = resp.services;
                var message         = resp.details.content;
                var practice_name   = resp.practices.display_name;
                var telephone       = resp.practices.telephone_no;
                
                var subject = resp.details.subject;
                subject = subject.replace("{TASK NAME}", service_name);
                $('#subject').val(subject);
                
                /* ================ Template Checking Start ============== */
                $('#tempServiceName').val(service_name);
                $('#tempPracticeName').val(practice_name);
                $('#tempTelephone').val(telephone);
                
                message = message.replace("{TASK NAME}", service_name);
                message = message.replace("{TASK NAME}", service_name);
                message = message.replace("{TASK NAME}", service_name);
                message = message.replace("{Alexander Rosse Limited}", practice_name);
                message = message.replace("{Telephone}", telephone);
                
                /* ================ Template Checking End ============== */
                console.log(message);
                tinymce.get("template_message").execCommand('mceInsertContent', false, message);
                
                /* ============= Status Dropdown Start ============== */
                var data = '<option value="2">Not Started</option>';
                if(resp.statuses.length >0){
                    $.each(resp.statuses, function(index, value){console.log(resp.statuses[index].step_id);
                        data += '<option value="'+resp.statuses[index].step_id+'">'+resp.statuses[index].title+'</option>';
                    });
                }
                $(".showStatusDrop").html(data); 
                /* ============= Status Dropdown End ============== */
                
            }
          });
    });
    
    $('.save_template').click(function(){
        var id      = $('#id').val();
        
        var service_name    = $('#tempServiceName').val();
        var service_name    = $('#tempServiceName').val();
        var practice_name   = $('#tempPracticeName').val();
        var telephone       = $('#tempTelephone').val();
        
        var subject = $('#subject').val();
        subject = subject.replace(service_name, "{TASK NAME}");

        
        /* ================ Template Checking Start ============== */
        var message = tinyMCE.get("template_message").getContent();
        message = message.replace(service_name, "{TASK NAME}");
        message = message.replace(service_name, "{TASK NAME}");
        message = message.replace(service_name, "{TASK NAME}");
        message = message.replace(practice_name, "{Alexander Rosse Limited}");
        message = message.replace(telephone, "{Telephone}");
        /* ================ Template Checking End ============== */
        
        console.log(message);//return false;
        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: '/reminder/template-action',
            data: { 'template_message':message, 'id':id, 'subject':subject, 'action':'save' },
            beforeSend:function(){
              //tinymce.get("template_message").setContent('');  
            },
            success : function(resp){
                $('.show_loader').html('<span style="color:green">Template successfully edited.</span>');
                //window.location.reload();
            }
          });
        
        
    })
    
    
    
    
});

$(window).load(function() {
    tinymce.init({
        height : "830px",
        selector: "#template_message",
        plugins: [ "advlist autolink lists link image charmap print preview anchor", "searchreplace visualblocks code fullscreen", "insertdatetime media table contextmenu paste", "wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code"],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });


    //CKEDITOR.replace( 'template_message',{ 
        //toolbar :[['Source'],['Cut','Copy','Paste','PasteText','SpellChecker'],['Undo','Redo','-','SelectAll','RemoveFormat'],['CreatePlaceholder'],[ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ], ['SpecialChar','PageBreak']],
       
        //extraPlugins : 'wordcount',
        //extraPlugins : 'wordcount,placeholder',
        //height: '400px',
        /*wordcount : {
            showCharCount : true,
            showWordCount : true
        }*/
    //});   
});