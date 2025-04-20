<!-- By PK -->

@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL :: asset('css/jquery-ui.css') }}" rel="stylesheet" type="text/css" />

@stop

@section('myjsfile')
<script type="text/javascript" src="{{url()}}/js/letter_heads.js"></script>
<script type="text/javascript" src="{{url()}}/js/jquery.ui.dialog.js"></script>

  <!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){
  $('#tab1').dataTable({
    "bPaginate": false,
    "bLengthChange": false,
    "bFilter": false,
    "bSort": true,
    "bInfo": false,
    "bAutoWidth": false,
    "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "iDisplayLength": 25,

    "aoColumns":[
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false}
    ],
    "aaSorting": [[1, 'desc']]
  });

});

$('body').on('click', '.viewLetterHead', function(){
    $('#pdfrm').attr('src', '/letter_heads/'+$(this).data('lhead_name'));
    $("#prevdialog").dialog({
      width: 600,
      height: 700,
      modal: true,
      close: function() {
        $("#prevdialog").dialog( "destroy" );
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
        @if(isset($letterheads) && count($letterheads) < 5)
        <div class="tab_topcon">
          <div class="top_bts" style="float:left;">
            <ul style="padding:0;">
              <li>
                <a class="btn btn-success" href="/letters/letter-head/add">
                <i class="fa fa-plus"></i> Add letterhead </a>
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
        @endif
      <div class="box-body table-responsive">
        <table class="table table-bordered table-hover dataTable" id="tab1" width="100%">
          <thead>
            <tr role="row">
              <!-- <th width="5%" style="text-align: center;"><input type="checkbox" class="allCheckSelect"></th> -->
              <th width="15%" >Date</th>
              <th width="20%" >Created by</th>
              <th>Name</th>
              <th width="6%">Actions</th>
            </tr>
          </thead>

          <tbody>
          @if(isset($letterheads) && count($letterheads) >0)
            @foreach($letterheads as $key=>$letterhead)
            <tr class="del_tabletr_{{$letterhead['id']}}">
              <!-- <td align="center"><input type="checkbox" class="checkbox ads_Checkbox" name="checkbox[]" id="cst_{{$letterhead['id']}}" value="{{$letterhead['id']}}" /></td> -->
              <td>{{ date('d-m-Y H:i a', strtotime($letterhead['created'])) }}</td>
              <td>{{ $letterhead['user_name'] or '' }}</td>
              <td>{{$letterhead['name'] or ''}} @if($letterhead['isdefaullt']) -  <b>(Default letter head)</b> @endif</td>
              <td>
              <div style="width: 22px;">
                <div class="customDrop">
                  <div class="dropdown action-menu">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:5px;">
                    <img src="/img/arrows.png">
                    </a>
                  
                    <ul class="dropdown-menu">
                      <li>
                        <div style="float: left; margin:0 6px;">
                          <img width="15" src="/img/icon_1.png">
                        </div>
                        <div style="float: left; cursor: pointer;" data-lhead_id="{{$letterhead['id']}}" data-lhead_name="{{$letterhead['name']}}" class="viewLetterHead">View
                        </div>
                        <div class="clearfix"></div>
                      </li>
                      @if(!$letterhead['isdefaullt']) 
                      <li> 
                        <div style="float: left; margin:0 6px 6px 6px;">
                          <img src="/img/edit_icon.png">
                        </div>
                        <div style="float: left; cursor: pointer;" data-lhead_id="{{$letterhead['id']}}" class="defaultLetterHead">make default</div>
                        <div class="clearfix"></div>
                      </li>
                      @endif
                      <li>
                        <div style="float: left; margin:0 6px;">
                          <img src="/img/deleteBtn.png">
                        </div>
                        <div style="float: left; cursor: pointer;" @if($letterhead['isdefaullt']) data-default="1" @endif data-lhead_id="{{$letterhead['id']}}" class="deleteLetterHead">Delete
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
    
        <div id="prevdialog" style="display:none">
            <div>
            <iframe id="pdfrm" src="" style="width: 100%; height: 600px"></iframe>
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
