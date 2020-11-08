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
		<h1> Liberty Dog - Transazioni in uscita</h1>
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
			$tbl_name="libdog_paga_e_menti"; // Table name 
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Inserisci']) && !empty($_POST['id_fornitore']) 
               && !empty($_POST['importo'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				  // INSERT INTO `uln6tjuc_libdog`.`libdog_paga_e_menti` (`data_trans`, `id_fornitore`,`importo`, `n_fattura`, `descrizione`, `commenti`, `tipologia`, `note`, `privato`) VALUES (...);
					$data_trans=$_POST['data_trans']; 
					$id_fornitore=$_POST['id_fornitore']; 
					$importo=$_POST['importo']; 
					$n_fattura=$_POST['n_fattura']; 
					$descrizione=$_POST['descrizione']; 
					$commenti=$_POST['commenti']; 
					$tipologia=$_POST['tipologia']; 
					$note=$_POST['note']; 
					$privato=$_POST['privato'];

// To protect MySQL injection (more detail about MySQL injection)
					$data_trans = stripslashes($data_trans);
					$id_fornitore = stripslashes($id_fornitore);
					$importo = stripslashes($importo);
					$n_fattura = stripslashes($n_fattura);
					$descrizione = stripslashes($descrizione);
					$commenti = stripslashes($commenti);
					$tipologia = stripslashes($tipologia);
					$note = stripslashes($note);
					$privato = stripslashes($privato);
					$data_trans = mysql_real_escape_string($data_trans);
					$id_fornitore = mysql_real_escape_string($id_fornitore);
					$importo = mysql_real_escape_string($importo);
					$n_fattura = mysql_real_escape_string($n_fattura);
					$descrizione = mysql_real_escape_string($descrizione);
					$commenti = mysql_real_escape_string($commenti);
					$tipologia = mysql_real_escape_string($tipologia);
					$note = mysql_real_escape_string($note);
					$privato = mysql_real_escape_string($privato);

					$arr = explode("-", $id_fornitore, 2);
				    $id_fornitore = $arr[0];
				  
                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_paga_e_menti` (`data_trans`, `id_fornitore`,`importo`, `n_fattura`, `descrizione`, `commenti`, `tipologia`, `note`, `privato`) VALUES ('$data_trans', '$id_fornitore','$importo', '$n_fattura', '$descrizione', '$commenti', '$tipologia','$note','$privato');";
				  $msginsert = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_paga_e_menti')";
				  $msglog= mysql_query($sql2);

               }else {
                  $msg = 'Id fornitore e Importo Assenti';
				  echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="paimento.php" method='post' id='login'>
              <table>
			  <tr> <td> <font color=#eeee00> Data Transazione: </font>   </td> 
				<td><font color=#eeee00> Identificativo fornitore: </font> </td>
				<td><font color=#eeee00> Importo: </font></td>  
			  </tr> 
			  <tr> <td> <input type='date' name='data_trans' /></td> 
				<td>          <?php
				$sqlcliente = "SELECT CONCAT(`idlibdog_Anagrafica_Fornitori`,'-',`name`) as fornicatore FROM `libdog_Anagrafica_Fornitori` order by name;";
				$resultcliente = mysql_query($sqlcliente);
						echo "<select name='id_fornitore'> ";
						echo "$resultcliente";
				if ($resultcliente !== FALSE){
					while($row=mysql_fetch_array($resultcliente)){
						$fornicatore = htmlspecialchars ($row["fornicatore"], ENT_COMPAT,'ISO-8859-1', true); 
						echo "<option value='$fornicatore'>$fornicatore</option> ";
						}
					}
				echo "</select> ";
         ?>	 </td> 
				<td> <input type='text' name='importo' /></td>
              </tr>
			  <tr> <td>  <font color=#eeee00> Numero Fattura: </font></td> 
				<td>  <font color=#eeee00> Descrizione: </font></td> 
				<td> <font color=#eeee00> Commenti: </font> </td> 
			  </tr>
			  <tr> <td> <input type='text' name='n_fattura' /> </td>
				<td> <input type='text' name='descrizione' /> </td> 
				<td><input type='text' name='commenti' /></td> 
			  </tr>
			  <tr> <td> <font color=#eeee00> Tipologia: </font> </td>
				<td> <font color=#eeee00> Note: </font> </td>
				<td> <font color=#eeee00> Privato: </font> </td>
			  </tr>
			  <tr> <td>  <select name='tipologia'>
						<option value='Bollette'>Bollette</option>
						<option value='Materiali'>Materiali</option>
						<option value='Magazzino'>Magazzino</option>
						<option value='Varie'>Varie</option>
						</select></td>
				<td> <input type='text' name='note' /> </td>
				<td> <select name='privato'>
						<option value='0'>LiberyDog</option>
						<option value='1'>Privato</option>
						</select></td>
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
						<h2>Pagamenti registrati</h2>
						
					<table align=center border=2> <tr><td>Identificativo</td><td>Data</td><td>Identificativo fornitore</td><td>Denominazione fornitore</td><td>Importo</td><td>N. fattura</td><td>Descrizione</td><td>Commenti</td><td>Tipologia</td><td>Note</td><td>Privato</td></tr>
						<?php 
	
						$sql = "SELECT `id`,`data_trans`, `id_fornitore`,`libdog_Anagrafica_Fornitori`.`name`, `importo`, `n_fattura`, `descrizione`, `commenti`,  `libdog_paga_e_menti`.`tipologia`, `note`, `privato` FROM `libdog_paga_e_menti`, `libdog_Anagrafica_Fornitori` where `libdog_Anagrafica_Fornitori`.`idlibdog_Anagrafica_Fornitori` =  `libdog_paga_e_menti`.`id_fornitore` order by `data_trans` desc;";
						$result = mysql_query($sql);
						$counter=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell) {
        					if ($counter == 0) { 	$idmoney = $cell;	}
							if ($counter < 12) {
        							echo "<td align=center><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								}	
							    echo "<td><a href=\"modifypaiment.php?id_money=",$idmoney,"\"> Modifica </a> </td></tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_libdog_paga_e_menti')";
						mysql_query($sql2);
						?>
					</table>
		<h2> Recap </h2>
					<table align=center border=2> <tr><td>Totale</td><td>Privato</td><td>Mese</td><td>Tipologia</td></tr>
						<?php 
	
//		SELECT sum(`importo`) as totale, `privato`, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `tipologia` FROM `libdog_paga_e_menti` group by `privato`, DATE_FORMAT(`data_trans`,'%Y-%m'), `tipologia`;

		$sqlrecap = "		SELECT sum(`importo`) as totale, `privato`, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `tipologia` FROM `libdog_paga_e_menti` group by `privato`, DATE_FORMAT(`data_trans`,'%Y-%m'), `tipologia`;";
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
						?>
					</table>
		
		<h2> Totali Mensili </h2>
					<table align=center border=2> <tr><td>Totale</td><td>Mese</td><td>Privato</td></tr>
						<?php 
	
//		SELECT sum(`importo`) as totale, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `privato` FROM `libdog_paga_e_menti` group by `privato`, DATE_FORMAT(`data_trans`,'%Y-%m');

		$sqlrecap2 = "		SELECT sum(`importo`) as totale, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `privato` FROM `libdog_paga_e_menti` group by  DATE_FORMAT(`data_trans`,'%Y-%m'),`privato`;";
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
						?>
					</table>

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