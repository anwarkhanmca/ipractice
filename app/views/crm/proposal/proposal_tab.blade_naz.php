<div class="box-body table-responsive">
  <div role="grid" class="dataTables_wrapper form-inline" id="example2_wrapper">
    <div class="row">
      <div class="col-xs-6"></div>
      <div class="col-xs-6"></div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="col_m2">
              <!--sub tab -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs nav-tabsbg">
              <li class="{{ ($page_open == 'dashboard')?'active':'' }}"><a href="{{ url('crm/dashboard') }}"><i class="fa fa-bar-chart-o tiny-icon"></i> &nbsp;DASHBOARD</a></li>
              <li class="{{ ($page_open == 'proposal')?'active':'' }}"><a href="{{ url('crm/viewAllProposal') }}"><i class="fa fa-file-text tiny-icon"></i> &nbsp;PROPOSAL</a></li>
              <!-- <li class="{{ ($page_open == 'schedule')?'active':'' }}"><a href="{{ url('crm/viewAllSchedule') }}"><i class="fa fa-clock-o tiny-icon"></i> &nbsp;SCHEDULE</a></li>
              <li class="{{ ($page_open == 'invoice')?'active':'' }}"><a href="{{ url('crm/viewAllInvoice') }}"><i class="fa fa-list-alt tiny-icon"></i> &nbsp;INVOICE</a></li>
              <li class="{{ ($page_open == 'payment')?'active':'' }}"><a href="{{ url('crm/viewAllBills') }}"><i class="fa fa-dollar tiny-icon"></i> &nbsp;PAYMENT</a></li> -->
              <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-suitcase tiny-icon"></i> &nbsp;SETTINGS<b class="caret"></b></a>
                <ul class="dropdown-menu proposal-dropdown-menu">
                      <li><a href="{{ url('crm/product') }}" onMouseOver="this.style.color='white'"
     onMouseOut="this.style.color='black'" style="color: black;"><i class="fa fa-edit tiny-icon"></i> PRODUCT</a></li>
                      <li><a href="{{ url('crm/attachment') }}" style="color: black" onMouseOver="this.style.color='white'"
     onMouseOut="this.style.color='black'"><i class="fa fa-envelope tiny-icon"></i> ATTACHMENTS</a></li>
                      <!-- <li><a href="{{ url('crm/tax') }}" style="color: black" onMouseOver="this.style.color='white'"
     onMouseOut="this.style.color='black'"><i class="fa fa-edit tiny-icon"></i> TAX</a></li> -->
                </ul>
              </li>  
            </ul>
            <div class="tab-content">
              <div class="tab-pane active">
                @if($page_open == 'dashboard')
                  @include('crm/proposal/dashboard')
                @elseif($page_open == 'proposal')
                  @if(isset($selected_page) && $selected_page == 'view all proposals')
                    @include('crm/proposal/proposal_grid')
                  @elseif($selected_page == 'select proposal')
                    @include('crm/proposal/create_proposal')  
                  @elseif($selected_page == 'select attachments')
                    @include('crm/proposal/attach_proposal')  
                  @elseif($selected_page == 'additional note')
                    @include('crm/proposal/additional_note')
                  @elseif($selected_page == 'select template')
                    @include('crm/proposal/select_template')
                  @elseif($selected_page == 'preview proposal')
                    @include('crm/proposal/preview_proposal')  
                  @elseif(isset($selected_page) && ($selected_page == 'Create Invoice' || $selected_page == 'Edit Invoice'))
                    @include('crm/proposal/payment_terms')   
                  @elseif(isset($selected_page) && $selected_page == 'preview invoice')
                    @include('crm/proposal/preview_invoice')
                  @elseif(isset($selected_page) && $selected_page == 'proposal_mail')
                    @include('crm/proposal/proposal_sending_via_email')     
                  @endif
                @elseif($page_open == 'schedule')
                  @if(isset($selected_page) && $selected_page == 'schedule_grid')
                    @include('crm/proposal/schedule_grid')
                  @elseif($selected_page == 'make_schedule')
                    @include('crm/proposal/make_schedule')
                  @elseif($selected_page == 'schedule_confirmation')
                    @include('crm/proposal/schedule_confirmation_message')
                  @endif
                @elseif($page_open == 'invoice')
                  @if($selected_page == 'Create Invoice' || $selected_page == 'Edit Invoice')
                    @include('crm/proposal/payment_terms')   
                  @elseif($selected_page == 'preview invoice')
                    @include('crm/proposal/preview_invoice')
                  @elseif($selected_page == 'invoices')
                    @include('crm/proposal/invoice_grid')
                  @elseif($selected_page == 'invoice_mail')
                    @include('crm/proposal/invoice_sending_via_email')                      
                  @endif
                @elseif($page_open == 'payment')
                  @if($selected_page == 'payment')
                    @include('crm/proposal/bill_grid')  
                  @elseif($selected_page == 'add payment')
                    @include('crm/proposal/add_amount_receive')   
                  @elseif($selected_page == 'edit payment')
                    @include('crm/proposal/add_amount_receive')  
                  @endif
                @elseif($page_open == 'product')
                  @include('crm/proposal/product_grid')
                @elseif($page_open == 'attachment')
                  @include('crm/proposal/attachment_grid')
                @elseif($page_open == 'tax')
                  @include('crm/proposal/tax_grid')    
                  <!-- <div class="container">
                    <div class="row">
                      <div class="col-md-6">
                        <h2>Saidul is a bad boy</h2>
                      </div>
                      <div class="col-md-6">
                        <h2>Saidul is a faltu boy</h2>
                      </div>
                    </div>
                  </div> -->
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>