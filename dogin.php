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
		require 'include/config-mysqli.php';
		//////// End of connecting to database ////////
		
		@$dog = $_GET['dog']; // Use this line or below line if register_global is off
		$dogid = $_GET['dog'];
		
		if(strlen($dog) > 0 and !is_numeric($dog)){ // to check if $dog is numeric data or not. 
			echo "Data Error";
			exit;
			}
		}
	?>
<!doctype html public "-//w3c//dtd html 3.2//en">
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
<SCRIPT language=JavaScript>
<!--
function reload(form)
{
var val=form.cat.options[form.cat.options.selectedIndex].value;
self.location='dd-mysqli_mio.php?cat=' + val ;
}
//-->

</script>
</head>
<body>
		<p align=center> <img src="./Liberty-dog.png"> </p>
		<h1> Liberty Dog - Presenze</h1>
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
			$tbl_name="libdog_presenze_day"; // Table name 
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Inserisci']) && !empty($_POST['giorno']) 
               && !empty($_POST['id_cane'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				  // INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_day` (`id_day`, `giorno`,`	id_cane`, `id_pagamento`, `note`, `intime`, `outtime`) VALUES (...);
					$giorno=$_POST['giorno']; 
					$id_cane=$_POST['id_cane']; 
					$id_pagamento=$_POST['id_pagamento']; 
					$intime=$_POST['intime']; 
					$outtime=$_POST['outtime']; 
					$trasporto=$_POST['trasporto'];
					$note=$_POST['note']; 

// To protect MySQL injection (more detail about MySQL injection)
					$giorno = stripslashes($giorno);
					$id_cane = stripslashes($id_cane);
					$id_pagamento = stripslashes($id_pagamento);
					$intime = stripslashes($intime);
					$outtime = stripslashes($outtime);
					$trasporto = stripslashes($trasporto);
					$note = stripslashes($note);
					$giorno = mysql_real_escape_string($giorno);
					$id_cane = mysql_real_escape_string($id_cane);
					$id_pagamento = mysql_real_escape_string($id_pagamento);
					$intime = mysql_real_escape_string($intime);
					$outtime = mysql_real_escape_string($outtime);
					$trasporto = mysql_real_escape_string($trasporto);
					$note = mysql_real_escape_string($note);


				  $arr = explode("-", $id_cane, 2);
				  $id_cane = $arr[0];
				  
				  $arr2 = explode("-", $id_pagamento, 2);
				  $id_pagamento = $arr2[0];
				  
                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_day` (`giorno`,`id_cane`, `id_pagamento`, `intime`, `outtime`,`trasporto`, `note`) VALUES ('$giorno', '$id_cane','$id_pagamento', '$intime', '$outtime','$trasporto','$note');";
				  $msginsert = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_presenze_day')";
				  $msglog= mysql_query($sql2);

               }else {
                  $msg = 'Id Cane e Giorno';
				  echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="dogin.php" method='post' id='login'>
              <table>
			  <tr> <td> <font color=#eeee00> Giorno: </font>   </td> 
				<td><font color=#eeee00> Identificativo cane: </font> </td>
				<td><font color=#eeee00> Tipologia entrata: </font></td>  
			  </tr> 
			  <tr> <td> <input type='date' name='giorno' /></td> 
				<td> 
         <?php
				$sqlcliente = "SELECT CONCAT(`idlibdog_Anagrafica_Cani`,'-',`name`,'-',`breed`) as dog FROM `libdog_Anagrafica_Cani` order by `name`;";
				$resultcliente = mysql_query($sqlcliente);
						echo "<select name='id_cane'> ";
						echo "$resultcliente";
				if ($resultcliente !== FALSE){
					while($row=mysql_fetch_array($resultcliente)){
						$dog = htmlspecialchars ($row["dog"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$dog'>$dog</option> ";
						}
					}
				echo "</select> ";
         ?>				
 </td> 
				<td> 
		<?php
				$sqlpaga = "SELECT CONCAT(`id`,'-',`descrizione`,'-',`tipologia`) as paga FROM `libdog_tariffario_all` where `tipologia` = 'Asilo';";
				$resultpaga = mysql_query($sqlpaga);
						echo "<select name='id_pagamento'> ";
				if ($resultpaga !== FALSE){
					while($rowpaga=mysql_fetch_array($resultpaga)){
						$paga = htmlspecialchars ($rowpaga["paga"], ENT_QUOTES);
						echo "<option value='$paga'>$paga</option> ";
						}
					}
				echo "</select> ";
         ?>	
		 </td>
              </tr>
			  <tr> <td>  <font color=#eeee00> Orario Entrata: </font></td> 
				<td>  <font color=#eeee00> Orario Uscita: </font></td> 
				<td> <font color=#eeee00> Note: </font> </td> 
			  </tr>
			  <tr> <td> <input type='time' name='intime' /> </td>
				<td> <input type='time' name='outtime' /> </td> 
				<td><input type='text' name='note' /></td> 
			  </tr>
              <tr>  <td><font color=#eeee00>Trasporto: </font></td> 
			  <td></td> 
			  <td></td> </tr>
              <tr>  <td><select name='trasporto'>
						<option value='0'>0-Nessuno</option>
						<option value='1'>1-Andata</option>
						<option value='2'>2-Andata e ritorno</option>
						</select></td> 
			  <td><input type='submit' name = "Inserisci" value='Inserisci' /></td> 
			  <td></td> </tr>
			  </table>
            </form>
        	</div>
			</td></tr>
		</table>
  </p>

  						<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>
  
  		<h2> Oggi 
<?php
		
		echo $today
?>		
		ci sono  
<?php
		// SELECT  count(`id_cane`) FROM  `libdog_presenze_day`  WHERE `giorno` = DATE( NOW( ) ) ;
		$queryquanti = "SELECT  count(`id_cane`) as quanti FROM  `libdog_presenze_day`  WHERE `giorno` = DATE( NOW( ) ) ; ";
		// echo $queryquanti;
		$result_quanti = mysql_query($queryquanti);
		$row_quanti = mysql_fetch_row($result_quanti);
		foreach($row_quanti as $cell_quanti)
			if ($counterquanti < 1) {
				echo " $cell_quanti cani.";
        		$counterquanti++;
				}
		mysql_query($queryquanti);
		?>

		</h2>
					<table align=center border=2> <tr><td>Giorno</td><td>Nome Cane</td><td>Razza</td><td>Tipologia</td><td>Entrata</td><td>Uscita</td><td>Note</td><td>Trasporto</td><td>Aggiorna</td></tr>
						<?php 
	
//		SELECT sum(`importo_fattura`) as totale, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `privato` FROM `libdog_paga_e_menti` group by `privato`, DATE_FORMAT(`data_trans`,'%Y-%m');

		$sqlrecap = "SELECT `giorno`,`libdog_Anagrafica_Cani`.`name`,`libdog_Anagrafica_Cani`.`breed`,`libdog_tariffario_all`.`descrizione`,`intime`,`outtime`,`note`,`trasporto`, `libdog_presenze_day`.`id_day`  FROM `libdog_Anagrafica_Cani`,`libdog_tariffario_all`,`libdog_presenze_day` WHERE `libdog_presenze_day`.`id_cane` = `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani` and `libdog_presenze_day`.`id_pagamento` = `libdog_tariffario_all`.`id` and `giorno`=  DATE(NOW())  order by `libdog_Anagrafica_Cani`.`name`;";
						$resultrecap = mysql_query($sqlrecap);
						$counterrecap=0;
						while($rowrecap = mysql_fetch_row($resultrecap)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($rowrecap as $cellrecap)
        					if ($counterrecap < 9) {
        							if ($counterrecap<8) {
										echo "<td align=center><h3>$cellrecap</h3></td>";
									} else {
										echo "<td> <a href=\"modifypresence.php?id_day=",$cellrecap,"\">Modifica uscita e note</a> </td>";
									}
        							$counterrecap++;
        					} else { 
        							echo ""; 
        							}
							    echo "</tr>";
							  $counterrecap=0;
							  }
						mysql_query($sqlrecap);
	// SELECT `giorno`,`libdog_Anagrafica_Cani`.`name`,`libdog_Anagrafica_Cani`.`breed`,`libdog_tariffario_all`.`descrizione` FROM `libdog_Anagrafica_Cani`,`libdog_tariffario_all`,`libdog_presenze_day` WHERE `libdog_presenze_day`.`id_cane` = `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani` and `libdog_presenze_day`.`id_pagamento` = `libdog_tariffario_all`.`id` and `giorno`=  DATE(NOW());

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