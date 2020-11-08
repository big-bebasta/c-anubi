<?php
   session_start();
   ob_start();
	openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_LOCAL0);
// log the attempt
	$access = date("Y/m/d H:i:s");
	syslog(LOG_WARNING, "Login attempt: $access {$_SESSION['myusername']}");
	if( !isset($_SESSION['myusername']) ) {
		header("location:main.php");
		session_destroy();
		exit();
	} else {
		$host="mysqlhost"; // Host name 
		$username="uln6tjuc_dataentry"; // Mysql username 
		$password="kN0Tt3n"; // Mysql password 
		$db_name="uln6tjuc_libdog"; // Database name 
		$tbl_name="voglioentrare"; // Table name 
		openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_LOCAL0);
		
		// Connect to server and select databse.
		mysql_connect("$host", "$username", "$password")or die ("There are some issues with the connect, in checklogin.php");
		mysql_select_db("$db_name")or die("cannot select DB");

		$myusername = $_SESSION['myusername'] ;
		$link = mysqli_connect($host, $username, $password, $db_name);	
		$getuserkind = mysqli_fetch_assoc(mysqli_query($link, "SELECT userkind FROM voglioentrare WHERE user_name = '$myusername'"));
		$userkind = $getuserkind['userkind'];	
		// If result matched $myusername and $mypassword, table row must be 1 row
		if($userkind == 'superuser'){
			$myusername = $_SESSION['myusername'] ;
			$id_day = $_GET['id_day'];
			$id_cane = $_GET['id_dog'];
			$id_carnet = $_GET['id_carnet'];
			$num_ingressi = $_GET['num_ingressi'];
			$id_linkage = $_GET['id_linkage'];
		}
	}

	if ($id_linkage>1) {
		// DELETE FROM `libdog_link_carnet_presenze` WHERE XXXXXXx
		$sqldel="DELETE FROM `libdog_link_carnet_presenze` WHERE id_linkage='$id_linkage'";
		$resultdel=mysql_query($sqldel);
		}
	if ($id_day>1 && $id_carnet>1) {
		// INSERT INTO `libdog_link_carnet_presenze`(`id_carnet`, `id_presenza`) VALUES ([value-1],[value-2])
		$sqlinsert="INSERT INTO `libdog_link_carnet_presenze`(`id_carnet`, `id_presenza`) VALUES ('$id_carnet','$id_day')";
		$resultinsert=mysql_query($sqlinsert);
		}

	header("location:listaccesscarnet.php?id_carnet=$id_carnet&num_ingressi=$num_ingressi");
	//header("location:carnet.php"); //main_login.php is the login page   

ob_end_flush();
?>


<html>
   
   <head>
      <title>Setting up a PHP session</title>
   </head>
   
   <body>
   
<?PHP 
/*		DEBUG
					$msg = "Benvenuta ".  $_SESSION['myusername'];
					echo ( $msg );
					echo "<h1>";
					echo $id_day;
					echo " - ";
					echo $id_cane;
					echo " - ";
					echo $id_carnet;
					echo " - ";
					echo $num_ingressi;
					echo " - ";
					echo $id_linkage;
					echo "</h1><h1>";
					$sqldel="DELETE FROM `libdog_link_carnet_presenze` WHERE id_linkage='$id_linkage'";
					echo ( $sqldel );
					echo "</h1><h1>";
					$sqlinsert="INSERT INTO `libdog_link_carnet_presenze`(`id_carnet`, `id_presenza`) VALUES ('$id_carnet','$id_day')";
					echo ( $sqlinsert );
					echo "</h1>";
				*/
				?>
				
				   </body>
   
</html>