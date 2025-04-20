<!DOCTYPE html>
<head>
    <title>Companies House Login</title>
</head>
<body>
	<div id="hide">
    Company No: {{ $un2 }} &nbsp;&nbsp;&nbsp; Authentication Code: {{ $pw2 }} &nbsp;&nbsp;&nbsp;
    </div>
    <iframe name="cframe" id="target" src="/chdata/remotecall/{{ $un1 }}/{{ $pw1 }}" width="100%" height="1200"></iframe>
<script>
document.getElementById("signin").click();
</script>
</body>