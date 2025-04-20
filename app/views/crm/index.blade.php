

@extends('layouts.layout')

@section('mycssfile')
<style>
/* .leads_tab li h3{ color:#fff; background: #000; font-size: 13px; padding: 8px 0 !important; margin: 0 0 0px 0!important; cursor: text;} */
.table_popup tr td{padding:10px;}
.yes_btn{background: green; color:#fff; float: left; border: none; outline: none; padding:5px 15px 5px 15px;}
.no_btn{background: gray; color:#fff; float: left; border: none; outline: none; padding:5px 15px 5px 15px;}
.job_send_btn, .job_sent_btn{ margin-bottom: 5px; margin-top: 5px;}

.blue_table{background: #0085f3;}
.blue_table td{ border:0 !important; border-right: 2px solid #fff !important; font-weight: bold !important; font-size: 18px; padding-top: 2px !important; padding-bottom: 2px !important;}
.blue_table td img{margin-right: 10px;}
.table_popup tr td{ padding-bottom: 0!important;}

/*proposal style*/

.proposal-dropdown-menu>li>a:hover{ background-color: #0866C6 }
.proposal-button{ font-size: 15px;}
.proposal-input-group{ margin-bottom: 10px;}
.proposal-label{ margin-top: 0px; margin-bottom: 0px; padding: 6px;}
.service-holder {
    position: absolute;
    top: 30px;
    display: none;
    background-color: #ffffff;
    width: 270px;
    border: 1px solid #efefef;
    z-index: 1000;
    box-shadow: 0 0 4px 0px #ccc;
}
.service-holder ul {
    list-style: none;
    margin: 0px;
    padding: 0px;
}
.service-holder ul li {
    margin: 0px;
    list-style: none;
    width: 100%;
    padding: 5px 10px;
    color: #666;
    background-color: #fff;
    border-bottom: 1px solid #e2e2e2;
}

.error-msg {
    color: red;
}

.proposal-top {
    margin: 0 auto;
    margin-bottom: 10px;
    border: none;
}
.proposal-attach-label{ margin-top: 0px; margin-bottom: 0px; padding: 6px; width: 140px !important;}
.proposal-template-label{ margin-top: 0px; margin-bottom: 0px; padding: 6px; width: 140px !important;}

.attachment-item{
        width:140px;
        float:left;
        margin-right:25px;
        margin-bottom: 10px;
        height: 240px;
        overflow: hidden;
    }
    .img-holder{
        padding:10px;
        border:1px solid #e2e2e2;
        border-radius: 4px;
    }
    .attachment-item img{
        width:100%;
        height:auto;
    }
    .attachment-item-title{
        padding:10px 0px;
        text-align: center;
    }

/*end proposal style*/
  svg:not(:root){overflow: inherit; margin-right: 20px; float:right;}

</style>


<link href="{{URL :: asset('css/datatables/dataTables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <!-- Date picker script -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<!-- Date picker script -->

<!-- Loader Css -->
<link href="{{URL :: asset('css/loader.css')}}" rel="stylesheet" type="text/css" />
<!-- <link href="{{ URL :: asset('css/colorpicker/colorpicker.css')}}" rel="stylesheet"> -->

<!-- Time picker script -->
<link rel="stylesheet" href="{{ URL :: asset('css/timepicki.css') }}" />

<!-- google search -->
<link rel="stylesheet" href="{{ URL :: asset('css/address_search.css') }}" />
<!-- google search -->
@stop

@section('myjsfile')
<!-- proposal js -->
<script src="{{ URL :: asset('js/proposal.js') }}" type="text/javascript"></script>
<!-- chart js -->
<script src="{{ URL :: asset('js/chartjs/Chart.min.js') }}"></script>
<!-- summernote js -->
<script src="{{ URL :: asset('js/summernote.js') }}"></script>
<!-- choosen js -->
<script src="{{ URL :: asset('js/chosen.js') }}"></script>
<!-- datepicker js -->
<script src="{{ URL :: asset('js/datepickerbootstrap/js/bootstrap-datepicker.js') }}"></script>


<!-- end proposal js -->

<!-- Time picker script -->
<script src="{{ URL :: asset('js/timepicki.js') }}"></script> 

<!-- Time picker script -->
<script src="{{ URL :: asset('js/forecast.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/crm.js') }}" type="text/javascript"></script>
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

<script src="{{ URL :: asset('js/jtablejs/wip.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/todolist.js') }}" type="text/javascript"></script>

<script>
$(document).ready(function(){
  var tab_no = $('#tab_no').val();
  if(tab_no == 1){
    $('.overlay').show();
  }else{
    $('.overlay').hide();
  }
});
  $(window).load(function() {
		//$("#before_show").hide();
    //$("#after_show").show();

    setTimeout(function(){
        $('.overlay').hide();
    },1000);

	});
    
    
    
    
  $(document).click(function() {
    $(".open_toggle").hide();
  });
  $("#small_icon").click(function(event) {
   // alert('dadad');return false;
      $(".open_toggle").toggle();
      event.stopPropagation();
  });
  $(".lead_QUOTES_modal").click(function() {
    $("#quotessettings-modal").modal("show");
  });
  
$(document).ready(function(){
    var terms={
      "PIA":"Payment in advance",
      "Net 7":"Payment seven days after invoice date",
      "Net 10":"Payment ten days after invoice date",
      "Net 30":"Payment thirty days after invoice date",
      "Net 60":"Payment sixty days after invoice date",
      "Net 90":"Payment ninty days after invoice date",
      "EOM":"End of Month",
      "21 MFI":"21st of the month following invoice date",
      "1% 10 Net 30":"1% discount if payment received within ten days otherwise payment 30 days after invoice date",
      "COD":"Cash on delivery",
      "Cash account":"Account conducted on a cash basis, no credit",
      "Letter of credit":"A documentary credit confirmed by a bank, often used for export",
      "Bill of Exchange":"A promise to pay at a later date, usually supported by a bank",
      "CND":"Cash next delivery",
      "CBS":"Cash before shipment",
      "CIA":"Cash in advance",
      "CWO":"Cash with order",
      "1MD":"Monthly credit payment of a full month's supply",
      "2MD":"As above plus an extra calendar month",
      "Contra":"Payment from the customer offset against the value of supplies purchased from the customer",
      "Stage payment":"Payment of agreed amounts at stage",
    }

    $(".choosen").chosen({
      no_results_text: "Oops, nothing found!"
    });


    //////////////CHOSEN SELECT AND TERMS SHOW////////////
    $(".choosen").change(function(){
      var term=$(".choosen").val();
      $(".terms").css({"display":"none"});
      $(".terms p").text(terms[term]);
      $(".terms").fadeIn(200);
    });



    //$(".dpick").datepicker({ minDate: new Date(1900, 12-1, 25), maxDate:0, dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true, yearRange: "-10:+10" });
    
    $("#close_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $(".close_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#from_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#to_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#new_lead_date").datepicker({ dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    $("#pop_startdate").datepicker({dateFormat:'dd-mm-yy', changeMonth:true, changeYear:true});
    $("#pop_joining").datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
    $("#pop_fwd_date").datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
    $("#pop_fwd_end").datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
    $("#tobecollect_date").datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
    $("#ProsStartDate").datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
    $("#ProsEndDate").datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});
    $("#edittaskdate").datepicker({dateFormat: 'dd-mm-yy', changeMonth:true, changeYear:true});

    $('#edittask_time').timepicki({
      show_meridian:false,
      max_hour_value:23,
      increase_direction:'up'
    });

    $('#roll_amount, .priceRound, #annual_revenue, .amountformat, #pop_amount, #quoted_value').priceFormat({
        prefix: ''
    });
    
    
    
});

</script>
<script type="text/javascript">

$(function() {
  $('input#id_search').quicksearch('.forecastsearch  li');
});


  $(function() {
    var page_open = '{{ $page_open }}';

     $('#exaforecast').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true}
       
      ],
      "aaSorting": [[1, 'desc']]
    });
    
    $('#mailing').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      
       
      ],
      "aaSorting": [[1, 'desc']]
    });
    $('#exampletab7').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
        
      ],
      "aaSorting": [[2, 'asc']]
    });
    $('#example21').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        //{"bSortable": false},
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[8, 'asc']]
    });
  if(page_open == '37'){ 
    $('#exampletab3').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,
      "aoColumns":[
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
      ],
      "aaSorting": [[2, 'desc']]
    });
  }else if(page_open == '38'){ 
    $('#exampletab3').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,
      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
      ],
      "aaSorting": [[2, 'desc']]
    });
  }else{
    $('#exampletab3').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, 100]],
      "iDisplayLength": 25,
      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
      ],
      "aaSorting": [[1, 'asc']]
    });
  }
    
    
  $('#exampletab4').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
    "iDisplayLength": 25,
    "aoColumns":[
      {"bSortable": false},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      /*{"bSortable": true},
      {"bSortable": false},
      {"bSortable": false},*/
      {"bSortable": false}
    ],
    "aaSorting": [[5, 'desc']]
  });
  $('#exampletab42').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[25, 50, 100, 200], [25, 50, 100, 200]],
    "iDisplayLength": 25,
    "aoColumns":[
      {"bSortable": false},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": false}
    ],
    "aaSorting": [[1, 'asc']]
  });
    
  $('#example611').dataTable({
    "bPaginate": true,
    "bLengthChange": true,
    "bFilter": true,
    "bSort": true,
    "bInfo": true,
    "bAutoWidth": false,
    "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
    "iDisplayLength": 25,

    "aoColumns":[
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": true},
      {"bSortable": false},
      {"bSortable": false},
      {"bSortable": false}
    ],
    "aaSorting": [[0, 'desc']]
  });

  for(var k=2; k<=11;k++){
    $('#example61'+k).dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        /*{"bSortable": true},*/
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        //{"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'desc']]
    });
  }

  $('#example62').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        //{"bSortable": false},
        //{"bSortable": false},
        //{"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'desc']]
    });

  $('#example63').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        //{"bSortable": false},
        //{"bSortable": false},
        //{"bSortable": false},
        //{"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'desc']]
    });

  $('#example64').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false},
        //{"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'desc']]
    });

  for(var k=0; k<=5;k++){ 
    $('#example51'+k).dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        //{"bSortable": false},
        //{"bSortable": false},
        //{"bSortable": false},
        //{"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'desc']]
    });
  }



  $('#tax_table').dataTable({});

  $('#attachment_table').dataTable({"order": [[ 0, "asc" ]]});

  $('#proposal_table').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[0, 'desc']]
    });

  $('#invoice_table').dataTable({"order": [[ 5, "desc" ]]});

  $('#payment_table').dataTable({"order": [[ 3, "desc" ]]});

  $('#bill_detail_table').dataTable({});

  $('#schedule_table').dataTable({"ordering": false});

  $('#product_table').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": true},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[0, 'desc']]
    });

    $('#attchCreateTbl').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[1, 'asc']]
    });

    $('#letterTemplate, #pricingTemplate').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[0, 'asc']]
    });

    $('#proposalTemplate').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[0, 'asc']]
    });

    $('#serviceTable').dataTable({
      "bPaginate": true,
      "bLengthChange": true,
      "bFilter": true,
      "bSort": true,
      "bInfo": true,
      "bAutoWidth": false,
      "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
      "iDisplayLength": 25,

      "aoColumns":[
        {"bSortable": false},
        {"bSortable": true},
        {"bSortable": false},
        {"bSortable": false},
        {"bSortable": false}
      ],
      "aaSorting": [[0, 'asc']]
    });
        

});

</script>

<script src="{{ URL :: asset('js/graph.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/jquery.maskedinput.js') }}" type="text/javascript"></script>
<!-- <script src="{{ URL :: asset('js/colorpicker/colorpicker.js') }}" type="text/javascript"></script> -->
<script src="{{ URL :: asset('js/proposal_settings.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('ckeditor/ckeditor.js') }}"></script>
<!-- <script src="{{ URL :: asset('js/contact_email_templates.js') }}" type="text/javascript"></script>
<script src="{{ URL :: asset('js/template_type.js') }}" type="text/javascript"></script> -->
@if(isset($tab_level) && $tab_level == '4341')
  <script type="text/javascript">
    $(window).load(function() {
      CKEDITOR.replace("pnTempDesc", {
        height: 600
      });
    });
  </script>
@endif
@if(isset($tab_level) && $tab_level == '4212')
  <script type="text/javascript">
    $(window).load(function() {
      CKEDITOR.replace( 'coverLtrText', {height : 600}); 
    });
  </script>
@endif

@if(isset($page_open) && $page_open == 'terms')
  <script type="text/javascript">
    $(window).load(function() {
      CKEDITOR.replace( 'terms_description'); 
    });
  </script>
@endif

<script type="text/javascript">
/*$(document).ready(function() {
  var borderColor;
  $('#menuColor').ColorPicker({
    onSubmit : function(hsb, hex, rgb, el) {
      $(el).val('#' + hex);
      $(el).ColorPickerHide();
      borderColor = $('#menuColor').val();
      console.log(borderColor)
      $('#colorArea2').css({'background-color' : borderColor});
    },
    onBeforeShow : function() {
      console.log('2')
      $(this).ColorPickerSetColor(this.value);
    }
  }).bind('keyup', function() {
    console.log('3')
    $(this).ColorPickerSetColor(this.value);
  });
});*/
</script>

<!-- Editor -->
<script src="{{ URL :: asset('classy-editor/js/jquery.classyedit.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL :: asset('classy-editor/css/jquery.classyedit.css') }}" />

<script src="{{ URL :: asset('js/contact_email_templates.js') }}"></script>

<script src="{{ URL :: asset('js/crm/clients/organisation.js') }}" type="text/javascript"></script>

<!-- JTable -->
<script src="{{ URL :: asset('js/jtablejs/proposal.js') }}" type="text/javascript"></script>

<script src="{{ URL :: asset('js/clients.js') }}" type="text/javascript"></script>

<!-- google search -->
<script src="{{ URL :: asset('js/address_search.js') }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCc7HTLVvrPyl_cJQGPIb1GuWwq0cTC4MY&libraries=places&callback=initAutocomplete" async defer></script>
<!-- google search -->
@stop

@section('content')
<!-- proposal -->
<input type="hidden" name="base_url" value="{{ url() }}" id="base_url">
<input type="hidden" name="root_path" value="{{ base_path() }}" id="root_path">
<input type="hidden" name="upload_path" value="{{ __DIR__.'/../uploads' }}" id="upload_path">

<!-- end proposal -->

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
          <a href="/pdfcrm/{{ base64_encode(isset($page_open)?$page_open:'') }}/{{ base64_encode(isset($owner_id)?$owner_id:'') }}" class="btn btn-success" style=""><i class="fa fa-download"></i> Generate PDF</a>
             <!-- <button class="btn btn-success"><i class="fa fa-download"></i> Generate PDF</button> -->
            </li>
            <li>
             <a href="/excelcrm/{{ base64_encode(isset($page_open)?$page_open:'') }}/{{ base64_encode(isset($owner_id)?$owner_id:'') }}" class="btn btn-primary" style=""><i class="fa fa fa-file-text-o"></i> Excel</a>
           <!--   <button class="btn btn-primary"><i class="fa fa fa-file-text-o"></i> Excel</button> -->
            </li>

            <!-- <li>
              <a href="/xero/index.php?invoice=1&method=put" class="btn btn-info">INVOICE</a>
              
            </li> -->

            <div class="clearfix"></div>
          </ul>
        </div>

        <div id="message_div"><!-- Loader image show while sync data --></div>
      </div>

      

      </div>
      <div class="practice_mid">
      <input type="hidden" name="page_open" id="page_open" value="{{ $page_open or '' }}">
      <input type="hidden" name="encode_page_open" id="encode_page_open" value="{{$encode_page_open or '' }}">
      <input type="hidden" name="encode_owner_id" id="encode_owner_id" value="{{ $encode_owner_id or '' }}">
      <input type="hidden" name="tab_no" id="tab_no" value="{{ $tab_no or '' }}">
      <input type="hidden" id="user_id" value="{{ $user_id or '' }}">
      <input type="hidden" id="client_type" value="{{ $client_type or 'all' }}">
    <div class="tabarea">
  
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-tabsbg">
      <li class="{{ (isset($tab_no) && $tab_no == 1)?'active':'' }}"><a href="{{ $goto_url or '' }}/{{ base64_encode('11') }}/{{ base64_encode(isset($owner_id)?$owner_id:'') }}/crm">DASHBOARD</a></li>
      <li class="{{ (isset($tab_no) && $tab_no == 5)?'active':'' }}"><a href="{{ $goto_url or '' }}/{{ base64_encode('51') }}/{{ base64_encode(isset($owner_id)?$owner_id:'') }}/leads">LEADS</a></li>
      <li class="{{ (isset($tab_no) && $tab_no == 6)?'active':'' }}"><a href="{{ $goto_url or '' }}/{{ base64_encode('611') }}/{{ base64_encode(isset($owner_id)?$owner_id:'') }}/opportunities">PROSPECTS</a></li>
      <li class="{{ (isset($tab_no) && $tab_no == 'proposal')?'active':''}}"><a href="{{ url('crm/proposals')}}">PROPOSALS</a></li>
      <li class="{{ (isset($tab_no) && ($tab_no == 2 || $tab_no == 3))?'active':'' }}"><a href="{{ $goto_url or '' }}/{{ base64_encode('2') }}/{{ base64_encode(isset($owner_id)?$owner_id:'') }}/clients">CLIENTS</a></li>
      <li class="{{ (isset($tab_no) && ($tab_no == 9 ))?'active':'' }}"><a href="{{$goto_url or ''}}/{{ base64_encode('9')}}/{{ base64_encode(isset($owner_id)?$owner_id:'') }}/wip">WIP</a></li>
      
    </ul>

<div class="tab-content">
  <!-- Tab 1 Start-->
@if($page_open == 11)
  <div id="tab_11" class="tab-pane {{ ($page_open == 11)?'active':'' }}">
    @include('crm/includes/tabone')
  </div>
@endif
<!-- Tab 1 End-->

<!-- Tab 2 Start-->
@if($tab_no == 2 || $tab_no == 3)
  <div id="tab_2" class="tab-pane {{ ($tab_no == 2 || $tab_no == 3)?'active':'' }}">
    @include('crm/includes/tabtwo')
  </div>
@endif
<!-- Tab 2 End-->

<!-- Tab 3 Start-->

<!-- Tab 3 End-->

<!-- Tab 4 Start-->
@if($tab_no == 4)
  <div id="tab_4" class="tab-pane {{($tab_no == 4)?'active':'' }}">
    @include('crm/includes/tabfour')
  </div>
@endif
<!-- Tab 4 End-->

<!-- Tab 5 Start-->
@if($page_open == 51 || $page_open == 511 || $page_open == 512 || $page_open == 513 || $page_open == 514 || $page_open == 515)
  <div id="tab_51" class="tab-pane {{ ($page_open == 51 || $page_open == 511 || $page_open == 512 || $page_open == 513 || $page_open == 514 || $page_open == 515)?'active':'' }}">
      @include('crm/leads_tab')
  </div>
@endif
<!-- Tab 5 End-->

<!-- Tab 6 Start-->
@if($page_open == 611 || $page_open == 612 || $page_open == 613 || $page_open == 614 || $page_open == 615 || $page_open == 616 || $page_open == 617 || $page_open == 62 || $page_open == 63 || $page_open == 64 || $page_open == 65)
  <div id="tab_61" class="tab-pane {{ ($page_open == 611 || $page_open == 612 || $page_open == 613 || $page_open == 614 || $page_open == 615 || $page_open == 616 || $page_open == 617 || $page_open == 62 || $page_open == 63 || $page_open == 64 || $page_open == 65)?'active':'' }}">
    @include('crm/opportunities_tab')
  </div>
@endif
<!-- Tab 6 End-->

<!-- Tab proposal Start-->
  @if($tab_no == 'proposal')
    <div id="tab_proposal" class="tab-pane {{ ($tab_no == 'proposal')?'active':'' }}">
    @include('crm/proposal/proposal_tab')
    </div>
  @endif
<!-- Tab proposal End--> 

<!-- Tab 7 Start-->
@if($page_open == '7')
  <div id="tab_7" class="tab-pane {{ ($page_open == '7')?'active':'' }}">
    <div class="col_m2" style="position:relative;">
      <div class="" style="position: absolute; left:15%; top:10px; width:58%; bottom: 20px; z-index: 10;">
        <table width="100%" border="0" class="table table-bordered blue_table" style="color:#fff;">
          <tbody>
            <tr>
              <td>1</td>
              <td>35</td>
              <td>10</td>
              <td>0</td>
              <td>20</td>
            </tr>
            <tr>
              <td>&pound;12,000.00</td>
              <td>&pound;15,000.00</td>
              <td>&pound;11,000.00</td>
              <td>&pound;106,000.00</td>
              <td>&pound;10,000.00</td>
            </tr>
             <tr>
              <td><img src="/img/draft.png" width="15" />Draft</td>
              <td><img src="/img/sent.png" width="15" />Sent</td>
              <td>Viewed/Discussion</td>
              <td><img src="/img/accepted.png" width="15" />  Accepted</td>
              <td><img src="/img/accepted.png" width="15" /> Lost</td>
            </tr>
          </tbody>
        </table>
      </div>  
   
      <table width="100%" border="0" class="staff_holidays" style="margin-top:70px;">
        <tbody>
          <tr>
            <table class="table table-bordered table-hover dataTable crm" id="exampletab7">
              <thead>
                <tr>
                  <td><input type="checkbox" name="" class="CheckallCheckbox" /></td>
                  <td><strong>Date</strong></td>
                  <td align="left"><strong>Client Name1</strong></td>
                  <td align="left"><strong>Contact Name</strong></td>
                  <td align="left"><strong>Email</strong></td>
                  <td align="left"><strong>Phone</strong></td>
                   <td align="left"><strong>Type</strong></td>
                  <td align="left"><strong>Ammount</strong></td>
                    <td align="left"><strong>Quote</strong></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input type="checkbox" name="" class="CheckallCheckbox" /></td>
                  <td>10-11-2015</td>
                  <td>Abel</td>
                  <td align="left">&nbsp; </td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">&nbsp;</td>
                  <td align="left">80,000,00</td>
                 
                  <td align="center">
                    <div class="email_client_selectbox" style="height:24px; width:93px!important; z-index: 999;">
                      <span>SEND</span>
                      <div class="small_icon" id="small_icon" data-id="47" data-tab="11"></div>
                      <div class="clr"></div>
                      <div class="open_toggle" style="display: none; width:156px;">
                        <ul>
                          <li data-value="1">Re Send</li>
                          <li data-value="2">Revoke and Edit</li>
                          <li data-value="3">Approve and Accpet</li>
                          <li data-value="4">Mark as a Lost</li>
                          <li data-value="5">Duplicate</li>
                          <li data-value="6">Delete</li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
@endif
<!-- Tab 7 End-->

<!-- Tab 8 Start-->
@if($page_open == 8)
  <div id="tab_8" class="tab-pane {{ ($page_open == 8)?'active':'' }}">
    <div class="import_fromch_main" style="width:600px;padding-left: 20px;padding-bottom:46px;padding-top:10px;">
      <div class="import_fromch"  style=" margin-right: 42px;">
        <a href="javascript:void(0)" class="import_fromch_link">+ ADD NEW</a>
      </div>
      <div class="import_fromch" >
        <a href="javascript:void(0)" class="import_fromch_link">IMPORT - CSV</a>
      </div>
    </div>
    
    <div class="col_m2">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;">
          <li class="active"><a data-toggle="tab" href="#tab_6">LIST</a></li>
          <li class=""><a data-toggle="tab" href="#tab_7">EXAMPLE DESCRIPTION</a></li>
        </ul>
        <div class="tab-content">
          <div id="tab_6" class="tab-pane active">
          <!--table area-->
          <div class="box-body table-responsive">
            <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
              <div class="row">
                <div class="col-xs-6"></div>
                <div class="col-xs-6"></div>
              </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="col_m2">
                  <div class="notes_top_btns"> </div>
                  <div class="total_annual_fee">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody><tr>
                      
                      <!--  <td>Total Annual Fees</td>
                        <td><input type="text" id="" class="form-control"></td>
                        <td width="10%">&nbsp;</td>
                        <td>Average Fees</td>
                        <td><input type="text" id="" class="form-control"></td> -->
                      </tr>
                    </tbody></table>
                  </div>
      
      
      <table width="100%" border="0" class="staff_holidays">
        <tbody>
          <tr>
            <td valign="top"><table width="100%" border="0">
                <tbody>
                  <tr>
                   
                    
                    
                    
                    
                  </tr>
                </tbody>
              </table></td>
          </tr>
          <tr>
            <td valign="top">
             
            
<table class="table table-bordered table-hover dataTable crm" id="mailing" aria-describedby="mailing_info">                                            
            
                <thead>
                  <tr>
                   
                    <td align="center" style="width:10%"><strong>Date</strong></td>
                    <td align="center" style="width:60%"><strong>List Name</strong></td>
                    <td align="center" style="width:20%"><strong>Action</strong></td>
                    <td align="center" style="width:10%"><strong>Notes</strong></td>
                    
                   
                  </tr>
                  </thead>
                <tbody>
                  <tr>
                    
                    <td align="center">09-09-2015</td>
                    <td align="center">EXAMPLE DESCRIPTION</td>
                    <td align="center">
                    <span style="padding-right: 20px;"><button  style="border-radius: 4px; width: 100px; border-color: rgb(8, 102, 198);" >Download</button></span>
                    
                    
                    <span style="padding-left:10px ;">
                   
                    <img src="/img/edit_icon.png"></span>
                    <span style="padding-left:10px ;">
                    <img src="/img/cross.png">
                   </span>
                    </td>
                   <td align="center">
            <a href="javascript:void(0)" class="notes_btn " id="mailingnotes"  data-leads_id="21" data-tab="11"><span style="">notes</span></a>
                    </td>

                    
                 
                  </tr>
               
                </tbody>
              </table></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
</div>
<!--end table-->
</div>
      <!-- /.tab-pane -->
      <div id="tab_7" class="tab-pane">
        <!--table area-->
        <div class="box-body table-responsive">
          <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
            <div class="row">
              <div class="col-xs-6"></div>
              <div class="col-xs-6"></div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="col_m2">
                  <div class="notes_top_btns"> </div>
                  <div class="total_annual_fee">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tbody><tr>
                      <!--  <td>Total Annual Fees</td>
                        <td><input type="text" id="" class="form-control"></td>
                        <td width="10%">&nbsp;</td>
                        <td>Average Fees</td>
                        <td><input type="text" id="" class="form-control"></td> -->
                      </tr>
                    </tbody></table>
                  </div>
                  <table width="100%" border="0" class="staff_holidays">
                    <tbody>
                      <tr>
                        <td valign="top"><table width="100%" border="0">
                            <tbody>
                              <tr>
                                <td width="5%"><strong>Show</strong></td>
                                <td width="7%"><select class="form-control">
                                    <option>50</option>
                                    <option>20</option>
                                    <option>10</option>
                                    <option>15</option>
                                  </select></td>
                                <td width="35%"><strong>entries</strong></td>
                                <td width="24%">&nbsp;</td>
                                <td width="5%"><strong>Search</strong></td>
                                <td width="21%"><input type="text" id="" class="form-control"></td>
                              </tr>
                            </tbody>
                          </table></td>
                      </tr>
                      <tr>
                        <td valign="top"><table width="100%" class="table table-bordered">
                            <tbody>
                              <tr>
                                <td><div class="icheckbox_minimal" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div></td>
                                <td><strong>Joining Date</strong></td>
                                <td align="center"><strong>Client Name</strong></td>
                                <td align="center"><strong>Payment Method</strong></td>
                                <td align="center"><strong>Engagement letters</strong></td>
                                <td align="center"><strong>Annual Fee</strong></td>
                                <td align="center"><strong>Monthly Fees</strong></td>
                                <td align="center"><strong>Contract End Date</strong></td>
                                <td align="center"><strong>Count Down</strong></td>
                                <td align="center"><strong>Renewals</strong></td>
                                <td align="center"><strong>Quotes</strong></td>
                              </tr>
                              <tr>
                                <td><div class="icheckbox_minimal" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div></td>
                                <td>09-09-2015</td>
                                <td align="center">Cockerton &amp; Co Limited</td>
                                <td align="center">ewfe</td>
                                <td align="center"><select class="form-control">
                                    <option>50</option>
                                    <option>20</option>
                                    <option>10</option>
                                    <option>15</option>
                                  </select></td>
                                <td align="center">&nbsp;</td>
                                <td align="center">ergre</td>
                                <td align="center">ewfew</td>
                                <td align="center">ewf</td>
                                <td align="center"><button class="btn btn-default">SENT</button></td>
                                <td align="center"><button class="btn btn-default">View</button></td>
                              </tr>
                              <tr>
                                <td><div class="icheckbox_minimal" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div></td>
                                <td>09-09-2015</td>
                                <td align="center">Cockerton &amp; Co Limited</td>
                                <td align="center">ewfe</td>
                                <td align="center"><select class="form-control">
                                    <option>50</option>
                                    <option>20</option>
                                    <option>10</option>
                                    <option>15</option>
                                  </select></td>
                                <td align="center">&nbsp;</td>
                                <td align="center">ergre</td>
                                <td align="center">ewfew</td>
                                <td align="center">ewf</td>
                                <td align="center"><button class="btn btn-default">SENT</button></td>
                                <td align="center"><button class="btn btn-default">View</button></td>
                              </tr>
                            </tbody>
                          </table></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--end table-->
      </div><!-- tab7 end -->

      <!-- /.tab-pane -->
    </div>
  </div>
  <!--end sub tab-->
</div>
  
  
<!-- Tab 8 -->
  </div>
@endif
<!-- Tab 8 End-->

<!-- Tab 9 start-->
  <div id="tab_9" class="tab-pane {{ ($page_open == '9')?'active':'' }}">
    <div class="row">
      <div class="col-xs-6"></div>
      <div class="col-xs-6"></div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="col_m2">
          <div class="row bottom_space">
            <div class="col-xs-6">
              <div class="dataTables_length" id="example2_length">
                <div style="float: left; margin-right: 5px;">Action</div> 

                <div class="btn-group" style="float: left;" id="wipActionDrop">
                  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-gear tiny-icon"></i> <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu proposal-dropdown-menu" role="menu">
                    <!-- <li><a href="#" target="_blank"><i class="fa fa-eye tiny-icon"></i>Preview</a></li> -->
                    <!-- <li><a href="javascript:void(0)"><i class="fa fa-tasks"></i>Allocate Job</a></li> -->
                    <li><a href="javascript:void(0)" class="invoiceXero"><i class="fa fa-file-text-o" aria-hidden="true"></i>Invoice</a></li>
                    <li><a href="javascript:void(0)" class="tasknamed" data-taskid="0"><i class="glyphicon glyphicon-plus-sign" aria-hidden="true"></i>Add New Job</a></li>

                    <li><a href="javascript:void(0)" class="deleteWipData"><i class="fa fa-trash-o tiny-icon"></i>Delete</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-xs-6">
              <div id="example2_filter" class="dataTables_filter">
                <form>
                  <input type="text" name="wipSearchText" id="wipSearchText" placeholder="Search" class="tableSearch" />
                  <button type="submit" id="wipSearchButton" style="display: none;">Search</button>
                </form>
              </div>
            </div>
          </div>
          <div id="wipTable"></div>
        </div>
      </div>
    </div>  
  </div>
<!-- Tab 9 End-->


</div>

</div>
          

</div>
        
      </div>
    </section>


</aside><!-- /.right-side -->
            
@include("crm.modal.prospect")

<!-- Add New Lead Start-->
<div class="modal fade" id="open_new_lead-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:700px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">NEW - LEAD ENQUIRY & PROSPECT</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '/crm/save-new-leads', 'id'=>'saveNewLeadOpporForm')) }}
      <input type="hidden" name="encode_page_open" value="{{ $encode_page_open or '' }}">
      <input type="hidden" name="encode_owner_id" value="{{ $encode_owner_id or '' }}">
      <input type="hidden" name="new_type" id="new_type" value="">
      <input type="hidden" name="new_leads_id" id="new_leads_id" value="0">
      <div class="modal-body">
        <div class="form-group" style="margin:0;">
            <div class="n_box12">
              <div class="form-group">
                <label for="exampleInputPassword1">Date</label>
                <input type="text" id="new_lead_date" name="new_lead_date" value="{{ $staff_row['date'] or '' }}" class="form-control date">
              </div>
            </div>

          <div class="n_box11">
            <div class="form-group">
              <!-- <label for="deal_certainty">Deal Certainty</label>
              <input type="text" id="deal_certainty" name="deal_certainty" value="100" class="form-control box_60" maxlength="3"><span style="margin-top: 7px; float:left;">%</span> -->
            </div>
          </div>

          <div class="f_namebox2">
            <label for="exampleInputPassword1">Lead Owner</label>
              <select class="form-control" name="new_deal_owner"  id="new_deal_owner">
                <option value="">-- None --</option>
                @if(isset($staff_details) && count($staff_details) >0)
                  @foreach($staff_details as $key=>$staff_row)
                  <option value="{{ $staff_row['user_id'] }}">{{ $staff_row['fname'] or "" }} {{ $staff_row['lname'] or "" }}</option>
                  @endforeach
                @endif
             </select>
          </div>
          <!-- <div class="f_namebox3">
            <label for="exampleInputPassword1">Attach Opportunity to Existing Client</label>
            <select class="form-control" name="existing_client" id="existing_client">
              <option value="0">-- None --</option>
              
             </select>
          </div> -->
          <div class="clearfix"></div>
        </div>

        <div class="twobox" id="lead_org_name_div">
          <div class="twobox_1">
            <div class="form-group" style="width:57%">
              <label for="exampleInputPassword1">Business Type <a href="#" class="add_to_list" data-toggle="modal" data-target="#addcompose-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></label>
              <select class="form-control" name="new_business_type" id="new_business_type">
                @if( isset($old_org_types) && count($old_org_types) >0 )
                  @foreach($old_org_types as $key=>$old_org_row)
                  <option value="{{ $old_org_row->organisation_id }}">{{ $old_org_row->name }}</option>
                  @endforeach
                @endif

                @if( isset($new_org_types) && count($new_org_types) >0 )
                  @foreach($new_org_types as $key=>$new_org_row)
                  <option value="{{ $new_org_row->organisation_id }}">{{ $new_org_row->name }}</option>
                  @endforeach
                @endif
              </select>
            </div>
            
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Lead Name</label>
              <input type="text" class="form-control" name="new_prospect_name" id="new_prospect_name">
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" id="lead_contact_name_div">
          <label for="exampleInputPassword1">Contact Name</label>
          <div class="clearfix"></div>
          <div class="n_box1">
            <select class="form-control select_title" id="new_contact_title" name="new_contact_title">
              <option value="">-- Title --</option>
              @if(!empty($titles))
                @foreach($titles as $key=>$title_row)
                <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="f_namebox">
            <input type="text" id="new_contact_fname" name="new_contact_fname" class="form-control" placeholder="First Name">
          </div>
          <div class="f_namebox">
            <input type="text" id="new_contact_lname" name="new_contact_lname" class="form-control" placeholder="Last Name">
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group" id="lead_name_div">
          <label for="exampleInputPassword1">Lead Name</label>
          <div class="clearfix"></div>
          <div class="n_box1">
            <select class="form-control select_title" id="new_prospect_title" name="new_prospect_title">
              <option value="">-- Title --</option>
              @if(!empty($titles))
                @foreach($titles as $key=>$title_row)
                <option value="{{ $title_row->title_name }}">{{ $title_row->title_name }}</option>
                @endforeach
              @endif
            </select>
          </div>
          <div class="f_namebox">
            <input type="text" id="new_prospect_fname" name="new_prospect_fname" class="form-control" placeholder="First Name">
          </div>
          <div class="f_namebox">
            <input type="text" id="new_prospect_lname" name="new_prospect_lname" class="form-control" placeholder="Last Name">
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Phone</label>
                <input type="text" id="new_phone" name="new_phone" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Mobile</label>
                <input type="text" id="new_mobile" name="new_mobile" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="twobox">
          <div class="twobox_1">
              <div class="form-group">
                <label for="exampleInputPassword1">Email</label>
                <input type="text" id="new_email" name="new_email" class="form-control" >
              </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Website</label>
                <input type="text" id="new_website" name="new_website" class="form-control" >
            </div>
          </div>
          <div class="clearfix"></div>
        </div>
        
        <div class="twobox">
          <div class="twobox_1">
            <div class="form-group">
              <label for="exampleInputPassword1">Lead Source <a href="javascript:void(0)" class="lead_source-modal"> <i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></label>
              <select class="form-control select_title" id="new_lead_source" name="new_lead_source">
                <option value="0">-- None --</option>
                @if(isset($old_lead_sources) && count($old_lead_sources) >0)
                  @foreach($old_lead_sources as $key=>$lead_row)
                    <option value="{{ $lead_row['source_id'] }}">{{ $lead_row['source_name'] }}</option>
                  @endforeach
                @endif
                @if(isset($new_lead_sources) && count($new_lead_sources) >0)
                  @foreach($new_lead_sources as $key=>$lead_row)
                    <option value="{{ $lead_row['source_id'] }}">{{ $lead_row['source_name'] }}</option>
                  @endforeach
                @endif
              </select>
            </div> 
          </div>
          <div class="twobox_2">
            <div class="form-group">
              <label for="exampleInputPassword1">Industry</label>
              <select class="form-control select_title" id="new_industry" name="new_industry">
                <option value="0">-- None --</option>
                @if(isset($industry_lists) && count($industry_lists) >0)
                  @foreach($industry_lists as $key=>$industry_row)
                    <option value="{{ $industry_row['industry_id'] }}">{{ $industry_row['industry_name'] }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Notes</label>
          <textarea class="form-control" rows="4" name="new_notes" id="new_notes"></textarea>
        </div>

        

        <div class="clearfix"></div>
      </div>
      
      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-info saveNewLeadOppor" >Save</button>
        </div>
      </div>
      {{ Form::close() }}
    
  </div>
  </div>
</div>
<!-- Add New Lead End-->

<!-- add/edit list -->
<div class="modal fade" id="addcompose-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:420px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Add to List</h4>
        <div class="clearfix"></div>
      </div>
    
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="org_name" name="org_name" placeholder="Business Type" class="txtlft form-control">
        <button type="button" class="btn btn-info pull-left save_t" data-client_type="org" id="add_business_type" name="save">Add</button>
        <div class="clearfix"></div>
      </div>
      
      <div id="append_bussiness_type">
      @if( isset($old_org_types) && count($old_org_types) >0 )
        @foreach($old_org_types as $key=>$old_org_row)
        <div class="pop_list form-group">
          {{ $old_org_row->name }}
        </div>
        @endforeach
      @endif

      @if( isset($new_org_types) && count($new_org_types) >0 )
        @foreach($new_org_types as $key=>$new_org_row)
        <div class="pop_list form-group" id="hide_div_{{ $new_org_row->organisation_id }}">
          <a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_org_name" data-field_id="{{ $new_org_row->organisation_id }}"><img src="/img/cross.png" width="12"></a>{{ $new_org_row->name }}
        </div>
        @endforeach
      @endif
      </div>
      
      <!-- <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="add_business_type" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div> -->
    </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="lead_status-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD/EDIT SERVICE ACTIVITIES</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '', 'id'=>'field_form')) }}
      <div class="modal-body">
      <table class="table table-bordered table-hover dataTable add_status_table">
        <thead>
          <tr>
            <!-- <th align="center" width="20%">Show/Unshow</th> -->
            <th >Status Name</th>
            <th align="center">Action</th>
          </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($leads_tabs) && count($leads_tabs) >0)
            @foreach($leads_tabs as $key=>$value)
              @if(isset($value['status']) && $value['status'] == "S" && $value['is_show'] == 'O' )
              <tr class="is_show_O" id="change_status_tr_{{ $value['tab_id'] or "" }}">
                <!-- <td align="center"><input type="checkbox" id="step_check_2{{ $value['tab_id']}}" class="status_check" {{ ($value['status'] == "S")?"checked":"" }} value="{{ $value['tab_id'] or "" }}" data-step_id="{{ $value['tab_id'] }}" {{ ((isset($value['count']) && $value['count'] !=0) || $value['tab_id'] == 10)?"disabled":"" }} /></td> -->
                <td><span id="status_span{{ $value['tab_id'] or "" }}">{{ $value['tab_name'] or "" }}</span></td>
                <td align="center"><span id="action_{{ $value['tab_id'] or "" }}"><a href="javascript:void(0)" class="edit_status" data-step_id="{{ $value['tab_id'] or "" }}"><img src="/img/edit_icon.png"></a></span></td>
              </tr>
              @endif
              @if(isset($value['status']) && $value['status'] == "S" && $value['is_show'] == 'L' )
              <tr class="is_show_L" id="change_status_tr_{{ $value['tab_id'] or "" }}">
                <td><span id="status_span{{ $value['tab_id'] or "" }}">{{ $value['tab_name'] or "" }}</span></td>
                <td align="center"><span id="action_{{ $value['tab_id'] or "" }}"><a href="javascript:void(0)" class="edit_status" data-step_id="{{ $value['tab_id'] or "" }}"><img src="/img/edit_icon.png"></a></span></td>
              </tr>
              @endif
            @endforeach
          @endif

        </tbody>
    
    </table>

        
      </div>
    {{ Form::close() }}
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="full_address-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">FULL ADDRESS</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body" id="show_full_address">
        
      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="full_notes-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">NOTES</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body" id="show_full_notes">
        
      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

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



<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="add_close_date-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD CLOSE DATE</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div class="show_loader" style="text-align: center;"></div>
        <input type="hidden" name="add_date_leads_id" id="add_date_leads_id" />
        <input type="hidden" name="add_date_tab_id" id="add_date_tab_id" />
        <div class="form-group" style="width:100%;">
          <label for="exampleInputPassword1">Close Date</label>
          <input type="text" class="form-control close_date" name="add_close_date" id="add_close_date" />
        </div>
        <div class="clearfix"></div>
      </div>

      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-info pull-left save_t2 save_close_date">Save</button>
        </div>
      </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="forecast-modal" tabindex="-1" role="dialog" aria-hidden="true">

 
  <div class="modal-dialog" style="width:62%;">
    <div class="modal-content">
      <!--<div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD COURSE</h4>
        <div class="clearfix"></div>
      </div>-->
      <!--<form action="#" method="post">-->
      
      <div class="modal-body">
          <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
          <table width="100%" border="0" class="staff_holidays">
            <tr>
              <td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  
    
    <td width="30%"><strong style="color: #00ccff; font-size: 20px;">ADD FORECAST VALUES</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

              </td>
            </tr>
            <tr>
              <td valign="top">
			  <?php 
			  		
					//echo '<pre>';
					//print_r($staff_details);
			  
			  ?>
			   {{ Form::open(array('url' => '/timesheet/insert-forecast')) }}
              <table width="100%" class="table table-bordered" id="BoxTable">
            <tbody>
              <!-- <tr class="table_heading_bg"> -->
              <tr>
              <td width="4%" align="center"><strong>Delete</strong></td>
                <td width="20%" align="center"><strong>Date</strong></td>
                <td width="20%" align="center"><strong>Details</strong></td>
                <td width="20%" align="center"><strong>Amount</strong></td>
                  
              </tr>
              
              <tr id="TemplateRow" class="makeCloneClass">
              
              <td align="center"><a href="#"><img src="/img/cross.png" width="15" id="date_picker"  class="DeleteBoxRow" ></a>
				
                
				</td>
              
               
				<td align="center">
                <input class="dpick" type="text" id="dpick1" name="date[]"  style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:140px; border-radius: 5px; height: 30px; "/>
				</td>
                
                
                <td align="center">
                
                <input type="text" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:374px; border-radius: 5px; height: 30px; " id="details" name="detaislname[]" value="" class="">
              
              </td>
                <td align="center">
			<input type="text" style="border: 1px solid #CCCCCC; color: #555555;  background: #fff; width:142px; border-radius: 5px; height: 30px; " id="amount" name="amountforecast[]" value="" class="amountformat">
		  </td>
                
              
                
                
              </tr>
             
            </tbody>
          </table>
              </td>
            </tr>
          </table>
         <div class="save_btncon">
            <div class="left_side"><button class="addnew_line"><i class="add_icon_img"><img src="/img/add_icon.png"></i><p class="add_line_t">Add New</p></button></div>




        <div class="right_side" style="padding-left: 10px;"> <button class="btn btn-info">Save</button></div>
        <div class="right_side"> <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>

          
          
            <div class="clearfix"></div>
            </div>
         
        </div>
        
        {{ Form::close() }}
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->

</div>  
  <!-- /.modal-dialog -->
 
 
<div>
<div class="modal fade" id="composemailingnotes-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:36%;">
    
    <div class="modal-content">
     <input type="hidden" id="notescid" value="">
      
      <div class="modal-body">
      <button class="close save_btn" aria-hidden="true" data-dismiss="modal" type="button">x</button>
     
      <div style="width:100%;">
      <h2 style="padding:0px; margin:0px;">
             <label for="f_name" >Notes</label></h2>
             
          <textarea rows="4" cols="50" style="width:100%"  name="notes1[]" id="notess" value="" ></textarea>
         
         <div class="clr"></div>   
          <button class="btn btn-primary" onclick="return notes()" id="save_notes" style=" padding:4px 20px; text-align: center; margin-top: 15px; float: right;">Save</button>   
               
         </div>
          <div class="clr"></div>   
        </div>
        
       
      <!--</form>-->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

</div>

<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="amount_mdd-modal" tabindex="" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:1300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title xero_title"><strong></strong>
          <div style="float:right; margin-right: 10px; font-size: 15px;" class='custom_chk'><input type='checkbox' class="autosend_invoice_check" id='j' data-check="click"/><label for='j' style="margin-top: 0px; width:280px;">Auto Collect all future invoices on due date</label></div>
          <!-- <div style="float:right; margin-right: 10px; font-size: 15px;">Auto Collect all future invoices on due due <input type="checkbox" class="autosend_invoice_check"></div> -->
        </h4>
        <div class="clearfix"></div>
      </div>
      {{ Form::open(array('url' => '/crm/update-invoice')) }}
      <div class="modal-body">
        <input type="hidden" id="pop_contact_id" name="pop_contact_id">
        <input type="hidden" id="owner_id" name="owner_id" value="{{ $owner_id or '0' }}">
        <table class="table-bordered invoice_popup" id="invoice_popup" width="100%">
          <tr>
            <th style="width:10%;text-align:center;">Invoice Number</th>
            <th style="width:8%;text-align:center;">Invoice Date</th>
            <th style="width:17%;text-align:left;">Description</th>
            <th style="width:8%;text-align:center;">Inv. Due Date</th>
            <th style="width:8%;text-align:right;">Total</th>
            <th style="width:8%;text-align:right;">Amount Paid</th>
            <th style="width:10%;text-align:right;">Amount Credited</th>
            <th style="width:8%;text-align:right;">Amount Due</th>
            <th style="width:10%;text-align:center;">To be Colected</th>
            <!-- <th style="width:10%;text-align:center;">Collection Date</th>
            <th style="width:3%;text-align:center;">Collect</th> -->
          </tr>
        </table>
                                                        
        <div class="clearfix"></div>
        <!-- <div class="modal_footer clearfix">
          <div class="email_btns gap_top">
            <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-info pull-left save_t2 ">Save</button>
            save_invoice
          </div>
        </div> -->
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

<!-- Auto send modal start -->
<div class="modal fade" id="auto_send-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:370px;">
    <div class="modal-content">
      <div class="loader_show"></div>
      <div class="modal-body">
        <div class="form-group">
            <div class="tab_topcon">
              <div class="send_task auto_send">
                <div class=" chk_cont01">
                  <!-- <input type='checkbox' id="manage_check" {{ (isset($autosend['days']) && $autosend['days'] != "")?"checked":"" }} /> -->
                  <label for="manage_check"> Auto Send To Task </label></div> 
                <div class="chk_cont02"><input type="text" name="dead_line" id="dead_line" style="width:18%; padding: 0; text-align: center; height: 19px;" value="{{ $autosend['days'] or "" }}" /> <label for=""> Days Before Deadline </label></div>
              </div>
              <div class="clearfix"></div>
            </div>     
        </div>

        <div class="auto_modal_footer clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info pull-left save_t2" data-client_type="org" id="manage_check" name="save">Save</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- Auto send modal end -->


<div>
<div class="modal fade" id="quotessettings-modal" tabindex="1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:600px; ">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">x</button>
        <h4 class="modal-title">Setup</h4>
        <div class="clearfix"></div>
      </div>
      <input type="hidden" id="hiddenclient" value="staff">
      
     
      <div class="" style="float:left; width: 20%; padding: 55px;"> 
      <img src="/img/tick.png" width="30" />      
      </div> 
      <div class="" style="float:right; width: 80%; padding:15px;">     
      <table width="100%" border="0" class="table_popup">
        <tbody>
          <tr>
            <td>Use this discount for online approval?</td>
          </tr>
           <tr>
            <td><input type="button" class="yes_btn" value="Yes">
            <input type="button" class="no_btn" value="No">
            </td>
          </tr> 
            <tr>
            <td>Acceptance dilog message</td>
          </tr> 
          <tr>
            <td><textarea rows="4" cols="80" style="width:100%;"></textarea></td>
          </tr>   
          <tr>
            <td>Acceptance dilog message</td>
          </tr> 
          <tr>
            <td><textarea rows="4" cols="80" style="width:100%;"></textarea></td>
          </tr>                                                      
          
        </tbody>
      </table></div>
      <div class="clr"></div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
</di>

<!-- OPEN EDIT CLIENT MODAL -->
<div class="modal fade" id="open_edit_pop-modal" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:350px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align: center">
          <a href="javascript:void(0)" class="inv_client"><!-- ajax --></a></h4>
        <div class="clearfix"></div>
      </div>
      {{ Form::open(array('url' => '')) }}
      <input type="hidden" name="edit_id" id="edit_id">
      <input type="hidden" name="edit_contact_id" id="edit_contact_id">
      <input type="hidden" name="edit_client_type" id="edit_client_type">
      <input type="hidden" name="edit_client_id" id="edit_client_id">
      <div class="modal-body">
        <div class="show_loader"><!-- Show Loader --></div>
        <div class="form-group client_area">
          <!-- Ajax Call -->
        </div>

        <div class="clearfix"></div>
        <div class="modal_footer clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info pull-left save_t2 merge_invoice">Save</button>
            <!-- save_invoice -->
          </div>
        </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

<!-- OPEN AUTO COLLECT ACTION MODAL -->
<div class="modal fade" id="autocollect_pop-modal" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:375px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"></h4>
        <div class="clearfix"></div>
      </div>
      {{ Form::open(array('url' => '')) }}
      <div class="modal-body">
        <div class="show_loader"><!-- Show Loader --></div>
        <div class="form-group">
          Set Direct Debit Collection date to invoice due date <input type="checkbox" name="autocollect_check" id="autocollect_check" value="Y">
        </div>

        <div class="clearfix"></div>
        <div class="modal_footer clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info pull-left save_t2 save_auto_collect">Save</button>
            <!-- save_invoice -->
          </div>
        </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

<!-- TO BE COLLECTED MODAL -->
<div class="modal fade" id="tobe_collected-modal" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:250px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <!-- <h4 class="modal-title">COLLECTION DATE</h4> -->
        <div class="clearfix"></div>
      </div>
      {{ Form::open(array('url' => '')) }}
      <div class="modal-body">
        <input type="hidden" id="invoice_id">
        <div class="show_loader"><!-- Show Loader --></div>
        <div class="form-group">
          <label>COLLECTION DATE</label>
          <input type="text" class="form-control" name="tobecollect_date" id="tobecollect_date">
        </div>

        <div class="form-group">
          <label>AMOUNT</label>
          <input type="text" class="form-control" name="tobecollect_amount" id="tobecollect_amount">
        </div>

        <div class="clearfix"></div>
        <div class="modal_footer clearfix">
          <div class="email_btns">
            <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-info pull-left save_t2 crm_send_collect" data-status="send">Send</button>
            <!-- save_invoice -->
          </div>
        </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

@include("crm.modal.lead_source")
@include("crm.proposal.modal.modal")

@include("contacts_letters.modal")




  <!-- loader on page loading start -->
  <div class="overlay">
    <div class="loading-img"><img src="/img/spinner.gif" /></div>
  </div>


@stop



