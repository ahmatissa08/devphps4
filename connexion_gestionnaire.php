<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connexion Gestionnaire - Banque</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <h2>Connexion Gestionnaire</h2>
        <form action="process_login_gestionnaire.php" method="post">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte gestionnaire ? <a href="creation_compte_gestionnaire.php">Créer un compte</a></p>
    </div>
</body>
</html>
