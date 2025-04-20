$(document).ready(function() {

     if($("#tab3_ch_vat").iCheck('uncheck'))
           $("#vat_stagger").hide();
		   
    $('#tab3_ch_vat').on('ifChecked', function(e) {
         $("#vat_stagger").show();
     });
	$('#tab3_ch_vat').on('ifUnchecked', function(e) {
	
        $("#vat_stagger").hide();
    });
 
    $(".datepiker").datepicker({
        dateFormat: 'dd-mm-yy'
    });
    $(".selfassessment").hide("");
})
	$('.res_tab3').change(function(){
	   var res_tab3 = $(this).find('option:selected').text();
	   if($(this).val() != ''){
				$('.in_res_tab3').remove();
				$('#resSec_tab3').append('<input type="hidden" name="res_tab3" class="in_res_tab3" value="'+res_tab3+'" >');
			}else{
				$('.in_res_tab3').remove();
			}
	});
	
	$('#clientdetailstab3').change(function(){
	   var client_name_tab3 = $(this).find('option:selected').text();
	   if($(this).val() != ''){
				$('.client_selected_tab3').remove();
				$('.clent_error_tab3').fadeOut();
				$('#client_name_selectedtab3').append('<input type="hidden" name="client_nametab3" class="client_selected_tab3" value="'+client_name_tab3+'" >');
			}else{
				$('.client_selected_tab3').remove();
				$('#client_name_selectedtab3').append('<span class="clent_error_tab3" style="color:red; padding:10px;">Please select "Client Name"!! </span>');
			}
	});
	
	
	
	$(function() {
		 $('#downloads').click(function(e){
		 var ClientRes  = $('#tab1_client').val();
		 $('#tab1_client').click(function(){
		   $('.clentres_error').fadeOut('slow');
	});
		 if(ClientRes == null || ClientRes == ''){
		 $('.clentres_error').remove();
			$('.client_reserorr').append('<span class="clentres_error" style="color:red; padding:10px;">Please select "Client Name"!! </span>');
			 e.preventDefault();
		 }
	 });
	 
    $('#responsible_tab2').change(function() {
	   var res_tab2 = $(this).find('option:selected').text();
	   
		if($(this).val() != ''){
			$('.in_res_tab2').remove();
			$('#resSec_tab2').append('<input type="hidden" name="res_tab2" class="in_res_tab2" value="'+res_tab2+'" >');
		}else{
		    $('.in_res_tab2').remove();
		}
	});
	
	$('#download_tab3').click(function(e){
		 if($('#clientdetailstab3').val() == ''){
		 $('.clent_error_tab3').remove();
			$('#client_name_selectedtab3').append('<span class="clent_error_tab3" style="color:red; padding:10px;">Please select "Client Name"!! </span>');
			 e.preventDefault();
		 }
	});
	
	
	$('.download_tab2').click(function(e){
	    var check_agent = $('#client_name_tab2').val();
		if(check_agent == ''){
		    $('.clientname_error').remove();
			$('.client_tab2').append('<span style="color:red; padding-top:10px;" class="clientname_error"> Please select Client!! </span>');
			e.preventDefault();
		}
	});
	$('#client_name_tab2').change(function() {
	   var file_name = $(this).find('option:selected').text();
		if($(this).val() != ''){
			$('.file_name').remove();
			$('.clientname_error').fadeOut();
			$('.client_tab2').append('<input type="hidden" name="file_name" class="file_name" value="'+file_name+'" >');
		}else{
		    $('.file_name').remove();
			$('.client_tab2').append('<span style="color:red; padding-top:10px;" class="clientname_error"> Please select Client!! </span>');
		}
	});
	
	$('#client_name_tab4').change(function(){
	    var client_sel_name_tab4 = $(this).find('option:selected').text();
	    if($(this).val()!= ''){
			$('.client_sel_name_tab4').remove();
			$('.clientname_error_tab4').fadeOut();
			$('#appended_val').append('<input type="hidden" name="client_sel_name_tab4" class="client_sel_name_tab4" value="'+client_sel_name_tab4+'" >');
		}else{
		    $('.client_sel_name_tab4').remove();
			$('#appended_val').append('<span style="color:red; padding-top:10px;" class="clientname_error_tab4"> Please select Client!! </span>');
		}
	});
	
	$('.download_tab4').click(function(e){
	  var check_agent = $('#client_name_tab4').val();
	   if(check_agent == ''){
			 $('.clientname_error_tab4').remove();
			 $('#appended_val').append('<span style="color:red; padding-top:10px;" class="clientname_error_tab4"> Please select Client!! </span>');
			e.preventDefault();
	   }
	});

	$('#clientdetailstab5').change(function(){
	    var client_sel_name_tab5 = $(this).find('option:selected').text();
	    if($(this).val()!= ''){
			$('.client_sel_name_tab5').remove();
			$('.clientname_error_tab5').fadeOut();
			$('#selected_val_tab5').append('<input type="hidden" name="client_sel_name_tab5" class="client_sel_name_tab5" value="'+client_sel_name_tab5+'" >');
		}else{
		    $('.client_sel_name_tab5').remove();
			$('#selected_val_tab5').append('<span style="color:red; padding-top:10px;" class="clientname_error_tab5"> Please select Client!! </span>');
		}
	});
	
	$('#download_tab5').click(function(e){
	
	   var check_agent = $('#clientdetailstab5').val();
	 
	   if(check_agent == ''){
			 $('.clientname_error_tab5').remove();
			 $('#selected_val_tab5').append('<span style="color:red; padding-top:10px;" class="clientname_error_tab5"> Please select Client!! </span>');
			 e.preventDefault();
	   }
	});
	
	
	$('.responsibleperson_tab5').change(function(){
	    var res_person_name_tab5 = $(this).find('option:selected').text();
	    if($(this).val()!= ''){
			$('.res_person_name_tab5').remove();
			$('.selected_res_person').append('<input type="hidden" name="res_person_name_tab5" class="res_person_name_tab5" value="'+res_person_name_tab5+'" >');	
		}
	});
	
	$('#selected_client_tab6').change(function(){
	    var SeletedValue = $(this).find('option:selected').text();
		  if($(this).val() != ''){
			 $('.client_name_tab6').remove();
			 $('.clientname_error_tab6').fadeOut();
			 $('.selected_val_tab6').append('<input type="hidden" class="client_name_tab6" value="'+SeletedValue+'" >');
		  }else{
			 $('.client_name_tab6').remove();
			 $('.selected_val_tab6').append('<span style="color:red; padding-top:10px;" class="clientname_error_tab6"> Please select Client!! </span>');
		  }
	
	});
	
	$('.download_tab6').click(function(e){
		var selected_value = $('#selected_client_tab6').val();
		  if(selected_value == ''){
			$('.clientname_error_tab6').remove();
			$('.selected_val_tab6').append('<span style="color:red; padding-top:10px;" class="clientname_error_tab6"> Please select Client!! </span>' );
			e.preventDefault();
		  }
	});

    $('.clientdetails').change(function() {
	   var PageUrl = $('.getpageurl').val();
		
        var client_id = $(this).val();
        var name = $(this).find('option:selected').text();
		$('#cl_id').remove();
		$('.client_reserorr').append('<input id="cl_id" type="hidden" name="compnay_name" value="'+name+'"/>');
        $('#tab3cname').val(name)
		
		$('.indclientdetails-empty').show();
		$('.indclientdetails').hide();
		if($('#add_res').length){
			$('#add_res').val("");
		}
		
        if (client_id != "") {
            $.ajax({
                type: "GET",
                url:"/getresponsibleperson",
                //url:"/public/getresponsibleperson",
                data: { 'client_id': client_id },
                beforeSend: function() {},
                success: function(resp) {
                    if (resp != "") {
                        $(".resperson").html(resp);
                    } else {
                        $(".resperson").html("");
                    }
                }
            });
            $.ajax({
                type: "GET",
                //url: "/public/getclientdetails",
                url: "/getclientdetails",
                data: { 'client_id': client_id },
                beforeSend : function(){
                  $(".page_loader").show();
                },
                success: function(resp) {
                    $(".page_loader").hide();
                    $('#tab1selfutr').val("");
                    var tab1addr = "";
                    var tab1addr_trade = "";
                    if (resp.type == "org") {
                        $("#selfassessmentid").iCheck('uncheck')
                        $(".selfassessment").hide("");
                        $(".selfassessment").val("");
                        $("#indclientdetailstab1").val(resp.client_id);
                        $("#tab1indnum").val(resp.ni_number);
                        $("#tab1indname").val("");

                    } else {
                        $("#selfassessmentid").iCheck('check')
                        $(".selfassessment").show("");
                        $(".selfassessment").val("Individual");
                        $("#indclientdetailstab1").val(resp.client_id);
                    }
                    if (resp.type == "org") {
                        /*if( typeof(resp.trading_address.address1) != "undefined" && resp.trading_address.address1 !== null) {
                            tab1addr = resp.trading_address.address1;
                        }
                        if (resp.trading_address.address2) {
                            tab1addr = tab1addr + ',' + resp.trading_address.address2;
                        }
                        if (resp.trading_address.city) {
                            tab1addr = tab1addr + ',' + resp.trading_address.city;
                        }
                        if (resp.trading_address.county) {
                            tab1addr = tab1addr + ',' + resp.trading_address.county;
                        }
                        if (resp.trading_address.country_name) {
                            tab1addr = tab1addr + ',' + resp.trading_address.country_name;
                        }*/
                        tab1addr = resp.reg_addr;

                        $('#tab1postcode, #tab2postcode, #tab3postcode, #tab4postcode, #tab5postcode, #tab6postcode').val(resp.trading_address.postcode);
                        $('#tab1telephonenumber, #tab2telephonenumber, #tab3telephonenumber').val(resp.contacttelephone);
                        $('#tab1postcode, #tab2postcode, #tab3postcode, #tab4postcode, #tab5postcode, #tab6postcode').val(resp.trading_address.postcode);
                        $('#tab2telephonenumber, #tab5telephonenumber').val(resp.contacttelephone);
                    }

                    if (resp.type == "ind") {
                        if (resp.residential_address.address1) {
                            tab1addr = resp.residential_address.address1;
                        }
                        if (resp.residential_address.address2) {
                            tab1addr = tab1addr + ',' + resp.residential_address.address2;
                        }
                        if (resp.residential_address.city) {
                            tab1addr = tab1addr + ',' + resp.residential_address.city;
                        }
                        if (resp.residential_address.county) {
                            tab1addr = tab1addr + ',' + resp.residential_address.county;
                        }
                        if (resp.residential_address.country_name) {
                            tab1addr = tab1addr + ',' + resp.residential_address.country_name;
                        }

                        $('#tab1selfutr').val(resp.tax_reference);
                        $('#tab1postcode, #tab2postcode, #tab3postcode, #tab4postcode, #tab5postcode, #tab6postcode').val(resp.residential_address.postcode);
                        $('#tab4telephonenumber').val(resp.res_telephone);

                        //$("#tab5telephonenumber").val(resp.contacttelephone)
                    }

                    $('#tab1reference, #tab2reference').val(resp.client_code)
                    $('#tab4registrationnumber, #crn').val(resp.registration_number);

                    $('#payereferencesamll').val(resp.samllpayeref)
                    $('#payereference').val(resp.paye_reference)

                    $('#corporationtaxreferencesmall, #tab2payereferencesamll').val(resp.utrsamllbox);
                    $('#corporationtaxreference, #tab2payereference, #tab6utr, #tab4utr').val(resp.tax_reference);

                    $('#vat_number, #vat_numbertab3, #vat_numbertab5').val(resp.vat_number)
                    $('#tab1address, #tab2address, #tab3_address-trade, #tab4address, #tab5address, #tab6address').val(tab1addr);
					
					$('#tab1selfninumber, #tab6ninumber').val(resp.ni_number);

                    $("#contacttab3fax").val(resp.contactfax);
                    $("#bnameemail").val(resp.contactemail);

                    $('#tab2accountofficereferencesmall').val(resp.samllaccofcref);
                    $('#tab2accountofficereference').val(resp.acc_office_ref);
                    if (resp.business_type == "Company") {
                        $('#tab1selfutr').val("");
                        $('#tab1selfninumber').val("");
                    }
                    $('.businesstype').val(resp.business_type);

                    if (resp.vat_stagger == "Jan-April-Jul-Oct") {
                        $("#vatsager1").iCheck('check')
                        $("#vatsager2").iCheck('uncheck')
                        $("#vatsager3").iCheck('uncheck')
                        $("#vatsager4").iCheck('uncheck')
                    }
                    if (resp.vat_stagger == "Feb-May-Aug-Nov") {
                        $("#vatsager2").iCheck('check')
                        $("#vatsager3").iCheck('uncheck')
                        $("#vatsager1").iCheck('uncheck')
                        $("#vatsager4").iCheck('uncheck')
                    }
                    if (resp.vat_stagger == "Mar-Jun-Sept-Dec") {
                        $("#vatsager3").iCheck('check')
                        $("#vatsager2").iCheck('uncheck')
                        $("#vatsager1").iCheck('uncheck')
                        $("#vatsager4").iCheck('uncheck')
                    }

                    if (resp.vat_stagger == "monthly") {
                        $("#vatsager3").iCheck('uncheck')
                        $("#vatsager2").iCheck('uncheck')
                        $("#vatsager1").iCheck('uncheck')
                        $("#vatsager4").iCheck('check')
                    }

                    if (resp.bank_short_code) {
                        var shortcode = resp.bank_short_code
                        var farr = shortcode.replace("-", "")
                        var finalarr = farr.replace("-", "")
                        output = [],
                        sNumber = finalarr.toString();
                        for (var i = 0, len = sNumber.length; i < len; i += 1) {
                            output.push(+sNumber.charAt(i));
                        }
                        // console.log(output);
                        $("#sortcode1").val(output[0])
                        $("#sortcode2").val(output[1])
                        $("#sortcode3").val(output[2])
                        $("#sortcode4").val(output[3])
                        $("#sortcode5").val(output[4])
                        $("#sortcode6").val(output[5])
                    }
                    if (resp.bank_acc_no) {
                        var bankaccno = resp.bank_acc_no
                        outputbank = [],
                            sbankNumber = bankaccno.toString();
                        for (var i = 0, len = sbankNumber.length; i < len; i += 1) {
                            outputbank.push(+sbankNumber.charAt(i));
                        }
                        $("#tab3accountnumber1").val(outputbank[0])
                        $("#tab3accountnumber2").val(outputbank[1])
                        $("#tab3accountnumber3").val(outputbank[2])
                        $("#tab3accountnumber4").val(outputbank[3])
                        $("#tab3accountnumber5").val(outputbank[4])
                        $("#tab3accountnumber6").val(outputbank[5])
                        $("#tab3accountnumber7").val(outputbank[6])
                        $("#tab3accountnumber8").val(outputbank[7])
                    }
                    //$("#bankaccname").val(resp.business_name);
                    if (resp.business_type == "LLP") {
                        var llpname = $('#tab3cname').val();
                        $("#bankaccname").val(llpname)
                    } else {
                        $("#bankaccname").val(resp.business_name)
                    }

                    $("#naturetrade, #tab4naturetrade").val(resp.business_desc)
                    $("#tab6dob").val(resp.dob)
                    $("#tab6tele").val(resp.res_telephone)

                    $("#tab6title").val(resp.title)
                    $("#tab6_fname").val(resp.fname)
                    $("#tab6mname").val(resp.mname)
                    $("#tab6lname").val(resp.lname);
                }
            });
        } else {
            $("#responsibleperson").html("");
            $(".resperson").html("");
            //location.reload()
        }
    });

    $('#staffmDetailstab2').change(function() {
        var client_id = $(this).val();
        console.log(client_id);
        // alert(client_id)
        $.ajax({
            type: "GET",
            //dataType: "json",
            //url: '/public/client/client-details-by-client_id/'+client_id+"=ajax",
            url: "/getresponsibleperson",
            data: {
                'client_id': client_id
            },
            beforeSend: function() {
                // $(".show_client_details").html('<img src="/img/spinner.gif" />');
                //return false;
            },
            success: function(resp) {
                //var res = JSON.parse(resp);
                //  console.log(resp);

                if (resp != "") {
                    $("#restab2").html(resp);
                } else {
                    $("#restab2").html("");
                }
            }
        });
    });

    $('.indclientdetails').change(function() {
        var client_id = $(this).val();
        console.log(client_id); //return false;
        if (client_id != "") {
            $.ajax({
                type: "GET",
                url: "/getindclientdetails",
                data: {
                    'client_id': client_id
                },
                beforeSend: function() {},
                success: function(resp) {
                    //var res = JSON.parse(resp);
					//alert(res);
                    //console.log(resp);
                    //return false;
					//alert(resp.client_name+":"+resp.ni_number);
                    if (resp != "") {
                        $("#tab1indname").val(resp.client_name);
                        $("#tab1indnum").val(resp.ni_number);
                    } else {
                        $("#tab1indname").val("");
                        $("#tab1indnum").val("");
                    }

                }
            });
        } else {
            $("#tab1indname").val("");
            $("#tab1indnum").val("");
        }
    });

    $('.selfassessment').change(function() {
        //var client_id= $("#responsibleperson").val();
		var client_id = $(".clientdetails").val();
        var assessment = $(this).val()
        console.log(assessment);
        if (assessment == "Individual") {
			$("#chk_sameagent").iCheck("uncheck");
			$("#indclientdetailstab1").val(1);
			 $("#tab1indname,#tab1indnum").val("");
			//$(".jointclaimant,.jointclaimant2").hide("");
            var client_id = $("#responsibleperson").val();
			//var client_id = $(".clientdetails").val();
            console.log(client_id);
        } else if(assessment == ""){
			$("#tab1selfutr, #tab1selfninumber").val("");
		}		
		else {
			if (assessment == "Partnership" || assessment == "Trust") {
          	  $("#tab1selfninumber").val("");
       		}
			$(".jointclaimant,.jointclaimant2").show("");
            var client_id = $(".clientdetails").val();
            console.log(client_id);
        }
        if (client_id != "") {
            $.ajax({
                type: "GET",
                url: "/getclientdetails",
                data: {
                    'client_id': client_id
                },
                success: function(resp) {
                    console.log(resp);
                   // return false;
              //alert(resp.tax_reference+":"+resp.ni_number);
                    $("#tab1selfutr").val(resp.tax_reference);
                    $("#tab1selfninumber").val(resp.ni_number);
                    //$("#tab1selfninumber").val("check-pk-2");
                }
            });
        } else {
            $("#tab1selfutr").val("");
            $("#tab1selfninumber").val("");
        }
        //return false;
    });

    $('#selfassessmentid').on('ifChecked', function(event) {
        console.log('chek')
        $(".selfassessment").show("");
		
    });
		
    $('#selfassessmentid').on('ifUnchecked', function(event) {
        $(".selfassessment").hide("");
		$("#tab1selfutr, #tab1selfninumber").val("");
		$('.selfassessment option:selected').prop('selected', false);
    });
		
	$('#tax_credits').on('ifChecked', function(event) {
        console.log('tax_credits chek')
		
		$("#indclientdetailstab1-empty").hide();
		$("#indclientdetailstab1").show();
		$('#indclientdetailstab1 option:selected').prop('selected', false);
		$("#indclientdetailstab1").prop('disabled', false);
		$('#tab1indname').prop('disabled', false);
		$('#tab1indnum').prop('disabled', false);
		$('#tab1indnum').val('');
		$('#tab1indname').val('');
    });
		
	$('#tax_credits').on('ifUnchecked', function(event) {
        console.log('tax_credits unchek')
		$('#indclientdetailstab1 option:selected').prop('selected', false);
		$("#chk_sameagent").iCheck("uncheck");
		$("#indclientdetailstab1-empty").show();
		$("#indclientdetailstab1").hide();
		$("#indclientdetailstab1").prop('disabled', 'disabled');
		$('#tab1indname').prop('disabled', 'disabled');
		$('#tab1indnum').prop('disabled', 'disabled');
		$('#tab1indnum').val('');
		$('#tab1indname').val('');
    });
	
	 $('#chk_sameagent').on('ifChecked', function(event) {
        console.log('chek same agent')
       // $(".jointclaimant2").hide("");
		//$('#tab1indnum').val($('#tab1selfninumber').val());
		
    });

    $('#chk_sameagent').on('ifUnchecked', function(event) {
        //$(".jointclaimant2").show("");
		//$('#tab1indnum').val();
    });
    //$( "#tab_3" ).on("change", ".resperson", function() {

    $('.resperson').change(function() {
        var val = $(this).val();
        if(val != ''){
            var name = $(this).find('option:selected').text();
            $('#add_res').remove();
            $('#reserror').append("<input id='add_res' type='hidden' name='res_person' value='"+name+"' />");
        }else{
            $('#add_res').remove();
		}
		  
        $("#loggedclent").val(name);
		
		$('#indclientdetailstab1-empty').hide();
		$('#indclientdetailstab1').show();
		
        if ($('#pageno').val() == "4") {
            var pname = $('#pageno').val()
            console.log(pname);
            var client_id = $(this).val();

            $.ajax({
                type: "GET",
                url: "/getclientdetails",
                data: {
                    'client_id': client_id
                },
                success: function(resp) {
                    console.log(resp)

                    $("#tab4title").val(resp.title);
                    $("#tab4fname").val(resp.fname);
                    $("#tab4mname").val(resp.mname);
                    $("#tab4lname").val(resp.lname);
                    $("#tab4dob").val(resp.dob);
                    $("#tab4ninumber").val(resp.ni_number);
                    $("#tab4resputr").val(resp.tax_reference);
                    $("#tab4telephone").val(resp.res_telephone);

                    if (resp.residential_address.address1) {
                        tab1addr = resp.residential_address.address1;
                    }
                    if (resp.residential_address.address2) {
                        tab1addr = tab1addr + ',' + resp.residential_address.address2;
                    }
                    if (resp.residential_address.city) {
                        tab1addr = tab1addr + ',' + resp.residential_address.city;
                    }
                    if (resp.residential_address.county) {
                        tab1addr = tab1addr + ',' + resp.residential_address.county;
                    }
                    if (resp.residential_address.country_name) {
                        tab1addr = tab1addr + ',' + resp.residential_address.country_name;
                    }

                    $("#tab4resaddress").val(tab1addr);
                    $('#tab4postcide').val(resp.residential_address.postcode);
                }

            });

        } else {

            if ($('#clientdetailstab3').val()) {
                var appwith = $('#clientdetailstab3').val();
            } else {
                var appwith = $('#clientdetailstab5').val();
            }
            var c_id = $(this).val();
            $.ajax({
                type: "GET",
                url: "/relationbetween",
                data: { 'appwith': appwith, 'c_id': c_id },
                success: function(resp) {
                    $("#positiontab3").val(resp.relation_type);
                    $("#statusproprietor").val(resp.relation_type);

                }
            });
        }

    })



});
$('#signedbyagent').on('ifChecked', function(event) {
    //alert('click')
    //$("#loggedinusername").val();  
    $('#decname').val($("#loggedinusername").val())
    $('#decposition').val("Agent")

});

$('#none').on('ifChecked', function(event) {
    $('#decname').val("");
    $('#decposition').val("");

});

$('#signedbyclient').on('ifChecked', function(event) {


    var responsi = $('#loggedclent').val();
    //alert(responsi)
    $('#decname').val(responsi);
    var position = $('#positiontab3').val();
    $('#decposition').val(position)
        // $('#decposition').val("");




});
