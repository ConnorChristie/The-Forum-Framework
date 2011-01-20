<script type="text/javascript">
<!--
function sendRequest() {
	new Ajax.Request("<?php echo ROOT.DS.'application/user/submit_registration.php'?>",
		{
		method: 'post',
		postBody: 'name='+ $F('name'),
		onComplete: showResponse
		});
	}

function showResponse(req){
	$('show').innerHTML= req.responseText;
}
//-->
</script>
<h2>User Registration</h2>
<form onsubmit="return false">
Username:<br />
<input type="text" name="username"><br />
Email:<br />
<input type="text" name="user_email"><br />
Password:<br />
<input type="password" name="user_password"><br />
<input onclick="sendRequest()" value="Submit" type="button">
</form>
<div id="show"></div>