<?php
   session_start();
   ob_start();
	openlog("myScriptLog", LOG_PID | LOG_PERROR, LOG_LOCAL0);
// log the attempt
	$access = date("Y/m/d H:i:s");
	syslog(LOG_WARNING, "Login attempt: $access {$_SESSION['myusername']}");
	if( !isset($_SESSION['myusername']) )
		{
		header("location:main.php");
		session_destroy();
		exit();
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
    		    <h1> Liberty Dog - Listino prezzi</h1>
				<h3>  
					<?php
					$msg = "Benvenuta ".  $_SESSION['myusername'];
					echo ( $msg );
				?>
  <br>

				</h3>
<br><br><br>	

						
						 <h2 align=center>Listino prezzi<h2>
					<table align=center border=2> <tr> <td> Identificativo </td> <td> Tipologia </td> <td> Descrizione </td> <td> Prezzo </td> </tr>
						<?php 
						$host="mysqlhost"; // Host name 
						$username="uln6tjuc_dataentry"; // Mysql username 
						$password="kN0Tt3n"; // Mysql password 
						$db_name="uln6tjuc_libdog"; // Database name 
						$tbl_name="libdog_tariffario_all"; // Table name 
//Connect to the server and select the database
						mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
						mysql_select_db("$db_name") or die ("cannot select DB");
	
						$sql = "SELECT  `id` , `tipologia` ,`descrizione` ,  `importo`  FROM  `libdog_tariffario_all` order by tipologia, id;";
						$result = mysql_query($sql);
						$counter=0;
						$listinoid=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 5) {
									if ($counter == 0) {
										$listinoid=$cell;
										}
        							echo "<td><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								echo "<td> <a href=\"modifylistino.php?listinoid=",$listinoid,"\">Modifica</a> </td>";
								echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_tariffario_all')";
						mysql_query($sql2);
						?>
					</table>
				</td>
			</tr>

    </table>
	<br><br><br>
							<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>

						</body>
</html>