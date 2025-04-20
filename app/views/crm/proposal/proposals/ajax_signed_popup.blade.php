<p class="signedAccept">Signed & 
	{{($signedData['save_type']=='A' || $signedData['save_type']=='MA')?'Accepted':'Declined'}}</p>
<div class="col-md-12">
  <div class="col-md-12 signedText">
	@if($signedData['save_type'] == 'MA')
        Marked as Accepted
    @elseif($signedData['save_type'] == 'ML')
        Marked as Lost
    @else
        {{ $signedData['signature'] or '' }}
    @endif
  </div>
  <div class="col-md-12">{{$signedData['added'] or ''}}</div>
  <div class="col-md-12">Ip Address : {{$signedData['ip_address'] or ''}}</div>
  <div class="col-md-12"><a href="#">View Signed Engagement Letter</a></div>
  <div class="clearfix"></div>
</div>