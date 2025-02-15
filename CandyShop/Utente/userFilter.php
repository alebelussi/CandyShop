<?php
    require "user.php";
    require "../connectionManager.php";

    $conn = ConnectionManager::getInstance();
    $user = new User("", "", "", "", "", "", "", "");
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $livelloFedelta = isset($_POST["livelloFedelta"]) ? $_POST["livelloFedelta"] :   "";
        $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
        $iniziale = isset($_POST["iniziale"]) ? $_POST["iniziale"] : "";
    }

    $query = "SELECT Username, Nome, Cognome, Email, CodiceFiscale, LivelloFedelta, Ruolo
              FROM Utente
              WHERE 1";
    
    if (!empty($livelloFedelta)) 
        $query .= " AND LivelloFedelta = '$livelloFedelta'";

    if (!empty($nome))
        $query .= " AND Nome = '$nome'";

    if (!empty($iniziale))
        $query .= " AND Nome LIKE '$iniziale%' ";

    $result = $user->getUsers($conn->getConnection(), $query);
    
    session_start();
    $_SESSION['query_result'] = $result;
    header("Location: ../Menu/viewUser.php");
    exit;
?>