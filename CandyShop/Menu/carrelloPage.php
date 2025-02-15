<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CandyShop - Cart</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="carrelloPage.css">
    <link rel="icon" href="../Immagini/logoCandyshop.png" type="image/x-icon">
</head>
<body>
    <div class="container">
    <?php
        include "../header.php";
        require "../Ordine/carrello.php";
        require "../Ordine/ordine.php";
        require "../connectionManager.php";

        $conn = ConnectionManager::getInstance();

        echo "<h1> Dai un'occhiata al tuo carrello! </h1>";
        echo "<hr>";

        session_start();
        if(!isset($_SESSION['codiceOrdine'])){
            /* --- GENERAZIONE DEL CODICE ORDINE ---
                Vengono generati tre byte che successivamente vengono codiciati da binario in esadecimale; 
                infine vengono presi soltanto i primi sei caratteri.
            */
            $codiceOrdine = substr(bin2hex(random_bytes(3)), 0, 6); 
            $_SESSION['codiceOrdine'] = $codiceOrdine;
        }
        else
            $codiceOrdine = $_SESSION['codiceOrdine'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $prodotto = [
                'nome' => htmlspecialchars($_POST['nome']),
                'descrizione' => htmlspecialchars($_POST['descrizione']),
                'prezzo' => htmlspecialchars($_POST['prezzo']),
                'quantitaOrdinata' => htmlspecialchars($_POST['quantitaOrdinata']),
                'immagine' => htmlspecialchars($_POST['immagine'])
            ];

            $_SESSION['prodotto'][] = $prodotto;  
        } 

        $ordine = new Ordine($codiceOrdine, 10, "", "", "", "Online", "", 10, null, date('Y-m-d'), $_SESSION['username'], "002");
        $ordine->createTable($conn->getConnection());
        $ordine->insertOrdine($conn->getConnection(), $codiceOrdine,  10, "", "", "", "Online", "", 10, null, date('Y-m-d'), $_SESSION['username'], "002");

        $carrello = new Carrello($codiceOrdine, $prodotto['nome'], $prodotto['quantitaOrdinata']);
        $carrello->createTable($conn->getConnection());
        $carrello->insert($conn->getConnection(), $codiceOrdine, $prodotto['nome'], $prodotto['quantitaOrdinata']);
        $carrello->setQuantity($conn->getConnection(), $prodotto['nome'], $prodotto['quantitaOrdinata']);
        $carrello->viewCart($conn->getConnection());

        $_SESSION['puntiFedelta'] = $carrello->totaleSpesa / 2;
    ?>
    
        <div class="buttons-container">
            <form action="viewProduct.php" method="POST">
                <input type="submit" value="Aggiungi Prodotti">
            </form>
            <form action="../Ordine/deleteCart.php" method="POST">
                <input type="submit" value="Cancella Ordine">
            </form>
            <form action="ordinePage.php" method="POST">
                <input type="submit" value="Conferma Ordine">
            </form>
        </div>
    </div>
    

</body>
</html>