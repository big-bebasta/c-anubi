<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
<link rel="stylesheet" href="style/style.css" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Forum GT - Calendario</title>
</head>
<body>
<div id="contenitore_generale">
<div id="header"><div id="testata"><h1>Gruppo di sviluppo del Forum GT</h1></div></div>
<div id="demo"><h2>Script per creazione calendario prenotazioni.</h2></div>
<div id="logo">
	<a href="http://www.giorgiotave.it/forum/" target="_blank"><img src="http://demogt.netsons.org/calendario/image/logo.png" alt="Logo Forum GT" title="Logo del Forum GT" /></a>&#32;
	<a href="http://samyorn.giorgiotave.it/gruppi/115-PHP-Project/" target="_blank"><img src="http://demogt.netsons.org/newsdb/news/php-mysql_project.jpg" alt="Logo progetto PHP-MySQL" title="Logo del gruppo di sviluppo aree PHP-MySQL del Network GT" /></a>
</div>
<h1>Troverai dei dati gia inseriti nei mesi di Marzo-Aprile 2010. ;-)</h1>
<?php
//inseriamo i parametri di connessione al Database
$db_host = "mysqlhost"; // Host name 
$db_user = "uln6tjuc_dataentry"; // Mysql username 
$db_pass = "kN0Tt3n"; // Mysql password 
$db_name = "uln6tjuc_libdog"; // Database name 

$connection = @mysql_connect($db_host,$db_user,$db_pass)
	or die ("Connessione al server non stabilita");
$db = @mysql_select_db($db_name,$connection)
	or die ("Connessione al Db non stabilita");

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
	$dati['mese_text'] = date("F", $time); // Mese Corrente ( testuale )
	$dati['anno'] = date("Y", $time); // Anno
	$dati['start'] = date("w", mktime(0,0,0, $dati['mese_num'], 1, $dati['anno'])); // Giorno della settimana del primo giorno del mese
	$dati['giorni_mesi'][1]=(date('L',$time)==0)?28:29; // calcolo giorni mese di Febbraio
	$dati['giorni_mese'] = $dati['giorni_mesi'][$dati['mese_num']-1]; // Giorni del mese corrente
	$dati['settimana']=array("D","L","M","M","G","V","S");
	$prenotato=array("0"=>"0.png","1"=>"1p.png","2"=>"2p.png","3"=>"3p.png"); // prenotati ma non confermati avranno una colorazione gialla
	$confermato=array("0"=>"0.png","1"=>"1c.png","2"=>"2c.png","3"=>"3c.png"); // confermati avranno una colorazione rossa
	
//procedo quindi a creare due form che mi portino al mese precedente ed al mese successivo a quello attualmente visualizzato facendo attenzione al cambio di anno, nel caso si stia visualizzando il mese di Gennaio il form del mese precedente mi dovrà postare il mese 12 e l'anno corrente -1. Speculare per il mese di dicembre, il form per il mese successivo dovrà postare il mese 1 e l'anno incrementato di 1	
?>
<table border="0" width="100%">
	<tr>
		<td width="33%"><form action="<? echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="hidden" name="mese" value="<? if ($dati['mese_num']=="1") { echo "12";} else {echo $dati['mese_num']-1;} ?>" /><input type="hidden" name="anno" value="<? if ($dati['mese_num']=="1"){ echo $dati['anno']-1;} else {echo $dati['anno'];}?>" /><input type="submit" value="&nbsp;&lt;&nbsp;" /></form></td>
		<td width="33%"><? echo "Mese: <strong>".$dati['mese_text']."</strong> Anno: <strong>".$dati['anno'] ?></strong></td>
		<td width="33%"><form action="<? echo $_SERVER['REQUEST_URI']; ?>" method="post"><input type="hidden" name="mese" value="<? if ($dati['mese_num']=="12") { echo "1";} else {echo $dati['mese_num']+1;} ?>" /><input type="hidden" name="anno" value="<? if ($dati['mese_num']=="12"){ echo $dati['anno']+1;} else {echo $dati['anno'];}?>" /><input type="submit" value="&nbsp;&gt;&nbsp;" /></form></td>	
	</tr>
</table>
<table border="1"  class="calendario" align="center">
<caption><strong>Calendario</strong></caption>
<tr>
<td rowspan="2">Stanze</td>
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
//procedo alla prima query per estrarre i nomi delle stanze
$sql_stanze="SELECT * FROM stanze ORDER BY nome";
$query_stanze=@mysql_query($sql_stanze) or die (mysql_error());
while ($row_stanze=mysql_fetch_array($query_stanze)) // ed inizio a ciclare questo risultato
{
	echo "<tr><td class=\"name\">".$row_stanze['nome']."</td>";
	$startmonth=mktime(0,0,0,$dati['mese_num'],1,$dati['anno']); // mi valorizzo il timestamp del primo giorno del mese 
	$stopmonth=mktime(0,0,0,$dati['mese_num'],$dati['giorni_mese'],$dati['anno']); // e dell'ultimo giorno del mese
	//estraggo quindi le prenotazioni del mese corrente per questa stanza
	$sql_pren="SELECT * FROM libdog_prenotazioni WHERE id_stanza='".$row_stanze['id']."' AND ((datain < '$startmonth' AND dataout >= '$startmonth') OR (datain >='$startmonth' AND dataout <= '$stopmonth') OR (datain <= '$stopmonth' AND dataout > '$stopmonth')) ORDER BY datain";
	//il sistema utilizzato è quello di controllare se vi sono prenotazioni che iniziano il mese precedente e finiscono dopo il primo giorno del mese interessato, poi se vi sono prenotazioni che iniziano e finiscono entro il mese corrente e quindi se vi sono prenotazioni che iniziano prima del fine mese corrente e finiscono nel mese successivo
	$query_pren=@mysql_query($sql_pren) or die (mysql_error());

//recuperati questi dati inizio a salvarmi i valori interessati dentro degli array il cui indice non è altro, per unicità, che il timestamp del giorno in questione, che ad ogni ciclo incremento di  1 giorno = 86400 secondi
for ($i=$startmonth;$i<=$startmonth+(($dati['giorni_mese'])*86400);$i=$i+86400)	
{
	$stanza[$i]=0;
	$stato[$i]=false;
	$nome[$i]=false;
}	
	//recuperati questi dati inizio a salvarmi i valori interessati dentro degli array il cui indice non è altro, per unicità, che il timestamp del giorno in questione, che ad ogni ciclo incremento di  1 giorno = 86400 secondi. 
	
	// per poter distinguere le prenotazioni tra loro utilizzo il sistema di valorizzare cella per cella (giorno per giorno) l'array $stanza. Se il suo valore è uguale a 0 (verde) la stanza, quel giorno, è libera, se è uguale a 1 significa che è l'inizio o la fine della prenotazione, se è uguale a 2 vuol dire che la stanza è occupata per tutto il giorno, se è uguale a 3 vuol dire che quel giorno sono presenti un fine prenotazione ed un inizio prenotazione. Se il numero è maggiore (nero) significa che c'è qualcosa che non va. :)
	while ($row_pren=mysql_fetch_array($query_pren))
	{
		if ($row_pren['datain']<$startmonth && $row_pren['dataout']>$startmonth) //se la prenotazione inizia il mese precedente e finisce dopo il primo giorno del mese
		{
			//estraggo il nominativo della prenotazione
			$sql_anagr="SELECT * FROM libdog_Anagrafica_Cani WHERE idlibdog_Anagrafica_Cani='".$row_pren['id_cliente']."'";
			$query_anagr=@mysql_query($sql_anagr) or die (mysql_error());
			$array_anagr=mysql_fetch_array($query_anagr);
			
			
			$q=$startmonth; //parto dal primo giorno del mese, relativo alla stanza di cui si sta eseguendo il ciclo
			$stanza[$q]=$stanza[$q]+3; 
			$stato[$q]=$row_pren['stato'];  // valorizzo lo stato prenotato o confermato
			$id[$q]=$row_pren['idlibdog_Anagrafica_Cani']; // valorizzo l'id della prenotazione
			$nome[$q]=$array_anagr['intestazione']; //valorizzo l'anagrafica del cliente
			$in[$q]=$row_pren['datain']; //valorizzo la data inizio prenotazione
			$out[$q]=$row_pren['dataout']; //valorizzo la data fine prenotazione
			
			for ($q=$startmonth+86400;$q<=$row_pren['dataout'];$q=$q+86400)
			{
				if ($q<$row_pren['dataout'])
				{
					$stanza[$q]=$stanza[$q]+3;
					$stato[$q]=$row_pren['stato'];
					$id[$q]=$row_pren['idlibdog_Anagrafica_Cani'];
					$nome[$q]=$array_anagr['intestazione'];
					$in[$q]=$row_pren['datain'];
					$out[$q]=$row_pren['dataout'];
				}
				else
				{
					$stanza[$q]=$stanza[$q]+1;
					$id[$q]=$row_pren['idlibdog_Anagrafica_Cani'];
					$stato[$q]=$row_pren['stato'];
					$nome[$q]=$array_anagr['intestazione'];
					$in[$q]=$row_pren['datain'];
					$out[$q]=$row_pren['dataout'];
				}
			}
		}
		else if ($row_pren['datain']>=$startmonth) // se la data inizio prenotazione è maggiore del primo giorno del mese
		{
			//estraggo il nominativo della prenotazione
			$sql_anagr="SELECT * FROM libdog_Anagrafica_Cani WHERE id='".$row_pren['id_cliente']."'";
			$query_anagr=@mysql_query($sql_anagr) or die (mysql_error());
			$array_anagr=mysql_fetch_array($query_anagr);
			
			$dw=date('d',$row_pren['datain']); //trovo il giorno del mese della data inizio
			$dw=$startmonth+(($dw-1)*86400); // e per regolarità sommo il timestamp di inizio mese al giorno del mese di data inizio prenotazione trasformato in secondi (sotratto di 1 perché il primo giorno è già valorizzato)
			$q=$dw;
			$stanza[$q]=$stanza[$q]+1; // aumento di 1 il valore di $stanza
			$stato[$q]=$row_pren['stato'];
			$id[$q]=$row_pren['idlibdog_Anagrafica_Cani'];
			$nome[$q]=$array_anagr['intestazione'];
			$in[$q]=$row_pren['datain'];
			$out[$q]=$row_pren['dataout'];
			// il sistema finora utilizzato, ovvero di incrementare i giorni sommando l'equivalente in secondi di un singolo giorno, va bene finché non ci si trova nei mesi in cui avviene il cambio dell'ora legale con quella solare e viceversa, ovvero ottobre e Marzo. Ma basta eseguire il controllo sulla data in questione ed eventualmente incrementare o decrementare il valore di 3600 secondi (1 ora)
			if (date("I",$row_pren['dataout'])==1 && $dati['mese_num']==3) {$row_pren['dataout']=$row_pren['dataout']+3600;};
			if (date("I",$row_pren['dataout'])==0 && $dati['mese_num']==10) {$row_pren['dataout']=$row_pren['dataout']-3600;};
			for ($q=($dw+86400);$q<=$row_pren['dataout'];$q=$q+86400)
			{
				if ($q<$row_pren['dataout'])
				{
					$stanza[$q]=$stanza[$q]+3;
					$stato[$q]=$row_pren['stato'];
					$id[$q]=$row_pren['idlibdog_Anagrafica_Cani'];
					$nome[$q]=$array_anagr['intestazione'];
					$in[$q]=$row_pren['datain'];
					$out[$q]=$row_pren['dataout'];
				}
				else
				{
					$stanza[$q]=$stanza[$q]+1;
					$stato[$q]=$row_pren['stato'];
					$id[$q]=$row_pren['idlibdog_Anagrafica_Cani'];
					$nome[$q]=$array_anagr['intestazione'];
					$in[$q]=$row_pren['datain'];
					$out[$q]=$row_pren['dataout'];
				}
			}
		}
		else if ($row_pren['dataout']=$startmonth) // se la data di fine prenotazione è uguale al primo giorno del mese
		{
			$q=$startmonth;
			$stanza[$q]=$stanza[$q]+1;
			$stato[$q]=$row_pren['stato'];
			$id[$q]=$row_pren['idlibdog_Anagrafica_Cani'];
			$nome[$q]=$array_anagr['intestazione'];
			$in[$q]=$row_pren['datain'];
			$out[$q]=$row_pren['dataout'];
		}
	}
//a questo punto i nostri array son ben che popolati, possiamo quindi procedere alla costruzione della tabella
$d=$dati['start'];
	
for ($i=$startmonth;$i<=$startmonth+(($dati['giorni_mese']-1)*86400);$i=$i+86400)	
{
	$vin=date('d-m-Y',$in[$i]);
	$vout=date('d-m-Y',$out[$i]);
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
		 if ($stanza[$i]=='0') // se il valore è uguale a zero e quindi la stanza è libera
		{
			echo "<img src=\"image/0.png\" alt=\"\" />";
		}
		else if ($stanza[$i]=='1') // se il valore è uguale a 1 e quindi si tratta di un inizio prenotazione o un fine prenotazione
		{
			$back=($stato[$i]==0)?$prenotato['1']:$confermato['1']; // controllo se la prenotazione è confermata o meno
			
			//nella costruzione del link dell'immagine inserisco l'id della prenotazione per recuperare questo dato quando andrò nella pagina della prenotazione e come title del link metto i dati importanti della prenotazione "Prenotazione Mario Rossi dal 01/01/2010 al 06/01/2010"
			echo "<a href=\"prenotazioni.php?id=".$id[$i]."\" title=\"Prenotazione ".$nome[$i]." dal ".$vin." al ".$vout."\"><img src=\"image/".$back."\" alt=\"\" /></a>";
		}
		else if ($stanza[$i]=='2')  // se il valore è uguale a 2 e quindi la stanza è occupata tutta la giornata
		{
			$back=($stato[$i]==0)?$prenotato['2']:$confermato['2'];
			echo "<a href=\"prenotazioni.php?id=".$id[$i]."\" title=\"Prenotazione ".$nome[$i]." dal ".$vin." al ".$vout."\"><img src=\"image/".$back."\" alt=\"\" /></a>";
		}
		else if ($stanza[$i]=='3') // se il valore è uguale a 3 e quindi abbiamo una fine prenotazione ed un inizio prenotazione lo stesso giorno
		{
			$back=($stato[$i]==0)?$prenotato['3']:$confermato['3'];
			echo "<a href=\"prenotazioni.php?id=".$id[$i]."\" title=\"Prenotazione ".$nome[$i]." dal ".$vin." al ".$vout."\"><img src=\"image/".$back."\" alt=\"\" /></a>";
		}
		else // se il valore è superiore a 3, e significa che qualcosa non va... :)
		{
			echo "<img src=\"image/black.png\" alt=\"\" />";
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
<div id="footer">Special thanks to: <a href="http://samyorn.giorgiotave.it" target="_blank">Samyorn</a>.</div>
</div>
</body>
</html>