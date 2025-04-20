@extends('layouts.layout')
@section('mycssfile')

    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Date picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/jquery-ui.css') }}" />
<!-- Date picker script -->

<!-- Add To Calender Start -->
<link href="{{ URL :: asset('css/atc-style-blue.css') }}" rel="stylesheet" type="text/css">
@stop

@section('myjsfile')
 <script src="{{ URL :: asset('js/jquery.tablednd.js') }}" type="text/javascript"></script> 
 <script src="{{ URL :: asset('js/quotes.js') }}" type="text/javascript"></script> 
<!-- <script src="{{ URL :: asset('js/onboard.js') }}" type="text/javascript"></script> 
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>-->
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->

<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript">


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="{{ URL :: asset('js/jquery-ui.min.js') }}"></script>


<!-- Date picker script -->
<script src="{{ URL :: asset('tinymce/tinymce.min.js') }}"></script>
<!-- page script -->
<script src="{{ URL :: asset('ckeditor/ckeditor.js') }}"></script>
<script>
    //var editor = CKEDITOR.replace( 'notesmsg' );
    var editor = CKEDITOR.replace( 'engnotes',
    {
        filebrowserBrowseUrl : '/browser/browse.php',
        filebrowserUploadUrl : '/uploader/upload.php'
    });
</script>

<script>

    var editor = CKEDITOR.replace( 'engagementnotes',
    {
        filebrowserBrowseUrl : '/browser/browse.php',
        filebrowserUploadUrl : '/uploader/upload.php'
    });
</script>
<script>
    //var editor = CKEDITOR.replace( 'notesmsg' );
    var editor = CKEDITOR.replace( 'quotesnote',
    {
        filebrowserBrowseUrl : '/browser/browse.php',
        filebrowserUploadUrl : '/uploader/upload.php'
    });
</script>


<script type="text/javascript">



/*
$("#BoxTableitemised").tableDnD({
    onDragClass: "myDragClass",
    onDrop: function(table, row) {
        var rows = table.tBodies[0].rows;
        var debugStr = "Row dropped was "+row.id+". New order: ";
        for (var i=0; i<rows.length; i++) {
            debugStr += rows[i].id+" ";
        }
        console.log(debugStr);
        //$(#debugArea).html(debugStr);
    },
    onDragStart: function(table, row) {
        //$(#debugArea).html("Started dragging row "+row.id);
    }
});


*/







$("#BoxTableitemised tbody").sortable({
    items: "> tr:not(:first)",
    appendTo: "parent",
    helper: "clone"
}).disableSelection();

   
 



$(function() {
    
     var cloneCount = 1;
   /*
   
    
    $('.descriptionclass').click(function() {
            
             var str=$(this).attr('id');
           // alert(str);
             id = str.match(/\d+/);
             $('#descriptiono'+id).html("<input type='text' style='width:100%;' id='oneoffdes"+id+"'  value=''>");
             $('#oneoffdes'+id).focus();
           // alert($(this).attr('id'))
    })
    
    $('.qtyoclass').click(function() {
            
             var str=$(this).attr('id');
             id = str.match(/\d+/);
             
             $('#qtyo'+id).replaceWith("<input type='text' style='width:100%;'  id='oneoffqty"+id+"' maxlength='3'  value=''>");
             $('#oneoffqty'+id).focus();
            //alert($(this).attr('id'))
    })
    $('.unitopriceclass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);
             id = str.match(/\d+/);
             $('#unitpriceo'+id).html("<input type='text' style='width:100%;' id='oneoffunit"+id+"' maxlength='10' value=''>");
             $('#oneoffunit'+id).focus();
            //alert($(this).attr('id'))
    })
    
    $('.disocclass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);
             id = str.match(/\d+/);
             $('#disco'+id).html("<input type='text' style='width:100%;' id='onediscou"+id+"' 70px;' value=''>");
             $('#onediscou'+id).focus();
            //alert($(this).attr('id'))
    })
   $('.taxrateoclass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);return false;
             id = str.match(/\d+/);
             $('#taxrateo'+id).html("<input type='text' style='width:100%;' id='oneofftaxrate"+id+"' value=''>");
             $('#oneofftaxrate'+id).focus();
            //alert($(this).attr('id'))
    })
  
     $('.amountogbpclass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);
             id = str.match(/\d+/);
             $('#amountgbpo'+id).html("<input type='text' style='width:100%;' id='oneoffamountgbpo"+id+"' value=''>");
             $('#oneoffamountgbpo'+id).focus();
            //alert($(this).attr('id'))
    })
    */
     $('#add_line_oneoffees').click(function() {
		
				//alert('AAAAAAAAAAAA');	
				
				//return false;
               // $(".dpick").datepicker("destroy");      
				
				
				
				var $newRow = $('#TemplateRow1').clone(true);
   
            /*	$newRow.find('#deleteimage').val('');
				//$newRow.find('.dpick').val('');
        		$newRow.find('#item').val('');
                $newRow.find('#description').val('');
				$newRow.find('#qty').val('');
                $newRow.find('#unitprice').val('');
                
                $newRow.find('#disc').val('');
                $newRow.find('#taxrate').val('');
                $newRow.find('#amountgbp').val('');
               // $newRow.find('#flexfees').val('');
                $newRow.find('#itemoneimg').val('');
			*/
        	
				var noOfDivs = $('.makeCloneClass1').length + 1;
                /*
                $newRow.find('td:eq(2)').attr('id', 'descriptiono'+ noOfDivs);
                $newRow.find('td:eq(3)').attr('id', 'qtyo'+ noOfDivs);
                $newRow.find('td:eq(4)').attr('id', 'unitpriceo'+ noOfDivs);
                $newRow.find('td:eq(5)').attr('id', 'disco'+ noOfDivs);
                $newRow.find('td:eq(6)').attr('id', 'taxrateo'+ noOfDivs);
                $newRow.find('td:eq(7)').attr('id', 'amountgbpo'+ noOfDivs);
                 
                 */
                
				// $newRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
			
				$('#BoxTable tr:last').after($newRow);
				
				 
				// $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});    
				return false;
			
})
    


    
    
    
    
    
    
      $("#expirydate").datepicker({ minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true, yearRange: "-5:+100" });

})
$('.DeleteBoxRow1').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".DeleteBoxRow1").size();
		if(size>1){
        	$(this).closest('tr').remove();
		}
    });

tinymce.init({
    selector: ".notesclass",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code" ]
}); 
</script>


<script>
$(function() {
    
     $('#add_line_optional').click(function() {
		
				//alert('AAAAAAAAAAAA');	
				
				//return false;
               // $(".dpick").datepicker("destroy");      
				
				
				
				var $newRow = $('#TemplateRow2').clone(true);
   
            	$newRow.find('#deleteimageop').val('');
				//$newRow.find('.dpick').val('');
        		$newRow.find('#itemop').val('');
                $newRow.find('#descriptionop').val('');
			
        	
				var noOfDivs = $('.makeCloneClassop').length + 1;
                
				// $newRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
			
				$('#BoxTable2 tr:last').after($newRow);
				
				 
				// $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});    
				return false;
			
})
    
    });
    
    $('.DeleteBoxRowop').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".DeleteBoxRowop").size();
		if(size>1){
        	$(this).closest('tr').remove();
		}
    });




$(function() {
    
     $('#add_line_packagedpricing').click(function() {
		
				//alert('AAAAAAAAAAAA');	
				
				//return false;

				var $newRow = $('#TemplateRowpackagedpricing').clone(true);
   
            	$newRow.find('#deleteimagepackagedpricing').val('');
				//$newRow.find('.dpick').val('');
        		$newRow.find('#itempackagedpricing').val('');
                $newRow.find('#commentspackagedpricing').val('');
			
        	
				var noOfDivs = $('.makeCloneClasspackagedpricing').length + 1;
                
				// $newRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
			
				$('#BoxTablepackagedpricing tr:last').after($newRow);
				
				 
				// $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});    
				return false;
			
})
    
    });

$('.DeleteBoxRowpackagedpricing').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".DeleteBoxRowpackagedpricing").size();
		if(size>1){
        	$(this).closest('tr').remove();
		}
    });





$(function() {
    
     $('#add_line_package2dpricing').click(function() {
		
				//alert('AAAAAAAAAAAA');	
				
				//return false;

				var $newRow = $('#TemplateRowpackage2dpricing').clone(true);
   
            	$newRow.find('#deleteimagepackage2dpricing').val('');
				//$newRow.find('.dpick').val('');
        		$newRow.find('#itempackage2dpricing').val('');
                $newRow.find('#commentspackage2dpricing').val('');
			
        	
				var noOfDivs = $('.makeCloneClasspackage2dpricing').length + 1;
                
				// $newRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
			
				$('#BoxTablepackage2dpricing tr:last').after($newRow);
				
				 
				// $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});    
				return false;
			
})
    
    });

$('.DeleteBoxRowpackage2dpricing').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".DeleteBoxRowpackage2dpricing").size();
		if(size>1){
        	$(this).closest('tr').remove();
		}
    });



$(function() {
    
     $('#add_line_package3dpricing').click(function() {
		
				//alert('AAAAAAAAAAAA');	
				
				//return false;

				var $newRow = $('#TemplateRowpackage3dpricing').clone(true);
   
            	$newRow.find('#deleteimagepackage3dpricing').val('');
				//$newRow.find('.dpick').val('');
        		$newRow.find('#itempackage3dpricing').val('');
                $newRow.find('#commentspackage3dpricing').val('');
			
        	
				var noOfDivs = $('.makeCloneClasspackage3dpricing').length + 1;
                
				// $newRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
			
				$('#BoxTablepackage3dpricing tr:last').after($newRow);
				
				 
				// $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});    
				return false;
			
})
    
    });

$('.DeleteBoxRowpackage3dpricing').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".DeleteBoxRowpackage3dpricing").size();
		if(size>1){
        	$(this).closest('tr').remove();
		}
    });


$(function() {
    
     $('#add_line_package4dpricing').click(function() {
		
				//alert('AAAAAAAAAAAA');	
				
				//return false;

				var $newRow = $('#TemplateRowpackage4dpricing').clone(true);
   
            	$newRow.find('#deleteimagepackage4dpricing').val('');
				//$newRow.find('.dpick').val('');
        		$newRow.find('#itempackage4dpricing').val('');
                $newRow.find('#commentspackage4dpricing').val('');
			
        	
				var noOfDivs = $('.makeCloneClasspackage4dpricing').length + 1;
                
				// $newRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
			
				$('#BoxTablepackage4dpricing tr:last').after($newRow);
				
				 
				// $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});    
				return false;
			
})
    
    });

$('.DeleteBoxRowpackage4dpricing').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".DeleteBoxRowpackage4dpricing").size();
		if(size>1){
        	$(this).closest('tr').remove();
		}
    });



$(function() {
    //attach the a function to the click event of the 
    //"Add Box Attribute" button that will add a new row
   var cloneCount = 1;
  /* 
   $('.desclass').click(function() {
            
            var str=$(this).attr('id');
            id = str.match(/\d+/); 
            
            $('#descriptioni'+id).replaceWith("<input type='text'style='width: 278px;' id='des"+id+"'  value=''>");
            $('#des'+id).focus();
            //alert(id);
    })
   */
   
   /*
    
    $('.comclass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);
             id = str.match(/\d+/);
             $('#com'+id).html("<input type='text'style='width: 110px;' id='comment"+id+"' value=''>");
             $('#comment'+id).focus();
            //alert($(this).attr('id'))
    })
    
    $('.qtyclass').click(function() {
            
             var str=$(this).attr('id');
             id = str.match(/\d+/);
             
             $('#qtyi'+id).replaceWith("<input type='text' style='width: 58px;' id='qty"+id+"' maxlength='3'  value=''>");
             $('#qty'+id).focus();
            //alert($(this).attr('id'))
    })
    $('.unitclass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);
             id = str.match(/\d+/);
             $('#unitpricei'+id).html("<input type='text' id='unit"+id+"' maxlength='10' value=''>");
             $('#unit'+id).focus();
            //alert($(this).attr('id'))
    })
    
    $('.discilass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);
             id = str.match(/\d+/);
             $('#disci'+id).html("<input type='text' style='width: id='discou"+id+"' 70px;' value=''>");
             $('#discou'+id).focus();
            //alert($(this).attr('id'))
    })
    $('.amountgbpiclass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);
             id = str.match(/\d+/);
             $('#amountgbpi'+id).html("<input type='text' id='amount"+id+"' value=''>");
             $('#amount'+id).focus();
            //alert($(this).attr('id'))
    })
    $('.flexfeesiclass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);
             id = str.match(/\d+/);
             $('#flexfeesi'+id).html("<input type='text' id='fle"+id+"' value=''>");
             $('#fle'+id).focus();
            //alert($(this).attr('id'))
    })
    $('.taxrateiclass').click(function() {
            
             var str=$(this).attr('id');
             //alert(str);
             id = str.match(/\d+/);
             $('#taxratei'+id).html("<input type='text' id='taxra"+id+"' maxlength='4' value='' >");
             $('#taxra'+id).focus();
            //alert($(this).attr('id'))
    })
 	*/
    $('#add_newlineitemised').click(function() {
		
				//alert('AAAAAAAAAAAA');return false;
				
					var $newRow = $('#TemplateRowitemised1').clone(true);
			
            //	$newRow.find('#item1').val('');
                $newRow.find('#descriptioni1').val('');
				$newRow.find('#com1').val('');
        		$newRow.find('#qtyi1').val('');
                $newRow.find('#unitpricei1').val('');
				$newRow.find('#disci1').val('');
               // $newRow.find('#amountgbpi1').val('');
                $newRow.find('#taxratei1').val('');
                $newRow.find('#flexfeesi1').val('');
                
                
                
			//	$newRow.find('#taxi1').val('');
				
               
				
               // $newRow.find('#delrowi1').val('');
        		
                	
                	
               
   
   
                
                
				var noOfDivs = $('.makeCloneClassitemised').length + 1;
				//alert(noOfDivs);
              /*  $newRow.find('td:eq(1)').attr('id', 'descriptioni'+ noOfDivs);
                $newRow.find('td:eq(2)').attr('id', 'com'+ noOfDivs);
                $newRow.find('td:eq(3)').attr('id', 'qtyi'+ noOfDivs);
                $newRow.find('td:eq(4)').attr('id', 'unitpricei'+ noOfDivs);
                $newRow.find('td:eq(5)').attr('id', 'disci'+ noOfDivs);
                $newRow.find('td:eq(6)').attr('id', 'amountgbpi'+ noOfDivs);
                $newRow.find('td:eq(7)').attr('id', 'taxratei'+ noOfDivs);
                $newRow.find('td:eq(8)').attr('id', 'flexfeesi'+ noOfDivs);
                
                */
                
                
                
                 //$newRow.find('span').attr('id', 'qtyi'+ noOfDivs);
                 
			
				$('#BoxTableitemised tr:last').after($newRow);
				
				 return false;
			
	})

	
})

$('.DeleteBoxRowitemised').click(function() {
    
    //find the closest parent row and remove it
	var size = $(".DeleteBoxRowitemised").size();
		if(size>1){
        	$(this).closest('tr').remove();
		}
    });



</script>



@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @include('layouts.outer_leftside')
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side  {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')

                <!-- Main content -->
                <section class="content">
                
                <section class="content">
      <div class="practice_mid">
        <div class="top_buttons">
          <div class="top_bts">
            <ul style="padding:0;">
             <!-- <li> <a href="#"><img src="img/download_latter.png" /></a> </li> -->
              
              <li>
                <button class="btn btn-warning" style="background-color:#6bb601; border: 0; width: 90px;">Preview</button>
              </li>
              <li>
                <button class="btn btn-info" style="">Save/Edit</button>
              </li>
            </ul>
          </div>
          <div class="right_side">
                                <!--  <div class="j_selectbox" style="background-color: #039bd1; width: 100px!important; height: 31px; margin-top: 1px; padding-top:3px; border: none;">
                        <span style="color:#fff!important;">ACTION</span>
                        <div class="select_icon" id="select_icon"></div>
                        <div class="clr"></div>
                        <div class="open_toggle" style="display: none;">
                          <ul>
                            <li data-value="1">SAVE</li>
                            <li data-value="2">EDIT</li>
                            <li data-value="3">DELETE</li>
                          </ul>
                            </div>
                        </div> -->
           <!-- <button class="btn btn-primary" style="background-color: #039bd1; border:0; width: 90px;">Save</button> -->
            <button class="btn btn-primary" style="background-color:#6bb601; border: 0; width: 90px;">Send..</button>
            <button class="btn btn-primary" style="width: 90px; background-color:#a2a7ab;  border: 0;" >Cancel</button>
          </div>
          <div class="clearfix"></div>
        </div>
        
          <div class="tabarea">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
                <li id="gentab1" class="active"><a data-toggle="tab"  href="#tab_1">SUMMARY</a></li>
                <li id="cwtab2" class=""><a data-toggle="tab"  href="#tab_2">CLIENT WELCOME</a></li>
                <li id="rltab2" class=""><a data-toggle="tab"  href="#tab_2">RENEWAL LETTER</a></li>
                <li id="covertab3" ><a data-toggle="tab"  href="#tab_3">QUOTE COVER LETTER</a></li>
                <li id="tabletab4" ><a data-toggle="tab"  href="#tab_4">QUOTE TABLE</a></li>
                <li id="eltab5" ><a data-toggle="tab"  href="#tab_5">ENGAGEMENT LETTER</a></li>
                <li id="tctab6" ><a data-toggle="tab"  href="#tab_6">T&Cs</a></li>
              
                <li id="tctab7" ><a data-toggle="tab"  href="#tab_7">T&Cs</a></li>
                 <li id="" style="float: right;" ><a href="javascript:void(0)" class="lead_status-modal" style="float:right;" data-is_show="O"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></li>
              </ul>
              <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                  <!--table area-->
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                        
                        
                           <div style="float: left; width:500px; margin-right: 100px;">
                           
                             <span style="float: left; width:100px; padding-top: 5px;"><strong>Select Client</strong></span>
                             <span style="float: left; margin-bottom: 10px;">
                             
                                <select class="form-control" style="width:380px; border-radius: 5px 5px 5px 5px !important;">
                                        <option>Select Client1</option>
                                        <option>Select Client2</option>
                                        <option>Select Client3</option>
                                        <option>Select Client4</option>
                                      </select>
                             
                             
                             </span>
                             <div class="clr"></div>
                             
                             
                             <span style="float: left; width:100px; padding-top: 5px;"><strong>Contact person</strong></span>
                             <span style="float: left;">
                             
                                <select class="form-control " style="width:380px; border-radius: 5px 5px 5px 5px !important;">
                                        <option>Contact person1</option>
                                        <option>Contact person2</option>
                                        <option>Contact person3</option>
                                        <option>Contact person4</option>
                                      </select>
                             
                             
                             </span>
                           
                           <div class="clr"></div>
                           
                             <button style="width:72px; margin-bottom: 0; height: 33px; margin-left:94px; margin-top:10px;" class="addnew_line"><i style="padding-right: 5px;" class="add_icon_img"><img src="img/add_icon.png"></i>
                                          <p class="add_line_t" style="font-size: 16px;">Add</p>
                                          </button>
                           
                           
                           
                           </div>
                           <div style="float: left; width:510px;">
                           
                           
                                <span style="float: left; width:50px; padding-top: 5px;"><strong>Subject</strong></span>
                                <span><a href="#" class="lead_status-modal" data-toggle="modal" data-target="#srvicesmodal-modal" style="float: left;" data-is_show="O"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></span>
                             <span style="float: right; margin-bottom: 10px;">
                             
                                <select class="form-control" style="width:380px; border-radius: 5px 5px 5px 5px !important;">
                                        <option>Subject1</option>
                                        <option>Subject2</option>
                                        <option>Subject3</option>
                                        <option>Subject4</option>
                                      </select>
                             
                             
                             </span>
                             <div class="clr"></div>
                             
                             <span style="float: left; width:95px; padding-top: 5px;"><strong>Email Address</strong></span>
                           
                              <div class="clr"></div>
                           
                           
                           
                           
                           
                           
                           
                           
                           </div>
                          
                           
                        
                        
                        
                        
                        
                        
                        
                        
                        
                  
                        
                        
                        
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                               <!--   <tr>
                                    <td width="8%">Select Client</td>
                                    <td width="49%"><select class="form-control" style="width: 52%;">
                                        <option>BLACK COMMERCIAL LIMITED</option>
                                        <option>BLACK COMMERCIAL LIMITED</option>
                                        <option>BLACK COMMERCIAL LIMITED</option>
                                        <option>BLACK COMMERCIAL LIMITED</option>
                                      </select></td>
                                    <td width="11%">&nbsp;</td>
                                    <td width="9%">Contact person</td>
                                    <td width="23%"><select class="form-control" >
                                        <option></option>
                                        <option>BLACK COMMERCIAL LIMITED</option>
                                        <option>BLACK COMMERCIAL LIMITED</option>
                                        <option>BLACK COMMERCIAL LIMITED</option>
                                      </select></td>
                                  </tr>
                                -->
                                </table></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="9%"><strong>Pick Elements</strong> <span><a data-is_show="O" style="float: right;" data-target="#srvicesmodal-modal" data-toggle="modal" class="lead_status-modal" href="#"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a></span></td>
                                    <td width="4%">&nbsp;</td>
                                    <td width="3%"><input type="radio" name="pickelements" id="none" value="None" checked="checked"></td>
                                    <td width="4%"><strong>None</strong></td>
                                    <td width="4%">&nbsp;</td>
                                    <td width="3%"><input type="radio" name="pickelements" id="ncwl" value="NEW CLIENT WELCOME LETTER"></td>
                                    <td width="23%"><button class="btn btn-info">NEW CLIENT WELCOME LETTER</button></td>
                                    <td width="2%"><input type="radio" name="pickelements" id="rl" value="RENEWAL LETTER"></td>
                                    <td width="48%"><button class="btn btn-warning">RENEWAL LETTER</button></td>
                                  </tr>
                                </table></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td valign="top" align="center"><table width="70%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td><input type="checkbox" name="qcl" id="qcl" value="qcl"></td>
                                    <td><button class="btn btn-danger">Quote cover letter</button></td>
                                    <td>&nbsp;</td>
                                    <td><input type="checkbox" name="qtnqs" id="qtnqs" value="qtnqs"></td>
                                    <td><button class="btn btn-danger">Quote Table Notes & Optional services</button></td>
                                    <td>&nbsp;</td>
                                    <td><input type="checkbox" name="el" id="el" value="el"></td>
                                    <td><button class="btn btn-primary">Engagement Letter</button></td>
                                    <td>&nbsp;</td>
                                    <td><input type="checkbox" name="tc" id="tc" value="tc"></td>
                                    <td><button class="btn btn-primary">T&C</button></td>
                                  </tr>
                                </table></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                            <tr>
                              <td align="center"><strong>Attachments</strong> <span class="btn btn-default btn-file"> Browse
                                <input type="file">
                                </span></td>
                            </tr>
                          </table>
                          <div class="add_client_btn">
                            <button class="btn btn-danger">Save</button>
                            <button class="btn btn-info">Next</button>
                            <div class="clearfix"></div>
                          </div>
                          
                          
                          
            <div class="clr"></div>              
                          
                
    <div class="tabarea">
            <div class="nav-tabs-custom" style="border: #ccc solid 1px;" >
              <ul class="nav nav-tabs nav-tabsbg" style="background-color: #ddd;">
              
              
               <li class="active" ><a data-toggle="tab" href="#tab_1sub" style="color:#000!important;"><span><img src="img/conversation.png" style="padding-right: 3px; width: 23px; height: 18px;"></span>Conversation</a></li>
                
                
                <li class=""><a data-toggle="tab" href="#tab_2sub" style="color:#000!important;"><span><img src="img/clock.png" style="padding-right: 3px; width: 23px; height: 18px;"></span>History</a></li>
              </ul>
              <div class="tab-content" style="padding-bottom: 12px;">
                <div id="tab_1sub" class="tab-pane active">
              
                <textarea style="width: 97%; margin-top:10px; margin-left: 17px;"></textarea>
                <button style="width:130px; margin-bottom: 0; height: 33px; margin-left:17px; margin-top:16px; " class="addnew_line"><i style="padding-right: 5px;" class="add_icon_img"><img src="img/post_message.png" style="padding-right: 3px; width: 23px; height: 18px;"></i>
                                          <p class="add_line_t" style="font-size: 14px; color:#000!important;">Post Message</p>
                                          </button>
                 
                 
                </div>
                <div id="tab_2sub" class="tab-pane">
              
                <table style="width:97%; border:#ccc solid 1px; margin-left: 12px;">
                
                <tr style="height: 44px; background-color: #eee; border-bottom: #ccc solid 1px;">
                
                <td align="center"><strong>Date</strong></td>
                <td align="center"><strong>Event</strong></td>
                <td align="center"><strong>Data</strong></td>
                <td align="center"><strong>User</strong></td>
                <td align="center"><strong>IP</strong></td>
                
                </tr>
                
                <tr>
                
                <td align="center">nov</td>
                <td align="center">maria</td>
                <td align="center">&nbsp;</td>
                <td align="center">maria</td>
                <td align="center">213.122.179.66</td>
                </tr>
                
                <tr>
                
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
                
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
                
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
                
                <tr>
                
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
                
                
               </table>
                </div>
                
                
               
              </div>
            </div>
          </div>
                          
                          
                          
                          
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                </div>
                <!-- /.tab-pane -->
                <div id="tab_2" class="tab-pane">
                  <!--table area-->
                  <div class="width_80p">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                        
                              
                               <div class="top_buttons" style=" margin-top: 0;">
                            <div class="form-group email_top_left">
                             
                            </div>
                            <div class="form-group select_template">
                             <button class="btn btn-default">Add New Field</button>
                            </div>
                            <div class="clearfix"></div>
                          </div>              
                          <div class="top_buttons" style=" margin-top: 0;">
                            <div class="form-group email_top_left">
                              <label for="exampleInputPassword1">Message Subject</label>
                              <input type="text" id="" class="form-control">
                            </div>
                            <div class="form-group select_template">
                              <label for="exampleInputPassword1">Select Template <a href="#">Add</a></label>
                              <select class="form-control">
                                <option></option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                              </select>
                            </div>
                            <div class="clearfix"></div>
                          </div>
                         
                          <textarea class="notesclass" name="" rows="10" cols="" style="width:100%;">This is my textarea</textarea>
                          <div class="add_client_btn">
                            <button class="btn btn-info">Prev</button>
                            <button class="btn btn-danger">Save</button>
                            <button class="btn btn-info">Next</button>
                            <div class="clearfix"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                  <!--end table-->
                </div>
                <div id="tab_3" class="tab-pane">
                  <!--table area-->
                  <div class="width_80p">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                          <div class="top_buttons" style=" margin-top: 0;">
                            <div class="form-group email_top_left">
                             
                            </div>
                            <div class="form-group select_template">
                             <button class="btn btn-default">Add New Field</button>
                            </div>
                            <div class="clearfix"></div>
                          </div>
                          <div class="top_buttons">
                            <div class="form-group email_top_left">
                              <label for="exampleInputPassword1">Message Subject</label>
                              <input type="text" id="" class="form-control">
                            </div>
                            <div class="form-group select_template">
                              <label for="exampleInputPassword1">Select Template <a href="#">Add</a></label>
                              <select class="form-control">
                                <option></option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                              </select>
                            </div>
                            <div class="clearfix"></div>
                          </div>
                          <textarea class="notesclass" name="" rows="10" cols="" style="width:100%;">This is my textarea</textarea>
                          <div class="add_client_btn">
                            <button class="btn btn-info">Prev</button>
                            <button class="btn btn-danger">Save</button>
                            <button class="btn btn-info">Next</button>
                            <div class="clearfix"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                  <!--end table-->
                </div>
                <div id="tab_4" class="tab-pane">
                  <!--table area-->
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                            <td width="8%"><strong>&nbsp;</strong></td>
                              <td width="8%"><strong>Quote Type</strong></td>
                              <td width="2%"><input type="radio" name="quotetype" class="quotetype" id="None" value="None" checked="checked"></td>
                              <td width="5%">None</td>
                              <td width="2%"><input type="radio" name="quotetype" class="quotetype" id="ltemisedservices" value="Itemised Services"></td>
                              <td width="12%">Itemised Services</td>
                              <td width="2%"><input type="radio" name="quotetype" class="quotetype"  id="menupricing" value="Menu/Packaged pricing"></td>
                              <td width="10%">Packaged pricing</td>
                              
                              <td width="2%"><input type="radio" name="quotetype" class="quotetype"  id="importfrommexcel" value="Import fromm Excel"></td>
                              <td width="20%" align="left">Custom-Import from Excel or pdf</td>
                             <!-- <td width="2%"><input type="radio" name="quotetype" class="quotetype"  id="ssquote" value=""></td>
                              <td width="14%">Select sample quote</td> -->
                              <td><div class="m_top" id="dropsample">
                              <select class="form-control newdropdown" style="height: 33px; padding: 7px 9px; text-align: center;">
                                  <option>SELECT TEMPLATE</option>
                                  <option>SELECT TEMPLATE</option>
                                </select> </div></td>
                            </tr>
                            <tr>
                             <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>
                              
                              &nbsp;
                             <!--
                              <input type="checkbox" name="" id="" value="">
                                Option1 -->
                                
                                
                                
                                
                                </td>
                              <td>&nbsp;</td>
                              <td>
                              
                                &nbsp;
                                <!--
                              <input type="checkbox" name="" id="" value="">
                                Option1
                                -->
                                
                                </td>
                              <td>&nbsp;</td>
                              
             

                               <!-- 
                              <td>&nbsp;</td>
                              
                              <td>&nbsp;</td> -->
                              
                              <td>
                               {{ Form::open( array('url' => '/quotefilefile-upload', 'files' => true, 'id'=>'quotefile1', 'name'=>'quotefile1')   ) }}
                              
                              
                              <td>
                              
        <span id="browsfile" class="btn btn-default btn-file m_top" style="width:74px; height: 30px; padding:2px 12px;"> Browse
             <input type="file" name="add_pdffile1" id="add_pdffile1" data-looper="1"  class="pdf"  />
                                </span>
                             
                                
                                
                                </td>
                                
  {{ Form :: close() }}
    
                              &nbsp;
                              <!-- <div class="m_top"><select class="form-control newdropdown" style="height: 33px; padding: 7px 9px; text-align: center;">
                                  <option>BLACK COMMERCIAL</option>
                                  <option>BLACK COMMERCIAL</option>
                                </select></div> --></td>

                              
                            </tr>
                            
                            <tr>
                             <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              
                            </tr>
                           
                           <!--<tr>
                                <td width="12%">Date of first Invoice</td>
                                <td width="13%"><input type="text" id="" class="form-control"></td>
                                <td width="12%">&nbsp;</td>
                                <td width="9%">Quote validity</td>
                              
                                <td width="3%"><input type="text" name="quotevalidity" id="quotevalidity" style="width:34px;" value=""></td>
                               
                                <td width="10%">Days</td>
                                <td width="1%">&nbsp;</td>
                                <td width="13%">&nbsp;</td>
                               
                                <td width="4%">Fees</td>
                                <td width="14%"><input type="text" id="" class="form-control"></td>
                              </tr>
                           -->
                           
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td valign="top">
                              &nbsp;
                              <!--
                              Or Import <span class="btn btn-default btn-file"> Browse
                                <input type="file">
                                </span>
                                -->
                                
                                </td> 
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                            </tr>
                          </table>
             <div class="width_80p">             
          <div id="expiryrow" style="padding: 0; margin: 0 auto; width:716px;">
            <span style="padding-right: 10px;"><strong>Expiry</strong></span>
            <span>
                <input type="text" name="quotevalidity" id="expirydate" class="form-control" value="" style=" width: 128px; margin-right: 50px;"/>
            </span>
                          
                          
                            <span style="padding-right: 10px;"><strong>Quote number</strong></span>
                            <span><input type="text" name="quotevalidity" id="quotevalidity" class="form-control"  value="" style=" width: 128px; margin-right: 50px;"></span>
                          
                          
                             <span style="padding-right: 10px;"><strong>Reference</strong></span>
                            <span><input type="text" name="quotevalidity" id="quotevalidity" class="form-control"  value="" style="width:128px"></span>
                          
                          </div>
                          </div>
                          <div class="ltemised_services" style="border: 0; margin:47px 0 0 1px; padding: 0; width: 100%;">
                          
                          <div class="width_80p">
                            <div id="firsttable">
                            <div class="first_item" style="border: 0; margin:0; padding: 0;">
                            <!--
                              <select class="form-control" style="width:164px; margin-right: 50px; margin-bottom: 15px;">
                              <option value="1">GBP British Pound</option>
                              <option value="2">2</option>
                              </select> -->
                            
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody><tr>
                                  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" id="BoxTableitemised" class="white_table table-bordered">
                                      <tbody><tr>
                                      <!--<th width="2%">&nbsp;</th> -->
                                        <th width="2%">&nbsp;</th>
                                        <th width="12%" align="center">Description<a style="float:right;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a></th>
                                        <th width="15%" align="center">Comment</th>
                                        
                                        <th width="5%" align="center">Qty</th>
                                        <th width="16%" align="center">Unit Price</th>
                                        <th width="8%" align="center">Disc%</th>
                                       <!-- <th width="6%" align="center">Account </th> -->
                                        <th width="17%" align="center">Tax Rate</th>
                                        
                                        <th width="13%" align="center">Amount GBP</th>
                                        <th width="2%" align="center">&nbsp;</th>
                                      </tr>
                                      
                                      <tr id="TemplateRowitemised1" class="makeCloneClassitemised">
    <td align="center"><img src="img/dotted_icon.png" id="itemoneimg" /></td>
    <!--<td><span  id="item">&nbsp;</span>
      </td> -->
    <td class="desclass"  ><span><select class="form-control drop_height newdropdown" name="" id="descriptioni1">
                                   <option value="">None</option>
                                  
                                    @if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    @if( isset($new_services) && count($new_services)>0 )
                                      @foreach($new_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                   
              </select></span></td>
        <td class="comclass"  ><input type="text" id="com1" class="form-control" style="width:100%" /></td>
        <td class="qtyclass" ><input type="text" id="qtyi1" maxlength='3' class="form-control" style="width:100%" /></td>
        <td width="13%" class="unitclass" ><input type="text" id="unitpricei1" class="form-control" maxlength='10' style="width:100%" /></td>
        <td width="2%" class="discilass" ><input type="text" id="disci1" class="form-control" style="width:100%" /></td>
        <!-- <td width="2%" class="amountgbpiclass" ><span  ><input type='text' id="amountgbpi1" value=''></span></td> -->
        <td width="2%" class="taxrateiclass" ><input type="text" id="taxratei1" class="form-control" maxlength='4' style="width:100%" /></td>
        <td width="2%" class="flexfeesiclass" ><input type="text" id="flexfeesi1" class="form-control" style="width:100%" /></td>
        
        <td align="center"><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" id="deleteimageitemised" class="DeleteBoxRowitemised"/></a></td>

  </tr>
                                     <!-- <tr>
                                      <td width="2%"><input type="checkbox" /></td>
                                        <td align="center"><img src="img/dotted_icon.png"></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td align="center" class="td_bg"><a href="#"><img src="img/cross_icon.png"></a></td>
                                      </tr>
                                     -->
                                     
                                      
                                    </tbody></table></td>
                                </tr>
                                <tr>
                                  <td valign="top"></td>
                                </tr>
                              </tbody></table>
                           
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tbody>
                                      <tr>
                                        <td width="6%" id="add_newlineitemised"><button style="width:124px; margin-bottom: 0; height: 29px; margin-left:5px;" class="addnew_line"><i style="padding-right: 5px;" class="add_icon_img"><img src="img/add_icon.png"></i>
                                          <p class="add_line_t">Add new line</p>
                                          </button></td>
                                        <td width="30%" align="center">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%" align="center" class="">Sub Total</td>
                                        <td width="10%" align="right" class="">5.00</td>
                                        <td width="10%" align="center"></td>
                                        <td width="4%">&nbsp;</td>
                                      </tr>
                                      
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td width="30%" align="center">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%" align="center" class="bottom_border">Total VAT 20%</td>
                                        <td width="10%" align="right" class="bottom_border">1.00</td>
                                        <td width="10%" align="center"></td>
                                        <td width="4%">&nbsp;</td>
                                      </tr>
                                      
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td align="center" class="bottom_border1"><strong class="total_t">TOTAL</strong></td>
                                        <td align="right" class="bottom_border1"><strong class="total_t">6.00</strong></td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                      </tr>
                                     
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                      
                                    </tbody></table>
                           
                            
                            <!--
                            
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="white_table table-bordered">
                                      <tbody><tr>
                                        <th width="2%">&nbsp;</th>
                                        <th width="10%" align="center">Item <a style="float:right;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a></th>
                                        <th width="26%" align="center">Description</th>
                                        <th width="10%" align="center">Qty</th>
                                        <th width="10%" align="center">Unit Price</th>
                                        <th width="10%" align="center">Disc%</th>
                                        <th width="10%" align="center">Tax Rate <a style="float:right;" class="lead_status-modal" href="javascript:void(0)"><i style="color:#00c0ef" class="fa fa-cog fa-fw"></i></a></th>
                                        <th width="10%" align="center">Amount GBP</th>
                                        
                                        <th width="10%" align="center">Flex fees</th>
                                        <th width="4%" align="center">&nbsp;</th>
                                      </tr>
                                      <tr>
                                        <td align="center"><img src="img/dotted_icon.png"></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td align="center" class="td_bg"><a href="#"><img src="img/cross_icon.png"></a></td>
                                      </tr>
                                      <tr>
                                      <td align="center"><img src="img/dotted_icon.png"></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td align="center" class="td_bg"><a href="#"><img src="img/cross_icon.png"></a></td>
                                      </tr>
                                      <tr>
                                      <td align="center"><img src="img/dotted_icon.png"></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td align="center" class="td_bg"><a href="#"><img src="img/cross_icon.png"></a></td>
                                      </tr>
                                       <tr>
                                       <td align="center"><img src="img/dotted_icon.png"></td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td class="td_bg">&nbsp;</td>
                                        <td align="center" class="td_bg"><a href="#"><img src="img/cross_icon.png"></a></td>
                                      </tr>
                                    </tbody></table> -->
                              
                              
                            </div>
                            
                            
                                    </div>
                                    </div>
                            
                            
                            <div class="width_80p">
                                <div id="setable">
                               <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
                <li ><a>SELECT/VIEW PACKAGE</a></li>
                <li class="active"><a data-toggle="tab" href="#tab_2a">PACKAGE 1 &#163;50+VAT</a></li>
                <li><a data-toggle="tab" href="#tab_2b">PACKAGE 2 &#163;75+VAT</a></li>
                <li><a data-toggle="tab" href="#tab_2c">PACKAGE 3 &#163;150+VAT</a></li>
                <li><a data-toggle="tab" href="#tab_2d">PACKAGE 4 &#163;175+VAT</a></li>
               <!-- <li><a data-toggle="tab" href="#tab_2e">PACKAGE 1 &#163;50+VAT</a></li> -->
                <li style="float: right;"><a href="#" class="lead_status-modal"  data-toggle="modal" data-target="#quotesubtab-modal" style="float:right;" data-is_show="O"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></li>
              </ul>
              <div class="tab-content">
                <div id="tab_2a" class="tab-pane active">
                  <!--table area-->
                  <span style="font-style: italic; float: left;">Add package1 description.....</span>
                  <span style="float: right;"><button style="background-color: #ccc; padding: 6px 23px; text-align: center; border: none; border-radius: 5px;">Choose</button></span>
                  <div class="clr"></div>
                  
                  
                  <table width="100%" class="table table-bordered table-hover dataTable" id="BoxTablepackagedpricing">
    <tbody>
    <tr>
      <td width="40%"><strong>Services</strong>  <a href="#" class="lead_status-modal" data-toggle="modal" data-target="#srvicesmodal-modal" style="float:right;" data-is_show="O"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></td>
      <td width="40%" align="center"><strong>Comments</strong></td>
      <!-- <td width="10%" align="center"><strong>Acting</strong></td> -->
      <td width="20%" align="center">&nbsp;</td>
    </tr>
  
   <tr id="TemplateRowpackagedpricing" class="makeCloneClasspackagedpricing">
                                       
                                        
                                        <td><span id="itempackagedpricing"><select class="form-control" name="" id="vat_scheme_types">
                                    <option value="">None</option>
                                    
                                    @if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    @if( isset($new_services) && count($new_services)>0 )
                                      @foreach($new_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                   
                                  </select></span></td>
                                        <td><span id="commentspackagedpricing">&nbsp;</span></td>
                                        <td><a href="javascript:void(0)"><img src="/img/cross.png" width="15" id="deleteimagepackagedpricing" class="DeleteBoxRowpackagedpricing"/></a></td>
                                      </tr>
  </tbody></table>
  
  
                  <!--end table-->
                  
    <div class="clr"></div>
    
    <div style="margin-top: 10px;" id="add_line_packagedpricing">
  <button type="button" onclick="show_div()" class="addnew_line">
  <i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p>
  
  </button>
  <!-- <a href="javascript:void(0)" class="btn btn-info" onClick="show_div()"><i class="fa fa-plus"></i> Add new line</a> -->
</div>
                </div>
                <!-- /.tab-pane -->
                <div id="tab_2b" class="tab-pane">
                 &nbsp;
                 
                  <!--table area-->
                  <span style="font-style: italic; float: left;">Add package2 description.....</span>
                  <span style="float: right;"><button style="background-color: #ccc; padding: 6px 23px; text-align: center; border: none; border-radius: 5px;">Choose</button></span>
                  <div class="clr"></div>
                  
                  
                  <table width="100%" class="table table-bordered table-hover dataTable" id="BoxTablepackage2dpricing">
    <tbody>
    <tr>
      <td width="40%"><strong>Services</strong></td>
      <td width="40%" align="center"><strong>Comments</strong></td>
      <!-- <td width="10%" align="center"><strong>Acting</strong></td> -->
      <td width="20%" align="center">&nbsp;</td>
    </tr>
  
   <tr id="TemplateRowpackage2dpricing" class="makeCloneClasspackage2dpricing">
                                       
                                        
                                        <td><span id="itempackage2dpricing"><select class="form-control" name="" id="">
                                    <option value="">None</option>
                                    
                                    @if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    @if( isset($new_services) && count($new_services)>0 )
                                      @foreach($new_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                   
                                  </select></span></td>
                                        <td><span id="commentspackage2dpricing">&nbsp;</span></td>
                                        <td><a href="javascript:void(0)"><img src="/img/cross.png" width="15" id="deleteimagepackage2dpricing" class="DeleteBoxRowpackagedpricing"/></a></td>
                                      </tr>
  </tbody></table>
  
  
                  <!--end table-->
                  
    <div class="clr"></div>
    
    <div style="margin-top: 10px;" id="add_line_package2dpricing">
  <button type="button" onclick="show_div()" class="addnew_line">
  <i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p>
  
  </button>
  <!-- <a href="javascript:void(0)" class="btn btn-info" onClick="show_div()"><i class="fa fa-plus"></i> Add new line</a> -->
</div>
         
                  
                  
                  
                  
                  
               </div>
                <!-- /.tab-pane -->
                  <div id="tab_2c" class="tab-pane">
                <!--table area-->
                  <span style="font-style: italic; float: left;">Add package3 description.....</span>
                  <span style="float: right;"><button style="background-color: #ccc; padding: 6px 23px; text-align: center; border: none; border-radius: 5px;">Choose</button></span>
                  <div class="clr"></div>
                  
                  
                  <table width="100%" class="table table-bordered table-hover dataTable" id="BoxTablepackage3dpricing">
    <tbody>
    <tr>
      <td width="40%"><strong>Services</strong></td>
      <td width="40%" align="center"><strong>Comments</strong></td>
      <!-- <td width="10%" align="center"><strong>Acting</strong></td> -->
      <td width="20%" align="center">&nbsp;</td>
    </tr>
  
   <tr id="TemplateRowpackage3dpricing" class="makeCloneClasspackage3dpricing">
                                       
                                        
                                        <td><span id="itempackage3dpricing"><select class="form-control" name="" id="">
                                    <option value="">None</option>
                                    
                                    @if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    @if( isset($new_services) && count($new_services)>0 )
                                      @foreach($new_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                   
                                  </select></span></td>
                                        <td><span id="commentspackag3edpricing">&nbsp;</span></td>
                                        <td><a href="javascript:void(0)"><img src="/img/cross.png" width="15" id="deleteimagepackage3dpricing" class="DeleteBoxRowpackagedpricing"/></a></td>
                                      </tr>
  </tbody></table>
  
  
                  <!--end table-->
                  
    <div class="clr"></div>
    
    <div style="margin-top: 10px;" id="add_line_package3dpricing">
  <button type="button" onclick="show_div()" class="addnew_line">
  <i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p>
  
  </button>
  <!-- <a href="javascript:void(0)" class="btn btn-info" onClick="show_div()"><i class="fa fa-plus"></i> Add new line</a> -->
</div>
         
                </div>
                <!-- /.tab-pane -->
                <!-- /.tab-pane -->
                  <div id="tab_2d" class="tab-pane">
                 <!--table area-->
                  <span style="font-style: italic; float: left;">Add package4 description.....</span>
                  <span style="float: right;"><button style="background-color: #ccc; padding: 6px 23px; text-align: center; border: none; border-radius: 5px;">Choose</button></span>
                  <div class="clr"></div>
                  
                  
                  <table width="100%" class="table table-bordered table-hover dataTable" id="BoxTablepackage4dpricing">
    <tbody>
    <tr>
      <td width="40%"><strong>Services</strong></td>
      <td width="40%" align="center"><strong>Comments</strong></td>
      <!-- <td width="10%" align="center"><strong>Acting</strong></td> -->
      <td width="20%" align="center">&nbsp;</td>
    </tr>
  
   <tr id="TemplateRowpackage4dpricing" class="makeCloneClasspackage4dpricing">
                                       
                                        
                                        <td><span id="itempackage4dpricing"><select class="form-control" name="" id="">
                                    <option value="">None</option>
                                    
                                    @if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    @if( isset($new_services) && count($new_services)>0 )
                                      @foreach($new_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                   
                                  </select></span></td>
                                        <td><span id="commentspackage4dpricing">&nbsp;</span></td>
                                        <td><a href="javascript:void(0)"><img src="/img/cross.png" width="15" id="deleteimagepackage4dpricing" class="DeleteBoxRowpackagedpricing"/></a></td>
                                      </tr>
  </tbody></table>
  
  
                  <!--end table-->
                  
    <div class="clr"></div>
    
    <div style="margin-top: 10px;" id="add_line_package4dpricing">
  <button type="button" onclick="show_div()" class="addnew_line">
  <i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add new line</p>
  
  </button>
  <!-- <a href="javascript:void(0)" class="btn btn-info" onClick="show_div()"><i class="fa fa-plus"></i> Add new line</a> -->
</div>
         
                </div>
                <!-- /.tab-pane -->
                <!-- /.tab-pane -->
                  <div id="tab_2e" class="tab-pane">
                <!-- 2e -->&nbsp;
                </div>
                <!-- /.tab-pane -->
                <!-- /.tab-pane -->
                  <div id="tab_2f" class="tab-pane">
               <!--  2f -->&nbsp;
                </div>
                <!-- /.tab-pane -->
                
              </div>
            </div>
                            </div>
                            </div>
                            <div class="width_80p">
                           <div id="thtab">
                           
                           
                           <iframe id="showquoteview" width="900" height="500" src=""></iframe>
                            <!-- <div style="width:100%; border: #ccc solid 2px; margin-top: 40px; height: 500px;"></div> -->
                           
                           
                           </div>
                           </div>
                           
                            
                          </div>
                        </div>
                      </div>
                    </div>
                    
                   
                            <div class="">
                                  <input type="checkbox" id="oneofffees" name="oneofffees" value="oneofffees" class="form-control">
                                  <label for="exampleInputPassword1">One - Off Fees</label>
                                </div>
                                <div class="width_80p">
                                <div id="secondtable">
                            <div class="first_item" >
                            
                       <table width="100%" border="1" cellspacing="0" cellpadding="0" style="" id="BoxTable" class="white_table table-bordered">
  <tbody>
  
 <tr >
                                         <th width="2%">&nbsp;</th>
                                        <th width="12%" align="center">Services <a href="javascript:void(0)" class="lead_status-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
                                        <th width="15%" align="center">Comments</th>
                                        <th width="5%" align="center">Qty</th>
                                        <th width="16%" align="center">Unit Price</th>
                                        <th width="8%" align="center">Disc%</th>
                                        <th width="17%" align="center">Tax Rate <a href="javascript:void(0)" class="lead_status-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
                                        <th width="13%" align="center">Amount GBP</th>
                                        
                                      <!--  <th width="10%" align="center">Flex fees</th> -->
                                       
                                        <th width="2%">&nbsp;</th>
                                      </tr>
  
  
  
  
  <tr id="TemplateRow1" class="makeCloneClass1">
  
  
    <td align="center"><img src="img/dotted_icon.png" id="itemoneimg" /></td>
     <td class=""><span  id="item"><select class="form-control drop_height newdropdown" name="" id="">
                                    <option value="">None</option>
                                    
                                    @if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    @if( isset($new_services) && count($new_services)>0 )
                                      @foreach($new_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                   
                                  </select></span>
      </td>
    <td class="descriptionclass" id="descriptiono1"><input type="text"  id="" class="form-control" style="width:100%" /></td>
    <td class="qtyoclass" id="qtyo1"><input type="text" id="" style="width:100%" class="form-control" /></td>
   <td class="unitopriceclass" id="unitpriceo1"><input type="text" id="" style="width:100%" class="form-control" /></td>
   <td class="disocclass" id="disco1"><input type="text" id="" style="width:100%" class="form-control" /></td>
   <td class="taxrateoclass" id="taxrateo1"><input type="text" id="" style="width:100%" class="form-control" /></td>
   <td class="amountogbpclass" id="amountgbpo1"><input type="text" id="" style="width:100%" class="form-control" /></td>
  
  
   <td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" id="deleteimage" class="DeleteBoxRow1"></a></td>
   
  
  
  
  </tr>
  
  <!--
  <tr id="TemplateRow1" class="makeCloneClass1">
  
  
    <td align="center"><img src="img/dotted_icon.png" id="itemoneimg" /></td>
     <td class=""><span  id="item"><select class="form-control" name="" id="">
                                    <option value="">None</option>
                                    
                                    @if( isset($old_services) && count($old_services)>0 )
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    @if( isset($new_services) && count($new_services)>0 )
                                      @foreach($new_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                   
                                  </select></span>
      </td>
    <td class="descriptionclass" id="descriptiono1"><span  >&nbsp;</span></td>
    <td class="qtyoclass" id="qtyo1"><span  >&nbsp;</span></td>
   <td class="unitopriceclass" id="unitpriceo1"><span  >&nbsp;</span></td>
   <td class="disocclass" id="disco1"><span  >&nbsp;</span></td>
   <td class="taxrateoclass" id="taxrateo1"><span  >&nbsp;</span></td>
   <td class="amountogbpclass" id="amountgbpo1"><span  >&nbsp;</span></td>
  
  
   <td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" id="deleteimage" class="DeleteBoxRow1"></a></td>
   
  
  
  
  </tr>
  -->
</tbody></table>
                             <!-- <table width="100%" border="0" cellspacing="0" cellpadding="0" id="BoxTable">
                                <tr>
                                  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="white_table table-bordered">
                                      <tr>
                                        <th width="2%">&nbsp;</th>
                                        <th width="10%" align="center">Item <a href="javascript:void(0)" class="lead_status-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
                                        <th width="26%" align="center">Description</th>
                                        <th width="6%" align="center">Qty</th>
                                        <th width="10%" align="center">Unit Price</th>
                                        <th width="10%" align="center">Disc%</th>
                                        <th width="10%" align="center">Tax Rate <a href="javascript:void(0)" class="lead_status-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
                                        <th width="10%" align="center">Amount GBP</th>
                                        
                                        <th width="10%" align="center">Flex fees</th>
                                        <th width="4%" align="center">&nbsp;</th>
                                      </tr>
                                     
                                      <tr id="TemplateRowtone" class="makeCloneClass">
                                        <td align="center"><img src="img/dotted_icon.png" id="itemoneimg" /></td>
                                        <td><input type="text" id="itemone1"/></td>
                                        <td><input type="text" id="itemone2"/></td>
                                        <td><input type="text" id="itemone3"/></td>
                                        <td><input type="text" id="itemone4"/></td>
                                        <td><input type="text" id="itemone"/></td>
                                        <td class="td_bg"><input type="text" id="itemone5"/></td>
                                        <td class="td_bg"><input type="text" id="itemone6"/></td>
                                        <td class="td_bg"><input type="text" id="itemone7"/></td>
                                        <td class="td_bg" align="center"><a href="#"><img id="itemoneimg1" src="img/cross_icon.png"></a></td>
                                      </tr>
                                      
                                      
                                      
                                    </table></td>
                                </tr>
                                <tr>
                                  <td valign="top"></td>
                                </tr>
                              </table> -->
                            </div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr >
                                        <td width="6%" id="add_line_oneoffees"><button class="addnew_line" style="width:70px; margin-bottom: 0; height: 29px; margin-left:5px;"><i class="add_icon_img" style="padding-right: 5px;"><img src="img/add_icon.png"></i>
                                          <p class="add_line_tone" >Add</p>
                                          </button></td>
                                        <td width="30%" align="center">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%">&nbsp;</td>
                                        <td width="10%" align="center" class="bottom_border">Sub Total</td>
                                        <td width="10%" align="center" class="bottom_border">0.00</td>
                                        <td width="10%" align="center"></td>
                                        <td width="4%">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        
                                        
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center" class="bottom_border1"><strong class="total_t">TOTAL</strong></td>
                                        <td align="center" class="bottom_border1"><strong class="total_t">0.00</strong></td>
                                        <td align="center">&nbsp;</td>
                                        <td align="center">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        
                                        
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                      </tr>
                                    </table>
                            </div>
                           </div>
                           <p id="noteschk">
                                <input type="checkbox" name="notes" id="notes" value="notes"  class="form-control">
                                <strong>Notes</strong></p>
                                
                                
                                
                          <div class="width_80p">
                            <div class="col-xs-12" style="padding:0; margin-bottom:15px;"id="thirdtable" >
                            
                            <!--  <div class="form-group email_top_left">
                                  <input type="checkbox" id="notes" name="notes" value="Notes" class="form-control">
                                  <label for="exampleInputPassword1">Notes</label>
                                </div> -->
                              
                              <div class="top_buttons" >
                                
                                <div class="form-group select_template">
                                  <label for="exampleInputPassword1">Select Template <a href="#">Add</a></label>
                                  <select class="form-control">
                                    <option></option>
                                    <option>Sfrewfgrewf</option>
                                    <option>Sfrewfgrewf</option>
                                    <option>Sfrewfgrewf</option>
                                  </select>
                                </div>
                                <div class="clearfix"></div>
                              </div>
                              <textarea class="" name="quotesnote" id="quotesnote" rows="10" cols="" style="width:100%;">This is my textarea </textarea>
                              
                            </div>
                            </div>
                            <div class="second_item">
                            <div style="float: left; width: 300px;">
                             <p id="optionalserviceschk">
                                <input type="checkbox" name="optionalservices" id="optionalservices" value="optionalservices">
                                <strong>Optional Services</strong></p>
                                
                                </div>
                                <div style="clear: both;"></div>
                              <div class="width_80p">
                              <div id="forthtable">
                              <div class="first_item">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" id="BoxTable2">
                                <tr>
                                  <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="white_table table-bordered">
                                     
                                      <tr>
                                        <th align="center" width="2%" >&nbsp;</th>
                                        <th width="20%" align="center" >Servicess</th>
                                        <th width="76%" align="left" style="text-align:left;">Commentss</th>
                                        <th align="center" width="2%" >&nbsp;</th>
                                      </tr>
                                     
                                     <tr id="TemplateRow2" class="makeCloneClass2">
                                       
                                        <td align="center"><img src="img/dotted_icon.png" id="itemoneimgop"></td>
                                        <td><span id="itemop"><select class="form-control drop_height newdropdown" name="" id="">
                                    <option value="">None</option>
                                    
                                    @if(isset($old_services) && count($old_services)>0)
                                      @foreach($old_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                    
                                    @if(isset($new_services) && count($new_services)>0)
                                      @foreach($new_services as $key=>$scheme_row)
                                        <option value="{{ $scheme_row->service_id }}" {{ (isset($client_details['vat_scheme_type']) && $client_details['vat_scheme_type'] == $scheme_row->service_id)?"selected":"" }}>{{ $scheme_row->service_name }}</option>
                                      @endforeach
                                    @endif
                                   
                                  </select></span></td>
                                        <td><span ><input type="text" id="descriptionop" style="width: 100%;" class="form-control" /></span></td>
                                        <td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" id="deleteimageop" class="DeleteBoxRowop"></a></td>
                                      </tr>
                                     
                                     
                                    </table></td>
                                </tr>
                                
                              </table>
                            </div>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="10%" id="add_line_optional"><button class="addnew_line" style="width:70px; margin-bottom: 0; height: 29px; margin-left:5px;"><i class="add_icon_img" style="padding-right: 5px;"><img src="img/add_icon.png"></i>
                                          <p class="add_line_t" >Add</p>
                                          </button></td>
                                        <td width="90%" align="center">&nbsp;</td>
                                        
                                      </tr>
                                      <tr>
                                        
                                        
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                       
                                      </tr>
                               <!--       <tr>
                                        
                                        
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                       
                                      </tr> -->
                                    </table>
                            </div>
                            </div>
                            

                            
                            
                            </div>
                            
                            <div  id="">
                             
                            <div class="add_client_btn">
                                <button class="btn btn-info">Prev</button>
                                <button class="btn btn-danger" class="quotesave" id="save">Save</button>
                                <button class="btn btn-info">Next</button>
                                <div class="clearfix"></div>
                              </div>
                            </div>
                  </div>
                  <!--end table-->
                </div>
                <div id="tab_5" class="tab-pane">
                  <!--table area-->
                  <div class="width_80p">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="engement_table">
                            <tr>
                              <td width="16%">Letter Date</td>
                              <td width="15%"><input type="text" id="" class="form-control"></td>
                              <td width="28%" align="right">Limitation of Liability </td>
                              <td width="15%"><input type="text" id="" class="form-control"></td>
                              <td width="25%" align="right"><button class="btn btn-default">Add New Field</button></td>
                            </tr>
                            <tr>
                              <td>Main Staff Contact</td>
                              <td><select class="form-control">
                                  <option>BLACK COMMERCIAL</option>
                                  <option>BLACK COMMERCIAL</option>
                                </select></td>
                              <td align="right">Staff Member responsible for ongoing work</td>
                              <td><select class="form-control">
                                  <option>BLACK COMMERCIAL</option>
                                  <option>BLACK COMMERCIAL</option>
                                </select></td>
                              <td><input type="checkbox" />
                                Group of Companies</td>
                            </tr>
                            <tr>
                              <td>Period of Engagement from</td>
                              <td><input type="text" id="" class="form-control"></td>
                              <td align="right">to</td>
                              <td><input type="text" id="" class="form-control"></td>
                              <td><input type="text" id="" class="form-control" style="width:94%;">
                                <a href="#">X</a></td>
                            </tr>
                            <tr>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td>&nbsp;</td>
                              <td><button class="addnew_line" style="width:82px;"><i class="add_icon_img"><img src="img/add_icon.png"></i>
                                <p class="add_line_t">Add</p>
                                </button></td>
                            </tr>
                          </table>
                        </div>
                         <div class="form-group email_top_left" style="padding-top:25px;">
                              <label for="exampleInputPassword1">COVER LETTER</label>
                        </div>
                        <div class="col-xs-12">
                          <div class="top_buttons">
                            <div class="form-group email_top_left">
                              <label for="exampleInputPassword1">Message Subject</label>
                              <input type="text" id="" class="form-control">
                            </div>
                            <div class="form-group select_template">
                              <label for="exampleInputPassword1">Select Template <a href="#">+ New</a></label>
                              <select class="form-control">
                                <option></option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                              </select>
                            </div>
                            <div class="clearfix"></div>
                          </div>
                          <textarea class="" name="engnotes" id="engnotes" rows="10" cols="" style="width:100%;">This is my textarea</textarea>
                          <!--<div class="add_client_btn">
<button class="btn btn-info">Prev</button>
<button class="btn btn-danger">Save</button>
<button class="btn btn-info">Next</button>
<div class="clearfix"></div>
</div>-->
                        </div>
                        <div class="form-group email_top_left" style="padding-top:25px;">
                              <label for="exampleInputPassword1">ENGAGEMENT LETTER</label>
                        </div>
                        <div class="col-xs-12" >
                          <div class="top_buttons">
                            <div class="form-group email_top_left">
                              <label for="exampleInputPassword1">Title</label>
                              <input type="text" id="" class="form-control">
                            </div>
                            <div class="form-group select_template">
                              <label for="exampleInputPassword1">Select Template <a href="#">+ New</a></label>
                              <select class="form-control">
                                <option></option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                              </select>
                            </div>
                            <div class="clearfix"></div>
                          </div>
                           <textarea class="" name="engagementnotes" id="engagementnotes" rows="10" cols="" style="width:100%;">This is my textarea</textarea>
                        <!--  <div class="col-xs-12 col-xs-4">
                            <div class="col_m2">
                              <div class="noted_right"> <img src="img/plus_1.png" class="icon_gap"> <strong class="notes_h_t">New Section</strong>
                                <div class="new_section"> <span class="notes_h_t">SCHEDULE OF SERVICES TO BE PROVIDED</span>
                                  <ul>
                                    <li>
                                      <div class="new_sec_chkbox"><input type="checkbox" id="" class="form-control"></div>
                                      <strong>TB Coder System requirements</strong></li>
                                    <li>
                                      <div class="new_sec_chkbox"><input type="checkbox" id="" class="form-control"></div>
                                      <strong>TB Coder System requirements</strong></li>
                                    <li>
                                      <div class="new_sec_chkbox"><input type="checkbox" id="" class="form-control"></div>
                                      <strong>TB Coder System requirements</strong></li>
                                    <li>
                                      <div class="new_sec_chkbox"><input type="checkbox" id="" class="form-control"></div>
                                      <strong>TB Coder System requirements</strong></li>
                                    <li>
                                      <div class="new_sec_chkbox"><input type="checkbox" id="" class="form-control"></div>
                                      <strong>TB Coder System requirements</strong></li>
                                    <li>
                                      <div class="new_sec_chkbox"><input type="checkbox" id="" class="form-control"></div>
                                      <strong>TB Coder System requirements</strong></li>
                                    <li>
                                      <div class="new_sec_chkbox"><input type="checkbox" id="" class="form-control"></div>
                                      <strong>TB Coder System requirements</strong></li>
                                  </ul>
                                </div>
                                <div class="add_client_btn">
                                  <button class="btn btn-info">Prev</button>
                                  <button class="btn btn-danger">Save</button>
                                  <button class="btn btn-info">Next</button>
                                </div>
                                <div class="clearfix"></div>
                              </div>
                            </div>
                          </div> -->
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="width_80p">                  
                  <!--end table-->
                </div>
                
                <!-- /.tab-pane -->
              </div>
            </div>
            <div id="tab_6" class="tab-pane">
                  <!--table area-->
                  <div class="width_80p">
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                        
                                <div class="top_buttons" style=" margin-top: 0;">
                            <div class="form-group email_top_left">
                             
                            </div>
                            <div class="form-group select_template">
                             <button class="btn btn-default">Add New Field</button>
                            </div>
                            <div class="clearfix"></div>
                          </div>              
                          <div class="top_buttons" style=" margin-top: 0;">
                            <div class="form-group email_top_left">
                              <label for="exampleInputPassword1">Message Subject</label>
                              <input type="text" id="" class="form-control">
                            </div>
                            <div class="form-group select_template">
                              <label for="exampleInputPassword1">Select Template <a href="#">Add</a></label>
                              <select class="form-control">
                                <option></option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                                <option>Sfrewfgrewf</option>
                              </select>
                            </div>
                            <div class="clearfix"></div>
                          </div>
                         
                          <textarea class="notesclass" name="" rows="10" cols="" style="width:100%;">This is my textarea</textarea>
                         
                         
                          <div class="add_client_btn">
                            <button class="btn btn-info">Prev</button>
                            <button class="btn btn-danger">Save</button>
                            <button class="btn btn-info">Next</button>
                            <div class="clearfix"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                  <!--end table-->
                </div>
                
                
                
               
                
                
                
          </div>
          <div style="clear: both;"></div>
        
      </div>
    </section>
  
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        
 
<div class="modal fade" id="quotesubtab-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-vat-scheme', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <input type="hidden" name="client_type" value="crm">
    <div class="modal-body">
     
     <table width="100%" border="1" cellspacing="0" cellpadding="0">
     <tr>
     <td><input type="checkbox" ></td>
     <td>PACKAGE1</td>
     <td><img src="img/edit_icon.png"></td>
     </tr> 
      <tr>
     <td><input type="checkbox" ></td>
     <td>PACKAGE2</td>
     <td><img src="img/edit_icon.png"></td>
     </tr> 
      <tr>
     <td><input type="checkbox" ></td>
     <td>PACKAGE3</td>
     <td><img src="img/edit_icon.png"></td>
     </tr> 
      <tr>
     <td><input type="checkbox" ></td>
     <td>PACKAGE4</td>
     <td><img src="img/edit_icon.png"></td>
     </tr> 
      <tr>
     <td>Show/hide</td>
     <td>PACKAGE</td>
     <td>Action</td>
     </tr> 
     </table>
      
     
    <!--  <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" id="add_vat_scheme" data-client_type="org" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div> -->
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>





<div class="modal fade" id="srvicesmodal-modal" tabindex="-1" role="dialog" aria-hidden="true">
  	
  <div class="modal-dialog" style="width:430px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD to List</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/client/add-vat-scheme', 'id'=>'field_form')) }}
    <input type="hidden" name="client_type" value="org">
    <input type="hidden" name="added_from" id="added_from" value="crm">
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="vat_scheme_name" id="vat_scheme_name" placeholder="Service" class="form-control">
      </div>
       
      <div id="append_vat_scheme">
       
        @if( isset($old_services) && count($old_services) )
          @foreach($old_services as $key=>$scheme_row)
            <div class="form-group">
              <label for="{{ $scheme_row->service_name }}">{{ $scheme_row->service_name }}</label>
            </div>
          @endforeach
        @endif

        @if( isset($new_services) && count($new_services) )
          @foreach($new_services as $key=>$scheme_row)
            <div class="form-group" id="hide_vat_div_{{ $scheme_row->service_id }}">
              <a href="javascript:void(0)" title="Delete Field ?" class="delete_vat_scheme" data-field_id="{{ $scheme_row->service_id }}"><img src="/img/cross.png" width="12"></a>
              <label for="{{ $scheme_row->service_name }}">{{ $scheme_row->service_name }}</label>
            </div>
          @endforeach
        @endif
     
     
              
     
     
      </div>
     
      <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" id="add_vat_scheme" data-client_type="org" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>

@stop