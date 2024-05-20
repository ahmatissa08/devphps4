<?php
session_start();

include 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'gestionnaire') {
    header("Location: connexion_gestionnaire.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero_compte = $_POST['numero_compte'];
    $montant = floatval($_POST['montant']);
    $type_operation = $_POST['type_operation']; 

    if ($type_operation === 'depot') {
        $sql = "UPDATE comptesbancaires SET solde = solde + ? WHERE numero_compte = ?";
    } elseif ($type_operation === 'retrait') {
        $sql = "UPDATE comptesbancaires SET solde = solde - ? WHERE numero_compte = ?";
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
    <section>
    <div class="operation-container">
        <h2>Dépôt / Retrait</h2>
        <form action="depot_retrait.php" method="post">
           
            <div class="input-box">
              <input type="numero_compte" required />
              <label>Numéro de Compte:</label>
            </div>
        
            <div class="input-box">
              <input type="number" id="montant" name="montant" step="0.01" required/>
              <label>Montant</label>
            </div>
            <div class="input-box3">
            <label>Type d'Opération:</label>
            <br>
            <br>
            <select id="type_operation" name="type_operation"required>
                <option value="depot">Dépôt</option>
                <option value="retrait">Retrait</option>
            </select>
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
