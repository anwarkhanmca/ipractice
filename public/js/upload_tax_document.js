$(document).ready(function (e) {
	
	// Function to preview image after validation
	$(function() {
		$("#tax_document").change(function() {
			var file = this.files[0];
			var imagefile = file.type;
			var reader = new FileReader();
			//reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
			saveToDataBase(this.files[0]);
		});
	});

	$("body").on('click', ".delete_files", function(){
		var document_id = $(this).data('document_id');
		var $event_action = $(this).closest("li");

		if(document_id == '0'){
			$event_action.remove();
		}else{
			$.ajax({
		        type:'POST',
		        //dataType : 'json',
		        url : '/jobs/action-taxreturn-details',
		        data : {'document_id' : document_id, 'action' : 'delete_document' },
		        beforeSend : function(){
		        
		        },
		        success : function(resp){
		            $event_action.remove();
				}

			});
		}
		$("#tax_document").val('');
	});

});


function saveToDataBase(file)
{
	var path = 'uploads/documents/'

	var file_name = '<li><a href="/uploads/tax_return_doc/'+file.name+'" download>'+file.name+'</a> <a href="javascript:void(0)" data-document_id="0" class="delete_files"><img src="/img/cross.png" height="12"></a></li>';
	$("#document_list").append(file_name);

}
