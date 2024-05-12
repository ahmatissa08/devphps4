<?php
session_start();

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM gestionnaires WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password']; 
        if ($password === $stored_password) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = 'gestionnaire';
            
            header("Location: dashboard_gestionnaire.php");
            exit();
        } else {
            echo "Mot de passe incorrect pour l'utilisateur: $username";
        }
    } else {
        echo "Aucun gestionnaire trouvé pour le nom d'utilisateur: $username";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: connexion_gestionnaire.php");
    exit();
}
?>
