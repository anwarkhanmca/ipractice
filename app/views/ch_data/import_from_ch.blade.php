@extends('layouts.layout')

@section('myjsfile')
<script src="{{ URL :: asset('js/ch_data.js') }}" type="text/javascript"></script>
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
        <form>
          <div class="chdata_main">
            <div class="tab_topcon">
              <div class="import_search">
                <div class="import_search_box">
                  <input type="text" class="form-control" name="search_value" id="search_value" placeholder="Search company name or number">
                </div>
                <div class="import_search_btn">
                  <button type="button" name="search_company" class="btn btn-warning search_company">Search</button>
                </div>
                <div class="top_search_con">
                  <!-- <button type="button" class="btn btn-info import_client">IMPORT</button> -->
                </div>
                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- <h2>Results</h2> -->
            <div class="details_table">
              <div class="registered_table">
                <table width="100%" border="1" bordercolor="60aad2" style="text-align:center;" id="result">
                  <tr class="td_color">
                    <td colspan="3"><span class="sub_header">COMPANY NAME</span></td>
                  </tr>
                  
                </table>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>


</aside><!-- /.right-side -->
            
        
<!-- popup content -->
<div class="modal fade" id="company_details-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <input type="hidden" name="back_url" id="back_url" value="{{ $back_url }}">
  <input type="hidden" name="hidden_cmpnyno" id="hidden_cmpnyno" value="">
  <div class="modal-dialog">
    <div class="modal-content">
       <div class="cross_btn1"><button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button></div>
      <div class="registered_table1 popup_align" id="company_details_div">
     
      <!-- Company Details Show -->
        
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


@stop



