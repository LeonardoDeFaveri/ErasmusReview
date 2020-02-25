<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Studente extends Soggetto {
    private $cognome;
    private $email;
    private $dataNascita;

    public function __construct($id, $nome, $cognome, $email, $dataNascita) {
        parent::__construct($id, $nome);
        $this->cognome = $cognome;
        $this->email = $email;
        $this->dataNascita = $dataNascita;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getDataNascita() {
        return $this->dataNascita;
    }
}
?>