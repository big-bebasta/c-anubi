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
		$id_money = $_GET['id_money'];	
		$getdata_transfromdb = mysqli_fetch_assoc(mysqli_query($link, "SELECT data_trans FROM libdog_paga_e_menti WHERE id = '$id_money'")); 
		$data_transfromdb = $getdata_transfromdb['data_trans'];
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
     <h1> Vorrei modificare i dati di : 
<?php 
		echo $id_money;
		echo " inserita il ";
		echo $data_transfromdb;
		?> 
		</h1>
		
         <?php
            $msg = '';

//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Modifica'])  ) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
					$data_trans=$_POST['data_trans']; 
					$data_trans = stripslashes($data_trans);
					$data_trans = mysql_real_escape_string($data_trans);
					$id_fornitore=$_POST['id_fornitore']; 
					$id_fornitore = stripslashes($id_fornitore);
					$id_fornitore = mysql_real_escape_string($id_fornitore);
					$importo_fattura=$_POST['importo_fattura']; 
					$importo_fattura = stripslashes($importo_fattura);
					$importo_fattura = mysql_real_escape_string($importo_fattura);
					$n_fattura=$_POST['n_fattura']; 
					$n_fattura = stripslashes($n_fattura);
					$n_fattura = mysql_real_escape_string($n_fattura);
					$descrizione=$_POST['descrizione']; 
					$descrizione = stripslashes($descrizione);
					$descrizione = mysql_real_escape_string($descrizione);
					$commenti=$_POST['commenti']; 
					$commenti = stripslashes($commenti);
					$commenti = mysql_real_escape_string($commenti);
					$tipologia=$_POST['tipologia']; 
					$tipologia = stripslashes($tipologia);
					$tipologia = mysql_real_escape_string($tipologia);
					$note=$_POST['note']; 
					$note = stripslashes($note);
					$note = mysql_real_escape_string($note);
					$privato=$_POST['privato']; 
					$privato = stripslashes($privato);
					$privato = mysql_real_escape_string($privato);

				  $sql1 = "UPDATE `uln6tjuc_libdog`.`libdog_paga_e_menti` SET `importo_fattura`='$importo_fattura', `n_fattura`='$n_fattura', `descrizione`='$descrizione', `commenti`='$commenti', `tipologia`='$tipologia', `note`='$note', `privato`='$privato' WHERE `id`='$id_money';";
				  //echo ( $sql1 );
				  $msgupdateentry = mysql_query($sql1);
				  //echo ($msgupdateentry);
				  $myusername = $_SESSION['myusername'] ;
				  $sql3 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','update_paga_e_menti')";
				  $msglog= mysql_query($sql3);
				  
               }

			   
			   
            if (isset($_POST['Elimina'])  ) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();

                  $sql1 = "delete from `uln6tjuc_libdog`.`libdog_paga_e_menti` WHERE `id`='$id_money';";
				//  echo ( $sql1 );
				  $msgupdateentry = mysql_query($sql1);
			//	  echo ($msgupdateentry);
				  $myusername = $_SESSION['myusername'] ;
				  $sql3 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','cancella_paga_e_menti')";
				  $msglog= mysql_query($sql3);
				  
               }
         ?>
      </div> <!-- /container -->			   
      <?php
		$sql6 = "SELECT money.*, concat(forni.idlibdog_Anagrafica_Fornitori,' ',forni.name) as fornitore FROM `uln6tjuc_libdog`.`libdog_paga_e_menti` as money, `uln6tjuc_libdog`.`libdog_Anagrafica_Fornitori` as forni WHERE  `id`='$id_money' and `id_fornitore` = forni.idlibdog_Anagrafica_Fornitori;";
			$resultentry = mysql_query($sql6);
			while($row = mysql_fetch_array($resultentry)){
			?>
      <div class = "container">
        	<div id='loginform'>
            <form action="modifypaiment.php?id_money=<?php echo $id_money ?>" method='post' id='login'>
			  <table>
			  <tr> <td bgcolor=#aaaa00> <font color=#eeee00> Giorno: </font>   </td> 
				<td bgcolor=#aaaa00> <font color=#eeee00> Fornitore: </font> </td>
				<td>&nbsp;</td>  
			  </tr> 
			  <tr> <td bgcolor=#aaaa00> <input type='text' name='data_trans' value="<?php echo $row['data_trans']; ?>"/></td> 
				<td bgcolor=#aaaa00> <input type='text' name='id_fornitore' value="<?php echo $row['fornitore']; ?>"/> </td> 
				<td> &nbsp;</td>
              </tr>
			  <tr> <td>  <font color=#eeee00> Importo fattura: </font>  </td>
				<td> <font color=#eeee00> Numero fattura: </font> </td>
 				<td> <font color=#eeee00> Descrizione: </font> </td>
			  </tr>
			  <tr> <td><input type='text' name='importo_fattura' value="<?php echo $row['importo']; ?>"/>  </td>
			    <td> <input type='text' name='n_fattura' value="<?php echo $row['n_fattura']; ?>"/> </td>
				<td> <input type='text' name='descrizione' value="<?php echo $row['descrizione']; ?>"/> </td>
			  </tr>
			  <tr> <td>  <font color=#eeee00> Commenti: </font>  </td>
				<td> <font color=#eeee00> Tipologia: </font> </td>
 				<td> <font color=#eeee00> Note: </font> </td>
			  </tr>
			  <tr> <td><input type='text' name='commenti' value="<?php echo $row['commenti']; ?>"/>  </td>
			    <td> <input type='text' name='tipologia' value="<?php echo $row['tipologia']; ?>"/> </td>
				<td> <input type='text' name='note' value="<?php echo $row['note']; ?>"/> </td>
			  </tr>
			  <tr> <td>  <font color=#eeee00> Privato: </font>  </td>
				<td> &nbsp; </td>
 				<td> &nbsp; </td>
			  </tr>
			  <tr> <td><input type='text' name='privato' value="<?php echo $row['privato']; ?>"/>  </td>
			    <td> &nbsp; </td>
				<td> &nbsp; </td>
			  </tr>
			  <tr>  
					<td> </td> 
					<td> </td> 
					<td><input type='submit' name = "Modifica" value='Modifica' /></td> 
				</tr>
			  <tr>  
					<td>  </td> 
					<td><input type='submit' name = "Elimina" value='Elimina' /></td> 
					<td> </td> 
				</tr>
			  </table>
            </form>
        	</div>
			</div>
		<?php
			} //Close while{} loop
        ?>
			</td></tr>
		</table>
  </p>

						<h4><a href="login_success.php">Return to Menu</a></h4> <br>
<?php 
 if ($userkind == 'superuser' || $userkind == 'teamleader') {
	echo "<h4><a href=\"paimento.php\">Return to Uscite</a></h4> <br> <h6>";
 } else {
	 if ($userkind == 'user') {
	echo "<h4><a href=\"paimento.php\">Return to Uscite</a></h4> <br><br><br><br><h6>";
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

