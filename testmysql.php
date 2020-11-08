<?php
$host="mysqlhost"; // Host name 
$username="uln6tjuc_dataentry"; // Mysql username 
$password="kN0Tt3n"; // Mysql password 
$db_name="uln6tjuc_libdog"; // Database name 


// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>