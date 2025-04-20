$(document).ready(function(){


$("body").on('click', '.openServicesStaff_1', function(){
  var service_id    = $(this).data('service_id');
  var client_id     = $(this).data('client_id');
  var client_name   = $(this).data('client_name');
  var service_name  = $(this).data('service_name');
  var page  		    = $(this).data('page');
  var client_type 	= $(this).data('client_type');

  if(page == 'tasks' && client_type == 'ind' && service_id == '7'){
    service_id = 10;
  }

  $.ajax({
    type: "POST",
    dataType : 'json',
    url: "/user/get-all-staff-details",
    data: { 'service_id':service_id, 'client_id':client_id },
    beforeSend : function(){
      $('#services_staff-modal').modal('show');
      $('#staff_service_id').val(service_id);
      $('#staff_client_id').val(client_id);
      $("#staff_client_type").val(client_type);
      if(page == 'tasks'){
      	$('#popup_service_name').html(client_name);
      }else{
      	$('#popup_service_name').html(service_name);
      }
      $('#removeTaskCheck').iCheck('check');

      $('.serviceStaffTable tbody').html('<tr><td colspan="5"><div class="loader_class"><img src="/img/spinner.gif" height="25" /></div></td></tr>');
      //return false;
    },
    success: function (resp) {
      var content = "<tr>";
      var option  = '<option value="">None</option>';
      if(resp.allStaff.length > 0){
        $.each(resp.allStaff, function(index, value){
          option += '<option value="'+resp.allStaff[index].user_id+'">'+resp.allStaff[index].fname+' '+resp.allStaff[index].lname+'</option>';
        });
      }
      for(var i=1; i<=5;i++){
        content += '<td><select class="form-control newdropdown save_manual_user" data-column="'+i+'" name="org_staff_id'+i+'" id="org_staff_id'+i+'">'+option+'</select></td>';
      }
      content += '</tr>';
      $('.serviceStaffTable tbody').html(content);
      $('#org_staff_id1').val(resp.allocatedStaff.staff_id1);
      $('#org_staff_id2').val(resp.allocatedStaff.staff_id2);
      $('#org_staff_id3').val(resp.allocatedStaff.staff_id3);
      $('#org_staff_id4').val(resp.allocatedStaff.staff_id4);
      $('#org_staff_id5').val(resp.allocatedStaff.staff_id5);
    }
  });
});

$("body").on("change", ".save_manual_user", function(){
    var client_type = $("#staff_client_type").val();
    var service_id  = $("#staff_service_id").val();
    var client_id   = $("#staff_client_id").val();

    var column      = $(this).data("column");
    var staff_id    = $(this).val();
    var staff_name = $('#org_staff_id'+column+' option:selected').text();

    $.ajax({
		type: "POST",
		url: '/save-manual-staff',
		data: { 'service_id':service_id,'column':column,'client_type':client_type,'staff_id':staff_id,'client_id':client_id },
		success : function(resp){
			putStaffDropdown(service_id, client_id);
		}
  });
});

$('body').on('ifUnchecked', '#removeTaskCheck', function(event){
    var client_type = $(".staff_client_type").val();
    var service_id  = $(".staff_service_id").val();
    var client_id   = $(".staff_client_id").val();

    $.ajax({
    type: "POST",
    url: '/jobs/delete-client-from-tasks',
    data: { 'service_id':service_id,'client_type':client_type,'client_id':client_id },
    success : function(resp){
      $('#hide_client_tr_'+client_id).hide();
      $('#services_staff-modal').modal('hide');
      location.reload();
    }
  });
});




});//document end


function putStaffDropdown(service_id, client_id)
{
  $.ajax({
      type: "POST",
      dataType : 'json',
      url: "/user/get-all-staff-details",
      data: { 'service_id':service_id, 'client_id':client_id },
      beforeSend : function(){
         
      },
      success: function (resp) {
        var option  = '<select class="form-control newdropdown" id="staff_dropdown_'+service_id+'">';
        if(resp.allAllocatedStaff.length > 0){
          $.each(resp.allAllocatedStaff, function(index, value){
            option += '<option value="'+resp.allAllocatedStaff[index].staff_id+'">'+resp.allAllocatedStaff[index].staff_name+'</option>';
          });
        }
        $("."+client_id+"_staff_table_drop_"+service_id).html(option);
      }
    });
}