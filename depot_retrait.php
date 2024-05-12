<?php
session_start();

include 'db.php';

// Vérifier si l'utilisateur est connecté en tant que gestionnaire
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'gestionnaire') {
    header("Location: connexion_gestionnaire.php");
    exit();
}

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_compte = $_POST['numero_compte'];
    $montant = floatval($_POST['montant']);
    $type_operation = $_POST['type_operation']; // 'depot' ou 'retrait'

    // Vérifier le type d'opération
    if ($type_operation === 'depot') {
        // Opération de dépôt
        $sql = "UPDATE ComptesBancaires SET solde = solde + ? WHERE numero_compte = ?";
    } elseif ($type_operation === 'retrait') {
        // Opération de retrait
        $sql = "UPDATE ComptesBancaires SET solde = solde - ? WHERE numero_compte = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ds", $montant, $numero_compte);

    if ($stmt->execute()) {
        echo "Opération effectuée avec succès.";
    } else {
        echo "Erreur lors de l'opération : " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dépôt / Retrait - Banque</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="operation-container">
        <h2>Dépôt / Retrait</h2>
        <form action="depot_retrait.php" method="post">
            <label for="numero_compte">Numéro de Compte:</label>
            <input type="text" id="numero_compte" name="numero_compte" required>
            <label for="montant">Montant:</label>
            <input type="number" id="montant" name="montant" step="0.01" required>
            <label for="type_operation">Type d'Opération:</label>
            <select id="type_operation" name="type_operation" required>
                <option value="depot">Dépôt</option>
                <option value="retrait">Retrait</option>
            </select>
            <button type="submit">Valider</button>
        </form>
        <a href="dashboard_gestionnaire.php">Retourner au Tableau de Bord</a>
    </div>
</body>
</html>
