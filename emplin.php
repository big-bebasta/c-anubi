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
<body>
		<p align=center> <img src="./Liberty-dog.png"> </p>
		<h1> Liberty Dog - Presenze personale</h1>
	<br><br><br><br>
	<p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
         
         <?php
            $msg = '';
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Inserisci']) && !empty($_POST['giorno']) 
               && !empty($_POST['id_empl'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				  // INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_empl` (`id_day`, `giorno`,`	id_empl`, `id_pagamento`, `note`, `intime`, `outtime`) VALUES (...);
					$giorno=$_POST['giorno']; 
					$id_empl=$_POST['id_empl']; 
					$intime=$_POST['intime']; 
					$outtime=$_POST['outtime']; 
					$note=$_POST['note']; 

// To protect MySQL injection (more detail about MySQL injection)
					$giorno = stripslashes($giorno);
					$id_empl = stripslashes($id_empl);
					$intime = stripslashes($intime);
					$outtime = stripslashes($outtime);
					$note = stripslashes($note);
					$giorno = mysql_real_escape_string($giorno);
					$id_empl = mysql_real_escape_string($id_empl);
					$intime = mysql_real_escape_string($intime);
					$outtime = mysql_real_escape_string($outtime);
					$note = mysql_real_escape_string($note);


				  $arr = explode("-", $id_empl, 2);
				  $id_empl = $arr[0];
				  
                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_presenze_empl` (`giorno`,`id_empl`, `intime`, `outtime`, `note`) VALUES ('$giorno', '$id_empl', '$intime', '$outtime','$note');";
				  $msginsert = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_libdog_presenze_empl')";
				  $msglog= mysql_query($sql2);

               }else {
                  $msg = 'Id personale e Giorno';
				  echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="emplin.php" method='post' id='login'>
              <table>
			  <tr> <td> <font color=#eeee00> Giorno: </font>   </td> 
				<td><font color=#eeee00> Identificativo dipendente: </font> </td>
			  </tr> 
			  <tr> <td> <input type='date' name='giorno' /></td> 
				<td> 
         <?php
				$sqlcliente = "SELECT CONCAT(`id_Anagrafica_Empl`,'-',`name`) as persona FROM `libdog_Anagrafica_Empl` order by `name`;";
				$resultcliente = mysql_query($sqlcliente);
						echo "<select name='id_empl'> ";
						echo "$resultcliente";
				if ($resultcliente !== FALSE){
					while($row=mysql_fetch_array($resultcliente)){
						$persona = htmlspecialchars ($row["persona"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$persona'>$persona</option> ";
						}
					}
				echo "</select> ";
         ?>				
 </td> 
              </tr>
			  <tr> <td>  <font color=#eeee00> Orario Entrata: </font></td> 
				<td>  <font color=#eeee00> Orario Uscita: </font></td> 
			  </tr>
			  <tr> <td> <input type='time' name='intime' /> </td>
				<td> <input type='time' name='outtime' /> </td> 
			  </tr>
              <tr>  
				<td> <font color=#eeee00> Note: </font> </td> 
			  <td></td> 
			  </tr>
			  	<tr> 			
					<td><input type='text' name='note' /></td> 
					<td><input type='submit' name = "Inserisci" value='Inserisci' /></td> 
			   </tr>
			  </table>
            </form>
        	</div>	
		</div>
			</td></tr>
		</table>
  </p>

  						<h4><a href="login_success.php">Return to Menu</a></h4> <br>
						
						<?php 
						if ($userkind == 'superuser') { 
    						echo "<h4> <a href=\"insert_empl.php\">Inserisci orari</a> </h4> <br><br>";
							}
						?>
						
			 <table align=center border=2> <tr><td>Giorno</td><td>Nome</td><td>Entrata</td><td>Uscita</td><td>Note</td><td>Aggiorna</td></tr>
						<?php 
	
//		SELECT sum(`importo_fattura`) as totale, DATE_FORMAT(`data_trans`,'%Y-%m') as mese, `privato` FROM `libdog_paga_e_menti` group by `privato`, DATE_FORMAT(`data_trans`,'%Y-%m');

		$sqlrecap = "SELECT `giorno`,`libdog_Anagrafica_Empl`.`name`,`intime`,`outtime`,`note`, `libdog_presenze_empl`.`id_day`  FROM `libdog_Anagrafica_Empl`,`libdog_presenze_empl` WHERE `libdog_presenze_empl`.`id_empl` = `libdog_Anagrafica_Empl`.`id_Anagrafica_Empl`  and `status` is null and `giorno`=  DATE(NOW());";
						$resultrecap = mysql_query($sqlrecap);
						$counterrecap=0;
						while($rowrecap = mysql_fetch_row($resultrecap)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($rowrecap as $cellrecap)
        					if ($counterrecap < 6) {
        							if ($counterrecap<5) {
										echo "<td align=center><h3>$cellrecap</h3></td>";
									} else {
										echo "<td> <a href=\"modifyemplpresence.php?id_day=",$cellrecap,"\"><font size=\"1%\">Modifica uscita e note</font></a> </td>";
									}
        							$counterrecap++;
        					} else { 
        							echo ""; 
        							}
							    echo "</tr>";
							  $counterrecap=0;
							  }
						mysql_query($sqlrecap);
	// SELECT `giorno`,`libdog_Anagrafica_Cani`.`name`,`libdog_Anagrafica_Cani`.`breed`,`libdog_tariffario_all`.`descrizione` FROM `libdog_Anagrafica_Cani`,`libdog_tariffario_all`,`libdog_presenze_empl` WHERE `libdog_presenze_empl`.`id_empl` = `libdog_Anagrafica_Cani`.`idlibdog_Anagrafica_Cani` and `libdog_presenze_empl`.`id_pagamento` = `libdog_tariffario_all`.`id` and `giorno`=  DATE(NOW());

						?>
					</table>
					
<br><br><br>
					<h1> Calendario di questo mese</h1>		
						
<?php

//Se cambio mese procedo al recupero dei dati postati.
$mese="";
$anno="";
$mese=$_POST['mese'];
$anno=$_POST['anno'];
if ($mese=="") //se il mese non è stato valorizzato
{
	$time=time(); //il parametro time sarà uguale al timestamp corrente
}
else
{
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
	$prenotato=array("10"=>"10.png","11"=>"11.png","12"=>"12.png","13"=>"13.png","14"=>"14.png"); // prenotati ma non confermati avranno una colorazione gialla
	
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
<td rowspan="2">Nome</td>
<?
// partita la tabella procedo alla costruzione delle righe di intestazione

//$d servirà per verificare il ciclo dei giorni della settimana, evitando così di dover utilizzare una funzione ad ogni ciclo, basta fare un semplice controllo che una volta incrementato a 7 il valore di $d, questo riparta da 0
$d=$dati['start'];	 // indice della settimana del primo giorno del mese
	for ($i=1; $i<=$dati['giorni_mese'];$i++)
	{
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
	for ($i=1; $i<=$dati['giorni_mese'];$i++)
	{
		if ($d=="7") $d=0;
	?>	
		<td style="text-align:center;<? if ($d=="6" || $d=="0") echo "background-color:red;"; ?>"><? echo $i; ?></td>
	<?	
		$d++;
	}
	?>
</tr>
<?
//procedo alla prima query per estrarre i nomi dei dipendenti
mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
mysql_select_db("$db_name") or die ("cannot select DB");

$sql_lavori="select distinct `id_empl`, `name` from `libdog_presenze_empl` as a, `libdog_Anagrafica_Empl` as b where  CONCAT('".$dati['mese_num']."','-','".$dati['anno']."')=DATE_FORMAT(`giorno`,'%c-%Y') and a.`id_empl`=b.`id_Anagrafica_Empl` and `status` is not null order by `name`;";
// DEBUG
//	printf ("<br><br>");
//	printf ("sql_lavori: %s \n", $sql_lavori);

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
	$sql_pren="SELECT * FROM `libdog_presenze_empl` WHERE `id_empl`='".$row_lavori['id_empl']."' AND giorno >= '$dtstartmonth' AND giorno <= '$dtstopmonth' and `status` is not null ORDER BY giorno";
	//il sistema utilizzato è quello di controllare se vi sono prenotazioni che iniziano il mese precedente e finiscono dopo il primo giorno del mese interessato, poi se vi sono prenotazioni che iniziano e finiscono entro il mese corrente e quindi se vi sono prenotazioni che iniziano prima del fine mese corrente e finiscono nel mese successivo
	$query_pren=@mysql_query($sql_pren) or die (mysql_error());
// DEBUG
//	printf ("QUERY: %s \n\n", $sql_pren);
//	printf ("OUTPUT QUERY: %s \n\n", $query_pren);
//	printf ("ULTIMO GIORNO MESE: %s - %s - %s \n\n",$dati['giorni_mese'], $dati['mese_num'],$dati['anno']);
//	printf ("PRIMO GIORNO MESE: %s - %s - %s \n\n","1", $dati['mese_num'],$dati['anno']);
	
	
//recuperati questi dati inizio a salvarmi i valori interessati dentro degli array il cui indice non è altro, per unicità, che il timestamp del giorno in questione, che ad ogni ciclo incremento di  1 giorno = 86400 secondi
for ($i=$startmonth;$i<=$startmonth+(($dati['giorni_mese'])*86400);$i=$i+86400)	
{
	$team[$i]=0;
	$statusarray[$i]=false;
	$zona[$i]=false;
}	
	//recuperati questi dati inizio a salvarmi i valori interessati dentro degli array il cui indice non è altro, per unicità, che il timestamp del giorno in questione, che ad ogni ciclo incremento di  1 giorno = 86400 secondi. 
	
	// per poter distinguere le prenotazioni tra loro utilizzo il sistema di valorizzare cella per cella (giorno per giorno) l'array $team. Se il suo valore è uguale a 0 (verde) la team, quel giorno, è libera, se è uguale a 1 significa che è l'inizio o la fine della prenotazione, se è uguale a 2 vuol dire che la team è occupata per tutto il giorno, se è uguale a 3 vuol dire che quel giorno sono presenti un fine prenotazione ed un inizio prenotazione. Se il numero è maggiore (nero) significa che c'è qualcosa che non va. :)
	while ($row_pren=mysql_fetch_array($query_pren))
	{
// DEBUG
//		printf ("row_pren: %s \n\n", $row_pren);
//		printf ("row_pren['datalavoroinizio']: %s \n\n", $row_pren['datalavoroinizio']);
//		printf ("row_pren['datalavorofine']: %s \n\n", $row_pren['datalavorofine']);
//		printf ("row_pren['datainizio']: %s \n\n", $row_pren['datainizio']);
//		printf ("row_pren['datafine']: %s \n\n", $row_pren['datafine']);
		$dtdaymonth = new DateTime($row_pren['giorno']); 
		$dtdaymonth = $dtdaymonth->format('d'); // for example


	
			//$dw=date('j',$row_pren['datainizio']); //trovo il giorno del mese della data inizio
			$dw=$dtdaymonth;
// DEBUG
//	printf ("giorno of inizio lavori: %s \n\n",$dw);
//	printf ("<br>");
			$dw=$startmonth+(($dw-1)*86400); // e per regolarità sommo il timestamp di inizio mese al giorno del mese di data inizio prenotazione trasformato in secondi (sotratto di 1 perché il primo giorno è già valorizzato)
// DEBUG
//			printf ("dw post transformation: %s \n\n",$dw);
			$q=$dw;
			$team[$q]=$team[$q]+1; // aumento di 1 il valore di $team
			$statusarray[$q]=$row_pren['status'];
			$id[$q]=$row_pren['id_empl'];
			$in[$q]=$row_pren['giorno'];
			$out[$q]=$row_pren['giorno'];
			$intimearray[$q]=$row_pren['intime'];					
			$outtimearray[$q]=$row_pren['outtime'];
			$notearray[$q]=$row_pren['note'];
// DEBUG
//			printf ("Date utilizzate da in: %s - e out: %s\n\n",$in[$q],$out[$q]);
			// il sistema finora utilizzato, ovvero di incrementare i giorni sommando l'equivalente in secondi di un singolo giorno, va bene finché non ci si trova nei mesi in cui avviene il cambio dell'ora legale con quella solare e viceversa, ovvero ottobre e Marzo. Ma basta eseguire il controllo sulla data in questione ed eventualmente incrementare o decrementare il valore di 3600 secondi (1 ora)
			if (date("I",$row_pren['datafine'])==1 && $dati['mese_num']==3) {$row_pren['datafine']=$row_pren['datafine']+3600;};
			if (date("I",$row_pren['datafine'])==0 && $dati['mese_num']==10) {$row_pren['datafine']=$row_pren['datafine']-3600;};
			for ($q=($dw+86400);$q<=$row_pren['datafine'];$q=$q+86400)
			{
				if ($q<$row_pren['giorno'])
				{
					$team[$q]=$team[$q]+3;
					$statusarray[$q]=$row_pren['status'];
					$id[$q]=$row_pren['id_empl'];
					$in[$q]=$row_pren['giorno'];
					$out[$q]=$row_pren['giorno'];
					$intimearray[$q]=$row_pren['intime'];
					$outtimearray[$q]=$row_pren['outtime'];
					$notearray[$q]=$row_pren['note'];
				}
				else
				{
					$team[$q]=$team[$q]+1;
					$statusarray[$q]=$row_pren['status'];
					$id[$q]=$row_pren['id_empl'];
					$in[$q]=$row_pren['giorno'];
					$out[$q]=$row_pren['giorno'];
					$intimearray[$q]=$row_pren['intime'];
					$outtimearray[$q]=$row_pren['outtime'];
					$notearray[$q]=$row_pren['note'];
				}
			}

	}
//a questo punto i nostri array son ben che popolati, possiamo quindi procedere alla costruzione della tabella
$d=$dati['start'];
	
for ($i=$startmonth;$i<=$startmonth+(($dati['giorni_mese']-1)*86400);$i=$i+86400)	
{
//	$vin=date('d-m-Y',$in[$i]);
//	$vout=date('d-m-Y',$out[$i]);
	if ($d=="7")
	{
		$d=0;
	} 
	echo "<td style=\"text-align:center;";
	if ($d=="0" || $d=="6") 
	{
		echo "border:1px solid #ff020e;"; // per i Sabati e le Domeniche metto un bordo rosso alle celle della tabella
	}
	echo "\">";
		 if ($team[$i]=='0') // se il valore è uguale a zero e quindi la team è libera
		{
			 if ($userkind == 'superuser') { 
				echo "<a href=\"insert_empl.php\" title=\" Inserisci un turno \"> <img src=\"images/00.png\" alt=\"Entrato alle ".$intimearray[$i]." uscito alle ".$outtimearray[$i]." Note: ".$notearray[$i]." \"> </a>";
			} else { 
				echo "<img src=\"images/00.png\"> ";
			} 
		}
		else 
		{
			echo "<a href=\" . \" title=\"Entrato alle ".$intimearray[$i]." uscito alle ".$outtimearray[$i]." Note: ".$notearray[$i]." \"><img src=\"images/".$statusarray[$i].".png\" alt=\"Entrato alle ".$intimearray[$i]." uscito alle ".$outtimearray[$i]." Note: ".$notearray[$i]." \"> </a>";
		}
		
			
	echo "</td>";
	$d++;
}
?>
</tr> <tr> <td> &nbsp; </td>
<?
//a questo punto i nostri array son ben che popolati, possiamo quindi procedere alla costruzione della tabella
$d2=$dati['start'];
	
for ($i=$startmonth;$i<=$startmonth+(($dati['giorni_mese']-1)*86400);$i=$i+86400)	
{
//	$vin=date('d-m-Y',$in[$i]);
//	$vout=date('d-m-Y',$out[$i]);
	if ($d2=="7")
	{
		$d2=0;
	} 
	echo "<td style=\"text-align:center;";
	if ($d2=="0" || $d2=="6") 
	{
		echo "border:1px solid #ff020e;"; // per i Sabati e le Domeniche metto un bordo rosso alle celle della tabella
	}
	echo "\">";
	if ($team[$i]=='0') // se il valore è uguale a zero e quindi la team è libera
		{
			 echo "&nbsp;";
		} else {
			echo "<font size=1%>".$intimearray[$i]." - ".$outtimearray[$i]."</font>";
		}
		
			
	echo "</td>";
	$d2++;
}

?>
</tr>

<?
}
?>
</table>
</div>
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