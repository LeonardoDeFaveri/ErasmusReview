<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Docente extends Soggetto{
    private $cognome;
    private $email;

    public function __construct($id, $nome, $cognome, $email) {
        parent::__construct($id, $nome);
        $this->cognome = $cognome;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getEmail(){
        return $this->email;
    }
}
?>