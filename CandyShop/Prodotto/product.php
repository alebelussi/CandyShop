<?php 

    class Product {

        public $nome; 
        public $prezzo; 
        public $peso; 
        public $quantitaMagazzino;
        public $dataScadenza; 
        public $percorsoImmagine;
        public $codiceCategoria;

        public function __construct($nome, $prezzo, $peso, $quantitaMagazzino, $dataScadenza, $percorsoImmagine, $codiceCategoria) {
            $this->nome = $nome;
            $this->prezzo = $prezzo;
            $this->peso = $peso;
            $this->quantitaMagazzino = $quantitaMagazzino;
            $this->dataScadenza = $dataScadenza;
            $this->percorsoImmagine = $percorsoImmagine;
            $this->codiceCategoria = $codiceCategoria;
        }

        public function createTable($pdo) {

            try {
                $query = "CREATE TABLE IF NOT EXISTS Prodotto (
                    Nome VARCHAR(30) NOT NULL, 
                    Prezzo INT NOT NULL, 
                    Peso FLOAT, 
                    QuantitaMagazzino INT NOT NULL, 
                    DataScadenza DATE, 
                    PercorsoImmagine VARCHAR(255),
                    CodiceCategoria VARCHAR(20) NOT NULL,
                    
                    PRIMARY KEY(Nome),
                    FOREIGN KEY (CodiceCategoria) REFERENCES Categoria(CodiceCategoria)
                );";

                $pdo->exec($query);
                echo "Tabella creata <br>"; 
            }
            catch(PDOException $e) {
                echo "Errore nella creazione della tabella Prodotto" . $e->getMessage();
            }
        }

        public function insertProduct($pdo, $nome, $prezzo, $peso, $quantitaMagazzino, $dataScadenza, $percorsoImmagine, $codiceCategoria) {

            try {
                $query = "INSERT INTO Prodotto
                        (Nome, Prezzo, Peso, QuantitaMagazzino, DataScadenza, PercorsoImmagine, CodiceCategoria)
                        VALUES (:nome, :prezzo, :peso, :quantita, :dataS, :img, :codiceCategoria) "; 
                
                $prepQuery = $pdo->prepare($query);

                $prepQuery->bindParam(':nome', $nome);
                $prepQuery->bindParam(':prezzo', $prezzo);
                $prepQuery->bindParam(':peso', $peso);
                $prepQuery->bindParam(':quantita', $quantitaMagazzino);
                $prepQuery->bindParam(':dataS', $dataScadenza);
                $prepQuery->bindParam(':img', $percorsoImmagine);
                $prepQuery->bindParam(':codiceCategoria', $codiceCategoria);

                if($prepQuery->execute())
                    echo "Inserimento completato <br>";
                else
                    echo "Errore nell'inserimeno";
            }
            catch(PDOException $e) {
                echo "Errore nell'inserimento dei dati nella tabella Prodotto" . $e->getMessage();
            }
        }

        public function getProducts($pdo, $query) {
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