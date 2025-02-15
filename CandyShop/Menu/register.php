<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CandyShop - Registration </title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="register.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body>
    <?php include("../header.php"); ?>

    <div class="login-container">
    <div class="login-box">
      <div class="login-form">
        <h2>Crea il tuo account</h2>
        <form action="../Utente/registration.php" method="POST">
          <div class="input-group"> Nome
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Nome" name="nome" required autocomplete="off">
          </div>
          <div class="input-group"> Cognome
            <i class="fas fa-user-tie"></i>
            <input type="text" placeholder="Cognome" name="cognome" required autocomplete="off">
          </div>
          <div class="input-group"> Codice Fiscale
            <i class="fas fa-id-card"></i>
            <input type="text" placeholder="Codice Fiscale" name="codiceFiscale" autocomplete="off">
          </div>
          <div class="input-group"> E-mail
            <i class="fas fa-envelope"></i>
            <input type="text" placeholder="E-mail" name="email" autocomplete="off">
          </div>
          <div class="input-group"> Username
            <i class="fas fa-user-secret"></i>
            <input type="text" placeholder="Username" name="username" required autocomplete="off">
          </div>
          <div class="input-group"> Password
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" required autocomplete="off">
          </div>
          <div class="input-button">
            <button type="submit">Accedi</button>
          </div>
        </form>
        
      </div>

      <div class="welcome-section">
        <h2>Benvenuto!</h2>
        <p>Crea il tuo account e accedi al mondo CandyShop</p>
        <a href="login.html"> Login </a>
      </div>
    </div>
  </div>
</body>
</html>