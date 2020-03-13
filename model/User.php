<?php
    class User extends Model {
    
        private $tableName = "users";
        
        public $email;
        public $name;
        private $password;

        public function __constructWithArg($iduser){
            $user = $this->fetch($iduser);
            $this->id = $user['iduser'];
            $this->email = $user['email'];
            $this->name = $user['name'];
            $this->password = $user['password'];
        }

        public function setPassword($password){
            $this->password = $password;
        }

        private function getPasswordHash(){
            return password_hash($this->password, PASSWORD_BCRYPT);
        }

        public function authCheck(){
            
            $query = "SELECT id as iduser, email, name, password FROM $this->tableName WHERE email=:email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if( $result && password_verify($this->password, $result['password']) ){

                unset($result['password']);
                
                return array_merge(
                            ['token' => AuthHelper::generateToken($result['iduser'])],
                            $result
                        );

            }else{
                return false;
            }

        }
    
        protected function create(){

            $query = "INSERT INTO $this->tableName SET email=:email, name=:name, password=:password";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":password", $this->getPasswordHash());
            
            return $stmt->execute();

        }

        protected function edit(){

            $isPasswordHash = password_get_info($this->password)['algo'] !== 0;
            $password = $isPasswordHash ? $this->password : $this->getPasswordHash();

            $query = "UPDATE $this->tableName SET email=:email, name=:name, password=:password WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":password", $password);
            $stmt->bindParam(":id", $this->id);
            
            return $stmt->execute();

        }

        public function delete($iduser){

            $query = "DELETE FROM $this->tableName WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $iduser);
            
            return $stmt->execute();

        }

        public function fetch($iduser){

            $query = "SELECT id as iduser, email, name, password FROM $this->tableName WHERE id=:id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":id", $iduser);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function fetchAll(){

            $query = "SELECT id as iduser, email, name FROM $this->tableName";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }

    }
?>