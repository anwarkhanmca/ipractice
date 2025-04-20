@extends('layouts.layout') 
@section('mycssfile')
<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
<link href="{{URL::asset('css/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/jquery.form.js') }}" type="text/javascript"></script> 
<script src="{{ URL :: asset('js/plugins/jquery.quicksearch.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/staff_appraisal.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/kbase.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->

<!-- page script -->
<script type="text/javascript">
$(function() {
  $('input#id_search').quicksearch('.notes_points ul li');
});
</script>
<!-- <script src="{{ URL :: asset('tinymce/tinymce.min.js') }}"></script> -->
<script src="{{ URL :: asset('js/plugins/jquery.quicksearch.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('ckeditor/ckeditor.js') }}"></script>
<script>
    //var editor = CKEDITOR.replace( 'notesmsg' );
    var editor = CKEDITOR.replace( 'notesmsg',
    {
        filebrowserBrowseUrl : '/browser/browse.php',
        filebrowserUploadUrl : '/uploader/upload.php'
    });
</script>

<script src="{{ URL :: asset('js/page_loading.js') }}" type="text/javascript"></script> 
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
    <div style="margin:0 auto; width:33%; margin-left: 450px; float: left;">
    <strong class="search_t">Search Article</strong> &nbsp;	<input style=" padding: 3px; border: #ccc solid 1px;   width: 20em;" type="text" name="search" value="" id="id_search" placeholder="" autofocus="">
    </div>
    <div style="float: left; margin-left: 250px; ">
      <strong class="search_t"><a href="javascript:void(0)" class="head_tab" data-url="/hmrc/technicalupdates">TECHNICAL UPDATES</a></strong>
    </div>
    
     <div class="clearfix"></div>
    
      <div class="row">
      <div class="col-xs-12 col-xs-4"> 
                      <div class="col_m2">
                      <div class="noted_right"> <a id="addnotes_button" href="javascript:void(0)" >
                      <img src="/img/plus_1.png" class="icon_gap"  /> <strong class="notes_h_t">New Article </strong></a>
                      <div class="notes_points"> 
                     
                      <span class="notes_h_t">HOW TO</span>
                     
                    
                      
                      <ul id="newaddnotes">
                   @foreach($knowledge_notes as $key=>$kb_notes_row)
                      <li id="listtitle{{ $kb_notes_row->knowledgebase_id }}"><a data-id="{{ $kb_notes_row->knowledgebase_id }}" class="title_view" href="javascript:void(0)">
                   
{{ (strlen($kb_notes_row->title) > 40)? substr(strip_tags($kb_notes_row->title), 0, 40)."...": strip_tags($kb_notes_row->title) }}
                      
                      
                      </a></li>
                      
                      
                         
                      @endforeach 
                </ul>
                      
                     
                      
                      </div>
                      </div>
                      </div>
                      </div>
                      <div class="col-xs-12 col-xs-8">
                        <div class="col_m2 icon_poisition" >
                        
                        <div class="notes_innermsg_top" style="display:none;" >
                       {{ Form::open(array('url' => '/knowledgebase-notesinsert', 'files' => true,'id'=>'atricale', 'name'=>'atricale')) }} 
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
                <!-- <div class="twobox_1">
    							<i class="fa fa-attach">
    							</i>
    							Attachment
    							<input type="file" name="add_file" id="add_file">
    						</div> -->
                <div class="add_client_btn">
                  <button class="btn btn-danger" id="cancle_notes" type="button">Cancel</button>
                           <!-- <button class="btn btn-info"  type="submit">Edit</button> 
                           <button class="btn btn-success" id="" type="submit" >Save</button>-->
                           <button type="button" id="savenotes" class="btn btn-success"> Save</button>
                           
                          </div>
                
                   
                    <div class="clearfix"></div>
                    </div>
                    {{ Form::close() }} 
                        </div>
                        
                        
                    <div class="notes_inner" id="notes_font" style="overflow:scroll;">
                        <div class="notes_inner_top">
                        <img src="/img/icon_1.png" class="heading_icon" />
                        <div class="add_client_btn">
                        
                        
                    
                    
                    
                   <!--   <button type="button" id="editsave_notes" class="btn btn-success "> Save</button> -->
                       
                       
                       
                       <!-- <button class="btn btn-success" id="editsave_notes" >Save</button> -->
                        <button class="btn btn-info" id="editnotes"  type="button">Edit</button>
                        <a href="/knowledgebase" class="btn btn-primary">Cancel</a>
                        
                        <button type="button" id="delete_notes" class="btn btn-danger "> Delete</button>
                      <!--  <button class="btn btn-danger"  type="submit">Delete</button> -->
                        
                           
                          
                             <!--<button class="btn btn-danger back" type="button">Delete</button>
                            <button class="btn btn-info"  type="submit">Save</button>
                            <button class="btn btn-info open" data-id="7" type="button">Next</button> -->
                          </div>
                        <div class="n_top_left">
                        
                        <span class="n_heading">{{ $staffprof_notes['title'] or "" }}</span>
                       <input type="hidden" name="msgid" id="msgid" value=" {{ $staffprof_notes['knowledgebase_id'] or "" }}"/>
                    
                        <p><span class="n_heading_name">By {{$user['fname']}} {{$user['lname']}}</span> <span class="n_date">On: {{ $staffprof_notes['created'] or "" }}</span></p>
                        </div>
                        <div class="print">
                        
                        
                        
                        
                        
                       
                       
                       
                        </div>
                        <div class="clearfix"></div>
                        </div>
                        <p class="n_text">{{ $staffprof_notes['textmessage'] or "" }}</p>
                        <!--
                        <div class="add_client_btn">
                         <button class="btn btn-info" id="editnotes"  type="button">Edit</button>
                        <button type="button" id="delete_notes" class="btn btn-danger "> Delete</button>
                        <a href="/knowledgebase" class="btn btn-primary">Cancel</a>
                           
                          
                             
                          </div> -->
                           <div class="clearfix"></div>
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