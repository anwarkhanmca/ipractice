$(document).ready(function () {
 

 
//$("#gentab1").hide();
$("#cwtab2").hide();
$("#rltab2").hide();

$("#covertab3").hide();
$("#tabletab4").hide();
$("#eltab5").hide();
$("#tctab6").hide();
 $("#setable").hide();
 $("#thtab").hide();
  $("#firsttable").hide();
  //  $("#dropsample").hide();
  $("#browsfile").hide();
  $("#expiryrow").hide();
  
$("#dropsample").hide();
 $('#ncwl').on('ifChecked', function(event){
		  $("#cwtab2").show("");
	});
  $('#ncwl').on('ifUnchecked', function(event){
      $("#cwtab2").hide("");
  });
  $('#rl').on('ifChecked', function(event){
		  $("#rltab2").show("");
	});
  $('#rl').on('ifUnchecked', function(event){
      $("#rltab2").hide("");
  });
 

  
 
  $('#qcl').on('ifChecked', function(event){
		  $("#covertab3").show("");
	});
  $('#qcl').on('ifUnchecked', function(event){
      $("#covertab3").hide("");
  });
 
  $('#qtnqs').on('ifChecked', function(event){
		  $("#tabletab4").show("");
	});
  $('#qtnqs').on('ifUnchecked', function(event){
      $("#tabletab4").hide("");
  });
 
 $('#el').on('ifChecked', function(event){
		  $("#eltab5").show("");
	});
  $('#el').on('ifUnchecked', function(event){
      $("#eltab5").hide("");
  });
  
  $('#tc').on('ifChecked', function(event){
		  $("#tctab6").show("");
	});
  $('#tc').on('ifUnchecked', function(event){
      $("#tctab6").hide("");
  });
  
 
 
 
 
        
$("#qtyo1").keydown(function(event) {
    if ( event.keyCode == 46 || event.keyCode == 8 ) {
    // let it happen, don't do anything
        }
        else {
            
        if($("#qtyo1").val().length>=3){
            event.preventDefault();	
            return false;
        }
            // Ensure that it is a number and stop the keypress
            if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
            event.preventDefault();
        }	
    }
});
        
        
        



$("#quotevalidity").keydown(function(event) {
    if ( event.keyCode == 46 || event.keyCode == 8 ) {
    // let it happen, don't do anything
    }
    else {
        if($("#quotevalidity").val().length>=3){
            event.preventDefault();	
            return false;
        }
        // Ensure that it is a number and stop the keypress
        if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
            event.preventDefault();
    }	
    }
});



 
 
 
 
 
 
  });
  
  $("body").on("click", "#tabletab4", function(){
    
    // $(".ltemised_services").hide("");
    
   // $("#firsttable").hide("");
    $("#secondtable").hide("");
    $("#thirdtable").hide("");
    $("#forthtable").hide("");
    
    
   // if ($("#ltemisedservices input[type='radio']:checked").val() == 'Ltemised Services') {
    
  //  alert('fsfsf');
   // }
  
 
  
  });
  
  /* 
   $(".quotetype").change(function(){
    
   var value = $(this).val();
   console.log(value);
   });*/
   
   $('#ltemisedservices').on('ifChecked', function(event){
    
       $("#noteschk").show("");
  
    $("#optionalserviceschk").show();
    
   });
   
   $('.quotetype').on('ifChecked', function(event){

      var value = $(this).val();
       //console.log(value);return false;
  if(value == "Ltemised Services"){
    
 
    
    $("#firsttable").show("");
    $("#secondtable").show("");
    $("#thirdtable").show("");
    $("#forthtable").show("");
    
    // $(".ltemised_services").show("");
  }
   console.log(value);
   
   if(value == "Tailored quote"){
    
    
    $("#oneofffees").show("");
    $("#noteschk").hide("");
  
    $("#optionalserviceschk").hide();
    
    $("#thirdtable").hide("");
    $("#forthtable").hide("");
    //$("#forthtable").hide("");
    
    
   }

  });
  
   $('#oneofffees').on('ifChecked', function(event){
		  
          $("#secondtable").show("");
          
	});
  $('#oneofffees').on('ifUnchecked', function(event){
      $("#secondtable").hide("");
  });
  
   $('#notes').on('ifChecked', function(event){
		  
          $("#thirdtable").show("");
          
	});
  $('#notes').on('ifUnchecked', function(event){
      $("#thirdtable").hide("");
  });
  $('#optionalservices').on('ifChecked', function(event){
		  
          $("#forthtable").show("");
          
	});
  $('#optionalservices').on('ifUnchecked', function(event){
      $("#forthtable").hide("");
  });
  
  
  
  
  //new design
    $('#menupricing').on('ifChecked', function(event){
		  $("#expiryrow").show();
          $("#firsttable").hide();
          $("#setable").show();
          
	});
  $('#menupricing').on('ifUnchecked', function(event){
      $("#setable").hide();
      $("#expiryrow").hide();
  });
  
    
    $('#importfrommexcel').on('ifChecked', function(event){
		  $("#firsttable").hide();
          $("#thtab").show();
          $("#browsfile").show();
          $("#expiryrow").show();
            
          
	});
  $('#importfrommexcel').on('ifUnchecked', function(event){
    $("#expiryrow").hide();
      $("#thtab").hide();
      $("#browsfile").hide();
  });
  
   $('#ltemisedservices').on('ifChecked', function(event){
		   
           $("#dropsample").show();
          $("#expiryrow").show();
          $("#firsttable").show();
          
	});
  $('#ltemisedservices').on('ifUnchecked', function(event){
      $("#dropsample").hide();
      $("#firsttable").hide();
      $("#expiryrow").hide();
  });
  
 /*  $('#ssquote').on('ifChecked', function(event){
		  
          $("#expiryrow").show();
          $("#dropsample").show();
          
	});
  $('#ssquote').on('ifUnchecked', function(event){
      $("#dropsample").hide();
      $("#expiryrow").hide();
  });
*/
  
function show_div()
{
    //alert('faafaf');return false;
  var edit_client_id = $("#client_id").val();
  
  
  
  
  $.ajax({
    type: "POST",
    url: "/client/get-name-and-type",
    dataType: "json",
    //data: { 'add_to_type': add_to_type, 'add_to_name': add_to_name },
    beforeSend: function() {
        //$("#add_to_msg_div").html('<img src="/img/spinner.gif" />');
    },
    success: function (resp) {
      if(resp['allClients'].length > 0){
        var option = '';
        for (var j = 0; j < resp['allClients'].length; j++) { 
          var client_id     = resp['allClients'][j].client_id;
          var client_name   = resp['allClients'][j].client_name;
          if(client_id != "" && client_name != ""){
            option += '<option value="'+client_id+'">'+client_name+'</option>';
          }
        }
      }//alert(option);
      $("#rel_client_id").html(option);
      
    }
  });

  $("#rel_type_id").val($("#rel_type_id option:first").val());
  $("#rel_client_id").val($("#rel_client_id option:first").val());
  $("#new_relationship").show();
}
var relationship_array = [];
var i = 0;
function saveRelationship(process_type)
{
  
  //$('input[type="checkbox"]').iCheck('enabled');

    if($('#non_rel_client_id').val() != ""){
      var rel_client_id = $('#non_rel_client_id').val();
    }else{
      var rel_client_id = $('#rel_client_id').val();
    }

    var rel_type_id = $('#rel_type_id').val();
    //alert(rel_client_id+"etet"+rel_type_id);
    //var rel_client_id = $('#rel_client_id').val();
    //var checkbox = '<span class="custom_chk"><input type="checkbox" class="acting_check" value="Y" name="acting_'+i+'" id="acting_'+i+'" data-edit_index="'+i+'" data-rel_client_id="'+rel_client_id+'"/><label for="acting_'+i+'"></label></span>';

    if(rel_client_id == ""){
      alert("Please select business name/name");
      return false;
    }else{
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/individual/save-relationship',
        data: { 'rel_type_id' : rel_type_id, 'rel_client_id' : rel_client_id },
        beforeSend: function() {
            $('#non_rel_client_id').val("");
        },
        success : function(resp){ //console.log(resp['client_details']['business_name'])
          var name = "";
          if(resp['client_details']['business_name'] !== undefined ){
            name = resp['client_details']['business_name'];
          }else{
            name = resp['client_details']['client_name'];
          }

          if(resp['client_details']['type'] != "non"){
            name = '<a href="'+resp['client_details']['link']+'" target="_blank">'+name+'</a>';
          }
          var content = "";
          content += '<tr id="added_tr'+i+'"><td width="40%">'+name+'</td>';
          content += '<td width="40%" align="center">'+resp['relation_type']+'</td>';
          //content += '<td width="10%" align="center">'+checkbox+'</td>';
          //content += '<td width="20%" align="center"><a href="javascript:void(0)" class="edit_rel" data-rel_client_id="'+rel_client_id+'" data-edit_index="'+i+'" data-link="'+resp['link']+'"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" data-rel_client_id="'+rel_client_id+'" class="delete_rel" data-delete_index="'+i+'"><i class="fa fa-trash-o fa-fw"></i></a></td></tr>';
          content += '<td width="20%" align="center"><a href="javascript:void(0)" data-rel_client_id="'+rel_client_id+'" class="delete_rel" data-delete_index="'+i+'"><img src="/img/cross.png" height="15"></a></td>';

          $("#myRelTable").last().append(content);
          
          var itemselected = i+"mpm"+rel_type_id+"mpm"+rel_client_id;
          if(itemselected !== undefined && itemselected !== null){
              relationship_array.push(itemselected);
          }
        
          $('#app_hidd_array').val(relationship_array);
          $('#relname').val("");
          $("#new_relationship").hide();

          i++;


          /*if(resp['client_details']['is_relation_add'] == "Y" ){
            $('#acting_client_id').append($('<option>', {
              value: rel_client_id,
              text: name
            }));
          }else{
            saveActing("by_own", rel_client_id);
          }*/


        }
      });
    }
    
}

$("#myRelTable").on("click", ".delete_rel", function(){

  if(confirm("Do you want to delete this relationship ?") === false){
    return false;
  }


  var delete_index       = $(this).data("delete_index");
  var rel_client_id      = $(this).data("rel_client_id");

  if(relationship_array.length > 0){
    for (var j = 0; j < relationship_array.length; j++) { 
        //console.log(relationship_array[j]) + "<br>";
        var element     = relationship_array[j];
        var rand_value  = element.split("mpm");
        if(rand_value[0] == delete_index){
        //  var index = relationship_array.indexOf(relationship_array[j]);
          relationship_array.splice(j, 1);
          break;
        }
    }
  }
  // delete added from add to list client start //
  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/client/delete-addtolist-client',
    data: { 'client_id' : rel_client_id },
    success : function(resp){
      
    }
  });
  // delete added from add to list client end //

  $('#app_hidd_array').val(relationship_array);
  $("#added_tr"+delete_index).hide();

  //$("#acting_client_id option[value='"+rel_client_id+"']").remove();
  
});

  $(document).click(function() {
    $(".open_toggle").hide();
  });
  $("#select_icon").click(function(event) {
      $(".open_toggle").toggle();
      event.stopPropagation();
  });
  
  
  
  
  $("#add_vat_scheme").click(function(){
    var vat_scheme_name  = $("#vat_scheme_name").val();
    var added_from  = $("#added_from").val();
   //alert(vat_scheme_name);return false;


    $.ajax({
      type: "POST",
      url: '/client/add-vat-scheme',
      data: { 'vat_scheme_name' : vat_scheme_name, 'added_from':added_from },
      
      success : function(field_id){//alert(client_type);return false;
        var append = '<div class="form-group" id="hide_vat_div_'+field_id+'"><a href="javascript:void(0)" title="Delete Field ?" class="delete_vat_scheme" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a><label for="'+field_id+'">'+vat_scheme_name+'</label></div>';
        $("#append_vat_scheme").append(append);

        $("#vat_scheme_name").val("");
        $("#vat_scheme_type").append('<option value="'+field_id+'">'+vat_scheme_name+'</option>');
		$("#vat_scheme_types").append('<option value="'+field_id+'">'+vat_scheme_name+'</option>');

      }
    });
});

$("#append_vat_scheme").on("click", ".delete_vat_scheme", function(){
  var field_id = $(this).data('field_id');
  if (confirm("Do you want to delete this field ?")) {
    $.ajax({
      type: "POST",
      //dataType: "json",
      url: '/client/delete-vat-scheme',
      data: { 'field_id' : field_id },
      success : function(resp){//console.log(resp);return false;
        if(resp != ""){
            //console.log(resp);return false;
          $("#hide_vat_div_"+field_id).hide();
          $("#vat_scheme_types option[value='"+field_id+"']").remove();
        }else{
          alert("There are some error to delete this scheme, Please try again");
        }
      }
    });
  }
  
}); 


$(".pdf").click(function() {
    //alert('sfsfsf')
	var id = $(this).attr("id").match(/\d+/);
	//alert(id);return false;
	$('#add_pdffile' + id).on('change', function() {
		//alert("#quotefile"+id);
        $("#quotefile" + id).ajaxForm(
		//$('#div5').html();
		{
			//target: '#previewpdf+id',
			success: function(response) {
			 //console.log(response);return false;
				//alert(response);return false;
                
               //response== move
			//	x = response;
                
                if(response != ""){
                    
                     $('#showquoteview').attr('src', response)
                    
                    //alert('move');
                    
                }
                else{
                    $('#showquoteview').html('Upload Proper Pdf File only')
                    
                }
                
             /*   if(x.length>"10"){
        
                 var filename = x.substr(0,10);
                  var uploadfilename=filename+'...' 
           
            //alert(finaledittitle);
            }
            else{
                uploadfilename = x
            }            
                */
                
                
                
                
                
			//	$("#file_pdfvalue" + id).html('<img src="img/attachment.png" />'+uploadfilename);
			//	$("#pdfprev").html('');
			}
		}).submit();
	
	});
});
