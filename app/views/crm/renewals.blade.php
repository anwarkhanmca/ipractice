@extends('layouts.layout')

@section('mycssfile')

    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    
@stop

@section('myjsfile')
 <script src="{{ URL :: asset('js/quotes.js') }}" type="text/javascript"></script> 
<!-- <script src="{{ URL :: asset('js/onboard.js') }}" type="text/javascript"></script> -->
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->

<script src="{{ URL :: asset('js/proposal.js') }}" type="text/javascript"></script> 


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>

<!-- Date picker script -->
<script src="{{ URL :: asset('js/jquery-ui.min.js') }}"></script>


<!-- Date picker script -->
<script src="{{ URL :: asset('tinymce/tinymce.min.js') }}"></script>
<!-- page script -->
<script type="text/javascript">
tinymce.init({
    selector: "textarea",
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
    plugins: ["wordcount", "table", "charmap", "anchor", "insertdatetime", "link", "image", "media", "visualblocks", "preview", "fullscreen", "print", "code" ]
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
                <section class="content">
                
                
                
                
                
      <form>
        <div class="tabarea">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs nav-tabsbg">
              <li class="active"><a data-toggle="tab" href="#tab_1">BASIC INFORMATION</a></li>
              <li class=""><a data-toggle="tab" href="#tab_2">CONTACT INFORMATION</a></li>
              <li><a data-toggle="tab" href="#tab_3">BILLING & FEES</a></li>
              <div class="top_tabs">
              <li><a data-toggle="tab" href="#tab_4">+Notes</a></li>
              <li><a data-toggle="tab" href="#tab_5">+Engagement Letter</a></li>
              <li><a data-toggle="tab" href="#tab_6">+New Contact</a></li>
              <li><a data-toggle="tab" href="#tab_7">+New Task</a></li>
              <li><a data-toggle="tab" href="#tab_8">+New Opportunity</a></li>
              <li><a data-toggle="tab" href="#tab_9">+New Quote</a></li>
              <li><a data-toggle="tab" href="#tab_10">+Log a Call</a></li></div>
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
                        <h3 class="box-title">Account Detail</h3>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="11%"><strong>Account Name</strong></td>
                            <td width="49%">Johannsen Foundation <span class="social_icon"> <a href="#"><img src="/img/tw.png" /></a> <a href="#"><img src="/img/fb.png" /></a> <a href="#"><img src="/img/link.png" /></a></span></td>
                            <td width="8%"><strong>Main Contact</strong></td>
                            <td width="32%">&nbsp;</td>
                          </tr>
                          <tr>
                            <td><strong>Join Date</strong></td>
                            <td>&nbsp;</td>
                            <td><strong>Client Type</strong></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td><strong>Website</strong></td>
                            <td>http://www.appsbee.com</td>
                            <td><strong>Industry</strong></td>
                            <td>Aid and Relief Arts and Culture</td>
                          </tr>
                          <tr>
                            <td><strong>Twitter Username</strong></td>
                            <td>Johanfund</td>
                            <td><strong>Phone</strong></td>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td><strong>Annual Income</strong></td>
                            <td>&nbsp;</td>
                            <td><strong>Phone</strong></td>
                            <td>(310) 592-1788</td>
                          </tr>
                          <tr>
                            <td><strong>Lead Source</strong></td>
                            <td>Website</td>
                            <td><strong>Fax</strong></td>
                            <td>(310) 592-1789</td>
                          </tr>
                          <tr>
                            <td><strong>Description</strong></td>
                            <td>Johannsen Foundation provides founds for after school programs in California.</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
                        </table>
                        <div class="basic_info_relationship">
                          <ul>
                            <li>
                              <p class="table_h">Relationships</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </li>
                            <li>
                              <p class="table_h">Additional Information</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td width="10%"><strong>VAT NO.</strong></td>
                                  <td width="40%">904854327</td>
                                  <td width="10%"><strong>Bank Name</strong></td>
                                  <td width="40%">&nbsp;</td>
                                </tr>
                                <tr>
                                  <td><strong>Tax Reference</strong></td>
                                  <td>501c3</td>
                                  <td><strong>Sort Code</strong></td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>&nbsp;</td>
                                  <td><strong>Account Number</strong></td>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </li>
                            <li>
                              <p class="table_h">Contact and Address Information</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td width="10%" valign="top"><strong>Billing Address</strong></td>
                                  <td width="40%">100 Main Street<br>
                                    Los Angeles, Ac 90012</td>
                                </tr>
                              </table>
                            </li>
                            <li>
                              <p class="table_h">Opportunities</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td width="5%" align="center"><strong>Action</strong></td>
                                  <td width="28%"><strong>Opportunity Name</strong></td>
                                  <td width="30%"><strong>Stage</strong></td>
                                  <td width="18%" align="right"><strong>Amount</strong></td>
                                  <td width="19%"><strong>Close Code</strong></td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td>Test</td>
                                  <td><strong>Proposal</strong></td>
                                  <td align="right">$ 678,899.00</td>
                                  <td>02/09/2015</td>
                                </tr>
                              </table>
                            </li>
                            <li>
                              <p class="table_h">Task and Events</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td align="left">No records to display</td>
                                </tr>
                              </table>
                            </li>
                            <li>
                              <p class="table_h">Activity History - Email, Call & NotesLog</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td align="left">No records to display</td>
                                </tr>
                              </table>
                            </li>
                          </ul>
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
                      <div class="col-xs-12"> Second tab </div>
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
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="18%"><strong>Billing & Fees</strong></td>
                            <td width="10%"><strong>Payment Method</strong></td>
                            <td width="72%"><div class="pay_method">
                                <select class="form-control">
                                  <option>efer</option>
                                  <option>regggf</option>
                                </select>
                              </div></td>
                          </tr>
                        </table>
                        <div class="basic_info_relationship">
                          <ul>
                            <li>
                              <p class="table_h">Contract Renewal History</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                </tr>
                              </table>
                            </li>
                            <li>
                              <p class="table_h">Direct Debits</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td align="left">No records to display</td>
                                </tr>
                              </table>
                            </li>
                            <li>
                              <p class="table_h">Engagement Letters</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td align="left">No records to display</td>
                                </tr>
                              </table>
                            </li>
                            <li>
                              <p class="table_h">Quotes History</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td align="left">No records to display</td>
                                </tr>
                              </table>
                            </li>
                            <li>
                              <p class="table_h">Services</p>
                              <table align="center" border="0" cellspacing="0" cellpadding="0" class="table table-bordered" style="margin:5px auto; width:99%;">
                                <tr>
                                  <td align="left">No records to display</td>
                                </tr>
                              </table>
                            </li>
                          </ul>
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
        

    

     

@stop