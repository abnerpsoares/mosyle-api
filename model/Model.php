<?php
    abstract class Model {

        protected $conn;
        public $id;
        
        public function __construct(){

            $this->conn = (new Database())->getConnection();

            $args = func_get_args();
            if( !empty($args) && method_exists($this, '__constructWithArg') ){
                $this->__constructWithArg($args[0]);
            }
            
        }

        public function save(){
            if( empty($this->id) ){
                return $this->create();
            }else{
                return $this->edit();
            }
        }

    }
?>