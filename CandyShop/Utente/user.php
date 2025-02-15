<?php

    class User {

        public $username; 
        public $password;
        public $nome;
        public $cognome;
        public $email;
        public $codiceFiscale; 
        public $livelloFedelta;
        public $ruolo; 

        function __construct($username, $password, $nome, $cognome, $email, $codiceFiscale, $livelloFedelta, $ruolo) {
            $this->username = $username;
            $this->password = $password;
            $this->nome = $nome;
            $this->cognome = $cognome;
            $this->email = $email;
            $this->codiceFiscale = $codiceFiscale;
            $this->livelloFedelta = $livelloFedelta;
            $this->ruolo = $ruolo;
        }

        public function createTable($pdo) {
            
            try {
                
                $query = "CREATE TABLE IF NOT EXISTS Utente (
                    Username VARCHAR(20) NOT NULL, 
                    Nome VARCHAR(20) NOT NULL, 
                    Cognome VARCHAR(20) NOT NULL, 
                    Password VARCHAR(255) NOT NULL, 
                    Email VARCHAR(20), 
                    CodiceFiscale VARCHAR(20), 
                    LivelloFedelta ENUM('Standard', 'Premium', 'Gold'),
                    Ruolo ENUM('Cliente', 'Amministratore'),
                    
                    PRIMARY KEY (Username)
                )";

                $pdo->exec($query);
            } 
            catch(PDOException $e) {
                echo "Errore nella creazione della tabella Utente" . $e->getMessage();
            }
        }

        public function insertUser($pdo, $username, $nome, $cognome, $password, $email, $codiceFiscale, $livelloFedelta, $ruolo) {
            if(! $this->findUser($pdo, $username, $password)){
                try {
                    $query = "INSERT INTO Utente
                              (Username, Nome, Cognome, Password, Email, CodiceFiscale, LivelloFedelta, Ruolo)
                              VALUES (:user, :nome, :cognome, :psw, :email, :codiceFiscale, :livelloFedelta, :ruolo)";
                    
                    $prepQuery = $pdo->prepare($query);
    
                    $prepQuery->bindParam(':user', $username);
                    $prepQuery->bindParam(':nome', $nome);
                    $prepQuery->bindParam(':cognome', $cognome);
                    $prepQuery->bindParam(':psw', $password);
                    $prepQuery->bindParam(':email', $email);
                    $prepQuery->bindParam(':codiceFiscale', $codiceFiscale);
                    $prepQuery->bindParam(':livelloFedelta', $livelloFedelta);
                    $prepQuery->bindParam(':ruolo', $ruolo);
                    
                    if($prepQuery->execute()){
                        
                        session_start(); 
                        $_SESSION['user_role'] = $ruolo;
                        $_SESSION['username'] = $username;
                    }    
                }
                catch(PDOException $e) {
                    echo "Errore nell'inserimento dei dati" . $e->getMessage();
                }
            }
            else
                echo "Username già utilizzato";
        }

        public function findUser($pdo, $username, $password) {

            try {
                $query = "SELECT *
                          FROM Utente
                          WHERE Username = :username";
                
                $prepQuery = $pdo->prepare($query);

                $prepQuery->bindParam(':username', $username);

                if($prepQuery->execute()) {
                    $user = $prepQuery->fetch(PDO::FETCH_ASSOC);
                    if($user && password_verify($password, $user["Password"]))
                        return $user;
                    else 
                        return false;
                }
                    
            }
            catch(PDOException $e) {
                echo "Errore nell'esecuzione della query" . $e->getMessage();
            }
        }

        public function getUsers($pdo, $query) {
            try {
                $prepQuery = $pdo->prepare($query);
                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
                else
                    return [];
            }
            catch(PDOException $e) {
                echo "Errore nell'esecuzione della query" . $e->getMessage();
            }
        }

    }
?>

