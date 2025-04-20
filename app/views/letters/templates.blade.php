<!-- By PK -->

@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

@stop

@section('myjsfile')
<!--<script src="http://cdn.ckeditor.com/4.5.2/standard-all/ckeditor.js"></script>-->
<script src="{{url('ckeditor/ckeditor.js')}}"></script>
<script type="text/javascript" src="{{url()}}/js/contact_email_templates.js"></script>
<script src="{{ URL :: asset('js/template_type.js') }}" type="text/javascript"></script>

  <!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
  $('#tab1').dataTable({
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
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false}
    ],
    "aaSorting": [[1, 'desc']]
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
      <div class="show_loader"><!-- Ajax Loader --></div>
      <div class="tabarea">
        <div class="tab_topcon">
          <div class="top_bts" style="float:left;">
            <ul style="padding:0;">
              <li>
                <a class="btn btn-success" target="_blank" href="/email/template/add">
                <!-- <a class="btn btn-success" target="_blank" href="/letters/template-action">  -->
                <i class="fa fa-plus"></i> Add template</a>
              </li>
              <div class="clearfix"></div>
            </ul>
          </div>
          <div class="top_search_con">
           <div class="top_bts">
            <ul style="padding:0;">

              <div class="clearfix"></div>
            </ul>
          </div>
          </div>
          <div class="clearfix"></div>
        </div>
      
      <div class="box-body table-responsive">
        <table class="table table-bordered table-hover dataTable" id="tab1" width="100%">
          <thead>
            <tr role="row">
              <th width="5%" style="text-align: center;"><input type="checkbox" class="allCheckSelect"></th>
              <th width="15%" >Date</th>
              <th width="20%" >Created by</th>
              <th>Title</th>
              <th width="6%">Action</th>
            </tr>
          </thead>

          <tbody>
          @if(isset($templates) && count($templates) >0)
            @foreach($templates as $key=>$itemValue)
            <tr class="del_tabletr_{{$itemValue['id']}}">
              <td align="center"><input type="checkbox" class="checkbox ads_Checkbox" name="checkbox[]" id="cst_{{$itemValue['id']}}" value="{{$itemValue['id']}}" /></td>
              <td>{{ date('d-m-Y H:i a', strtotime($itemValue['created'])) }}</td>
              <td>{{ $itemValue['user_name'] or '' }}</td>
              <td><a href="javascript:void(0)" class="openTaskPop">{{$itemValue['subject'] or ''}}</a></td>
              <td>
              <div style="width: 22px;">
                <div class="customDrop">
                  <div class="dropdown action-menu">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:5px;">
                    <img src="/img/arrows.png">
                    </a>
                  
                    <ul class="dropdown-menu">
                      <li> 
                        <div style="float: left; margin:0 6px 6px 6px;">
                          <img src="/img/edit_icon.png">
                        </div>
                        <div style="float: left; cursor: pointer;" data-template_id="{{$itemValue['id']}}" class="EditContactTemplate">Edit</div>
                        <div class="clearfix"></div>
                      </li>
                      <li>
                        <div style="float: left; margin:0 6px 6px 6px;">
                          <img src="/img/copy.png">
                        </div>
                        <div style="float: left; cursor: pointer;" data-template_id="{{$itemValue['id']}}" class="copyContactTemplate">Copy</div>
                        <div class="clearfix"></div>
                      </li>
                      <li>
                        <div style="float: left; margin:0 6px;">
                          <img src="/img/deleteBtn.png">
                        </div>
                        <div style="float: left; cursor: pointer;" data-template_id="{{$itemValue['id']}}" class="deleteContactTemplate">Delete
                        </div>
                        <div class="clearfix"></div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              </td>
            </tr>
            @endforeach
          @endif
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <div class="clearfix"></div>
          
  
      </div>
    </section>
    <!-- /.content -->
  </aside>
            <!-- /.right-side -->
        
  </div>

        <!-- ./wrapper --> 

@stop



