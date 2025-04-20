@extends('layouts.layout')

@section('mycssfile')
<style>
/* .leads_tab li h3{ color:#fff; background: #000; font-size: 13px; padding: 8px 0 !important; margin: 0 0 0px 0!important; cursor: text;} */
.table_popup tr td{padding:10px;}
.yes_btn{background: green; color:#fff; float: left; border: none; outline: none; padding:5px 15px 5px 15px;}
.no_btn{background: gray; color:#fff; float: left; border: none; outline: none; padding:5px 15px 5px 15px;}

  .job_send_btn, .job_sent_btn{ margin-bottom: 5px; margin-top: 5px;}


</style>

<link href="{{URL :: asset('css/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->

<!-- Loader Css -->
<link href="{{URL :: asset('css/loader.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('ckeditor/ckeditor.js') }}"></script>

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->
<script src="{{ URL :: asset('js/forecast.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/reminder_notification.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/jquery.quicksearch.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<!-- page script -->

<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<!-- <script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script> -->
<script src="{{ URL :: asset('js/jquery.price_format.2.0.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('tinymce/tinymce.min.js') }}"></script>

<script type="text/javascript">

  $(function() {
    var page_open = '{{ $page_open }}';

    $('#example11').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": false},
        /*{"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},*/
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'asc']]
    });
    
    $('#example12').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'asc']]
    });
    
    $('#example21').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'asc']]
    });
    
    $('#example22').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'asc']]
    });
    
    $('#example3').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'asc']]
    });
  
        

});

</script>

<script src="{{ URL :: asset('js/graph.js') }}" type="text/javascript"></script>

<style type="text/css">
  svg:not(:root){overflow: inherit; margin-right: 20px; float:right;}

</style>
@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas {{ $left_class }}">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            @include('layouts.inner_leftside')
        </section>
        <!-- /.sidebar -->
    </aside>

<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side {{ $right_class }}">
  
    <!-- Content Header (Page header) -->
    @include('layouts.below_header')

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="practice_hed">
        <div class="top_bts">
          <ul>
            <li>
          <a href="/pdfcrm/{{ base64_encode($page_open) }}" class="btn btn-success" style=""><i class="fa fa-download"></i> Generate PDF</a>
             <!-- <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button> -->
            </li>
            <li>
             <a href="/excelcrm/{{ base64_encode($page_open) }}" class="btn btn-primary" style=""><i class="fa fa fa-file-text-o"></i> Excel</a>
           <!--   <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button> -->
            </li>
            <div class="clearfix"></div>
          </ul>
        </div>

        <div id="message_div"><!-- Loader image show while sync data --></div>
      </div>

      

  </div>
  <div class="practice_mid">
    <input type="hidden" name="page_open" id="page_open" value="{{ $page_open or '' }}">
<div class="tabarea">
  
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-tabsbg">
      <li class="{{ ($tab_no == 1)?'active':'' }}"><a href="{{ $goto_url or '' }}/11">DEADLINE REMINDERS</a></li>
      <!-- <li class="{{ ($tab_no == 2)?'active':'' }}"><a href="{{ $goto_url or '' }}/21">TASKS STATUS NOTIFICATIONS</a></li> -->
      <li class="{{ ($tab_no == 3)?'active':'' }}"><a href="{{ $goto_url or '' }}/3">CLIENT DATA CHANGES NOTIFICATION</a></li>
    </ul>

<div class="tab-content">
  <!-- Tab 1 Start-->
  <div id="tab_11" class="tab-pane {{ ($tab_no == 1)?'active':'' }}">
    @include('settings/reminder_notification/includes/tabone')
  </div>
<!-- Tab 1 End-->

<!-- Tab 2 Start-->
  <div id="tab_2" class="tab-pane {{ ($tab_no == 2)?'active':'' }}">
      @include('settings/reminder_notification/includes/tabtwo')
  </div>
<!-- Tab 2 End-->

<!-- Tab 3 Start-->
  <div id="tab_3" class="tab-pane {{ ($tab_no == 3)?'active':'' }}">
      @include('settings/reminder_notification/includes/tabthree')
  </div>
<!-- Tab 3 End-->      

</div>

</div>
          

</div>
        
      </div>
    </section>


</aside><!-- /.right-side -->


<!-- Modal Pop Up Start -->
<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="template11-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:60%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">EDIT REMINDER EMAIL</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/reminder/save-template', 'id'=>'field_form')) }}
    <input type="hidden" name="id" id="id" value="">
    <input type="hidden" name="action" id="action" value="get">
    
    <input type="hidden" name="tempServiceName" id="tempServiceName" value="">
    <input type="hidden" name="tempPracticeName" id="tempPracticeName" value="">
    <input type="hidden" name="tempTelephone" id="tempTelephone" value="">
    <input type="hidden" name="tempFname" id="tempFname" value="">
    
    
      <div class="modal-body">
          <!-- <table  width="100%">
            <tr>
                <td style="height: 40px;">Send the first reminder</td>
                <td width="50%"><input type="text" class="small_txtbox"> days after task has been sent to the tasks section</td>
            </tr>
            <tr>
                <td style="height: 35px;">Frequency of reminders</td>
                <td><a href="javascript:void(0)">Every 7 day(s) <img src="/img/cross.png" height="14"></a></td>
            </tr>
            <tr>
                <td style="height: 35px;">Stop sending reminders when tasks are at the</td>
                <td><div style="float: left; width: 50%; margin-right: 8px;">
                    <select class="form-control newdropdown showStatusDrop">
                        <option value="">Not Started</option>
                    </select>
                    </div>
                    <div style="float: left;">stage</div>
                </td>
            </tr>
        </table> -->
        <div class="show_loader"></div>
          
        <div class="form-group">
          <label for="subject">Subject</label>
          <input type="text" class="form-control" name="subject" id="subject">
        </div>

        <div class="form-group">
          <label for="template_message">Template</label>
          <textarea name="template_message" id="template_message" cols="40" rows="20" class="form-control"></textarea>
        </div>
        
          <div class="modal-footer" style="padding-right: 0px;">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-info pull-right save_template" name="save">Save</button>
        </div>
      </div>
    {{ Form::close() }}
  </div>
  </div>
</div>

@stop



