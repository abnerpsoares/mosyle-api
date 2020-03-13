<?php
    abstract class Controller {

        protected $input;
        protected $output;
        protected $responseCode;
        protected $loggedUserId;
        
        function __construct($needsToken = true){
            
            $this->input = json_decode(file_get_contents("php://input"));

            if( $needsToken ){
                $token = AuthHelper::validateAndReturnToken();
                $this->loggedUserId = $token->iduser;
            }

        }

        public function output(){
            http_response_code($this->responseCode ?? 200);
            if( empty($this->output) ){
                $this->output = ['message' => 'ok'];
            }
            echo json_encode($this->output);
        }

    }
?>