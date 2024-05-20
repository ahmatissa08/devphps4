<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    
    $sql_client = "INSERT INTO clients (prenom, nom, adresse, telephone, username, password) 
                   VALUES ('$prenom', '$nom', '$adresse', '$telephone', '$username', '$password')";

    if ($conn->query($sql_client) === TRUE) {
        $client_id = $conn->insert_id;
        $numero_compte = generateAccountNumber(); 
        $initial_solde = 0.00;

        $sql_account = "INSERT INTO comptesbancaires (numero_compte, solde, client_id) 
                        VALUES ('$numero_compte', $initial_solde, $client_id)";

        if ($conn->query($sql_account) === TRUE) {
            echo "Compte client créé avec succès.";
            header("Location: inde.php");
            exit();
        } else {
            echo "Erreur lors de la création du compte bancaire : " . $conn->error;
        }
    } else {
        echo "Erreur lors de la création du compte client : " . $conn->error;
    }
}

$conn->close();
function generateAccountNumber() {
    return 'ACC' . uniqid(); 
}
?>
