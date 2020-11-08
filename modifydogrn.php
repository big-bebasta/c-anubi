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
		<h1> Liberty Dog - Data entry</h1>
	<br><br><br><br>
	<p align=center>
		<table align=center bgcolor=#999999>
			<tr align=center> <td align=center>
     <div class = "container form-signin">
     <h1> Vorrei modificare i dati di :
<?php
		echo $ownerid
		?> e
		<?php
		echo $dogid
		?> </h1>

         <?php
            $msg = '';
			$host="81.31.155.67"; // Host name
			$username="uln6tjuc_dataentry"; // Mysql username
			$password="kN0Tt3n"; // Mysql password
			$db_name="uln6tjuc_libdog"; // Database name
			$tbl_name="libdog_Anagrafica_Clienti"; // Table name
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['ModificaCliente']) && !empty($_POST['name'])
               && !empty($_POST['family'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables:
				  // INSERT INTO `Sql1036019_1`.`libdog_Anagrafica_Clienti` (`name`, `family`, `town`, `zip`, `prov`, `mail`, `mobile`, `phone`, `CF`) VALUES (...);
					$name=$_POST['name'];
					$family=$_POST['family'];
					$address=$_POST['address'];
					$town=$_POST['town'];
					$zip=$_POST['zip'];
					$prov=$_POST['prov'];
					$mail=$_POST['mail'];
					$mail2=$_POST['mail2'];
					$mobile=$_POST['mobile'];
					$mobile2=$_POST['mobile2'];
					$phone=$_POST['phone'];
					$CF=$_POST['CF'];

// To protect MySQL injection (more detail about MySQL injection)
					$name = stripslashes($name);
					$family = stripslashes($family);
					$address = stripslashes($address);
					$town = stripslashes($town);
					$zip = stripslashes($zip);
					$prov = stripslashes($prov);
					$mail = stripslashes($mail);
					$mail2 = stripslashes($mail2);
					$mobile = stripslashes($mobile);
					$mobile2 = stripslashes($mobile2);
					$phone = stripslashes($phone);
					$CF = stripslashes($CF);
					$name = mysql_real_escape_string($name);
					$family = mysql_real_escape_string($family);
					$address = mysql_real_escape_string($address);
					$town = mysql_real_escape_string($town);
					$zip = mysql_real_escape_string($zip);
					$prov = mysql_real_escape_string($prov);
					$mail = mysql_real_escape_string($mail);
					$mail2 = mysql_real_escape_string($mail2);
					$mobile = mysql_real_escape_string($mobile);
					$mobile2 = mysql_real_escape_string($mobile2);
					$phone = mysql_real_escape_string($phone);
					$CF = mysql_real_escape_string($CF);

                  $sql1 = "UPDATE `Sql1036019_1`.`libdog_Anagrafica_Clienti` SET `name`='$name', `family`='$family', `address`='$address',`town`='$town', `zip`='$zip', `prov`='$prov', `mail`='$mail',`mail2`='$mail2', `mobile`='$mobile', `mobile2`='$mobile2', `phone`='$phone', `CF`='$CF' WHERE `idlibdog_Anagrafica_Clienti`='$ownerid';";
				  $msgupdateclient = mysql_query($sql1);
				  #echo ( $sql1 );
				  #echo "<br>";
				  $myusername = $_SESSION['myusername'] ;
				  $sql3 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','update_Anagrafica_Clienti')";
				  $msglog= mysql_query($sql3);
				  #echo ( $sql3 );

               }else {
                  # $msg = 'Nome e Cognome Assenti';
				  # echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      <?php
		$sql6 = "SELECT * FROM `Sql1036019_1`.`libdog_Anagrafica_Clienti` WHERE `idlibdog_Anagrafica_Clienti`='$ownerid';";
			$resultowner = mysql_query($sql6);
			while($row = mysql_fetch_array($resultowner)){
			?>
      <div class = "container">
        	<div id='loginform'>
            <form action="modifydog.php?ownerid=<?php echo $ownerid ?>&dogid=<?php echo $dogid ?>" method='post' id='login'>
			  <table>
			  <tr> <td> <font color=#eeee00> Nome: </font>   </td>
				<td><font color=#eeee00> Cognome: </font> </td>
				<td><font color=#eeee00> Codice Fiscale: </font></td>
			  </tr>
			  <tr> <td> <input type='text' name='name' value="<?php echo $row['name']; ?>"/></td>
				<td> <input type='text' name='family' value="<?php echo $row['family']; ?>"/> </td>
				<td> <input type='text' name='CF' value="<?php echo $row['CF']; ?>"/></td>
              </tr>
			  <tr> <td>  <font color=#eeee00> Via: </font></td>
				<td>  <font color=#eeee00> CAP: </font></td>
				<td> <font color=#eeee00> Paese: </font> </td>
			  </tr>
			  <tr> <td> <input type='text' name='address' value="<?php echo $row['address']; ?>"/> </td>
				<td> <input type='text' name='zip' value="<?php echo $row['zip']; ?>"/> </td>
				<td><input type='text' name='town' value="<?php echo $row['town']; ?>"/></td>
			  </tr>
			  <tr> <td> <font color=#eeee00> Provincia: </font> </td>
				<td> <font color=#eeee00> E-Mail: </font> </td>
				<td> <font color=#eeee00> E-Mail 2: </font> </td>
			  </tr>
			  <tr> <td> <input type='text' name='prov' value="<?php echo $row['prov']; ?>"/></td>
				<td> <input type='text' name='mail' value="<?php echo $row['mail']; ?>"/> </td>
				<td> <input type='text' name='mail2' value="<?php echo $row['mail2']; ?>"/> </td>
			  </tr>
              <tr> <td>  <font color=#eeee00> Cellulare: </font> </td>
				<td><font color=#eeee00> Telefono: </font>  </td>
			    <td><font color=#eeee00> Cellulare 2: </font> </td>
			  </tr>
              <tr> <td> <input type='text' name='mobile' value="<?php echo $row['mobile']; ?>"/> </td>
				<td><input type='text' name='phone' value="<?php echo $row['phone']; ?>"/></td>
				<td><input type='text' name='mobile2' value="<?php echo $row['mobile2']; ?>"/></td>
			  </tr>
			  <tr>  <td></td> <td><input type='submit' name = "ModificaCliente" value='ModificaCliente' /></td> <td></td> </tr>
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


	<p align=center>
	<table align=center bgcolor=#aaaaaa>
			<tr align=center> <td align=center>
     <div class = "container form-signin">

         <?php
            $msg = '';
			$host="81.31.155.67"; // Host name
			$username="uln6tjuc_dataentry"; // Mysql username
			$password="kN0Tt3n"; // Mysql password
			$db_name="uln6tjuc_libdog"; // Database name
			$tbl_name="libdog_Anagrafica_Cani"; // Table name
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['ModificaCane']) && !empty($_POST['namedog'])
               && !empty($_POST['breed'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: $namedog, $breed, $aggressive, $chip, $notes, $id_padrone, $birth, $gender, $activesex, $fur, $allergiefood, $allergiefarm, $sickness
					$namedog=$_POST['namedog'];
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
					$namedog = stripslashes($namedog);
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
					$namedog = mysql_real_escape_string($namedog);
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

                  $sql2 = "UPDATE `Sql1036019_1`.`libdog_Anagrafica_Cani` SET `libdog_Anagrafica_Clienti_id`='$id_padrone',`name`='$namedog',`breed`='$breed',`aggressive`='$aggressive',`chip`='$chip',`notes`='$notes',`id_padrone`='$id_padrone',`birth`='$birth',`gender`='$gender',`activesex`='$activesex',`fur`='$fur',`allergiefood`='$allergiefood',`allergiefarm`='$allergiefarm',`sickness`='$sickness'  WHERE `idlibdog_Anagrafica_Cani`='$dogid';";
				  $msgupdatedog = mysql_query($sql2);

				  $myusername = $_SESSION['myusername'] ;
				  $sql4 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','update_Anagrafica_Cani')";
				  $msglog= mysql_query($sql4);

               }else {
                  # $msg = 'Missing Name and breed';
				  # echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      <?php
		$sql5 = "SELECT * FROM `Sql1036019_1`.`libdog_Anagrafica_Cani` WHERE `idlibdog_Anagrafica_Cani`='$dogid';";
			$resultdog = mysql_query($sql5);
			while($row = mysql_fetch_array($resultdog)){
			?>
      <div class = "container">
        	<div id='loginform'>
            <form action="modifydog.php?ownerid=<?php echo $ownerid ?>&dogid=<?php echo $dogid ?>" method='post' id='login'>
              <table>
			  <tr> <td> <font color=#eeee00> Nome: </font>   </td> <td><font color=#eeee00> Razza: </font></td> <td><font color=#eeee00> Aggressiva: </font></td></tr>
              <tr> <td> <input type='text' name='namedog' value="<?php echo $row['name']; ?>"/></td> <td> <input type='text' name='breed' value="<?php echo $row['breed']; ?>"/> </td> <td> <input type='text' name='aggressive' value="<?php echo $row['aggressive']; ?>"/></td></tr>
              <tr> <td>  <font color=#eeee00> Chip: </font></td> <td> <font color=#eeee00> Note: </font> </td> <td> <font color=#eeee00> Padrone N.: </font> </td></tr>
              <tr> <td> <input type='text' name='chip' value="<?php echo $row['chip']; ?>"/> </td> <td><input type='text' name='notes' value="<?php echo $row['notes']; ?>"/></td> <td> <input type='text' name='id_padrone' value="<?php echo $row['id_padrone']; ?>"/></td></tr>
              <tr> <td>  <font color=#eeee00> Data di Nascita: </font> </td> <td><font color=#eeee00> Sesso: </font>  </td> <td><font color=#eeee00> Sterilizzata: </font></td></tr>
              <tr> <td> <input type='text' name='birth' value="<?php echo $row['birth']; ?>"/> </td> <td><input type='text' name='gender' value="<?php echo $row['gender']; ?>"/></td> <td><input type='text' name='activesex' value="<?php echo $row['activesex']; ?>"/></td></tr>
              <tr> <td>  <font color=#eeee00> Pelo: </font> </td> <td><font color=#eeee00> Allergie Cibo: </font></td> <td><font color=#eeee00> Allergie Farmaci: </font></td> </tr>
              <tr> <td> <input type='text' name='fur' value="<?php echo $row['fur']; ?>"/>  </td> <td> <input type='text' name='allergiefood' value="<?php echo $row['allergiefood']; ?>"/>  </td> <td> <input type='text' name='allergiefarm' value="<?php echo $row['allergiefarm']; ?>"/></td></tr>
              <tr> <td> </td> <td> <font color=#eeee00> Malattie: </font></td> <td></td></tr>
              <tr> <td> </td> <td><input type='text' name='sickness' value="<?php echo $row['sickness']; ?>"/></td> <td></td></tr>
              <tr>  <td></td> <td><input type='submit' name = "ModificaCane" value='ModificaCane' /></td> <td></td> </tr>
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