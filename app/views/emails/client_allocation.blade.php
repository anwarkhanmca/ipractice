<p>Dear {{ $STAFFNAME or ''}}</p>
@if($SENDFROM == 'bulk')
	<p>The following clients has been allocated to you for {{ $SERVICENAME or ''}}</p>
	<p>Position : - {{ $POSITION or ''}}</p>

	@if(!empty($clients))
		@foreach($clients as $k=>$v)
			<p>{{$k+1}}. {{ $v['client_name'] or '' }}</p>
		@endforeach
	@endif
@else
	<p>A new client has been allocated to you!</p>
	<p>Role : {{ $POSITION or ''}}</p>
	<p>Date : {{ $DATE or ''}}</p>
@endif

<p>Author : {{ $USERNAME or ''}}</p>
<p>Regard</p>
<p>{{$PRACTICENAME or ''}}</p>
<p>This email and any attachments to it may be confidential and are intended solely for the use of the individual to whom it is addressed. If you are not the intended recipient of this email, you must neither take any action based upon its contents, nor copy or show it to anyone. Please contact the sender if you believe you have received this email in error.</p>
