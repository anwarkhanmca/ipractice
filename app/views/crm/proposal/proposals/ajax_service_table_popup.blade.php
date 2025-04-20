<table class="table table-bordered table-hover dataTable" width="100%">
  <thead>
    <tr>
      <th align="center" width="6%"></th>
      <th>Table Name</th>
      <th width="14%" style="text-align: center;">View Table</th>
      <th align="center" width="8%" align="center">Action</th>
    </tr>
  </thead>

  <tbody role="alert" aria-live="polite" aria-relevant="all">
  @if(isset($tables) && count($tables) >0)
    @foreach($tables as $k=>$v)
      <tr class="removeServiceTableTr_{{$v['id'] or ''}}">
        <td align="center"><button type="button" id="copyTableToProposalService" data-id="{{$v['id'] or ''}}">Copy</button></td>
        <td>{{ $v['table_name'] or '' }}</td>
        <td align="center"><a href="javascript:void(0)" class="center openAddOpperFee" data-p_service_id="0" data-id="{{$v['id'] or ''}}" data-action_type="view_table">View Table</a></td>
        <td align="center"><a href="javascript:void(0)" class="delete_service_table" data-p_service_id="0" data-id="{{$v['id'] or ''}}" data-delete_type="service_table"><img src="/img/cross.png" height="12"></a></td>
      </tr>
    @endforeach
  @endif

  </tbody>
</table>
<div class="clearfix"></div>