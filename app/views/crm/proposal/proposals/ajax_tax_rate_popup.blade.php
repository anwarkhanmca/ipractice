@if(isset($TaxRates) && count($TaxRates) >0 )
  @foreach($TaxRates as $key=>$v)
    <tr class="TaxRateTr_{{$v['tax_rate_id'] or '0'}} {{($v['is_archive'] == 'Y')?'rowColor':''}}">
      <td>{{$v['name'] or ''}}</td>
      <td>{{$v['rate'] or '0'}}%</td>
      <td align="center">
          @if(isset($v['status']) && $v['status'] == 'N')
              <a href="javascript:void(0)" data-id="{{$v['tax_rate_id'] or '0'}}" class="deleteTaxRate"><img src="/img/cross.png" height="12"></a>
          @endif
      </td>
      <td align="center"><input type="checkbox" class="arcTaxRate"  data-id="{{ $v['tax_rate_id']}}" data-update_value="{{($v['is_archive']=='Y')?'N':'Y'}}" data-event="{{($v['is_archive']=='Y')?'unarchive':'archive'}}" {{($v['is_archive']=='Y')?'checked':''}} /></td> 
    </tr>
  @endforeach
@endif