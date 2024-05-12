<?php
require_once 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    if (empty($prenom) || empty($nom) || empty($adresse) || empty($telephone)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    $sql_insert_client = "INSERT INTO clients (prenom, nom, adresse, telephone) 
                          VALUES ('$prenom', '$nom', '$adresse', '$telephone')";

    if ($conn->query($sql_insert_client) === TRUE) {
        $client_id = $conn->insert_id; 

        $numero_compte = uniqid('COMPTE_');

        $solde_initial = 0;

        $sql_insert_compte = "INSERT INTO comptes_bancaires (numero_compte, solde, proprietaire_id) 
                              VALUES ('$numero_compte', '$solde_initial', '$client_id')";

        if ($conn->query($sql_insert_compte) === TRUE) {
            header("Location: gerer_comptes.php?creation_success=true");
            exit;
        } else {
            echo "Erreur lors de la création du compte : " . $conn->error;
        }
    } else {
        echo "Erreur lors de la création du client : " . $conn->error;
    }
} else {
    header("Location: creer_compte.php");
    exit;
}
?>
