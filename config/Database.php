<?php
    class Database {
    
        private $host = "localhost";
        private $db_name = "mosyle";
        private $username = "root";
        private $password = "root";
        public $conn = null;
    
        public function getConnection(){

            try {

                $this->conn = new PDO(
                                        "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                                        $this->username,
                                        $this->password
                                    );

                $this->conn->exec("set names utf8");
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            } catch(PDOException $ex){
                throw new ExceptionHelper($ex->getMessage());
            }

            return $this->conn;

        }
    }
?>