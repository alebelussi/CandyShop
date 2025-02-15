<?php

    require "user.php";
    require "../connectionManager.php";

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
        }
    }

    $user = new User("", "", "", "", "", "", "", "");
    $conn = ConnectionManager::getInstance();

    $user->createTable($conn->getConnection());
    if($user->findUser($conn->getConnection(), $username, $password) != false){
        $utente = $user->findUser($conn->getConnection(), $username, $password);
        
        session_start(); 
        $_SESSION['user_role'] = $utente['Ruolo'];
        $_SESSION['username'] = $username;

        header("Location: ../Menu/homePage.php");
        exit;
    }
    else
       header("Location: ../Menu/login.html");
    exit;
        
?>