<table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
        
<tr>

                <td><h5>Date:{{$cdate or ""}}</h5></td>
                <td>&nbsp;</td>
                <td colspan="2" height="30px" align="center">
                
                {{ "CRM-OPPORTUNITIES" }}
                        @if($page_open == 611 || $page_open == 612 || $page_open == 613 || $page_open == 614 || $page_open == 615 || $page_open == 616 || $page_open == 617)
                        
                        {{ "(OPENED)" }}
                        @endif
                        
                        
                         @if($page_open == '62')
                          {{ "(CLOSED-WON)" }}
                         @endif
                         @if($page_open == '63')
                          {{ "(CLOSED-LOST)" }}
                         @endif
                          @if($page_open == '64')
                          {{ "(COLD)" }}
                         @endif
                
                
                </td>
                <td>&nbsp;</td>
</tr>

<tr>

                <td><h5>Time:		{{$ctime or ""}}</h5></td>
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





<div class="col-xs-12">
        <div class="col_m2">
              <!--sub tab -->
          <div class="nav-tabs-custom">
           <!-- -->
          <div class="tab-content">
          @if($page_open == 611 || $page_open == 612 || $page_open == 613 || $page_open == 614 || $page_open == 615 || $page_open == 616 || $page_open == 617)
          <div id="tab_611">
            <!-- <div id="tab_611" class="tab-pane {{ ($page_open == 611 || $page_open == 612 || $page_open == 613 || $page_open == 614 || $page_open == 615 || $page_open == 616 || $page_open == 617)?'active':'' }}"> -->
              <!--<div class="tab_topcon">
                <div class="top_bts" style="float:left;">
                        <ul style="padding:0;">
                          <li>
                            <a class="btn btn-danger deleteLeads" href="javascript:void(0)">DELETE</a>
                          </li>
                          <li>
                            <div class="import_fromch_main" style="width:182px;">
                              <div class="import_fromch">
                                <a href="javascript:void(0)" class="import_fromch_link">+ NEW OPPORTUNITY</a>
                                <a href="javascript:void(0)" class="i_selectbox" id="select_icon"><img src="/img/arrow_icon.png"></a>
                                <div class="clearfix"></div>
                              </div>
                              <div class="crm_dropdown open_toggle">
                              <ul>
                                <li><a href="javascript:void(0)" data-type="ind" data-leads_id="0" class="open_form-modal">Individual</a></li>
                                <li><a href="javascript:void(0)" data-type="org" data-leads_id="0" class="open_form-modal">Organisation</a></li>
                              </ul>
                            </div>
                          </div>
                          </li>
                          <li>
                            <a href="javascript:void(0)" style="margin-left: 300px; font-size: 23px;">Pipeline Deals</a>
                          </li>
                          <li>
                            <a class="btn btn-info" href="/crm/report" target="_blank">REPORT</a>
                          </li> 
                        <div class="clearfix"></div>
                        </ul>
                      </div>-->
                      <!-- <div class="top_search_con">
                       <div class="top_bts">
                        <ul style="padding:0;">
                          
                          <li style="margin-top: 8px;">
                            <a href="javascript:void(0)" id="archive_div"></a>
                          </li>
                          <li>
                            <button type="button" id="archivedButton" class="btn btn-warning">Archive</button>
                          </li>
                          <div class="clearfix"></div>
                        </ul>
                      </div>
                      </div> 
                      <div class="clearfix"></div>
                    </div>-->

                  <!--  <ul class="leads_tab">
                        <li style="width:9%;" class="{{ ($page_open == '611')?'active_leads':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('611') }}/{{ base64_encode($owner_id) }}"><h3 style="background:#0066FF;">All [<span id="task_count_11">{{ $all_count }}</span>]</h3></a>
                          <p>{{ ($all_total != '0.00')?round( ($all_total*100/$all_total), 2 ):'0.00' }}%</p>
                          <p>&#163;{{ $all_total or "0.00" }}</p>
                          <p>&#163;{{ $all_average or "0.00" }}</p>
                          <p>&#163;{{ $all_likely or "0.00" }}</p>
                        </li>

                        @if(isset($leads_tabs) && count($leads_tabs) >0)
                          <?php 
                            $i = 2;
                            $total    = 0;
                            $average  = 0;
                            $likely   = 0;
                          ?>
                          @foreach($leads_tabs as $key=>$tab_row)
                            @if($tab_row['status'] == 'S' && $tab_row['is_show'] == 'O')
                            <li class="{{ ($page_open == '61'.$i)?'active_leads':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('61'.$i) }}/{{ base64_encode($owner_id) }}"><h3 style="background:#{{ $tab_row['color_code'] or "" }};"><span id="step_field_{{ $tab_row['tab_id'] or "" }}">{{ $tab_row['tab_name'] or "" }}</span> [<span id="task_count_1.$i">{{ $tab_row['count'] or "0" }}</span>]</h3></a>
                            <p>{{ (isset($tab_row['table_value']['total']) && $all_total != '0.00')?round(str_replace(',','',$tab_row['table_value']['total'])*100/str_replace(',','',$all_total), 2):'0.00' }}%</p>
                            <p>&#163;{{ $tab_row['table_value']['total'] or "0.00" }}</p>
                            <p>&#163;{{ $tab_row['table_value']['average'] or "0.00" }}</p>
                            <p>&#163;{{ $tab_row['table_value']['likely'] or "0.00" }}</p>
                            </li>
                            @endif
                          <?php $i++;?>
                          @endforeach
                        @endif

                        <li style="width:7%;"><h3 style="background:#FF3399;">METRIC</h3>
                          <p style="border-right: 0px"><strong>Percentages</strong></p>
                          <p style="border-right: 0px"><strong>Total</strong></p>
                          <p style="border-right: 0px"><strong>Average</strong></p>
                          <p style="border-right: 0px"><strong>Likely</strong></p>
                        </li>

                        <div class="clearfix"></div>
                    </ul> -->
                    
                 <div id="tab_611" class="tab-pane top_margin {{ ($page_open == '611')?'active':'' }}">
                    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
                      <thead>
                        <tr role="row">
                          
                          <th width="15%">Date</th>
                          <th width="15%">Deal Owner</th>
                          <th width="20%">Prospect Name</th>
                          <th width="15%">Contact Name</th>
                          <th width="12%">Phone</th>
                          <th width="20%">Email</th>
                          <th width="5%">Age</th>
                         
                          
                          
                          <th width="15%">Amount</th>
                          
                          <!-- <th width="6%">Client Onboarding</th> -->
                        </tr>
                      </thead>

                      <tbody role="alert" aria-live="polite" aria-relevant="all">
                        @if(isset($leads_details) && count($leads_details) >0)
                          @foreach($leads_details as $key=>$leads_row)
                            @if(isset($leads_row['lead_status']) && ($leads_row['lead_status'] != 8 && $leads_row['lead_status'] != 9 && $leads_row['lead_status'] != 10))
                            <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                              
                              <td align="left">{{ $leads_row['date'] or "" }}</td>
                              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
                              <td align="left">
                                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                                  {{ $leads_row['prospect_name'] or "" }}
                                @else
                                  {{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}             @endif
                              </td>
                              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
                              <td align="left">{{ $leads_row['phone'] or "" }}</td>
                              <td align="left">{{ $leads_row['email'] or "" }}</td>
                              <td align="left">{{ $leads_row['deal_age'] or "0" }}</td>
                              
                            
                              
                              <td align="left">{{ $leads_row['quoted_value'] or "" }}</td>
                              
                              <!-- <td align="center">
                                @if(isset($leads_row['existing_client']) && $leads_row['existing_client'] != '0')
                                  {{ "N/A" }}
                                @else
                                  <button type="button" class="send_btn send_manage_task" data-client_id="{{ $leads_row['leads_id'] or "" }}" data-field_name="ch_manage_task">START</button>
                                @endif
                              </td> -->
                            </tr>
                            @endif
                          @endforeach
                        @endif
                        
                      </tbody>
                    </table>
                    </div>


                  </div>
@endif

                <!-- Tab 62 Start-->
                @if($page_open == '62')
                 <div id="tab_62">
                  <!-- <div id="tab_62" class="tab-pane top_margin {{ ($page_open == '62')?'active':'' }}"> -->
                   <!-- <div class="tab_topcon">
                      <div class="top_bts" style="float:left;">
                        <ul style="padding:0;">
                          <li>
                            <a class="btn btn-danger deleteLeads" href="javascript:void(0)">DELETE</a>
                          </li>
                          <div class="clearfix"></div>
                        </ul>
                      </div>
                      <div class="top_search_con">
                       <div class="top_bts">
                        <ul style="padding:0;">
                          <li style="margin-top: 8px;">
                            <a href="javascript:void(0)" class="archive_div" data-tab_id='8'>{{$won_archive}}</a>
                          </li>
                          <li>
                            <a href="javascript:void(0)" data-tab_id='8' class="btn btn-warning archivedButton">Archive</a>
                          </li>
                          <div class="clearfix"></div>
                        </ul>
                      </div>
                      </div>
                      <div class="clearfix"></div>
                    </div> -->
                    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
                      <thead>
                        <tr role="row">
                          
                          <th width="12%">Close Date</th>
                          <th width="20%">Deal Owner</th>
                          <th width="20%">Prospect Name</th>
                          <th width="15%">Contact Name</th>
                          <th width="5%">Age</th>
                        
                          
                          <th width="10%">Amount</th>
                          
                          <th width="10%">Client Onboarding</th>
                        </tr>
                      </thead>

                      <tbody role="alert" aria-live="polite" aria-relevant="all">
                        @if(isset($leads_details) && count($leads_details) >0)
                          @foreach($leads_details as $key=>$leads_row)
                            @if(isset($leads_row['lead_status']) && $leads_row['lead_status'] == 8)
                            <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                              
                              <td align="left">{{ $leads_row['close_date'] or "" }}</td>
                              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
                              <td align="left">
                                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                              {{ $leads_row['prospect_name'] or "" }}
                                @else
                               {{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}
                                @endif
                              </td>
                              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
                              <td align="center">{{ (strtotime($leads_row['close_date']) - strtotime($leads_row['date']))/3600*24  }}</td>
                              
                              
                              
                              <td align="left">{{ $leads_row['quoted_value'] or "" }}</td>
                             
                              <td align="left" id="onboard_td_{{ $leads_row['leads_id'] }}">
                                @if(isset($leads_row['existing_client']) && $leads_row['existing_client'] != '0')
                                  {{ "N/A" }}
                                @else
                                  @if(isset($leads_row['is_onboarding']) && $leads_row['is_onboarding'] == 'N')
                                    START
                                  @elseif(isset($leads_row['is_onboarding']) && $leads_row['is_onboarding'] == 'C')
                                    COMPLETED
                                  @else
                                   STARTED....
                                  @endif
                                @endif
                              </td>
                            </tr>
                            @endif
                          @endforeach
                        @endif
                        
                      </tbody>
                    </table>
                    </div>
                    @endif
                  <!-- Tab 62 End-->

                  <!-- Tab 63 Start-->
                  @if($page_open == '63')
                  <div id="tab_63">
                  <!-- <div id="tab_63" class="tab-pane {{ ($page_open == '63')?'active':'' }}"> -->
                   <!-- <div class="tab_topcon">
                      <div class="top_bts" style="float:left;">
                        <ul style="padding:0;">
                          <li>
                            <a class="btn btn-danger deleteLeads" href="javascript:void(0)">DELETE</a>
                          </li>
                          <div class="clearfix"></div>
                        </ul>
                      </div>
                      <div class="top_search_con">
                       <div class="top_bts">
                        <ul style="padding:0;">
                          <li style="margin-top: 8px;">
                            <a href="javascript:void(0)" class="archive_div" data-tab_id='9'>{{$lost_archive}}</a>
                          </li>
                          <li>
                            <a href="javascript:void(0)" data-tab_id='9' class="btn btn-warning archivedButton">Archive</a>
                          </li>
                          <div class="clearfix"></div>
                        </ul>
                      </div>
                      </div>
                      <div class="clearfix"></div>
                    </div> -->
                    <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
                      <thead>
                        <tr role="row">
                          
                          <th width="12%">Close Date</th>
                          <th width="18%">Deal Owner</th>
                          <th width="18%">Prospect Name</th>
                          <th width="18%">Contact Name</th>
                          <th width="5%">Age</th>
                         
                         
                          <th width="8%">Amount</th>
                         
                        </tr>
                      </thead>

                      <tbody role="alert" aria-live="polite" aria-relevant="all">
                        @if(isset($leads_details) && count($leads_details) >0)
                          @foreach($leads_details as $key=>$leads_row)
                            @if(isset($leads_row['lead_status']) && $leads_row['lead_status'] == 9)
                            <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                             
                              <td align="left">{{ $leads_row['close_date'] or "" }}</td>
                              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
                              <td align="left">
                                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                                 {{ $leads_row['prospect_name'] or "" }}
                                @else
                                  {{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}
                                @endif
                              </td>
                              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
                              <td align="center">{{ $leads_row['deal_age'] or "0" }}</td>
                              
                             
                              
                              <td align="center">{{ $leads_row['quoted_value'] or "" }}</td>
                             
                              
                            </tr>
                            @endif
                          @endforeach
                        @endif
                        
                      </tbody>
                    </table>
                  </div>
                  @endif
                  <!-- Tab 63 End-->

                  <!-- Tab 64 Start-->
                  @if($page_open == '64')
                  <div id="tab_64">
                  <table border="1" style="width: 100%;margin-bottom: 20px; border-collapse: collapse;">
                      <thead>
                        <tr role="row">
                          
                          <th width="7%">Date</th>
                          <th width="15%">Deal Owner</th>
                          <th width="15%">Prospect Name</th>
                          <th width="15%">Contact Name</th>
                          <th width="8%">Phone</th>
                          <th width="15%">Email</th>
                          <th width="5%">Age</th>                       
                          <th width="7%">Amount</th>
                         
                          <!-- <th width="6%">Client Onboarding</th> -->
                        </tr>
                      </thead>

                      <tbody role="alert" aria-live="polite" aria-relevant="all">
                        @if(isset($leads_details) && count($leads_details) >0)
                          @foreach($leads_details as $key=>$leads_row)
                            @if(isset($leads_row['lead_status']) && $leads_row['lead_status'] == 10)
                            <tr {{ ($leads_row['show_archive'] == "Y")?'style="background:#ccc"':"" }}>
                              
                              <td align="left">{{ $leads_row['date'] or "" }}</td>
                              <td align="left">{{ $leads_row['deal_owner'] or "" }}</td>
                              <td align="left">
                                @if(isset($leads_row['client_type']) && $leads_row['client_type'] == "org")
                                 {{ $leads_row['prospect_name'] or "" }}
                                @else
                                  {{ $leads_row['prospect_title'] or "" }} {{ $leads_row['prospect_fname'] or "" }} {{ $leads_row['prospect_lname'] or "" }}
                                @endif
                              </td>
                              <td align="left">{{ $leads_row['contact_title'] or "" }} {{ $leads_row['contact_fname'] or "" }} {{ $leads_row['contact_lname'] or "" }}</td>
                              <td align="left">{{ $leads_row['phone'] or "" }}</td>
                              <td align="left">{{ $leads_row['email'] or "" }}</td>
                              <td align="center">{{ $leads_row['deal_age'] or "0" }}</td>
                             
                              
                              
                              <td align="center">{{ $leads_row['quoted_value'] or "" }}</td>
                             
                              <!-- <td align="center">
                                @if(isset($leads_row['existing_client']) && $leads_row['existing_client'] != '0')
                                  {{ "N/A" }}
                                @else
                                  <button type="button" class="send_btn send_manage_task" data-client_id="{{ $leads_row['leads_id'] or "" }}" data-field_name="ch_manage_task">START</button>
                                @endif
                              </td> -->
                            </tr>
                            @endif
                          @endforeach
                        @endif
                        
                      </tbody>
                    </table>
                  
                   </div>
                  @endif
                  <!-- Tab 64 End-->

                  <!-- Tab 65 Start-->
                 <!-- <div id="tab_65" class="tab-pane {{ ($page_open == '65')?'active':'' }}">
                    Reports
                  </div> -->
                  <!-- Tab 64 End-->


                </div>
              </div>
              <!--end sub tab-->
            </div>
          </div>