<?php
$servername = "mysql-souguibg.alwaysdata.net"; 
$username = "souguibg"; 
$password = "WCJ.nJw4sEBiFzV"; 
$dbname = "souguibg_bd"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");

?>
