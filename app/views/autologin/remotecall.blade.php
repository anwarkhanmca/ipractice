<!DOCTYPE html>
<html>
<body>
<form id="login" method="post" action="https://ewf.companieshouse.gov.uk//seclogin?tc=1">
	<label for="email">
		<span>Email address</span>
		<input class="" type="text" name="email" value="{{ $un1 }}" maxlength="256" id="email" />
	</label>
	
	<label for="seccode">
		<span>Password</span>
		<input class="" type="password" name="seccode" value="{{ $pw1 }}" maxlength="32" id="seccode" />
	</label>

	<input type="submit" name="submit" id="signin" value="Sign in" />
	<input type="hidden" name="lang" value="en" />
</form>
<script>
document.getElementById("signin").click();
</script>
</body>
</html>