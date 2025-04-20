


$(document).ready(function () {
  var address_type = $('#address_type').val();
  /*var table = $('#example1').DataTable({
      "processing": true,
      "serverSide": true,
      "pageLength": 10,
      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false}
      ],
      "order" : [1, "desc"],

      "ajax": {
        "url" : '/contacts/get-contact-org',
        "type" : "POST",
        "data" : {'address_type': address_type}
      },

      "columnDefs": [
      {
        "targets": 0,
        "render": function ( data, type, full, meta ) {
          var text = '<span class="custom_chk"><input type="checkbox" class="xero_check_pop" value="'+data+'" id="j_'+data+'"><label style="width:0px!important;margin-top:0px;" for="j_'+data+'"></label></span>';
          
          return text;
        }
      },{
        "targets": 1,
        "render": function ( data, type, full, meta ) {
          return '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data+'" data-service_id="8">'+data+'</a>';
        }
      },{
        "targets": 2,
        "render": function ( data, type, full, meta ) {
          var text = '';
          if(data.length >0){
            text = '<select class="form-control newdropdown address_type" data-key="2" data-client_id="'+full[0]+'">';
            $.each(data, function(index, value){
              text +='<option value="'+data[index].short_name+'">'+data[index].title+'</option>';
            });
            text +='</select>';
          }
          return text;
        }
      },{
        "targets": 3,
        "render": function ( data, type, full, meta ) {
          return '<span class="contName'+full[0]+'">'+data+'</span>';
        }
      },{
        "targets": 4,
        "render": function ( data, type, full, meta ) {
          return '<span class="teleAddr'+full[0]+'">'+data+'</span>';
        }
      },{
        "targets": 5,
        "render": function ( data, type, full, meta ) {
          return '<span class="mobAddr'+full[0]+'">'+data+'</span>';
        }
      },{
        "targets": 6,
        "render": function ( data, type, full, meta ) {
          return '<span class="emailAddr'+full[0]+'">'+data+'</span>';
        }
      }
      ,{
        "targets": 7,
        "render": function ( data, type, full, meta ) {
          return '<span class="fullAddr'+full[0]+'">'+data+'</span>';
        }
      }
      ,{
        "targets": 8,
        "render": function ( data, type, full, meta ) {
          var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+full[0]+'"><span>notes</span></a>';
          text += '<input type="hidden" name="corres_add_'+full[0]+'" id="corres_add_'+full[0]+'" value="'+full[7]+'">';
          return text;
        }
      }         
    ]
    });*/






});





