$(document).ready(function(){

  $('body').on('click', '.openNotification', function(){
    var store_id = $(this).data('store_id');
    $.ajax({
      type: "POST",
      dataType:'json',
      url: "/client/ajax-get-store-data",
      data: { 'store_id': store_id },
      beforeSend: function() {
        $('#backup_clientdata').addClass('open');
          //$("#officer_details_div").html('<img src="/img/ajax-loader1.gif" />');
          //$("#personal_details").modal('show');//return false;
      },
      success: function (resp) {
        var heading = 'Notification for '+resp.details.client_name+' on '+resp.details.date+' at '+resp.details.time;
        $(".unread_data_count").html(resp.unread_count);
        $("#show_title").html(heading);

        if (resp.details.description.length != 0) {
          var content = '';
          $.each(resp.details.description, function(key){
            if(resp.details.description[key].prev_value == ''){
              var prev_value = 'Null';
            }else{
              var prev_value = resp.details.description[key].prev_value;
            }
            if(resp.details.description[key].updated_value == ''){
              var updated_value = 'Null';
            }else{
              var updated_value = resp.details.description[key].updated_value;
            }
            content+= "<p><strong>"+resp.details.description[key].full_name+"</strong><br>Updated from "+prev_value+" to "+updated_value+"</p>";
          });

          $(".data_show_box").html(content);
        }

        //$("#officer_details_div").html(resp);
        $('#open_details-modal').modal('show');
      }
    });
    
  }); 

  $('body').on('click', '.actionNotification', function(){
    var store_id  = $(this).data('store_id');
    var action    = $(this).data('action');

    $.ajax({
      type: "POST",
      dataType:'json',
      url: "/client/store-data-action",
      data: { 'store_id': store_id, 'action':action },
      beforeSend: function() {
        $('#backup_clientdata').addClass('open');
      },
      success: function (resp) {
        if(action == 'delete'){
          $('#action_not'+store_id).hide();
        }
        if(action == 'new'){

          $(".unread_data_count").html(resp.unread_count);
        }
      }
    });

  });

  $('body').on('click', '.open_notifications', function(){
    $('#manage_notification-modal').modal('show');
  });
      



});
    







