<p>Dear User,</p>
<p>A new {{ $value['type_name'] or ''}} has been requested</p><br>

<p><strong>Details</strong></p>
<p>Staff Name : {{ $STAFFNAME or '' }}</p>
<p>Time off type : {{ $value['type_name'] or ''}}</p>
<p>Date : {{ date("d-m-Y", strtotime($value['date'])); }}</p>
<p>Duration : {{ $value['duration'] or '' }}</p>
<p>Note :- {{ $value['notes'] or '' }}</p><br>


<p>Author : {{ $USERNAME or ''}}</p>
<p>Regard</p>
<p>{{$PRACTICENAME or ''}}</p>
<p>This email and any attachments to it may be confidential and are intended solely for the use of the individual to whom it is addressed. If you are not the intended recipient of this email, you must neither take any action based upon its contents, nor copy or show it to anyone. Please contact the sender if you believe you have received this email in error.</p>
