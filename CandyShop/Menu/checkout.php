<?php
    require "../connectionManager.php";
    require "../Ordine/ordine.php";

    $conn = ConnectionManager::getInstance();
    
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["importo"]) && isset($_POST["cittaConsegna"]) && isset($_POST["via"]) && isset($_POST["modalitaSpedizione"])){
            $ordine = [
                'importo' => htmlspecialchars($_POST["importo"]),
                'cittaConsegna' => htmlspecialchars($_POST["cittaConsegna"]),
                'cap' => htmlspecialchars($_POST["cap"]),
                'via' => htmlspecialchars($_POST["via"]),
                'modalitaSpedizione' => htmlspecialchars($_POST["modalitaSpedizione"]),
                'negozio' => htmlspecialchars($_POST["negozio"])
            ];
        } 
    }

    /* --- GENERAZIONE DELLA DATA DI CONSEGNA
        strtotime(): genera un timestamp corrispondente a n giorni da oggi
        date(): conerte il timestamp passato come parametro nel formato
        rand(): genera un numero casuale
    */
    
    $timestampInizio = strtotime(date("Y-m-d", strtotime("+3 days")));
    $timestampFine = strtotime(date("Y-m-d", strtotime("+7 days")));

    $timestampCasuale = rand($timestampInizio, $timestampFine);

    $dataConsegna = date("Y-m-d", $timestampCasuale);

    $codiceOrdine = $_SESSION['codiceOrdine'];
    $order = new Ordine($codiceOrdine, $ordine['importo'], $ordine['cittaConsegna'], $ordine['cap'], $ordine['via'], "Online",
                        $ordine['modalitaSpedizione'], $_SESSION['puntiFedelta'], $dataConsegna, date("Y-m-d"), $_SESSION['username'], $ordine['negozio']);
    $order->updateOrdine($conn->getConnection(), $codiceOrdine, $ordine['importo'], $ordine['cittaConsegna'], $ordine['cap'], $ordine['via'], 
                        $ordine['modalitaSpedizione'], $_SESSION['puntiFedelta'], $dataConsegna, date("Y-m-d"), $_SESSION['username'], $ordine['negozio']);
    foreach($_SESSION['prodotto'] as $prodotto){
        $order->insertSale($conn->getConnection(), $ordine['negozio'], $prodotto['nome'], $prodotto['quantitaOrdinata']);
    }

    unset($_SESSION['puntiFedelta']);
    unset($_SESSION['quantitaOrdinata']);
    unset($_SESSION['prodotto']);

    header("Location: orderConfirmation.php");
?>
