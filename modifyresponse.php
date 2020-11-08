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
	$id_comm = $_GET['id_comm'];
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
		echo $id_comm
		?> 
		</h1>
		
         <?php
            $msg = '';
			$host="mysqlhost"; // Host name 
			$username="uln6tjuc_dataentry"; // Mysql username 
			$password="kN0Tt3n"; // Mysql password 
			$db_name="uln6tjuc_libdog"; // Database name 
			$tbl_name="libdog_comunic_azioni"; // Table name 
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Modifica'])  ) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				//	$id_day=$_POST['id_day']; 
					$inserita=$_POST['inserita']; 
					$id_cane=$_POST['id_cane']; 
					$testo=$_POST['testo'];
					$testoorig=$_POST['testoorig'];					
					$note=$_POST['note']; 
					$closedby=$_POST['closedby']; 
					$valida_fino_a=$_POST['valida_fino_a']; 
					$risposta=$_POST['risposta']; 
					
// To protect MySQL injection (more detail about MySQL injection)
				//	$id_day = stripslashes($id_day);
					$inserita = stripslashes($inserita);
					$id_cane = stripslashes($id_cane);
					$testo = stripslashes($testo);
					$testoorig = stripslashes($testoorig);
					$closedby = stripslashes($closedby);
					$valida_fino_a = stripslashes($valida_fino_a);
					$risposta = stripslashes($risposta);
				//	$id_day = mysql_real_escape_string($id_day);
					$inserita = mysql_real_escape_string($inserita);
					$id_cane = mysql_real_escape_string($id_cane);
					$testo = mysql_real_escape_string($testo);
					$testoorig = mysql_real_escape_string($testoorig);
					$closedby = mysql_real_escape_string($closedby);
					$valida_fino_a = mysql_real_escape_string($valida_fino_a);
					$risposta = mysql_real_escape_string($risposta);
					
                  if ($testo == $testoorig) {
					  $sql1 = "UPDATE `uln6tjuc_libdog`.`libdog_comunic_azioni` SET `risposta`='$risposta', `valida_fino_a`='$valida_fino_a' , `closedby`='$closedby' , `closedwhen`=NOW() WHERE `id`='$id_comm';";
				  } else {
					  $sql1 = "UPDATE `uln6tjuc_libdog`.`libdog_comunic_azioni` SET `testo`='$testo' , `testoorig`='$testoorig', `risposta`='$risposta', `valida_fino_a`='$valida_fino_a' , `closedby`='$closedby'  WHERE `id`='$id_comm';";
					}
				  
				  // echo ( $sql1 );
				  $msgupdateentry = mysql_query($sql1);
				  // echo ($msgupdateentry);
				  $myusername = $_SESSION['myusername'] ;
				  $sql3 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','update_comunic_azioni')";
				  $msglog= mysql_query($sql3);
				  
               }
         ?>
      </div> <!-- /container -->
      <?php
		$sql6 = "SELECT * FROM `uln6tjuc_libdog`.`libdog_comunic_azioni` WHERE `id`='$id_comm';";
			$resultentry = mysql_query($sql6);
			while($row = mysql_fetch_array($resultentry)){
			?>
      <div class = "container">
        	<div id='loginform'>
            <form action="modifyresponse.php?id_comm=<?php echo $id_comm ?>" method='post' id='login'>
			  <table>
			  <tr> <td> <font color=#eeeeee> Inserita il: </font>   </td> 
				<td> <font color=#eeeeee> ID Cane: </font> </td>
				<td><font color=#eeeeee> Comunicazione: </font></td>  
			  </tr> 
			  <tr> <td bgcolor=#aaaa00> <input type='date' name='inserita' value="<?php echo $row['inserita']; ?>"/></td> 
				<td bgcolor=#aaaa00> <input type='text' name='id_cane' value="<?php echo $row['id_cane']; ?>"/> </td> 
				<td bgcolor=#aaaa00> <input type='text' name='testoorig' value="<?php if ( $row['testoorig'] == NULL ) { echo $row['testo']; } else { echo $row['testoorig']; } ?>"/></td>
              </tr>
			  <tr>  
				<td> <font color=#eeee00> Nuovo Testo: </font> </td>
				<td> <font color=#eeee00> Visualizza fino a: </font> </td>
				<td> <font color=#eeee00> Risposta: </font> </td>
			  </tr>
			  <tr> 
			    <td> <input type='text' name='testo' value="<?php echo $row['testo']; ?>"/></td>
			    <td> <input type='date' name='valida_fino_a' value="<?php echo $row['valida_fino_a']; ?>"/> </td>
				<td> <input type='text' name='risposta' value="<?php echo $row['risposta']; ?>"/> </td>
			  </tr>
			  <tr>  <td> <font color=#eeee00> Chiusa da: </font> </td>  <td> </td> <td> </td>
			   </tr>
			  <tr>
				<td> <select name='closedby'>
						<option value='Alessia'>Alessia</option>
						<option value='Arianna'>Arianna</option>
						<option value='Laura'>Laura</option>
						<option value='Lola'>Lola</option>
						<option value='Roberto'>Roberto</option>
						<option value='Altri'>Altri</option>
						</select>  </td> <td> </td>
			  <td><input type='submit' name = "Modifica" value='Modifica' /></td> <td></td> </tr>
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

						<h4><a href="communications.php">Return to Comunicazioni</a></h4> <br><br><br><br>

						<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>
						
 		<?php 
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