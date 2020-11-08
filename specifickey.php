<?php
ob_start();
$host="den00pec.us.oracle.com"; // Host name 
$username="csiuser"; // Mysql username 
$password="UsainBolt"; // Mysql password 
$db_name="csiencryption"; // Database name 
$tbl_name="csikeys"; // Table name 
openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_LOCAL0);

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die ("There are some issues with the connect, in checklogin.php");
mysql_select_db("$db_name")or die("cannot select DB");

// Define $myusername and $mypassword 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 

// To protect MySQL injection (more detail about MySQL injection)
$myspecificdate = stripslashes($myspecificdate);
$myspecificdate = mysql_real_escape_string($myspecificdate);
$sql="SELECT * FROM $tbl_name WHERE date='$myspecificdate'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
    // log the attempt
    $access = date("Y/m/d H:i:s");
    syslog(LOG_WARNING, "Login attempt: $access {$_SERVER['REMOTE_ADDR']} ({$_SERVER['HTTP_USER_AGENT']}) , result: $result  and count: $count");
	
// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
//if($count>0){
// Register $myusername, $mypassword and redirect to file "login_success.php"
//store data:
session_register("myusername");
session_register("mypassword"); 
$_SESSION['myusername'] = $myusername;
$_SESSION['mypassword'] = $mypassword;
syslog(LOG_WARNING, "Login attempt: $access {$_SESSION['myusername']}");
header("location:login_success.php");
}
else {
header("location:home.htm"); //main_login.php is the login page   
}
ob_end_flush();
?>