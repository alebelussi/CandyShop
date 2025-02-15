<?php

    class Category {

        public function getCategoryList($pdo) {

            try {
                $query = "SELECT CodiceCategoria, Nome
                          FROM Categoria"; 

                $prepQuery = $pdo->prepare($query);

                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e) {
                echo "Errore nell'esecuzione della query" . $e->getMessage();
            }
        }

        public function getCategorySale($pdo) {
            try {
                $query = "SELECT C.CodiceCategoria, C.Nome
                          FROM Categoria C
                          WHERE C.CodiceCategoria IN (SELECT P.CodiceCategoria
                                                      FROM Prodotto P JOIN Vendita V ON P.Nome = V.Nome
                                                      )"; 

                $prepQuery = $pdo->prepare($query);

                if($prepQuery->execute())
                    return $prepQuery->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e) {
                echo "Errore nell'esecuzione della query" . $e->getMessage();
            }
        }
    }


?>
