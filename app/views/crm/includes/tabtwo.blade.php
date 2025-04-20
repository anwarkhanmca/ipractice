@if($page_open == 2 || $page_open == 21 || $page_open == 22)
<div class="col_m2">
  <table style="margin-left:50px">
    <tr>
      <td width="7%"><strong>Number of Clients :</strong></td>
      <td width="4%"><strong class="countClient">{{ $client_count or '0' }}</strong></td>
      <td width="6%"><strong>Total Annual Fees :</strong></td>
      <td width="5%"><strong id="ann_amnt_head">{{ (isset($annual_ammount) && $annual_ammount >0)?number_format($annual_ammount, '2'):'0' }}</strong></td>
      <td width="7%"><strong>Average Annual Fees :</strong></td>
      <td width="5%"><strong id="ann_avg_head">{{ ($client_count >0 && isset($annual_ammount) && $annual_ammount >0)?number_format($annual_ammount/$client_count, 2):'0' }}</strong></td>
      <td width="7%"><strong>Total Monthly Fees :</strong></td>
      <td width="4%"><strong id="mnth_amnt_head">{{ (isset($annual_ammount) && $annual_ammount >0)?number_format($annual_ammount/12, 2):'0' }}</strong></td>
      <td width="8%"><strong>Average Monthly Fees :</strong></td>
      <td width="4%"><strong id="mnth_avg_head">{{ ($client_count >0 && isset($annual_ammount) && $annual_ammount >0)?number_format($annual_ammount/(12*$client_count), 2):'0' }}</strong></td>
    </tr>
  </table>  
</div>
@endif
<!-- <input type="hidden" name="client_type" id="client_type" value="{{ $client_type or "" }}"> -->

<div class="col_m2">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;">
      <li class="{{ ($page_open == 2 || $page_open == 21)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('21') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">ORGANISATION</a></li>
      <li class="{{ ($page_open == 22)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('22') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">INDIVIDUALS</a></li>
      <li class="{{ ($tab_no == 3)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('3') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">MANAGE RENEWAL</a></li>
    </ul>
    <div class="tab-content">
@if($page_open == 2 || $page_open == 21 || $page_open == 22)
  <div id="tab_21" class="tab-pane {{ ($tab_no == 2)?'active':'' }}">
    <div class="row bottom_space">
      <div class="col-xs-6">
        <div class="dataTables_length" id="example2_length">
          
        </div>
      </div>
      <div class="col-xs-6">
        <div id="example2_filter" class="dataTables_filter">
          <form>
            <input type="text" name="search" id="search" placeholder="Search" class="tableSearch" />
            <button type="submit" id="LoadRecordsButton" style="display: none;">Search</button>
            <!-- <button type="submit" id="LoadRecordsButton">Search</button> -->
          </form>
        </div>
      </div>
    </div>

    <div id="OrgTableContainer"></div>
  </div>
@endif

@if($page_open == 222222)
  <div id="tab_21" class="tab-pane {{ ($tab_no == 2)?'active':'' }}">
    <table class="table table-bordered table-hover dataTable" id="example21">
        <thead>
          <tr>
            <th><input type="checkbox" class="CheckallCheckbox"></th>
            <th><strong>Joining Date</strong></th>
            <th align="left"><strong>Client Name</strong></th>
            <th align="left"><strong>Recurring Contracts</strong></th>
            <th align="left"><strong>Annual Fee</strong></th>
            <th align="left"><strong>Monthly Fees</strong></th>
            <th align="left"><strong>Contract Start Date</strong></th>
            <th align="left"><strong>Contract End Date</strong></th>
            <th align="left"><strong>Count Down</strong></th>
            <th align="left" width="8%"><strong>Action</strong></th>
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
                <select class="form-control newdropdown change_payment" data-client_id="{{ $client_row['client_id'] or '0' }}">
                  <option value="">None</option>
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


<!-- Start Date modal start -->
<div class="modal fade" id="startdate_pop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">CONTRACT START DATE</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <input type="hidden" id="startdate_client_id" name="startdate_client_id">
        <input type="hidden" id="start_data_type" name="start_data_type" value="startdate">
        <div class="form-group">
          <label for="exampleInputPassword1">Start Date</label>
          <input type="text" id="pop_startdate" name="pop_startdate" class="form-control">
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" id="save_startdate" class="btn btn-info pull-left save_t2">Save</button>
        </div>
      </div>
    
    </div>
  </div>
</div>        
<!-- Start Date modal End -->

<!-- Joining Date modal start -->
<div class="modal fade" id="joining_pop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD/EDIT JOINING DATE</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <input type="hidden" id="joining_client_id" name="joining_client_id">
        <input type="hidden" id="joining_table" name="joining_table" value="">
        <input type="hidden" id="joining_data_type" value="engagement_date">
        <div class="form-group">
          <label for="exampleInputPassword1">Joining Date</label>
          <input type="text" id="pop_joining" name="pop_joining" class="form-control">
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" id="save_joining" class="btn btn-info pull-left save_t2">Save</button>
        </div>
      </div>
    
    </div>
  </div>
</div>        
<!-- Joining Date modal End -->

<!-- Joining Date modal start -->
<div class="modal fade" id="amount_pop-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD/EDIT ANNUAL FEE</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <input type="hidden" id="amount_client_id" name="amount_client_id">
        <input type="hidden" id="amount_table" name="amount_table" value="">
        <input type="hidden" id="amount_data_type" value="billing_amount">
        <div class="form-group">
          <label for="exampleInputPassword1">Annual Fee</label>
          <input type="text" id="pop_amount" name="pop_amount" class="form-control">
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" id="save_amount" class="btn btn-info pull-left save_t2">Save</button>
        </div>
      </div>
    
    </div>
  </div>
</div>        
<!-- Joining Date modal End -->

<!-- Roll Forword modal start -->
<div class="modal fade" id="roll_fwd-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:300px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ROLL FORWORD DATE</h4>
        <div class="clearfix"></div>
      </div>
    
      <div class="modal-body">
        <div style="text-align: center; margin-bottom: 5px;" class="loader_class"></div>
        <input type="hidden" id="fwd_client_id" name="fwd_client_id">
        <input type="hidden" id="fwd_data_type" name="fwd_data_type" value="fwddate">
        <div class="form-group">
          <label for="exampleInputPassword1">Contract start date</label>
          <input type="text" id="pop_fwd_date" name="pop_fwd_date" class="form-control">
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Contract End date</label>
          <input type="text" id="pop_fwd_end" name="pop_fwd_end" class="form-control">
          <div class="clearfix"></div>
        </div>

        <div class="form-group">
          <label for="exampleInputPassword1">Amount</label>
          <input type="text" id="roll_amount" name="roll_amount" class="form-control">
          <div class="clearfix"></div>
        </div>

      </div>

      <div class="modal-footer clearfix" style="border-top: none; padding-top: 0;">
        <div class="email_btns">
          <button type="button" class="btn btn-danger pull-left save_t" data-dismiss="modal">Cancel</button>
          <button type="button" id="save_fwddate" class="btn btn-info pull-left save_t2">Save</button>
        </div>
      </div>
    
    </div>
  </div>
</div>        
<!-- Roll Forword modal End -->