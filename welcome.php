<!DOCTYPE html>
<?PHP
session_start();
openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_LOCAL0);
// log the attempt
$access = date("Y/m/d H:i:s");
syslog(LOG_WARNING, "Login attempt: $access {$_SESSION['myusername']}");
if( !isset($_SESSION["myusername"]) ){
    header("location:main.php");
    exit();
}
?>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
<head>
    <meta http-equiv='content-type' content='application/xhtml+xml; charset=UTF-8' />
		<title>Liberty Dog</title>
    <!-- JAVASCRIPTS -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="script/jquery.js"></script>
    <!-- CSS FILES -->
    <link rel='stylesheet' type='text/css' href='css/default.css' />

	<style>
		h1   {color:#003333; font-size:250%; text-align:center;}
		h2   {color:#ffffff;}
		h3   {color:#000000; font-size:50px; text-align:center;}
		h4   {color:#3333ff; font-size:22px; text-align:center;}
		h6   {color:#ffffff; font-size:16px; text-align:center;}
		p    {margin-left:50px;}
		body {background-color:#c9c9ff; 
				background-image:url('../images/background.jpg'); 
				background-attachment:fixed;
				background-size:60%;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-repeat:no-repeat;
				background-position:center top;
				vlink:#3333ff;
				}
</style>
</head>
<body>
	<p align=center> <img src="./Liberty-dog.png"> </p>
	<br><br><br><br>
	<p align=center> <h1> Benvenuta  </h1> </p>
					<?PHP
					$myusername = $_SESSION['myusername'];
					$mypassword = $_SESSION['mypassword'];
					echo "$_SESSION['myusername']"; 
				?>
  <br>
  <h4 align=center>Per inserire un nuovo Padrone clicca <a href="newclient.php"> qui </a><h4><br> <br>
  <h4 align=center>Per inserire un nuovo Cane clicca <a href="newdog.php">qui</a><h4><br>
  <br><br>
<!--  <h4> <a href="https://en.wikipedia.org/wiki/2015_Rugby_World_Cup"> <img src="./shaun.jpg"> <a href="http://www.uefa.com/uefaeuro/"> <img src="./euro2016.png"> <a href="https://www.rio2016.com/en"> <img src="./rio.png"> </a></h4>
 -->
 </body>
</html>