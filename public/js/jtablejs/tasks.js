$(document).ready(function () {
  var service_id      = $('#service_id').val();
  var page_open       = $('#page_open').val();
  var title           = $('#service_name').val();
  var admin_name      = $('#admin_name').val();
  var logged_email    = $('#logged_email').val();

  if(page_open == 1){//5,7,8

    if(service_id == 1){
      $('#tasksFirstTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksFirstTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_id: {
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead"></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){
              return '<div class="align_center"><input type="checkbox" class="tasksFirstCheckbox" name="tasksFirstCheck[]" value="'+data.record.client_id+'"></div>';
            }
          },
          effective_date: {
            title: 'DOR',
            width: '4%',
            sorting:false,
            display:function(data){
              return data.record.effective_date;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          vat_scheme_type: {
            title: 'VAT Scheme',
            display:function(data){
              return data.record.vat_scheme_type;
            }
          },
          vat_scheme: {
            title: 'Type',
            width: '3%',
            display:function(data){
              return data.record.vat_scheme;
            } 
          },
          vat_number: {
            title: 'VAT Number',
            width: '4%',
            display: function(data) {
              return data.record.vat_number;
            }
          },
          vat_stagger: {
            title: 'Stagger',
            width: '3%',
            //sorting:false,
            display: function(data) {
              return data.record.vat_stagger;
            }
          },
          ret_frequency: {
            title: 'Frequency',
            width: '3%',
            //sorting:false,
            display: function(data) {
              return data.record.ret_frequency;
            }
          },
          manage_task: {
            title: 'Tasks <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>',
            width: '6%',
            sorting:false,
            display: function(data) {
              var button = '<button type="button" class="job_send_btn job_send_pop" data-client_id="'+data.record.client_id+'" data-field_name="manage_task">';
              button += (data.record.manage_task == 'N')?'SEND':'SEND MORE';
              button += '</button>';
              return '<div class="center">'+button+'</div>';
            }
          },
          staff: {
            title: 'Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var allocated_staffs = data.record.allocated_staffs;
              var select = '';
              if(allocated_staffs.length >0){
                select = '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
                $.each(allocated_staffs, function(k,v){
                  select += '<option value="'+v.staff_id+'">'+v.staff_name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          }
        }
      });

    }//if(service == 1) end

    if(service_id == 2){
      $('#tasksFirstTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksFirstTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_id: {
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead"></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){
              return '<div class="align_center"><input type="checkbox" class="tasksFirstCheckbox" name="tasksFirstCheck[]" value="'+data.record.client_id+'"></div>';
            }
          },
          effective_date: {
            title: 'DOR',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.effective_date;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          vat_scheme_type: {
            title: 'VAT Scheme',
            display:function(data){
              return data.record.vat_scheme_type;
            }
          },
          vat_scheme: {
            title: 'Type',
            width: '3%',
            display:function(data){
              return data.record.vat_scheme;
            } 
          },
          vat_number: {
            title: 'VAT Number',
            width: '4%',
            display: function(data) {
              return data.record.vat_number;
            }
          },
          vat_stagger: {
            title: 'VAT Stagger',
            width: '4%',
            //sorting:false,
            display: function(data) {
              return data.record.vat_stagger;
            }
          },
          ecsl_freq: {
            title: 'ECSL Frequency',
            width: '3%',
            //sorting:false,
            display: function(data) {
              return data.record.ecsl_freq;
            }
          },
          manage_task: {
            title: 'Tasks <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var button = '<button type="button" class="job_send_btn job_send_pop" data-client_id="'+data.record.client_id+'" data-field_name="manage_task">';
              button += (data.record.manage_task == 'N')?'SEND':'SEND MORE';
              button += '</button>';
              return '<div class="center">'+button+'</div>';
            }
          },
          staff: {
            title: 'Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var allocated_staffs = data.record.allocated_staffs;
              var select = '';
              if(allocated_staffs.length >0){
                select = '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
                $.each(allocated_staffs, function(k,v){
                  select += '<option value="'+v.staff_id+'">'+v.staff_name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          }
        }
      });

    }//if(service == 2) end

    if(service_id == 3){
      $('#tasksFirstTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'deadacc_count ASC',

        actions: {
          listAction: '/jtable/action?action=tasksFirstTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_id: {
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckallCheckbox" /></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){
              var text = '<input type="checkbox" class="ads_Checkbox" name="checkbox[]" value="'+data.record.client_id+'">';
              text += '<input type="hidden" id="clnt_no_'+data.record.client_id+'" value="'+data.record.registration_number+'">';
              return '<div class="center">'+text+'</div>';
            }
          },
          incorporation_date: {
            title: 'DOI',
            width: '3%',
            sorting:false,
            display:function(data){
              return "<div class='center'>"+data.record.incorporation_date+"</div>";
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            display:function(data){
              return "<div class='center'>"+data.record.registration_number+"</div>";
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          year_end: {
            title: 'Year End',
            width: '2%',
            sorting:false,
            display:function(data){
              return "<div class='center'>"+data.record.year_end+"</div>";
            }
          },
          ch_auth_code: {
            title: 'Authen code',
            width: '3%',
            display:function(data){
              return data.record.ch_auth_code;
            } 
          },
          last_acc_madeup_date: {
            title: 'Last Accts',
            width: '4%',
            sorting:false,
            display: function(data) {
              return data.record.last_acc_madeup_date;
            }
          },
          next_made_up_to: {
            title: 'Next Accts',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = data.record.next_made_up_to;
              return "<div class='center'>"+text+"</div>";
            }
          },
          next_acc_due: {
            title: 'Next Accounts Due',
            width: '5%',
            sorting:false,
            display: function(data) {
              return data.record.next_acc_due;
            }
          },
          /*sign_off_date: {
            title: 'S/Off Date',
            width: '3%',
            sorting:false,
            display: function(data) {
              var sign_off_date = data.record.sign_off_date;

              var text = '<div class="center sign_off_span_'+data.record.client_id+'">';
              if(sign_off_date != '' && sign_off_date.length > 0){
                text += '<a href="javascript:void(0)" class="sign_off_date sign_off_a_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'" data-action="old">'+data.record.sign_off_date+'</a>';
              }else{
                text += '<a href="javascript:void(0)" class="sign_off_date sign_off_a_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'" data-action="new">Add..</a>';
              }
              text += '</div>';
              return text;
            }
          },*/
          deadacc_count: {
            title: 'Days',
            width: '1%',
            display: function(data) {
              var deadacc_count = data.record.deadacc_count;
              if(deadacc_count.length > 0){
                if(deadacc_count < 0){
                  deadacc_count = '<span style="color:red">'+deadacc_count+'</span>';
                }
              }else{
                deadacc_count = '<span style="color:red">-</span>';
              }
              return '<div class="center">'+deadacc_count+'</div>';
            }
          },
          manage_task: {
            title: 'Tasks <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>',
            width: '4%',
            sorting:false,
            display: function(data) {
              var text = '<button type="button" class="job_sent_btn">SENT</button>';
              if(data.record.manage_task == 'N'){
                text = '<button type="button" class="job_send_btn send_manage_task" data-client_id="'+data.record.client_id+'" data-field_name="manage_task">SEND</button>';
              }
              return '<div class="center" id="after_send_'+data.record.client_id+'">'+text+'</div>';
            }
          },
          staff: {
            title: 'Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '4%',
            sorting:false,
            display: function(data) {
              var allocated_staffs = data.record.allocated_staffs;
              var select = '';
              if(allocated_staffs.length >0){
                select = '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
                $.each(allocated_staffs, function(k,v){
                  select += '<option value="'+v.staff_id+'">'+v.staff_name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          }
        }
      });

    }//if(service == 3) end

    if(service_id == 4){
      $('#tasksFirstTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksFirstTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_id: {
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead"></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){
              return '<div class="align_center"><input type="checkbox" class="tasksFirstCheckbox" name="tasksFirstCheck[]" value="'+data.record.client_id+'"></div>';
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          vat_scheme_type: {
            title: 'VAT Scheme',
            display:function(data){
              return data.record.vat_scheme_type;
            }
          },
          vat_scheme: {
            title: 'Type',
            width: '3%',
            display:function(data){
              return data.record.vat_scheme;
            } 
          },
          vat_stagger: {
            title: 'VAT Stagger',
            width: '3%',
            //sorting:false,
            display: function(data) {
              return data.record.vat_stagger;
            }
          },
          repeat_day: {
            title: 'Job Freq',
            width: '4%',
            //sorting:false,
            display: function(data) {
              var repeat_day = data.record.repeat_day;

              var text = '';
              if(repeat_day != ''){
                text += '<a href="javascript:void(0)" class="left job_freq_pop" id="job_freq_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">Every '+repeat_day+' Day(s)</a>';
                text += '<a href="javascript:void(0)" class="left delete_job_freq" data-client_id="'+data.record.client_id+'"><img src="/img/cross.png" width="10"></a>';
              }else{
                text += '<a href="javascript:void(0)" class="job_freq_pop" id="job_freq_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">Add..</a>';
              }
              return '<div class="center">'+text+'</div>';
            }
          },
          hrs_wk: {
            title: 'Hrs/Wk',
            width: '1%',
            display: function(data) {
              var text = '<div class="center hrs_'+data.record.client_id+'">'+data.record.hrs_wk+'</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var button = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-tab="1">notes</a>';
              return '<div class="center">'+button+'</div>';
            }
          },
          staff: {
            title: 'Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var allocated_staffs = data.record.allocated_staffs;
              var select = '';
              if(allocated_staffs.length >0){
                select = '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
                $.each(allocated_staffs, function(k,v){
                  select += '<option value="'+v.staff_id+'">'+v.staff_name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          }
        }
      });

    }//if(service == 4) end

    if(service_id == 5){
      $('#tasksFirstTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'ct_count_down DESC',

        actions: {
          listAction: '/jtable/action?action=tasksFirstTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_id: {
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckallCheckbox" /></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){
              var text = '<input type="checkbox" class="ads_Checkbox" name="checkbox[]" value="'+data.record.client_id+'">';
              text += '<input type="hidden" id="clnt_no_'+data.record.client_id+'" value="'+data.record.registration_number+'">';
              return '<div class="center">'+text+'</div>';
            }
          },
          incorporation_date: {
            title: 'DOI',
            width: '3%',
            sorting:false,
            display:function(data){
              return "<div class='center'>"+data.record.incorporation_date+"</div>";
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          year_end: {
            title: 'Year End',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = data.record.year_end;
              return "<div class='center'>"+text+"</div>";
            }
          },
          tax_reference: {
            title: 'CT. Reference',
            width: '3%',
            sorting:false,
            display: function(data) {
              //var text = (data.record.tax_reference_type == 'C')?data.record.tax_reference:'';
              var text = data.record.tax_reference;
              return "<div class='center'>"+text+"</div>";
            }
          },
          accounts_date: {
            title: 'Accounts',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = data.record.accounts_date;
              return "<div class='center'>"+text+"</div>";
            }
          },
          accounts_status: {
            title: 'Accounts Status',
            width: '7%',
            sorting:false,
            display: function(data) {
              var return_status = data.record.return_status;
              var text = (return_status.length >0)?'<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+return_status+'</span>':'';
              return '<div class="center">'+text+'</div>';
            }
          },
          return_due_date: {
            title: 'Return Due Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              var return_due_date = data.record.return_due_date;
              var text = '<div class="center tax_return_end_'+data.record.client_id+'">'+return_due_date+'</div>';
              return text;
            }
          },
          ct_count_down: {//roll_count
            title: 'Days',
            width: '3%',
            display: function(data) {
              var roll_count = data.record.ct_count_down;
              if(roll_count < 0){
                roll_count = '<span style="color:red">'+roll_count+'</span>';
              }
              return '<div class="center count_tax_'+data.record.client_id+'">'+roll_count+'</div>';
            }
          },
          manage_task: {
            title: 'Tasks',
            width: '4%',
            sorting:false,
            display: function(data) {
              var text = '<button type="button" class="job_sent_btn">SENT</button>';
              if(data.record.manage_task == 'N'){
                text = '<button type="button" class="job_send_btn send_manage_task" data-client_id="'+data.record.client_id+'" data-field_name="manage_task">SEND</button>';
              }
              return '<div class="center" id="after_send_'+data.record.client_id+'">'+text+'</div>';
            }
          },
          staff: {
            title: 'Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '4%',
            sorting:false,
            display: function(data) {
              var allocated_staffs = data.record.allocated_staffs;
              var select = '';
              if(allocated_staffs.length >0){
                select = '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
                $.each(allocated_staffs, function(k,v){
                  select += '<option value="'+v.staff_id+'">'+v.staff_name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          }
        }
      });

    }//if(service == 5) end

    if(service_id == 6){
      $('#tasksFirstTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksFirstTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_id: {
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead"></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){
              return '<div class="align_center"><input type="checkbox" class="tasksFirstCheckbox" name="tasksFirstCheck[]" value="'+data.record.client_id+'"></div>';
            }
          },
          incorporation_date: {
            title: 'DOI',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.incorporation_date;
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            display:function(data){
              return data.record.registration_number;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          year_end: {
            title: 'Year End',
            width: '2%',
            sorting:false,
            display:function(data){
              return "<div class='center'>"+data.record.year_end+"</div>";
            }
          },
          last_acc_madeup_date: {
            title: 'Last Accts Filed',
            width: '4%',
            sorting:false,
            display: function(data) {
              return data.record.last_acc_madeup_date;
            }
          },
          next_acc_due: {
            title: 'Next Accounts Due',
            width: '5%',
            sorting:false,
            display: function(data) {
              return data.record.next_acc_due;
            }
          },
          completion_date: {
            title: 'Completion Date',
            width: '3%',
            sorting:false,
            display: function(data) {
              var completion_date = data.record.completion_date;

              var text = '<div class="center"><a href="javascript:void(0)" class="open_completion_pop completion_span_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
              if(completion_date != ''){
                text += data.record.completion_date;
              }else{
                text += 'Add..';
              }
              text += '</a></div>';
              return text;
            }
          },
          completion_days: {
            title: 'Days',
            width: '1%',
            display: function(data) {
              var completion_days = data.record.completion_days;
              if(completion_days < 0){
                completion_days = '<span style="color:red">'+completion_days+'</span>';
              }
              return '<div class="center count_compl_'+data.record.client_id+'">'+completion_days+'</div>';
            }
          },
          manage_task: {
            title: 'Tasks <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var text = '<button type="button" class="job_send_btn open_audit_popup" data-client_id="'+data.record.client_id+'" data-send_type="single">';
              if(data.record.manage_task == 'N'){
                text += 'SEND';
              }else{
                text += 'SEND MORE';
              }
              text += '</button>';
              return '<div class="center" id="after_send_'+data.record.client_id+'">'+text+'</div>';
            }
          },
          staff: {
            title: 'Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '4%',
            sorting:false,
            display: function(data) {
              var allocated_staffs = data.record.allocated_staffs;
              var select = '';
              if(allocated_staffs.length >0){
                select = '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
                $.each(allocated_staffs, function(k,v){
                  select += '<option value="'+v.staff_id+'">'+v.staff_name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          }
        }
      });

    }//if(service == 6) end

    if(service_id == 7){
      $('#tasksFirstTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksFirstTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_id: {
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckallCheckbox" /></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){
              var text = '<input type="checkbox" class="ads_Checkbox" name="checkbox[]" value="'+data.record.client_id+'">';
              text += '<input type="hidden" id="clnt_no_'+data.record.client_id+'" value="'+data.record.registration_number+'">';
              return '<div class="center">'+text+'</div>';
            }
          },
          client_name: {
            title: 'Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          ni_number: {
            title: 'NI Number',
            width: '2%',
            sorting:false,
            display:function(data){
              var text = (data.record.client_type == 'ind')?data.record.ni_number:'N/A';
              return "<div class='center'>"+text+"</div>";
            }
          },
          tax_reference: {
            title: 'Tax Reference',
            width: '2%',
            display:function(data){
              return "<div class='center'>"+data.record.tax_reference+"</div>";
            } 
          },
          /*address: {
            title: 'Address',
            width: '6%',
            sorting:false,
            display: function(data) {
              return data.record.address;
            }
          },*/
          relationship: {
            title: 'Related Companies',
            width: '8%',
            sorting:false,
            display: function(data) {
              var relationship = data.record.relationship;
              var select = '';
              if(relationship.length >0){
                select += '<select class="form-control newdropdown" data-client_id="'+data.record.client_id+'">';
                $.each(relationship, function(k,v){
                  select += '<option value="'+v.client_id+'">'+v.name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          },
          client_users: {
            title: 'View Data',
            width: '2%',
            sorting:false,
            display: function(data) {
              var text = '';
              var client_type = data.record.client_type;
              if(client_type == 'ind'){
                var client_portal = data.record.client_portal;
                var client_id     = data.record.client_id;
                var client_users  = data.record.client_users;
                if($.inArray(client_id, client_users) !== -1){
                  text = '<a class="p_send_btn" href="/tsxreturninfromation/'+client_id+'/'+client_portal+'/1/0" target="_blank">VIEW</a>';
                }else{
                  text = '<a href="javascript:void(0)" class="viewClientMessage p_send_btn">VIEW</a>';
                }
              }
              return "<div class='center'>"+text+"</div>";
            }
          },
          manage_task: {
            title: 'Tasks <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>',
            width: '4%',
            sorting:false,
            display: function(data) {
              var button = '<button type="button" class="job_send_btn open_send_popup" data-client_id="'+data.record.client_id+'" data-send_type="single">';
              button += (data.record.manage_task == 'N')?'SEND':'SEND MORE';
              button += '</button>';
              return '<div class="center" id="after_send_'+data.record.client_id+'">'+button+'</div>';
            }
          },
          staff: {
            title: 'Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '4%',
            sorting:false,
            display: function(data) {
              var allocated_staffs = data.record.allocated_staffs;
              var select = '';
              if(allocated_staffs.length >0){
                select = '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
                $.each(allocated_staffs, function(k,v){
                  select += '<option value="'+v.staff_id+'">'+v.staff_name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          }
        }
      });

    }//if(service == 7) end

    if(service_id == 8){
      $('#tasksFirstTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksFirstTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_id: {
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckHead"></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){
              return '<div class="align_center"><input type="checkbox" class="tasksFirstCheckbox" name="tasksFirstCheck[]" value="'+data.record.client_id+'"></div>';
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          year_end: {
            title: 'Year End',
            width: '4%',
            display:function(data){
              return "<div class='center'>"+data.record.year_end+"</div>";
            }
          },
          vat_stagger: {
            title: 'VAT Stagger',
            width: '4%',
            //sorting:false,
            display: function(data) {
              return data.record.vat_stagger;
            }
          },
          book_status: {
            title: 'Bookkeeping Status',
            width: '4%',
            sorting:false,
            display:function(data){
              var book_status = data.record.book_status;
              var text = '';
              if(book_status.length >0){
                text += '<select class="form-control newdropdown" data-manage_id="0" data-client_id="'+data.record.client_id+'">';
                $.each(book_status, function(k, v){
                  text += '<option value="'+v.job_due_date+'">'+v.job_due_date+'-'+v.status_name+'</option>';
                });
                text += '</select>';
              }
              return text;
            } 
          },
          frequency: {
            title: 'Frequency',
            width: '5%',
            sorting:false,
            display: function(data) {
              var select = data.record.frequency;
              var select1 = (select == 'Monthly')?'selected':'';
              var select2 = (select == 'Mar-Jun - Sep-Dec')?'selected':'';
              var select3 = (select == 'Jan-Apr - Jul-Oct')?'selected':'';
              var select4 = (select == 'Feb-May - Aug-Nov')?'selected':'';

              var text = '';

              text += '<select class="form-control newdropdown save_details" data-manage_id="0" data-client_id="'+data.record.client_id+'" data-field_name="frequency">';
                text += '<option value="">None</option>';
                text += '<option value="Monthly" '+select1+'>Monthly</option>';
                text += '<option value="Mar-Jun - Sep-Dec" '+select2+'>Mar-Jun - Sep-Dec</option>';
                text += '<option value="Jan-Apr - Jul-Oct" '+select3+'>Jan-Apr - Jul-Oct</option>';
                text += '<option value="Feb-May - Aug-Nov" '+select4+'>Feb-May - Aug-Nov</option>';
              text += '</select>';

              return text;
            }
          },
          
          due_date: {
            title: 'Due Date',
            width: '3%',
            sorting:false,
            display: function(data) {
              var due_date = data.record.due_date;
              var text = '';
              text += '<select class="form-control newdropdown save_details" data-manage_id="0" data-client_id="'+data.record.client_id+'" data-field_name="due_date">';
                text += '<option value="0">None</option>';
                for(var i = 1; i <=31;i++){
                  var selected = (due_date == i)?'selected':'';
                  i = (i < 10)?'0'+i:i;
                  text += '<option value="'+i+'" '+selected+'>'+i+'</option>';
                }
              text += '</select>';

              return text;
            }
          },
          manage_task: {
            title: 'Tasks <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var button = '<button type="button" class="job_send_btn job_send_pop" data-client_id="'+data.record.client_id+'" data-field_name="manage_task">';
              button += (data.record.manage_task == 'N')?'SEND':'SEND MORE';
              button += '</button>';
              return '<div class="center" id="after_send_'+data.record.client_id+'">'+button+'</div>';
            }
          },
          staff: {
            title: 'Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var allocated_staffs = data.record.allocated_staffs;
              var select = '';
              if(allocated_staffs.length >0){
                select = '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
                $.each(allocated_staffs, function(k,v){
                  select += '<option value="'+v.staff_id+'">'+v.staff_name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          }
        }
      });

    }//if(service == 8) end

    if(service_id == 9){
      $('#tasksFirstTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksFirstTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_id: {//CheckHead
            title: '<div style="padding-left:7px;"><input type="checkbox" class="CheckallCheckbox"></div>',
            width: '0.5%',
            sorting:false,
            display:function(data){//tasksFirstCheckbox
              var text = '<input type="checkbox" class="ads_Checkbox" name="checkbox[]" value="'+data.record.client_id+'">';
              text += '<input type="hidden" id="clnt_no_'+data.record.client_id+'" value="'+data.record.registration_number+'">';
              return '<div class="center">'+text+'</div>';
            }
          },
          incorporation_date: {
            title: 'DOI',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.incorporation_date;
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            display:function(data){
              return data.record.registration_number;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          year_end: {
            title: 'Year End',
            width: '2%',
            sorting:false,
            display:function(data){
              return "<div class='center'>"+data.record.year_end+"</div>";
            }
          },
          ch_auth_code: {
            title: 'Authen code',
            width: '3%',
            display:function(data){
              return data.record.ch_auth_code;
            } 
          },
          next_return: {
            title: 'Next Return',
            width: '3%',
            sorting:false,
            display:function(data){
              var text = data.record.next_return;
              return "<div class='center'>"+text+"</div>";
            }
          },
          made_up_date: {
            title: 'Last Return Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              return data.record.made_up_date;
            }
          },
          next_ret_due: {
            title: 'Next Return Due On',
            width: '5%',
            sorting:false,
            display: function(data) {
              return data.record.next_ret_due;
            }
          },
          deadret_count: {
            title: 'Count Down',
            width: '3%',
            display: function(data) {
              var deadret_count = data.record.deadret_count;
              if(deadret_count < 0){
                deadret_count = '<span style="color:red">'+deadret_count+'</span>';
              }
              return '<div class="center">'+deadret_count+'</div>';
            }
          },
          manage_task: {
            title: 'Tasks <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i>',
            width: '4%',
            sorting:false,
            display: function(data) {
              if(data.record.manage_task == 'N'){
                text = '<button type="button" class="job_send_btn send_manage_task" data-client_id="'+data.record.client_id+'" data-field_name="ch_manage_task">SEND</button>';
              }else{
                text = '<button type="button" class="job_sent_btn">SENT</button>';
              }
              return '<div class="center" id="after_send_'+data.record.client_id+'">'+text+'</div>';
            }
          },
          staff: {
            title: 'Staff <a href="javascript:void(0)" class="openAllocationHeading"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '4%',
            sorting:false,
            display: function(data) {
              var allocated_staffs = data.record.allocated_staffs;
              var select = '';
              if(allocated_staffs.length >0){
                select = '<select class="form-control newdropdown table_select staff_dropdown" id="1_staff_dropdown_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'">';
                $.each(allocated_staffs, function(k,v){
                  select += '<option value="'+v.staff_id+'">'+v.staff_name+'</option>';
                });
                select    += '</select>';
              }
              return select;
            }
          }
        }
      });

    }//if(service == 9) end

  }//page open 1 end


  if(page_open == 2){

    if(service_id == 1){
      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          /*effective_date: {
            title: 'DOR',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.effective_date;
            }
          },*/
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          vat_stagger: {
            title: 'Stagger',
            width: '4%',
            display:function(data){
              return data.record.vat_stagger;
            }
          },
          e_reminders: {
            title: 'E-Reminders',
            width: '2%',
            sorting:false,
            display:function(data){//RE-SEND
              var e_reminders = (data.record.e_reminders >0)?'SENT <small>['+data.record.e_reminders+']</small>':'SEND';
              return '<div class="center"><button type="button" class="p_send_btn " data-client_id="'+data.record.client_id+'">'+e_reminders+'</button></div>';
            }
          },
          ret_frequency: {
            title: 'Frequency',
            width: '2%',
            display:function(data){
              return data.record.ret_frequency;
            } 
          },
          return_date: {
            title: 'Return',
            width: '1%',
            display: function(data) {
              return '<div class="center">'+data.record.return_date+'</div>';
            }
          },
          deadline: {
            title: 'Deadline',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.deadline;
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                //text += '<li><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to TODO List</a></li>';
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          status_name: {
            title: '<div class="center">Status</div>',
            width: '8%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';



              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              if(service_id== 1 || service_id== 2 || service_id== 4 || service_id== 6 || service_id == 7 || service_id == 8)
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              else{
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              }

              return '<div class="center">'+text+'</div>';
            }
          }

        }
      });
    }//service id 1 end

    if(service_id == 2){
      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          effective_date: {
            title: 'DOR',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.effective_date;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          vat_stagger: {
            title: 'Stagger',
            width: '4%',
            display:function(data){
              return data.record.vat_stagger;
            }
          },
          e_reminders: {
            title: 'E-Reminders',
            width: '2%',
            sorting:false,
            display:function(data){//RE-SEND
              var e_reminders = (data.record.e_reminders >0)?'SENT <small>['+data.record.e_reminders+']</small>':'SEND';
              return '<div class="center"><button type="button" class="p_send_btn " data-client_id="'+data.record.client_id+'">'+e_reminders+'</button></div>';
            }
          },
          ecsl_freq: {
            title: 'ECSL Frequency',
            width: '3%',
            display: function(data) {
              return data.record.ecsl_freq;
            }
          },
          return_date: {
            title: 'Return',
            width: '1%',
            display: function(data) {
              return '<div class="center">'+data.record.return_date+'</div>';
            }
          },
          deadline: {
            title: 'Deadline',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.deadline;
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                //text += '<li><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to TODO List</a></li>';
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          status_name: {
            title: '<div class="centerHead">Status</div>',
            width: '8%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';
              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              //text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';

              return '<div class="center">'+text+'</div>';
            }
          }

        }
      });
    }//service id 2 end

    if(service_id == 3){
      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'deadacc_count ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          e_reminders: {
            title: 'E-Reminders',
            width: '2%',
            display:function(data){
              var e_reminders = (data.record.e_reminders >0)?'SENT <small>['+data.record.e_reminders+']</small>':'SEND';
              return '<div class="center"><button type="button" class="p_send_btn " data-client_id="'+data.record.client_id+'">'+e_reminders+'</button></div>';
            }
          },
          year_end: {
            title: 'Year End',
            width: '3%',
            display:function(data){
              return data.record.year_end;
            }
          },
          next_made_up_to: {
            title: 'Accounts',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = data.record.next_made_up_to;
              return "<div class='center'>"+text+"</div>";
            }
          },
          next_acc_due: {
            title: 'Accts Due On',
            width: '4%',
            display:function(data){
              var next_acc_due = data.record.next_acc_due;
              return '<div class="center">'+next_acc_due+'</div>';
            }
          },
          deadacc_count: {
            title: 'Days',
            width: '2%',
            display: function(data) {
              var deadacc_count = data.record.deadacc_count;
              if(deadacc_count < 0){
                deadacc_count = '<span style="color:red">'+deadacc_count+'</span>';
              }
              return '<div class="center">'+deadacc_count+'</div>';
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          sync_date: {
            title: 'Sync Data',
            width: '3%',
            sorting:false,
            display: function(data) {
              return '<div class="center"><a href="javascript:void(0)" class="notes_btn sync_chreturn_data" data-client_id="'+data.record.client_id+'" data-action="single">Sync</a></div>';
            }
          },
          status_name: {
            title: '<div class="center">Status</div>',
            width: '7%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';
              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              if(service_id== 1 || service_id== 2 || service_id== 4 || service_id== 6 || service_id == 7 || service_id == 8)
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              else{
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              }

              return '<div class="center">'+text+'</div>';
            }
          }

        }
      });
    }//service id 3 end

    if(service_id == 4){
      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="/client/edit-org-client/'+data.record.client_id+'/'+data.record.org_client+'" class="left" style="margin-right:5px;" target="_blank">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          job_due_date: {
            title: 'Job Due Date',
            width: '4%',
            sorting:false,
            display:function(data){
              return '<div class="center">'+data.record.job_due_date+'</div>';
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                //text += '<li><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to TODO List</a></li>';
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          status_name: {
            title: '<div class="center">Status</div>',
            width: '8%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';
              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';

              return '<div class="center">'+text+'</div>';
            }
          }
        }
      });
    }//service id 4 end

    if(service_id == 5){
      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'ct_count_down ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          year_end: {
            title: 'Year End',
            width: '3%',
            display:function(data){
              var text = data.record.year_end;
              return '<div class="center">'+text+'</div>';
            }
          },
          accounts_date: {
            title: 'Accounts',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = data.record.accounts_date;
              return "<div class='center'>"+text+"</div>";
            }
          },
          return_due_date: {
            title: 'Return Due Date',
            width: '5%',
            display:function(data){
              var text = data.record.return_due_date;
              return "<div class='center'>"+text+"</div>";
            }
          },
          ct_count_down: {
            title: 'Days',
            width: '2%',
            display: function(data) {
              var ct_count_down = data.record.ct_count_down;
              if(ct_count_down < 0){
                ct_count_down = '<span style="color:red">'+ct_count_down+'</span>';
              }
              return '<div class="center">'+ct_count_down+'</div>';
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          /*return_status: {
            title: 'Return Status',
            width: '7%',
            sorting:false,
            display: function(data) {
              var return_status = data.record.return_status;
              var text = (return_status.length >0)?'<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+return_status+'</span>':'';
              return text;
            }
          },*/
          status_name: {
            title: '<div class="center">Status</div>',
            width: '7%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';
              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              if(service_id== 1 || service_id== 2 || service_id== 4 || service_id== 6 || service_id == 7 || service_id == 8)
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              else{
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              }

              return '<div class="center">'+text+'</div>';
            }
          }

        }
      });
    }//service id 5 end

    if(service_id == 6){
      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'completion_days ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          incorporation_date: {
            title: 'DOI',
            width: '3%',
            sorting:false,
            display:function(data){
              return "<div class='center'>"+data.record.incorporation_date+"</div>";
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          year_end: {
            title: 'Year End',
            width: '3%',
            display:function(data){
              return data.record.year_end;
            }
          },
          period_end: {
            title: 'Period End',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = data.record.period_end;
              return "<div class='center'>"+text+"</div>";
            }
          },
          completion_date: {
            title: 'Completion Date',
            width: '4%',
            display:function(data){
              var text = data.record.completion_date;
              return '<div class="center">'+text+'</div>';
            }
          },
          completion_days: {
            title: 'Days',
            width: '2%',
            display: function(data) {
              var text = data.record.completion_days;
              if(text < 0){
                text = '<span style="color:red">'+text+'</span>';
              }
              return '<div class="center">'+text+'</div>';
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          status_name: {
            title: '<div class="center">Status</div>',
            width: '7%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';
              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              //text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';

              return '<div class="center">'+text+'</div>';
            }
          }

        }
      });
    }//service id 6 end

    if(service_id == 7){
      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_name: {
            title: 'Client Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          return_date: {
            title: 'Return',
            width: '1%',
            display: function(data) {
              var text = data.record.return_date;
              return '<div class="center">'+text+'</div>';
            }
          },
          deadline: {
            title: 'Deadline',
            width: '1%',
            sorting:false,
            display: function(data) {
              var text = data.record.deadline;
              return '<div class="center">'+text+'</div>';
            }
          },
          e_reminders: {
            title: 'E-Reminders',
            width: '2%',
            sorting:false,
            display:function(data){
              var e_reminders = (data.record.e_reminders >0)?'SENT <small>['+data.record.e_reminders+']</small>':'SEND';
              return '<div class="center"><button type="button" class="p_send_btn " data-client_id="'+data.record.client_id+'">'+e_reminders+'</button></div>';
            }
          },
          view_data: {
            title: 'View Data',
            width: '2%',
            sorting:false,
            display: function(data) {//VIEW[1]
              var return_date = data.record.return_date;
              var returnDate  = return_date.replace("/", "-");

              var text = '';
              var client_type = data.record.client_type;
              if(client_type == 'ind'){
                var client_portal = data.record.client_portal;
                var client_id     = data.record.client_id;
                var client_users  = data.record.client_users;
                if($.inArray(client_id, client_users) !== -1){
                  text = '<a class="p_send_btn" href="/tsxreturninfromation/'+client_id+'/'+client_portal+'/1/'+returnDate+'" target="_blank">VIEW</a>';
                }else{
                  text = '<a href="javascript:void(0)" class="viewClientMessage p_send_btn">VIEW</a>';
                }
              }
              return "<div class='center'>"+text+"</div>";
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                //text += '<li><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to TODO List</a></li>';
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          status_name: {
            title: '<div class="center">Status</div>',
            width: '7%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';
              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              if(service_id== 1 || service_id== 2 || service_id== 4 || service_id== 6 || service_id == 7 || service_id == 8)
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              else{
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              }

              return '<div class="center">'+text+'</div>';
            }
          }

        }
      });
    }//service id 7 end

    if(service_id == 8){
      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_name: {
            title: 'Client Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          job_name: {
            title: 'Job',
            width: '3%',
            display: function(data) {
              var text = data.record.job_name;
              return "<div class=''>"+text+"</div>";
            }
          },
          deadline: {
            title: 'Deadline',
            width: '3%',
            sorting:false,
            display:function(data){
              var text = data.record.deadline;
              return "<div class='center'>"+text+"</div>";
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '4%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                //text += '<li><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to TODO List</a></li>';
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '1%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          status_name: {
            title: '<div class="center">Status</div>',
            width: '7%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';
              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  var display = (v.status == 'H')?'hide':'block';
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange '+display+'" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              if(service_id== 1 || service_id== 2 || service_id== 4 || service_id== 6 || service_id == 7 || service_id == 8)
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              else{
                text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';
              }

              return '<div class="center">'+text+'</div>';
            }
          }

        }
      });
    }//service id 8 end

    if(service_id == 9){
      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'deadret_count ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          e_reminders: {
            title: 'E-Reminders',
            width: '2%',
            sorting:false,
            display:function(data){
              var e_reminders = (data.record.e_reminders >0)?'SENT <small>['+data.record.e_reminders+']</small>':'SEND';
              return '<div class="center"><button type="button" class="p_send_btn " data-client_id="'+data.record.client_id+'">'+e_reminders+'</button></div>';
            }
          },
          ch_auth_code: {
            title: 'Authen Code',
            width: '3%',
            display:function(data){
              return data.record.ch_auth_code;
            }
          },
          next_return: {
            title: 'Next Return',
            width: '3%',
            sorting:false,
            display:function(data){
              var text = data.record.next_return;
              return "<div class='center'>"+text+"</div>";
            }
          },
          next_ret_due: {
            title: 'Next Return Due On',
            width: '5%',
            sorting:false,
            display: function(data) {
              var text = data.record.next_ret_due;
              return "<div class='center'>"+text+"</div>";
            }
          },
          deadret_count: {
            title: 'Days',
            width: '2%',
            display: function(data) {
              var text = data.record.deadret_count;
              if(text < 0){
                text = '<span style="color:red">'+text+'</span>';
              }
              return '<div class="center">'+text+'</div>';
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '5%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          sync_date: {
            title: 'Sync Data',
            width: '3%',
            sorting:false,
            display: function(data) {
              return '<div class="center"><a href="javascript:void(0)" class="notes_btn sync_chreturn_data" data-client_id="'+data.record.client_id+'" data-action="single">Sync</a></div>';
            }
          },
          status_name: {
            title: '<div class="centerHead">Status</div>',
            width: '7%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '2%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail1" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop1" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';
              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              return '<div class="center">'+text+'</div>';
            }
          }

        }
      });
    }//service id 9 end

    if(service_id > 9){
      var headfield1  = $('#headfield1').val();
      var headfield2  = $('#headfield2').val();
      var field1      = $('#field1').val();
      var field2      = $('#field2').val();

      $('#tasksSecondTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'count_down ASC',

        actions: {
          listAction: '/jtable/action?action=tasksSecondTable&service_id='+service_id+'&page_open='+page_open+'&field1='+field1+'&field2='+field2
        },
        fields: {
          client_name: {
            title: 'Business Name',
            display:function(data){
              var reminders   = (data.record.reminders.is_enable == 1)?'block':'none';
              var taskstatus  = (data.record.taskstatus.is_enable == 2)?'block':'none';

              text = '<a href="javascript:void(0)" class="openTaskPop left" data-client_id="'+data.record.client_id+'" style="margin-right:5px;" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              text += '<div class="right">';
              text += '<div class="red_box red_box_'+data.record.client_id+'" id="red_box_'+data.record.client_id+'" style="display:'+reminders+'"></div>';
              text += '<div class="blue_box blue_box_'+data.record.client_id+'" id="blue_box_'+data.record.client_id+'" style="display:'+taskstatus+'"></div>'; 
              text += '</div>';
              return text;
            }
          },
          e_reminders: {
            title: 'E-Reminders',
            width: '1%',
            sorting:false,
            display:function(data){//RE-SEND
              var e_reminders = (data.record.e_reminders >0)?'SENT <small>['+data.record.e_reminders+']</small>':'SEND';
              return '<div class="center"><button type="button" class="p_send_btn " data-client_id="'+data.record.client_id+'">'+e_reminders+'</button></div>';
            }
          },
          field1_value: {
            title: headfield1,
            width: '4%',
            display:function(data){
              return data.record.field1_value;
            }
          },
          field2_value: {
            title: headfield2,
            width: '2%',
            display:function(data){
              return data.record.field2_value;
            } 
          },
          cust_job_name: {
            title: 'Job Name',
            width: '2%',
            sorting:false,
            display:function(data){
              var text = data.record.cust_job_name;
              return "<div class='center'>"+text+"</div>";
            }
          },
          deadline_date: {
            title: 'Deadline Date',
            width: '3%',
            sorting:false,
            display: function(data) {
              return '<div class="center">'+data.record.deadline_date+'</div>';
            }
          },
          count_down: {
            title: 'Days',
            width: '1%',
            display: function(data) {
              var count = data.record.count_down;
              if(count.length > 0){
                if(count < 0){
                  count = '<span style="color:red">'+count+'</span>';
                }
              }else{
                count = '<span style="color:red">-</span>';
              }
              return '<div class="center">'+count+'</div>';
            }
          },
          job_start_date: {
            title: 'Job Start Date <a href="javascript:void(0)" class="job_start_date-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>',
            width: '4%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';

              var text = '<div id="edit_calender_'+data.record.client_id+'_2" class="edit_cal">';
              text += '<a href="javascript:void(0)" id="date_view_'+data.record.client_id+'_2" />'+data.record.job_start_date+'</a>';
              text += '<span class="glyphicon glyphicon-chevron-down open_adddrop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2"></span>';
              text += '<div class="cont_add_to_date open_dropdown_'+data.record.job_manage_id+'_2" style="display:none;">';
              text += '<ul>'; 
                //text += '<li><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to TODO List</a></li>';
                text += '<li><a href="javascript:void(0)" class="open_calender_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2">Add/Edit Start Date</a></li>';
                text += '<li>';
                  text += '<span id="view_calender_'+data.record.job_manage_id+'_2" class="addtocalendar atc-style-blue">';
                  text += '<var class="atc_event">';
                  text += '<var class="atc_date_start">'+data.record.job_start_date+'</var>';
                  text += '<var class="atc_date_end">'+data.record.job_start_plus+'</var>';
                  text += '<var class="atc_timezone">Europe/London</var>';
                  text += '<var class="atc_title">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_description">'+title+' - '+data.record.client_name+'</var>';
                  text += '<var class="atc_location">Office</var>';
                  text += '<var class="atc_organizer">'+admin_name+'</var>';
                  text += '<var class="atc_organizer_email">'+logged_email+'</var>';
                  text += '</var>';
                  text += '</span>';
                text += '</li>';
              text += '</ul>';
              text += '</div>';
              return text;
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          status_name: {
            title: 'Status',
            width: '8%',
            sorting:false,
            display: function(data) {
              var text = data.record.status_name;
              return '<span class="p_send_btn JobStatusTd_'+data.record.job_manage_id+'">'+text+'</span>';
            }
          },
          action: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display: function(data) {
              var tasksadded = (data.record.tasksadded == 1)?'Added':'Add';
              var jobs_steps = data.record.jobs_steps;

              var text = '<div class="btn-group"><button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-gear tiny-icon"></i> <span class="caret"></span></button>';
              text += '<ul class="dropdown-menu proposal-dropdown-menu" role="menu">';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="openChaserEmail" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Send Chaser Email</a></li>';
              text += '<li style="border-bottom:1px solid #dbdbdb"><a href="javascript:void(0)" class="open_newtask_pop" data-manage_id="'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-tab="2" data-task_name="'+title+'">'+tasksadded+' to Todo List</a></li>';
              text += '<li><a href="javascript:void(0)" class="" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" style="text-decoration:underline; font-weight:bold; font-style:italic">Select Status...</a></li>';
              text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="2" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">Not Started</a></li>';
                $.each(jobs_steps, function(k,v){
                  text += '<li><a href="javascript:void(0)" class="jobStatusChange" data-step_id="'+v.step_id+'" id="'+page_open+'_status_dropdown_'+data.record.job_manage_id+'" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'">'+v.title+'</a></li>';
                });
                text += '<li style="border-top:1px solid #dbdbdb!important"><a href="javascript:void(0)" class="deleteSingleTask" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>';
              text += '</ul></div>';

              text += '<input type="hidden" name="'+page_open+'_prev_status_'+data.record.job_manage_id+'" id="'+page_open+'_prev_status_'+data.record.job_manage_id+'" value="'+data.record.status_id+'">';

              return '<div class="center">'+text+'</div>';
            }
          }

        }
      });
    }//service id gretter than 9 end

  }//page_open 2 end

  if(page_open == 3){

    if(service_id == 1){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.registration_number;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          vat_number: {
            title: 'Vat Number',
            width: '4%',
            display:function(data){
              return '<div class="center">'+data.record.vat_number+'</div>';
            }
          },
          ret_frequency: {
            title: 'Frequency',
            width: '2%',
            display:function(data){
              return '<div class="center">'+data.record.ret_frequency+'</div>';
            } 
          },
          return_date: {
            title: 'Return',
            width: '1%',
            display: function(data) {
              return '<div class="center">'+data.record.return_date+'</div>';
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          filling_date: {
            title: 'Filing Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              var text = data.record.filling_date;
              return '<div class="center">'+text+'</div>';
            }
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data) {
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }
        }
      });
    }// service 1 end

    if(service_id == 2){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.registration_number;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          vat_number: {
            title: 'Vat Number',
            width: '4%',
            display:function(data){
              return '<div class="center">'+data.record.vat_number+'</div>';
            }
          },
          ret_frequency: {
            title: 'Frequency',
            width: '2%',
            display:function(data){
              return '<div class="center">'+data.record.ret_frequency+'</div>';
            } 
          },
          ecsl_freq: {
            title: 'Quarter',
            width: '1%',
            display: function(data) {
              return '<div class="center">'+data.record.ecsl_freq+'</div>';
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="2"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          filling_date: {
            title: 'Filing Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              var text = data.record.filling_date;
              return '<div class="center">'+text+'</div>';
            }
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data){
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }
        }
      });
    }// service 2 end

    if(service_id == 3){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            sorting:false,
            display:function(data){
              return data.record.registration_number;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          last_acc_madeup_date: {
            title: 'Last Accounts Date',
            width: '4%',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="change_last_date" data-client_id="'+data.record.client_id+'" data-tab="3" data-key="'+data.record.key+'" id="3_dateanchore_'+data.record.key+'" data-prev_date="'+data.record.last_acc_madeup_date+'">'+data.record.last_acc_madeup_date+'</a>';
                text += '<span class="3_save_made_span_'+data.record.key+'"  style="display:none;">';
                text += '<input type="text" class="made_up_date" id="3_made_up_date_'+data.record.key+'" />;'
                text += '<a href="javascript:void(0)" class="search_t save_made_date" data-client_id="'+data.record.client_id+'" data-tab="3" data-key="'+data.record.key+'" data-field_name="last_acc_madeup_date" data-step_id="1">Save</a>';
                text += '<a href="javascript:void(0)" class="search_t cancel_made_date" data-client_id="'+data.record.client_id+'" data-tab="3" data-key="'+data.record.key+'">Cancel</a>';
                text += '</span>';
              return '<div class="center">'+text+'</div>';
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              //var text = '<a href="javascript:void(0)" class="search_t open_notes_popup" data-client_id="'+data.record.client_id+'" data-is_completed="'+data.record.is_completed+'" data-job_status_id="'+data.record.job_status_id+'" data-tab="3"><span '+border+'>notes</span></a>';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="3"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          filling_date: {
            title: 'Filing Date',
            width: '4%',
            sorting:false,
            display: function(data) {
              var text = data.record.filling_date;
              return '<div class="center">'+text+'</div>';
            }
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data) {
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }

        }
      });
    }

    if(service_id == 4){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          job_due_date: {
            title: 'Job Due Date',
            width: '4%',
            sorting:false,
            display:function(data){
              return '<div class="center">'+data.record.job_due_date+'</div>';
            }
          },
          completion_date: {
            title: 'Completion Date',
            width: '2%',
            sorting:false,
            display:function(data){
              return '<div class="center">'+data.record.completion_date+'</div>';
            } 
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data) {
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }
        }
      });
    }//service 4 end

    if(service_id == 5){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            display:function(data){
              return data.record.registration_number;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          ct_reference: {
            title: 'CT. Reference',
            width: '4%',
            display:function(data){
              var text = (data.record.tax_reference_type == 'C')?data.record.tax_reference:'';
              return "<div class='center'>"+text+"</div>";
            }
          },
          tax_return: {
            title: 'Tax Return Period',
            width: '4%',
            sorting:false,
            display:function(data){
              var tax_return_start = data.record.tax_return_start;
              var text = '<a href="javascript:void(0)" class="tax_return_modal tax_return_'+data.record.client_id+'" data-client_id="'+data.record.client_id+'" data-tax_return_start="'+tax_return_start+'" data-action="TRP">';
              if(tax_return_start.length >0){
                text += data.record.tax_return;
              }else{
                text += 'Add..';
              }
              text += '</a>';
              return "<div class='center'>"+text+"</div>";
            } 
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="3"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          filling_date: {
            title: 'Filing Date',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = data.record.filling_date;
              return '<div class="center">'+text+'</div>';
            }
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data) {
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }
        }
      });
    }//service 5 end

    if(service_id == 6){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            display:function(data){
              return data.record.registration_number;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          period_end: {
            title: 'Period End',
            width: '4%',
            display:function(data){
              var text = data.record.period_end;
              return "<div class='center'>"+text+"</div>";
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="3"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          completion: {
            title: 'Completion Date',
            width: '2%',
            sorting:false,
            display:function(data){
              return '<div class="center">'+data.record.completion+'</div>';
            } 
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data) {
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }
        }
      });
    }//service 6 end

    if(service_id == 7){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          client_name: {
            title: 'Client Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          ni_number: {
            title: 'NI Number',
            width: '4%',
            display:function(data){
              var text = (data.record.client_type == 'ind')?data.record.ni_number:'N/A';
              return "<div class='center'>"+text+"</div>";
            }
          },
          tax_reference: {
            title: 'Tax Reference',
            width: '4%',
            display:function(data){
              var text = (data.record.tax_reference_type == 'I')?data.record.tax_reference:'';
              return "<div class='center'>"+text+"</div>";
            }
          },
          return_date: {
            title: 'Tax Year',
            width: '4%',
            display:function(data){
              var text = data.record.return_date;
              return "<div class='center'>"+text+"</div>";
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="3"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          filling_date: {
            title: 'Filing Date',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = data.record.filling_date;
              return '<div class="center">'+text+'</div>';
            }
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data) {
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }
        }
      });
    }//service 7 end

    if(service_id == 8){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          return_date: {
            title: 'Job',
            width: '4%',
            display:function(data){
              var text = data.record.return_date;
              return "<div class='center'>"+text+"</div>";
            }
          },
          completion_date: {
            title: 'Completion Date',
            width: '2%',
            sorting:false,
            display:function(data){
              return '<div class="center">'+data.record.completion_date+'</div>';
            } 
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data) {
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }
        }
      });
    }//service 8 end

    if(service_id == 9){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          registration_number: {
            title: 'CRN',
            width: '3%',
            display:function(data){
              return data.record.registration_number;
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          next_return: {
            title: 'Next Return',
            width: '3%',
            sorting:false,
            display:function(data){
              var text = data.record.next_return;
              return "<div class='center'>"+text+"</div>";
            }
          },
          made_up_date: {
            title: 'Last Return Date',
            width: '4%',
            display:function(data){
              var text = data.record.period_end;
              return "<div class='center'>"+text+"</div>";
            }
          },
          notes: {
            title: 'Notes',
            width: '2%',
            sorting:false,
            display: function(data) {
              var notes = data.record.notes;
              var border = (notes.length >0)?'style="border-bottom:3px dotted #3a8cc1 !important"':'';
              var text = '<a href="javascript:void(0)" class="notes_btn open_notes_popup" data-client_id="'+data.record.client_id+'" data-manage_id="'+data.record.job_manage_id+'" data-tab="3"><span '+border+'>notes</span></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          filling_date: {
            title: 'Filing Date',
            width: '3%',
            sorting:false,
            display: function(data) {
              var text = data.record.filling_date;
              return '<div class="center">'+text+'</div>';
            }
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data) {
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }
        }
      });
    }//service 9 end

    if(service_id > 9){
      $('#tasksThirdTable').jtable({
        paging: true,
        sorting: true,
        pageSize: 10,
        defaultSorting: 'client_name ASC',

        actions: {
          listAction: '/jtable/action?action=tasksThirdTable&service_id='+service_id+'&page_open='+page_open
        },
        fields: {
          task_id: {
            title: 'Action',
            width: '1%',
            sorting:false,
            display:function(data){
              var text = '<a href="javascript:void(0)" class="delete_completed_task" data-client_id="'+data.record.client_id+'" data-tab="3" data-task_id="'+data.record.task_id+'" data-manage_id="'+data.record.job_manage_id+'"><img src="/img/cross.png" height="12"></a>';
              return '<div class="center">'+text+'</div>';
            }
          },
          client_name: {
            title: 'Business Name',
            display:function(data){
              var text = '<a href="javascript:void(0)" class="openTaskPop" data-client_id="'+data.record.client_id+'" data-service_id="'+data.record.service_id+'">'+data.record.client_name+'</a>';
              return text;
            }
          },
          job_due_date: {
            title: 'Job Due Date',
            width: '4%',
            sorting:false,
            display:function(data){
              return '<div class="center">'+data.record.job_due_date+'</div>';
            }
          },
          completion_date: {
            title: 'Completion Date',
            width: '2%',
            sorting:false,
            display:function(data){
              return '<div class="center">'+data.record.completion_date+'</div>';
            } 
          },
          timesheet_check: {
            title: 'Time Sheet',
            width: '3%',
            sorting:false,
            display: function(data) {
              var timesheet_check = data.record.timesheet_check;
              if(timesheet_check != 'Y'){  
                var text = '<a href="javascript:void(0)" class="addTimeSheet" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" data-filling_date="'+data.record.filling_date+'">Add..</a>';
              }else{
                var text = '<a href="javascript:void(0)" data-client_id="'+data.record.client_id+'" data-completed_id="'+data.record.task_id+'" class="viewTimeSheet">Completed</a>';
              }
              return '<div class="center" id="addTimeSheet'+data.record.task_id+'">'+text+'</div>';
            }
          }
        }
      });
    }// custom tasks end

  }//page_open 3 end








  


  $('#tasksFirstSearchButton,#tasksSecondSearchButton,#tasksThirdSearchButton').click(function(e){
    e.preventDefault();
    refresh_table();
  });
  $('#tasksFirstSearchText, #tasksSecondSearchText, #tasksThirdSearchText').keyup(function (e) {
    e.preventDefault();
    refresh_table();
  });

  if(page_open == 1){
    $('#tasksFirstSearchButton').click();
  }else if(page_open == 2){
    $('.centerHead').closest('.jtable-column-header-container').css({'text-align':'center'});
    $('#tasksSecondSearchButton').click();
  }else if(page_open == 3){
    $('#tasksThirdSearchButton').click();
  }
  

// check all check box
  $('.CheckallCheckbox').click(function (e) {
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
  $('.deletetasksFirstData').click(function (e) {
    var val = [];
    $(".tasksFirstCheckbox:checked").each( function (i) {
      if($(this).is(':checked')){
        val[i] = $(this).val();
      }
    });
    
    //console.log(val);alert(val.length);return false;
    if(val.length>0){
      if(confirm("Do you want to delete?")){
        $.ajax({
          type: "POST",
          url: '/crm/delete-tasks',
          data: { 'ids' : val },
          beforeSend: function() {
            $("#message_div").html('<div class="show_loader"><img src="/img/spinner.gif" /></div>');
          },
          success : function(resp){
            $("#message_div").html('');
            refresh_table();
          }
        });
      }
    }else{
      alert('Please select atleast one row');
    }
  });


  


  
  









  /* ################# Filter By Staff Start ################### */
  $(".filter_by_staff").change(function(){
    var staff_id    = $(this).val();
    var service_id  = $("#service_id").val();
    //var serv = ['1','2','3','4','5','6','9'];

    $.ajax({
      type: "POST",
      url: '/jobs/update-staff-filter',
      data: { 'staff_id' : staff_id, 'service_id' : service_id },
      success : function(resp){ 
        refresh_table();
        /*if($.inArray(service_id, serv) > '-1'){
          refresh_table();
        }else{
          window.location.reload();
        }*/
      }
    });
      
  });
  /* ################# Filter By Staff Start ################### */

  /* ################# Job Status Change Start ################### */
  $("body").on('click', '.jobStatusChange', function(){
      var service_id  = $("#service_id").val();
      var client_id   = $(this).data("client_id");
      var manage_id   = $(this).data("manage_id");
      var status_id   = $(this).data("step_id");
      var page_open   = $("#page_open").val();
      var status_name = $(this).html();

      var prev_status = $("#"+page_open+"_prev_status_"+manage_id).val();
      //alert("val.length");return false;
      if(status_id != 2)
      {
        $.ajax({
          type: "POST",
          dataType : 'json',
          url: '/jobs/change-job-status',
          data: { 'service_id':service_id,'manage_id':manage_id, 'client_id':client_id, 'status_id' : status_id },
          success : function(resp){
            $("#"+page_open+"_prev_status_"+manage_id).val(status_id);
            $(".JobStatusTd_"+manage_id).html(status_name.toUpperCase());

            var jobs_steps = resp.jobs_steps;
            var select = '<option value="1">Show All ['+resp.all_count+']</option>';
            select += '<option value="2">Not Started ['+resp.not_started_count+']</option>';
            $.each(jobs_steps, function(k,v){
              select += '<option value="'+v.step_id+'">'+v.title+' ['+v.count+']</option>';
            });
            $('#statusFilterDrop').html(select);
          }
        });
      }else{
          $('#'+page_open+'_status_dropdown_'+client_id).val(prev_status);
          alert("There are some problem to change status");
          return false;
      }
  });
  /* ################# Delete to Task Management End ################### */

  /* ################# Delete Single Task Management Start ################### */
  $("body").on('click', '.deleteSingleTask', function(e){
    var client_id   = $(this).data('client_id');
    var manage_id   = $(this).data('manage_id');
    var service_id  = $("#service_id").val();
    var page_open   = $("#page_open").val();
    if(!confirm('Do you want to delete this tasks?')){
      return false;
    }

    $.ajax({
      type: "POST",
      dataType:'json',
      url: '/jobs/delete-single-task',
      data: {'client_id':client_id,'service_id':service_id,'manage_id':manage_id },
      success : function(resp){
        refresh_table();
        var jobs_steps = resp.jobs_steps;
        var select = '<option value="1">Show All ['+resp.all_count+']</option>';
        select += '<option value="2">Not Started ['+resp.not_started_count+']</option>';
        $.each(jobs_steps, function(k,v){
          select += '<option value="'+v.step_id+'">'+v.title+' ['+v.count+']</option>';
        });
        $('#statusFilterDrop').html(select);
      }
    });
  });
  /* ################# Delete Single Task Management End ################### */

  /* ################# Filter By Staff Start ################### */
  $("#statusFilterDrop").change(function(){
    var status_id   = $(this).val();
    var service_id  = $("#service_id").val();
    var search      = $('#tasksSecondSearchText').val();

    var serv = ['1','2','3','4','5','6','7','8','9'];
    if($.inArray(service_id, serv) > '-1' || service_id >9){
      $('#tasksSecondTable').jtable('load', { search:search, status_id: status_id });
    }
  });
  /* ################# Filter By Staff Start ################### */





});

function refresh_table()
{
  var page_open = $('#page_open').val();
  if(page_open == 1){
    $('#tasksFirstTable').jtable('load', { search: $('#tasksFirstSearchText').val() });
  }else if(page_open == 2){
    var search = $('#tasksSecondSearchText').val();
    $('#tasksSecondTable').jtable('load', { search:search, status_id:1 });
    
  }else if(page_open == 3){
    $('#tasksThirdTable').jtable('load', { search: $('#tasksThirdSearchText').val() });
  }
}