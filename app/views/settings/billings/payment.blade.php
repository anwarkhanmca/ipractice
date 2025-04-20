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
 <!--start your plan-->       


<!--payment part-->
<div class="payment_part">
    <div style="font-size: 18px; color: #3c8dbc">{{ $paypal_success or "" }}</div>
    <div style="font-size: 18px; color: red">{{ $paypal_error or "" }}</div>
<p class="plan_t">PAYMENT</p>
<form action="{{ $paypal_url }}" method="post">

<!-- Identify your business so that you can collect the payments. -->
<input type="hidden" name="business" value="{{ $paypal_id }}">

<!-- Specify a Buy Now button. -->
<input type="hidden" name="cmd" value="_xclick">

<!-- Specify details about the item that buyers will purchase. -->
<input type="hidden" name="item_name" value="User Subscription">
<!-- <input type="hidden" name="item_number" value="PRO4321"> -->
<input type="hidden" name="currency_code" value="GBP">

<!-- Specify URLs -->
<input type="hidden" name="cancel_return" value="{{ $cancel_url }}">
<input type="hidden" name="return" value="{{ $return_url }}">

<table width="100%" class="billing_table">
    <tbody>
        <tr>
            <td width="14%" align="left">Enter Number of Clients:</td>
            <td width="12%" align="left">
                <input type="text" id="no_of_clients" maxlength="10">
            </td>
            <td width="21%">&nbsp; &pound;{{ $client_price or '0' }} Per Month Per Client
                <input type="hidden" id="hidden_price" value="{{ $client_price or '0' }}">
            </td>                        
            <td width="47%" align="left"><a href="javascript:void(0)" id="viewplan">View Plans</a></td>
        </tr>

        <tr>
            <td width="14%" align="left">Number of Months :</td>
            <td width="5%" align="left">
                <div style="width:147px; margin:5px 0 5px 0;">
                    <select id="no_of_months" style="width:100%; height:25px;cursor:pointer;">
                        @for($i=1; $i <=100; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select> 
                </div>
            </td>
            <td width="21%">&nbsp;</td>                        
            <td width="47%" align="left">&nbsp;</td>
        </tr>

        <tr>
            <td width="14%" align="left">Total Amount :</td>
            <td width="5%" align="left"><strong>&pound; <span id="total_span">0.00</span></strong></td>
            <td width="21%">&nbsp;</td>                        
            <td width="47%" align="left">&nbsp;</td>
        </tr>

        <!-- <tr>
            <td width="14%" align="left">Upgrade Difference</td>
            <td width="5%" align="left"><strong>&pound; = Number of Months Left x (New Package - Current Package) </strong></td>
            <td width="21%">&nbsp;</td>                        
            <td width="47%" align="left">&nbsp;</td>
        </tr> -->

        <tr>
            <td align="left">Grand Total</td>
            <td align="left">
                <div style="float: left; margin: 2px 2px 0 0;font-size: 14px;font-weight: bold;">&pound;</div>
                <div style="float: left; width:92%"><input type="text" name="amount" id="amount" style="width:140px"></div>
            </td>
            <td colspan="2">&nbsp;</td>
        </tr>

        <tr>
            <td width="14%" align="left">&nbsp;</td>
            <td align="left" colspan="3" style="height: 60px;">
                <input type="image" name="submit" border="0" src="/img/btn_buynow_LG.gif" alt="PayPal - The safer, easier way to pay online" style="height:22px">
            </td>
        </tr>

    </tbody>
</table>
</form>

<div class="choose_plan" style="display: none;"><img src="img/lst_img2.jpg" /></div>
</div>
<!--end payment part-->
          
      </div>
    </section>
    <!-- /.content -->
  </aside>
  <!-- /.right-side -->
</div>


       
<!-- ADD JOB START DATE MODAL END -->
@stop
<!--staff -->