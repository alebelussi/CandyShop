<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conferma Ordine</title>
    <link rel="stylesheet" href="orderConfirmation.css">
    <link rel="stylesheet" href="menu.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body>
    <?php
        include("../header.php");

        session_start();
    ?>

    <div class="container">
        <div class="confirmation-box">
            <h1>🎉 Ordine Confermato!</h1>
            <p>Grazie per il tuo acquisto. Il tuo ordine è stato ricevuto con successo.</p>
            <p><strong>ID Ordine: <?php echo $_SESSION['codiceOrdine'] ?></strong></p>
            <p>Riceverai presto un'email con i dettagli del tuo acquisto.</p>
            <a href="homePage.php" class="home-button">Torna alla Home</a>
        </div>
    </div>

    <?php  unset($_SESSION['codiceOrdine']); ?>
</body>
</html>
