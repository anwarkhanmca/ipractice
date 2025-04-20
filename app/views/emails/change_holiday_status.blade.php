<p>Dear {{ $FNAME or ''}}</p>
<p>The time off request for {{ $value['type_name'] or ''}} on {{ date("d-m-Y", strtotime($value['date'])); }} has been updated from {{ $old_state or ''}} to {{ $value['state'] or ''}}</p><br>
<p>New status : {{ $value['state'] or ''}}</p>

<p>Author : {{ $USERNAME or ''}}</p>
<p>Regard</p>
<p>{{$PRACTICENAME or ''}}</p>
<p>This email and any attachments to it may be confidential and are intended solely for the use of the individual to whom it is addressed. If you are not the intended recipient of this email, you must neither take any action based upon its contents, nor copy or show it to anyone. Please contact the sender if you believe you have received this email in error.</p>
