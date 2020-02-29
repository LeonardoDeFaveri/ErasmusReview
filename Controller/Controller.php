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
                        header('Location: View/login.php');
                        exit();
                    }
                    $tipoUtente = $this->modello->verificaCredenziali($_POST['email'], $_POST['password']);
                    if(!$tipoUtente){
                        header('Location: View/login.php?errore=1');
                        exit();
                    }
                    $_SESSION['email_utente'] = $_POST['email'];
                    $_SESSION['tipo_utente'] = $tipoUtente;
                    header("Location: index.php?comando=home-{$tipoUtente}");
                    exit();

                break;
                case 'search':
                    $search = $_GET['search'];
                break;
                case 'home-studente':
                    $studente = $this->modello->getStudente($_SESSION['email_utente']);
                    if($studente == null){
                        header('Location: View/homeStudente?errore=1');
                        exit();
                    }
                    $esperienze = $this->modello->getEsperienze($studente);
                    $_SESSION['studente'] = serialize($studente);
                    header('Location: View/homeStudente.php');
            }
        }
    }
?>