$(document).ready(function (e) {
	
	// Function to preview image after validation
	$(function() {
		$(".upload_file").change(function() {
			var div_id = $(this).attr("id");
			
			var file = this.files[0];
			var imagefile = file.type;
			/*var match= ["image/jpeg","image/png","image/jpg"];
			if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
			{
				alert("Please Select A valid Image File. Only jpeg, jpg and png Images type allowed");
				return false;
			}
			else
			{*/
				var reader = new FileReader();
				//reader.onload = imageIsLoaded;
				reader.readAsDataURL(this.files[0]);
				saveToDataBase(this.files[0], div_id);
			//}
		});
	});
	
	/*function imageIsLoaded(e) {
		
		//$('#image_preview').html( '<img src="'+e.target.result+'" class="browse_img">' );
		//$('#image_preview').attr('src', e.target.result);
	};*/

});

function saveToDataBase(file, div_id)
{
	var client_id = $("#client_id").val();//alert(client_id)
	if(div_id == "passport1" || div_id == "passport2"){
		var path = 'uploads/passports/';
	}else{
		var path = 'uploads/documents/'
	}

	/*$.ajax({
	    type: "POST",
	    url: '/client/upload-other-files',
	    data: { 'file_name' : file.name, 'column' : div_id, 'client_id' : client_id },
	    success : function(resp){
	    	$("#a"+div_id).show();
	      	var file_name = file.name+' <a href="javascript:void(0)" data-id="'+resp+'" data-column="'+div_id+'" data-path="'+path+'" class="delete_files"><img src="/img/cross.png" height="12"></a>';
			$("#a"+div_id).html(file_name);
	    }
	});*/

$("#a"+div_id).show();
var file_name = file.name+' <a href="javascript:void(0)" data-id="'+client_id+'" data-column="'+div_id+'" data-path="'+path+'" class="delete_files"><img src="/img/cross.png" height="12"></a>';
$("#a"+div_id).html(file_name);
	
	//alert(file.name);
}