<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $username = $_POST['username']; 
    $password = $_POST['password'];

    $sql = "INSERT INTO gestionnaires (prenom, nom, adresse, telephone, username, password) 
            VALUES ('$prenom', '$nom', '$adresse', '$telephone', '$username', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "Compte gestionnaire créé avec succès.";
        header("Location: index.php");
        exit(); 
    } else {
        echo "Erreur lors de la création du compte gestionnaire : " . $conn->error;
    }
}

$conn->close();
?>
