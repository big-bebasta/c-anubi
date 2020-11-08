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
	<title>Asilo x Pets - Demo</title>
	<style>
		h1   {color:#000000; font-size:200%; text-align:center;}
		h2   {color:#000000; font-size:150%; text-align:center;}
		h3   {color:#000000; font-size:75%; text-align:center;}
		h4   {color:#000000; font-size:100%; text-align:center;}
		h5   {color:#000000; font-size:60%; text-align:center;}
		h6   {color:#000000; font-size:55%; text-align:center;}
		p    {margin-left:50px;}
		body {background-color:#708eba; 
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
		<div id="imgcontainer" align="center"  style="width: 100%; height: 30%;">			 <img align="center" src="./images/top-logo.jpg" style="height:95%;">		</div>
		<h1> Asilo x Pets - Demo</h1>
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
			$db_name="uln6tjuc_dataentry_3"; // Database name 
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

					$soc = $_POST['sickness']; 
					$origin = $_POST['origin'];
					$owner = $_POST['owner);'];
					$attitude = $_POST['attitude);'];
					$arousal = $_POST['arousal);'];
					$motivazione = $_POST['motivazione);'];
					$game = $_POST['game);'];
					$naso = $_POST['naso);'];
					$padrone = $_POST['padrone);'];
					
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
					
					$soc = stripslashes($soc);
					$origin = stripslashes($origin);
					$owner = stripslashes($owner);
					$attitude = stripslashes($attitude);
					$arousal = stripslashes($arousal);
					$motivazione = stripslashes($motivazione);
					$game = stripslashes($game);
					$naso = stripslashes($naso);
					$padrone = stripslashes($padrone);
					
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
					
					$soc = mysql_real_escape_string($soc);
					$origin = mysql_real_escape_string($origin);
					$owner = mysql_real_escape_string($owner);
					$attitude = mysql_real_escape_string($attitude);
					$arousal = mysql_real_escape_string($arousal);
					$motivazione = mysql_real_escape_string($motivazione);
					$game = mysql_real_escape_string($game);
					$naso = mysql_real_escape_string($naso);
					$padrone = mysql_real_escape_string($padrone);
					
                  $arr = explode("-", $id_padrone, 2);
				  $id_padrone = $arr[0];

				  $sql2 = "INSERT INTO `uln6tjuc_dataentry_3`.`libdog_Anagrafica_Cani` (`libdog_Anagrafica_Clienti_id`,`name`, `breed`, `aggressive`, `chip`, `notes`, `id_padrone`, `birth`, `gender`, `activesex`, `fur`, `allergiefood`, `allergiefarm`, `sickness`) VALUES ('$id_padrone','$name', '$breed', '$aggressive', '$chip', '$notes', '$id_padrone', '$birth', '$gender', '$activesex', '$fur', '$allergiefood', '$allergiefarm', '$sickness');";
				  $msginsert = mysql_query($sql2);
				  
				  $sql3 = "INSERT INTO `uln6tjuc_dataentry_3`.`libdog_Anagrafica_Cani_first` (`name`, `breed`,`birth`, `gender`,`soc`, `origin`, `owner`, `attitude`, `arousal`, `motivazione`, `game`, `naso`, `padrone`) VALUES ('$name', '$breed', '$birth', '$gender', '$soc', '$origin', '$owner', '$attitude', '$arousal', '$motivazione', '$game', '$naso', '$padrone');";
				  $msginsert = mysql_query($sql3);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql4 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_Anagrafica_Cani_and_first')";
				  $msglog= mysql_query($sql4);

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
			  <tr> <td> <font color=#eeee00> Nome: </font>   </td> <td><font color=#eeee00> Razza: </font></td> <td><font color=#eeee00> Aggressiva: </font></td><td>  <font color=#eeee00> Chip: </font></td></tr> 
              <tr> <td> <input type='text' name='name' /></td> <td> <input type='text' name='breed' /> </td> <td> <select name='aggressive'><option value='SI'>SI</option><option value='NO'>NO</option> </select></td><td> <input type='text' name='chip' /> </td> </tr>
              <tr>  <td> <font color=#eeee00> Note: </font> </td> <td> <font color=#eeee00> Padrone: </font> </td><td>  <font color=#eeee00> Data di Nascita: </font> </td> <td><font color=#eeee00> Sesso: </font> </tr>
              <tr> <td><input type='text' name='notes' /></td> <td> 
		<?php
				$sqlcliente = "SELECT CONCAT(`idlibdog_Anagrafica_Clienti`,'-',`libdog_Anagrafica_Clienti`.`name`,'-',`libdog_Anagrafica_Clienti`.`family`) as clio FROM `libdog_Anagrafica_Clienti` order by `libdog_Anagrafica_Cani`.`name`;";
				$resultcliente = mysql_query($sqlcliente);
				echo "<select name='id_padrone'> ";
				echo "$resultcliente";
				if ($resultcliente !== FALSE){
					while($row=mysql_fetch_array($resultcliente)){
						$clio = htmlspecialchars ($row["clio"], ENT_COMPAT,'ISO-8859-1', true);
						echo "<option value='$clio'>$clio</option> ";
						}
					}
				echo "</select> ";
         ?>				

			  </td> <td> <input type='date' name='birth' /> </td> <td><select name='gender'><option value='Maschio'>Maschio</option><option value='Femmina'>Femmina</option> </select></td> </tr>
              <tr>  </td> <td><font color=#eeee00> Sterilizzata: </font></td><td>  <font color=#eeee00> Pelo: </font> </td> <td><font color=#eeee00> Allergie Cibo: </font></td> <td><font color=#eeee00> Allergie Farmaci: </font></td></tr> 
              <tr><td><select name='activesex'><option value='SI'>SI</option><option value='NO'>NO</option> </select></td> <td> <input type='text' name='fur' />  </td> <td> <input type='text' name='allergiefood' />  </td> <td> <input type='text' name='allergiefarm' /></td></tr>
              <tr> <td>  <font color=#eeee00> Socevolezza: </font> </td> <td> <font color=#eeee00> Origine: </font></td> <td> <font color=#eeee00> Malattie: </font></td> <td><font color=#eeee00> Interazione con il padrone: </font></td></tr>
              <tr> <td> <input type='text' name='soc' />  </td> <td> <input type='text' name='origin' />  </td> <td> <input type='text' name='sickness' /></td><td> <input type='text' name='owner' /></td></tr>
              <tr><td> <font color=#eeee00> Attitudine: </font></td> <td> <font color=#eeee00> Arousal: </font></td><td><font color=#eeee00> Motivazione: </font></td> <td> <font color=#eeee00> Gioco: </font></td> </tr>
              <tr> <td> <input type='text' name='attitude' /></td> <td><input type='text' name='arousal' /></td> <td><input type='text' name='motivazione' /></td><td><input type='text' name='game' /></td></tr>
              <tr>  <td> <font color=#eeee00> Usa il naso: </font></td> <td><font color=#eeee00> Legame con il padrone: </font></td><td> &nbsp; </td><td>&nbsp;</td></tr>
              <tr> <td> <input type='text' name='naso' /></td> <td><input type='text' name='padrone' /></td> <td> &nbsp;</td><td><input type='submit' name = "Inserisci" value='Inserisci' /></td></tr>
              <tr>  <td></td><td></td> <td></td> </tr>
			  </table>
            </form>
        	</div>
			</td></tr>
		</table>
  </p>
  
						<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>

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