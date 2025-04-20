<!-- add/edit list -->
<div class="modal fade" id="lead_source-modal" tabindex="-1" role="dialog" aria-hidden="true">

  <div class="modal-dialog" style="width:400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close save_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">ADD LEAD SOURCE</h4>
        <div class="clearfix"></div>
      </div>
    
    <div class="modal-body">
      <div class="form-group">
        <label for="name">Lead Source</label>
        <input type="text" id="new_source" name="new_source" class="txtlft form-control" placeholder="Lead Source">
        <button type="button" class="btn btn-info pull-left save_t" data-client_type="org" id="add_lead_source" name="save">Add</button>
        <div class="clearfix"></div>
      </div>
      
      <div id="append_new_source">
      @if( isset($old_lead_sources) && count($old_lead_sources) >0 )
        @foreach($old_lead_sources as $key=>$source_row)
          <div class="pop_list form-group">{{ $source_row['source_name'] }}</div>
        @endforeach
      @endif
      @if( isset($new_lead_sources) && count($new_lead_sources) >0 )
        @foreach($new_lead_sources as $key=>$source_row)
        <div class="pop_list form-group" id="hide_div_{{ $source_row['source_id'] }}">
          <a href="javascript:void(0)" title="Delete Field ?" class="newlist delete_source" data-field_id="{{ $source_row['source_id'] }}"><img src="/img/cross.png" width="12"></a>
          {{ $source_row['source_name'] }}
        </div>
        @endforeach
      @endif
      </div>
      
      <!-- <div class="modal-footer1 clearfix">
        <div class="email_btns">
          <button type="button" class="btn btn-primary pull-left save_t" data-client_type="org" id="add_lead_source" name="save">Save</button>
          <button type="button" class="btn btn-danger pull-left save_t2" data-dismiss="modal">Cancel</button>
        </div>
      </div> -->
    </div>
    
  </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>