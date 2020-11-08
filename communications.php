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
    		    <h1> Liberty Dog - Comunicazioni</h1>
				<h3>  
					<?php
					$msg = "Benvenuta ".  $_SESSION['myusername'];
					echo ( $msg );
				?>
  <br>

				</h3>
</td> </tr> </table>
<br>

														
							<h2> Inserisci una comunicazione</h2> 
							
	<p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
	<?php 						
//Connect to the server and select the database
		mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
		mysql_select_db("$db_name") or die ("cannot select DB");

		if (isset($_POST['Inserisci']) && !empty($_POST['testo']) 
               && !empty($_POST['inserita'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				    $inserita=$_POST['inserita']; 
					$testo=$_POST['testo']; 
					$destinatario=$_POST['destinatario']; 
					$risposta=$_POST['risposta']; 
					$categoria=$_POST['categoria']; 
					$id_cane=$_POST['id_cane']; 
					$valida_fino_a=$_POST['valida_fino_a']; 

// To protect MySQL injection (more detail about MySQL injection)
					$inserita = stripslashes($inserita);
					$testo = stripslashes($testo);
					$destinatario = stripslashes($destinatario);
					$risposta = stripslashes($risposta);
					$categoria = stripslashes($categoria);
					$id_cane = stripslashes($id_cane);
					$valida_fino_a = stripslashes($valida_fino_a);
					$inserita = mysql_real_escape_string($inserita);
					$testo = mysql_real_escape_string($testo);
					$destinatario = mysql_real_escape_string($destinatario);
					$risposta = mysql_real_escape_string($risposta);
					$categoria = mysql_real_escape_string($categoria);
					$id_cane = mysql_real_escape_string($id_cane);
					$valida_fino_a = mysql_real_escape_string($valida_fino_a);
					
					$arr = explode("-", $id_cane, 2);
				    $id_cane = $arr[0];
				  
                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_comunic_azioni` (`inserita`, `testo`,`destinatario`, `risposta`, `categoria`, `id_cane`, `valida_fino_a`) VALUES ('$inserita', '$testo','$destinatario', '$risposta', '$categoria', '$id_cane','$valida_fino_a');";
				  $msginsert = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_comunic_azioni')";
				  $msglog= mysql_query($sql2);

               }else {
                  $msg = 'Testo e data inserimento';
				  echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="communications.php" method='post' id='login'>
              <table align=center border=3>
			  <tr> <td> <font color=#eeee00> Data Inserimento: </font>   </td> 
				<td><font color=#eeee00> Valida fino a: </font> </td>
				<td><font color=#eeee00> Cane coinvolto: </font></td>  
			  </tr> 
			  <tr> <td> <input type='date' name='inserita' /></td> 
			  <td> <input type='date' name='valida_fino_a' /></td> 
				<td>      
				<?php
				$sqldog = "SELECT CONCAT(`idlibdog_Anagrafica_Cani`,'-',`name`,'-',`breed`) as id_cane FROM `libdog_Anagrafica_Cani` order by `name`;";
				$resultdog = mysql_query($sqldog);
						echo "<select name='id_cane'> ";
						// echo "$resultdog";
				if ($resultdog !== FALSE){
					while($row=mysql_fetch_array($resultdog)){
						$id_cane = htmlspecialchars ($row["id_cane"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$id_cane'>$id_cane</option> ";
						}
					}
				echo "<option value='0-Nessuno'>0-Nessuno</option> ";
				echo "</select> ";
         ?>	 </td> 
              </tr>
			  <tr> <td>  <font color=#eeee00> Testo: </font></td> 
				<td>  <font color=#eeee00> Destinatario: </font></td> 
				<td> <font color=#eeee00> Risposta: </font> </td> 
			  </tr>
			  <tr> <td> <input type='text' name='testo' /> </td>
				<td> <select name='destinatario'>
						<option value='Alessia'>Alessia</option>
						<option value='Teamleader'>Teamleader</option>
						<option value='Users'>Users</option>
						<option value='Clienti'>Clienti</option>
						<option value='Tutti'>Tutti</option>
		<?php 	
			if ($userkind == 'superuser') { 
						echo "<option value='Roberto'>Roberto</option>";
			}
			?>
						</select>
				</td> 
				<td><input type='text' name='risposta' /></td> 
			  </tr>
			  <tr> <td> <font color=#eeee00> Categoria: </font> </td>
				<td>  </td>
				<td>  </td>
			  </tr>
			  <tr> <td> <select name='categoria'>
						<option value='Gestione'>Gestione</option>
						<option value='Alimentazione'>Alimentazione</option>
						<option value='Cibo'>Cibo</option>
						<option value='Economiche'>Economiche</option>
		<?php 	
			if ($userkind == 'superuser') { 
						echo "<option value='Alessia'>Alessia</option>";
						echo "<option value='Modifiche Software'>Modifiche Software</option>";
			}
			if ($userkind == 'teamleader') { 
						echo "<option value='Teamleader'>Teamleader</option>";
						echo "<option value='Modifiche Software'>Modifiche Software</option>";
			}
			?>
						</select>
						</td>
				<td>  </td>
				<td> <input type='submit' name = "Inserisci" value='Inserisci' /> </td>
			  </tr>
			  </table>
            </form>
        	</div>
			</td></tr>
		</table>
  </p>
  

<br><br>	

							<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>
							
<table align=center border=0> <tr> <td bgcolor=#aaaaaa> 
						
						 <h2 align=center>Richieste economiche</h2>
						 <h2 align=center>Aperte</h2>
					<table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td><td> Cane </td></tr>
						<?php 
						$tbl_name="libdog_comunic_azioni"; // Table name 
	
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane,`id` FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Economiche' and  `risposta`='' order by `inserita` desc;";
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
        							echo "<td><a href=\"modifyresponse.php?id_comm=",$cell,"\">Modifica risposta</a></td>"; 
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
					 <h2 align=center>Chiuse</h2>
				<table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td> <td> Cane </td><td> Chiusa da </td></tr>
						<?php 
	
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane, `closedby`  FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Economiche' and  `risposta`!='' and `valida_fino_a` >= CURDATE() order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
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
</td>	<td bgcolor=#00ff00>
						 <h2 align=center>Note gestione cani</h2>
						 <h2 align=center>Aperte</h2>
					<table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td><td> Cane </td></tr>
						<?php 
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta` , CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane,`id` FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Gestione' and  `risposta`='' order by `inserita` desc;";
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
        							echo "<td><a href=\"modifyresponse.php?id_comm=",$cell,"\">Modifica risposta</a></td>"; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						?>
					</table>


						<br><br>					 <h2 align=center>Chiuse</h2>
					<table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td> <td> Cane </td> <td> Chiusa da </td></tr>
						<?php 
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane, `closedby`  FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Gestione' and  `risposta`!='' and `valida_fino_a` >= CURDATE() order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
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
						 <h2 align=center>Alimentazione</h2>
						 <h2 align=center>Aperte</h2>
					<table align=center border=2> <tr> <td> Data </td>  <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td><td> Cane </td></tr>
						<?php 
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane,`id` FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Alimentazione' and  `risposta`='' order by `inserita` desc;";
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
        							echo "<td><a href=\"modifyresponse.php?id_comm=",$cell,"\">Modifica risposta</a></td>"; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						?>
					</table>
				
					<br><br> 						 <h2 align=center>Chiuse</h2>
					<table align=center border=2> <tr> <td> Data </td>  <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td><td> Cane </td> <td> Chiusa da </td></tr>
						<?php 
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane, `closedby`  FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and `categoria`='Alimentazione' and  `risposta`!='' and `valida_fino_a` >= CURDATE() order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
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
					<h2 align=center>Forniture Cibo</h2>
							 <h2 align=center>Aperte</h2>
					<table align=center border=2> <tr>  <td> Data </td>  <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td><td> Cane </td></tr>
						<?php 
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane,`id` FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Cibo' and  `risposta`='' order by `inserita` desc;";
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
        							echo "<td><a href=\"modifyresponse.php?id_comm=",$cell,"\">Modifica risposta</a></td>"; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						?>
					</table>
					
					<br><br>	 <h2 align=center>Chiuse</h2>
					<table align=center border=2> <tr>  <td> Data </td>  <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td> <td> Cane </td><td> Chiusa da </td></tr>
						<?php 
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane, `closedby`  FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and `categoria`='Cibo' and `risposta`!='' and `valida_fino_a` >= CURDATE() order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
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
		<?php 	
	 if ($userkind == 'superuser') { 

				echo "	<table align=center><tr><td  align=center bgcolor=#00ff00>  <h2 align=center>Note private</h2>  <h2 align=center>Aperte</h2> <table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td><td> Cane </td></tr>";

						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta` , CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane,`id` FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Alessia' and  `risposta`='' order by `inserita` desc;";
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
        							echo "<td><a href=\"modifyresponse.php?id_comm=",$cell,"\">Modifica risposta</a></td>"; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						
					echo "</table>";


						echo "<br><br>					 <h2 align=center>Chiuse<h2>";
					echo "<table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td> <td> Cane </td> <td> Chiusa da </td></tr>";
					
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane, `closedby`  FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Alessia' and  `risposta`!='' and `valida_fino_a` >= CURDATE() order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
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
						echo " </table></td></tr></table>";


				echo "	<table align=center><tr><td  align=center bgcolor=#00cccc>  <h2 align=center>Modifiche Software</h2>  <h2 align=center>Aperte</h2> <table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td><td> Cane </td></tr>";

						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta` , CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane,`id` FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Modifiche Software' and  `risposta`='' order by `inserita` desc;";
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
        							echo "<td><a href=\"modifyresponse.php?id_comm=",$cell,"\">Modifica risposta</a></td>"; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						
					echo "</table>";


						echo "<br><br>					 <h2 align=center>Chiuse<h2>";
					echo "<table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td> <td> Cane </td> <td> Chiusa da </td></tr>";
					
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane, `closedby`  FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Modifiche Software' and  `risposta`!='' and `valida_fino_a` >= CURDATE() order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
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
						echo " </table></td></tr></table>";


						}


	 if ($userkind == 'teamleader') { 

				echo "	<table align=center><tr><td  align=center bgcolor=#00ff00>  <h2 align=center>Note private</h2>  <h2 align=center>Aperte</h2> <table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td><td> Cane </td></tr>";

						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta` , CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane,`id` FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Teamleader' and  `risposta`='' order by `inserita` desc;";
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
        							echo "<td><a href=\"modifyresponse.php?id_comm=",$cell,"\">Modifica risposta</a></td>"; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						
					echo "</table>";


						echo "<br><br>					 <h2 align=center>Chiuse<h2>";
					echo "<table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td> <td> Cane </td> <td> Chiusa da </td></tr>";
					
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane, `closedby`  FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Teamleader' and  `risposta`!='' and `valida_fino_a` >= CURDATE() order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
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
						echo " </table></td></tr></table>";


				echo "	<table align=center><tr><td  align=center bgcolor=#00cccc>  <h2 align=center>Modifiche Software</h2>  <h2 align=center>Aperte</h2> <table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td><td> Cane </td></tr>";

						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta` , CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane,`id` FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Modifiche Software' and  `risposta`='' order by `inserita` desc;";
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
        							echo "<td><a href=\"modifyresponse.php?id_comm=",$cell,"\">Modifica risposta</a></td>"; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						
					echo "</table>";


						echo "<br><br>					 <h2 align=center>Chiuse<h2>";
					echo "<table align=center border=2> <tr> <td> Data </td> <td> Descrizione </td> <td> Destinatario </td> <td> Risposta </td> <td> Cane </td> <td> Chiusa da </td></tr>";
					
						$sql = "SELECT  `inserita` ,`testo` ,  `destinatario`, `risposta`, CONCAT(`libdog_Anagrafica_Cani`.`name`,'-',`libdog_Anagrafica_Cani`.`breed`) as desc_cane, `closedby`  FROM `libdog_Anagrafica_Cani`,  `libdog_comunic_azioni` WHERE `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani`=`libdog_comunic_azioni`.`id_cane` and  `categoria`='Modifiche Software' and  `risposta`!='' and `valida_fino_a` >= CURDATE() order by `inserita` desc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
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
						echo " </table></td></tr></table>";


						}

						?>
					
					



  
						</body>
</html>