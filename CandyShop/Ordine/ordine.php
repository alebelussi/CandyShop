<?php

    class Ordine {

        public $codiceOrdine; 
        public $importo;
        public $cittaConsegna; 
        public $CAP;
        public $via; 
        public $tipo; 
        public $modalitaSpedizione; 
        public $puntiFedelta; 
        public $dataConsegna; 
        public $dataOrdine; 
        public $username; 
        public $codiceNegozio; 

        public function __construct($codiceOrdine, $importo, $cittaConsegna, $CAP, $via, $tipo, $modalitaSpedizione, 
                                    $puntiFedelta, $dataConsegna, $dataOrdine, $username, $codiceNegozio) {
            $this->codiceOrdine = $codiceOrdine;
            $this->importo = $importo;
            $this->cittaConsegna = $cittaConsegna;
            $this->CAP = $CAP;
            $this->via = $via;
            $this->tipo = $tipo;
            $this->modalitaSpedizione = $modalitaSpedizione;
            $this->puntiFedelta = $puntiFedelta;
            $this->dataConsegna = $dataConsegna;
            $this->dataOrdine = $dataOrdine;
            $this->username = $username;
            $this->codiceNegozio = $codiceNegozio;
            }

        public function createTable($pdo) {

            try {
                $query = "CREATE TABLE IF NOT EXISTS Spesa (
                    CodiceOrdine VARCHAR(255) NOT NULL,
                    Importo FLOAT NOT NULL, 
                    CittaConsegna VARCHAR(20),
                    CAP VARCHAR(20),
                    Via VARCHAR(20),
                    Tipo VARCHAR(30) NOT NULL,
                    ModalitaSpedizione VARCHAR(30),
                    PuntiFedelta INT NOT NULL,
                    DataConsegna DATE,
                    DataOrdine DATE NOT NULL, 
                    Username VARCHAR(20) NOT NULL, 
                    CodiceNegozio VARCHAR(20) NOT NULL, 

                    PRIMARY KEY (CodiceOrdine),
                    FOREIGN KEY (Username) REFERENCES Utente(Username),
                    FOREIGN KEY (CodiceNegozio) REFERENCES Negozio(CodiceNegozio)
                    );";

                    $pdo->exec($query);
            }
            catch(PDOException $e) {
                echo "Errore nella creazione della tabella Spesa" . $e->getMessage();
            }
        }

        public function insertOrdine($pdo, $codiceOrdine, $importo, $cittaConsegna, $CAP, $via, $tipo, $modalitaSpedizione, 
                                    $puntiFedelta, $dataConsegna, $dataOrdine, $username, $codiceNegozio) {
            try {
                $query = "INSERT INTO Spesa
                          (CodiceOrdine, Importo, CittaConsegna, CAP, Via, Tipo, ModalitaSpedizione, PuntiFedelta, DataConsegna, DataOrdine, Username, CodiceNegozio)
                          VALUES (:codice, :importo, :citta, :cap, :via, :tipo, :spedizione, :punti, :dataConsegna, :dataOrdine, :username, :codiceNegozio)";
                
                $prepQuery = $pdo->prepare($query);

                $prepQuery->bindParam(':codice', $codiceOrdine);
                $prepQuery->bindParam(':importo', $importo);
                $prepQuery->bindParam(':citta', $cittaConsegna);
                $prepQuery->bindParam(':cap', $CAP);
                $prepQuery->bindParam(':via', $via);
                $prepQuery->bindParam(':tipo', $tipo);
                $prepQuery->bindParam(':spedizione', $modalitaSpedizione);
                $prepQuery->bindParam(':punti', $puntiFedelta);
                $prepQuery->bindParam(':dataConsegna', $dataConsegna);
                $prepQuery->bindParam(':dataOrdine', $dataOrdine);
                $prepQuery->bindParam(':username', $username);
                $prepQuery->bindParam(':codiceNegozio', $codiceNegozio);
                
                $prepQuery->execute();
                
            }
            catch(PDOException $e) {
                echo "Errore nell'inserimento dei dati nella tabella Spesa " . $e->getMessage();
            }
        }

        public function updateOrdine($pdo, $codiceOrdine, $importo, $cittaConsegna, $CAP, $via, $modalitaSpedizione, 
                                    $puntiFedelta, $dataConsegna, $dataOrdine, $username, $codiceNegozio) {
            try {
                $query = "UPDATE Spesa
                          SET Importo = :importo, CittaConsegna = :citta, CAP = :cap, Via = :via, ModalitaSpedizione = :spedizione, 
                            PuntiFedelta = :punti, DataConsegna = :dataConsegna, DataOrdine = :dataOrdine, CodiceNegozio = :codiceNegozio
                          WHERE CodiceOrdine = :codiceOrdine AND Username = :username";
                
                $prepQuery = $pdo->prepare($query);

                $prepQuery->bindParam(':codiceOrdine', $codiceOrdine);
                $prepQuery->bindParam(':importo', $importo);
                $prepQuery->bindParam(':citta', $cittaConsegna);
                $prepQuery->bindParam(':cap', $CAP);
                $prepQuery->bindParam(':via', $via);
                $prepQuery->bindParam(':spedizione', $modalitaSpedizione);
                $prepQuery->bindParam(':punti', $puntiFedelta);
                $prepQuery->bindParam(':dataConsegna', $dataConsegna);
                $prepQuery->bindParam(':dataOrdine', $dataOrdine);
                $prepQuery->bindParam(':username', $username);
                $prepQuery->bindParam(':codiceNegozio', $codiceNegozio);

                if($prepQuery->execute())
                    echo "Ordine completato";
            }
            catch(PDOException $e) {
                echo "Errore nell'aggiornamento dell'ordine" . $e->getMessage();
            }
        }

        public function viewOrder($pdo, $username) {
            try {
                $query = "SELECT CodiceOrdine, Importo, CittaConsegna, CAP, Via, ModalitaSpedizione, PuntiFedelta, DataConsegna, DataOrdine, Username, CodiceNegozio
                          FROM Spesa
                          WHERE 1";

                if(isset($username) && $username !== "admin"){
                    $query .= " AND Username = :user";
                    $prepQuery = $pdo->prepare($query);
                    $prepQuery->bindParam(':user', $username);
                }
                else 
                    $prepQuery = $pdo->prepare($query);

                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
                else
                    return [];      
            }
            catch(PDOException $e) {
                echo "Errore durante l'esecuzione della query " . $e->getMessage();
            }
        }

        public function totalePrize($pdo, $username) {
            try {
                $query = "SELECT SUM(S.Importo) AS SpesaTotale
                        FROM Spesa S JOIN Utente U ON U.Username = S.Username
                        WHERE U.Username = :username
                        GROUP BY U.Username
                      ";

                $prepQuery = $pdo->prepare($query);
                $prepQuery->bindParam(':username', $username);

                if($prepQuery->execute())
                    return $prepQuery->fetchColumn();
                else
                    return [];
                   
            }
            catch(PDOException $e) {
                echo "Errore durante l'esecuzione della query " . $e->getMessage();
            }
        }

        public function getUser($pdo) {
            try {
                $query = "SELECT DISTINCT Username
                          FROM Spesa";

                $prepQuery = $pdo->prepare($query);

                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
                else
                    return [];
                   
            }
            catch(PDOException $e) {
                echo "Errore durante l'esecuzione della query " . $e->getMessage();
            }
        }

        public function insertSale($pdo, $codiceNegozio, $nomeProdotto, $quantitaOrdinata) {
            try {
                $query = "INSERT INTO Vendita
                          (CodiceNegozio, Nome, QuantitaVenduta)
                          VALUES (:codiceNegozio, :nome, :quantitaOrdinata)
                          ON DUPLICATE KEY UPDATE QuantitaVenduta = QuantitaVenduta + :quantitaOrdinata";
            
                $prepQuery = $pdo->prepare($query);
                
                $prepQuery->bindParam(':codiceNegozio', $codiceNegozio);
                $prepQuery->bindParam(':nome', $nomeProdotto);
                $prepQuery->bindParam(':quantitaOrdinata', $quantitaOrdinata);

                $prepQuery->execute();
            }
            catch(PDOException $e) {
                echo "Errore duranta il caricamento della vendita " . $e->getMessage();
            }
        }

        public function getOrderDate($pdo) {
            try {
                $query = "SELECT DISTINCT S.DataOrdine
                          FROM Spesa S
                          ORDER BY S.DataOrdine DESC";

                $prepQuery = $pdo->prepare($query);

                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
                else 
                    return []; 
            }
            catch(PDOException $e) {
                echo "Errore durante l'esecuzione della query " . $e->getMessage();
            }
        }

        public function deleteOrder($pdo, $codiceOrdine) {
            try {
                $query = "DELETE FROM Spesa WHERE CodiceOrdine = :codiceOrdine";

                $prepQuery = $pdo->prepare($query);
                $prepQuery->bindParam(':codiceOrdine', $codiceOrdine);
                
                $prepQuery->execute();
            }
            catch(PDOException $e) {
                echo "Errore durante l'eliminazione del record " . $e->getMessage();
            }
        }
    }

?>