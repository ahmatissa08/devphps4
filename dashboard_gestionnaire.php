<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'gestionnaire') {
    header("Location: connexion_gestionnaire.php");
    exit();
}
include 'db.php';

$sql = "SELECT * FROM ComptesBancaires";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tableau de Bord Gestionnaire - Banque</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="dashboard-container">
            <h2>Tableau de Bord Gestionnaire</h2>
            <p>Bienvenue, Gestionnaire <?php echo $_SESSION['user_id']; ?></p>

            <h3>Liste des Comptes Bancaires</h3>
            <table>
                <tr>
                    <th>Numéro de Compte</th>
                    <th>Propriétaire</th>
                    <th>Solde</th>
                    <th>Actions</th>
                </tr>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['numero_compte'] . "</td>";
                    echo "<td>" . $row['client_id'] . "</td>";
                    echo "<td>" . $row['solde'] . " €</td>";
                    echo "<td><a href='depot_retrait.php?numero_compte=" . $row['numero_compte'] . "'>Dépôt/Retrait</a> | <a href='virement.php?numero_compte=" . $row['numero_compte'] . "'>Virement</a></td>";
                    echo "</tr>";
                }
                ?>
            </table>

            <p><a href="logout.php">Déconnexion</a></p>
        </div>
    </body>
    </html>

    <?php
} else {
    echo "Aucun compte bancaire n'a été trouvé.";
}

$conn->close();
?>
