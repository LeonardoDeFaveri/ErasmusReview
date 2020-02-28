<?php
    if(session_id() == ''){
        session_start();
    }
    include_once "{$_SESSION['root']}/Model/Modello.php";

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
            $comando = 'login';
            if(isset($_GET['comando'])){
                $comando = $_GET['comando'];
            }

            switch ($comando){
                case 'login':
                    if(!isset($_POST['login'])){
                        header('Location: View/Login.php');
                        exit();
                    }
                    $tipoUtente = $this->modello->verificaCredenziali($_POST['email'], $_POST['password']);
                    if(!$tipoUtente){
                        header('Location: View/Login.php?errore=1');
                        exit();
                    }
                break;
                case 'search':
                    $search = $_GET['search'];
                break;
            }
        }
    }
?>