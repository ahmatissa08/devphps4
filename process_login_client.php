<?php
session_start();

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM clients WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
    
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = 'client';
            
            header("Location: dashboard_client.php");
            exit();
        } else {
            echo "Mot de passe incorrect pour l'utilisateur: $username";
        }
    } else {
        echo "Aucun utilisateur trouvé pour le nom d'utilisateur: $username";
    }

    
    $stmt->close();
    $conn->close();
} else {
    header("Location: inde.html");
    exit();
}
?>
