@extends('layouts.layout')

@section('mycssfile')

    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/fileandsign.js') }}" type="text/javascript"></script>
<!-- <script src="{{ URL :: asset('js/onboard.js') }}" type="text/javascript"></script> -->
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->




<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="{{ URL :: asset('js/jquery-ui.min.js') }}"></script>
<!-- Date picker script -->
<!-- page script -->
<script type="text/javascript">

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
                <section class="content">
        <form>
          <div class="tabarea">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
                <li class="active"><a data-toggle="tab" id="tab1signanddoc" href="#tab_1">SIGN A DOCUMENT</a></li>
                <li class=""><a data-toggle="tab" id="tab2send" href="#tab_2">SEND FOR SIGNATURE</a></li>
                <li><a data-toggle="tab" id="tab3signdocs" href="#tab_3">SIGNED DOCS</a></li>
                <li><a data-toggle="tab" id="tab4sharefile" href="#tab_4">SHARE FILES WITH CLIENT PORTAL(DROPBOX LINKS)</a></li>
              
              <li class="chk_right"> <input type="checkbox" name="notification" id="notification" />
            <!--  <span class="red_point">4</span> -->
               </li>
               
                <li style="float:right;" id="sharefiles"><a href="#" class=" btn-block btn-primary " data-toggle="modal" data-target="#compose-modal"><i class="fa fa-plus"></i> Share New Document </a></li>
              </ul>
              <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                  <!--table area-->
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                        
                        <div class="top_bts">
                                          <ul style="padding:0;">
                                            <li>
                                            <button class="btn btn-default"><i class="fa fa-upload"></i> Upload Document</button> 
                                            </li>
                                            <li>
                                              <button class="btn btn-default"><i class="fa fa-pencil-square-o"></i> My Signature</button>
                                            </li>
                                            <li>
                                              <button class="btn btn-default"><i class="fa fa-file-text-o"></i> My Text</button>
                                            </li>
                                             <li>
                                              <button class="btn btn-default"><i class="fa fa-trash-o fa-clock-o"></i> Today's Date</button>
                                            </li>
                                            <div class="clearfix"></div>
                                          </ul>
                                        </div>
                           
                           <div class="right_side"><button class="btn btn-default" data-toggle="modal" data-target="#compose-modal">Delete</button></div>
                           <div class="clearfix"></div>
                           
<div class="file_midsection">
<h1>CONFIDENTIALITY AGREEMENT</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <strong>Ut enim ad minim veniam, quis nostrud exercitation</strong> ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
<ul class="agreement_points">
<li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas...</li>
<li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas...</li>
<li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas...</li>
<li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas...</li>
<li>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas...</li>
</ul> <div class="clearfix"></div>
</div>
<div class="closeand_download">
<button class="close_btn1">Close</button>
<button class="download_btn1">Download</button>
 <div class="clearfix"></div>
</div>
</div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                </div>
                <!-- /.tab-pane -->
                <div id="tab_2" class="tab-pane">
                  <!--table area-->
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                        
                        <div class="top_bts">
                                          <ul style="padding:0;">
                                            <li>
                                            <button class="btn btn-default"> <i class="fa fa-upload"></i> Upload Document</button> 
                                            </li>
                                            <li>
                                              <button class="btn btn-primary"><i class="fa fa-download"></i> GENERATE & COPY DOCUMENT LINK</button>
                                            </li>
                                            <li>
                                              <button class="btn btn-primary"><i class="fa fa-envelope"></i> EMAIL DOCUMENT LINK</button>
                                            </li>
                                            <div class="clearfix"></div>
                                          </ul>
                                        </div>
                           
                           <div class="right_side"><button class="btn btn-default" data-toggle="modal" data-target="#compose-modal">Delete</button></div>
                           <div class="clearfix"></div>
                           
<div class="file_midsection">
<h1>CONFIDENTIALITY AGREEMENT</h1>
<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <strong>Ut enim ad minim veniam, quis nostrud exercitation</strong> ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
</div>
<div class="closeand_download">
<button class="close_btn1">Close</button>
<!-- <button class="download_btn1">Download</button> -->
 <div class="clearfix"></div>
</div>
</div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                </div>
                <div id="tab_3" class="tab-pane">
                  <!--table area-->
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
<!--                           <div class="right_side"><button class="btn btn-default" data-toggle="modal" data-target="#compose-modal">Delete</button></div>
                           <div class="clearfix"></div>-->
                           
<table width="100%" class="table table-bordered">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="10%" align="center"><strong>Date</strong></td>
                                      <td width="10%" align="center"><strong>Document Name</strong></td>
                                      <td width="20%" align="center"><strong>Upload by</strong></td>
                                      <td width="20%" align="center"><strong>Download</strong></td>
                                      <td width="15%" align="center"><strong>File in Dropbox</strong></td>
                                      <td width="10%" align="center"><strong>Delete</strong></td>
                                    </tr>
                                    <tr>
                                     
                                      <td align="center">08/09/2015</td>
                                      <td align="center">wfw werfwerf</td>
                                      <td align="center">M s</td>

                                      <td align="center"><a href="#">Link</a></td>
                                      <td align="center"><button class="btn btn-default">Send</button></td>
                                      <td align="center"><a href="#"><img src="img/cross.png" width="15"></a></td>
                                    </tr>
                                    
                                   
                                  </tbody>
                                </table>
<div class="closeand_download">
<button class="close_btn1">Close</button>
<!-- <button class="download_btn1">Download</button> -->
 <div class="clearfix"></div>
</div>
</div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                </div>
                <div id="tab_4" class="tab-pane">
                  <!--table area-->
                  <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">
                        
 <table width="100%" class="table table-bordered">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="10%" align="center"><strong>Date</strong></td>
                                      <!--<td width="15%" align="center"><strong>Request Type</strong></td>-->
                                      <td width="10%" align="center"><strong>Document Name</strong></td>
                                      <td width="20%" align="center"><strong>Client Name</strong></td>
                                      <td width="20%" align="center"><strong>Client email</strong></td>
                                      <td width="15%" align="center"><strong>View and download</strong></td>
                                      <td width="10%" align="center"><strong>Share by</strong></td>
                                      <td width="10%" align="center"><strong>Delete</strong></td>
                                    </tr>
                                    <tr>
                                     
                                      <td align="center">08/09/2015</td>
                                      <td align="center">wfw werfwerf</td>
                                      <td align="center">sinha</td>
                                      <td align="center">sinha@appsbee.com</td>
                                      <td align="center"><a href="#">Link</a></td>
                                      <td align="center">SinhA </td>
                                      <td align="center"><a href="#"><img src="img/cross.png" width="15"></a></td>
                                    </tr>
                                    
                                   
                                  </tbody>
                                </table>                       
                           
                           
                           

<div class="closeand_download">
<button class="close_btn1">Close</button>
<!--<button class="download_btn1">Download</button> -->
 <div class="clearfix"></div>
</div>
</div>
                      </div>
                    </div>
                  </div>
                  <!--end table-->
                </div>
                <!-- /.tab-pane -->
              </div>
            </div>
          </div>
        </form>
  
    </section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        

        <!-- share doc-->
        <div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:800px;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <form action="#" method="post">
        <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr class="table_heading_bg">
    <td class="shared_t">SHARED FILES</td>
  </tr>
  <tr>
    <td valign="top">
    <table width="100%" class="table table-bordered">
                                  <tbody>
                                    <tr>
                                      
                                      <td width="10%" align="center"><strong>Date</strong></td>
                                      <!--<td width="15%" align="center"><strong>Request Type</strong></td>-->
                                      <td width="10%" align="center"><strong>Document Name</strong></td>
                                      <td width="20%" align="center"><strong>Client Name</strong></td>
                                      <td width="20%" align="center"><strong>Client email</strong></td>
                                      <td width="15%" align="center"><strong>View and download</strong></td>
                                      <td width="10%" align="center"><strong>Share by</strong></td>
                                      <td width="10%" align="center"><strong>Delete</strong></td>
                                    </tr>
                                    <tr>
                                      <td align="center">08/09/2015</td>
                                      <td align="center">wfw werfwerf</td>
                                      <td align="center">R Sharma</td>
                                      <td align="center">sharma@appsbee.com</td>
                                      <td align="center"><a href="#">Link</a></td>
                                      <td align="center">R sharma</td>
                                      <td align="center"><a href="#"><img src="img/cross.png" width="15"></a></td>
                                    </tr>
                                    
                                   
                                  </tbody>
                                </table>
    </td>
  </tr>
</table>

          
          
          <div class="closeand_download">
<button class="close_btn1">Close</button>
<!-- <button class="download_btn1">Download</button> -->
 <div class="clearfix"></div>
</div>
        
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

     

@stop