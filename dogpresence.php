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
		$getclient_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT client_id FROM voglioentrare WHERE user_name = '$myusername'"));
		$client_id = $getclient_id['client_id'];    
		$getdognumber = mysqli_fetch_assoc(mysqli_query($link, "SELECT count(*) as dognumber FROM `libdog_Anagrafica_Cani` WHERE `id_padrone` = '$client_id'"));
		$dognumber = $getdognumber['dognumber'];  
		$getview = mysqli_fetch_assoc(mysqli_query($link, "SELECT viewcal FROM `libdog_Anagrafica_Clienti` WHERE `idlibdog_Anagrafica_Clienti` = '$client_id'"));
		$viewcal = $getview['viewcal'];  
		if ($dognumber=='1') { 
			$getdog_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT idlibdog_Anagrafica_Cani FROM `libdog_Anagrafica_Cani` WHERE libdog_Anagrafica_Clienti_id = '$client_id'"));
			$dog_id = $getdog_id['idlibdog_Anagrafica_Cani'];
		} else {
			$getdog_id = mysqli_fetch_assoc(mysqli_query($link, "SELECT idlibdog_Anagrafica_Cani FROM `libdog_Anagrafica_Cani` WHERE libdog_Anagrafica_Clienti_id = '$client_id' LIMIT 1 , 1"));
			$dog_id = $getdog_id['idlibdog_Anagrafica_Cani'];
		}
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
    		    <h1> Liberty Dog - Data entry</h1>
				<h2>  
					<?php
					$msg = "Benvenuto/a ".  $_SESSION['myusername'];
					//$msg = "Benvenuto/a ".  $_SESSION['myusername']. " - ". $userkind. " - ".$viewcal. " - ". $dognumber. " - ". $dog_id . " - ". $client_id;
					echo ( $msg );
				?>
				</h2>
			</td>	
	</tr>
</table>

<br><br>

						
<?php
	//procedo alla prima query per estrarre i nomi dei cani
	mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
	mysql_select_db("$db_name") or die ("cannot select DB");

// if viewcal = 0 allora tolgo la visione del calendario-dinamico-php
	if ($viewcal=='1') {
		//Se cambio mese procedo al recupero dei dati postati.
		$mese="";
		$anno="";
		$mese=$_POST['mese'];
		$anno=$_POST['anno'];
		if ($mese=="") //se il mese non è stato valorizzato
		{
			$time=time(); //il parametro time sarà uguale al timestamp corrente
			}
		else {
			$time=mktime(0,0,0,$mese,1,$anno); //altrimenti mi ricavo il timestamp del primo giorno del mese richiesto
			}
		//utilizzo il sistema creato da PaTer in questo thread http://www.giorgiotave.it/forum/scripting-e-risorse-utili/3211-tutorial-creare-un-calendario-dinamico-php.html apportando alcune modifiche
		$dati['giorni_mesi'] =  array(31, 0, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); // Array con i giorni dei mesi
		$dati['mese_num'] = date("n",  $time); // Mese corrente ( numerico )
		//	$dati['mese_text'] = date("F", $time); // Mese Corrente ( testuale )
		$dati['mese_text'] = array("Fake","Gennaio","Febbraio","Marzo","Aprile","Maggio","Giugno","Luglio","Agosto","Settembre","Ottobre","Novembre","Dicembre"); // Mese Corrente ( testuale Italiano)
		$dati['anno'] = date("Y", $time); // Anno
		$dati['start'] = date("w", mktime(0,0,0, $dati['mese_num'], 1, $dati['anno'])); // Giorno della settimana del primo giorno del mese
		$dati['giorni_mesi'][1]=(date('L',$time)==0)?28:29; // calcolo giorni mese di Febbraio
		$dati['giorni_mese'] = $dati['giorni_mesi'][$dati['mese_num']-1]; // Giorni del mese corrente
		$dati['settimana']=array("D","L","M","M","G","V","S");
		$prenotato=array("0"=>"0.png","1"=>"1p.png","2"=>"2p.png","3"=>"3p.png"); // prenotati ma non confermati avranno una colorazione gialla
		$confermato=array("0"=>"0.png","1"=>"1c.png","2"=>"2c.png","3"=>"3c.png"); // confermati avranno una colorazione rossa
			
		//procedo quindi a creare due form che mi portino al mese precedente ed al mese successivo a quello attualmente visualizzato facendo attenzione al cambio di anno, nel caso si stia visualizzando il mese di Gennaio il form del mese precedente mi dovrà postare il mese 12 e l'anno corrente -1. Speculare per il mese di dicembre, il form per il mese successivo dovrà postare il mese 1 e l'anno incrementato di 1	
		?>
		<table align="center" border="0" width="80%">
			<tr>
				<td align="center" width="25%"><form action="<? echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="hidden" name="mese" value="<? if ($dati['mese_num']=="1") { echo "12";} else {echo $dati['mese_num']-1;} ?>" /><input type="hidden" name="anno" value="<? if ($dati['mese_num']=="1"){ echo $dati['anno']-1;} else {echo $dati['anno'];}?>" /><input type="submit" value="&nbsp;&lt;&nbsp;" /></form></td>
				<td align="center" width="25%"><? echo "Mese: <strong>".$dati['mese_text'][$dati['mese_num']]."</strong> Anno: <strong>".$dati['anno'] ?></strong></td>
				<td align="center" width="25%"><form action="<? echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="hidden" name="mese" value="<? if ($dati['mese_num']=="12") { echo "1";} else {echo $dati['mese_num']+1;} ?>" /><input type="hidden" name="anno" value="<? if ($dati['mese_num']=="12"){ echo $dati['anno']+1;} else {echo $dati['anno'];}?>" /><input type="submit" value="&nbsp;&gt;&nbsp;" /></form></td>	
			</tr>
		</table>
		<table border="1"  class="calendario" align="center">
		<caption><strong><h3>Calendario</h3></strong></caption>
			<tr>
				<td rowspan="2">Cani</td>
		<?
		// partita la tabella procedo alla costruzione delle righe di intestazione
		//$d servirà per verificare il ciclo dei giorni della settimana, evitando così di dover utilizzare una funzione ad ogni ciclo, basta fare un semplice controllo che una volta incrementato a 7 il valore di $d, questo riparta da 0
		$d=$dati['start'];	 // indice della settimana del primo giorno del mese
		for ($i=1; $i<=$dati['giorni_mese'];$i++) {
			if ($d=="7") $d=0;
		?>	
				<td style="text-align:center;<? if ($d=="6" || $d=="0") echo "background-color:red;"; // se $d è uguale a 6 o 0 vuol dire che è un sabato o una domenica, quindi coloriamo di rosso questi giorni ?>"><? echo $dati['settimana'][$d]; //utilizzo $d anche come indice progressivo per visualizzare il contenuto dell'array dei giorni della settimana ?></td>
		<?	
			$d++; //ad ogni ciclo bisogna ovviamente incrementare $d
			}
		?>
			</tr>
			<tr>
		<?
		// Esattamente come il ciclo precedente costruisco la riga dei giorni del mese
		$d=$dati['start'];	
		for ($i=1; $i<=$dati['giorni_mese'];$i++) {
			if ($d=="7") $d=0;
		?>
				<td style="text-align:center;<? if ($d=="6" || $d=="0") echo "background-color:red;"; ?>"><? echo $i; ?></td>
		<?
			$d++;
			}
		?>
			</tr>
		<?
		$sql_lavori="select distinct `id_cane`, `name` from `libdog_presenze_day` as a, `libdog_Anagrafica_Cani` as b where  CONCAT('".$dati['mese_num']."','-','".$dati['anno']."')=DATE_FORMAT(`giorno`,'%c-%Y')  and a.`id_cane`=b.`idlibdog_Anagrafica_Cani` and `libdog_Anagrafica_Clienti_id`= '$client_id' order by `name`;";
		$query_lavori=@mysql_query($sql_lavori) or die (mysql_error());
		while ($row_lavori=mysql_fetch_array($query_lavori)) // ed inizio a ciclare questo risultato
			{
			echo "<tr><td class=\"name\">".$row_lavori['name']."</td>";
			$startmonth=gmmktime(0,0,0,$dati['mese_num'],1,$dati['anno']); // mi valorizzo il timestamp del primo giorno del mese 
			$stopmonth=gmmktime(0,0,0,$dati['mese_num'],$dati['giorni_mese'],$dati['anno']); // e dell'ultimo giorno del mese
		// DEBUG
		//	printf ("<br><br>");
		//	printf ("START & STOP TIMESTAMP: %s - %s \n\n", $startmonth, $stopmonth);
			$dtstartmonth = new DateTime("@$startmonth"); 
			$dtstopmonth = new DateTime("@$stopmonth"); 
			$dtstartmonth = $dtstartmonth->format('Y-m-d'); // for example
			$dtstopmonth = $dtstopmonth->format('Y-m-d'); // for example
		// DEBUG
		//	printf ("START & STOP DATE: %s - %s \n\n", $dtstartmonth, $dtstopmonth);
			//estraggo quindi le prenotazioni del mese corrente per questa team
			$sql_pren="SELECT * FROM `libdog_presenze_day` WHERE `id_cane`='".$row_lavori['id_cane']."' AND giorno >= '$dtstartmonth' AND giorno <= '$dtstopmonth' ORDER BY giorno";
			//$sql_pren="SELECT * FROM safetycat_Calendario_Lavori WHERE team='".$row_lavori['id_team']."'  ORDER BY datalavoroinizio";
			//il sistema utilizzato è quello di controllare se vi sono prenotazioni che iniziano il mese precedente e finiscono dopo il primo giorno del mese interessato, poi se vi sono prenotazioni che iniziano e finiscono entro il mese corrente e quindi se vi sono prenotazioni che iniziano prima del fine mese corrente e finiscono nel mese successivo
			$query_pren=@mysql_query($sql_pren) or die (mysql_error());
		// DEBUG
		//	printf ("QUERY: %s \n\n", $sql_pren);
		//	printf ("OUTPUT QUERY: %s \n\n", $query_pren);
		//	printf ("ULTIMO GIORNO MESE: %s - %s - %s \n\n",$dati['giorni_mese'], $dati['mese_num'],$dati['anno']);
		//	printf ("PRIMO GIORNO MESE: %s - %s - %s \n\n","1", $dati['mese_num'],$dati['anno']);
			
			
		//recuperati questi dati inizio a salvarmi i valori interessati dentro degli array il cui indice non è altro, per unicità, che il timestamp del giorno in questione, che ad ogni ciclo incremento di  1 giorno = 86400 secondi
			for ($i=$startmonth;$i<=$startmonth+(($dati['giorni_mese'])*86400);$i=$i+86400) {
				$team[$i]=0;
				$status[$i]=false;
				$zona[$i]=false;
				}	
			//recuperati questi dati inizio a salvarmi i valori interessati dentro degli array il cui indice non è altro, per unicità, che il timestamp del giorno in questione, che ad ogni ciclo incremento di  1 giorno = 86400 secondi. 
			
			// per poter distinguere le prenotazioni tra loro utilizzo il sistema di valorizzare cella per cella (giorno per giorno) l'array $team. Se il suo valore è uguale a 0 (verde) la team, quel giorno, è libera, se è uguale a 1 significa che è l'inizio o la fine della prenotazione, se è uguale a 2 vuol dire che la team è occupata per tutto il giorno, se è uguale a 3 vuol dire che quel giorno sono presenti un fine prenotazione ed un inizio prenotazione. Se il numero è maggiore (nero) significa che c'è qualcosa che non va. :)
			while ($row_pren=mysql_fetch_array($query_pren)) {
		// DEBUG
		//		printf ("row_pren: %s \n\n", $row_pren);
		//		printf ("row_pren['datalavoroinizio']: %s \n\n", $row_pren['datalavoroinizio']);
		//		printf ("row_pren['datalavorofine']: %s \n\n", $row_pren['datalavorofine']);
		//		printf ("row_pren['datainizio']: %s \n\n", $row_pren['datainizio']);
		//		printf ("row_pren['datafine']: %s \n\n", $row_pren['datafine']);
				$dtdaymonth = new DateTime($row_pren['giorno']); 
				$dtdaymonth = $dtdaymonth->format('d'); // for example
		// DEBUG
		//		printf ("row_pren['dtdaymonth']: %s \n\n", $dtdaymonth);
		// DEBUG
		//		printf ("la data inizio prenotazione è maggiore del primo giorno del mese %s %s %s\n",$row_pren['datainizio'],$row_pren['datalavoroinizio'], $dtstartmonth);
				//estraggo il nominativo della prenotazione
				$sql_anagr="SELECT * FROM libdog_Anagrafica_Cani WHERE idlibdog_Anagrafica_Cani='".$row_pren['id_cane']."'";
				$query_anagr=@mysql_query($sql_anagr) or die (mysql_error());
				$array_anagr=mysql_fetch_array($query_anagr);
		// DEBUG
		//	printf ("<br>");
		//	printf ("query_anagr: %s \n\n", $query_anagr);
		//	printf ("array_anagr: %s \n\n", $array_anagr);
		//	printf ("<br>");
		
			
				//$dw=date('j',$row_pren['datainizio']); //trovo il giorno del mese della data inizio
				$dw=$dtdaymonth;
		// DEBUG
		//	printf ("giorno of inizio lavori: %s \n\n",$dw);
		//	printf ("<br>");
				$dw=$startmonth+(($dw-1)*86400); // e per regolarità sommo il timestamp di inizio mese al giorno del mese di data inizio prenotazione trasformato in secondi (sotratto di 1 perché il primo giorno è già valorizzato)
		// DEBUG
		//		printf ("dw post transformation: %s \n\n",$dw);
				$q=$dw;
				$team[$q]=$team[$q]+1; // aumento di 1 il valore di $team
				$status[$q]=$row_pren['status'];
				$id[$q]=$row_pren['id_cane'];
				$cognome[$q]=$array_anagr['name']; 
				$paese[$q]=$array_anagr['breed'];
				$in[$q]=$row_pren['intime'];
				$out[$q]=$row_pren['outtime'];
				$note[$q]=$row_pren['note'];
				$trasporto[$q]=$row_pren['trasporto'];
		// DEBUG
		//		printf ("Date utilizzate da in: %s - e out: %s\n\n",$in[$q],$out[$q]);
				// il sistema finora utilizzato, ovvero di incrementare i giorni sommando l'equivalente in secondi di un singolo giorno, va bene finché non ci si trova nei mesi in cui avviene il cambio dell'ora legale con quella solare e viceversa, ovvero ottobre e Marzo. Ma basta eseguire il controllo sulla data in questione ed eventualmente incrementare o decrementare il valore di 3600 secondi (1 ora)
				if (date("I",$row_pren['datafine'])==1 && $dati['mese_num']==3) {$row_pren['datafine']=$row_pren['datafine']+3600;};
				if (date("I",$row_pren['datafine'])==0 && $dati['mese_num']==10) {$row_pren['datafine']=$row_pren['datafine']-3600;};
				for ($q=($dw+86400);$q<=$row_pren['datafine'];$q=$q+86400) {
					if ($q<$row_pren['giorno']) {
						$team[$q]=$team[$q]+3;
						$status[$q]=$row_pren['status'];
						$id[$q]=$row_pren['id_cane'];
						$cognome[$q]=$array_anagr['name']; 
						$paese[$q]=$array_anagr['breed'];
						$in[$q]=$row_pren['intime'];
						$out[$q]=$row_pren['outtime'];
						$note[$q]=$row_pren['note'];
						$trasporto[$q]=$row_pren['trasporto'];
					} else {
						$team[$q]=$team[$q]+1;
						$status[$q]=$row_pren['status'];
						$id[$q]=$row_pren['id_cane'];
						$cognome[$q]=$array_anagr['name']; 
						$paese[$q]=$array_anagr['breed'];
						$in[$q]=$row_pren['intime'];
						$out[$q]=$row_pren['outtime'];
						$note[$q]=$row_pren['note'];
						$trasporto[$q]=$row_pren['trasporto'];
						}
					}
				}
		//a questo punto i nostri array son ben che popolati, possiamo quindi procedere alla costruzione della tabella
			$d=$dati['start'];
			
			for ($i=$startmonth;$i<=$startmonth+(($dati['giorni_mese']-1)*86400);$i=$i+86400) {
		//	$vin=date('d-m-Y',$in[$i]);
		//	$vout=date('d-m-Y',$out[$i]);
				if ($d=="7") {
					$d=0;
					} 
				echo "<td style=\"text-align:center;";
				if ($d=="0" || $d=="6")  {
					echo "border:1px solid #ff020e;"; // per i Sabati e le Domeniche metto un bordo rosso alle celle della tabella
					}
				echo "\">";
				if ($team[$i]=='0') // se il valore è uguale a zero e quindi la team è libera
					{
					echo "<img src=\"images/0.png\" alt=\"\" />";
				} else if ($team[$i]=='1') // se il valore è uguale a 1 e quindi si tratta di un inizio prenotazione o un fine prenotazione
					{
					$back=($status[$i]==0)?$prenotato['1']:$confermato['1']; // controllo se la prenotazione è confermata o meno
					echo "<img src=\"images/$back\"> <br>Entrato alle $in[$i] <br>Uscito alle $out[$i]";
					if (!($note[$i]==""||$note[$i]=="presente"||$note[$i]=="p-presente")) {	echo "<br>Note: $note[$i]"; }
					if ($trasporto[$i]<>"0") {	echo "<br>Trasporti effettuati: $trasporto[$i]"; }
					}
				echo "</td>";
				$d++;
				}
		?>
			</tr>
		<?
			}
		?>
		</table>
		</div>
<?php
	} else { echo "."; }

	$sqltimer = "SELECT count(*) as total, num_ingressi FROM `libdog_presenze_day` as presence, `libdog_carnet_history` as carnet, libdog_tariffario_all as paga, `libdog_link_carnet_presenze` as link  WHERE carnet.`id_cane` = presence.`id_cane` and carnet.`id_cane` = $dog_id and `giorno` >= `validita` and presence.`id_pagamento` = paga.`id` and link.`id_presenza` = presence.`id_day` and carnet.`id_carnet` = ( select max(`id_carnet`) from  `libdog_carnet_history` where `id_cane` = $dog_id ) group by num_ingressi;";
	$resulttimer = mysql_query($sqltimer);
//	DEBUG
//	$msg = "Benvenuto/a ".  $_SESSION['myusername']. " - ". $userkind. " - ".$viewcal. " - ". $dognumber. " - ". $dog_id . " - ". $client_id . " - ". $sqltimer . " - ". $resulttimer;
//	echo ( $msg );
//	print_r($resulttimer);
	if (!$resulttimer) {
		echo "<h1 align=center>Non ci sono carnet attivi</h1>";
	} else {
		while ($rowtimer = mysql_fetch_assoc($resulttimer)) {
			$total = $rowtimer['total'];
			$num_ingressi = $rowtimer['num_ingressi'];
			if ($total >= $num_ingressi ) { echo "<br><br> <h1> <font color=red> Il carnet e' finito, sono state usate  $total dei $num_ingressi ingressi </font> </h1><br><br><br>"; }
			}
		}	

	
if ($dognumber=='1') { 
	?>
						 <h1 align=center>Presenze da data inizio ultimo carnet<h1>
					<table align=center border=2> <tr> <td align=center> <h2> Giorno </h2> </td> <td align=center> <h2> Note </h2> </td>  <td align=center> <h2> Trasporto </h2> </td>  <td align=center> <h2> Ore </h2> </td> <td align=center> <h2> Tipologia Entrata </h2> </td> </tr>
						<?php 
						$sql = "SELECT giorno, note, trasporto,  TIMEDIFF(outtime,intime) as ore, paga.`denominazione` FROM `libdog_presenze_day` as presence, `libdog_carnet_history` as carnet, libdog_tariffario_all as paga,  `libdog_link_carnet_presenze` as link  WHERE carnet.`id_cane` = presence.`id_cane` and carnet.`id_cane` = $dog_id and `giorno` >= `validita` and presence.`id_pagamento` = paga.`id` and carnet.`id_carnet` = ( select max(`id_carnet`) from  `libdog_carnet_history` where `id_cane` = $dog_id ) and link.`id_presenza` = presence.`id_day`order by giorno asc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						$switch=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 5) {
									echo "<td><h2>$cell</h2></td>"; 
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_presenze_day')";
						mysql_query($sql2);
						?>
					</table>
				</td>
			</tr>

    </table>
		<h2 align=center> Il carnet scadrà il:  
		<?php 
			$getexpdate = mysqli_fetch_assoc(mysqli_query($link, "SELECT expiration from`libdog_carnet_history` as carnet where carnet.`id_carnet` = ( select max(`id_carnet`) from  `libdog_carnet_history` where `id_cane` = $dog_id );"));
			echo $getexpdate['expiration']; 
		?>
		</h2>
	<br><br><br>

						 <h1 align=center>Presenze non in carnet da data inizio ultimo carnet<h1>
					<table align=center border=2> <tr> <td align=center> <h2> Giorno </h2> </td> <td align=center> <h2> Note </h2> </td>  <td align=center> <h2> Trasporto </h2> </td>  <td align=center> <h2> Ore </h2> </td> <td align=center> <h2> Tipologia Entrata </h2> </td> </tr>
						<?php 
						$sql = "SELECT giorno, note, trasporto,  TIMEDIFF(outtime,intime) as ore, paga.`denominazione` FROM `libdog_presenze_day` as presence, `libdog_carnet_history` as carnet, libdog_tariffario_all as paga WHERE carnet.`id_cane` = presence.`id_cane` and carnet.`id_cane` = $dog_id and `giorno` >= `validita` and presence.`id_pagamento` = paga.`id` and carnet.`id_carnet` = ( select max(`id_carnet`) from  `libdog_carnet_history` where `id_cane` = $dog_id ) and presence.`id_day` not in (select link.`id_presenza` FROM  `libdog_link_carnet_presenze` as link ) order by giorno asc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						$switch=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 5) {
									echo "<td><h2>$cell</h2></td>"; 
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_presenze_day')";
						mysql_query($sql2);
						?>
					</table>
				</td>
			</tr>
<?php 
		} else {
?>
						 <h1 align=center>Presenze da data inizio ultimo carnet<h1>
					<table align=center border=2> <tr> <td align=center> <h2> Cane </h2> </td> <td align=center><h2> Giorno </h2> </td> <td align=center> <h2> Note </h2> </td>  <td align=center> <h2> Trasporto </h2> </td>  <td align=center> <h2> Ore </h2> </td> <td align=center> <h2> Tipologia Entrata </h2> </td> </tr>
						<?php 
						$sql = "SELECT cane.`name`,   giorno, note, trasporto,  TIMEDIFF(outtime,intime) as ore, paga.`denominazione`  FROM `libdog_presenze_day` as presence, `libdog_carnet_history` as carnet, libdog_tariffario_all as paga,  `libdog_link_carnet_presenze` as link , `libdog_Anagrafica_Cani` as cane  WHERE carnet.`id_cane` = presence.`id_cane`  and carnet.`id_cane` in (select idlibdog_Anagrafica_Cani from `libdog_Anagrafica_Cani` WHERE `id_padrone` = '$client_id') and `giorno` >= `validita`  and presence.`id_pagamento` = paga.`id`  and carnet.`id_carnet` = ( select max(`id_carnet`) from  `libdog_carnet_history` where `id_cane` in (select idlibdog_Anagrafica_Cani from `libdog_Anagrafica_Cani` WHERE `id_padrone` = '$client_id') )  and link.`id_presenza` = presence.`id_day` and cane.`idlibdog_Anagrafica_Cani` in (select idlibdog_Anagrafica_Cani from `libdog_Anagrafica_Cani` WHERE `id_padrone` = '$client_id') order by cane.`name`, giorno asc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						$switch=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
									echo "<td><h2>$cell</h2></td>"; 
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_presenze_day')";
						mysql_query($sql2);
						?>
					</table>
				</td>
			</tr>

    </table>
	<h2 align=center> Il carnet scadrà il:  
	<?php 
			$getexpdate = mysqli_fetch_assoc(mysqli_query($link, "SELECT expiration from`libdog_carnet_history` as carnet where carnet.`id_carnet` = ( select max(`id_carnet`) from  `libdog_carnet_history` where `id_cane` = $dog_id );"));
			echo $getexpdate['expiration']; 
		?>
	</h2>
	
	<br><br><br>

						 <h1 align=center>Presenze non in carnet da data inizio ultimo carnet<h1>
					<table align=center border=2> <tr> <td align=center> <h2> Cane </h2> </td> <td align=center><h2> Giorno </h2> </td> <td align=center> <h2> Note </h2> </td>  <td align=center> <h2> Trasporto </h2> </td>  <td align=center> <h2> Ore </h2> </td> <td align=center> <h2> Tipologia Entrata </h2> </td> </tr>
						<?php 
						$sql = "SELECT cane.`name`,giorno, note, trasporto,  TIMEDIFF(outtime,intime) as ore, paga.`denominazione` FROM `libdog_presenze_day` as presence, `libdog_carnet_history` as carnet, libdog_tariffario_all as paga, `libdog_Anagrafica_Cani` as cane  WHERE carnet.`id_cane` = presence.`id_cane` and carnet.`id_cane` in (select idlibdog_Anagrafica_Cani from `libdog_Anagrafica_Cani` WHERE `id_padrone` = '$client_id') and `giorno` >= `validita` and presence.`id_pagamento` = paga.`id` and carnet.`id_carnet` = ( select max(`id_carnet`) from  `libdog_carnet_history` where `id_cane` in (select idlibdog_Anagrafica_Cani from `libdog_Anagrafica_Cani` WHERE `id_padrone` = '$client_id') ) and presence.`id_day` not in (select link.`id_presenza` FROM  `libdog_link_carnet_presenze` as link ) and cane.`idlibdog_Anagrafica_Cani` in (select idlibdog_Anagrafica_Cani from `libdog_Anagrafica_Cani` WHERE `id_padrone` = '$client_id') order by cane.`name`,giorno asc;";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						$switch=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 6) {
									echo "<td><h2>$cell</h2></td>"; 
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_presenze_day')";
						mysql_query($sql2);
						?>
					</table>
				</td>
			</tr>




<?php 
		// chiudo if dognumber = 1
		} 
?>

    </table>
	<br><br><br>

		<h1 align=center>Acquisti ultimi mesi<h1>
					<table align=center border=2> <tr> <td align=center> Nome Cane </td> <td align=center> Giorno </td>  <td align=center> Descrizione </td> <td align=center> Quantita' </td>  <td align=center> Importo </td> <td align=center> Ricevuta o Fattura </td> <td align=center> Tipo Pagamento </td></tr>
						<?php 

						$sql = "SELECT dog.`name`, `data_trans`, `descrizione` , `quantita`, `importo_fattura`, `ric_fat`, `tipo_pagamento` FROM `libdog_prendi_e_scappa` as money, `libdog_Anagrafica_Cani` as dog WHERE `id_cane` = `idlibdog_Anagrafica_Cani` and `data_trans` > NOW() - INTERVAL 4 MONTH and `id_cliente` = $client_id order by `data_trans` desc";
						$result = mysql_query($sql);
						$counter=0;
						$dogid=0;
						$switch=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 7) {
									echo "<td><h3>$cell</h3></td>"; 
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_prenti_e_scappa')";
						mysql_query($sql2);
						?>
					</table>
				</td>
			</tr>

    </table>

	<br><br>	<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>
							
							
<h3><a href="logout.php">Exit</a></h3>

</body>
</html>