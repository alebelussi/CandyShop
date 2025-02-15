<?php

    class Utility {

        public static function createTable($queryResult) {
            if(empty($queryResult)){
                echo "Nessun utente trovato";
                return;
            }
               
            echo "<table border = '1' cellspacing = '1' cellpadding = '10'>";
            echo "<tr>";

            foreach (array_keys($queryResult[0]) as $columnName) {
                echo "<th>" . htmlspecialchars($columnName) . "</th>";
            }
            
            echo "</tr>";

            foreach ($queryResult as $row) {
                echo "<tr>";
                foreach ($row as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>"; 
                }

                echo "</tr>";
            }

            echo "</table>";
            
        }
    }
?>