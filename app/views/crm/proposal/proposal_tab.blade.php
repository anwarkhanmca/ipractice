<style type="text/css">
#primary_nav_wrap li { position:relative; }
#primary_nav_wrap ul { position:absolute; padding:0 }
#primary_nav_wrap ul ul { list-style: none; }
#primary_nav_wrap ul ul { top:0; left:100% }
#primary_nav_wrap li:hover > ul { display:block }

</style>

<input type="hidden" id="ProposalID" value="99999">
<input type="hidden" id="proposal_id" value="">



<div class="col_m2">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;" id="primary_nav_wrap">
      <li class="{{ ($page_open == 'dashboard')?'active':'' }}"><a href="{{ url('crm/proposals') }}"><i class="fa fa-bar-chart-o tiny-icon"></i> &nbsp;DASHBOARD</a></li>
      <li class="{{ ($page_open == 'proposal')?'active':'' }}"><a href="{{ url('crm/viewAllProposal') }}"><i class="fa fa-file-text tiny-icon"></i> &nbsp;PROPOSALS</a></li>

      <li class="dropdown {{ ($page_open == 'settings' || $page_open == 'p_template' || $page_open == 'service' || $page_open == 'branding' || $page_open == 'attachment' || $page_open == 'letter' || $page_open == 'apps')?'active':'' }}">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="fa fa-cog"></i> &nbsp;SETTINGS<b class="caret"></b></a>
        <ul class="dropdown-menu proposal-dropdown-menu proposal_ul">
          <li><a href="{{ url('crm/service') }}"><i class="fa fa-suitcase tiny-icon"></i> Services</a></li>
          <li><a href="{{ url('crm/branding') }}"><i class="fa fa-file"></i> Branding</a></li>
          <li><a href="{{ url('crm/attachment')}}"><i class="fa fa-paperclip"></i> Attachments</a></li>

          <li class="subdropdown">
            <a href="#"><i class="fa fa-file-text tiny-icon"></i> Templates</a>
            <ul class="dropdown-menu proposal-dropdown-menu">
              <li><a href="/crm/letter-template"><i class="fa fa-file-text tiny-icon"></i>Letter Templates</a></li>
              <li>
               <!-- <a href="javascript:void(0)" class="openPackagePop"><i class="fa fa-gbp"></i>Standard Packages</a> -->
                <a href="javascript:void(0)" class="newProposalTablePop" data-prop_serv_id="0" data-action="add" data-page_name="settings"><i class="fa fa-gbp"></i>Standard Packages</a>

              </li>
              <li><a href="/crm/proposal-template"><i class="fa fa-file"></i>Proposal Templates</a></li>
            </ul>
          </li>
          <li><a href="{{ url('crm/terms')}}"><i class="fa fa-file"></i>Terms & Conditions</a></li>

          <li><a href="{{ url('crm/apps')}}"><i class="fa fa-apple"></i> Apps</a></li>

        </ul>
      </li> 

      <li style="float: right;">
      @if($page_open == 'p_template')
        <a href="{{ url('proposal/new-proposal/0/template') }}">+New Template</a>
      @else
        <a href="{{ url('proposal/new-proposal') }}">+New Proposal</a>
      @endif
      </li>


      @if(isset($proposal_page) && $proposal_page == 'letter')
        <li style="float: right;"><a href="javascript:void(0)" class="pNewLetterTemplate">+New Letter Template</a></li>
      @endif
      @if(isset($proposal_page) && $proposal_page == 'pricing')
        <li style="float: right;"><a href="javascript:void(0)" class="newPricingTemplate" data-pop_type="PT">+New Pricing Template</a></li>
      @endif
    </ul>

    <div class="tab-content">

      @if($page_open == 'dashboard')
        @include('crm/proposal/dashboard')

      @elseif($page_open == 'proposal')
        @include('crm/proposal/proposals/final')

      @elseif($page_open == 'letter')
          @include('crm/proposal/proposals/letter_template')
      @elseif($page_open == 'pricing')
          @include('crm/proposal/proposals/pricing_template')
      @elseif($page_open == 'p_template')
          @include('crm/proposal/proposals/proposal_template')

      @elseif($page_open == 'service')
        @include('crm/proposal/service_grid')

      @elseif($page_open == 'branding')
        @include('crm/settings/branding_grid')

      @elseif($page_open == 'terms')
        @include('crm/settings/terms')

      @elseif($page_open == 'apps')
        @include('crm/settings/apps')

      @elseif($page_open == 'attachment')
        @include('crm/proposal/attachment_grid')



      @endif











@if($page_open == 2 || $page_open == 21 || $page_open == 22)
      <div id="tab_21" class="tab-pane {{ ($tab_no == 2)?'active':'' }}">
        <table class="table table-bordered table-hover dataTable" id="example21">
            <thead>
              <tr>
                <th><input type="checkbox" class="CheckallCheckbox"></th>
                <th><strong>Joining Date</strong></th>
                <th align="left"><strong>Client Name</strong></th>
                <th align="left"><strong>Payment Method</strong></th>
                <th align="left"><strong>Billing Cycle</strong></th>
                <th align="left"><strong>Annual Fee</strong></th>
                <th align="left"><strong>Monthly Fees</strong></th>
                <th align="left"><strong>Contract Start Date</strong></th>
                <th align="left"><strong>Contract End Date</strong></th>
                <th align="left"><strong>Count Down</strong></th>
                <th align="left" width="8%"><strong>Contract</strong></th>
                <th align="left"><strong>Send to Renewals</strong>
                <a href="#" data-toggle="modal" data-target="#auto_send-modal"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a>
                </th>
              </tr>
            </thead>
          <tbody role="alert" aria-live="polite" aria-relevant="all">
            @if(isset($tab_details) && count($tab_details) >0)
              @foreach($tab_details as $key=>$client_row)
                <tr>
                  <td><input type="checkbox" class="CheckallCheckbox"></td>
                  <td>
                    @if(isset($client_row['crm_leads_id']) && $client_row['crm_leads_id'] != "0")
                      <a href="javascript:void(0)" class="open_joining_pop" data-joining="{{ date('d-m-Y', strtotime($client_row['created'])) }}" data-client_id="{{ $client_row['client_id'] or '0' }}" data-table="client" id="joining_div_{{ $client_row['client_id'] or '0' }}">{{ date('d-m-Y', strtotime($client_row['created'])) }}</a>
                    @else
                      <a href="javascript:void(0)" class="open_joining_pop" data-joining="{{ (isset($client_row['accounts']['engagement_date']) && $client_row['accounts']['engagement_date'] != '')?$client_row['accounts']['engagement_date']:''}}" data-client_id="{{ $client_row['client_id'] or '0' }}" data-table="crm" id="joining_div_{{ $client_row['client_id'] or '0' }}">{{ (isset($client_row['accounts']['engagement_date']) && $client_row['accounts']['engagement_date'] != '')?$client_row['accounts']['engagement_date']:'Add..'}}</a>
                    @endif
                  </td>
                  <td align="left">
                    @if(isset($client_row['client_type']) && $client_row['client_type'] == "ind")
                      <a href="/renewals/{{ $client_row['client_id'] or '0' }}/{{ base64_encode('ind_client') }}/{{ base64_encode('1') }}" target="_blank">{{ $client_row['client_name'] or "" }}</a>
                    @else
                      <a href="/renewals/{{ $client_row['client_id'] or '0' }}/{{ base64_encode('org_client') }}/{{ base64_encode('1') }}" target="_blank">{{ $client_row['business_name'] or "" }}</a>
                    @endif
                  </td>
                  <td align="left">
                    <select class="form-control newdropdown change_payment" data-client_id="{{ $client_row['client_id'] or '0' }}" data-data_type="payment_method">
                      <option value="0" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '0')?'selected':''}}>None</option>
                      <option value="1" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '1')?'selected':''}}>Direct Debit</option>
                      <option value="2" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '2')?'selected':''}}>Invoice Basis</option>
                      <option value="3" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '3')?'selected':''}}>Standing Order</option>
                      <option value="4" {{(isset($client_row['accounts']['payment_method']) && $client_row['accounts']['payment_method'] == '4')?'selected':''}}>Other</option>
                    </select>
                  </td>
                  <td align="left">
                    <select class="form-control newdropdown change_payment" data-client_id="{{ $client_row['client_id'] or '0' }}" data-data_type="billing_cycle">
                      <option value="0" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '0')?'selected':''}}>None</option>
                      <option value="1" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '1')?'selected':''}}>Weekly</option>
                      <option value="2" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '2')?'selected':''}}>Monthly</option>
                      <option value="3" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '3')?'selected':''}}>Yearly</option>
                      <option value="4" {{(isset($client_row['accounts']['billing_cycle']) && $client_row['accounts']['billing_cycle'] == '4')?'selected':''}}>Adhoc</option>
                    </select>
                  </td>
                  <td align="left">
                    <a href="javascript:void(0)" class="open_amount_pop billing_amount_{{ $client_row['client_id'] or '0' }}" data-amount="{{ (isset($client_row['accounts']['billing_amount']) && $client_row['accounts']['billing_amount'] != '')?$client_row['accounts']['billing_amount']:''}}" data-client_id="{{ $client_row['client_id'] or '0' }}">{{ (isset($client_row['accounts']['billing_amount']) && $client_row['accounts']['billing_amount'] != '')?$client_row['accounts']['billing_amount']:'Add..'}}</a>
                  </td>
                  <td align="left" class="monthly_amount_{{ $client_row['client_id'] or '0' }}">
                    {{(isset($client_row['accounts']['billing_amount']) && $client_row['accounts']['billing_amount'] != '')?number_format(str_replace(',', '', $client_row['accounts']['billing_amount'])/12, 2):''}}
                  </td>

                  <td align="left">
                    <a href="javascript:void(0)" class="open_startdate_pop startdate_{{ $client_row['client_id'] or '0' }}" data-startdate="{{ (isset($client_row['accounts']['startdate']) && $client_row['accounts']['startdate'] != '')?$client_row['accounts']['startdate']:''}}" data-client_id="{{ $client_row['client_id'] or '0' }}">
                      {{ (isset($client_row['accounts']['startdate']) && $client_row['accounts']['startdate'] != '')?$client_row['accounts']['startdate']:'Add..'}}</a>
                  </td>

                  <!-- <td align="left">
                    <span class="enddate_{{ $client_row['client_id'] or '0' }}">{{ (isset($client_row['accounts']['startdate']) && $client_row['accounts']['startdate'] != "")?date("d-m-Y", strtotime('-1 day', strtotime('+1 years', strtotime($client_row['accounts']['startdate'])) )):"" }}</span>
                  </td> -->
                  <td align="left">
                    <span class="enddate_{{ $client_row['client_id'] or '0' }}">{{ (isset($client_row['accounts']['enddate']) && $client_row['accounts']['enddate'] != '')?$client_row['accounts']['enddate']:''}}</span>
                  </td>

                  <td align="left">
                    <span class="countdown_{{ $client_row['client_id'] or '0'}}">
                      @if(isset($client_row['accounts']['count_down']) && $client_row['accounts']['count_down'] > 0)
                        {{ $client_row['accounts']['count_down'] }}
                      @else
                        <p style="color:red">{{ $client_row['accounts']['count_down'] or "0" }}</p>
                      @endif
                    </span>
                  </td>

                  <td>
                    <a href="javascript:void(0)" class="notes_btn roll_fwd_button" data-client_id="{{ $client_row['client_id'] or '0' }}">Roll fwd</a>
                  </td>

                  <td align="center" id="after_send_{{ $client_row['client_id'] or "" }}">
                    @if(isset($client_row['manage_renewals']) && $client_row['manage_renewals'] == "N")
                      <button type="button" class="job_send_btn send_renewals" data-client_id="{{ $client_row['client_id'] or '0' }}">SEND</button>
                    @else
                      <button type="button" class="job_sent_btn">SENT</button>
                    @endif
                  </td>
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
@endif

@if($tab_no == 3)
  <div id="tab_3" class="tab-pane {{ ($tab_no == 3)?'active':'' }}">
    @include('crm/includes/tabthree')
  </div>
@endif


      
      <!-- /.tab-pane -->
    </div>
  </div>
  <!--end sub tab-->
</div>





