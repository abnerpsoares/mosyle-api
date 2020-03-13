<?php
    class ExceptionHelper extends Exception {
        

        public function __construct($message, $code = 400, Exception $previous = null) {
            parent::__construct($message, $code, $previous);
            $this->returnError();
        }

        private function returnError(){

            http_response_code($this->code);
            
            echo json_encode([
                'message' => $this->message
            ]);

            exit();

        }

    }
?>