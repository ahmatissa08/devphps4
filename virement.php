<?php
session_start();

include 'db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'gestionnaire') {
    header("Location: connexion_gestionnaire.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $compte_origine = $_POST['compte_origine'];
    $compte_destinataire = $_POST['compte_destinataire'];
    $montant = floatval($_POST['montant']);

    $sql_debit = "UPDATE comptesbancaires SET solde = solde - ? WHERE numero_compte = ?";
    $stmt_debit = $conn->prepare($sql_debit);
    $stmt_debit->bind_param("ds", $montant, $compte_origine);

    $sql_credit = "UPDATE comptesbancaires SET solde = solde + ? WHERE numero_compte = ?";
    $stmt_credit = $conn->prepare($sql_credit);
    $stmt_credit->bind_param("ds", $montant, $compte_destinataire);

    $conn->begin_transaction();
    $debit_success = $stmt_debit->execute();
    $credit_success = $stmt_credit->execute();

    if ($debit_success && $credit_success) {
        $conn->commit();
        echo "Virement effectué avec succès.";
    } else {
        $conn->rollback();
        echo "Erreur lors du virement : " . $conn->error;
    }

    $stmt_debit->close();
    $stmt_credit->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Virement - Banque</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="operation-container">
        <h2>Virement</h2>
        <form action="virement.php" method="post">
            <label for="compte_origine">Compte Origine:</label>
            <input type="text" id="compte_origine" name="compte_origine" required>
            <label for="compte_destinataire">Compte Destinataire:</label>
            <input type="text" id="compte_destinataire" name="compte_destinataire" required>
            <label for="montant">Montant:</label>
            <input type="number" id="montant" name="montant" step="0.01" required>
            <button type="submit">Valider</button>
        </form>
        <a href="dashboard_gestionnaire.php">Retourner au Tableau de Bord</a>
    </div>
</body>
</html>
