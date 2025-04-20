$(document).ready(function(){
  $('.toUpperCase').keyup(function() {
    $(this).val($(this).val().toUpperCase());
  });

  $("#proposal_logo").change(function() {
    var file = this.files[0];
    var imagefile = file.type;
    var match= ["image/jpeg","image/png","image/jpg"];
    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
    {
      $("#error_image_type").html("Please Select A valid Image File. Only jpeg, jpg and png Images type allowed");
      return false;
    }
    else
    {
      var reader = new FileReader();
      reader.onload = imageIsLoaded;
      reader.readAsDataURL(this.files[0]);
    }
  });



  $('.useColor').click(function(){
    var postData = [];
    postData['type']      = $(this).data('type');
    postData['use_color'] = $(this).data('use_color');
    if(postData['type'] == 'auto_use'){
      postData['color']     = $('#colorAreaA').val();
    }else{
      postData['color']     = $('#menuColor').val();
    }
    changeColor( postData );
  });

  $('.menuColor').on('change', function(){
    var postData = [];
    postData['color']     = $(this).val();
    postData['type']      = $(this).data('type');
    changeColor( postData )
  });

  $('#colorTable .selectRadioColor').on('ifChecked', function(event){
    var postData = [];
    postData['type']      = 'auto_use';
    postData['use_color'] = 'A';
    postData['color']     = $(this).val();
    $('#colorAreaA').val(postData['color']);
    changeColor( postData );
  });

  $('body').on('click', '.selectRadioColor', function(event){
    var postData = [];
    postData['type']      = 'auto_use';
    postData['use_color'] = 'A';
    postData['color']     = $(this).val();
    $('#colorAreaA').val(postData['color']);
    changeColor( postData );
  });

  $('body').on('click', '#UploadProcess', function(){
    var added_from = $('#added_from').val();

    $("#CrmLogoForm").ajaxForm({
      //dataType: 'json',
      //data : {'crm_proptbl_id':crm_proptbl_id},
      beforeSend : function(){
        $('.show_loader').html('<img src="/img/spinner.gif" />');
        $("#colorTable tbody").html('<tr><td colspan="5"><div class="show_loader"><img src="/img/spinner.gif" /></div></td></tr>');
        $('#viewDemoProposal').html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
      },
      success: function(resp) {
        var data = resp.split('anwar');
        console.log(data[3])
        if(added_from == 'practice'){
          $('.show_loader').html('');
          $('#hidd_practice_logo').val(data[2]);
          $('.content-header .logo_con').html('<img src="/colorextract/images/'+data[2]+'" class="browse_img" width="150" />');
          $('#imgFile').val('');
          $('.LogoActionLi').html('<button type="button" title="Delete Logo?" data-logo_name="'+data[2]+'" id="delete_practice_logo">Delete Logo</button>');
          //location.reload();
        }else{
          
          $('#colorTable').html('');
          $('#colorTable').html(data[0]);
          $('#colorAreaA').val(data[1]);
          /* =============================== */
          var postData = [];
          postData['type']      = 'auto_use';
          postData['use_color'] = 'A';
          postData['color']     = data[1];
          changeColor( postData );
        }
      }
    }).submit();
  });

  $("#delete_branding_logo").click(function(){
    var logo_name = $(this).attr('data-logo_name');
    if(confirm("Do you want to delete this logo?")){
      $.ajax({
        type : "POST",
        dataType: 'json',
        url: "/settings/action",
        data: {'logo_name':logo_name, 'action':'deleteBrandingLogo' },
        beforeSend : function(){
          $('.deleteLoader').html('<img src="/img/spinner.gif" />');
        },
        success : function(resp){
          if(resp.success == 1){
            //$('.content-header .logo_con').html('');
            //$('#hidd_practice_logo').val('');
            //$('.LogoActionLi').html('<button type="button" title="Upload Logo?" id="UploadProcess">Upload</button>');
            location.reload();
          }
        }
      })
    }
  });




  

  $('#tandc_file').on('change', function(){
    $("#tcFileUploadForm").ajaxForm({
      dataType: 'json',
      data : {'action' : 'tcFileUpload'},
      success: function(resp) {
        location.reload();
      }
    }).submit();
  });

  $(".terms_file_preview").click(function(e){
    e.preventDefault();
    var file = '/uploads/tc_files/'+$(this).data('file');
    $("#attach_iframe").attr("src",file);
    $("#preview_attach").modal('show');
  });

  $("#terms_edit").click(function(e){
    e.preventDefault();
    $(".termsExists").hide();
    $(".termsNotExists").show();
  });

  $('#terms_save').on('click', function(){
    var description = CKEDITOR.instances['terms_description'].getData();
    $.ajax({
      url: "/proposal/action",
      type: "POST",
      dataType : 'json',
      data : {'description' : description, 'action' : 'tcFileUpload'},
      beforeSend: function() {
        $('.show_loader').html('<img src="/img/spinner.gif" />');
      },
      success: function (resp) {
        $('.show_loader').html('');
        $(".termsNotExists").hide();
        $(".termsExists").show();

        var content = '<div class="col-md-12" style="margin-bottom: 10px; border-bottom: 1px solid #ccc;">';
            content += '<a href="javascript:void(0)" id="termsHeader">Updated by '+resp.user_name+' On '+resp.added_date+'</a>';
            content += '</div>';
            content += '<div class="col-md-12" id="trmsDescDiv">';
            content += resp.description;
            content += '</div>';
            content += '<div class="clearfix"></div>';
        $("#termsExists").html(content);
      }
    });
  });

  $(".pNewLetterTemplate").click(function(e){
    $("#pnTempTitle").val('');
    CKEDITOR.instances.pnTempDesc.setData('');
    $(".editpnTempPop").hide();
    $(".savepnTempPop").show();
    $("#pNewLetterTemplate-modal").modal('show');
  });

  $(".savepnTempPop").click(function(e){
    var desc        = CKEDITOR.instances.pnTempDesc.getData();
    var template_id = $('#pNewLetterTemplate-modal #pNewLetterId').val();
    var title       = $('#pNewLetterTemplate-modal #pnTempTitle').val();
    if(title == ''){
      alert('Please enter letter title.');
      return false;
    }

    $("#pNewLetterTemplateForm").ajaxForm({
      dataType: 'json',
      data : {'desc':desc},
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
      },
      success: function(resp) {
        $(".show_loader").html('');
        var template = resp.template;
        if(template_id > 0){
          $('#tab_4341 table tbody .ptempTr_'+template_id+' td:nth-child(3)').html(template.title);
        }else{
          var content = '';
          content +=  '<tr class="ptempTr_'+template.template_id+'">';
          content +=  '<td>'+template.created+'</td><td>'+template.user_name+'</td><td>'+template.title+'</td>';
          content +=  '<td><div class="btn-group">';
          content +=  '<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">';
          content +=  '<i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
          content +=  '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
          content +=  '<li><a href="javascript:void(0)" data-template_id="'+template.template_id+'" class="viewTemp"><i class="fa fa-files-o"></i>View</a></li>';
          content +=  '<li><a href="javascript:void(0)" data-template_id="'+template.template_id+'" class="deleteTemp"><i class="fa fa-trash-o"></i>Delete</a></li>';
          content +=  '</ul></div></td></tr>';
          $('#tab_4341 table tbody').append(content);
        }

        $('#pNewLetterTemplate-modal').modal('hide');
        
      }
    }).submit();
  });

  $("body").on('click', "#tab_4341 .deleteTemp", function(e){
    var template_id = $(this).attr('data-template_id');
    if(!confirm('Do you want to delete?')){
      return false;
    }
    $.ajax({
      url: "/settings/action",
      type: "POST",
      dataType : 'json',
      data : {'template_id' : template_id, 'action' : 'deleteTemp'},
      success: function (resp) {
        $('#tab_4341 table tbody .ptempTr_'+template_id).hide();
      }
    });
  });

  $("body").on('click', "#tab_4341 .viewTemp", function(e){
    var template_id = $(this).attr('data-template_id');
    var type = 'template';
    $.ajax({
      url: "/settings/action",
      type: "POST",
      dataType : 'json',
      data : {'table_id' : template_id, 'type' : type, 'action' : 'getProposalTemplate'},
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
        $(".savepnTempPop").hide();
        $(".editpnTempPop").show();
        $("#pNewLetterTemplate-modal").modal('show');
        $('#pNewLetterTemplate-modal #pnTempTitle').attr('readonly', 'readonly');
        $('#pNewLetterTemplate-modal #pnTempPlaceDrop').attr('disabled', 'disabled');
        CKEDITOR.instances['pnTempDesc'].setReadOnly(true);

      },
      success: function (resp) {
        $(".show_loader").html('');
        var data = resp.template;
        $('#pNewLetterTemplate-modal #pNewLetterId').val(data.template_id);
        $('#pNewLetterTemplate-modal #pnTempTitle').val(data.title);
        CKEDITOR.instances.pnTempDesc.setData(data.desc);
      }
    });
  });

  $(".editpnTempPop").click(function(e){
    $(".editpnTempPop").hide();
    $(".savepnTempPop").show();
    $('#pNewLetterTemplate-modal #pnTempTitle').attr('readonly', false);
    $('#pNewLetterTemplate-modal #pnTempPlaceDrop').attr('disabled', false);
    CKEDITOR.instances['pnTempDesc'].setReadOnly(false);
  });

  $('body').on('click', '.deleteServicesSet', function(e){
    var service_id    = $(this).attr('data-service_id');
    var column_name   = $(this).attr('data-column_name');
    var table_name    = $(this).attr('data-table_name');
    var update_value  = $(this).attr('data-update_value');
    var action        = $(this).attr('data-action');

    var postData = [];
    postData['column_name']   = column_name;
    postData['column_value']  = service_id;
    postData['table_name']    = table_name;
    postData['update_value']  = update_value;

    if(action == 'unarchive'){
      postData['event']       = 'unarchive';
      archiveProposalItems(postData);
      return false;
    }else{
      $.ajax({
        url: "/settings/action",
        type: "POST",
        dataType : 'json',
        data : {'service_id':service_id, 'action':'checkServiceInProposal'},
        beforeSend : function(){

        },
        success: function (resp) {
          if(resp.count >= 1){
            if(confirm(" This service cannot be deleted because it is associated with a proposal so it will be archived")){
              postData['event'] = 'archive';
              archiveProposalItems(postData);
            }
          }else{
            postData['event']   = 'delete';
            if(confirm('Do you want to delete?')){
              archiveProposalItems(postData);
            }
          }
          
        }
      });
    }
  });


  $('body').on('change', '.actArchiveCheck', function(event){
    var postData = [];
    postData['column_name']   = 'activity_id';
    postData['column_value']  = $(this).attr('data-activity_id');
    postData['table_name']    = 'proposal_activities';

    if($(this).is(':checked')){
      postData['update_value']  = 'Y';
      $.ajax({
        url: "/settings/action",
        type: "POST",
        dataType : 'json',
        data : {'activity_id':postData['column_value'], 'action':'checkActivityInProposal'},
        beforeSend : function(){
          $(".show_loader").html('<img src="/img/spinner.gif" />');
        },
        success: function (resp) {
          if(resp.count >= 1){
            if(confirm("Activity cannot be deleted as it's in use .Please archive instead.")){
              postData['event'] = 'archive';
              archiveProposalItems(postData);
            }
          }else{
            postData['event']   = 'delete';
            if(confirm('Do you want to delete?')){
              archiveProposalItems(postData);
            }
          }
          
        }
      });
    }else{
      postData['update_value']  = 'N';
      postData['event']  = 'unarchive';
      archiveProposalItems(postData);
      return false;
    }
  });


  $('body').on('click', '.arcAttachment', function(event){
    var column_name   = 'id';
    var column_value  = $(this).attr('data-attachment_id');
    var table_name    = 'attachments';
    var update_value  = $(this).attr('data-update_value');
    var event         = $(this).attr('data-event');

    //archiveProposalItems(postData);

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

        $('#arcAttachment_'+column_value).attr('data-update_value', (update_value=='Y')?'N':'Y' );
        $('#arcAttachment_'+column_value).attr('data-event', (event=='archive')?'unarchive':'archive' );
        

        if(event == 'archive'){
          $('.attAcH_'+column_value).hide();
        }else{
          $('.attAcH_'+column_value).removeClass('rowColor');
          $('#arcAttachment_'+column_value).html('<i class="fa fa-edit tiny-icon"></i> Archive');
        }
      }
    });
  });

  $('body').on('click', '.openPackagePop', function(){
    $.ajax({
      type: "POST",
      url: "/proposal/action",
      data: { 'is_archive':'hide', 'action':'openPackagePop' },
      beforeSend: function() {
        $('#openPackagePop-modal .show_loader').html('<img src="/img/spinner.gif" />');
        $(".add_package_table tbody").html('');
        $('#openPackagePop-modal').modal('show');
      },
      success: function (resp) {
        $('.show_loader').html(''); 
        var data = resp.split('ipractice'); 
        $(".add_package_table tbody").html(data[0]);
      }
    });
  });

  $('body').on('click', '.addNewPackageBtn', function(){
    var package_name = $('#package_name').val();
    var package_type = $('#package_type').val();
    var proposal_id = $('#ProposalID').val();
    
    if(package_name == ''){
      alert('Please enter package name');
      $('#package_name').focus();
      return false;
    }else if(package_type == ''){
      alert('Please enter package type');
      $('#package_type').focus();
      return false;
    }

    $("#openPackagePopForm").ajaxForm({
      //dataType: 'json',
      data : {'proposal_id':proposal_id},
      beforeSend : function(){
        $(".show_loader").html('<img src="/img/spinner.gif" />');
        $(".toUpperCase").val('');
        $(".packageTypes").val('');
      },
      success: function(resp) {
        $(".show_loader").html('');
        
        var data = resp.split('ipractice'); console.log(data[0])
        $('.add_package_table tbody').append(data[0]);
        
      }
    }).submit();
  });

  $('body').on('click', '.showArchive', function(){
    var is_archive    = $(this).attr('data-is_archive');

    
    
    $.ajax({
      type: "POST",
      url: "/proposal/action",
      data: { 'is_archive':is_archive, 'action':'getShowHidePackages' },
      beforeSend: function() {
        $('#openPackagePop-modal .show_loader').html('<img src="/img/spinner.gif" />');
        //$("#add_package_table tbody").html('');
        $(".add_heading_table").html('');
        //$("#openPackagePop-modal").modal('show');
      },
      success: function (resp) {
        $('.show_loader').html('');   
        //$(".add_package_table tbody").html(resp); 
        $(".add_heading_table").html(resp); 
        $('#showArchive').attr('data-is_archive', (is_archive=='show')?'hide':'show');
        $('#showArchive').html((is_archive=='show')?'Hide Archive':'Show Archive');
      }
    });
  });


  $('body').on('click', '.viewTableServicePop', function(){
      var heading_id    = $(this).data('heading_id');
      var heading_name  = $(this).data('heading_name');
      $('#old_heading_id').val(heading_id);

      $.ajax({
        type: "POST",
        url: "/proposal/action",
        //dataType: 'json',
        data: { 'heading_id':heading_id, 'action':'getServicesByHeadingId' },
        beforeSend: function() {
          $('#viewProposalServicePop-modal .show_loader').html('<img src="/img/spinner.gif" />');
          $("#viewProposalServicePop-modal table tbody").html('');
          $(".tableName").html(heading_name);
          $("#old_page_name").val('settings');

          $("#viewProposalServicePop-modal").modal('show');
          $("#viewProposalServicePop-modal .newProposalServicePop").attr('data-heading_id', heading_id);
        },
        success: function (resp) {
          $('.show_loader').html('');   
          var data = resp.split('ipractice');
          $("#viewProposalServicePop-modal table tbody").html(data[0]);  
          reloadServicesOrdering();
        }
      });
    });

  




});//main document end

function archiveProposalItems(postData)
{
  var column_name   = postData['column_name'];
  var column_value  = postData['column_value'];
  var table_name    = postData['table_name'];
  var table_name    = postData['table_name'];
  var update_value  = postData['update_value'];
  var event         = postData['event'];

  $.ajax({
    url: "/settings/action",
    type: "POST",
    dataType : 'json',
    data : {'column_name':column_name, 'column_value':column_value, 'table_name':table_name, 'update_value':update_value, 'event':event, 'action':'archiveProposalItems'},
    beforeSend : function(){
      $(".show_loader").html('<img src="/img/spinner.gif" />');
    },
    success: function (resp) {
      if(event == 'delete'){
        var message = '<span style="color:#00c0ef">Data has been deleted successfully</span>';
      }
      if(event == 'archive'){
        var message = '<span style="color:#00c0ef">Data has been archived</span>';
      }
      if(event == 'unarchive'){
        var message = '<span style="color:#00c0ef">Data has been un-archived</span>';
      }
      $(".show_loader").html(message);

      if(event == 'unarchive'){
        $('.TaskServTablTr_'+column_value).removeClass('rowColor');
        $('.archiveLi_'+column_value).html('<a href="javascript:void(0)" data-service_id="'+column_value+'" class="deleteServicesSet" data-action="delete" data-table_name="services" data-column_name="service_id" data-update_value="Y"><i class="fa fa-trash-o tiny-icon"></i>Delete</a>');
      }else{
        if(table_name == 'proposal_activities'){
          $('.delListAct_'+column_value).hide();
        }else{
          $('.TaskServTablTr_'+column_value).hide();
        }
      }
    }
  });
}


function changeColor( postData )
{
  var color   = postData['color'];
  var type    = postData['type'];
  $.ajax({
    type: "POST",
    url: "/settings/action",
    //dataType:'json',
    data: { 'type':type, 'use_color':postData['use_color'], 'color':color, 'action':'saveColorCode' },
    beforeSend : function(){
      $('#viewDemoProposal').html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
    },
    success : function(resp){
      $('#viewDemoProposal').html('');
      $('#viewDemoProposal').html(resp);
      //location.reload();
      if(postData['use_color'] == 'M'){
        if(type == 'manual_notuse'){
          $('.manualNotUseBtn').hide();
          $('.manualUseBtn').show();
        }else{
          $('.manualUseBtn').hide();
          $('.manualNotUseBtn').show();
        }
      }else{
        if(type == 'auto_notuse'){
          $('.autoNotUseBtn').hide();
          $('.autoUseBtn').show();
        }else{
          $('.autoUseBtn').hide();
          $('.autoNotUseBtn').show();
        }
      }
    }
  });
}

function imageIsLoaded(e) {
  $('.image_preview').html( '<img src="'+e.target.result+'" class="browse_img" width="80">' );
}