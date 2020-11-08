<?php
   session_start();
    $msg = "Messaggio vuoto";
   if( isset( $_SESSION['myusername'] ) ) {
      $msg = "Session Set ".  $_SESSION['myusername'];
   }else {
      $msg = "Session NOT Set ".  $_SESSION['myusername'];
   }

?>
<html>
<head>

		<title>Liberty Dog</title>


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
	<p align=center> <h1> Invalid Login  </h1> </p>
  <br><br>
        <?php  echo ( $msg ); ?>
		
		<br><br><br>
  <h4> <a href="https://en.wikipedia.org/wiki/2015_Rugby_World_Cup"> <img src="./shaun.jpg"> <a href="http://www.uefa.com/uefaeuro/"> <img src="./euro2016.png"> <a href="https://www.rio2016.com/en"> <img src="./rio.png"> </a></h4>
 </body>
</html>