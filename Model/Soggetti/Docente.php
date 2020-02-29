<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Docente extends Soggetto {
    private $cognome;
    private $email;

    public function __construct($id, $nome, $cognome, $email) {
        parent::__construct($id, $nome);
        $this->cognome = $cognome;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function serialize() {
        return serialize([$this->id, $this->nome, $this->cognome, $this->email]);
    }

    public function unserialize($stringa) {
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->nome = $valori[1];
        $this->cognome = $valori[2];
        $this->email = $valori[3];
    }
}
?>