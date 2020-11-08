<?php
			$host="mysqlhost"; // Host name 
			$username="uln6tjuc_dataentry"; // Mysql username 
			$password="kN0Tt3n"; // Mysql password 
			$db_name="uln6tjuc_libdog"; // Database name 
$connect=mysql_connect($host,$username,$password);
$db=mysql_select_db($databasename);

if(isset($_POST['get_submenu']))
{
 $menu_id=$_POST['menu_id'];
 $sub_menu = mysql_query("SELECT * FROM `uln6tjuc_libdog`.`libdog_presenze_day` where `id_cane`='$menu_id'");
 while($row=mysql_fetch_array($sub_menu))
 {
  echo "<li>".$row['giorno']."<br></li>";
 }	
 exit();
}
?>