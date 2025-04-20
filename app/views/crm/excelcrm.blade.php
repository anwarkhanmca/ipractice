<!-- Tab 2 Start-->
@if($tab_no == 2)
@include('crm/includeexcel/tabtwo')
@endif
<!--  <div id="tab_2" class="tab-pane {{ ($tab_no == 2)?'active':'' }}">
    
  </div> -->
<!-- Tab 2 End-->


@if($page_open == 51 || $page_open == 511 || $page_open == 512 || $page_open == 513)
 @include('crm/includeexcel/leads_tab')
@endif



@if($page_open == 611 || $page_open == 612 || $page_open == 613 || $page_open == 614 || $page_open == 615 || $page_open == 616 || $page_open == 617 || $page_open == 62 || $page_open == 63 || $page_open == 64 || $page_open == 65)
@include('crm/includeexcel/opportunities_tab')
@endif

