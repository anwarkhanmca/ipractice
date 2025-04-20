$(document).ready(function(){
    $('#CheckallCheckbox').on('ifChecked', function(event){
        $(".ch_returns input[class='checkbox']").iCheck('check');
    });

    $('#CheckallCheckbox').on('ifUnchecked', function(event){
        $(".ch_returns input[class='checkbox']").iCheck('uncheck');
    });

    $(document).click(function() {
        $(".open_toggle").hide();
    });
    $("#select_icon").click(function(event) {
        $(".open_toggle").toggle();
        event.stopPropagation();
    });

	$(".get_officers").click(function(){
		var number = $(this).attr("data-number");
		var key = $(this).attr("data-key");

        $.ajax({
            type: "POST",
            url: "/officers-details",
            data: { 'number': number, 'key': key },
            beforeSend: function() {
                $("#officer_details_div").html('<img src="/img/ajax-loader1.gif" />');
                $("#personal_details").modal('show');//return false;
            },
            success: function (resp) {
            	$("#officer_details_div").html(resp);
            }
        });
    });

    $(".search_company").click(function(){
        var value = $("#search_value").val();
        $.ajax({
            url : "/company-search",
            type : "POST",
            data : { 'value' : value},
            beforeSend : function(){
                $("#result").html("");
                var result = '<tr class="td_color"><td colspan="3"><span class="sub_header">COMPANY NAME</span></td></tr><tr><td colspan="3" align="center"><img src="/img/spinner.gif"></td></tr>';
                $("#result").html(result);
            },
            success : function(resp){
                $("#result").html(resp);
            }
        });
    });

    $("#result").on("click", ".get_company_details", function(){//popup_align
        //var number = $(this).data("number");
        var key         = $(this).data("key");
        var number      = $('#cmpnyno_'+key).val();
        var back_url    = $("#back_url").val();
        //alert(number);
        $.ajax({
            type: "POST",
            url: "/company-details",
            data: { 'number': number, 'back_url' : back_url },
            beforeSend: function() {
                $('#hidden_cmpnyno').val(number);
                $("#company_details_div").html('<img src="/img/ajax-loader1.gif" />');
                $("#company_details-modal").modal('show');//return false;
            },
            success: function (resp) {
                $("#company_details_div").html(resp);
            }
        });
    });

    $("#company_details_div").on("click", ".import_client", function(){
        //var number = $(this).data("number");
        var number      = $('#hidden_cmpnyno').val();
        var back_url    = $("#back_url").val();
        var goto_url    = $(this).data("goto_url");

        $.ajax({
            type: "POST",
            url: "/import-company-details/"+number+"=ajax",
            //data: { 'number': number },
            beforeSend: function() {
                $("#message_div").html('<img src="/img/spinner.gif" />');
            },
            success: function (client_id) {//return false;
                if(client_id > 0){
                    //$("#message_div").html("<p style='color:#3c8dbc;font-size:16px'>Company details successfully imported</p>");
                    if(back_url == 'ch_list'){
                        window.location.href='/chdata/index';
                    }
                    if(back_url == 'org_list'){
                        window.location.href='/client/edit-org-client/'+client_id+"/"+goto_url;
                    }
                    if(back_url == 'ind_list'){
                        window.location.href='/client/edit-ind-client/'+client_id+"/"+goto_url;
                    }
                        
                }else{
                    $("#message_div").html("<p style='color:red;font-size:16px'>There are some error to importing data</p>");
                }
            }
        });
    });


    $("#company_details_div").on("click", ".add_client_officers", function(){
        var key = $(this).data("key");
        //var company_number = $(this).data("company_number");
        var company_number = $('#hidden_cmpnyno').val();
        var goto_url = $(this).data("goto_url");

        $.ajax({
            type: "POST",
            url: "/goto-edit-client",
            dataType: "json",
            data: { 'company_number': company_number, 'key' : key },
            beforeSend: function() {
                $("#goto"+key).html('<img src="/img/spinner.gif" />');
            },
            success: function (resp) {//console.log(resp['link']);return false;
            $("#goto"+key).html('<button class="btn btn-default btn-sm imp_but" type="button">+ Add</button>');
                if(resp['link'] == 'org'){
                    var url = resp['base_url']+'/client/edit-org-client/'+resp['client_id']+"/"+goto_url;
                    var myWindow = window.open(url , '_blank');
                    myWindow.focus();
                }
                if(resp['link'] == 'ind'){//alert(resp['link']);
                    var url = resp['base_url']+'/client/edit-ind-client/'+resp['client_id']+"/"+goto_url;
                    var myWindow = window.open(url, '_blank');
                    myWindow.focus();
                }
            }
        });

    });


    /* ################# SYNC data in job section start ################### */
    $(".sync_jobs_data").click(function(){

        var val = [];
        //alert('val');return false;
        $(".checkbox:checked").each( function (i) {
          if($(this).is(':checked')){
            val[i] = $(this).val();
          }
        });
        //alert(val.length);return false;
        if(val.length>0){
            $.ajax({
                type: "POST",
                url: '/jobs/sync-jobs-clients',
                data: { 'client_ids' : val },
                beforeSend : function(){
                    $(".sync_jobs_data").attr('disabled', 'disabled');
                    $("#message_div").html('<img src="/img/spinner.gif" />');
                },
                success : function(resp){
                  //window.location = '/chdata/index';
                  window.location.reload();
                }
            });
            
        }else{
            alert('Please select atleast one client');
        }

    });
    /* ################# SYNC data in job section end ################### */

    /* ################# Auto login start ################### */
    $('.autologin_button').click(function(event){
        var val = [];
        $(".for_autologin:checked").each( function (i) {
          if($(this).is(':checked')){
            val[i] = $(this).val();
          }
        });
        //alert(val.length);return false;
        if(val.length == 0){
          alert("Please select atleast one client.");
          return false;
        }else if(val.length > 1){
          alert("You can't select more than one client.");
          return false;
        }else{
          $.ajax({
            type: "POST",
            url: '/client/ajax-client-details',
            dataType: 'json',
            data: { 'client_id' : val[0] },
            success : function(resp){
              if(resp.ch_username == "" || resp.ch_password == ""){
                alert("Please enter the Companies' house logins detail under practice settings");
                return false;
              }else{
                if(resp.ch_auth_code === undefined){
                  var ch_auth_code = '123456';
                }else{
                  var ch_auth_code = resp.ch_auth_code;
                }
                window.open('/chdata/autologin/'+resp.registration_number+'/'+ch_auth_code, '_blank');
              }
            }
          });
        }
    });

    $('.autologin_single').click(function(event){
        var company_no      = $(this).data('company_no');
        var ch_auth_code    = $(this).data('authcode');
        $.ajax({
            type: "POST",
            url: '/client/ajax-chlogin-details',
            dataType: 'json',
            data: { 'client_id' : 1 },
            success : function(resp){
              if(resp.ch_username == "" || resp.ch_password == ""){
                alert("Please enter the Companies' house logins detail under practice settings");
                return false;
              }else{
                if(ch_auth_code === undefined){
                  var ch_auth_code = '123456';
                }
                window.open('/chdata/autologin/'+company_no+'/'+ch_auth_code, '_blank');
              }
            }
          });
        
    });
    /* ################# Auto login end ################### */


    $("body").on("click", ".open_popdata", function(){//popup_align
        var link    = $(this).data('link');
        //alert(link);
        $(".continue_link").attr('href', link);
        $("#chdatadetails_pop-modal").modal('show');
    });
  



});//end of main document ready 
