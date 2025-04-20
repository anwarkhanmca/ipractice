$(document).ready(function (e) {
	
	// Function to preview image after validation
	$(function() {
		$("#imgFile").change(function() {
                //alert('afafafafa');return false;
                
			$("#error_image_type").empty();
			var file = this.files[0];
			var imagefile = file.type;
			var match= ["image/jpeg","image/png","image/jpg"];
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
			{console.log('outside');
				$("#error_image_type").html("Please Select A valid Image File. Only jpeg, jpg and png Images type allowed");
				return false;
			}
			else
			{console.log('inside');
				$('.LogoActionLi').html('<button type="button" title="Upload Logo?" id="UploadProcess">Upload</button>');
				/*var reader = new FileReader();
				reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);*/
			}
		});
	});

	$("body").on('click', '#deleteLogo', function() {
		$('#practice_logo').val('');
		$('#hidd_practice_logo').val('');
		$('.image_preview').html('');
		$('.big_image').html('');
	});
	
	function imageIsLoaded(e) {
		$('.big_image').html( '<img src="'+e.target.result+'" class="browse_img" width="80">');
		$('.image_preview').html( '<img src="'+e.target.result+'" class="browse_img" width="30"><button class="btn btn-danger" title="Delete Logo?" type="button" id="deleteLogo">Delete</button>' );
		//$('#image_preview').attr('src', e.target.result);
	};

});