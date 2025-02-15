<?php
    require "user.php";
    require "../connectionManager.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["nome"]) && isset($_POST["cognome"])) {
            $username = $_POST["username"];
            $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $nome = $_POST["nome"];
            $cognome = $_POST["cognome"];
            $email = $_POST["email"];
            $codiceFiscale = $_POST["codiceFiscale"]; 
        }
    }

    $user = new User($username, $password, $nome, $cognome, $email, $codiceFiscale, "Standard", "Cliente");
    $conn = ConnectionManager::getInstance();

    $user->createTable($conn->getConnection());
    $user->insertUser($conn->getConnection(), $username, $nome, $cognome, $password, $email, $codiceFiscale, "Standard", "Cliente");
    
    header("Location: ../Menu/homePage.php");
    exit; 
?>