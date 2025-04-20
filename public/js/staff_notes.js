

$("#demo").hide();
//$("#notes_innermsg_top").css("display", "none");

$("#addnotes_button").click(function(){
    $("#notesmsg").val("");
    tinymce.remove();
    tinymce.init({
    selector: "#notesmsg",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code" ]
});
    //tinyMCE.activeEditor.setContent("");
    
    
    $("#notes_font").html("");
    $("#notes_error").html('');
    $("#notestitle").val("");
    //$("#notesmsg").val("");
    
        
    $(".notes_innermsg_top").css("display", "block");
    
    //alert('fsfsfsf');
   
    //$("#notes_font").hide();
    $("#demo").show();
});

$("#cancle_notes").click(function(){    
    $(".notes_innermsg_top").css("display", "none");
    $("#demo").hide();
    $("#notes_font").show();
});



$("body").on("click", "#savenotes", function(){
 
   if( $("#notestitle").val()==""){
     $("#notes_error").html('Please enter  Notes Title');
       $("#notestitle").focus();
        return false;
   }
    else{
        
        
        $("#notes_error").html('');
        
        
        var notestitle= $("#notestitle").val();
    
         //var notesmsg= $("#notesmsg").val();
   
   var notesmsg = tinyMCE.activeEditor.getContent();
        
        //var toRemove = notestitle;
            //var gorge = toRemove.replace(toRemove,'');
            
            if(notestitle.length>"40"){
                 var title = notestitle.substr(0,40);
                  var finaltitle=title+'...' 
            }
            else{
                finaltitle=notestitle;
            }
            
            
        
        $.ajax({
		type: "POST",
		//dataType: "html",
		url: '/staffprof-notes',
		data: 
			{ 'notestitle':notestitle, 'notesmsg' : notesmsg
		},
		success: function(resp) {
			console.log(resp);
          // var title=
            $("#notes_font").css("display", "block");
            //$('#notesmsg').tinymce().remove();
            tinymce.remove('textarea');
            $(".notes_innermsg_top").css("display", "none");
            
            var r = resp.split('|||');
            
            
            
            
            $("#notes_font").html(r[1]);
           // var len = notestitle.length
           // alert(len);
            
            $("#newaddnotes").prepend('<li id="listtitle'+r[0]+'"><a data-id="'+r[0]+'" class="title_view" href="javascript:void(0)">'+finaltitle+'</a></li>');
            
            
            }
	});
    
    
    
    
    
    
    
    
    }


  });
  
   $("body").on("click", "#editsave_notes", function(){

    
    //alert('adadadadada');return false;
    
    if( $("#editnotestitle").val()==""){
     $("#notes_error1").html('Please enter  Notes Title');
      $("#editnotestitle").focus();
        return false;
   }
    else{
   
    var editnotesval= $("#editnotestitle").val();
    //var editnotesmsg= $("#editnotesmsg").val();
    var editnotesmsg = tinyMCE.activeEditor.getContent();
   var edited_id= $("#editstaffnotes_id").val();
    var client_id= $("#editclient_id").val();
    
    /*console.log(editnotesval);
    console.log(editnotesmsg);
    console.log(edited_id);
    console.log(client_id);*/
    console.log(edited_id);
    
    
    
    
    //var edittitle = editnotesval.substr(0,20);
    
    if(editnotesval.length>"40"){
        
                 var edit_title = editnotesval.substr(0,40);
                  var finaledittitle=edit_title+'...' 
           
            //alert(finaledittitle);
            }
            
            else{
                finaledittitle=editnotesval;
                //alert(finaledittitle);
            }
            
    
    
    $.ajax({
		type: "POST",
		//dataType: "html",
		url: '/editstaff-notes',
		data: 
			{ 'editnotesval':editnotesval, 'editnotesmsg' : editnotesmsg,'edited_id':edited_id
		},
		success: function(resp) {
		  
		 // $("#notes_font").css("display", "block");
          //  $(".notes_innermsg_top").css("display", "none");
          
			console.log(resp);
            $("#notes_font").html("");
           
            $("#notes_font").html(resp);
           
           $("#listtitle"+edited_id).html('<a data-id='+edited_id+' class="title_view" href="javascript:void(0)">'+finaledittitle+'</a>');
           
            
            }
	});
    
    
    
    }
    
    
    
    
    
   
    });
    
      $("body").on("click", "#delete_notes", function(){
       
       
       
       
       var numItems = $('.title_view').length;
    //alert(numItems);return false;
    if (numItems >0 ) {
       
        var deleted_id="";
        var edited_id= $("#editstaffnotes_id").val();
         //var client_id= $("#editclient_id").val();
        var notesmsgid= $("#msgid").val();
       if(notesmsgid){
        deleted_id=notesmsgid;
       }else{
        deleted_id=edited_id;
       }
       deleted_id = $.trim(deleted_id);
        
        
        console.log(deleted_id);
        console.log(edited_id);
       
        $("#listtitle"+deleted_id).remove();
       
    $.ajax({
		type: "POST",
		//dataType: "html",
		url: '/deletestaffprof-notes',
		data: 
			{ 'edited_id':deleted_id
		},
		success: function(resp) {
			//console.log(resp);
            console.log(deleted_id);
            $("#notes_font").html(resp);
            $("#listtitle"+deleted_id).remove();
            }
	});                        
        
       // }
        
             }//     
             else{
                	alert("Add Notes first before Deleting");
                
             }                                      
  
    });
  
//end of main document ready

$("body").on("click", ".title_view", function(){

var notesmsgid =$(this).attr('data-id');
//alert(notesmsgid);return false;
console.log(notesmsgid);

//$("#").html('loading.....');

$.ajax({
		type: "POST",
		//dataType: "html",
		url: '/view-staffnotes',
		data: {
			'notesmsgid': notesmsgid
		},
        
        beforeSend: function() {

               // $("#notes_font").html('<img src="/img/ajax-loader1.gif" />');

            },
        
		success: function(resp) {
		 // $("#notes_font").html("");
			console.log(resp);
            $("#notes_font").html(resp);
            
    $(".notes_innermsg_top").css("display", "none");
            }
	});


});

$("body").on("click", "#editnotes", function(){

var numItems = $('.title_view').length;
    //alert(numItems);return false;
    if (numItems >0 ) {
	 var notesmsgid= $("#msgid").val();
//alert(notesmsgid);return false;

//var notesmsgid =$(this).attr('data-id');
//alert(notesmsgid);
console.log(notesmsgid);
$.ajax({
		type: "POST",
		//dataType: "html",
		url: '/editmodestaff-notes',
		data: {
			'notesmsgid': notesmsgid
		},
        beforeSend: function(){
            tinymce.remove();  
        },
		success: function(resp) {
		 // tinymce.get('#notes_font').setContent('');
			console.log(resp);
            $("#notes_font").html("");
            $("#notes_font").html(resp);
            
        }
	});
       
       

	} else {
		alert("Add Notes first before Editing");
	}








});



