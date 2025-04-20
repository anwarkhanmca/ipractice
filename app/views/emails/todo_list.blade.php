<p>Dear {{ $STAFFNAME or ''}}</p>

<p>A new task has been allocated to you.</p>
<p>Urgent : {{ ($details['urgent'] == 'N')?'No':'Yes' }}</p>

<p>Task name :- {{ $details['taskname'] or '' }}</p>
<p>Task deadline : {{ date('d-m-Y', strtotime($details['taskdate'])) }}</p>
<p>Time :- {{ date('H:i', strtotime($details['task_time'])) }}</p>
<p>Client Name :- {{ $details['client_name'] or '' }}</p>
<p>Notes :- {{ $details['notes'] or '' }}</p>

<p>Author : {{ $USERNAME or ''}}</p>
<p>Regard</p>
<p>{{$PRACTICENAME or ''}}</p>
<p>This email and any attachments to it may be confidential and are intended solely for the use of the individual to whom it is addressed. If you are not the intended recipient of this email, you must neither take any action based upon its contents, nor copy or show it to anyone. Please contact the sender if you believe you have received this email in error.</p>
