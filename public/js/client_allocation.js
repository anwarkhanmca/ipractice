$(document).ready(function(){

	$("body").on('click', '.openAllocation', function(){
		var client_id 	= $(this).data('client_id');
		var service_id  = $(this).data('service_id');
    var page_name   = $(this).data('page_name');
    //alert(page_name)

		$.ajax({
      type: "POST",
      dataType : 'json',
      url: '/allocation/get-client-allocation',
      data: { 'client_id' : client_id, 'service_id' : service_id, 'action':'getAllocation' },
      beforeSend : function(){
        $('.show_loader').html('<img src="/img/spinner.gif" />');
        $('#allocation-modal').modal('show');
        $('.staff_service_id').val(service_id);
        $('.staff_client_id').val(client_id); 
        if(page_name == 'allocation'){
          $('#removeAllocCheck').iCheck('check');
        }
        $('.page_name_modal').val(page_name);      
      },
      success : function(resp){
      	$('.show_loader').html('');
      	$('.popup_client_name').html(resp.client_name);
      	$('.popup_service_name').html(resp.service_name);
        $('.staff_client_type').val(resp.client_type);

        var trvalue = '';
        if(resp.details.length > 0){
          $.each(resp.details, function(key, value){
            trvalue += '<tr id="TemplateRow" class="makeCloneClass TemplateRow'+value.client_allocation_id+'">';
            trvalue += '<td width="5%" class="deleteAllocation">';
          if(key > 0)
            trvalue += '<a href="javascript:void(0)" data-id="'+value.client_allocation_id+'" class="deleteAlloc" data-status="database"><img src="/img/cross_icon.png"></a>';
            
            trvalue += '</td>';
            var smallBx = '';
            for(var i=1; i <=5; i++){
              if(i == 1){
                smallBx = value.staff_hrs1;
                if(value.staff_id1 != '0' && value.staff_id1 != 'undefined'){
                  selected = 'selected';
                }
              }else if(i == 2){
                smallBx = value.staff_hrs2;
                if(value.staff_id2 != '0' && value.staff_id1 != 'undefined'){
                  selected = 'selected';
                }
              }else if(i == 3){
                smallBx = value.staff_hrs3;
                if(value.staff_id3 != '0'){
                  selected = 'selected';
                }
              }else if(i == 4){
                smallBx = value.staff_hrs4;
                if(value.staff_id4 != '0'){
                  selected = 'selected';
                }
              }else if(i == 5){
                smallBx = value.staff_hrs5;
                if(value.staff_id5 != '0'){
                  selected = 'selected';
                }
              }

                
              trvalue += '<td align="left" class="staffDrop_'+i+'">';
              trvalue += '<select class="form-control newdropdown allocationSubmit" name="staff_id'+i+'[]" id="staff_id'+i+'1" data-column_name="staff_id'+i+'" data-index="'+key+'" >';
              trvalue += '<option value="">None</option>';
              $.each(resp.staffs, function(key1, value1){
                selected = '';
                if(i == 1){
                  if(value.staff_id1 == value1.user_id){
                    selected = 'selected';
                  }
                }else if(i == 2){
                  if(value.staff_id2 == value1.user_id){
                    selected = 'selected';
                  }
                }else if(i == 3){
                  if(value.staff_id3 == value1.user_id){
                    selected = 'selected';
                  }
                }else if(i == 4){
                  if(value.staff_id4 == value1.user_id){
                    selected = 'selected';
                  }
                }else if(i == 5){
                  if(value.staff_id5 == value1.user_id){
                    selected = 'selected';
                  }
                }
                trvalue += '<option value="'+value1.user_id+'" '+selected+'>'+value1.fname+' '+value1.lname+'</option>';
              });
              trvalue += '</select>';
              trvalue += '</td>';
              trvalue += '<td><input type="text" class="smallBx allocationSave" value="'+smallBx+'" name="staff'+i+'_hrs[]" id="staff'+i+'1_hrs" data-column_name="staff'+i+'1_hrs" data-index="'+key+'"></td>';
            }
          trvalue += '</tr>';
          });
        }else{
          var trvalue = $('#TemplateRow_final').clone(true); 
          var $newRow = trvalue;
          $newRow.find('#staff_id11').val('');
          $newRow.find('#staff_id21').val('');
          $newRow.find('#staff_id31').val('');
          $newRow.find('#staff_id41').val('');
          $newRow.find('#staff_id51').val('');

          $newRow.find('#staff11_hrs').val('');
          $newRow.find('#staff21_hrs').val('');
          $newRow.find('#staff31_hrs').val('');
          $newRow.find('#staff41_hrs').val('');
          $newRow.find('#staff51_hrs').val('');
        }
            
        $('#BoxTableResp tbody').html(trvalue);
      }
    });
	});


      $('.addnew_responsible').click(function() {

            var staff1Drop = $('.staffDrop_1 select').html();
            
              //var $table = $(this).prev('table'),
        //$newRow = $table.find('tr:eq(1)').clone();


            var $newRow = $('#BoxTableResp tbody > tr:first').clone(true);
            var noOfDivs = $('.makeCloneClass').length + 1;

            /*$newRow.find('.deleteAllocation a').attr('data-id', noOfDivs);
            $newRow.find('.deleteAllocation a').attr('data-status', 'normal');
            $newRow.find('.deleteAllocation a').attr('class', 'deleteAlloc');*/

            $newRow.find('.deleteAllocation').html('<a href="javascript:void(0)" data-id="'+noOfDivs+'" class="deleteAlloc"><img src="/img/cross_icon.png"></a>');

            for(var i=1; i<=5;i++){
                  $newRow.find('#staff_id'+i+'1').val('');
                  $newRow.find('#staff'+i+'1_hrs').val('');
                  $newRow.find('#staff_id'+i+'1').attr('id', 'staff_id'+i+noOfDivs);
                  $newRow.find('#staff_id'+i+'1').attr('data-column_name', 'staff_id'+i);
                  $newRow.find('#staff_id'+i+'1').attr('data-index', noOfDivs);
                  $newRow.find('#staff'+i+'1_hrs').attr('id', 'staff'+i+noOfDivs+'_hrs');
                  $newRow.find('#staff'+i+'1_hrs').attr('data-column_name', 'staff'+i+'_hrs');
                  $newRow.find('#staff'+i+'1_hrs').attr('data-index', noOfDivs);

                  $newRow.find('#staff_id'+i+noOfDivs).html('');


                  $newRow.find('#staff_id'+i+noOfDivs).html(staff1Drop);
                  $newRow.find('#staff_id'+i+noOfDivs).val('');
            }


            $('#BoxTableResp tr:last').after($newRow);    

            $('#BoxTableResp tr:last').attr('class', 'makeCloneClass TemplateRow'+noOfDivs);
            return false;
          
      });

      $('.DeleteBoxRow').click(function() {
          var size = $(".DeleteBoxRow").size();
          if(size>1){
              $(this).closest('tr').remove();
          }
      });


      $("body").on('change', ".allocationSubmit", function(event) {
        $('#input_type').val('dropdown');
        save_client_allocation('dropdown');
      });

      $("body").on("blur", ".allocationSave", function(event) {
        $('#input_type').val('text');
        save_client_allocation('text');
      });

      $("body").on("click", "#AllocationSubmit", function(event) {
        $('#input_type').val('notify');
        save_client_allocation('notify');
      });

      $("body").on("click", ".openAllocationHeading", function(event) {
            var client_id     = $('#staff_client_id').val();
            var service_id    = $('#staff_service_id').val();
              $.ajax({
                  type: "POST",
                  dataType : 'json',
                  url: '/allocation/get-client-allocation',
                  data: { 'client_id' : client_id, 'service_id' : service_id, 'action':'getHeading' },
                  beforeSend : function(){
                        $('#showLoadHead').html('<img src="/img/spinner.gif" />');
                        $('#heading-modal').modal('show');
                        //$('#heading_service_id').val(service_id);
                        //$('#heading_client_id').val(client_id);      
                  },
                  success : function(resp){
                        $('#showLoadHead').html('');
                        var headings = resp.headings;
                        var list = "";
                        $.each(headings, function(key, value){
                              list += '<tr id="change_status_tr_'+value.alloc_head_id+'">';
                              list += '<td><span id="statusSpan'+value.alloc_head_id+'">'+value.heading+'</span></td>';
                              list += '<td align="center"><span id="action_'+value.alloc_head_id+'"><a href="javascript:void(0)" class="edit_status" data-step_id="'+value.alloc_head_id+'"><img src="/img/edit_icon.png"></a></span></td>';
                              list += '</tr>';
                        });
                        $('.add_heading_table tbody').html(list);
                  }
            });
        
      });

      /* ================== Manage Tasks ================== */
      $(document).on("click", ".edit_status", function(){
        var step_id = $(this).data("step_id");
        var status_name = $("#statusSpan"+step_id).html();
        var text_field = "<input type='text' id='status_name"+step_id+"' value='"+status_name+"' style='width:100%; height:30px'>";
        var action = "<a href='javascript:void(0)' class='save_new_status' data-step_id='"+step_id+"'>Save</a>&nbsp;&nbsp;<a href='javascript:void(0)' class='cancel_edit' data-step_id='"+step_id+"'>Cancel</a>";
        $("#statusSpan"+step_id).html(text_field);
        $("#action_"+step_id).html(action);
      });

      $("#heading-modal").on("click", ".cancel_edit", function(){
        var step_id = $(this).data("step_id");
        var status_name = $("#status_name"+step_id).val();
        var action = "<a href='javascript:void(0)' class='edit_status' data-step_id='"+step_id+"'><img src='/img/edit_icon.png'></a>";
        $("#statusSpan"+step_id).html(status_name);
        $("#action_"+step_id).html(action);
      });

      $("#heading-modal").on("click", ".save_new_status", function(){
        var step_id = $(this).data("step_id");
        var heading_name = $("#status_name"+step_id).val();
        //alert(status_name+" "+step_id);
        $.ajax({
            type: "POST",
            url: "/allocation/get-client-allocation",
            dataType: "json",
            data: { 'step_id' : step_id, 'heading_name' : heading_name, 'action':'saveHeading' },
            beforeSend : function(){
                  $('#showLoadHead').html('<img src="/img/spinner.gif" />');     
            },
            success: function (resp) {
                  $('#showLoadHead').html(''); 
                  if(resp.headings != ""){
                    var action = "<a href='javascript:void(0)' class='edit_status' data-step_id='"+step_id+"'><img src='/img/edit_icon.png'></a>";
                    $("#statusSpan"+step_id).html(heading_name);
                    $("#action_"+step_id).html(action);

                    $(".head_"+step_id+' div:nth-child(1)').text(heading_name);
                  }else{
                    alert("There are some problem to update status");
                  }
            }
        });

      });

      $(".allocationPopTable").on("click", ".deleteAlloc", function(){
        var id          = $(this).data("id");
        var status      = $(this).data("status");
        if(confirm('Do you want to delete?')){
            if(status == 'database'){
                  $.ajax({
                        type: "POST",
                        url: "/allocation/get-client-allocation",
                        dataType: "json",
                        data: { 'id' : id, 'action':'deleteAlloc' },
                        beforeSend : function(){
                              //$('#showLoadHead').html('<img src="/img/spinner.gif" />');     
                        },
                        success: function (resp) {
                              $(".TemplateRow"+id).hide();
                              location.reload();
                        }
                  });
            }else{
                  $(".TemplateRow"+id).hide();
            }
            
        }

      });

      $('.serviceCheck').on('ifChecked', function(event){
            var client_type = $("#client_type").val();
            var service_id = $(this).data('service_id');
            var client_id = $(this).data('client_id');
            $.ajax({
                type: "POST",
                url: '/edit-service-id',
                data: { 'service_id':service_id,'action_type':'add','client_id':client_id },
                beforeSend : function(){
                  $(".service_edit_td_"+service_id).removeClass('disable_click');
                },
                success : function(resp){

                  //$("#hide_service_tr_"+service_id).find('select').prop('disabled', false);
                  //$("#"+client_type+"_checkbox"+client_id).iCheck('enable');
                  //$("#client_"+client_id+" input[type=checkbox]").prop('disabled', false);
                }
            });
      });

      $('.serviceCheck').on('ifUnchecked', function(event){
            var client_type = $("#client_type").val();
            var service_id = $(this).data('service_id');
            var client_id = $(this).data('client_id');
            $.ajax({
                type: "POST",
                url: '/edit-service-id',
                data: { 'service_id':service_id,'action_type':'delete','client_id':client_id },
                success : function(resp){
                  $(".service_edit_td_"+service_id).addClass('disable_click');
                  $("#hide_service_tr_"+service_id+" td:nth-last-child(2)").html('');
                }
            });
    });

      


});


function save_client_allocation(input_type)
{
  var client_id     = $('.staff_client_id').val();
  var service_id    = $('.staff_service_id').val();
  var page_name     = $('.page_name_modal').val();
  var input_type    = $('#input_type').val();//alert(page_name+'ad')

  $("#AllocationForm").ajaxForm({
    dataType: 'json',
    beforeSend: function() {
      if(input_type == 'notify'){
        $('#allocation-modal .show_loader').html('<img src="/img/spinner.gif" />');
      }
    },
    success: function(resp) {
      var data = resp.allocationStaff;

      if(page_name == 'allocation'){
        var client_type = $('#client_type').val();
        if(input_type == 'notify'){
          $('#allocation-modal .show_loader').html('');
          $('#allocation-modal').modal('hide');
        }
        refresh_table();

      }else if(page_name == 'edit_org_form' || page_name == 'edit_ind_form' || page_name == 'tasks'){
        var selected1 = '<select class="form-control newdropdown " id="staff_dropdown_'+service_id+'">';
        $.each(data, function(key, value){
          if(value.staff_name1 != '' && value.staff_name1 !== undefined && value.staff_id1 != '0'){
            selected1 += '<option value="'+value.staff_id1+'">'+value.staff_name1+'</option>';
          }
          if(value.staff_name2 != '' && value.staff_name2 !== undefined && value.staff_id2 != '0'){
            selected1 += '<option value="'+value.staff_id2+'">'+value.staff_name2+'</option>';
          }
          if(value.staff_name3 != '' && value.staff_name3 !== undefined && value.staff_id3 != '0'){
            selected1 += '<option value="'+value.staff_id3+'">'+value.staff_name3+'</option>';
          }
          if(value.staff_name4 != '' && value.staff_name4 !== undefined && value.staff_id4 != '0'){
            selected1 += '<option value="'+value.staff_id4+'">'+value.staff_name4+'</option>';
          }
          if(value.staff_name5 != '' && value.staff_name5 !== undefined && value.staff_id5 != '0'){
            selected1 += '<option value="'+value.staff_id5+'">'+value.staff_name5+'</option>';
          }
        });
        selected1 += '</select>';
        $('.'+client_id+'_staff_table_drop_'+service_id).html(selected1);
        removeDuplicateOption(client_id, service_id);
      }
    }
  }).submit();
}


function removeDuplicateOption(client_id, service_id){
      var seen = {};
      $('#staff_dropdown_'+service_id).children().each(function() {
          var txt = $(this).attr('value');
          if (seen[txt]) {
              jQuery(this).remove();
          } else {
              seen[txt] = true;
          }
      });
}