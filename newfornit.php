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
			$tbl_name="libdog_Anagrafica_Fornitori"; // Table name 
//Connect to the server and select the database
			mysql_connect("$host", "$username", "$password") or die ("There are some issues with the connect");
			mysql_select_db("$db_name") or die ("cannot select DB");

            if (isset($_POST['Inserisci']) && !empty($_POST['name']) 
               && !empty($_POST['PI'])) {
                  $_SESSION['valid'] = true;
                  $_SESSION['timeout'] = time();
				  // Define my variables: 
				  // INSERT INTO `uln6tjuc_libdog`.`libdog_Anagrafica_Fornitori` (`idlibdog_Anagrafica_Fornitori`,`name`,`PI`,`town`,`address`,`zip`,`prov`,`mail`,`mobile`,`phone`,`CF`,`mobile2`,`mail2`,`tipologia`,`webpage`) VALUES (...);
					$name=$_POST['name']; 
					$PI=$_POST['PI']; 
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
					$tipologia=$_POST['tipologia']; 
					$webpage=$_POST['webpage']; 

// To protect MySQL injection (more detail about MySQL injection)
					$name = stripslashes($name);
					$PI = stripslashes($PI);
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
					$tipologia = stripslashes($tipologia);
					$webpage = stripslashes($webpage);
					$name = mysql_real_escape_string($name);
					$PI = mysql_real_escape_string($PI);
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
					$tipologia = mysql_real_escape_string($tipologia);
					$webpage = mysql_real_escape_string($webpage);

                  $sql2 = "INSERT INTO `uln6tjuc_libdog`.`libdog_Anagrafica_Fornitori` (`name`,`PI`,`town`,`address`,`zip`,`prov`,`mail`,`mobile`,`phone`,`CF`,`mobile2`,`mail2`,`tipologia`,`webpage`) VALUES ('$name','$PI','$town','$address','$zip','$prov','$mail','$mobile','$phone','$CF','$mobile2','$mail2','$tipologia','$webpage');";
				  $msginsert = mysql_query($sql2);
				  
				  $myusername = $_SESSION['myusername'] ;
				  $sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','insert_Anagrafica_Fornitori')";
				  $msglog= mysql_query($sql2);

               }else {
                  $msg = 'Nome e Cognome Assenti';
				  echo ( $msg );
               }
         ?>
      </div> <!-- /container -->
      
      <div class = "container">
        	<div id='loginform'>
            <form action="newfornit.php" method='post' id='login'>
              <table>
			  <tr> <td> <font color=#eeee00> Nome: </font>   </td> 
				<td><font color=#eeee00> PI: </font> </td>
				<td><font color=#eeee00> Codice Fiscale: </font></td>  
			  </tr> 
			  <tr> <td> <input type='text' name='name' /></td> 
				<td> <input type='text' name='PI' /> </td> 
				<td> <input type='text' name='CF' /></td>
              </tr>
			  <tr> <td>  <font color=#eeee00> Via: </font></td> 
				<td>  <font color=#eeee00> CAP: </font></td> 
				<td> <font color=#eeee00> Paese: </font> </td> 
			  </tr>
			  <tr> <td> <input type='text' name='address' /> </td>
				<td> <input type='text' name='zip' /> </td> 
				<td><input type='text' name='town' /></td> 
			  </tr>
			  <tr> <td> <font color=#eeee00> Provincia: </font> </td>
				<td> <font color=#eeee00> E-Mail: </font> </td>
				<td> <font color=#eeee00> E-Mail 2: </font> </td>
			  </tr>
			  <tr> <td> <input type='text' name='prov' /></td>
				<td> <input type='text' name='mail' /> </td>
				<td> <input type='text' name='mail2' /> </td>
			  </tr>
              <tr> <td>  <font color=#eeee00> Cellulare: </font> </td> 
				<td><font color=#eeee00> Telefono: </font>  </td> 
			    <td><font color=#eeee00> Cellulare 2: </font> </td> 
			  </tr> 
              <tr> <td> <input type='text' name='mobile' /> </td> 
				<td><input type='text' name='phone' /></td> 
				<td><input type='text' name='mobile2' /></td>
			  </tr>
              <tr> <td>  <font color=#eeee00> Tipologia: </font> </td> 
				<td><font color=#eeee00> Pagina web: </font>  </td> 
			    <td> &nbsp; </td> 
			  </tr> 
              <tr> <td> <select name='tipologia'>
						<option value='Contanti'>Bollette</option>
						<option value='Materiali'>Materiali</option>
						<option value='Magazzino'>Magazzino</option>
						<option value='Varie'>Varie</option>
						</select></td> 
				<td><input type='text' name='webpage' /></td> 
				<td>&nbsp; </td>
			  </tr>
              <tr>  <td></td> 
			  <td><input type='submit' name = "Inserisci" value='Inserisci' /></td> 
			  <td></td> </tr>
			  </table>
            </form>
        	</div>
			</td></tr>
		</table>
  </p>
						<h4><a href="login_success.php">Return to Menu</a></h4> <br><br><br><br>
						<h2>Fornitori attualmente in lista</h2>
						
					<table align=center border=2> <tr><td>id_Clienti</td><td>name</td><td>PI</td><td>Paese</td><td>Indirizzo</td><td>CAP</td><td>Provincia</td><td>mail</td><td>mail 2</td><td>Cellulare</td><td>Cellulare 2</td><td>Telefono</td><td>Codice Fiscale</td><td>Tipologia</td><td>Pagina Web</td></tr>
						<?php 
	
						$sql = "SELECT `idlibdog_Anagrafica_Fornitori`,`name`,`PI`,`town`,`address`,`zip`,`prov`,`mail`,`mail2`,`mobile`,`mobile2`,`phone`,`CF`,`tipologia`,`webpage` FROM `libdog_Anagrafica_Fornitori` order by `name`;";
						$result = mysql_query($sql);
						$counter=0;
						while($row = mysql_fetch_row($result)) {
					    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable					
						    foreach($row as $cell) {
        					if ($counter == 0) { 	$fornit = $cell;	}
							if ($counter < 15) {
        							echo "<td><h3>$cell</h3></td>";
        							$counter++;
        					} else { 
        							echo ""; 
        							}
								}
							    echo "<td><a href=\"modifornit.php?id_money=",$fornit,"\"> Modifica </a> </td></tr>";
							  $counter=0;
							  }
						$myusername = $_SESSION['myusername'] ;
						$sql2 = "insert into libdog_log_actions (quando, chi, cosa) VALUES (now(),'$myusername','read_Anagrafica_Fornitori')";
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