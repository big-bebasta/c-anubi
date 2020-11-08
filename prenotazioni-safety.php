<?php
   session_start();
   ob_start();
	openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_LOCAL0);
// log the attempt
	$access = date("Y/m/d H:i:s");
	syslog(LOG_WARNING, "Login attempt: $access {$_SESSION['myusername']}");
	if( !isset($_SESSION['myusername']) )
		{
		header("location:index.php");
		session_destroy();
		exit();
		}
	$id="";
	$id=$_GET['id'];
	?>
<html>
	<head>
		<title>Safety Cat - Calendar update</title>
	<style>
		h1   {color:#000000; font-size:250%; text-align:center;}
		h2   {color:#000000;}
		h3   {color:#000000; font-size:200%; text-align:center;}
		h4   {color:#000000; font-size:22px; text-align:center;}
		h6   {color:#000000; font-size:16px; text-align:center;}
		p    {margin-left:50px;}
		body {background-color:#eeeeee; 
				background-image:url('./images/backgroundsafetycat.png'); 
				background-repeat: repeat;
				background-attachment:fixed;
				background-opacity: 0.1;
				background-filter: alpha(opacity=10); /* For IE8 and earlier */
				background-size:40%;
				-webkit-background-size: cover;
				-moz-background-size: cover;
				-o-background-size: cover;
				background-position:center top;
				}
		/* unvisited link */ 
		a:link {   color: black; }
		/* visited link */
		a:visited {  color: red; }
		/* mouse over link */
		a:hover {    color: green; }
		/* selected link */
		a:active {  color: blue;  }
		
			div.transbox {
		margin: 20px;
		text-align:center;
		background-color: #ffffff;
		border: 1px solid black;
		opacity: 0.6;
		filter: alpha(opacity=60); /* For IE8 and earlier */
		}

	div.transbox h4 {
		margin: 5%;
		text-align:center;
		font-weight: bold;
		color: #000000;
		}	
		
</style>
</head>
    <body vlink=#ffffff link=#ffffff>
	<table width=80% align=center>
    	<tr>
    		<td width=20%> 	<p align=center> <img width=80% src="./images/gatto66.png"> </p> </td>
	<td width=60%>   <h1> Safety Cat - Editor Lavori</h1>  </td> </tr>
	 <tr> <td> <h3> Si sta modificando <br> il lavoro con ID: 
<?
	if ($id!="")
	{
		printf ("%s\n", $id);
	}
	else
	{
		echo "<br><br>Non hai selezionato una prenotazione, <br><a href=\"login_sulcess.php\">ritorna al calendario o inserisci un nuovo lavoro</a></h1>";
	}
?>
</h3>
</td>
	<td>



    <div class = "container form-signin">
         
         <?php
            $msg = '';
			$host="89.46.111.37"; // Host name 
			$username="Sql1066350"; // Mysql username 
			$password="13v679566y"; // Mysql password 
			$db_name="Sql1066350_3"; // Database name 
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Salva']) && !empty($_POST['id_lavoro']) ) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: $name, $breed, $aggressive, $chip, $notes, $id_padrone, $birth, $gender, $activesex, $fur, $allergiefood, $allergiefarm, $sickness
//<!--	`id_lavoro` ,`datalavoroinizio` ,`id_cliente` ,`datalavorofine` ,`descrizione` ,
//		`balconi` ,`finestre` , `terrazzi` ,`prezzo` ,`id_fattura` ,
//		`spese` ,`team` ,`commenti` ,`rete_alta` ,`note` ,
//		`rete_bassa` ,`datafine` ,`datainizio` ,`status`, `immagini`
//-->
					$id_lavoro=$_POST['id_lavoro']; 
					$datalavoroinizio=$_POST['datalavoroinizio']; 
					$id_cliente=$_POST['id_cliente']; 
					$datalavorofine=$_POST['datalavorofine']; 
					$descrizione=$_POST['descrizione']; 
					$balconi=$_POST['balconi']; 
					$finestre=$_POST['finestre']; 
					$terrazzi=$_POST['terrazzi']; 
					$prezzo=$_POST['prezzo']; 
					$id_fattura=$_POST['id_fattura']; 
					$spese=$_POST['spese']; 
					$team=$_POST['team']; 
					$rete_alta=$_POST['rete_alta']; 
					$rete_bassa=$_POST['rete_bassa']; 
					$note=$_POST['note']; 
					$commenti=$_POST['commenti']; 
					$datafine=$_POST['datafine']; 
					$datainizio=$_POST['datainizio']; 
					$status=$_POST['status']; 
					$immagini=$_POST['immagini']; 

// To protect MySQL injection (more detail about MySQL injection)
					$id_lavoro = stripslashes($id_lavoro);
					$datalavoroinizio = stripslashes($datalavoroinizio);
					$id_cliente = stripslashes($id_cliente);
					$datalavorofine = stripslashes($datalavorofine);
					$descrizione = stripslashes($descrizione);
					$balconi = stripslashes($balconi);
					$finestre = stripslashes($finestre);
					$terrazzi = stripslashes($terrazzi);
					$prezzo = stripslashes($prezzo);
					$id_fattura = stripslashes($id_fattura);
					$spese = stripslashes($spese);
					$team = stripslashes($team);
					$rete_alta = stripslashes($rete_alta);
					$rete_bassa = stripslashes($rete_bassa);
					$note = stripslashes($note);
					$commenti = stripslashes($commenti);
					$datafine = stripslashes($datafine);
					$datainizio = stripslashes($datainizio);
					$status = stripslashes($status);
					$immagini = stripslashes($immagini);
					$id_lavoro = mysql_real_escape_string($id_lavoro);
					$datalavoroinizio = mysql_real_escape_string($datalavoroinizio);
					$id_cliente = mysql_real_escape_string($id_cliente);
					$datalavorofine = mysql_real_escape_string($datalavorofine);
					$descrizione = mysql_real_escape_string($descrizione);
					$balconi = mysql_real_escape_string($balconi);
					$finestre = mysql_real_escape_string($finestre);
					$terrazzi = mysql_real_escape_string($terrazzi);
					$prezzo = mysql_real_escape_string($prezzo);
					$id_fattura = mysql_real_escape_string($id_fattura);
					$spese = mysql_real_escape_string($spese);
					$team = mysql_real_escape_string($team);
					$rete_alta = mysql_real_escape_string($rete_alta);
					$rete_bassa = mysql_real_escape_string($rete_bassa);
					$note = mysql_real_escape_string($note);
					$commenti = mysql_real_escape_string($commenti);
					$datafine = mysql_real_escape_string($datafine);
					$datainizio = mysql_real_escape_string($datainizio);
					$status = mysql_real_escape_string($status);
					$immagini = mysql_real_escape_string($immagini);

	//				INSERT INTO  `Sql1066350_3`.`safetycat_Calendario_Lavori` (`id_lavoro` ,`datalavoroinizio` ,`id_cliente` ,`datalavorofine` ,`descrizione` ,`balconi` ,`finestre` ,`prezzo` ,`id_fattura` ,`note` ,`terrazzi` ,`spese` ,`team` ,`commenti` ,`rete_alta` ,`rete_bassa` ,`datafine` ,`datainizio` ,`status`)
	//				VALUES ('3',  '2017-07-31',  '2',  '2017-07-31',  'test',  '',  '',  '',  '',  '',  '',  '',  '',  '', NULL , NULL ,  '2017-07-31 00:00:00',  '2017-07-31 00:00:00',  '0')

 //                 $sql2 = "update  `Sql1066350_3`.`safetycat_Calendario_Lavori` set (`id_lavoro` ,`datalavoroinizio` ,`id_cliente` ,`datalavorofine` ,`descrizione` ,`balconi` ,`finestre` ,`prezzo` ,`id_fattura` ,`note` ,`terrazzi` ,`spese` ,`team` ,`commenti` ,`rete_alta` ,`rete_bassa` ,`datafine` ,`datainizio` ,`status`,`immagini`) VALUES ('$id_lavoro','$datalavoroinizio','$id_cliente','$datalavorofine','$descrizione','$balconi','$finestre','$prezzo','$id_fattura','$note','$terrazzi','$spese','$team','$commenti','$rete_alta','$rete_bassa','$datafine','$datainizio','$status','$immagini');";
				  $msginsert = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into safetycat_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_Anagrafica_Cani')";
				  $msglog= mysql_query($sql2);

               } else if ( $id==''){
					$msg = '<div class="background"> 	<div class="transbox"> Bisogna valorizzare l identificativo del lavoro </div> </div>';			    
					echo ( $msg );
				  // Define my variables: $name, $breed, $aggressive, $chip, $notes, $id_padrone, $birth, $gender, $activesex, $fur, $allergiefood, $allergiefarm, $sickness
//<!--	`id_lavoro` ,`datalavoroinizio` ,`id_cliente` ,`datalavorofine` ,`descrizione` ,
//		`balconi` ,`finestre` , `terrazzi` ,`prezzo` ,`id_fattura` ,
//		`spese` ,`team` ,`commenti` ,`rete_alta` ,`note` ,
//		`rete_bassa` ,`datafine` ,`datainizio` ,`status`, `immagini`
//-->
					$id_lavoro=$_POST['id_lavoro']; 
					$datalavoroinizio=$_POST['datalavoroinizio']; 
					$id_cliente=$_POST['id_cliente']; 
					$datalavorofine=$_POST['datalavorofine']; 
					$descrizione=$_POST['descrizione']; 
					$balconi=$_POST['balconi']; 
					$finestre=$_POST['finestre']; 
					$terrazzi=$_POST['terrazzi']; 
					$prezzo=$_POST['prezzo']; 
					$id_fattura=$_POST['id_fattura']; 
					$spese=$_POST['spese']; 
					$team=$_POST['team']; 
					$rete_alta=$_POST['rete_alta']; 
					$rete_bassa=$_POST['rete_bassa']; 
					$note=$_POST['note']; 
					$commenti=$_POST['commenti']; 
					$datafine=$_POST['datafine']; 
					$datainizio=$_POST['datainizio']; 
					$status=$_POST['status']; 
					$immagini=$_POST['immagini']; 

// To protect MySQL injection (more detail about MySQL injection)
					$id_lavoro = stripslashes($id_lavoro);
					$datalavoroinizio = stripslashes($datalavoroinizio);
					$id_cliente = stripslashes($id_cliente);
					$datalavorofine = stripslashes($datalavorofine);
					$descrizione = stripslashes($descrizione);
					$balconi = stripslashes($balconi);
					$finestre = stripslashes($finestre);
					$terrazzi = stripslashes($terrazzi);
					$prezzo = stripslashes($prezzo);
					$id_fattura = stripslashes($id_fattura);
					$spese = stripslashes($spese);
					$team = stripslashes($team);
					$rete_alta = stripslashes($rete_alta);
					$rete_bassa = stripslashes($rete_bassa);
					$note = stripslashes($note);
					$commenti = stripslashes($commenti);
					$datafine = stripslashes($datafine);
					$datainizio = stripslashes($datainizio);
					$status = stripslashes($status);
					$immagini = stripslashes($immagini);
					$id_lavoro = mysql_real_escape_string($id_lavoro);
					$datalavoroinizio = mysql_real_escape_string($datalavoroinizio);
					$id_cliente = mysql_real_escape_string($id_cliente);
					$datalavorofine = mysql_real_escape_string($datalavorofine);
					$descrizione = mysql_real_escape_string($descrizione);
					$balconi = mysql_real_escape_string($balconi);
					$finestre = mysql_real_escape_string($finestre);
					$terrazzi = mysql_real_escape_string($terrazzi);
					$prezzo = mysql_real_escape_string($prezzo);
					$id_fattura = mysql_real_escape_string($id_fattura);
					$spese = mysql_real_escape_string($spese);
					$team = mysql_real_escape_string($team);
					$rete_alta = mysql_real_escape_string($rete_alta);
					$rete_bassa = mysql_real_escape_string($rete_bassa);
					$note = mysql_real_escape_string($note);
					$commenti = mysql_real_escape_string($commenti);
					$datafine = mysql_real_escape_string($datafine);
					$datainizio = mysql_real_escape_string($datainizio);
					$status = mysql_real_escape_string($status);
					$immagini = mysql_real_escape_string($immagini);

	//				INSERT INTO  `Sql1066350_3`.`safetycat_Calendario_Lavori` (`id_lavoro` ,`datalavoroinizio` ,`id_cliente` ,`datalavorofine` ,`descrizione` ,`balconi` ,`finestre` ,`prezzo` ,`id_fattura` ,`note` ,`terrazzi` ,`spese` ,`team` ,`commenti` ,`rete_alta` ,`rete_bassa` ,`datafine` ,`datainizio` ,`status`)
	//				VALUES ('3',  '2017-07-31',  '2',  '2017-07-31',  'test',  '',  '',  '',  '',  '',  '',  '',  '',  '', NULL , NULL ,  '2017-07-31 00:00:00',  '2017-07-31 00:00:00',  '0')

                  $sql2 = "INSERT INTO  `Sql1066350_3`.`safetycat_Calendario_Lavori` (`id_lavoro` ,`datalavoroinizio` ,`id_cliente` ,`datalavorofine` ,`descrizione` ,`balconi` ,`finestre` ,`prezzo` ,`id_fattura` ,`note` ,`terrazzi` ,`spese` ,`team` ,`commenti` ,`rete_alta` ,`rete_bassa` ,`datafine` ,`datainizio` ,`status`,`immagini`) VALUES ('$id_lavoro','$datalavoroinizio','$id_cliente','$datalavorofine','$descrizione','$balconi','$finestre','$prezzo','$id_fattura','$note','$terrazzi','$spese','$team','$commenti','$rete_alta','$rete_bassa','$datafine','$datainizio','$status','$immagini');";
				  $msginsert = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into safetycat_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_Anagrafica_Cani')";
				  $msglog= mysql_query($sql2);

					} else   {
				  $msg = '';
				  echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      
 
<div class="background">
  <div class="transbox">
	<table>
	<tr>
     <div class = "container">
        	<div id='loginform'>
            <form action="prenotazioni.php" method='post' id='login'>
              <table border=2 align=center>
        <?php
			$sql6 = "SELECT * FROM `Sql1066350_3`.`safetycat_Calendario_Lavori` WHERE `id_lavoro`='$id';";
			$resultwork = mysql_query($sql6);
			while($row = mysql_fetch_array($resultwork)){
		?>
			
			  <tr> <td> <font color=#aa0000> <b> ID lavoro: </b> </font>   </td> <td> <input type='text' name='id_lavoro'  value="<?php echo $row['id_lavoro']; ?>"/></td>   <td><font color=#aa0000> <b> Data inizio lavoro: </b> </font></td> <td> <input type='date' name='datalavoroinizio' value="<?php echo $row['datalavoroinizio']; ?>"/></td> </tr> 
              <tr> <td> <font color=#aa0000> <b> ID cliente: </b> </font>   </td> <td> <input type='text' name='id_cliente'  value="<?php echo $row['id_cliente']; ?>"/></td>   <td><font color=#aa0000>  <b>Data fine lavoro: </b> </font></td> <td> <input type='date' name='datalavorofine' value="<?php echo $row['datalavorofine']; ?>"/></td> </tr> 
              <tr> <td> <font color=#aa0000> <b> Descrizione: </b> </font>   </td> <td> <input type='text' name='descrizione' value="<?php echo $row['descrizione']; ?>"/></td>   <td><font color=#aa0000>  <b>Note: </b> </font></td> <td> <input type='text' name='note' value="<?php echo $row['note']; ?>"/></td> </tr> 
              <tr> <td> <font color=#aa0000> <b> Balconi: </b> </font>   </td> <td> <input type='text' name='balconi' value="<?php echo $row['balconi']; ?>"/></td>   <td><font color=#aa0000>  <b>Commenti: </b> </font></td> <td> <input type='text' name='commenti' value="<?php echo $row['commenti']; ?>"/></td> </tr> 
              <tr> <td> <font color=#aa0000> <b> Terrazzi: </b> </font>   </td> <td> <input type='text' name='terrazzi' value="<?php echo $row['terrazzi']; ?>"/></td>   <td><font color=#aa0000> <b> Team lavoro: </b> </font></td> <td> <input type='text' name='team' value="<?php echo $row['team']; ?>"/></td> </tr> 
              <tr> <td> <font color=#aa0000> <b> Finestre: </b> </font>   </td> <td> <input type='text' name='finestre' value="<?php echo $row['finestre']; ?>"/></td>   <td><font color=#aa0000>  <b>Spese: </b> </font></td> <td> <input type='text' name='spese' value="<?php echo $row['spese']; ?>"/></td> </tr> 
              <tr> <td> <font color=#aa0000> <b> Rete alta: </b> </font>   </td> <td> <input type='text' name='rete_alta' value="<?php echo $row['rete_alta']; ?>"/></td>   <td><font color=#aa0000> <b> Prezzo: </b> </font></td> <td> <input type='text' name='prezzo' value="<?php echo $row['prezzo']; ?>"/></td> </tr> 
              <tr> <td> <font color=#aa0000> <b> Rete bassa: </b> </font>   </td> <td> <input type='text' name='rete_bassa' value="<?php echo $row['rete_bassa']; ?>"/></td>   <td><font color=#aa0000>  <b>ID fattura: </b> </font></td> <td> <input type='text' name='id_fattura' value="<?php echo $row['id_fattura']; ?>"/></td> </tr> 
              <tr> <td> <font color=#aa0000> <b> Immagini: </b> </font>   </td> <td> <input type='text' name='immagini' value="<?php echo $row['immagini']; ?>"/></td>   <td><font color=#aa0000>  <b>Stato lavori: </b> </font></td> <td> <input type='text' name='status' value="<?php echo $row['status']; ?>"/></td> </tr> 
              <tr>  <td></td> <td></td> <td></td> <td><input type='submit' name = "Salva" value='Salva' /></td> </tr>
			  </table>		<br><br>
            </form>
        	</div>
			</td></tr>
		<?php
			} //Close while{} loop
        ?>
		</table>

	</div>
  </div>
 </div>
</td></tr>
</table>

</td></tr>
</table>

<h2 align=center><a href="login_sulcess.php">Torna al Calendario</a><h2>
</body>
</html>