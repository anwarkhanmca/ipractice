@extends('layouts.layout')

@section('mycssfile')
<link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
<!-- Date picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/jquery-ui.css') }}" />
<!-- Date picker script -->

<!-- Time picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/timepicki.css') }}" />
<!-- Time picker script -->

<!-- Add To Calender Start -->
<link href="{{ URL :: asset('css/atc-style-blue.css') }}" rel="stylesheet" type="text/css">
<!-- Add To Calender End -->
@stop

@section('myjsfile')

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script>
<!-- Time picker script -->
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

<!-- page script -->
<script src="{{ URL :: asset('js/todolist.js') }}" type="text/javascript"></script>

<script type="text/javascript">
var Table1, Table2;
$(function() {
  Table1 = $('#example').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, 200]],
    "iDisplayLength": 10,
    "language": {
      "lengthMenu": "Show _MENU_ entries",
      "zeroRecords": "Nothing found - sorry",
      "info": "Showing page _PAGE_ of _PAGES_",
      "infoEmpty": "No records available",
      "infoFiltered": "(filtered from _MAX_ total records)"
    },

    "aoColumns":[
      {"bSortable": true},

      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true}
      
    ]

  });
  Table1.fnSort( [ [2,'asc'] ] );
})
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
    
    <div class="nav-tabs-custom">
              <ul class="nav nav-tabs nav-tabsbg">
                <li class="active"><a data-toggle="tab" href="#tab_1">Users</a></li>
                <li class=""><a data-toggle="tab" href="#tab_2">Pricing</a></li>
                <li class=""><a data-toggle="tab" href="#tab_3">Paypal</a></li>
                <!--<li><a href="#" class=" btn-block btn-primary " data-toggle="modal" data-target="#compose-modal"><i class="fa fa-plus"></i> New Field </a></li>-->
              </ul>
              <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
               <h1>Users</h1>
               
               
               <div class="box-body table-responsive">
                    <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
                      <div class="row">
                        <div class="col-xs-6"></div>
                        <div class="col-xs-6"></div>
                      </div>
                      <div class="row">
                        <div class="col-xs-12">


        <table class="table table-bordered table-hover dataTable" id="example" aria-describedby="example_info">

            <thead>
              <tr role="row">
                <td align="left"><strong>ID</strong></td>
                <td align="left"><strong>Email</strong></td>
                <td align="left"><strong>Practice Name</strong></td>
                <td align="left"><strong>Phone</strong></td>
                <td align="left"><strong>Date Registered</strong></td>
                 
                <td align="left"><strong>Website Address</strong></td>
                <td align="left" width="10%"><strong>Package Name</strong></td>
               
              </tr>
            </thead>

            <tbody role="alert" aria-live="polite" aria-relevant="all">
              
              
              
              <tr>
              
                 <td align="left">1010</td>
                <td align="left">123@gmail.com</td>
                <td align="left">mono.appsbee</td>
                <td align="left">&nbsp;</td>
                <td align="left">25-10-2015 8:15</td>
                 
                <td align="left">www.google.co.in</td>
                <td align="left" width="10%">30</td>
                
              
              </tr>
              
<tr>
              
                 <td align="left">1011</td>
                <td align="left">123@gmail.com</td>
                <td align="left">James.coleman</td>
                <td align="left">&nbsp;</td>
                <td align="left">24-10-2015 19:15</td>
                 
                <td align="left">mpm.com</td>
                <td align="left" width="10%">&nbsp;</td>
              
              
              </tr>
            </tbody>
          </table>

                          <!--end table-->
                        </div>
                      </div>
                    </div>
                  </div>
               
               
               
               
               
               
                </div>
                <!-- /.tab-pane -->
                <div id="tab_2" class="tab-pane">
                <h1>Pricing</h1>
                </div>
                <div id="tab_3" class="tab-pane">
                  <h1>Paypal</h1>
                </div>
                
                
                
                <!-- /.tab-pane -->
              </div>
            </div>
    
    
    
    
      </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>




       
<!-- ADD JOB START DATE MODAL END -->
@stop
<!--staff -->