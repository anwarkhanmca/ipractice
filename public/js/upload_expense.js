$(document).ready(function (e) {
	
	$(function() {
		$(".attachFile").change(function() {
            var file 		= this.files[0];
			var imagefile 	= file.type;
			var key 		= $(this).attr('data-key');

 			var reader 		= new FileReader();
			reader.onload 	= imageIsLoaded(key);
			reader.readAsDataURL(this.files[0]);
		});
	});

	$("body").on('click', '.deleteAttachPop', function() {
		var key = $(this).attr('data-key');
		$('#attachment'+key).val('');
		$('#attachDivPop'+key).html('');
	});
	
	function imageIsLoaded(key) {
		var text = '<a href="javascript:void(0)"><img src="/img/pdficon.png" height="20"></a>';
        text += '<a href="javascript:void(0)" class="deleteAttachPop" data-key="'+key+'"><img src="/img/cross.png" width="13"></a>';
		$('#attachDivPop'+key).html(text);
		
		//$('#image_preview').attr('src', e.target.result);
	};

});