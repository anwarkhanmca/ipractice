$(document).ready(function(){

  //$(".open_toggle").hide();
  $("#select_icon").click(function(event) {
      $(".open_toggle").toggle();
      event.stopPropagation();
  });
  $("#view_prev_app").click(function(event) {
      $(".open_view_prev").toggle();
      event.stopPropagation();
  });

  $('.show_set_objective').click(function() {
    $(".review_last").hide();
    $(".set_objective").toggle();
  });

  $('.show_review_last').click(function() {
    $(".set_objective").hide();
    $(".review_last").toggle();
  });

  $('.show_identifying').click(function() {
    $(".performance_table").hide();
    $(".identifying_table").toggle();
  });

  $('.show_performance').click(function() {
    $(".identifying_table").hide();
    $(".performance_table").toggle();
  });


  $('#j_selectbox2').attr('disabled','disabled');
  $('#newform').attr('disabled','disabled');
    
  $('.staffdata').change(function(){
    $('#show_form_content').hide();
    var stafval   = $(this).val();
    var data = [];
    data['staff_id']    = stafval;
    data['appraiser1']  = $("#appraiser1").val();
    data['appraiser2']  = $("#appraiser2").val();
//alert(data['appraiser2']);
    addDisabled();
    putAppraisalDetails(data);
  });
    
  $('#newform').click(function() {
    var satffid= $("#staffdropdown").val();

    $('#action').val('add');
    $('#appraisal_id').val('0');
  
    $.ajax({
  	  type: "POST",
      //dataType: "html",
      url: '/getjobforappraisee',
      data: { 'satffid': satffid },
      beforeSend : function(){
        $("#appraisee_title").html("");
        $("#dateofmeeting").val("");
        $("#timeofmeeting").val("");
        $("#appraisee_comment").val("");
        $("#appraiser_comment").val("");
        $("#tab_p2 tbody").html("");
        $("#tab_c2 tbody").html("");
        $("#last_perform_id").val('0');
        $(".open_toggle").hide();
        $('.open_view_prev').hide();

        $("#appraiser1").val("");
        $("#appraiser2").val("");
        $("#appraiser_title1").html("");
        $("#appraiser_title2").html("");
        $("#appraiser1, #appraiser2").removeClass("disable_click");

        gray_out();
      },
      success: function(resp) {
	      if(resp !=""){
          var res = resp.split("|||")
          if(res['0'] !=""){
            //$('#newtarget').html(res['0']);
          }
          if(res['1'] !=""){
            $('#append_task').html(res['1']);
          }
          if(res['2'] !=""){
            //$('#csi2').html(res['2']);
          }
          if(res['3'] !=""){
            $('#append_competencies').html(res['3']);
          }
          if(res['4'] !=""){
            $('#appraisee').html(res['4']);
          }
          if(res['5'] !=""){
            $('#appraisee_title').html(res['5']);
          }
          if(res['6'] !=""){
            $('#appraiser').html(res['6']);
          }
          if(res[''] !=""){
            $('#appraiser_title').html(res['7']);
          }
          if(res['8'] !=""){
            $('#dateofmeeting').val(res['8']);
          }
          if(res['9'] !=""){
            $('#timeofmeeting').val(res['9']);
          }
          if(res['10'] !=""){
            $("#tab_p1 tbody").html(res['10']);
          }
          if(res['11'] !=""){
            $("#tab_c1 tbody").html(res['11']);
          }
          $("#show_form_content").show();
          $("#completion").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
        }
      }
    });
  
  });
  
  /*$(document).on('focus',".dpick", function(){
    $(this).datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true}); 
  });*/

  $('#addline1').click(function() {
  	$(".dpick").datepicker("destroy");      
  	//var $newRow = $('#TemplateRow1').clone(true);

    var $tableBody = $('#BoxTable').find("tbody"),
    $trLast = $tableBody.find("tr:last"),
    $newRow = $trLast.clone();

    $newRow.find('#date_picker').val('');
  	$newRow.find('.dpick').val('');
    $newRow.find('#newtarget').val('');
    $newRow.find('#notes1').val('');
  	$newRow.find('#notes2').val('');
  	var noOfDivs = $('.makeCloneClass1').length + 1;
    //$newRow.find('#completion').attr('id', 'dpick'+ noOfDivs);
    $newRow.find('.date_of_meeting').attr('id', 'dpick'+ noOfDivs);
  	$('#BoxTable tr:last').after($newRow);
  	$(".dpick").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});    
  	return false;
  });

  $("#tab_1").on('click', '.DeleteBoxRow1', function(){
    var target_id  = $(this).data('target_id');
    if(target_id == '0'){
      var size = $(".DeleteBoxRow1").size();
      if(size>1){
        $(this).closest('tr').remove();
      }
    }else{
      $.ajax({
        type : 'POST',
        url : '/sm/ajax-delete-objective',
        data : {'target_id' : target_id, 'action' : 'OT'},
        success : function(resp){
          $(".po_delete_"+target_id).hide();
        }
      });
    }
    
  });
    
  $('#addline2').click(function() {
  	$(".dpick").datepicker("destroy");      
  	//var $newRow = $('#TemplateRow2').clone(true);

    var $tableBody = $('#BoxTable1').find("tbody"),
    $trLast = $tableBody.find("tr:last"),
    $newRow = $trLast.clone();

    $newRow.find('#date_picker').val('');
  	$newRow.find('#csi2').val('');
    $newRow.find('#clr2').val('');
  	$newRow.find('#pcl2').val('');
  	$newRow.find('#ccl2').val('');
  	$newRow.find('#notes3').val('');
    var noOfDivs = $('.makeCloneClass2').length + 1;
    $newRow.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs);
  	$('#BoxTable1 tr:last').after($newRow);
  	$(".dpick").datepicker({dateFormat: 'dd-mm-yy'});    
  	return false;
  });
      
  $("#tab_1").on('click', '.DeleteBoxRow2', function(){
    var skill_id  = $(this).data('skill_id');
    if(skill_id == '0'){
      var size = $(".DeleteBoxRow2").size();
      if(size>1){
        $(this).closest('tr').remove();
      }
    }else{
      $.ajax({
        type : 'POST',
        url : '/sm/ajax-delete-objective',
        data : {'skill_id' : skill_id, 'action' : 'PS'},
        success : function(resp){
          $(".ps_delete_"+skill_id).hide();
        }
      });
    }
    
  });
    
  $("#com").click(function(){
    $("#typedata").val('com');
  });

  $("#per").click(function(){
    $("#typedata").val('per');
  });
    
  $("#savenewtergetobject").click(function(){
    var newtergetobject_name  = $("#newtergetobject").val();
    if($("#typedata").val()!=""){
      var tab_name  = $("#typedata").val();
    }else{
      var tab_name ="com";
    }
    var staffdropdown  = $("#staffdropdown").val();
    
    $.ajax({
      type: "POST",
      url: '/addnewtergetobject',
      data: { 'newtergetobject_name' : newtergetobject_name,'staffdropdown' : staffdropdown,'tab_name':tab_name, },
      success : function(field_id){
        var append = '<div class="form-group" id="hide_task'+field_id+'"><a href="javascript:void(0)" title="Delete Field ?" class="deletetergetobject" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a><label for="'+field_id+'">'+newtergetobject_name+'</label></div>';
        $("#append_task").append(append);
        $("#newtergetobject").val("");
        $("#newtarget").append('<option value="'+field_id+'">'+newtergetobject_name+'</option>');
		    $("#vat_scheme_types").append('<option value="'+field_id+'">'+newtergetobject_name+'</option>');
      }
    });
  });
    
  $("#append_task").on("click", ".deletetergetobject", function(){
    var field_id = $(this).data('field_id');
    //console.log(field_id);return false;
    if (confirm("Do you want to delete this field ?")) {
      $.ajax({
        type: "POST",
        //dataType: "json",
        url: '/deladdnewtergetobject',
        data: { 'field_id' : field_id },
        success : function(resp){//console.log(resp);return false;
          if(resp != ""){
            $("#hide_task"+field_id).hide();
            $("#newtarget option[value='"+field_id+"']").remove();
          }else{
            alert("There are some error to delete , Please try again");
          }
        }
      });
    }
  });

  $("#addcompetencies").click(function(){
    var newtergetobject_name  = $("#textcompetencies").val();
    if($("#typedata").val()!=""){
      var tab_name  = $("#typedata").val();
    }else{
      var tab_name ="com";
    }
    var staffdropdown  = $("#staffdropdown").val();
    $.ajax({
      type: "POST",
      url: '/addnewtergetobject',
      data: { 'newtergetobject_name' : newtergetobject_name,'staffdropdown' : staffdropdown,'tab_name':tab_name, },
      success : function(field_id){
        var append = '<div class="form-group" id="hide_task'+field_id+'"><a href="javascript:void(0)" title="Delete Field ?" class="deletetergetobject" data-field_id="'+field_id+'"><img src="/img/cross.png" width="12"></a><label for="'+field_id+'">'+newtergetobject_name+'</label></div>';
        $("#append_competencies").append(append);
        $("#textcompetencies").val("");
        $("#csi2").append('<option value="'+field_id+'">'+newtergetobject_name+'</option>');
		    $("#vat_scheme_types").append('<option value="'+field_id+'">'+newtergetobject_name+'</option>');
      }
    });
  });
    
  $("#append_competencies").on("click", ".deletetergetobject", function(){
    var field_id = $(this).data('field_id');
    //console.log(field_id);return false;
    if (confirm("Do you want to delete this field ?")) {
      $.ajax({
        type: "POST",
        //dataType: "json",
        url: '/deladdnewtergetobject',
        data: { 'field_id' : field_id },
        success : function(resp){//console.log(resp);return false;
          if(resp != ""){
            $("#hide_task"+field_id).hide();
            $("#csi2 option[value='"+field_id+"']").remove();
          }else{
            alert("There are some error to delete , Please try again");
          }
        }
      });
    }
  });

  $("#tab_1").on('click', '.delete_appraisal',function(){
    var appraisal_id  = $(this).data('appraisal_id');
    var tab_no        = $('#tab_no').val();
    //console.log(field_id);return false;
    if (confirm("Do you want to delete?")) {
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/sm/delete-appraisal',
        data: { 'appraisal_id' : appraisal_id, 'action' : 'D' },
        success : function(resp){
          if(resp.text != ""){
            if(tab_no == '1'){
              $('.vd_'+appraisal_id).hide();
            }else{
              $("."+tab_no+"_hide_appraisal_"+appraisal_id).hide();
            }
          }else{
            alert("There are some error to delete , Please try again");
          }
        }
      });
    }
  });

  $(".change_action").change(function(){
    var appraisal_id  = $(this).data('appraisal_id');
    var action        = $(this).val();
    var tab_no        = $('#tab_no').val();
    //if (confirm("Do you want to delete?")) {
      change_action(appraisal_id, action, tab_no);
    //}
  });

  $("#tab_1").on('click', '.roll_fwd_drop', function(){
    var appraisal_id  = $(this).data('appraisal_id');
    var staff_id      = $(this).data('staff_id');
    var action        = $(this).data('action');
    var page_open     = $('#page_open').val();
    $('#pop_appraisal_id').val(appraisal_id);


    //alert(appraisal_id+'=='+staff_id+'=='+action)
    if(page_open == 'profile'){
      var stafval = $('#staffdropdown').val();
      var data = [];
      data['staff_id']    = stafval;
      data['appraiser1']  = $("#appraiser1").val();
      data['appraiser2']  = $("#appraiser2").val();

      putAppraisalDetails(data);
    }
    
    
    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/sm/ajax-appraisal-details',
      data: { 'appraisal_id' : appraisal_id, 'staff_id' : staff_id, 'action' : action },
      beforeSend : function(){
        $("#show_form_content").show();
      },
      success : function(resp){
        if(action == 'V'){
          var obj_coming    = "";
          var skill_coming  = "";
          var objectives    = "";
          var skills        = "";

          if(resp.p_objectives.length != 0){
            $.each(resp.p_objectives, function(key){
              obj_coming+= "<tr id='TemplateRow1' class='makeCloneClass1 po_delete_"+resp.p_objectives[key].target_id+"'><td>";              
              //obj_coming+= "<a href='javascript:void(0)'><img src='/img/cross_icon.png' width='15' data-target_id='"+resp.p_objectives[key].target_id+"' id='date_picker' class='DeleteBoxRow1'></a>";
              obj_coming+= "</td>";
              obj_coming+= "<td>"+resp.p_objectives[key].task_name+"</td>";
              obj_coming+= "<td>"+resp.p_objectives[key].perform_notes+"</td>";
              obj_coming+= "<td>"+resp.p_objectives[key].measured_notes+"</td>";
              obj_coming+= "<td>"+resp.p_objectives[key].completion_date+"</td></tr>";
            });
          }

          if(resp.p_skills.length != 0){
            $.each(resp.p_skills, function(key){
              skill_coming+= "<tr id='TemplateRow2' class='makeCloneClass2 ps_delete_"+resp.p_skills[key].skill_dev_id+"'><td>";
              //skill_coming+= "<a href='javascript:void(0)''><img src='/img/cross_icon.png' width='15' data-skill_id='"+resp.p_skills[key].skill_dev_id+"' id='date_picker' class='DeleteBoxRow2'></a>";
              skill_coming+= "</td>";
              skill_coming+= "<td>"+resp.p_skills[key].task_name+"</td>";
              skill_coming+= "<td>"+resp.p_skills[key].required_name+"</td>";
              skill_coming+= "<td>"+resp.p_skills[key].previous_name+"</td>";
              skill_coming+= "<td>"+resp.p_skills[key].current_name+"</td>";
              skill_coming+= "<td>"+resp.p_skills[key].supporting_notes+"</td></tr>";
            });
          }
          $("#tab_p1 tbody").html(obj_coming);
          $("#tab_c1 tbody").html(skill_coming);
          //gray_in();
          $("#dateofmeeting").val(resp.details.meeting_date);
          $("#timeofmeeting").val(resp.details.meeting_time);

          $("#appraiser1").val(resp.details.appraiser1);
          $("#appraiser_title1").html(resp.details.appraiser_title1);
          $("#appraiser2").val(resp.details.appraiser2);
          $("#appraiser_title2").html(resp.details.appraiser_title2);

          /* ================ Sign Section Start =================== */
          if(resp.staffSign.staff_name !== undefined){
            var content = 'Signed by '+resp.staffSign.staff_name+' on '+resp.staffSign.date+' at '+resp.staffSign.time;
            $('#staff_sign_text').html(content)
          }
          if(resp.profileSign.staff_name !== undefined){
            var content = 'Signed by '+resp.profileSign.staff_name+' on '+resp.profileSign.date+' at '+resp.profileSign.time;
            $('#profile_sign_text').html(content)
          }
          /* ================ Sign Section End =================== */

        }else{
          var tab1_row = "";
          var tab2_row = "";
          var c_level = "";
          tab1_row +='<tr id="TemplateRow1" class="makeCloneClass1"><td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" data-target_id="0" id="date_picker" class="DeleteBoxRow1"></a></td>';
          tab1_row += '<td><select class="form-control drop_height newdropdown" id="newtarget" name="newtarget[]"><option value="">None</option>';
          if(resp.staff_tasks.length != 0){
            $.each(resp.staff_tasks, function(key){
              if(resp.staff_tasks[key].for_task == 'per'){
                tab1_row+= "<option value='"+resp.staff_tasks[key].stafftasks_id+"'>"+resp.staff_tasks[key].name+"</option>";
              }
            });
          }                    
          tab1_row += '</td><td><input type="text" name="perform_notes[]" id="notes1" class="form-control"></td>';
          tab1_row += '<td><input type="text" name="measured_notes[]" id="notes2" class="form-control"></td>';
          tab1_row += '<td><input type="text" id="completion" name="completion_date[]" class="form-control dpick"></td></tr>';
          $("#tab_p1 tbody").html(tab1_row);

          tab2_row +='<tr id="TemplateRow2" class="makeCloneClass2"><td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" data-skill_id="0" id="date_picker2" class="DeleteBoxRow2"></a></td>';
          tab2_row +='<td><select class="form-control drop_height newdropdown" id="csi2" name="competency_skill[]"><option value="">None</option>';
          if(resp.staff_tasks.length != 0){
            $.each(resp.staff_tasks, function(key){
              if(resp.staff_tasks[key].for_task == 'com'){
                tab2_row+= "<option value='"+resp.staff_tasks[key].stafftasks_id+"'>"+resp.staff_tasks[key].name+"</option>";
              }
            });
          }
          if(resp.CompetencyLevel.length != 0){
            $.each(resp.CompetencyLevel, function(key){
              c_level+= "<option value='"+resp.CompetencyLevel[key].level_id+"'>"+resp.CompetencyLevel[key].name+"</option>";
            });
          }                                                                                                                              
          tab2_row +='</select></td><td><select class="form-control drop_height newdropdown" id="clr2" name="competency_level[]">';
          tab2_row +=c_level;
          tab2_row +='</select></td><td><select class="form-control drop_height newdropdown" id="pcl2" name="prev_competency[]">';
          tab2_row +=c_level;
          tab2_row +='</select></td><td><select class="form-control drop_height newdropdown" id="ccl2" name="cur_competency[]">';
          tab2_row +=c_level;
          tab2_row +='</select></td><td><input type="text" name="supporting_notes[]" class="form-control supporting_notes"></td></tr>';
          $("#tab_c1 tbody").html(tab2_row);
          //$(".addnew_line").removeAttr("disabled");
          //gray_out();
          $("#dateofmeeting").val(resp.details.dateofmeeting);
          $("#timeofmeeting").val(resp.details.timeofmeeting);

          $("#appraiser1").val("");
          $("#appraiser2").val("");
          $("#appraiser_title1").html("");
          $("#appraiser_title2").html("");
          if(page_open == 'staff'){
            $("#profile_sign_text").html('<a href="javascript:void(0)">Sign... </a>');
            $("#staff_sign_text").html('<a href="javascript:void(0)" class="sign_modal" id="appraiser_sign">Sign... </a>');
          }else{
            $("#profile_sign_text").html('<a href="javascript:void(0)" class="sign_modal" id="appraisee_sign">Sign... </a>');
            $("#staff_sign_text").html('<a href="javascript:void(0)">Sign... </a>');
          }


          /* ============= Review of last performance (1,2 tab)=================== */
          if (resp.objectives.length != 0) {
            $.each(resp.objectives, function(key){
              if(resp.objectives[key].last_perform_id == '0'){
                objectives+= "<tr><td>"+resp.objectives[key].task_name+"</td>";
                objectives+= "<td><select class='form-control newdropdown disable_click'><option value='yes'>Yes</option><option value='no'>No</option><option value='partially'>Partially</option></select></td>";
                objectives+= "<td><a href='javascript:void(0)' data-field='supporting_evidence' data-table_id='"+resp.objectives[key].target_id+"' class='notes_btn open_appr_notes disable_click' data-type='O'>Notes</a></td></tr>"
              }
            });
          }
          /* ============= Review of last performance =================== */

          /* ============= Review of last performance (2,2 tab)=================== */
          if (resp.skills.length != 0) {
            $.each(resp.skills, function(key){
              if(resp.skills[key].last_perform_id == '0'){
                skills+= "<tr><td>"+resp.skills[key].task_name+"</td>";
                skills+= "<td><select class='form-control newdropdown disable_click'><option value='1'>Not Applicable</option><option value='2'>Awareness</option><option value='3'>Novice</option><option value='4'>Intermediate</option><option value='5'>Advanced</option></select></td>";
                skills+= "<td><select class='form-control newdropdown disable_click'><option value='1'>Not Applicable</option><option value='2'>Awareness</option><option value='3'>Novice</option><option value='4'>Intermediate</option><option value='5'>Advanced</option></select></td>";
                skills+= "<td><a href='javascript:void(0)' data-field='developed_notes' data-table_id='"+resp.skills[key].skill_dev_id+"' class='notes_btn open_appr_notes disable_click' data-type='S'>Notes</a></td>";
                skills+= "<td><a href='javascript:void(0)' data-field='supporting_notes' data-table_id='"+resp.skills[key].skill_dev_id+"' class='notes_btn open_appr_notes disable_click' data-type='S'>Notes</a></td></tr>"
              }
            });
          }
          /* ============= Review of last performance (2,2 tab)=================== */
          

        }

        //alert('resp.details.appraisee');
        /* ============= Review of last performance (1,2 tab)=================== */
          if (resp.objectives.length != 0) {
            $.each(resp.objectives, function(key){
              if(resp.objectives[key].last_perform_id != '0'){
                objectives+= "<tr><td>"+resp.objectives[key].task_name+"</td>";
                objectives+= "<td><select class='form-control newdropdown disable_click'><option value='yes'>Yes</option><option value='no'>No</option><option value='partially'>Partially</option></select></td>";
                objectives+= "<td><a href='javascript:void(0)' data-field='supporting_evidence' data-table_id='"+resp.objectives[key].target_id+"' class='notes_btn open_appr_notes disable_click' data-type='O'>Notes</a></td></tr>"
              }
            });
          }
          /* ============= Review of last performance =================== */

          /* ============= Review of last performance (2,2 tab)=================== */
          if (resp.skills.length != 0) {
            $.each(resp.skills, function(key){
              if(resp.skills[key].last_perform_id != '0'){
                skills+= "<tr><td>"+resp.skills[key].task_name+"</td>";
                skills+= "<td><select class='form-control newdropdown disable_click'><option value='1'>Not Applicable</option><option value='2'>Awareness</option><option value='3'>Novice</option><option value='4'>Intermediate</option><option value='5'>Advanced</option></select></td>";
                skills+= "<td><select class='form-control newdropdown disable_click'><option value='1'>Not Applicable</option><option value='2'>Awareness</option><option value='3'>Novice</option><option value='4'>Intermediate</option><option value='5'>Advanced</option></select></td>";
                skills+= "<td><a href='javascript:void(0)' data-field='developed_notes' data-table_id='"+resp.skills[key].skill_dev_id+"' class='notes_btn open_appr_notes disable_click' data-type='S'>Notes</a></td>";
                skills+= "<td><a href='javascript:void(0)' data-field='supporting_notes' data-table_id='"+resp.skills[key].skill_dev_id+"' class='notes_btn open_appr_notes disable_click' data-type='S'>Notes</a></td></tr>"
              }
            });
          }
          /* ============= Review of last performance (2,2 tab)=================== */


        $("#appraisee").html(resp.details.appraisee);
        $("#appraisee_title").html(resp.details.appraisee_title);
        

        $("#last_perform_id").val(resp.details.appraisal_id);

        $("#appraisee_comment").val(resp.details.appraisee_comment);
        $("#appraiser_comment").val(resp.details.appraiser_comment);

        $("#tab_p2 tbody").html(objectives);
        $("#tab_c2 tbody").html(skills);

        $("#completion").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
        
        if(action == 'V'){
          $('.open_toggle').hide();
          gray_in();
        }else{
          $('.open_view_prev').hide();
          gray_out();
        }
      }
    });
  });

  $("#tab_1").on('click', '.open_appr_notes', function(){
    var field_name  = $(this).data('field');
    var table_id    = $(this).data('table_id');
    var type        = $(this).data('type');

    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/sm/get-appraisal-notes',
      data: { 'field_name' : field_name, 'table_id' : table_id, 'type' : type },
      beforeSend : function(){
        $("#field_name").val(field_name);
        $("#table_id").val(table_id);
        $("#type").val(type);
      },
      success : function(resp){
        if(field_name == 'supporting_evidence'){
          $("#notes").val(resp.supporting_evidence);
        }else if(field_name == 'developed_notes'){
          $("#notes").val(resp.developed_notes);
        }else{
          $("#notes").val(resp.supporting_notes);
        }
        
        $("#notes-modal").modal('show');
      }
    });
  });

  $(".save_notes").click(function(){
    var field_name  = $("#field_name").val();
    var table_id    = $("#table_id").val();
    var type        = $("#type").val();
    var text        = $("#notes").val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/sm/save-appraisal-notes',
      data: { 'field_name' : field_name, 'table_id' : table_id, 'type' : type, 'text' : text },
      beforeSend : function(){
        $(".loader_class").html('<img src="/img/spinner.gif" height="25" />');
      },
      success : function(resp){
        $(".loader_class").html('');
        $("#notes-modal").modal('hide');
      }
    });
  });

  $('.getJobTitle').change(function(){
      var stafval     = $("#staffdata").val();
      var appraiser1  = $("#appraiser1").val();
      var appraiser2  = $("#appraiser2").val();

      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/sm/get-previous-roll',
        data: { 'staff_id':stafval, 'appraiser1':appraiser1, 'appraiser2':appraiser2 },
        success: function(resp) {
          $("#appraiser_title1").html(resp.appraiser_title1);
          $("#appraiser_title2").html(resp.appraiser_title2);
        }
      });
  });

  $('body').on('click', '.sign_modal', function(){
    var page_open = $('#page_open').val();
    if(page_open == 'staff'){
      var stafval   = $("#staffdata").val();
    }else{
      var stafval   = $("#staffdropdown").val();
    }
    var appraiser1  = $("#appraiser1").val();
    var appraiser2  = $("#appraiser2").val();

    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/sm/get-previous-roll',
      data: { 'staff_id':stafval, 'appraiser1':appraiser1, 'appraiser2':appraiser2 },
      beforeSend : function(){
        $('.apprse_name').html('');
        $('.clickName').html('');
        $('#sign-modal').modal('show');
      },
      success: function(resp) {
        if(page_open == 'staff'){
          var name = resp.appraisee;
          var clickName = resp.logged_appr_name;
        }else{
          var name = 'my';
          var clickName = resp.appraisee;
        }
        $('.apprse_name').html(name);
        $('.clickName').html(clickName);
        $('.meetpopupdate').html(resp.dateofmeeting)
        
      }
    });

  });

  $('#add_sigature').click(function(){
    var hiddenclient = $('#page_type').val();
    //alert(hiddenclient);
    $("#signPop").ajaxForm({
        dataType: 'json',
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function(resp) {
          if(resp.last_id > 0){
            $('#sign-modal').modal('hide');
            var content = 'Signed by '+resp.staff_name+' on '+resp.date+' at '+resp.time;
            $('#'+hiddenclient+'_sign_text').html(content);
            $('#staff_sign_id').val(resp.last_id);
          }else{
            $(".show_loader").html('<span style="color:red">Address exists please select from drop down</span>');
          }
          
        }
      }).submit();
  });

  /*$('#openEditAppraisal').click(function(){
    gray_out();
    var newRow = $('#11addNew tbody').html();//alert(newRow);
    $('#action').val('edit');
    $('#appraisal_id').val($('#pop_appraisal_id').val());



    $(".dpick").datepicker("destroy");      
    var $newRow = $('#11addNew #TemplateRow1').clone(true);
    $newRow.find('#date_picker').val('');
    $newRow.find('.dpick').val('');
    $newRow.find('#newtarget').val('');
    $newRow.find('#notes1').val('');
    $newRow.find('#notes2').val('');
    var noOfDivs = $('.makeCloneClass1').length + 1;
    $newRow.find('#completion').attr('id', 'dpick'+ noOfDivs);
    $('#BoxTable tbody tr:last').after($newRow);
    $(".dpick").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});    
    //return false;



    var $newRow1 = $('#21addNew #TemplateRow2').clone(true);

    $newRow1.find('#date_picker').val('');
    $newRow1.find('#csi2').val('');
    $newRow1.find('#clr2').val('');
    $newRow1.find('#pcl2').val('');
    $newRow1.find('#ccl2').val('');
    $newRow1.find('#notes3').val('');
    var noOfDivs1 = $('.makeCloneClass2').length + 1;
    $newRow1.find('input[type="text"]').attr('id', 'dpick'+ noOfDivs1);
    $('#BoxTable1 tbody tr:last').after($newRow1);
    $(".dpick").datepicker({dateFormat: 'dd-mm-yy'});  


    //$('#BoxTable tbody tr:last').after(newRow);

  });*/

  $('#openEditAppraisal').click(function(){
    $('#action').val('edit');
    
    var appraisal_id  = $('#pop_appraisal_id').val();
    $('#appraisal_id').val(appraisal_id);
    var staff_id      = $('#staffdata').val();
  
    var action        = $(this).data('action');
    var page_open     = $('#page_open').val();
    
    
    $.ajax({
      type: "POST",
      dataType: "json",
      url: '/sm/ajax-appraisal-details',
      data: { 'appraisal_id' : appraisal_id, 'staff_id' : staff_id, 'action' : action },
      beforeSend : function(){
        $("#show_form_content").show();

        gray_out();
      },
      success : function(resp){
        var obj_coming = "";
          var skill_coming = "";
          if(resp.p_objectives.length != 0){
            $.each(resp.p_objectives, function(key){
              obj_coming+= "<tr id='TemplateRow1' class='makeCloneClass1 po_delete_"+resp.p_objectives[key].target_id+"'><td>";              
              
              obj_coming+= "<a href='javascript:void(0)'><img src='/img/cross_icon.png' width='15' data-target_id='"+resp.p_objectives[key].target_id+"' id='date_picker' class='DeleteBoxRow1'></a>";
              
              obj_coming+= "</td>";
              obj_coming+= "<td>"+resp.p_objectives[key].task_name+"</td>";
              obj_coming+= "<td>"+resp.p_objectives[key].perform_notes+"</td>";
              obj_coming+= "<td>"+resp.p_objectives[key].measured_notes+"</td>";
              obj_coming+= "<td>"+resp.p_objectives[key].completion_date+"</td></tr>";
            });
          }
          $("#tab_p1 tbody").html(obj_coming);

          var tab1_row = "";
          var tab2_row = "";
          var c_level = "";
          tab1_row +='<tr id="TemplateRow1" class="makeCloneClass1"><td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" data-target_id="0" id="date_picker" class="DeleteBoxRow1"></a></td>';
          tab1_row += '<td><select class="form-control drop_height newdropdown" id="newtarget" name="newtarget[]"><option value="">None</option>';
          if(resp.staff_tasks.length != 0){
            $.each(resp.staff_tasks, function(key){
              if(resp.staff_tasks[key].for_task == 'per'){
                tab1_row+= "<option value='"+resp.staff_tasks[key].stafftasks_id+"'>"+resp.staff_tasks[key].name+"</option>";
              }
            });
          }                    
          tab1_row += '</td><td><input type="text" name="perform_notes[]" id="notes1" class="form-control"></td>';
          tab1_row += '<td><input type="text" name="measured_notes[]" id="notes2" class="form-control"></td>';
          tab1_row += '<td><input type="text" id="completion" name="completion_date[]" class="form-control dpick"></td></tr>';
          //$("#tab_p1 tbody").html(tab1_row);
          $('#tab_p1 tbody tr:last').after(tab1_row);

          
          if(resp.p_skills.length != 0){
            $.each(resp.p_skills, function(key){
              skill_coming+= "<tr id='TemplateRow2' class='makeCloneClass2 ps_delete_"+resp.p_skills[key].skill_dev_id+"'><td>";
              skill_coming+= "<a href='javascript:void(0)''><img src='/img/cross_icon.png' width='15' data-skill_id='"+resp.p_skills[key].skill_dev_id+"' id='date_picker' class='DeleteBoxRow2'></a>";
              skill_coming+= "</td>";
              skill_coming+= "<td>"+resp.p_skills[key].task_name+"</td>";
              skill_coming+= "<td>"+resp.p_skills[key].required_name+"</td>";
              skill_coming+= "<td>"+resp.p_skills[key].previous_name+"</td>";
              skill_coming+= "<td>"+resp.p_skills[key].current_name+"</td>";
              skill_coming+= "<td>"+resp.p_skills[key].supporting_notes+"</td></tr>";
            });
          }
          $("#tab_c1 tbody").html(skill_coming);

          tab2_row +='<tr id="TemplateRow2" class="makeCloneClass2"><td><a href="javascript:void(0)"><img src="/img/cross_icon.png" width="15" data-skill_id="0" id="date_picker2" class="DeleteBoxRow2"></a></td>';
          tab2_row +='<td><select class="form-control drop_height newdropdown" id="csi2" name="competency_skill[]"><option value="">None</option>';
          if(resp.staff_tasks.length != 0){
            $.each(resp.staff_tasks, function(key){
              if(resp.staff_tasks[key].for_task == 'com'){
                tab2_row+= "<option value='"+resp.staff_tasks[key].stafftasks_id+"'>"+resp.staff_tasks[key].name+"</option>";
              }
            });
          }
          if(resp.CompetencyLevel.length != 0){
            $.each(resp.CompetencyLevel, function(key){
              c_level+= "<option value='"+resp.CompetencyLevel[key].level_id+"'>"+resp.CompetencyLevel[key].name+"</option>";
            });
          }                                                                                                                              
          tab2_row +='</select></td><td><select class="form-control drop_height newdropdown" id="clr2" name="competency_level[]">';
          tab2_row +=c_level;
          tab2_row +='</select></td><td><select class="form-control drop_height newdropdown" id="pcl2" name="prev_competency[]">';
          tab2_row +=c_level;
          tab2_row +='</select></td><td><select class="form-control drop_height newdropdown" id="ccl2" name="cur_competency[]">';
          tab2_row +=c_level;
          tab2_row +='</select></td><td><input type="text" name="supporting_notes[]" class="form-control supporting_notes"></td></tr>';
          $("#tab_c1 tbody tr:last").after(tab2_row);



          //gray_in();
          $("#dateofmeeting").val(resp.details.meeting_date);
          $("#timeofmeeting").val(resp.details.meeting_time);

          $("#appraiser1").val(resp.details.appraiser1);
          $("#appraiser_title1").html(resp.details.appraiser_title1);
          $("#appraiser2").val(resp.details.appraiser2);
          $("#appraiser_title2").html(resp.details.appraiser_title2);

          /* ================ Sign Section Start =================== */
          if(resp.staffSign.staff_name !== undefined){
            var content = 'Signed by '+resp.staffSign.staff_name+' on '+resp.staffSign.date+' at '+resp.staffSign.time;
            $('#staff_sign_text').html(content)
          }
          if(resp.profileSign.staff_name !== undefined){
            var content = 'Signed by '+resp.profileSign.staff_name+' on '+resp.profileSign.date+' at '+resp.profileSign.time;
            $('#profile_sign_text').html(content)
          }


        //alert('resp.details.appraisee');

          $("#appraisee").html(resp.details.appraisee);
          $("#appraisee_title").html(resp.details.appraisee_title);
          

          $("#last_perform_id").val(resp.details.appraisal_id);

          $("#appraisee_comment").val(resp.details.appraisee_comment);
          $("#appraiser_comment").val(resp.details.appraiser_comment);

          
          var objectives = "";
          var skills = "";
          if (resp.objectives.length != 0) {
            $.each(resp.objectives, function(key){
              objectives+= "<tr><td>"+resp.objectives[key].task_name+"</td>";
              objectives+= "<td><select class='form-control newdropdown'><option value='yes'>Yes</option><option value='no'>No</option><option value='partially'>Partially</option></select></td>";
              objectives+= "<td><a href='javascript:void(0)' data-field='supporting_evidence' data-table_id='"+resp.objectives[key].target_id+"' class='notes_btn open_appr_notes' data-type='O'>Notes</a></td></tr>"
            });
          }
          if (resp.skills.length != 0) {
            $.each(resp.skills, function(key){
              skills+= "<tr><td>"+resp.skills[key].task_name+"</td>";
              skills+= "<td><select class='form-control newdropdown'><option value='1'>Not Applicable</option><option value='2'>Awareness</option><option value='3'>Novice</option><option value='4'>Intermediate</option><option value='5'>Advanced</option></select></td>";
              skills+= "<td><select class='form-control newdropdown'><option value='1'>Not Applicable</option><option value='2'>Awareness</option><option value='3'>Novice</option><option value='4'>Intermediate</option><option value='5'>Advanced</option></select></td>";
              skills+= "<td><a href='javascript:void(0)' data-field='developed_notes' data-table_id='"+resp.skills[key].skill_dev_id+"' class='notes_btn open_appr_notes' data-type='S'>Notes</a></td>";
              skills+= "<td><a href='javascript:void(0)' data-field='supporting_notes' data-table_id='"+resp.skills[key].skill_dev_id+"' class='notes_btn open_appr_notes' data-type='S'>Notes</a></td></tr>"
            });
          }
          $("#tab_p2 tbody").html(objectives);
          $("#tab_c2 tbody").html(skills);

          $("#completion").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
        
      }
    });
  });


  $('#updateForm').click(function(){
    removeDisabled();
  });


  




});//end main document

function addDisabled()
{
  $('.open_toggle').hide();
  $('.open_view_prev').hide();
  $('#select_icon').addClass('disable_click');
  $('#view_prev_app').addClass('disable_click');
  $('#newform').attr('disabled', 'disabled');
}

function removeDisabled()
{
  $('#select_icon').removeClass('disable_click');
  $('#view_prev_app').removeClass('disable_click');
  $('#newform').removeAttr('disabled');
}

function change_action(appraisal_id, action, tab_no)
{
  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/sm/delete-appraisal',
    data: { 'appraisal_id' : appraisal_id, 'action' : action },
    success : function(resp){
      if(resp.text != ""){
        $("."+tab_no+"_hide_appraisal_"+appraisal_id).hide();
      }else{
        alert("There are some error to delete , Please try again");
      }
    }
  });
}

function gray_in(){
  $(".addnew_line").hide();
  //$(".download_btn").attr("disabled", "disabled");
  $(".small_right").hide();
  $("#openEditAppraisal").show();

  $("#appraisee_comment").attr("disabled", "disabled");
  $("#appraiser_comment").attr("disabled", "disabled");
  $("#dateofmeeting").attr("disabled", "disabled");
  $("#timeofmeeting").attr("disabled", "disabled");
  $("#appre_sign").attr("disabled", "disabled");
  $("#appr_sign").attr("disabled", "disabled");
  $(".save_t").attr("disabled", "disabled");
  $(".save_t2").attr("disabled", "disabled");
  $("#textcompetencies").attr("disabled", "disabled");
  $("#newtergetobject").attr("disabled", "disabled");
  $("#notes").attr("disabled", "disabled");
  $(".save_notes").attr("disabled", "disabled");
  $(".newdropdown").attr("disabled", "disabled");
  $("#appraiser1, #appraiser2").addClass("disable_click");
}

function gray_out(){
  $(".addnew_line").show();
  //$(".download_btn").removeAttr("disabled");
  $("#openEditAppraisal").hide();
  $(".small_right").show();
  $("#appraisee_comment").removeAttr("disabled");
  $("#appraiser_comment").removeAttr("disabled");
  $("#dateofmeeting").removeAttr("disabled");
  $("#timeofmeeting").removeAttr("disabled");
  $("#appre_sign").removeAttr("disabled");
  $("#appr_sign").removeAttr("disabled");
  $(".save_t").removeAttr("disabled");
  $(".save_t2").removeAttr("disabled");
  $("#textcompetencies").removeAttr("disabled");
  $("#newtergetobject").removeAttr("disabled");
  $("#notes").removeAttr("disabled");
  $(".save_notes").removeAttr("disabled");
  $(".newdropdown").removeAttr("disabled");
  $("#appraiser1, #appraiser2").removeClass("disable_click");
} 

function putAppraisalDetails(stafIds)
{
    var stafval = stafIds['staff_id'];
    var appraiser1 = stafIds['appraiser1'];
    var appraiser2 = stafIds['appraiser2'];


    $("#staffdropdown").val(stafval);
    var satff_name = $('#staffdata option:selected').text();
    $("#appraisee").html(satff_name);

    var page_open = $('#page_open').val();
      
    if(stafval != ''){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: '/sm/get-previous-roll',
        data: { 'staff_id':stafval, 'appraiser1':appraiser1, 'appraiser2':appraiser2 },
        beforeSend : function(){
          refreshForm();
        },
        success: function(resp) {
          var content   = "";
          var view_prev = "";
          if (resp.previous_roll.length != 0) {
            $.each(resp.previous_roll, function(key){
              var del_icon = "";
              if(page_open == 'staff'){
                del_icon = "<a href='javascript:void(0)' class='delete_appraisal' data-appraisal_id='"+resp.previous_roll[key].appraisal_id+"'><img src='/img/cross.png' height='13'></a>";
              }
              content+= "<li><a href='javascript:void(0)' data-action='E' class='roll_fwd_drop' data-staff_id='"+resp.previous_roll[key].staff_id+"' data-appraisal_id='"+resp.previous_roll[key].appraisal_id+"'>"+resp.previous_roll[key].staff_name+"</a> - "+resp.previous_roll[key].meeting_date+" "+resp.previous_roll[key].meeting_time+"</li>";
              view_prev+= "<li class='vd_"+resp.previous_roll[key].appraisal_id+"'>"+del_icon+" <a href='javascript:void(0)' data-action='V' class='roll_fwd_drop' data-staff_id='"+resp.previous_roll[key].staff_id+"' data-appraisal_id='"+resp.previous_roll[key].appraisal_id+"'>"+resp.previous_roll[key].staff_name+"</a> - "+resp.previous_roll[key].meeting_date+" "+resp.previous_roll[key].meeting_time+"</li>";
            });
          }
          $("#open_toggle_ul").html(content);
          $("#open_view_prev").html(view_prev);

          $("#appraisee").html(resp.appraisee);
          $("#appraisee_title").html(resp.appraisee_title);
          //alert(resp.appraiser1)
          //$("#appraiser1").val(resp.appraiser1);
          $("#appraiser_title1").html(resp.appraiser_title1);
          //$("#appraiser2").val(resp.appraiser2);
          $("#appraiser_title2").html(resp.appraiser_title2);

          $("#dateofmeeting").val(resp.dateofmeeting);
          $("#timeofmeeting").val(resp.timeofmeeting);

          //$('#rollforwad').removeAttr('disabled');
          //$('#newform').removeAttr('disabled');
        }
      });        
    }else{
      $('#j_selectbox2').attr('disabled','disabled');
      $('#newform').attr('disabled','disabled');
    }
}

function refreshForm(){
  //window.location.reload();
  $('#BoxTable tbody').children( 'tr:not(:first)' ).remove();
  $('#BoxTable1 tbody').children( 'tr:not(:first)' ).remove();
  $('#completion, #newtarget, #notes1, #notes2').val('');

  $('#csi2, .supporting_notes, #appraisee_comment, #appraiser_comment').val('');
  $('#clr2, #pcl2, #ccl2').val('1');
  $('#staff_sign_text').html('<a href="javascript:void(0)" class="sign_modal" id="appraiser_sign">Sign... </a>');

  $('#tab_c2, #tab_p2').html('');

  gray_out();

}