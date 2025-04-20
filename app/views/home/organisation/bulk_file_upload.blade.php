@extends('layouts.layout')

@section('myjsfile')
<!-- http://hayageek.com/ajax-file-upload-jquery/ -->
<script src="{{ URL :: asset('js/ch_data.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.form.js') }}"></script>
<script type="text/javascript">
$(document).ready(function()
{
  var options = { 
    beforeSend: function() 
    {
        $("#upload_loader").html('<img src="/img/spinner.gif" />');
    },
    /*uploadProgress: function(event, position, total, percentComplete) 
    {
        $("#upload_loader").html('progress');
    },*/
    success: function(resp) 
    {
      var message;
      if(resp == "0"){
        message = "<font color='red'>There are some error to upload files</font>";
      }
      if(resp == "1"){
        message = "<font color='red'>Please ensure file contains a max of 100 rows</font>";
      }
      if(resp == "2"){
        message = "Client details has been uploaded successfully.";
        $("#upload_loader").html(message);
        window.location="{{URL::to('/organisation-clients')}}";
      }
      if(resp == "3"){
        message = "<font color='red'>Company number is not available in the file, please check.</font>";
      }
      $("#upload_loader").html(message);
    },
    /*complete: function(response) 
    {
        $("#upload_loader").html("complete");
    },*/
    error: function()
    {
        $("#upload_loader").html("<font color='red'>There are some error to upload files</font>");
 
    }
 
}; 
 
  $("#bulk_upload_form").ajaxForm(options);
 
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
      <div class="practice_mid">
       <div class="bulk_header">BULK UPLOAD - UNICORPORATED BUSINESSES</div>
          <div class="chdata_main">
            <div class="tab_topcon">
            {{ Form::open(array('url' => '/chdata/bulk-file-upload','files' => true,'id'=>'bulk_upload_form')) }}
            <input type="hidden" name="back_url" value="{{ $back_url or "" }}"> 
              <div class="import_search">
                <div class="import_search_box">
                  <input type="file" class="form-control" name="bulk_file" id="bulk_file">
                </div>
                <div class="import_search_btn">
                  <!-- <a href="javascript:void(0)" type="button" name="company_upload" id="company_upload" class="btn btn-warning">Upload</a> -->
                  <button type="submit" name="company_upload" id="company_upload" class="btn btn-warning">Upload</a>
                </div>
                <div class="import_search_btn">
                <!--   Max of 100 companies per upload -->
                 File must be in CSV format
                </div>
                <div class="top_search_con">
                  <!-- <button type="button" class="btn btn-info import_client">IMPORT</button> -->
                </div>
                <div class="clearfix"></div>
              </div>
              {{ Form::close() }}

              <div class="clearfix"></div>
              <div style="text-align: center; color:green; font-size: 20px;" id="upload_loader"></div>
            </div>

          </div>

        <div class="bulk_text"><!-- File must be in CSV format with the company numbers laid out in a single column, with no column heading. Please also ensure company number has the preceeding "0". --></div>
        <div>
        
        <a href="uploads/csvdemo.pdf" download="csvformart.csv">
                           Download sample </a>
        </div>
        
        
        
      </div>
    </section>
  

</aside><!-- /.right-side -->
            

@stop



