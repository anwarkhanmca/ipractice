<table width="100%" style="margin-bottom: 10px;">
  <thead>
    <tr>
      <td width="60%"><input type="text" class="roundBox" placeholder="Table Name" name="table_name" value="{{$tables['table_name'] or ''}}"></td>
      <td width="2%"></td>
      <td width="15%">
        <select class="form-control newdropdown" name="table_type">
          <option value="">-- Select --</option>
          <option value="Variable" {{(isset($tables['table_type']) && $tables['table_type'] == 'Variable')?'selected':''}}>Variable</option>
          <!-- <option value="Activity fee total" {{(isset($tables['table_type']) && $tables['table_type'] == 'Activity fee total')?'selected':''}}>Activity fee total</option> -->
          <option value="Estimate" {{(isset($tables['table_type']) && $tables['table_type'] == 'Estimate')?'selected':''}}>Estimate</option>
        </select>
      </td>
      <td width="23%"></td>
    </tr>
  </thead>
</table>
<table class="table table-bordered table-striped table-hover" width="100%">
  <thead>
      <tr>
          <th>Description</th>
          <th width="16%">Fees</th>
          <th width="4%">Action</th>
      </tr>
  </thead>
  <tbody>
    <?php $i = 1;?>
    @if(isset($details) && count($details) > 0)
      @foreach($details as $k=>$v)
        <tr id="TableRow{{$i}}" class="makeCloneClass">
          <td>
            <input type="text" class="roundBox" name="feeTypeDesc[]" id="feeTypeDesc{{$i}}" value="{{$v['desc'] or ''}}">
          </td>
          <td><input type="text" class="roundBox" name="feeTypeFees[]" id="feeTypeFees{{$i}}" value="{{$v['fees'] or ''}}"></td>
          <!-- <td align="center">
            <a href="javascript:void(0)" class="notes_btn openTableNotesPop" data-row_no="{{$v['id'] or ''}}" >notes</a>
            <input type="hidden" name="feeTypeNotes[]" id="feeTypeNotes{{$i}}" value="{{$v['notes'] or ''}}">
          </td> -->
          <td align="center">
          @if($k > 0)
            <a href="javascript:void(0)" class="deleteServFeesRow" data-row_no="{{$i}}" data-table_id="{{$v['id'] or ''}}"><img src="/img/cross.png" height="12"></a>
          @endif
          </td>
      </tr>
      <?php $i++;?>
      @endforeach
    @else
      <tr id="TableRow1" class="makeCloneClass">
          <td><input type="text" class="roundBox" name="feeTypeDesc[]" id="feeTypeDesc1"></td>
          <td><input type="text" class="roundBox" name="feeTypeFees[]" id="feeTypeFees1"></td>
          <!-- <td align="center"><a href="javascript:void(0)" class="notes_btn openTableNotesPop" data-row_no="1" >notes</a> -->
            <input type="hidden" name="feeTypeNotes[]" id="feeTypeNotes1" value="">
          </td>
          <td align="center"><!-- <a href="javascript:void(0)" class="deleteServFeesRow" data-row_no="1" data-table_id="0"><img src="/img/cross.png" height="12"></a> --></td>
      </tr>
    @endif
  </tbody>
</table>


