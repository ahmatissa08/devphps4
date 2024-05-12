<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Relevé de Compte - Banque</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="statement-container">
        <h2>Relevé de Compte</h2>
        <div class="account-statement">
            <?php
            include 'db.php';

            $account_id = $_GET['account_id'];

            $sql = "SELECT * FROM ComptesBancaires WHERE id = $account_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<h3>Numéro de Compte: " . $row['numeroCompte'] . "</h3>";
                echo "<h4>Solde Actuel: $" . $row['solde'] . "</h4>";

                $transactions_sql = "SELECT * FROM Transactions WHERE compte_id = $account_id";
                $transactions_result = $conn->query($transactions_sql);

                if ($transactions_result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr><th>Date</th><th>Description</th><th>Montant</th></tr>";
                    while ($transaction = $transactions_result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $transaction['date'] . "</td>";
                        echo "<td>" . $transaction['description'] . "</td>";
                        echo "<td>$" . $transaction['montant'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "Aucune transaction trouvée.";
                }
            } else {
                echo "Compte non trouvé.";
            }

            $conn->close();
            ?>
        </div>
    </div>
</body>
</html>
