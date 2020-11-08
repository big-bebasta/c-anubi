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
    <body vlink=#ffffff link=#ffffff>
    <table width=55% align=center>
    	<tr>
    		<td>
    		    <h1> Liberty Dog - Data entry</h1>
				<h3>  
					<?php
					$msg = "Benvenuta ".  $_SESSION['myusername']. " - ". $userkind;
					echo ( $msg );
				?>
  <br><br><br>
<table width=800px align="center"> <tr> <td width=400px>
  <div id="reportlist"  ">		
  <ul>
   <li class="Main-category">Personale:    
   <ol>
     <li><a href="#listaore">Lista orari personale mese corrente   </a>  </li>
	 <li><a href="#listaorepast">Lista orari personale mese precedente   </a>  </li>
     <li> <a href="#oremese">Sommatoria ore personale mese corrente  </a>   </li>
   </ol>
   <li class="Main-category">Spese:
   <ol>
     <li><a href="#spesetot">Spese totali </a></li>
     <li><a href="#spesemen">Spese mensili   </a>    </li>
   </ol>
  <li class="Main-category">Incassi:  
  <ol>
    <li><a href="#gainclient">Incasso per cliente  </a> </li>
    <li><a href="#gainmen">Incasso mensile </a>   </li> </ol>   </ul>
</div> 
</td><td width=400px>
  <div id="reportlist2"">		
  <ul>
   <li class="Main-category">Presenze:    
   <ol>
     <li><a href="#listacani">Presenze cani   </a>  </li>
     <li> <a href="#oremese">Pro-memoria settimanale  </a>   </li>
   </ol>
   <li class="Main-category">Fatture:
   <ol>
     <li><a href="#spesetot">Fatture non saldate </a></li>
     <li><a href="#spesetaxi">Taxi   </a>    </li>
	 <li><a href="#spesemen">Conguagli   </a>    </li>
   </ol>
  <li class="Main-category">Comunicazioni:  
  <ol>
    <li><a href="#gainclient">Comunicazioni ancora aperte  </a> </li>
    <li><a href="#gainmen">Comunicazioni chiuse </a>   </li> </ol>   </ul>
</div> 
</td></tr></table>

			<br><br>	<h4><a href="login_success.php">Return to Menu</a></h4> <br><br> 
  <?php  
 	echo "	<br><br> <h2 id=\"listaore\"> Lista orari personale mese corrente </h2>";
						
	if (($userkind == 'superuser') || ($userkind == 'user')) {

	echo "	<table align=center border=2> <tr> <td> Nome </td> <td> Giorno </td> <td> Ore </td> <td> Uscita </td> <td> Entrata </td><td> Modifica </td></tr> ";
	//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");
			$tbl_name="libdog_Anagrafica_Cani"; // Table name 
	//Connect to the server and select the database
			$sql = "SELECT `libdog_Anagrafica_Empl`.`name`, `giorno`, TIMEDIFF(`outtime`,`intime`), `outtime`, `intime`, `libdog_presenze_empl`.`id_day` FROM `libdog_presenze_empl` , `libdog_Anagrafica_Empl` where `id_empl` = `id_Anagrafica_Empl` and `intime` is not null and `outtime` is not null and `calendar` = '' and `status` is null and DATE_FORMAT(`giorno`,\"%Y%m\") > DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 MONTH),\"%Y%m\") order by `libdog_Anagrafica_Empl`.`name`, `giorno`;";
			$result = mysql_query($sql);
			$counter=0;
			$dogid=0;
			while($row = mysql_fetch_row($result)) {
		    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
		    foreach($row as $cell)
    			if ($counter < 5) {
					if ($counter == 0) {
						$dogid=$cell;
						}
    				echo "<td><h3>$cell</h3></td>";
    				$counter++;
    			} else { 
    				echo ""; 
    				}
				echo "<td><a href=\"modifyemplpresence.php?id_day=$cell\"> Modifica </a> </td></tr>";
			  $counter=0;
			  }
			$myusername = $_SESSION['myusername'] ;
			$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_Presenze_Empl')";
			mysql_query($sql2);
			}
			?>
					</table>
				</td>
			</tr>

    </table> 

	 <?php  
 	echo "	<br><br> <h2 id=\"listaorepast\"> Lista orari personale mese precedente </h2>";
						
	if (($userkind == 'superuser') || ($userkind == 'user')) {

	echo "	<table align=center border=2> <tr> <td> Nome </td> <td> Giorno </td> <td> Ore </td> <td> Uscita </td> <td> Entrata </td></tr> ";
	//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");
			$tbl_name="libdog_Anagrafica_Cani"; // Table name 
	//Connect to the server and select the database
			$sql = "SELECT `libdog_Anagrafica_Empl`.`name`, `giorno`, TIMEDIFF(`outtime`,`intime`), `outtime`, `intime` FROM `libdog_presenze_empl` , `libdog_Anagrafica_Empl` where `id_empl` = `id_Anagrafica_Empl` and `intime` is not null and `outtime` is not null and `calendar` = '' and `status` is null and DATE_FORMAT(`giorno`,\"%Y%m\") > DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -2 MONTH),\"%Y%m\") and DATE_FORMAT(`giorno`,\"%Y%m\") < DATE_FORMAT(CURDATE(),\"%Y%m\") order by `libdog_Anagrafica_Empl`.`name`, `giorno`;";
			$result = mysql_query($sql);
			$counter=0;
			$dogid=0;
			while($row = mysql_fetch_row($result)) {
		    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
		    foreach($row as $cell)
    			if ($counter < 5) {
					if ($counter == 0) {
						$dogid=$cell;
						}
    				echo "<td><h3>$cell</h3></td>";
    				$counter++;
    			} else { 
    				echo ""; 
    				}
				echo "</tr>";
			  $counter=0;
			  }
			$myusername = $_SESSION['myusername'] ;
			$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_Presenze_Empl')";
			mysql_query($sql2);
			}
			?>
					</table>
				</td>
			</tr>

    </table> 
	

  <?php  
 	echo "	<br><br> <h2 id=\"oremese\"> Lista sommatoria ore personale mese corrente </h2>";
						
	if ($userkind == 'superuser') {

	echo "	<table align=center border=2> <tr> <td> Nome </td> <td> Ore </td> <td> Minuti </td> <td> Mese precedente</td> <td> Ore </td> <td> Minuti </td> <td> Mese corrente</td></tr> ";
	//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");
			$tbl_name="libdog_Anagrafica_Cani"; // Table name 
	//Connect to the server and select the database
			$sql3 = "select prevmonth.`Nome`, prevmonth.`Ore` ,prevmonth.`Minuti` ,prevmonth.`Mese`, curmonth.`Ore` ,curmonth.`Minuti` ,curmonth.`Mese`   from ( SELECT `libdog_Anagrafica_Empl`.`name` as Nome, HOUR(SEC_TO_TIME( SUM( TIME_TO_SEC(TIMEDIFF(`outtime`,`intime`))))) as Ore, MINUTE(SEC_TO_TIME( SUM( TIME_TO_SEC(TIMEDIFF(`outtime`,`intime`))))) as Minuti, month(`giorno`) as Mese  FROM `libdog_presenze_empl` , `libdog_Anagrafica_Empl` 
where `id_empl` = `id_Anagrafica_Empl` 
and `intime` is not null 
and `outtime` is not null 
and `calendar` = ''
and `status` is null
and DATE_FORMAT(`giorno`,\"%Y%m\") = DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 MONTH),\"%Y%m\")
group by `libdog_Anagrafica_Empl`.`name`, month(`giorno`) 
) as prevmonth LEFT JOIN ( SELECT `libdog_Anagrafica_Empl`.`name` as Nome, HOUR(SEC_TO_TIME( SUM( TIME_TO_SEC(TIMEDIFF(`outtime`,`intime`))))) as Ore, MINUTE(SEC_TO_TIME( SUM( TIME_TO_SEC(TIMEDIFF(`outtime`,`intime`))))) as Minuti, month(`giorno`) as Mese  FROM `libdog_presenze_empl` , `libdog_Anagrafica_Empl` 
where `id_empl` = `id_Anagrafica_Empl` 
and `intime` is not null 
and `outtime` is not null 
and `calendar` = ''
and `status` is null
and month(`giorno`) = (month(CURDATE()))
group by `libdog_Anagrafica_Empl`.`name`, month(`giorno`) 
) as curmonth
ON prevmonth.`Nome` = curmonth.`Nome`
order by `Nome`;";

			$result = mysql_query($sql3);
			$counter=0;
			$dogid=0;
			while($row = mysql_fetch_row($result)) {
		    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
		    foreach($row as $cell)
    			if ($counter < 7) {
					if ($counter == 0) {
						$dogid=$cell;
						}
    				echo "<td><h3>$cell</h3></td>";
    				$counter++;
    			} else { 
    				echo ""; 
    				}
			    echo "</tr>";
			  $counter=0;
			  }
			}
			?>
					</table>
				</td>
			</tr>

    </table> 

	
	
  <?php  
 	echo "	<br><br> <h2 id=\"spesetaxi\"> Lista servizi taxi ultimi 60gg </h2>";
						
	if ($userkind == 'superuser') {

	echo "	<table align=center border=2> <tr> <td> Nome </td> <td> Giorno </td> <td> n. Taxi </td> <td> Orario Arrivo</td> <td> Orario Uscita </td> <td> Note del giorno </td> </tr> ";
	//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");
			$tbl_name="libdog_Anagrafica_Cani"; // Table name 
	//Connect to the server and select the database
			$sql3 = "SELECT b.`name`,`giorno`,`trasporto`,`intime`,`outtime`,`note` FROM `libdog_presenze_day` as a, `libdog_Anagrafica_Cani` as b WHERE a.`id_cane` =  b.`idlibdog_Anagrafica_Cani` and `trasporto` > 0 and DATEDIFF(curdate(),`giorno`) < 60 order by  b.`name`, `giorno` desc;";
			$result = mysql_query($sql3);
			$counter=0;
			$dogid=0;
			while($row = mysql_fetch_row($result)) {
		    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
		    foreach($row as $cell)
    			if ($counter < 6) {
					if ($counter == 0) {
						$dogid=$cell;
						}
    				echo "<td><h3>$cell</h3></td>";
    				$counter++;
    			} else { 
    				echo ""; 
    				}
			    echo "</tr>";
			  $counter=0;
			  }
			}
			?>
					</table>
				</td>
			</tr>

    </table> 	
	
	
	
	
			<br><br>	<h4><a href="login_success.php">Return to Menu</a></h4> <br><br> 
	
						</body>
</html>