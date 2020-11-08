<?php
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
$client->setApplicationName("TestCalendarAPI");

$httpClient = $client->authorize();

// E" anche variato il modo di indicare gli “scopes”
$scopes = implode(" ", array(Google_Service_Calendar::CALENDAR,Google_Service_Calendar::CALENDAR_READONLY));
$client->setScopes($scopes);

$service = new Google_Service_Calendar($client);
  
  //Otteniamo la lista dei calendari visibili dall"account di
  //servizio e lo mandiamo a schermo
  $listaCalendari = $service->calendarList->listCalendarList();
  echo "<pre>".var_export($listaCalendari,true)."</pre>";
}
catch(Google_Service_Exception $gse)
{
  echo $gse->getMessage();
}
catch(Exception $ex)
{
  echo $ex->getMessage();
}

?>