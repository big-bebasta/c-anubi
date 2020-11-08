<?php 
session_start();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" 
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en'>
<head>
    <meta http-equiv='content-type' content='application/xhtml+xml; charset=UTF-8' />
		<title>Liberty Dog - Data entry</title>
    <!-- JAVASCRIPTS -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="script/jquery.js"></script>
    <!-- CSS FILES -->
    <link rel='stylesheet' type='text/css' href='css/default.css' />

	<style>
		h1   {color:#000000; font-size:250%; text-align:center;}
		h2   {color:#000000;}
		h3   {color:#000000; font-size:50px; text-align:center;}
		h4   {color:#000000; font-size:22px; text-align:center;}
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
	<br>
		<p align=center> <img src="./Liberty-dog.png"> </p>
		<h1> Liberty Dog - Data entry </h1>
	<br><br>
	<h2 align=center> You have currently logged out successfully </h2>
	<br><br><br><br><br>
	<p align=center>
		<table align=center bgcolor=#000066> 
			<tr align=center> <td align=center> 
			  <div id='wrapper'>
        	<div id='loginform'>
            <form action="checklogin.php" method='post' id='login'>
                <font color=#eeee00> Username: </font> </font><br />
                <input type='text' name='myusername' /><br />
                <font color=#eeee00> Password: </font> <br />
               <input type='password' name='mypassword' /><br />
                <input type='submit' value='Login' />
            </form>
        	</div>
    		</div>
			</td></tr>
		</table>
  </p>
</body>
</html>