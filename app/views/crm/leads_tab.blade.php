<ul class="leads_tab" style="border: none;">
  <li style="width:8%">
    <a class="btn btn-danger deleteLeads" href="javascript:void(0)">DELETE</a>
  </li>
  <li>
    <div class="import_fromch_main" style="width:182px;">
      <div class="import_fromch">
        <a href="javascript:void(0)" class="import_fromch_link">+ NEW LEAD</a>
        <a href="javascript:void(0)" class="i_selectbox" id="select_new_lead"><img src="/img/arrow_icon.png"></a>
        <div class="clearfix"></div>
      </div>
      <div class="crm_dropdown open_toggle" style="left: 90px;">
        <ul>
          <li><href="javascript:void(0)" data-type="ind" data-leads_id="0" class="open_new_lead-modal">Individual</a></li>
          <li><href="javascript:void(0)" data-type="org" data-leads_id="0" class="open_new_lead-modal">Organisation</a></li>
        </ul>
      </div>
    </div>
  </li>

  <li style="width:9%; border-left: #3c8dbc solid 1px;" class="{{ ($page_open == '51')?'active_leads':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('51') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}"><h3 style="background:#0066FF;">All [<span id="task_count_11">{{ $leads['leads_count'] or '0'}}</span>]</h3></a>
    <p>{{ (isset($leads['leads_count']) && $leads['leads_count'] != '0')?round( ($leads['leads_count']*100/$leads['leads_count']), 2 ):'0.00' }}%</p>
  </li>

  @if(isset($leads_tabs) && count($leads_tabs) >0)
  <?php $j = 11;?>
    @foreach($leads_tabs as $key=>$tab_row)
      @if(isset($tab_row['is_show']) && $tab_row['is_show'] == 'L')
      <li class="{{ ($page_open == '5'.$j)?'active_leads':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('5'.$j) }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}"><h3 style="background:#{{ $tab_row['color_code'] or "" }};"><span id="step_field_{{ $tab_row['tab_id'] or "" }}">{{ $tab_row['tab_name'] or "" }}</span> [<span id="task_count_1{{ $j }}">{{ $tab_row['count'] or "0" }}</span>]</h3></a>
      <p>{{ (isset($tab_row['count']) && isset($leads['leads_count']) && $leads['leads_count'] != 0)?round(($tab_row['count']*100)/$leads['leads_count'], 2):'0.00' }}%</p>
    </li>
      <?php $j++;?>
      @endif
    @endforeach
  @endif

  <div class="clearfix"></div>
</ul>
    
<div class="tab-content">
  <div id="tab_51" class="tab-pane top_margin {{ ($page_open == '51')?'active':'' }}">
  <table class="table table-bordered table-hover dataTable crm" id="example510" aria-describedby="example510_info">
    <thead>
      <tr role="row">
        <th width="3%"><input type='checkbox' class="CheckallCheckbox"></th>
        <th width="7%">Date</th>
        <th width="12%">Deal Owner</th>
        <th width="12%">Prospect Name</th>
        <th>Contact Name</th>
        <th width="">Phone</th>
        <th width="13%">Convert to Opportunity</th>
        <th width="8%">Lead Source</th>
        <th width="9%">Lead Status <a href="javascript:void(0)" class="lead_status-modal" style="float:right;" data-is_show="L"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
        <th width="5%">Notes</th>
      </tr>
    </thead>

    <tbody role="alert" aria-live="polite" aria-relevant="all">
      @if(isset($leads['leads_details']) && count($leads['leads_details']) >0)
        @foreach($leads['leads_details'] as $key=>$leads_row)
          <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
            <td><input type='checkbox' data-archive="{{ $leads_row['show_archive'] }}" class="ads_Checkbox" name="leads_delete_id[]" value="{{ $leads_row['leads_id'] or "" }}"></td>
            <td align="left">{{ $leads_row['date'] or "" }}</td>
            <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
            <td align="left">
              @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                <a href="javascript:void(0)" data-type="org" data-leads_id="{{ $leads_row['leads_id'] }}" class="open_new_lead-modal">{{ $leads_row['prospect_name'] or "" }}</a>
              @else
                <a href="javascript:void(0)" data-type="ind" data-leads_id="{{ $leads_row['leads_id'] or "" }}" class="open_new_lead-modal">{{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}</a>
              @endif
            </td>
            <td align="left">
              @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                <a href="javascript:void(0)" data-type="org" data-leads_id="{{ $leads_row['leads_id'] }}" class="open_new_lead-modal">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</a>
              @endif
              
            </td>
            <td align="center">{{ $leads_row['phone'] or "" }}</td>
            <td align="center">
              <div class="j_selectbox" style="width:80px!important;">
                <span>No</span>
                <div class="select_icon select_leads_list" data-leads_id="{{ $leads_row['leads_id'] }}"></div>
                <div class="clr"></div>
                <div class="open_drop" id="open_toggle_{{ $leads_row['leads_id'] }}" style="display: none;">
                  <ul>
                    <li><a style="color:#999" href="javascript:void(0)" data-type="{{ $leads_row['client_type'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}" class="open_form-modal">Yes</a></li>
                  </ul>
                </div>
              </div>
            </td>
            
            <td align="center">{{ $leads_row['source_name'] or "" }}</td>
            <td align="center">
              <select class="form-control newdropdown status_dropdown" id="11_status_dropdown_{{ $leads_row['leads_id'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}">
                @if(isset($leads_tabs) && count($leads_tabs) >0)
                  @foreach($leads_tabs as $key=>$tab_row)
                    @if(isset($tab_row['is_show']) && $tab_row['is_show'] == 'L')
                      <option value="{{ $tab_row['tab_id'] or "" }}" {{ (isset($leads_row['lead_status']) && $leads_row['lead_status'] == $tab_row['tab_id'])?'selected':'' }}>{{ $tab_row['tab_name'] or "" }}</option>
                      @endif
                  @endforeach
                @endif
              </select>
            </td>
            <td>
              <input type="hidden" id="notes_{{ $leads_row['leads_id'] or "" }}" value="{{ $leads_row['notes'] or "" }}">
              <a href="javascript:void(0)" class="notes_btn open_notes_popup" data-leads_id="{{ $leads_row['leads_id'] or "" }}" data-tab="51"><span style="{{ (isset($leads_row['notes']) && $leads_row['notes'] != '')?'border-bottom:3px dotted #3a8cc1 !important':''}}">notes</span></a>
            </td>
            
          </tr>
        @endforeach
      @endif
      
    </tbody>
  </table>
  </div>

@for($k=11; $k <=15;$k++)                          
  <div id="tab_5{{$k}}" class="tab-pane top_margin {{ ($page_open == '5'.$k)?'active':'' }}">
    <table class="table table-bordered table-hover dataTable crm" id="example5{{$k}}" aria-describedby="example5{{$k}}_info">
      <thead>
        <tr role="row">
          <th width="3%"><input type='checkbox' class="CheckallCheckbox"></th>
          <th width="7%">Date</th>
          <th width="12%">Deal Owner</th>
          <th width="12%">Prospect Name</th>
          <th>Contact Name</th>
          <th width="5%">Phone</th>
          <th width="13%">Convert to Opportunity</th>
          <th width="8%">Lead Source</th>
          <th width="9%">Lead Status <a href="javascript:void(0)" class="lead_status-modal" style="float:right;" data-is_show="L"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></th>
          <th width="5%">Notes</th>
        </tr>
      </thead>

      <tbody role="alert" aria-live="polite" aria-relevant="all">
        @if(isset($leads['leads_details']) && count($leads['leads_details']) >0)
          @foreach($leads['leads_details'] as $key=>$leads_row)
            @if(isset($leads_row['lead_status']) && $leads_row['lead_status'] == $k)
            <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
              <td><input type='checkbox' data-archive="{{ $leads_row['show_archive'] }}" class="ads_Checkbox" name="leads_delete_id[]" value="{{ $leads_row['leads_id'] or "" }}"></td>
              <td align="left">{{ $leads_row['date'] or "" }}</td>
              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
              <td align="left">
                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                  <a href="javascript:void(0)" data-type="org" data-leads_id="{{ $leads_row['leads_id'] }}" class="open_new_lead-modal">{{ $leads_row['prospect_name'] or "" }}</a>
                @else
                  <a href="javascript:void(0)" data-type="ind" data-leads_id="{{ $leads_row['leads_id'] or "" }}" class="open_new_lead-modal">{{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}</a>
                @endif
              </td>
              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
              <td align="center">{{ $leads_row['phone'] or "" }}</td>
              <td align="center">
                <div class="j_selectbox" style="width:80px!important;">
                  <span>No</span>
                  <div class="select_icon select_leads_list" data-leads_id="{{ $leads_row['leads_id'] }}"></div>
                  <div class="clr"></div>
                  <div class="open_drop" id="open_toggle_{{ $leads_row['leads_id'] }}" style="display: none;">
                    <ul>
                      <li><a style="color:#999" href="javascript:void(0)" data-type="{{ $leads_row['client_type'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}" class="open_form-modal">Yes</a></li>
                    </ul>
                  </div>
                </div>
              </td>
              
              <td align="center">{{ $leads_row['source_name'] or "" }}</td>
              <td align="center">
                <select class="form-control newdropdown status_dropdown" id="11_status_dropdown_{{ $leads_row['leads_id'] or "" }}" data-leads_id="{{ $leads_row['leads_id'] or "" }}">
                  @if(isset($leads_tabs) && count($leads_tabs) >0)
                    @foreach($leads_tabs as $key=>$tab_row)
                      @if(isset($tab_row['is_show']) && $tab_row['is_show'] == 'L')
                        <option value="{{ $tab_row['tab_id'] or "" }}" {{ (isset($leads_row['lead_status']) && $leads_row['lead_status'] == $tab_row['tab_id'])?'selected':'' }}>{{ $tab_row['tab_name'] or "" }}</option>
                        @endif
                    @endforeach
                  @endif
                </select>
              </td>
              <td>
                <input type="hidden" id="notes_{{ $leads_row['leads_id'] or "" }}" value="{{ $leads_row['notes'] or "" }}">
                <a href="javascript:void(0)" class="notes_btn open_notes_popup" data-leads_id="{{ $leads_row['leads_id'] or "" }}" data-tab="51"><span style="{{ (isset($leads_row['notes']) && $leads_row['notes'] != '')?'border-bottom:3px dotted #3a8cc1 !important':''}}">notes</span></a>
              </td>
              
            </tr>
            @endif
          @endforeach
        @endif
      </tbody>
    </table>
  </div>
  @endfor  

</div>