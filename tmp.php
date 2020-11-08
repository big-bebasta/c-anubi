<?php
	openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_LOCAL0);
// log the attempt
	$access = date("Y/m/d H:i:s");
	syslog(LOG_WARNING, "Login attempt: $access {$_SESSION['myusername']}");
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

            if (isset($_POST['Inserisci']) && !empty($_POST['giorno']) ) {
					$giorno=$_POST['giorno']; 
					$intime=$_POST['intime']; 
					$outtime=$_POST['outtime']; 

// To protect MySQL injection (more detail about MySQL injection)
					$giorno = stripslashes($giorno);
					$intime = stripslashes($intime);
					$outtime = stripslashes($outtime);
					$giorno = mysql_real_escape_string($giorno);
					$intime = mysql_real_escape_string($intime);
					$outtime = mysql_real_escape_string($outtime);


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
						
						//First of all, let’s convert the date and time stored in
						//$_POST[‘dateAndHour’] in a RFC 3339 compliant string, then set
						//the end of the event 30 minutes after the beginning
						//echo "$intime";
						$date = new DateTime($giorno);
						$dateout = new DateTime($giorno);
						//echo " Date =  " . $date->format('Y-m-d H:i:s') . "\n"; 
						$ore=substr($intime, 0, 2);
						$minuti=substr($intime, -2, 2);;
						//echo "Ore e Minuti: " . $ore . " " . $minuti . "\n";
						$date->setTime($ore,$minuti);
						//echo $date->format('Y-m-d H:i:s') . "\n";
						$startDate = strftime('%Y-%m-%dT%H:%M:%S',$date->format('Y-m-d H:i:s'));
						if ($outtime == "") {
							$oreout="23";
							$minutiout="59";
							$dateout->setTime($oreout,$minutiout);
							$endDate = strftime('%Y-%m-%dT%H:%M:%S',$dateout->format('Y-m-d H:i:s'));
						} else {
							$dateout = new DateTime($giorno);
							$oreout=substr($outtime, 0, 2);
							$minutiout=substr($outtime, -2, 2);;
							$dateout->setTime($oreout,$minutiout);
							// echo $dateout->format('Y-m-d H:i:s') . "\n";
							$endDate = strftime("%Y-%m-%dT%H:%M:%S", $dateout->format('Y-m-d H:i:s'));
							}
						//echo " Ok set up delle date \n" ;
						
						$event = new Google_Service_Calendar_Event();
						//echo " Ok set up di event \n" ;
						//Set the summary (= the text shown in the event)
						$event->setSummary("Prova 1");
						//echo " Ok set up di Summary \n" ;
						//Set the place of the event
						$event->setLocation("Asilo");
						echo " Ok set up di location \n" ;
						//Set the beginning of the event
						$start = new Google_Service_Calendar_EventDateTime();
						$start->setDateTime($startDate);
						$start->setTimeZone("Europe/Rome");
						echo " Ok set up di start \n" ;
						$event->setStart($start);
						echo " Ok set up di event con start \n" ;
						//Set the end of the event
						$end = new Google_Service_Calendar_EventDateTime();
						$end->setDateTime($endDate);
						$end->setTimeZone("Europe/Rome");
						$event->setEnd($end);
						//Let’s add the event to the calendar
						$createdEvent = $service->events->insert("asilolibertydog@gmail.com",$event);
						//Show the ID of the created event
						echo "< div >".$createdEvent->getId()."< /div >";
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
						

               }else {
                  $msg = 'Id Cane e Giorno';
				  echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="tmp.php" method='post' id='login'>
              <table>
			  <tr> <td> <font color=#eeee00> Giorno: </font>   </td> 
			  <td></td> 
			  <td></td> 
			  </tr> 
			  <tr> <td> <input type='date' name='giorno' /></td> 
			  <td></td> 
			  <td></td> 
              </tr>
			  <tr> <td>  <font color=#eeee00> Orario Entrata: </font></td> 
				<td>  <font color=#eeee00> Orario Uscita: </font></td> 
			  <td></td> 
			  </tr>
			  <tr> <td> <input type='time' name='intime' /> </td>
				<td> <input type='time' name='outtime' /> </td> 
			  <td></td> 
			  </tr>
			  <td></td> 
			  <td></td> </tr>
              <tr>  			  <td></td> 
			  <td><input type='submit' name = "Inserisci" value='Inserisci' /></td> 
			  <td></td> </tr>
			  </table>
            </form>
        	</div>
			</td></tr>
		</table>
  </p>

					

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