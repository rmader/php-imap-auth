<?php
session_start();

$host = "mailrechner.de";
$domains = array(
	"liqd.de",
	"liqd.net"
);

function endsWith($haystack, $needle)
{
	return substr($haystack, -strlen($needle))===$needle;
}

if(isset($_SESSION['userid'])) {
        die("You are logged in");
}

if(isset($_POST['email']) and isset($_POST['password'])){

	$email = $_POST['email'];
	$password = $_POST['password'];
	$url = $_POST['url'];

	$validDomain = false;
	foreach($domains as $domain){
		if(endsWith($email,"@".$domain)){
			$validDomain = true;
			break;
		}
	}
	if(!$validDomain){
		$errorMessage = "Domain invalid";
	} elseif (imap_open("{".$host.":143/imap/tls/readonly}", $email, $password)) {
		$_SESSION['userid'] = rand();
		if(!empty($url)){
			header('Location: '.$url);
		}
		die("Login successful");
	} else {
 		$errorMessage = "Invalid credentials";
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>LIQD Login</title>
<?php if(!isset($url)): ?>
		<script type="text/javascript">
        		function setURL(){
                		document.getElementById("url").value = document.URL;
        		}
        		window.onload = setURL;
		</script>
<?php endif ?>
		<style>
body{
	background: #0076ae;
}
#content{
	position:absolute;
	top:50%;
	left:50%;
	margin-top:-100px; /* this is half the height of your div*/  
	margin-left:-155px; /*this is half of width of your div*/
	width: 310px;
	font-family: 'Open Sans', Frutiger, Calibri, 'Myriad Pro', Myriad, sans-serif;	
}
#title{
	text-align: center;
	font-size: 3em;
	color: #fff;
}
#form{
	float: left;
}
#error_message{
	text-align:center;
	font-size: 20px;
	color: red;
	font-weight: 600;
}
#form input{
	border-radius: 3px;
	outline: none;
	font-size: 20px;
	margin: 5px;
}
#email{
	box-sizing: content-box;
	padding: 11px 10px 9px 10px;
	width: 280px;
	border: none;
	font-weight: 300;
	margin-bottom: 0 !important;
	border-bottom: 0 !important;
	border-bottom-left-radius: 0 !important;
	border-bottom-right-radius: 0 !important;
}
#password{
	box-sizing: content-box;
	padding: 11px 10px 9px 10px;
	width: 280px;
	border: none;
	font-weight: 300;
	margin-top: 0 !important;
	border-top: 0 !important;
	border-top-right-radius: 0 !important;
	border-top-left-radius: 0 !important;
	box-shadow: 0 1px 0 rgba(0,0,0,.1) inset !important;
}
#submit{
	padding: 10px 20px;
	width: 300px;
	color: #fff;
	background-color: #0092d9;
	border: 1px solid #0082c9;
	cursor: pointer;
	font-weight: 600;
	outline: none;
}
		</style>
	</head>
<body>

<div id="content">
<div id="title">LIQD-Login</div>
<div id="error_message">
<?php
if(isset($errorMessage)) {
	echo $errorMessage;
}
?>
</div>
<div id="form">
<form action="/imap-login.php" method="post">
	<input type="email" size="40" maxlength="250" name="email" id="email" placeholder="Your.name@liqd.de" autofocus="" autocomplete="on" autocapitalize="off" autocorrect="off">
	<input type="password" size="40"  maxlength="250" name="password" id="password" placeholder="Password">
	<input type="hidden" <?php if(isset($url)) echo "value=\"".$url."\"";?>  name="url" id="url">

	<input type="submit" id="submit" value="Log in">
</form>
</div>
</div>
</body>
</html>
