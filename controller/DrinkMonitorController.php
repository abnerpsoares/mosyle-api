<?php
    class DrinkMonitorController extends Controller {

        public function create($userId){

            $drinkMonitor = new DrinkMonitor();
            $drinkMonitor->userId = $userId;
            $drinkMonitor->drinkMl = $this->input->drink_ml;

            try {

                $drinkMonitor->save();

            }catch(PDOException $ex){
                throw new ExceptionHelper($ex->getMessage());
            }

            $this->output();

        }

        public function fetchAll($userId){

            $drinkMonitor = new DrinkMonitor();
            $fetchAll = $drinkMonitor->fetchAll($userId);

            $this->output = [
                'drinks' => $fetchAll
            ];
            
            $this->output();

        }

        public function ranking(){

            $drinkMonitor = new DrinkMonitor();
            $ranking = $drinkMonitor->getRanking();

            $this->output = [
                'ranking' => $ranking
            ];

            $this->output();

        }

    }
?>