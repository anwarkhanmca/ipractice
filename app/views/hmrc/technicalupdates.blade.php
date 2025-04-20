@extends('layouts.layout')


@section('mycssfile')

<style>
#example1_filter{position: absolute; left: -18%;} 
</style>



<!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->
@stop

@section('myjsfile')
<script src="{{ URL :: asset('js/plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

<!--<script src="{{ URL :: asset('js/technical.js') }}" type="text/javascript"></script>-->
<script src="{{ URL :: asset('js/org_clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/relationship.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
<!-- Date picker script -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<!-- Date picker script -->
<script>
var Table1, Table2, Table3;
$(function() {
//$(function() {
  Table1 = $('#example1').dataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, 200]],
        "iDisplayLength": 50,
        "language": {
            "lengthMenu": "Show _MENU_ entries",
            "zeroRecords": "Nothing found - sorry",
            "info": "Showing page _PAGE_ of _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
        },

      "aoColumns":[
            //{"bSortable": false},
            {"bSortable": true},
            {"bSortable": true},
            {"bSortable": true},
           // {"bSortable": true},
           // {"bSortable": false},
           // {"bSortable": false},
            {"bSortable": false}
        ]

    });
});



$(document).ready(function () {
  $(window).load(function() {
    $(".page_loader").fadeOut("slow");
  });

  /*$('#pdf_loader_div').load(function() {
    $(".page_loader").fadeOut("slow");
  });*/

});


</script>






@stop

@section('content')
<div class="wrapper row-offcanvas row-offcanvas-left">
  <aside class="left-side sidebar-offcanvas {{ $left_class }}">
    <section class="sidebar">
      @include('layouts/inner_leftside')
    </section>
  </aside>

  <aside class="right-side {{ $right_class }}">
    @include('layouts.below_header')

    <!-- Main content -->
<section class="content">
  <div class="row" style="margin-bottom: 15px;">
    <div class="col-md-6"></div>
    <div class="col-md-6">
      <table width="100%">
        <tr>
          <td style="width: 15%"></td>
          <td style="width: 30%"><strong class="search_t"><a href="/hmrc/technicalupdates/policy">HMRC - POLICY PAPERS</a></strong></td>
          <td style="width: 25%"><strong class="search_t"><a href="/hmrc/technicalupdates/guidance">HMRC - GUIDANCE</a></strong></td>
          <td style="width: 30%"><strong class="search_t"><a href="/hmrc/technicalupdates/agent">TAX AGENT UPDATES</a></strong></td>
        </tr>
      </table>
    </div>
    <div class="clearfix"></div>
  </div>

<div class="practice_mid"> 

<div class="tax_return_con">
<div class="col_m2">   
  <div class="page_loader"><img src="/img/spinner.gif"></div>    
<div style="width:93%; margin: 0 auto;">
  <!-- <object id="pdf_loader_div" data='http://pdf.fivefilters.org/makepdf.php?v=2.5&url=https%3A%2F%2Fwww.gov.uk%2Fgovernment%2Fpublications.atom%3Fdepartments%255B%255D%3Dhm-revenue-customs%26topics%255B%255D%3Dtax-and-revenue&mode=multi-story&output=pdf&template=Letter&title=NEWS+FOR+AGENTS+%26+ADVISORS&order=desc&date=true&api_key=&sub=I-PRACTICE+NEWS' type='application/pdf' width='100%' height='700px'> -->

  <iframe id="pdf_loader_div" width="100%" height="700px" src="/pdfload/{{$button}}"></iframe>

<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <tr>
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="42%" valign="top" class="h_text_top">
    Sed ut perspiciatis unde omnis <br />
- Iste natus error sit voluptatem
    </td>
  <td width="41%" valign="top" class="h_text_top">
    Sed ut perspiciatis unde omnis <br />
- Iste natus error sit voluptatem
    </td>
   <td width="17%" valign="top" align="right" class="h_text_top">
   - Sed ut perspiciatis unde
    </td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="b_border">
  <tr>
    <td width="42%"><a href="#"><img src="/img/hm_logo.jpg" /></a></td>
    <td width="28%"><a href="#"><img src="/img/hm_logo.jpg" /></a></td>
    <td width="30%" class="text_return"><h3>Tax Return 2015</h3>
<p>Tax year 6 April 2014 to 5 April 2015(2014-15)</p></td>
  </tr>
  <tr>
    <td colspan="3" height="10"></td>
  </tr>
</table>

    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="utr_table">
  <tr>
    <td width="12%">UTR</td>
    <td width="27%">05058255</td>
    <td width="11%">TR</td>
    <td width="30%">05485288</td>
    <td width="20%">Issue Address</td>
  </tr>
  <tr>
    <td>Tax Reference</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table> -->
</div>
</div>

</div>
    <!-- <table width="100%" class="table table-bordered table-hover" id="example1" aria-describedby="example1_info" style="margin-top: 15px;">
    
            
                            <thead>
                              <tr>
                                <td  width="5%" align="center"><strong>Delete</strong></td>
                                <td width="15%" align="center"><strong>Date & Time</strong></td>
                                <td width="55%" align="center"><strong>Topic</strong></td>
                                <td width="15%" align="center"><strong>Commentary</strong></td>
                                
                              </tr>
                            </thead>
    
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                                
                            <tr>
                             <td align="center">
                            <a href="javascript:void(0)" data-client_id="" data-tab=""><img src="/img/cross.png"></a>                
                            </td>
                            <td align="center">               
                           4:31pm, 04september2015
                            </td>
                            <td align="center" id="frequency">
                            
                           <p id="businessname" align="center" style="margin: -3px 0px -9px 1px;font-size: 18px; font-weight: bold;color:#00acd6">Professional bodies approved for tax relief (list3)</p>
                            
                            
                            </td>
                            <td align="center">
                            <a href="#">View</a>
                            </td>
    
                        </tr>
                                        
                              
                            </tbody>
                          </table> -->
          
        
      </div></section>
</aside>



@stop