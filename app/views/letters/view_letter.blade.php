@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css">
  .bottom_space{ height: 50px;}
</style>
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/letter_email.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/generate_letter.js') }}" type="text/javascript"></script>

<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->

<script type="text/javascript">
$(document).ready(function(){
  $('#tab1, #tab2').dataTable({
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
          
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
              @include('layouts.outer_leftside')
          </ul>
      </section>
      <!-- /.sidebar -->
  </aside>

  <!-- Right side column. Contains the navbar and content of the page -->
  <aside class="right-side  {{ $right_class }}">
    @include('layouts.below_header')
    <input type="hidden" id="template_id" value="{{ $template_id or '0' }}">
    <section class="content">
      <div class="practice_mid">
        <div class="tabarea">
            <div class="show_loader"></div>
            <div class="tab_topcon">
              <div class="top_bts" style="float:left;">
                <ul style="padding:0;">
                  <li style="margin-left: 600px; font-size: 25px;">
                    {{ isset($template_title)?strtoupper($template_title):'' }}
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

            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
                <li class="{{ ($page_open == 1)?'active':'' }}"><a href="/letters/view-letter/1">FINAL</a></li>
                <li class="{{ ($page_open == 2)?'active':'' }}"><a href="/letters/view-letter/2">DRAFT</a></li>
              @if($page_open != 1 && $page_open != 2)
                <li class="{{ ($page_open == 31 || $page_open == 32)?'active':'' }}"><a href="/letters/view-letter/31">VIEW LETTER</a></li>
              @endif
              </ul>

              <div class="tab-content">
                <div id="tab_1" class="tab-pane {{ ($page_open == 1)?'active':'' }}">
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
                    @if(isset($finalDetails) && count($finalDetails) >0)
                      @foreach($finalDetails as $key=>$itemValue)
                      <tr class="del_tabletr_{{$itemValue['template_id']}}">
                        <td align="center"><input type="checkbox" class="checkbox ads_Checkbox" name="checkbox[]" id="cst_{{$itemValue['template_id']}}" value="{{$itemValue['template_id']}}" /></td>
                        <td>{{ date('d-m-Y H:i a', strtotime($itemValue['created'])) }}</td>
                        <td>{{ $itemValue['user_name'] or '' }}</td>
                        <td><a href="javascript:void(0)" class="openTaskPop">{{$itemValue['subject'] or ''}}</a></td>
                        <td>
                        <div style="width: 22px;">
                          <div class="customDrop">
                            <!-- <div style="float: left;padding: 5px"><img src="/img/settings-24.png"></div> -->
                            <div class="dropdown action-menu">
                              <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown" style="padding-left:5px;">
                              <img src="/img/arrows.png">
                              </a>
                            
                              <ul class="dropdown-menu">
                                <li> <!-- /letters/view-letter/31-{{$itemValue['template_id']}} -->
                                  <div style="float: left; margin:0 6px 6px 6px;">
                                    <img src="/img/view.png">
                                  </div>
                                  <div style="float: left; cursor: pointer;" data-template_id="{{$itemValue['template_id']}}" class="viewLetterData">View</div>
                                  <div class="clearfix"></div>
                                </li>
                                <li>
                                  <div style="float: left; margin-right: 2px; margin-bottom: 6px;">
                                    <input type="checkbox" class="checkConfidential" value="{{$itemValue['template_id']}}" {{ ($itemValue['confidentialUserId'] == $user_id)?'checked':'' }}> 
                                  </div>
                                  <div style="float: left;">Confidential</div>
                                  <div class="clearfix"></div>
                                </li>
                                <li>
                                  <div style="float: left; margin:0 6px 6px 6px;">
                                    <img src="/img/copy.png">
                                  </div>
                                  <div style="float: left; cursor: pointer;" data-template_id="{{$itemValue['template_id']}}" data-copy_id="{{$itemValue['template_id']}}-0" class="copyLetterContact">Copy</div>
                                  <div class="clearfix"></div>
                                </li>
                                <li>
                                  <div style="float: left; margin:0 6px;">
                                    <img src="/img/deleteBtn.png">
                                  </div>
                                  <div style="float: left; cursor: pointer;" data-template_id="{{$itemValue['template_id']}}" class="deleteLetterContact">Delete
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

                <div id="tab_2" class="tab-pane {{ ($page_open == 2)?'active':'' }}">
                  <table class="table table-bordered table-hover dataTable" id="tab1" width="100%">
                    <thead>
                      <tr role="row">
                        <th width="5%" style="text-align: center;"><input type="checkbox" class="allCheckSelect"></th>
                        <th width="15%" >Date</th>
                        <th width="20%" >Created by</th>
                        <th>Title</th>
                        <th width="10%" style="text-align: center;">Action</th>
                      </tr>
                    </thead>

                    <tbody>
                    @if(isset($draftDetails) && count($draftDetails) >0)
                      @foreach($draftDetails as $key=>$itemValue)
                      <tr class="del_tabletr_{{$itemValue['template_id']}}">
                        <td align="center"><input type="checkbox" class="checkbox ads_Checkbox" name="checkbox[]" id="cst_{{$itemValue['template_id']}}" value="{{$itemValue['template_id']}}" /></td>
                        <td>{{ date('d-m-Y H:i a', strtotime($itemValue['created'])) }}</td>
                        <td>{{ $itemValue['user_name'] or '' }}</td>
                        <td><a href="javascript:void(0)" class="openTaskPop" data-template_id="{{$itemValue['template_id']}}">{{$itemValue['subject'] or ''}}</a></td>
                        <td align="center"><a href="/letters/generate-letter/2/{{$itemValue['template_id']}}"><img src="/img/edit_icon.png"></a> | <a href="javascript:void(0)" class="deleteLetterContact" data-template_id="{{$itemValue['template_id']}}" data-deleteFrom="recept"><img src="/img/cross_icon.png"></a></td>
                      </tr>
                      @endforeach
                    @endif
                    </tbody>
                  </table>
                </div>

                <div id="tab_3" class="tab-pane {{ ($page_open != 1 && $page_open != 2)?'active':'' }}">
                  <ul class="nav nav-tabs nav-tabsbg tasksTabOuter">
                    <li class="{{ ($page_open == 31)?'active':'' }}"><a href="/letters/view-letter/31-{{$template_id or '0'}}">CONTACTS</a></li>
                @if($page_open == 32)
                    <li class="{{($page_open==32)?'active':''}}"><a href="javascript:void(0)">PREVIEW</a></li>
                @endif
                  </ul>

                  <div class="tab-content">
                    <div id="tab_31" class="tab-pane {{ ($page_open == 31)?'active':'' }}">
                    <table class="table table-bordered table-hover dataTable" id="tab31" width="100%">
                        <thead>
                          <tr role="row">
                            <th width="5%" style="text-align: center;"><input type="checkbox" class="allCheckSelect"></th>
                            <th>Name</th>
                            <th width="12%" style="text-align: center;">Use this Letter</th>
                            <th width="10%" style="text-align: center;">Letter Preview</th>
                          </tr>
                        </thead>

                        <tbody>
                        @if(isset($itemDetails) && count($itemDetails) >0)
                          @foreach($itemDetails as $key=>$itemValue)
                          <tr class="del_tabletr_{{$itemValue['recipient_id'] or '0'}}">
                            <td align="center"><input type="checkbox" class="checkbox ads_Checkbox" name="checkbox[]" id="cst_{{$itemValue['recipient_id'] or '0'}}" value="{{$itemValue['recipient_id'] or '0'}}" data-item_type="{{$itemValue['item_type'] or ''}}" /></td>
                            <td><a href="javascript:void(0)" class="openTaskPop" data-item_id="{{$itemValue['item_id'] or '0'}}">{{$itemValue['item_name'] or ''}}</a></td>
                            <td align="center"><a href="javascript:void(0)" class="job_send_btn copyLetterContact" data-copy_id="{{ $itemValue['template_id'] }}-{{ $itemValue['recipient_id'] }}">COPY</a></td>
                            <td align="center"><a href="javascript:void(0)" class="job_send_btn viewForPreviewBtn" data-recipient_id="{{$itemValue['recipient_id'] or '0'}}" data-url="/letters/view-letter/32-{{$itemValue['recipient_id'] or '0'}}">VIEW</a></td>
                          </tr>
                          @endforeach
                        @endif
                        </tbody>
                      </table>
                    </div>

                    <div id="tab_32" class="tab-pane {{ ($page_open == 32)?'active':'' }}">
                      <div style="width: 70%; margin: 20px auto;"> 
                        <iframe width="100%" height="600" src="/uploads/emailTemplates/{{$user_id}}_template.pdf"></iframe> 
                      </div> 
                    </div>
                  </div>
                </div>

              </div>
            </div>
          <div class="clearfix"></div>

        </div>
      </div>
    </section>
  </aside>
</div>




      
<!-- Add to Group modal end -->

@stop

