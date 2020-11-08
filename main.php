<?php
   ob_start();
   session_start();
?>

<html>
<head>
	<title>Liberty Dog - Data entry</title>
	<style>
		h1   {color:#000000; font-size:250%; text-align:center;}
		h2   {color:#000000;}
		h3   {color:#000000; font-size:50px; text-align:center;}
		h4   {color:#000000; font-size:22px; text-align:center;}
		h6   {color:#000000; font-size:16px; text-align:center;}
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
		<p align=center> <table align=center><tr align=center><td  align=center bgcolor=#004400> <img src="./jumi/Liberty-dog.png"> </td></tr></table></p>
	<br><br>
	<p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
         
         <?php
            $msg = '';
            
            if (isset($_POST['login']) && !empty($_POST['myusername']) 
               && !empty($_POST['mypassword'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
                  $_SESSION['myusername'] = $myusername;
				  $_SESSION['mypassword'] = $mypassword;
				  $msg = "User= ".  $_SESSION['myusername'];
               }else {
                  $msg = 'Wrong username or password';
               }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="checklogin.php" method='post' id='login'>
                <font color=#eeee00> Username: </font> </font><br />
                <input type='text' name='myusername' /><br />
                <font color=#eeee00> Password: </font> <br />
                <input type='password' name='mypassword' /><br />
                <input type='submit' name = "login" value='Login' />
            </form>
        	</div>
			</td></tr>
		</table>
  </p>

  
   <?php  
	//echo ( $msg ); 
	?>
   
   
</body>
</html>