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
    <body vlink=#ffffff link=#ffffff>
    <table width=55% align=center>
    	<tr>
    		<td>
    		    <h1> Liberty Dog - Data entry</h1>
				<h3>  
					<?php
					$msg = "Benvenuta ".  $_SESSION['myusername']. " - ". $userkind;
					echo ( $msg );
				?>
  <br>

				</h3>
<br><br><br>	
<?php 
 if ($userkind == 'superuser') {
	echo "<table width=90% align=center border=0> <tr align=center> <td align=center> <a href=\"incam.php\"> <img width=80% src=\"./image/entrate.png\" alt=\"Per inserire una transazione economica in entrata\"> </a> </td> 	<td align=center> <a href=\"doginplus.php\"> <img width=80% src=\"./image/orari.png\" alt=\"Per registrare ingressi e uscite\"> </a>  </td> <td align=center> <a href=\"booking.php\"> <img width=80% src=\"./image/booking.png\" alt=\"Prenotazioni\"> </a>  </td> <td align=center> <a href=\"paimento.php\"> <img width=80% src=\"./image/uscite.png\" alt=\"Per inserire una transazione economica in uscita\"> </a> </td> </tr></table>";
	echo "<table width=90% align=center border=0> <tr align=center> <td align=center> <a href=\"newclient.php\"> <img width=80% src=\"./image/padrone.png\" alt=\"Per inserire nuovi clienti\"> </a>  </td> <td align=center> <a href=\"newdog.php\"> <img width=80% src=\"./image/cani.png\" alt=\"Per inserire un nuovo cane\"> </a>  </td> 	<td align=center> <a href=\"newfornit.php\"> <img width=80% src=\"./image/forni.png\" alt=\"Per inserire nuovi fornitori\"> </a>  </td> 								<td align=center> <a href=\"communications.php\"> <img width=80% src=\"./image/comm.png\" alt=\"Comunicazioni generali\"> </a>  </td> </tr></table>";
	echo "<table width=70% align=center border=0> <tr align=center> <td align=center> <a href=\"listonedit.php\"> <img width=80% src=\"./image/list.png\" alt=\"Listino Prezzi\"> </a>  </td> <td align=center> <a href=\"emplin.php\"> <img width=80% src=\"./image/people.png\" alt=\"Registro presenze personale\"> </a>   <td align=center> <a href=\"report.php\"> <img width=80% src=\"./image/report.png\" alt=\"Reports\"> </a>  </td>  </tr></table>";
	echo "<table width=70% align=center border=0> <tr align=center> <td align=center> <a href=\"fattone.php\"> <img width=80% src=\"./image/fatture.png\" alt=\"Registro ed emissione fatture\"> </a>  </td> <td align=center> <a href=\"carnet.php\"> <img width=80% src=\"./image/carnet.png\" alt=\"Registro Carnet\"> </a>  </td> <td align=center> <a href=\"magas.php\"> <img width=80% src=\"./image/magas.png\" alt=\"Gestione Magazziono\"> </a>  </td>  </tr></table>";
 } else {
	 if ($userkind == 'teamleader') {
	echo "<table width=90% align=center border=0> <tr align=center> <td align=center> <a href=\"incam.php\"> <img width=80% src=\"./image/entrate.png\" alt=\"Per inserire una transazione economica in entrata\"> </a> </td> 	 <td align=center> <a href=\"doginplus.php\"> <img width=80% src=\"./image/orari.png\" alt=\"Per registrare ingressi e uscite\"> </a>  </td>				<td align=center> <a href=\"booking.php\"> <img width=80% src=\"./image/booking.png\" alt=\"Prenotazioni\"> </a>  </td> </tr></table>";
	echo "<table width=90% align=center border=0> <tr align=center> <td align=center> <a href=\"newclient.php\"> <img width=80% src=\"./image/padrone.png\" alt=\"Per inserire nuovi clienti\"> </a>  </td> <td align=center> <a href=\"newdog.php\"> <img width=80% src=\"./image/cani.png\" alt=\"Per inserire un nuovo cane\"> </a>  </td> 					<td align=center> <a href=\"communications.php\"> <img width=80% src=\"./image/comm.png\" alt=\"Comunicazioni generali\"> </a>  </td> </tr></table>";
	echo "<table width=90% align=center border=0> <tr align=center> <td align=center> <a href=\"listone.php\"> <img width=80% src=\"./image/list.png\" alt=\"Listino Prezzi\"> </a>  </td> <td align=center> <a href=\"emplin.php\"> <img width=80% src=\"./image/people.png\" alt=\"Registro presenze personale\"> </a>  </td> <td align=center> <a href=\"carnet.php\"> <img width=80% src=\"./image/carnet.png\" alt=\"Gestione Carnet\"> </a>  </td> </tr></table>";
 } else {
	 if ($userkind == 'user') {
	echo "<table width=90% align=center border=0> <tr align=center> <td align=center> <a href=\"incam.php\"> <img width=80% src=\"./image/entrate.png\" alt=\"Per inserire una transazione economica in entrata\"> </a> </td> 	 <td align=center> <a href=\"dogin.php\"> <img width=80% src=\"./image/orari.png\" alt=\"Per registrare ingressi e uscite\"> </a>  </td>				<td align=center> <a href=\"booking.php\"> <img width=80% src=\"./image/booking.png\" alt=\"Prenotazioni\"> </a>  </td> </tr></table>";
	echo "<table width=90% align=center border=0> <tr align=center> <td align=center> <a href=\"newclient.php\"> <img width=80% src=\"./image/padrone.png\" alt=\"Per inserire nuovi clienti\"> </a>  </td> <td align=center> <a href=\"newdog.php\"> <img width=80% src=\"./image/cani.png\" alt=\"Per inserire un nuovo cane\"> </a>  </td> 					<td align=center> <a href=\"communications.php\"> <img width=80% src=\"./image/comm.png\" alt=\"Comunicazioni generali\"> </a>  </td> </tr></table>";
	echo "<table width=60% align=center border=0> <tr align=center> <td align=center> <a href=\"listone.php\"> <img width=80% src=\"./image/list.png\" alt=\"Listino Prezzi\"> </a>  </td> <td align=center> <a href=\"emplin.php\"> <img width=80% src=\"./image/people.png\" alt=\"Registro presenze personale\"> </a>  </td> </tr></table>";
	} else {
		if ($userkind == 'client') {
		echo "<table width=70% align=center border=0> <tr align=center> <td align=center> <td align=center> <a href=\"dogpresence.php\"> <img width=80% src=\"./image/orari.png\" alt=\"Per visualizzare gli ultimi 10 ingressi\"> </a>  </td>									<td align=center> <a href=\"communications2owners.php\"> <img width=80% src=\"./image/comm.png\" alt=\"Comunicazioni generali\"> </a>  </td> </tr></table>";
		echo "<table width=35% align=center border=0> <tr align=center> <td align=center> <a href=\"listonec.php\"> <img width=80% src=\"./image/list.png\" alt=\"Listino Prezzi\"> </a>  </td> </tr></table>";
		echo "<table width=35% align=center border=0> <tr align=center> <td align=center> <a href=\"prenota.php\"> <img width=80% src=\"./image/booking.png\" alt=\"Prenotazioni\"> </a>  </td> </tr></table>";
		} else {
			echo "<h1> Ma tu cosa ci fai qui? </h1>";
		}
	}
  }	
 }
 
 
//  <h2 align=center>Per inserire una transazione economica in <a href="incam.php">entrata</a><h2>
//  <h2 align=center>Per inserire una transazione economica in <a href="paimento.php">uscita </a><h2>
//  <h2 align=center>Per inserire un cane che entra in asilo <a href="dogin.php">oggi </a><h2>
//  <h2 align=center>Per inserire <a href="communications.php"> messaggi e comunicazioni  </a><h2>
//  <br><br>
//  <h2 align=center><a href="newclient.php">Per inserire un nuovo Padrone </a><h2>
//  <h2 align=center><a href="newdog.php">Per inserire un nuovo Cane </a><h2>
//  <h2 align=center><a href="fattone.php">Per generare fatture </a><h2>
//    <h2 align=center><a href="fattone.php">Listino prezzi </a><h2>
	echo "	<br><br><br><br>";
						

 if (($userkind == 'superuser') || ($userkind == 'user')) {

	echo "	<h2 align=center>Elenco Cani attualmente inseriti ( Nome e razza )<h2>";
	echo "	<table align=center border=2> <tr> <td> ID Cane </td> <td> Nome Cane </td> <td> Razza </td> <td> Cognome Padrone </td> <td> Id Padrone </td> <td> Modifica </td></tr> ";
						$tbl_name="libdog_Anagrafica_Cani"; // Table name 
//Connect to the server and select the database
						mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
						mysql_select_db("$db_name") or die ("cannot select DB");
	
						$sql = "SELECT  `idlibdog_Anagrafica_Cani` , b.`name` ,  `breed` ,  `family`, `libdog_Anagrafica_Clienti_id` FROM  `libdog_Anagrafica_Cani` AS b,  `libdog_Anagrafica_Clienti` AS a WHERE a.`idlibdog_Anagrafica_Clienti` = b.`libdog_Anagrafica_Clienti_id`;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 5) {
									if ($counter == 0) {
										$dogid=$cell;
										}
        							echo "<td><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
							    echo "<td> <a href=\"modifydog.php?ownerid=",$cell,"&dogid=",$dogid,"\">Modifica</a> </td>";
								echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_Anagrafica_Cani')";
						mysql_query($sql2);
						?>
					</table>
				</td>
			</tr>

    </table>
<?php 
 // Chiudo la if per la visualizzazione dei cani 
 }
 ?>
						<h3><a href="logout.php">Exit</a></h3>

						</body>
</html>