<?php
if(session_id() == ''){
    session_start();
    $_SESSION['root'] = __DIR__ . "/../";
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Scuola extends Soggetto{
    private $email;
    private $citta;
    private $indirizzo;

    public function __construct($id, $nome, $email, $citta, $indirizzo) {
        parent::__construct($id, $nome);
        $this->email = $email;
        $this->citta = $citta;
        $this->indirizzo = $indirizzo;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCitta() {
        return $this->citta;
    }

    public function getIndirizzo() {
        return $this->indirizzo;
    }

    public function serialize() {
        return serialize([$this->id, $this->nome, $this->email, $this->citta,
         $this->indirizzo]);
    }
    
    public function unserialize($stringa){
        $valori = unserialize($stringa);
        $this->id = $valori[0];
        $this->nome = $valori[1];
        $this->email = $valori[2];
        $this->citta = $valori[3];
        $this->indirizzo = $valori[4];
    }
}
?>