$(document).ready(function () {

  $('#wipTable').jtable({
      paging: true,
      sorting: true,
      pageSize: 10,
      defaultSorting: 'created DESC',

      actions: {
        listAction: '/jtable/action?action=wipTable'
      },
      fields: {
        client_id: {
          title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead"></div>',
          width: '0.5%',
          sorting:false,
          display:function(data){
            return '<div class="align_center"><input type="checkbox" class="WipCheckbox" name="wipCheck[]" value="'+data.record.id+'"></div>';
          }
        },
        created: {
          title: 'Date',
          width: '3%',
          //sorting:false,
          display:function(data){
            return data.record.created;
          }
        },
        client_name: {
          title: 'Client Name',
          display:function(data){
            if(data.record.status == 'Allocate Job'){
              return '<a href="javascript:void(0)">'+data.record.client_name+'</a>';
            }else{
              return '<a href="javascript:void(0)" class="tasknamed" data-taskid="'+data.record.id+'">'+data.record.client_name+'</a>';
            }
          }
        },
        service_name: {
          title: 'Service Name',
          display:function(data){
            //return '<a href="javascript:void(0)" class="openViewActivity">'+data.record.service_name+'</a>';
            return data.record.service_name;
          }
        },
        proposal_id: {
          title: 'Proposal ID',
          width: '3%',
          display:function(data){
            return '<div class="align_center">'+data.record.proposal_id+'</div>';
          } 
        },
        staff_name: {
          title: 'Responsible Staff',
          width: '4%',
          display: function(data) {
            return data.record.staff_name;
          }
        },
        comp_date: {
          title: 'Completion Date',
          width: '3%',
          sorting:false,
          display: function(data) {
            return data.record.comp_date;
          }
        },
        amount: {
          title: '<div class="align_center">Amount</div>',
          width: '3%',
          sorting:false,
          display: function(data) {
            return '<div class="align_right">'+data.record.amount+'</div>';
          }
        },
        notes: {
          title: 'Notes',
          width: '2%',
          sorting:false,
          display: function(data) {
            var button = '<a href="javascript:void(0)" class="notes_btn openWipNotesPopup" data-id="'+data.record.id+'">notes</a>';
            //button += '<input type="hidden" id="wipNotes_'+data.record.id+'" value="'+data.record.notes+'">';
            return button;
          }
        },
        status: {
          title: 'Job Status',
          width: '5%',
          //sorting:false,
          display: function(data) {//Allocate job
            var tasknamed = '';
            if(data.record.status == 'Allocate Job'){
              tasknamed = 'tasknamed';
            }
            var text = '<div class="align_center"><button type="button" class="job_send_btn '+tasknamed+'" data-taskid="'+data.record.id+'">'+data.record.status+'</button></div>';
            return text;
          }
        }
      }
  });

  $('#wipSearchButton').click(function (e) {
      e.preventDefault();
      $('#wipTable').jtable('load', { search: $('#wipSearchText').val() });
  });

  $('#wipSearchText').keyup(function (e) {
      e.preventDefault();
      $('#wipTable').jtable('load', { search: $(this).val() });
  });

  $('#wipSearchButton').click();

// check all check box
  $('.CheckHead').click(function (e) {
    if ($(this).is(':checked')) {
      $("input[type=checkbox]").each(function () {
          $(this).prop("checked", true);
      });
    } else {
      $("input[type=checkbox]").each(function () {
          $(this).attr("checked", false);
      });
    }
  });

// delete wip table data 
  $('.deleteWipData').click(function (e) {
    var val = [];
    $(".WipCheckbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    
    //console.log(val);alert(val.length);return false;
    if(val.length>0){
      if(confirm("Do you want to delete?")){
        $.ajax({
          type: "POST",
          url: '/crm/delete-todolist',
          data: { 'ids' : val },
          beforeSend: function() {
            $("#message_div").html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
          },
          success : function(resp){
            $("#message_div").html('');
            $('#wipTable').jtable('load', { search: $('#wipSearchText').val() });
          }
        });
      }
    }else{
      alert('Please select atleast one row');
    }
  });

// notes pop up 
  $("body").on('click', ".openWipNotesPopup", function(){
    var id = $(this).data("id");
    
    $.ajax({
      url: "/proposal/action",
      type: "POST",
      dataType : 'json',
      data : {'id':id, 'action':'getWipNotes' },
      beforeSend : function(){
        $("#wipNotesTextareaTd").html('');
        $("#openWipNotesPopup-modal").modal("show");
        //$("#openWipNotesPopup-modal #wipTableId").val(id);
      },
      success: function (resp) {
        $('#wipNotesTextareaTd').html(resp.notes);
        //$("#wipNotesTextareaTd").html('<textarea class="form-control classy-editor" rows="5" name="wipNotesTextarea" id="wipNotesTextarea">'+resp.notes+'</textarea>');
        //$(".classy-editor").ClassyEdit();
      }
    });
  });


// invoice xero 
  $("body").on('click', ".invoiceXero", function(){
    var val = [];
    $(".WipCheckbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });

    if(val.length>0){
      var ids = val.join();
      if(confirm("Do you want to create invoice?")){
        window.location.href = '/xero/index.php?invoice=1&method=put&page_name=wip&ids='+ids;
        /*url='/xero/index.php?invoice=1&method=put&page_name=wip&ids='+ids;
        newwindow=window.open(url,'name','left=300,top=100,height=500,width=650,scrollbars=1');
        if (window.focus) {newwindow.focus();}
        return false;*/
      }
    }else{
      alert('Please select atleast one row');
    }

  });
  


  
  











});

