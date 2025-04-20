
<!-- jQuery 2.0.2 -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> -->
<script src="{{ URL :: asset('js/jquery-1.11.0.min.js') }}"></script>
<!-- jQuery UI 1.10.3 -->
<script src="{{ URL :: asset('js/jquery-ui-1.10.3.min.js') }}" type="text/javascript"></script>
<!-- Bootstrap -->
<script src="{{ URL :: asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- Morris.js charts -->
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>-->
<script src="{{ URL :: asset('js/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
<!-- Sparkline -->
<script src="{{ URL :: asset('js/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>
<!-- jvectormap -->
<script src="{{ URL :: asset('js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ URL :: asset('js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
<!-- iCheck -->
<script src="{{ URL :: asset('js/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

<!-- AdminLTE App -->
<script src="{{ URL :: asset('js/AdminLTE/app.js') }}" type="text/javascript"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="{{ URL :: asset('js/AdminLTE/dashboard.js') }}" type="text/javascript"></script> -->

<!-- Add By User -->
        
<script type="text/javascript" src="{{ URL :: asset('js/sites/jquery.autoSuggest.js') }}"></script> 

<!-- COLOR BOX JS -->
<script type="text/javascript" src="/file-and-sign/colorbox/jquery.colorbox.js"></script>
<script type="text/javascript" src="{{ URL :: asset('/js/contact_message.js') }}"></script>
<script type="text/javascript" src="{{ URL :: asset('/js/header.js') }}"></script>


<!-- jTable section -->
<link href="{{ URL :: asset('css/jtable/jquery-ui.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL :: asset('css/jtable/jtable.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ URL :: asset('js/jtable/jquery-ui-1.10.0.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jtable/jquery.jtable.js') }}" type="text/javascript"></script> 

<script type="text/javascript" src="{{ URL :: asset('js/jquery.form.js') }}"></script>       
        
<script type="text/javascript">
var idleTime = 0;
$(document).ready(function () {
/* ================== Logged User Access Validation ================== */
    $(".checkUserAccess").click(function(event) {
        var name = $(this).data('name');
        alert("Check permissions");
    });
/* ================== Logged User Access Validation ================== */


    //Increment the idle time counter every minute.
    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

    //Zero the idle timer on mouse movement.
    $(this).mousemove(function (e) {
        idleTime = 0;
    });
    $(this).keypress(function (e) {
        idleTime = 0;
    });
});

function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime >120) { // 20 minutes
        window.location.href = '/admin-logout';
    }
}
</script>  

   
        <!-- Add By User -->

@include('contact_report/contact')

<!-- ================== POP UP SECTION ====================== -->
<!-- Notes Pop Up -->
<div class="modal fade in" id="open_details-modal" tabindex="-1" role="dialog" aria-hidden="false">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="popup_border">
        <div class="modal-header">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
          <h5 class="modal-title" id="show_title"></h5>
          <div class="clearfix"></div>
        </div>
      
        <div class="modal-body">
          <div class="form-group">
          <!-- <label for="name">Description</label> -->
          <div class="data_show_box">
            
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style type="text/css">
  #manage_notification-modal .icheckbox_minimal{ width: 0; margin-left: 0px;}
  #manage_notification-modal table td{ height: 35px; }
</style>
<!-- Manage Notifications Pop Up -->
<div class="modal" id="manage_notification-modal" tabindex="-1" role="dialog" aria-hidden="false">
  <div class="modal-dialog" style="width:330px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h5 class="modal-title">Manage all on-screen and email notifications</h5>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <table style="width: 100%">
          <tr>
            <td style="width: 80%;"><a>Client information changes</a></td>
            <td><input type='checkbox' class="notCheck" value='client' {{ in_array('client', $notifications)?'':'checked' }} /></td>
          </tr>
          <tr>
            <td><a>Staff information changes</a></td>
            <td><input type='checkbox' class="notCheck" value='staff' {{ in_array('staff', $notifications)?'':'checked' }} /></td>
          </tr>
          <tr>
            <td><a>Time off request & status changes</a></td>
            <td><input type='checkbox' class="notCheck" value='status_change' {{ in_array('status_change', $notifications)?'':'checked' }} /></td>
          </tr>
          <tr>
            <td><a>To do tasks allocation</a></td>
            <td><input type='checkbox' class="notCheck" value='todo_tasks' {{ in_array('todo_tasks', $notifications)?'':'checked' }} /></td>
          </tr>
          <!-- <tr>
            <td><a>Client list allocations</a></td>
            <td><input type='checkbox' class="notCheck" name='checkbox5' checked /></td>
          </tr>
          <tr>
            <td><a>Tasks deadlines</a></td>
            <td><input type='checkbox' class="notCheck" name='checkbox6' checked /></td>
          </tr> -->
        </table>
      </div>

    </div>
  </div>
</div>

<script src="{{ URL :: asset('js/bootstrap-switch.js') }}" ></script>
<script>
$(".notCheck").change(function() {
  var type = $(this).val();
  if($(this).is(':checked')){
    var position = 'checked';
  }else{
    var position = 'unchecked';
  }
  $.ajax({
    type: "POST",
    dataType: "json",
    url: '/common/action',
    data: { 'type':type, 'position':position, 'action':'manageNotification' },
    success : function(resp){
      location.reload();
    }
  });
});

$(".notCheck").bootstrapSwitch({
    size: 'xs'
});
/*$("[name='checkbox1']").bootstrapSwitch({
  on: 'On',
  off: 'Off ',
  onLabel: '&nbsp;&nbsp;&nbsp;',
  offLabel: '&nbsp;&nbsp;&nbsp;',
  same: false,//same labels for on/off states
  size: 'md',
  onClass: 'primary',
  offClass: 'default'
});*/

</script>  