@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .bottom_space{ height: 50px;}
</style>
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/letter_email.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->
<script src="{{ URL :: asset('ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
  $(window).load(function() {
    
    CKEDITOR.replace( 'add_message',
    { 
        toolbar :[['Source'],['Cut','Copy','Paste','PasteText','SpellChecker'],['Undo','Redo','-','SelectAll','RemoveFormat'],['CreatePlaceholder'],[ 'Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink' ], ['SpecialChar','PageBreak']],
       
        //extraPlugins : 'wordcount',
        extraPlugins : 'wordcount,placeholder',
        //height: '400px',
        wordcount : {
            showCharCount : true,
            showWordCount : true
            
            
        }
    });
    
    
   
});





</script>
@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @include('layouts.outer_leftside')
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side  {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')

                <!-- Main content -->
                <section>
                <div class="eml_pan" style="padding: 20px;">
                
                <div style="margin: 0px auto; width:650px;">
                
                     <div class="form-group">
                    <p id="notes_error1"></p>
                <label for="exampleInputPassword1">Title</label>
                 
                   <input type="text" value="" class="form-control" id="editnotestitle" name="notestitle" style="width:650px;"/>
                
              
              </div>
              
              
              
                  
                  
                  <div class="form-group">
                <label for="exampleInputPassword1">Message</label>
                  
                  <p></p><textarea rows="30" id="add_message" cols="88"></textarea></p>
                
                
                
                
                
                
                
                </div>
                </div>
                
                </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->





       
      
<!-- Add to Group modal end -->

@stop