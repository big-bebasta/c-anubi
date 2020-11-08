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
		$id_day = $_GET['id_day'];	
	}
		
	?>
<html>
<head>
	<title>Liberty Dog - Setup Orario</title>
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
		<h1> Liberty Dog - Setup orario personale</h1>
	<br><br><br><br>
 <?php
			if ($userkind = "superuser") {
 ?>
 <p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
         
         <?php
            $msg = '';
			$msginsert1 = '';
			$msglog1 = '';
			$msginsert2 = '';
			$msglog2 = '';
			$msginsert3 = '';
			$msglog3 = '';
			$msginsert4 = '';
			$msglog4 = '';
			$msginsert5 = '';
			$msglog5 = '';
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Inserisci']) && !empty($_POST['giorno']) 
               && !empty($_POST['id_empl1'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				  // INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_empl` (`id_day`, `giorno`,`	id_empl`, `id_pagamento`, `note`, `intime`, `outtime`) VALUES (...);
					$giorno=$_POST['giorno']; 
					$id_empl1=$_POST['id_empl1']; 
					$intime1=$_POST['intime1']; 
					$outtime1=$_POST['outtime1']; 
					$note1=$_POST['note1']; 
					$status1==$_POST['status1'];
					$id_empl2=$_POST['id_empl2']; 
					$intime2=$_POST['intime2']; 
					$outtime2=$_POST['outtime2']; 
					$note2=$_POST['note2']; 
					$status2==$_POST['status2'];
					$id_empl3=$_POST['id_empl3']; 
					$intime3=$_POST['intime3']; 
					$outtime3=$_POST['outtime3']; 
					$note3=$_POST['note3']; 
					$status3==$_POST['status3'];
					$id_empl4=$_POST['id_empl4']; 
					$intime4=$_POST['intime4']; 
					$outtime4=$_POST['outtime4']; 
					$note4=$_POST['note4']; 
					$status4==$_POST['status4'];
					$id_empl5=$_POST['id_empl5']; 
					$intime5=$_POST['intime5']; 
					$outtime5=$_POST['outtime5']; 
					$note5=$_POST['note5']; 
					$status5==$_POST['status5'];

// To protect MySQL injection (more detail about MySQL injection)
					$giorno = stripslashes($giorno);
					$id_empl1 = stripslashes($id_empl1);
					$intime1 = stripslashes($intime1);
					$outtime1 = stripslashes($outtime1);
					$note1 = stripslashes($note1);
					$status1 = stripslashes($status1);
					$id_empl2 = stripslashes($id_empl2);
					$intime2 = stripslashes($intime2);
					$outtime2 = stripslashes($outtime2);
					$note2 = stripslashes($note2);
					$status2 = stripslashes($status2);
					$id_empl3 = stripslashes($id_empl3);
					$intime3 = stripslashes($intime3);
					$outtime3 = stripslashes($outtime3);
					$note3 = stripslashes($note3);
					$status3 = stripslashes($status3);
					$id_empl4 = stripslashes($id_empl4);
					$intime4 = stripslashes($intime4);
					$outtime4 = stripslashes($outtime4);
					$note4 = stripslashes($note4);
					$status4 = stripslashes($status4);
					$id_empl5 = stripslashes($id_empl5);
					$intime5 = stripslashes($intime5);
					$outtime5 = stripslashes($outtime5);
					$note5 = stripslashes($note5);
					$status5 = stripslashes($status5);
					$giorno = mysql_real_escape_string($giorno);
					$id_empl1 = mysql_real_escape_string($id_empl1);
					$intime1 = mysql_real_escape_string($intime1);
					$outtime1 = mysql_real_escape_string($outtime1);
					$note1 = mysql_real_escape_string($note1);
					$status1= mysql_real_escape_string($status1);
					$id_empl2 = mysql_real_escape_string($id_empl2);
					$intime2 = mysql_real_escape_string($intime2);
					$outtime2 = mysql_real_escape_string($outtime2);
					$note2 = mysql_real_escape_string($note2);
					$status2= mysql_real_escape_string($status2);
					$id_empl3 = mysql_real_escape_string($id_empl3);
					$intime3 = mysql_real_escape_string($intime3);
					$outtime3 = mysql_real_escape_string($outtime3);
					$note3 = mysql_real_escape_string($note3);
					$status3= mysql_real_escape_string($status3);
					$id_empl4 = mysql_real_escape_string($id_empl4);
					$intime4 = mysql_real_escape_string($intime4);
					$outtime4 = mysql_real_escape_string($outtime4);
					$note4 = mysql_real_escape_string($note4);
					$status4= mysql_real_escape_string($status4);
					$id_empl5 = mysql_real_escape_string($id_empl5);
					$intime5 = mysql_real_escape_string($intime5);
					$outtime5 = mysql_real_escape_string($outtime5);
					$note5 = mysql_real_escape_string($note5);
					$status5= mysql_real_escape_string($status5);


				  $arr1 = explode("-", $id_empl1, 2);
				  $id_emplungo1=$id_empl1;
				  $id_empl1 = $arr1[0];
				  $arr2 = explode("-", $id_empl2, 2);
				  $id_emplungo2=$id_empl2;
				  $id_empl2 = $arr2[0];
				  $arr3 = explode("-", $id_empl3, 2);
				  $id_emplungo3=$id_empl3;
				  $id_empl3 = $arr3[0];
				  $arr4 = explode("-", $id_empl4, 2);
				  $id_emplungo4=$id_empl4;
				  $id_empl4 = $arr4[0];
				  $arr5 = explode("-", $id_empl5, 2);
				  $id_emplungo5=$id_empl5;
				  $id_empl5 = $arr5[0];
				  
				  if ($id_empl1 > 0 ) {
					  $status1 = '';
					  // Assegno il lable della parte di giornata
					  if (strtotime($intime1) < strtotime("08:35:00") ) { $status1=10; }
					  if (strtotime($intime1) > strtotime("08:35:00") && strtotime($outtime1) < strtotime("15:10:00")) { $status1=11; }
					  if (strtotime($intime1) > strtotime("11:05:00") && strtotime($outtime1) < strtotime("17:40:00")) { $status1=12; }
					  if (strtotime($intime1) > strtotime("13:15:00") && strtotime($outtime1) < strtotime("18:20:00")) { $status1=13; }
					  if (strtotime($intime1) > strtotime("12:00:00") && strtotime($outtime1) > strtotime("18:00:00")) { $status1=14; }
						  
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
						$ore=substr($intime1, 0, 2);
						$minuti=substr($intime1, -2, 2);
						//echo "Ore e Minuti: " . $ore . " " . $minuti . "\n";
						date_time_set($date,$ore,$minuti);
						//echo $date->format('Y-m-d H:i:s') . "\n";
						//echo "date=" .date_format($date, 'Y-m-d H:i:s') . "\n";
						//$startDate = date_format($date, 'Y-m-dTH:i:s');
						$startDate = date_format($date,"Y-m-d")."T".date_format($date,"H:i:s")."+01:00";
						//echo "startDate= $startDate \n" ;
						if ($outtime1 == "") {
							$oreout="19";
							$minutiout="30";
							$dateout->setTime($oreout,$minutiout);
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
						} else {
							$dateout = new DateTime($giorno);
							$oreout=substr($outtime1, 0, 2);
							$minutiout=substr($outtime1, -2, 2);;
							$dateout->setTime($oreout,$minutiout);
							// echo $dateout->format('Y-m-d H:i:s') . "\n";
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
							}
						//echo " Ok set up delle date \n" ;
						//echo " $endDate \n" ;
						
						$event = new Google_Service_Calendar_Event(array( 
							'attendees' => array(array('email' => 'roberto.bedola@gmail.com')), 
							'reminders' => array('useDefault' => FALSE,'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60),array('method' => 'popup', 'minutes' => 15)))
							));
						//echo " Ok set up di event \n" ;
						//Set the summary (= the text shown in the event)
						$event->setSummary("$id_emplungo1");
						//echo " Ok set up di Summary \n" ;
						//Set the place of the event
						$event->setLocation("Asilo");
						//echo " Ok set up di location \n" ;
						//Set the beginning of the event
						$start = new Google_Service_Calendar_EventDateTime();
						$start->setDateTime($startDate);
						$start->setTimeZone("Europe/Rome");
						//echo " Ok set up di start \n" ;
						$event->setStart($start);
						//echo " Ok set up di event con start \n" ;
						//Set the end of the event
						$end = new Google_Service_Calendar_EventDateTime();
						$end->setDateTime($endDate);
						$end->setTimeZone("Europe/Rome");
						$event->setEnd($end);
						//Let’s add the event to the calendar
						$createdEvent = $service->events->insert("asilolibertydog@gmail.com",$event);
						//Show the ID of the created event
						$calendarid = $createdEvent->getId();
						//echo "<div>". $calendarid ."</div>";
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
						
                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_empl` (`giorno`,`id_empl`, `intime`, `outtime`, `note`, `status`, `calendar`) VALUES ('$giorno', '$id_empl1', '$intime1', '$outtime1','$note1','$status1','$calendarid');";
				  $msginsert1 = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_presenze_empl_orari')";
				  $msglog1= mysql_query($sql2);

               }else {
                  $msg = 'Id personale e Giorno';
				  echo ( $msg );
               }


				  if ($id_empl2 > 0 ) {
					  $status2 = '';
					  // Assegno il lable della parte di giornata
					  if (strtotime($intime2) < strtotime("08:35:00") ) { $status2=10; }
					  if (strtotime($intime2) > strtotime("08:35:00") && strtotime($outtime2) < strtotime("15:10:00")) { $status2=11; }
					  if (strtotime($intime2) > strtotime("11:05:00") && strtotime($outtime2) < strtotime("17:40:00")) { $status2=12; }
					  if (strtotime($intime2) > strtotime("13:15:00") && strtotime($outtime2) < strtotime("18:20:00")) { $status2=13; }
					  if (strtotime($intime2) > strtotime("12:00:00") && strtotime($outtime2) > strtotime("18:00:00")) { $status2=14; }
						  
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
						$ore2=substr($intime2, 0, 2);
						$minuti2=substr($intime2, -2, 2);
						//echo "Ore e Minuti: " . $ore . " " . $minuti . "\n";
						date_time_set($date,$ore2,$minuti2);
						//echo $date->format('Y-m-d H:i:s') . "\n";
						//echo "date=" .date_format($date, 'Y-m-d H:i:s') . "\n";
						//$startDate = date_format($date, 'Y-m-dTH:i:s');
						$startDate = date_format($date,"Y-m-d")."T".date_format($date,"H:i:s")."+01:00";
						//echo "startDate= $startDate \n" ;
						if ($outtime2 == "") {
							$oreout2="19";
							$minutiout2="30";
							$dateout->setTime($oreout2,$minutiout2);
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
						} else {
							$dateout = new DateTime($giorno);
							$oreout=substr($outtime2, 0, 2);
							$minutiout=substr($outtime2, -2, 2);;
							$dateout->setTime($oreout,$minutiout);
							// echo $dateout->format('Y-m-d H:i:s') . "\n";
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
							}
						//echo " Ok set up delle date \n" ;
						//echo " $endDate \n" ;
						
						$event = new Google_Service_Calendar_Event(array( 
							'attendees' => array(array('email' => 'roberto.bedola@gmail.com')), 
							'reminders' => array('useDefault' => FALSE,'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60),array('method' => 'popup', 'minutes' => 15)))
							));
						//echo " Ok set up di event \n" ;
						//Set the summary (= the text shown in the event)
						$event->setSummary("$id_emplungo2");
						//echo " Ok set up di Summary \n" ;
						//Set the place of the event
						$event->setLocation("Asilo");
						//echo " Ok set up di location \n" ;
						//Set the beginning of the event
						$start = new Google_Service_Calendar_EventDateTime();
						$start->setDateTime($startDate);
						$start->setTimeZone("Europe/Rome");
						//echo " Ok set up di start \n" ;
						$event->setStart($start);
						//echo " Ok set up di event con start \n" ;
						//Set the end of the event
						$end = new Google_Service_Calendar_EventDateTime();
						$end->setDateTime($endDate);
						$end->setTimeZone("Europe/Rome");
						$event->setEnd($end);
						//Let’s add the event to the calendar
						$createdEvent = $service->events->insert("asilolibertydog@gmail.com",$event);
						//Show the ID of the created event
						$calendarid = $createdEvent->getId();
						//echo "<div>". $calendarid ."</div>";
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
						
                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_empl` (`giorno`,`id_empl`, `intime`, `outtime`, `note`, `status`, `calendar`) VALUES ('$giorno', '$id_empl2', '$intime2', '$outtime2','$note2','$status2','$calendarid');";
				  $msginsert2 = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_presenze_empl_orari')";
				  $msglog2= mysql_query($sql2);

               }

				  if ($id_empl3 > 0 ) {
					  $status3 = '';
					  // Assegno il lable della parte di giornata
					  if (strtotime($intime3) < strtotime("08:35:00") ) { $status3=10; }
					  if (strtotime($intime3) > strtotime("08:35:00") && strtotime($outtime3) < strtotime("15:10:00")) { $status3=11; }
					  if (strtotime($intime3) > strtotime("11:05:00") && strtotime($outtime3) < strtotime("17:40:00")) { $status3=12; }
					  if (strtotime($intime3) > strtotime("13:15:00") && strtotime($outtime3) < strtotime("18:20:00")) { $status3=13; }
					  if (strtotime($intime3) > strtotime("12:00:00") && strtotime($outtime3) > strtotime("18:00:00")) { $status3=14; }
						  
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
						$ore=substr($intime3, 0, 2);
						$minuti=substr($intime3, -2, 2);
						//echo "Ore e Minuti: " . $ore . " " . $minuti . "\n";
						date_time_set($date,$ore,$minuti);
						//echo $date->format('Y-m-d H:i:s') . "\n";
						//echo "date=" .date_format($date, 'Y-m-d H:i:s') . "\n";
						//$startDate = date_format($date, 'Y-m-dTH:i:s');
						$startDate = date_format($date,"Y-m-d")."T".date_format($date,"H:i:s")."+01:00";
						//echo "startDate= $startDate \n" ;
						if ($outtime3 == "") {
							$oreout="19";
							$minutiout="30";
							$dateout->setTime($oreout,$minutiout);
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
						} else {
							$dateout = new DateTime($giorno);
							$oreout=substr($outtime3, 0, 2);
							$minutiout=substr($outtime3, -2, 2);;
							$dateout->setTime($oreout,$minutiout);
							// echo $dateout->format('Y-m-d H:i:s') . "\n";
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
							}
						//echo " Ok set up delle date \n" ;
						//echo " $endDate \n" ;
						
						$event = new Google_Service_Calendar_Event(array( 
							'attendees' => array(array('email' => 'roberto.bedola@gmail.com')), 
							'reminders' => array('useDefault' => FALSE,'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60),array('method' => 'popup', 'minutes' => 15)))
							));
						//echo " Ok set up di event \n" ;
						//Set the summary (= the text shown in the event)
						$event->setSummary("$id_emplungo3");
						//echo " Ok set up di Summary \n" ;
						//Set the place of the event
						$event->setLocation("Asilo");
						//echo " Ok set up di location \n" ;
						//Set the beginning of the event
						$start = new Google_Service_Calendar_EventDateTime();
						$start->setDateTime($startDate);
						$start->setTimeZone("Europe/Rome");
						//echo " Ok set up di start \n" ;
						$event->setStart($start);
						//echo " Ok set up di event con start \n" ;
						//Set the end of the event
						$end = new Google_Service_Calendar_EventDateTime();
						$end->setDateTime($endDate);
						$end->setTimeZone("Europe/Rome");
						$event->setEnd($end);
						//Let’s add the event to the calendar
						$createdEvent = $service->events->insert("asilolibertydog@gmail.com",$event);
						//Show the ID of the created event
						$calendarid = $createdEvent->getId();
						//echo "<div>". $calendarid ."</div>";
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
						
                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_empl` (`giorno`,`id_empl`, `intime`, `outtime`, `note`, `status`, `calendar`) VALUES ('$giorno', '$id_empl3', '$intime3', '$outtime3','$note3','$status3','$calendarid');";
				  $msginsert3 = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_presenze_empl_orari')";
				  $msglog3= mysql_query($sql2);

               }

				  if ($id_empl4 > 0 ) {
					  $status4 = '';
					  // Assegno il lable della parte di giornata
					  if (strtotime($intime4) < strtotime("08:35:00") ) { $status4=10; }
					  if (strtotime($intime4) > strtotime("08:35:00") && strtotime($outtime4) < strtotime("15:10:00")) { $status4=11; }
					  if (strtotime($intime4) > strtotime("11:05:00") && strtotime($outtime4) < strtotime("17:40:00")) { $status4=12; }
					  if (strtotime($intime4) > strtotime("13:15:00") && strtotime($outtime4) < strtotime("18:20:00")) { $status4=13; }
					  if (strtotime($intime4) > strtotime("12:00:00") && strtotime($outtime4) > strtotime("18:00:00")) { $status4=14; }
						  
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
						$ore=substr($intime4, 0, 2);
						$minuti=substr($intime4, -2, 2);
						//echo "Ore e Minuti: " . $ore . " " . $minuti . "\n";
						date_time_set($date,$ore,$minuti);
						//echo $date->format('Y-m-d H:i:s') . "\n";
						//echo "date=" .date_format($date, 'Y-m-d H:i:s') . "\n";
						//$startDate = date_format($date, 'Y-m-dTH:i:s');
						$startDate = date_format($date,"Y-m-d")."T".date_format($date,"H:i:s")."+01:00";
						//echo "startDate= $startDate \n" ;
						if ($outtime4 == "") {
							$oreout="19";
							$minutiout="30";
							$dateout->setTime($oreout,$minutiout);
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
						} else {
							$dateout = new DateTime($giorno);
							$oreout=substr($outtime4, 0, 2);
							$minutiout=substr($outtime4, -2, 2);;
							$dateout->setTime($oreout,$minutiout);
							// echo $dateout->format('Y-m-d H:i:s') . "\n";
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
							}
						//echo " Ok set up delle date \n" ;
						//echo " $endDate \n" ;
						
						$event = new Google_Service_Calendar_Event(array( 
							'attendees' => array(array('email' => 'roberto.bedola@gmail.com')), 
							'reminders' => array('useDefault' => FALSE,'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60),array('method' => 'popup', 'minutes' => 15)))
							));
						//echo " Ok set up di event \n" ;
						//Set the summary (= the text shown in the event)
						$event->setSummary("$id_emplungo4");
						//echo " Ok set up di Summary \n" ;
						//Set the place of the event
						$event->setLocation("Asilo");
						//echo " Ok set up di location \n" ;
						//Set the beginning of the event
						$start = new Google_Service_Calendar_EventDateTime();
						$start->setDateTime($startDate);
						$start->setTimeZone("Europe/Rome");
						//echo " Ok set up di start \n" ;
						$event->setStart($start);
						//echo " Ok set up di event con start \n" ;
						//Set the end of the event
						$end = new Google_Service_Calendar_EventDateTime();
						$end->setDateTime($endDate);
						$end->setTimeZone("Europe/Rome");
						$event->setEnd($end);
						//Let’s add the event to the calendar
						$createdEvent = $service->events->insert("asilolibertydog@gmail.com",$event);
						//Show the ID of the created event
						$calendarid = $createdEvent->getId();
						//echo "<div>". $calendarid ."</div>";
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
						
                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_empl` (`giorno`,`id_empl`, `intime`, `outtime`, `note`, `status`, `calendar`) VALUES ('$giorno', '$id_empl4', '$intime4', '$outtime4','$note4','$status4','$calendarid');";
				  $msginsert4 = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_presenze_empl_orari')";
				  $msglog4= mysql_query($sql2);

               }

				  if ($id_empl5 > 0 ) {
					  $status5 = '';
					  // Assegno il lable della parte di giornata
					  if (strtotime($intime5) < strtotime("08:35:00") ) { $status5=10; }
					  if (strtotime($intime5) > strtotime("08:35:00") && strtotime($outtime5) < strtotime("15:10:00")) { $status5=11; }
					  if (strtotime($intime5) > strtotime("11:05:00") && strtotime($outtime5) < strtotime("17:40:00")) { $status5=12; }
					  if (strtotime($intime5) > strtotime("13:15:00") && strtotime($outtime5) < strtotime("18:20:00")) { $status5=13; }
					  if (strtotime($intime5) > strtotime("12:00:00") && strtotime($outtime5) > strtotime("18:00:00")) { $status5=14; }
						  
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
						$ore=substr($intime5, 0, 2);
						$minuti=substr($intime5, -2, 2);
						//echo "Ore e Minuti: " . $ore . " " . $minuti . "\n";
						date_time_set($date,$ore,$minuti);
						//echo $date->format('Y-m-d H:i:s') . "\n";
						//echo "date=" .date_format($date, 'Y-m-d H:i:s') . "\n";
						//$startDate = date_format($date, 'Y-m-dTH:i:s');
						$startDate = date_format($date,"Y-m-d")."T".date_format($date,"H:i:s")."+01:00";
						//echo "startDate= $startDate \n" ;
						if ($outtime5 == "") {
							$oreout="19";
							$minutiout="30";
							$dateout->setTime($oreout,$minutiout);
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
						} else {
							$dateout = new DateTime($giorno);
							$oreout=substr($outtime5, 0, 2);
							$minutiout=substr($outtime5, -2, 2);;
							$dateout->setTime($oreout,$minutiout);
							// echo $dateout->format('Y-m-d H:i:s') . "\n";
							$endDate = date_format($dateout,"Y-m-d")."T".date_format($dateout,"H:i:s")."+01:00";
							}
						//echo " Ok set up delle date \n" ;
						//echo " $endDate \n" ;
						
						$event = new Google_Service_Calendar_Event(array( 
							'attendees' => array(array('email' => 'roberto.bedola@gmail.com')), 
							'reminders' => array('useDefault' => FALSE,'overrides' => array(array('method' => 'email', 'minutes' => 24 * 60),array('method' => 'popup', 'minutes' => 15)))
							));
						//echo " Ok set up di event \n" ;
						//Set the summary (= the text shown in the event)
						$event->setSummary("$id_emplungo5");
						//echo " Ok set up di Summary \n" ;
						//Set the place of the event
						$event->setLocation("Asilo");
						//echo " Ok set up di location \n" ;
						//Set the beginning of the event
						$start = new Google_Service_Calendar_EventDateTime();
						$start->setDateTime($startDate);
						$start->setTimeZone("Europe/Rome");
						//echo " Ok set up di start \n" ;
						$event->setStart($start);
						//echo " Ok set up di event con start \n" ;
						//Set the end of the event
						$end = new Google_Service_Calendar_EventDateTime();
						$end->setDateTime($endDate);
						$end->setTimeZone("Europe/Rome");
						$event->setEnd($end);
						//Let’s add the event to the calendar
						$createdEvent = $service->events->insert("asilolibertydog@gmail.com",$event);
						//Show the ID of the created event
						$calendarid = $createdEvent->getId();
						//echo "<div>". $calendarid ."</div>";
						} catch (Exception $e) {
							echo 'Caught exception: ',  $e->getMessage(), "\n";
							}
						
                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_empl` (`giorno`,`id_empl`, `intime`, `outtime`, `note`, `status`, `calendar`) VALUES ('$giorno', '$id_empl5', '$intime5', '$outtime5','$note5','$status5','$calendarid');";
				  $msginsert5 = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_presenze_empl_orari')";
				  $msglog5= mysql_query($sql2);

               }
			 }
			   ?>
      </div> <!-- /container -->

	  
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="insert_empl.php" method='post' id='login'>
              <table>
			  <tr> <td> &nbsp; </td>  <td>  <font color=#eeee00> Giorno: </font> </td>  <td> <input type='date' name='giorno' /> </td>  <td> &nbsp;  </td> </tr>
			  <tr>
				<td> <font color=#eeee00> Identificativo dipendente: </font> </td>
				<td> <font color=#eeee00> Orario Entrata: </font></td> 
				<td> <font color=#eeee00> Orario Uscita: </font></td> 
				<td> <font color=#eeee00> Note: </font> </td> 
			  </tr> 
			  <tr> 
				<td> 
         <?php
				$sqlempl = "SELECT CONCAT(`id_Anagrafica_Empl`,'-',`name`) as persona1 FROM `libdog_Anagrafica_Empl` order by `name`;";
				$resultempl = mysql_query($sqlempl);
						echo "<select name='id_empl1'> <option value='0-Empty'>0-Empty</option>";
						//echo "$resultempl";
				if ($resultempl !== FALSE){
					while($row=mysql_fetch_array($resultempl)){
						$persona1 = htmlspecialchars ($row["persona1"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$persona1'>$persona1</option> ";
						}
					}
				echo "</select> ";
         ?>				
			</td> 
				<td> <input type='time' name='intime1' /> </td>
				<td> <input type='time' name='outtime1' /> </td> 
				<td><input type='text' name='note1' /></td> 
			  </tr>
			  <tr>
				<td> <font color=#eeee00> Identificativo dipendente: </font> </td>
				<td> <font color=#eeee00> Orario Entrata: </font></td> 
				<td> <font color=#eeee00> Orario Uscita: </font></td> 
				<td> <font color=#eeee00> Note: </font> </td> 
			  </tr> 
			  <tr> 
				<td> 
         <?php
				$sqlempl = "SELECT CONCAT(`id_Anagrafica_Empl`,'-',`name`) as persona2 FROM `libdog_Anagrafica_Empl` order by `name`;";
				$resultempl = mysql_query($sqlempl);
						echo "<select name='id_empl2'> <option value='0-Empty'>0-Empty</option>";
						//echo "$resultempl";
				if ($resultempl !== FALSE){
					while($row=mysql_fetch_array($resultempl)){
						$persona2 = htmlspecialchars ($row["persona2"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$persona2'>$persona2</option> ";
						}
					}
				echo "</select> ";
         ?>				
			</td> 
				<td> <input type='time' name='intime2' /> </td>
				<td> <input type='time' name='outtime2' /> </td> 
				<td><input type='text' name='note2' /></td> 
			  </tr>
			  <tr>
				<td> <font color=#eeee00> Identificativo dipendente: </font> </td>
				<td> <font color=#eeee00> Orario Entrata: </font></td> 
				<td> <font color=#eeee00> Orario Uscita: </font></td> 
				<td> <font color=#eeee00> Note: </font> </td> 
			  </tr> 
			  <tr> 
				<td> 
         <?php
				$sqlempl = "SELECT CONCAT(`id_Anagrafica_Empl`,'-',`name`) as persona3 FROM `libdog_Anagrafica_Empl` order by `name`;";
				$resultempl = mysql_query($sqlempl);
						echo "<select name='id_empl3'> <option value='0-Empty'>0-Empty</option>";
						//echo "$resultempl";
				if ($resultempl !== FALSE){
					while($row=mysql_fetch_array($resultempl)){
						$persona3 = htmlspecialchars ($row["persona3"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$persona3'>$persona3</option> ";
						}
					}
				echo "</select> ";
         ?>				
			</td> 
				<td> <input type='time' name='intime3' /> </td>
				<td> <input type='time' name='outtime3' /> </td> 
				<td><input type='text' name='note3' /></td> 
			  </tr>
			  <tr>
				<td> <font color=#eeee00> Identificativo dipendente: </font> </td>
				<td> <font color=#eeee00> Orario Entrata: </font></td> 
				<td> <font color=#eeee00> Orario Uscita: </font></td> 
				<td> <font color=#eeee00> Note: </font> </td> 
			  </tr> 
			  <tr> 
				<td> 
         <?php
				$sqlempl = "SELECT CONCAT(`id_Anagrafica_Empl`,'-',`name`) as persona4 FROM `libdog_Anagrafica_Empl` order by `name`;";
				$resultempl = mysql_query($sqlempl);
						echo "<select name='id_empl4'> <option value='0-Empty'>0-Empty</option>";
						//echo "$resultempl";
				if ($resultempl !== FALSE){
					while($row=mysql_fetch_array($resultempl)){
						$persona4 = htmlspecialchars ($row["persona4"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$persona4'>$persona4</option> ";
						}
					}
				echo "</select> ";
         ?>				
			</td> 
				<td> <input type='time' name='intime4' /> </td>
				<td> <input type='time' name='outtime4' /> </td> 
				<td><input type='text' name='note4' /></td> 
			  </tr>
			  <tr>
				<td> <font color=#eeee00> Identificativo dipendente: </font> </td>
				<td> <font color=#eeee00> Orario Entrata: </font></td> 
				<td> <font color=#eeee00> Orario Uscita: </font></td> 
				<td> <font color=#eeee00> Note: </font> </td> 
			  </tr> 
			  <tr> 
				<td> 
         <?php
				$sqlempl = "SELECT CONCAT(`id_Anagrafica_Empl`,'-',`name`) as persona5 FROM `libdog_Anagrafica_Empl` order by `name`;";
				$resultempl = mysql_query($sqlempl);
						echo "<select name='id_empl5'> <option value='0-Empty'>0-Empty</option>";
						//echo "$resultempl";
				if ($resultempl !== FALSE){
					while($row=mysql_fetch_array($resultempl)){
						$persona5 = htmlspecialchars ($row["persona5"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$persona5'>$persona5</option> ";
						}
					}
				echo "</select> ";
         ?>				
			</td> 
				<td> <input type='time' name='intime5' /> </td>
				<td> <input type='time' name='outtime5' /> </td> 
				<td><input type='text' name='note5' /></td> 
			  </tr>
			  <tr>
					<td><input type='submit' name = "Inserisci" value='Inserisci' /></td> 
			   </tr>
			  </table>
            </form>
        	</div>	
		</div>
			</td></tr>
		</table>
  </p>

  						<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>



      

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
		
		<?php 
			} else {
				 echo "<h1> Questa pagina non è accessibile per questo utente </h1>";
			}
		?>
</body>
</html>