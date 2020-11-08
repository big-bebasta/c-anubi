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
		<h1> Liberty Dog - Data entry</h1>
	<br><br><br><br>
	<p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
     <h1> Vorrei modificare i dati di : 
<?php 
		echo $id_day
		?> 
		</h1>
		
         <?php
            $msg = '';

//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Modifica'])  ) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				//	$id_day=$_POST['id_day']; 
					$giorno=$_POST['giorno']; 
					$id_cane=$_POST['id_cane']; 
					$id_pagamento=$_POST['id_pagamento']; 
					$note=$_POST['note']; 
					$intime=$_POST['intime']; 
					$outtime=$_POST['outtime']; 
					$trasporto=$_POST['trasporto'];
					
// To protect MySQL injection (more detail about MySQL injection)
				//	$id_day = stripslashes($id_day);
					$giorno = stripslashes($giorno);
					$id_cane = stripslashes($id_cane);
					$id_pagamento = stripslashes($id_pagamento);
					$note = stripslashes($note);
					$intime = stripslashes($intime);
					$outtime = stripslashes($outtime);
					$trasporto = stripslashes($trasporto);
				//	$id_day = mysql_real_escape_string($id_day);
					$giorno = mysql_real_escape_string($giorno);
					$id_cane = mysql_real_escape_string($id_cane);
					$id_pagamento = mysql_real_escape_string($id_pagamento);
					$note = mysql_real_escape_string($note);
					$intime = mysql_real_escape_string($intime);
					$outtime = mysql_real_escape_string($outtime);
					$trasporto = mysql_real_escape_string($trasporto);
					
                  $sql1 = "UPDATE `uln6tjuc_libdog`.`libdog_presenze_day` SET `outtime`='$outtime', `note`='$note', `trasporto`='$trasporto' WHERE `id_day`='$id_day';";
				//  echo ( $sql1 );
				  $msgupdateentry = mysql_query($sql1);
			//	  echo ($msgupdateentry);
				  $myusername = $_SESSION['myusername'] ;
				  $sql3 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','update_presenze_day')";
				  $msglog= mysql_query($sql3);
				  
               }
         ?>
      </div> <!-- /container -->
      <?php
		$sql6 = "SELECT * FROM `uln6tjuc_libdog`.`libdog_presenze_day` WHERE `id_day`='$id_day';";
			$resultentry = mysql_query($sql6);
			while($row = mysql_fetch_array($resultentry)){
			?>
      <div class = "container">
        	<div id='loginform'>
            <form action="modifypresence.php?id_day=<?php echo $id_day ?>" method='post' id='login'>
			  <table>
			  <tr> <td> <font color=#eeeeee> Giorno: </font>   </td> 
				<td> <font color=#eeeeee> ID Cane: </font> </td>
				<td><font color=#eeeeee> Orario Entrata: </font></td>  
			  </tr> 
			  <tr> <td bgcolor=#aaaa00> <input type='date' name='giorno' value="<?php echo $row['giorno']; ?>"/></td> 
				<td bgcolor=#aaaa00> <input type='text' name='id_cane' value="<?php echo $row['id_cane']; ?>"/> </td> 
				<td bgcolor=#aaaa00> <input type='time' name='intime' value="<?php echo $row['intime']; ?>"/></td>
              </tr>
			  <tr> <td>  <font color=#eeee00> Trasporto: </font>  </td>
				<td> <font color=#eeee00> Orario Uscita: </font> </td>
				<td> <font color=#eeee00> Note: </font> </td>
			  </tr>
			  <tr> <td><input type='text' name='trasporto' value="<?php echo $row['trasporto']; ?>"/>  </td>
			    <td> <input type='time' name='outtime' value="<?php echo $row['outtime']; ?>"/> </td>
				<td> <input type='text' name='note' value="<?php echo $row['note']; ?>"/> </td>
			  </tr>
			  <tr>  <td></td> <td><input type='submit' name = "Modifica" value='Modifica' /></td> <td></td> </tr>
			  </table>
            </form>
        	</div>
			</div>
		<?php
			} //Close while{} loop
        ?>
			</td></tr>
		</table>
  </p>

						<h4><a href="login_success.php">Return to Menu</a></h4> <br>
<?php 
 if ($userkind == 'superuser') {
	echo "<h4><a href=\"doginplus.php\">Return to Orari</a></h4> <br> ";
 } else {
	 if ($userkind == 'user') {
	echo "<h4><a href=\"dogin.php\">Return to Orari</a></h4> <br><br><br><br>";
			}
		}	
			echo ( $msgupdateentry );
		?>

		<h6>
 		<?php 
			echo ( $msglog );
		?>
		</h6>
		

		</body>
</html>

