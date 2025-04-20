@extends('layouts.layout')

@section('mycssfile')
  
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/crm.js') }}" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->

<script src="{{ URL :: asset('js/graph.js') }}" type="text/javascript"></script>
<!-- <script>
$(function () {
  var bar = new GraphBar({
    attachTo: '#show_graph',
    special: 'combo',
    height: 475,
    width: '100%',
    yDist: 40,
    xDist: 105,
    showPoints: false,
    xGrid: false,
    legend: false,
    averageLineColor:false,
    points: [32, 15, 75, 20, 45, 90, 52, 15, 75, 20, 45, 90],
    colors: ['blue'],
    //dataNames: ['Won'],
    xName: 'Month',
    tooltipWidth: 15,
    design: {
        //tooltipColor: '#fff',
        gridColor: 'black',
        tooltipBoxColor: 'none',
        averageLineColor: 'none',
    }
  });
  bar.init();
});
</script>-->
<style type="text/css">
  svg:not(:root){overflow: inherit; margin-right: 20px; float:right;}

</style>
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
      <div class="row">
        <div class="practice_hed">
          <div class="top_bts">
            <ul>
              <li>
                <a class="btn btn-info" href="{{ $back_url }}">Black</a>
              </li>
              <div class="clearfix"></div>
            </ul>
          </div>

          <div id="message_div"><!-- Loader image show while sync data --></div>
        </div>
      </div>

      <div class="practice_mid">
        <div class="tabarea">
          <div class="nav-tabs-custom">
            <div class="tab-content">
              <div class="modal-body">
                <div class="crm_graph">
                  <div class="crm_graph_box">
                      <div class="form-group">
                        <label for="exampleInputPassword1">Select Month</label>
                        <select class="form-control " name="month" id="month">
                          @foreach($months as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option> 
                          @endforeach
                        </select>
                      </div> 
                  </div>
                  <div class="crm_graph_box">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Select Year</label>
                        <select class="form-control " name="year" id="year">
                          @for($i=1900; $i <=date('Y')+50; $i++)
                            <option value="{{ $i }}" {{ $i == date('Y')?'selected':'' }}>{{ $i }}</option> 
                          @endfor  
                        </select>
                    </div>
                  </div>
                  <div class="crm_graph_box">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Compare with Previous</label>
                        <select class="form-control " name="compare" id="compare">
                          @for($i=1; $i <=11; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ ($i==1)?'Month':'Months' }}</option> 
                          @endfor
                        </select>
                    </div>
                  </div>
                 
                      <div class="deleted_items">
                    <div class="form-group">
                        <input type="checkbox" id="" name="" class="form-control" checked>
                        <label for="exampleInputPassword1" style="width: 75%!important;">Include Deleted Items</label>
                    </div>
                     </div>

                   <div class="deleted_items">
                    <div class="form-group">
                        <input type="checkbox" id="" name="" class="form-control" checked>
                       <label for="exampleInputPassword1" style="width: 75%!important;">Include Archived Items</label>
                    </div>
                     </div>
                  
                  <div class="crm_graph_box">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Filtere by deal owner</label>
                        <select class="form-control " name="business_type" id="business_type">
                          <option></option>  
                        </select>
                    </div>
                  </div>

                  <div class="crm_graph_box">
                    <div class="form-group">
                      <label for="exampleInputPassword1"></label>
                  <input type="button" id="show_graph_button" class="btn btn-info" value="Show Graph" style="margin-top: 14px;">
                </div> </div>

                <div class="clearfix"></div>
                </div>

                <div id="show_graph_loader" style="text-align: center;"></div>
                <div class="clearfix"></div>

                <div class="form-group" id="show_graph"></div>
                 <div class="clearfix"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


</aside><!-- /.right-side -->
            


<!-- GRAPHS MODAL -->
<div class="modal fade" id="graphs-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:790px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">GRAPHS</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">From Date</label>
                <input type="text" id="from_date" name="from_date" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">To Date</label>
                <input type="text" id="to_date" name="to_date" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <input type="button" id="show_graph_button" class="btn btn-info" value="Show Graph">
        </div> 
        <div id="show_graph_loader" style="text-align: center;"></div>
        <div class="clearfix"></div>

        <div class="form-group" id="show_graph"></div>
         <div class="clearfix"></div>
      </div>
    
    </div>
  </div>
</div>

@stop



