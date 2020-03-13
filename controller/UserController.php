<?php
    class UserController extends Controller {

        public function auth(){

            if( empty($this->input->email) ){
                throw new ExceptionHelper('O parâmetro email é obrigatório.');
            }
            
            if( empty($this->input->password) ){
                throw new ExceptionHelper('O parâmetro senha é obrigatório.');
            }

            $user = new User();
            $user->email = $this->input->email;
            $user->setPassword($this->input->password);
            
            try {

                $auth = $user->authCheck();
                if( !$auth ){
                    throw new PDOException('Usuário ou senha inválido.');
                }

                $drinkMonitor = new DrinkMonitor();

                $this->output = array_merge(
                    $auth,
                    ['drink_counter' => count($drinkMonitor->fetchAll($auth['iduser']))]
                );

            }catch(PDOException $ex){
                throw new ExceptionHelper($ex->getMessage());
            }

            $this->output();

        }

        public function create(){

            if( empty($this->input->email) ){
                throw new ExceptionHelper('O parâmetro email é obrigatório.');
            }
            
            if( empty($this->input->name) ){
                throw new ExceptionHelper('O parâmetro nome é obrigatório.');
            }
            
            if( empty($this->input->password) ){
                throw new ExceptionHelper('O parâmetro senha é obrigatório.');
            }

            $user = new User();
            $user->email = $this->input->email;
            $user->name = $this->input->name;
            $user->setPassword($this->input->password);

            try {

                $user->save();

            }catch(PDOException $ex){

                $message = $ex->getMessage();
                if( $ex->getCode() == 23000 ){
                    $message = 'Usuário já existente.';
                }

                $this->output = ['message' => $message];
                $this->responseCode = 400;

            }

            $this->output();

        }

        public function edit($id){

            if( $id !== $this->loggedUserId ){
                throw new ExceptionHelper('Você não tem permissão para editar este usuário.');
            }

            $user = new User($id);
            
            if( !empty($this->input->email) ){
                $user->email = $this->input->email;
            }
            
            if( !empty($this->input->name) ){
                $user->name = $this->input->name;
            }

            if( !empty($this->input->password) ){
                $user->setPassword($this->input->password);
            }

            try {

                $user->save();

            }catch(PDOException $ex){
                throw new ExceptionHelper($ex->getMessage());
            }

            $this->output();

        }

        public function delete($id){

            if( $id !== $this->loggedUserId ){
                throw new ExceptionHelper('Você não tem permissão para excluir este usuário.');
            }

            $user = new User();

            try {

                $user->delete($id);

            }catch(PDOException $ex){
                throw new ExceptionHelper($ex->getMessage());
            }

            $this->output();

        }

        public function fetch($iduser){

            $user = new User($iduser);
            $drinkMonitor = new DrinkMonitor();

            $this->output = array_merge(
                [
                    'iduser' => $user->id,
                    'email' => $user->email,
                    'name' =>  $user->name,
                    'drink_counter' => count($drinkMonitor->fetchAll($iduser))
                ]
            );

            $this->output();

        }

        public function fetchAll(){

            $user = new User();
            $fetchAll = $user->fetchAll();

            $this->output = [
                'users' => $fetchAll
            ];
            
            $this->output();

        }

    }
?>