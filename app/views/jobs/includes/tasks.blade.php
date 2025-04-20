
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
            <div style="float: left; margin-right: 5px;margin-top:4px;">Filter Status <a href="#" data-toggle="modal" data-target="#status-modal" class="auto_send-modal" style="float:right;"><i class="fa fa-cog fa-fw" style="color:#00c0ef"></i></a></div>
            <div style="float: left;width: 63%!important">
              <select id="statusFilterDrop" class="form-control input-sm" style="width:56%!important">
                <option value="1">Show All [{{ $all_count or '0' }}]</option>
                <option value="2">Not Started [{{ $not_started_count or '0' }}]</option>

                @if(isset($jobs_steps) && count($jobs_steps) >0)
                  @foreach($jobs_steps as $key=>$v)
                    <option value="{{ $v['step_id'] or "" }}">{{ $v['title'] or "" }} [{{ $v['count'] or "0" }}]</option>
                  @endforeach
                @endif 
              </select>
            </div>
          </div>
        </div>
        <div class="col-xs-6">
          <div id="example2_filter" class="dataTables_filter">
            <form>
              <input type="text" name="tasksSecondSearchText" id="tasksSecondSearchText" placeholder="Search" class="tableSearch" />
              <button type="submit" id="tasksSecondSearchButton" style="display:none;">Search</button>
            </form>
          </div>
        </div>
      </div>
      <div id="tasksSecondTable"></div>
    </div>
  </div>
</div>
