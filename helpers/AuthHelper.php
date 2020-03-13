<?php
    class AuthHelper {

        public static function validateAndReturnToken(){

            try {
                
                $token = $_SERVER['HTTP_TOKEN'];
                $obj   = self::decodeToken($token);

                if( !$obj || empty($obj->iduser) ){
                    throw new Exception('Token inválido.');
                }

                return $obj;

            }
            catch(Exception $ex){
                throw new ExceptionHelper($ex->getMessage());
            }

        }

        public static function generateToken($iduser){

            $authData = [
                'iduser' => $iduser,
                'current' => date('Y-m-d H:i:s')
            ];

            return base64_encode(
                json_encode($authData)
            );

        }

        private static function decodeToken($token){
            return json_decode(base64_decode($token));
        }

    }
?>