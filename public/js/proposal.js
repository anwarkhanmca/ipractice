

$(function($) {
  reloadOrdering();
  //reloadServicesOrdering();

  var bill_customer_id = $('#bill_customer').val();
  if(typeof bill_customer_id !== 'undefined'){
    $('#customer').val(bill_customer_id);
  }

  $(document).on("click",".view_details",function(e){
      e.preventDefault();
      var invoice_id=$(this).data('invoiceid');
      $.ajax({
          url: base_url+"/crm/getBillsByInvoice",
          type: "GET",
          data: {
            invoice_id: invoice_id
          },
          success:function(data){
              $("#invoice-container").html(data);
              $("#payment_detail").modal('show');
          },
          error:function() {
              /* Act on the event */
          }
      });
  });

  $(".tab_change").click(function(){
    var data_id = $(this).data('id');
    if(data_id == 11){
      $('#tab_15').show();
    }else{
      $('#tab_15').hide();
    }
    $("#header_ul li").parent().find('li').removeClass("active");
    $(this).parent('li').addClass('active');
    $(".commonClass").fadeOut("fast");
    $("#step"+data_id).fadeIn("slow");
  });


  ///////////////////  CHECK BEFOR DELETING ATTACHEMNT//////////////////////
	$(".deleteAttachment").click(function(e){
	    e.preventDefault();
	    var url        = $(this).attr("href");
	    var check_url  = $(this).data("url");
      var id         = $(this).data("id");
      if(confirm('Do you want to delete ?')){
        $.ajax({
          //url: base_url+'/crm/attachment/delete',
          url : '/delete-attachment',
          type: "POST",
          data : {id:id},
          beforeSend : function(){
            $('.show_loader').html('<img src="/img/spinner.gif">');
          },
          success:function(data){//alert(data);return false;
            $('.show_loader').html('');
            //location.reload();
            if(data > 0){
              alert("Attachment cannot be deleted as it's ok use. Please archive.");
              return false;
            }else{
              $(".attAcH_"+id).hide();
            }
          }
        });
      }
  }); 

	$('.input-number').keyup(function(e){
		if(! $.isNumeric( $(this).val() )){
			$(this).val('');
		}
	});
});


// for create proposal


	   var id=$('#select_product').data('edit');

    var deletedRow=[];
    //var perchantageList='<?php //if($taxlist) { foreach ($taxlist as $taxr) {?><option value="<?php //echo $taxr->tax_rate; ?>"><?php //echo $taxr->tax_name."(".$taxr->tax_rate;?>%)</option><?php //}} ?> ';
    var perchantageList = '';
    var perchantageList = '<option value="None(0.00%),0">None(0.00%)</option><option value="Tax(2%),2">Tax(2%)</option><option value="Tax(5%),5">Tax(5%)</option><option value="Tax(10%),10">Tax(10%)</option>';
    var allTaxes = [];
    var base_url = $('#base_url').val();

    $(function(){
      $("#customer").change(function(){
        var customer_id=$("#customer").val();
          $.ajax({
              url: base_url+"/crm/getInvoicesViaAjax",
              type: "GET",
              data: {
                customer_id: customer_id
              },
              success: function (data) {
                $("#invoice").html(data);
              },
              error: function () {
                  alert("Something went wrong");
              }
          });
          });

        /////////////////GETTING DUE AMOUNT VIA AJAX//////////////////
 $('#invoice').change(function(){
   var invoice_ids=$('#invoice').val();
   $.ajax({
   url: base_url+ "/crm/getBillingAmount",
   jsonp: "jsoncallback",
   crossDomain:true,
   data:{ invoice_id:invoice_ids},
   type:"POST",
   success:function(data){
     data=JSON.parse(data);
     $("#proposal_amount").val(data.paid);
     $("#due_amount").val(parseFloat(data.amount)-parseFloat(data.paid));
     $("#due-msg").html(parseFloat(data.amount)-parseFloat(data.paid));
   },
   error:function(){
     alert("some thing went wrong");
   }
 });//ajax ends here
 });

 //   /////////////// validate amount//////////////
 $("#amount").keyup(function(){
   var due=parseFloat($.trim($("#due_amount").val()));
   var amount =$.trim($("#amount").val());
   if(amount!="" && $.isNumeric(amount)==true){

   if(amount>due){
     $("#amount").val('');
     $(".amount_error").show();
     $("#amount").css({"border-color":"red"});
      
   }else{
     $(".amount_error").hide();
     $("#amount").css({"border-color":"#ccc"});
   }
   }else{
     $("#amount").val('');

   }
 });


    });

    function printDocument(){
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById('pdfcontent').innerHTML;
      document.body.innerHTML = printcontent;
      window.print();
      document.body.innerHTML = restorepage;
    }

     /////////////////////////////////////////////////
    /////////////////ADDING FIELD
    ///////////////////////////////////////////////
    function addField(e) {
            var assign_tax = $(e).data('tax');
            var split_tax = assign_tax.split(',');

            var price=$(e).data('price');
            var serviceName=$(e).text();
           	var taxrate=split_tax[1];
           	var tax_id=$(e).data('tax_id');
            var serviceId=$(e).data('ids');
            var qantyPrice=(parseFloat(price)*1).toFixed(2);
            var tax=(qantyPrice*(parseFloat(taxrate)/100)).toFixed(2);
            //var amount=qantyPrice+tax;
            var amount=qantyPrice;

        // console.log("TaxRate: "+taxrate+" Price :"+price+" amount :"+amount+" tax: "+tax);

        var nodeStr = '<tr id="row_' + id + '"><td><input type="hidden" value="'+serviceId+'" name="service[]" /><h3>' + (id+1) + '</h3></td> <td> <input type="text" name="service_item[]" class="form-control" readonly placeholder="Product" value="'+serviceName+'"  style="margin-bottom:5px;width:210px" id="service_item_' + id + '"/>' +
            ' <textarea name="description[]"  class="form-control" placeholder="Description" id="description_' + id + '"></textarea><span class="error-msg" style="display: none;">Maximum character limit 255</span> </td> <td> <input type="text" name="unit_price[]"  class="form-control input-number"' +
            ' placeholder="Unit Price" onBlur="return checkUnitPrice('+id+');" onkeyup="return calculateRow(' + id + ');" value="'+price+'" style="width:100px;" id="unit_price_' + id + '"/> </td> <td> <input type="text" name="quantity[]" value="1" onblur="return checkQuantity(' + id + ');" onkeyup="return calculateRow(' + id + ');" class="form-control" placeholder="Quantity" style="width:50px;"  id="quantity_' + id + '"/>' +
            ' </td> <td> <input type="text" name="discount[]" value="0.00"  onkeyup="return calculateRow(' + id + ');" class="form-control" placeholder="Discount"  onblur="return checkDiscount(' + id + ');" style="width:70px;" id="discount_' + id + '"/><span class="error-msg" style="display: none;">Discount can\'t be greater than 100%</span> </td> <td> <select name="tax_rate[]" class="form-control pull-left" ' +
            ' style="width:100px;margin-left:10px;" onchange="return calculateRow(' + id + ');" id="tax_rate_' + id + '"> <option value="" selected="selected" data-taxid="0">Tax Rate</option>'+perchantageList+' </select> </td> '+
            '<td> <input type="text" name="tax[]" class="form-control" readonly placeholder="Tax"  id="tax_' + id + '"/> </td> <td> <input type="text"' +
            ' name="amount[]" class="form-control" placeholder="Amount" readonly  id="amount_' + id + '"/> </td> <td> <button class="btn btn-danger btn-xs" onclick="return deleter(' + id + ');" style="margin-top:5px;"><i class="fa fa-trash-o"></i> </button> </td> </tr>';
        
        $("#form-table tbody").append(nodeStr);
        $("#tax_rate_"+id).val(tax_id);
        $("#amount_"+id).val(amount);
        $("#tax_"+id).val(tax);
        updateRowNo();
        id++;
        totalSum();
        $("#serviceFinder").val('');

    }//addField

    //////////////////////////////////////////////////////
    /////// DELETE FIELD
    ////////////////////////////////////////////////////////
    function deleter(id){
        $("#row_"+id).remove();
        deletedRow.push(id);
        totalSum();
        updateRowNo();
    }
    ////////////////////////////////////////////////////////
    ///// CHECK DESCRIPTION LENGTH
    ////////////////////////////////////////////////////////
   /* function checkDescription(id){
        var texts= $.trim($("#description_"+id).val());
        if(texts.length>255){
            $("#description_"+id).val(texts.substring(0,255));

        }
    }*/
    /////////////////////////////////////////////////////
    //////////UPDATE ROW NUmber
    ///////////////////////////////////////////////////////
    function updateRowNo(){
        var numRows=$("#form-table tbody tr").length;
        for(var r=0;r<numRows;r++){
            $("#form-table tbody tr").eq(r).find("td:first h3").text(r+1);
        }

    }
    //////////////////////////////////////////////////////
    //////// SEARCH SERVICE
    ///////////////////////////////////////////////////////
    function searchService(){
        var str=$("#serviceFinder").val();
      if($.trim(str)!="") {
          $.ajax({
              url: base_url+"/crm/getServicesProducts",
              type: "GET",
              data: {
              	search_key: str
              },
              success: function (data) {
              	if(data){
              		// if(typeof data.result !== 'undefined'){
              		$(".service-holder").show();
                  $("#serviceList").html(data);
              		// } 
              		// if(typeof data.taxes!== 'undefined'){
              		// 	perchantageList = '';
              		// 	for(var t=0; t<data.taxes.length; t++){
              		// 		perchantageList += '<option value="'+data.taxes[t].id +'">'+ data.taxes[t].tax_name+'('+data.taxes[t].tax_rate+'%)</option>'; 		
              		// 	}
              		// }
              	}
                  
              },
              error: function () {
                  alert("Something went wrong");
              }
          });
      }//endIf

    }
    ////////////////////////////////////////////
    ////// TOTAL SUM
    ////////////////////////////////////////////

    function totalSum(){
        var totalAmount=0;
        var totalTax=0;
        for(var i=0;i<id;i++){
            if(deletedRow.indexOf(i)<0) {
                totalAmount += parseFloat($.trim($("#amount_" + i).val()));
                totalTax += parseFloat($.trim($("#tax_" + i).val()));
            }
        }
        $("#subtotal").val(totalAmount.toFixed(2));
        $("#sales_tax").val(totalTax.toFixed(2));
        $("#total").val((totalAmount+totalTax).toFixed(2));
    }

    //////////////////////////////////////////////
    /////////////CALCULATE ROW
    //////////////////////////////////////////////
    function calculateRow(id){

        var price=$("#unit_price_"+id).val();
        var quantity=$("#quantity_"+id).val();
        var discount=$("#discount_"+id).val();
        var taxRate = 0;

        // for(var t=0; t<allTaxes.length; t++){
        // 	if(allTaxes[t].id == $("#tax_rate_"+id).val()){
				    // var taxRate = allTaxes[t].tax_rate;         		
        // 	}
        // }

        var taxInfo = $("#tax_rate_"+id).val();
        var taxRate = taxInfo.split(',')[1];

        // var taxRate=$("#tax_rate_"+id).val();
        if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
            //$("#quantity_"+id).val(1);
            quantity=1;
        }
        if($.trim(discount)==""|| $.isNumeric(discount)==false){
            discount=0;
            //$("#discount_"+id).val(0);
        }
        if($.trim(taxRate)==""|| $.isNumeric(taxRate)==false){
            taxRate=0;
            //$("#discount_"+id).val(0);
        }
        if($.trim(price)==""|| $.isNumeric(price)==false){

            price=0;
            //$("#discount_"+id).val(0);
        }
        var quantityAndPrice=parseFloat($.trim(price))*parseFloat($.trim(quantity));
        var afterDiscount=quantityAndPrice-(quantityAndPrice*(parseFloat($.trim(discount))/100));
        var tax=afterDiscount*parseFloat($.trim(taxRate)/100);
        //var amount=afterDiscount+tax;
        $("#amount_"+id).val(afterDiscount.toFixed(2));
        $("#tax_"+id).val(tax.toFixed(2));
        totalSum();
    }//calculateRow
    ////////////////////////////////////////////
    //////////CHECK QUANTITY
    ///////////////////////////////////////////
    function checkQuantity(id){
        var quantity=$("#quantity_"+id).val();
        if($.trim(quantity)==""|| $.isNumeric(quantity)==false){
            $("#quantity_"+id).val(1);
            calculateRow(id);

        }
    }
    ////////////////////////////////////////////
    //////////CHECK UNIT PRICE
    ///////////////////////////////////////////
    function checkUnitPrice(id){
        var unitPrice=$("#unit_price_"+id).val();
        if($.trim(unitPrice)==""|| $.isNumeric(unitPrice)==false){
            $("#unit_price_"+id).val(1);
            calculateRow(id);

        }
    }
    ////////////////////////////////////////////
    //////////CHECK DISCOUNT
    ///////////////////////////////////////////
    function checkDiscount(id){
        var discount=$("#discount_"+id).val();
        if($.trim(discount)==""|| $.isNumeric(discount)==false){
            $("#discount_"+id).val(0);
        }else{
            if(discount>=100){
                $("#discount_"+id).css({"border-color":"red"});
                $("#discount_"+id).next("span").show(200).delay(5000).hide(200,function(){
                    $("#discount_"+id).css({"border-color":"#ccc"});
                });
                $("#discount_"+id).val(0);
                calculateRow(id);

            }
        }
    }

    ////////////////////////////////////////////
    //////////ADD NEW CUSTOMER
    ///////////////////////////////////////////


  $(document).ready(function(){
      ///////////////////////////////////////////////////
      ////////////// access via keyboard  //////////////
      //////////////////////////////////////////////////
       var selectedr=false;
      var selectedIndex=0;

      $("#serviceFinder").keypress(function(e){
        selectedr=false;
        selectedIndex=0;
        if(e.keyCode==40&&$(".service-holder ul li").length>0){
             if(selectedr==false){
              $("#serviceFinder").trigger('blur');
              $(".service-holder>ul li").eq(0).addClass('active');
              selectedr=true;
              
            }//selected false
            
        }//if keycode==40

      });
 
     $(document).keypress(function(e){
      if($(".service-holder ul li").length>0&&selectedr==true){
         var index=$(".service-holder>ul li.active").index();
           $(".service-holder>ul li").eq(index).removeClass("active");

        if(e.keyCode==40){
             //alert(index);
             if(index<$(".service-holder ul li").length){
                $(".service-holder>ul li").eq(selectedIndex).addClass("active");
                selectedIndex++;
            }
        }//if 40
        else if(e.keyCode==38){
          if(index>0){
                $(".service-holder>ul li").eq(selectedIndex-2).addClass("active");
                selectedIndex--;
                
            }
        }
       ///////////////////////////////ENTER CLICKING///////////////

       if(e.keyCode==13){
        $(".service-holder>ul li").eq(selectedIndex-1).trigger('click');
       }


      }//selectedr=true

       
      });
     ///////////////////END ACCESSING VIA KEYBOARD////////////

      ///////////////////////////////////////////////
      //////////reseting search,hiding menu
      ////////////////////////////////////////////////
      $(document).on("click","body",function(event){
          var nodes=$(event.target);
          if(!nodes.is(".serviceList")){
              $(".service-holder").fadeOut(200);
          }
      });
      ////////////////////////////////////////////////
      /////////// COPY BILLING ADDRESS
      //////////////////////////////////////////////
      $("#copyAddress").change(function(e){
          var billingAddress=$("#billing_address").val();
          if($("#copyAddress").prop("checked")){
              $("#service_address").val(billingAddress);
          }else{
              $("#service_address").val("");
          }
      });
      ////////////////////////////////////////////////
      /////////// COPY CUSTOMER NAME
      //////////////////////////////////////////////
      $("#copyCustomer").change(function(e){
          var billingAddress=$("#customer_name").val();
          if($("#copyCustomer").prop("checked")){
              $("#contact_person").val(billingAddress);
          }else{
              $("#contact_person").val("");
          }
      });
      ////////////////////////////////////////////
      //////////AUTO SELECT CUSTOMER
      ///////////////////////////////////////////
      $(window).load(function(){
          var customerID=$("#customer_id").val();
          $("#customer").val(customerID);
      });

      ////////////////////////////////////////////
      //////////ADD NEW CUSTOMER
      ///////////////////////////////////////////
      $("#customer-btn").click(function(){
          $(".error-msg").css({"display":"none"});
          var customer_name= $.trim($("#customer_name").val());
          var contact_person= $.trim($("#contact_person").val());
          var phone= $.trim($("#phone").val());
          var email= $.trim($("#email_address").val());
          var website= $.trim($("#website").val());
          var billing_address= $.trim($("#billing_address").val());
          var service_address= $.trim($("#service_address").val());
          var error=false;
          if(customer_name==""){
              $("#customer_name").next("span").show();
              error=true;
          }
          if(contact_person==""){
              $("#contact_person").next("span").show();
              error=true;
          }
          if(phone==""){
              $("#phone").next("span").show();
              error=true;
          }

          if(billing_address==""){
              $("#billing_address").next("span").show();
              error=true;
          }
          if(service_address==""){
              $("#service_address").next("span").show();
              error=true;
          }
          if(error==false){
              $.ajax({
                  url: base_url+'/admin/ajaxSaveCustomer',
                  type:"POST",
                  data:{
                      customer_name:customer_name,
                      contact_person:contact_person,
                      phone:phone,
                      email_address:email,
                      website:website,
                      billing_address:billing_address,
                      service_address:service_address
                  },
                  success:function(data){
                          var strr='<option value="'+data.id+'">'+data.name+'</option>';
                         // alert(strr);
                          $("#customer").append(strr);
                          $("#customer-alert").show(200).delay(3000).hide(200,function(){
                              $("#customer-form").trigger('reset');
                              $("#customerModal").modal('hide');
                          });



                  },
                  error:function(){
                      alert("Some thing went wrong");
                  }
              });
          }

      });
      ///////////////////////////////////////////////////////////////
      /////////// ADD NEW SERVICE
      //////////////////////////////////////////////////////////////////

      //attach_proposal modal
      $(".attach_proposal_previewr").click(function(){
             var ID=$(this).data('atid');
             // for server it needs "public" path 
              // $.get(base_url+"/public/crm/getAttachmentInfo/"+ID,function(data){ 
            $.ajax({
              url: base_url+"/crm/getAttachmentInfo",
              type: "GET",
              data: {
                id: ID
              },
              success: function (data) {
                if(data === false){
                  alert('Not found this file.');
                } else {
                  //for server
                  //var url = base_url+'/public/uploads/pdf forms/'+data;

                  var url = base_url + '/public/uploads/pdf forms/'+data;
                  $("#attachmentFile").attr("src",url);
                  $("#attach_modal").modal('show');
                }
                  
              },
              error: function () {
                  alert("Something went wrong");
              }
            });  
      });
      // attach_proposal modal end

      $(".attach_file_preview").click(function(e){
        e.preventDefault();
        var file= base_url + '/uploads/pdf forms/'+$(this).data('file');console.log(file);
        $("#attach_iframe").attr("src",file);
        $("#preview_attach").modal('show');
      });

      $("#service-btn").click(function() {
          $(".error-msg").css({"display":"none"});
          var name= $.trim($("#name").val());
          var price= $.trim($("#price").val());
          var tax_rate= $.trim($("#tax_rate").val());
          var error=false;
          if(name==""){
              $("#name").next("span").show();
              error=true;
          }
          if(price==""){
              $("#price").next("span").show();
              error=true;
          }
          if(tax_rate==""){
              $("#tax_rate").next("span").show();
              error=true;
          }
          if(error==false){
              //ajax goes here
              $.ajax({
                  url: base_url+"/crm/ajaxSaveServiceOrProduct",
                  type:"POST",
                  data:{
                      _token: $('#csrf_token').val(),
                      name:name,price:price,tax_rate:tax_rate
                  },
                  success:function(data){
                      if(data=="SUCCESS") {
                          $("#service-alert").show(200).delay(3000).hide('fast', function() {
                              $("#service-form").trigger('reset');
                              $("#serviceModal").modal('hide');
                          });

                      }

                  },
                  error:function(){
                      alert("Some thing went wrong");
                  }
              });
          }

      });
      /////////////////////////////////////////////////////////////////////
      ///////// PROPOSAL FORM SUBMIT
      /////////////////////////////////////////////////////////////////////
      $("#proposal-form").submit(function(){
          var customerId=$("#customer").val();
          var title=$("#proposal_title").val();
          var serviceNum=$("#form-table tbody tr").length;
          var error=false;
          //alert(id);
          for(var n=0;n==id-1;n++){
             //alert($("#description_"+n).val());
             if(deletedRow.indexOf(n)<0){
               var description= $.trim($("#description_"+n).val());
               //alert(description);
               if(description.length>255){
                   $("#description_"+n).css({"border-color":"red"});
               $("#description_"+n).next("span").show(200).delay(5000).hide(200,function(){
               $("#description_"+n).css({"border-color":"#ccc"});
               });
               error=true;
               }
               }
          }
          if(serviceNum<1){
              $(".service-empty").show(200).delay(5000).hide(200);
               error=true;
          }
          if(customerId==""){
              $("#customer").css({"border-color":"red"});
              $("#customer").parent().children("span").show(200).delay(5000).hide(200,function(){
                  $("#customer").css({"border-color":"#ccc"});
              });
              error=true;
          }
          if(title==""){
              $("#proposal_title").css({"border-color":"red"});
              $("#proposal_title").parent().children("span").show(200).delay(5000).hide(200,function(){
                  $("#proposal_title").css({"border-color":"#ccc"});
              });
              error=true;
          }

          if(error==true){
              return false;
          }
          //return false;
      });
  });

// });


// summernote 
$(function() {
        $('.summernote').summernote({

            height: 150,
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            /////////////
        });
        $(window).load(function(){
            $('.note-toolbar .note-fontsize,.note-fontname,.note-font [data-event="removeFormat"],.note-insert,.note-height,.note-view, .note-toolbar .note-color, .note-toolbar .note-para .dropdown-menu li:first, .note-toolbar .note-line-height').remove();

        });

    });

// summernote for mail 
    $(document).ready(function() {
        $('.mail_summernote').summernote({

            height: 350,
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            /////////////
        });
        $(window).load(function(){
            $('.note-toolbar .note-fontsize,.note-fontname,.note-font [data-event="removeFormat"],.note-insert,.note-height,.note-view, .note-toolbar .note-color, .note-toolbar .note-para .dropdown-menu li:first, .note-toolbar .note-line-height').remove();

        });

    });

//invoice mail summernote
$(document).ready(function() {
    $('.invoice_mail_summernote').summernote({
        height: 350,
        codemirror: { // codemirror options
            theme: 'monokai'
        },
        /////////////
    });
    $(window).load(function(){
      $('.note-toolbar .note-fontsize,.note-fontname,.note-font [data-event="removeFormat"],.note-insert,.note-height,.note-view, .note-toolbar .note-color, .note-toolbar .note-para .dropdown-menu li:first, .note-toolbar .note-line-height').remove();
    });


    $('.Servicepop431').click(function(){
      var prop_serv_id  = $(this).data('prop_serv_id');
      var type          = $(this).data('type');
      var action        = $(this).data('action');
      $('#prop_serv_id').val(prop_serv_id);
      $('#Servtype').val(type);
      $('#ServiceAction').val(action);

      if(action == 'add'){
        $('#serViceName, #servcPrice, #servcRate').val('');
        $("#Servicepop431-modal").modal('show');
      }else{
        var service_id  = $(this).data('service_id');
        $.ajax({
          url: base_url+"/service/save-tax-action",
          type:"POST",
          dataType : 'json',
          data:{ 'prop_serv_id':prop_serv_id, 'service_id':service_id, 'type':type, 'action':'getServiceById' },
          beforeSend : function(){
            $('.show_loader').html('<img src="/img/spinner.gif">');
            $("#Servicepop431-modal").modal('show');
          },
          success:function(resp){
            var data = resp.service;
            $('.show_loader').html('');
            $('#serViceName').val(data.service_name);
            $('#servcPrice').val(data.price);
            $('#servcRate').val(data.tax_rate);
            $('#dfltServiceId').val(service_id);
          }
        });
      }

      
    });

    $('.tax_rate_open').click(function(){
      var is_archive = $(this).attr('data-is_archive');
      $.ajax({
        url: base_url+"/service/save-tax-action",
        type:"POST",
        //dataType : 'json',
        data:{ 'is_archive':is_archive, 'action':'getTaxRatePopup' },
        beforeSend : function(){
          $('#tax_rate-modal .show_loader').html('<img src="/img/spinner.gif">');
          $('.TaxRateTable tbody').html('');
          $("#tax_rate-modal").modal('show');
        },
        success:function(resp){
          $('.show_loader').html('');
          if(is_archive == 'hide'){
            $('#tax_rate_open').html('Show Archive');
            $('#tax_rate_open').attr('data-is_archive', 'show');
          }else{
            $('#tax_rate_open').html('Hide Archive');
            $('#tax_rate_open').attr('data-is_archive', 'hide');
          }
          $('.TaxRateTable tbody').html(resp);
        }
      });
    });

    $('body').on('click', '.activities_modal', function(){
      var prop_serv_id  = $(this).attr('data-prop_serv_id');
      var type          = $(this).attr('data-type');
      var service_id    = $(this).attr('data-service_id');
      var is_archive    = $(this).attr('data-is_archive');

      $('#prop_serv_id').val(prop_serv_id);
      $('#Servtype').val(type);
      $('#dfltServiceId').val(service_id);

      $('#activities_modal').attr('data-prop_serv_id', prop_serv_id);
      $('#activities_modal').attr('data-type', type);
      $('#activities_modal').attr('data-service_id', service_id);
      $('#activities_modal').attr('data-is_archive', (is_archive=='show')?'hide':'show');
      $('#activities_modal').html((is_archive=='show')?'Hide Archive':'Show Archive');

      $.ajax({
        url: base_url+"/service/save-tax-action",
        type:"POST",
        dataType : 'json',
        data:{ 'prop_serv_id':prop_serv_id, 'service_id':service_id, 'type':type, 'is_archive':is_archive, 'action':'getServiceById' },
        beforeSend : function(){
          $('#activities-modal .show_loader').html('<img src="/img/spinner.gif">');
          $('#popActvtiList').html('');
          $("#activities-modal").modal('show');
          $('#activityOpenFrom').val('settings');
        },
        success:function(resp){
          var data        = resp.service;
          var activities  = resp.activities;
          $('#activities-modal .show_loader').html('');
          $('#acTiVePopTitlE').html(data.service_name);

          var content = '';
          $.each(activities, function(index, value){
            var checked = '';
            if(value.is_archive == 'Y'){
              checked = 'checked';
            }
            content   += '<tr class="delListAct_'+value.activity_id+'">';
            content   += '<td><span id="activity_span'+value.activity_id+'">'+value.name+'</span></td>';
            content   += '<td align="right"><span id="activity_base_span'+value.activity_id+'">'+value.base_fee+'</span></td>';
            content   += '<td align="center"><span id="activity_action_'+value.activity_id+'"><a href="javascript:void(0)" class="editActivity" data-activity_id="'+value.activity_id+'"><img src="/img/edit_icon.png"></a>&nbsp;<a href="javascript:void(0)" class="deletePropActivity" data-service_id="'+service_id+'" data-prop_serv_id="'+prop_serv_id+'" data-activity_id="'+value.activity_id+'"><img src="/img/cross.png" height="12"></a></span></td>';
            content   += '<td align="center"><input type="checkbox" '+checked+' name="step_actv'+value.activity_id+'" id="step_actv'+value.activity_id+'" class="actArchiveCheck" value="'+value.activity_id+'" data-activity_id="'+value.activity_id+'" /></td>';
            content   += '</tr>';

          });
          $('#popActvtiList').append(content);
        }
      });
      
    });

    $('#saveActivtbTn').click(function(){
      var prop_serv_id  = $('#prop_serv_id').val();
      var type          = $('#Servtype').val();
      var service_id    = $('#dfltServiceId').val();
      var name          = $('#actIviTyName').val();
      var base_fee      = $('#servActBaseFee').val();
      if(name == ''){
        alert('Please enter activity name');
        $('#actIviTyName').focus();
        return false;
      }else if(base_fee == ''){
        alert('Please enter base fee');
        $('#servActBaseFee').val();
        return false;
      }

      $.ajax({
        url: base_url+"/service/save-tax-action",
        type:"POST",
        dataType : 'json',
        data:{'prop_serv_id':prop_serv_id,'service_id':service_id,'type':type,'name':name,'base_fee':base_fee,'action':'saveActivity' },
        beforeSend : function(){
          $('.show_loader').html('<img src="/img/spinner.gif">');
          $("#activities-modal").modal('show');
          $('#actIviTyName, #servActBaseFee').val('');
        },
        success:function(resp){
          var value = resp.activity;
          $('.show_loader').html('');

          var content = '';
          content   += '<tr class="delListAct_'+value.activity_id+'">';
          content   += '<td><span id="activity_span'+value.activity_id+'">'+value.name+'</span></td>';
          content   += '<td align="right"><span id="activity_base_span'+value.activity_id+'">'+value.base_fee+'</span></td>';
          content   += '<td align="center"><span id="activity_action_'+value.activity_id+'"><a href="javascript:void(0)" class="editActivity" data-activity_id="'+value.activity_id+'"><img src="/img/edit_icon.png"></a>&nbsp;<a href="javascript:void(0)" class="deletePropActivity" data-service_id="'+service_id+'" data-prop_serv_id="'+prop_serv_id+'" data-activity_id="'+value.activity_id+'"><img src="/img/cross.png" height="12"></a></span></td>';
          content   += '<td align="center"><input type="checkbox" name="step_actv'+value.activity_id+'" id="step_actv'+value.activity_id+'" class="actArchiveCheck" value="'+value.activity_id+'" data-activity_id="'+value.activity_id+'" /></td>';
          content   += '</tr>';
          $('#popActvtiList').append(content);

          if(service_id == '0'){
            $('#serviceTable tbody .ServTablTr_'+prop_serv_id+' td:nth-child(4) select').append('<option value="'+value.activity_id+'">'+value.name+' (£'+value.base_fee+')</option>');
          }else{
            $('#serviceTable tbody .TaskServTablTr_'+service_id+' td:nth-child(4) select').append('<option value="'+value.activity_id+'">'+value.name+' (£'+value.base_fee+')</option>');
          }

        }
      });

    });

    $('body').on('click', '.deletePropActivity', function(){
      var activity_id   = $(this).data('activity_id');
      var prop_serv_id  = $(this).data('prop_serv_id');
      var service_id    = $(this).data('service_id');
      if(!confirm('Do you want to delete ?')){
        return false;
      }

      $.ajax({
        url: base_url+"/service/save-tax-action",
        type:"POST",
        dataType : 'json',
        data:{'activity_id':activity_id, 'action':'deleteActivity' },
        beforeSend : function(){
          $('#activities-modal .show_loader').html('<img src="/img/spinner.gif">');
        },
        success:function(resp){
          $('#activities-modal .show_loader').html('');
          if(resp.count >0){
            alert("Activity cannot be used delete as its in use. Please archive");
            return false;
          }else{
            $('.delListAct_'+activity_id).hide();
            if(service_id == '0'){
              $('#serviceTable tbody .ServTablTr_'+prop_serv_id+' td:nth-child(4) select option[value="'+activity_id+'"]').remove();
            }else{
              $('#serviceTable tbody .TaskServTablTr_'+service_id+' td:nth-child(4) select option[value="'+activity_id+'"]').remove();
            }
          }
          //$(".tAxRaTeSelecT option[value='"+id+"']").remove();
        }
      });
    });

    $('.newPricingTemplate').click(function(){
      var pop_type = $(this).data('pop_type');
      $('.popupDrop').hide();
      if(pop_type == 'PT'){
        $('.TitLe').html('CREATE NEW PRICING TEMPLATE');
        $('#divDrop'+pop_type).show();
        $("#newPricingTemplate-modal").modal('show');
      }else if(pop_type == 'S'){
        $('.TitLe').html('SELECT SERVICES');
        //getAllServices(pop_type);
        openServicesPopUp(pop_type);
      }else{
        $('.TitLe').html('SELECT PRICING');
        $('#divDrop'+pop_type).show();
        $("#newPricingTemplate-modal").modal('show');
      }
      
    });

    $('.newLetterTemplate').click(function(){
      $("#newLetterTemplate-modal").modal('show');
    });

    $('#saveTaxRates').click(function(){
      var name = $('#Taxname').val();
      var tax_rate = $('#Taxrate').val();
      if(name == ''){
        alert('Please enter name');
        return false;
      }else if(tax_rate == ''){
        alert('Please enter tax rate');
        return false;
      }else{
        $.ajax({
          url: base_url+"/service/save-tax-action",
          type:"POST",
          data:{ 'name':name, 'tax_rate':tax_rate, 'action':'add_tax' },
          beforeSend : function(){
            $('.show_loader').html('<img src="/img/spinner.gif">');
          },
          success:function(id){//alert(id)
            $('#Taxname, #Taxrate').val('');
            $('.show_loader').html('');

            var content = '<tr class="TaxRateTr_'+id+'">';
            content += '<td>'+name+'</td>';
            content += '<td>'+tax_rate+'%</td>';
            content += '<td align="center"><a href="javascript:void(0)" data-id="'+id+'" class="deleteTaxRate"><img src="/img/cross.png" height="12"></a></td>';
            content += '<td align="center"><input type="checkbox" class="arcTaxRate"  data-id="'+id+'" data-update_value="Y" data-event="archive" /></td>';
            content += '</tr>' ;
            $('.TaxRateTable').append(content);

            $('.tAxRaTeSelecT').append('<option value="'+id+'">'+name+'('+tax_rate+'%)</option>');
          }
        });
      }
    });

    $('body').on('click', '.deleteTaxRate', function(){
      var id  = $(this).data('id');
      if(confirm('Do you want to delete?')){
        $.ajax({
          url: base_url+"/service/save-tax-action",
          type:"POST",
          dataType : 'json',
          data:{ 'id':id, 'action':'delete_tax' },
          beforeSend : function(){
            $('.show_loader').html('<img src="/img/spinner.gif">');
          },
          success:function(resp){
            $('.show_loader').html('');
            if(resp.message == 'exists'){
              alert("Tax rate cannot be used delete as its in use. Please archive");
              return false;
            }else{
              $('.TaxRateTr_'+id).hide();
              $(".tAxRaTeSelecT option[value='"+id+"']").remove();
            }
          }
        });
      }
    });

    $('body').on('change', '.arcTaxRate', function(){
      if($(this).is(':checked')){
        var event         = 'archive';
        var update_value  = 'Y';
      }else{
        var event         = 'unarchive';
        var update_value  = 'N';
      }
      var column_name   = 'tax_rate_id';
      var column_value  = $(this).attr('data-id');
      var table_name    = 'tax_rates';

      $.ajax({
        url: "/settings/action",
        type: "POST",
        dataType : 'json',
        data : {'column_name':column_name, 'column_value':column_value, 'table_name':table_name, 'update_value':update_value, 'event':event, 'action':'archiveProposalItems'},
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {
          if(event == 'archive'){
            var message = '<span style="color:#00c0ef">Data has been archived</span>';
          }
          if(event == 'unarchive'){
            var message = '<span style="color:#00c0ef">Data has been un-archived</span>';
          }
          $(".show_loader").html(message);
          setTimeout(function(){
            $(".show_loader").html('');
          }, 2000);

          if(event == 'archive'){
            $('.TaxRateTr_'+column_value).hide();
          }else{
            $('.TaxRateTr_'+column_value).removeClass('rowColor');
          }
        }
      });
    });

//Add Service
    $('.saveServiceInPop').click(function(){
      var service_name  = $('#serViceName').val();
      var price         = $('#servcPrice').val();
      var rate          = $('#servcRate').val();
      var prop_serv_id  = $('#prop_serv_id').val();
      var Servtype      = $('#Servtype').val();
      var service_id    = $('#dfltServiceId').val();
      var action        = $('#ServiceAction').val();

      if(service_name == ''){
        alert('Please enter service name');
        return false;
      }else if(price == ''){
        alert('Please enter price');
        return false;
      }else if(rate == ''){
        alert('Please select tax rate');
        return false;
      }else{
      $.ajax({
        url: base_url+"/service/save-tax-action",
        type:"POST",
        dataType : 'json',
        data:{ 'service_id':service_id, 'service_name':service_name, 'dbAction':action, 'price':price, 'tax_rate':rate, 'prop_serv_id':prop_serv_id, 'Servtype':Servtype, 'action':'save_service' },
        beforeSend : function(){
          $('.show_loader').html('<img src="/img/spinner.gif">');
          $('#serViceName').val('');
          $('#servcPrice').val('');
          $('#servcRate').val('');
        },
        success:function(resp){
          $("#Servicepop431-modal").modal('hide');
          $('#Taxname, #Taxrate').val('');
          $('.show_loader').html('');
          var services = resp;

          var content = '<tr class="ServTablTr_'+services.prop_serv_id+'">';
          content += '<td>'+services.service_name+'</td>';
          content += '<td>'+services.price+'</td>';
          content += '<td>'+services.tax_percent+'%</td>';
          content += '<td><div style="float: left;width: 10%; margin-right: 3px;"><a href="javascript:void(0)" class="activities_modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></div>';
          content += '<div style="float: left; width: 87%">';
          content += '<select class="form-control newdropdown">';
          content += '<option value="">-- Select --</option>';
          content += '</select>';
          content += '</td>';

          content += '<td><div class="btn-group">';
          content += '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">';
          content += '<i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
          content += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
          content += '<li><a href="javascript:void(0)" data-type="'+Servtype+'" data-prop_serv_id="'+prop_serv_id+'" class="Servicepop431"><i class="fa fa-edit tiny-icon"></i>Edit</a></li>';
          content += '<li><a href="#" class="delete" data-id=""><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
          content += '</ul></div></td>';

          content += '</tr>' ;
          if(action == 'add'){
            $('#serviceTable tbody').append(content);
          }else{
            var price = parseFloat(services.price).toFixed(2);

            if(service_id == '0'){
              $('#serviceTable tbody .ServTablTr_'+services.prop_serv_id+' td:nth-child(1)').html(services.service_name);
              $('#serviceTable tbody .ServTablTr_'+services.prop_serv_id+' td:nth-child(2)').html(price);
              $('#serviceTable tbody .ServTablTr_'+services.prop_serv_id+' td:nth-child(3)').html(services.tax_percent+'%');
            }else{
              $('#serviceTable tbody .TaskServTablTr_'+service_id+' td:nth-child(1)').html('*'+services.service_name);
              $('#serviceTable tbody .TaskServTablTr_'+service_id+' td:nth-child(2)').html(price);
              $('#serviceTable tbody .TaskServTablTr_'+service_id+' td:nth-child(3)').html(services.tax_percent+'%');
            }
          }
        }
       });
      }
    });
    
    $('body').on('click', '.deletePropService', function(){
      var id    = $(this).data('id');
      var type  = $(this).data('type');

      $.ajax({
        url: base_url+"/service/save-tax-action",
        type:"POST",
        dataType : 'json',
        data:{ 'id':id, 'type':type, 'action':'delete_service' },
        beforeSend : function(){
          //$('.show_loader').html('<img src="/img/spinner.gif">');
        },
        success:function(resp){
          $('.ServTablTr_'+id).hide();
        }
      })

    });

    $('body').on('change', '.PopCheckServ', function(){
      var service_id = $(this).val();
      if($(this).is(':checked')){
        $('.srvListProp_'+service_id+' input[type=checkbox]').attr('disabled',true);
        $(this).attr('disabled',false);
      }else{
        $('.srvListProp_'+service_id+' input[type=checkbox]').attr('disabled',false);
      }
    });

    $('body').on('change', '.AddServiceHead', function(){
      var postData  = [];

      postData['service_id']      = $(this).data('service_id');
      postData['service_name']    = $(this).data('service_name');
      postData['service_option']  = $(this).val();
      addServiceHead(postData);
    });

    /* ===================== New Proposal Section ======================== */
    $('body').on('change', '#NewPropContctType', function(){
      $('#SPlus').hide();

      var cont_type = $(this).val();
      $('.TemplateNameTd').hide();
      $('#clientProspectList, .FirstPlusIcon, #propContactTd, .SecondPlusIcon').show();
      $("#CreateProposalActionDrop li:nth-child(2)").show();
      $("#CreateProposalActionDrop li:nth-child(3)").show();
      $("#CreateProposalActionDrop li:nth-child(4)").show();

      if(cont_type == ''){
        $('#propContactList, #FPlus, #propContactDrop').hide();
      }else{
        var DropVal = cont_type.split('_');
        if(DropVal[1] == 'ind'){
          $('#propContactList, #FPlus').show();
          $('#propContactDrop').hide();
        }else if(DropVal[1] == 'org'){
          if(DropVal[0] == 'p'){
            $('#propContactList, #FPlus, #propContactDrop').show();
          }else{
            $('#propContactDrop').show();
          }
        }else{
          $('#clientProspectList, .FirstPlusIcon, #propContactTd, .SecondPlusIcon, #SPlus').hide();
          $('.TemplateNameTd').show();
          $("#CreateProposalActionDrop li:nth-child(2)").hide();
          $("#CreateProposalActionDrop li:nth-child(3)").hide();
          $("#CreateProposalActionDrop li:nth-child(4)").hide();
        }

        var link = '';
        //$('#open_form-modal .email_btns .save_t2').attr('type', 'button');
        if(cont_type == 'p_ind'){
          link = '<a href="javascript:void(0)" id="FPlus" data-type="ind" data-leads_id="0" class="open_form-modal"><img src="/img/plus_1.png"></a>';
        }else if(cont_type == 'p_org'){
          link = '<a href="javascript:void(0)" id="FPlus" data-type="org" data-leads_id="0" class="open_form-modal"><img src="/img/plus_1.png"></a>';
        }else if(cont_type == 'c_ind'){
          link = '<a href="javascript:void(0)" id="FPlus" class="FirstPlusA" data-cont_type="'+cont_type+'"><img src="/img/plus_1.png"></a>';
        }else if(cont_type == 'c_org'){
          link = '<a href="javascript:void(0)" id="FPlus" class="FirstPlusA" data-cont_type="'+cont_type+'"><img src="/img/plus_1.png"></a>';
        }else if(cont_type == 'template'){
          link = '<a href="javascript:void(0)" id="FPlus" class="FirstPlusA" data-cont_type="'+cont_type+'"><img src="/img/plus_1.png"></a>';
        }
        $('.FirstPlusIcon').html(link)
        //$('#propContactList, #FPlus, #propContactDrop, #SPlus').show();

        $.ajax({
          url: base_url+"/proposal/action",
          type:"POST",
          dataType : 'json',
          data:{'cont_type':cont_type, 'action':'getProspectByType' },
          beforeSend : function(){
            //$('#clientProspectList').html('');
          },
          success:function(resp){
            var option = '<select class="form-control newdropdown" id="propContactList" data-cont_type="'+cont_type+'"><option value="">Select Client or Prospect</option>';
            $.each(resp.prospects, function(k,v){
              if(cont_type == 'c_ind' || cont_type == 'c_org'){
                option += '<option value="'+v.client_id+'">'+v.client_name+'</option>';
              }else{
                option += '<option value="'+v.leads_id+'">'+v.prospect_name+'</option>';
              }
            });
            option += '</select>';
            $('#clientProspectList').html(option);
          }
        });//Ajax End
      }
    });

    $('body').on('click', '.FirstPlusA', function(){
      var cont_type = $(this).attr('data-cont_type');
      if(cont_type == 'c_ind'){
        $('#FirstPlusOrgIcon').hide();
        $('#FirstPlusIndIcon').show();
        $('#poPTypE').html('INDIVIDUAL');
      }else{
        $('#FirstPlusIndIcon').hide();
        $('#FirstPlusOrgIcon').show();
        $('#poPTypE').html('ORGANISATION');
      }
      $("#FirstPlusA-modal").modal("show");
    });

    $('body').on('change', '#propContactList', function(){
      var drop1_val = $('#NewPropContctType').val();
      var item_id   = $(this).val();
      var cont_type = $(this).data('cont_type');

      if(drop1_val == 'c_org' && item_id != ''){//
        $('#SPlus').show();
      }else{
        $('#SPlus').hide();
      }
      //if(cont_type != ''){
        $.ajax({
          url: base_url+"/proposal/action",
          type:"POST",
          dataType : 'json',
          data:{'item_id':item_id, 'cont_type':cont_type, 'action':'getContactByType' },
          beforeSend : function(){
            //$('#propContactTd').html('');
          },
          success:function(resp){
            var option = '<select class="form-control newdropdown" id="propContactDrop"><option value="">Select Contact</option>';
            $.each(resp.prospects, function(k,v){
              if(cont_type == 'c_org'){
                option += '<option value="'+v.item_id+'_'+v.item_type+'">'+v.item_name+'</option>';
              }else{
                option += '<option value="'+v.contact_id+'">'+v.contact_name+'</option>';
              }
            });
            option += '</select>';
            if(cont_type == 'p_org' || cont_type == 'c_org'){
              $('#propContactTd').html(option);
            }
          }
        });

    });

    $('body').on('click', '.saveProposals', function(){
      var save_type       = $(this).data('save_type');
      saveNewProposal(save_type, 'btnClick');
      /*var contact_type    = $('#NewPropContctType').val();
      var prospect_id     = $('#propContactList').val();
      var contact_id      = $('#propContactDrop').val();
      var validity        = $('#propValidity').val();
      var proposal_title  = $('#PropTitle').val();
      var start_date      = $('#ProsStartDate').val();
      var end_date        = $('#ProsEndDate').val();
      var ProposalID      = $('#ProposalID').val();
      var contact_name    = $('#propContactDrop option:selected').text();
      var ExtProspectId   = $('#ExtProspectId').val();
      var from_page       = $('#from_page').val();//alert(contact_name);return false;
      var postData = [contact_type,prospect_id,contact_id,validity,proposal_title,start_date,end_date,save_type,ProposalID,contact_name,ExtProspectId,from_page];
      if(validation()){
        $.ajax({
          url: base_url+"/proposal/action",
          type:"POST",
          dataType : 'json',
          data:{'postData':JSON.stringify(postData), 'action':'saveNewProposal' },
          beforeSend : function(){
            $('#message_div').html('<img src="/img/spinner.gif">');
          },
          success:function(resp){
            $('#message_div').html('');
            //window.location.href = '/crm/viewAllProposal';
            if(save_type == 'D'){
              var p = resp.proposals;
              $('#ProposalID').val(p.proposalID);
              $('#ExtProspectId').val(p.crm_proposal_id);
            }else if(save_type == 'F' || save_type == 'DC'){
              window.location.href = '/crm/viewAllProposal';
            }
          }
        });
      }*/
    });

    $('body').on('click', '#SPlus', function(){
      var secVal = $('#propContactList').val();
      $('#secPlusPopCompanyName').val(secVal);
      $("#SecondPlusA-modal").modal("show");
    });

    $('body').on('change', '#cntTypeSecPlus', function(){
      var value = $(this).val();
      $('#secDropVal').val(value);
      if(value == 3){
        $('#posSelectSecP').hide();
        $('#posTextSecP').show();
      }else{
        $('#posTextSecP').hide();
        $('#posSelectSecP').show();
      }
    });

    $('body').on('click', '#saveSecPlusPop', function(){
      $("#SecondPlusA-modal #saveContactForm").ajaxForm({
        dataType: 'json',
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function(resp) {
          $(".show_loader").html('');
          var contact = resp.contacts;

          var option = '<option value="'+contact.contact_id+'_'+contact.contact_type+'">'+contact.contact_name+'</option>';
          $('#propContactDrop').append(option);
          $('#SecondPlusA-modal').modal('hide');
          
        }
      }).submit();

    });
    
    $('body').on('click', '#deleteProposalFinal', function(){
      var proposal_id = $(this).data('proposal_id');
      var crm_proposal_id = $(this).data('crm_proposal_id');
      if(confirm('Do you want to delete?')){
        $.ajax({
          url: base_url+"/proposal/action",
          type:"POST",
          dataType : 'json',
          data:{'proposal_id':proposal_id, 'crm_proposal_id':crm_proposal_id, 'action':'deleteProposal' },
          beforeSend : function(){
            $('#message_div').html('<img src="/img/spinner.gif">');
          },
          success:function(resp){
            $('#message_div').html('');
            //location.reload();
            $('.FiNalTableTr_'+crm_proposal_id).hide();
          }
        });
      }
    });

    /*$('body').on('click', '.tableTabheader', function(){
      var no    = $(this).data('no');
      var type  = $(this).attr('data-type');
      $('.subTableIn').hide();

      if(type == 'up'){
        $('#subTableIn_'+no).show();
        $(this).attr('data-type', 'down');
        $(this).find('img').attr('src', '/img/arrows-up.png');
      }else{
        $('#subTableIn_'+no).hide();
        $(this).attr('data-type', 'up');
        $(this).find('img').attr('src', '/img/arrows-down.png');
      }
    });*/

    $('body').on('click', '.innerSubTable', function(){
      var no    = $(this).data('sub_no');
      var type  = $(this).attr('data-type');
      $('.subSubTableRow').hide();
      if(type == 'down'){
        $('#1subSubTableRow_'+no).show();
        $('.2subSubTableRow_'+no).show();
        $(this).attr('data-type', 'up');
        $(this).find('img').attr('src', '/img/arrows-up.png');
      }else{
        $('#1subSubTableRow_'+no).hide();
        $('.2subSubTableRow_'+no).hide();
        $(this).attr('data-type', 'down');
        $(this).find('img').attr('src', '/img/arrows-down.png');
      }
    });

    $('body').on('click', '.addTableButton', function(){
      $('#newTableForm').show();
    });

    $('body').on('click', '.addNewTableBtn', function(){
      //var proposal_id   = $('#ProposalID').val();
      var proposal_id   = '99999';
      var page_name     = $('#old_page_name').val();
      var package_name  = $('#heading_name').val();
      var heading_type  = $('#heading_type').val();

      if(package_name == ''){
        alert('Please enter package name');
        $('#heading_name').focus();
        return false;
      }else if(heading_type == ''){
        alert('Please enter package type');
        $('#heading_type').focus();
        return false;
      }

      $("#addTableProposalForm").ajaxForm({
        dataType: 'json',
        data : {'proposal_id':proposal_id},
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
          $(".toUpperCase").val('');
          $("#heading_type").val('');
        },
        success: function(resp) {
          $(".show_loader").html('');
          var heading = resp;

          var content = '<tr id="change_status_tr_'+heading.heading_id+'">';
          if(page_name == 'add'){
            content += '<td align="center"><span class="custom_chk"><input type="checkbox" name="step_check_2'+heading.heading_id+'" id="step_check_3'+heading.heading_id+'" class="heading_check" value="'+heading.heading_id+'" data-heading_id="'+heading.heading_id+'" data-is_show="O" /><label style="width:0px!important" for="step_check_3'+heading.heading_id+'">&nbsp;</label></span></td>';
            content += '<td align="center"><span class="custom_chk"><input type="checkbox" name="step_check_2'+heading.heading_id+'" id="step_check_2'+heading.heading_id+'" class="heading_check" value="'+heading.heading_id+'" data-heading_id="'+heading.heading_id+'" data-is_show="G" /><label style="width:0px!important" for="step_check_2'+heading.heading_id+'">&nbsp;</label></span></td>';
          }
            content += '<td><div class="left" id="status_span'+heading.heading_id+'">'+heading.heading_name+'</div>';
          /*if(page_name == 'settings'){
            content += '<div class="right"></div>';
          }  */

            content += '</td>';
            content += '<td align="center"><a href="javascript:void(0)" class="viewProposalServicePop" data-crm_proptbl_id="'+heading.crm_proptbl_id+'" data-heading_name="'+heading.heading_name+'" data-heading_id="'+heading.heading_id+'" data-proposal_id="'+heading.proposal_id+'" data-is_show="O"><i class="fa fa-list tiny-icon"></i></a></td>';
            content += '<td align="center">'+heading.package_name+'</td>';
            content += '<td align="center"><div class="btn-group">';
            content += '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">';
            content += '<i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
            content += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
            content += '<li><a href="javascript:void(0)" class="delete_status" data-heading_id="'+heading.heading_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
            content += '<li><a href="javascript:void(0)" class="" data-heading_id="'+heading.heading_id+'"><i class="fa fa-edit tiny-icon"></i>Archive</a></li>';
            content += '</ul>';
            content += '</div></td>';
          content += '</tr>';

          $('.add_heading_table tbody').append(content);
          
        }
      }).submit();
    });

    $("#newProposalTablePop-modal").on("click", ".edit_status", function(){
      var heading_id = $(this).data("heading_id");
      $("#old_heading_id").val(heading_id);
      var status_name = $("#status_span"+heading_id).html();
      var text_field = "<input type='text' id='status_name"+heading_id+"' value='"+status_name+"' class='form-control'>";
      var action = "<a href='javascript:void(0)' class='save_new_status' data-heading_id='"+heading_id+"'>Save</a>&nbsp;&nbsp;<a href='javascript:void(0)' class='cancel_edit' data-heading_id='"+heading_id+"'>Cancel</a>";
      $("#status_span"+heading_id).html(text_field);
      $("#action_"+heading_id).html(action);
    });

    $("#newProposalTablePop-modal").on("click", ".cancel_edit", function(){
      var heading_id = $(this).data("heading_id");
      var status_name = $("#status_name"+heading_id).val();
      var action = "<a href='javascript:void(0)' class='edit_status' data-heading_id='"+heading_id+"'><img src='/img/edit_icon.png'></a> ";
      action += '<a href="javascript:void(0)" class="delete_status" data-heading_id="'+heading_id+'"><img src="/img/cross.png" height="12"></a>';
      $("#status_span"+heading_id).html(status_name);
      $("#action_"+heading_id).html(action);
    });

    $("#newProposalTablePop-modal").on("click", ".save_new_status", function(){
      var heading_id = $(this).data("heading_id");
      var status_name = $("#status_name"+heading_id).val();
      $.ajax({
        type: "POST",
        url: "/proposal/action",
        dataType: "json",
        data: { 'heading_id': heading_id, 'heading_name' : status_name, 'action' : "editNewTable" },
        beforeSend: function() {
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {
          $(".show_loader").html('');
          if(resp.heading_name != ''){
            var action = "<a href='javascript:void(0)' class='edit_status' data-heading_id='"+heading_id+"'><img src='/img/edit_icon.png'></a>";
            action += '<a href="javascript:void(0)" class="delete_status" data-heading_id="'+heading_id+'"><img src="/img/cross.png" height="12"></a>';
            $("#status_span"+heading_id).html(status_name);
            $("#action_"+heading_id).html(action);

            $("#step_field_"+heading_id).text(status_name);
          }else{
            alert("There are some problem to update status");
          }
        }
      });
    });

    $("#newProposalTablePop-modal, #openPackagePop-modal").on("click", ".delete_status", function(){
      var heading_id = $(this).data("heading_id");
      if(confirm('Do you want to delete?')){
        $.ajax({
          type: "POST",
          url: "/proposal/action",
          dataType: "json",
          data: { 'heading_id': heading_id, 'action' : "deleteNewTable" },
          beforeSend: function() {
            $(".show_loader").html('<img src="/img/spinner.gif" />');
          },
          success: function (resp) {
            $(".show_loader").html('');
            if(resp.message == 'exists'){
              alert('Service package cannot be used delete as its in use. Please archive');
              return false;
            }else{
              $('#change_status_tr_'+heading_id).hide();
            }
          }
        });
      }
    });
    $('body').on('click', '.arcPackage', function(event){
    var column_name   = 'heading_id';
    var column_value  = $(this).attr('data-heading_id');
    var table_name    = 'crm_table_headings';
    var update_value  = $(this).attr('data-update_value');
    var event         = $(this).attr('data-event');

    $.ajax({
      url: "/settings/action",
      type: "POST",
      dataType : 'json',
      data : {'column_name':column_name, 'column_value':column_value, 'table_name':table_name, 'update_value':update_value, 'event':event, 'action':'archiveProposalItems'},
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
      },
      success: function (resp) {
        if(event == 'archive'){
          var message = '<span style="color:#00c0ef">Data has been archived</span>';
        }
        if(event == 'unarchive'){
          var message = '<span style="color:#00c0ef">Data has been un-archived</span>';
        }
        $(".show_loader").html(message);
        setTimeout(function(){
          $(".show_loader").html('');
        }, 2000);

        $('#arcPackage_'+column_value).attr('data-update_value', (update_value=='Y')?'N':'Y' );
        $('#arcPackage_'+column_value).attr('data-event', (event=='archive')?'unarchive':'archive' );
        

        if(event == 'archive'){
          $('.packageTr_'+column_value).hide();
        }else{
          $('.packageTr_'+column_value).removeClass('rowColor');
          $('#arcPackage_'+column_value).html('<i class="fa fa-edit tiny-icon"></i> Archive');
        }
      }
    });
  });

  $('body').on('click', '.packages_modal', function(){
      var is_archive    = $(this).attr('data-is_archive');
      //var proposal_id   = $('#ProposalID').val();
      var proposal_id   = $('#proposal_id').val();

      $.ajax({
        type: "POST",
        url: "/proposal/action",
        data: { 'proposal_id':proposal_id, 'is_archive':is_archive, 'action':'gatAllProposalPackages' },
        beforeSend: function() {
          $('#newProposalTablePop-modal .show_loader').html('<img src="/img/spinner.gif" />');
          $("#add_heading_table tbody").html('');
          $("#newProposalTablePop-modal").modal('show');
        },
        success: function (resp) {
          $('.show_loader').html('');   
          $(".add_heading_table").html(resp); 
          $('#packages_modal').attr('data-is_archive', (is_archive=='show')?'hide':'show');
          $('#packages_modal').html((is_archive=='show')?'Hide Archive':'Show Archive'); 
        }
      });
      
    });

    /*$(document).on('change', '.heading_check', function(event){alert('doc')
      var postData    = [];
      postData['heading_id']  = $(this).data("heading_id");
      postData['is_show']     = $(this).data("is_show");;
      postData['type']        = (postData['is_show'] == 'N')?'remove':"add";
      
      addRemoveTable( postData );
    });

    $('#newProposalTablePop-modal .heading_check').on('ifChecked', function(event){alert('doc1')
      var postData    = [];
      postData['heading_id']  = $(this).data("heading_id");
      postData['is_show']     = $(this).data("is_show");
      postData['type']        = (postData['is_show'] == 'N')?'remove':"add";
      
      addRemoveTable( postData );
    });*/

    /*$('#newProposalTablePop-modal .heading_check').on('ifUnchecked', function(event){
      var postData    = [];
      postData['heading_id']  = $(this).data("heading_id");
      postData['type']        = 'remove';
      postData['is_show']     = $(this).data("is_show");
      
      addRemoveTable( postData );
    });*/

    $(document).on('change', '.heading_check', function(event){
      var postData    = [];
      if($(this).is(':checked')){
        postData['type']      = 'add';
      } else {
        postData['type']      = 'remove';
      }
      postData['heading_id']  = $(this).data("heading_id");
      postData['is_show']     = $(this).data("is_show");
      
      addRemoveTable( postData );
    });

    $('#newProposalTablePop-modal .heading_check').on('ifChecked', function(event){
      var postData    = [];
      postData['heading_id']  = $(this).data("heading_id");
      postData['type']        = 'add';
      postData['is_show']     = $(this).data("is_show");
      
      addRemoveTable( postData );
    });
    $('#newProposalTablePop-modal .heading_check').on('ifUnchecked', function(event){
      var postData    = [];
      postData['heading_id']  = $(this).data("heading_id");
      postData['type']        = 'remove';
      postData['is_show']     = $(this).data("is_show");
      
      addRemoveTable( postData );
    });

    $('#newProposalTablePop-modal').on('change', '.recurringCheck', function(event){
      var heading_id    = $(this).data("heading_id");
      var recurring     = ($(this).is(':checked'))?'Y':'N';
      var proposal_id   = $('#proposal_id').val();
      $.ajax({
        type: "POST",
        url: "/proposal/action",
        data: { 'proposal_id':proposal_id,'recurring':recurring, 'heading_id':heading_id, 'action':'updateRecurring' },
        beforeSend: function() {
          
        },
        success: function (resp) {
 
        }
      });
    });

    $('body').on('click', '.newProposalTablePop', function(){
      if(validation()){
        var proposal_id   = $('#proposal_id').val();
        var page_name     = $(this).attr('data-page_name');
        $('#old_page_name').val(page_name);

        $.ajax({
          type: "POST",
          url: "/proposal/action",
          data: { 'proposal_id':proposal_id, 'page_name':page_name, 'is_archive':'hide', 'action':'newProposalTablePop' },
          beforeSend: function() {
            $('#newProposalTablePop-modal .show_loader').html('<img src="/img/spinner.gif" />');
            $("#add_heading_table").html('');
            $("#newProposalTablePop-modal").modal('show');
          },
          success: function (resp) {
            $('.show_loader').html('');   
            $(".add_heading_table").html(resp);  
          }
        });
      }
    });


  /* ======================== Service pop up section =============================== */
    $('body').on('click', '.newProposalServicePop', function(){
      var proposal_id   = $('#proposal_id').val();
      var p_table_id    = $(this).attr('data-crm_proptbl_id');
      $('#old_crm_proptbl_id').val(p_table_id);
      $.ajax({
        type: "POST",
        url: "/proposal/action",
        data: { 
          'p_table_id':p_table_id, 'proposal_id':proposal_id, 'action':'getServiceVyTableId'
        },
        beforeSend: function() {
          $('#newProposalServicePop-modal .show_loader').html('<img src="/img/spinner.gif" />');
          $("#add_service_table tbody").html('');
          $("#newProposalServicePop-modal").modal('show');
        },
        success: function (resp) {
          $('.show_loader').html('');   
          $(".add_service_table tbody").html(resp);  
        }
      });
    });

    $('body').on('click', '.newProposalActivityPop', function(){
      var proposal_id   = $('#proposal_id').val();
      var service_id    = $(this).attr('data-service_id');
      var service_name  = $(this).attr('data-service_name');
      var p_service_id  = $(this).attr('data-p_service_id');
      $('#old_service_id').val(service_id);
      $('#old_prop_service_id').val(p_service_id);
      $('.addNewActServName').html(service_name);

      $.ajax({
        type: "POST",
        url: "/proposal/action",
        data: { 
          'service_id':service_id, 'proposal_id':proposal_id, 'p_service_id':p_service_id, 'action':'getActivityByServiceId'
        },
        beforeSend: function() {
          $('#newProposalActivityPop-modal .show_loader').html('<img src="/img/spinner.gif" />');
          $(".add_activity_table tbody").html('');
          $("#newProposalActivityPop-modal").modal('show');
          $('#activityOpenFrom').val('new_proposal');
        },
        success: function (resp) {
          $('#newProposalActivityPop-modal .show_loader').html('');   
          $(".add_activity_table tbody").html(resp);  
        }
      });
    });

    $('body').on('click', '.viewProposalServicePop', function(){
      //var proposal_id   = $('#ProposalID').val();
      var p_table_id    = $(this).data('crm_proptbl_id');
      var heading_name  = $(this).data('heading_name');
      var heading_id    = $(this).data('heading_id');
      var proposal_id   = $(this).data('proposal_id');
      $('#old_crm_proptbl_id').val(p_table_id);

      var is_show    = $(this).data('is_show');
      $('#isShowTable').val(is_show);

      $.ajax({
        type: "POST",
        url: "/proposal/action",
        //dataType: 'json',
        data: { 
          'p_table_id':p_table_id, 'proposal_id':proposal_id, 'action':'getServicesByTableId'
        },
        beforeSend: function() {
          $('#viewProposalServicePop-modal .show_loader').html('<img src="/img/spinner.gif" />');
          $("#viewProposalServicePop-modal table tbody").html('');
          $(".tableName").html(heading_name);
          $('#proposal_id').val(proposal_id);
          //$("#viewProposalServicePop-modal .tableName").html(heading_name);
          $("#viewProposalServicePop-modal").modal('show');
          $("#viewProposalServicePop-modal .newProposalServicePop").attr('data-crm_proptbl_id', p_table_id);
        },
        success: function (resp) {
          $('.show_loader').html('');   
          var data = resp.split('ipractice');
          $("#viewProposalServicePop-modal table tbody").html(data[0]); 
          $("#viewProposalServicePop-modal #package_type").val(data[2]);
          reloadServicesOrdering();
        }
      });
    });

    $('body').on('click', '.addNewServiceBtn', function(){
        var crm_proptbl_id = $('#old_crm_proptbl_id').val();
        var service_name = $('#service_name').val();
        var base_fee      = $('#srvBaseFee').val();

        if(service_name == ''){
          alert('Please enter service name');
          $('#service_name').focus();
          return false;
        }else if(base_fee == ''){
          alert('Please enter base fee');
          $('#srvBaseFee').focus();
          return false;
        }

        $("#addServiceProposalForm").ajaxForm({
          dataType: 'json',
          data : {'crm_proptbl_id':crm_proptbl_id},
          beforeSend : function(){
            $(".show_loader").html('<img src="/img/spinner.gif" />');
          },
          success: function(resp) {
            $(".show_loader").html('');
            //$(".toUpperCase").val('');
            $("#service_name, #srvBaseFee").val('');
            
            var service = resp;

            var content = '<tr id="change_service_tr_'+service.service_id+'">';
              content += '<td align="center">';
            content += '<span class="custom_chk"><input type="checkbox" id="service_'+service.service_id+'" class="heading_service_check" value="'+service.service_id+'" data-service_id="'+service.service_id+'" /><label style="width:0px!important" for="service_'+service.service_id+'">&nbsp;</label></span></td>';
              content += '<td></td>';
              content += '<td><span id="status_span'+service.service_id+'">'+service.service_name+'</span></td>';
              content += '<td align="right"><span id="status_base_span'+service.service_id+'">'+base_fee+'</span></td>';
              content += '<td align="center"><span id="action_'+service.service_id+'">';
                content += '<a href="javascript:void(0)" class="editServices" data-service_id="'+service.service_id+'"><img src="/img/edit_icon.png"></a>';
                //content += ' <a href="javascript:void(0)" class="deleteServices" data-service_id="'+service.service_id+'"><img src="/img/cross.png" height="12"></a>';
              content += '</span></td>';
            content += '</tr>';

            $('.add_service_table tbody').append(content);
            
          }
        }).submit();
    });

    $("#newProposalServicePop-modal").on("click", ".deleteServices", function(){
        var service_id = $(this).data("service_id");
        if(confirm('Do you want to delete?')){
          $.ajax({
            type: "POST",
            url: "/proposal/action",
            dataType: "json",
            data: { 'service_id': service_id, 'action' : "deleteNewService" },
            beforeSend: function() {
              $(".show_loader").html('<img src="/img/spinner.gif" />');
            },
            success: function (resp) {
              $(".show_loader").html('');
              $('#change_service_tr_'+service_id).hide();
            }
          });
        }
    });

    $('body').on("click", ".editServices", function(){
      var service_id  = $(this).data("service_id");
      var status      = $(this).data("status");
      $("#old_service_id").val(service_id);
      var service_name  = $("#service_span"+service_id).text();
      var base_fee      = $("#service_base_span"+service_id).text();

      var text_field  = "<input type='text' id='service_name"+service_id+"' value='"+service_name+"' class='form-control'>";
      var fee_field   = "<input type='text' id='service_base"+service_id+"' value='"+base_fee+"' class='form-control priceRound'>";
      
      var action = "<a href='javascript:void(0)' class='save_new_services' data-service_id='"+service_id+"' data-status='"+status+"'>Save</a>&nbsp;&nbsp;<a href='javascript:void(0)' class='cancelEdit' data-service_id='"+service_id+"' data-status='"+status+"'>Cancel</a>";
      $("#service_span"+service_id).html(text_field);
      $("#service_base_span"+service_id).html(fee_field);
      $("#service_action_"+service_id).html(action);

      $('#service_base'+service_id).priceFormat({
        prefix: ''
      });
    });

    $("#newProposalServicePop-modal").on("click", ".cancelEdit", function(){
      var service_id    = $(this).data("service_id");
      var status        = $(this).data("status");
      var service_name  = $("#service_name"+service_id).val();
      var base_fee      = $("#service_base"+service_id).val();

      var action = "<a href='javascript:void(0)' class='editServices' data-service_id='"+service_id+"' data-status='"+status+"'><img src='/img/edit_icon.png'></a> ";
      if(status == 'new'){
        action += '<a href="javascript:void(0)" class="deleteServices" data-service_id="'+service_id+'"><img src="/img/cross.png" height="12"></a>';
      }
      $("#service_span"+service_id).html(service_name);
      $("#service_base_span"+service_id).html(base_fee);
      $("#service_action_"+service_id).html(action);
    });

    $("#newProposalServicePop-modal").on("click", ".save_new_services", function(){
      var service_id    = $(this).data("service_id");
      var service_name  = $("#service_name"+service_id).val();
      var base_fee      = $("#service_base"+service_id).val();
      var status        = $(this).data("status");
      $.ajax({
        type: "POST",
        url: "/proposal/action",
        dataType: "json",
        data: { 'service_id':service_id, 'service_name':service_name, 'base_fee':base_fee, 'action':"editNewService" },
        beforeSend: function() {
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {
          $(".show_loader").html('');
          if(resp.service_name != ''){
            var action = "<a href='javascript:void(0)' class='editServices' data-service_id='"+service_id+"' data-status='"+status+"'><img src='/img/edit_icon.png'></a>";
            if(status == 'new'){
              action += '<a href="javascript:void(0)" class="deleteServices" data-service_id="'+service_id+'"><img src="/img/cross.png" height="12"></a>';
            }
            $("#service_span"+service_id).html(service_name);
            $("#service_base_span"+service_id).html(resp.price);
            $("#service_action_"+service_id).html(action);
          }else{
            alert("There are some problem to update status");
          }
        }
      });
    });

    $(document).on('change', '.heading_service_check', function(event){
      if($(this).is(':checked')){
        var type = 'add';
      }else{
        var type = 'remove';
      }
      var postData = [];
      //postData['proposal_id'] = $('#ProposalID').val();
      postData['proposal_id'] = $('#proposal_id').val();
      postData['p_table_id']  = $('#old_crm_proptbl_id').val();
      postData['service_id']  = $(this).data("service_id");
      postData['type']        = type;
      postData['action']      = 'addRemoveServicesToTable';
      postData['page_name']   = $('#old_page_name').val();
      postData['heading_id']  = $('#old_heading_id').val();
      add_services_to_table(postData);  
    });

    /* ===================== Activity ======================== */
    $('body').on('click', '.addNewActivityBtn', function(){
        var service_id    = $('#old_service_id').val();
        var activity_name = $('#activity_name').val();
        var base_fee      = $('#actBaseFee').val();
        if(activity_name == ''){
          alert('Please enter activity name');
          $('#activity_name').focus();
          return false;
        }else if(base_fee == ''){
          alert('Please enter base fee');
          $('#actBaseFee').focus();
          return false;
        }

        $("#addActivityProposalForm").ajaxForm({
          dataType: 'json',
          data : {'service_id':service_id},
          beforeSend : function(){
            $("#addActivityProposalForm .show_loader").html('<img src="/img/spinner.gif" />');
          },
          success: function(resp) {
            $("#addActivityProposalForm .show_loader").html('');
            $("#activity_name").val('');
            $("#actBaseFee").val('');
            var service = resp;

            var content = '<tr id="change_activity_tr_'+service.activity_id+'">';
              content += '<td align="center">';
            content += '<span class="custom_chk"><input type="checkbox" id="act_check_'+service.activity_id+'" class="activity_check" value="'+service.activity_id+'" data-activity_id="'+service.activity_id+'" /><label style="width:0px!important" for="act_check_'+service.activity_id+'">&nbsp;</label></span></td>';
            content += '<td><span id="activity_span'+service.activity_id+'">'+service.name+'</span></td>';
            content += '<td align="right"><span id="activity_base_span'+service.activity_id+'">'+service.base_fee+'</span></td>';
              content += '<td align="center"><span id="activity_action_'+service.activity_id+'">';
                content += '<a href="javascript:void(0)" class="editActivity" data-activity_id="'+service.activity_id+'"><img src="/img/edit_icon.png"></a>'; 
                //content += '<a href="javascript:void(0)" class="deleteActivity" data-activity_id="'+service.activity_id+'"><img src="/img/cross.png" height="12"></a>';
              content += '</span></td>';
            content += '</tr>';

            $('.add_activity_table tbody').append(content);
            
          }
        }).submit();
    });

    $("#newProposalActivityPop-modal").on("click", ".deleteActivity", function(){
        var activity_id = $(this).data("activity_id");
        if(confirm('Do you want to delete?')){
          $.ajax({
            type: "POST",
            url: "/proposal/action",
            dataType: "json",
            data: { 'activity_id': activity_id, 'action' : "deleteNewActivity" },
            beforeSend: function() {
              $("#newProposalActivityPop-modal .show_loader").html('<img src="/img/spinner.gif" />');
            },
            success: function (resp) {
              $("#newProposalActivityPop-modal .show_loader").html('');
              $('#change_activity_tr_'+activity_id).hide();
            }
          });
        }
    });

    $("body").on("click", ".editActivity", function(){
      var activity_id  = $(this).data("activity_id");
      $("#old_activity_id").val(activity_id);

      var activity_name = $("#activity_span"+activity_id).text();
      var base_fee      = $("#activity_base_span"+activity_id).text();

      //var text_field = "<input type='text' id='activity_name"+activity_id+"' value='"+activity_name+"' class='form-control'>";
      var fee_field   = "<input type='text' id='activity_base"+activity_id+"' value='"+base_fee+"' class='priceRound'>";

      var action = "<a href='javascript:void(0)' class='save_new_activity' data-activity_id='"+activity_id+"'>Save</a>&nbsp;&nbsp;<a href='javascript:void(0)' class='cancelActivityEdit' data-activity_id='"+activity_id+"'>Cancel</a>";
      //$("#activity_span"+activity_id).html(text_field);
      $("#activity_base_span"+activity_id).html(fee_field);
      $("#activity_action_"+activity_id).html(action);

      $('#activity_base'+activity_id).priceFormat({
        prefix: ''
      });
    });

    $("body").on("click", ".cancelActivityEdit", function(){
      var activity_id   = $(this).data("activity_id");
      var activity_name = $("#activity_name"+activity_id).val();
      var base_fee      = $("#activity_base"+activity_id).val();
      var open_from     = $("#activityOpenFrom").val();
      var service_id    = $("#dfltServiceId").val();

      var action = "<a href='javascript:void(0)' class='editActivity' data-activity_id='"+activity_id+"'><img src='/img/edit_icon.png'></a> ";
      if(open_from == 'settings'){
        action += '<a href="javascript:void(0)" class="deletePropActivity" data-prop_serv_id="0" data-service_id="'+service_id+'" data-activity_id="'+activity_id+'"><img src="/img/cross.png" height="12"></a>';
      }
      $("#activity_span"+activity_id).html(activity_name);
      $("#activity_base_span"+activity_id).html(base_fee);
      $("#activity_action_"+activity_id).html(action);
    });

    $("body").on("click", ".save_new_activity", function(){
      var activity_id     = $(this).data("activity_id");
      var activity_name   = $("#activity_name"+activity_id).val();
      var base_fee        = $("#activity_base"+activity_id).val();
      var open_from       = $("#activityOpenFrom").val();
      var service_id      = $("#dfltServiceId").val();

      $.ajax({
        type: "POST",
        url: "/proposal/action",
        dataType: "json",
        data: {'activity_id':activity_id, 'activity_name':activity_name, 'base_fee':base_fee, 'action':"editNewActivity" },
        beforeSend: function() {
          $("#newProposalActivityPop-modal .show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {
          $("#newProposalActivityPop-modal .show_loader").html('');
          if(resp.name != ''){
            var action = "<a href='javascript:void(0)' class='editActivity' data-activity_id='"+activity_id+"'><img src='/img/edit_icon.png'></a> ";
            if(open_from == 'settings'){
              action += '<a href="javascript:void(0)" class="deletePropActivity" data-prop_serv_id="0" data-service_id="'+service_id+'" data-activity_id="'+activity_id+'"><img src="/img/cross.png" height="12"></a>';
            }
            $("#activity_span"+activity_id).html(activity_name);
            $("#activity_base_span"+activity_id).html(base_fee);
            $("#activity_action_"+activity_id).html(action);

            /* Dropdown value change in settings=>service page */
            $("#serviceTable tbody td:nth-child(4) select option[value='"+activity_id+"']").text(activity_name+' (£'+base_fee+')');
            //$('#serviceTable tbody .ServTablTr_'+prop_serv_id+' td:nth-child(4) select').append('<option value="'+activity_id+'">'+activity_name+' (£'+base_fee+')</option>');
          }else{
            alert("There are some problem to update status");
          }
        }
      });
    });

    $(document).on('change', '.activity_check', function(event){
      if($(this).is(':checked')){
        var type = 'add';
      }else{
        var type = 'remove';
      }
      var postData = [];
      //postData['proposal_id']     = $('#ProposalID').val();
      postData['proposal_id']     = $('#proposal_id').val();
      postData['p_service_id']    = $('#old_prop_service_id').val();
      postData['activity_id']     = $(this).data("activity_id");
      postData['type']            = type;
      postData['activity_option'] = 1;
      postData['action']          = 'addRemoveActivityToTable';
      add_activity_to_table(postData);  
    });

    $('body').on('change', '.crmActivityOption', function(){
      var p_activity_id = $(this).data("p_activity_id");
      var p_service_id  = $(this).data("p_service_id");
      var value         = $(this).val();
      $.ajax({
        type: "POST",
        url: "/proposal/action",
        dataType:'json',
        data: {'p_activity_id':p_activity_id,'p_service_id':p_service_id, 'value':value, 'action':'crmActivityOption'},
        success: function (resp) {
          $('#service_fees_'+p_service_id).val(resp.fees);
          $('#service_flexFees_'+p_service_id).val('100');
        }
      });
    });

    $('body').on('click', '.viewProposalActivityPop', function(){
      //var proposal_id     = $('#ProposalID').val();
      var proposal_id     = $('#proposal_id').val();
      var p_service_id    = $(this).data('p_service_id');
      var service_name    = $(this).data('service_name');
      var service_id      = $(this).data('service_id');
      var package_type    = $("#viewProposalServicePop-modal #package_type").val();

      //$('#old_crm_proptbl_id').val(p_table_id);
      $.ajax({
        type: "POST",
        url: "/proposal/action",
        data: { 
          'p_service_id':p_service_id, 'proposal_id':proposal_id, 'package_type':package_type, 'action':'getActitiesByServiceId'
        },
        beforeSend: function() {
          $('#viewProposalActivityPop-modal .show_loader').html('<img src="/img/spinner.gif" />');
          $("#viewProposalActivityPop-modal table tbody").html('');
          $("#viewProposalActivityPop-modal .ActivityName").html(service_name);
          $("#viewProposalActivityPop-modal").modal('show');

          $("#viewProposalActivityPop-modal .newProposalActivityPop").attr('data-p_service_id', p_service_id);
          $("#viewProposalActivityPop-modal .newProposalActivityPop").attr('data-service_id', service_id);
          $("#viewProposalActivityPop-modal .newProposalActivityPop").attr('data-service_name', service_name);
          $("#viewProposalActivityPop-modal .doNotUseFeesService").attr('data-p_service_id', p_service_id);
          $("#viewProposalActivityPop-modal .doNotUseFeesService").attr('data-service_id', service_id);
        },
        success: function (resp) {
          $('#viewProposalActivityPop-modal .show_loader').html('');  
          var splitpart   = resp.split("anwar");
          var content     = splitpart['0'];
          var isFeeAdded  = $.trim(splitpart['1']);

          if(isFeeAdded == 'N'){
            $("#viewProposalActivityPop-modal .doNotUseFeesService").iCheck('check');
          }else{
            $("#viewProposalActivityPop-modal .doNotUseFeesService").iCheck('uncheck');
          }
          $("#viewProposalActivityPop-modal table tbody").html(content);  
          reloadActivitiesOrdering();
        }
      });
    });

    /* ======== Do not use activity fees to price this service in activity pop up ======= */
    $('.doNotUseFeesService').on('ifChecked', function(event){

      var postData    = [];
      postData['p_service_id']  = $(this).attr('data-p_service_id');
      postData['service_id']    = $(this).attr('data-service_id');
      postData['type']          = 'add';
      doNotUseFeesService( postData );
    });
    $('.doNotUseFeesService').on('ifUnchecked', function(event){
      var postData    = [];
      postData['p_service_id']  = $(this).attr('data-p_service_id');
      postData['service_id']    = $(this).attr('data-service_id');
      postData['type']          = 'remove';
      doNotUseFeesService( postData );
    });



    $('body').on('click', '.proposalNotes', function(){
      var table_id    = $(this).data('table_id');
      var name        = $(this).data('name');
      var type        = $(this).data('type');
      //var proposal_id = $('#ProposalID').val();
      var proposal_id = $('#proposal_id').val();
      
      $.ajax({
        type: "POST",
        url: "/proposal/action",
        dataType:'json',
        data: { 'table_id':table_id, 'proposal_id':proposal_id, 'type':type, 'action':'getNotesByTableId' },
        beforeSend: function() {
          $('#newProposalNotesPop-modal .show_loader').html('<img src="/img/spinner.gif" />');
          $("#newProposalNotesPop-modal #proposalNote").val('');
          $("#newProposalNotesPop-modal .addNewName").html(name);
          $("#newProposalNotesPop-modal").modal('show');

          $("#newProposalNotesPop-modal #notesTableId").val(table_id);
          $("#newProposalNotesPop-modal #notesType").val(type);
        },
        success: function (resp) {
          var notes = resp.notes;
          $('#newProposalNotesPop-modal .show_loader').html('');   
          $("#newProposalNotesPop-modal #proposalNote").val(notes);
        }
      });
    });

    $('body').on('click', '.saveProposalNotesPop', function(){
      var table_id    = $("#newProposalNotesPop-modal #notesTableId").val();
      var type        = $("#newProposalNotesPop-modal #notesType").val();
      var notes       = $("#newProposalNotesPop-modal #proposalNote").val();
      //var proposal_id = $('#ProposalID').val();
      var proposal_id = $('#proposal_id').val();
      
      $.ajax({
        type: "POST",
        url: "/proposal/action",
        dataType:'json',
        data: {'table_id':table_id,'proposal_id':proposal_id,'type':type,'notes':notes,'action':'saveNotesByTableId' },
        beforeSend: function() {
          $('#newProposalNotesPop-modal .show_loader').html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {
          $('#newProposalNotesPop-modal .show_loader').html('');  
          $("#newProposalNotesPop-modal").modal('hide'); 
        }
      });
    });

    $('body').on('keyup', '.proposalHrsFees', function(){
      var postData = [];
      postData['field_value']     = $(this).val();
      postData['type']            = $(this).data('type');
      postData['column_name']     = $(this).data('column_name');
      postData['table_id']        = $(this).data('table_id');
      postData['crm_proptbl_id']  = $('#old_crm_proptbl_id').val();
      if(postData['type'] == 'activity'){
        postData['table_name']    = $('#act_table_name').val();
        postData['table_id_name'] = $('#tableIdName').val();
      }
      if(postData['type'] == 'service'){
        postData['table_name']    = $('#table_name').val();
        postData['table_id_name'] = $('#table_id_name').val();
      }
      saveHrsAndFees(postData);
    });

    $('body').on('click', '.deletePopupRow', function(){
      var postData = [];
      postData['type']            = $(this).data('type');
      postData['column_name']     = $(this).data('column_name');
      postData['table_id']        = $(this).data('table_id');
      if(postData['type'] == 'activity'){
        postData['table_name']    = $('#act_table_name').val();
        postData['table_id_name'] = $('#tableIdName').val();
      }
      if(postData['type'] == 'service'){
        postData['table_name']    = $('#table_name').val();
        postData['table_id_name'] = $('#table_id_name').val();
      }
      deleteActivityAndService(postData);
    });

    $('body').on('click', '.grandTotalTablePop', function(){
      //var proposal_id = $('#ProposalID').val();
      var proposal_id = $('#proposal_id').val();
      $.ajax({
        type: "POST",
        url: "/proposal/action",
        dataType:'json',
        data: { 'proposal_id' : proposal_id, 'action':'grandTotalTablePop' },
        beforeSend: function() {
          $('.show_loader').html('<img src="/img/spinner.gif" />');
          $('#grandTotalHeading-modal table tbody').html('');
          $("#grandTotalHeading-modal").modal('show');
        },
        success: function (resp) {
          $('.show_loader').html('');
          var content = '';

          $.each(resp.tableHeadings, function(k, v){
            var checked = disabled = '';
            if(v.grand_show > 0) checked = 'checked';
            if(v.table_show <= 0) disabled = 'disabled';

            content += '<tr id="tablePop_tr_'+v.heading_id+'">';
            content += '<td align="center"><span class="custom_chk">';
            content += '<input type="checkbox" id="table'+v.heading_id+'" class="grand_total_check" '+checked+' '+disabled+' value="'+v.heading_id+'" data-heading_id="'+v.heading_id+'" /><label style="width:0px!important" for="table'+v.heading_id+'">&nbsp;</label></span>';
            content += '</td>';
            content += '<td>'+v.heading_name+'</td>';
            content += '</tr>';
          });
          $('#grandTotalHeading-modal table tbody').html(content);
        }
      });
    });
    
    $(document).on('change', '.grand_total_check', function(event){
      if($(this).is(':checked')){
        var type = 'add';
      }else{
        var type = 'remove';
      }
      var postData = [];
      postData['heading_id']      = $(this).val();
      postData['type']            = type;
      postData['proposal_id']     = $('#proposal_id').val();
      addRemoveGrandTotal( postData );
    });

/* Activity pop up */
    $(document).on('change', '.show_fees_check', function(event){
      if($(this).is(':checked')){
        var type = 'Y';
      }else{
        var type = 'N';
      }
      var postData = [];
      postData['table_id']        = $(this).val();
      postData['popup']           = $(this).data('popup');
      postData['type']            = type;
      //alert('dd');return false;
      showHideFeesInPreview( postData );
    });


    /* ====================== Attachment Section ======================= */
    $('.checkedAttachment').on('ifChecked', function(event){
      var postData    = [];
      postData['attachment_id'] = $(this).val();
      postData['type']          = 'add';
      addRemoveAttachment( postData );
    });
    $('.checkedAttachment').on('ifUnchecked', function(event){
      var postData    = [];
      postData['attachment_id'] = $(this).val();
      postData['type']          = 'remove';
      addRemoveAttachment( postData );
    });

    $('.openNotesPopUp').on('click', function(event){
      $("#newProposalNotesPop-modal").modal('show');
    });

    $('.newPageSettingsTmpl').change(function(event){
      var table_id      = $(this).val();
      var type          = $(this).data('type');
      var contact_type  = $('#NewPropContctType').val();
      var client_id     = $('#propContactList').val();

      client_name = $('#propContactList option:selected').text();

      if(table_id == ''){
        $('#NewProposalForm #npfTempTitle').val('');
        CKEDITOR.instances.coverLtrText.setData('');
      }else{
        $.ajax({
          url: "/settings/action",
          type: "POST",
          dataType : 'json',
          data : {'table_id':table_id, 'type':type, 'contact_type':contact_type, 'client_id':client_id, 
            'short_name':'client_address', 'action':'getProposalTemplate'
          },
          beforeSend : function(){
            $(".show_loader").html('<img src="/img/spinner.gif" />');
          },
          success: function (resp) {
            $(".show_loader").html('');
            var data    = resp.details;
            var content = data.desc;
            $('#NewProposalForm #npfTempTitle').val(data.title);

            // replace section
            if(type == 'template'){
              content = replaceContentByPlaceHolder(data.desc)
            }
            if(type == 'letter'){
              content = replaceContentByPlaceHolder(data.placeholder_desc)
            }
            // replace section
            CKEDITOR.instances.coverLtrText.setData(content);
          }
        });
      }
    });

    
    $('.openNpSecTab').click(function(){
      id = $(this).data('id');
      if(id == 12){
        if(validation()){
          saveNewProposal('D', 'default');
        }else{
          return false;
        }
      }
      $('.secondHeadTab li').removeClass('active');
      $('#tab_'+id).addClass('active');
      /*$('.commonClass').css('display', 'none');
      $('#step'+id).css('display', 'block');*/
      $('.commonClass').removeClass('active');
      $('.commonClass').addClass('hide');
      $('#step'+id).removeClass('hide');
      $('#step'+id).addClass('active');
    });

    $('.saveCPCoverLetter').click(function(event){
      saveCPCoverLetter();
    });

    $('body').on('change', '.activityFeeType', function(){
      
      var proposal_id   = $('#proposal_id').val();
      var value         = $(this).val();
      var p_service_id  = $(this).data('p_service_id');
      var fees          = $(this).data('fees');

      $('#service_hrs_'+p_service_id).removeAttr('disabled', true);
      $('#ServTable_'+p_service_id).removeAttr('disabled', true);
      if(value == 'free_text'){
        var content = '<input type="text" class="priceRound proposalHrsFees" data-type="service" data-column_name="fees"  data-table_id="'+p_service_id+'" value="'+fees+'" id="service_fees_'+p_service_id+'">';
      }else if(value == 'fee_table'){
        var content = '<a href="javascript:void(0)" class="openAddOpperFee" data-p_service_id="'+p_service_id+'" data-action="add">Add..</a>';
        $('#service_hrs_'+p_service_id).attr('disabled', 'disabled');
        $('#ServTable_'+p_service_id).attr('disabled', 'disabled');
      }else if( !isNaN(value) && value > '0'){
        var content = '<div style="float: left;"><a href="javascript:void(0)" class="openAddOpperFee" data-p_service_id="'+p_service_id+'" data-action="view" style="text-align: left;">View table</a></div>';
        content += '<div style="float: right;"><a href="javascript:void(0)" class="deleteServiceTable" data-p_service_id="'+p_service_id+'" style="text-align: right;"><img src="/img/cross.png" height="12"></a></div>';
        $('#service_hrs_'+p_service_id).attr('disabled', 'disabled');
        $('#ServTable_'+p_service_id).attr('disabled', 'disabled');
        //var content = '<a href="javascript:void(0)" class="openAddOpperFee" data-p_service_id="'+p_service_id+'" data-action="view">View Table</a>';
      }else{
        var content = '<input type="text" class="priceRound proposalHrsFees" data-type="service" data-column_name="fees"  data-table_id="'+p_service_id+'" value="'+fees+'" id="service_fees_'+p_service_id+'" disabled>';
      }
      
      $.ajax({
        url: "/proposal/action",
        type: "POST",
        dataType : 'json',
        data : {'proposal_id':proposal_id, 'value':value, 'p_service_id':p_service_id,
          'action':'changeActivityFeeType'},
        beforeSend : function(){
          $('#servPopFeesCol_'+p_service_id).html(content);
          //$(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {
          $(".show_loader").html('');
        }
      });
    });

    $('body').on('change', '.singleFieldChange', function(){
      
      var proposal_id     = $('#proposal_id').val();
      var id_name         = $(this).data('id_name');
      var id_value        = $(this).data('id_value');
      var table_name      = $(this).data('table_name');
      var update_column   = $(this).data('update_column');
      var update_value    = $(this).val();
      $.ajax({
        url: "/proposal/action",
        type: "POST",
        dataType : 'json',
        data : {'proposal_id':proposal_id, 'id_name':id_name, 'id_value':id_value,
           'table_name':table_name,'update_column':update_column,'update_value':update_value,'action':'singleFieldChange'},
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {
          $(".show_loader").html('');
        }
      });

    });

    /*$('body').on('click', '.openAddOpperFee', function(){
      $("#openAddOpperFee-modal").modal('show');return false;
      var p_service_id  = $(this).data('p_service_id');
      var proposal_id   = $('#ProposalID').val();
      var service_name  = $(this).closest('tr').children('td:first').text();
      var action_type   = $(this).data('action');
      var serv_table_id = $('#activityFeeType_'+p_service_id).val();
      
      $.ajax({
        url: "/proposal/action",
        type: "POST",
        //dataType : 'json',
        data : {'proposal_id':proposal_id, 'p_service_id':p_service_id, 'serv_table_id':serv_table_id, 
                'action_type':action_type, 'action':'openAddOpperFee'
        },
        beforeSend : function(){
          $("#openAddOpperFee-modal").modal('show');
          $("#openAddOpperFee-modal #PCervId").val(p_service_id);
          $("#openAddOpperFee-modal #feeTypeDesc").val('');
          $("#openAddOpperFee-modal #feeTypeFees").val('')
          $("#openAddOpperFee-modal .show_loader").html('<img src="/img/spinner.gif" />');
          $("#viewServFeesTypeTable").html('');

          $("#openAddOpperFee-modal .tableName").html(service_name);
          $("#openAddOpperFee-modal #action_type").val(action_type);
        },
        success: function (resp) {
          $(".show_loader").html('');
          $("#viewServFeesTypeTable").html(resp);
        }
      });
    });*/
    $('body').on('click', '.openAddOpperFee', function(){
      var p_service_id  = $(this).attr('data-p_service_id');
      var proposal_id   = $('#ProposalID').val();
      var action_type   = $(this).attr('data-action_type');
      var id            = $(this).attr('data-id');
      
      $.ajax({
        url: "/proposal/action",
        type: "POST",
        //dataType : 'json',
        data : {'proposal_id':proposal_id, 'p_service_id':p_service_id, id:id,
                'action_type':action_type, 'action':'openAddOpperFee'
        },
        beforeSend : function(){
          $("#openAddOpperFee-modal").modal('show');
          $("#openAddOpperFee-modal #PCervId").val(p_service_id);
          $("#openAddOpperFee-modal #ServTblId").val(id);
          $("#openAddOpperFee-modal #feeTypeDesc").val('');
          $("#openAddOpperFee-modal #feeTypeFees").val('')
          $("#openAddOpperFee-modal .show_loader").html('<img src="/img/spinner.gif" />');
          $("#viewServFeesTypeTable").html('');

          $("#openAddOpperFee-modal #action_type").val(action_type);
        },
        success: function (resp) {
          $(".show_loader").html('');
          $("#viewServFeesTypeTable").html(resp);
        }
      });
    });

    $('body').on('click', '.saveServiceFeeType', function(){
      var proposal_id   = $('#proposal_id').val();
      var p_service_id  = $("#openAddOpperFee-modal #PCervId").val();
      var action_type   = $('#action_type').val();

      $("#openAddOpperFee-modal #openAddOpperFee-form").ajaxForm({
        //dataType: 'json',
        data:{'proposal_id':proposal_id},
        beforeSend : function(){
          $("#openAddOpperFee-modal .show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function(resp) {
          //var table = resp.tables;
          $("#openAddOpperFee-modal .show_loader").html('');
          if(action_type == 'add_table' || action_type == 'view_table'){
            $('#add_service_table-modal .modal-body').html(resp);
          }

          /*var view = '<div style="float: left;"><a href="javascript:void(0)" class="openAddOpperFee" data-p_service_id="'+p_service_id+'" data-action="view" style="text-align: left;">View table</a></div>';
          view += '<div style="float: right;"><a href="javascript:void(0)" class="deleteServiceTable" data-p_service_id="'+p_service_id+'" style="text-align: right;"><img src="/img/cross.png" height="12"></a></div>';
          $("#servPopFeesCol_"+p_service_id).html(view);

          var option = $("#activityFeeType_"+p_service_id).find('option[value='+table.id+']').length;
          if(option > 0){
            $(".activityFeeType option[value='"+table.id+"']").text(table.table_name);
          }else{
            $(".activityFeeType").append('<option value="'+table.id+'">'+table.table_name+'</option>');
          }
          $("#activityFeeType_"+p_service_id).val(table.id);*/

          $("#openAddOpperFee-modal").modal('hide');
          
        }
      }).submit();
    });

    $('body').on('click', '#copyTableToProposalService', function(){
      var id            = $(this).attr('data-id');
      var p_service_id  = $("#proposalServiceId").val();
      var proposal_id   = $("#proposal_id").val();

      $.ajax({
        url: "/proposal/action",
        type: "POST",
        dataType : 'json',
        data : {'id':id, 'p_service_id':p_service_id, 'proposal_id':proposal_id, 'action':'copyTableToProposalService' },
        beforeSend : function(){
          $("#add_service_table-modal .show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {
          $("#add_service_table-modal .show_loader").html('');
          var table = resp.table;
          var view = '<a href="javascript:void(0)" class="center openAddOpperFee" data-p_service_id="'+p_service_id+'" data-id="0" data-action_type="view_proposal_table">View Table</a> &nbsp;';
          view += '<a href="javascript:void(0)" class="delete_service_table" data-p_service_id="'+p_service_id+'" data-id="'+table.id+'" data-delete_type="proposal_service_table"><img src="/img/cross.png" height="12"></a>';
          $('#AddServTableTd_'+p_service_id).html(view);

          $("#add_service_table-modal").modal('hide');
        }
      });
    });

    $('body').on('click', '.delete_service_table', function(){
      var id = $(this).attr('data-id');
      var delete_type   = $(this).attr('data-delete_type');
      var p_service_id  = $(this).attr('data-p_service_id');

      if(confirm('Do you want to delete this table?')){
        $.ajax({
          url: "/proposal/action",
          type: "POST",
          dataType : 'json',
          data : {'id':id, 'delete_type':delete_type, 'action':'delete_service_table' },
          beforeSend : function(){

          },
          success: function (resp) {
            if(delete_type == 'service_table'){
              $(".removeServiceTableTr_"+id).hide();
            }
            if(delete_type == 'proposal_service_table'){
              console.log(p_service_id);
              $("#AddServTableTd_"+p_service_id).html('<a href="javascript:void(0)" class="openViewServiceTales" data-p_service_id="'+p_service_id+'" data-action_type="add_service_table">Add..</a>');
            }
          }
        });
      }
    });


    var cloneCount = 0;
    $('.addNewRowInTablePop').click(function(event){

      var $newRow = $('#TableRow1').clone(true);
      $newRow.find('#feeTypeDesc1').val('');
      $newRow.find('#feeTypeFees1').val('');
      $newRow.find('#feeTypeNotes1').val('');

      var noOfDivs = $('.makeCloneClass').length + 1;

      //$newRow.attr('id', 'TableRow'+noOfDivs);
      $newRow.find('input[type="text"]').attr('id', 'feeTypeDesc'+ noOfDivs);
      $newRow.find('input[type="text"]').attr('id', 'feeTypeFees'+ noOfDivs);
      $newRow.find('a').attr('data-row_no', noOfDivs);
      $newRow.find('input[type="hidden"]').attr('id', 'feeTypeNotes'+ noOfDivs);

      var del = '<a href="javascript:void(0)" class="deleteServFeesRow" data-row_no="'+noOfDivs+'" data-table_id="0"><img src="/img/cross.png" height="12"></a>'
      $newRow.find('td:last').html(del);
      
      $('#viewServFeesTypeTable tbody tr:last').after($newRow);  
      return false;
    });

    $('body').on('click', '.deleteServFeesRow', function(){
      var row_no    = $(this).attr('data-row_no');
      var table_id  = $(this).attr('data-table_id');

      if(confirm('Do you want to delete?')){
        if(table_id == '0'){
          $(this).closest("tr").remove();
        }else{
          $.ajax({
            url: "/proposal/action",
            type: "POST",
            dataType : 'json',
            data : {'table_id':table_id, 'action':'deleteServiceFeeType'},
            success: function (resp) {
              $('#TableRow'+row_no).remove();
              //$(this).closest("tr").remove();
            }
          });
        }
      }
    });

    /* ===================== Proposal comment =================== */
    $('body').on('click', '.openCommentPopUp', function(){
      var crm_proposal_id   = $(this).data('crm_proposal_id');
      var name    = $(this).data('name');
      var title   = $(this).data('title');
      $(".PTitle").html(name+' - '+title);
      
      $.ajax({
        url: "/proposal/action",
        type: "POST",
        dataType : 'json',
        data : {'crm_proposal_id':crm_proposal_id, 'action':'getProposalComment' },
        beforeSend : function(){
          $("#textAreaTd").html('');
          $("#textAreaTd").html('<textarea class="form-control classy-editor" rows="3" name="comment_text" id="comment_text"></textarea>');
          $("#comment_text").ClassyEdit();

          $("#openCommentPopUp-modal").modal('show');
          $("#openCommentPopUp-modal #crm_proposal_id").val(crm_proposal_id);
          $("#postCommentArea").html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
          $("#UnresdIcon"+crm_proposal_id).hide();
        },
        success: function (resp) {
          $("#postCommentArea").html('');
          var content = displayComment(resp.comments);
          $('#postCommentArea').html(content);
        }
      });
    });

    $('body').on('click', '#postComment', function(){
      var crm_proposal_id   = $('#crm_proposal_id').val();
      var comment_text      = $('#comment_text').val();
      if(comment_text == ''){
        alert('Please enter comment.');
        return false;
      }

      $("#commentForm").ajaxForm({
        beforeSend : function(){
          $("#postCommentArea").html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
          $('.classyedit .editor').html('');
          $('#comment_text').val('');
        },
        success: function(resp) {
          $("#postCommentArea").html('');
          /*var content = displayComment(resp.comments);
          $('#postCommentArea').html(content);*/
          $('#postCommentArea').html(resp);
        }
      }).submit();
    });

/* ======================= Action pop up email send ====================== */
    $('body').on('click', '.openActionSendPopUp', function(){
      var postData = [];
      var crm_proposal_id   = $(this).data('crm_proposal_id');
      var name    = $(this).data('name');
      var title   = $(this).data('title');
      $(".PTitle").html(name+' - '+title);
      $("#crm_proposal_id").val(crm_proposal_id);
      var content = $("#SendTextAreaHide").html();
      $("#sending_page").val('proposal_list');
      
      postData['crm_proposal_id'] = crm_proposal_id;
      postData['content']         = content;
      getProposalEmailContent(postData);

    });

    $('body').on('click', '#sendActionEmail', function(){
      var crm_proposal_id   = $('#crm_proposal_id').val();
      var actionEmail       = $('#actionEmail').val();
      var email_text        = $('#email_text').val();
      var sending_page      = $("#sending_page").val();

      if(actionEmail == ''){
        alert('Please enter recipient email.');
        return false;
      }else if(email_text == ''){
        alert('Please enter content.');
        return false;
      }
      //alert(email_text);return false;

      $("#sendActionEmailForm").ajaxForm({
        dataType: 'json',
        data:{'crm_proposal_id':crm_proposal_id},
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function(resp) {
          $(".show_loader").html('');
          $("#openActionSendPopUp-modal").modal('hide');
          if(sending_page == 'client_list'){
            var client_id  = $("#client_id").val();
            $(".sendText_"+client_id).html('Re-Send');
          }else{
            refresh_table();

            if(resp.save_type!='A' && resp.save_type!='MA' && resp.save_type!='L' && resp.save_type!='ML'){
              $(".Status_"+crm_proposal_id).html('SENT');
            }
            
            var revoke = '<a href="javascript:void(0)" class="doRevoked" data-crm_proposal_id="'+crm_proposal_id+'"><i class="fa fa-edit tiny-icon"></i>Revoke & Edit</a>';
            $(".revokeLi_"+crm_proposal_id).html(revoke);
            $(".sendText_"+crm_proposal_id).html('Re-Send');
          }
          
          
        }
      }).submit();
    });

    /* =================== Preview Signature Section ====================== */
    $('body').on('click', '.acceptSigned', function(){
      var crm_proposal_id   = $('#crm_proposal_id').val();
      var signatureText     = $('#signatureText').val();
      var action_type       = $(this).data('action_type');

      $.ajax({
        url: "/proposal-preview/action",
        type:"POST",
        //dataType : 'json',
        data:{'crm_proposal_id':crm_proposal_id, 'action_type':action_type, 'signatureText':signatureText, 
          'action':'saveSignature' },
        beforeSend : function(){
          $('.show_loader').html('<img src="/img/spinner.gif">');
        },
        success:function(resp){
          refresh_table();
          //$('.show_loader').html('');
          $('#signatureSection').html('');

          $('#signatureSection').html(resp);
          $('#menu-panel6').html((action_type=='A')?'ACCEPTED':'DECLINED');
          $('#valip').hide();
        },
        error:function(data){
          alert('error'+data);
        }
      }); 
    });

    /* ==================== Revoke & Edit under Action ===================== */
    $('body').on('click', '.doRevoked', function(){
      var crm_proposal_id   = $(this).attr('data-crm_proposal_id');
      if(confirm('Do you want to revoke this proposal?')){
        $.ajax({
          url: "/proposal/action",
          type:"POST",
          dataType : 'json',
          data:{'crm_proposal_id':crm_proposal_id, 'action':'revokeProposal' },
          beforeSend : function(){
            //$('.show_loader').html('<img src="/img/spinner.gif">');
          },
          success:function(resp){
            refresh_table();
            //$('.show_loader').html('');
            var data = resp.details;
            $('.Status_'+crm_proposal_id).html('REVOKED');
            var revoke = '<a href="/proposal/edit-proposal/'+crm_proposal_id+'/proposal"><i class="fa fa-edit tiny-icon"></i>Edit</a>';
            $(".revokeLi_"+crm_proposal_id).html(revoke);
          }
        }); 
      }
    });

    /* ==================== MArked as accepted and lost under Action ===================== */
    $('body').on('click', '.markedSigned', function(){
      var proposal_id       = $(this).attr('data-proposal_id');
      var crm_proposal_id   = $(this).attr('data-crm_proposal_id');
      var action_type       = $(this).attr('data-action_type');
      var message = (action_type=='MA')?'accepted':'lost'
      if(confirm('Do you want to mark the proposal as '+message+'?')){
        $.ajax({
          url: "/proposal-preview/action",
          type:"POST",
          //dataType : 'json',
          data:{'proposal_id':proposal_id,'crm_proposal_id':crm_proposal_id,'action_type':action_type,'action':'markedSigned' },
          beforeSend : function(){
            $('.show_loader').html('<img src="/img/spinner.gif">');
          },
          success:function(resp){
            refresh_table();
            
            $('.show_loader').html('');
            $('.Status_'+crm_proposal_id).html((action_type == 'MA')?'ACCEPTED':'LOST');
            var revoke = '<a href="javascript:void(0)" class="doRevoked" data-crm_proposal_id="'+crm_proposal_id+'"><i class="fa fa-edit tiny-icon"></i>Revoke & Edit</a>';
            $(".revokeLi_"+crm_proposal_id).html(revoke);

            $(".matkLostLi_"+crm_proposal_id).removeClass('show');
            $(".matkLostLi_"+crm_proposal_id).addClass('hide');
            $(".matkAcceptLi_"+crm_proposal_id).removeClass('show');
            $(".matkAcceptLi_"+crm_proposal_id).addClass('hide');
          }
        }); 
      }
    });

    /* ================ Copy proposal ==================== */
    $('body').on('click', '.copyProposal', function(){
      var crm_proposal_id = $(this).attr('data-crm_proposal_id');
      var from_page       = $(this).attr('data-from_page');

      if(confirm('Do you want to copy this proposal?')){
        $.ajax({
          url: "/proposal/action",
          type:"POST",
          dataType : 'json',
          data:{'crm_proposal_id':crm_proposal_id, 'from_page':from_page, 'action':'copyProposal' },
          beforeSend : function(){
            $('#message_div').html('<div class="show_loader"><img src="/img/spinner.gif"></div>');
          },
          success:function(resp){
            $('#message_div').html('');
            window.location.href = base_url+'/proposal/edit-proposal/'+resp.crm_proposal_id+'/'+from_page;
          }
        }); 
      }
    });

    /* ======================= Action pop up email send ====================== */
    $('body').on('click', '.openHistoryPopUp', function(){
      var proposal_id       = $(this).data('proposal_id');
      var crm_proposal_id   = $(this).data('crm_proposal_id');
      
      $.ajax({
        url: "/proposal/action",
        type: "POST",
        dataType : 'json',
        data : {'proposal_id':proposal_id, 'crm_proposal_id':crm_proposal_id, 'action':'getHistoryByProposalId'
        },
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
          $(".proposalHistory tbody").html('');
          $(".historyProposalId").html(proposal_id);
          $("#openHistoryPopUp-modal").modal('show');
        },
        success: function (resp) {
          $(".show_loader").html('');
          var details = resp.details;

          var content = '';
          $.each(details, function(k, v){
            content += '<tr>';
            content += '<td>'+v.added+'</td><td>Proposal '+v.event_type+'</td>';
            content += '<td>'+v.ip_address+'</td><td>'+v.user_name+'</td></tr>';
          });
          $(".proposalHistory tbody").html(content);
        }
      });
    });

    /* ==================== Remove service pop up table ================= */
    $('body').on('click', '.deleteServiceTable', function(){
      var p_service_id  = $(this).attr('data-p_service_id');
      var serv_table_id = $('#activityFeeType_'+p_service_id).val();//alert(serv_table_id);
      if(confirm('Do you want to delete this table?')){
        $.ajax({
          url: "/proposal/action",
          type:"POST",
          dataType : 'json',
          data:{'serv_table_id':serv_table_id, 'p_service_id':p_service_id, 'action':'deleteServiceTable' },
          beforeSend : function(){
            
          },
          success:function(resp){
            $('.activityFeeType option[value="'+serv_table_id+'"]').remove();
            $('#activityFeeType_'+p_service_id).val('fee_table');
            $('#servPopFeesCol_'+p_service_id).html('<a href="javascript:void(0)" class="openAddOpperFee" data-p_service_id="'+p_service_id+'" data-action="add">Add..</a>');
          }
        }); 
      }
    });

    $('body').on('change', '.changeFlexFees', function(){
      var field_value   = $(this).val();
      var type          = $(this).data('type');
      var column_name   = $(this).data('column_name');
      var table_id      = $(this).data('table_id');
      var p_service_id  = $(this).data('p_service_id');
      $.ajax({
        url: "/proposal/action",
        type:"POST",
        dataType : 'json',
        data:{'field_value':field_value, 'type':type, 'column_name':column_name, 'p_service_id':p_service_id, 'table_id':table_id, 
          'action':'changeFlexFees' 
        },
        beforeSend : function(){
          
        },
        success:function(resp){
          var data = resp.details;
          if(type == 'activity'){
            $('#ActAnnualFee_'+table_id).val(data.fees);
            $('#service_fees_'+p_service_id).val(resp.totalServiceFee);
          }
          if(type == 'service'){
            $('#service_fees_'+table_id).val(data.fees);
          }
          $('#table_fees_'+resp.table_id).html(resp.totalTableFee);
        }
      }); 
    });

    // Add new service table pop up
    $('body').on('click', '.openViewServiceTales', function() {
      var action_type   = $(this).attr('data-action');
      var p_service_id  = $(this).attr('data-p_service_id');

      $.ajax({
        url: "/proposal/action",
        type:"POST",
        //dataType : 'json',
        data:{'action_type':action_type, 'p_service_id':p_service_id, 'action':'openViewServiceTales' 
        },
        beforeSend : function(){
          $("#PCervId").val(p_service_id);
          $("#proposalServiceId").val(p_service_id);

          $("#add_service_table-modal .show_loader").html('<img src="/img/spinner.gif" />');
          $('#add_service_table-modal').modal('show');
        },
        success:function(resp){
          var tables = resp;
          $("#add_service_table-modal .show_loader").html('');

          $('#add_service_table-modal .modal-body').html(tables);
        }
      }); 

      
    });

    // place holder 
    /*$('#changePlaceHolder').change(function() {
      var dropValue = $(this).val();
      if(dropValue != ''){
        $.ajax({
          type: "POST",
          url: '/letters/generate-letter-action',
          dataType:'json',
          data: { 'dropValue' : dropValue, 'action' : 'getPlaceHolder' },
          beforeSend : function(){
          $(".placeholderList").html('<li style="text-align:center;"><img src="/img/spinner.gif" /></li>');
        },
        success : function(resp){
          var list = '';
          $.each(resp, function(key, value){
            if( dropValue == 'proposal_general' )
                list += '<li><a href="javascript:void(0)" class="addNewPlaceholder" data-paceholdId="'+value.placeholder_id+'" data-short_name="'+value.short_name+'">'+value.view_name+'</a></li>';
              else
                list += '<li><a href="javascript:void(0)" class="" data-paceholdId="'+value.placeholder_id+'" data-short_name="'+value.short_name+'">'+value.view_name+'</a></li>';
            });
            $('.placeholderList').html(list);
          }
        });
      }else{
        $('.placeholderList').html('');
      }
    });*/


    

});//document end

function replaceContentByPlaceHolder(content)
{ 
  if(content != ''){
    var client_name   = $('#propContactList option:selected').text();
    var coverLtrText  = $('#propContactDrop option:selected').text();
    var clientContact = (coverLtrText=='Select Contact')?'':coverLtrText;
    var proposal_id   = $('#ProposalID').val();
    var title         = $('#PropTitle').val();
    var validity      = $('#propValidity').val();
    var start_date    = $('#ProsStartDate').val();
    var end_date      = $('#ProsEndDate').val();

    var d       = new Date();
    var month   = d.getMonth()+1;
    var day     = d.getDate();
    var months  = [ "January", "February", "March", "April", "May", "June", 
               "July", "August", "September", "October", "November", "December" ];
    var month   = months[d.getMonth()];
    //var today   = (day<10 ? '0' : '') + day + '-' + (month<10 ? '0' : '') + month + '-' + d.getFullYear();
    var today   = month+' '+(day<10 ? '0' : '') + day +', '+d.getFullYear();

    content = content.replace("[Client Name]", client_name);
    content = content.replace('[Client Contact]', clientContact);
    content = content.replace('[Proposal ID]', proposal_id);
    content = content.replace('[Proposal Title]', title);
    content = content.replace('[Proposal Validity]', validity);
    content = content.replace('[Proposal Start Date]', start_date);
    content = content.replace('[Proposal End Date]', end_date);
    content = content.replace("[Todays Date]", today);
  }

  return content;
}

function replacePlaceHolderByContent(content)
{
  if(content != ''){
    var client_name   = $('#propContactList option:selected').text();
    var coverLtrText  = $('#propContactDrop option:selected').text();
    var clientContact = (coverLtrText=='Select Contact')?'':coverLtrText;
    var proposal_id   = $('#ProposalID').val();
    var title         = $('#PropTitle').val();
    var validity      = $('#propValidity').val();
    var start_date    = $('#ProsStartDate').val();
    var end_date      = $('#ProsEndDate').val();

    var d       = new Date();
    var month   = d.getMonth()+1;
    var day     = d.getDate();
    var today   = (day<10 ? '0' : '') + day + '-' + (month<10 ? '0' : '') + month + '-' + d.getFullYear();

    content = content.replace(client_name, "[Client Name]");
    content = content.replace(clientContact, '[Client Contact]');
    content = content.replace(proposal_id, '[Proposal ID]');
    content = content.replace(title, '[Proposal Title]');
    content = content.replace(validity, '[Proposal Validity]');
    content = content.replace(start_date, '[Proposal Start Date]');
    content = content.replace(end_date, '[Proposal End Date]');
    content = content.replace(today, "[Todays Date]");
  }

  return content;
}

function getProposalEmailContent(postData)
{
  var crm_proposal_id = postData['crm_proposal_id'];
  var content         = postData['content'];

  $.ajax({
    url: "/proposal/action",
    type: "POST",
    dataType : 'json',
    data : {'crm_proposal_id':crm_proposal_id, 'content':content, 'action':'getProposalEmailContent'
    },
    beforeSend : function(){
      $(".show_loader").html('<img src="/img/spinner.gif" />');
      $("#SendTextAreaTd").html('');
      $("#openActionSendPopUp-modal").modal('show');
    },
    success: function (resp) {
      $(".show_loader").html('');
      $("#openActionSendPopUp-modal #actionEmail").val(resp.email);
      $("#SendTextAreaTd").html('<textarea class="form-control classy-editor" rows="3" name="email_text" id="email_text">'+resp.content+'</textarea>');
      $("#email_text").ClassyEdit();
    }
  });
}


function doNotUseFeesService(postData)
{
  var proposal_id = $('#proposal_id').val();
  $.ajax({
    url: "/proposal/action",
    type: "POST",
    dataType : 'json',
    data : {'proposal_id':proposal_id, 'p_service_id':postData['p_service_id'],'service_id':postData['service_id'],
      'type':postData['type'], 'action':'doNotUseFeesService'
    },
    beforeSend : function(){
      $(".show_loader").html('<img src="/img/spinner.gif" />');
    },
    success: function (resp) {
      $(".show_loader").html('');
      var data = resp.details;
      if(postData['type'] == 'add'){
        $('#service_fees_'+postData['p_service_id']).removeAttr('disabled', true);
      }else{
        $('#service_fees_'+postData['p_service_id']).attr('disabled', true);
      }
      $('#service_fees_'+postData['p_service_id']).val(data.fees); 
      $('#service_flexFees_'+postData['p_service_id']).val('100'); 
      $('#table_fees_'+resp.p_table_id).html(resp.TotalTableFees);
    }
  });
}

function saveCPCoverLetter()
{
  var proposal_id = $('#proposal_id').val();
  var letter_id   = $('#extLetterId').val();
  var template_id = $('#extTmplateId').val();
  var desc        = CKEDITOR.instances.coverLtrText.getData();
  var cover_letter_id   = $('#crmPCoverLerretId').val();
  var placeholder_desc  = '';

  if(desc != ''){
    placeholder_desc = replacePlaceHolderByContent(desc);
    //placeholder_desc  = placeholder_desc.replace(/\n/g, ',');
    var contact_type  = $('#NewPropContctType').val();
    var client_id     = $('#propContactList').val();

    $.ajax({
      url: "/settings/action",
      type: "POST",
      dataType : 'json',
      data : {'proposal_id':proposal_id, 'letter_id':letter_id, 'template_id':template_id,
        'desc':desc, 'placeholder_desc':placeholder_desc, 'cover_letter_id':cover_letter_id, 
        'contact_type':contact_type, 'client_id':client_id, 'short_name':'client_address', 'action':'saveCPCoverLetter'
      },
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
      },
      success: function (resp) {
        $(".show_loader").html('');
        $('#crmPCoverLerretId').val(resp.details.cover_letter_id);
      }
    });
  }
}

function displayComment(comments)
{
  var content = '';
    $.each(comments, function(k, v){
      content += '<table class="singleCommentTable">';
      content += '<tr><td rowspan="2" valign="top" class="listIcon"><i class="fa fa-user user-icon"></i></td>';
      content += '<td align="left"><strong>'+v.previewSender+'</strong></td><td align="right">'+v.created_format+'</td></tr>';
      content += '<tr><td colspan="2">'+v.comment+'</td></tr>';
      content += '</table>';
    });
    content += '<div class="clearfix"></div>';
    return content;
}

function showHideFeesInPreview(postData)
{
  var proposal_id = $('#proposal_id').val();
  $.ajax({
    url: base_url+"/proposal/action",
    type:"POST",
    dataType : 'json',
    data:{'type':postData['type'],'table_id':postData['table_id'],'popup':postData['popup'],'proposal_id':proposal_id,'action':'showHideFeesInPreview' },
    beforeSend : function(){
      $('#message_div').html('<img src="/img/spinner.gif">');
    },
    success:function(resp){
      
    }
  });
}

function saveNewProposal(save_type, save_from)
{
  var contact_type    = $('#NewPropContctType').val();
  var prospect_id     = $('#propContactList').val();
  var contact_id      = $('#propContactDrop').val();
  var validity        = $('#propValidity').val();
  var proposal_title  = $('#PropTitle').val();
  var start_date      = $('#ProsStartDate').val();
  var end_date        = $('#ProsEndDate').val();
  var ProposalID      = $('#ProposalID').val();
  var contact_name    = $('#propContactDrop option:selected').text();
  var ExtProspectId   = $('#ExtProspectId').val();
  var from_page       = $('#from_page').val();
  var TemplateName    = $('#TemplateName').val();
  var termsText       = CKEDITOR.instances.termsText.getData();

  if(contact_id == ''){
    contact_name = '';
  }
  //alert(contact_name);return false;
  if(validation()){
    $.ajax({
      url: base_url+"/proposal/action",
      type:"POST",
      dataType : 'json',
      data:{'contact_type':contact_type, 'prospect_id':prospect_id, 'contact_id':contact_id,
        'validity':validity, 'proposal_title':proposal_title, 'start_date':start_date,
        'end_date':end_date, 'ProposalID':ProposalID, 'contact_name':contact_name, 'ExtProspectId':ExtProspectId,
        'from_page':from_page,'save_type':save_type,'TemplateName':TemplateName,'termsText':termsText,
        'action':'save_new_proposal' },
      beforeSend : function(){
        if(save_from == 'btnClick'){
          $('.createProposal').html('<img src="/img/spinner.gif">');
        }
        saveCPCoverLetter();
      },
      success:function(resp){
        if(save_from == 'btnClick'){
          $('.createProposal').html('Proposal Saved!');
          setTimeout(function(){
            $('.createProposal').html('');
          }, 2000);
        }
        //window.location.href = '/crm/viewAllProposal';
        if(save_type == 'D' && contact_type != 'template'){
          var p = resp.proposals;
          $('#ProposalID').val(p.proposalID);
          $('#ExtProspectId').val(p.crm_proposal_id);
        }else if(save_type == 'F' || save_type == 'DC'){
          window.location.href = '/crm/viewAllProposal';
        }else if(save_type == 'T' || contact_type == 'template'){
          window.location.href = '/crm/proposal-template';
        }
      }
    });
  }else{
    return false;
  }
}


function addRemoveAttachment( postData )
{
  var proposal_id = $('#ProposalID').val();
  $.ajax({
    type: "POST",
    url: "/proposal/action",
    dataType : 'json',
    data:{ 'attachment_id':postData['attachment_id'], 'proposal_id':proposal_id, 'type':postData['type'],
      'action':'addRemoveAttachment' },
    success: function (resp) {
      if(postData['type'] == 'add'){
        $('.attachmnt_'+postData['attachment_id']+' .proposalNotes').removeClass('disable_click');
      }else{
        $('.attachmnt_'+postData['attachment_id']+' .proposalNotes').addClass('disable_click');
      }
    }
  });
}

function addRemoveTable( postData )
{
  var heading_id      = postData['heading_id'];
  var is_show         = postData['is_show'];
  var type            = postData['type'];

  if(is_show == 'O'){
    if(type == 'add'){
      $('#step_check_2'+heading_id).removeAttr('disabled');
      $('#step_check_2'+heading_id).removeClass('disabled');
      $('#step_check_2'+heading_id).parent().removeClass('disabled');
      $('#step_check_2'+heading_id).parent().removeClass('disable_click');
      //$('#recurringCheck'+heading_id).removeAttr('disabled');
    }else{
      $('#step_check_2'+heading_id).attr('disabled');
      $('#step_check_2'+heading_id).addClass('disabled');
      $('#step_check_2'+heading_id).parent().addClass('disabled');
      $('#step_check_2'+heading_id).parent().addClass('disable_click');
      $('#step_check_2'+heading_id).iCheck('uncheck');
      //$('#recurringCheck'+heading_id).prop("disabled",true);
      //$('#recurringCheck'+heading_id).removeAttr("checked");
    }
  }
  
  //alert(type);return false;

  var proposal_id     = $('#ProposalID').val();
  var contact_type    = $('#NewPropContctType').val();
  var prospect_id     = $('#propContactList').val();
  var contact_id      = $('#propContactDrop').val();
  var contact_name    = $('#propContactDrop option:selected').text();
  var validity        = $('#propValidity').val();
  var proposal_title  = $('#PropTitle').val();
  var start_date      = $('#ProsStartDate').val();
  var end_date        = $('#ProsEndDate').val();
  var ExtProspectId   = $('#ExtProspectId').val();
  var from_page       = $('#from_page').val();
  var TemplateName    = $('#TemplateName').val();

  if(contact_id == ''){
    contact_name  = '';
  }

  if(heading_id != ""){
    $.ajax({
      type: "POST",
      url: "/proposal/action",
      data: { 
        'heading_id': heading_id,'proposal_id':proposal_id,'type':type,'is_show':is_show,'action':'addRemoveTable',
        'contact_type':contact_type,'prospect_id':prospect_id,'contact_id':contact_id,'contact_name':contact_name,
        'validity':validity,'proposal_title':proposal_title,'start_date':start_date,'end_date':end_date,
        'ExtProspectId':ExtProspectId,'from_page':from_page, 'TemplateName':TemplateName
      },
      beforeSend: function() {
        $('#newAddedTableToProposal').html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
      },
      success: function (resp) {
        $('#newAddedTableToProposal').html(resp);       
        
        $tabs = $('#newAddedTableToProposal');
        $( ".connectedSortable" ).sortable({
          connectWith: ".connectedSortable",
          appendTo: $tabs,
          helper:"clone",
          zIndex: 999990,
          start: function(){ $tabs.addClass("dragging") },
          stop: function(){ $tabs.removeClass("dragging") },
          update: function(){
            var table       = $('#table').val();
            var sort_column = $('#sort_column').val();
            var id_name     = $('#id_name').val();

            var sortOrder   = [];
            $('#newAddedTableToProposal').children('.connectedSortable').each(function(){
                sortOrder.push($(this).data('id'));//alert($(this).data('id'))
            });
            var ordering = sortOrder.join(',');
            $('#ids').val(ordering);

            $.post("/proposal/action", {action:'change_rows_order', 'id_name':id_name, 'table':table, 'column':sort_column, 'ordering':ordering } );
          }
        }).disableSelection();

      }
    });
  }
}

function addRemoveGrandTotal( postData )
{
  $.ajax({
    type: "POST",
    url: "/proposal/action",
    dataType:'json',
    data: { 
      'heading_id':postData['heading_id'], 'type':postData['type'],
      'proposal_id':postData['proposal_id'], 'action':'addRemoveGrandTotal'
    },
    beforeSend: function() {
      $('.show_loader').html('<img src="/img/spinner.gif" />');
    },
    success: function (resp) {
      $('.show_loader').html('');
      $('#grandTotal').html(resp.grand_total);
    }
  });
}

function deleteActivityAndService(postData)
{
  if(!confirm('Do you want to delete?')){
    return false;
  }
  $.ajax({
    type: "POST",
    url: "/proposal/action",
    dataType:'json',
    data: { 
      'table_id':postData['table_id'], 'type':postData['type'],
      'table_name':postData['table_name'], 'table_id_name':postData['table_id_name'], 'action':'deleteActivityAndService'
    },
    beforeSend: function() {
      $('.show_loader').html('<img src="/img/spinner.gif" />');
    },
    success: function (resp) {
      $('.show_loader').html('');
      $('#'+postData['type']+'RowPop_'+postData['table_id']).hide();
    }
  });
}

function saveHrsAndFees(postData)
{
  var proposal_id = $('#proposal_id').val();
  var is_show     = $('#isShowTable').val();

  $.ajax({
    type: "POST",
    url: "/proposal/action",
    dataType:'json',
    data: { 
      'is_show':is_show, 'table_id':postData['table_id'], 'type':postData['type'], 'field_value':postData['field_value'], 
      'column_name':postData['column_name'], 'table_name':postData['table_name'], 'table_id_name':postData['table_id_name'],
      'crm_proptbl_id':postData['crm_proptbl_id'], 'proposal_id':proposal_id, 'action':'saveHrsAndFees' 
    },
    beforeSend: function() {
      //$('#newProposalNotesPop-modal .show_loader').html('<img src="/img/spinner.gif" />');
    },
    success: function (resp) {
      if(postData['type'] == 'activity'){
        $('#changeFlexFees_'+resp.table_id).val('100');
        $('#service_fees_'+resp.p_service_id).val(resp.fees);
        if(is_show == 'G')
          $('#grandTotal').html(resp.grand_total);
      }

      if(postData['type'] == 'service'){
        $('#service_flexFees_'+resp.table_id).val('100');
      }
      $('#table_fees_'+postData['crm_proptbl_id']).html(resp.grand_total);
    }
  });
}

function reloadActivitiesOrdering()
{
  $tabs = $('#viewActivityTable');
  $( ".sortingActivities" ).sortable({
    connectWith: ".sortingActivities",
    cursor: 'move',
    appendTo: $tabs,
    helper:"clone",
    zIndex: 999990,
    start: function(){ $tabs.addClass("dragging") },
    stop: function(){ $tabs.removeClass("dragging") },
    update: function(){
      var table       = $('#act_table_name').val();
      var sort_column = $('#sort_column').val();
      var id_name     = $('#tableIdName').val();

      var sortOrder   = [];
      $('.sortingActivities').children('tr').each(function(){
        var id = $(this).data('p_activity_id');
        sortOrder.push(id);
      });
      var ordering = sortOrder.join(',');
      $('#p_activity_ids').val(ordering);
      $.post("/proposal/action", {action:'change_rows_order', 'id_name':id_name, 'table':table, 'column':sort_column, 'ordering':ordering } );
    }
  }).disableSelection();
}

function reloadServicesOrdering()
{
  $tabs = $('#viewServiceTable');
  $( ".sortingServices" ).sortable({
    connectWith: ".sortingServices",
    //cancel: '.subTableIn',
    cursor: 'move',
    appendTo: $tabs,
    helper:"clone",
    zIndex: 999990,
    start: function(){ $tabs.addClass("dragging") },
    stop: function(){ $tabs.removeClass("dragging") },
    update: function(){
      var table       = $('#table_name').val();
      var sort_column = $('#sort_column').val();
      var id_name     = $('#table_id_name').val();

      var sortOrder   = [];
      $('.sortingServices').children('tr').each(function(){
        var id = $(this).data('p_service_id');
        sortOrder.push(id);
      });
      var ordering = sortOrder.join(',');
      $('#p_service_ids').val(ordering);
      $.post("/proposal/action", {action:'change_rows_order', 'id_name':id_name, 'table':table, 'column':sort_column, 'ordering':ordering } );
    }
  }).disableSelection();
}

function reloadOrdering()
{
    $("#newAddedTableToProposal").sortable({
      items: '> .connectedSortable',
      update: function(){
        var table       = $('#table').val();
        var sort_column = $('#sort_column').val();
        var id_name     = $('#id_name').val();

        var sortOrder   = [];
        $('.connectedSortable').each(function(){
          var id = $(this).data('id');
          sortOrder.push(id);
        });
        var ordering = sortOrder.join(',');
        $('#ids').val(ordering);

        $.post("/proposal/action", {action:'change_rows_order', 'id_name':id_name, 'table':table, 'column':sort_column, 'ordering':ordering } );
      }
    });
}

function add_activity_to_table(postData)
{
  $.ajax({
    type: "POST",
    url: "/proposal/action",
    data: { 
      'proposal_id':postData['proposal_id'], 'p_service_id':postData['p_service_id'], 'type':postData['type'],
      'action':postData['action'], 'activity_id':postData['activity_id'], 'activity_option':postData['activity_option']
    },
    beforeSend: function() {
      //$("#newProposalActivityPop-modal .show_loader").html('<img src="/img/spinner.gif" />');
    },
    success: function (resp) {
      var splitpart         = resp.split("anwar");
      var content           = splitpart['0'];
      var isFeeAdded        = $.trim(splitpart['1']);
      var TotalServiceFees  = $.trim(splitpart['2']);
      var p_table_id        = $.trim(splitpart['3']);
      var TotalTableFees    = $.trim(splitpart['4']);

      $('#service_fees_'+postData['p_service_id']).val(TotalServiceFees); 
      $('#table_fees_'+p_table_id).html(TotalTableFees); 
      $('#service_flexFees_'+postData['p_service_id']).val('100'); 
      

      $('#viewActivityTable tbody').html(content);       
    }
  });
}

function add_services_to_table(postData)
{
  $.ajax({
    type: "POST",
    url: "/proposal/action",
    data: { 
      'proposal_id':postData['proposal_id'], 'p_table_id':postData['p_table_id'], 'type':postData['type'],
      'action':postData['action'], 'service_id':postData['service_id'], 'page_name':postData['page_name'],
      'heading_id':postData['heading_id']
    },
    beforeSend: function() {
      $('#newProposalServicePop-modal .show_loader').html('<img src="/img/spinner.gif" />');
    },
    success: function (resp) {
      $('.show_loader').html('');
      var data = resp.split('ipractice');
      $('#viewServiceTable tbody').html(data[0]);  
      $('#table_fees_'+postData['p_table_id']).html(data[1]);  
    }
  });
}

function validation(){
  var contact_type    = $('#NewPropContctType').val();
  var prospect_id     = $('#propContactList').val();
  var contact_id      = $('#propContactDrop').val();
  var proposal_title  = $('#PropTitle').val();
  var template_name   = $('#TemplateName').val();

  if(contact_type == ''){
    alert('Please select contact type');
    $('#NewPropContctType').focus();
    return false;
  }else if(prospect_id == '' && contact_type != 'template'){
    alert('Please select client or prospect');
    $('#propContactList').focus();
    return false;
  }else if(contact_type == 'template' && template_name == ''){
    alert('Please enter template name');
    $('#TemplateName').focus();
    return false;
  }else if(proposal_title == ''){
    alert('Please enter proposal title');
    $('#PropTitle').focus();
    return false;
  }else{
    return true;
  }
}

function addServiceHead(postData)
{
  $.ajax({
    url: base_url+"/service/save-tax-action",
    type:"POST",
    dataType : 'json',
    data:{'service_id':postData['service_id'],'service_name':postData['service_name'], 'action':'addServiceHead' },
    beforeSend : function(){
      $('.show_loader').html('<img src="/img/spinner.gif">');
      //$('#SeRvPopList tbody').html('');
    },
    success:function(resp){
      $('.show_loader').html('');
      var service = resp.service;
      var content = '<li class=""><a href="">'+service.service_name+'</a></li>';
      $('#serviceTabHead').append(content);
    }
  });
}


function getAllServices(pop_type)
{
  $.ajax({
    url: base_url+"/service/save-tax-action",
    type:"POST",
    dataType : 'json',
    data:{'pop_type':pop_type, 'action':'servicesForProposal' },
    beforeSend : function(){
      $('.show_loader').html('<img src="/img/spinner.gif">');
      $('#SeRvPopList tbody').html('');
      $("#newPricingTemplate-modal").modal('show');
    },
    success:function(resp){
      $('.show_loader').html('');

      var servList = resp.servList;
      var content = '';

      $.each(servList, function(i, v){
        price =  (v.price != '')?parseFloat(v.price).toFixed(2):'';

        content   += '<tr class="srvListProp_'+v.service_id+'">';
        content += '<td><select class="form-control newdropdown AddServiceHead" data-service_id="'+v.service_id+'" data-service_name="'+v.service_name+'">';
          content += '<option>Not Applicable</option>';
          content += '<option value="1">Chargeable</option>';
          content += '<option value="2">Optional</option>';
          content += '<option value="3">Disbursements & Recharges</option>';
          content += '<option value="4">Complementary</option>';
        content += '</select></td>';
        content += '<td>'+v.service_name+'</td>';
        content += '<td><input type="text" class="priceRound" value="'+price+'"></td>';

        var rearrange = '<select class="form-control newdropdown">';
        for(var j=1; j<=servList.length;j++){
          rearrange += '<option value="'+j+'">'+j+'</option>';
        };
        rearrange += '</select>';
        content += '<td>'+rearrange+'</td>';
        content += '</tr>';
      });
      $('#SeRvPopList tbody').append(content);
    }
  });
  
}

function openServicesPopUp(pop_type){
  $.ajax({
    url: base_url+"/service/save-tax-action",
    type:"POST",
    dataType : 'json',
    data:{'pop_type':pop_type, 'action':'servicesForProposal' },
    beforeSend : function(){
      $('.show_loader').html('<img src="/img/spinner.gif">');
      $('#SeRvPopList tbody').html('');
      $("#newServiceInNewProposal-modal").modal('show');
    },
    success:function(resp){
      $('.show_loader').html('');

      var servList = resp.servList;
      var content = '';

      content   += '<tr class="srvListProp_">';
      content   += '<td><select class="form-control newdropdown AddServiceHead" data-service_id="" data-service_name="">';
        content += '<option>Not Applicable</option>';
        content += '<option value="1">Chargeable</option>';
        content += '<option value="2">Optional</option>';
        content += '<option value="3">Disbursements & Recharges</option>';
        content += '<option value="4">Complementary</option>';
      content   += '</select></td>';
      
      var rearrange = '<select class="form-control newdropdown">';
      $.each(servList, function(i, v){
        rearrange += '<option value="'+v.service_id+'">'+v.service_name+'</option>';
      });
      rearrange += '</select>';
      content += '<td>'+rearrange+'</td>';
      content   += '<td><input type="text" class="priceRound" value=""></td>';
      content += '<td align="center"><img src="/img/cross.png" height="12"> | <img src="/img/edit_icon.png" height="12"></td>';
      content += '</tr>';

      $('#SeRvPopList tbody').append(content);
    }
  });
  
}