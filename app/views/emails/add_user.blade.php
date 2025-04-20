<p>Hi {{ $fname }},</p>

<p>You have been invited as a user of the Firm's {{($user_type == 'C')?'Client ':''}}portal, please log in as follows to manage your account.</p>
<p>Please see below a copy of your log in details:</p>
<p>Url:- <a target="_blank" href="{{ $link }}">{{ $link }}</a></p>
<p>Login name:- {{ $email }}</p>
<p>Password:- {{ $password }}</p>
<br />

<p>Regards</p>
<p>{{ $display_name }}</p>