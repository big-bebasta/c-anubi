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
<body>
		<p align=center> <img src="./Liberty-dog.png"> </p>
		<h1> Liberty Dog - Data entry</h1>
	<br><br><br><br>
	<p align=center>
		<table align=center bgcolor=#999999> 
			<tr align=center> <td align=center> 
     <div class = "container form-signin">
         
         <?php
            $msg = '';
			$host="mysqlhost"; // Host name 
			$username="uln6tjuc_dataentry"; // Mysql username 
			$password="kN0Tt3n"; // Mysql password 
			$db_name="uln6tjuc_libdog"; // Database name 
			$tbl_name="libdog_Anagrafica_Cani"; // Table name 
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Inserisci']) && !empty($_POST['name']) 
               && !empty($_POST['breed'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: $name, $breed, $aggressive, $chip, $notes, $id_padrone, $birth, $gender, $activesex, $fur, $allergiefood, $allergiefarm, $sickness
					$name=$_POST['name']; 
					$breed=$_POST['breed']; 
					$aggressive=$_POST['aggressive']; 
					$chip=$_POST['chip']; 
					$notes=$_POST['notes']; 
					$id_padrone=$_POST['id_padrone']; 
					$birth=$_POST['birth']; 
					$gender=$_POST['gender']; 
					$activesex=$_POST['activesex']; 
					$fur=$_POST['fur']; 
					$allergiefood=$_POST['allergiefood']; 
					$allergiefarm=$_POST['allergiefarm']; 
					$sickness=$_POST['sickness']; 

// To protect MySQL injection (more detail about MySQL injection)
					$name = stripslashes($name);
					$breed = stripslashes($breed);
					$aggressive = stripslashes($aggressive);
					$chip = stripslashes($chip);
					$notes = stripslashes($notes);
					$id_padrone = stripslashes($id_padrone);
					$birth = stripslashes($birth);
					$gender = stripslashes($gender);
					$activesex = stripslashes($activesex);
					$fur = stripslashes($fur);
					$allergiefood = stripslashes($allergiefood);
					$allergiefarm = stripslashes($allergiefarm);
					$sickness = stripslashes($sickness);
					$name = mysql_real_escape_string($name);
					$breed = mysql_real_escape_string($breed);
					$aggressive = mysql_real_escape_string($aggressive);
					$chip = mysql_real_escape_string($chip);
					$notes = mysql_real_escape_string($notes);
					$id_padrone = mysql_real_escape_string($id_padrone);
					$birth = mysql_real_escape_string($birth);
					$gender = mysql_real_escape_string($gender);
					$activesex = mysql_real_escape_string($activesex);
					$fur = mysql_real_escape_string($fur);
					$allergiefood = mysql_real_escape_string($allergiefood);
					$allergiefarm = mysql_real_escape_string($allergiefarm);
					$sickness = mysql_real_escape_string($sickness);

                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_Anagrafica_Cani` (`libdog_Anagrafica_Clienti_id`,`name`, `breed`, `aggressive`, `chip`, `notes`, `id_padrone`, `birth`, `gender`, `activesex`, `fur`, `allergiefood`, `allergiefarm`, `sickness`) VALUES ('$id_padrone','$name', '$breed', '$aggressive', '$chip', '$notes', '$id_padrone', '$birth', '$gender', '$activesex', '$fur', '$allergiefood', '$allergiefarm', '$sickness');";
				  $msginsert = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_Anagrafica_Cani')";
				  $msglog= mysql_query($sql2);

               }else {
                  $msg = 'Missing Name and breed';
				  echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="newdog.php" method='post' id='login'>
              <table>
			  <tr> <td> <font color=#eeee00> Nome: </font>   </td> <td><font color=#eeee00> Razza: </font></td> <td><font color=#eeee00> Aggressiva: </font></td></tr> 
              <tr> <td> <input type='text' name='name' /></td> <td> <input type='text' name='breed' /> </td> <td> <input type='text' name='aggressive' /></td></tr>
              <tr> <td>  <font color=#eeee00> Chip: </font></td> <td> <font color=#eeee00> Note: </font> </td> <td> <font color=#eeee00> Padrone N.: </font> </td></tr>
              <tr> <td> <input type='text' name='chip' /> </td> <td><input type='text' name='notes' /></td> <td> <input type='text' name='id_padrone' /></td></tr>
              <tr> <td>  <font color=#eeee00> Data di Nascita: </font> </td> <td><font color=#eeee00> Sesso: </font>  </td> <td><font color=#eeee00> Sterilizzata: </font></td></tr> 
              <tr> <td> <input type='text' name='birth' /> </td> <td><input type='text' name='gender' /></td> <td><input type='text' name='activesex' /></td></tr>
              <tr> <td>  <font color=#eeee00> Pelo: </font> </td> <td><font color=#eeee00> Allergie Cibo: </font></td> <td><font color=#eeee00> Allergie Farmaci: </font></td> </tr>
              <tr> <td> <input type='text' name='fur' />  </td> <td> <input type='text' name='allergiefood' />  </td> <td> <input type='text' name='allergiefarm' /></td></tr>
              <tr> <td> </td> <td> <font color=#eeee00> Malattie: </font></td> <td></td></tr>
              <tr> <td> </td> <td><input type='text' name='sickness' /></td> <td></td></tr>
              <tr>  <td></td> <td><input type='submit' name = "Inserisci" value='Inserisci' /></td> <td></td> </tr>
			  </table>
            </form>
        	</div>
			</td></tr>
		</table>
  </p>
  
  						<h4><a href="primavolta.php">Inserisci un primo incontro</a></h4> <br><br>
						<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>
						<h2>Cani attualmente in lista</h2>
						
					<table align=center border=2> <tr><td>id_Cani</td><td>id_Clienti</td><td>name</td><td>Aggressivo</td><td>microchip</td><td>note</td><td>id_padrone</td><td>birth</td><td>gender</td><td>activesex</td><td>Pelo</td><td>allergie cibo</td><td>allergie farmaci</td><td>malattie</td><td>Razza</td></tr>
						<?php 
	
						$sql = "SELECT `idlibdog_Anagrafica_Cani`,`libdog_Anagrafica_Clienti_id`,`name`,`aggressive`,`chip`,`notes`,`id_padrone`,`birth`,`gender`,`activesex`,`fur`,`allergiefood`,`allergiefarm`,`sickness`,`breed` FROM `libdog_Anagrafica_Cani`;";
						$result = mysql_query($sql);
						$counter=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell)
        					if ($counter < 15) {
        							echo "<td><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
							    echo "</tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_Anagrafica_Cani')";
						mysql_query($sql2);
						?>
					</table>
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