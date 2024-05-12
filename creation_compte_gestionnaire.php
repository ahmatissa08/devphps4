<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Création de compte gestionnaire - Banque</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="create-account-container">
        <h2>Création de compte gestionnaire</h2>
        <form action="process_creation_compte_gestionnaire.php" method="post">
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required>
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>
            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse" required>
            <label for="telephone">Téléphone:</label>
            <input type="text" id="telephone" name="telephone" required>
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Créer le compte gestionnaire</button>
        </form>
    </div>
</body>
</html>
