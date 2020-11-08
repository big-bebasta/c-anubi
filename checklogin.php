<?php
ob_start();
$host="mysqlhost"; // Host name 
$username="uln6tjuc_dataentry"; // Mysql username 
$password="kN0Tt3n"; // Mysql password 
$db_name="uln6tjuc_libdog"; // Database name 
$tbl_name="voglioentrare"; // Table name 
openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_LOCAL0);

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die ("There are some issues with the connect, in checklogin.php");
mysql_select_db("$db_name")or die("cannot select DB");

// Define $myusername and $mypassword 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM $tbl_name WHERE user_name='$myusername' and password='$mypassword' and active='1'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
    // log the attempt
    $access = date("Y/m/d H:i:s");
    syslog(LOG_WARNING, "Login attempt: $access {$_SERVER['REMOTE_ADDR']} ({$_SERVER['HTTP_USER_AGENT']}) , result: $result  and count: $count");

$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','login')";
$result2=mysql_query($sql2);
	
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
//if($count>-2){
// Register $myusername, $mypassword and redirect to file "login_success.php"
//store data:
	session_start(); 
	$_SESSION['myusername'] = $myusername;
	$_SESSION['mypassword'] = $mypassword;
	syslog(LOG_WARNING, "Login attempt: $access {$_SESSION['myusername']}");
	// header("location:welcome.htm");
	header("location:login_success.php");
}  else {
	header("location:main.php"); //main_login.php is the login page   
	}
ob_end_flush();
?>


<html>
   
   <head>
      <title>Setting up a PHP session</title>
   </head>
   
   <body>
   
<?PHP 

					$msg = "Benvenuta ".  $_SESSION['myusername'];
					echo ( $msg );
				?>
				
				   </body>
   
</html>