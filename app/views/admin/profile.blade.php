@extends('layouts.layout')

@section('mycssfile')
    <link href="{{ URL :: asset('css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@stop

@section('myjsfile')
<!-- DATA TABES SCRIPT -->
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!-- page script -->
<script type="text/javascript">
$(function() {
    $('#example2').dataTable({
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bSort": false,
        "bInfo": false,
        "bAutoWidth": false,


        //"iDisplayLength": -1,
        //"aaSorting": [[ 5, "desc" ]],
        "aoColumns":[
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true}
        ]

    });

    $("#example2_filter").hide();
    
});

</script>
@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                                        
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        @include('layouts.outer_leftside')
                        
                    </ul>
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
        <div class="box-body table-responsive">
            <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper"><div class="row"><div class="col-xs-6"></div><div class="col-xs-6"></div></div>
                <table class="table table-bordered table-hover dataTable" id="example2" aria-describedby="example2_info">
                
                <thead>
                    <tr role="row">
                      <th><strong>Name</strong></th>
                      <th align="center"><strong>Website</strong></th>
                      <th align="center"><strong>Phone No</strong></th>
                      <th align="center"><strong>Country</strong></th>
                      <th align="center"><strong>Action</strong></th>
                    </tr>
                </thead>
        
                <tbody role="alert" aria-live="polite" aria-relevant="all">
                    @if(!empty($admin_details) && count($admin_details) > 0)
                       <tr>
                            <td align="center">{{ $admin_details['fname'] }} {{ $admin_details['lname'] }}</td>
                            <td align="center">{{ $admin_details['website'] }}</td>
                            <td align="center">{{ $admin_details['phone'] }} </td>
                            <td align="center">{{ $admin_details['country'] }} </td>
                            <td align="center"><a href="/profile-edit"><i class="fa fa-edit"></i></a></td>
                        </tr>
                        <?php ?>
                    @endif
                  
                  
                </tbody>
              </table>
        
                </div>
            </div>
            
        </div>
        
    </div>
</section>
                <!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->

@stop