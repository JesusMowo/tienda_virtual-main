<?php

date_default_timezone_set("America/Caracas");

$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; 
$db_name = 'flavio_token'; 

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) {
    die('Error de conexión MySQL: ' . $conn->connect_error);
}
$conn->set_charset('utf8');

?>