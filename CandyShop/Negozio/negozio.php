<?php
    class Negozio {

        public function addProductAllert($pdo) {
            try {
                $query = "SELECT N.Nome AS 'Nome Negozio', N.CodiceNegozio AS 'Codice Negozio', P.Nome AS 'Nome Prodotto'
                            FROM Negozio N JOIN Vendita V ON N.CodiceNegozio = V.CodiceNegozio
                            JOIN Prodotto P ON V.Nome = P.Nome
                            WHERE P.Nome IN (
                                SELECT P.Nome
                                FROM Prodotto P
                                JOIN Categoria C ON P.CodiceCategoria = C.CodiceCategoria
                                WHERE P.QuantitaMagazzino < C.ScorteMinime
                            )";

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

        public function avgQuantitySale($pdo, $codiceCategoria) {
            try {
                $query = "SELECT ROUND(AVG(V.QuantitaVenduta), 2) AS 'Quantità Venduta', N.Nome, V.CodiceNegozio AS 'Codice Negozio'
                          FROM Vendita V, Negozio N
                          WHERE V.CodiceNegozio = N.CodiceNegozio AND V.Nome IN (SELECT P.Nome
                                                                                 FROM Prodotto P
                                                                                 WHERE P.CodiceCategoria = :categoria) 
                          GROUP BY V.CodiceNegozio";
                
                $prepQuery = $pdo->prepare($query);
                
                $prepQuery->bindParam(':categoria', $codiceCategoria);

                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
                else
                    return 0;
            }
            catch(PDOException $e) {
                echo "Errore durante l'esecuzion della query" . $e->getMessage();
            }
        }

        public function foundShop($pdo, $codiceCategoria) {
            try {
                $query = "SELECT DISTINCT N.Citta, N.Nome, V.QuantitaVenduta AS 'Massima Quantità'
                          FROM Vendita V JOIN NEGOZIO N ON V.CodiceNegozio = N.CodiceNegozio
                          WHERE V.Nome IN (SELECT P.Nome 
                                           FROM Prodotto P 
                                           WHERE P.CodiceCategoria = :categoria)
                                AND V.QuantitaVenduta = (SELECT MAX(V2.QuantitaVenduta)
                                                        FROM Vendita V2 JOIN Prodotto P ON V2.Nome = P.Nome
                                                        WHERE P.CodiceCategoria = :categoria)";
                
                $prepQuery = $pdo->prepare($query);
                
                $prepQuery->bindParam(':categoria', $codiceCategoria);

                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
                else
                    return [];
            }
            catch(PDOException $e) {
                echo "Errore durante l'esecuzion della query" . $e->getMessage();
            }
        }

        public function shopMostSales($pdo, $dataOrdine) {
            try {
                $query = "SELECT N.Nome, SUM(V.QuantitaVenduta) AS 'Quantita Venduta'
                          FROM Negozio N JOIN Vendita V ON N.CodiceNegozio = V.CodiceNegozio
                          WHERE N.CodiceNegozio IN (SELECT S.CodiceNegozio 
                                                    FROM Spesa S 
                                                    WHERE S.DataOrdine = :dataOrdine)
                          GROUP BY V.CodiceNegozio
                ";

                $prepQuery = $pdo->prepare($query);
                $prepQuery->bindParam(':dataOrdine', $dataOrdine);

                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e) {
                echo "Errore durante l'esecuzione della query" . $e->getMessage();
            }
        }

        public function getShop($pdo) {
            try {
                $query = "SELECT N.Nome, N.CodiceNegozio
                          FROM Negozio N";

                $prepQuery = $pdo->prepare($query);

                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
                else 
                    return []; 
                    
            }
            catch(PDOException $e) {
                echo "Errore durante l'esecuzione della query" . $e->getMessage();
            }
        }

    }

?>