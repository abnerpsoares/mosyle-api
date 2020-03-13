<?php
    class DrinkMonitor extends Model {
    
        private $tableName = "drinksMonitor";
        
        public $userId;
        public $drinkMl;
        public $createdAt;
    
        protected function create(){

            $query = "INSERT INTO $this->tableName SET userId=:userId, drinkMl=:drinkMl";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":userId", $this->userId);
            $stmt->bindParam(":drinkMl", $this->drinkMl);
            
            return $stmt->execute();

        }

        public function fetchAll($userId){
            
            $query = "SELECT id, drinkMl as drink_ml, createdAt as created_at FROM $this->tableName WHERE userId=:userId";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":userId", $userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

        public function getRanking(){
            
            $query = "SELECT
                            u.id as iduser,
                            u.name,
                            SUM(d.drinkMl) as drink_ml
                        FROM
                            $this->tableName as d
                            LEFT JOIN users as u ON d.userId = u.id
                        WHERE
                            CAST(d.createdAt as DATE) = '" . date('Y-m-d') . "'
                        GROUP BY
                            u.id
                        ORDER BY
                            drink_ml DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

    }
?>