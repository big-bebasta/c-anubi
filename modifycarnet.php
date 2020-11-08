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
		$id_carnet = $_GET['id_carnet'];	
		}
		
	?>
<html>
<head>
	<title>Liberty Dog</title>
	<style>
		h1   {color:#000000; font-size:150%; text-align:center;}
		h2   {color:#000000; font-size:100%; text-align:center;}
		h3   {color:#000000; font-size:75%; text-align:center;}
		h4   {color:#000000; font-size:65%; text-align:center;}
		h5   {color:#000000; font-size:60%; text-align:center;}
		h6   {color:#000000; font-size:55%; text-align:center;}
		p    {margin-left:50px;}
		body {background-color:#bbbbbb; 
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
		<h1> Liberty Dog</h1>
	<br><br><br><br>
	<p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
     <h1> Vorrei modificare i dati di : 
<?php 
		echo $id_carnet;
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
					$validita=$_POST['validita']; 
					$validita = stripslashes($validita);
					$validita = mysql_real_escape_string($validita);
					$expiration=$_POST['expiration']; 
					$expiration = stripslashes($expiration);
					$expiration = mysql_real_escape_string($expiration);
					$id_cane=$_POST['id_cane']; 
					$id_cane = stripslashes($id_cane);
					$id_cane = mysql_real_escape_string($id_cane);
					$num_ingressi=$_POST['num_ingressi']; 
					$num_ingressi = stripslashes($num_ingressi);
					$num_ingressi = mysql_real_escape_string($num_ingressi);
					$id_acquisto=$_POST['id_acquisto']; 
					$id_acquisto = stripslashes($id_acquisto);
					$id_acquisto = mysql_real_escape_string($id_acquisto);
					$id_pagamento=$_POST['id_pagamento']; 
					$id_pagamento = stripslashes($id_pagamento);
					$id_pagamento = mysql_real_escape_string($id_pagamento);

				
				
                  $sql1 = "UPDATE `uln6tjuc_libdog`.`libdog_carnet_history` SET `validita`='$validita', `expiration`='$expiration', `id_cane`='$id_cane', `num_ingressi`='$num_ingressi', `id_acquisto`='$id_acquisto', `id_pagamento`='$id_pagamento' WHERE `id_carnet`='$id_carnet';";
				  //echo ( $sql1 );
				  $msgupdateentry = mysql_query($sql1);
				  //echo ($msgupdateentry);
				  $myusername = $_SESSION['myusername'] ;
				  $sql3 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','update_carnet_history')";
				  $msglog= mysql_query($sql3);
				  
               }

			   
			   
            if (isset($_POST['Elimina'])  ) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();

                  $sql1 = "delete from `uln6tjuc_libdog`.`libdog_carnet_history` WHERE `id_carnet`='$id_carnet';";
				//  echo ( $sql1 );
				  $msgupdateentry = mysql_query($sql1);
			//	  echo ($msgupdateentry);
				  $myusername = $_SESSION['myusername'] ;
				  $sql3 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','cancella_carnet_history')";
				  $msglog= mysql_query($sql3);
				  
               }
         ?>
      </div> <!-- /container -->			   
      <?php
		$sql6 = "SELECT carnet.* FROM `uln6tjuc_libdog`.`libdog_carnet_history` as carnet WHERE  `id_carnet`='$id_carnet';";
			$resultentry = mysql_query($sql6);
			while($row = mysql_fetch_array($resultentry)){
			?>
      <div class = "container">
        	<div id='loginform'>
            <form action="modifycarnet.php?id_carnet=<?php echo $id_carnet ?>" method='post' id='login'>
			  <table>
			  <tr> <td> <font color=#eeee00> Validit&agrave;: </font> </td> 
				<td> <font color=#eeee00> Scadenza: </font> </td>
				<td><font color=#eeee00> ID cane: </font></td>  
			  </tr> 
			  <tr> <td> <input type='date_time_set' name='validita' value="<?php echo $row['validita']; ?>"/></td> 
				<td> <input type='date' name='expiration' value="<?php echo $row['expiration']; ?>"/> </td> 
				<td> <input type='text' name='id_cane' value="<?php echo $row['id_cane']; ?>"/></td>
              </tr>
			  <tr> <td>  <font color=#eeee00> Numero Ingressi: </font>  </td>
				<td> <font color=#eeee00> Id Pagamento: </font> </td>
 				<td> <font color=#eeee00> Id Entrata: </font> </td>
			  </tr>
			  <tr> <td><input type='text' name='num_ingressi' value="<?php $num_ingressi=$row['num_ingressi'];  echo $row['num_ingressi']; ?>"/>  </td>
			    <td> <input type='text' name='id_acquisto' value="<?php echo $row['id_acquisto']; ?>"/> </td>
				<td> <input type='text' name='id_pagamento' value="<?php echo $row['id_pagamento']; ?>"/> </td>
			  </tr>
			  <tr>  
					<td> <a href="listaccesscarnet.php?id_carnet=<?php echo $id_carnet ?>&num_ingressi=<?php echo $num_ingressi ?>"> <font color=#00ff00><b>Modifica lista accessi</b></font></a></td> 
					<td> </td> 
					<td><input type='submit' name = "Modifica" value='Modifica' /></td> 
				</tr>
			  <tr>  
					<td>  </td> 
					<td><input type='submit' name = "Elimina" value='Elimina' /></td> 
					<td> </td> 
				</tr>
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
 if ($userkind == 'superuser' || $userkind == 'teamleader') {
	echo "<h4><a href=\"carnet.php\">Return to Carnet</a></h4> <br> <h6>";
 } else {
	 if ($userkind == 'user') {
	echo "<h4><a href=\"carnet.php\">Return to Carnet</a></h4> <br><br><br><br><h6>";
			}
		}	
			echo ( $msgupdateentry );
		?>
		</h6>
		<h6>
 		<?php 
			echo ( $msglog );
		?>
		</h6>
		

		</body>
</html>

