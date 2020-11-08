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
<meta  http-equiv="Content-Type" content="text/html;  charset=iso-8859-1"> 
<title>Search Dog</title> 
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
<h3>Ricerca Cane</h3> 
<form  method="post" action="search.php?go"  id="searchform"> 
<input  type="text" name="name"> 
<input  type="submit" name="submit" value="Search"> 
</form>
<p><a  href="?by=A">A</a> | <a  href="?by=B">B</a> | <a  href="?by=K">K</a></p>
<?php

			$host="mysqlhost"; // Host name 
			$username="uln6tjuc_dataentry"; // Mysql username 
			$password="kN0Tt3n"; // Mysql password 
			$db_name="uln6tjuc_libdog"; // Database name 
			$tbl_name="libdog_Anagrafica_Clienti"; // Table name 
			
  if(isset($_POST['submit'])){
  if(isset($_GET['go'])){
  if(preg_match("/^[  a-zA-Z]+/", $_POST['name'])){
  $name=$_POST['name'];
  //connect  to the database
  $db=mysql_connect  ("host", "username",  "password") or die ('I cannot connect to the database  because: ' . mysql_error());
  //-select  the database to use
  $mydb=mysql_select_db("db_name");
  //-query  the database table
  $sql="SELECT  ID, name FROM `uln6tjuc_libdog`.`libdog_Anagrafica_Cani` WHERE name LIKE '%" . $name ."%'";
  //-run  the query against the mysql query function
  $result=mysql_query($sql);
  //-create  while loop and loop through result set
  while($row=mysql_fetch_array($result)){
          $FirstName  =$row['FirstName'];
          $LastName=$row['LastName'];
          $ID=$row['ID'];
  //-display the result of the array
  echo "<ul>\n";
  echo "<li>" . "<a  href=\"search.php?id=$ID\">"   .$FirstName . " " . $LastName .  "</a></li>\n";
  echo "</ul>";
  }
  }
  else{
  echo  "<p>Please enter a search query</p>";
  }
  }
  } //end of search form script
if(isset($_GET['by'])){
$letter=$_GET['by'];
//connect  to the database
$db=mysql_connect  ("servername", "username",  "password") or die ('I cannot connect to the database  because: ' . mysql_error());
//-select  the database to use
$mydb=mysql_select_db("yourDatabase");
//-query  the database table
$sql="SELECT  ID, FirstName, LastName FROM Contacts WHERE FirstName LIKE '%" . $letter . "%' OR LastName LIKE '%" . $letter ."%'";
//-run  the query against the mysql query function
$result=mysql_query($sql);
//-count  results
$numrows=mysql_num_rows($result);
echo  "<p>" .$numrows . " results found for " . $letter . "</p>";
//-create  while loop and loop through result set
while($row=mysql_fetch_array($result)){
$FirstName  =$row['FirstName'];
            $LastName=$row['LastName'];
            $ID=$row['ID'];
//-display  the result of the array
echo  "<ul>\n";
echo  "<li>" . "<a  href=\"search.php?id=$ID\">"   .$FirstName . " " . $LastName .  "</a></li>\n";
echo  "</ul>";
}
}
?>

</body> 
</html> 
