<?php
    include_once "Model/Modello.php";

    class Controller {
        private $modello;
        public function __construct() {
            $this->modello = new Modello();
        }

        /**
         * invoca: elabora il comando ricevuto.
         * Il controllore elabora il comando ricevuto e richiama la vista opportuna
         * fornendole i dati necessari.
         */
        public function invoca(): void {
            $comando = 'login';
            if(isset($_GET['comando'])){
                $comando = $_GET['comando'];
            }

            switch ($comando){
                case 'login':
                    header('Location: View/Login.php');
            }
        }
    }
?>