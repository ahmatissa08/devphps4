<?php
session_start(); 

include 'db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header("Location: inde.html");
    exit();
}

$client_id = $_SESSION['user_id'];

$sql_client = "SELECT * FROM clients WHERE id = $client_id";
$result_client = $conn->query($sql_client);
$client_data = $result_client->fetch_assoc();

$sql_accounts = "SELECT * FROM comptesbancaires WHERE client_id = $client_id";
$result_accounts = $conn->query($sql_accounts);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de Compte - Client</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<section>
<div class="">
    <h1>Bienvenue, <?php echo $client_data['prenom'] . ' ' . $client_data['nom']; ?></h1>
   
    <h1>Vos relevés de compte :</h1>
    <?php
    if ($result_accounts->num_rows > 0) {
        while ($account = $result_accounts->fetch_assoc()) {
            echo "<h4>Compte : " . $account['numero_compte'] . "</h4>";

            $account_id = $account['id'];
            $sql_operations = "SELECT * FROM operationsbancaires WHERE compte_id = $account_id ORDER BY date_operation DESC";
            $result_operations = $conn->query($sql_operations);

            if ($result_operations->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>Date</th><th>Type d'Opération</th><th>Montant</th></tr>";
                while ($operation = $result_operations->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $operation['date_operation'] . "</td>";
                    echo "<td>" . $operation['type_operation'] . "</td>";
                    echo "<td>" . $operation['montant'] . " EUR</td>";
                    echo "</tr>";
                }
                echo "</table>";

                // Calculer le solde actuel du compte
                $sql_balance = "SELECT SUM(montant) AS total FROM operationsbancaires WHERE compte_id = $account_id";
                $result_balance = $conn->query($sql_balance);
                $balance = $result_balance->fetch_assoc()['total'];
                echo "<p>Solde actuel : " . number_format($balance, 2) . " EUR</p>";
            } else {
                echo "<p>Aucune opération pour ce compte.</p>";
            }
        }
    } else {
        echo "<p>Aucun compte bancaire trouvé.</p>";
    }
    ?>

    <br>
    
    <a href="logout.php">
  <button class="Btn">
    <div class="sign">
      <svg viewBox="0 0 512 512">
        <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
      </svg>
    </div>
    <div class="text">Logout</div>
  </button>
</a>



</div>
</section>
</body>
</html>

<?php
$conn->close();
?>
