<html>
<head>
<link href="menu_style.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">
function get_submenu(id)
{
$.ajax
 ({
 type:'post',
 url:'get_submenu.php',
 data:{
  get_submenu:"submenu",
  menu_id:id
 },
 success:function(response) {
 if(response!="")
 {
  $("#link"+id+">#submenu_div").html(response);
 }
 }
 });
}
</script>
</head>
<body>
<div id="wrapper">

<div id="menu_div">
 <?php
			$host="mysqlhost"; // Host name 
			$username="uln6tjuc_dataentry"; // Mysql username 
			$password="kN0Tt3n"; // Mysql password 
			$db_name="uln6tjuc_libdog"; // Database name 
			$tbl_name="libdog_Anagrafica_Cani"; // Table name 
 $connect=mysql_connect($host,$username,$password);
 $db=mysql_select_db($databasename);

 $menu = mysql_query("SELECT * FROM `uln6tjuc_libdog`.`libdog_Anagrafica_Cani`");
 echo "<div id='main_menu'>";
 while($row=mysql_fetch_array($menu))
 {
  ?>
  <li class='menu_link' id="link<?php echo $row['idlibdog_Anagrafica_Cani'];?>">
  <a href='' class="menu_anchor" id="<?php echo $row['idlibdog_Anagrafica_Cani'];?>" onmouseover="get_submenu(this.id);"><?php echo $row['name'];?></a>
  <ul id='submenu_div'></ul>
  </li>
  <?php
 }
 echo "</div>";
 ?>
</div>

</div>
</body>
</html>