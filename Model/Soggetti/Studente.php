<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Studente extends Soggetto{
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

    public function serialize(){
        return serialize([$this->id, $this->nome, $this->cognome, $this->email, $this->dataNascita]);
    }

    public function unserialize($stringa){
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->nome = $valori[1];
        $this->cognome = $valori[2];
        $this->email = $valori[3];
        $this->dataNascita = $valori[4];
    }
}
?>