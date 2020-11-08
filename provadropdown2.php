<?php
			$host="mysqlhost"; // Host name 
			$username="uln6tjuc_dataentry"; // Mysql username 
			$password="kN0Tt3n"; // Mysql password 
			$db_name="uln6tjuc_libdog"; // Database name 
  $db = new mysqli($host,$username,$password,$db_name);//set your database handler
  $query = "SELECT idlibdog_Anagrafica_Cani, name FROM `uln6tjuc_libdog`.`libdog_Anagrafica_Cani` order by name;";
  $result = $db->query($query);

  while($row = $result->fetch_assoc()){
	  echo $row['name'];
    $categories[] = array("id" => $row['idlibdog_Anagrafica_Cani'], "val" => $row['name']);
  }

  $query = "SELECT id_day, id_cane, giorno FROM `uln6tjuc_libdog`.`libdog_presenze_day` order by id_cane, giorno desc";
  $result = $db->query($query);

  while($row = $result->fetch_assoc()){
	  //echo $row['giorno'].$row['id_cane']."<br>";
    $subcats[$row['id_cane']][] = array("id" => $row['id_day'], "val" => $row['giorno']);
  }

  $jsonCats = json_encode($categories);
  $jsonSubCats = json_encode($subcats);


?>

<html>

  <head>
	<script src="js/jquery-3.2.1.min.js"></script>
    <script type='text/javascript'>
      <?php
        echo "var categories = $jsonCats; \n";
        echo "var subcats = $jsonSubCats; \n";
		echo categories.length;
      ?>
      function loadCategories(){
        var select = document.getElementById("categoriesSelect");
        select.onchange = updateSubCats;
        for(var i = 0; i < categories.length; i++){
          select.options[i] = new Option(categories[i].val,categories[i].id);          
        }
      }
      function updateSubCats(){
        var catSelect = this;
        var catid = this.value;
        var subcatSelect = document.getElementById("subcatsSelect");
        subcatSelect.options.length = 0; //delete all options if any present
        for(var i = 0; i < subcats[catid].length; i++){
          subcatSelect.options[i] = new Option(subcats[catid][i].val,subcats[catid][i].id);
        }
      }
    </script>

  </head>

  <body onload='loadCategories()'>
    <select id='categoriesSelect'>
    </select>

    <select id='subcatsSelect'>
    </select>
  </body>
</html>