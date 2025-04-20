@extends('layouts.layout')


@section('mycssfile')
<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/org_clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/relationship.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<script>
var Table1;

    
  $(function() {

   Table1 = $('#example1').dataTable({
         "aaSorting": [[2, 'asc']],
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": false,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
     
      "aoColumns":[
            //{"bSortable": false},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
          //  {"bSortable": true},
          //  {"bSortable": true},
           // {"bSortable": true},
            {"bSortable": false}
        ]

    });
   // Table1.fnSort( [ [2,'asc'] ] );
   
    }); 
    
</script>
@stop

@section('content')

<div class="wrapper row-offcanvas row-offcanvas-left">
    <aside class="left-side sidebar-offcanvas {{ $left_class }}">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    @include('layouts/inner_leftside')

                </section>
                <!-- /.sidebar -->
            </aside>
           <aside class="right-side {{ $right_class }}">
                <!-- Content Header (Page header) -->
                @include('layouts.below_header')
    <!-- Content Header (Page header) -->
    <!--<section class="content-header">
      <h1>HMRC AUTHORISATIONS</h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>-->
    <!-- Main content -->
    <section class="content">
      <div class="practice_mid"> 
        <form>
          <div class="top_buttons">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="25%"><div class="top_bts">
                    <ul>
                      <!--<li>
                        <button class="btn btn-danger"><i class="fa fa-trash-o fa-fw"></i> Delete</button>
                      </li>-->
                      <li>
                        <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button>
                      </li>
                      <li>
                        <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button>
                      </li>
                      
                      <div class="clearfix"></div>
                  
                    </ul>
                  </div></td>

                <td width="50%">&nbsp;</td>
               
              </tr>
            </table>
          </div>
          <div class="tabarea">
            <div class="row">
                        <div class="col-xs-12">
                          <!--start table-->
                         
                          <tr>
                          <td valign="top">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td width="15%"><a href="#"><img src="/img/download_64.png" /></a></td>
     <td width="85%"><a href="#"><img src="/img/download_fbi2.png" /></a></td>
  </tr>
</table>

                          </td>
                         
                          </tr>
                           
                            <tr>
                              <td valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered dataTable" id="example1" aria-describedby="example1_info" >
   
  
  
 
  
  
  <thead>
    <th  align="center" class="padding_h"><input type="checkbox" /></th>
    <th  align="center" class="padding_h"><strong>NAME</strong></th>
    <th  align="center" class="padding_h"><strong>RESPONSIBLE PERSON</strong></th>
    <th align="center"><table class="table table-bordered"><tr><td colspan="5">PAPER AUTHORISATIONS</td> </tr> <tr><td>SA/NI</td> <td>TC</td> <td>CT</td> <td>PAYE</td><td>VAT</td></table></th>
    <th  align="center"><strong>ONLINE AUTHORISATIONS</strong></th>
    </thead>
  <!--<tr>
    <td align="center"><strong>SA/NI</strong></td>
    <td align="center"><strong>TC</strong></td>
    <td align="center"><strong>CT</strong></td>
    <td align="center"><strong>PAYE</strong></td>
    <td align="center"><strong>VAT</strong></td>
    <td align="center"><strong>SA/TC</strong></td>
    <td align="center"><strong>PAYE</strong></td>
    <td align="center"><strong>CT</strong></td>
    <td align="center"><strong>ERS</strong></td>
    <td align="center"><strong>CT</strong></td>
      <td align="center"><strong>VAT</strong></td>
    <td align="center"><strong>NOVA</strong></td>
    <td align="center"><strong>EU REFUNDS</strong></td>
    <td align="center"><strong>MOSS-US</strong></td>
    <td align="center"><strong>MOSS-NUS</strong></td>
  </tr>-->
  
  @if(!empty($client_details))
                <?php $i=1; ?>
                @foreach($client_details as $key=>$client_row)
  <tr>
    <td align="center"><input type="checkbox" /></td>
    
    <td align="left"><a target="_blank" href="{{ $client_row['client_url'] or "" }}">{{ $client_row['client_name'] or "" }}</a></td>
    
    
    <td align="center">
        @if(isset($client_row['contact_name']) && count($client_row['contact_name']) >0)
                        <select class="form-control newdropdown">
                        @foreach($client_row['contact_name'] as $key=>$name_row)
                        <option>{{ $name_row['name'] }}</option>
                        @endforeach
                        </select>
                      @endif
    </td>
   
   
    <td align="center"><table border="1px"><tr><td><input type="checkbox" /></td> <td><input type="checkbox" /></td> <td><input type="checkbox" /></td> <td><input type="checkbox" /></td><td><input type="checkbox" /></td></table></td>
    <td align="center"><input type="checkbox" /></td>
    <!--<td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>
        <td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>
        <td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>
    <td align="center"><input type="checkbox" /></td>-->
  </tr>
  <?php $i++; ?>
              @endforeach
            @endif
 
</table>

                                </td>
                                
                            </tr>
                          
                          <!--end table-->
                        </div>
                      </div>
          </div>
        </form>
      </div>
    </section>
    <!-- /.content -->
  </aside></div>




@stop