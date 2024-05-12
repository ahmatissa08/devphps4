<?php
session_start(); 

include 'db.php'; 

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header("Location: login_client.php");
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
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<div class="container">
    <h2>Bienvenue, <?php echo $client_data['prenom'] . ' ' . $client_data['nom']; ?></h2>
    <h3>Vos relevés de compte :</h3>
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
    <a href="logout.php">Se déconnecter</a>
</div>

</body>
</html>

<?php
$conn->close();
?>
