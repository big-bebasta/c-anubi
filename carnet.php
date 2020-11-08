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
		<h1> Liberty Dog - Gestione Carnet</h1>
	<br><br>
	<p align=center>
         	<h4><a href="login_success.php">Return to Menu</a></h4> <br><br>
         <?php
            $msg = '';
			$host="mysqlhost"; // Host name 
			$username="uln6tjuc_dataentry"; // Mysql username 
			$password="kN0Tt3n"; // Mysql password 
			$db_name="uln6tjuc_libdog"; // Database name 
			$tbl_name="libdog_prendi_e_scappa"; // Table name 
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

						
			if ($userkind == 'superuser') {
				echo "<h2>Carnet registrati</h2>";
						
				echo "	<table align=center border=2> <tr><td>Carnet</td><td>Data Inizio Validit&agrave;</td><td>Data Scadenza</td><td>ID Cane</td><td>Nome Cane</td><td>Razza Cane</td><td>Cognome Padrone</td><td>Numero Ingressi</td><td>Ingressi rimanenti</td><td>ID Acquisto</td><td>ID Pagamento</td></tr>";

	
						//$sql = "SELECT `libdog_carnet_history`.`id_carnet`,`validita`, `expiration`,`id_cane`, `libdog_Anagrafica_Cani`.`name`, `libdog_Anagrafica_Cani`.`breed`,`libdog_Anagrafica_Clienti`.`family`,`num_ingressi`,'0' as num, `id_acquisto`, `id_pagamento` FROM `libdog_carnet_history` , `libdog_Anagrafica_Cani`, `libdog_Anagrafica_Clienti`  where `idlibdog_Anagrafica_Cani` = `id_cane` and `libdog_Anagrafica_Clienti`.`idlibdog_Anagrafica_Clienti` = `libdog_Anagrafica_Clienti_id` and `libdog_carnet_history`.`id_carnet` not in (select `id_carnet` from `libdog_link_carnet_presenze`) union all SELECT `libdog_carnet_history`.`id_carnet`,`validita`, `expiration`,`id_cane`, `libdog_Anagrafica_Cani`.`name`, `libdog_Anagrafica_Cani`.`breed`,`libdog_Anagrafica_Clienti`.`family`,`num_ingressi`,count(*) num, `id_acquisto`, `id_pagamento` FROM `libdog_carnet_history` , `libdog_Anagrafica_Cani`, `libdog_Anagrafica_Clienti`,`libdog_link_carnet_presenze`  where `idlibdog_Anagrafica_Cani` = `id_cane` and `libdog_Anagrafica_Clienti`.`idlibdog_Anagrafica_Clienti` = `libdog_Anagrafica_Clienti_id` and `libdog_link_carnet_presenze`.`id_carnet`=`libdog_carnet_history`.`id_carnet` group by `libdog_carnet_history`.`id_carnet` order by `libdog_carnet_history`.`id_carnet` desc;";
						$sql = "select * from (SELECT `libdog_carnet_history`.`id_carnet`,`validita`, `expiration`,`id_cane`, `libdog_Anagrafica_Cani`.`name`, `libdog_Anagrafica_Cani`.`breed`,`libdog_Anagrafica_Clienti`.`family`,`num_ingressi`,'0' as num, `id_acquisto`, `id_pagamento` FROM `libdog_carnet_history` , `libdog_Anagrafica_Cani`, `libdog_Anagrafica_Clienti`  where `idlibdog_Anagrafica_Cani` = `id_cane` and `libdog_Anagrafica_Clienti`.`idlibdog_Anagrafica_Clienti` = `libdog_Anagrafica_Clienti_id` and `libdog_carnet_history`.`id_carnet` not in (select `id_carnet` from `libdog_link_carnet_presenze`) union all SELECT `libdog_carnet_history`.`id_carnet`,`validita`, `expiration`,`id_cane`, `libdog_Anagrafica_Cani`.`name`, `libdog_Anagrafica_Cani`.`breed`,`libdog_Anagrafica_Clienti`.`family`,`num_ingressi`,`num_ingressi`-count(*) num, `id_acquisto`, `id_pagamento` FROM `libdog_carnet_history` , `libdog_Anagrafica_Cani`, `libdog_Anagrafica_Clienti`,`libdog_link_carnet_presenze`  where `idlibdog_Anagrafica_Cani` = `id_cane` and `libdog_Anagrafica_Clienti`.`idlibdog_Anagrafica_Clienti` = `libdog_Anagrafica_Clienti_id` and `libdog_link_carnet_presenze`.`id_carnet`=`libdog_carnet_history`.`id_carnet` group by `libdog_carnet_history`.`id_carnet`) as tutto order by `id_carnet` desc;";
						$result = mysql_query($sql);
						$counter=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell) {
        					if ($counter == 0) { 	$id_carnet = $cell;	}
							if ($counter < 11) {
        							echo "<td align=center><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								}	
							    echo "<td><a href=\"modifycarnet.php?id_carnet=",$id_carnet,"\"> Modifica </a> </td></tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_libdog_carnet_history')";
						mysql_query($sql2);
			
				echo "	</table>";
		}
?>	
	</p>
	<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>				

</body>
</html>