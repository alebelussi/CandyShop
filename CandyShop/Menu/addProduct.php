<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CandyShop - Product </title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="addProduct.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body>
    <?php include("../header.php"); ?>
    <div class="container">
        <h1> Inserisci i dati del prodotto </h1>
        <form action="../Prodotto/productManager.php" method="POST">
            <div class="row">
                <div class="column left">
                    <label for="Nome">Nome</label>
                    <input type="text" placeholder="Nome" name="nome" required autocomplete="off">

                    <label for="prezzo">Prezzo</label>
                    <input type="text" placeholder="Prezzo" name="prezzo" required autocomplete="off">

                    <label for="peso">Peso</label>
                    <input type="text" placeholder="Peso" name="peso" autocomplete="off">

                    <label for="quantitaMagazzino">Quantità in Magazzino</label>
                    <input type="text" placeholder="Quantita in magazzino" name="quantitaMagazzino" autocomplete="off">
                </div>

                <div class="column right">
                    <div class="center">
                        <label for="dataScadenza">Data di Scadenza</label>
                        <input type="date" name="dataScadenza" autocomplete="off">
    
                        <label for="percorsoImmagine">PercorsoImmagine</label>
                        <input type="text" placeholder="Percorso Immagine" name="percorsoImmagine" autocomplete="off">

                        <label for="codiceCategoria"> Codice Categoria </label> 
                        <input type="text" placeholder="Codice Categoria" name="codiceCategoria" autocomplete="off">
                    </div> 
                </div>
            </div>
            <div class="input-button">
                <button type="submit">Inserisci</button>
            </div>
        </form>
    </div>
</body>
</html>