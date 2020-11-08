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
						
						//Ometto il codice di autorizzazione in quanto uguale
//alla parte precedentemente mostrata, inserisco qui
//solamente la procedura di recupero e visualizzazione
//degli eventi…
$eventi = $service->events->listEvents("asilolibertydog@gmail.com");

while(true)
{
 foreach($eventi->getItems() as $evento)
 {
  $inizio = $evento->getStart()->getDateTime();
  $fine = $evento->getEnd()->getDateTime();
  $testo = $evento->getSummary();
  echo "< div >$inizio &rarr; $fine: $testo< /div >";
 } //Fine foreach sugli eventi della pagina

 $pageToken = $eventi->getNextPageToken();

 if($pageToken)
 {
  $parametriOpzionali = array("pageToken"=>$pageToken);
  $eventi = $service->events->listEvents("asilolibertydog@gmail.com", $parametriOpzionali);
 }
 else
  break;
}//Fine while sulle pagine degli eventi

?>


</body>
</html>
