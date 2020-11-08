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
		$id_book = $_GET['id'];	
		$getcalendaridfromdb = mysqli_fetch_assoc(mysqli_query($link, "SELECT calendar FROM libdog_presenze_day WHERE id_day = '$id_book'")); 
		$calendaridfromdb = $getcalendaridfromdb['calendar'];
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
		<h1> Liberty Dog - Data entry</h1>
	<br><br><br><br>
	<p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
     <h1> Vorrei modificare i dati di : 
<?php 
		echo $id_book
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
				//	$id_day=$_POST['id_day']; 
					$giorno=$_POST['giorno']; 
					$id_cane=$_POST['id_cane']; 
					$id_pagamento=$_POST['id_pagamento']; 
					$note=$_POST['note']; 
					$intime=$_POST['intime']; 
					$outtime=$_POST['outtime']; 
					$trasporto=$_POST['trasporto'];
					
// To protect MySQL injection (more detail about MySQL injection)
				//	$id_day = stripslashes($id_day);
					$giorno = stripslashes($giorno);
					$id_cane = stripslashes($id_cane);
					$id_pagamento = stripslashes($id_pagamento);
					$note = stripslashes($note);
					$intime = stripslashes($intime);
					$outtime = stripslashes($outtime);
					$trasporto = stripslashes($trasporto);
				//	$id_day = mysql_real_escape_string($id_day);
					$giorno = mysql_real_escape_string($giorno);
					$id_cane = mysql_real_escape_string($id_cane);
					$id_pagamento = mysql_real_escape_string($id_pagamento);
					$note = mysql_real_escape_string($note);
					$intime = mysql_real_escape_string($intime);
					$outtime = mysql_real_escape_string($outtime);
					$trasporto = mysql_real_escape_string($trasporto);
				
				//Put here the authentication part of the code
					//Autoloader di Composer, gestisce la corretta
					//inclusione della libreria Google Client API
					include("vendor/autoload.php");
					try
					{
						$client = new Google_Client();
						// Il metodo suggerito dalla documentazione è quello di
						// inserire le credenziali dentro una variabile di ambiente
						putenv("GOOGLE_APPLICATION_CREDENTIALS=include/g_api_auth_data.json");
						$client->useApplicationDefaultCredentials();
						$client->setApplicationName("InsertDog");
						$httpClient = $client->authorize();
						// E" anche variato il modo di indicare gli “scopes”
						$scopes = implode(" ", array(Google_Service_Calendar::CALENDAR,Google_Service_Calendar::CALENDAR));
						$client->setScopes($scopes);
						$service = new Google_Service_Calendar($client);
				
						//echo "calendaridfromdb:".$calendaridfromdb;
						
						$event = $service->events->get("asilolibertydog@gmail.com",$calendaridfromdb);
						
						$date = new DateTime($giorno);
						$dateout = new DateTime($giorno);
						$ore=substr($intime, 0, 2);
						$minuti=substr($intime, -2, 2);
						date_time_set($date,$ore,$minuti);
						$startDate = date_format($date,"Y-m-d")."T".date_format($date,"H:i:s")."+02:00";
						if ($outtime == "") {
							$oreout="19";
							$minutiout="30";
							$dateout->setTime($oreout,$minutiout);
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+02:00";
						} else {
							$dateout = new DateTime($giorno);
							$oreout=substr($outtime, 0, 2);
							$minutiout=substr($outtime, -2, 2);;
							$dateout->setTime($oreout,$minutiout);
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+02:00";
							}

							
						//Let’s update the start time…
						$start = new Google_Service_Calendar_EventDateTime();
						$start->setDateTime($startDate);
						$start->setTimeZone("Europe/Rome");
						$event->setStart($start);

						//… and the end time
						$end = new Google_Service_Calendar_EventDateTime();
						$end->setDateTime($endDate);
						$end->setTimeZone("Europe/Rome");
						$event->setEnd($end);

						//Store the new event properties
						$service->events->update("asilolibertydog@gmail.com",$calendaridfromdb,$event);

					} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
				
                  $sql1 = "UPDATE `uln6tjuc_libdog`.`libdog_presenze_day` SET `intime`='$intime',`outtime`='$outtime', `note`='$note', `trasporto`='$trasporto' WHERE `id_day`='$id_book';";
				//  echo ( $sql1 );
				  $msgupdateentry = mysql_query($sql1);
			//	  echo ($msgupdateentry);
				  $myusername = $_SESSION['myusername'] ;
				  $sql3 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','update_presenze_day_booking')";
				  $msglog= mysql_query($sql3);
				  
               }

			   
			   
            if (isset($_POST['Elimina'])  ) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				//	$id_day=$_POST['id_day']; 
					$giorno=$_POST['giorno']; 
					$id_cane=$_POST['id_cane']; 
					$id_pagamento=$_POST['id_pagamento']; 
					$note=$_POST['note']; 
					$intime=$_POST['intime']; 
					$outtime=$_POST['outtime']; 
					$trasporto=$_POST['trasporto'];
					
// To protect MySQL injection (more detail about MySQL injection)
				//	$id_day = stripslashes($id_day);
					$giorno = stripslashes($giorno);
					$id_cane = stripslashes($id_cane);
					$id_pagamento = stripslashes($id_pagamento);
					$note = stripslashes($note);
					$intime = stripslashes($intime);
					$outtime = stripslashes($outtime);
					$trasporto = stripslashes($trasporto);
				//	$id_day = mysql_real_escape_string($id_day);
					$giorno = mysql_real_escape_string($giorno);
					$id_cane = mysql_real_escape_string($id_cane);
					$id_pagamento = mysql_real_escape_string($id_pagamento);
					$note = mysql_real_escape_string($note);
					$intime = mysql_real_escape_string($intime);
					$outtime = mysql_real_escape_string($outtime);
					$trasporto = mysql_real_escape_string($trasporto);
				
				//Put here the authentication part of the code
					//Autoloader di Composer, gestisce la corretta
					//inclusione della libreria Google Client API
					include("vendor/autoload.php");
					try
					{
						$client = new Google_Client();
						// Il metodo suggerito dalla documentazione è quello di
						// inserire le credenziali dentro una variabile di ambiente
						putenv("GOOGLE_APPLICATION_CREDENTIALS=include/g_api_auth_data.json");
						$client->useApplicationDefaultCredentials();
						$client->setApplicationName("InsertDog");
						$httpClient = $client->authorize();
						// E" anche variato il modo di indicare gli “scopes”
						$scopes = implode(" ", array(Google_Service_Calendar::CALENDAR,Google_Service_Calendar::CALENDAR));
						$client->setScopes($scopes);
						$service = new Google_Service_Calendar($client);
				
						//echo "calendaridfromdb:".$calendaridfromdb;
						
						$event = $service->events->get("asilolibertydog@gmail.com",$calendaridfromdb);
						
						// Remove from calendar
						// to be done

						//Store the new event properties
						// $service->events->update("asilolibertydog@gmail.com",$calendaridfromdb,$event);

					} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
				
                  $sql1 = "delete from `uln6tjuc_libdog`.`libdog_presenze_day` WHERE `id_day`='$id_book';";
				//  echo ( $sql1 );
				  $msgupdateentry = mysql_query($sql1);
			//	  echo ($msgupdateentry);
				  $myusername = $_SESSION['myusername'] ;
				  $sql3 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','cancella_presenze_day_booking')";
				  $msglog= mysql_query($sql3);
				  
               }
         ?>
      </div> <!-- /container -->			   
      <?php
		$sql6 = "SELECT book.*, cane.name as cane, paga.descrizione as pagamento FROM `uln6tjuc_libdog`.`libdog_presenze_day` as book, `uln6tjuc_libdog`.`libdog_Anagrafica_Cani` as cane, `uln6tjuc_libdog`.`libdog_tariffario_all` as paga WHERE  `id_day`='$id_book' and id_cane = cane.idlibdog_Anagrafica_Cani and id_pagamento = paga.id;";
			$resultentry = mysql_query($sql6);
			while($row = mysql_fetch_array($resultentry)){
			?>
      <div class = "container">
        	<div id='loginform'>
            <form action="prenotazioni.php?id=<?php echo $id_book ?>" method='post' id='login'>
			  <table>
			  <tr> <td> <font color=#eeeeee> Giorno: </font>   </td> 
				<td> <font color=#eeeeee> Cane: </font> </td>
				<td><font color=#eeee00> Orario Entrata: </font></td>  
			  </tr> 
			  <tr> <td bgcolor=#aaaa00> <input type='date' name='giorno' value="<?php echo $row['giorno']; ?>"/></td> 
				<td bgcolor=#aaaa00> <input type='text' name='cane' value="<?php echo $row['cane']; ?>"/> </td> 
				<td> <input type='time' name='intime' value="<?php echo $row['intime']; ?>"/></td>
              </tr>
			  <tr> <td>  <font color=#eeee00> Trasporto: </font>  </td>
				<td> <font color=#eeee00> Orario Uscita: </font> </td>
 				<td> <font color=#eeee00> Note: </font> </td>
			  </tr>
			  <tr> <td><input type='text' name='trasporto' value="<?php echo $row['trasporto']; ?>"/>  </td>
			    <td> <input type='time' name='outtime' value="<?php echo $row['outtime']; ?>"/> </td>
				<td> <input type='text' name='note' value="<?php echo $row['note']; ?>"/> </td>
			  </tr>
			  <tr>  
					<td> <font color=#eeeeee> Pagamento: </font></td> 
					<td> </td> 
					<td><input type='submit' name = "Modifica" value='Modifica' /></td> 
				</tr>
			  <tr>  
					<td bgcolor=#aaaa00> <input type='pagamento' name='pagamento' value="<?php echo $row['pagamento']; ?>"/> </td> 
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
	echo "<h4><a href=\"doginplus.php\">Return to Orari</a></h4> <br> <h6>";
 } else {
	 if ($userkind == 'user') {
	echo "<h4><a href=\"dogin.php\">Return to Orari</a></h4> <br><br><br><br><h6>";
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

