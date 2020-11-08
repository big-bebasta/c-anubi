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
		//Connect to the server and select the database
		$myusername = $_SESSION['myusername'] ;
		$link = mysqli_connect($host, $username, $password, $db_name);	
		$getuserkind = mysqli_fetch_assoc(mysqli_query($link, "SELECT userkind FROM voglioentrare WHERE user_name = '$myusername'"));
		$userkind = $getuserkind['userkind'];
		$id_carnet = $_GET['id_carnet'];
		$num_ingressi = $_GET['num_ingressi'];
		$getdog = mysqli_fetch_assoc(mysqli_query($link, "SELECT `id_cane` FROM `libdog_carnet_history` WHERE `id_carnet` = '$id_carnet'"));
		$dogid = $getdog['id_cane'];
		$getdogname = mysqli_fetch_assoc(mysqli_query($link, "SELECT `name` FROM `libdog_Anagrafica_Cani` WHERE `idlibdog_Anagrafica_Cani` = '$dogid'"));
		$dogname = $getdogname['name'];
		}
		
	?>
<html>
<head>
	<title>Liberty Dog</title>
	<style>
		h1   {color:#000000; font-size:150%; text-align:center;}
		h2   {color:#000000; font-size:100%; text-align:center;}
		h3   {color:#000000; font-size:75%; text-align:center;}
		h4   {color:#000000; font-size:65%; text-align:center;}
		h5   {color:#000000; font-size:60%; text-align:center;}
		h6   {color:#000000; font-size:55%; text-align:center;}
		p    {margin-left:50px;}
		body {background-color:#bbbbbb; 
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
		<h1> Liberty Dog</h1>
	<br><br><br><br>
	<p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
     <h1> Vorrei modificare i dati del carnet numero : 
<?php 
		echo $id_carnet;
		echo " che consiste di ";
		echo $num_ingressi;
		echo " ingressi e riguarda il cane ";
		echo $dogname;
		?> 
		</h1>
		
         <?php
            $msg = '';
		echo "<table> <tr> <td>";
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");
			echo "<table align=center border=2> <tr><td>Id</td><td>Carnet</td><td>Giorno</td><td>Id Ingresso</td><td>Ore</td><td>Note</td><td>Scollega</td></tr>";
			$sqlsummary="SELECT `id_linkage`,`id_carnet`, `giorno`, id_day,timediff(pres.outtime,pres.intime) as orein, `note` FROM `libdog_link_carnet_presenze` as link, `libdog_presenze_day` as pres WHERE `id_carnet` = $id_carnet and pres.id_day = link.`id_presenza` order by `giorno` desc;";
			$resultsqlsummary = mysql_query($sqlsummary);
			$countersummary=0;
			while($rowsummary = mysql_fetch_row($resultsqlsummary)) {
			    echo "<tr>";
			    foreach($rowsummary as $cellsummary) {
   					if ($countersummary == 0) { $id_linkage = $cellsummary;}
					if ($countersummary < 6) {
						echo "<td align=center><h3>$cellsummary</h3></td>";
						$countersummary++;
   					} else { 
						echo ""; 
						}
					}
				echo "<td><a href=\"collega.php?id_linkage=",$id_linkage,"&id_carnet=",$id_carnet,"&num_ingressi=",$num_ingressi,"\"> Scollega </a> </td></tr>";
				$countersummary=0;
				}
			echo "</table>";
			echo "</td><td>";
			echo "<table align=center border=2> <tr><td>Id</td><td>Giorno</td><td>Id Cane</td><td>Id Ingresso</td><td>Descrizione Ingresso</td><td>Trasporto</td><td>Stato</td><td>Note</td><td>Collega</td></tr>";
			$sqlaccess="SELECT `id_day`,`giorno`, `id_cane`, `id_pagamento`, `denominazione`, `trasporto`, `status`,`note` FROM `libdog_presenze_day`, `libdog_tariffario_all` where `libdog_presenze_day`.`id_pagamento` =`libdog_tariffario_all`.`id` and `id_cane` = $dogid order by `giorno` desc limit 0,80;";
			$resultaccess = mysql_query($sqlaccess);
			$counteraccess=0;
			while($rowaccess = mysql_fetch_row($resultaccess)) {
			    echo "<tr>";
			    foreach($rowaccess as $cellaccess) {
					if ($counteraccess == 0) { 	$id_day = $cellaccess;}
   					if ($counteraccess < 8) {
						echo "<td align=center><h3>$cellaccess</h3></td>";
						$counteraccess++;
   					} else { 
						echo ""; 
						}
					}
				echo "<td><a href=\"collega.php?id_day=",$id_day,"&id_dog=",$dogid,"&id_carnet=",$id_carnet,"&num_ingressi=",$num_ingressi,"\"> Collega </a> </td></tr>";
				$counteraccess=0;
				}
			echo "</table>";
			echo "</td></tr></table>";

         ?>
      </div> <!-- /container -->			   
	</td></tr></table>
  </p>

						<h4><a href="login_success.php">Return to Menu</a></h4> <br>
<?php 
 if ($userkind == 'superuser' || $userkind == 'teamleader') {
	echo "<h4><a href=\"carnet.php\">Return to Carnet</a></h4> <br> <h6>";
 } else {
	 if ($userkind == 'user') {
	echo "<h4><a href=\"carnet.php\">Return to Carnet</a></h4> <br><br><br><br><h6>";
			}
		}	
			echo ( $msgupdateentry );
		?>
		</h6>
		<h6>
 		<?php 
			echo ( $msglog );
		?>
		</h6>
		

		</body>
</html>

