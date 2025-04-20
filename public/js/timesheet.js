$(document).ready(function(){
  $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});
  $("#eddpick").datepicker({dateFormat: 'dd-mm-yy'});

  $(".newPopupOpen").click(function(){
    $("#addNewLineBut").show();
    var entry_type = $(this).data('entry_type');
    $('#entry_type').val(entry_type);
    $('#BoxTable tbody').children( 'tr:not(:first)' ).remove();

    if(entry_type == 'T'){
      $('#servDiv').html('Service <a href="javascript:void(0)" class="add_to_list openVatSchemeModal">Add/Edit List</a>');
      $('#HeadingDiv').html('NEW TIME SHEET');
      $('#hrsDiv').html('Hrs');
      $('#expenseDropRow').hide();
      $('#schemeDropRow').show();

      $('#attachTh').hide();
      $('#attachTd').hide();
    }else{
      $('#servDiv').html('Expense Type <a href="javascript:void(0)" class="add_to_list openExpenseTypeModal">Add/Edit List</a>');
      $('#HeadingDiv').html('NEW CLIENT EXPENSE RECHARGE');
      $('#hrsDiv').html('£');
      $('#schemeDropRow').hide();
      $('#expenseDropRow').show();

      $('#attachTh').show();
      $('#attachTd').show();
    }

    $('#dpick1').val('');
    $('#staff_id').val('');
    $('#rel_client_id').val('');
    $('#edit_id').val('0');
    $('#hrs').val('');
    $('#notes1').val('');
    $('#attachDivPop1').html('');
    $('#expense_type').val('');
    $('#vat_scheme_types').val('');

    $("#compose-modal").modal("show");
  });

  $('body').on('click', '.openVatSchemeModal', function(){
      $("#vatScheme-modal").modal("show");
  });

  $('body').on('click', '.openExpenseTypeModal', function(){
      $("#expenseType-modal").modal("show");
  });

  $('body').on('click', '#add_expense_type', function(){
    var expense_type_name  = $("#expense_type_name").val();

    $.ajax({
      type: "POST",
      url: '/timesheet/expense-type-action',
      data: { 'expense_type_name' : expense_type_name, 'action':'add' },
      
      success : function(field_id){//alert(client_type);return false;
        var append = '<div class="pop_list form-group" id="hide_vat_div_'+field_id+'"><a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_expense_type" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a>'+expense_type_name+'</div>';
        $("#append_expense_type").append(append);

        $("#expense_type_name").val("");
        $("#expense_type").append('<option value="'+field_id+'">'+expense_type_name+'</option>');
      }
    });
  });

  //Delete Expenses Type start
$("#append_expense_type").on("click", ".delete_expense_type", function(){
  var field_id = $(this).data('field_id');
  if (confirm("Do you want to delete this field ?")) {
    $.ajax({
      type: "POST",
      url: '/timesheet/expense-type-action',
      data: { 'field_id' : field_id, 'action':'delete' },
      success : function(resp){//console.log(resp);return false;
        if(resp != ""){
          $("#hide_vat_div_"+field_id).hide();
          $("#expense_type option[value='"+field_id+"']").remove();
        }else{
          alert("There are some error to delete this scheme, Please try again");
        }
      }
    });
  }
  
}); 
/* Delete Expenses Type end */

var cloneCount = 0;
$('.addnew_line').click(function() {
  $(".dpick").datepicker("destroy");      
  
  var $newRow = $('#TemplateRow').clone(true);

  $newRow.find('#date_picker').val('');
  $newRow.find('.dpick').val('');
  $newRow.find('#staff_id').val('');
  $newRow.find('#rel_client_id').val('');
  $newRow.find('#vat_scheme_type').val('');
  $newRow.find('#hrs').val('');
  $newRow.find('#notes').val('');

  var noOfDivs = $('.makeCloneClass').length + 1;
  $newRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
  $newRow.find('input[type="file"]').attr('name', 'attachment'+noOfDivs);
  $newRow.find('input[type="file"]').attr('id', 'attachment'+noOfDivs);
  $newRow.find('input[type="file"]').attr('data-key', noOfDivs);

  $newRow.find('.attachDivPop').attr('id', 'attachDivPop'+noOfDivs);
  $newRow.find('.attachDivPop').html('');

  $newRow.find('.notesPop').attr('id', 'notes'+noOfDivs);
  $newRow.find('.notesPop').attr('value', '');
  $newRow.find('.openNotesPop').attr('data-key', noOfDivs);

  $('#BoxTable tr:last').after($newRow);  
  $('#BoxTable1 tr:last').after($newRow);   
   
  $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});    
  return false;
    
});

$('.DeleteBoxRow').click(function() {
    var size = $(".DeleteBoxRow").size();
    if(size>1){
        $(this).closest('tr').remove();
    }
});

$('.openNotesPop').click(function() {
  var NotesKey = $(this).attr('data-key');
  $('#NotesKey').val(NotesKey);

  var prev_notes = $('#notes'+NotesKey).val();
  $('#notess').val(prev_notes);

  $("#compose-modal").modal("hide");
  $("#composenotes-modal").modal("show");
});

$('body').on('click', '.deleteAttachment', function() {
  var timesheet_id  = $(this).attr('data-timesheet_id');
  
  if (confirm("Do you want to delete attachment file?")) {
    $.ajax({
      type: "POST",
      url: '/timesheet/expense-type-action',
      data: { 'timesheet_id': timesheet_id, 'action':'delete_attachment' },
      success: function(resp) {
        location.reload();
      }
    });
  }
});


$(".attachTableFile").change(function(event) {
  var key = $(this).attr('data-key');
  $("#UpdtAttch"+key).ajaxForm({
    dataType: 'json',
    beforeSend: function() {
      $('#attachTable'+key).html('<img src="/img/spinner.gif" />');
    },
    success: function(resp) {
      var text = '<a href="/uploads/expense_files/'+resp.fileName+'" download><img src="/img/pdficon.png" height="20"></a>';
      text += '<a href="javascript:void(0)" class="deleteAttachment" data-timesheet_id="'+resp.timesheet_id+'" ><img src="/img/cross.png" width="13" ></a>';
      $('#attachTable'+resp.timesheet_id).html(text);
    }
  }).submit();
    
});

/* ================ Task Section =============== */
$("body").on('click', '.addTimeSheet', function(event) {
  var client_id     = $(this).data('client_id');
  var service_id    = $('#service_id').val();
  var filling_date  = $(this).data('filling_date');
  var user_id       = $('#logged_user_id').val();
  var completed_id  = $(this).data('completed_id');

  $('#attachTh').hide();
  $('#attachTd').hide();
  $('#expenseDropRow').hide();
  $('#schemeDropRow').show();
  $('#tasks_client_id').val(client_id);
  $('#rel_client_id').val(client_id);
  $('#dpick1').val(filling_date);
  $('#vat_scheme_type').val(service_id);
  $('#staff_id').val(user_id);
  $('#completed_id').val(completed_id);
  $('#newTimeSheet-modal').modal('show');
  /*$.ajax({
    type : 'POST',
    url : '/jobs/tasks-action',
    data : {'client_id' : client_id, 'service_id':service_id, 'action':'getClientById'},
    beforeSend : function(){
      $('#attachTh').hide();
      $('#attachTd').hide();
      $('#expenseDropRow').hide();
      $('#schemeDropRow').show();
      $('#tasks_client_id').val(client_id);
      $('#rel_client_id').val(client_id);
      $('#dpick1').val(filling_date);
      $('#vat_scheme_type').val(service_id);
    },
    success : function(resp){
      $('#newTimeSheet-modal').modal('show');
    }
  });*/
});

$("#timeSheetSubmit").click(function(event) {
  var client_id     = $('#tasks_client_id').val();
  var completed_id  = $('#completed_id').val();
  $("#timeSheetForm").ajaxForm({
    //dataType: 'json',
    beforeSend: function() {
      $('.show_loader').html('<img src="/img/spinner.gif" />');
    },
    success: function(resp) {
      $('#addTimeSheet'+completed_id).html('<a href="javascript:void(0)" data-client_id="'+client_id+'" data-completed_id="'+completed_id+'" class="viewTimeSheet">Completed</a>');
      $('#modal_body2').hide();
      $('#modal_body1').html('Time sheet completed');
      setTimeout(function(){
        //location.reload();
        refresh_table();
      }, 3000);
      //
    }
  }).submit();
});

$("body").on('click', '.viewTimeSheet', function(event) {
  var client_id   = $(this).attr('data-client_id');
  var service_id  = $('#service_id').val();

  $.ajax({
    type : 'POST',
    dataType :'json',
    url : '/timesheet/expense-type-action',
    data : {'client_id' : client_id, 'service_id':service_id, 'action':'viewTimeSheet'},
    beforeSend : function(){
      $('#viewTimeSheet-modal').modal('show');
      $('#ViewTimesheetTable tbody').html('<tr><td colspan="6" style="text-align:center"><img src="/img/spinner.gif" /></td></tr>');
      //return false;
    },
    success : function(resp){
      var trvalue = '';
      $.each(resp.details, function(key, value){
        trvalue += '<tr>';
        trvalue += '<td>'+value.created_date+'</td>';
        trvalue += '<td>'+value.staff_name+'</td>';
        trvalue += '<td>'+value.client_name+'</td>';
        trvalue += '<td>'+value.scheme_name+'</td>';
        trvalue += '<td>'+value.hrs+'</td>';
        trvalue += '<td><a href="javascript:void(0)" onclick="fontfetchnotesmodal('+"'"+value.notes+"'"+')" data-toggle="modal" data-target="#fontfetchcomposenotes-modal"><span class="notes_btn">Notes</span></a></td>';
      });
      $('#ViewTimesheetTable tbody').html(trvalue);
    }
  });

});




});//end document 


function openModal(timesheet_id, entry_type) {
  $.ajax({
    type: "POST",
    url: '/timesheet/timesheet-templates',
    data: { 'timesheet_id': timesheet_id },
    beforeSend : function(){
        $("#addNewLineBut").hide();
        $("#entry_type").val(entry_type);
    },
    success: function(resp) {
      //$("#compose-edit-modal").modal("show");
      $("#compose-modal").modal("show");
      if(entry_type == 'T'){
        $('#servDiv').html('Service <a href="javascript:void(0)" class="add_to_list openVatSchemeModal">Add/Edit List</a>');
        $('#HeadingDiv').html('EDIT TIME SHEET');
        $('#hrsDiv').html('Hrs');
        $('#expenseDropRow').hide();
        $('#schemeDropRow').show();

        $('#attachTh').hide();
        $('#attachTd').hide();
        $('#vat_scheme_types').val(resp.vat_scheme_type);
      }else{
        $('#servDiv').html('Expense Type <a href="javascript:void(0)" class="add_to_list openExpenseTypeModal">Add/Edit List</a>');
        $('#HeadingDiv').html('EDIT CLIENT EXPENSE RECHARGE');
        $('#hrsDiv').html('£');
        $('#schemeDropRow').hide();
        $('#expenseDropRow').show();

        $('#attachTh').show();
        $('#attachTd').show();
        $('#expense_type').val(resp.vat_scheme_type);
      }

      var dateAr = resp.created_date.split('-');
      var date_string = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];

      $('#dpick1').val(date_string);
      $('#staff_id').val(resp.staff_id);
      $('#rel_client_id').val(resp.rel_client_id);
      
      $('#edit_id').val(resp.timesheet_id);
      $('#hrs').val(resp.hrs);
      $('#notes1').val(resp.notes);

      var text = '';
      if(resp.attachment != ''){
        text += '<a href="/uploads/expense_files/'+resp.attachment+'" download=""><img src="/img/pdficon.png" height="20"></a>';
        text += '<a href="javascript:void(0)" class="deleteAttachment" data-timesheet_id="'+resp.timesheet_id+'"><img src="/img/cross.png" width="13"></a>';
      }
      $('#attachDivPop1').html(text);
    }
  });
}

function notes()
{
    var NotesKey= $("#NotesKey").val();
    var notesval= $("#notess").val();
   
    $('#notes'+NotesKey).val(notesval);
    $("#composenotes-modal").modal("hide");
    $("#compose-modal").modal("show");
}

function fontfetchnotesmodal(fontvalue){
  var fontnotesvalue=fontvalue;
  $("#fontfetchnotess").val(fontnotesvalue);
  $("#fontfetchcomposenotes-modal").modal("show");
}
