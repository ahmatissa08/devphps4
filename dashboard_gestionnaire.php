<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'gestionnaire') {
    header("Location: connexion_gestionnaire.php");
    exit();
}
include 'db.php';

$sql = "SELECT * FROM comptesbancaires";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tableau de Bord Gestionnaire - Banque</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <section>
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
} else {
    echo "Aucun compte bancaire n'a été trouvé.";
}

$conn->close();
?>
