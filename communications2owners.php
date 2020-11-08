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
		$getclient_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT client_id FROM voglioentrare WHERE user_name = '$myusername'"));
		$client_id = $getclient_id['client_id'];    
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
    		    <h1> Liberty Dog - Comunicazioni</h1>
				<h3>  
					<?php
					$msg = "Benvenuto/a ".  $_SESSION['myusername'] ;
					echo ( $msg );
				?>
  <br>

				</h3>
</td> </tr> </table>
<br><br><br>	
<table align=center border=0> <tr> <td bgcolor=#aaaaaa> 
						
						 <h2 align=center>Richieste economiche<h2>
					<table align=center border=2> <tr>  <td> Data </td>  <td> Descrizione </td>  <td> Risposta </td></tr>
						<?php 
						$host="mysqlhost"; // Host name 
						$username="uln6tjuc_dataentry"; // Mysql username 
						$password="kN0Tt3n"; // Mysql password 
						$db_name="uln6tjuc_libdog"; // Database name 
						$tbl_name="libdog_comunic_azioni"; // Table name 
//Connect to the server and select the database
						mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
						mysql_select_db("$db_name") or die ("cannot select DB");
	
						$sql = "SELECT  `inserita` ,`testo` , `risposta`  FROM  `libdog_comunic_azioni` as a, `libdog_Anagrafica_Cani` as b WHERE b.`libdog_Anagrafica_Clienti_id`= '$client_id'  and `categoria`='Economiche' and  `valida_fino_a`>=NOW() and `id_cane`=b.`idlibdog_Anagrafica_Cani` and `destinatario`='Clienti' union all SELECT  `inserita` ,`testo` , `risposta`  FROM  `libdog_comunic_azioni` WHERE `destinatario`='Tutti' and  `valida_fino_a`>=NOW()  and `categoria`='Economiche' order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 3) {
									if ($counter == 0) {
										$dogid=$cell;
										}
        							echo "<td><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_communication_all')";
						mysql_query($sql2);
						?>
					</table>

					<br><br>	
	</td>	<td bgcolor=#00ff00>
							 <h2 align=center>Forniture Cibo<h2>
					<table align=center border=2> <tr>  <td> Data </td>  <td> Descrizione </td>  <td> Risposta </td></tr>
						<?php 
						$sql = "SELECT  `inserita` ,`testo` , `risposta`  FROM  `libdog_comunic_azioni` as a, `libdog_Anagrafica_Cani` as b WHERE b.`libdog_Anagrafica_Clienti_id`= '$client_id'  and `categoria`='Cibo' and  `valida_fino_a`>=NOW() and `id_cane`=b.`idlibdog_Anagrafica_Cani` and `destinatario`='Clienti' union all SELECT  `inserita` ,`testo` , `risposta`  FROM  `libdog_comunic_azioni` WHERE `destinatario`='Tutti' and  `valida_fino_a`>=NOW()  and `categoria`='Cibo' order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 3) {
									if ($counter == 0) {
										$dogid=$cell;
										}
        							echo "<td><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						?>
					</table>
					
	
</td></tr>
<tr> <td bgcolor=#00ff00>
						 <h2 align=center>Alimentazione<h2>
					<table align=center border=2><tr>  <td> Data </td>  <td> Descrizione </td>  <td> Risposta </td></tr>
						<?php 
						$sql = "SELECT  `inserita` ,`testo` , `risposta`  FROM  `libdog_comunic_azioni` as a, `libdog_Anagrafica_Cani` as b WHERE b.`libdog_Anagrafica_Clienti_id`=  '$client_id'   and `categoria`='Alimentazione' and  `valida_fino_a`>=NOW() and `id_cane`=b.`idlibdog_Anagrafica_Cani` and `destinatario`='Clienti' union all SELECT  `inserita` ,`testo` , `risposta`  FROM  `libdog_comunic_azioni` WHERE `destinatario`='Tutti' and  `valida_fino_a`>=NOW()  and `categoria`='Alimentazione' order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 3) {
									if ($counter == 0) {
										$dogid=$cell;
										}
        							echo "<td><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						?>
					</table>


</td> <td bgcolor=#aaaaaa>
						 <h2 align=center>Note gestione cani<h2>
					<table align=center border=2> <tr>  <td> Data </td>  <td> Descrizione </td>  <td> Risposta </td></tr>
						<?php 
						$sql = "SELECT  `inserita` ,`testo` , `risposta`  FROM  `libdog_comunic_azioni` as a, `libdog_Anagrafica_Cani` as b WHERE b.`libdog_Anagrafica_Clienti_id`= '$client_id'  and `categoria`='Gestione' and  `valida_fino_a`>=NOW() and `id_cane`=b.`idlibdog_Anagrafica_Cani` and `destinatario`='Clienti' union all SELECT  `inserita` ,`testo` , `risposta`  FROM  `libdog_comunic_azioni` WHERE `destinatario`='Tutti' and  `valida_fino_a`>=NOW()  and `categoria`='Gestione' order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 3) {
									if ($counter == 0) {
										$dogid=$cell;
										}
        							echo "<td><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						?>
					</table>



</td> </tr>
</table>
	<br>
							<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>

														
  
						</body>
</html>