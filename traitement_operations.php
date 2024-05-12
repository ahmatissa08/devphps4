<?php

require_once 'connexion.php';
require_once 'CompteBancaire.php';
require_once 'OperationBancaire.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_compte = $_POST['numero_compte'];
    $montant = $_POST['montant'];
    $type_operation = $_POST['type_operation'];

    if (empty($numero_compte) || empty($montant) || empty($type_operation)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    $query = "SELECT * FROM comptes_bancaires WHERE numero_compte = '$numero_compte'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $compte = new CompteBancaire($row['id'], $row['numero_compte'], $row['solde'], $row['proprietaire_id']);
        $operation = new OperationBancaire();

        switch ($type_operation) {
            case 'depot':
                $operation->effectuerDepot($compte, $montant);
                break;
            case 'retrait':
                $operation->effectuerRetrait($compte, $montant);
                break;
            case 'virement':
                $numero_destinataire = $_POST['numero_destinataire'];
                
                $query_destinataire = "SELECT * FROM comptes_bancaires WHERE numero_compte = '$numero_destinataire'";
                $result_destinataire = $conn->query($query_destinataire);

                if ($result_destinataire->num_rows > 0) {
                    $row_destinataire = $result_destinataire->fetch_assoc();
                    $compte_destinataire = new CompteBancaire($row_destinataire['id'], $row_destinataire['numero_compte'], $row_destinataire['solde'], $row_destinataire['proprietaire_id']);

                    $operation->effectuerVirement($compte, $compte_destinataire, $montant);
                } else {
                    echo "Le compte destinataire n'existe pas.";
                    exit;
                }
                break;
            default:
                echo "Opération non valide.";
                exit;
        }

        $nouveau_solde_compte = $compte->getSolde();
        $sql_update_compte = "UPDATE comptes_bancaires SET solde = '$nouveau_solde_compte' WHERE id = '{$compte->getId()}'";
        $conn->query($sql_update_compte);

        if (isset($compte_destinataire)) {
            $nouveau_solde_destinataire = $compte_destinataire->getSolde();
            $sql_update_destinataire = "UPDATE comptes_bancaires SET solde = '$nouveau_solde_destinataire' WHERE id = '{$compte_destinataire->getId()}'";
            $conn->query($sql_update_destinataire);
        }

        header("Location: gerer_comptes.php?operation_success=true");
        exit;
    } else {
        echo "Le compte n'existe pas.";
        exit;
    }
} else {
    header("Location: gerer_comptes.php");
    exit;
}
?>
