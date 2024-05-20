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
    <section>
    <div class="operation-container">
        <h2>Virement</h2>
        <form action="virement.php" method="post">
           
            <div class="input-box">
              <input type="text" id="compte_origine" name="compte_origine" required />
              <label>Compte Origine:</label>
            </div>
            <div class="input-box">
              <input type="text" id="compte_destinataire" name="compte_destinataire" required />
              <label>Compte Destinataire:</label>
            </div>
            <div class="input-box">
              <input type="number" id="montant" name="montant" step="0.01" required/>
              <label>Montant:</label>
            </div>
            
            <button type="submit" class="btn">Valider</button>
        </form>
        <br>
        <a href="dashboard_gestionnaire.php">
  <button class="Btn">
    <div class="sign">
      <svg viewBox="0 0 512 512">
        <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
      </svg>
    </div>
    <div class="text"> Tableau de Bord</div>
  </button>
</a>
    </div>

    </section>
</body>
</html>
