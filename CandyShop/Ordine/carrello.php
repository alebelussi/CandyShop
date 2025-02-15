<?php

    class Carrello {

        public $codiceOrdine;
        public $nomeProdotto; 
        public $quantitaOrdinata;
        public $totaleSpesa; 

        public function __construct($codiceOrdine, $nomeProdotto, $quantitaOrdinata) {
            $this->codiceOrdine = $codiceOrdine;
            $this->nomeProdotto = $nomeProdotto;
            $this->quantitaOrdinata = $quantitaOrdinata;
        }

        public function createTable($pdo) {
            try {
                $query = "CREATE TABLE IF NOT EXISTS Ordina (
                    CodiceOrdine VARCHAR(255) NOT NULL,
                    Nome VARCHAR(30) NOT NULL, 
                    QuantitaOrdinata INT,
                    
                    PRIMARY KEY (CodiceOrdine, Nome),
                    FOREIGN KEY (CodiceOrdine) REFERENCES Spesa(CodiceOrdine),
                    FOREIGN KEY (Nome) REFERENCES Prodotto(Nome)
                    );
                ";
                $pdo->exec($query);
            }
            catch(PDOException $e) {
                echo "Errore nella creazione della tabella Ordina" . $e->getMessage();
            }
        }

        public function insert($pdo, $codiceOrdine, $nomeProdotto, $quantitaOrdinata) {
            try {
                $query = "INSERT INTO Ordina
                          (CodiceOrdine, Nome, QuantitaOrdinata)
                          VALUES (:codice, :nome, :quantita)
                          ON DUPLICATE KEY UPDATE QuantitaOrdinata = QuantitaOrdinata + :quantita";
                
                $prepQuery = $pdo->prepare($query);

                $prepQuery->bindParam(':codice', $codiceOrdine);
                $prepQuery->bindParam(':nome', $nomeProdotto);
                $prepQuery->bindParam(':quantita', $quantitaOrdinata);
                
                $prepQuery->execute();
              
            }
            catch(PDOException $e) {
                echo "Errore nell'inserimento dei dati" . $e->getMessage();
            }
        }

        public function viewCart($pdo) {
            try {
                $query = "SELECT O.Nome, O.QuantitaOrdinata, P.PercorsoImmagine, P.Prezzo
                          FROM Ordina O, Prodotto P
                          WHERE P.Nome = O.Nome AND CodiceOrdine = :codiceOrdine";
                
                $prepQuery = $pdo->prepare($query);
                
                $prepQuery->bindParam(":codiceOrdine", $this->codiceOrdine);
                $prepQuery->execute();
                $products = $prepQuery->fetchAll(PDO::FETCH_ASSOC);
                
                if ($products) {
                    echo "<div class='product-grid'>"; 
                    
                    foreach ($products as $product) {
                        $this->totaleSpesa += $product['Prezzo'] * $product['QuantitaOrdinata'];

                        echo "<div class='product-item'>";
                        
                        echo "<img src='" . $product['PercorsoImmagine'] . "' alt='" . $product['Nome'] . "'>";
                        
                        echo "<div class='product-details'>";
                        echo "<h3 style='font-size: 18px; margin: 0;'>" . $product['Nome'] . "</h3>";
                        echo "<p style='font-size: 14px; margin: 0;'>Quantità: " . $product['QuantitaOrdinata'] . "</p>";
                        echo "<p style='font-size: 12px; margin: 0;'>Prezzo: " . $product['Prezzo']. " €" . "</p>";
                        echo "</div>";
        
                        echo "</div>"; 
                    }
                    $_SESSION['prezzoTotale'] = $this->totaleSpesa;
                    echo "</div>";
                    echo "<p class='total-price'> Totale del carrello: " . number_format($this->totaleSpesa, 2) . " €</p>";

                } 
                else 
                    echo "<p>Il carrello è vuoto.</p>";
                
            } catch (PDOException $e) {
                echo "Errore nella visualizzazione dei prodotti del carrello " . $e->getMessage();
            }
        }

        public function setQuantity($pdo, $nome, $quantitaOrdinata) {

            try {
                
                $query = "UPDATE Prodotto
                          SET QuantitaMagazzino = QuantitaMagazzino - :quantitaOrdinata
                          WHERE Nome = :nome";
                
                $prepQuery = $pdo->prepare($query);

                $prepQuery->bindParam(":nome", $nome);
                $prepQuery->bindParam(":quantitaOrdinata", $quantitaOrdinata);

                $prepQuery->execute();
            }
            catch(PDOException $e) {
                echo "Errore nella modifica della quantità in magazzino " . $e->getMessage();
            }
        }

        public function deleteOrder($pdo, $codiceOrdine) {
            try {
                $query = "DELETE FROM Ordina WHERE CodiceOrdine = :codiceOrdine";

                $prepQuery = $pdo->prepare($query);
                $prepQuery->bindParam(":codiceOrdine", $codiceOrdine);

                $prepQuery->execute();
            }
            catch(PDOException $e) {
                echo "Errore durante l'eliminazione del record " . $e->getMessage();
            }
        }
    }
?>