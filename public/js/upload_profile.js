$(document).ready(function (e) {
	$("#profile_photo").change(function() {
		$(".error_image_type").empty(); // To remove the previous error message
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
		{
			$(".error_image_type").html("Please Select A valid Image File. Only jpeg, jpg and png Images type allowed");
			return false;
		}
		else
		{
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
		}
	});

	$(".delete_photo").click(function() {
		var delete_staff_id = $('#delete_staff_id').val();
		$('#profile_photo').val('');
		if(delete_staff_id == ''){
			$('#image_preview').html('');
		}else{
			$.ajax({
			    type: "POST",
			    url: '/sp/delete-profile-photo',
			    data: { 'staff_id' : delete_staff_id },
			    success : function(resp){
			    	$('#image_preview').html('');
			    }
			});
		}
	});

	$(".pbody-modal").click(function() {
		$('#professional-modal').modal('show');
	});

	$("#add_prof_body").click(function(){
	    var body_name      = $("#body_name").val();
	    $.ajax({
	      type: "POST",
	      url: '/sp/add-professional-body',
	      data: { 'body_name':body_name },
	      success : function(field_id){
	        var append = '<div class="pop_list form-group" id="hide_div_'+field_id+'"><a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_body_name" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a>'+body_name+'</div>';
	        $("#append_prof_body").append(append);

	        $("#body_name").val("");
	        $("#professional_body").append('<option value="'+field_id+'">'+body_name+'</option>');

	      }
	    });
	});

	$(".delete_body_name").click(function(){
	    var field_id  = $(this).data('field_id');
	    $.ajax({
	      type: "POST",
	      url: '/sp/delete-professional-body',
	      data: { 'field_id':field_id },
	      success : function(resp){
	        if(resp != ""){
          //location.reload();
          	$("#hide_div_"+field_id).hide();
	          $("#professional_body option[value='"+field_id+"']").remove();
	        }else{
	          alert("There are some error to delete this type, Please try again");
	        }

	      }
	    });
	});
});

function imageIsLoaded(e) {
	//$('#profile_photo').val('');
	$('#image_preview').html( '<img src="'+e.target.result+'" class="browse_img">' );
}




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