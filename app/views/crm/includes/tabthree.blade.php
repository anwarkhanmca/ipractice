
  <!-- <ul class="nav nav-tabs nav-tabsbg" style="cursor: move;">
    <li class="{{ ($page_open == 3)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('3') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">All [<span id="task_count_1">{{ $total_count or '0' }}</span>]</a></li>
    <li class="{{ ($page_open == 32)?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('32') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">Not Started [<span id="task_count_2">{{$notstarted_count or '0'}}</span>]</a></li>
    @if(isset($tab_status) && count($tab_status) >0)
      <?php $i = 3;?>
      @foreach($tab_status as $key=>$status)
        <li class="header_step_{{ $status['renewal_status_id']}} {{ ($page_open == '3'.$i)?'active':'' }}" style="display: {{ ($status['status'] == 'H')?'none':'block'}}"><a href="{{ $goto_url }}/{{ base64_encode('3'.$i) }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">{{ $status['status_name'] or "" }} [<span id="task_count_{{ $status['renewal_status_id'] }}">{{ $status['count'] or '0' }}</span>]</a></li>
      <?php $i++;?>
      @endforeach
    @endif
    <li class="{{ ($page_open == '38')?'active':'' }}"><a href="{{ $goto_url }}/{{ base64_encode('38') }}/{{ base64_encode($owner_id) }}/{{ $proposals or '' }}">Archived</a></li>
  </ul> -->
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

              <div class="row bottom_space">
                <div class="col-xs-6">
                  <div class="dataTables_length" id="example2_length">
                    <div style="float: left; margin-right: 5px;margin-top: 4px;">Filter Status</div>
                    <div style="float: left;width: 50%!important">
                      <select id="renewalStatusDrop" class="form-control input-sm" style="width: 56%!important">
                        <option value="">Show All [{{$total_count}}]</option>
                        @if(isset($status_dropdown) && count($status_dropdown) >0)
                          @foreach($status_dropdown as $key=>$v)
                            <option value="{{ $v['short_name'] }}">{{ $v['status'] }} [{{ $v['count'] }}]</option>
                          @endforeach
                        @endif
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-xs-6">
                  <div id="example2_filter" class="dataTables_filter">
                    <form>
                      <input type="text" name="manageRenewalText" id="manageRenewalText" placeholder="Search" class="tableSearch" />
                      <button type="submit" id="manageRenewalSearchBtn" style="display: none;">Search</button>
                    </form>
                  </div>
                </div>
              </div>
              <div id="manageRenewalContainer"></div>
                <!-- <table class="table table-bordered table-hover dataTable crm" id="exampletab3">
                  <thead>
                    <tr>
                      <td width="3%"><input type="checkbox"></td>
                      <td align="center"><strong>Client Name</strong></td>
                      <td align="center"><strong>Contracts</strong></td>
                      <td align="center"><strong>Annual Fee</strong></td>
                      <td align="center"><strong>Start Date</strong></td>
                      <td align="center" width="8%"><strong>End Date</strong></td>
                      <td align="center" width="12%"><strong>Status</strong></td>
                    </tr>
                  </thead>
                  <tbody>
                  @if(isset($tab_details) && count($tab_details) >0)
                    @foreach($tab_details as $key=>$client_row)
                      <tr>
                        <td width="3%"><input type="checkbox"></td>
                        <td>{{ $client_row['client_name'] or "" }}</td>
                        <td align="center"></td>
                        <td align="center">{{ $client_row['annual_fee'] or "" }}</td>
                        <td>{{ $client_row['contract_start_date'] or "" }}</td>
                        <td align="center"></td>
                        <td align="center">{{ $client_row['status_name'] or '' }}</td>
                      </tr>
                    @endforeach
                  @endif 
                  </tbody>
                </table> -->
            </div>
          </div>
        </div>
      </div>
      <!--end table-->
    </div>
    <!-- /.tab-pane -->
    
    <!-- /.tab-pane -->
  </div>


<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="status-modal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width:500px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD NEW FIELD</h4>
        <div class="clearfix"></div>
      </div>
    {{ Form::open(array('url' => '', 'id'=>'field_form')) }}
      <div class="modal-body">
      <table class="table table-bordered table-hover dataTable add_status_table">
        <thead>
          <tr>
            <th align="center" width="20%">Show/Unshow</th>
            <th >Status Name</th>
            <th align="center">Action</th>
          </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
          @if(isset($tab_status) && count($tab_status) >0)
            @foreach($tab_status as $key=>$value)
              <tr id="change_status_tr_{{ $value['renewal_status_id'] or "" }}">
                <td align="center"><input type="checkbox" id="step_check_2{{ $value['renewal_status_id']}}" class="status_check" {{ ($value['status'] == "S")?"checked":"" }} value="{{ $value['renewal_status_id'] or "" }}" data-renewal_status_id="{{ $value['renewal_status_id'] }}" {{ ((isset($value['count']) && $value['count'] !=0) || $value['renewal_status_id'] == 10)?"disabled":"" }} /></td>
                <td><span id="status_span{{ $value['renewal_status_id'] or "" }}">{{ $value['status_name'] or "" }}</span></td>
                <td align="center"><span id="action_{{ $value['renewal_status_id'] or "" }}"><a href="javascript:void(0)" class="edit_status" data-renewal_status_id="{{ $value['renewal_status_id'] or "" }}"><img src="/img/edit_icon.png"></a></span></td>
              </tr>
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