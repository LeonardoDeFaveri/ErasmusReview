<?php
if(session_id() == ''){
    session_start();
}
include_once "{$_SESSION['root']}/Model/Soggetti/Soggetto.php";

class Famiglia extends Soggetto{
    private $cognome;
    private $stato;
    private $citta;
    private $indirizzo;
    
    public function __construct($id, $nome, $cognome, $stato, $citta, $indirizzo) {
        parent::__construct($id, $nome);
        $this->cognome = $cognome;
        $this->stato = $stato;
        $this->citta = $citta;
        $this->indirizzo = $indirizzo;
    }

    public function getCognome() {
        return $this->cognome;
    }

    public function getStato() {
        return $this->stato;
    }

    public function getCitta() {
        return $this->citta;
    }

    public function getIndirizzo() {
        return $this->indirizzo;
    }
}
?>