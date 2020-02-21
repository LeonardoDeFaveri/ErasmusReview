<?php
    include_once "Soggetti/Agenzia.php";
    include_once "Soggetti/Azienda.php";
    include_once "Soggetti/Docente.php";
    include_once "Soggetti/Famiglia.php";
    include_once "Soggetti/Studente.php";
    include_once "Aspetto.php";
    include_once "Valutazione.php";
    include_once "SchedaValutazione.php";
    include_once "ConnessioneDB/ConnessioneDB.php";    

    class Modello{
        private $connessioneDB;
        
        public function __construct() {
            $this->$connessioneDB = new ConnessioneDB();
        }

        public function verificaLogin(){
            $email = $_POST["email"];
            $password = $_POST["password"];
            $verificato = $connessioneDB->verificaCredenziali($email, $password);
            return $verificato;
        }
        
    }

    
?>
