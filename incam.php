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
<body>
		<p align=center> <img src="./Liberty-dog.png"> </p>
		<h1> Liberty Dog - Transazioni in entrata</h1>
	<br><br><br><br>
	<p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
         
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

            if (isset($_POST['Inserisci']) && !empty($_POST['id_cliente'])
               && !empty($_POST['importo_fattura'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				  // INSERT INTO `uln6tjuc_libdog`.`libdog_prendi_e_scappa` (`data_trans`, `id_cliente`,`importo_fattura`, `n_fattura`, `descrizione`, `commenti`, `tipologia`, `note`, `privato`, `tipo_pagamento`) VALUES (...);
					$data_trans=$_POST['data_trans']; 
					$id_cliente=$_POST['id_cliente']; 
					$importo_fattura=$_POST['importo_fattura']; 
					$n_fattura=$_POST['n_fattura']; 
					$descrizione=$_POST['descrizione']; 
					$commenti=$_POST['commenti']; 
					$tipologia=$_POST['tipologia']; 
					$note=$_POST['note']; 
					$privato=$_POST['privato'];
					$tipo_pagamento=$_POST['tipo_pagamento'];
					$ric_fat=$_POST['ric_fat'];
					$quantita=$_POST['quantita'];
					

// To protect MySQL injection (more detail about MySQL injection)
					$data_trans = stripslashes($data_trans);
					$id_cliente = stripslashes($id_cliente);
					$importo_fattura = stripslashes($importo_fattura);
					$n_fattura = stripslashes($n_fattura);
					$descrizione = stripslashes($descrizione);
					$commenti = stripslashes($commenti);
					$tipologia = stripslashes($tipologia);
					$note = stripslashes($note);
					$privato = stripslashes($privato);
					$tipo_pagamento = stripslashes($tipo_pagamento);
					$ric_fat = stripslashes($ric_fat);
					$quantita = stripslashes($quantita);
					$data_trans = mysql_real_escape_string($data_trans);
					$id_cliente = mysql_real_escape_string($id_cliente);
					$importo_fattura = mysql_real_escape_string($importo_fattura);
					$n_fattura = mysql_real_escape_string($n_fattura);
					$descrizione = mysql_real_escape_string($descrizione);
					$commenti = mysql_real_escape_string($commenti);
					$tipologia = mysql_real_escape_string($tipologia);
					$note = mysql_real_escape_string($note);
					$privato = mysql_real_escape_string($privato);
					$tipo_pagamento = mysql_real_escape_string($tipo_pagamento);
					$ric_fat = mysql_real_escape_string($ric_fat);
					$quantita = mysql_real_escape_string($quantita);

				  $arrdog = explode("-", $id_cliente);
				  $id_cane = $arrdog[4];
				  $arr = explode("-", $id_cliente, 2);
				  $id_cliente = $arr[0];
				  $arrcar = explode("-", $descrizione);
				  $carne = $arrcar[3];
				  $carid = $arrcar[0];

				  
				  if ($carne>1 && $carne<7) { 
						$sqlcarne1 = "INSERT INTO `uln6tjuc_libdog`.`libdog_carnet_history` (`validita`, `expiration`, `id_cane`, `num_ingressi`, `id_acquisto`, `id_pagamento`) VALUES ( '$data_trans', DATE_ADD('$data_trans', INTERVAL 3 MONTH),'$id_cane', '$carne', '0', '$carid');";
						//echo ( $sqlcarne1 );
						$msginsertcarne1 = mysql_query($sqlcarne1);	
						//echo ( $msginsertcarne1 );
						}
                  if ($carne>6 && $carne<12) { 
						$sqlcarne2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_carnet_history` (`validita`, `expiration`, `id_cane`, `num_ingressi`, `id_acquisto`, `id_pagamento`) VALUES ( '$data_trans', DATE_ADD('$data_trans', INTERVAL 5 MONTH),'$id_cane', '$carne', '0', '$carid');";
						//echo ( $sqlcarne2 );
						$msginsertcarne2 = mysql_query($sqlcarne2);	
						//echo ( $msginsertcarne2 );
						}
				  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_prendi_e_scappa` (`data_trans`, `id_cliente`,`id_cane`,`importo_fattura`, `n_fattura`, `descrizione`, `commenti`, `tipologia`, `note`, `privato`,`tipo_pagamento`,`ric_fat`,`quantita`) VALUES ('$data_trans', '$id_cliente','$id_cane','$importo_fattura', '$n_fattura', '$descrizione', '$commenti', '$tipologia','$note','$privato','$tipo_pagamento','$ric_fat','$quantita');";
				 // echo ( $sql2 );
				  $msginsert = mysql_query($sql2);
				 // echo ( $msginsert );
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_prendi_e_scappa')";
				  $msglog= mysql_query($sql2);

               }else {
                  $msg = 'Id cliente e Importo Assenti';
				  echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="incam.php" method='post' id='login'>
              <table>
			  <tr> <td> <font color=#eeee00> Data Transazione: </font>   </td> 
				<td><font color=#eeee00> Identificativo cliente: </font> </td>
				<td><font color=#eeee00> Importo: </font></td>  
			  </tr> 
			  <tr> <td> <input type='date' name='data_trans' /></td> 
				<td> 
         <?php
				$sqlcliente = "SELECT CONCAT(`idlibdog_Anagrafica_Clienti`,'-',`libdog_Anagrafica_Clienti`.`name`,'-',`libdog_Anagrafica_Clienti`.`family`,'-',`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`) as clio FROM `libdog_Anagrafica_Clienti`, `libdog_Anagrafica_Cani` where `libdog_Anagrafica_Clienti`.`idlibdog_Anagrafica_Clienti`=`libdog_Anagrafica_Cani`.`libdog_Anagrafica_Clienti_id` order by `libdog_Anagrafica_Cani`.`name`;";
				$resultcliente = mysql_query($sqlcliente);
						echo "<select name='id_cliente'> ";
						echo "$resultcliente";
				if ($resultcliente !== FALSE){
					while($row=mysql_fetch_array($resultcliente)){
						$clio = htmlspecialchars ($row["clio"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$clio'>$clio</option> ";
						}
					}
				echo "</select> ";
         ?>				
 </td> 
				<td> <input type='text' name='importo_fattura' /></td>
              </tr>
			  <tr> <td>  <font color=#eeee00> Numero Ricevuta o Fattura: </font></td> 
				<td>  <font color=#eeee00> Descrizione: </font>
				</td> 
				<td> <font color=#eeee00> Commenti: </font> </td> 
			  </tr>
			  <tr> <td> <input type='text' name='n_fattura' /> </td>
				<td> 
		<?php
				$sqldesc = "SELECT CONCAT(`id`,'-',`descrizione`,'-',`tipologia`,'-',`carnet`) as descr FROM `libdog_tariffario_all` order by carnet desc, tipologia, id;";
				$resultdesc = mysql_query($sqldesc);
						echo "<select name='descrizione'> ";
				if ($resultdesc !== FALSE){
					while($rowdesc=mysql_fetch_array($resultdesc)){
						$descr = htmlspecialchars ($rowdesc["descr"], ENT_QUOTES);
						echo "<option value='$descr'>$descr</option> ";
						}
					}
				echo "</select> ";
         ?>	
		 </td> 
				<td><input type='text' name='commenti' /></td> 
			  </tr>
			  <tr> <td> <font color=#eeee00> Tipologia: </font> </td>
				<td> <font color=#eeee00> Note: </font> </td>
				<td> <font color=#eeee00> Privato: </font> </td>
			  </tr>
			  <tr> <td> <select name='tipologia'>
						<option value='Cibo'>Cibo</option>
						<option value='Asilo'>Asilo</option>
						<option value='Accessori'>Accessori</option>
						<option value='Giochi'>Giochi</option>
						</select> </td>
				<td> <input type='text' name='note' /> </td>
				<td> <select name='privato'>
						<option value='0'>LibertyDog</option>
						<option value='1'>Privato</option>
						</select> </td>
			  </tr>
			  <tr> 				<td> <font color=#eeee00> Quantit&agrave;: </font> </td>
				<td> <font color=#eeee00> Tipo Pagamento: </font> </td>
				<td>  <font color=#eeee00> Ricevuta o Fattura </font> </td>
							  </tr>
			  <tr> <td> <input type='number' name='quantita' /> </td>
				<td> <select name='tipo_pagamento'>
						<option value='Contanti'>Contanti</option>
						<option value='Bonifico'>Bonifico</option>
						<option value='Bancomat'>Bancomat</option>
						<option value='CartaCredito'>Carta di credito</option>
						<option value='Assegno'>Assegno</option>
						<option value='BuoniVari'>Buoni vari</option>
						<option value='PayPal'>PayPal</option>
						</select>
						</td>
				<td> <select name='ric_fat'>
						<option value='Ricevuta'>Ricevuta</option>
						<option value='Fattura'>Fattura</option>
						</select> </td>
			  </tr>
			  
              <tr>  <td></td> 
			  <td><input type='submit' name = "Inserisci" value='Inserisci' /></td> 
			  <td></td> </tr>
			  </table>
            </form>
        	</div>
			</td></tr>
		</table>
  </p>
						<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>
						<?php 

if ($userkind == 'teamleader') {
				echo "<h2>Pagamenti registrati</h2>";
						
				echo "	<table align=center border=2> <tr><td>Identificativo</td><td>Data</td><td>Nome Cane</td><td>Razza Cane</td><td>Cognome Padrone</td><td>Importo</td><td>Quantit&agrave;</td><td>N. fattura</td><td>Descrizione</td><td>Commenti</td><td>Tipologia</td><td>Tipo pagamento</td><td>Note</td><td>Privato</td></tr>";

	
						$sql = "SELECT `id`,`data_trans`, `libdog_Anagrafica_Cani`.`name`, `libdog_Anagrafica_Cani`.`breed`,`libdog_Anagrafica_Clienti`.`family`,`importo_fattura`, `quantita`, `n_fattura`, `descrizione`, `commenti`, `tipologia`, `tipo_pagamento`,`note`, `privato`  FROM `libdog_prendi_e_scappa` , `libdog_Anagrafica_Cani`, `libdog_Anagrafica_Clienti`  where `libdog_Anagrafica_Clienti_id` = `id_cliente` and `libdog_Anagrafica_Clienti`.`idlibdog_Anagrafica_Clienti` = `id_cliente` and `libdog_prendi_e_scappa`.`id_cane`=`libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani` and `data_trans` > CURDATE() - 120 order by `data_trans` desc;";
						$result = mysql_query($sql);
						$counter=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 15) {
        							echo "<td align=center><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
							    echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_libdog_prendi_e_scappa')";
						mysql_query($sql2);
			
				echo "	</table>";
}
						
if ($userkind == 'superuser') {
				echo "<h2>Pagamenti registrati</h2>";
						
				echo "	<table align=center border=2> <tr><td>Identificativo</td><td>Data</td><td>Nome Cane</td><td>Razza Cane</td><td>Cognome Padrone</td><td>Importo</td><td>Quantit&agrave;</td><td>N. fattura</td><td>Descrizione</td><td>Commenti</td><td>Tipologia</td><td>Tipo pagamento</td><td>Note</td><td>Privato</td></tr>";

	
						$sql = "SELECT `id`,`data_trans`, `libdog_Anagrafica_Cani`.`name`, `libdog_Anagrafica_Cani`.`breed`,`libdog_Anagrafica_Clienti`.`family`,`importo_fattura`, `quantita`, `n_fattura`, `descrizione`, `commenti`, `tipologia`, `tipo_pagamento`,`note`, `privato`  FROM `libdog_prendi_e_scappa` , `libdog_Anagrafica_Cani`, `libdog_Anagrafica_Clienti`  where `libdog_Anagrafica_Clienti_id` = `id_cliente` and `libdog_Anagrafica_Clienti`.`idlibdog_Anagrafica_Clienti` = `id_cliente` and `libdog_prendi_e_scappa`.`id_cane`=`libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani` order by `data_trans` desc;";
						$result = mysql_query($sql);
						$counter=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell) {
        					if ($counter == 0) { 	$idmoney = $cell;	}
							if ($counter < 15) {
        							echo "<td align=center><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								}	
							    echo "<td><a href=\"modifyincam.php?id_money=",$idmoney,"\"> Modifica </a> </td></tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_libdog_prendi_e_scappa')";
						mysql_query($sql2);
			
				echo "	</table>";

				echo "	<h2> Recap per Cliente</h2>";
				echo "	<table align=center border=2> <tr><td>Totale</td><td>Padrone</td><td>Mese</td><td>Tipologia</td><td>Cliente</td></tr>";
					
	
//		SELECT sum(`importo_fattura`) as totale, `privato`, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `tipologia`,`id_cliente` FROM `libdog_prendi_e_scappa` group by `privato`, DATE_FORMAT(`data_trans`,'%Y-%m'), `tipologia`, `id_cliente` ;

		$sqlrecap = "SELECT sum(`importo_fattura`) as totale, `libdog_Anagrafica_Clienti`.`family`, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `tipologia`, `id_cliente`  FROM `libdog_prendi_e_scappa`, `libdog_Anagrafica_Clienti` where `libdog_Anagrafica_Clienti`.`idlibdog_Anagrafica_Clienti` = `id_cliente` group by DATE_FORMAT(`data_trans`,'%Y-%m'), `tipologia`, `id_cliente` order by DATE_FORMAT(`data_trans`,'%Y-%m') desc, totale desc;";
						$resultrecap = mysql_query($sqlrecap);
						$counterrecap=0;
						while($rowrecap = mysql_fetch_row($resultrecap)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($rowrecap as $cellrecap)
        					if ($counterrecap < 5) {
        							echo "<td align=center><h3>$cellrecap</h3></td>";
        							$counterrecap++;
        					} else { 
        							echo ""; 
        							}
							    echo "</tr>";
							  $counterrecap=0;
							  }
						mysql_query($sqlrecap);
					
				echo "	</table> ";


				echo "	<h2> Recap </h2>";
				echo "	<table align=center border=2> <tr><td>Totale</td><td>Privato</td><td>Mese</td><td>Tipologia</td></tr>";
					
	
//		SELECT sum(`importo_fattura`) as totale, `privato`, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `tipologia` FROM `libdog_prendi_e_scappa` group by `privato`, DATE_FORMAT(`data_trans`,'%Y-%m'), `tipologia`;

		$sqlrecap = "		SELECT sum(`importo_fattura`) as totale, `privato`, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `tipologia` FROM `libdog_prendi_e_scappa` group by `privato`, DATE_FORMAT(`data_trans`,'%Y-%m'), `tipologia`;";
						$resultrecap = mysql_query($sqlrecap);
						$counterrecap=0;
						while($rowrecap = mysql_fetch_row($resultrecap)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($rowrecap as $cellrecap)
        					if ($counterrecap < 4) {
        							echo "<td align=center><h3>$cellrecap</h3></td>";
        							$counterrecap++;
        					} else { 
        							echo ""; 
        							}
							    echo "</tr>";
							  $counterrecap=0;
							  }
						mysql_query($sqlrecap);
				
			echo "		</table> ";
		
			echo "<h2> Totali Mensili </h2>";
			echo "		<table align=center border=2> <tr><td>Totale</td><td>Mese</td><td>Privato</td></tr>";
						
	
//		SELECT sum(`importo_fattura`) as totale, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `privato` FROM `libdog_prendi_e_scappa` group by `privato`, DATE_FORMAT(`data_trans`,'%Y-%m');

		$sqlrecap2 = "		SELECT sum(`importo_fattura`) as totale, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `privato` FROM `libdog_prendi_e_scappa` group by  DATE_FORMAT(`data_trans`,'%Y-%m'),`privato`;";
						$resultrecap2 = mysql_query($sqlrecap2);
						$counterrecap2=0;
						while($rowrecap2 = mysql_fetch_row($resultrecap2)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($rowrecap2 as $cellrecap2)
        					if ($counterrecap2 < 3) {
        							echo "<td align=center><h3>$cellrecap2</h3></td>";
        							$counterrecap2++;
        					} else { 
        							echo ""; 
        							}
							    echo "</tr>";
							  $counterrecap2=0;
							  }
						mysql_query($sqlrecap2);
					
					echo " </table> ";
	} else {
		if ($userkind == 'user') {
						echo "<h2>Pagamenti odierni</h2>";
						
				echo "	<table align=center border=2> <tr><td>Identificativo</td><td>Data</td><td>Identificativo cliente</td><td>Importo</td><td>N. fattura</td><td>Descrizione</td><td>Commenti</td><td>Tipologia</td><td>Note</td><td>Privato</td><td>Tipo pagamento</td><td>Ricevuta o Fattura</td><td>Quantit&agrave;</td></tr>";

	
						$sql = "SELECT `id`,`data_trans`, `id_cliente`,`importo_fattura`, `n_fattura`, `descrizione`, `commenti`, `tipologia`, `note`, `privato`,`tipo_pagamento`,`ric_fat`,`quantita` FROM `libdog_prendi_e_scappa` where `data_trans`=CURDATE();";
						$result = mysql_query($sql);
						$counter=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 14) {
        							echo "<td align=center><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
							    echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_libdog_prendi_e_scappa')";
						mysql_query($sql2);
			
				echo "	</table>";	
				
								echo "	<table align=center border=2> <tr><td>Importo</td><td>Tipologia</td><td>Privato</td><td>Tipo pagamento</td></tr>";

	
						$sql = "SELECT sum(`importo_fattura`) as 'Importo', `tipologia`, `privato`,`tipo_pagamento` FROM `libdog_prendi_e_scappa` where `data_trans`=CURDATE() group by `tipologia`, `privato`,`tipo_pagamento`;";
						$result = mysql_query($sql);
						$counter=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 5) {
        							echo "<td align=center><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
							    echo "</tr>";
							  $counter=0;
							  }

			
				echo "	</table>";
						}
	}	
?>	
					
					<h6>
 		<?php 
			echo ( $msginsert );
		?>
		</h6>
		<h6>
 		<?php 
			echo ( $msglog );
		?>
		</h6>
</body>
</html>