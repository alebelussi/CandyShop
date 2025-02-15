<?php
    class ConnectionManager {

        private static $instance = null;
        private $connection;

        const HOST = 'localhost';
        const USERNAME = 'root';
        const PASSWORD = 'root';
        const DATABASE = 'CandyShop';
        
        function __construct() {
            $this->createConnection();
        }

        function __destruct() {}

        public function createConnection() {
            try {
                $this->connection = new PDO(
                    "mysql:host=" . self::HOST . ";dbname=" . self::DATABASE, 
                    self::USERNAME, 
                    self::PASSWORD
                );
            } catch (PDOException $e) {
                die("Connessione non stabilita: " . $e->getMessage());
            }
        }

        public static function getInstance() {
            if(self::$instance === null) 
                self::$instance = new ConnectionManager();
            return self::$instance;
        }

        public function getConnection() {
            return $this->connection;
        }

    }
?>