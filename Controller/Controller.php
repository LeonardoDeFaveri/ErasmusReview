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
        public function invoca() {
            $comando = "Home";
            if(isset($_GET['comando'])){
                $comando = $_GET['comando'];
            }

            switch ($comando){

            }
        }
    }
?>