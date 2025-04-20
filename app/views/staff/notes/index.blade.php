@extends('layouts.layout') 
@section('mycssfile')
<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
  <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/staff_appraisal.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/staff_notes.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->

<!-- page script -->
<script type="text/javascript">
/*
$(".date_of_meeting").datepicker({minDate: new Date(1900, 12-1, 25), dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});

var Table1, Table2;
$(function() {//date_of_meeting
  Table1 = $('#example1').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true}
        ]

    });
  //Table1.fnSort( [ [1,'asc'] ] );
  Table2 = $('#example2').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
            {"bSortable": false},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true}
        ]

    });
});
*/
</script>
<script src="{{ URL :: asset('tinymce/tinymce.min.js') }}"></script>

<script type="text/javascript">

/*
tinymce.init({
    selector: "#notesmsg",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code" ]
});
*/
</script>





@stop

@section('content')
 <div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas {{ $left_class }}">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            @include('layouts/inner_leftside')

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
                      <div class="col-xs-12 col-xs-8">
                        <div class="col_m2 icon_poisition" >
                        
                        <div class="notes_innermsg_top" style="display:none;" >
                      <!--   {{ Form::open(array('url' => '/org-notes', 'files' => true)) }} -->
                         <img src="/img/icon_1.png" class="heading_icon">
                  
                    <div id="demo" >
                    <p id="notes_error"></p>
                    <div class="form-group">
                <label for="exampleInputPassword1">Title</label>
                
                   <input type="text" name="notestitle" id="notestitle" class="form-control" />
                
              
              </div>
                    
                    <div class="form-group">
                <label for="exampleInputPassword1">Message</label>
                <textarea name="notesmsg" rows="15" cols="20" id="notesmsg" class="form-control"></textarea>
                </div>
                
                <div class="add_client_btn">
                            <button class="btn btn-danger" id="cancle_notes" type="button">Cancel</button>
                           <!-- <button class="btn btn-info"  type="submit">Edit</button> 
                           <button class="btn btn-success" id="" type="submit" >Save</button>-->
                           <button type="button" id="savenotes" class="btn btn-success"> Save</button>
                           
                          </div>
                
                   
                    <div class="clearfix"></div>
                    </div>
                   <!-- {{ Form::close() }} -->
                        </div>
                        
                        
                    <div class="notes_inner" id="notes_font" style="overflow:scroll;">
                        <div class="notes_inner_top">
                        <img src="/img/icon_1.png" class="heading_icon" />
                        <div class="n_top_left" >
                        <span class="n_heading">{{ $staffprof_notes['title'] or "" }}</span>
                       <input type="hidden" name="msgid" id="msgid" value=" {{ $staffprof_notes['staffprofnotes_id'] or "" }}"/>
                    
                        <p><span class="n_heading_name">By {{$user['fname']}} {{$user['lname']}}</span> <span class="n_date">On: {{ $staffprof_notes['created'] or "" }}</span></p>
                        </div>
                        <div class="print">
                        
                        
                        
                        
                        
                        
                       
                       
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        <p class="n_text">{{ $staffprof_notes['textmessage'] or "" }}</p>
                        
                        <div class="add_client_btn">
                        
                        
                    
                    
                    
                   <!--   <button type="button" id="editsave_notes" class="btn btn-success "> Save</button> -->
                       
                       
                       
                       <!-- <button class="btn btn-success" id="editsave_notes" >Save</button> -->
                        <button class="btn btn-info" id="editnotes"  type="button">Edit</button>
                        
                        
                        <button type="button" id="delete_notes" class="btn btn-danger "> Delete</button>
                      <!--  <button class="btn btn-danger"  type="submit">Delete</button> -->
                        <a href="/staff-profile" class="btn btn-primary">Cancel</a>
                           
                          
                             <!--<button class="btn btn-danger back" type="button">Delete</button>
                            <button class="btn btn-info"  type="submit">Save</button>
                            <button class="btn btn-info open" data-id="7" type="button">Next</button> -->
                          </div>
                           <div class="clearfix"></div>
                 </div>
                        
                        </div>
                      </div>
                      <div class="col-xs-12 col-xs-4"> 
                      <div class="col_m2">
                      <div class="noted_right"> <a id="addnotes_button" href="javascript:void(0)" >
                      <img src="/img/plus_1.png" class="icon_gap"  /> <strong class="notes_h_t">New Notes</strong></a>
                      <div class="notes_points"> 
                      <span class="notes_h_t">NOTES</span>
                     
                    
                      
                      <ul id="newaddnotes">
                     @foreach($staffs_notes as $key=>$staffs_notes_row)
                      <li id="listtitle{{ $staffs_notes_row->staffprofnotes_id }}"><a data-id="{{ $staffs_notes_row->staffprofnotes_id }}" class="title_view" href="javascript:void(0)">
                   
                      
                      
{{ (strlen($staffs_notes_row->title) > 40)? substr(strip_tags($staffs_notes_row->title), 0, 40)."...": strip_tags($staffs_notes_row->title) }}
                      
                      
                      
                      
                      </a></li>
                      @endforeach
                     <!-- <li><a href="#">How does TB coder work</a></li>
                      <li><a href="#">Is TB coder a Secure site?</a></li>
                      <li><a href="#">Sign Up for a TB coder account</a></li>
                      <li><a href="#">How can I sin up for TB coder</a></li>
                      <li><a href="#">For which contries is TB coder available?</a></li>
                      <li><a href="#">Does TB coder work any accounts</a></li> -->
                      </ul>
                      
                     
                      
                      </div>
                      </div>
                      </div>
                      </div>
                    </div>

    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>
<!-- ./wrapper -->


@stop
<!-- staff-->