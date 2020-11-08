<?php
   session_start();
   ob_start();
	openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_LOCAL0);
// log the attempt
	$access = date("Y/m/d H:i:s");
	syslog(LOG_WARNING, "Login attempt: $access {$_SESSION['myusername']}");
	if( !isset($_SESSION['myusername']) )
		{
		header("location:main.php");
		session_destroy();
		exit();
		}
	?>

<html>
<head>
	<title>Liberty Dog - Data entry</title>
	<style>
		h1   {color:#000000; font-size:150%; text-align:center;}
		h2   {color:#000000; font-size:100%; text-align:center;}
		h3   {color:#000000; font-size:75%; text-align:center;}
		h4   {color:#000000; font-size:65%; text-align:center;}
		h5   {color:#000000; font-size:60%; text-align:center;}
		h6   {color:#000000; font-size:55%; text-align:center;}
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
			
<p><b>Date</b> </p>
<?php
// Read the css directory for theme folders
$themes_ar = array();
$themesDirectory = dir('./calendar/css/');
while($tname = $themesDirectory->read())
{
	if(is_dir('./calendar/css/'.$tname) && file_exists('./calendar/css/'.$tname.'/calendar.css') && !preg_match("/^[\.]/", $tname))
	{
		$themes_ar[$tname] = $tname;
	};
};
natsort($themes_ar);
$themesDirectory->close();
?>



<h1> Second Option:</h1>

<p>
Depending on browser support:<br>
A date picker can pop-up when you enter the input field.
</p>

<form action="/action_page.php">
  Birthday:
  <input type="date" name="bday">
  <input type="submit">
</form>

<p><strong>Note:</strong> type="date" is not supported in Firefox, or Internet Explorer 11 and earlier versions.</p>	
		
</body>
</html>