<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Création de compte client - Banque</title>
    <link rel="stylesheet" href="./style.css" />
</head>
<body>
<div class="container">
<div class="login-section">
<div class="login-box">
        <h2>Création de compte client</h2>
        <form action="process_creation_compte_client.php" method="post">
        <div class="input-box">
              <input type="prenom" required />
              <label>Prenom</label>
            </div>
        <div class="input-box">
              <input type="nom" required />
              <label>Nom</label>
            </div>
            <div class="input-box">
              <input type="adresse" required />
              <label>Adresse</label>
            </div>
            <div class="input-box">
              <input type="telephone" required />
              <label>Telephone</label>
            </div>
            <div class="input-box">
              <input type="username" required />
              <label>Username</label>
            </div>
            <div class="input-box">
              <input type="password" required />
              <label>Password</label>
            </div>
            <button type="submit" class="btn">Créer le Compte</button>
        </div>
        </form>
    </div>
    </div>
    </div>
</body>
</html>
