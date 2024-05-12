<?php
$servername = "localhost"; 
$username = "root"; 
$password = "123456"; 
$dbname = "banque"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8");

?>
