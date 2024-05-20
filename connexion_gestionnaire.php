<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Connexion Gestionnaire - Banque</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
      <div class="login-section">
        <div class="login-box">
          <h2>Login</h2>
          <form action="process_login_gestionnaire.php" method="POST">
            <div class="input-box">
              <input type="username" autocomplete="off" name="username" class="input" placeholder="Username">
            </div>
            <div class="input-box">
              <input type="password" autocomplete="off" name="password" class="input" placeholder="Password">
            </div>
            <div class="forgot-password">
              <a href="#">Forgot Password?</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <div class="signup-link">
              <a href="creation_compte_gestionnaire.php">Signup</a>
            </div>
          </form>
        </div>
        
      </div>
</body>
</html>
