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
<script src="{{ URL :: asset('js/billings.js') }}" type="text/javascript"></script>

<script type="text/javascript">

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
    
    <div class="billing_mid"> 
        <form>
 <!--start your plan-->       
<div class="top_buttons">
<p class="plan_t">YOUR PLAN</p>
<table width="100%" class="table table-bordered" style="width:90%;">
<tbody>
<tr>
<td width="18%" align="center"><strong>Purchase Date</strong></td>
<td width="13%" align="center"><strong>Package Type</strong></td>
<td width="16%" align="center"><strong>Months left</strong></td>
<td width="14%" align="center"><strong>Days left</strong></td>
<td width="18%" align="center"><strong>Expiry Date</strong></td>
<td width="21%" align="center"><strong>Action</strong></td>
</tr>
<tr>

<td align="center">02/04/2015</td>
<td align="center">ULTIMATE</td>
<td align="center">8</td>
<td align="center">2</td>
<td align="center">02/04/2015</td>
<td align="center">
<!--

<button class="btn btn-info">RENEW</button> <button class="btn btn-danger">Delete</button> -->
<a href="/payment/{{ base64_encode('no') }}" target="_blank" class="btn btn-info" id="renewplan">RENEW</a> &nbsp;
<a href="javascript:void(0)" class="btn btn-danger" id="viewplandelete">Delete</a>


</td>
</tr>
</tbody>
</table>
</div>
<!--end your plan-->

<!--payment part-->
<!--
<div class="payment_part">
<p class="plan_t">PAYMENT</p>

<table width="100%" class="billing_table">
<tbody>
<tr>
<td width="14%" align="left">Select Package Type :</td>
<td width="18%" align="left">
<select class="form-control">
<option>Select Relatioship Type</option>
<option>Sole Tradership</option>
<option>Company</option>
<option>LLP</option>
<option>Incorporation Charity</option>
<option>Unincorporation Charity</option>
<option>Other</option>
</select> </td>
<td width="21%">&nbsp; Price $ 39.99 per month</td>                        
<td width="47%" align="left"><a href="javascript:void(0)" id="viewplan">View Plans</a></td>
</tr>

<tr>
<td width="14%" align="left">Number of Months :</td>
<td width="5%" align="left">
<div style="width:60px; margin:5px 0 5px 0;">
<select class="form-control">
<option>1</option>
<option>2</option>
<option>3</option>
<option>4</option>
</select> </div></td>
<td width="21%">&nbsp;</td>                        
<td width="47%" align="left">&nbsp;</td>
</tr>

<tr>
<td width="14%" align="left">Total Amount :</td>
<td width="5%" align="left"><strong>$ 39.99</strong></td>
<td width="21%">&nbsp;</td>                        
<td width="47%" align="left">&nbsp;</td>
</tr>

<tr>
<td width="14%" align="left">Upgrade Difference</td>
<td width="5%" align="left"><strong>$ = number of months left x (new package - current package) </strong></td>
<td width="21%">&nbsp;</td>                        
<td width="47%" align="left">&nbsp;</td>
</tr>

<tr>
<td width="14%" align="left">Grand Total</td>
<td width="5%" align="left"><input type="text" value="$"></td>
<td width="21%"><img src="img/pay_now.png" /></td>                        
<td width="47%" align="left">&nbsp;</td>
</tr>

</tbody>
</table>

<div class="choose_plan"><img src="img/lst_img2.jpg" /></div>
</div> -->
<!--end payment part-->
          
        </form>
      </div>
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>


       
<!-- ADD JOB START DATE MODAL END -->
@stop
<!--staff -->