function openModal( template_id )
{//console.log(template_id);
	$.ajax({
	    type: "POST",
	    dataType: "json",
	    url: '/template/edit_template',
	    data: { 'template_id' : template_id },
	    success : function(resp){
	       console.log(resp);
           
			$('#edit_email_template_id').val(resp['email_template_id']);
	    	$('#edit_name').val(resp['name']);
	    	$('#edit_title').empty().val(resp['title']);
	    	$('#hidd_file').empty().val(resp['file']);
	    	$('#edit_attach_file').empty().html(resp['file']);
			CKEDITOR.instances['edit_message'].setData(resp['message']);

			getTemplateType( resp['template_type_id'] );

	    	$('#edit-modal').modal('show');
			
			
	    }
	});
}

function getTemplateType( tmpl_typ_id )
{
	$.ajax({
	    type: "POST",
	    url: '/template/get-edit-template-type',
	    data: { 'tmpl_typ_id' : tmpl_typ_id },
	    success : function(resp){
	    	//console.log(resp);
	    	$('#edit_template_type').empty().html(resp);
	    }
	});
}

function getTemplate( template_id, process )
{
	$.ajax({
	    type: "POST",
	    dataType: "json",
	    url: '/template/get_template',
	    data: { 'template_id' : template_id },
	    success : function(resp){
	    	//console.log(resp);
	    	if(resp != "fail"){
	    		$('#'+process+'_title').empty().val(resp['title']);
	    		CKEDITOR.instances[process+'_message'].setData(resp['content']);
	    	}else{
	    		$('#'+process+'_title').val("");
	    		CKEDITOR.instances[process+'_message'].setData("");
	    	}
	    	
	    }
	});
}

function form_validation()
{
	if($('#edit_template_type').val() == ""){
		alert("Please select template type");
		return false;
	}else{
		$("#edit_form").submit();
		return true;
	}
}


$(document).ready(function(){

	$('.deleteTemplate').click(function(event){
		var eml_tmpl_id = $(this).data('eml_tmpl_id');
		if (confirm("Do you want to delete this template")) {
			$.ajax({
			    type: "POST",
			    url: '/template/delete-email-template',
			    data: { 'eml_tmpl_id' : eml_tmpl_id },
			    success : function(resp){
			    	if(resp == "success"){
			    		location.reload();
			    	}else{
			    		$('#msg').html('<p style="color:red; font-size:15px;">There are some error to delete this email template.</p>')
			    	}
			    }
			});
		}
		
	});


//################### Delete Template Attach File Start ###########################//

	$('.deleteTemplateFile').click(function(event){
		var eml_tmpl_id = $(this).data('eml_tmpl_id');
		var file = $(this).data('file');
		if (confirm("Do you want to delete this attach file")) {
			$.ajax({
			    type: "POST",
			    url: '/template/delete-attach-file',
			    data: { 'eml_tmpl_id' : eml_tmpl_id, 'file' : file },
			    success : function(resp){
			    	if(resp == "success"){
			    		location.reload();
			    	}else{
			    		$('#msg').html('<p style="color:red; font-size:15px;">There are some error to delete this email template.</p>')
			    	}
			    }
			});
		}
		
	});
    
//###################Delete Template Attach File Start ###########################//





});


$(window).load(function() {
    
    CKEDITOR.replace( 'add_message',
    { 
        toolbar :[
        ['Source'],['Cut','Copy','Paste','PasteText','SpellChecker'],['Undo','Redo','-','SelectAll','RemoveFormat'],['CreatePlaceholder'],[ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','StrikeThrough' ],['SpecialChar','PageBreak']
        ],
       
        extraPlugins : 'wordcount,placeholder',
        wordcount : {
            showCharCount : true,
            showWordCount : true
            
            
        }
    });
    
    
/*var editor = CKEDITOR.instances.doc_desc;
editor.on( 'key', function( evt ){
    limitChars(evt, 100, 'cke_wordcount_doc_desc');
   
}); */ 

CKEDITOR.replace( 'edit_message',
    { 
        toolbar :[['Source'],['Cut','Copy','Paste','PasteText','SpellChecker'],['Undo','Redo','-','SelectAll','RemoveFormat'],[ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ], ['SpecialChar','PageBreak']],
        extraPlugins : 'wordcount',
        wordcount : {
            showCharCount : true,
            showWordCount : true
            
            
        }
    });

    
});
$(document).ready(function(){

   $('#addplaceholder').change(function(){ /*
       
  
        var satff_name=$('#addplaceholder option:selected').text();
        console.log(satff_name);//return false;
        
        CKEDITOR.instances['add_message'].setData(satff_name);*/
           /*var caretPos =  CKEDITOR.instances['add_message'].getSelection();

    var textAreaTxt =  CKEDITOR.instances['add_message'].getData();
    
    console.log(caretPos);

    var txtToAdd =$('#addplaceholder option:selected').text();
    CKEDITOR.instances['add_message'].setData(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );*/
    var txtToAdd =$('#addplaceholder option:selected').text();
    CKEDITOR.instances['add_message'].insertText(txtToAdd);

})
   $('#editplaceholder').change(function(){ /*
       
  
        var satff_name=$('#addplaceholder option:selected').text();
        console.log(satff_name);//return false;
        
        CKEDITOR.instances['add_message'].setData(satff_name);*/
           /*var caretPos =  CKEDITOR.instances['add_message'].getSelection();

    var textAreaTxt =  CKEDITOR.instances['add_message'].getData();
    
    console.log(caretPos);

    var txtToAdd =$('#addplaceholder option:selected').text();
    CKEDITOR.instances['add_message'].setData(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );*/
    var txtToAdd =$('#editplaceholder option:selected').text();
    CKEDITOR.instances['edit_message'].insertText(txtToAdd);

})

})

/*
jQuery("#btn").on('click', function() {

    var caretPos =  CKEDITOR.instances['add_message'].selectionStart;

    var textAreaTxt =  CKEDITOR.instances['add_message'].val();
    
    console.log(textAreaTxt);

    var txtToAdd = "stuff";

    //jQuery("#txt").val(textAreaTxt.substring(0, caretPos) + txtToAdd + textAreaTxt.substring(caretPos) );

});*/